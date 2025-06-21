<?php

require("../cardObjNew/database/selectCardObj.php");
//                 imagePath: item[1],

// Pfad zum gewünschten Ordner
$ordner = "../cardObjNew/uploads";


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
}


echo json_encode($array);

?>
