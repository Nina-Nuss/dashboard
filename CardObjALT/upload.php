<?php
include("connection.php");





$sql = "INSERT INTO images (image_name, image_Path) VALUES (?, ?)";
$params = array($random_name, $uploadFile);

$result = sqlsrv_query($conn, $sql, $params);
if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
} else {
    echo "Erfolgreich Ausgeführt";
    if (move_uploaded_file($tmp_name, $uploadFile)) {
        echo "Das Bild wurde erfolgreich verschoben.<br>";
        echo "Name: " . $random_name . "<br>";
        echo "Pfad: " . $uploadFile;
    } else {
        echo "Beim Verschieben des Bildes ist ein Fehler aufgetreten.";
    }
};
