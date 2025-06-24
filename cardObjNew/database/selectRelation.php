<?php

include("connection.php");

$sql = "SELECT * FROM infotherminal_schema";
$result = sqlsrv_query($conn, $sql);

if ($result === false) {
    die("Abfragefehler: " . print_r(sqlsrv_errors(), true));
}

$unsereTabelle1 = [];

while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    if (
        isset($row['fk_infotherminal_id']) && $row['fk_infotherminal_id'] !== null &&
        isset($row['fk_schema_id']) && $row['fk_schema_id'] !== null

    ) {
        $key = $row['fk_infotherminal_id'] . '-' . $row['fk_schema_id'];
        if (in_array($key, $unsereTabelle1)) {
            continue; // Überspringe doppelte Einträge
        } else {
            array_push($unsereTabelle1, array(
                $row["fk_infotherminal_id"],
                $row['fk_schema_id'],
            ));
        }
    }
}
sqlsrv_free_stmt($result);

$jsonList2 = json_encode($unsereTabelle1);
echo $jsonList2;

sqlsrv_close($conn);
