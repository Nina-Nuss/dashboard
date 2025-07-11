<!DOCTYPE html>
<html lang="en">

<?php include '../assets/links.html'; ?>
<?php include '../assets/scripts.html'; ?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template</title>
</head>

<body>

    <H1>Erstelle Schemas</H1>
    <form action="/schemas/movePic.php">
        <label for="img">Select image:</label>
        <input type="file" id="img" name="img" accept="image/*">
        <br>
        <label for="title">name: </label>
        <input type="text" id="title" name="title" placeholder="name">
        <br>
        <label for="description">Description:</label>
        <input type="text" id="description" name="description" placeholder="description">
        <br>
        <label for="selectedTime">selectedTime:</label>
        <select id="selectedTime" name="selectedTime">
            <option value="3000">3 Sekunden</option>
            <option value="7000">7 Sekunden</option>
            <option value="10000">10 Sekunden</option>
        </select>
        <br>
        <label for="aktiv">aktiv:</label>
        <select id="aktiv" name="aktiv">
            <option value="1">aktiv</option>
            <option value="0">inaktiv</option>
        </select>
        <br>
        <input type="submit" onclick="meow(event)">
    </form>
    <div>
        <div>
            <img id="imageContainer" src="" alt="">
        </div>
    </div>
</body>
<script>
   
</script>

</html>