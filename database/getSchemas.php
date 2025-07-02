<?php

// include("../cardObjNew/database/selectCardObj.php");
//                 imagePath: item[1],
ob_start();

// Pfad zum gewünschten Ordner
include("selectSchemas.php");
include("selectInfotherminal.php");
include("selectRelation.php");

ob_end_clean(); // Puffer leeren, um vorherige Ausgaben zu entfernen

$input = json_decode(file_get_contents("php://input"), true);

$ipGefunden = false;

$schemaList = json_decode($schemaList); //Schemas
$infothermalList = json_decode($infothermalList); //Infoterminals
$relationList = json_decode($beziehungsList); //Beziehungen

// $clientIP = $_SERVER['REMOTE_ADDR'];

$ip = $input['ip'] ?? 'begegnungshaus';

$therminal = array();

foreach ($infothermalList as $infotherminal) {
    if ($ip == $infotherminal[1]) {
        $ip = $infotherminal[2];
        $id = $infotherminal[0];
        //  "<br>Gefundene IP: " . $ip . "<br>";
        $ipGefunden = true;

        array_push($therminal, $id, $ip);
    }
}

if (!$ipGefunden) {
    // echo "<br>IP nicht gefunden, Standardwert wird verwendet: " . $ip . "<br>";
    return json_encode([]); // Rückgabe eines leeren Arrays, wenn die IP nicht gefunden wurde
}

$images = getAllImages();

$imagesContainer = array();

foreach ($images as $image) {
    // echo "<br>" . "gesuchtes Bild: " . $image . "<br>";
    foreach ($schemaList as $schema) {
        if($schema[1] == $image && $schema[3] == true){
            foreach ($relationList as $relation) {
                if ($relation[0] == $id && $relation[1] == $schema[0]) {
                        array_push($imagesContainer, $schema);
                }
            }
        }
    }
};

$imageList = json_encode($imagesContainer);

echo $imageList;

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

    $ordner = "../schemas/uploads";
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
