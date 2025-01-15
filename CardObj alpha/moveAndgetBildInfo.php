<?php

if (!empty($_FILES['bild']['name'])) {
    $tmp_name = $_FILES['bild']['tmp_name'];
    // Erzeugen eines zufälligen Namens für das Bild
    $random_name = uniqid() . '-' . basename($_FILES['bild']['name']);
    $uploadDir = 'C:\Users\maxim\OneDrive\infoterminal\dashboard\DBimageDateTimePicker\pojekt\\';
    $uploadFile = $uploadDir . $random_name;
    $list = [];
    if (move_uploaded_file($tmp_name, $uploadFile)) {
        // echo "Das Bild wurde erfolgreich verschoben.<br>";
        // echo "Name: " . $random_name . "<br>";
        // echo "Pfad: " . $uploadFile;
        array_push($list, $random_name, $uploadFile);
    } else {
        // echo "Beim Verschieben des Bildes ist ein Fehler aufgetreten.";
    }
    echo json_encode($list);
}
