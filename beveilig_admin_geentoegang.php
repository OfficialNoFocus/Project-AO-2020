<?php 
  session_start();
  define('REMOTE_URL','http://school.local');
  require_once("API/Database.php");
  require_once("API/Settings.php");

  $dbinstance = new API\Database(API\Settings::getDatabaseCredentials());
  $allvotes = $dbinstance->getAllVotes();
  
  usort($allvotes, function($a, $b) {
    return $a['votes'] <=> $b['votes'];
  });
  $allvotes = array_reverse($allvotes);

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>

    <title>Worldpress wedstrijd - Admin</title>
  </head>
  <body>

  <div class="modal <?php 
    // if(!isset($_SESSION["ingelogd"]) || $_SESSION["ingelogd"] != true){
    //   echo "is-active";
    // } 
  ?>">
    <div class="modal-background"></div>
      <div class="modal-content">
        <div class="card">
          <div class="card-content">
            <p class="subtitle">u bent nog niet ingelogd</p>

            <form action="/API/inloggen.php" method="POST"> 

            <div class="field">
              <label class="label">Inloggen</label>
              <div class="control has-icons-left has-icons-right">
                <input class="input" type="text" name="username" placeholder="Gebruikersnaam">
                <span class="icon is-small is-left">
                  <i class="fas fa-user"></i>
                </span>
                <span class="icon is-small is-right">
                  <i class="fas fa-check"></i>
                </span>
              </div>
            </div>

            <div class="field">
              <p class="control has-icons-left">
                <input class="input" type="password" name="password" placeholder="Wachtwoord">
                <span class="icon is-small is-left">
                  <i class="fas fa-lock"></i>
                </span>
              </p>
            </div>

            <div class="field">
              <div class="control">
                <button class="button is-dark">Submit</button>
              </div>
            </div>

            </form>

          </div>
        </div>
      </div>
    <button class="modal-close is-large" aria-label="close"></button>
  </div>

  <section class="hero is-dark is-fullheight">
      <div class="hero-body">
        <div class="container">
          <div class="columns">
            <div class="column ">
              <h1 class="title">
                Stem voortgang
                  <hr />
                  <select style="width: 100px; padding: 4px;">
                    <option value="2019" <?php if(date("Y") === "2019") echo"selected='selected';" ?>> 2019 <?php if(date("Y") === "2019") echo"(Nu)" ?> </option>
                    <option value="2020" <?php if(date("Y") === "2020") echo"selected='selected';" ?>> 2020 <?php if(date("Y") === "2020") echo"(Nu)" ?> </option>
                  </select>
                  <a href="<?php echo REMOTE_URL?>/admin-kanidaten/home.php?role=photographer">Fotografen</a>
                  <a href="<?php echo REMOTE_URL?>/admin-kanidaten/home.php?role=videographer">Videografen</a>
                  <br />
                  <h2 class="subtitle" style="margin-top: -5px;">
                    fotograven: 
                  </h2>
              </h1>  
            </div>
          </div>
          <div class="columns">
          <?php
            $loopcount = 0;
            foreach ($allvotes as $value) {
              $naam = $value["naam"];
              $stemmen = $value["votes"];
              $type = $value["role"];
              if($type == "fotograaf"){
                if($loopcount != 0 && ($loopcount % 3) === 0){
                  echo "
                    </div>
                    <div class='columns'>
                  ";
                }
                echo "
                  <div class='column is-one-third'>
                    <div class='card'>
                      <div class='card-content'>
                        <p class='subtitle is-size-6 has-text-centered has-text-dark'>
                          $naam | $type
                        </p>
  
                        <hr />
  
                        <p class='has-text-success has-text-centered'>
                          $stemmen <span class='is-size-7'>stemmen</span>
                        </p>
                      </div>
                    </div>
                  </div>
                ";
                $loopcount++;
              }
            }
          ?>
          </div>

          <br />
          <h2 class="subtitle">
            videograven: 
          </h2>
          <div class="columns">
          <?php
            $loopcount = 0;
            foreach ($allvotes as $value) {
              $naam = $value["naam"];
              $stemmen = $value["votes"];
              $type = $value["role"];
              if($type == "videograaf"){
                if($loopcount != 0 && ($loopcount % 3) === 0){
                  echo "
                    </div>
                    <div class='columns'>
                  ";
                }
                echo "
                  <div class='column is-one-third'>
                    <div class='card'>
                      <div class='card-content'>
                        <p class='subtitle is-size-6 has-text-centered has-text-dark'>
                          $naam | $type
                        </p>
  
                        <hr />
  
                        <p class='has-text-success has-text-centered'>
                          $stemmen <span class='is-size-7'>stemmen</span>
                        </p>
                      </div>
                    </div>
                  </div>
                ";
                $loopcount++;
              }
            }
          ?>
          </div> 


        </div>
      </div>
    </section>

  </body>
</html>