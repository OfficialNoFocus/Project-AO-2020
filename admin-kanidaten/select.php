<?php
    session_start();
    define('REMOTE_URL','http://school.local');
    require_once($_SERVER['DOCUMENT_ROOT']."/API/Database.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/API/Settings.php");
    // require($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');
    // dd( intval($_GET['id']));
    // dd((new API\Database(API\Settings::getDatabaseCredentials()))->deleteUser(3));
    // dd((new API\Database(API\Settings::getDatabaseCredentials()))->getMediaPerUserYear(2019));
    $id = intval($_GET['id']);
    if($id > 0) {
        $grapher = (new API\Database(API\Settings::getDatabaseCredentials()))->getUser($id);

        $media = (new API\Database(API\Settings::getDatabaseCredentials()))->getUserPhotos($id);
        if(!$media){
            $media = (new API\Database(API\Settings::getDatabaseCredentials()))->getUserVideo($id);
        }
        if(!$media){
            return header("HTTP/1.0 404 Not Found");
        } 
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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <!-- can be replaced with bootstrap cdn -->
    <link href="<?php echo(REMOTE_URL) ?>/css/app.css" rel="stylesheet">
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
                <h2>Media</h2>
                    <div class="information-field">
                        <?php
                        if(sizeof($media) > 1) {
                            $i = 0;
                            echo('
                            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
                                </ol>
                                <div class="carousel-inner">
                            ');
                            foreach ($media as $content) {
                                
                                    $foto = $content["img"];
                                    $disc = $content["desc"];
                                    if($i > 0) {
                                    echo('
                                        <div class="carousel-item">
                                            <img src="'.REMOTE_URL.'/resources/'.$foto.'.jpg" class="d-block w-100" alt="'.$i++.'"/>
                                            <div class="carousel-caption d-none d-md-block">
                                                <p>'.$disc.'</p>
                                            </div>
                                        </div>
                                    ');
                                    }
                                    else {
                                    echo('
                                        <div class="carousel-item active">
                                            <img src="'.REMOTE_URL.'/resources/'.$foto.'.jpg" class="d-block w-100" alt="'.$i++.'"/>
                                            <div class="carousel-caption d-none d-md-block">
                                                <p>'.$disc.'</p>
                                            </div>
                                        </div>
                                    ');
                                    }      
                                }  
                                echo('
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                            ');
                        }
                        else {
                            foreach ($media as $content) {
                                $video = $content["video"];
                                echo('
                                    <div id="div_video">
                                        <div class="bs-example" data-example-id="responsive-embed-16by9-iframe-youtube" id="div_iframe_video">
                                            <div class="embed-responsive embed-responsive-16by9" style="margin-bottom:10px">
                                                <iframe class="embed-responsive-item" id="iframe_video" allow="allowfullscreen" src="https://www.youtube.com/embed/'.$video.'" ></iframe>
                                            </div>
                                        </div>
                                    </div>
                                ');
                            }
                        }
                    ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
        body {
            background-color: #4a4a4a;
        }
        h2 {
            border-bottom: 1px solid #4a4a4a;
        }
    </style>
</body>
</html>