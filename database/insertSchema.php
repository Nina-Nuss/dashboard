<?php

include("connection.php");

$file = file_get_contents('php://input');

// Abrufen der JSON-Daten aus der Anfrage
$data = json_decode($file, true);

echo json_encode($data);

// Überprüfen, ob die Daten korrekt abgerufen wurden
if (is_array($data)) {
    $imagePath = $data["imagePath"];
    $selectedTime = $data["selectedTime"];
    $aktiv = $data["aktiv"];
    $startTime = $data["startTime"];
    $endTime = $data["endTime"];
    $startDate = $data["startDateTime"];
    $endDate = $data["endDateTime"];
    $timeAktiv = $data["timeAktiv"];
    $dateAktiv = $data["dateAktiv"];
    $titel = $data["titel"];
    $beschreibung = $data["beschreibung"];
    // SQL-Abfrage mit Prepared Statement
    $sql = "INSERT INTO schemas (imagePath, selectedTime, isAktiv, startTime, endTime, startDateTime, endDateTime, timeAktiv, dateAktiv, titel, beschreibung) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $params = array( $imagePath, $selectedTime, $aktiv, $startTime, $endTime, $startDate, $endDate, $timeAktiv, $dateAktiv, $titel, $beschreibung);
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