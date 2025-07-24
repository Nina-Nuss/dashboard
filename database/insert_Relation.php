<?php
// filepath: c:\Infotherminal\database\insert_Relation.php

include("connection.php");

$input = json_decode(file_get_contents('php://input'), true);

$umgebungsID = $input['umgebungsID'] ?? '';
$cardObjektID = $input['cardObjektID'] ?? '';

// Überprüfen, ob beide Werte vorhanden sind
if ($umgebungsID !== '' && $cardObjektID !== '') {
    $sql = "INSERT INTO infotherminal_schema (fk_infotherminal_id, fk_schema_id) VALUES (?, ?)";
    // Parameter-Reihenfolge korrigiert: cardObjektID zuerst, dann umgebungsID
    $params = array($umgebungsID, $cardObjektID);
    $stmt = sqlsrv_prepare($conn, $sql, $params);

    if ($stmt) {
        // Statement ausführen
        if (sqlsrv_execute($stmt)) {
            echo json_encode(['success' => true, 'message' => 'Beziehung erfolgreich eingefügt']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Fehler beim Einfügen']);
        }
        // Statement schließen
        sqlsrv_free_stmt($stmt);
    } else {
        echo json_encode(['success' => false, 'error' => 'Fehler bei der Vorbereitung']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'umgebungsID oder cardObjektID nicht gesetzt']);
}

sqlsrv_close($conn);
?>