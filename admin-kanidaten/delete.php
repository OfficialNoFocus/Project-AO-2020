<?php
    session_start();
    define('REMOTE_URL','http://school.local');
    require_once($_SERVER['DOCUMENT_ROOT']."/API/Database.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/API/Settings.php");
    // require($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');

    $id = intval($_GET['id']);
    (new API\Database(API\Settings::getDatabaseCredentials()))->deleteUser($id);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
?>