<?php

include("connection.php");

$file = file_get_contents('php://input');

// Abrufen der JSON-Daten aus der Anfrage
$data = json_decode($file, true);

echo json_encode($data);

// Überprüfen, ob die Daten korrekt abgerufen wurden
if (is_array($data)) {
    $titel = $data["titel"];
    $imagePath = $data["imagePath"];
    $selectedTime = $data["selectedTime"];
    $imageSet = $data["imageSet"];
    $curSelect = $data["curSelect"];
    $startDateTime = $data["startDateTime"];
    $endDateTime = $data["endDateTime"];
    $aktiv = $data["aktiv"];

    // SQL-Abfrage mit Prepared Statement
    $sql = "INSERT INTO schemas (imagePath, selectedTime, isAktiv, curSelect, startDateTime, endDateTime) VALUES (?, ?, ?, ?, ?, ?)";
    $params = array($titel, $imagePath, $selectedTime, $imageSet, $aktiv, $startDateTime, $endDateTime);
    $stmt = sqlsrv_prepare($conn, $sql, $params);

    if ($stmt) {
        // Statement ausführen
        if (sqlsrv_execute($stmt)) {
            echo "Datensatz erfolgreich eingefügt";
        } else {
            echo "Fehler beim Einfügen: ";
            print_r(sqlsrv_errors());
        }
        // Statement schließen
        sqlsrv_free_stmt($stmt);
    } else {
        echo "Fehler bei der Vorbereitung: ";
        print_r(sqlsrv_errors());
    }
} else {
    echo "Fehler beim Abrufen der Daten";
}

sqlsrv_close($conn);