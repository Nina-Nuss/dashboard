<?php


include("connection.php");

$sql = "SELECT * FROM schemas";
$result = sqlsrv_query($conn, $sql);

if ($result === false) {
    die("Abfragefehler: " . print_r(sqlsrv_errors(), true));
}

// Pfad zu den Bildern
$path = "../uploads";
$absolutePath = realpath($path);

if (!$absolutePath || !is_dir($absolutePath)) {
    die("Der Ordner 'uploads' existiert nicht.");
}

// Tabelle für die Ergebnisse
$unsereTabelle = [];

while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    if (isset($row['id']) && $row['id'] !== null) {
        array_push($unsereTabelle, array(
            $row["id"],
            $row["titel"],
            $row["imagePath"],
            $row["selectedTime"],
            (bool)$row["imageSet"],
            (bool)$row["aktiv"],
            $row["startDateTime"],
            $row["endDateTime"],
        ));
    }
}

sqlsrv_free_stmt($result);

// JSON-Ausgabe
$jsonList = json_encode($unsereTabelle);
echo $jsonList;

sqlsrv_close($conn);
?>