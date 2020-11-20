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
        <option value="fotograaf">fotograaf</option>
        <option value="videograaf">videograaf</option>
        </select>
    </p>

    <p>
    	<label for="beschrijving">beschrijving:</label>
        <input type="text" name="beschrijving" id="beschrijving">
    </p>
    <p>
    	<label for="titel">titel:</label>
        <input type="text" name="titel" id="titel">
    </p>
    <input type="submit" value="Add Records">
</form>
</body>
</html>
