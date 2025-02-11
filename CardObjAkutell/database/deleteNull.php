<?php
include("connection.php");

// Löschen von Datensätzen, bei denen der Titel null ist
$deleteSql = "DELETE FROM card_objekte WHERE titel IS NULL";
if (!mysqli_query($conn, $deleteSql)) {
    die("Fehler beim Löschen: " . mysqli_error($conn));
}

// Abrufen der verbleibenden Datensätze
$sql = "SELECT * FROM card_objekte";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Abfragefehler: " . mysqli_error($conn));
}

$unsereTabelle = [];
while ($row = mysqli_fetch_assoc($result)) {
    if (isset($row['id']) && $row['id'] !== null) {
        array_push($unsereTabelle, array(
            $row["id"],
            $row["titel"],
            $row["imagePath"],
            $row["selectedTime"],
            $row["isTimeSet"],
            $row["imageSet"],
            $row["aktiv"],
            $row["startDateTime"],
            $row["endDateTime"]
        ));
    }
}
mysqli_free_result($result);

$jsonList = json_encode($unsereTabelle);

echo $jsonList;

mysqli_close($conn);
?>