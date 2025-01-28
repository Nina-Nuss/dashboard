let updateInterval = 5000;// Wie oft soll updateCarousel aufgerufen werden (10 Sekunden)?
// Funktion zum Erstellen der Carousel-Inhalte
// Funktion zum Warten

function wait(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}
// Funktion zum Starten des Carousels
async function startCarouselLoop() {
    let i = 0
    while (true) {
        var items = document.querySelectorAll('.carousel-item'); // Aktuelle Elemente abrufen
        // Wenn keine Elemente vorhanden sind, warten und fortsetzen
        if (items.length === 0) {
            console.warn('Keine Carousel-Elemente gefunden. Warten auf Aktualisierung...');
            await wait(1000); // Warten, bevor erneut geprüft wird
            continue;
        }
        // Alle Slides deaktivieren
        items.forEach(item => item.classList.remove('active'));
        // Aktuelles Slide aktivieren
        items[i].classList.add('active');
        // Intervall des aktuellen Slides abrufen
        const interval = parseInt(items[i]?.dataset.interval) || 3000;
        // Warten, bevor zum nächsten gewechselt wird
        await wait(interval);
        // Index für das nächste Slide berechnen
        i = (i + 1) % items.length;
        items = null;

    }

}
// Funktion zum wiederholten Aktualisieren des Carousels
async function repeatUpdateCarousel(umgebungsObj) {
    var carouselInner = document.querySelector(`#carousel${umgebungsObj.id}`);
    if (carouselInner) {
        // Leeren Sie den Inhalt des Carousel-Containers

        // Fügen Sie die Elemente der listAnzeige hinzu
        umgebungsObj.listAnzeige.forEach((obj, index) => {
            const isActive = index === 0 ? 'active' : ''; // Das erste Element ist aktiv
            carouselInner.innerHTML += `
                            <div class="carousel-item ${isActive}" data-interval="${obj.selectedTime}">
                                <img src="${obj.imagePath}" class="imagesCarousel d-block w-100" alt="Bild ${index + 1}">
                            </div>
                        `;
        });
    }
    console.log(carouselInner);
    if (updateInterval == 5000) {
        updateInterval = 20000
    }
    await wait(updateInterval); // Warten, bevor es erneut aktualisiert wird
    console.log(umgebungsObj.listAnzeige);
    console.log('Carousel wird aktualisiert...');
}

async function carouselLeeren() {
    while (true) {
        await wait(30000);
        var allCarousel = document.querySelectorAll('[id^="carousel"]');
        allCarousel.forEach(carouselInner => {
            carouselInner.innerHTML = ''; // Leeren Sie den Inhalt des Carousel-Containers
        });
        console.log('Carousel geleert...');
    }
}
// Carousel initialisieren und starten
window.onload = function () {
    ladenUmgebung();
    checkUmgebungList();
    startCarousels();
    startCarouselLoop(); //Carousel starten
    carouselLeeren();//30 Sekunden warten und dann Carousel leeren
}


async function startCarousels() {
    const umgebungen = Umgebung.umgebungsIdList;
    while (true) {
        const promises = umgebungen.map(umgebungObj => repeatUpdateCarousel(umgebungObj));
        await Promise.all(promises); // Warten Sie, bis alle Carousels parallel aktualisiert wurden
        await wait(3000); // Warten Sie 300ms bevor die nächste Runde startet
        console.log('Alle Carousels wurden aktualisiert...');
        
        
    }
}
async function checkUmgebungList() {
    while (true) {
        for (let i = 0; i < Umgebung.umgebungsIdList.length; i++) {
            const umgebung = Umgebung.umgebungsIdList[i]
            await checkUmgebung(umgebung);
            await wait(2000);
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
function removeObjFromList(list, obj) {
    let index = list.findIndex(e => e.id == obj.id);
    if (index != -1) {
        list.splice(index, 1); // Remove the object from the array
    }
}
function addObjToList(list, obj) {
    if (!list.some(e => e.id == obj.id)) {
        list.push(obj);
        console.log(`Object with id ${obj.id} added to list.`);
    }
}