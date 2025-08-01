<div class="container-fluid py-4 " style="max-height: 90vh; overflow-y: auto;">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-cogs me-2"></i> Schema Einstellungen
                    </h3>
                    <p class="mb-0 mt-2">Hier können die Schemas verwaltet werden</p>
                </div>
                <div class="card-body">
                    <div class="row d-flex justify-content-between">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-cog me-2"></i> Schema Eigenschaften</h6>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="card-body w-25">
                                        <div class="mb-3">
                                            <label for="websiteName" class="form-label">Webseite Name:</label>
                                            <input type="text" class="form-control" id="websiteName" value="Snapbar_Warm" readonly>
                                        </div>

                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="checkA" name="checkA" onchange="CardObj.checkAktiv()">
                                            <label class="form-check-label" for="checkA">
                                                Aktiv
                                            </label>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="timerSelectRange" class="form-label">Dauer:</label>
                                            <select class="form-select form-control" id="timerSelectRange" onchange="CardObj.setTimerRange(this.value)">
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
                                    </div>
                                    <div class="card-body w-25">
                                        <div class="mb-2">
                                            <label class="form-label fw-bold mb-2">Zeit-Einstellungen</label>
                                            <div class="btn-group w-100 mb-3" role="group">
                                                <button class="btn btn-outline-primary" type="button" id="btnShowZeitraum" onclick="showDateTime('zeitspanne')">
                                                    <i class="bi bi-calendar-range me-1"></i> Zeitspanne
                                                </button>
                                                <button class="btn btn-outline-primary" type="button" id="btnShowUhrzeit" onclick="showDateTime('uhrzeit')">
                                                    <i class="bi bi-clock me-1"></i> Uhrzeit
                                                </button>
                                            </div>
                                        </div>
                                        <div id="zeitspannePanel" class="border rounded-3 shadow-sm p-3 mb-3 bg-light" style="display:none;">
                                            <div class="row g-2">
                                                <div class="col-6">
                                                    <label for="startDate" class="form-label small">Startdatum</label>
                                                    <input type="date" class="form-control form-control-sm" id="startDate" name="startDate">
                                                </div>
                                                <div class="col-6">
                                                    <label for="endDate" class="form-label small">Enddatum</label>
                                                    <input type="date" class="form-control form-control-sm" id="endDate" name="endDate">
                                                </div>
                                            </div>
                                            <div class="row g-2 mt-1">
                                                <div class="col-6">
                                                    <label for="startTimeDate" class="form-label small">Startzeit</label>
                                                    <input type="time" class="form-control form-control-sm" id="startTimeDate" name="startTimeDate">
                                                </div>
                                                <div class="col-6">
                                                    <label for="endTimeDate" class="form-label small">Endzeit</label>
                                                    <input type="time" class="form-control form-control-sm" id="endTimeDate" name="endTimeDate">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 text-end mt-2">
                                                    <button id="delDateTimeRange" class="btn btn-outline-danger btn-sm px-3" onclick="CardObj.deleteDateTimeRange(CardObj.selectedID)">
                                                        <i class="fas fa-trash-alt"></i> Zeitspanne löschen
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="uhrzeitPanel" class="border rounded-3 shadow-sm p-3 bg-light" style="display:none;">
                                            <div class="row g-2">
                                                <div class="col-6">
                                                    <label for="startTimeRange" class="form-label small">Startzeit</label>
                                                    <input type="time" class="form-control form-control-sm" id="startTimeRange" name="startTimeRange">
                                                </div>
                                                <div class="col-6">
                                                    <label for="endTimeRange" class="form-label small">Endzeit</label>
                                                    <input type="time" class="form-control form-control-sm" id="endTimeRange" name="endTimeRange">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 text-end mt-2">
                                                    <button id="delTimeRange" class="btn btn-outline-danger btn-sm px-3" onclick="CardObj.deleteTimeRange(CardObj.selectedID)">
                                                        <i class="fas fa-trash-alt"></i> Uhrzeit löschen
                                                    </button>
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
                                    <h6 class="mb-0"><i class="fas fa-desktop me-2"></i> Infoterminal Anzeigen</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="infotherminalSelect" class="form-label">Infoterminal wählen:</label>
                                        <select class="form-select" id="infotherminalSelect">
                                            <option value="">-- Bitte wählen --</option>
                                        </select>
                                    </div>
                                    <button id="openTerminalBtn" class="btn btn-primary w-100" disabled>
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
        </div>
    </div>
</div>


<!--  -->
<script src="/html_Infoterminal/js/zeitPanel.js"></script>