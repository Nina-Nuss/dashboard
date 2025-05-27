<?php

include("connection.php");

$sql = "SELECT * FROM card_objekte";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Abfragefehler: " . mysqli_error($conn));
}

// Pfad zu den Bildern
$path = "../uploads";
$absolutePath = realpath($path);



if (!$absolutePath || !is_dir($absolutePath)) {
    die("Der Ordner 'uploads' existiert nicht.");
}

// Dateien im Ordner auslesen
// $dateien = array_diff(scandir($absolutePath), ['.', '..']); // Entfernt '.' und '..'


// Tabelle für die Ergebnisse
$unsereTabelle = [];

while ($row = mysqli_fetch_assoc($result)) {
    if (isset($row['id']) && $row['id'] !== null) {
        // Überprüfen, ob die Datei existiert       
        // if($row["imagePath"]){
        //     $cleanedImagePath = preg_replace('/[^a-zA-Z0-9\/._-]/', '', $row["imagePath"]); // Entfernt unnötige Zeichen
        //     echo $cleanedImagePath . "<br>";
        // }
        
        // Daten in das Array einfügen
        array_push($unsereTabelle, array(
            $row["id"],
            $row["titel"],
            $row["imagePath"], // Pfad setzen oder null
            $row["selectedTime"],
            (bool)$row["isTimeSet"], // Cast zu Boolean
            (bool)$row["imageSet"],  // Cast zu Boolean
            (bool)$row["aktiv"],   
            $row["startDateTime"],
            $row["endDateTime"],
        ));
    }
}

mysqli_free_result($result);

// JSON-Ausgabe
$jsonList = json_encode($unsereTabelle);
echo $jsonList;

?>