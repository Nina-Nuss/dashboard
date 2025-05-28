<?php
include("connection.php");

$file = file_get_contents('php://input');
$data = json_decode($file, true);

if (
    isset($data['ip']) &&
    isset($data['titel']) &&
    isset($data['von']) &&
    isset($data['bis']) &&
    isset($data['beschreibung'])
) {
    $ip = $data['ip'];
    $titel = $data['titel'];
    $von = $data['von'];
    $bis = $data['bis'];
    $beschreibung = $data['beschreibung'];

    // SQL-Abfrage mit Prepared Statement für MSSQL
    $sql = "INSERT INTO daten (ip, titel, von, bis, beschreibung) VALUES (?, ?, ?, ?, ?)";
    $params = array($ip, $titel, $von, $bis, $beschreibung);
    $stmt = sqlsrv_prepare($conn, $sql, $params);

    if ($stmt) {
        if (sqlsrv_execute($stmt)) {
            echo "Datensatz erfolgreich eingefügt";
        } else {
            echo "Fehler beim Einfügen: ";
            print_r(sqlsrv_errors());
        }
        sqlsrv_free_stmt($stmt);
    } else {
        echo "Fehler bei der Vorbereitung: ";
        print_r(sqlsrv_errors());
    }
} else {
    echo "Fehlende Daten";
}

sqlsrv_close($conn);
?>