<?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/links.html'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/layout/header.php'; ?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/modal/hinzufuegen.html'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/modal/loeschen.html'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/database/deleteFileFolder.php'; ?>

<div class="container-fluid py-2 " style="max-height: 90vh; overflow-y: auto;">

    <div class="row">

        <?php include $_SERVER['DOCUMENT_ROOT'] . '/layout/sidebar.php'; ?>
        <div class="col-md-10 text-center">
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/layout/selectPanel.php'; ?>

            <div class="pt-3"></div>
            <div class="card">
                <div class="card-header text-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-cogs me-2"></i> Infoseite-Konfiguration
                    </h3>
                    <p class="mb-0 mt-2">Hier können die Infoseiten verwaltet werden</p>
                </div>
                <div class="card-body">
                    <div class="row d-flex justify-content-between">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-cog me-2"></i> Infoseite Eigenschaften</h6>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="card-body w-25">
                                        <div class="mb-3">
                                            <label for="websiteName" class="form-label">Infoseite Name: </label>
                                            <input type="text" class="form-control" id="websiteName" value="bitte Infoseite auswählen" readonly>
                                        </div>

                                        <div class="form-check mb-3">
                                         
                                            <input class="form-check-input" type="checkbox" id="checkA" name="checkA" onchange="CardObj.checkAktiv()">
                                            <label class="form-check-label" for="checkA">
                                                anzeigen
                                            </label>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="timerSelectRange" class="form-label">Anzeige-Dauer:</label>
                                            <select class="form-select form-control" id="timerSelectRange" onchange="CardObj.setTimerRange(this.value)">
                                                <option value="3000">3 Sekunden</option>
                                              
                                                <option value="5000">5 Sekunden</option>
                                               
                                                <option value="10000">10 Sekunden</option>
                                               
                                                <option value="15000">15 Sekunden</option>
                                              
                                                <option value="20000">20 Sekunden</option>
                                                
                                                <option value="25000">25 Sekunden</option>
                                                
                                                <option value="30000">30 Sekunden</option>
                                                <option value="45000">45 Sekunden</option>
                                                <option value="60000">1 Minute</option>
                                            </select>
                                        </div>

                                        <!-- <div class="form-group mb-2">
                                            <div class="d-flex align-items-center mt-4 p-2 justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <label for="selectSekunden" class="me-2">Sekunden:</label>
                                                    <input type="text" id="selectSekunden" class="form-control" maxlength="2" style="width: 50px;">
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <label for="selectMinuten" class="me-2">Minuten:</label>
                                                    <input type="text" id="selectMinuten" class="form-control" maxlength="2" style="width: 50px;">
                                                </div>
                                            
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="card-body w-25">
                                        <div class="mb-2">
                                            <label class="form-label fw-bold">Zeit-Konfigurieren</label>
                                            <div class="btn-group w-100" role="group">
                                                <button class="btn btn-outline-primary" type="button" id="btnShowZeitraum" onclick="showDateTime('zeitspanne')">
                                                    <i class="bi bi-calendar-range me-1"></i> Datum & Uhrzeit
                                                </button>
                                                <button class="btn btn-outline-primary" type="button" id="btnShowUhrzeit" onclick="showDateTime('uhrzeit')">
                                                    <i class="bi bi-clock me-1"></i> Täglich
                                                </button>
                                            </div>
                                        </div>
                                        <div id="panelForDateTime">
                                            <div id="zeitspannePanel" class="border rounded-3 shadow-sm p-3 mb-3 bg-light" style="display:none;">
                                                <div class="row g-2">
                                                    <div class="col-6">
                                                        <label for="startDate" class="form-label small">Von Datum</label>
                                                        <input type="date" class="form-control form-control-sm" id="startDate" name="startDate">
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="endDate" class="form-label small">Bis Datum</label>
                                                        <input type="date" class="form-control form-control-sm" id="endDate" name="endDate">
                                                    </div>
                                                </div>
                                                <div class="row g-2 mt-1">
                                                    <div class="col-6">
                                                        <label for="startTimeDate" class="form-label small">Von Zeit</label>
                                                        <input type="time" class="form-control form-control-sm" id="startTimeDate" name="startTimeDate">
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="endTimeDate" class="form-label small">Bis Zeit</label>
                                                        <input type="time" class="form-control form-control-sm" id="endTimeDate" name="endTimeDate">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 text-end mt-2">
                                                        <button id="btnDelDateTime" class="btn btn-outline-danger btn-sm px-3" onclick="CardObj.deleteDateTimeRange(CardObj.selectedID)">
                                                            <i class="fas fa-trash-alt"></i> Zeitspanne löschen
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="uhrzeitPanel" class="border rounded-3 shadow-sm p-3 bg-light" style="display:none;">
                                                <div class="row g-2">
                                                    <div class="col-6">
                                                        <label for="startTimeRange" class="form-label small">Von Zeit</label>
                                                        <input type="time" class="form-control form-control-sm" id="startTimeRange" name="startTimeRange">
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="endTimeRange" class="form-label small">Bis Zeit</label>
                                                        <input type="time" class="form-control form-control-sm" id="endTimeRange" name="endTimeRange">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 text-end mt-2">
                                                        <button id="delTimeRange" class="btn btn-outline-danger btn-sm px-3" onclick="CardObj.removeTimeRange(CardObj.selectedID)">
                                                            <i class="fas fa-trash-alt"></i> Uhrzeit löschen
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12 d-flex justify-content-center">
                                        <button id="btn_save_changes" type="button" onclick="CardObj.saveChanges()" class="btn btn-success shadow-sm w-75">
                                            <i class="fas fa-save"></i> Speichern
                                        </button>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="col-md-3">

                            <div class="card h-35">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-desktop me-2"></i> Infoseite öffnen(Testanzeige)</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="infotherminalSelect" class="form-label">Infoterminal wählen:</label>
                                        <select class="form-select" id="infotherminalSelect">
                                            <option value="">-- Bitte wählen --</option>
                                        </select>
                                    </div>
                                    <button id="openTerminalBtn" class="btn btn-primary w-100">
                                        <i class="fas fa-external-link-alt me-1"></i> Anzeige öffnen
                                    </button>
                                </div>
                            </div>


                        </div>

                        <div class="col-md-3">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-network-wired me-2"></i> IP-Adressen Verwaltung</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex mb-3">
                                        <button id="btn_hinzufuegen" type="button" data-toggle="modal" data-target="#modal_hinzufuegen" class="btn btn-success btn-sm me-2">
                                            <i class="fas fa-plus"></i> Hinzufügen
                                        </button>
                                        <button id="btn_loeschen" type="button" data-toggle="modal" class="btn btn-danger btn-sm" data-target="#modal_loeschen">
                                            <i class="fas fa-trash"></i> Löschen
                                        </button>
                                    </div>
                                    <div class="border rounded p-2" style="max-height: 200px; overflow-y: auto; overflow-x: hidden; border-radius: 8px;" id="anzeigebereichV">
                                        <!-- IP Adressen werden hier angezeigt -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr />

        </div>

    </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/scripts.html'; ?>