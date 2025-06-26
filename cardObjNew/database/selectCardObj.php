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

while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    if (isset($row['id']) && $row['id'] !== null) {
        array_push($schemaList1, array(
            $row["id"],
            $row["imagePath"],
            $row["selectedTime"],
            (bool)$row["isAktiv"],
            $row["startDateTime"],
            $row["endDateTime"],
            $row["fk_infotherminal_id"]
        ));
    }
}

sqlsrv_free_stmt($result);

// JSON-Ausgabe
$schemaList = json_encode($schemaList1);
echo $schemaList;

sqlsrv_close($conn);
?>