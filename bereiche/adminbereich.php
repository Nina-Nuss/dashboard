<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adminbereich - Infotherminal Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-light">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-light text-dark border-bottom">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-cogs me-2"></i>Adminbereich
                        </h3>
                        <p class="mb-0 mt-2">Hier können Sie neue Infotherminals hinzufügen oder löschen</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-success text-white">
                                        <h5 class="card-title mb-0">
                                            <i class="fas fa-plus me-2"></i>Infotherminals hinzufügen
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="alert alert-info" role="alert">
                                            <h6 class="alert-heading">
                                                <i class="fas fa-info-circle me-2"></i>Wichtige Hinweise:
                                            </h6>
                                            <ul class="mb-0">
                                                <li>IP-Adresse soll dem Format "192.168.1.100" entsprechen</li>
                                                <li>Es dürfen keine Leerzeichen vorhanden sein</li>
                                                <li>Sonderzeichen sind nicht erlaubt</li>
                                            </ul>
                                        </div>
                                        
                                        <form id="formID" action="/bereiche/bereitsVorhanden.php" method="post">
                                            <div class="form-group mb-3">
                                                <label for="infotherminalIp" class="form-label">
                                                    <i class="fas fa-network-wired me-2"></i>IP-Adresse:
                                                </label>
                                                <input class="form-control" type="text" id="infotherminalIp" 
                                                       name="infotherminalIp" placeholder="z.B. 192.168.1.100" required>
                                            </div>
                                            
                                            <div class="form-group mb-3">
                                                <label for="infotherminalName" class="form-label">
                                                    <i class="fas fa-tag me-2"></i>Name:
                                                </label>
                                                <input class="form-control" type="text" id="infotherminalName" 
                                                       name="infotherminalName" placeholder="z.B. Terminal Empfang" required>
                                            </div>
                                            
                                            <button type="submit" class="btn btn-success shadow-sm">
                                                <i class="fas fa-plus me-2"></i>Hinzufügen
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-header bg-danger text-white">
                                        <h5 class="card-title mb-0">
                                            <i class="fas fa-trash me-2"></i>Infotherminals löschen
                                        </h5>
                                    </div>
                                    <div class="card-body" >
                                        <div class="form-group mb-3">
                                            <label for="infotherminalSelect" class="form-label">
                                                <i class="fas fa-list me-2"></i>Infotherminal auswählen:
                                            </label>
                                            
                                        </div>
                                        
                                        <div class="border rounded p-3 mb-3" style="max-height: 200px; overflow-y: auto; overflow-x: hidden; border-radius: 8px;" id="deleteInfotherminal">
                                            <!-- Infotherminal-Liste wird hier dynamisch geladen -->
                                           
                                        </div>
                                        
                                        <button type="button" class="btn btn-danger shadow-sm" onclick="Umgebung.remove_generate()">
                                            <i class="fas fa-trash me-2"></i>Infotherminal löschen
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
</html>