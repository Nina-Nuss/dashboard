<?php
$serverName = "Ninchen\SQLEXPRESS"; // Servername oder IP-Adresse des SQL Servers
$connectionOptions = array(
    "Database" => "clickTestDB", // Name der Datenbank
    "Uid" => "sa", // Benutzername
    "PWD" => "123456789", // Kennwort
    "CharacterSet" => "UTF-8"
);

// Verbindung herstellen
global $conn;
$conn = sqlsrv_connect($serverName, $connectionOptions);


if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
} else {
    // echo "Verbindung erfolgreich hergestellt.";
}