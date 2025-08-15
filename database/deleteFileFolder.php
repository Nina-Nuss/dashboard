<?php

include("connection.php");

$imageListPath = [];
$videoListPath = [];
$idList = [];
global $uploadFolder;
$uploadFolder = $_SERVER['DOCUMENT_ROOT'] . '/uploads/img/';
$uploadFolder2 = $_SERVER['DOCUMENT_ROOT'] . '/uploads/video/';

// SQL-Abfrage mit Prepared Statement - alle Schemas mit Bildpfaden abrufen
$sql = "SELECT id, imagePath FROM schemas WHERE imagePath IS NOT NULL";
$stmt = sqlsrv_prepare($conn, $sql);

if ($stmt) {
    if (sqlsrv_execute($stmt)) {
        $deletedCount = 0;

        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $id = $row['id'];
            $imagePath = $row['imagePath'];
            // Füge den Bildpfad und die ID zur Liste hinzu
            if (strpos($imagePath, 'img_') !== false) {
                $fullPath = $uploadFolder . $imagePath;
               array_push($imageListPath, $imagePath);
            } elseif (strpos($imagePath, 'video_') !== false) {
                $fullPath = $uploadFolder2 . $imagePath;
                array_push($videoListPath, $imagePath);
            }
            array_push($idList, $id);

            if (!file_exists($fullPath)) {
                // Datei existiert nicht → Beziehungen und Datensatz löschen

                // Beziehung löschen
                $deleteRelationsSql = "DELETE FROM infotherminal_schema WHERE fk_schema_id = ?";
                $relStmt = sqlsrv_prepare($conn, $deleteRelationsSql, array($id));

                if ($relStmt && sqlsrv_execute($relStmt)) {
                    sqlsrv_free_stmt($relStmt);
                } else {
                    // echo "Fehler beim Löschen der Beziehungen für ID $id: ";
                    // print_r(sqlsrv_errors());
                }

                // Datensatz löschen
                $deleteSql = "DELETE FROM schemas WHERE id = ?";
                $deleteStmt = sqlsrv_prepare($conn, $deleteSql, array($id));

                if ($deleteStmt && sqlsrv_execute($deleteStmt)) {
                    // echo "Datensatz ID $id gelöscht, weil Bilddatei nicht existierte: $imagePath<br>";
                    $deletedCount++;
                    sqlsrv_free_stmt($deleteStmt);
                } else {
                    // echo "Fehler beim Löschen des Datensatzes ID $id: ";
                    // print_r(sqlsrv_errors());
                }
            }
        }

        // echo "<br>Insgesamt $deletedCount verwaiste Datensätze gelöscht.<br>";
    } else {
        // echo "Fehler beim Ausführen der Abfrage: ";
        // print_r(sqlsrv_errors());
    }
    sqlsrv_free_stmt($stmt);
} else {
    // echo "Fehler bei der Vorbereitung der Abfrage: ";
    // print_r(sqlsrv_errors());
}

// Jetzt noch alle physisch vorhandenen Dateien prüfen, ob sie verwaist sind
$dateienImg = scandir($uploadFolder);
$dateienVideo = scandir($uploadFolder2);

foreach ($dateienImg as $imagePath) {
    if ($imagePath === '.' || $imagePath === '..') continue;

    if (!in_array($imagePath, $imageListPath)) {
        // Datei ist nicht mehr referenziert → löschen
        $fullPath = $uploadFolder . $imagePath;
        if (unlink($fullPath)) {
            // echo "Verwaiste Datei gelöscht: $imagePath<br>";
        } else {
            // echo "Fehler beim Löschen von: $imagePath<br>";
        }
    }
}


foreach ($dateienVideo as $imagePath) {
    if ($imagePath === '.' || $imagePath === '..') continue;

    if (!in_array($imagePath, $videoListPath)) {
        // Datei ist nicht mehr referenziert → löschen
        $fullPath = $uploadFolder2 . $imagePath;
        if (unlink($fullPath)) {
            // echo "Verwaiste Datei gelöscht: $imagePath<br>";
        } else {
            // echo "Fehler beim Löschen von: $imagePath<br>";
        }
    }
}

// Verbindung schließen
sqlsrv_close($conn);
