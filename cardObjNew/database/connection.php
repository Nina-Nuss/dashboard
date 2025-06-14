<?php

// MSSQL Verbindungsparameter
$serverName = "FIS-BW-03\\SQLEXPRESS"; 



$connectionOptions = array(
    "Database" => "infotherminal",      // Hier den Datenbanknamen eintragen!
    "CharacterSet" => "UTF-8",
    "TrustServerCertificate" => true,  // Entspricht "Serverzertifikat vertrauen"
    "Encrypt" => true                  // Entspricht "Verschlüsselung: Obligatorisch"
    // KEIN "Authentication" hier!
);

// Verbindung herstellen
global $conn;
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Verbindung überprüfen
if (!$conn) {
    die("Verbindung fehlgeschlagen: " . print_r(sqlsrv_errors(), true));
}else{
    // echo "Verbindung erfolgreich hergestellt.";
}
?>