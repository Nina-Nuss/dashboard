<?php
include("connection.php");

// Daten aus der Anfrage abrufen
$titel = $_POST["titel"];
$isTimeSet = $_POST["isTimeSet"];
$imagePath = $_POST["imagePath"];
$imageSet = $_POST["imageSet"];
$startDateTime = $_POST["startDateTime"];
$endDateTime = $_POST["endDateTime"];
$aktiv = $_POST["aktiv"];
$id = $_POST["id"];

// SQL-Abfrage mit Prepared Statement
$sql = "UPDATE card_objekte SET titel = ?, isTimeSet = ?, imagePath = ?, imageSet = ?, startDateTime = ?, endDateTime = ?, aktiv = ? WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // Parameter binden
    mysqli_stmt_bind_param($stmt, "sssssssi", $titel, $isTimeSet, $imagePath, $imageSet, $startDateTime, $endDateTime, $aktiv, $id);
    
    // Statement ausführen
    if (mysqli_stmt_execute($stmt)) {
        echo "Datensatz erfolgreich aktualisiert";
    } else {
        echo "Fehler beim Aktualisieren: " . mysqli_stmt_error($stmt);
    }
    
    // Statement schließen
    mysqli_stmt_close($stmt);
} else {
    echo "Fehler bei der Vorbereitung: " . mysqli_error($conn);
}

mysqli_close($conn);
?>