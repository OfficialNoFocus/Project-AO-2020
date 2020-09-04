<?php
namespace API;

class Settings  
{
  private static $env = "prod";
  private static $host = "localhost";
  private static $dbname = "stegion_wpf";
  private static $voteUrl = "https://worldpresswedstrijd.nl/?action=createVote&param=";

  public static function getVoteUrl()
  {
    return Settings::$voteUrl;
  }

  public static function getDatabaseCredentials()
  {
    if(Settings::$env === "debug/boyd"){
      return [
        Settings::$host,
        "root",
        "",
        Settings::$dbname
      ];
    } else if (Settings::$env === "debug/testserver"){
      return [
        Settings::$host,
        "stegion_wpf",
        "password",
        Settings::$dbname
      ];
    } else if (Settings::$env === "prod") {
      return [
        Settings::$host,
        "worldpress",
        "password",
        "worldpress_tdn"
      ];
    }
  }
}
