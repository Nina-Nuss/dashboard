<?php
include("connection.php");

// JSON-Daten aus der Anfrage abrufen
$data = json_decode(file_get_contents('php://input'), true);

echo "Received data: " . json_encode($data);

// Daten aus der Anfrage abrufen
$titel = $data["titel"];
$imagePath = $data["imagePath"];
$selectedTime = $data["selectedTime"];
$isTimeSet = $data["isTimeSet"];
$imageSet = $data["imageSet"];
$aktiv = $data["aktiv"];
$startDateTime = $data["startDateTime"];
$endDateTime = $data["endDateTime"];
$id = $data["id"]; // ID muss ebenfalls aus der Anfrage abgerufen werden

// SQL-Abfrage mit Prepared Statement
$sql = "UPDATE card_objekte 
        SET titel = ?, imagePath = ?, selectedTime = ?, isTimeSet = ?, imageSet = ?, aktiv = ?, startDateTime = ?, endDateTime = ? 
        WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // Parameter binden (Reihenfolge muss mit der SQL-Abfrage übereinstimmen)
    mysqli_stmt_bind_param($stmt, "ssssssssi", $titel, $imagePath, $selectedTime, $isTimeSet, $imageSet, $aktiv, $startDateTime, $endDateTime, $id);

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

// Verbindung schließen
mysqli_close($conn);
?>