<?php
include("connection.php");

if (!isset($_GET['idDelete'])) {
    echo 'Fehler: Keine Daten empfangen';
    return;
} else {
    echo "Daten empfangen: " . $_GET['idDelete'];
}

$sql = "SELECT * FROM infotherminals";

$sqlDeleteCardObjs = "DELETE FROM infotherminal_schema WHERE fk_infotherminal_id = ?";
$paramsCardObjs = array($_GET['idDelete']);
$stmtCardObjs = sqlsrv_query($conn, $sqlDeleteCardObjs, $paramsCardObjs);

if ($stmtCardObjs) {
    $cardObjsDeleted = sqlsrv_rows_affected($stmtCardObjs);
    echo "beziehungen gelöscht: " . $cardObjsDeleted . "<br>";
    sqlsrv_free_stmt($stmtCardObjs);
} else {
    echo "Fehler beim Löschen der beziehung-Datensätze: " . print_r(sqlsrv_errors(), true) . "<br>";
}

// Dann das Infotherminal selbst löschen
$sql = "DELETE FROM infotherminals WHERE id = ?";

$params = array($_GET['idDelete']);
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt) {
    $rowsAffected = sqlsrv_rows_affected($stmt);
    // Statement ausführen
    if ($rowsAffected > 0) {
        echo "Datensatz erfolgreich gelöscht";
    } else {
        echo "Fehler beim Löschen: Kein Datensatz gefunden";
    }

    // Statement schließen
    sqlsrv_free_stmt($stmt);
} else {
    echo "Fehler bei der Vorbereitung: " . print_r(sqlsrv_errors(), true);
}
