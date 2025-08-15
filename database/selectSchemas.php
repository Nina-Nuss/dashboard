<?php

include("connection.php");


$sql = "SELECT * FROM schemas";
$result = sqlsrv_query($conn, $sql);

if ($result === false) {
    die("Abfragefehler: " . print_r(sqlsrv_errors(), true));
}

// Pfad zu den Bildern
$path =  $_SERVER['DOCUMENT_ROOT'] . "/uploads";
$absolutePath = realpath($path);

if (!$absolutePath || !is_dir($absolutePath)) {
    echo "Der Ordner 'uploads' existiert nicht.";
}

// Tabelle für die Ergebnisse
$schemaList1 = [];



while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    if (isset($row['id']) && $row['id'] !== null) {
        array_push($schemaList1, array(
            $row["id"],
            $row["imagePath"],
            $row["selectedTime"],
            (bool)$row["isAktiv"],
            $row["startTime"],
            $row["endTime"],
            $row["startDateTime"],
            $row["endDateTime"],
            $row["timeAktiv"],
            $row["dateAktiv"],
            $row["titel"],
            $row["beschreibung"],
        ));
    }
    
    
}

// Upload-Ordner bereinigen (nur echte Dateien löschen)
// $uploadFolder = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
// if (is_dir($uploadFolder)) {
//     $files = scandir($uploadFolder);

//     foreach ($files as $file) {

//         if ($file === '.' || $file === '..' || is_dir($uploadFolder . $file)) {
//             continue;
//         }

//         $filePath = $uploadFolder . $file;
//         if (file_exists($filePath) && is_file($filePath)) {
//             if (unlink($filePath)) {
//                 echo "Datei gelöscht: " . $file . "<br>";
//             } else {
//                 echo "Fehler beim Löschen: " . $file . "<br>";
//             }
//         }
//     }
// } else {
//     echo "Upload-Ordner nicht gefunden.<br>";
// }

sqlsrv_free_stmt($result);

// JSON-Ausgabe
$schemaList = json_encode($schemaList1);


echo $schemaList;

sqlsrv_close($conn);
