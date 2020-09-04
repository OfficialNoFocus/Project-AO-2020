<?php
namespace API;

require_once("vendor/autoload.php");

class Qrcode
{
  private $code;
  private $qrinstance = [];

  public function __construct(int $aantal = 1, $code = null) 
  {
    if($aantal !== 0){
      $this->generateValue($aantal);
    } else {
      $this->code = $code;
      $this->qrinstance[0] = new \Endroid\QrCode\QrCode(Settings::getVoteUrl() . $this->code);
      $this->qrinstance[0]->setSize(100);
    }
  }

  private function generateValue(int $aantal)
  {
    for($i = 0; $i < $aantal; $i++){

      $this->code = (int)sqrt(date("YmdHis") * rand());
      $this->qrinstance[$i] = new Qrcode(0, $this->code);

      $this->qrinstance[$i]->getQrcodes(true)->writeFile(dirname(__DIR__, 1) . "/qrcode/" . $this->qrinstance[$i]->getCode() . ".png");
    }
  }

  public function getQrcodes(bool $singleton = false)
  {
    if($singleton){
      return $this->qrinstance[0];
    } else {
      return $this->qrinstance;
    }
  }

  public function getCode()
  {
    return $this->code;
  }
}
