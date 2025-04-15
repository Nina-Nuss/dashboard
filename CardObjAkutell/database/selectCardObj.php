<?php

include ("connection.php");

$sql = "SELECT * FROM card_objekte";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Abfragefehler: " . mysqli_error($conn));
}


$unsereTabelle = [];
while ($row = mysqli_fetch_assoc($result)) {
    if(isset($row['id']) && $row['id'] !== null) {
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

?>