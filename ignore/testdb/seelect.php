<?php
include ("coonnection.php");

$sql = "SELECT * FROM meow";

$result = sqlsrv_query($conn, $sql);

if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}
$unsereTabelle = [];
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    // echo $row['ID'] . ", " . $row['Name'] . "<br />";
    // array_push($list, $row);
    array_push($unsereTabelle, array( 
        $row["Vorname"],
        $row["Nachname"],
        $row["Wohnort"],
    ));

}

$jsonList = json_encode($unsereTabelle);

echo $jsonList;
// echo "</br>";