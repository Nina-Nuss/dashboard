<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Template</title>
    <script src="/js/schema.js"></script>
</head>

<body>
    <H1>mewwwwwwwwwwwoo</H1>
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
        <input type="submit" onclick="meow(event)">
    </form>
    <div>
        <div>
            <img id="imageContainer" src="" alt="">
        </div>
    </div>
</body>
<script>
    function meow(event) {
        event.preventDefault(); // Verhindert das Standardverhalten des Formulars
        const form = event.target.form;
        const formData = new FormData(form);



    }
    async function sendPicture() {
        await fetch("/schemas/movePic.php", {
                method: 'POST',
                body: formData
            }).then(response => response.text())
            .then(response => {
                document.getElementById('imageContainer').src = '/schemas/' + response; // Aktualisiert das Bild mit dem neuen Dateinamen
                console.log(response);

            }).catch(error => {
                console.error('Error:', error);
            });
    }
</script>

</html>