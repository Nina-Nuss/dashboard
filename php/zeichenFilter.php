<?php
// filepath: c:\xampp\htdocs\html_Infoterminal\checkInput.php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = $_POST["benutzername"] ?? '';

    // Erlaubt nur Buchstaben, Zahlen und Unterstrich
    if (!preg_match('/^[A-Za-z0-9_]+$/', $input)) {
        echo "Ungültige Zeichen im Benutzernamen!";
    } else {
        echo "Eingabe ist gültig: " . htmlspecialchars($input);
    }
}
?>

<form method="post">
    <label for="benutzername">Benutzername:</label>
    <input type="text" name="benutzername" id="benutzername">
    <button type="submit">Prüfen</button>
</form>