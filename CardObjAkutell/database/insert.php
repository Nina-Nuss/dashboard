<?php
include("connection.php");

// Abrufen der JSON-Daten aus der Anfrage
$data = json_decode(file_get_contents('php://input'), associative: true);

echo json_encode($data);

// Überprüfen, ob die Daten korrekt abgerufen wurden
if (is_array($data)) {
    $titel = $data["titel"];
    $imagePath = $data["imagePath"];
    $isTimeSet = $data["isTimeSet"];
    $selectedTime = $data["selectedTime"];
    $imageSet = $data["imageSet"];
    $startDateTime = $data["startDateTime"];
    $endDateTime = $data["endDateTime"];
    $aktiv = $data["aktiv"];

    echo $isTimeSet;
    echo $aktiv;
    echo $isTimeSet;


    // if ($aktiv == 1) {
    //     $aktiv = "true";
    // } else {
    //     $aktiv = "false";
    // }
    // if ($isTimeSet == 1) {
    //     $isTimeSet = "true";
    // } else {
    //     $isTimeSet = "false";
    // }
    // if ($imageSet == 1) {
    //     $imageSet = "true";
    // } else {
    //     $imageSet = "false";
    // }

 
    // SQL-Abfrage mit Prepared Statement
    $sql = "INSERT INTO card_objekte (titel, imagePath, selectedTime, isTimeSet, imageSet, aktiv, startDateTime, endDateTime) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Parameter binden
        mysqli_stmt_bind_param($stmt, "ssssssss", $titel, $imagePath, $selectedTime, $isTimeSet, $imageSet, $aktiv, $startDateTime, $endDateTime);

        // Statement ausführen
        if (mysqli_stmt_execute($stmt)) {
            echo "Datensatz erfolgreich eingefügt";
        } else {
            echo "Fehler beim Einfügen: " . mysqli_stmt_error($stmt);
        }
        // Statement schließen
        mysqli_stmt_close($stmt);
    } else {
        echo "Fehler bei der Vorbereitung: " . mysqli_error($conn);
    }
} else {
    echo "Fehler beim Abrufen der Daten";
}

mysqli_close($conn);
