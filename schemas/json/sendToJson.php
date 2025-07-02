<?php
// JSON-Daten aus der Anfrage abrufen
$jsonData = file_get_contents("php://input");

// Überprüfen, ob die Daten empfangen wurden
if (!$jsonData) {
    http_response_code(400);
    echo json_encode(["error" => "Keine Daten empfangen"]);
    exit;
}


$jsonDecode = json_decode($jsonData, true);

// echo json_encode($jsonDecode[0]);

// if (isset($jsonDecode[0]["ipAdresse"])) {
//     $filePath = __DIR__ . '/umgebung.json';
//     if (file_put_contents($filePath, $jsonData)) {
//         echo json_encode(["success" => true, "message" => "Daten erfolgreich gespeichert"]);
//     } else {
//         http_response_code(500);
//         echo json_encode(["error" => "Fehler beim Speichern der Daten"]);
//     }
// if(isset($jsonDecode[0]["aktiv"])){
//     $filePath = __DIR__ . '/cardObj.json';
//     if (file_put_contents($filePath, $jsonData)) {
//         echo json_encode(["success" => true, "message" => "Daten erfolgreich gespeichert"]);
//     } else {
//         http_response_code(500);
//         echo json_encode(["error" => "Fehler beim Speichern der Daten"]);
//     }
// }

exit;

// JSON-Daten in einer Datei speichern
