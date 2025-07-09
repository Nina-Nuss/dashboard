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
        if ($schema[1] == $image && $schema[3] == true) {
            foreach ($relationList as $relation) {
                if ($relation[0] == $id && $relation[1] == $schema[0]) {
                    // Konvertiere stdClass zu DateTime
                    if (isset($schema[4]) && $schema[4] !== null && isset($schema[5]) && $schema[5] !== null) {
                        $startTime = createDateTimeObj($schema[4]);
                        $endTime = createDateTimeObj($schema[5]);
                        if ($startTime === false || $endTime === false) {
                            array_push($imagesContainer, $schema);
                            continue; // Springt zum nächsten Durchlauf der innersten Schleife
                        }
                        if (isNowBetween($startTime, $endTime)) {
                            array_push($imagesContainer, $schema);
                            continue;
                        } else {

                        }
                    } else {
                        array_push($imagesContainer, $schema);
                        continue;
                    }
                }
            }
        }
    }
};

$imageList = json_encode($imagesContainer);

echo $imageList;



function isNowBetween($startTime, $endTime)
{
    $timezone2 = new DateTimeZone('Europe/Berlin');
    $now = new DateTime('now', $timezone2);
    return $now >= $startTime && $now <= $endTime;
}

function createDateTimeObj($dateTimeSrt)
{
    $datetimeFormat = 'Y-m-d H:i:s';
    if ($dateTime = DateTime::createFromFormat($datetimeFormat, $dateTimeSrt)) {
        $timezone = new DateTimeZone('Europe/Berlin');
        $dateTime->setTimezone($timezone);
        // Datumsformat für die Eingabe

        if (
            !$dateTime || $dateTime->format($datetimeFormat) !== trim($dateTimeSrt)
        ) {
            return false; // Ungültiges Datumsformat
        }
        return $dateTime;
    }else{
        return false;
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
