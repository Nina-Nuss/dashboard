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
    async function meow(event) {
        event.preventDefault(); // Verhindert das Standardverhalten des Formulars
        const form = event.target.form;
        const formData = new FormData(form);
        const selectedTime = String(formData.get('selectedTime')); // Wert als Zahl
        const aktiv = formData.get('aktiv'); // Wert der ausgewählten Option
      
        const titel = formData.get('title');
        const description = formData.get('description');
     

        console.log("Selected Time:", selectedTime);
        
        const imgFile = formData.get("img");
        const localImageName = imgFile && imgFile.name ? imgFile.name : "";
        if (localImageName === "" || localImageName === null || selectedTime === null || aktiv === null || titel === "" || description === "") {
            alert("Bitte füllen Sie alle Felder aus inkl Bild.");
            return;
        }
        // Bild hochladen und vom Server den Dateinamen erhalten
        const serverImageName = await sendPicture(formData);
        // CardObj mit dem vom Server erhaltenen Bildnamen erstellen
        if (serverImageName === "") {
            console.error("Bild konnte nicht hochgeladen werden.");
            return;
        }
        try {
            // Lokalen Dateinamen in den CardObj einfügen
            const obj1 = new CardObj(
                "",
                serverImageName, // Nur Bildname, kein Pfad
                selectedTime, 
                aktiv,
                "",
                "",
                "",
                "",
                titel,
                description
            )
            console.log(obj1.selectedTime);
            
            await insertDatabase(obj1);
            alert("Schema erfolgreich erstellt!");
        } catch (error) {
            console.error("Fehler beim erstellen des CardObj:", error);
        }
    }
    async function sendPicture(formData) {
        try {
            const response = await fetch("/schemas/movePic.php", {
                method: 'POST',
                body: formData
            });
            let imageName = await response.text();
            // Falls der Server einen Pfad zurückgibt, extrahiere nur den Dateinamen
            imageName = imageName.split('/').pop();
            
            return imageName;
        } catch (error) {
            console.error('Error:', error);
            return "";
        }
    }
</script>

</html>