<?php
require_once("settings.php");

//connect to database - define at "Settings.php"
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

$climate = $_GET["chosen"];

if($climate == "Rainy"){
    $number = 1;
}
elseif($climate == "Tropical"){
    $number = 2;
}
elseif($climate == "Sunny"){
    $number = 3;
}
elseif($climate == "Cloudy"){
    $number = 4;
}
else{
    //start new automatic
    $number = 1;
}


//insert posted data
$query = "UPDATE aquarium SET climate='$number' WHERE id=1";
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

if($climate == "Automatic"){
    $query2 = "UPDATE aquarium SET automatic=1 WHERE id=1";
}
else{
    $query2 = "UPDATE aquarium SET automatic=0 WHERE id=1";
}


$mysqli->query($query);
$mysqli->query($query2);