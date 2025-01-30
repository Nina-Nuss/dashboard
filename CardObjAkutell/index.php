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
        <button id="saveBtn" type="button" class="btn bg-success d-block">save</button>
    </div>
    <div class="container d-flex">
        <div id="rowForCards" class="col-4 p-2"><!-- bild Obj --></div>
        <div id="rowForCarousels" class="img-thumbnail w-75 m-3">
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
        holeUmgebung().then(data => {
            data.forEach(umgebung => {
                var umgebung = new Umgebung(umgebung[0], umgebung[1]);
            })
        }).then(() => {
            ladenUmgebung();
        })
        holeCardObj().then(data => {
            data.forEach(cardObj => {
                switch (cardObj[3]) {
                    case "true":
                        cardObj[3] = true;
                    case "false":
                        cardObj[3] = false;
                    default:
                        cardObj[3] = false;
                }
                switch (cardObj[4]) {
                    case "true":
                        cardObj[4] = true;
                    case "false":
                        cardObj[4] = false;
                    default:
                        cardObj[4] = false;
                }
                switch (cardObj[5]) {
                    case "true":
                        cardObj[5] = true;
                    case "false":
                        cardObj[5] = false;
                    default:
                        cardObj[5] = false;
                }
                var obj = {
                    titel: cardObj[0],
                    imagePath: cardObj[1],
                    selectedTime: cardObj[2],
                    isTimeSet: cardObj[3], //True or false
                    imageSet: cardObj[4], //True or false
                    aktiv: cardObj[5], //True or false
                    startDateTime: cardObj[6],
                    endDateTime: cardObj[7]
                }

                Umgebung.umgebungsListe.forEach(umgebung => {
                    if (umgebung.titel == obj.titel) {
                        var cardObj = new CardObj(umgebung, obj.titel, obj.imagePath, obj.selectedTime, obj.isTimeSet, obj.imageSet, obj.aktiv, obj.startDateTime, obj.endDateTime);
                        //initializeDateRangePicker() muss immer nach aufruf eines CardObjektes aufgerufen werden
                        initializeDateRangePicker()
                    }
                })
                console.log(Umgebung.umgebungsListe);
            })

        })
        updateObj()
    }
    async function updateObj() {
        const listeUmgebung = await holeUmgebung()
        const listeCardObj = await holeCardObj()

        console.log(listeUmgebung);
        console.log(listeCardObj);
        Umgebung.umgebungsListe.forEach(e => {
            var prepare = "?ip=" + e.ipAdresse +
                "&titel=" + e.zugeordnet +
                "&isTimeSet=" + e.isTimeSet +
                "&imagePath=" + e.imagePath +
                "&imageSet=" + e.imageSet +
                "&startDateTime=" + e.startDateTime +
                "&endDateTime=" + e.endDateTime +
                "&aktiv=" + e.aktiv;

            listUpdate.push(prepare)
        });
        var result = await fetch("insert.php" + prepare);
    }

    async function holeUmgebung() {
        try {
            const response = await fetch("database/selectUmgebung.php", { // .php Extension hinzugefügt
                method: "GET",
                headers: {
                    "Content-Type": "application/json"
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const jsObject = await response.json();
            return jsObject;

        } catch (error) {
            console.error("Fehler beim Laden der Umgebung:", error);
            return null;
        }
    }
    async function holeCardObj() {
        const result = await fetch("database/selectCardObj.php", { // .php Extension hinzugefügt
            method: "GET",
            headers: {
                "Content-Type": "application/json"
            }
        });
        var cardobjlist = await result.json()
        return cardobjlist
    }

    function ladenUmgebung() {
        selectUmgebung.innerHTML = ``;
        selectUmgebung.innerHTML = `<option selected>Wähle Umgebung aus oder erstelle ein CardObj und füge es zur einer Umgebung hinzu</option>`;
        cardAnzeige.style.display = "none";
        console.log(Umgebung.umgebungsListe);
        Umgebung.umgebungsListe.forEach(umgebung => {
            selectUmgebung.innerHTML += `<option value="${umgebung.id}">${umgebung.titel}</option>`;
        });
    };

    function lengthListUmgebung() {
        var length = Umgebung.umgebungsIdList.length
        return length
    }

    function lengthListCardObj(umgebung) {
        var length = umgebung.cardObjList.length
        console.log(length);
        return length
    }

    const plusBtn = document.getElementById("plusBtn");
    const minusBtn = document.getElementById("minusBtn");
    let counter = document.getElementById("counter");

    plusBtn.addEventListener("click", function() {
        let currentCounter = parseInt(counter.innerHTML);
        if (currentCounter < 5) {
            if (selectedUmgebung != "undefined") {
                const newCardObj = new CardObj(selectedUmgebung, "", "", "", false, false, false, "", "");
                initializeDateRangePicker()
                console.log(newCardObj);
                counter.innerHTML = currentCounter + 1;
            }
        } else {
            return
        }
    });
    var selectUmgebung = document.getElementById("selectUmgebung");
    const deleteBtnForCards = document.getElementById("deleteBtnForCards");

    const ersteAuswahl = selectUmgebung.querySelector('option');

    selectUmgebung.addEventListener("change", function() {
        cardAnzeige.style.display = "block";
        var currendselect = selectUmgebung.querySelectorAll('option');
        if (selectUmgebung.selectedIndex != 0) {
            selectedUmgebung = sucheUmgebung(selectUmgebung.value);
            console.log(selectedUmgebung);
            plusBtn.disabled = false;
            updateAnzeigeCounter()
            console.log("wächsle umgebung");
            console.log(selectedUmgebung);
            // Entfernen der Option "Wähle Object aus
            zeigeUmgebungAn()
            Umgebung.startCarousels(selectedUmgebung)
        }
    })

    function cardSwitch(idBtn) {
        const cardId = idBtn.replace('alwaysOnBtn', '');
        const cardObj = Umgebung.findObj(cardId);
        const calenderBtn = document.querySelector(`#${cardObj.openModalButtonId}`);
        if (cardObj.aktiv == false && cardObj.imageSet == true) {
            cardObj.aktiv = true;
            selectedUmgebung.addCardObjToAnzeige(cardObj)
            calenderBtn.disabled = true
        } else {
            cardObj.aktiv = false;
            console.log(cardObj.aktiv);
            calenderBtn.disabled = false
            selectedUmgebung.removeObjFromList(selectedUmgebung.listAnzeige, cardObj)
        }
    }
    document.getElementById("saveBtn").addEventListener("click", function() {
        try {
            if (selectedUmgebung) {}
        } catch (error) {
            alert("Wähle ein Object aus")
            return
        }
        alert("Daten werden gespeichert")

        selectedUmgebung.cardObjList.forEach(cardObj => {
            insertDatabase(cardObj)
        });
    });

    function updateAnzeigeCounter() {
        var currentlength = lengthListCardObj(selectedUmgebung);
        console.log(currentlength);

        counter.innerHTML = currentlength;
    }
    minusBtn.addEventListener("click", function() {
        if (selectedUmgebung != "") {
            checkBoxShow();
        }
    });

    function zeigeUmgebungAn() {
        document.querySelectorAll('[id^="bodyForCards"]').forEach(item => {
            let lastIndexUmgebung = item.id.replace('bodyForCards', '');
            if (lastIndexUmgebung == selectedUmgebung.id) {
                document.getElementById(item.id).style.display = "block";
            } else {
                document.getElementById(item.id).style.display = "none";
            }
        });
        document.querySelectorAll('[id^="carousel"]').forEach(item => {
            let lastIndexUmgebung = item.id.replace('carousel', '');
            if (lastIndexUmgebung == selectedUmgebung.id) {
                console.log(lastIndexUmgebung);
                document.getElementById(item.id).style.display = "block";
            } else {
                document.getElementById(item.id).style.display = "none";
            }
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
                const cardObj = Umgebung.findObj(cardId);

                if (this.checked) {
                    selectedUmgebung.tempListForDeleteCards.push(cardObj);
                    console.log("checkInn");
                } else {
                    selectedUmgebung.removeObjFromList(selectedUmgebung.tempListForDeleteCards, cardObj);
                    console.log("checkout");
                }
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
    async function insertDatabase() {
        const cardObj = new FormData();
        const response2 = await fetch('sendToDatabase.php', {
            method: 'POST',
            body: cardObj
        })
        var result = await response2.text()
        console.log(result);
    }

    function sucheUmgebung(UmgebungsID) {
        let umgebung = Umgebung.umgebungsListe.find(umgebung => umgebung.id == UmgebungsID);
        return umgebung
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
            selectedUmgebung.removeObjFromList(selectedUmgebung.listAnzeige, aktuellesObj)
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
                let lastChar = selectedId[selectedId.length - 1];
                let closebtnID = '#closeBtn' + lastChar
                $(closebtnID).css("display", "block")
                $('#timerSelect' + lastChar).val(3)
                $('#timerSelect' + lastChar).prop('disabled', false);
                aktuellesObj.imageSet = true;
                var alwaysOnBtn = 'alwaysOnBtn' + lastChar
                var inputbtn = document.getElementById(alwaysOnBtn)
                inputbtn.disabled = false
                console.log(formID, aktuellesObj);
                getImagePath(formID, aktuellesObj)
                this.value = '';
            })
        }
    }
    //jQuerry Zone:
    function initializeDateRangePicker() {
        console.log(23423423423424234234234);

        $(document).on('click', 'button[id^="openModal"]', function() {
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
        $(document).on('click', '.close', function() {
            $(this).closest('.modal').fadeOut();
        });
        // schließt modal wenn außerhalb des modales geklickt wird
        $(document).on('click', function(event) {
            const $target = $(event.target);
            if ($target.hasClass('modal')) { // Check if the clicked element has the "modal" class
                $target.fadeOut();
            }
        });
        $('button[id^="infoBtn"]').click(function() {
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
        $('input[id^="timerSelect"]').on('input', function() {
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
        $(document).on('click', 'span[id^="daterange-icon"]', function() {
            const iconID = $(this).attr('id');
            const daterangeID = iconID.replace('daterange-icon', 'daterange');
            console.log(daterangeID);
            $('#' + daterangeID).focus(); // Focus on input to trigger the picker  
        });

        $('input[id^="daterange"]').ready(function() {
            // Entferne die Klasse von allen Elementen mit der Klasse 'drp-selected'
            $(".drp-selected").removeClass("drp-selected");
        });

        // Update input field and display the selected date range when a date is selected
        $('input[id^="daterange"]').on('apply.daterangepicker', function(ev, picker) {
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
        $('input[id^="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val(''); // Clear the input
            $('#selected-daterange').text(''); // Clear the displayed text
            selectedDateRange = ''; // Reset the variable
        });

        // Set today's date on button click
        $('input[id^="daterange"]').on('show.daterangepicker', function(ev, picker) {
            let selectedrange = picker.startDate.format('DD.MM') + '  -  ' + picker.endDate.format('DD.MM');
            $(this).val(selectedrange);
        });
    }
</script>

</html>