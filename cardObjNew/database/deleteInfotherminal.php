<?php
include("connection.php");

if (!isset($_GET['idDelete'])) {
    echo 'Fehler: Keine Daten empfangen';
    return;
} else {
    echo "Daten empfangen: " . $_GET['idDelete'];
}


$sql = "SELECT * FROM infotherminals";

$sql = "DELETE FROM daten WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // Parameter binden
    mysqli_stmt_bind_param($stmt, "i", $_GET['idDelete']); // i für Integer

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
