


<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 pt-3">
            <div class="card">
                <div class="card-header">
                   <h3 class="card-title mb-0">
                            <i class="fas fa-cogs me-2"></i> Schema Einstellungen
                        </h3>
                        <p class="mb-0 mt-2">Hier können die Schemas verwaltet werden</p>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="websiteName" class="form-label"> Webseite Name:</label>
                                    <input type="text" class="form-control" id="websiteName" value="Snapbar_Warm" readonly>
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="checkA" name="checkA" onclick="CardObj.checkAktiv()">
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

                                <button id="btn_save_changes" type="button"  onclick="CardObj.saveChanges()" class="btn btn-success shadow-sm">
                                    <i class="fas fa-save"></i>  Save
                                </button>
                            </div>
                            <div class="col-md-4">
                                <!-- Modal Error Log -->
                                <!-- Modal Datum Von -->
                                <!-- Modal hinzufügen -->
                                <!-- Modal löschen -->
                            </div>
                            
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0"> IP-Adressen Verwaltung</h6>
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
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  -->


