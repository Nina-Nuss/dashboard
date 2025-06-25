<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Datepicker</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

    <script src="main.js"></script>
</head>

<body>
    <section class="col-sm-4">
        <div class="form-group" style="display: flex; justify-content: space-around; align-items: center;">
            <div>von</div>
            <div class='input-group mb-4 date' id='datetimepicker1'>
                <input type='text' class="form-control" id="form-control" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
        <div class="form-group" style="display: flex;  align-items: center; justify-content: space-around;">
            <div>bis</div>
            <div class='input-group date' id='datetimepicker2'>
                <input type='text' class="form-control" id="form-control2" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>
    </section>
    <form id="uploadForm" action="moveAndgetBildInfo.php" method="post" enctype="multipart/form-data">
        <input type="file" name="bild">
        <input type="submit" class="btn btn-light" onclick="takeDate(event, document.getElementById('form-control').value,document.getElementById('form-control2').value)">
    </form>

    <div id="inhalt"></div>
    <script type="text/javascript">
        $(function() {
            $('#datetimepicker1').datetimepicker(
             
            );
            $('#datetimepicker2').datetimepicker();
        });
    </script>
    <p>

</body>

</html>