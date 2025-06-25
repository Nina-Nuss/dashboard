<?php

// Beispiel-Daten, die von mysqli_fetch_assoc($result) zurückgegeben werden könnten
$row1 = array(
    "id" => 1,
    "titel" => "Objekt A",
    "imagePath" => "meow1.png",
    "selectedTime" => "2025-04-27 12:00:00",
    "isTimeSet" => 1, // 1 für true
    "imageSet" => 0,  // 0 für false
    "aktiv" => 1,     // 1 für aktiv
    "startDateTime" => "2025-04-27 08:00:00",
    "endDateTime" => "2025-04-27 18:00:00"
);

$row2 = array(
    "id" => 2,
    "titel" => "Objekt A",
    "imagePath" => "meow2.png",
    "selectedTime" => "2025-04-27 12:00:00",
    "isTimeSet" => 1, // 1 für true
    "imageSet" => 0,  // 0 für false
    "aktiv" => 1,     // 1 für aktiv
    "startDateTime" => "2025-04-27 08:00:00",
    "endDateTime" => "2025-04-27 18:00:00"
);

$liste = [$row1, $row2]; // Array mit den Beispiel-Daten

// Pfad zu den Bildern
$path = "../uploads";
$absolutePath = realpath($path);

echo $absolutePath ."";

if ($absolutePath && is_dir($absolutePath)) {
    echo "Der Ordner existiert: " . $absolutePath . "<br>";

    // Dateien und Ordner im Verzeichnis auslesen
    $dateien = array_diff(scandir($absolutePath), ['.', '..']); // Entfernt '.' und '..'

    echo $dateien;

    foreach ($liste as $row) {
        echo "ID: " . $row["id"] . "<br>";

        // Überprüfen, ob die Datei existiert
        if (in_array($row["imagePath"], $dateien)) {
            echo "Die Datei existiert: " . $row["imagePath"] . "<br>";
        } else {
            echo "Die Datei existiert nicht: " . $row["imagePath"] . "<br>";
        }
    }
} else {
    echo "Der Ordner existiert nicht.<br>";
}

?>
