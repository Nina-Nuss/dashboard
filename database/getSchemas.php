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
$infotherminalList = json_decode($infotherminalList); //Infoterminals
$relationList = json_decode($beziehungsList); //Beziehungen

$timeFormat = 'H:i:s';
$dateFormat = 'Y-m-d H:i:s';

$now = new DateTime('now', new DateTimeZone('Europe/Berlin'));

$nowTime = $now->format('H:i:s');
$nowDateTime = $now->format('Y-m-d H:i:s');

// $clientIP = $_SERVER['REMOTE_ADDR'];

$ip = $input['ip'] ?? 'empfang';

$therminal = array();

foreach ($infotherminalList as $infotherminal) {
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
        if ($schema[1] == $image && $schema[3] == true) {
            foreach ($relationList as $relation) {
                if ($relation[1] == $id && $relation[2] == $schema[0]) {
                    $timeIsBetween = checkTime($schema[4], $schema[5], $timeFormat, $nowTime, $schema);
                    $dateIsBetween = checkTime($schema[6], $schema[7], $dateFormat, $nowDateTime, $schema);
                    // echo $timeIsBetween . " von: " . $schema[4] . " bis: " . $schema[5] . "<br>";
                    // echo $dateIsBetween . " von: " . $schema[6] . " bis: " . $schema[7] . "<br>";
                    // if ($dateIsBetween === true) {
                    //     if ($timeIsBetween === true) {
                    //         array_push($imagesContainer, $schema);
                    //         continue 2; // Skip to the next image if both time and date are valid
                    //     }
                    // }
                    // if ($timeIsBetween === true) {
                    //     array_push($imagesContainer, $schema);
                    // }
                    array_push($imagesContainer, $schema);
                }
            }
        }
    }
};

function checkTime($start, $end, $format,   $time, $schema)
{
    if (isset($start) && isset($end)) {
        $timeIsBetween = checkDateTime($start, $end, $format, $time);
        return $timeIsBetween;
    } else {
        return false;
    }
}

$imageList = json_encode($imagesContainer);

echo $imageList;

function checkDateTime($start, $end, $format, $now)
{
    if (empty(trim($start)) || empty(trim($end))) {
        return true;
    }
    $startTime = createDateTimeFormat($start, $format);
    $endTime = createDateTimeFormat($end, $format);
    $nowTime = createDateTimeFormat($now, $format);

    if ($startTime && $endTime && $nowTime) {
        return ($nowTime >= $startTime && $nowTime <= $endTime);
    }
    return false;
}

function createDateTimeFormat($dateTime, $format)
{
    $dateTime = str_replace(' ', '', $dateTime);

    $dateTime = trim($dateTime);

    if (empty($dateTime)) {
        return null;
    }
    $dateObj = DateTime::createFromFormat($format, $dateTime);
    
    if ($dateObj === false) {
        return null; // Ungültiges Format
    }
    
    return $dateObj; // DateTime-Objekt zurückgeben, nicht String!
}
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
