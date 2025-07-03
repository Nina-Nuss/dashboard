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
    <form action="/schemas/movePic.php" id="form" method="post" enctype="multipart/form-data">
        <label for="img">Select image:</label>
        <input type="file" id="img" name="img" accept="image/*">
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