<?php
// Zielordner für die hochgeladenen Dateien
$uploadDir = 'uploads/';

// Überprüfen, ob der Ordner existiert, und erstellen, falls nicht
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Überprüfen, ob eine Datei hochgeladen wurde
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $fileName = basename($file['name']);
    echo "<h1>$fileName</h1>"; // Ursprünglicher Dateiname
    $targetPath = $uploadDir . $fileName; // Zielpfad

    // Überprüfen, ob es sich um ein gültiges Bild handelt
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (in_array($file['type'], $allowedTypes)) {
        // Datei verschieben
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            echo "<h1>Bild hochgeladen</h1>";
            echo "<p>Die Datei wurde erfolgreich hochgeladen:</p>";
            echo "<p><a href='$targetPath'>$fileName</a></p>";
            // Anzeige des hochgeladenen Bildes
            echo "<img src='$targetPath' alt='Hochgeladenes Bild' style='max-width: 300px; max-height: 300px;'>";
            echo "<p><a href='index.html'>Weitere Datei hochladen</a></p>";
        } else {
            echo "<p>Fehler beim Hochladen der Datei.</p>";
        }
    } else {
        echo "<p>Ungültiger Dateityp. Bitte laden Sie ein Bild (JPEG, PNG, GIF) hoch.</p>";
    }
} else {
    echo "<p>Es wurde keine Datei hochgeladen.</p>";
}
?>
