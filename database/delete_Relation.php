<?php

include("connection.php");

// Abrufen der JSON-Daten aus der Anfrage
$input = json_decode(file_get_contents('php://input'), true);

$umgebungsID = $input['umgebungsID'] ?? '';
$cardObjektID = $input['cardObjektID'] ?? '';


// Überprüfen, ob die Daten korrekt abgerufen wurden
if (isset($umgebungsID) && isset($cardObjektID)) {
    // SQL-Abfrage mit Prepared Statement
    $sql = "DELETE FROM infotherminal_schema WHERE fk_infotherminal_id = ? AND fk_schema_id = ?";
    $params = array($umgebungsID, $cardObjektID);
    $stmt = sqlsrv_prepare($conn, $sql, $params);

    if ($stmt) {
        // Statement ausführen
        if (sqlsrv_execute($stmt)) {
            echo "Datensatz erfolgreich gelöscht";
        } else {
            echo "Fehler beim Löschen: ";
            print_r(sqlsrv_errors());
        }
        // Statement schließen
        sqlsrv_free_stmt($stmt);
    } else {
        echo "Fehler bei der Vorbereitung: ";
        print_r(sqlsrv_errors());
    }
} else {
    echo "Fehlende ID";
}

sqlsrv_close($conn);
?>