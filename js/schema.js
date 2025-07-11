class CardObj {
    static idCounter = 0;
    static selectedID = 0;
    static allCardObjekte = [];
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
        // setTimeout(() => {
        //     this.updateObj();
        // }, 100);
        // umgebung.addCardObjs(this)
        // Umgebung.allCardsInOneList.push(this)
    }
    htmlKonstruktObjBody(umgebung) {
        // Dynamische Card mit CardObj-Daten
        const body = `
            <div class="card-deck">
                <div class="card" id="${this.cardObjekte}">
                    <img class="card-img-top" src="/uploads/${this.imagePath}" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">${this.titel}</h5>
                        <p class="card-text">${this.beschreibung}</p>
                        <div class="form-check">
                            <input class="form-check-input single-active-checkbox" type="checkbox" value="" id="flexCheck${this.id}"}>
                            <label class="form-check-label" name="MEOW" for="flexCheck${this.id}">
                                Aktiv
                            </label>
                        </div>
                        <div>
                            <small class="text-muted">selectedTime: ${this.selectedTime} ms</small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">Last updated just now</small>
                    </div>
                </div>
            </div>
        `;
        document.getElementById(umgebung).innerHTML += body;
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


            // await fetch('/bereiche/templatebereich.js'){

            // }

        });
    }

    const checkboxes = document.querySelectorAll('.form-check-input');
    const labels = document.querySelectorAll('.form-check-label');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            if (this.checked) {
                console.log(`Checkbox with ID ${this.id} is checked`);
                const id = extractNumberFromString(this.id);
                CardObj.selectedID = id; // Set the selected ID
                console.log(`Selected ID set to: ${CardObj.selectedID}`);
                console.log(`Checkbox ID extracted: ${id}`);

                console.log(this.checked);
                checkboxes.forEach(cb => {
                    if (cb !== this) {
                        cb.checked = false;

                    }
                });
                labels.forEach(label => {


                    if (label.html == id) {
                        label.innerHTML = "checked"; // Set the label text to "checked" when checked
                    } else {
                        label.innerHTML = ""; // Clear the label text for unchecked checkboxes
                    }
                });

            } else {
                console.log(`Checkbox with ID ${id} is unchecked`);
            }
        });
    });

});
console.log("Schema wurde geladen");


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