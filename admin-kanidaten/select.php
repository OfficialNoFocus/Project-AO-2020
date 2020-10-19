<?php
    session_start();
    define('REMOTE_URL','http://school.local');
    require_once($_SERVER['DOCUMENT_ROOT']."/API/Database.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/API/Settings.php");
    // require($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');
    // dd( intval($_GET['id']));
    // dd((new API\Database(API\Settings::getDatabaseCredentials()))->getUser(1));
    $id = intval($_GET['id']);
    if($id > 0) {
        $grapher = (new API\Database(API\Settings::getDatabaseCredentials()))->getUser($id);
    }
    else {
        return header("HTTP/1.0 404 Not Found");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" crossorigin="anonymous">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
</head>
<body>
    <div class="row px-2 px-lg-3 mx-0">
        <div class="col-lg-6 p-2 p-lg-4">
            <div class="bg-white shadow rounded p-4 p-lg-5">
                <h2>Informatie</h2>
                <?php
                if(!empty($grapher[$id]['groep_opm'] )) {
                echo'
                <div class="information-field">
                    <b>Groep Kanidaten</b>
                    <p>'.($grapher[$id]["groep_opm"]).'</p>
                </div>
                ';
                }
                else{
                echo '
                <div class="information-field">
                    <b>Naam</b>
                    <p>'.($grapher[$id]['naam']).'</p>
                </div>';
                }
                ?>
                <div class="information-field">
                    <b>Jaar</b>
                    <p><?php echo($grapher[$id]['jaar']) ?></p>
                </div>
                <div class="information-field">
                    <b>Onderdeel</b>
                    <p><?php echo($grapher[$id]['role']) ?></p>
                </div>
            </div>
            <br>
            <div class="bg-white shadow rounded p-4 p-lg-5">
                <h2>Title</h2>
                <div class="information-field">
                    <p><?php echo($grapher[$id]['titel']) ?></p>
                </div>
                <div class="information-field">
                    <b>Beschrijving</b>
                    <p><?php echo($grapher[$id]['beschrijving']) ?></p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 p-2 p-lg-4">
            <div class="bg-white shadow rounded p-4 p-lg-5">
            <!-- de afbeeldingen en video -->
                <h2>Website</h2>
                    <div class="information-field">
                        <b>Url-website:</b>
                        <p>{{$winetasting->url}}</p>
                    </div>
                    <div class="information-field">
                        <b>Url-Facebook:</b>
                        <p>{{$winetasting->fb_url}}</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>