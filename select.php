<?php
include ("connectionA.php");

$sql = "SELECT * FROM daten";

$result = sqlsrv_query($conn, $sql);

if ($result === false) {
  
    die(print_r(sqlsrv_errors(), true));
    
}
$unsereTabelle = [];
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    // echo $row['ID'] . ", " . $row['Name'] . "<br />";
    // array_push($list, $row);
    if(isset($row['ip']) && $row['ip'] !== null && isset($row['titel']) 
            && $row['titel'] !== null && isset($row['von'])    
            && $row['von'] !== null && isset($row['bis'])
            && $row['bis'] !== null && isset($row['beschreibung']) 
            && $row['beschreibung'] !== null && isset($row['id']) 
            && $row['id'] !== null){
            array_push($unsereTabelle, array( 
                $row["ip"],
                $row["titel"],
                $row["von"],
                $row["bis"],
                $row["beschreibung"],
                $row["id"]
             
            ));
    }
}


$jsonList = json_encode($unsereTabelle);

echo $jsonList;
// echo "</br>";