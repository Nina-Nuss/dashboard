
// Umgebung = Schema
class Umgebung {
    static id = 0;
    static umgebungsListe = [];
    static ipList = [];
    static nameList = [];
    constructor(ipAdresse, titel) {
        this.id = Umgebung.id++;
       
        //HTMLOBJEKTE-------------------------
        this.carousel = `carousel${this.id}`;
        this.htmlUmgebungsBody = `bodyForCards${this.id}`;
        //-------------------------------------

        //AB hier kommt alles in die Datenbank rein:
        this.ipAdresse = ipAdresse;
        this.titel = titel
        //-------------------------------------

        
        //Listen-------------------------------
        this.cardObjList = [];
        this.tempListForDeleteCards = [];
        this.htmlCardObjList = [];
        this.listAnzeige = [];
        //-------------------------------------

        this.ladeUmgebung();
        Umgebung.ipList.push(this.ipAdresse);
        Umgebung.umgebungsListe.push(this);

    }
    addCardObjs(cardObj) {
        this.cardObjList.push(cardObj);
    }
    addCardObjToAnzeige(cardObj) {
        if (!this.listAnzeige.some(e => e.id == cardObj.id)) {
            this.listAnzeige.push(cardObj);
        }
    }
    static createCardObj(umgebung){
        Umgebung.cardObjList.forEach(cardObj => {
            var cardObj = new CardObj(umgebung);
            console.log(cardObj);
        });
    }

    static showCardObjList() {
        this.cardObjList.forEach(cardObj => {
            console.log(cardObj);
        });
    }
    removeObjFromList(list, obj) {
        var index = list.findIndex(item => item.id === obj.id);
        if (index > -1) {
            list.splice(index, 1);
        }
    }
    ladeUmgebung() {
        rowForCards.innerHTML += `
            <div id="${this.htmlUmgebungsBody}"></div>  
        `
        carousels.innerHTML += `
            <div class="carousel-inner" id="${this.carousel}"></div>
        `
    }
    static addObjToList(list, obj) {
        if (!list.some(e => e.id == obj.id)) {
            list.push(obj);
            console.log(`Object with id ${obj.id} added to list.`);
        }
    }
    static findObj(id) {
        for (let umgebung of Umgebung.umgebungsListe) {
            const cardObj = umgebung.cardObjList.find(obj => obj.id == id.charAt(id.length - 1));
            if (cardObj) {
                cardObj.update = true;
                return cardObj;
            }
        }
        return null;
    }
    static async carouselLeeren() {
        while (true) {
            await wait(30000);
            var allCarousel = document.querySelectorAll('[id^="carousel"]');
            allCarousel.forEach(carouselInner => {
                carouselInner.innerHTML = '';
            });
            console.log('Carousel geleert...');
        }
    }
    async moveToNextPic(cardObj) {
        await wait(cardObj.selectedTime);
        this.ci = (this.ci + 1) % this.listAnzeige.length;
    }

    static async repeatUpdateCarousel(umgebungsObj) {
        var carouselInner = document.querySelector(`#${umgebungsObj.carousel}`);
        carouselInner.innerHTML = '';
        if (carouselInner && umgebungsObj.listAnzeige.length > 0) {
            umgebungsObj.listAnzeige.forEach((cardObj, index) => {
                carouselInner.innerHTML += `
                    <div class="d-none" id="${cardObj.shownInCarousel}">
                        <img src="${cardObj.imagePath}" class="w-100" alt="aktuelles Bild: ${index + 1}">
                    </div>
                `;
            });
        }
        if (updateInterval == 5000) {
            updateInterval = 5000
        }
        await wait(updateInterval);
        console.log(`Carousel von Umgebung ${umgebungsObj.id} wird aktualisiert...`);
        await Umgebung.startCarouselLoop(umgebungsObj);

    }
    static async startCarouselLoop(umgebungsObj) {
        if (umgebungsObj.listAnzeige.length == 0) {
            return;
        }
        console.log(umgebungsObj);
        let i = umgebungsObj.ci;
        //wenn der letzte index der listAnzeige erreicht mit curentIndex erreicht ist, 
        //dann wird die while schleife abgebrochen 
        while (umgebungsObj.listAnzeige.length != 0 && i < umgebungsObj.listAnzeige.length && umgebungsObj != null) {
            i = (i + 1) % umgebungsObj.listAnzeige.length;
            const element = umgebungsObj.listAnzeige[i];
            console.log(element.selectedTime);
            if (element.selectedTime == "") {
                element.selectedTime = 3000
            }
            try {
                const inner = document.getElementById(element.shownInCarousel);
                inner.classList.remove("d-none");
                await wait(element.selectedTime);
                inner.classList.add("d-none");
            } catch (error) {
                console.log(error);
                return
            }
        }
    }

    static async startCarousels(selectedUmgebung) {
        console.log(selectedUmgebung);

        await wait(3000);
    }
    static async checkUmgebungList() {
        while (true) {
            for (let i = 0; i < Umgebung.umgebungsListe.length; i++) {
                const umgebung = Umgebung.umgebungsListe[i]
                await checkUmgebung(umgebung);
                await wait(2000);
            }
        }
    }
}
async function checkUmgebung(umgebung) {
    if (umgebung.cardObjList.length == 0) {
        return;
    }
    for (let obj of umgebung.cardObjList) {
        if (obj.aktiv == true && obj.imageSet == true) {
            umgebung.addCardObjToAnzeige(obj);
        } else {
            umgebung.removeObjFromList(umgebung.listAnzeige, obj);
        }
    }
}

let rowForCards;
let carousels;
let updateInterval = 5000;


async function sendListToServer(list, umgebung) {
    try {
        const response = await fetch(umgebung, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(list)
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const result = await response.json();
        console.log('Erfolg:', result);
    } catch (error) {
        console.error('Fehler beim Senden:', error);
    }
}

// Global functions
function wait(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

// Wait for DOM to be loaded
document.addEventListener('DOMContentLoaded', function () {
    rowForCards = document.getElementById("rowForCards");
    carousels = document.getElementById("rowForCarousels");
});



