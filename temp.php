<?php
require_once("settings.php");

//connect to database - define at "Settings.php"
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

$type = $_GET["chosen"];


if($type == "Automatic"){
    $number = 0;
}
elseif($type == "Manual"){
    //manual = true
    $number = 1;
    $manual = $_GET["manual"];
}

else{
    //wrong input - do automatic standard
    $number = 0;
}


//insert posted data
$query = "UPDATE aquarium SET manual='$number' WHERE id=1";
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

if($type == "Manual"){
    $query2 = "UPDATE aquarium SET manual_temp='$manual' WHERE id=1";
    $mysqli->query($query2);
}



$mysqli->query($query);
