<?php

include("../database/selectUmgebung.php");

$clientIP =


$clientIP = $_GET["ip"] ?? '2';



echo "ip adresse: " . $clientIP . "<br>";

foreach ($unsereTabelle as $datensatz) {

    if (isset($datensatz[2]) && $clientIP === $datensatz[2] && $datensatz[2] !== null) {
        echo "Gefundene IP: " . $datensatz[2] . "<br>";
        echo "Titel: " . $datensatz[1] . "<br>";
        header("Location: /anzeigeTherminal/index.php?ip=" . urlencode($datensatz[1]));
        exit;
    };
}

?>