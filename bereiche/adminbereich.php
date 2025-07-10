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
            <ul>
                <li>IP-Adresse soll dem Format "00.0.0.000" entsprechen</li>
                <li>Es darf keine Leerzeichen vorhanden sein</li>
                <li>Sonderzeichen sind nicht erlaubt</li>
            </ul>
            <br>
            <form id="formID" action="/bereiche/bereitsVorhanden.php" method="post">
                <label for="infotherminalIp">IP-Adresse:</label>
                <input class="inputAddInfo" type="text" id="infotherminalIp" name="infotherminalIp" required><br>
                <label for="infotherminalName">Name:</label>
                <input class="inputAddInfo" type="text" id="infotherminalName" name="infotherminalName" required><br>
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
</html>