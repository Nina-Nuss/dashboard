<?php

// Server-IP (nicht Client-IP) ermitteln
$serverIP = $_SERVER['SERVER_ADDR'] ?? gethostname();

// Prüfen ob IPv4
if (filter_var($serverIP, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
    echo json_encode($serverIP);
} else {
    exit;
}
?>

