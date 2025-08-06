<?php
// config.php erstellen

use Dom\Document;

header('Content-Type: application/json; charset=utf-8');

// JSON-Daten aus dem Request lesen
$data = json_decode(file_get_contents('php://input'), true);

// Überprüfen, ob die erforderlichen Felder vorhanden sind
if (!isset($data['name']) || !isset($data['value'])) {
    echo json_encode(['success' => false, 'error' => 'Ungültige Daten: "name" oder "value" fehlt']);
    exit;
}

$configFile = $_SERVER['DOCUMENT_ROOT'] . '/config/config.json';

// Überprüfen, ob die Konfigurationsdatei lesbar und beschreibbar ist
if (!is_readable($configFile) || !is_writable($configFile)) {
    echo json_encode(['success' => false, 'error' => 'Konfigurationsdatei nicht gefunden oder nicht beschreibbar']);
    exit;
}

// Konfigurationsdatei laden
$config = json_decode(file_get_contents($configFile), true);
if ($config === null) {
    echo json_encode(['success' => false, 'error' => 'Ungültiges JSON in der Konfigurationsdatei']);
    exit;
}

// Den Wert im Konfigurationsarray aktualisieren
$config[$data['name']] = $data['value'];

// Aktualisierte Konfiguration in die Datei schreiben
if (file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) === false) {
    echo json_encode(['success' => false, 'error' => 'Schreibfehler']);
    exit;
}

// Erfolgsantwort zurückgeben
echo json_encode(['success' => true]);