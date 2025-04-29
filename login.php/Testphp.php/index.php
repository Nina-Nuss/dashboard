<?



$password = 'meinPasswort123';
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$eingabePasswort = 'meinPasswort123';
if (password_verify($eingabePasswort, $hashedPassword)) {
    echo 'Passwort ist korrekt!';
} else {
    echo 'Ungültiges Passwort.';
}
