class CardObj {
    static idCounter = 1;
    constructor(umgebung, titel, ipAdresse, isTimeSet, imagePath, imageSet, startDateTime, endDateTime, aktiv) {
        this.id = CardObj.idCounter++;
        this.update = false;
 
        //AB hier kommt alles in die Datenbank rein:
        this.zugeordnet = titel
        this.ipAdresse = ipAdresse
        this.isTimeSet = isTimeSet //true or false
        this.imagePath = imagePath 
        this.imageSet = imageSet  //true or false
        this.startDateTime = startDateTime
        this.endDateTime = endDateTime
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
        this.infoCard = `showDateInCard${this.id}`
        this.shownInCarousel = `showInCarousel${this.id}`;
        this.closeBtn = `closeBtn${this.id}`
        this.sumbitBtnID = `submit${this.id}`;
        this.formID = `formID${this.id}`
        //-------------------------------------

        
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