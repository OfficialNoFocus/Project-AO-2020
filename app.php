<!DOCTYPE html>
<html lang="nl">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#000">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Worldpress</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <!--jQuery 2 nog om geJSON en load functie, die 2 omzetten en je kunt jQuery 3 gebruiken-->
    <!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


    <link rel="dns-prefetch" href="https://fonts.gstatic.com/">
    <link href="css/app.css" rel="stylesheet">

    <style>
        .btn-danger {
            color: #fff;
            background-color: #ff0000;
            border-color: #e3342f;
            font-weight:700;
            margin:5px 0;

        }
        #overlay {
            position: fixed; /* Sit on top of the page content */
            display: none; /* Hidden by default */
            width: 100%; /* Full width (cover the whole page) */
            height: 100%; /* Full height (cover the whole page) */
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('../img/under_construction.png');
            background-repeat: no-repeat;
            background-position: center;

            background-color: rgba(0,0,0,0.5); /* Black background with opacity */
            z-index: 2; /* Specify a stack order in case you're using a different order for other elements */
            cursor: pointer; /* Add a pointer on hover */
        }
    </style>

</head>

<body style="background-color: #ff0000;">
<?php if(isset($_GET["overlay"]) && $_GET["overlay"] != 1) {
    echo '<div id="overlay"></div>';
}
?>

<div id="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel" style="background-color: black;">
        <div class="container">
            <div class="navbar-header"><a href="https://worldpresswedstrijd.nl/" class="navbar-brand"><img
                        src="img/logo.png" alt="" style="height: 40px;"></a></div>
            <ul style="display: flex; list-style-type: none; margin-top: 15px;">
                <li><a href="javascript:loadMedia(true)"  style="color: rgb(255, 0, 0);">Foto's</a></li>
                <li><a href="javascript:loadMedia(false)" style="color: rgb(255, 0, 0); margin-left: 20px;">Video's</a></li>
            </ul>
        </div>
    </nav>
    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card" id="error" style="margin-bottom: 15px; background-color: black; color: white;">

                        <div class="card-body">

                                <div style="display:flex; justify-content: space-between; align-items: center; ">
                                    <div style="border:0px solid lime;">
                                        <select style="width: 100px; padding: 4px;">
                                            <option value="2019" <?php if(date("Y") === "2019") echo"selected='selected';" ?>>2019 <?php if(date("Y") === "2019") echo"(Nu)" ?></option>
                                            <option value="2020" <?php if(date("Y") === "2020") echo"selected='selected';" ?>>2020 <?php if(date("Y") === "2020") echo"(Nu)" ?></option> 
                                        </select>
                                        <div style="display:flex;">
                                            <button onclick="nextCand(false)" class="btn btn-danger btn-sm"">
                                                <img src="vendor/icons-master/icons/chevron-left.svg" fill="/#ffffff" alt="left" />
                                            </button>
                                            <h4 style="margin: 0; padding: 10px;" id="name_candidate">Kandidaat</h4>
                                            <button onclick="nextCand(true)" class="btn btn-danger btn-sm"">
                                                <img src="vendor/icons-master/icons/chevron-right.svg" alt="left" />
                                            </button>
                                        </div>
                                    </div>

                                    <div class="float-right" style="width:100px; margin-left:10px;">
                                        <div>
                                            <button class="btn-danger btn-sm" disabled role="button" style="width:100%;" id="btn_qrcode" onclick="fStem()">
                                                scan, of vul in
                                            </button>
                                        </div>
                                        <div>
                                            <?php
                                            if(isset($_GET["param"]) && $_GET["param"] != ""){
                                                echo '<div onclick="fClickInput()"><input type="text" id="inp_qrcode" onclick="fClickInput()" style="width:100%;" disabled  value="'.$_GET["param"].'" ></div>';
                                            } else {
                                                echo '<input type="text" id="inp_qrcode" style="width:100%;"  placeholder="vul stemcode in">'; /*onchange="changedInput(this)"*/
                                            }
                                            ?>
                                        </div>
                                       <!-- <button class="btn-danger btn-sm" disabled role="button" style="width:100%;" onclick="fClickInput()">
                                            wis
                                        </button>
                                        <div onclick="()">oeps</div>-->
                                    </div>

                                </div>

                        </div>
                    </div>
                    <div class="card" style="background-color: black; color: white;">
                        <!-- <div class="card-header" style=""></div>-->
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6">

                                    <div id="div_foto" style="margin-bottom:10px">
                                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                            <ol class="carousel-indicators" id="indicators_cand"></ol>
                                            <div class="carousel-inner" id="carousel_inner_cand"></div>
                                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </div>
                                    </div>

                                    <div id="div_video">
                                        <div class="bs-example" data-example-id="responsive-embed-16by9-iframe-youtube" id="div_iframe_video">
                                            <div class="embed-responsive embed-responsive-16by9" style="margin-bottom:10px">
                                                <iframe class="embed-responsive-item" id="iframe_video" allowfullscreen="" ></iframe>
                                            </div>
                                        </div>
                                        <div id="loadingMessage" style="color:#FF0000; text-align:center; padding:90px 0; font-weight:700;">
                                            <h4 >Aan het laden...</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div>

                                        <span>
                                            <div><h4 id="title_cand">titel</h4></div>
                                            <h5 id="group_cand">groep</h5>
                                            <span id="desc_cand">beschrijving</span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<script type="text/javascript">

    var fotoCand = [];
    var videoCand = [];
    var dataCand;
    var currentIndexCand = 0;
    var current_bFoto = true;

    const $source = document.querySelector('#inp_qrcode');

    const typeHandler = function(e) {
        var value = e.target.value; //$(el).val();
        changeButton (value);

    }
    $source.addEventListener('input', typeHandler) // register for oninput
    $source.addEventListener('propertychange', typeHandler) // for IE8

    function changeButton (value) {
        //console.log("value.length=" + value.length);
        var sActive = "video";
        if(current_bFoto)
            sActive = "foto";
        if (value.length > 8) {
            $("#btn_qrcode").html("stem op "+ sActive +" "+ dataCand.vnaam);
            $('#btn_qrcode').prop('disabled', false);
        } else {
            $("#btn_qrcode").html("vul code in of scan QR code");
            $('#btn_qrcode').prop('disabled', true);
        }
    }

    function fClickInput() {
        //alert("check");
        var txt;
        if (confirm("Bestaande code wissen?")) {
            //txt = "You pressed OK!";
            window.location.href ="https://worldpresswedstrijd.nl";
        } else {
            //txt = "You pressed Cancel!";
        }
        //document.getElementById("demo").innerHTML = txt;
    }

    function fStem() {
        var qrcode = $("#inp_qrcode").val();
        //console.log("dataCand.id = ", dataCand.id );
        //console.log("fStem qrcode = "+qrcode );

        // https://worldpresswedstrijd.nl/?action=setVote&param=123605722539&video=2
        // https://worldpresswedstrijd.nl/?action=setVote&param=123605722539&foto=4
        /*{
            sMessage: "stem is succesvol",
            bSuccess: true,
            data: null
        }*/
        var sActive = "video";
        if(current_bFoto)
            sActive = "foto";

        $.getJSON( "https://worldpresswedstrijd.nl/?action=setVote&param="+qrcode+"&"+sActive+"="+dataCand.id+"", function( json ) {
            //console.log("antwoord van vote:", json);
            var sMes = "";
            if(!json.bSuccess) {
                sMes = "stemmen op de "+sActive+ " van " +  dataCand.vnaam+" "+dataCand.tv+" "+dataCand.anaam+ " niet gelukt. Code is al gebruikt of bestaat niet.";
                //sMes = "fout bij stemmen: " + json.sMessage;
            } else {
                    sMes = "er is gestemd op de "+sActive+ " van " + dataCand.vnaam+" "+dataCand.tv+" "+dataCand.anaam;
                    //sMes = "stemmen gelukt: " + json.sMessage;
            }
            alert(sMes);
        });
    }

    //$('#loadingMessage').on("load", function (e) {})  //in jquery 3
    $('#iframe_video').load(function () {
        $('#loadingMessage').css('display', 'none');
        $('#div_iframe_video').css('display', 'block');
        //console.log("load");
    });

    function initData() {
        $.getJSON( "https://worldpresswedstrijd.nl/?action=getMediaPerUser", function( json ) { //https://wpf.stegion.nl/api/wpf.php?action=getMediaPerUser
            //console.log( "json:", json );

            var bfotoCand;
            var idCand = 0;
            var objCand = {};
            $.each(json.data, function( key, val ) {
                if(idCand != val.id_cand) { //nieuwe candidate
                    if(!$.isEmptyObject(objCand))
                        if(objCand.bfotoCand)
                            fotoCand.push(objCand); // if not (empty) first one: push photo Candidate in array
                        else
                            videoCand.push(objCand); // if not (empty) first one: push video Candidate in array
                    idCand = val.id_cand;
                    objCand = {};

                    if(val.videos == "")
                        bfotoCand = true
                    else
                        bfotoCand = false;

                    objCand = {
                        bfotoCand: bfotoCand,
                        id: val.id_cand,
                        vnaam: val.vnaam,
                        tv: val.tv,
                        anaam: val.anaam,
                        titel: val.titel,
                        beschrijving: val.beschrijving,
                        groep_opm: val.groep_opm,
                        foto:[val.img+'.jpg'],
                        desc:[val.desc],
                        video:val.videos
                        //u.vnaam, u.tv, u.anaam, u.role, u.beschrijving, u.titel, u.groep_opm,
                        //m.img, m.id_cand, m.videos, m.desc
                    }
                } else { // if candidate exist just pus photo
                    if(bfotoCand) {
                        objCand.foto.push(val.img+'.jpg');
                        objCand.desc.push(val.desc);
                    }
                }

            });
            if(objCand.bfotoCand)
                fotoCand.push(objCand);  // push last photo candidate in array
            else
                videoCand.push(objCand); // push last video candidate in array

            //console.log( "fotoCand = ", fotoCand);
            //console.log( "videoCand = ", videoCand);

            //loadCandidate(currentIndexCand, current_bFoto);
            loadMedia(current_bFoto);
        });
    }

    function loadCandidate(index, bFoto) {
        currentIndexCand = index;
        current_bFoto = bFoto;
        if(bFoto) {
            dataCand = fotoCand[index];
        } else {
            dataCand = videoCand[index];
        }
        // console.log(dataCand);

        $("#name_candidate").html(dataCand.vnaam+" "+dataCand.tv+" "+dataCand.anaam);   // fill name candidate
        $("#title_cand").html(dataCand.titel);                                          // fill title candidate
        $("#group_cand").html(dataCand.groep_opm);                                      // fill groep candidate
        $("#desc_cand").html(dataCand.beschrijving);                                    // fill description candidate

        if(bFoto) {
            // fill indicators an carousel-items candidate
            var sLis = "";
            var sDivs = "";
            $.each(dataCand.foto, function( index, foto ) {
                //console.log(foto);
                if(index == 0) sLis += '<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>'
                else           sLis += '<li data-target="#carouselExampleIndicators" data-slide-to="'+index+'"></li>'

                if(index == 0) sDivs += '<div class="carousel-item active"><img src="resources/'+foto+'" class="d-block w-100" alt="..."></div>'
                else           sDivs += '<div class="carousel-item"       ><img src="resources/'+foto+'" class="d-block w-100" alt="..."></div>'

            });

            $("#indicators_cand").html(sLis);
            $("#carousel_inner_cand").html(sDivs);
        } else {
            /*$('#iframe_video').css('display', 'none');*/
            $('#div_iframe_video').css('display', 'none');

            $('#loadingMessage').css('display', 'block');
            $("#iframe_video").attr('src', 'https://www.youtube.com/embed/'+dataCand.video);   //uP2qIPTCjec";
        }

    }

    function nextCand(bNext) {
        if(bNext) {
            currentIndexCand++;
            if( current_bFoto && currentIndexCand >  fotoCand.length) currentIndexCand = 0;
            if(!current_bFoto && currentIndexCand > videoCand.length) currentIndexCand = 0;
        } else {
            currentIndexCand--;
            if( current_bFoto && currentIndexCand < 0) currentIndexCand = fotoCand.length-1;
            if(!current_bFoto && currentIndexCand < 0) currentIndexCand = videoCand.length-1;
        }
        console.log("loadCandidate, currentIndexCand= "+currentIndexCand+", current_bFoto="+current_bFoto);
        loadCandidate(currentIndexCand, current_bFoto);
        changeButton ($("#inp_qrcode").val() );
    }

    function loadMedia(bFoto) {
        currentIndexCand = 0;
        if(bFoto) {
            current_bFoto = true;
            $("#div_foto").css({"display": "block"});
            $("#div_video").css({"display": "none"});
        }
        else {
            current_bFoto = false;
            $("#div_foto").css({"display": "none"});
            $("#div_video").css({"display": "block"});
        }
        loadCandidate(currentIndexCand, bFoto);
        changeButton ($("#inp_qrcode").val() );
    }

    initData();
</script>

</body>
</html>
