<?php
// config.php erstellen

header('Content-Type: application/json; charset=utf-8');

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['default'])) {
    echo json_encode(['success'=>false, 'error'=>'Kein Wert übergeben']);
    exit;
}

$configFile = __DIR__ . '/../config/config.json';
if (!is_readable($configFile) || !is_writable($configFile)) {
    echo json_encode(['success'=>false, 'error'=>'Konfigurationsdatei nicht gefunden oder nicht beschreibbar']);
    exit;
}

$config = json_decode(file_get_contents($configFile), true);
if ($config === null) {
    echo json_encode(['success'=>false, 'error'=>'Ungültiges JSON in der Konfigurationsdatei']);
    exit;
}

$config['default'] = $data['default'];

if (file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE)) === false) {
    echo json_encode(['success'=>false, 'error'=>'Schreibfehler']);
    exit;
}

echo json_encode(['success'=>true]);