class CardObj {
    static idCounter = 0;
    static selectedID = 0;
    static allCardObjekte = [];
    static temp_remove = [];
    static eleListe = []
    static list = [];
    constructor(id, imagePath, selectedTime, aktiv, startTime, endTime, startDate, endDate, titel, beschreibung) {

        this.id = id;
        this.update = false;
        //AB hier kommt alles in die Datenbank rein:
        this.imagePath = imagePath //Der Pfad zum Bild
        this.startTime = startTime //Startzeit des Zeitplans
        this.endTime = endTime //Endzeit des Zeitplans
        this.startDate = startDate //Startdatum des Zeitplans
        this.endDate = endDate //Enddatum des Zeitplans
        this.selectedTime = selectedTime // Der aktuelle ausgewählte Wert
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
        this.modalCloseButtonId = `closeModal${this.id}`;
        this.daterangeIconId = `daterange-icon${this.id}`;
        this.infoBtn = `infoBtn${this.id}`;
        this.timerSelectRange = `timerSelect${this.id}`
        this.alwaysOnBtn = `alwaysOnBtn${this.id}`
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
                    <img class="card-img-top" src="/schemas/uploads/${this.imagePath}" alt="Card image cap">
                    <div class="card-body p-2 h-50">
                        <h5 class="card-title m-0">${this.titel}</h5>
                        <p class="card-text m-0">${this.beschreibung}</p>
                        <div class="form-check">
                            <input class="form-check-input single-active-checkbox" type="checkbox" value="" id="flexCheck${this.id}"}>
                            <label class="form-check-label" name="label${this.id}" for="flexCheck${this.id}">
                                
                            </label>
                        </div>
                        <div>
                            <small class="text-muted">selectedTime: ${this.selectedTime} ms</small>
                        </div>
                    </div>
                    <div class="card-footer p-1">
                        <small class="text-muted">Last updated just now</small>
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
    updateObj() {
        // Checkbox-Status aktualisieren
        const objSwitch = document.getElementById(this.alwaysOnBtn);
        const calendarBtn = document.getElementById(this.openModalButtonId);
        const imageContainer = document.getElementById(this.imagePreviewId);
        console.log("edfsfdsfdsfdsfsdf");
        objSwitch.checked = this.aktiv;
        console.log(this);
        // Kalender-Button aktualisieren
        console.log("kalenderbtn: " + calendarBtn.disabled);
        console.log("switch: " + objSwitch.checked);

        if (this.imageSet == true) {
            calendarBtn.disabled = false;
        } else {
            calendarBtn.disabled = true;
        }

        if (!imageContainer) {
            console.warn(`Bild-Container mit ID imagePreview${this.id} nicht gefunden`);
            return;
        }
        if (!this.imagePath || this.imagePath === "") {
            return;
        }

        const container = document.createElement("div");
        container.id = this.imagePreviewId;
        container.className = "image-container";
    }

    checkboxAktiv() {
        const cbAktiv = document.querySelectorAll('[id^="cbAktiv"]')
        cbAktiv.forEach(cb => {
            cb.addEventListener("change", (event) => {
                this.aktiv = event.target.checked;
            });
        });
    }

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
    static remove_generate() {
        this.removeFromListLogik();
        this.update();
    }

    static async removeFromListLogik() {
        // DIese Methode wird aufgerufen sobald wir auf Minus (-) klicken
        // Hier benötigen wir die Aktuellen IDS der Datenbank zum löschen
        console.log(this.list);

        this.temp_remove.forEach(id => {
            this.list = this.removeFromListViaID(id, this.list);

        });
        this.temp_remove = []
        console.log(this.list);
    }

    static removeFromListViaID(id, list) {
        var temp = [];
        console.log(list);

        list.forEach(element => {
            if (element.id != id) {
                //ID muss aus Liste gelöscht werden
                temp.push(element);

            } else {
                // Verhindere das Löschen der Hauptumgebung (ID 0 - "Alle Schemas")
                if (element.id != 0) {
                    this.deleteCardObjDataBase(element.id);
                    console.log("Das Element wurde gefunden und wird gelöscht! " + element.id);
                    // Delete muss in der Datenbank nun hier ausgefuehrt werden
                } else {
                    console.warn("Hauptumgebung (Alle Schemas) kann nicht gelöscht werden!");
                }
                return;
            }
        });
        return temp;
    }

    static async deleteCardObjDataBase(cardObjId) {
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

    static async update() {
        var delSchema = document.getElementById("deleteSchema")
        var cardContainer = document.getElementById("cardContainer");
      
        if (delSchema != null) {
            delSchema.innerHTML = "";
            cardContainer.innerHTML = "";
            this.list = [];
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
                    listInfo[8], // titel
                    listInfo[9]  // beschreibung
                );
                delSchema.innerHTML += `<input type="checkbox" id="checkDelSchema${listInfo[0]}" name="${listInfo[8]}" onchange="CardObj.event_remove(${listInfo[0]})"> ${listInfo[8]} - ${listInfo[9]} <br>`
            });
        }
        createBodyCardObj();
        console.log(this.list);

    }
}





window.addEventListener("load", function () {
    const templatebereich = document.getElementById("templateBereich");
    if (templatebereich !== null) {
        console.log(234);

        templatebereich.addEventListener("click", async function (event) {

            var settingPanel = document.getElementById("settingsPanel");

            await fetch("bereiche/templatebereich.php")
                .then(response => response.text())
                .then(html => {
                    settingPanel.innerHTML = html;
                });


            const delSchema = document.getElementById("deleteSchema")
            console.log("deleteSchema: ", delSchema);

            CardObj.list.forEach(element => {
                delSchema.innerHTML += `<input type="checkbox" id="checkDelSchema${element.id}" name="${element.titel}" onchange="CardObj.event_remove(${element.id})"> ${element.titel} <br>`
            });
            const deletBtnForSchemas = document.createElement("button");
            deletBtnForSchemas.id = "deleteBtnForSchemas";
            deletBtnForSchemas.textContent = "löschen";

            deletBtnForSchemas.addEventListener("click", function () {
                CardObj.remove_generate();

            });
            settingPanel.appendChild(deletBtnForSchemas);
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
        startDate: cardObj.startDate,
        endDate: cardObj.endDate
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
        startDate: cardObj.startDate,
        endDate: cardObj.endDate
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
function createBodyCardObj() {
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
                console.log("Checkbox mit ID " + id + " wurde aktiviert.");

                console.log(this.checked);
                cbForSelectSchema.forEach(cb => {
                    if (cb !== this) {
                        cb.checked = false;
                    }
                });
                labels.forEach(label => {
                    const labelId = extractNumberFromString(label.getAttribute('name'));
                    if (labelId == id) {
                        label.innerHTML = "checked"; // Set the label text to "checked" when checked
                    } else {
                        label.innerHTML = ""; // Clear the label text for unchecked checkboxes
                    }
                });
            } else {

                CardObj.selectedID = 0; // Reset the selected ID
            }
            Beziehungen.update(CardObj.selectedID);
            Beziehungen.temp_remove = [];
        });
    });
};



