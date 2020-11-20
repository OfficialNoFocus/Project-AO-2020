<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "", "stegion_wpf");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
// Escape user inputs for security
$vnaam = mysqli_real_escape_string($link, $_REQUEST['vnaam']);
$tv = mysqli_real_escape_string($link, $_REQUEST['tv']);
$anaam = mysqli_real_escape_string($link, $_REQUEST['anaam']);
$jaar = mysqli_real_escape_string($link, $_REQUEST['jaar']);
$role = mysqli_real_escape_string($link, $_REQUEST['role']);
$beschrijving = mysqli_real_escape_string($link, $_REQUEST['beschrijving']);
$titel = mysqli_real_escape_string($link, $_REQUEST['titel']);
 
// attempt insert query execution
$sql  = "INSERT INTO users (vnaam, tv, anaam, jaar, role, beschrijving, titel) VALUES ('$vnaam','$tv', '$anaam','$jaar','$role','$beschrijving','$titel')";
if(mysqli_query($link, $sql)){
    echo "Records added successfully.";header( "refresh:5;url=http://school.local/beveilig_admin_geentoegang.php" );
    exit();
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
// close connection
mysqli_close($link);
?>