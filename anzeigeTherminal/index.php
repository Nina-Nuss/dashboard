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
        padding: 0;
    }

    body {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .iframe-container {
        display: flex;
        align-items: center;
        justify-content: center;

    }

    iframe {
        width: 700px;
        height: 600px;
        border: none;
        display: block;
        object-fit: contain;
    }
</style>
</head>

<script>


</script>
<body>
    <header class="pl-3">
        <?php include '..\header\header.php'; ?>
    </header>

    <container class="iframe-container" id="container">


    </container>

    <footer class="pr-3">
        <?php include '..\liveTicker\liveTicker.php'; ?>
    </footer>
</body>
<script>
    const params = new URLSearchParams(window.location.search);

    async function getImagePath(){
        const jsonlist = await fetch("/cardObjNew/database/selectCardObj.php")
            .then(response => response.json())
            .then(data => {
              
                const jslist = {
                    id: item[0],
                    imagePath: data[1],
                    selectedTime: data[2],
                    isImageSet: data[3],
                    isAktiv: data[4],
                    startDateTime: data[5],
                    endDateTime: data[6],
                    infotherminal_id: data[7]
                };
                return jslist;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }


    const ip = params.get('ip');
    var list = getImagePath()
    console.log('Image Path List:', list);
    
    console.log('IP:', ip);
    const container = document.getElementById('container');
    if (ip && container != null) {
        const iframe = document.createElement('iframe');
        var datai = `${ip}.php`;
        iframe.src = `${datai}`;
        console.log('Iframe source:', iframe.src);
        console.log();
        
        container.appendChild(iframe);

    } else {
        container.innerHTML = '<p class="text-danger">No IP address provided.</p>';
    }
</script>
</html>