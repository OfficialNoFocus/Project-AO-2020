
<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include "db.php";

//standaard json output zodat api altijd wat terug geeft
$json = array(
    "sMessage"=>"nog niets geset",
    "bSuccess"=>false,
    "data"=>null
);

// media: id, img, id_cand, videos, desc
// qr: id, qrcode
// users:id, vnaam, tv, anaam, ww, email, role
// vote: id, id_qr, id_media

//  https://wpf.stegion.nl/api/wpf.php?action=getUsers
if( $_GET["action"] == "getUsers" ) {
    $sql = "SELECT *
			FROM users
			ORDER BY vnaam;";
    $res = mysqli_query($con, $sql);
    if($res) {
        $lst = array();
        while($rij = mysqli_fetch_assoc($res)) {
            $lst[] = array_map("utf8_encode", $rij);
        }
        $json = array("sMessage"=>"Users zijn opgehaald", "bSuccess"=>true, "data"=>$lst);
    } else {
        $json = array("sMessage"=>"Users zijn NIET opgehaald. SQL: ".$sql, "bSuccess"=>false, "data"=>null);
    }
}

// https://wpf.stegion.nl/api/wpf.php?action=getMediaPerUser
// media: `id`, `img`, `id_cand`, `videos`, `desc`
//users: `id`, `vnaam`, `tv`, `anaam`, `ww`, `email`, `role`, `beschrijving`, `titel`, `groep_opm`
if( $_GET["action"] == "getMediaPerUser" ) {
    $sql = "SELECT u.vnaam, u.tv, u.anaam, u.role, u.beschrijving, u.titel, u.groep_opm, 
                   m.img, m.id_cand, m.videos, m.desc
			FROM users AS u
            INNER JOIN media AS m ON u.id = m.id_cand
			ORDER BY anaam;  ";
    $res = mysqli_query($con, $sql);
    if($res) {
        $lst = array();
        while($rij = mysqli_fetch_assoc($res)) {

            $lst[] = array_map("utf8_encode", $rij);
        }
        $json = array("sMessage"=>"Users zijn opgehaald", "bSuccess"=>true, "data"=>$lst);
    } else {
        $json = array("sMessage"=>"Users zijn NIET opgehaald. SQL: ".$sql, "bSuccess"=>false, "data"=>null);
    }
}

if( $_GET["action"] == "inlog" ) {
    //if username and pw correct
    //S_SESSION["ingelogd"] =true;
}

if( $_SESSION["ingelogd"] OR $_GET["secret"] == "geheimpje" ) {

    //  http://15euros.nl/api/beer_all.php?action=updateBeer
    if( $_GET["action"] == "updateBeer" ) {
        //bier__bier: `id`, `naam`, `brouwer`, `type`, `gisting`, `perc`
        $sql = "UPDATE bier__bier_edit SET
						naam 	= '" . $_POST["data"]["naam"] . "',
						brouwer = '" . $_POST["data"]["brouwer"] . "',
						type	= '" . $_POST["data"]["type"] . "',
						gisting	= '" . $_POST["data"]["gisting"] . "',
						perc	= '" . $_POST["data"]["perc"] . "'
					WHERE id = " . $_POST["data"]["id"] . "; ";
        $res = mysqli_query($con, $sql);
        if ($res) {
            // evt. het geupdate record weer ophalen om terug te geven
            //$sql  = " SELECT * FROM csp3__product ";
            //$sql .= " WHERE id = '".$_POST["id_product"]."' ";
            $json = array(
                "sMessage" => "Bier is aangepast",
                "bSuccess" => true,
                "data" => null
            );
        } else {
            $json = array(
                "sMessage" => "Biertjes zijn NIET ge-update. SQL: " . $sql,
                "bSuccess" => false,
                "data" => null
            );
        }
    }

    if( $_GET["action"] == "deleteBeer" ) {
        //bier__bier: `id`, `naam`, `brouwer`, `type`, `gisting`, `perc`
        $sql = "DELETE FROM bier__bier_edit 
					WHERE id = ".$_POST["data"]["id"]."; ";
        $res = mysqli_query($con, $sql);
        if($res) {
            // evt. het geupdate record weer ophalen om terug te geven
            //$sql  = " SELECT * FROM csp3__product ";
            //$sql .= " WHERE id = '".$_POST["id_product"]."' ";
            $json = array(
                "sMessage"=>"Bierje is gewist",
                "bSuccess"=>true,
                "data"=>null
            );
        } else {
            $json = array(
                "sMessage"=>"Biertje is niet gewist. SQL: ".$sql,
                "bSuccess"=>false,
                "data"=>null
            );
        }

    }
}  // einde van secret


echo json_encode($json);
