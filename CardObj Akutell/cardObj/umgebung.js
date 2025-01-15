console.log("test");

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
    static async startCarouselLoop(umgebungsObj) {
        console.log(umgebungsObj);
        let i = 0
        if (umgebungsObj != null) {
            var carouselInner = document.querySelector(`#${umgebungsObj.carousel}`);
            if (!carouselInner) {
                console.warn(`Carousel with ID #${umgebungsObj.carousel} not found`);
                return;
            }
        } else {
            return;
        }
        console.log(carouselInner);
        const carouselItems = carouselInner.querySelectorAll('.carousel-item');
        carouselItems.forEach(item => item.classList.remove('active'));

        if (carouselInner.length === 0) {
            console.warn('Keine Carousel-Elemente gefunden. Warten auf Aktualisierung...');
            await wait(1000);
            return;
        }
        // carouselItems[i].classList.add('active');
        // const interval = parseInt(carouselItems[i]?.dataset.interval) || 3000;
        // await wait(interval);
        // i = (i + 1) % carouselItems.length;
        // carouselItems = null;
    }

    static async repeatUpdateCarousel(umgebungsObj) {
        console.log(umgebungsObj);
        var carouselInner = document.querySelector(`#${umgebungsObj.carousel}`);
        console.log(carouselInner);
        carouselInner.innerHTML = '';
        if (carouselInner && umgebungsObj.listAnzeige.length > 0) {
            umgebungsObj.listAnzeige.forEach((obj, index) => {
                const isActive = index === 0 ? 'active' : '';
                carouselInner.innerHTML += `
                    <div class="carousel-item ${isActive}" data-interval="${obj.selectedTime}">
                        <img src="${obj.imagePath}" class="imagesCarousel d-block w-100" alt="Bild ${index + 1}">
                    </div>
                `;

            });
            console.log(umgebungsObj.listAnzeige);
        }
        if (updateInterval) {
            updateInterval = 20000
        }
        await wait(updateInterval);
        console.log(umgebungsObj.listAnzeige);
        console.log('Carousel wird aktualisiert...');
    }

    static async startCarousels() {
        const umgebungen = Umgebung.umgebungsIdList;
        while (true) {
            const promisesUpdate = umgebungen.map(umgebungObj => Umgebung.repeatUpdateCarousel(umgebungObj));
            await Promise.all(promisesUpdate); // Warten Sie, bis alle Carousels parallel aktualisiert wurden
            await wait(3000); // Warten Sie 300ms bevor die nächste Runde startet
            console.log("jetzt kommt startCarouselLoop");
            const promisesLoop = umgebungen.map(umgebungObj => Umgebung.startCarouselLoop(umgebungObj));
            await Promise.all(promisesLoop); // Warten Sie, bis alle Carousels parallel aktualisiert wurden
            await wait(3000); // Warten Sie 300ms bevor die nächste Runde startet
            console.log('Alle Carousels wurden aktualisiert...');
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
