<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Überprüfen, ob eine Datei hochgeladen wurde
        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            // Informationen über die hochgeladene Datei
            $fileTmpPath = $_FILES['file']['tmp_name']; // Temporärer Pfad
            $fileName = $_FILES['file']['name'];       // Ursprünglicher Name
            $fileSize = $_FILES['file']['size'];       // Dateigröße
            $fileType = $_FILES['file']['type'];       // MIME-Typ
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $randomName = uniqid('file_', true) . '.' . $fileExtension;
            // Zielordner für die hochgeladene Datei
            $uploadFolder = 'uploads/';
            if (!is_dir($uploadFolder)) {
                mkdir($uploadFolder, 0777, true); // Ordner erstellen, falls nicht vorhanden
            }
            // Neuer Pfad (inkl. Zielname)
            $destPath = $uploadFolder . $randomName;
            // Datei verschieben
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                echo $destPath; // Absoluter Pfad
            } else {
                echo "Fehler: Datei konnte nicht verschoben werden.";
            }
        } else {
            echo "Fehler: Keine Datei hochgeladen oder Fehler beim Upload.";
        
        }
    }
    
