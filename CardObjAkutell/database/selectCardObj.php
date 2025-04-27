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
$dateien = array_diff(scandir($absolutePath), ['.', '..']); // Entfernt '.' und '..'

// Tabelle für die Ergebnisse
$unsereTabelle = [];

while ($row = mysqli_fetch_assoc($result)) {
    if (isset($row['id']) && $row['id'] !== null) {
        // Überprüfen, ob die Datei existiert
        $fileExists = in_array($row["imagePath"], $dateien);

        // Daten in das Array einfügen
        array_push($unsereTabelle, array(
            "id" => $row["id"],
            "titel" => $row["titel"],
            "imagePath" => $fileExists ? $path . "/" . $row["imagePath"] : null, // Pfad setzen oder null
            "selectedTime" => $row["selectedTime"],
            "isTimeSet" => (bool)$row["isTimeSet"], // Cast zu Boolean
            "imageSet" => (bool)$row["imageSet"],  // Cast zu Boolean
            "aktiv" => (bool)$row["aktiv"],   
            "startDateTime" => $row["startDateTime"],
            "endDateTime" => $row["endDateTime"],
        ));
    }
}

mysqli_free_result($result);

// JSON-Ausgabe
$jsonList = json_encode($unsereTabelle);
echo $jsonList;

?>