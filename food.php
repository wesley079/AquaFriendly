<?php
require_once("settings.php");

//connect to database - define at "Settings.php"
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

$queryAquarium = "SELECT food FROM aquarium WHERE id= 1";  //id hard-coded - only 1 aquarium
$aquaInfo = $mysqli->query($queryAquarium);

//make string to export Json
$foodInformation = [];

if ($aquaInfo->num_rows > 0) {

    //save aquarium data to
    while ($row = $aquaInfo->fetch_assoc()) {
        $foodInformation[] = $row["food"];
    }
}
else{
    $foodInformation[] = "not active";
}
header('Content-Type: application/json');
echo json_encode($foodInformation);
exit;