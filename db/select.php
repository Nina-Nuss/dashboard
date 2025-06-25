<?php
include ("connectionMy.php");

$sql = "SELECT * FROM daten";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Abfragefehler: " . mysqli_error($conn));
}

$unsereTabelle = [];
while ($row = mysqli_fetch_assoc($result)) {
    if(isset($row['ip']) && $row['ip'] !== null && 
       isset($row['titel']) && $row['titel'] !== null && 
       isset($row['von']) && $row['von'] !== null && 
       isset($row['bis']) && $row['bis'] !== null && 
       isset($row['beschreibung']) && $row['beschreibung'] !== null && 
       isset($row['id']) && $row['id'] !== null) {
        
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
echo json_encode($unsereTabelle);

mysqli_free_result($result);
$jsonList = json_encode($unsereTabelle);

?>