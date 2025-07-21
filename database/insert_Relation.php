<?php
// filepath: c:\Infotherminal\database\insertRelation.php

include("connection.php");

$input = json_decode(file_get_contents('php://input'), true);

$umgebungsID = $input['umgebungsID'] ?? '';
$cardObjektID = $input['cardObjektID'] ?? '';

// Überprüfen, ob beide Werte vorhanden sind
if ($umgebungsID !== '' && $cardObjektID !== '') {
    $sql = "INSERT INTO infotherminal_schema (fk_infotherminal_id, fk_schema_id) VALUES (?, ?)";
    $params = array($umgebungsID, $cardObjektID);
    $stmt = sqlsrv_prepare($conn, $sql, $params);

    if ($stmt) {
        // Statement ausführen
        if (sqlsrv_execute($stmt)) {
            echo "Beziehung erfolgreich eingefügt";
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
    echo "Fehler: umgebungsID oder cardObjektID nicht gesetzt";
}

sqlsrv_close($conn);
?>