let updateInterval = 5000; // Wie oft soll updateCarousel aufgerufen werden (10 Sekunden)?

// Funktion zum Warten
function wait(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

// Funktion zum Starten des Carousels
async function startCarouselLoop() {
    let i = 0;
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
async function repeatUpdateCarousel(umgebungObj) {
    var carouselInner = document.querySelector(`#carousel${umgebungObj.id}`);
    if (carouselInner) {
        // Leeren Sie den Inhalt des Carousel-Containers
        carouselInner.innerHTML = '';
        // Fügen Sie die Elemente der listAnzeige hinzu
        umgebungObj.listAnzeige.forEach((obj, index) => {
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
        updateInterval = 30000;
    }
    await wait(updateInterval); // Warten, bevor es erneut aktualisiert wird
    console.log('Carousel wird aktualisiert...');
}

// Carousel initialisieren und starten
async function startCarousels() {
    const umgebungen = Umgebung.umgebungsIdList;
    for (let umgebungObj of umgebungen) {
        repeatUpdateCarousel(umgebungObj); // Starten Sie jede Carousel-Aktualisierung ohne auf den Abschluss zu warten
    }
}

// Funktion zum Überprüfen der Umgebungsliste
async function checkUmgebungList() {
    while (true) {
        for (let i = 0; i < Umgebung.umgebungsIdList.length; i++) {
            const umgebung = Umgebung.umgebungsIdList[i];
            await checkUmgebung(umgebung);
            await wait(2000);
        }
    }
}

// Funktion zum Überprüfen einer Umgebung
async function checkUmgebung(umgebung) {
    if (umgebung.cardObjList.length == 0) {
        return;
    }
    for (let obj of umgebung.cardObjList) {
        if (obj.aktiv == true && obj.imageSet == true) {
            umgebung.addCardObjToAnzeige(umgebung.listAnzeige, obj);
        } else {
            umgebung.removeObjFromList(umgebung.listAnzeige, obj);
        }
    }
}

// Funktion zum Entfernen eines Objekts aus einer Liste
function removeObjFromList(list, obj) {
    let index = list.findIndex(e => e.id == obj.id);
    if (index != -1) {
        list.splice(index, 1); // Remove the object from the array
    }
}

// Funktion zum Hinzufügen eines Objekts zu einer Liste
function addObjToList(list, obj) {
    if (!list.some(e => e.id == obj.id)) {
        list.push(obj);
        console.log(`Object with id ${obj.id} added to list.`);
    }
}