let cancelUplaod = false
var zeitEingegeben = false
let pushDelete = false
let json;
let selectedCard = "";
var anzeigebereichV = document.getElementById("anzeigebereichV");



window.onload = async function () {
    console.log("window.onload von index.js läuft!");

    const ipAdress = await getSystemPath();
    console.log("IP-Adresse:", ipAdress);


    try {
        await CardObj.update();
    } catch (error) {
        console.error("Fehler beim Erstellen der CardObjekte oder umgebungen:", error);
    }
    try {
        await Umgebung.update();

    } catch (error) {
        console.error("Fehler beim Aktualisieren der Umgebung:", error);
    }
    // Modal Focus-Management hinzufügen
    setupModalFocusManagement();
    // Hier wird die startseite ausgewählt
    erstelleNavigation();
}


function deakNavbarbtns() {
    try {
        const startBtnsContainer = document.getElementById("startBtns");
        const buttonsInContainer = startBtnsContainer.querySelectorAll("button");

        buttonsInContainer.forEach(button => {
            button.addEventListener("click", function () {
                console.log(`Button mit ID ${button.id} wurde geklickt`);

                // Alle Buttons aktivieren
                buttonsInContainer.forEach(btn => {
                    btn.disabled = false;
                });

                // Nur den geklickten Button deaktivieren
                button.disabled = true;
            });
        });

    } catch (error) {
        console.error("Fehler beim Laden der Seite:", error);
    }

}
function erstelleNavigation() {
    const infoterminalBereich = document.getElementById("infotherminalBereich");
    infoterminalBereich.addEventListener("click", async function (event) {
        window.location.href = 'startSeite.php';
    });
}




async function getSystemPath() {
    let path = null;
    try {
        const response = await fetch("../php/getSystemPath.php");
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        path = await response.text();
        console.log("System Path erhalten:", path);
    } catch (error) {
        console.error("Fehler beim Abrufen des Systempfads:", error);
        path = "/html_infoterminal/"; // Fallback-Pfad
    }
    return path;
}


function checkAnzahl() {
    const anzahlInfo = Umgebung.list.length;
    const anzahlCardObj = CardObj.list.length;
    console.log("Anzahl der Umgebungen:", anzahlInfo);
    console.log("Anzahl der CardObjekte:", anzahlCardObj);
    if (anzahlInfo > 0) {
        document.getElementById("selectUmgebung").disabled = false;
    } else {
        document.getElementById("selectUmgebung").disabled = true;
    }

}

function homeSeite() {
    window.location.href = 'index.php';
}

function extractNumberFromString(str) {
    const match = str.match(/\d+$/);
    return match ? match[0] : null;
}


async function readDatabase(databaseUrl) {
    const listUmgebung = await selectObj(`../database/${databaseUrl}.php`)
    return listUmgebung;
}


console.log("index_new.js wurde geladen");
function saveToLocalStorage(key, jsonData) {
    const jsonString = JSON.stringify(jsonData, null, 2); // Formatierung für bessere Lesbarkeit
    localStorage.setItem(key, jsonString);
}
function getJsonData(key) {
    const jsonData = localStorage.getItem(key);
    const obj = JSON.parse(jsonData);
    return obj
}


function showDateTime(type) {
    const zeitspannePanel = document.getElementById("zeitspannePanel");
    const uhrzeitPanel = document.getElementById("uhrzeitPanel");

    if (type === 'zeitspanne') {
        zeitspannePanel.style.display = "block";
        uhrzeitPanel.style.display = "none";
    } else if (type === 'uhrzeit') {
        zeitspannePanel.style.display = "none";
        uhrzeitPanel.style.display = "block";
    }
}




function findObj(list, id) {
    if (typeof id === "string") {
        var number = extractNumberFromString(id);
    } else {
        var number = id; // Falls id bereits eine Zeichenkette ist
    }

    if (!Array.isArray(list)) {
        console.warn('findObj: list ist kein Array');
        return null;
    }
    const found = list.find(cardObj => String(cardObj.id) === String(number));
    if (found) {
        found.update = true; // Optional: nur wenn du das Flag wirklich brauchst
        return found;
    }
    console.warn(`Objekt mit ID ${id} nicht gefunden.`);
    return null;
}



function convertCardObjForDataBase(cardObjListe) {
    objListe = []
    cardObjListe.forEach(cardObj => {
        var obj = {
            id: cardObj[0],
            imagePath: cardObj[1],
            selectedTime: cardObj[2], //True or false
            isAktiv: cardObj[3], //True or false
            startTime: cardObj[4],
            endTime: cardObj[5],
            startDate: cardObj[6],
            endDate: cardObj[7],
            timeAktiv: cardObj[8], //True or false
            dateAktiv: cardObj[9], //True or false
            titel: cardObj[10],
            beschreibung: cardObj[11]
        };
        objListe.push(obj)
    });
    return objListe
}

// Aufruf der Funktion

async function selectObj(select) {
    try {
        const response = await fetch(select, { // .php Extension hinzugefügt
            method: "GET",
            headers: {
                "Content-Type": "application/json"
            }
        });
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    } catch (error) {
        console.error("Fehler beim Laden der Umgebung:", error);
        return null;
    }
}
async function getImagePath(formID, ob) {
    const form = document.getElementById(formID);
    const formData = new FormData(form);
    const response = await fetch('/test.php', {
        method: 'POST',
        body: formData,
    })
    var path = await response.text()
    ob.imagePath = path
    return path
}

async function createJsonFile(jsonData) {
    if (jsonData.length === 0) {
        console.error("jsonData ist leer!");
        return;
    } else {
        const json = JSON.stringify(jsonData, null, 2);
        console.log(json);

    }
    try {
        const response = await fetch("/json/sendToJson.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: json
        });
        const responseData = await response.json();
        console.log("JSON-Daten gespeichert:", responseData);
    } catch (error) {
        console.error("Fehler beim Speichern der JSON-Daten:", error);
    }
}
function saveTempAddDatabase() {
    Umgebung.tempListForSaveCards.forEach(cardObj => {
        insertDatabase(cardObj)
        console.log(cardObj.imagePath);
    });
    Umgebung.tempListForSaveCards = []
}

function saveCardObj() {
    umgebung.allCardList.forEach(cardObjlist => {
        cardObjlist.forEach(cardObj => {
            console.log(cardObj);
        });
    });
}

async function updateDataBase(cardObj, databaseUrl) {
    // Erstellen eines FormData-Objekts
    try {
        console.log("updateDataBase wurde aufgerufen");
        const createJsObj = JSON.stringify(cardObj)
        var result = await fetch(`/database/${databaseUrl}.php`, {
            method: "POST",
            body: createJsObj
        });
        const responseText = await result.text();
        console.log("Antwort vom Server:", responseText);
    } catch (error) {
        console.error("Fehler in updateDataBase:", error);
    }
}



// Neue Funktion für Modal Focus-Management
function setupModalFocusManagement() {
    const modals = document.querySelectorAll('.modal');

    modals.forEach(modal => {
        // Beim Öffnen des Modals
        modal.addEventListener('show.bs.modal', function () {
            // Entferne aria-hidden vor dem Öffnen
            modal.removeAttribute('aria-hidden');
        });

        // Beim Schließen des Modals
        modal.addEventListener('hide.bs.modal', function () {
            // Blur alle fokussierten Elemente im Modal
            const focusedElement = modal.querySelector(':focus');
            if (focusedElement) {
                focusedElement.blur();
            }
        });

        // Nach dem Schließen des Modals
        modal.addEventListener('hidden.bs.modal', function () {
            // Setze aria-hidden erst nach dem vollständigen Schließen
            modal.setAttribute('aria-hidden', 'true');
        });
    });
}


function uncheckAllTableCheckboxes() {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });

    // Reset auch die temp_remove Liste
    if (Umgebung.temp_remove) {
        Umgebung.temp_remove = [];
    }
    if (CardObj.temp_remove) {
        CardObj.temp_remove = [];
    }



    console.log(`${checkboxes.length} Tabellen-Checkboxes wurden ausgeschaltet`);
}

