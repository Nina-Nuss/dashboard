<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="main.js"></script>
</head>

<body>
    <h2>HTML Forms</h2>
    <label for="fname">ID:</label><br>
    <input type="text" id="id" name="fname" value="4"><br>
    <label for="lname">name:</label><br>
    <input type="text" id="name" name="lname" value="Josef"><br>
    <input type="button" value="Add" onclick="GetValues(document.getElementById('id').value, document.getElementById('name').value)"></input>
    <br>
    <input type="text" id="idDelete"></input>
    <input type="button" value="delete"  onclick="deletee(document.getElementById('idDelete').value)">

    <div>
        <div id="tabelle"></div>
        <div id="tabelle2"></div>
        <div id="tabelle3"></div>
    </div>
</body>

</html>