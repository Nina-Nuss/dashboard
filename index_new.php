<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- bootstrap 5 | css | javascript -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css"
        integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"
        integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <!-- eigener css und javascript code -->
    <link rel="stylesheet" href="css/index_new.css">

    <script src="js/index_new.js"></script>
    <script src="js/itemsliderObj.js"></script>
    <script src="datetime picker\Datetimepicker-main\main.js"></script>
    <script src="datetime picker\Datetimepicker-main\style.css"></script>

</head>

<body >
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