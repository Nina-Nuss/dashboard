class CardObj {
    static idCounter = 1;
    constructor(id, imagePath, selectedTime, aktiv, startDateTime, endDateTime, infotherminalID) {

        this.id = id;
        this.update = false;
        //AB hier kommt alles in die Datenbank rein:
        this.imagePath = imagePath //Der Pfad zum Bild
        this.startDateTime = startDateTime //Der kalender, der den startdatum enthält
        this.endDateTime = endDateTime //Der kalender, der die enddatum enthält
        this.selectedTime = selectedTime // Der aktuelle ausgewählte Wert
        this.aktiv = aktiv //true or false
        this.infotherminalID = infotherminalID // Der Infoterminal ID, zu dem das Objekt gehört
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

        this.htmlKonstruktObjBody(umgebung)
        setTimeout(() => {
            this.updateObj();
        }, 100);
        umgebung.addCardObjs(this)
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

        // Bild-Element erstellen
        // const img = document.createElement("img");
        // img.src = this.imagePath;
        // img.alt = "Bild";
        // img.className = "img-fluid";

        // // Bild dem Container hinzufügen
        // container.appendChild(img);

        // const closebtn = document.getElementById(this.closeBtn);
        // closebtn.style.display = "block";

        // // Container in das DOM einfügen (z. B. in ein Element mit der ID "imagePreview")

        // if (imageContainer) {
        //     imageContainer.appendChild(container);
        // } else {
        //     console.warn("Elternelement mit ID 'imagePreview' nicht gefunden.");
        // }

    }






















    initializeDateRangePicker() {
        $(document).on('click', 'button[id^="openModal"]', function () {
            const buttonId = $(this).attr('id'); //"openModal1"
            const modalId = buttonId.replace('openModal', 'myModal'); // e.g., "myModal1"
            const aktuellesObj = Umgebung.findObj(modalId)
            console.log(aktuellesObj);
            console.log(modalId);
            if (!aktuellesObj.imageSet) {
                return
            } else {
                $(`#${modalId}`).fadeIn(() => {
                    // Sobald das Modal sichtbar ist, den DateTimePicker fokussieren
                    const dateRangeId = modalId.replace('myModal', 'daterange');
                    console.log(dateRangeId);
                    $(`#${dateRangeId}`).focus(); // Fokus auf das Eingabefeld
                });
            }
        });
        // Close the modal when the "x" button is clicked
        $(document).on('click', '.close', function () {
            $(this).closest('.modal').fadeOut();
        });
        // schließt modal wenn außerhalb des modales geklickt wird
        $(document).on('click', function (event) {
            const $target = $(event.target);
            if ($target.hasClass('modal')) { // Check if the clicked element has the "modal" class
                $target.fadeOut();
            }
        });
        $('button[id^="infoBtn"]').click(function () {
            // Hole die ID des geklickten Elements
            var eIDtimer = $(this).attr('id');
            const aktuellesObj = Umgebung.findObj(eIDtimer)
            console.log(eIDtimer);
            if (aktuellesObj.imageSet == true) {
                var eIDtimer = $(this).attr('id');
                console.log('Die ID des Elements ist: ' + eIDtimer);

                let lastIndex = eIDtimer.replace('infoBtn', '');
                // Erstelle den ID-Selektor für das zugehörige Select-Element
                let timerselect = '#timerSelect' + lastIndex;
                console.log('Der Selektor ist: ' + timerselect);
                // Ändere den Stil des zugehörigen Select-Elements
                $(timerselect).css("display", "block");
                $('#' + eIDtimer).css("display", "block");
            }
        });
        $('input[id^="timerSelect"]').on('input', function () {
            var selectedValue = $(this).val();
            console.log(selectedValue);
            selectedValue = selectedValue * 1000
            let selectedId = $(this).attr('id');
            let lastChar = selectedId[selectedId.length - 1];
            console.log(lastChar);
            var obj = Umgebung.findObj(lastChar)
            obj.selectedTime = selectedValue
            console.log(obj.selectedTime);
        });
        //Ab hier geht es um den DateTimePicker
        //!!!!  daterangepicker muss nach cardobj geladen werden!!!!!!!
        let selectedDateRange = '';
        // Initialize Date Range Picker
        $('input[id^="daterange"]').daterangepicker({
            autoUpdateInput: false, // Prevent auto-filling the input
            timePicker: true,
            timePicker24Hour: true,
            locale: {
                format: 'DD-MM-YYYY HH:mm',
                cancelLabel: 'Abbrechen',
                applyLabel: 'Übernehmen',
            },
            minDate: new Date(), // Minimum selectable date is today
            drops: 'down', // Ensure dropdown opens correctly
            opens: 'center'
        });

        // Open Date Range Picker when the icon is clicked
        $(document).on('click', 'span[id^="daterange-icon"]', function () {
            const iconID = $(this).attr('id');
            const daterangeID = iconID.replace('daterange-icon', 'daterange');
            console.log(daterangeID);
            $('#' + daterangeID).focus(); // Focus on input to trigger the picker  
        });

        $('input[id^="daterange"]').ready(function () {
            // Entferne die Klasse von allen Elementen mit der Klasse 'drp-selected'
            $(".drp-selected").removeClass("drp-selected");
        });

        // Update input field and display the selected date range when a date is selected
        $('input[id^="daterange"]').on('apply.daterangepicker', function (ev, picker) {
            selectedDateRange = picker.startDate.format('DD-MM-YYYY HH:mm') + '  -  ' + picker.endDate.format('DD-MM-YYYY HH:mm');
            $(this).val(selectedDateRange); // Update input field
            $('#selected-daterange').text(selectedDateRange); // Display the selected date range below
            var obj = Umgebung.findObj(this.id);
            showData(obj, selectedDateRange);

            let date = picker.startDate.format('DD.MM') + '  -  ' + picker.endDate.format('DD.MM');
            let dateForInfo = picker.startDate.format('DD.MM.YYYY HH:mm') + '  bis  ' + picker.endDate.format('DD.MM.YYYY HH:mm');
            // Extrahiere den Tag, Monat und Jahr von startDate
            let startDay = picker.startDate.format('DD'); // Tag des Startdatums
            let startMonth = picker.startDate.format('MM'); // Monat des Startdatums
            let startYear = picker.startDate.format('YYYY'); // Jahr des Startdatums
            let startTime = picker.startDate.format('HH:mm'); // Uhrzeit des Startdatums
            // Extrahiere den Tag, Monat und Jahr von endDate
            let endDay = picker.endDate.format('DD'); // Tag des Enddatums
            let endMonth = picker.endDate.format('MM'); // Monat des Enddatums
            let endYear = picker.endDate.format('YYYY'); // Jahr des Enddatums
            let endTime = picker.endDate.format('HH:mm'); // Uhrzeit des Enddatums
            // Erstelle den Text, der das Datum, Jahr und die Uhrzeit anzeigt
            let dateText = startDay + '.' + startMonth + '.' + startYear + ' ' + startTime + ' bis ' + endDay + '.' + endMonth + '.' + endYear + ' ' + endTime;
            $(this).val(date);
            var todayStart = moment().startOf('day');
            if (picker.startDate.isSame(todayStart)) {
                // If today was selected, set the start and end time to the current time
                var currentTime = moment();
                picker.setStartDate(currentTime); // Set start time to now
            }
            let selectedId = $(this).attr('id');
            let lastChar = selectedId[selectedId.length - 1];
            $('#showDateInCard' + lastChar).text(dateText);
            $('#infoBtn' + lastChar).css("display", "block");
            console.log(34534535234532452345);
            let alwaysOnBtn = '#alwaysOnBtn' + lastChar;
            $(alwaysOnBtn).css("display", "none");
        });

        // Clear input field and display when cancel is clicked
        $('input[id^="daterange"]').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val(''); // Clear the input
            $('#selected-daterange').text(''); // Clear the displayed text
            selectedDateRange = ''; // Reset the variable
        });

        // Set today's date on button click
        $('input[id^="daterange"]').on('show.daterangepicker', function (ev, picker) {
            let selectedrange = picker.startDate.format('DD.MM') + '  -  ' + picker.endDate.format('DD.MM');
            $(this).val(selectedrange);
        });
    }
}



const templatebereich = document.getElementById("templatebereich");
if (templatebereich) {
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

console.log("schema wurde geladen");