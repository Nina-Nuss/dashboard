<?php



$serverName = "FIS-BW-03\SQLEXPRESS"; // Servername oder IP-Adresse des SQL Servers
$connectionOptions = array(
    "Database" => "master", // Name der Datenbank
    "CharacterSet" => "UTF-8" // Zeichensatz
);

// Verbindung herstellen
global $conn;
$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
} else {
    // echo "Verbindung erfolgreich hergestellt.";
}
