<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

require('../php/connection.php');
require('../php/access.php');

$host_server = "10.1.6.3";
//$host_server = "localhost:3000";

$ip = $_SERVER['REMOTE_ADDR'];
if ($ip == "::1")
    $ip = "127.0.0.1";
$liste = [];

//localhost:3000/dashboard/login.php?username=test&password=test

//Beim Einloggen werden diese Informationen angegeben
$username = $_GET['username'];
$password = $_GET['password'];

if (is_null($username) or is_null($password)) {
    echo "Login Fehlgeschlagen..";
    exit();
}

// echo "PW: " . $password . "<br>";
// echo "Benutzer: " . $username . "<br>";
// echo erstelleHash($password) . "<br>";

$sql = "SELECT * FROM access WHERE username = '$username'";
$result = sqlsrv_query($conn, $sql);

#Fetching Data by array
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    if ($row['username'] == $username && $row['active'] == "true") {
        array_push($liste, new Access($row['id'], $row['username'], $row['salt'], $row['hash'], $row['active'], $row['last_session']));
    }
}

for ($i = 0; $i < count($liste); $i++) {
    if ($username == $liste[$i]->username) {
        $hash = $liste[$i]->hash;
        if (ueberpruefeLogin($password, $hash)) {
            echo 'Password is valid!';
            header('Location: http://' . $host_server . '/dashboard');
            echo 'true';
        } else {
            echo 'false';
        }
        exit();
    }
}

echo 'false';

function erstelleHash($pw)
{
    return password_hash($pw, PASSWORD_DEFAULT);
}

function ueberpruefeLogin($pw, $hsh)
{
    // See the password_hash() example to see where this came from.
    if (password_verify($pw, $hsh)) {
        return true;
    } else {
        return false;
    }
}
?>