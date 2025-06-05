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
$unsereTabelle2 = [];

while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    if (isset($row['id']) && $row['id'] !== null) {
        array_push($unsereTabelle2, array(
            $row["id"],
            $row["imagePath"],
            $row["selectedTime"],
            (bool)$row["isImageSet"],
            (bool)$row["isAktiv"],
            $row["startDateTime"],
            $row["endDateTime"],
            $row["infotherminal_id"]
        ));
    }
}

sqlsrv_free_stmt($result);

// JSON-Ausgabe
$jsonList1 = json_encode($unsereTabelle2);
echo $jsonList1;

sqlsrv_close($conn);
?>