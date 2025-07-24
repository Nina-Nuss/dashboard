let cancelUplaod = false
var zeitEingegeben = false
let pushDelete = false
let json;
let selectedCard = "";


window.onload = async function () {
            


    var selectUmgebung = document.getElementById("selectUmgebung");
    const deleteBtnForCards = document.getElementById("deleteBtnForCards");
    const UmgebungsTitel = document.getElementById("titelUmgebung")
    // const ersteAuswahl = selectUmgebung.querySelector('option');
    const denied = document.getElementById("umgebungsContainer");

    const plusBtn = document.getElementById("plusBtn");

    let counter = document.getElementById("counter");
    const saveBtn = document.getElementById("saveBtn")
    console.log("window.onload von index.js läuft!");
    // executeDeleteNull();

    createUmgebung()
    try {
        await createCardObj()
    } catch (error) {
        console.error("Fehler beim Erstellen der CardObjekte:", error);
    }

    // Modal Focus-Management hinzufügen
    setupModalFocusManagement();
   
    console.log("index_new.js wurde geladen");
    if (selectUmgebung != null) {
        selectUmgebung.addEventListener("change", function () {
            selectedUmgebung = sucheUmgebung(selectUmgebung.value);
            console.log(selectedUmgebung);
            plusBtn.disabled = false;
            updateAnzeigeCounter()
            console.log("wächsle umgebung");
            UmgebungsTitel.innerHTML = selectedUmgebung.titel;

            if (selectedUmgebung.id == 0) {
                showAllUmgebungen()
                disableInput(denied)
            } else {
                zeigeUmgebungAn(selectedUmgebung)
                disableInput(denied)
            }
        })
    }

    if (deleteBtnForCards != null) {
        deleteBtnForCards.addEventListener('click', function () {
            if (selectedUmgebung.tempListForDeleteCards.length == 0) {
                alert("wähle ein Object aus")
                return
            }
            selectedUmgebung.tempListForDeleteCards.forEach(cardObj => {
                cardObj.removeHtmlElement();
                selectedUmgebung.removeObjFromList(selectedUmgebung.cardObjList, cardObj);
                selectedUmgebung.removeObjFromList(selectedUmgebung.listAnzeige, cardObj);
                deleteCardObjDataBase(cardObj.id)
            });

            selectedUmgebung.tempListForDeleteCards = [];
            checkBoxShow();
            updateAnzeigeCounter()

        });
    }

    if (saveBtn != null) {
        saveBtn.addEventListener("click", function () {
            alert("Daten werden gespeichert")
            saveTempAddDatabase()
            Umgebung.allCardList.forEach(cardObjlist => {
                cardObjlist.forEach(cardObj => {
                    console.log(cardObj);
                    if (cardObj.update == true) {
                        console.log(cardObj.update);
                        cardObj.update = false
                        updateDataBase(cardObj)
                    }
                });
            });
        });
    }

    // Hier wird die startseite ausgewählt
    const infotherminalBereich = document.getElementById("infotherminalBereich");
    if (infotherminalBereich !== null) {
        infotherminalBereich.addEventListener("click", async function (event) {
            var settingPanel = document.getElementById("settingsPanel");
            const response = await fetch("bereiche/startSeite.php")
            const responseText = await response.text();
            settingPanel.innerHTML = responseText;
        });
    }


}


async function createUmgebung() {
    const resultUmgebung = selectObj("../database/selectInfotherminal.php")
    const data = await resultUmgebung
    Umgebung.list = [];
    data.forEach(umgebung => {
        var umgebungObj = new Umgebung(umgebung[0], umgebung[1], umgebung[2]);
    })
    var selectedUmgebung = Umgebung.list[1];
}

function extractNumberFromString(str) {
    const match = str.match(/\d+$/);
    return match ? match[0] : null;
}

async function readDatabase(databaseUrl) {
    const listUmgebung = await selectObj(`/database/${databaseUrl}.php`)
    return listUmgebung;
}

// Funktion zum Überprüfen, ob eine Checkbox oder switch aktiviert ist
function checkTrue(check) {
    var isChecked = document.getElementById(check).checked;
    if (isChecked) {
        console.log("Checkbox ist aktiviert");
        return true;
    } else {
        console.log("Checkbox ist deaktiviert");
        return false;
    }
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
async function createCardObj() {
    const response = await selectObj("../database/selectSchemas.php")
    let objList = convertCardObjForDataBase(response)

    objList.forEach(cardObj => {
        if(cardObj.imagePath == null || cardObj.imagePath == "null" || cardObj.imagePath == "") {
            cardObj.imagePath = "img/bild.png"; // Setze einen Standardwert,
        }else {
        const cardObjj = new CardObj(
            cardObj.id,
            cardObj.imagePath,
            cardObj.selectedTime,
            cardObj.isAktiv,
            cardObj.startTime,
            cardObj.endTime,
            cardObj.startDate,
            cardObj.endDate,
            cardObj.titel,
            cardObj.beschreibung
        )}
    });
    createBodyCardObj();
    console.log(CardObj.list);
}

function findObj(list, id) {
    const number = extractNumberFromString(id);
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
            titel: cardObj[8],
            beschreibung: cardObj[9]
        };
        objListe.push(obj)
    });
    return objListe
}
async function executeDeleteNull() {
    try {
        const response = await fetch("database/deleteNull.php", {
            method: "GET"
        });

        if (!response.ok) {
            throw new Error(`Fehler beim Ausführen der Anfrage: ${response.statusText}`);
        }

        const data = await response.json();
        console.log("Erfolgreich ausgeführt:", data);
    } catch (error) {
        console.error("Fehler:", error);
    }
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
    const response = await fetch('test.php', {
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
        const response = await fetch("json/sendToJson.php", {
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
function disableInput(container) {
    if (selectUmgebung.value == 0) {
        console.log("readonly wurde aufgerufen");
        container.style.pointerEvents = "none"; // Deaktiviert alle Interaktionen
        container.style.opacity = "0.7"; // Optional: Reduziert die Sichtbarkeit
    } else {
        console.log("readonly wurde deaktiviert");
        container.style.pointerEvents = "auto"; // Aktiviert alle Interaktionen
        container.style.opacity = "1"; // Optional: Setzt die Sichtbarkeit zurück
    }
}

function createID() {
    const cardObjIDList = CardObj.list
        .map(cardObj => parseInt(cardObj.id)) // Konvertiere alle IDs in Zahlen
        .filter(id => !isNaN(id)); // Entferne ungültige Werte (NaN)
    console.log("Gefilterte ID-Liste:", cardObjIDList);
    console.log(cardObjIDList)
    if (cardObjIDList.length === 0) {
        console.error("Die Liste ist leer. Es gibt keine gültigen IDs.");
        return 1; // Standardwert, falls keine IDs vorhanden sind
    }
    const groessteZahl = Math.max(...cardObjIDList);
    return groessteZahl + 1;
}



function saveTempAddDatabase() {
    Umgebung.tempListForSaveCards.forEach(cardObj => {
        insertDatabase(cardObj)
        console.log(cardObj.imagePath);
    });
    Umgebung.tempListForSaveCards = []
}


function checkSelectedUmgebung() {
    if (!selectedUmgebung || selectedUmgebung === "undefined") {
        console.error("Keine Umgebung ausgewählt!");
        return false; // Gibt false zurück, um anzuzeigen, dass die Umgebung nicht definiert ist
    }
    return true; // Gibt true zurück, wenn `selectedUmgebung` definiert ist
}

function zeigeUmgebungAn(selectedUmgebung) {
    console.log(selectedUmgebung.id);
    Umgebung.list.forEach(umgebung => {
        if (umgebung.id == selectedUmgebung.id) {
            document.getElementById("umgebungsBody" + umgebung.id).style.display = "block";
        } else {
            document.getElementById("umgebungsBody" + umgebung.id).style.display = "none";
        }
    });
}

function showAllUmgebungen() {
    document.querySelectorAll('[id^="umgebungsBody"]').forEach(item => {
        document.getElementById(item.id).style.display = "block";
    });
}





function deleteBtn() {
    const deleteBtns = document.querySelectorAll('[id^="deleteBtn"]');
    deleteBtns.forEach(deleteBtn => {
        deleteBtn.addEventListener('change', function () {
            const cardId = this.id.replace('deleteBtn', '');
            console.log(cardId);
            const cardObj = findObj(CardObj.allCardObjekte, cardId);
            const element = document.getElementById(cardObj.id);
            if (this.checked) {
                selectedUmgebung.tempListForDeleteCards.push(cardObj);
                console.log("checkInn");
                console.log(cardObj.id);

            } else {
                selectedUmgebung.removeObjFromList(selectedUmgebung.tempListForDeleteCards, cardObj);
                console.log("checkout");
            }
        });
    });
}

function saveCardObj() {
    umgebung.allCardList.forEach(cardObjlist => {
        cardObjlist.forEach(cardObj => {
            console.log(cardObj);
        });
    });
}

function sucheUmgebung(UmgebungsID) {
    let umgebung = Umgebung.list.find(umgebung => umgebung.id == UmgebungsID);
    return umgebung
}

function lengthListUmgebung() {
    var length = Umgebung.umgebungsIdList.length
    return length
}

async function updateDataBase(cardObj, databaseUrl) {
    // Erstellen eines FormData-Objekts
    try {
        console.log("updateDataBase wurde aufgerufen");
        const jsObj = JavaScriptCardObj(cardObj);
        const createJsObj = JSON.stringify(jsObj)
        console.log(jsObj);
        var result = await fetch(`database/${databaseUrl}.php`, {
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
        modal.addEventListener('show.bs.modal', function() {
            // Entferne aria-hidden vor dem Öffnen
            modal.removeAttribute('aria-hidden');
        });
        
        // Beim Schließen des Modals
        modal.addEventListener('hide.bs.modal', function() {
            // Blur alle fokussierten Elemente im Modal
            const focusedElement = modal.querySelector(':focus');
            if (focusedElement) {
                focusedElement.blur();
            }
        });
        
        // Nach dem Schließen des Modals
        modal.addEventListener('hidden.bs.modal', function() {
            // Setze aria-hidden erst nach dem vollständigen Schließen
            modal.setAttribute('aria-hidden', 'true');
        });
    });
}