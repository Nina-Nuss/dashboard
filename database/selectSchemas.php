<?php

include("connection.php");



$sql = "SELECT * FROM schemas";
$result = sqlsrv_query($conn, $sql);

if ($result === false) {
    die("Abfragefehler: " . print_r(sqlsrv_errors(), true));
}

// Pfad zu den Bildern
$path = "/uploads";
$absolutePath = realpath($path);

if (!$absolutePath || !is_dir($absolutePath)) {
    echo "Der Ordner 'uploads' existiert nicht.";
}

// Tabelle für die Ergebnisse
$schemaList1 = [];

if (!function_exists('fileExist')) {
    function fileExist($imagePath) {
        $uploadFolder = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
        if (empty($imagePath) || $imagePath === 'null') {
            return false;
        }
        $fullPath = $uploadFolder . basename($imagePath);
        return file_exists($fullPath);
    }
}


while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    if (isset($row['id']) && $row['id'] !== null && fileExist($row['imagePath'])) {
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
    }else{
        $deleteSql = "DELETE FROM schemas WHERE id = ?";
        $params = array($row['id']);
        $deleteStmt = sqlsrv_prepare($conn, $deleteSql, $params);
        
        if ($deleteStmt) {
            if (sqlsrv_execute($deleteStmt)) {
                // echo "Datensatz mit ID " . $row['id'] . " gelöscht (Bild nicht gefunden)<br>";
            } else {
                echo "Fehler beim Löschen von ID " . $row['id'] . ": ";
                print_r(sqlsrv_errors());
            }
            sqlsrv_free_stmt($deleteStmt);
        }
        
    }
}





sqlsrv_free_stmt($result);

// JSON-Ausgabe
$schemaList = json_encode($schemaList1);


echo $schemaList;

sqlsrv_close($conn);
