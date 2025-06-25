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

<!-- jQuery, Moment.js, Bootstrap JS, and Date Range Picker JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
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
<script href="styles.scss"></script>


</head>

<body>
    <div class="container d-flex gap-2">
        <div id="row" class="col-4 p-2 ">
            <!-- bild Obj -->
        </div>
        <div class="img-thumbnail w-100 m-3 ">
            <?php include 'imageCarusel.html'; ?>
        </div>
    </div>
</body>
<style>
    .daterangepicker ltr show-calendar opensright {
        right: 100px;
        left: auto;
    }

    .modalBtn {
        width: 70%;
        height: auto;
        padding: 0px;
    }

    #showDateInCard {
        padding: 0;
        width: 100%;
        border: #000;
        text-align: center;
    }

    .hourselect {
        border-radius: 5px;
    }

    .minuteselect {
        border-radius: 5px;
    }

    #zeitManagment {
        display: block;
    }

    .modalBtn {
        border-radius: 5px;
    }

    .file-input-button {
        height: 20px;
        width: 130px;
        border: none;
        text-align: center;
        line-height: 1000px;
        cursor: pointer;
        background-color: #f8f9fa;
        outline: none;
        overflow: hidden;
        /* Add more styles as needed */
    }

    .card {
        padding-left: 0%;
        padding-right: 0%;
    }

    .image-picker {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 20px;
    }

    .image-preview {
        width: 100%;
        height: 100px;
        display: flex;
        border-radius: 5px 5px 0px 0px;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        background-color: #f0f0f0;
        cursor: pointer;
    }

    .image-preview img {
        max-height: max-content;
        max-width: max-content;
    }

    /* Versteckt das Datei-Input-Feld */
    .imageInput {
        display: none;

    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        /* Overlay background */
    }

    /* Modal content */
    .modal-content {
        position: relative;
        margin: auto;
        padding: 20px;
        background-color: white;
        width: 50%;
        max-width: 250px;
        border-radius: 5px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.0);
        text-align: center;
    }

    /* Close button styling */
    .close {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
        color: #aaa;
    }

    .close:hover {
        color: #000;
    }

    .removePicBtn {
        position: absolute;

        left: 134px;
        width: 25px;
        height: 25px;
        background-color: white;
        border-radius: 0px 3px 0px 3px;
        opacity: 0.5;
        z-index: 1;
        cursor: pointer;
    }

    .removePicBtn:hover {
        background-color: red;
        opacity: 1;
    }

    [id^="timerSelect"] {
        display: block;
    }

    [id^="infoBtn"] {
        display: none;
    }

    [id^="closeBtn"] {
        display: none;
        margin-left: -0.3px;
    }

    [id^="imagePreview"] {
        display: inline-block;
        overflow: hidden;
    }

    [id^="imagePreview"] img {
        width: 300px;
        /* Ursprungsgröße */
        height: auto;
        transition: transform 0.3s ease;
        /* Animation beim Hover */
    }

    .form-check {
        display: block;
        padding-left: 0rem !important;

    }

    [id^="imagePreview"] img:hover {
        transform: scale(1.2);
        /* Vergrößert das Bild auf 120% */
    }

    /* Hide the default button value text */
    .material-symbols-outlined {
        vertical-align: middle;
        font-variation-settings:
            'FILL' 1,
            'wght' 300,
            'GRAD' 0,
            'opsz' 20
    }

    .upload-container {
        display: flex;
        justify-content: center;
        align-items: center;
        width: auto;
        max-width: auto;
        height: 7rem;
        border-radius: 3px 3px 0px 0px;
        background-color: ghostwhite;
        color: gray;
        font-size: 18px;
        text-align: center;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .upload-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 5;
        /* Start hidden */
    }

    .picInCard img:hover {
        transform: scale(1.2);
        border-radius: 5px;
        /* Vergrößert das Bild auf 120% */
    }

    .upload-container input[type="file"] {
        position: absolute;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    /* Versteckt den Submit-Button */
    .hidden-submit {
        display: none;
    }

    .btn-container {
        display: inline-block;
        position: relative;
    }

    .btn-select {
        position: absolute;
        top: 100%;
        left: 0;
        margin-top: 10px;
        display: none;
    }

    .minuteselect {
        max-height: 300px;
        /* Setzt eine maximale Höhe für das Dropdown-Menü */
        overflow-y: auto;
        /* Ermöglicht Scrollen bei Bedarf */
        transform-origin: top !important;
        /* Setzt den Ursprung der Transformation nach oben */
        transform: translateY(0)
    }

    .hourselect {
        max-height: 300px;
        /* Setzt eine maximale Höhe für das Dropdown-Menü */
        overflow-y: auto;
        /* Ermöglicht Scrollen bei Bedarf */
        transform-origin: top !important;
        /* Setzt den Ursprung der Transformation nach oben */
        transform: translateY(0)
    }

    .form-select {
        -webkit-appearance: none;
        /* Standard-Pfeil-Symbol ausblenden */
        -moz-appearance: none;
        /* Standard-Pfeil-Symbol ausblenden */
        appearance: none;
        /* Standard-Pfeil-Symbol ausblenden */
        background: url('');
        /* Entferne das Hintergrundbild, falls vorhanden */
        padding-right: 1.5rem;
        /* Abstand zum Rand hinzufügen, um Platz für benutzerdefinierte Symbole zu schaffen */
        position: relative;
    }

    /* Container für relativen Bezug */
    .select-container {
        position: relative;
    }

    .form-range {
        appearance: none;
        width: 99%;
        height: 0px;
        background: #e9ecef;
        border-radius: 5px;
        outline: none;
        transition: background 0.3s;
        background: linear-gradient(to right, blue 0%, blue var(--range-fill), white var(--range-fill), white 100%);
    }

    .form-range::-webkit-slider-thumb {
        appearance: none;
        width: 10px;
        height: 10px;

        /* Farbe des Schiebereglers */
        border-radius: 50%;
        /* Runde Form des Buttons */
        cursor: pointer;
        border: none;
        position: relative;
        top: 100%;
        transform: translateY(-50%);
        /* Zentrierung */
    }

    .btn.dropdown-toggle::after {
        display: none;
    }

   
</style>
<script>
    const rowForCards = document.getElementById("row")
    const listAnzeige = []
    const endloseAnzeige = []
    let cancelUplaod = false
    var zeitEingegeben = false
    let pushDelete = false
    class CardObj {
        static idCounter = 0;
        static objList = []
        constructor() {
            this.id = CardObj.idCounter++;
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
            this.infoCard = `showDateInCard${this.id}`
            this.isTimeSet = false
            this.imagePath = ""
            this.imageSet = false
            this.startDateTime = ""
            this.endDateTime = ""
            this.closeBtn = `closeBtn${this.id}`
            this.sumbitBtnID = `submit${this.id}`;
            this.formID = `formID${this.id}`
            this.imBereich = true
            this.htmlKonstruktObjBody();
            CardObj.objList.push(this);
        }
        htmlKonstruktObjBody() {
            rowForCards.innerHTML += `
        <div class="card m-1" style="width: 10rem;" >
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
                <input type="range" class="form-range z-3" min="1" max="7" id="${this.timerSelectRange}"  disabled>
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
                <div class="form-check form-switch align-self-end" id="${this.alwaysOnBtn}">
                    <input class="form-check-input pl-3" type="checkbox" role="switch" id="flexSwitchCheckDefault" disabled>
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
    }
    function delay(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }
    const bildObj = new CardObj();
    const bildObj1 = new CardObj();
    const bildObj2 = new CardObj();
    const bildObj3 = new CardObj();
    // Logik zum Auslösen des Submit-Buttons
    async function getImagePath(formID, ob) {
        const form = document.getElementById(formID);
        const formData = new FormData(form);
        const response = await fetch('test.php', {
            method: 'POST',
            body: formData,
        })
        var path = await response.text()
        ob.imagePath = path
        console.log(ob.imagePath);
    }

    function deletePicture(imagePreview, modalImage) {
        var modalImage = document.getElementById(modalImage).id; // Modal for image preview
        var imagePreview = document.getElementById(imagePreview);
        var aktuellesObj = findObj(modalImage);
        console.log(aktuellesObj.selectedTime);
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
            console.log(aktuellesObj.selectedTime);
            removeObjFromList(listAnzeige, aktuellesObj)
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

    function setupImagePicker(previewId, modalImageId, inputId, formID) {
        var lastFileName = null
        var modalImage = document.getElementById(modalImageId); // Modal for image preview
        var imageInput = document.getElementById(inputId); // File input
        var imagePreview = document.getElementById(previewId); // Image preview container
        // Find object and set initial state if required
        var aktuellesObj = findObj(inputId);
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
                let lastChar = selectedId[selectedId.length - 1];
                let closebtnID = '#closeBtn' + lastChar
                $(closebtnID).css("display", "block")
                $('#timerSelect' + lastChar).val(3)
                $('#timerSelect' + lastChar).prop('disabled', false);
                aktuellesObj.imageSet = true;
                var alwaysOnBtn = 'alwaysOnBtn' + lastChar
                var inputbtn = document.getElementById(alwaysOnBtn)
                var childElement = inputbtn.querySelector('input');
                childElement.disabled = false
                getImagePath(formID, aktuellesObj)
                this.value = '';
            })
        }
    }

    function findObj(id) {
        return CardObj.objList.find(obj => obj.id == id.charAt(id.length - 1));
    }
    //jQuerry Zone:
    $(document).ready(function() {
        $(document).on('click', 'button[id^="openModal"]', function() {
            const buttonId = $(this).attr('id'); //"openModal1"
            const modalId = buttonId.replace('openModal', 'myModal'); // e.g., "myModal1"
            const aktuellesObj = findObj(modalId)
            if (!aktuellesObj.imageSet) {
                return
            } else {
                $(`#${modalId}`).fadeIn(() => {
                    // Sobald das Modal sichtbar ist, den DateTimePicker fokussieren
                    const dateRangeId = modalId.replace('myModal', 'daterange');
                    $(`#${dateRangeId}`).focus(); // Fokus auf das Eingabefeld
                });
            }
        });
        // Close the modal when the "x" button is clicked
        $(document).on('click', '.close', function() {
            $(this).closest('.modal').fadeOut();
        });
        // Close the modal when clicking outside the modal content
        $(document).on('click', function(event) {
            const $target = $(event.target);
            if ($target.hasClass('modal')) { // Check if the clicked element has the "modal" class
                $target.fadeOut();
            }
        });
        $('button[id^="infoBtn"]').click(function() {
            // Hole die ID des geklickten Elements
            var eIDtimer = $(this).attr('id');
            const aktuellesObj = findObj(eIDtimer)
            console.log(eIDtimer);
            if (aktuellesObj.imageSet == true) {
                var eIDtimer = $(this).attr('id');
                console.log('Die ID des Elements ist: ' + eIDtimer);
                // Extrahiere die Nummer am Ende der ID (angenommen, ID hat das Format timerBtnX)
                let lastIndex = eIDtimer.replace('infoBtn', '');
                // Erstelle den ID-Selektor für das zugehörige Select-Element
                let timerselect = '#timerSelect' + lastIndex;
                console.log('Der Selektor ist: ' + timerselect);
                // Ändere den Stil des zugehörigen Select-Elements
                $(timerselect).css("display", "block");
                $('#' + eIDtimer).css("display", "block");
            }
        });
        $('input[id^="timerSelect"]').on('input', function() {
            var selectedValue = $(this).val();
            console.log(selectedValue);
            selectedValue = selectedValue * 1000
            let selectedId = $(this).attr('id');
            let lastChar = selectedId[selectedId.length - 1];
            var obj = findObj(lastChar)
            obj.isTimeSet = true
            obj.selectedTime = selectedValue
            console.log(obj.selectedTime);
        });
        //Ab hier geht es um den DateTimePicker
        $(function() {
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
            $(document).on('click', 'span[id^="daterange-icon"]', function() {
                const iconID = $(this).attr('id');
                const daterangeID = iconID.replace('daterange-icon', 'daterange'); // e
                $('#' + daterangeID).focus(); // Focus on input to trigger the picker  
            });
            $('input[id^="daterange"]').ready(function() {
                // Entferne die Klasse von allen Elementen mit der Klasse 'drp-selected'
                $(".drp-selected").removeClass("drp-selected");
            });
            // Update input field and display the selected date range when a date is selected
            // button nach bestätigen 
            $('input[id^="daterange"]').on('apply.daterangepicker', function(ev, picker) {
                selectedDateRange = picker.startDate.format('DD-MM-YYYY HH:mm') + '  -  ' + picker.endDate
                    .format('DD-MM-YYYY HH:mm');
                $(this).val(selectedDateRange); // Update input field
                $('#selected-daterange').text(selectedDateRange); // Display the selected date range below
                var obj = findObj(this.id)
                showData(obj, selectedDateRange);
                let date = picker.startDate.format('DD.MM') + '  -  ' + picker.endDate.format('DD.MM')
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
                $('#showDateInCard' + lastChar).text(dateText)
                $('#infoBtn' + lastChar).css("display", "block")
                console.log(34534535234532452345);

                let alwaysOnBtn = '#alwaysOnBtn' + lastChar
                $(alwaysOnBtn).css("display", "none");
            });
            // Clear input field and display when cancel is clicked
            $('input[id^="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val(''); // Clear the input
                $('#selected-daterange').text(''); // Clear the displayed text
                selectedDateRange = ''; // Reset the variable
            });
            // Set today's date on button click
            $('input[id^="daterange"]').on('show.daterangepicker', function(ev, picker) {
                let selectedrange = picker.startDate.format('DD.MM') + '  -  ' + picker.endDate.format('DD.MM')
                $(this).val(selectedrange);
            });
        });
    });
</script>

</html>