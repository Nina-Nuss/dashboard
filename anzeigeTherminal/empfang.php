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
            <div id="">
                <div class="d-flex col-auto gap-4 w-100 justify-content-center align-items-center">
                    <img src="../images/1.jpg" alt="logo" class="imageContainer rounded">
                </div>
            </div>
        </div>
    </article>
    <footer class="pr-3">
        <?php include '..\liveTicker\liveTicker.php'; ?>
    </footer>
</body>
<script>
    async function carousel(){
        
    }

    setInterval(carousel, 5000);


</script>

</html>