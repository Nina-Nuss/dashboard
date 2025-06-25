<?php


include("database/selectUmgebung.php");
include("database/selectCardObj.php");


// echo "<h1>------------</h1>";



$clientIP = $_SERVER['REMOTE_ADDR'];
echo "Die IP-Adresse des Clients ist: " . $clientIP;


// echo "ip adresse: " . $clientIP . "<br>";

$listePics = array();

foreach ($unsereTabelle1 as $datensatz) {
    // Überprüfen, ob die IP-Adresse im Datensatz vorhanden ist und nicht null ist
    if (isset($datensatz[2]) && $clientIP === $datensatz[2] && $datensatz[2] !== null) {
        $idDatensatz = $datensatz[0];
        // echo $idDatensatz;
        // Wenn die IP-Adresse übereinstimmt, führe die folgenden Aktionen aus
        foreach ($unsereTabelle2 as $datensatz2) {
            
            if($idDatensatz === $datensatz2[7]) {
                // echo "<h3>Gefundenes Bild:</h3>";
                // Wenn die infotherminal_id übereinstimmt, füge das Bild zur Liste hinzu
                // echo $idDatensatz . "<br>"  . $datensatz2[1];

                array_push($listePics, array(
                    $datensatz2[1], // imagePath
                ));
            }
        }
        // echo "<h4>------------</h4>";
        // echo "Gefundene IP: " . $datensatz[2] . "<br>";
        // echo "Titel: " . $datensatz[1] . "<br>";
        // echo "<h4>------------</h4>";
      
        echo json_encode($listePics);

        header("Location: /anzeigeTherminal/index.php?ip=" . urlencode($datensatz[1]));
        
    };
}


?>