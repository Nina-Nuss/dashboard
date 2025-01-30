<?php
include("connection.php");

$ip = $_GET["ip"];
$titel = $_GET["titel"];
$von = $_GET["von"];
$bis = $_GET["bis"];
$beschreibung = $_GET["beschreibung"];
$isTimeSet = $_GET["isTimeSet"];
$imagePath = $_GET["imagePath"];
$imageSet = $_GET["imageSet"];
$startDateTime = $_GET["startDateTime"];
$endDateTime = $_GET["endDateTime"];
$aktiv = $_GET["aktiv"];

// SQL-Abfrage mit Prepared Statement
$sql = "INSERT INTO daten (ip, titel, von, bis, beschreibung, isTimeSet, imagePath, imageSet, startDateTime, endDateTime, aktiv) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // Parameter binden
    mysqli_stmt_bind_param($stmt, "sssssssssss", $ip, $titel, $von, $bis, $beschreibung, $isTimeSet, $imagePath, $imageSet, $startDateTime, $endDateTime, $aktiv);
    
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