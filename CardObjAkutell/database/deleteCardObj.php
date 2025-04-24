<?php
include("connection.php");

// Abrufen der JSON-Daten aus der Anfrage
$data = json_decode(file_get_contents('php://input'), associative: true);




// Überprüfen, ob die Daten korrekt abgerufen wurden
if (isset($data['id'])) {
    $id = $data['id'];

    // SQL-Abfrage mit Prepared Statement
    $sql = "DELETE FROM card_objekte WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Parameter binden
        mysqli_stmt_bind_param($stmt, "i", $id);
        
        // Statement ausführen
        if (mysqli_stmt_execute($stmt)) {
            echo "Datensatz erfolgreich gelöscht";
        } else {
            echo "Fehler beim Löschen: " . mysqli_stmt_error($stmt);
        }
        // Statement schließen
        mysqli_stmt_close($stmt);
    } else {
        echo "Fehler bei der Vorbereitung: " . mysqli_error($conn);
    }
} else {
    echo "Fehlende ID";
}

mysqli_close($conn);
?>