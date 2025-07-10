class CardObj {
    static idCounter = 1;
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
        this.selectedTime = ""
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
        Umgebung.allCardsInOneList.push(this)
    }
    htmlKonstruktObjBody(umgebung) {
        var htmlUmgebungsBody = document.getElementById(umgebung.htmlUmgebungsBody);
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

});
console.log("Schema wurde geladen");




console.log("schema wurde geladen");