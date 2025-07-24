


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
                                    <label for="websiteName" class="form-label">Webseite Name:</label>
                                    <input type="text" class="form-control" id="websiteName" value="Snapbar_Warm" readonly>
                                </div>
                                
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="checkA" name="checkA">
                                    <label class="form-check-label" for="checkA">
                                         Aktiv
                                    </label>
                                </div>
                                
                                <div class="form-group mb-3">
                                    <label for="timerSelectRange" class="form-label">Timer Bereich:</label>
                                    <select class="form-select form-control" id="timerSelectRange">
                                        <option value="3">1</option>
                                        <option value="4">2</option>
                                        <option value="5">3</option>
                                        <option value="6">4</option>
                                        <option value="7">5</option>
                                        <option value="8">6</option>
                                        <option value="9">7</option>
                                    </select>
                                </div>
                                
                                <button type="button" class="btn btn-primary shadow-sm">
                                    <i class="fas fa-plus"></i>  Neues Display
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
                                        <h6 class="mb-0">IP-Adressen Verwaltung</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex mb-3">
                                            <button type="button" data-toggle="modal" data-target="#modal_hinzufuegen" class="btn btn-success btn-sm me-2">
                                                <i class="fas fa-plus"></i> Hinzufügen
                                            </button>
                                            <button type="button" data-toggle="modal" class="btn btn-danger btn-sm" data-target="#modal_loeschen">
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


