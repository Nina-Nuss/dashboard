<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    .panelAdmin {
        display: flex;
        justify-content: space-around;
    }
    .deleteInfotherminal {
        margin-left: 20px;
    }
    .addTerminal {
        margin-right: 20px;
    }
</style>


<body>
    <h1>Willkommen im Adminbereich</h1>
    <p>Hier können Sie neue Infotherminals hinzufügen oder löschen</p>


    <div class="panelAdmin">
        <div class="addInfotherminal">
            <h2>Infotherminals hinzufügen</h2>
            <form id="formID" action="/bereiche/bereitsVorhanden.php" method="post">
                <label for="infotherminalIp">IP-Adresse:</label>
                <input type="text" id="infotherminalIp" name="infotherminalIp" required><br>
                <label for="infotherminalName">Name:</label>
                <input type="text" id="infotherminalName" name="infotherminalName" required><br>
                <button type="submit">Hinzufügen</button>
            </form>
        </div>
        <div class="deleteInfotherminal">
            <h2>Infotherminals löschen</h2>
            <div id="deleteInfotherminal">
            </div>
        </div>
    </div>
</body>
<script>
    // ...existing code...
    console.log("me3oewrpojsgjdaglikjfdglikjgl");
    // Beispiel: Event Listener für alle CardObj-Formulare
    // ...existing code...
    document.getElementById('formID').addEventListener('submit', function(event) {
        event.preventDefault(); // Standard-Submit verhindern


        const form = event.target;
        const formData = new FormData(form);

        fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(result => {
                // Optional: Rückmeldung anzeigen
                console.log(result);
                // z.B. Erfolgsmeldung anzeigen oder UI aktualisieren
            })
            .catch(error => {
                console.error('Fehler beim Hinzufügen:', error);
            });
    });
</script>

</html>