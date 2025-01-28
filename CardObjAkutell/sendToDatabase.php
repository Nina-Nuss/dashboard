<?php
include("connection.php");
include("select.php");

$data = json_decode(file_get_contents('php://input'), true);


// SQL-Abfrage mit Prepared Statement
$sql = "INSERT INTO daten (ip, titel, von, bis, beschreibung) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare(mysql: $conn, $sql);

if ($stmt) {
    // Parameter binden
    mysqli_stmt_bind_param($stmt, "sssss", $ip, $titel, $von, $bis, $beschreibung);
    
    // Statement ausführen
    if (mysqli_stmt_execute($stmt)) {
        echo "Datensatz erfolgreich eingefügt";
    } else {
        echo "Fehler beim Einfügen: " . mysqli_stmt_error($stmt);
    }
    
    // Statement schließen
    mysqli_stmt_close($stmt);
} else {
    echo "Fehler bei der Vorbereitung: " . mysqli_error($conn);
}
?>