class Umgebung {
    ipAdresse = ""
      static id = 1;
    static umgebungsListe = [];
    static allCardList = [];
    static ipList = [];
    static nameList = [];
    static tempListForSaveCards = [];
    static allCardsInOneList = [];

    static check = false
    static list = [];
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

    
    static temp_remove = []
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
        var element = document.getElementById(`CHECK${id}`);
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

    static delete_checkbox() {
        alert("Geandert")
    }
    static removeFromListViaID(id, liste) {
        var temp = [];
        liste.forEach(element => {
            if (element.id != id) {
                //ID muss aus Liste gelöscht werden
                temp.push(element);

            } else {
                deletee(element.id);
                console.log("Das Element wurde gefunden und wird gelöscht! " + element.id);
                // Delete muss in der Datenbank nun hier ausgefuehrt werden

                return;
            }
        });
        return temp;
    }
    static removeFromListLogik() {
        // DIese Methode wird aufgerufen sobald wir auf Minus (-) klicken
        // Hier benötigen wir die Aktuellen IDS der Datenbank zum löschen
        this.temp_remove.forEach(id => {
            this.list = this.removeFromListViaID(id, Umgebung.umgebungsListe);

        });
        this.temp_remove = []
        console.log(this.list);
    }
    static remove_generate() {
        this.removeFromListLogik()
        this.update()
    }
    static async add() {
        var listeObj = []
        var alleObjVorhanden = true
        let ip = document.getElementById("modal_hinzufuegen_txtbox_ip");
        let title = document.getElementById("modal_hinzufuegen_txtbox_titel");


        listeObj.push(ip.value, title.value, beschreibung.value, von.value, bis.value)

        var prepare = "?ip=" + ip.value + "&titel=" + title.value + "&beschreibung=" + beschreibung.value + "&von=" + von.value + "&bis=" + bis.value;
        var result = await fetch("./db/insert.php" + prepare);

        listeObj.forEach(listValue => {
            if (listValue == "") {
                listeObj = []
                alleObjVorhanden = falseh
            }
        });
        if (alleObjVorhanden == false) {
            alert("bite alle Werte im Textbox eingeben")
            return
        }
        new Umgebung(ip.value, title.value, beschreibung.value, von.value, bis.value);
        Umgebung.update();
    }

    static update() {
        var anzeigebereichv = document.getElementById("anzeigebereichV")
        const anzeigebereicht = document.getElementById("tabelle")
       
        if (anzeigebereichv == null || anzeigebereicht == null) {
            return;
        }
        anzeigebereichv.innerHTML = ""
        anzeigebereicht.innerHTML = ""
        for (let i = 0; i < this.list.length; i++) {
            var ele = this.list[i]
            console.log(ele);


        }



        // selectFromDatabase("beispielPOST.php")
        for (let i = 0; i < this.list.length; i++) {
            const element = this.list[i];
            anzeigebereichv.innerHTML += `<div style="display: flex;">
                                <span name="${element.titel}" id="${element.id}" style="float: left;  margin-right: 10px;">${element.ipAdresse}</span>
                                <label for="Schulaula" clSs="text-wrap"value="15">${element.beschreibung}</label>
                            </div>
                            `;
            anzeigebereicht.innerHTML += `<tr>
                                                <td>${element.id}</td>
                                                <td>${element.ipAdresse}</td>
                                                <td>${element.titel}</td>
                                                <td>${element.beschreibung}</td>
                                                <td>${element.von}</td>
                                                <td>${element.bis}</td>
                                                <td><input type="checkbox" name="${element.id}" id="CHECK${element.id}" onchange="anzeigebereich.event_remove(${element.id})"></td>
                                           </tr>`
        }
    }
}

function wait(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}
function extractNumberFromString(str) {
    const match = str.match(/\d+$/);
    return match ? match[0] : null;
}
// Wait for DOM to be loaded


console.log("Umgebung.js wurde geladen...");



window.onload = function () {
    Umgebung.update();
    select()
}
function select() {
    getCuttedList = []
    fetch("/cardObjNew/database/selectUmgebung").then(async (response) => {
        var responseText = await response.text();
        cutAndCreate(responseText)
        Umgebung.update()


    });
}



function cutAndCreate(responseText) {
    var obj = responseText.split("],[");
    for (let i = 0; i < obj.length; i++) {
        var zeile = obj[i].replace("[[", "").replace("]]", "").replace("[", "").replace("]", "").replace(/"/g, '')
        const inZeile = zeile.split(",");
        new Umgebung(inZeile[0], inZeile[1], inZeile[2])
    }
}

document.getElementById("adminBereich").addEventListener("click", async function () {
    const settingsPanel = document.getElementById("settingsPanel")

    await fetch("./bereiche/adminbereich.php")
        .then(response => response.text())
        .then(html => {
            settingsPanel.innerHTML = html;
        });

    document.getElementById('formID').addEventListener('submit', function (event) {
        event.preventDefault(); // Standard-Submit verhindern


        const form = event.target;
        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(result => {
                // Optional: Rückmeldung anzeigen

                alert(result); // Hier können Sie eine Erfolgsmeldung anzeigen
                // z.B. Erfolgsmeldung anzeigen oder UI aktualisieren
            })
            .catch(error => {
                console.error('Fehler beim Hinzufügen:', error);
            });
    });
    const delInfo = document.getElementById("deleteInfotherminal")
    Umgebung.umgebungsListe.forEach(element => {
        delInfo.innerHTML += `<input type="checkbox" id="CHECK${element.id}" name="${element.titel}" onchange="Umgebung.event_remove(${element.id})"> ${element.titel} - ${element.ipAdresse} <br>`
    });
    const deleteBtn = document.createElement("button");
    deleteBtn.id = "deleteBtnForInfotherminal";
    deleteBtn.textContent = "löschen";

    deleteBtn.addEventListener("click", function () {
        Umgebung.remove_generate();
    });
    settingsPanel.appendChild(deleteBtn);



});


// Beispiel: Event Listener für alle CardObj-Formulare
// ...existing code...



function insert() {
    fetch("./db/insert.php").then(async (response) => {
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
    prepare = "?idDelete=" + idDelete;
    result = await fetch("/dashboard/cardObjNew/database/deleteInfotherminal" + prepare)
    var meow = await result.text()
    console.log(meow)
}