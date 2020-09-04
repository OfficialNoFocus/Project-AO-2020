<?php
namespace API;

require_once("fpdf.php");

class Pdf extends \FPDF
{


  public function __construct(int $aantal, array $qrcodes) 
  {
    parent::__construct();

    $this->makePages($aantal, $qrcodes);
  }

  /**
   * functie waar alle opmaak voor de header in komt, fpdf called de functie uit zichzelf
   * de opmaak die er al instaat is basis opmaak om te testen of alles werkt
   */
  public function Header()
  {
//    $this->SetFont('Arial','B',15);
//    $this->Cell(80);
//    $this->Cell(30,10,'Title',1,0,'C');
//    $this->Ln(20);
  }

  /**
   * functie waar alle opmaak voor de footer in komt, fpdf called de functie uit zichzelf
   * de opmaak die er al instaat is basis opmaak om te testen of alles werkt
   */
  public function Footer()
  {
//     $this->SetY(-15);
//     $this->SetFont('Arial','I',8);
//     $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
  }

    /**
    * functie die alle pages toevoegd aan de pdf, word door de constructor geroepen.
    * de opmaak die er al instaat is basis opmaak om te testen of alles werkt
    * images zijn al wel correct
    */
    public function makePages(int $aantal, array $qrcodes)
    {
        $xMargin = 10;
        $yMargin = 10;
        $xPos = 0;
        $yPos = 0;
        $w = 150;
        $w1 = 95;
        $h = 100;
        $hLn = 5.3;

        //dit is waar de opmaak code staat, dit doe ik hier om te voorkomen dat er teveel calls komen in de api,(maybe function)
        $this->AliasNbPages();
        $this->AddPage('L');
        $this->SetFont('Arial','',12);

        //dit loopt over alle qrcodes
        $i = 0;
        $iPage = 0;
        foreach ($qrcodes as $qrcode) {
            if($i < $aantal ){
                if( $iPage > 3) {
                    $iPage = 0;
                    $this->AddPage('L');
                    $xPos = 0;
                    $yPos = 0;
                }
                
                $xPos = $xMargin;
                $yPos = $yMargin;
                if ($iPage & 1) { //is odd
                    $xPos += $w;
                }
                if($iPage>1) {
                    $yPos += $h;
                }

                //Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, int fill [, mixed link]]]]]]])

                $this->SetFont('Arial','BI',14);
                $this->SetXY($xPos, $yPos);
                $this->Cell($w1, $hLn,'Stemkaart Worldpress wedstrijd',0,1,'L');

                $this->SetFont('Arial','',12);
                $this->SetXY($xPos, $yPos + 1.5*$hLn);
                //MultiCell(float w, float h, string txt [, mixed border [, string align [, int fill]]])
                $this->MultiCell($w1, $hLn, 'Met deze stemkaart kunt u 1 stem uitbrengen op een fotograaf en een stem op een videograaf op de website https://worldpresswedstrijd.nl.');


                $this->SetXY($xPos, $yPos+ 5*$hLn);
                $this->MultiCell($w1, $hLn, 'U kunt stemmen door de QR-code te scannen en een student te kiezen, of door op de site de student te zoeken en bij stemmen de onder- staande code in te voeren.');
                //Scan de QR-code en zoek de student waar u een stem op wilt uitbrengen
                $this->SetXY($xPos, $yPos+ 9*$hLn);
                $this->SetFont('Arial','I',10);
                $this->Cell(130, $hLn,'Code: '.$qrcode["qrcode"] ,0,1,'R');

                $this->Image(
                    dirname(__DIR__, 1) . "/qrcode/" . $qrcode["qrcode"] . ".png",
                    $xPos+$w1+5, $yPos );

                $yPos += 1*$hLn;
                $this->Image(dirname(__DIR__, 1) . "/img/logo.png",
                    $xPos, $yPos +$h - 52, 130);
                $i++;
                $iPage++;
            }

        }
        $this->Output();
    }
}
