<?php
    session_start();
    define('REMOTE_URL','http://school.local');
    require_once($_SERVER['DOCUMENT_ROOT']."/API/Database.php");
    require_once($_SERVER['DOCUMENT_ROOT']."/API/Settings.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Create user</title>
</head>
<body>
<form action="insert.php" method="post">
	<p>
    	<label for="vnaam">Voornaam:</label>
        <input type="text" name="vnaam" id="vnaam">
    </p>
    <p>
    	<label for="tv">tussenvoegsel:</label>
        <input type="text" name="tv" id="tv">
    </p>
    <p>
    	<label for="anaam">Achternaam:</label>
        <input type="text" name="anaam" id="anaam">
    </p>
    <p>
    	<label for="jaar">jaar:</label>
        <select name="jaar" id="jaar">
        <option value="2019">2019</option>
        <option value="2020">2020</option>
        <option value="2021">2021</option>
        </select>
    </p>
    <p>
    	<label for="role">role:</label>
        <select name="role" id="role">
        <option  value="fotograaf">fotograaf</option>
        <option value="videograaf">videograaf</option>
        </select>
    </p>

    <p>
    	<label for="beschrijving">beschrijving:</label>
        <textarea name="beschrijving" id="beschrijving"> </textarea>
    </p>
    <p>
    	<label for="titel">titel:</label>
        <input type="text" name="titel" id="titel">
    </p>
    <input type="submit" onclick="return confirm('Weet u zeker dat u deze persoon wilt toevoegen?')" value="Add Records">
</form>
<style>
body{
    background-color: #4a4a4a;
}
form {
    width: fit-content;
    margin: 0 auto;
    background-color: #fff;
    padding: 14px 30px 30px 30px;
    box-shadow: 0 .5rem 1rem rgba(0,0,0,0.15)!important;
    border-radius: 4px;
}
form  input{
    width: 100%;
}
form p label{
    display: block;
    width: 45%;
    float: left;
}
form p input{
    width: 52%;
}
form p textarea{
    width: 52.5%;
    height: 50px;
}
form p select{
    width: 55%;
}
</style>
</body>
</html>
