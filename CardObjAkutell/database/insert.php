<?php
include("connection.php");

// Daten aus der Anfrage abrufen
$titel = $_POST["titel"];
$imagePath = $_POST["imagePath"];
$isTimeSet = $_POST["isTimeSet"];
$selectedTime = $_POST["selectedTime"];
$imageSet = $_POST["imageSet"];
$startDateTime = $_POST["startDateTime"];
$endDateTime = $_POST["endDateTime"];
$aktiv = $_POST["aktiv"];

// SQL-Abfrage mit Prepared Statement
$sql = "INSERT INTO card_objekte (titel, imagePath, selectedTime, isTimeSet, imageSet, aktiv, startDateTime, endDateTime) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // Parameter binden
    mysqli_stmt_bind_param($stmt, "ssssssss", $titel, $imagePath, $selectedTime, $isTimeSet, $imageSet, $aktiv, $startDateTime, $endDateTime);
    
    // Statement ausführen
    if (mysqli_stmt_execute($stmt)) {
        echo "Datensatz erfolgreich eingefügt";
    } else {
        echo "Fehler beim Einfügen: " . mysqli_stmt_error($stmt);
    }
    // Statement schließen
    mysqli_stmt_close($stmt);
} else {
    echo "Fehler bei der Vorbereitung: " . mysqli_error($conn);
}

mysqli_close($conn);
?>