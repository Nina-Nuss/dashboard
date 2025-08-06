<?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/links.html'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/layout/header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/scripts.html'; ?>





<body class="bg-light">
    <div class="container-fluid py-2">
        <div class="row ">
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/layout/sidebar.php'; ?>
            <div class="col-10 ">
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/layout/selectPanel.php'; ?>
                <div class="pt-3"></div>
                <div class="card  shadow-sm text-center ">
                    <div class="card-header bg-light text-dark border-bottom">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-layer-group me-2"></i> Infoseiten-Neuauflage/Löschen
                        </h3>
                        <p class="mb-0 mt-2">Hier können Sie neue Infoseiten erstellen und oder löschen</p>
                    </div>
                    <div class="card-body" style="max-height: calc(90vh - 120px); overflow-y: auto;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="fas fa-plus me-2"></i> Infoseiten NEU erstellen
                                        </h5>
                                    </div>
                                    <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                                        <form action="../php/movePic.php" method="post" enctype="multipart/form-data">
                                            <div>
                                                <div class="alert alert-info" role="alert">
                                                    <h6 class="alert-heading">
                                                        <i class="fas fa-info-circle me-2"></i> Wichtige Hinweise:
                                                    </h6>
                                                    <ul class="mb-0">
                                                        <li>Maximal 50 Infoseiten</li>
                                                        <li>Es sind jpg, png und gif Dateien erlaubt</li>
                                                    </ul>
                                                </div>


                                                <div class="form-group mb-3">
                                                    <label for="img" class="form-label">
                                                        <i class="fas fa-image me-2"></i> Bild auswählen
                                                    </label>
                                                    <input type="file" id="img" name="img" accept="image/*,video/*">
                                                    <img id="imgPreview" src="#" alt="Bildvorschau" style="display:none; max-width:100%; max-height:200px; margin-top:10px;">
                                                    <video id="videoPreview" controls muted style="display:none; max-width:100%; max-height:200px; margin-top:10px;">
                                                        <source src="#" type="video/mp4">
                                                        Ihr Browser unterstützt das Video-Element nicht.
                                                    </video>
                                                </div>


                                                <div class="form-group mb-3">
                                                    <label for="title" class="form-label">
                                                        <i class="fas fa-tag me-2"></i> Name:
                                                    </label>
                                                    <input type="text" class="form-control" id="title" name="title" placeholder="Schema Name eingeben">
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="description" class="form-label">
                                                        <i class="fas fa-align-left me-2"></i> Beschreibung:
                                                    </label>
                                                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Beschreibung eingeben"></textarea>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="selectedTime" class="form-label">
                                                        <i class="fas fa-clock me-2"></i> Anzeigedauer:
                                                    </label>
                                                    <select class="form-select" id="selectedTime" name="selectedTime">
                                                        <option value="3000">3 Sekunden</option>
                                                        <option value="4000">4 Sekunden</option>
                                                        <option value="5000">5 Sekunden</option>
                                                        <option value="6000">6 Sekunden</option>
                                                        <option value="7000">7 Sekunden</option>
                                                        <option value="8000">8 Sekunden</option>
                                                        <option value="9000">9 Sekunden</option>
                                                        <option value="10000">10 Sekunden</option>
                                                        <option value="11000">11 Sekunden</option>
                                                        <option value="12000">12 Sekunden</option>
                                                        <option value="13000">13 Sekunden</option>
                                                        <option value="14000">14 Sekunden</option>
                                                        <option value="15000">15 Sekunden</option>
                                                        <option value="16000">16 Sekunden</option>
                                                        <option value="17000">17 Sekunden</option>
                                                        <option value="18000">18 Sekunden</option>
                                                        <option value="19000">19 Sekunden</option>
                                                        <option value="20000">20 Sekunden</option>
                                                        <option value="21000">21 Sekunden</option>
                                                        <option value="22000">22 Sekunden</option>
                                                        <option value="23000">23 Sekunden</option>
                                                        <option value="24000">24 Sekunden</option>
                                                        <option value="25000">25 Sekunden</option>
                                                        <option value="26000">26 Sekunden</option>
                                                        <option value="27000">27 Sekunden</option>
                                                        <option value="28000">28 Sekunden</option>
                                                        <option value="29000">29 Sekunden</option>
                                                        <option value="30000">30 Sekunden</option>
                                                    </select>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="aktiv" class="form-label">
                                                        <i class="fas fa-toggle-on me-2"></i> Status:
                                                    </label>
                                                    <select class="form-select" id="aktiv" name="aktiv">
                                                        <option value="1">Aktiv</option>
                                                        <option value="0">Inaktiv</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-success shadow-sm" onclick="meow(event)">
                                                <i class="fas fa-plus me-2"></i> hinzufügen
                                            </button>

                                        </form>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="fas fa-trash me-2"></i> Infoseiten LÖSCHEN
                                        </h5>
                                    </div>
                                    <div class="card-body" id="cardBodyForDelSchema">
                                        <div class="form-group mb-3">
                                            <label for="schemaSelect" class="form-label">
                                                <div class="fas fa-list me-2"></div> Schema auswählen:
                                            </label>

                                        </div>

                                        <div style="max-height: 300px; overflow-y: auto;">
                                            <table class="table table-hover position-relative">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Titel</th>
                                                        <th>Beschreibung</th>
                                                        <th>Auswahl</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="deleteSchema">

                                                </tbody>
                                            </table>
                                        </div>

                                        <button type="button" class="btn btn-danger shadow-sm" id="deleteBtnForSchemas" onclick="CardObj.remove_generate()">
                                            <i class="fas fa-trash me-2"></i> löschen
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </bo>

    <script>

    </script>

    </html>