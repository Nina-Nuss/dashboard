<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $titel = $_POST["title"] ?? '';
    $beschreibung = $_POST["description"] ?? '';


    // Erlaubt nur Buchstaben, Zahlen und Unterstrich
    if (isset($titel)) {
        if (!preg_match('/^[A-Za-z0-9_]+$/', $titel)) {
            echo "";
            exit("");
        }
        
        if (!preg_match('/^[A-Za-z0-9_ ]+$/', $beschreibung) && $beschreibung !== '') {
            echo "";
            exit("");
        }
    }
    // Überprüfen, ob eine Datei hochgeladen wurde
    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        // Informationen über die hochgeladene Datei
        $fileTmpPath = $_FILES['img']['tmp_name']; // Temporärer Pfad
        $fileName = $_FILES['img']['name'];       // Ursprünglicher Name
        $fileSize = $_FILES['img']['size'];       // Dateigröße
        $fileType = $_FILES['img']['type'];       // MIME-Typ
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $randomName = uniqid('file_', true) . '.' . $fileExtension;
        // Zielordner für die hochgeladene Datei
        $uploadFolder = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
        if (!is_dir($uploadFolder)) {
            mkdir($uploadFolder, 0777, true); // Ordner erstellen, falls nicht vorhanden
        }
        // Neuer Pfad (inkl. Zielname)
        $destPath = $uploadFolder . $randomName;
        // Datei verschieben
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            echo $destPath; // Absoluter Pfad
        } else {
            echo "Fehler: Keine Datei hochgeladen oder Fehler beim Upload." .  $uploadFolder;
        }
    } else {
        echo "Fehler: Keine Datei hochgeladen oder Fehler beim Upload." .  $uploadFolder;
    }
}
