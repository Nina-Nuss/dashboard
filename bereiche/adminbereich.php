<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Willkommen im Adminbereich</h1>
    <p>Hier können Sie neue Infotherminals hinzufügen oder löschen</p>
    <br>
    <h2>Infotherminals hinzufügen</h2>

    <form action="bereitsVorhanden.php" method="post">
        <label for="infotherminalIp">IP-Adresse:</label>
        <input type="text" id="infotherminalIp" name="infotherminalIp" required><br>
        <label for="infotherminalName">Name:</label>
        <input type="text" id="infotherminalName" name="infotherminalName" required><br>
        <button type="submit">Hinzufügen</button>
    </form>
    <br>
    <h2>Infotherminals löschen</h2>
    <form action="infotherminalLöschen">
       
        <button type="submit">Löschen</button>
    </form>
</body>

</html>