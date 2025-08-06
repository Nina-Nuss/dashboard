<?php
include("checkJson.php");
include("connection.php");


$ip = $_SESSION['ip'] ?? '';
$name = $_SESSION['name'] ?? '';


// ...weiter wie gehabt...
// IP und Name aus POST-Daten abrufen

echo  $_SESSION['infoterminalListLength'];
echo "<br>";

echo  $_SESSION['defaultMaxCountForInfoTerminals'];
echo "<br>";
echo  $_SESSION['infoterminalListLength'] < $_SESSION['defaultMaxCountForInfoTerminals'];


// Überprüfen, ob beide Werte vorhanden sind
if ($ip !== '' && $name !== '' &&  $_SESSION['infoterminalListLength'] < $_SESSION['defaultMaxCountForInfoTerminals']) {
    // SQL-Abfrage mit Prepared Statement
    $sql = "INSERT INTO infotherminals (titel, ipAdresse) VALUES (?, ?)";
    $params = array($name, $ip);
    $stmt = sqlsrv_prepare($conn, $sql, $params);

    if ($stmt) {
        // Statement ausführen
        if (sqlsrv_execute($stmt)) {
            echo "Datensatz erfolgreich eingefügt";
            $ip = "";
            $name = "";
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
    echo "Fehler: IP oder Name nicht gesetzt, oder maximale Anzahl an Infoterminals erreicht.";
}

sqlsrv_close($conn);
?>