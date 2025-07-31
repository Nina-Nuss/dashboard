<?php

include("selectSchemas.php");

$ordnerPfad = '../uploads/';


// Verzeichnisinhalt auslesen
$alleDateien = scandir($ordnerPfad);


// "." und ".." entfernen
$alleDateien = array_diff($alleDateien, ['.', '..']);

// Überprüfung: Welche Dateien im Ordner sind NICHT in der Liste?
foreach ($alleDateien as $datei) {
    if (!in_array($datei, $schemaList1)) {
         unlink($ordnerPfad . $datei);
    } else {
        echo "Datei OK: $datei<br>";
    }
}
?>




?>