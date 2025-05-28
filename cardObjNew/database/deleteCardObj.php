<?php

include("connection.php");

// Abrufen der JSON-Daten aus der Anfrage
$data = json_decode(file_get_contents('php://input'), true);

// Überprüfen, ob die Daten korrekt abgerufen wurden
if (isset($data['id'])) {
    $id = $data['id'];

    // SQL-Abfrage mit Prepared Statement
    $sql = "DELETE FROM card_objekte WHERE id = ?";
    $params = array($id);
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