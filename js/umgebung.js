class Umgebung {
    ipAdresse = ""
    static id = 1;
    static umgebungsListe = [];
    static allCardList = [];
    static ipList = [];
    static nameList = [];
    static tempListForSaveCards = [];
    static allCardsInOneList = [];
    static currentSelect = 0;
    static listDataBase = [];
    check = false;
    static temp_list = []
    static eleListe = []
    static responseText = ""
    constructor(id, titel, ipAdresse) {
        this.id = id;
        this.cardCounter = 0;
        //HTMLOBJEKTE-------------------------
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
        this.umgebungsBodyList = [];
        //-------------------------------------
        this.htmlUmgebungsBody = `umgebungsBody${this.id}`;
        // this.ladeUmgebung(this.htmlUmgebungsBody);
        Umgebung.ipList.push(this.ipAdresse);
        Umgebung.allCardList.push(this.cardObjList);
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
    removeObjFromList(list, obj) {
        var index = list.findIndex(item => item.id === obj.id);
        if (index > -1) {
            list.splice(index, 1);
        }
    }
    ladeUmgebung(htmlUmgebungsBody) {
        rowForCards = document.getElementById("rowForCards");
        rowForCards.innerHTML += `
            <div id="${htmlUmgebungsBody}"></div>  
        `
    }
    lengthListCardObj() {
        var length = this.cardObjList.length
        return length
    }
    static loadAllCardObj() {
        Umgebung.allCardList.forEach(cardList => {
            cardList.forEach(cardObj => {
                cardObj.htmlUmgebungsBody(cardObj.umgebung);

            });
        });
    }
    static showCardObjList() {
        this.cardObjList.forEach(cardObj => {
            console.log(cardObj);
        });
    }
    static addObjToList(list, obj) {
        if (!list.some(e => e.id == obj.id)) {
            list.push(obj);
            console.log(`Object with id ${obj.id} added to list.`);
        }
    }
    static async update() {
        var delInfo = document.getElementById("deleteInfotherminal")
        if (delInfo != null) {
            console.log(this.umgebungsListe);
            delInfo.innerHTML = "";
            // KEINE neuen Umgebung-Objekte hier erzeugen!
            const result = await Crud.readDatabase("selectInfotherminal");
            console.log("result: ", result);
            await result.forEach(listInfo => {
                // Nur hier neue Umgebung-Objekte erzeugen
                new Umgebung(listInfo[0], listInfo[1], listInfo[2]);
                delInfo.innerHTML += `<input type="checkbox" id="checkDelInfo${listInfo[0]}" name="${listInfo[1]}" onchange="Crud.event_remove('umgebungsListe', this.id, ${listInfo[0]})"> ${listInfo[1]} - ${listInfo[2]} <br>`
            });
        }
        console.log(Umgebung.umgebungsListe);
    }
}

console.log("Umgebung.js loaded");

window.addEventListener("load", function () {
    var adminBereich = document.getElementById("adminBereich")
    if (adminBereich != null) {
        document.getElementById("adminBereich").addEventListener("click", async function () {
            const settingsPanel = document.getElementById("settingsPanel")
            Umgebung.temp_list = [];
            await fetch("bereiche/adminbereich.php")
                .then(response => response.text())
                .then(html => {
                    settingsPanel.innerHTML = html;
                });
            document.getElementById('formID').addEventListener('submit', function (event) {
                event.preventDefault(); // Standard-Submit verhindern

                const form = event.target;
                const formData = new FormData(form);
                console.log(form);
                console.log(formData);

                fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.text())
                    .then(result => {
                        // Optional: Rückmeldung anzeigen

                        alert(result); // Hier können Sie eine Erfolgsmeldung anzeigen
                        // z.B. Erfolgsmeldung anzeigen oder UI aktualisieren
                        if (result.includes("Datensatz erfolgreich eingefügt")) {
                            Umgebung.update();
                            document.querySelectorAll(".addInfotherminal input[type='text']").forEach(input => {
                                input.value = ""; // Eingabefelder leeren
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Fehler beim Hinzufügen:', error);
                    });
            });
            const delInfo = document.getElementById("deleteInfotherminal")
            console.log("deleteInfotherminal: ", delInfo);

            Umgebung.umgebungsListe.forEach(element => {
                delInfo.innerHTML += `<input type="checkbox" id="checkDelInfo${element.id}" name="${element.titel}" onchange="Crud.event_remove('umgebungsListe', this.id, ${element.id})"> ${element.titel} - ${element.ipAdresse} <br>`
            });
            const deleteBtn = document.createElement("button");
            deleteBtn.id = "deleteBtnForInfotherminal";
            deleteBtn.textContent = "löschen";

            deleteBtn.addEventListener("click", function () {
                Crud.remove_generate(Umgebung);

            });
            settingsPanel.appendChild(deleteBtn);
        });
    }
});



function wait(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

// Wait for DOM to be loaded

function select() {
    getCuttedList = []

    // Versuche verschiedene Pfade
    const possiblePaths = [
        "database/selectInfotherminal.php",
        "./database/selectInfotherminal.php",
        "/database/selectInfotherminal.php",
        "selectInfotherminal.php"
    ];
    async function tryFetch(paths, index = 0) {
        if (index >= paths.length) {
            console.error("Keine gültigen Pfade für selectInfotherminal.php gefunden");
            return;
        }
        try {
            console.log(`Versuche Pfad: ${paths[index]}`);
            const response = await fetch(paths[index]);

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const responseText = await response.text();
            console.log("Select Response:", responseText);
            cutAndCreate(responseText);
            Umgebung.update();
        } catch (error) {
            console.warn(`Pfad ${paths[index]} fehlgeschlagen:`, error.message);
            // Versuche nächsten Pfad
            await tryFetch(paths, index + 1);
        }
    }
    tryFetch(possiblePaths);
}
function cutAndCreate(responseText) {
    var obj = responseText.split("],[");
    for (let i = 0; i < obj.length; i++) {
        var zeile = obj[i].replace("[[", "").replace("]]", "").replace("[", "").replace("]", "").replace(/"/g, '')
        const inZeile = zeile.split(",");
        // new Umgebung(inZeile[0], inZeile[1], inZeile[2])
    }
}



// Event Listener für den Admin-Bereich


// Beispiel: Event Listener für alle CardObj-Formulare
// ...existing code...



function insert() {
    fetch("db/insert.php").then(async (response) => {
        this.responseText = await response.text();
        var obj = JSON.parse(this.responseText);
        var anzeigebereichv = document.getElementById("anzeigebereichV")
        var anzeigebereicht = document.getElementById("tabelle")
        obj.forEach(o => {
            anzeigebereichv.innerHTML += o + `<br>`
        });
        // RESULT: responseText => [[183,"0","aaa"],[186,"1","bbb"],[187,"2","ccc"],[184,"0","aaa"]]
    });
}
