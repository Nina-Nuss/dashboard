<?php

// MySQL Verbindungsparameter
$servername = "127.0.0.1";  // oder IP-Adresse
$username = "root";           // MySQL Benutzername
$password = "123456789";   // MySQL Passwort
$database = "infoterminal"; // Datenbankname

// Verbindung herstellen
global $conn;
$conn = mysqli_connect($servername, $username, $password, $database);

// Zeichensatz auf UTF-8 setzen
mysqli_set_charset($conn, "utf8");

// Verbindung überprüfen
if (!$conn) {
    die("Verbindung fehlgeschlagen: " . mysqli_connect_error());
} else {
    //echo "Verbindung erfolgreich hergestellt.";
}
?>