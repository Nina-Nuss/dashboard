<?php

// include("../cardObjNew/database/selectCardObj.php");
//                 imagePath: item[1],

use Dom\Document;

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

$timeFormat = 'H:i';
$dateFormat = 'Y-m-d H:i';

$now = new DateTime('now', new DateTimeZone('Europe/Berlin'));

$nowTime = $now->format('H:i');
$nowDateTime = $now->format('Y-m-d H:i');

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

$timeIsBetween = false;
$dateIsBetween = false;



foreach ($images as $image) {
    // echo "<br>" . "gesuchtes Bild: " . $image . "<br>";
    foreach ($schemaList as $schema) {
        if ($schema[1] == $image && $schema[3] == true) {
            foreach ($relationList as $relation) {
                if ($relation[1] == $id && $relation[2] == $schema[0]) {
                    // ✅ Variablen pro Schema initialisieren
                    $timeIsActive = filter_var($schema[8], FILTER_VALIDATE_BOOLEAN);
                    $dateIsActive = filter_var($schema[9], FILTER_VALIDATE_BOOLEAN);

                    $timeIsValid = false;
                    $dateIsValid = false;

                    if ($dateIsActive) {
                        // Wenn Zeit auch aktiv ist, müssen beide stimmen
                        if ($timeIsActive) {
                            $timeIsValid = checkTime($schema[4], $schema[5], $timeFormat, $nowTime);
                            $dateIsValid = checkTime($schema[6], $schema[7], $dateFormat, $nowDateTime);
                            if ($timeIsValid && $dateIsValid) {
                                array_push($imagesContainer, $schema);
                            }
                        } else {
                            // Nur Datum zählt
                            $dateIsValid = checkTime($schema[6], $schema[7], $dateFormat, $nowDateTime);
                            if ($dateIsValid) {
                                array_push($imagesContainer, $schema);
                            }
                        }
                    } else {
                        // Wenn Datum nicht aktiv, prüfe nur Zeit
                        if ($timeIsActive) {
                            $timeIsValid = checkTime($schema[4], $schema[5], $timeFormat, $nowTime);
                            if ($timeIsValid) {
                                array_push($imagesContainer, $schema);
                            }
                        } else {
                            // Weder Zeit noch Datum aktiv: immer anzeigen
                            array_push($imagesContainer, $schema);
                        }
                    }
                }
            }
        }
    }
};


function checkTime($start, $end, $format, $time)
{
    // echo "  → Prüfe: '$start' bis '$end' (Format: $format), Jetzt: '$time'<br>";
    // Prüfe auf leere, NULL oder 'NULL' Werte
    $startTrim = trim($start);
    $endTrim = trim($end);
    if (empty($startTrim) || empty($endTrim) || $startTrim === 'NULL' || $endTrim === 'NULL' || $startTrim === null || $endTrim === null) {
        // echo "  → Leere/NULL Start/End-Werte gefunden → INVALID<br>";
        return false;
    }
    $result = checkDateTime($startTrim, $endTrim, $format, $time);
    // echo "  → Ergebnis: " . ($result ? 'VALID' : 'INVALID') . "<br>";
    return $result;
}

$imageList = json_encode($imagesContainer);

echo $imageList;

function checkDateTime($start, $end, $format, $now)
{
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
    $dateTime = trim($dateTime);
    if (empty($dateTime) || $dateTime === 'NULL' || $dateTime === null || $dateTime === 'null') {
        return null;
    }
    // Für Zeit-Format: Leerzeichen entfernen ist ok
    if ($format === 'H:i:s' || $format === 'H:i') {
        $dateTime = str_replace(' ', '', $dateTime);
    }
    // Unterstütze auch das ISO-Format mit T
    if ($format === 'Y-m-d H:i' && strpos($dateTime, 'T') !== false) {
        $format = 'Y-m-d\TH:i';
    }
    $dateObj = DateTime::createFromFormat($format, $dateTime);
    if ($dateObj === false) {
        return null;
    }
    return $dateObj;
}
function getAllImages()
{
    $ordner =  $_SERVER["DOCUMENT_ROOT"] . "/uploads";
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
