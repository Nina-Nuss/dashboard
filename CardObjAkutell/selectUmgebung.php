<?php

include ("connection.php");

$sql = "SELECT * FROM umgebungen";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Abfragefehler: " . mysqli_error($conn));
}

$unsereTabelle = [];
while ($row = mysqli_fetch_assoc($result)) {
    if(isset($row['ipAdresse']) && $row['ipAdresse'] !== null && 
       isset($row['titel']) && $row['titel'] !== null) {
        
        array_push($unsereTabelle, array(
            $row["ipAdresse"],
            $row["titel"]
        ));
    }
  
}


mysqli_free_result($result);
$jsonList = json_encode($unsereTabelle);

echo $jsonList;

?>