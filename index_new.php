<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- bootstrap 5 | css | javascript -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900">
    <!-- Google Material Symbols -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=close,date_range,info" />
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Date Range Picker CSS -->
    <link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font Awesome (optional) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Eigene Styles -->
    <link rel="stylesheet" href="CardObjAkutell/styles.css">
    <link rel="stylesheet" href="css/index_new.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Moment.js (inkl. Deutsch) -->
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/min/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/de.js"></script>
    <!-- Bootstrap 5 JS Bundle (inkl. Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Date Range Picker JS -->
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <!-- Eigene Skripte -->
    <script src="CardObjAkutell/convertDateTime.js"></script>
    <script src="CardObjAkutell/beziehung.js"></script>
    <script src="CardObjAkutell/umgebung.js"></script>
    <script src="CardObjAkutell/cardObj.js"></script>
    <script src="CardObjAkutell/test.js"></script>
    <script src="CardObjAkutell/index.js"></script>
    <script src="js/index_new.js"></script>
    <script src="js/itemsliderObj.js"></script>
    <script src="js/datetimepicker.js"></script>
</head>

<body>

    <body>
        <?php include 'header/header.php'; ?>
        <div id="content">
            <div class="container-fluid">
                <div class="row ">
                    <div class="bearbeiten col-md-2 text-center ">
                        <p style="font-size: 3vh; font-weight: bold; margin-bottom: 1vh;">Bearbeiten</p>
                        <div id="dokumente">
                        </div>
                    </div>
                    <div class="col-md-10 text-center pt-2">
                        <div class="col-md-12 mx-auto pl-auto bg-gray-100 ">
                            <div class="d-flex justify-content-center" style="margin-right: 10vh;">
                                <button type="button" class="btn  text-dark start-btn  pt-0"
                                    style="background-color: rgba(255, 255, 255, 0.952); border-color: #006c99;">Infoterminal</button>
                                <button type="button" class="btn  text-dark  start-btn" style="border-color: #006c99;"
                                    style="background-color: rgba(255, 255, 255, 0.952);">Templates</button>
                                <button type="button" class="btn   text-dark start-btn" style="border-color: #006c99;"
                                    style="background-color: rgba(255, 255, 255, 0.952);">Administation</button>
                                <button type="button" class="btn   text-dark start-btn" style="border-color: #006c99;"
                                    style="background-color: rgba(255, 255, 255, 0.952);">Video</button>
                            </div>
                        </div>

                        <div class="col-md-12  mx-auto pl-auto bg-gray-100 pt-2">
                            <div class="d-flex justify-content-center" style="margin-left: 10vh;">
                                <button type="button" class="materialDesigne shadow-sm btn btn-primary"><span
                                        class="material-symbols-outlined">
                                        add
                                    </span></button>
                                <button type="button" class="materialDesigne shadow-sm save btn btn-success"><span
                                        class="material-symbols-outlined">
                                        save
                                    </span></button>
                                <button type="button" class="materialDesigne shadow-sm btn btn-danger"><span
                                        class="material-symbols-outlined">
                                        delete
                                    </span></button>
                                <button type="button" class="materialDesigne shadow-sm btn btn-dark"><span
                                        class="material-symbols-outlined">
                                        close
                                    </span></button>
                            </div>
                        </div>
                        <div class="col-md-11 pt-3 d-flex align-items-center justify-content-center position-relative">

                            <div class=" col-md-4 container-fluid position-relative ">
                                Webseite name: <span style="font-weight: bold;">Snapbar_Warm</span><br>
                                <input type="checkbox" name="checkA">
                                <label style="margin-right: 2vh;" for="checkA">Aktiv</label>
                                <span name="anzeige" class="">Anzeigedauer sek:</span>
                                <label for="anzeige" value="15">15</label>
                                <button type="button"
                                    class="btn shadow-sm btn-light w-50">neues Display</button>
                            </div>
                            <div style="display:block" class="col-md-4">
                                <!-- Modal Error Log -->
                                <!-- Modal Datum Von -->
                                <!-- Modal hinzufügen -->
                                <!-- Modal löschen -->
                                <?php include 'modal/loeschen.html'; ?>
                                <?php include 'modal/hinzufuegen.html'; ?>

                            </div>

                            <div id="IP_Adresse_main" class="border border-grey rounded ">
                                <div class=" d-block d-flex" id="IP_Adress">
                                    <div class="mr-2 mt-3" id="btnPosition">
                                        <button type="button" data-toggle="modal" data-target="#modal_hinzufuegen"
                                            id="btnDis" class="btn btn-light ml-0">
                                            <span class="material-symbols-outlined">
                                                add
                                            </span></button>
                                        </br>
                                        <button type="button" id="btnDis" data-toggle="modal" class="btn btn-light ml-0" data-target="#modal_loeschen">
                                            <span class="materialDesigne material-symbols-outlined">
                                                remove
                                            </span>
                                        </button>
                                    </div>
                                    <div class="container" style="max-height: 75px;overflow: auto;" id="anzeigebereichV">
                                        <!-- <div class="displayIp" id="anzeigebereichV"> -->
                                    </div>
                                </div>
                            </div>

                        </div>
                        <hr />
                    </div>
                </div>
            </div>
        </div>
        </div>
    </body>

</html>