<!DOCTYPE html>
<html lang="en">

<link>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Date Range Picker with Time</title>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Date Range Picker CSS -->
<link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<!-- jQuery, Momenhgt.js, Bootsmtrap JS, and Date Range Picker JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/min/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/de.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=close,date_range,info" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="convertDateTime.js"></script>
<link rel="stylesheet" href="styles.css">
<script src="umgebung.js"></script>
<script src="cardObj.js"></script>
</head>

<body>
    <!-- <div class="d-none">
        <button id="plusBtnU" type="button" class="btn btn-primary">Create</button>
        <div id="counterU">0</div>
        <button id="minusBtnU" type="button" class="btn btn-light">Select</button>
        <button id="deleteBtnForCardsU" type="button" class="btn btn-danger d-none">-</button>
    </div>
     -->
    <select id="selectUmgebung" class="form-select" aria-label="Default select example"></select>
    <div class="d-flex">
        <button id="plusBtn" type="button" class="btn btn-primary">Create</button>
        <div id="counter">0</div>
        <button id="minusBtn" type="button" class="btn btn-light">Select</button>
        <button id="deleteBtnForCards" type="button" class="btn btn-danger d-none">delete</button>
        <button id="saveBtn" type="button" class="btn btn-success d-block">save</button>
    </div>
    <h2 id="titelUmgebung"></h2>
    <div class="container d-flex">
        <div id="rowForCards" class="col-4 p-2"><!-- bild Obj -->

        </div>
    </div>
</body>
<script>
    let cancelUplaod = false
    var zeitEingegeben = false
    let pushDelete = false
    let json;

    var cardAnzeige = document.getElementById("rowForCards")
    window.onload = function() {
        executeDeleteNull();
        const resultUmgebung = selectObj("database/selectUmgebung.php").then(async (data) => {
            var HauptUmgebungsObj = new Umgebung(0, 0, "Alle Schemas");

            data.forEach(umgebung => {
                console.log(umgebung);
                var umgebungObj = new Umgebung(umgebung[0], umgebung[2], umgebung[1]);
            })
            var selectedUmgebung = Umgebung.umgebungsListe[1];
        }).then(() => {
            ladenUmgebung();
            createCardObj();
        })
    }


    function updateObj(cardObj) {
        let objSwitch = document.getElementById("alwaysOnBtn" + cardObj.id)
        let kindObj = objSwitch.children[0]
        if (cardObj.aktiv == true) {
            kindObj.checked = true
        } else {
            kindObj.checked = false
            console.log("false")
            console.log(objSwitch);
        }
        let imageContainer = document.getElementById("imagePreview" + cardObj.id)
        console.log(imageContainer);
        if (cardObj.imagePath == "") {
            console.log("imageContainer ist null")
            return
        }
        const imgElement = document.createElement("img");
        imgElement.classList.add("picInCard")
        imgElement.style.width = "110%";

        imgElement.src = cardObj.imagePath;
        imageContainer.appendChild(imgElement);

        // kindObjImage = cardObj.imagePath


    }

    function createCardObj() {
        selectObj("database/selectCardObj.php").then(async (data) => {
            let objList = convertCardObjForDataBase(data)
            console.log(objList)
            objList.forEach(obj => {
                Umgebung.umgebungsListe.forEach(umgebung => {
                    if (umgebung.titel == obj.titel) {
                        var cardObj = new CardObj(umgebung, obj.titel, obj.isTimeSet, obj.imagePath, obj.imageSet, obj.startDateTime, obj.endDateTime, obj.aktiv, obj.id);
                        umgebung.cardCounter = umgebung.cardCounter + 1
                        cardObj.initializeDateRangePicker()
                        updateObj(cardObj)
                    }
                })
            });
        })
    }

    function convertCardObjForDataBase(cardObjListe) {
        objListe = []
        cardObjListe.forEach(cardObj => {
            var obj = {
                id: cardObj[0],
                titel: cardObj[1],
                imagePath: cardObj[2],
                selectedTime: cardObj[3],
                isTimeSet: cardObj[4], //True or false
                imageSet: cardObj[5], //True or false
                aktiv: cardObj[6], //True or false
                startDateTime: cardObj[7],
                endDateTime: cardObj[8]
            };


            objListe.push(obj)
        });
        return objListe
    }
    async function updateDataBase(cardObj) {
        // Erstellen eines FormData-Objekts
        try {
            console.log("updateDataBase wurde aufgerufen");
            const jsObj = JavaScriptCardObj(cardObj);
            console.log(jsObj);
            var result = await fetch("database/update.php", {
                method: "POST",
                body: JSON.stringify(jsObj)
            });
            const responseText = await result.text();
            console.log("Antwort vom Server:", responseText);
        } catch (error) {
            console.error("Fehler in updateDataBase:", error);
        }
    }
    async function executeDeleteNull() {
        try {
            const response = await fetch("database/deleteNull.php", {
                method: "GET"
            });

            if (!response.ok) {
                throw new Error(`Fehler beim Ausführen der Anfrage: ${response.statusText}`);
            }

            const data = await response.json();
            console.log("Erfolgreich ausgeführt:", data);
        } catch (error) {
            console.error("Fehler:", error);
        }
    }
    async function deleteCardObj(cardObjId) {
        try {
            const response = await fetch("database/deleteCardObj.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    id: cardObjId
                })
            });
            if (!response.ok) {
                throw new Error(`Fehler beim Löschen: ${response.statusText}`);
            }
            const result = await response.text();
            console.log(result);
        } catch (error) {
            console.error("Fehler:", error);
        }
    }
    // Aufruf der Funktion
    function prepareCardObj(cardObj) {
        var prepare =
            "&titel=" + cardObj.zugeordnet +
            "&isTimeSet=" + cardObj.isTimeSet +
            "&imagePath=" + cardObj.imagePath +
            "&imageSet=" + cardObj.imageSet +
            "&startDateTime=" + cardObj.startDateTime +
            "&endDateTime=" + cardObj.endDateTime +
            "&aktiv=" + cardObj.aktiv +
            "&selectedTime=" + cardObj.selectedTime +
            "&id=" + cardObj.id;

        return prepare
    }

    function JavaScriptCardObj(cardObj) {
        const jsonData = {
            titel: cardObj.zugeordnet,
            isTimeSet: cardObj.isTimeSet,
            imagePath: cardObj.imagePath,
            imageSet: cardObj.imageSet,
            startDateTime: cardObj.startDateTime,
            endDateTime: cardObj.endDateTime,
            aktiv: cardObj.aktiv,
            selectedTime: cardObj.selectedTime,
            id: cardObj.id // Hinzufügen des fehlenden Schlüssels
        };
        return jsonData
    }
    async function selectObj(select) {
        try {
            const response = await fetch(select, { // .php Extension hinzugefügt
                method: "GET",
                headers: {
                    "Content-Type": "application/json"
                }
            });
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        } catch (error) {
            console.error("Fehler beim Laden der Umgebung:", error);
            return null;
        }
    }

    function ladenUmgebung() {
        Umgebung.umgebungsListe.forEach(umgebung => {
            selectUmgebung.innerHTML += `<option value="${umgebung.id}">${umgebung.titel}</option>`;

        });


    };
    const plusBtn = document.getElementById("plusBtn");
    const minusBtn = document.getElementById("minusBtn");
    let counter = document.getElementById("counter");



    plusBtn.addEventListener("click", function() {
        let currentCounter = parseInt(counter.innerHTML);
        if (currentCounter < 5) {
            if (selectedUmgebung != "undefined") {
                console.log(selectedUmgebung);
                console.log(selectedUmgebung.titel);
                const newCardObj = new CardObj(selectedUmgebung, selectedUmgebung.titel, false, "", false, "", "", true, "");
                Umgebung.addCardObjs(newCardObj);

                Umgebung.tempListForSaveCards.push(newCardObj);
                console.log(newCardObj);
                newCardObj.initializeDateRangePicker()
                counter.innerHTML = currentCounter + 1;
            }
        } else {
            return
        }
    });
    var selectUmgebung = document.getElementById("selectUmgebung");
    const deleteBtnForCards = document.getElementById("deleteBtnForCards");
    const UmgebungsTitel = document.getElementById("titelUmgebung")
    const ersteAuswahl = selectUmgebung.querySelector('option');

    selectUmgebung.addEventListener("change", function() {
        selectedUmgebung = sucheUmgebung(selectUmgebung.value);
        console.log(selectedUmgebung);
        plusBtn.disabled = false;
        updateAnzeigeCounter()
        console.log("wächsle umgebung");
        UmgebungsTitel.innerHTML = selectedUmgebung.titel;

        if (selectedUmgebung.id == 0) {
            showAllUmgebungen()
        } else {
            zeigeUmgebungAn(selectedUmgebung)
        }
    })

    function cardSwitch(idBtn) {
        const cardId = idBtn.replace('alwaysOnBtn', ''); // Extrahiere die ID
        const cardObj = Umgebung.findObj(cardId); // Finde das entsprechende Objekt
        const calenderBtn = document.querySelector(`#${cardObj.openModalButtonId}`); // Hole den Kalender-Button
        if (!cardObj) {
            console.error(`CardObj mit ID ${cardId} nicht gefunden.`);
            return;
        }
        // Umschalten des Aktiv-Status
        if (cardObj.aktiv === false) {
            calenderBtn.disabled = false; // Kalender-Button aktivieren
            cardObj.aktiv = true; // Aktiv setzen
            cardObj.update = true; // Update-Flag setzen
            cardId.checked = true;
            counter += 1; // Counter erhöhen
            console.log(`CardObj aktiviert. Counter: ${counter}`);
        } else {
            cardId.checked = false;
            cardObj.update = true; // Update-Flag setzen
            cardObj.aktiv = false; // Deaktivieren
            counter -= 1; // Counter verringern
            calenderBtn.disabled = true; // Kalender-Button deaktivieren
            selectedUmgebung.removeObjFromList(selectedUmgebung.listAnzeige, cardObj); // Aus der Anzeige entfernen
            console.log(`CardObj deaktiviert. Counter: ${counter}`);
        }

        // Debugging: Zeige den aktuellen Status von cardObj.aktiv
        console.log(`Aktueller Status von cardObj.aktiv: ${cardObj.aktiv}`);
    }

    document.getElementById("saveBtn").addEventListener("click", function() {
        alert("Daten werden gespeichert")
        saveTempAddDatabase()
        Umgebung.allCardList.forEach(cardObjlist => {
            cardObjlist.forEach(cardObj => {
                console.log(cardObj);
                if (cardObj.update == true) {
                    console.log(cardObj.update);
                    cardObj.update = false
                    updateDataBase(cardObj)
                }
            });
        });
    });

    function saveTempAddDatabase() {
        Umgebung.tempListForSaveCards.forEach(cardObj => {
            console.log(cardObj);
            insertDatabase(cardObj)
        });
        Umgebung.tempListForSaveCards = []
    }

    function updateAnzeigeCounter() {
        var currentlength = lengthListCardObj(selectedUmgebung);
        console.log(currentlength);
        counter.innerHTML = currentlength;
    }

    minusBtn.addEventListener("click", function() {
        console.log("minus");
        if (selectedUmgebung != "") {
            checkBoxShow();
        }
    });

    function zeigeUmgebungAn(selectedUmgebung) {
        console.log(selectedUmgebung.id);
        Umgebung.umgebungsListe.forEach(umgebung => {
            if (umgebung.id == selectedUmgebung.id) {
                document.getElementById("umgebungsBody" + umgebung.id).style.display = "block";
            } else {
                document.getElementById("umgebungsBody" + umgebung.id).style.display = "none";
            }
        });
        // document.querySelectorAll('[id^="carousel"]').forEach(item => {
        //     let lastIndexUmgebung = item.id.replace('carousel', '');
        //     if (lastIndexUmgebung == selectedUmgebung.id) {
        //         console.log(lastIndexUmgebung);
        //         document.getElementById(item.id).style.display = "block";
        //     } else {
        //         document.getElementById(item.id).style.display = "none";
        //     }
        // });
    }

    function showAllUmgebungen() {
        document.querySelectorAll('[id^="umgebungsBody"]').forEach(item => {
            document.getElementById(item.id).style.display = "block";
        });
    }

    function checkBoxShow() {
        var formCheckboxes = document.querySelectorAll('.form-check-d');
        console.log("bin da");
        // Iteriere über alle Elemente und ändere ihre Klassen
        formCheckboxes.forEach(formCheckbox => {
            // Entferne die Klasse "d-none", falls vorhanden
            if (!formCheckbox.classList.contains('d-none')) {
                formCheckbox.classList.add('d-none');
                formCheckbox.classList.remove('d-block');
                deleteBtnForCards.classList.add('d-none');
                plusBtn.disabled = false;
            } else {
                formCheckbox.classList.add('d-block');
                formCheckbox.classList.remove('d-none');
                deleteBtnForCards.classList.remove('d-none');
                plusBtn.disabled = true;
            }
        });
        deleteBtn()
    }

    function deleteBtn() {
        const deleteBtns = document.querySelectorAll('.form-check-d input[type="checkbox"]');
        deleteBtns.forEach(deleteBtn => {
            deleteBtn.addEventListener('change', function() {
                const cardId = this.id.replace('deleteBtn', '');
                console.log(cardId);
                const cardObj = Umgebung.findObj(cardId);
                const element = document.getElementById(cardObj.id);
                if (this.checked) {
                    selectedUmgebung.tempListForDeleteCards.push(cardObj);
                    console.log("checkInn");
                    console.log(cardObj.id);

                } else {
                    selectedUmgebung.removeObjFromList(selectedUmgebung.tempListForDeleteCards, cardObj);
                    console.log("checkout");

                }
            });
        });
    }

    function saveCardObj() {
        umgebung.allCardList.forEach(cardObjlist => {
            cardObjlist.forEach(cardObj => {
                console.log(cardObj);
            });
        });
    }

    deleteBtnForCards.addEventListener('click', function() {
        if (selectedUmgebung.tempListForDeleteCards.length == 0) {
            alert("wähle ein Object aus")
            return
        }
        selectedUmgebung.tempListForDeleteCards.forEach(cardObj => {
            cardObj.removeHtmlElement();
            selectedUmgebung.removeObjFromList(selectedUmgebung.cardObjList, cardObj);
            selectedUmgebung.removeObjFromList(selectedUmgebung.listAnzeige, cardObj);
            deleteCardObj(cardObj.id)
        });

        selectedUmgebung.tempListForDeleteCards = [];
        checkBoxShow();
        updateAnzeigeCounter()

    });
    async function getImagePath(formID, ob) {
        const form = document.getElementById(formID);
        const formData = new FormData(form);
        const response = await fetch('test.php', {
            method: 'POST',
            body: formData,
        })
        var path = await response.text()
        ob.imagePath = path
    }

    async function insertDatabase(cardObj) {
        // Erstellen eines JSON-Objekts
        const jsonData = {
            titel: cardObj.zugeordnet,
            isTimeSet: cardObj.isTimeSet,
            imagePath: cardObj.imagePath,
            imageSet: cardObj.imageSet,
            startDateTime: cardObj.startDateTime,
            endDateTime: cardObj.endDateTime,
            aktiv: cardObj.aktiv,
            selectedTime: cardObj.selectedTime // Hinzufügen des fehlenden Schlüssels
        };
        console.log(JSON.stringify(jsonData));
        // Senden der POST-Anfrage mit JSON-Daten
        const response = await fetch("database/insert.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(jsonData)
        });
        if (!response.ok) {
            console.error("Fehler beim Einfügen:", response.statusText);
        } else {
            const result = await response.text();
            console.log(result);
        }
    }

    function sucheUmgebung(UmgebungsID) {
        let umgebung = Umgebung.umgebungsListe.find(umgebung => umgebung.id == UmgebungsID);
        return umgebung
    }

    function lengthListUmgebung() {
        var length = Umgebung.umgebungsIdList.length
        return length
    }

    function lengthListCardObj(umgebung) {
        var length = umgebung.cardObjList.length
        return length
    }

    //Ab hie geht es mit dem CardObj ansich weiter
    function setupImagePicker(previewId, modalImageId, inputId, formID) {
        var lastFileName = null
        var modalImage = document.getElementById(modalImageId); // Modal for image preview
        var imageInput = document.getElementById(inputId); // File input
        var imagePreview = document.getElementById(previewId); // Image preview container

        // Find object and set initial state if required
        var aktuellesObj = Umgebung.findObj(inputId);

        if (aktuellesObj.imagePath == "") {
            imageInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (!file) {
                    return;
                }
                const fileType = file.type;
                // Validate file type (image or video)
                const image = fileType.startsWith('image/')
                const video = fileType.startsWith('video/')
                if (!image && !video) {
                    alert('Bitte wählen Sie ein unterstütztes Bild- oder Videoformat aus.');
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (image) {
                        // Image preview
                        imagePreview.innerHTML =
                            `<img src="${e.target.result}" class="picInCard" alt="Bildvorschau" style="width: 110%;">`;
                        modalImage.innerHTML =
                            `<img src="${e.target.result}" alt="Bildvorschau" style="width: 75%" border-radius: 5px;">`;
                    } else if (video) {
                        // Video preview
                        imagePreview.innerHTML = `
                        <video autoplay muted loop style="max-width: 100%; border-radius: 5px;">
                            <source src="${e.target.result}" type="${fileType}">
                            Ihr Browser unterstützt dieses Videoformat nicht.
                        </video>`;
                        modalImage.innerHTML = `
                        <video autoplay muted loop style="width: 80%; border-radius: 5px;">
                            <source src="${e.target.result}" type="${fileType}">
                            Ihr Browser unterstützt dieses Videoformat nicht.
                        </video>`;
                    }
                };
                reader.readAsDataURL(file);
                lastFileName = file.name;
                let selectedId = $(this).attr('id');
                let id = extractNumberFromString(selectedId)
                let closebtnID = '#closeBtn' + id
                $(closebtnID).css("display", "block")
                let meow = $('#timerSelect' + id).val()
                console.log(meow);
                $('#timerSelect' + id).prop('disabled', false);
                let isDisabled = $('#timerSelect' + id).prop('disabled');
                console.log('Ist das Element disabled?', isDisabled);
                console.log(isDisabled);
                aktuellesObj.imageSet = true;
                var alwaysOnBtn = 'alwaysOnBtn' + id
                var inputbtn = document.getElementById(alwaysOnBtn)
                console.log(formID, aktuellesObj);
                getImagePath(formID, aktuellesObj)
                this.value = '';
            })
        }
    }

    function deletePicture(imagePreview, modalImage) {
        var modalImage = document.getElementById(modalImage).id; // Modal for image preview
        var imagePreview = document.getElementById(imagePreview);
        var aktuellesObj = Umgebung.findObj(modalImage);
        console.log(aktuellesObj);
        if (aktuellesObj.imageSet == true) {
            modalImage.innerHTML = ``;
            imagePreview.innerHTML = `Bild auswählen oder hierher ziehen`;
            aktuellesObj.imagePath = ``;
            aktuellesObj.imageSet = false
            var select = document.getElementById("timerSelect" + aktuellesObj.id)
            var infoBtn = document.getElementById("infoBtn" + aktuellesObj.id)
            var closeBtn = document.getElementById("closeBtn" + aktuellesObj.id)
            var selectedValue = $(select).val();
            var selectedValue = ""
            select.selectedIndex = -1;
            aktuellesObj.isTimeSet = false
            aktuellesObj.startDateTime = ``;
            aktuellesObj.endDateTime = ``;
            aktuellesObj.selectedTime = selectedValue
            if (selectedUmgebung != "undefined") {
                selectedUmgebung.removeObjFromList(selectedUmgebung.cardObjList, aktuellesObj)
            }
            select.disabled = true
            $('#timerSelect' + aktuellesObj.id).val(3)
            infoBtn.style.display = "none"
            closeBtn.style.display = "none"
            let alwaysOnBtn = '#alwaysOnBtn' + aktuellesObj.id
            $(alwaysOnBtn).css("display", "block");
            alwaysOnBtn.disabled = true
        }
        return
    }
</script>

</html>