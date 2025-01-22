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
    body {
        display: flex;
        flex-direction: column;
        margin: 0;
        position: fixed;
        overflow: hidden; /* Verhindert Scrolling */  
    }

    .imageContainer {
        width: 1200px;      /* Feste Breite */
        height: 570px;     /* Feste Höhe */
        object-fit: contain; /* Behält Seitenverhältnis bei */
        display: block;
        margin: 0 auto;
        border: 1px solid #ddd; 

    }

    .content {
        flex: 1 0 auto;
        display: flex;
        flex-direction: column;

    }

    header {
        width: 100%;
    }
    footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        background: white;
        padding: 10px 0;
    }

    @media (min-width: 1920px) {
        body {
            max-width: 1920px;
            margin: 0 auto;
        }
    }
</style>

<body>
    <header class="pl-3">
        <?php include '..\header\header.php'; ?>
    </header>
    <article class="content">
        <div class="d-flex row h-100 flex-column justify-content-center align-items-center">            
            <div class="d-flex col-auto gap-4 w-100 justify-content-center align-items-center">
                <img src="../images/1.jpg" alt="logo" class="imageContainer rounded">
            </div>
        </div>
    </article>
    <footer  class="pr-3">
        <?php include 'liveTicker.php'; ?>
    </footer>
</body>

</html>