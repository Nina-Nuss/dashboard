<?php

// Funktion, um die IP-Adresse des Clients zu ermitteln
function getClientIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $ip = trim($ipList[0]);
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    // ::1 ist IPv6-Loopback, entspricht 127.0.0.1
    if ($ip === '::1') {
        $ip = '127.0.0.1';
    }
    return $ip;
}

$clientIP = getClientIP();

// Weiterleitung und IP als GET-Parameter übergeben
header("Location: /cardObjNew/web/index.php?ip=" . urlencode($clientIP));
exit;
?>