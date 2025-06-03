<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Site</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>

</head>
<style>
    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    img.fullscreen {
        width: 100vw;
        height: 100vh;
        object-fit: cover;
        display: block;
    }
</style>

<body>
    
</body>
<script>
    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    async function carousel() {
        const response = await fetch("../php/getNamesFolder.php");
        if (!response.ok) {
            console.error('Error fetching image:', response.statusText);
            return;
        }
        const data = await response.json();

        for (const element of data) {
            console.log(element);
            // Hier könntest du das Bild anzeigen
       
            const img = document.createElement('img');
            img.src = "../cardObjNew/uploads/" + element;
            img.className = "fullscreen";
            img.alt = "Image";
            document.body.innerHTML = ''; // Clear the body content
            document.body.appendChild(img); // Add the new image to the body
            await sleep(5000); // 5 Sekunden warten, bevor das nächste Bild angezeigt wird
            
        }




    }


    carousel(); // Initial call to set the first image
</script>
<?php

// $dir = "../cardObjNew/uploads";
// if (is_dir(filename: $dir)) {
//     foreach (scandir($dir) as $file) {

//         echo "<br>" . $dir . '/' . $file . "</br>";
//     }
// }
?>

</html>