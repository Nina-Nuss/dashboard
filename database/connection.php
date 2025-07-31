<?php


// $serverName = "10.1.6.3";  // IP-Adresse direkt

$serverName = "Nina\SQLEXPRESS";
// Alternativen:
// $serverName = "10.1.6.3,1433";        // IP mit Port (Standard: 1433)
// $serverName = "10.1.6.3\\SQLEXPRESS"; // IP mit Named Instance
// $serverName = "tcp:10.1.6.3,1433";    // Explizit TCP-Protokoll 

// ...existing code...
$connectionOptions = array(
    "Database" => "dbTerminal",      // Hier den Datenbanknamen eintragen!
    "CharacterSet" => "UTF-8",
    "TrustServerCertificate" => true,  // Entspricht "Serverzertifikat vertrauen"
    "Encrypt" => true,                 // Entspricht "Verschlüsselung: Obligatorisch"
    // "UID" => "sa",                     // SQL Server Authentication Benutzername
    // "PWD" => "A%00000p&",               // SQL Server Authentication Passwort

);
// ...existing code...

// Verbindung herstellen
global $conn;
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Verbindung überprüfen
if (!$conn) {
    die("Verbindung fehlgeschlagen: " . print_r(sqlsrv_errors(), true));
} else {
    // echo "Verbindung erfolgreich hergestellt.";
}
