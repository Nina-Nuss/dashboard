<?php
// filepath: c:\xampp\htdocs\Infotherminal\dashboard\database\delete_All_Relations_For_Schema.php

include("connection.php");

// Abrufen der JSON-Daten aus der Anfrage
$input = json_decode(file_get_contents('php://input'), true);

$cardObjektID = $input['cardObjektID'] ?? '';

// Überprüfen, ob die Daten korrekt abgerufen wurden
if ($cardObjektID !== '') {
    // SQL-Abfrage um ALLE Beziehungen für dieses Schema zu löschen
    $sql = "DELETE FROM infotherminal_schema WHERE fk_schema_id = ?";
    $params = array($cardObjektID);
    $stmt = sqlsrv_prepare($conn, $sql, $params);

    if ($stmt) {
        // Statement ausführen
        if (sqlsrv_execute($stmt)) {
            echo json_encode(['success' => true, 'message' => 'Alle Beziehungen für Schema erfolgreich gelöscht']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Fehler beim Löschen der Beziehungen', 'details' => sqlsrv_errors()]);
        }
        // Statement schließen
        sqlsrv_free_stmt($stmt);
    } else {
        echo json_encode(['success' => false, 'error' => 'Fehler bei der Vorbereitung', 'details' => sqlsrv_errors()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Fehlende Schema-ID']);
}

sqlsrv_close($conn);
?>
