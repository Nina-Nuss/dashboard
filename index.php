<?php
ob_start();
require("database/selectInfotherminal.php");
require("database/selectSchemas.php");

ob_clean();

// echo "<h1>------------</h1>";

$clientIP = trim(strval($_SERVER['REMOTE_ADDR']));

// $clientIP = "10.1.1.7";
echo "Die IP-Adresse des Clients ist: " . $clientIP;

$listePics = array();

$ipAdressFound = false;

foreach ($infotherminalList1 as $datensatz) {
    // Überprüfen, ob die IP-Adresse im Datensatz vorhanden ist und nicht null ist
    if (isset($datensatz[2]) && $clientIP === $datensatz[2] && $datensatz[2] !== null) {
        $idDatensatz = $datensatz[0];
        echo "<h1>Gefundene Ip adresse: </h1>" . $datensatz[2];
        $ipAdressFound = true;
        // echo $idDatensatz;
        // Wenn die IP-Adresse übereinstimmt, führe die folgenden Aktionen aus
        // foreach ($schemalist1 as $datensatz2) {            
        //     if($idDatensatz === $datensatz2[6]) {
        //         // echo "<h3>Gefundenes Bild:</h3>";
        //         // Wenn die infotherminal_id übereinstimmt, füge das Bild zur Liste hinzu
        //         // echo $idDatensatz . "<br>"  . $datensatz2[1];
        //         array_push($listePics, array(
        //             $datensatz2[1], // imagePath
        //         ));
        //     }
        // }
        // echo "<h4>------------</h4>";
        // echo "Gefundene IP: " . $datensatz[2] . "<br>";
        // echo "Titel: " . $datensatz[1] . "<br>";
        // echo "<h4>------------</h4>";
        // echo json_encode($listePics);
        header("Location: ../output/index.php?ip=" . urlencode($datensatz[1]));
    }
} 
if($ipAdressFound != true){
    header("Location: ../error/index.php?ip=" . urlencode($clientIP));
}




?>
