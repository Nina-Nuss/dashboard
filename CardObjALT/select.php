<?php
include "connection.php";
include "imageObj.php";


$sql = "SELECT * FROM images";

$result = sqlsrv_query($conn, $sql);

if ($result === false) {

    die(print_r(sqlsrv_errors(), true));
}
$unsereTabelle = [];
// Assuming $result is a valid SQLSRV result resource
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    if (isset($row['image_name']) && $row['image_name'] !== null && isset($row['image_path']) && $row['image_path'] !== null) {
        array_push($unsereTabelle, array(
            new Image($row["id"], $row["image_path"], $row["image_name"], $row["startDatum"], $row["endDatum"])
        ));
    }
}
$listee = json_encode($unsereTabelle);
echo $listee;




