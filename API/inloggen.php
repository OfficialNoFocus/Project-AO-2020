<?php
  session_start();

  

  if(!isset($_SESSION["ingelogd"])){

    // var_dump($_POST["username"]);
    // die();

    if(isset($_POST["username"]) && $_POST["username"] == "worldpressAdmin" && isset($_POST["password"]) && $_POST["password"] == "Geheim123!"){
      $_SESSION["ingelogd"] = true;
    } else {
      $_SESSION["ingelogd"] = false;
    }
  }

  header("Location: "+REMOTE_URL+"/beveilig_admin_geentoegang.php");
?>