<?php

include("connection.php");

// JSON-Daten aus der Anfrage abrufen
$data = json_decode(file_get_contents('php://input'), true);

echo "Received data: " . json_encode($data);

// Daten aus der Anfrage abrufen
$titel = $data["titel"];
$imagePath = $data["imagePath"];
$selectedTime = $data["selectedTime"];
$imageSet = $data["imageSet"];
$aktiv = $data["aktiv"];
$startDateTime = $data["startDateTime"];
$endDateTime = $data["endDateTime"];
$id = $data["id"]; // ID muss ebenfalls aus der Anfrage abgerufen werden

// SQL-Abfrage mit Prepared Statement für MSSQL
$sql = "UPDATE card_objekte 
        SET titel = ?, imagePath = ?, selectedTime = ?, imageSet = ?, aktiv = ?, startDateTime = ?, endDateTime = ? 
        WHERE id = ?";
$params = array($titel, $imagePath, $selectedTime, $imageSet, $aktiv, $startDateTime, $endDateTime, $id);
$stmt = sqlsrv_prepare($conn, $sql, $params);

if ($stmt) {
    // Statement ausführen
    if (sqlsrv_execute($stmt)) {
        echo "Datensatz erfolgreich aktualisiert";
    } else {
        echo "Fehler beim Aktualisieren: ";
        print_r(sqlsrv_errors());
    }
    sqlsrv_free_stmt($stmt);
} else {
    echo "Fehler bei der Vorbereitung: ";
    print_r(sqlsrv_errors());
}

// Verbindung schließen
sqlsrv_close($conn);
?>