<?php
include("connectionA.php");
include("console.php");

if (!isset($_GET['idDelete'])) {
     echo 'Fehler: Keine Daten empfangen';
     return;
}else{
     echo "daten empfangen" . $_GET['idDelete'] ;
}
// SQL-Abfrage (INSERT) ausführen
$sql = "DELETE FROM daten WHERE id = (?)";
$params = array($_GET['idDelete']);

$result = sqlsrv_query($conn,$sql,$params);

if($result === false) {
     die( print_r( sqlsrv_errors(), true));
}