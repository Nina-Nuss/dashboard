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
        display: block;
        object-fit: contain;
    }

</style>

<body>

</body>

<script>
    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }
    async function carousel() {
        const params = new URLSearchParams(window.location.search);
        const ort = params.get('ip');
        console.log('IP-Adresse:', ort);
        try {
            const response = await fetch("/database/getSchemas.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    ip: ort
                }), // Beispieldaten
            });

            if (!response.ok) {
                console.error('Error fetching data:', response.statusText);
                return;
            }

            const data = await response.json();

            if (data === null || data === undefined || data.length === 0) {
                console.error('No data received or data is null/undefined');
                return;
            }
            console.log('Received data:', data);
         
            while (true) {
                for (const element of data) {
                    console.log(element[1]);
                    // Hier könntest du das Bild anzeigen

                    const img = document.createElement('img');
                    img.src = "/schemas/uploads/" + element[1];
                    img.className = "fullscreen";
                    img.alt = "Image";
                    document.body.innerHTML = ''; // Clear the body content
                    document.body.appendChild(img); // Add the new image to the body
                    await sleep(element[2]); // 5 Sekunden warten, bevor das nächste Bild angezeigt wird

                }
            }

        } catch (error) {
            console.error('Fetch failed:', error);
        }
    }
    timerRefresh(0.1);
    carousel(); // Initial call to set the first image

    function timerRefresh(time) {
        setTimeout(() => {
            location.reload();
        }, 1000 * 60 * time); // Alle 5 Minuten neu laden
    }
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