<?php
namespace API;

require_once("Settings.php");

class Database  
{
  private $dbinstance;
  private $result;

  private $users;
  private $media;
  private $qr;

  public function __construct() 
  {
    $this->dbinstance = new \mysqli(...Settings::getDatabaseCredentials());
    if($this->dbinstance->connect_error){
      throw new \Exception("error connecting to database: " . $this->dbinstance->connect_error);
    }
  }

  public function __destruct()
  {
    $this->dbinstance->close();
  }

  private function runQuery(string $call)
  {
    try {
      $this->result = $this->dbinstance->query($call);
    } catch (\Throwable $th) {
      return;
    }

    return $this;
  }

  public function getUsers()
  {
    $this->users = [];
    $this->runQuery("SELECT id, vnaam, tv, anaam, email, 'role', beschrijving, titel, groep_opm FROM users");

    //users:id, vnaam, tv, anaam, email, role
    while($row = $this->result->fetch_assoc()) {
      $this->users[$row["id"]] = [];
      $this->users[$row["id"]]["id"] = utf8_encode($row["id"]);
      $this->users[$row["id"]]["vnaam"] = utf8_encode($row["vnaam"]);
      if(isset($row["tv"])){
        $this->users[$row["id"]]["tv"] = utf8_encode($row["tv"]);
      }
      $this->users[$row["id"]]["anaam"] = utf8_encode($row["anaam"]);
      $this->users[$row["id"]]["email"] = utf8_encode($row["email"]);
      $this->users[$row["id"]]["role"] = utf8_encode($row["role"]);
      $this->users[$row["id"]]["beschrijving"] = utf8_encode($row["beschrijving"]);
      $this->users[$row["id"]]["titel"] = utf8_encode($row["titel"]);
      $this->users[$row["id"]]["groep_opm"] = utf8_encode($row["groep_opm"]);
    }

    return $this->users;
  }

  public function getPhotographers()
  {
    $this->users = [];
    $this->runQuery("SELECT id, CONCAT(vnaam,' ',IFNULL(tv,' '),' ',anaam) AS naam, jaar, `titel`, `role` FROM users where `role` = 'fotograaf';");
    //users:id, vnaam, tv, anaam, email, role
    if(!$this->result){
      return [];
    }
    while($row = $this->result->fetch_assoc()) {  
      $this->users[$row["id"]] = [];

      $this->users[$row["id"]]["naam"] = utf8_encode($row["naam"]);
      $this->users[$row["id"]]["jaar"] = utf8_encode($row["jaar"]);
      $this->users[$row["id"]]["role"] = utf8_encode($row["role"]);
      $this->users[$row["id"]]["titel"] = utf8_encode($row["titel"]);
    }

    return $this->users;
  }
  
  public function getVideographers()
  {
    $this->users = [];
    $this->runQuery("SELECT id, CONCAT(vnaam,' ',IFNULL(tv,' '),' ',anaam) AS naam, jaar, `titel`, `role` FROM users where `role` = 'videograaf';");
    //users:id, vnaam, tv, anaam, email, role
    if(!$this->result){
      return [];
    }
    while($row = $this->result->fetch_assoc()) {  
      $this->users[$row["id"]] = [];

      $this->users[$row["id"]]["naam"] = utf8_encode($row["naam"]);
      $this->users[$row["id"]]["jaar"] = utf8_encode($row["jaar"]);
      $this->users[$row["id"]]["role"] = utf8_encode($row["role"]);
      $this->users[$row["id"]]["titel"] = utf8_encode($row["titel"]);
    }

    return $this->users;
  }

  public function getUser(int $id)
  {
    $this->users = [];
    $stmt = $this->dbinstance->prepare("SELECT id, CONCAT(vnaam,' ',IFNULL(tv,' '),' ',anaam) AS naam, jaar, `titel`, `role`, beschrijving, groep_opm FROM users where id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $this->result = $stmt->get_result();
    $stmt->close();

    while($row = $this->result->fetch_assoc()) {
      $this->users[$row["id"]] = [];
      // $this->users[$row["id"]]["id"] = utf8_encode($row["id"]);
      $this->users[$row["id"]]["naam"] = utf8_encode($row["naam"]);
      $this->users[$row["id"]]["jaar"] = utf8_encode($row["jaar"]);
      $this->users[$row["id"]]["role"] = utf8_encode($row["role"]);
      $this->users[$row["id"]]["beschrijving"] = utf8_encode($row["beschrijving"]);
      $this->users[$row["id"]]["titel"] = utf8_encode($row["titel"]);
      $this->users[$row["id"]]["groep_opm"] = utf8_encode($row["groep_opm"]);
    }

    return $this->users;
  }

  public function getUserPhotos(int $id)
  {
    $this->media = [];
    $stmt = $this->dbinstance->prepare("SELECT * FROM media WHERE id_cand = ? AND img IS NOT NULL");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $this->result = $stmt->get_result();
    $stmt->close();

    while($row = $this->result->fetch_assoc()) {
      $this->media[$row["id"]] = [];
      $this->media[$row["id"]]["id"] = utf8_encode($row["id"]);
      $this->media[$row["id"]]["id_cand"] = utf8_encode($row["id_cand"]);
      $this->media[$row["id"]]["img"] = utf8_encode($row["img"]);
      $this->media[$row["id"]]["desc"] = utf8_encode($row["desc"]);
    }

    return $this->media;
  }

  public function getUserVideo(int $id)
  {
    $this->media = [];
    $stmt = $this->dbinstance->prepare("SELECT * FROM media WHERE id_cand = ? AND video IS NOT NULL");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $this->result = $stmt->get_result();
    $stmt->close();
    
    while($row = $this->result->fetch_assoc()) {
      $this->media[$row["id"]] = [];
      $this->media[$row["id"]]["id"] = utf8_encode($row["id"]);
      $this->media[$row["id"]]["id_cand"] = utf8_encode($row["id_cand"]);
      $this->media[$row["id"]]["video"] = utf8_encode($row["video"]);
      $this->media[$row["id"]]["desc"] = utf8_encode($row["desc"]);
    }

    return $this->media;
  }

  public function getUserParam()
  {
    return $this->user;
  }

  public function getPhotos()
  {
    $this->media = [];
    $this->runQuery("SELECT * FROM media WHERE img IS NOT NULL");

    //media: id, img, id_cand, video, description
    while($row = $this->result->fetch_assoc()) {
      $this->media[$row["id"]] = [];
      $this->media[$row["id"]]["id"] = utf8_encode($row["id"]);
      $this->media[$row["id"]]["id_cand"] = utf8_encode($row["id_cand"]);
      $this->media[$row["id"]]["img"] = utf8_encode($row["img"]);
      $this->media[$row["id"]]["desc"] = utf8_encode($row["desc"]);
    }

    return $this->media;
  }

  public function getPhoto(int $id)
  {
    $this->media = [];
    $stmt = $this->dbinstance->prepare("SELECT * FROM media WHERE id = ? AND img IS NOT NULL");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $this->result = $stmt->get_result();
    $stmt->close();

    while($row = $this->result->fetch_assoc()) {
      $this->media[$row["id"]] = [];
      $this->media[$row["id"]]["id"] = utf8_encode($row["id"]);
      $this->media[$row["id"]]["id_cand"] = utf8_encode($row["id_cand"]);
      $this->media[$row["id"]]["img"] = utf8_encode($row["img"]);
      $this->media[$row["id"]]["desc"] = utf8_encode($row["desc"]);
    }

    return $this->media;
  }

  public function getVideos()
  {
    $this->media = [];
    $this->runQuery("SELECT * FROM media WHERE video IS NOT NULL");

    while($row = $this->result->fetch_assoc()) {
      $this->media[$row["id"]] = [];
      $this->media[$row["id"]]["id"] = utf8_encode($row["id"]);
      $this->media[$row["id"]]["id_cand"] = utf8_encode($row["id_cand"]);
      $this->media[$row["id"]]["video"] = utf8_encode($row["video"]);
      $this->media[$row["id"]]["desc"] = utf8_encode($row["desc"]);
    }

    return $this->media;
  }

  public function getVideo(int $id)
  {
    $this->media = [];
    $stmt = $this->dbinstance->prepare("SELECT * FROM media WHERE id = ? AND video IS NOT NULL");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $this->result = $stmt->get_result();
    $stmt->close();
    
    while($row = $this->result->fetch_assoc()) {
      $this->media[$row["id"]] = [];
      $this->media[$row["id"]]["id"] = utf8_encode($row["id"]);
      $this->media[$row["id"]]["id_cand"] = utf8_encode($row["id_cand"]);
      $this->media[$row["id"]]["video"] = utf8_encode($row["video"]);
      $this->media[$row["id"]]["desc"] = utf8_encode($row["desc"]);
    }

    return $this->media;
  }

  public function getMediaPerUserYear(int $param)
  {
    $this->media = [];
    $query = $this->dbinstance->prepare("SELECT u.vnaam, u.tv, u.anaam, u.jaar, u.role, u.beschrijving, u.titel, u.groep_opm, m.img, m.id_cand, m.video, m.desc
    FROM users AS u
    INNER JOIN media AS m ON u.id = m.id_cand WHERE jaar = ?
    ORDER BY anaam;");
    // $stmt = "SELECT u.vnaam, u.tv, u.anaam, u.role, u.beschrijving, u.titel, u.groep_opm, 
    //   m.img, m.id_cand, m.video, m.desc
    //   FROM users AS u
    //   INNER JOIN media AS m ON u.id = m.id_cand WHERE year = ?
    //   ORDER BY anaam;";
    $query->bind_param("i", $param);
    $query->execute();
    $this->result = $query->get_result();

    while ($row = $this->result->fetch_assoc()) {
      $this->media[] = array_map("utf8_encode", $row);
    }
    
    $query->close();
    return $this->media;
  }

  public function getMediaPerUser()
  {
    $this->media = [];

    $query = "SELECT u.vnaam, u.tv, u.anaam, u.role, u.beschrijving, u.titel, u.groep_opm, 
      m.img, m.id_cand, m.video, m.desc
      FROM users AS u
      INNER JOIN media AS m ON u.id = m.id_cand
      ORDER BY anaam;";
    
    $this->runQuery($query);

    while ($row = $this->result->fetch_assoc()) {
      $this->media[] = array_map("utf8_encode", $row);
    }
    
    return $this->media;
  }

  public function deleteUser(int $id)
  {
    $query = $this->dbinstance->prepare("DELETE FROM `users` WHERE `users`. id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $query->close();

    $query = $this->dbinstance->prepare("DELETE FROM `media` WHERE `media`.`id_cand` = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $query->close();
  }

  public function createQr(string $code) 
  {
    $this->runQuery("INSERT INTO `qr` (`id`, `qrcode`) VALUES (NULL, '$code');");
  }

  public function getEmptyQr()
  {
    $this->qr = [];
    $this->runQuery("SELECT * FROM `qr` WHERE `id`");

    while($row = $this->result->fetch_assoc()) {
      $this->qr[$row["id"]] = [];
      $this->qr[$row["id"]]["id"] = $row["id"];
      $this->qr[$row["id"]]["qrcode"] = $row["qrcode"];
    }

    return $this->qr;
  }

  public function checkCode($code, $type = null)
  {
    if($type == "video" || $type == "foto"){
      $stmt = $this->dbinstance->prepare("SELECT * FROM `qr` WHERE qrcode = ? AND id NOT IN (SELECT `id_qr` FROM `vote_$type`)");
    } else {
      $stmt = $this->dbinstance->prepare("SELECT * FROM `qr` WHERE qrcode = ? AND id NOT IN (SELECT `id_qr` FROM `vote_video`) AND id NOT IN (SELECT `id_qr` FROM `vote_foto`)");
    }
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $this->result = $stmt->get_result();
    $stmt->close();

    if($this->result->num_rows === 1){
      return true;
    } else if($this->result->num_rows > 1){
      throw new \Exception("duplicate codes found, please hold on to this code and contact an administrator");
    } else {
      return false;
    }
  }

  public function setVote($code, $id, $type, $secondId = null)
  {
    if($type == "video" || $type == "foto"){
      $stmt = $this->dbinstance->prepare("INSERT INTO `vote_$type` (`id`, `id_qr`, `id_user`) VALUES (NULL, (SELECT id FROM qr WHERE qrcode = ?), ?)");
      $stmt->bind_param("si", $code, $id);
      $stmt->execute();
      $this->result = $stmt->get_result();
      $stmt->close();
    } else {
      $stmt = $this->dbinstance->prepare("INSERT INTO `vote_video` (`id`, `id_qr`, `id_user`) VALUES (NULL, (SELECT id FROM qr WHERE qrcode = ?), ?)");

      $stmt->bind_param("si", $code, $id);
      $stmt->execute();
      $this->result = $stmt->get_result();
      $stmt->close();

      $stmt = $this->dbinstance->prepare("INSERT INTO `vote_foto` (`id`, `id_qr`, `id_user`) VALUES (NULL, (SELECT id FROM qr WHERE qrcode = ?), ?)");
      
      $stmt->bind_param("si", $code, $secondId);
      $stmt->execute();
      $this->result = $stmt->get_result();
      $stmt->close();
    }
  }

  public function getAllVotes() 
  {
    $this->votes = [];
    $this->runQuery(
      "SELECT u.vnaam, u.tv, u.anaam, vf.id_user
      FROM users AS u
      INNER JOIN vote_foto AS vf ON u.id = vf.id_user;"
    );

    while ($row = $this->result->fetch_assoc()) {
      $naam = $row["vnaam"] . " " . $row["tv"] . " " .  $row["anaam"];

      if(!isset($this->votes[$naam])){
        $this->votes[$naam] =  ["votes" => 1, "role" => "fotograaf", "naam" => $naam]; 
      } else {
        $this->votes[$naam]["votes"]++;
      }
    }
      
    $this->runQuery(
      "SELECT u.vnaam, u.tv, u.anaam, vv.id_user
      FROM users AS u
      INNER JOIN vote_video AS vv ON u.id = vv.id_user;"
    );

    while ($row = $this->result->fetch_assoc()) {
      $naam = $row["vnaam"] . " " . $row["tv"] . " " .  $row["anaam"];


      if(!isset($this->votes[$naam])){
        $this->votes[$naam] =  ["votes" => 1, "role" => "videograaf", "naam" => $naam]; 
      } else {
        $this->votes[$naam]["votes"]++;
      }
    }


    return $this->votes;
  }
}