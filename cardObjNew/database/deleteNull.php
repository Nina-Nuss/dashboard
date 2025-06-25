<?php

include("connection.php");

// Löschen von Datensätzen, bei denen der Titel null ist
$deleteSql = "DELETE FROM schemas WHERE titel IS NULL";
$deleteStmt = sqlsrv_query($conn, $deleteSql);
if ($deleteStmt === false) {
    die("Fehler beim Löschen: " . print_r(sqlsrv_errors(), true));
}

// Abrufen der verbleibenden Datensätze
$sql = "SELECT * FROM card_objekte";
$result = sqlsrv_query($conn, $sql);

if ($result === false) {
    die("Abfragefehler: " . print_r(sqlsrv_errors(), true));
}

$unsereTabelle = [];
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    if (isset($row['id']) && $row['id'] !== null) {
        array_push($unsereTabelle, array(
            $row["id"],
            $row["titel"],
            $row["imagePath"],
            $row["selectedTime"],
            $row["imageSet"],
            $row["aktiv"],
            $row["startDateTime"],
            $row["endDateTime"]
        ));
    }
}
sqlsrv_free_stmt($result);

$jsonList = json_encode($unsereTabelle);

echo $jsonList;

sqlsrv_close($conn);
?>