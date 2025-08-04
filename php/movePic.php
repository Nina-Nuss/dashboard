<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $titel = $_POST["title"] ?? '';
    $beschreibung = $_POST["description"] ?? '';

    // Erlaubt nur Buchstaben, Zahlen und Unterstrich
    if (isset($titel)) {
        if (!preg_match('/^[A-Za-z0-9_]+$/', $titel)) {
            echo "Ungültige Zeichen im Titel!";
            exit;
        }

        if (!preg_match('/^[A-Za-z0-9_ \r\n]+$/', $beschreibung) && $beschreibung !== '') {
            echo "Ungültige Zeichen in der Beschreibung!";
            exit;
        }
    }

    // Überprüfen, ob eine Datei hochgeladen wurde
    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        // Informationen über die hochgeladene Datei
        $fileTmpPath = $_FILES['img']['tmp_name'];
        $fileName = $_FILES['img']['name'];
        $fileSize = $_FILES['img']['size'];
        $fileType = $_FILES['img']['type'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Erlaubte Dateierweiterungen
        $allowedImageTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $allowedVideoTypes = ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm'];
        $allowedTypes = array_merge($allowedImageTypes, $allowedVideoTypes);

        // Prüfen ob Dateierweiterung erlaubt ist
        if (!in_array($fileExtension, $allowedTypes)) {
            echo "Dateityp nicht erlaubt! Erlaubt: " . implode(', ', $allowedTypes);
            exit;
        }



        // Zielordner je nach Dateityp
        if (in_array($fileExtension, $allowedImageTypes)) {
            $uploadFolder = $_SERVER['DOCUMENT_ROOT'] . '/uploads/img/';
            $randomName = uniqid('img_', true) . '.' . $fileExtension;
        } elseif (in_array($fileExtension, $allowedVideoTypes)) {
            $uploadFolder = $_SERVER['DOCUMENT_ROOT'] . '/uploads/video/';
            $randomName = uniqid('video_', true) . '.' . $fileExtension;
        } else {
            $uploadFolder = $_SERVER['DOCUMENT_ROOT'] . '/uploads/video/';
        }

        if (!is_dir($uploadFolder)) {
            mkdir($uploadFolder, 0777, true);
        }

        // Neuer Pfad (inkl. Zielname)
        $destPath = $uploadFolder . $randomName;

        // Datei verschieben
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            echo $destPath; // Vollständiger Pfad zurückgeben
        } else {
            echo "Fehler beim Verschieben der Datei.";
        }
    } else {
        echo "Fehler: Keine Datei hochgeladen oder Upload-Fehler.";
    }
}
