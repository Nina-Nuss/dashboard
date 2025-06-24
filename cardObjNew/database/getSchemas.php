<?php

// include("../cardObjNew/database/selectCardObj.php");
//                 imagePath: item[1],
ob_start();

// Pfad zum gewünschten Ordner
include("../database/selectCardObj.php");
include("../database/selectUmgebung.php");

ob_end_clean();

$input = json_decode(file_get_contents("php://input"), true);

$ipGefunden = false;

$jsonList1 = json_decode($jsonList1); //Schemas
$jsonList2 = json_decode($jsonList2); //Infoterminals


$ip = $input['ip'] ?? 'aulaa';



foreach ($jsonList2 as $infotherminal) {
    if ($ip == $infotherminal[1]) {
        $ip = $infotherminal[2];
        // echo "<br>Gefundene IP: " . $ip . "<br>";
        $ipGefunden = true;
    }

}

if(!$ipGefunden) {
    // echo "<br>IP nicht gefunden, Standardwert wird verwendet: " . $ip . "<br>";
    return json_encode([]); // Rückgabe eines leeren Arrays, wenn die IP nicht gefunden wurde
}



$images = getAllImages();

$imagesContainer = array();


foreach ($images as $image) {
    // echo "<br>" . "gesuchtes Bild: " . $image . "<br>";
    foreach ($jsonList1 as $item) {
        if ($item[1] == $image && $item[6] == $ip) {
            array_push($imagesContainer, $item);

            // echo "<br>";
            // echo "bild ist im ort: " . $item[6];
        }
    }
};

$imageList = json_encode($imagesContainer);

echo $imageList;

// echo "<br>";
// echo "<br>";
// echo "<br>";

// foreach ($jsonList2 as $item) {
//     echo "<br>" . "ip adresse: " . $item[2] . "<br>";
//     if($item[2] == $ip) {
//         echo "<br>aktueller ort: " .  $item[1] . "<br>";

//     }
//     // foreach ($images as $image) {
//     //     if ($item[1] == $image) {
//     //         // echo "<br>Gefundenes Bild: " .  $image . "<br>";
//     //         array_push($array, $image);
//     //     }
//     // }
// }   

// echo "<br>";
// echo "<br>";
// echo "<br>";

// echo json_encode($array);
// Optional: IP-Adresse zurückgeben, falls benötigt

function getAllImages()
{

    $ordner = "../uploads";
    $array = array();
    // Prüfen, ob der Ordner existiert

    if (is_dir($ordner)) {
        // Alle Dateien und Ordner einlesen
        $dateien = scandir($ordner);

        // Nur Dateinamen (keine . und ..) ausgeben
        foreach ($dateien as $datei) {
            if ($datei !== "." && $datei !== "..") {
                array_push($array, $datei);
            }
        }
    } else {
        echo "Ordner nicht gefunden.";
    };

    return $array;
}
