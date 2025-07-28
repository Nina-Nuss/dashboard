class CardObj {
    static idCounter = 0;
    static selectedID = null;
    static allCardObjekte = [];
    static temp_remove = [];
    static eleListe = []
    static list = [];
    static checkAllowed = false; // Variable to control checkbox behavior
    constructor(id, imagePath, selectedTime, aktiv, startTime, endTime, startDate, endDate, timeAktiv, dateAktiv, titel, beschreibung) {

        this.id = id;
        this.update = false;
        //AB hier kommt alles in die Datenbank rein:
        this.imagePath = imagePath //Der Pfad zum Bild
        this.startTime = startTime //Startzeit des Zeitplans
        this.endTime = endTime //Endzeit des Zeitplans
        this.startDate = startDate //Startdatum des Zeitplans
        this.endDate = endDate //Enddatum des Zeitplans
        this.selectedTime = selectedTime // Der aktuelle ausgewählte Wert
        this.timeAktiv = timeAktiv //True or false
        this.dateAktiv = dateAktiv //True or false
        this.aktiv = aktiv //true or false
        this.titel = titel //Der Titel des Objektes
        this.beschreibung = beschreibung //Die Beschreibung des Objektes
        //-------------------------------------

        //HTMLOBJEKTE-------------------------
        this.deleteBtn = `deleteBtn${this.id}`
        this.imagePreviewId = `imagePreview${this.id}`;
        this.imageInputId = `imageInput${this.id}`;
        this.modalImageId = `modalImageID${this.id}`;
        this.checkAktiv = `activCheck${this.id}`;
        this.timePlanCheckboxId = `timeCheck${this.id}`;
        this.openModalButtonId = `openModal${this.id}`;
        this.modalId = `myModal${this.id}`;
        this.dateRangeInputId = `daterange${this.id}`;
        this.dateRangeContainerId = `selected-daterange${this.id}`;
        this.infoBtn = `infoBtn${this.id}`;
        this.selectedTimerLabel = `selectedTime${this.id}`
        this.cardObjekte = `cardObjekt${this.id}`
        this.infoCard = `showDateInCard${this.id}`
        this.shownInCarousel = `showInCarousel${this.id}`;
        this.closeBtn = `closeBtn${this.id}`
        this.sumbitBtnID = `submit${this.id}`;
        this.formID = `formID${this.id}`
        this.checkSelect = `checkSelect${this.id}`

        //-------------------------------------    

        CardObj.list.push(this)

    }
    htmlBody(umgebung) {
        const body = `
            <div class="card-deck p-1 h-50">
                <div class="card" id="${this.cardObjekte}">
                    <div class="card-header p-1">
                        <small class="text-muted">Uhrzeit: ${this.startTime} - ${this.endTime}</small>
                    </div>
                    <img class="card-img-top" src="/schemas/uploads/${this.imagePath}" alt="Card image cap">
                    <div class="card-body p-2">
                        <h5 class="card-title m-0">${this.titel}</h5>
                        <p class="card-text m-0">${this.beschreibung}</p>
                        <div class="form-check">
                            <input class="form-check-input single-active-checkbox" type="checkbox" value="" id="flexCheck${this.id}"}>
                            <label class="form-check-label" name="label${this.id}" for="flexCheck${this.id}">
                                
                            </label>
                        </div>
                        <div>
                            <small id="${this.selectedTimerLabel}" class="text-muted">Dauer: ${this.selectedTime / 1000} sekunde</small>
                        </div>
                    </div>
                    
                </div>
            </div>
        `;
        document.getElementById(umgebung).innerHTML += body;

        // document.getElementById(this.checkAktiv).addEventListener("change", (event) => {
        //     this.aktiv = event.target.checked;
        // });

    }
    removeHtmlElement() {
        const element = document.getElementById(this.cardObjekte);
        if (element) {
            element.remove();
        }
    }
    checkboxAktiv() {
        const cbAktiv = document.querySelectorAll('[id^="cbAktiv"]')
        cbAktiv.forEach(cb => {
            cb.addEventListener("change", (event) => {
                this.aktiv = event.target.checked;
            });
        });
    }


    // zeigeCardObjInUmgebungAn(){
    //      document.getElementById("cardContainer").innerHTML = "";
    //     const selector = document.createElement("select");
    //     selector.id = "selectUmgebung";
    //     selector.className = "form-select";
    //     selector.innerHTML = `<option value="">Bitte wählen Sie eine Umgebung</option>`;
    //     Umgebung.list.forEach(umgebung => {
    //         selector.innerHTML += `<option value="${umgebung.id}">${umgebung.titel}</option>`;
    //     });
    //     selector.addEventListener("change", (event) => {
    //         const selectedId = event.target.value;
    //         Beziehungen.list.forEach(beziehung => {
    //             if (beziehung.cardObjektID == Umg.selectedID && beziehung.umgebungID == selectedId) {
    //                 // Hier kannst du die Logik hinzufügen, um die Beziehung anzuzeigen
    //                 console.log(`Beziehung gefunden: CardObjektID ${CardObj.selectedID}, UmgebungID ${selectedId}`);
    //             }
    //         });
    //     });
    //     document.getElementById("rowForCards").appendChild(selector);
    //     this.htmlBody("cardContainer");
    // }

    static event_remove(id) {
        var element = document.getElementById(`checkDelSchema${id}`);
        if (element.checked && !this.temp_remove.includes(id)) {
            this.list.forEach(checkID => {
                if (checkID.id == id) {
                    checkID.check = true
                    // console.log(checkID)
                }
            });
            this.temp_remove.push(id);
        }
        else {
            this.list.forEach(checkID => {
                if (checkID.id == id) {
                    checkID.check = false
                    // console.log(checkID)
                }
            });
            this.temp_remove.forEach(idd => {
                if (id != idd) {
                    this.eleListe.push(idd)
                }
            });
            this.temp_remove = this.eleListe
            this.eleListe = []
        }
        console.log(this.temp_remove);
    };
    static async remove_generate() {
        if (this.temp_remove.length == 0) {
            alert("Bitte wählen Sie mindestens ein Schema aus, um es zu löschen.");
            return;
        }
        
        // Bestätigungsdialog anzeigen
        const confirmed = confirm(`Sind Sie sicher, dass Sie ${this.temp_remove.length} Schema(s) löschen möchten? Diese Aktion kann nicht rückgängig gemacht werden.`);
        
        if (!confirmed) {
            console.log("Löschvorgang vom Benutzer abgebrochen");
            return; // Benutzer hat abgebrochen
        }
        
        await this.removeFromListLogik();
        await this.update();
    }

    static async removeFromListLogik() {
        // DIese Methode wird aufgerufen sobald wir auf Minus (-) klicken
        // Hier benötigen wir die Aktuellen IDS der Datenbank zum löschen
        console.log(this.list);

        // Warte auf alle Löschvorgänge bevor die Liste aktualisiert wird
        for (const id of this.temp_remove) {
            this.list = await this.removeFromListViaID(id, this.list);
        }
        this.temp_remove = []
        console.log(this.list);
    }

    static async removeFromListViaID(id, list) {
        var temp = [];
        console.log(list);

        for (const element of list) {
            if (element.id != id) {
                //ID muss aus Liste gelöscht werden
                temp.push(element);

            } else {
                await this.deleteCardObjDataBase(element.id);
                console.log("Das Element wurde gefunden und wird gelöscht! " + element.id);
                // Nicht sofort return, sondern weiter iterieren um alle anderen Elemente zu behalten
            }
        }
        return temp;
    }


    static async deleteCardObjDataBase(cardObjId) {
        try {
            // Erst ALLE Beziehungen für dieses Schema löschen
            const relationResponse = await fetch("database/delete_All_Relations_For_Schema.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    cardObjektID: cardObjId
                })
            });

            const relationResult = await relationResponse.text();
            console.log("Beziehungen gelöscht:", relationResult);

            // Dann das Schema löschen
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
            console.log("Schema gelöscht:", result);
        } catch (error) {
            console.error("Fehler:", error);
        }
    }

    static async update() {
        var delSchema = document.getElementById("deleteSchema")
        var cardContainer = document.getElementById("cardContainer");
        uncheckAllCheckboxes();
        if (delSchema != null) {
            console.log("bin in delschema drin");

            delSchema.innerHTML = "";
            cardContainer.innerHTML = "";
            this.list = [];
            this.temp_remove = [];
            // KEINE neuen Umgebung-Objekte hier erzeugen!
            const result = await readDatabase("selectSchemas");
            console.log("result: ", result);
            await result.forEach(listInfo => {
                // Nur hier neue Umgebung-Objekte erzeugen - alle Datenbankfelder verwenden
                new CardObj(
                    listInfo[0], // id
                    listInfo[1], // imagePath
                    listInfo[2], // selectedTime
                    listInfo[3], // isAktiv
                    listInfo[4], // startTime
                    listInfo[5], // endTime
                    listInfo[6], // startDate
                    listInfo[7], // endDate
                    listInfo[8], // startAktiv
                    listInfo[9], // endAktiv
                    listInfo[10], // titel
                    listInfo[11]  // beschreibung
                );
                delSchema.innerHTML += `<tr class="border-bottom">
                    <td class="p-2">${listInfo[0]}</td>
                    <td class="p-2">${listInfo[8]}</td>
                    <td class="p-2">${listInfo[9]}</td>
                    <td class="p-2 text-center"><input type="checkbox" name="${listInfo[0]}" id="checkDelSchema${listInfo[0]}" onchange="CardObj.event_remove(${listInfo[0]})"></td>
                </tr>`;
            });
        }
        createBodyCardObj();
        console.log(this.list);

    }

    static checkAktiv() {
        if (CardObj.selectedID !== null) {
            var checkA = document.getElementById("checkA");
            var obj = findObj(CardObj.list, CardObj.selectedID);
            if (checkA.checked && obj !== null) {
                console.log("Checkbox ist aktiviert");
                obj.aktiv = true;
                console.log("Checkbox aktiviert für CardObjektID:", obj.id);

            } else {
                if (obj === null) {
                    console.warn("Objekt nicht gefunden für ID:", CardObj.selectedID);
                    return;
                }
                obj.aktiv = false;
                console.log("Checkbox deaktiviert für CardObjektID:", obj.id);
            }
        }
    }
    static async saveChanges() {
        if (CardObj.selectedID === null) {
            alert("Bitte wählen Sie ein Schema aus, um Änderungen zu speichern.");
            return;
        }
        CardObj.checkAktiv();

        const obj = findObj(CardObj.list, CardObj.selectedID);

        if (obj === null) {
            console.warn("Objekt nicht gefunden für ID:", CardObj.selectedID);
            return;
        }
        try {
            var preCardObj = CardObj.prepareObjForUpdate(obj); // Bereite das Objekt für die Aktualisierung vor
            await updateDataBase(preCardObj, "updateSchema");
            alert("Änderungen erfolgreich gespeichert!");
            CardObj.loadChanges(obj); // Lade die Änderungen für das ausgewählte CardObj
        } catch (error) {
            console.error("Fehler beim Speichern der Änderungen:", error);
            alert("Fehler beim Speichern der Änderungen. Bitte versuchen Sie es erneut.");
        }
    }

    static prepareObjForUpdate(obj) {
        // Hier können Sie das Objekt in den Zustand für die Aktualisierung versetzen
        CardObj.checkAktiv()

        var timerSelect = document.getElementById("timerSelectRange");
        obj.selectedTime = timerSelect.value;

        var preObj = {
            id: obj.id,
            imagePath: obj.imagePath,
            selectedTime: obj.selectedTime,
            isAktiv: obj.aktiv,
            startTime: obj.startTime,
            endTime: obj.endTime,
            startDate: obj.startDate,
            endDate: obj.endDate,
            titel: obj.titel,
            beschreibung: obj.beschreibung
        }; // Erstellen Sie eine Kopie des Objekts
        preObj.update = true; // Setzen Sie das Update-Flag
        console.log("CardObjekt vorbereitet für Update:", preObj.id);
        return preObj;
    }

    static loadChanges(cardObj) {
        console.log("loadChanges aufgerufen für CardObjektID:", cardObj.id);
        var cardtimerLabel = document.getElementById(cardObj.selectedTimerLabel);
        var timerbereich = document.getElementById("timerSelectRange");
        var titel = document.getElementById("websiteName");
        var checkA = document.getElementById("checkA");

        checkA.checked = cardObj.aktiv; // Set the checkbox state
        titel.value = cardObj.titel; // Set the title to the checkbox's title
        timerbereich.value = cardObj.selectedTime; // Set the time range
        var selectedTime = cardObj.selectedTime / 1000; // Convert milliseconds to seconds
        cardtimerLabel.innerHTML = `Dauer: ${selectedTime} Sekunden`; // Update the label with the selected time

        checkA.checked = cardObj.aktiv; // Set the checkbox state

    }
    static setTimerRange(value) {
        console.log("Timer Range gesetzt auf:", value);
        var timerbereich = document.getElementById("timerSelectRange");
        if (timerbereich) {
            timerbereich.value = value; // Set the time range
        } else {
            console.error("Timer Select Range Element nicht gefunden");
        }
    }

}



window.addEventListener("load", function () {
    const templatebereich = document.getElementById("templateBereich");
    if (templatebereich !== null) {
        templatebereich.addEventListener("click", async function (event) {
            uncheckAllTableCheckboxes();
            deakCb(true);

            var settingPanel = document.getElementById("settingsPanel");
            await fetch("bereiche/templatebereich.php")
                .then(response => response.text())
                .then(html => {
                    settingPanel.innerHTML = html;
                });

            const delSchema = document.getElementById("deleteSchema")
            CardObj.list.forEach(element => {
                delSchema.innerHTML += `<tr class="border-bottom">
                    <td class="p-2">${element.id}</td>
                    <td class="p-2">${element.titel}</td>
                    <td class="p-2">${element.beschreibung || 'Keine Beschreibung'}</td>
                    <td class="p-2 text-center"><input type="checkbox" name="${element.id}" id="checkDelSchema${element.id}" onchange="CardObj.event_remove(${element.id})"></td>
                </tr>`;
            });
        });
    }

});

async function meow(event) {
    event.preventDefault(); // Verhindert das Standardverhalten des Formulars
    const form = event.target.form;
    const formData = new FormData(form);
    const selectedTime = String(formData.get('selectedTime')); // Wert als Zahl
    const aktiv = formData.get('aktiv'); // Wert der ausgewählten Option

    const titel = formData.get('title');
    const description = formData.get('description');

    console.log("Selected Time:", selectedTime);

    const imgFile = formData.get("img");
    const localImageName = imgFile && imgFile.name ? imgFile.name : "";
    if (localImageName === "" || localImageName === null || selectedTime === null || aktiv === null || titel === "" || description === "") {
        alert("Bitte füllen Sie alle Felder aus inkl Bild.");
        return;
    }
    // Bild hochladen und vom Server den Dateinamen erhalten
    const serverImageName = await sendPicture(formData);
    // CardObj mit dem vom Server erhaltenen Bildnamen erstellen
    if (serverImageName === "") {
        console.error("Bild konnte nicht hochgeladen werden.");
        return;
    }
    try {
        // Lokalen Dateinamen in den CardObj einfügen
        const obj1 = new CardObj(
            "",
            serverImageName, // Nur Bildname, kein Pfad
            selectedTime,
            aktiv,
            "",
            "",
            "",
            "",
            "",
            "",
            titel,
            description
        )
        console.log(obj1.selectedTime);

        await insertDatabase(obj1);
        alert("Schema erfolgreich erstellt!");
        await CardObj.update();
        createBodyCardObj();
    } catch (error) {
        console.error("Fehler beim erstellen des CardObj:", error);
    }
    form.reset(); // Formular zurücksetzen

}
async function sendPicture(formData) {
    try {
        const response = await fetch("/schemas/movePic.php", {
            method: 'POST',
            body: formData
        });
        let imageName = await response.text();
        // Falls der Server einen Pfad zurückgibt, extrahiere nur den Dateinamen
        imageName = imageName.split('/').pop();

        return imageName;
    } catch (error) {
        console.error('Error:', error);
        return "";
    }
}

async function insertDatabase(cardObj) {
    // Erstellen eines JSON-Objekts
    const jsonData = {
        titel: cardObj.titel,
        beschreibung: cardObj.beschreibung,
        imagePath: cardObj.imagePath,
        selectedTime: cardObj.selectedTime,
        aktiv: cardObj.aktiv,
        startTime: cardObj.startTime,
        endTime: cardObj.endTime,
        startDateTime: cardObj.startDate,
        endDateTime: cardObj.endDate
    };
    console.log(jsonData.selectedTime);

    console.log(JSON.stringify(jsonData));
    // Senden der POST-Anfrage mit JSON-Daten
    const response = await fetch("/database/insertSchema.php", {
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
async function createBodyCardObj() {
    var cardContainer = document.getElementById("cardContainer");
    if (!cardContainer) {
        console.error("Card container not found");
        return;
    }

    cardContainer.innerHTML = ""; // Clear existing content
    CardObj.list.forEach(cardObj => {
        const cardContainer = "cardContainer"
        cardObj.htmlBody(cardContainer);

    });
    deakCb(true);
    console.log(CardObj.list);
    const cbForSelectSchema = document.querySelectorAll('[id^="flexCheck"]')
    const labels = document.querySelectorAll('label[name^="label"]');
    console.log(cbForSelectSchema.length);
    // Alle Checkboxen mit ID, die mit "flexCheck" beginnt, auswählen und loopen
    cbForSelectSchema.forEach(checkbox => {
        // Hier kannst du mit jeder Checkbox arbeiten
        checkbox.addEventListener('change', function () {
            if (this.checked) {


                const id = extractNumberFromString(this.id);
                CardObj.selectedID = id; // Set the selected ID
                var obj = findObj(CardObj.list, id);
                deakAktivCb(false);
                CardObj.loadChanges(obj); // Load changes for the selected CardObj   

                cbForSelectSchema.forEach(cb => {
                    if (cb !== this) {
                        cb.checked = false;
                    }
                });
                labels.forEach(label => {
                    const labelId = extractNumberFromString(label.getAttribute('name'));
                    if (labelId == CardObj.selectedID) {
                        label.innerHTML = "Ausgewählt"; // Set the label text to "checked" when checked
                        var label = label;

                    } else {
                        label.innerHTML = ""; // Clear the label text for unchecked checkboxes
                        console.log("Checkbox mit ID " + labelId + " wurde deaktiviert.");

                    }
                });
            } else {
                var checkA = document.getElementById("checkA");
                var btn_save_changes = document.getElementById("btn_save_changes");
                deakAktivCb(true);


                CardObj.selectedID = null; // Reset the selected ID
                labels.forEach(label => {
                    label.innerHTML = ""; // Clear the label text for unchecked checkboxes
                });
                checkA.checked = false;

            }
            Beziehungen.update(CardObj.selectedID);

        });
    });

   
};

function deakAktivCb(aktiv) {
    console.log("deakAktivCb aufgerufen mit aktiv:", aktiv);

    var timerbereich = document.getElementById("timerSelectRange");
    var titel = document.getElementById("websiteName");
    var checkA = document.getElementById("checkA");
    var btn_hinzufuegen = document.getElementById("btn_hinzufuegen");
    var btn_loeschen = document.getElementById("btn_loeschen");
    var btn_save_changes = document.getElementById("btn_save_changes");
    if (aktiv == true) {
        timerbereich.disabled = true; // Deaktiviert den Timerbereich
        titel.disabled = true; // Deaktiviert das Titel-Eingabefeld
        checkA.disabled = true; // Deaktiviert die Aktiv-Checkbox
        btn_hinzufuegen.disabled = true; // Deaktiviert den Hinzufügen-
        btn_loeschen.disabled = true; // Deaktiviert den Löschen-Button
        btn_save_changes.disabled = true; // Deaktiviert den Speichern-Button
    } else {
        timerbereich.disabled = false; // Aktiviert den Timerbereich
        titel.disabled = false; // Aktiviert das Titel-Eingabefeld
        checkA.disabled = false; // Aktiviert die Aktiv-Checkbox
        btn_hinzufuegen.disabled = false; // Aktiviert den Hinzufügen-Button
        btn_loeschen.disabled = false; // Aktiviert den Löschen-Button
        btn_save_changes.disabled = false; // Aktiviert den Speichern-Button
    }
}

function uncheckAllCheckboxes() {
    const cardContainer = document.getElementById('cardContainer');
    var checkA = document.getElementById("checkA");
    if (cardContainer) {
        const checkboxes = cardContainer.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = false;

        });
        console.log(`${checkboxes.length} Checkboxes im cardContainer wurden ausgeschaltet`);
    } else {
        console.log("cardContainer nicht gefunden");
    }
}
function deakCb(aktiv) {
    const cardContainer = document.getElementById('cardContainer');

    if (cardContainer) {
        const checkboxes = cardContainer.querySelectorAll('input[type="checkbox"]');
        const labels = cardContainer.querySelectorAll('label[name^="label"]');
        checkboxes.forEach(checkbox => {
            checkbox.disabled = aktiv;

        });
        labels.forEach(label => {
            label.innerHTML = ""; // Clear the label text for unchecked checkboxes
        });
        CardObj.selectedID = null; // Update the checkAllowed state
        console.log(`${checkboxes.length} Checkboxes im cardContainer wurden deaktiviert`);
    } else {
        console.log("cardContainer nicht gefunden");
    }
}

