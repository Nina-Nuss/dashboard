<?php
session_start();


include("/xampp/htdocs/Infotherminal/dashboard/cardObjNew/database/selectUmgebung.php");
// echo "<br>";
ob_end_clean();

$ip = $_POST["infotherminalIp"] ?? '';
$name = $_POST["infotherminalName"] ?? '';

$patternIp = '/^[A-Za-z0-9._@-]+$/';

$patternIpFormat = '/^\d{2}\.\d\.\d\.\d{1,3}$/';


$ip = $_POST["infotherminalIp"] ?? '';
$name = $_POST["infotherminalName"] ?? '';


// echo $ip;
// echo "<br>";
// echo $name;
// echo "<br>";

if (!preg_match($patternIp, $ip) || !preg_match($patternIp, $name)) {
    echo "ungültiges Zeichen";
    exit;
}
if (!preg_match($patternIpFormat, $ip)) {
    echo "IP-Adresse entspricht nicht dem Format 00.0.0.000!";
    exit;
}

if (isset($ip) && isset($name)) {
    foreach ($infothermalList1 as $datensatz) {
        if ($datensatz[2] === $ip || $datensatz[1] === $name) {
            echo "IP bereits vorhanden: " . $datensatz[2];
            exit;
        } 
    }
    
    $_SESSION['ip'] = $ip;
    $_SESSION['name'] = $name;
    include $_SERVER['DOCUMENT_ROOT'] . '/cardObjNew/database/insertInfotherminal.php';
    exit;
}
