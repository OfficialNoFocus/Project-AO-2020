<?php
namespace API;

require_once("Database.php");
require_once("Pdf.php");

/**
 * deze applicatie vereist composer, als je er aan werkt run dan composer update om alle
 * packeges te intaleren
 */
class API  
{
  public static $instance;
  private $response = [
    "sMessage"=>"nog niets geset",
    "bSuccess"=>false,
    "data"=>null
  ];

  private $dbinstance;

  public function __construct() 
  {
    $this->dbinstance = new Database();
  }

  public static function runApi()
  {


    API::$instance = new API();
    API::$instance->handleRequest();
  }

  public function handleRequest()
  {
    if(isset($_GET["action"])){
      header('Access-Control-Allow-Origin: *');
      header('Content-Type: application/json');

      $url = $_GET["action"];
      if(method_exists(API::class, $url)){
        if(isset($_GET["param"])){
          try {
            if(isset($_GET["foto"]) && isset($_GET["video"])){
              $this->response["data"] = $this->$url($_GET["param"], $_GET["foto"], $_GET["video"]);
              http_response_code(200);
              $this->response["sMessage"] = "stem is succesvol";
              $this->response["bSuccess"] = true;
            } else if (isset($_GET["video"])){
              $this->response["data"] = $this->$url($_GET["param"], null,  $_GET["video"]);
              http_response_code(200);
              $this->response["sMessage"] = "succesvol gestemt op video " . $_GET["video"];
              $this->response["bSuccess"] = true;
            } else if (isset($_GET["foto"])) {
              $this->response["data"] = $this->$url($_GET["param"], $_GET["foto"], null);
              http_response_code(200);
              $this->response["sMessage"] = "successvol gestemt op foto " . $_GET["foto"];
              $this->response["bSuccess"] = true;
            } else {
              $this->response["data"] = $this->$url($_GET["param"]);
              http_response_code(200);
              $this->response["sMessage"] = "database succesvol uitgelezen";
              $this->response["bSuccess"] = true;
            }
          } catch (\Throwable $th) {
            $this->response["sMessage"] = "de codes zijn al in gebruik";
            $this->response["bSuccess"] = false;
          }
        } else {
          try{
            $this->response["data"] = $this->$url();
            http_response_code(200);
            $this->response["sMessage"] = "database succesvol uitgelezen";
            $this->response["bSuccess"] = true;
          } catch(\Throwable $th) {
            http_response_code(400);
            $this->response["sMessage"] = "de website verwacht een paramater genaamd param";
          }
        }
      } else {
        http_response_code(404);
        $this->response["sMessage"] = "action niet gevonden, probeer een ander";
      }

    } else {
      include_once(dirname(__DIR__, 1) . "/app.php");
    }

    
    if(isset($_GET["action"])){
      if($_GET["action"] === "createVote"){
        header("Content-Type: text/html; charset=UTF-8");
        include_once(dirname(__DIR__, 1) . "/app.php");
      } else {
        echo json_encode($this->response);
      } 
    }
  }

  private function getUsers()
  {
    return $this->dbinstance->getUsers();
  }

  private function getUser(int $id = null)
  {
    if($id === null){
      throw new \Exception("geen id gegeven aan de controller functie");
    }
    return $this->dbinstance->getUser($id);
  }


  private function getPhotos()
  {
    return $this->dbinstance->getPhotos();
  }

  private function getPhoto(int $id)
  {
    return $this->dbinstance->getPhoto($id);
  }


  private function getVideos()
  {
    return $this->dbinstance->getVideos();
  }

  private function getVideo(int $id)
  {
    return $this->dbinstance->getVideo($id);
  }

  private function getMediaPerUser()
  {
    return $this->dbinstance->getMediaPerUser();
  }

  private function getMediaOfUser(int $id)
  {
    $result = $this->dbinstance->getMediaPerUser();
    $user = $result["user"][$id];
    $media = [];
    foreach ($result["media"] as $key => $value) {
      if($value["id_cand"] == $id){
        $media[$key] = $value;
      }
    }

    return ["user" => $user, "media" => $media];
  }

  private function getQr()
  {
    return $this->dbinstance->getEmptyQr();
  }

  // auth route
  // private function createQr(int $aantal)
  // {
  //   $qrcodes = new Qrcode($aantal);
  //   foreach ($qrcodes->getQrcodes() as $value) {
  //     $this->dbinstance->createQr($value->getCode());
  //   }
    
  //   return "qrcodes successvol gegenereerd";
  // }

  private function generatePdf(int $aantal)
  {
    $emptyQrList = $this->dbinstance->getEmptyQr();

    $pdf = new Pdf($aantal, $emptyQrList);
    return;
  }

  //deze functie zou eingelijk door de frontend moeten worden afgehandeled.
  private function createVote($code)
  {
    if($this->dbinstance->checkCode($code, "video")){
      return 1;
    } else if ($this->dbinstance->checkCode($code, "foto")){
      return 1;
    } else {
      return 0;
    }
  }

  private function setVote($code, $idFoto, $idVideo)
  {
    $type;

    if($idFoto === null){
      $type = "video";
      if($this->dbinstance->checkCode($code, $type)){
        $this->dbinstance->setVote($code, $idVideo, $type);
        return true;
      } else {
        $this->response["data"] = [
          "videoCodeUsed" => true
        ];
        throw new Exception("de code is al gebruikt voor het stemmen op een video");
      }
    } else if($idVideo === null) {
      $type = "foto";
      if($this->dbinstance->checkCode($code, $type)){
        $this->dbinstance->setVote($code, $idFoto, $type);
      } else {
        $this->response["data"] = [
          "fotoCodeUsed" => true
        ];
        throw new Exception("de code is al gebruikt voor het stemmen op een foto");
      }
    } else {
      $type = "both";
      if($this->dbinstance->checkCode($code, $type)){
        $this->dbinstance->setVote($code, $idFoto, $type, $idVideo);
      } else {
        $this->response["data"] = [
          "fotoCodeUsed" => true,
          "videoCodeUsed" => true
        ];

        throw new Exception("de codes zijn al in gebruik");
      }
    }
  }
}
