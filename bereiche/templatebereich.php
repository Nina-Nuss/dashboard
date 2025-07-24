<body class="bg-light">
    <div class="container-fluid py-4" style="max-height: 90vh; overflow-y: auto;">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-light text-dark border-bottom">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-layer-group me-2"></i> Templatebereich
                        </h3>
                        <p class="mb-0 mt-2">Hier können Sie neue Schemas erstellen und verwalten</p>
                    </div>
                    <div class="card-body" style="max-height: calc(90vh - 120px); overflow-y: auto;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="fas fa-plus me-2"></i> Schemas erstellen
                                        </h5>
                                    </div>
                                    <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                                        <form action="/schemas/movePic.php">
                                            <div class="form-group mb-3">
                                                <label for="img" class="form-label">
                                                    <i class="fas fa-image me-2"></i> Bild auswählen
                                                </label>
                                                <input type="file"  id="img" name="img" accept="image/*">
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
                                                    <option value="7000">7 Sekunden</option>
                                                    <option value="10000">10 Sekunden</option>
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

                                            <button type="submit" class="btn btn-success shadow-sm" onclick="meow(event)">
                                                <i class="fas fa-save me-2"></i> Schema erstellen
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="fas fa-trash me-2"></i> Schemas löschen
                                        </h5>
                                    </div>
                                    <div class="card-body" id="cardBodyForDelSchema" style="max-height: 400px; overflow-y: auto;">
                                        <div class="form-group mb-3">
                                            <label for="schemaSelect" class="form-label">
                                                <divlass="fas fa-list me-2"></i> Schema auswählen:
                                            </label>

                                        </div>

                                        <table class="table table-hover position-relative">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Titel</th>
                                                    <th>Beschreibung</th>
                                                    <th>Auswahl</th>
                                                </tr>
                                            </thead>
                                            <tbody id="deleteSchema" style="max-height: 300px; overflow-y: auto;">
        
                                            </tbody>
                                        </table>

                                        <button type="button" class="btn btn-danger shadow-sm" id="deleteBtnForSchemas" onclick="CardObj.remove_generate()">
                                            <i class="fas fa-trash me-2"></i> Schema löschen
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
</body>
<script>

</script>

</html>