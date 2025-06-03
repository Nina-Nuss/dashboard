<?php

$listeOfIPs = array("127.0.0.1", "2.2.2.2.");

$clientIP = $_GET["ip"] ?? '';


echo "ip adresse: " . $clientIP . "<br>";


foreach ($listeOfIPs as $ip) {
    if ($ip === $clientIP) {
        echo "Gefundene IP: " . $ip . "<br>";
        // header("Location: /cardObjNew/web/index.php?ip=" . urlencode($clientIP));
        
    }else{
        echo "IP nicht gefunden: " . $ip . "<br>";
        return;
    }
}



?>