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
    static check = false
    static listDataBase = [];

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

    static temp_list = []
    static temp_remove = []
    static temp_remove_info = []
    static temp_add = []
    static eleListe = []
    static responseText = ""

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
    static findObj(id) {
        const number = extractNumberFromString(id); // Extrahiere die ID
        console.log(`ID: ${number}`);

        for (const cardList of Umgebung.allCardList) {
            for (const cardObj of cardList) {
                if (cardObj.id == number) {
                    cardObj.update = true;
                    return cardObj; // Rückgabe des gefundenen Objekts
                }
            }
        }
        console.warn(`Objekt mit ID ${id} nicht gefunden.`);
        return null; // Rückgabe von null, wenn kein Objekt gefunden wurde
    }
    static event_remove(id) {
        var eleDelInfo = document.getElementById(`checkDelInfo${id}`);
        var eleAdd = document.getElementById(`checkAdd${id}`);
        var eleDel = document.getElementById(`checkDel${id}`);
        var element = ""
        
        if (eleDelInfo) {
            element = eleDelInfo
            this.temp_list = this.temp_remove_info
        } else if (eleAdd) {
            element = eleAdd
            this.temp_list = this.temp_remove
        } else if (eleDel) {
            element = eleDel
             this.temp_list = this.temp_remove
        }
        if (element.checked && !thistemp_list.includes(id)) {
            console.log(`Checkbox mit ID ${id} wurde aktiviert.`);

            this.umgebungsListe.forEach(checkID => {
                if (checkID.id == id) {
                    checkID.check = true
                    // console.log(checkID)
                }
            });
            this.temp_list.push(id);
            console.log(this.temp_list);

        }
        else {
            this.umgebungsListe.forEach(checkID => {
                if (checkID.id == id) {
                    checkID.check = false
                    // console.log(checkID)
                }
            });
            this.temp_list.forEach(idd => {
                if (id != idd) {
                    this.eleListe.push(idd)
                }
            });
            this.temp_list = this.eleListe
            this.eleListe = []
        }
        console.log(this.temp_list);
    };

    static removeFromListViaID(id, liste) {
        var temp = [];
        liste.forEach(element => {
            if (element.id != id) {
                //ID muss aus Liste gelöscht werden
                temp.push(element);

            } else {
                // Verhindere das Löschen der Hauptumgebung (ID 0 - "Alle Schemas")
                if (element.id != 0) {
                    deletee(element.id);
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
    static removeFromListLogik() {
        // DIese Methode wird aufgerufen sobald wir auf Minus (-) klicken
        // Hier benötigen wir die Aktuellen IDS der Datenbank zum löschen
        this.temp_list.forEach(id => {
            this.umgebungsListe = this.removeFromListViaID(id, Umgebung.umgebungsListe);

        });
        this.temp_list = []
        this.temp_remove = []
        this.temp_remove_info = []
        this.temp_add = []
        console.log(this.umgebungsListe);
    }


    static remove_generate() {
        console.log("remove_generate wurde aufgerufen");

        this.removeFromListLogik()
        this.update()
    }
    static async add_generate() {
        console.log("add_generate wurde aufgerufen");
        // Hier müssen wir die IDs der Datenbank abfragen und dann die Objekte hinzufügen
        this.temp_add.forEach(id => {
            this.umgebungsListe = this.removeFromListViaID(id, Umgebung.umgebungsListe);
            console.log("UmgebungsListe: ", this.umgebungsListe);
        });
        this.temp_add = []
        console.log(this.umgebungsListe);
        await Umgebung.update();
    }

    static async update() {
        var anzeigebereichv = document.getElementById("anzeigebereichV")
        const anzeigebereicht = document.getElementById("tabelleAdd")
        const anzeigebereichD = document.getElementById("tabelleDelete")
        var delInfo = document.getElementById("deleteInfotherminal")
        var selectAddUmgebung = document.getElementById("selectAddUmgebung")
        const anzeigebereichS = document.getElementById("anzeigebereichS")

        if (anzeigebereichv != null) {
            anzeigebereichv.innerHTML = ""
            var avvorhanden = true
        }
        if (anzeigebereicht != null) {
            anzeigebereicht.innerHTML = ""
            var atvorhanden = true
        }
        if (selectAddUmgebung != null) {
            selectAddUmgebung.innerHTML = "";
            var sAu = true
        }
        if (anzeigebereichD != null) {
            anzeigebereichD.innerHTML = "";
            var advorhanden = true
        }

        if (delInfo != null) {
            Umgebung.umgebungsListe = [];
            console.log("Umgebung.umgebungsListe: ", Umgebung.umgebungsListe.length);

            delInfo.innerHTML = ""
            console.log("Umgebung.umgebungsListe: ", Umgebung.umgebungsListe);

            // KEINE neuen Umgebung-Objekte hier erzeugen!
            await getInfothermianl().then(result => {
                // Umgebung.umgebungsListe vorher leeren, damit keine Duplikate entstehen
                console.log(Umgebung.umgebungsListe);
                result.forEach(listInfo => {
                    // Nur hier neue Umgebung-Objekte erzeugen
                    new Umgebung(listInfo[0], listInfo[1], listInfo[2]);
                    delInfo.innerHTML += `<input type="checkbox" id="checkDelInfo${listInfo[0]}" name="${listInfo[1]}" onchange="Umgebung.event_remove(${listInfo[0]})"> ${listInfo[1]} - ${listInfo[2]} <br>`
                });
                console.log(Umgebung.umgebungsListe);
            });
        }
        for (let i = 0; i < this.umgebungsListe.length; i++) {
            const element = this.umgebungsListe[i];
            if (sAu) {
                selectAddUmgebung.innerHTML += `<option value="${element.id}">${element.titel}</option>`;
            }
            if (avvorhanden) {
                anzeigebereichv.innerHTML += `<div style="display: flex;">
                                <span name="${element.titel}" id="${element.id}" style="float: left;  margin-right: 10px;">${element.ipAdresse}</span>
                                
                                <label for="Schulaula" clSs="text-wrap"value="15">${element.titel}</label>
                            </div>
                            `;
            }
            if (atvorhanden) {
                anzeigebereicht.innerHTML += `<tr>
                                                <td>${element.id}</td>
                                                <td>${element.ipAdresse}</td>
                                                <td>${element.titel}</td>
                                                <td><input type="checkbox" name="${element.id}" id="checkAdd${element.id}" onchange="Umgebung.event_remove(${element.id})"></td>
                                           </tr>`
            }
            if (advorhanden) {
                anzeigebereichD.innerHTML += `<tr>
                                                <td>${element.id}</td>
                                                <td>${element.ipAdresse}</td>
                                                <td>${element.titel}</td>
                                                <td><input type="checkbox" name="${element.id}" id="checkDel${element.id}" onchange="Umgebung.event_remove(${element.id})"></td>
                                           </tr>`
            }

        }
        if (selectAddUmgebung != null) {
            selectAddUmgebung.addEventListener("change", function () {
                console.log("Auswahl geändert:", selectAddUmgebung.value);
            });
        }

    }
}

console.log("Umgebung.js loaded");

window.addEventListener("load", function () {
    var adminBereich = document.getElementById("adminBereich")
    if (adminBereich != null) {
        document.getElementById("adminBereich").addEventListener("click", async function () {
            const settingsPanel = document.getElementById("settingsPanel")

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
                delInfo.innerHTML += `<input type="checkbox" id="checkDelInfo${element.id}" name="${element.titel}" onchange="Umgebung.event_remove(${element.id})"> ${element.titel} - ${element.ipAdresse} <br>`
            });
            const deleteBtn = document.createElement("button");
            deleteBtn.id = "deleteBtnForInfotherminal";
            deleteBtn.textContent = "löschen";

            deleteBtn.addEventListener("click", function () {
                Umgebung.remove_generate();

            });
            settingsPanel.appendChild(deleteBtn);
        });
    }
});


async function getInfothermianl() {
    listUmgebung = await selectObj("/database/selectInfotherminal.php")
    return listUmgebung;
}
function wait(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}
function extractNumberFromString(str) {
    const match = str.match(/\d+$/);
    return match ? match[0] : null;
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
        new Umgebung(inZeile[0], inZeile[1], inZeile[2])
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
async function deletee(idDelete) {
    console.log("deletee wurde aufgerufen");
    try {
        const prepare = "?idDelete=" + idDelete;
        console.log(prepare);

        const response = await fetch("/database/deleteInfotherminal.php" + prepare);

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