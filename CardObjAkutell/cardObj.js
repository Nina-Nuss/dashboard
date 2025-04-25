class CardObj {
    static idCounter = 1;
    constructor(umgebung, titel, isTimeSet, imagePath, imageSet, startDateTime, endDateTime, aktiv, id) {

        this.id = id;
        this.update = false;

        //AB hier kommt alles in die Datenbank rein:
        this.zugeordnet = titel // Der Name des Aufenhaltsortes
        this.isTimeSet = isTimeSet //true or false
        this.imagePath = imagePath //Der Pfad zum Bild
        this.imageSet = imageSet  //true or false
        this.startDateTime = startDateTime //Der kalender, der den startdatum enthält
        this.endDateTime = endDateTime //Der kalender, der die enddatum enthält
        this.aktiv = aktiv //true or false
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
        //-------------------------------------    

        this.htmlKonstruktObjBody(umgebung)
        this.initializeDateRangePicker()
        this.updateObj()
        umgebung.addCardObjs(this)
        Umgebung.allCardsInOneList.push(this)
    }
    htmlKonstruktObjBody(umgebung) {
        var htmlUmgebungsBody = document.getElementById(umgebung.htmlUmgebungsBody);
        htmlUmgebungsBody.innerHTML += `
        <div id="${this.cardObjekte}" class="card m-1" style="width: 10rem;" >
            <div class="position-absolute form-check-d d-none">
                <input class="form-check-input" type="checkbox" value="" id="${this.deleteBtn}">
            </div>
            <span class="material-symbols-outlined removePicBtn z-3" id="${this.closeBtn}" onclick="deletePicture('${this.imagePreviewId}', '${this.modalImageId}')" >close</span>
        <div class="picture pt-0">
            <form action="test.php" method="post" enctype="multipart/form-data" id="${this.formID}">
                <label class="upload-container">
                    <div class="z-1" id="${this.imagePreviewId}">Bild auswählen oder hierher ziehen</div>  
                    <input 
                        type="file" 
                        name="file" 
                        id="${this.imageInputId}"
                        accept="image/*" 
                        required 
                        onclick="setupImagePicker('${this.imagePreviewId}', '${this.modalImageId}', '${this.imageInputId}', '${this.formID}')"
                    >      
                </label>
                <!-- Der versteckte Submit-Button -->
                <input type="submit" name="submit" value="Hochladen" class="hidden-submit z-3">
            </form>
        </div>
        <div class="d-flex justify-content-center">
            <!-- rangeslider -->  
            <input type="range" class="form-range z-3" min="3" max="9" id="${this.timerSelectRange}" disabled>
            <!-- rangeslider -->
        </div>  
        <div class="card-body d-flex align-items-center justify-content-between p-2 gap-2">
            <button id="${this.openModalButtonId}" class="btn btn-light btn-sm modalBtn" data-toggle="modal">
                <span class="material-symbols-outlined">date_range</span>
            </button>
           
            <div class="btn-group dropend" >
                <button id="${this.infoBtn}" type="button" class="btn btn-light dropdown-toggle p-0" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="material-symbols-outlined">info</span>
                </button>
                <ul class="dropdown-menu p-2">
                    <label class="p-0 d-flex justify-content-center align-items-center " id="${this.infoCard}"></label>
                </ul>      
            </div>  
            <div class="form-check form-switch align-self-end ">
                <input  class="form-check-input pl-3" type="checkbox" role="switch" onclick="cardSwitch('${this.alwaysOnBtn}')" id="${this.alwaysOnBtn}">
            </div>
        </div>
    <!-- Modal structure -->
    <div id="${this.modalId}" class="modal">
        <div id="${this.dateRangeContainerId}" class="mt-2 text-muted"></div>
        <div class="modal-content">           
            <span id="${this.modalCloseButtonId}" class="close">&times;</span>
            <div id="${this.modalImageId}"></div>
            <div class="container mt-3" id="zeitManagment${this.id}" style="display: block;">
                <div class="input-group">
                    <span class="input-group-text" id="${this.daterangeIconId}">
                        <i class="bi bi-calendar3"></i>
                        <input type="text" id="${this.dateRangeInputId}"  class="file-input-button" readonly>
                    </span>
                </div>
            </div>         
        </div>
    </div>
    `;
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

        if (objSwitch) {
            objSwitch.checked = this.aktiv === true;
            console.log(`Switch ${this.alwaysOnBtn} wurde auf ${objSwitch.checked ? 'aktiv' : 'inaktiv'} gesetzt`);

            // Kalender-Button aktualisieren
            const calendarBtn = document.getElementById(this.openModalButtonId);
            if (calendarBtn) {
                // Wenn aktiv ist TRUE, wird der Kalender-Button DEAKTIVIERT
                // Wenn aktiv ist FALSE, wird der Kalender-Button AKTIVIERT
                calendarBtn.disabled = this.aktiv === true;
                console.log(`Kalender-Button ${this.openModalButtonId} wurde ${calendarBtn.disabled ? 'deaktiviert' : 'aktiviert'}`);
            } else {
                console.warn(`Kalender-Button mit ID ${this.openModalButtonId} nicht gefunden`);
            }
        } else {
            console.warn(`Element mit ID ${this.alwaysOnBtn} nicht gefunden`);
        }

        // Bild aktualisieren, falls vorhanden
        const imageContainer = document.getElementById("imagePreview" + this.id);
        if (!imageContainer) {
            console.warn(`Bild-Container mit ID imagePreview${this.id} nicht gefunden`);
            return;
        }

        // Keine Aktion erforderlich, wenn kein Bildpfad existiert
        if (!this.imagePath || this.imagePath === "") {
            return;
        }

        // Prüfen, ob bereits ein Bild vorhanden ist, um Duplikate zu vermeiden
        if (imageContainer.querySelector('img')) {
            // Bild bereits vorhanden, prüfen ob Update nötig
            const existingImg = imageContainer.querySelector('img');
            if (existingImg.src !== this.imagePath) {
                existingImg.src = this.imagePath;
            }
        } else {
            // Neues Bild erstellen und einfügen
            try {
                const imgElement = document.createElement("img");
                imgElement.classList.add("picInCard");
                imgElement.style.width = "110%";
                imgElement.src = this.imagePath;
                imgElement.alt = `Bild für ${this.zugeordnet || 'Karte'}`;
                imageContainer.appendChild(imgElement);
            } catch (error) {
                console.error(`Fehler beim Hinzufügen des Bildes: ${error.message}`);
            }
        }
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
            var obj = Umgebung.findObj(lastChar)
            obj.isTimeSet = true
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