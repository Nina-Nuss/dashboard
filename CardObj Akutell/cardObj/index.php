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


    window.onload = function() {
        const umgebung1 = new Umgebung();
        const umgebung2 = new Umgebung();
        const umgebung3 = new Umgebung();

        var selectedUmgebung = umgebung1;
        const testCard = new CardObj(umgebung1);
        const testCard2 = new CardObj(umgebung1);
        const testCard3 = new CardObj(umgebung2);
        const testCard4 = new CardObj(umgebung2);
        ladenUmgebung()
        Umgebung.checkUmgebungList()
        Umgebung.startCarousels()
    }

    class CardObj {
        static idCounter = 0;
        constructor(umgebung) {
            this.id = CardObj.idCounter++;
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
            this.infoCard = `showDateInCard${this.id}`
            this.isTimeSet = false
            this.imagePath = ""
            this.imageSet = true
            this.startDateTime = ""
            this.endDateTime = ""
            this.closeBtn = `closeBtn${this.id}`
            this.sumbitBtnID = `submit${this.id}`;
            this.formID = `formID${this.id}`
            this.aktiv = true
            this.htmlKonstruktObjBody(umgebung)
            umgebung.addCardObjs(this)
        }
        htmlKonstruktObjBody(umgebung) {
            var htmlUmgebungsBody = document.getElementById(umgebung.htmlUmgebungsBody);
            htmlUmgebungsBody.innerHTML += `
            <div id="${this.id}" class="card m-1" style="width: 10rem;" >
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
                <button id="${this.openModalButtonId}" class="btn btn-light btn-sm modalBtn" data-toggle="modal" disabled>
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
                <div class="form-check form-switch align-self-end "  id="${this.alwaysOnBtn}">
                    <input  class="form-check-input pl-3" type="checkbox" role="switch" onclick="cardSwitch('${this.alwaysOnBtn}')" id="flexSwitchCheckDefault" checked>
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
            const element = document.getElementById(this.id);
            if (element) {
                element.remove();
            }
        }
    }

    // class Umgebung {
    //     static id = 0;
    //     static umgebungsIdList = [];
    //     constructor() {
    //         this.id = Umgebung.id++;
    //         this.cardObjList = [];
    //         this.tempListForDeleteCards = [];
    //         this.ipList = [];
    //         this.htmlCardObjList = [];
    //         this.listAnzeige = [];
    //         this.carousel = `carousel${this.id}`;
    //         this.htmlUmgebungsBody = `umgebungsBody${this.id}`
    //         this.ladeUmgebung();
    //         Umgebung.umgebungsIdList.push(this);
    //     }
    //     addCardObjs(cardObj) {
    //         this.cardObjList.push(cardObj);
    //     }
    //     addCardObjToAnzeige(cardObj) {
    //         if (!this.listAnzeige.some(e => e.id == cardObj.id)) {
    //             this.listAnzeige.push(cardObj);
    //         }
    //     }
    //     showCardObjList() {
    //         this.cardObjList.forEach(cardObj => {
    //             console.log(cardObj);
    //         }); // Implementieren Sie die Logik, um die Umgebung anzuzeigen
    //     }
    //     removeObjFromList(list, obj) {
    //         var index = list.findIndex(item => item.id === obj.id);
    //         if (index > -1) {
    //             list.splice(index, 1);
    //         }
    //     }
    //     ladeUmgebung() {
    //         rowForCards.innerHTML += `
    //             <div id="${this.htmlUmgebungsBody}"></div>  
    //         `
    //         carousel.innerHTML += `
    //             <div class="carousel-inner" id="${this.carousel}"></div>
    //         `
    //     }
    //     static findObj(id) {
    //         for (let umgebung of Umgebung.umgebungsIdList) {
    //             const cardObj = umgebung.cardObjList.find(obj => obj.id == id.charAt(id.length - 1));
    //             if (cardObj) {
    //                 return cardObj;
    //             }
    //         }
    //         return null;
    //     }

    // }


    function lengthListUmgebung() {
        var length = Umgebung.umgebungsIdList.length
        return length
    }

    function lengthListCardObj(selectedUmgebung) {
        var length = selectedUmgebung.cardObjList.length
        return length
    }

    const plusBtn = document.getElementById("plusBtn");
    const minusBtn = document.getElementById("minusBtn");
    let counter = document.getElementById("counter");

    plusBtn.addEventListener("click", function() {
        let currentCounter = parseInt(counter.innerHTML);
        if (currentCounter < 5) {
            if (selectedUmgebung != "") {
                const newCardObj = new CardObj(selectedUmgebung);
                initializeDateRangePicker()
                counter.innerHTML = currentCounter + 1;
            }
        } else {
            return
        }
    });
    const selectUmgebung = document.getElementById("selectUmgebung");
    const deleteBtnForCards = document.getElementById("deleteBtnForCards");

    function ladenUmgebung() {
        selectUmgebung.innerHTML = ``;
        selectUmgebung.innerHTML = `<option selected>Wähle Umgebung aus</option>`;
        Umgebung.umgebungsIdList.forEach(umgebung => {
            selectUmgebung.innerHTML += `<option value="${umgebung.id}">${umgebung.id}</option>`;
        });

    };


    selectUmgebung.addEventListener("change", function() {
        const selectedOption = selectUmgebung.value;
        if (selectedOption !== "Wähle Umgebung aus") {
            selectedUmgebung = sucheUmgebung(selectedOption);
            plusBtn.disabled = false;
            updateAnzeigeCounter()
            checkBoxShow();
            console.log("wächsle umgebung");
            console.log(selectedUmgebung);
            // Entfernen der Option "Wähle Object aus"
            const defaultOption = selectUmgebung.querySelector('option[selected]');
            if (defaultOption) {
                defaultOption.remove();
            }
            zeigeUmgebungAn()
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

    function updateAnzeigeCounter() {
        var currentlength = lengthListCardObj(selectedUmgebung);
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
        console.log(ob.imagePath);
    }

    function sucheUmgebung(UmgebungsID) {
        let umgebung = Umgebung.umgebungsIdList.find(umgebung => umgebung.id == UmgebungsID);
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
                getImagePath(formID, aktuellesObj)
                this.value = '';
            })
        }
    }
    //jQuerry Zone:
    function initializeDateRangePicker() {
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

            selectedUmgebung.addCardObjToAnzeige(obj)
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