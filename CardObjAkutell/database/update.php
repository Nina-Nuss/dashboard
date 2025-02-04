<?php
include("connection.php");

// Daten aus der Anfrage abrufen
$ip = $_POST["ip"];
$titel = $_POST["titel"];
$isTimeSet = $_POST["isTimeSet"];
$imagePath = $_POST["imagePath"];
$imageSet = $_POST["imageSet"];
$startDateTime = $_POST["startDateTime"];
$endDateTime = $_POST["endDateTime"];
$aktiv = $_POST["aktiv"];

// SQL-Abfrage mit Prepared Statement
$sql = "UPDATE infoterminal SET isTimeSet = ?, imagePath = ?, imageSet = ?, startDateTime = ?, endDateTime = ?, aktiv = ? WHERE ip = ? AND titel = ?";
$stmt = mysqli_prepare($conn, $sql);


"?ip=" + cardObj.ipAdresse +
"&titel=" + cardObj.zugeordnet +
"&isTimeSet=" + cardObj.isTimeSet +
"&imagePath=" + cardObj.imagePath +
"&imageSet=" + cardObj.imageSet +
"&startDateTime=" + cardObj.startDateTime +
"&endDateTime=" + cardObj.endDateTime +
"&aktiv=" + cardObj.aktiv;

if ($stmt) {
    // Parameter binden
    mysqli_stmt_bind_param($stmt, "ssssssss", $isTimeSet, $imagePath, $imageSet, $startDateTime, $endDateTime, $aktiv, $ip, $titel);
    
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