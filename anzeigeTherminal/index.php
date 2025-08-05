<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Site</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/anzeige.css">
</head>
<style>
    html,
    body {
        height: 100%;
        margin: 0;
    }

    body {
        display: flex;
        flex-direction: column;
        height: 100vh; /* Höhe des Viewports */
    }

    main {

        display: flex;
        justify-content: center;
        align-items: center;
    }

    .iframe-container {
        width: 70vw;
        height: 100%;
        border: 1px solid black;
        box-sizing: border-box;
    }

    .iframe-container iframe {
        width: 100%;
        height: 100%;
        border: none;
        object-fit: cover;
        display: block;
    }
</style>
</head>

<body>
    <header class="pl-3">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/layout/header.php'; ?>
    </header>
    <main>
        <div class="iframe-container" id="container"></div>
    </main>
    <footer class="pr-3">
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/layout/footer.php'; ?>
    </footer>

    <script>
        const params = new URLSearchParams(window.location.search);
        const ort = params.get('ip');
        console.log('IP-Adresse:', ort); // IP-Adresse aus der URL holen
        const foo = params.get('foo'); // weitere Variable aus der URL holen (optional)
        const container = document.getElementById('container');
        if (ort && container != null) {
            const iframe = document.createElement('iframe');
            // Variablen als Query-Parameter anhängen
            let data = `anzeige.php?ip=${encodeURIComponent(ort)}`;
            // Wenn du weitere Variablen hast, einfach anhängen:
            // data += `&foo=${encodeURIComponent(foo)}`;
            iframe.src = data;
            container.appendChild(iframe);
        } else {
            container.innerHTML = '<p class="text-danger">No IP address provided.</p>';
        }
    </script>

</html>