
let rowForCards;
let carousels;
let updateInterval = 5000;

// Global functions
function wait(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}


// Wait for DOM to be loaded
document.addEventListener('DOMContentLoaded', function () {
    rowForCards = document.getElementById("rowForCards");
    carousels = document.getElementById("rowForCarousels");
});

class Umgebung {
    static id = 0;
    static umgebungsIdList = [];
    constructor() {
        this.id = Umgebung.id++;
        this.ci = 0
        this.cardObjList = [];
        this.tempListForDeleteCards = [];
        this.ipList = [];
        this.htmlCardObjList = [];
        this.listAnzeige = [];
        this.carousel = `carousel${this.id}`;
        this.htmlUmgebungsBody = `bodyForCards${this.id}`;
        this.ladeUmgebung();
        Umgebung.umgebungsIdList.push(this);
    }
    addCardObjs(cardObj) {
        this.cardObjList.push(cardObj);
    }
    addCardObjToAnzeige(cardObj) {
        if (!this.listAnzeige.some(e => e.id == cardObj.id)) {
            this.listAnzeige.push(cardObj);
        }
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
        for (let umgebung of Umgebung.umgebungsIdList) {
            const cardObj = umgebung.cardObjList.find(obj => obj.id == id.charAt(id.length - 1));
            if (cardObj) {
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
        if (updateInterval) {
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
        let curentIndex = umgebungsObj.ci;
        //wenn der letzte index der listAnzeige erreicht mit curentIndex erreicht ist, 
        //dann wird die while schleife abgebrochen 
        while (umgebungsObj.listAnzeige.length != 0 && curentIndex < umgebungsObj.listAnzeige.length && umgebungsObj != null) {
            curentIndex = (curentIndex + 1) % umgebungsObj.listAnzeige.length;
            const element = umgebungsObj.listAnzeige[curentIndex];
            console.log(element.selectedTime);
            if(element.selectedTime == "") {
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

    static async startCarousels() {
        while (true) {
            const umgebungen = Umgebung.umgebungsIdList;
            const promisesUpdate = umgebungen.map(umgebungObj => Umgebung.repeatUpdateCarousel(umgebungObj));
            await Promise.all(promisesUpdate);
            await wait(3000);
        }
    }
    static async checkUmgebungList() {
        while (true) {
            for (let i = 0; i < Umgebung.umgebungsIdList.length; i++) {
                const umgebung = Umgebung.umgebungsIdList[i]
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
