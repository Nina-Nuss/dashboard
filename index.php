<?php
ob_start();
require "database/selectInfotherminal.php";
require "database/selectSchemas.php";


// echo "<h1>------------</h1>";

// $clientIP = $_SERVER['REMOTE_ADDR'];

$clientIP = "10.1.1.7"; // Temporarily hardcoded for testing purposes

echo "Die IP-Adresse des Clients ist: " . $clientIP;

if($clientIP === "::1") {
    $clientIP = "127.0.0.1";
}

$listePics = array();

foreach ($infotherminalList1 as $datensatz) {
    // Überprüfen, ob die IP-Adresse im Datensatz vorhanden ist und nicht null ist
    if (isset($datensatz[2]) && $clientIP === $datensatz[2] && $datensatz[2] !== null) {
        $idDatensatz = $datensatz[0];
        echo "<h3>Gefundenes Bild:</h3>";
        // echo $idDatensatz;
        // Wenn die IP-Adresse übereinstimmt, führe die folgenden Aktionen aus
        foreach ($schemalist1 as $datensatz2) {            
            if($idDatensatz === $datensatz2[6]) {
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
        header("Location: ../output/index.php?ip=" . urlencode($datensatz[1]));
    }
    else{
        // Wenn keine Übereinstimmung gefunden wurde, kann hier eine entsprechende Aktion erfolgen
        header("Location: ../error/index.php");
    };
}
?>
