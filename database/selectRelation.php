<?php

include("connection.php");

$sql = "SELECT * FROM infotherminal_schema";
$result = sqlsrv_query($conn, $sql);

if ($result === false) {
    die("Abfragefehler: " . print_r(sqlsrv_errors(), true));
}

$beziehungsList1 = [];

while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    if (
        isset($row['fk_infotherminal_id']) && $row['fk_infotherminal_id'] !== null &&
        isset($row['fk_schema_id']) && $row['fk_schema_id'] !== null

    ) {
        $key = $row['fk_infotherminal_id'] . '-' . $row['fk_schema_id'];
        if (in_array($key, $beziehungsList1)) {
            continue; // Überspringe doppelte Einträge
        } else {
            array_push($beziehungsList1, array(
                $row["id"],
                $row["fk_infotherminal_id"],
                $row['fk_schema_id'],
            ));
        }
    }
}
sqlsrv_free_stmt($result);

$beziehungsList = json_encode($beziehungsList1);
echo $beziehungsList;

sqlsrv_close($conn);
