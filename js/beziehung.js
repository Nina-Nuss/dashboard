

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


    static async update(cardObjID) {
        this.list = [];
         var anzeigebereichV = document.getElementById("anzeigebereichV");
        const relationListe = await Beziehungen.getRelation();
        console.log(relationListe);
        relationListe.forEach(element => {
            new Beziehungen(element[0], element[1], element[2]);
        });

        this.temp_remove = [];
        this.temp_list_add = [];
        this.temp_list_remove = [];
        this.temp_list = [];
        console.log("Update wird aufgerufen mit CardObjektID: " + cardObjID);

        leereListe(anzeigebereichV);
        leereListe(anzeigebereicht);
        leereListe(anzeigebereichD);
        leereListe(anzeigebereicht);

        this.createList(cardObjID)
        console.log("Temp Liste Add: " + this.temp_add);
        console.log("Temp Liste Remove: " + this.temp_remove);
        if(CardObj.selectedID != null) {
            this.createListForAnzeige();
        }
    
    }

    static createListForAnzeige() {
        console.log("createListForAnzeige aufgerufen");
        var anzeigebereichV = document.getElementById("anzeigebereichV");
        // Display items to remove
        if (anzeigebereichD && this.temp_remove.length > 0) {
            this.temp_remove.forEach(umgebungsId => {
                let obj = erstelleObj(umgebungsId);
                if (obj) {
                    anzeigebereichD.innerHTML += `<tr>
                    <td>${obj.id}</td>
                    <td>${obj.ipAdresse}</td>
                    <td>${obj.titel}</td>
<<<<<<< HEAD
                    <td><input type="checkbox" name="${obj.id}" id="checkAdd${obj.id}" onchange="Beziehungen.event_remove( ${obj.id})"></td>
=======
                    <td><input type="checkbox" name="${obj.id}" id="checkDel${obj.id}" onchange="Beziehungen.event_remove(${obj.id})"></td>
>>>>>>> beta
                </tr>`;

<<<<<<< HEAD


            if (anzeigebereicht != null) {
                Umgebung.list.forEach(umgebung => {
                    const istInTempList = this.temp_list.some(beziehung => beziehung.umgebungsID == umgebung.id);
                    if (!istInTempList && !this.temp_list_add.includes(umgebung.id)) {
                        this.temp_list_add.push(umgebung.id);
                        anzeigebereicht.innerHTML += `<tr>
                            <td>${umgebung.id}</td>
                            <td>${umgebung.ipAdresse}</td>
                            <td>${umgebung.titel}</td>
                            <td><input type="checkbox" name="${umgebung.id}" id="checkAdd${umgebung.id}" onchange="Beziehungen.event_remove( ${umgebung.id})"></td>
                        </tr>`;
                    }
                });
            }
        }
    }


    static removeFromListViaID(id, list) {
        var temp = [];
        list.forEach(element => {
            if (element.umgebungsID != id) {
                temp.push(element);
            } else {
                if (element.umgebungsID != 0) {
                    // this.deletee(element.umgebungsID, "deleteInfotherminal");
                    console.log("Das Element wurde gefunden und wird gelöscht! " + element.umgebungsID);
                } else {
                    console.warn("Hauptumgebung (Alle Schemas) kann nicht gelöscht werden!");
                }
                return;
            }
        });
        return temp;
    }

    static event_remove(id) {
        
        var element = document.getElementById(`checkAdd${id}`);
        if (element.checked && !this.temp_list_remove.includes(id)) {
            this.list.forEach(checkID => {
                if (checkID.id == id) {
                    checkID.check = true;
                }
            });
            this.temp_list_remove.push(id);
        } else {
            this.temp_list_remove.forEach(checkID => {
                if (checkID.id == id) {
                    checkID.check = false;
                }
            });
            this.temp_list_remove = this.temp_list_remove.filter(idd => id != idd);
        }
        console.log(this.temp_list_remove);
    }
    


    static async deletee(idDelete, databaseUrl) {
        console.log("deletee wurde aufgerufen");
        try {
            const prepare = "?idDelete=" + idDelete;
            const response = await fetch(`/database/${databaseUrl}.php` + prepare);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const responseText = await response.text();
            try {
                const jsonResponse = JSON.parse(responseText);
                return jsonResponse;
            } catch (jsonError) {
                return { message: responseText };
            }
        } catch (error) {
            return { error: error.message };
        }
    }

    static removeFromListLogik() {
        this.temp_list_remove.forEach(id => {
            this.list = this.removeFromListViaID(id, this.list);
        });
        this.temp_list_remove = [];
        this.temp_list = [];

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

        if (anzeigebereichV != null) {
            console.log("anzeigebereichv ist nicht null, füge Elemente hinzu");
            this.temp_remove.forEach(umgebungsId => {
                let obj = erstelleObj(umgebungsId);
                if (obj) {
                    anzeigebereichV.innerHTML += `<div style="display: flex;">
                    <span name="${obj.titel}" id="${obj.id}" style="float: left;  margin-right: 10px;">${obj.ipAdresse}</span>
                    <label for="Schulaula" class="text-wrap" value="15">${obj.titel}</label>
                </div>`;
                }
            });
        } else {
            console.log("anzeigebereichV ist null, keine Elemente hinzugefügt");
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
>>>>>>> beta
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

    static async removeFromListLogik(id, list, databaseUrl) {
        for (const umgebungsID of list) {
            await this.addToDatabaseViaID(id, umgebungsID, databaseUrl);
        };
    }

    static async remove_generate(id, list, databaseUrl) {
        if (CardObj.selectedID == null || id === undefined || list === undefined || databaseUrl === undefined) {
            return;

        }
        console.log("remove_generate aufgerufen mit ID:", id, "List:", list, "Database URL:", databaseUrl);
        await this.removeFromListLogik(id, list, databaseUrl);

        this.update(id);
    }

    static async addToDatabaseViaID(cardObjektID, umgebungsID, databaseUrl) {
        console.log("addToDatabaseViaID aufgerufen mit UmgebungsID:", umgebungsID, "CardObjektID:", cardObjektID);
        await fetch(`/database/${databaseUrl}.php`, {
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
const anzeigebereicht = document.getElementById("tabelleAdd");
const anzeigebereichD = document.getElementById("tabelleDelete");


function leereListe(anzeigebereich) {
    if (anzeigebereich != null) {
        anzeigebereich.innerHTML = "";
    }
}


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

