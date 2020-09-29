<?php 
namespace API;
session_start();

define('REMOTE_URL','http://school.local');
require_once("API/API.php");

API::runAPI();