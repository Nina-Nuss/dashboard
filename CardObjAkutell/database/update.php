<?php
include("connection.php");

// Daten aus der Anfrage abrufen


$titel = $_GET["titel"];
$isTimeSet = $_GET["isTimeSet"];
$imagePath = $_GET["imagePath"];
$imageSet = $_GET["imageSet"];
$startDateTime = $_GET["startDateTime"];
$endDateTime = $_GET["endDateTime"];
$aktiv = $_GET["aktiv"];
$id = $_GET["id"];


// SQL-Abfrage mit Prepared Statement
$sql = "UPDATE card_objekte 
        SET isTimeSet = ?, imagePath = ?, imageSet = ?, startDateTime = ?, endDateTime = ?, aktiv = ? 
        WHERE id = ? 
        AND titel = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ssssssss", $isTimeSet, $imagePath, $imageSet, $startDateTime, $endDateTime, $aktiv, $ip, $titel);
    if (mysqli_stmt_execute($stmt)) {
        echo "Datensatz erfolgreich aktualisiert";
    } else {
        echo "Fehler beim Aktualisieren: " . mysqli_stmt_error($stmt);
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Fehler bei der Vorbereitung: " . mysqli_error($conn);
}
mysqli_close($conn);


?>