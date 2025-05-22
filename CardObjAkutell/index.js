/* 
    <!-- <select id="selectUmgebung" class="form-select" aria-label="Default select example"></select>
    <div class="d-flex">
        <button id="plusBtn" type="button" class="btn btn-primary">Create</button>
        <div id="counter">0</div>
        <button id="minusBtn" type="button" class="btn btn-light">Select</button>
        <button id="deleteBtnForCards" type="button" class="btn btn-danger d-none">delete</button>
        <button id="saveBtn" type="button" class="btn btn-success d-block">save</button>
    </div>
    <h2 id="titelUmgebung"></h2>
    <div class="container d-flex" id="umgebungsContainer">
        <div id="rowForCards" class="col-4 p-2">

        </div>
    </div>  */


   // var selectUmgebung = document.getElementById("selectUmgebung");
    // const deleteBtnForCards = document.getElementById("deleteBtnForCards");
    // const UmgebungsTitel = document.getElementById("titelUmgebung")
    // // const ersteAuswahl = selectUmgebung.querySelector('option');
    // const denied = document.getElementById("umgebungsContainer");
    // var cardAnzeige = document.getElementById("rowForCards")
    // const plusBtn = document.getElementById("plusBtn");
    // const minusBtn = document.getElementById("minusBtn");
    // let counter = document.getElementById("counter");
  
  
  
  
  
    let cancelUplaod = false
    var zeitEingegeben = false
    let pushDelete = false
    let json;

   

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
            setUmgebung(Umgebung.umgebungsListe[2]);
            disableInput(denied)
            createCardObj();
            updateAlwaysOnButtons()


        })
        //testbereich

        // setTimeout(() => {
        //     console.log("Funktion wird nach window.onload ausgeführt");
        //     console.log(Umgebung.allCardsInOneList.length);
        //     createJsonFile(Umgebung.allCardsInOneList);
        //     console.log(Umgebung.allCardList);
        //     saveToLocalStorage("Umgebungen", Umgebung.umgebungsListe);
        //     const obj = getJsonData("test")
        //     obj.forEach(obj => {
        //         console.log(obj);
        //     });

        // }, 1000); // V

    }

    function createJsonObjForJsonFile() {
        let jsonObjUmgebung = []
        let jsonObjCardObj = []
        Umgebung.allCardsInOneList.forEach(cardObj => {
            var obj = {
                id: cardObj.id,
                titel: cardObj.zugeordnet,
                imagePath: cardObj.imagePath,
                selectedTime: cardObj.selectedTime,
                isTimeSet: cardObj.isTimeSet, //True or false
                imageSet: cardObj.imageSet, //True or false
                aktiv: cardObj.aktiv, //True or false
                startDateTime: cardObj.startDateTime,
                endDateTime: cardObj.endDateTime
            };
            jsonObj.push(obj)
        });

        Umgebung.umgebungsListe.forEach(umgebung => {
            var obj = {
                id: umgebung.id,
                titel: umgebung.titel,
                cardObjList: umgebung.cardObjList,
                listAnzeige: umgebung.listAnzeige
            };
            jsonObjUmgebung.push(obj)
        });


        return jsonObj
    }


    async function createJsonFile(jsonData) {
        if (jsonData.length === 0) {
            console.error("jsonData ist leer!");
            return;
        } else {
            const json = JSON.stringify(jsonData, null, 2);
            console.log(json);

        }
        try {
            const response = await fetch("json/sendToJson.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: json
            });
            const responseData = await response.json();
            console.log("JSON-Daten gespeichert:", responseData);
        } catch (error) {
            console.error("Fehler beim Speichern der JSON-Daten:", error);
        }
    }
    console.log(Umgebung.allCardsInOneList.length);

    function saveToLocalStorage(key, jsonData) {
        const jsonString = JSON.stringify(jsonData, null, 2); // Formatierung für bessere Lesbarkeit
        localStorage.setItem(key, jsonString);
    }

    function getJsonData(key) {
        const jsonData = localStorage.getItem(key);
        const obj = JSON.parse(jsonData);
        return obj
    }

    function createCardObj() {
        selectObj("database/selectCardObj.php").then(async (data) => {
            let objList = convertCardObjForDataBase(data)
            objList.forEach(obj => {
                console.log(obj.imagePath);
                Umgebung.umgebungsListe.forEach(umgebung => {
                    if (umgebung.titel == obj.titel) {
                        var cardObj = new CardObj(umgebung, obj.titel, obj.isTimeSet, obj.imagePath, obj.imageSet, obj.startDateTime, obj.endDateTime, obj.aktiv, obj.id);
                        new Beziehungen(umgebung, cardObj)
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
            const createJsObj = JSON.stringify(jsObj)
            console.log(jsObj);
            var result = await fetch("database/update.php", {
                method: "POST",
                body: createJsObj
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
    async function deleteCardObjDataBase(cardObjId) {
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

    function setUmgebung(umgebung) {
        console.log("umgebunng wurde auf: " + umgebung.titel + " gesetzt");
        selectUmgebung.value = umgebung.id;
        selectedUmgebung = umgebung;
        zeigeUmgebungAn(umgebung)
        updateAnzeigeCounter()
    }

    function disableInput(container) {
        if (selectUmgebung.value == 0) {
            console.log("readonly wurde aufgerufen");
            container.style.pointerEvents = "none"; // Deaktiviert alle Interaktionen
            container.style.opacity = "0.7"; // Optional: Reduziert die Sichtbarkeit
        } else {
            console.log("readonly wurde deaktiviert");
            container.style.pointerEvents = "auto"; // Aktiviert alle Interaktionen
            container.style.opacity = "1"; // Optional: Setzt die Sichtbarkeit zurück
        }
    }

    // plusBtn.addEventListener("click", function() {
    //     let currentCounter = parseInt(counter.innerHTML);
    //     if (currentCounter < 5) {
    //         if (checkSelectedUmgebung()) {
    //             console.log(selectedUmgebung);
    //             console.log(selectedUmgebung.titel);
    //             var newId = createID()
    //             const newCardObj = new CardObj(selectedUmgebung, selectedUmgebung.titel, false, "", false, "", "", true, newId);
    //             new Beziehungen(selectedUmgebung, newCardObj);
    //             selectedUmgebung.addCardObjs(newCardObj);
    //             console.log(selectedUmgebung);
    //             Umgebung.tempListForSaveCards.push(newCardObj);
    //             console.log(newCardObj);
                
    //             Beziehungen.beziehungsListe.forEach(beziehung => {
    //                 console.log(beziehung);
    //                 console.log("beziehung gefunden");
    //             });
    //             updateAnzeigeCounter()
    //         }
    //     } else {
    //         return
    //     }
    // });

    function createID() {
        const cardObjIDList = Umgebung.allCardsInOneList
            .map(cardObj => parseInt(cardObj.id)) // Konvertiere alle IDs in Zahlen
            .filter(id => !isNaN(id)); // Entferne ungültige Werte (NaN)
        console.log("Gefilterte ID-Liste:", cardObjIDList);
        console.log(cardObjIDList)
        if (cardObjIDList.length === 0) {
            console.error("Die Liste ist leer. Es gibt keine gültigen IDs.");
            return 1; // Standardwert, falls keine IDs vorhanden sind
        }
        const groessteZahl = Math.max(...cardObjIDList);
        return groessteZahl + 1;
    }

    // selectUmgebung.addEventListener("change", function() {
    //     selectedUmgebung = sucheUmgebung(selectUmgebung.value);
    //     console.log(selectedUmgebung);
    //     plusBtn.disabled = false;
    //     updateAnzeigeCounter()
    //     console.log("wächsle umgebung");
    //     UmgebungsTitel.innerHTML = selectedUmgebung.titel;

    //     if (selectedUmgebung.id == 0) {
    //         showAllUmgebungen()
    //         disableInput(denied)
    //     } else {
    //         zeigeUmgebungAn(selectedUmgebung)
    //         disableInput(denied)
    //     }
    // })

    function cardSwitch(idBtn) {
        console.log(idBtn);
        const cardId = idBtn.replace('alwaysOnBtn', ''); // Extrahiere die ID
        const cardObj = Umgebung.findObj(cardId); // Finde das entsprechende Objekt
        const checkbox = document.getElementById(idBtn);

        // Überprüfen, ob das CardObj gefunden wurde
        if (!cardObj) {
            console.error(`CardObj mit ID ${cardId} nicht gefunden.`);
            return;
        }

        const calenderBtn = document.querySelector(`#${cardObj.openModalButtonId}`); // Hole den Kalender-Button

        // Umschalten des Aktiv-Status basierend auf dem aktuellen Checkbox-Status
        if (cardObj.imageSet == true) {
            // Checkbox wurde aktiviert
            calenderBtn.disabled = false;

            cardObj.update = true; // Update-Flag setzen
            console.log(`CardObj aktiviert. Counter: ${counter}`);
        }

        if (cardObj.aktiv == true) {
            // Checkbox wurde deaktiviert
            cardObj.update = true; // Update-Flag setzen
            cardObj.aktiv = false; // Deaktivieren
            console.log("aktiv?: " + cardObj.aktiv);
            console.log("kalenderBtn: " + calenderBtn);
            selectedUmgebung.removeObjFromList(selectedUmgebung.listAnzeige, cardObj); // Aus der Anzeige entfernen
            console.log(`CardObj deaktiviert. Counter: ${counter}`);
        } else {
            cardObj.aktiv = true; // Aktivieren
            calenderBtn.disabled = true; // Deaktivieren des Kalenders
        }

        // Debugging: Zeige den aktuellen Status von cardObj.aktiv
        console.log(`Aktueller Status von cardObj.aktiv: ${cardObj.aktiv}`);
    }

    function updateAlwaysOnButtons() {
        console.log("updateAlwaysOnButtons wurde aufgerufen");

        // Hole alle Elemente mit einer ID, die mit "alwaysOnBtn" beginnt
        const alwaysOnButtons = document.querySelectorAll('[id^="alwaysOnBtn"]');
        alwaysOnButtons.forEach(button => {
            // Hole die ID des Buttons
            const id = button.id.replace('alwaysOnBtn', ''); // Extrahiere die ID
            const cardObj = Umgebung.findObj(id); // Finde das entsprechende Objekt
            console.log(`ID: ${id}, cardObj:`, cardObj); // Debugging-Ausgabe


            if (cardObj && cardObj.aktiv === true) {
                button.checked = true; // Setze die Checkbox auf true
                console.log(`Checkbox für alwaysOnBtn${id} wurde aktiviert.`);
            } else {
                button.checked = false; // Setze die Checkbox auf false
                console.log(`Checkbox für alwaysOnBtn${id} wurde deaktiviert.`);
            }
        });
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
            console.log(cardObj.imagePath);

        });
        Umgebung.tempListForSaveCards = []
    }

    function updateAnzeigeCounter() {
        if (checkSelectedUmgebung()) {
            var currentlength = selectedUmgebung.lengthListCardObj();
            console.log("aktuelle länge: " + currentlength);
            counter.innerHTML = currentlength;
        }
    }

    minusBtn.addEventListener("click", function() {
        console.log("minus");
        checkBoxShow();
    });

    function checkSelectedUmgebung() {
        if (!selectedUmgebung || selectedUmgebung === "undefined") {
            console.error("Keine Umgebung ausgewählt!");
            return false; // Gibt false zurück, um anzuzeigen, dass die Umgebung nicht definiert ist
        }
        return true; // Gibt true zurück, wenn `selectedUmgebung` definiert ist
    }

    function zeigeUmgebungAn(selectedUmgebung) {
        console.log(selectedUmgebung.id);
        Umgebung.umgebungsListe.forEach(umgebung => {
            if (umgebung.id == selectedUmgebung.id) {
                document.getElementById("umgebungsBody" + umgebung.id).style.display = "block";
            } else {
                document.getElementById("umgebungsBody" + umgebung.id).style.display = "none";
            }
        });
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

    function updateCounter() {
        var currentlength = lengthListUmgebung();
        console.log(currentlength);
        counter.innerHTML = currentlength;
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
            deleteCardObjDataBase(cardObj.id)
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
        return path
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

    // let changesMade = false;
    // document.addEventListener("input", function() {
    //     changesMade = true;
    // });

    // window.addEventListener("beforeunload", function(event) {
    //     if (changesMade) {
    //         const message = "Sind Sie sicher, dass Sie die Seite verlassen möchten? Nicht gespeicherte Änderungen gehen verloren.";

    //         event.preventDefault();
    //         event.returnValue = message;
    //         return message;
    //     }
    // });

    //Ab hie geht es mit dem CardObj ansich weiter
    function setupImagePicker(previewId, modalImageId, inputId, formID) {
        var modalImage = document.getElementById(modalImageId); // Modal for image preview
        var imageInput = document.getElementById(inputId); // File input
        var imagePreview = document.getElementById(previewId); // Image preview container
        const form = document.getElementById(formID);
        console.log("DSAGFDAGFDGGFDAGDAGDAFG");

        // Find object and set initial state if required
        var aktuellesObj = Umgebung.findObj(inputId);
        console.log(aktuellesObj);
        
        console.log("imagePath ist leer");
        if (aktuellesObj.imagePath == "") {
            imageInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        modalImage.innerHTML = `<img src="${e.target.result}" alt="Bild" class="img-fluid">`;
                        imagePreview.innerHTML = `<img src="${e.target.result}" alt="Bild" class="img-fluid">`;
                        aktuellesObj.imagePath = file.name;
                        console.log(aktuellesObj.imagePath);
                    };
                    reader.readAsDataURL(file);
                } else {
                    modalImage.innerHTML = ``;
                    imagePreview.innerHTML = `Bild auswählen oder hierher ziehen`;
                }
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
                getImagePath(formID, aktuellesObj)
                this.value = '';
            })
        }

        // Drag and drop functionality 
        imagePreview.addEventListener('dragover', function(event) {
            event.preventDefault();
            imagePreview.classList.add('drag-over');
        });
        imagePreview.addEventListener('dragleave', function(event) {
            event.preventDefault();
            imagePreview.classList.remove('drag-over');
        });
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
            console.log(select);
            
            var infoBtn = document.getElementById("infoBtn" + aktuellesObj.id)
            var closeBtn = document.getElementById("closeBtn" + aktuellesObj.id)
            var selectedValue = $(select).val();
            console.log(selectedValue);
            var selectedValue = ""
            select.selectedIndex = -1;
            aktuellesObj.isTimeSet = false
            aktuellesObj.startDateTime = ``;
            aktuellesObj.endDateTime = ``;
            aktuellesObj.selectedTime = selectedValue
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
