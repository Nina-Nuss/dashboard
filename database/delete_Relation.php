<?php
// filepath: c:\Infotherminal\database\delete_Relation.php

include("connection.php");

// Abrufen der JSON-Daten aus der Anfrage
$input = json_decode(file_get_contents('php://input'), true);

$umgebungsID = $input['umgebungsID'] ?? '';
$cardObjektID = $input['cardObjektID'] ?? '';

// Überprüfen, ob die Daten korrekt abgerufen wurden
if ($umgebungsID !== '' && $cardObjektID !== '') {
    // SQL-Abfrage mit Prepared Statement
    $sql = "DELETE FROM infotherminal_schema WHERE fk_infotherminal_id = ? AND fk_schema_id = ?";
    // Parameter-Reihenfolge korrigiert: cardObjektID zuerst, dann umgebungsID
    $params = array($umgebungsID, $cardObjektID);
    $stmt = sqlsrv_prepare($conn, $sql, $params);

    if ($stmt) {
        // Statement ausführen
        if (sqlsrv_execute($stmt)) {
            echo json_encode(['success' => true, 'message' => 'Datensatz erfolgreich gelöscht']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Fehler beim Löschen']);
        }
        // Statement schließen
        sqlsrv_free_stmt($stmt);
    } else {
        echo json_encode(['success' => false, 'error' => 'Fehler bei der Vorbereitung']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Fehlende IDs']);
}

sqlsrv_close($conn);
?>