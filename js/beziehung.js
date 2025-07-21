class Beziehungen {
    static list = [];
    static temp_remove = [];
    static eleListe = [];
    static temp_add = [];
    static temp_list_add = [];
    static temp_list_remove = [];

    constructor(id, umgebungsID, cardObjektID) {
        this.id = id;
        this.umgebungsID = umgebungsID;
        this.cardObjektID = cardObjektID;
        Beziehungen.list.push(this);
    }
    static async getRelation() {
        const response = await fetch('database/selectRelation.php', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
        })
        var relationlistee = await response.json();
        return relationlistee;
    }


    static update(cardObjID) {

        console.log("Update wird aufgerufen mit CardObjektID: " + cardObjID);

        this.temp_list_add = [];
        this.temp_list_remove = [];

        leereListe(anzeigebereichv);
        leereListe(anzeigebereicht);
        leereListe(anzeigebereichD);

        this.createList(cardObjID)
        console.log("Temp Liste Add: " + this.temp_add);
        console.log("Temp Liste Remove: " + this.temp_remove);
        // for (let i = 0; i < this.temp_list.length; i++) {
        //     const element = this.temp_list[i];
        //     let obj = erstelleObj(element);
        //     if (!obj) {
        //         console.warn("Kein passendes Umgebung-Objekt gefunden für:", element);
        //         continue; // Überspringe diesen Durchlauf
        //     }
        //    
        //     // if (anzeigebereichD != null) {
        //     //     anzeigebereichD.innerHTML += `<tr>
        //     //         <td>${obj.id}</td>
        //     //         <td>${obj.ipAdresse}</td>
        //     //         <td>${obj.titel}</td>
        //     //         <td><input type="checkbox" name="${obj.id}" id="checkDel${obj.id}" onchange="Beziehungen.event_remove(${obj.id})"></td>
        //     //     </tr>`;
        //     // }

        // }

        this.createListForAnzeige();
    }
    static createListForAnzeige() {
        console.log("createListForAnzeige aufgerufen");
        // Display items to remove
        if (anzeigebereichD && this.temp_remove.length > 0) {
            this.temp_remove.forEach(umgebungsId => {
                let obj = erstelleObj(umgebungsId);
                if (obj) {
                    anzeigebereichD.innerHTML += `<tr>
                    <td>${obj.id}</td>
                    <td>${obj.ipAdresse}</td>
                    <td>${obj.titel}</td>
                    <td><input type="checkbox" name="${obj.id}" id="checkDel${obj.id}" onchange="Beziehungen.event_remove(${obj.id})"></td>
                </tr>`;
                }
            });
        }

        // Display items to add
        if (anzeigebereicht && this.temp_add.length > 0) {
            this.temp_add.forEach(umgebungsId => {
                let obj = erstelleObj(umgebungsId);
                if (obj) {
                    anzeigebereicht.innerHTML += `<tr>
                    <td>${obj.id}</td>
                    <td>${obj.ipAdresse}</td>
                    <td>${obj.titel}</td>
                    <td><input type="checkbox" name="${obj.id}" id="checkAdd${obj.id}" onchange="Beziehungen.event_add(${obj.id})"></td>
                </tr>`;
                }
            });
        }

        console.log("Temp Remove verarbeitet:", this.temp_remove);
        console.log("Temp Add verarbeitet:", this.temp_add);
    }
    static createList(cardObjID) {
        console.log("createList aufgerufen mit CardObjektID: " + cardObjID);
        // Clear arrays first
        this.temp_remove = [];
        this.temp_add = [];

        this.list.forEach(ele => {
            if (ele.cardObjektID == cardObjID) {
                console.log(`Beziehung gefunden: ${ele.id} mit CardObjektID: ${ele.cardObjektID}`);
                this.temp_remove.push(ele.umgebungsID);
            }
        });
        // Find available umgebungsIDs (not connected to this cardObjID)
        Umgebung.list.forEach(umgebung => {
            if (!this.temp_remove.includes(umgebung.id)) {
                this.temp_add.push(umgebung.id);
            }
        });
        console.log("Temp Remove:", this.temp_remove);
        console.log("Temp Add:", this.temp_add);
    }

    static event_remove(id) {
        console.log(`Event remove aufgerufen für ID: ${id}`);
        var element = document.getElementById(`checkDel${id}`);
        if (!this.temp_list_remove.includes(id)) {
            element.checked = true;
            this.temp_list_remove.push(id);
        } else {
            element.checked = false;
            this.temp_list_remove = this.temp_list_remove.filter(idd => id != idd);
        }
        console.log(this.temp_list_remove);
    }

    static event_add(id) {
        console.log(`Event add aufgerufen für ID: ${id}`);
        var element = document.getElementById(`checkAdd${id}`);
        if (!this.temp_list_add.includes(id)) {
            element.checked = true;
            this.temp_list_add.push(id);
        } else {
            element.checked = false;
            this.temp_list_add = this.temp_list_add.filter(idd => id != idd);
        }
        console.log(this.temp_list_add);
    }

    static removeFromListLogik(id, list, databaseUrl) {
        list.forEach(umgebungsID => {
            this.addToDatabaseViaID(id, umgebungsID, databaseUrl);
        });
        this.temp_remove = [];
        this.temp_list_add = [];
        this.temp_list_remove = [];
        this.temp_list = [];
    }

    static remove_generate(id, list, databaseUrl) {
        this.removeFromListLogik(id, list, databaseUrl);
        this.update(id);
    }

    static add_generate(id, list) {
        this.addToListLogik(id, list)
        this.update(id);
    }

    static addToDatabaseViaID(cardObjektID, umgebungsID, databaseUrl) {
        console.log("addToDatabaseViaID aufgerufen mit UmgebungsID:", umgebungsID, "CardObjektID:", cardObjektID);
        fetch(`/database/${databaseUrl}.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                umgebungsID: umgebungsID,
                cardObjektID: cardObjektID
            })
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.text();
            })
            .then(responseText => {
                try {
                    const jsonResponse = JSON.parse(responseText);
                    console.log("Daten erfolgreich hinzugefügt:", jsonResponse);
                } catch (jsonError) {
                    console.error("Fehler beim Parsen der Antwort:", jsonError);
                    console.log("Response Text:", responseText);
                }
            })
            .catch(error => {
                console.error("Fehler beim Hinzufügen der Daten:", error);
            });
    }
}

function leereListe(anzeigebereich) {
    if (anzeigebereich != null) {
        anzeigebereich.innerHTML = "";
    }
}
const anzeigebereichv = document.getElementById("anzeigebereichV");
const anzeigebereicht = document.getElementById("tabelleAdd");
const anzeigebereichD = document.getElementById("tabelleDelete");


window.addEventListener("load", async () => {
    const relationListe = await Beziehungen.getRelation();
    console.log(relationListe);
    relationListe.forEach(element => {
        new Beziehungen(element[0], element[1], element[2]);
    });
})
function erstelleObj(element) {
    let obj = undefined;
    Umgebung.list.forEach(umgebung => {
        if (umgebung.id === element) {
            obj = {
                titel: umgebung.titel,
                ipAdresse: umgebung.ipAdresse,
                id: umgebung.id,
            };

        }
    });
    return obj;
}