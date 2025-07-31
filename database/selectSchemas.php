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

if (!function_exists('fileExist')) {
    function fileExist($imagePath)
    {
        $uploadFolder = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
        if (empty($imagePath) || $imagePath === 'null') {
            return false;
        }
        $fullPath = $uploadFolder . basename($imagePath);
        return file_exists($fullPath);
    }
}

function deleteFileFromPath($imagePath)
{
    $uploadFolder = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
    if (empty($imagePath) || $imagePath === 'null') {
        return false;
    }
    $fullPath = $uploadFolder . basename($imagePath);
    if (file_exists($fullPath)) {
        unlink($fullPath);
        return true;
    }
    return false;
}


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
    } else {
        // $deleteRelationsSql = "DELETE FROM infotherminal_schema WHERE fk_schema_id = ?";
        // $relParams = array($row['id']);
        // $relStmt = sqlsrv_prepare($conn, $deleteRelationsSql, $relParams);

        // if ($relStmt) {
        //     sqlsrv_execute($relStmt);
        //     sqlsrv_free_stmt($relStmt);
        // }
        // $deleteSql = "DELETE FROM schemas WHERE id = ?";
        // $params = array($row['id']);
        // $deleteStmt = sqlsrv_prepare($conn, $deleteSql, $params);

        // if ($deleteStmt) {
        //     if (sqlsrv_execute($deleteStmt)) {
        //         // echo "Datensatz mit ID " . $row['id'] . " gelöscht (Bild nicht gefunden)<br>";
        //     } else {
        //         echo "Fehler beim Löschen von ID " . $row['id'] . ": ";
        //         print_r(sqlsrv_errors());
        //     }
        //     sqlsrv_free_stmt($deleteStmt);
        // }
    }
}

$uploadFolder = scandir($_SERVER['DOCUMENT_ROOT'] . '/uploads/');
foreach ($uploadFolder as $file) {
    if (!in_array($file, ['.', '..']) && !in_array($file, array_column($schemaList1, 1))) {
        $filePath = $_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $file;
        if (file_exists($filePath)) {
            unlink($filePath);
            // echo "Datei gelöscht: " . $file . "<br>";
        } else {
            // echo "Datei nicht gefunden: " . $file . "<br>";
        }
    }
}


sqlsrv_free_stmt($result);

// JSON-Ausgabe
$schemaList = json_encode($schemaList1);


echo $schemaList;

sqlsrv_close($conn);
