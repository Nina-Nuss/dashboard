<?php
include("connection.php");

$sql = "SELECT * FROM infotherminals";
$result = sqlsrv_query($conn, $sql);

if ($result === false) {
    die("Abfragefehler: " . print_r(sqlsrv_errors(), true));
}

$unsereTabelle = [];
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    if (isset($row['ipAdresse']) && $row['ipAdresse'] !== null &&
        isset($row['titel']) && $row['titel'] !== null) {
        array_push($unsereTabelle, array(
            $row["id"],
            $row["titel"],
            $row["ipAdresse"]
        ));
    }
}
sqlsrv_free_stmt($result);



$jsonList = json_encode($unsereTabelle);
echo $jsonList;

sqlsrv_close($conn);



?>