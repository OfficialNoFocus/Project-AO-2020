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
                <select style="width: 100px; padding: 4px;">
                  <option value="2019" <?php if(date("Y") === "2019") echo"selected='selected';" ?>> 2019 <?php if(date("Y") === "2019") echo"(Nu)" ?> </option>
                  <option value="2020" <?php if(date("Y") === "2020") echo"selected='selected';" ?>> 2020 <?php if(date("Y") === "2020") echo"(Nu)" ?> </option>
                </select>
                <hr />
                <div class="tabs">
                  <div class="tab-2">
                    <div>
                      <label for="tab2-1">Fotografen
                        <a href="<?php echo REMOTE_URL?>/admin-kanidaten/home.php?role=photographer">
                          <i class="fas fa-eye"></i>
                          <span class="tooltiptext">Klik voor overview</span>
                        </a>
                      </label>
                    </div>
                    <input id="tab2-1" name="tabs-two" type="radio" checked="checked">
                    <div class="columns">
                      <?php
                        $loopcount = 0;
                        foreach ($allvotes as $value) {
                          $naam = $value["naam"];
                          $stemmen = $value["votes"];
                          $type = $value["role"];
                          if($type == "fotograaf"){
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
                  <div class="tab-2">
                    <label for="tab2-2">Videografen
                      <a href="<?php echo REMOTE_URL?>/admin-kanidaten/home.php?role=videographer">
                        <i class="fas fa-eye"></i>
                        <span class="tooltiptext">Klik voor overview</span>
                      </a>
                    </label>
                    <input id="tab2-2" name="tabs-two" type="radio">
                    <div class="columns">
                      <?php
                        $loopcount = 0;
                        foreach ($allvotes as $value) {
                          $naam = $value["naam"];
                          $stemmen = $value["votes"];
                          $type = $value["role"];
                          if($type == "videograaf"){
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
                <style>
                  .column.is-one-third, .column.is-one-third-tablet {
                    float: left;
                  }
                  button:focus,
                  input:focus,
                  textarea:focus,
                  select:focus {
                    outline: none; 
                  }
                  .tabs {
                    display: block;
                    display: -webkit-flex;
                    display: -moz-flex;
                    display: flex;
                    -webkit-flex-wrap: wrap;
                    -moz-flex-wrap: wrap;
                    flex-wrap: wrap;
                    margin: 0;
                    overflow: hidden; 
                    margin-bottom: 0!important;
                  }
                  .tabs [class^="tab"] label,
                  .tabs [class*=" tab"] label {
                    color: #efedef;
                    cursor: pointer;
                    display: block;
                    font-size: 1.1em;
                    font-weight: 300;
                    line-height: 1em;
                    padding: 2rem 0;
                    text-align: center; 
                  }
                  .tabs [class^="tab"] label a,
                  .tabs [class*=" tab"] label a{  
                    position: relative;
                    display: unset;
                    padding: 0;
                    border: none;
                  }
                  label a .tooltiptext {
                    visibility: hidden;
                    width: 145px;
                    background-color: #f5f5f5;
                    color: #000;
                    text-align: center;
                    border-radius: 6px;
                    padding: 5px 0;
                    position: absolute;
                    z-index: 1;
                    bottom: 110%;
                    left: -10%;
                    margin-left: -60px;
                  }
                  label a .tooltiptext::after {
                    content: "";
                    position: absolute;
                    top: 100%;
                    left: 50%;
                    margin-left: -5px;
                    border-width: 5px;
                    border-style: solid;
                    border-color: #f5f5f5 transparent transparent transparent;
                  }
                  label a:hover .tooltiptext {
                    visibility: visible;
                  }
                  .tabs [class^="tab"] [type="radio"],
                  .tabs [class*=" tab"] [type="radio"] {
                    border-bottom: 1px solid rgba(239, 237, 239, 0.5);
                    cursor: pointer;
                    -webkit-appearance: none;
                    -moz-appearance: none;
                    appearance: none;
                    display: block;
                    width: 100%;
                    -webkit-transition: all 0.3s ease-in-out;
                    -moz-transition: all 0.3s ease-in-out;
                    -o-transition: all 0.3s ease-in-out;
                    transition: all 0.3s ease-in-out; 
                  }
                  .tabs [class^="tab"] [type="radio"]:hover, .tabs [class^="tab"] [type="radio"]:focus,
                  .tabs [class*=" tab"] [type="radio"]:hover,
                  .tabs [class*=" tab"] [type="radio"]:focus {
                    border-bottom: 1px solid #ff0000; 
                  }
                  .tabs [class^="tab"] [type="radio"]:checked,
                  .tabs [class*=" tab"] [type="radio"]:checked {
                    border-bottom: 2px solid #ff0000; 
                  }
                  .tabs [class^="tab"] [type="radio"]:checked + div,
                  .tabs [class*=" tab"] [type="radio"]:checked + div {
                    opacity: 1; 
                  }
                  .tabs [class^="tab"] [type="radio"] + div,
                  .tabs [class*=" tab"] [type="radio"] + div {
                    display: block;
                    opacity: 0;
                    padding: 2rem 0;
                    width: 90%;
                    -webkit-transition: all 0.3s ease-in-out;
                    -moz-transition: all 0.3s ease-in-out;
                    -o-transition: all 0.3s ease-in-out;
                    transition: all 0.3s ease-in-out; 
                  }
                  .tabs .tab-2 {
                    width: 50%; 
                  }
                  .tabs .tab-2 [type="radio"] + div {
                    width: 200%;
                    margin-left: 200%; 
                  }
                  .tabs .tab-2 [type="radio"]:checked + div {
                    margin-left: 0; 
                  }
                  .tabs .tab-2:last-child [type="radio"] + div {
                    margin-left: 100%; 
                  }
                  .tabs .tab-2:last-child [type="radio"]:checked + div {
                    margin-left: -100%; }
                </style>
                
              </h1>  
            </div>
          </div>
        </div>
      </div>
    </section>

  </body>
</html>