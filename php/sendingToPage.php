<?php
// Diese Datei empfängt die POST-Daten und leitet sie an die gewünschte Seite weiter

// POST-Daten empfangen
$postData = $_POST;

// Zielseite festlegen
$targetPage = "/web/adminbereich.php";

// Daten an die Zielseite senden
if (!empty($postData)) {
  
    // Hier können Sie die Daten verarbeiten oder speichern, bevor Sie zur Zielseite weiterleiten
    // Zum Beispiel: speichern in der Datenbank

    // Nach der Verarbeitung zur Zielseite weiterleiten
    header("Location: $targetPage");
    exit;
}


