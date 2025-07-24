class Umgebung {
    ipAdresse = ""
    static id = 1;
    static umgebungsListe = [];
    static allCardList = [];
    static ipList = [];
    static nameList = [];
    static tempListForSaveCards = [];
    static currentSelect = 0;
    static listDataBase = [];
    check = false;
    static temp_remove = []
    static list = [];
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
        Umgebung.list.push(this);
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
        uncheckAllCheckboxes();
        var delInfo = document.getElementById("deleteInfotherminal")
        if (delInfo != null) {
            delInfo.innerHTML = "";
            this.list = [];
            // KEINE neuen Umgebung-Objekte hier erzeugen!
            const result = await readDatabase("selectInfotherminal");
            console.log("result: ", result);
            await result.forEach(listInfo => {
                // Nur hier neue Umgebung-Objekte erzeugen
                new Umgebung(listInfo[0], listInfo[1], listInfo[2]);
                delInfo.innerHTML += `<input type="checkbox" id="checkDelInfo${listInfo[0]}" name="${listInfo[1]}" onchange="Umgebung.event_remove(${listInfo[0]})"> ${listInfo[1]} - ${listInfo[2]} <br>`
            });
        }
        console.log(this.list);


    }
   
    static removeFromListViaID(id, list) {
        var temp = [];
        console.log(list);
        
       
        list.forEach(element => {
            if (element.id != id) {
                //ID muss aus Liste gelöscht werden
                temp.push(element);

            } else {
                // Verhindere das Löschen der Hauptumgebung (ID 0 - "Alle Schemas")
               if (element.id != 0) {
                    this.deletee(element.id, "deleteInfotherminal");
                    console.log("Das Element wurde gefunden und wird gelöscht! " + element.id);
                    // Delete muss in der Datenbank nun hier ausgefuehrt werden
                } else {
                    console.warn("Hauptumgebung (Alle Schemas) kann nicht gelöscht werden!");
                }
                return;
            }
        });
        return temp;
    }
    static event_remove(id) {
        var element = document.getElementById(`checkDelInfo${id}`);
        if (element.checked && !this.temp_remove.includes(id)) {
            this.list.forEach(checkID => {
                if (checkID.id == id) {
                    checkID.check = true
                    // console.log(checkID)
                }
            });
            this.temp_remove.push(id);
        }
        else {
            this.list.forEach(checkID => {
                if (checkID.id == id) {
                    checkID.check = false
                    // console.log(checkID)
                }
            });
            this.temp_remove.forEach(idd => {
                if (id != idd) {
                    this.eleListe.push(idd)
                }
            });
            this.temp_remove = this.eleListe
            this.eleListe = []
        }
        console.log(this.temp_remove);
    };

    static async deletee(idDelete, databaseUrl) {
        console.log("deletee wurde aufgerufen");
        try {
            const prepare = "?idDelete=" + idDelete;
            console.log(prepare);

            const response = await fetch(`/database/${databaseUrl}.php` + prepare);

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const responseText = await response.text();
            console.log("Delete Response:", responseText);

            // Versuche JSON zu parsen, falls möglich
            try {
                const jsonResponse = JSON.parse(responseText);
                console.log("Delete Result:", jsonResponse);
                return jsonResponse;
            } catch (jsonError) {
                // Falls kein JSON, gib Text zurück
                console.log("Non-JSON Response:", responseText);
                return { message: responseText };
            }
        } catch (error) {
            console.error("Fehler beim Löschen:", error);
            return { error: error.message };
        }

    }
    static async removeFromListLogik() {
        // DIese Methode wird aufgerufen sobald wir auf Minus (-) klicken
        // Hier benötigen wir die Aktuellen IDS der Datenbank zum löschen
        console.log(this.list);

        this.temp_remove.forEach(id => {
            this.list = this.removeFromListViaID(id, this.list);

        });
        this.temp_remove = []
        console.log(this.list);
    }

    static remove_generate() {
        this.removeFromListLogik();
        this.update();
    }
}

console.log("Umgebung.js loaded");

window.addEventListener("load", function () {
    var adminBereich = document.getElementById("adminBereich")
    if (adminBereich != null) {
        document.getElementById("adminBereich").addEventListener("click", async function () {
            const settingsPanel = document.getElementById("settingsPanel")
           
            Umgebung.temp_remove = [];
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
            const cardBodyDelInfo = document.getElementById("cardBodyForDelInfo");
            const delInfo = document.getElementById("deleteInfotherminal")
            console.log("deleteInfotherminal: ", delInfo);

            Umgebung.list.forEach(element => {
                delInfo.innerHTML += `<input type="checkbox" id="checkDelInfo${element.id}" name="${element.titel}" onchange="Umgebung.event_remove(${element.id})"> ${element.titel} - ${element.ipAdresse} <br>`
            });
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
