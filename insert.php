<?php
include("connectionA.php");
include("select.php");


$ip = $_GET["ip"];
$titel = $_GET["titel"];
$von = $_GET["von"];
$bis = $_GET["bis"];
$beschreibung = $_GET["beschreibung"];




// SQL-Abfrage (INSERT) ausführen
$sql = "INSERT INTO daten (ip, titel, von, bis, beschreibung) VALUES (?, ?, ?, ?, ?)";

$params = array($ip, $titel, $von, $bis, $beschreibung);

$result = sqlsrv_query($conn,$sql,$params);

if( $result === false ) {
     die( print_r( sqlsrv_errors(), true));
}else{
     echo "Erfolgreich Ausgeführt";
};




