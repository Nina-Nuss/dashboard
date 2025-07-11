<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include '../assets/links.html'; ?>
    <?php include '../assets/scripts.html'; ?>
    <!-- weitere benötigte Skripte hier einfügen -->
</head>
<body>
    <div id="cardContainer" class="container">
        <!-- Hier werden die Cards dynamisch eingefügt -->
        <!-- Beispiel-CardObj wird hier erstellt und angezeigt -->
        
    </div>
    
</body>
<script>
    // Beispiel-CardObj mit allen Parametern
    const test = new CardObj(
        1,                // id
        "",       // imagePath
        "3000",           // selectedTime
        "1",              // aktiv
        "08:00",          // startTime
        "10:00",          // endTime
        "2024-06-01",     // startDate
        "2024-06-30",     // endDate
        "Beispiel-Titel", // titel
        "Beschreibung"    // beschreibung
    )
    const test2 = new CardObj(
        2,                // id
        "",       // imagePath
        "3000",           // selectedTime
        "1",              // aktiv
        "08:00",          // startTime
        "10:00",          // endTime
        "2024-06-01",     // startDate
        "2024-06-30",     // endDate
        "Beispiel-Titel", // titel
        "Beschreibung"    // beschreibung
    )
    test.htmlKonstruktObjBody("cardContainer");
    test2.htmlKonstruktObjBody("cardContainer");
    
</script>
</html>