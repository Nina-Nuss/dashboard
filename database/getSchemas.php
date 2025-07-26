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
$dateFormat = 'Y-m-d';

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
                    // Konvertiere stdClass zu DateTime
                    if (isset($schema[4]) && isset($schema[5])) {
                        $trueTime = checkDateTime($schema[4], $schema[5], $timeFormat, $nowTime);
                    }
                    if(isset($schema[6]) && isset($schema[7])) {
                        $trueDate = checkDateTime($schema[6], $schema[7], $dateFormat, $nowDateTime);
                    }
                    if($trueDate === true && $trueTime === true) {
                        array_push($imagesContainer, $schema);
                    } else {
                       continue; // Wenn die Zeit oder das Datum nicht im Bereich ist, überspringe das Schema
                    }
                    array_push($imagesContainer, $schema);
                }
            }
        }
    }
};

$imageList = json_encode($imagesContainer);

echo $imageList;

function checkDateTime($start, $end, $format, $now)
{
    $startTime = $start;
    $endTime = $end;
    $startTime = createDateTimeFormat($startTime, $format);
    $endTime = createDateTimeFormat($endTime, $format);
    if ($startTime !== null && $endTime !== null) {
        if ($now >= $startTime && $now <= $endTime) {
            return true;
        } else {
  
            return false;
        }
    } else {
        return false;
    }
}

function createDateTimeFormat($dateTime, $format)
{
    $dateTime = str_replace(' ', '', $dateTime);

    trim($dateTime);

    $dateTime = DateTime::createFromFormat($format, $dateTime);

    if (!$dateTime) {
        return null; // Ungültiges Datumsformat
    }
    $dateTime = $dateTime->format($format);
    if ($dateTime !== false) {
        return $dateTime;
    } else {
        return null;
    }
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
