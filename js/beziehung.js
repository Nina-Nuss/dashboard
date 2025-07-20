class Beziehungen {
    static list = [];
    static temp_remove = [];
    static eleListe = [];
    static temp_list = [];
    static temp_list_add = [];

    constructor(id, umgebungsID, cardObjektID) {
        this.id = id;
        this.umgebungsID = umgebungsID;
        this.cardObjektID = cardObjektID;
        Beziehungen.list.push(this);
    }

    setUmgebung(umgebung) {
        this.umgebung = umgebung;
    }
    getUmgebung() {
        return this.umgebung;
    }
    getCardObjekt() {
        return this.cardObjekt;
    }
    setCardObjekt(cardObjekt) {
        this.cardObjekt = cardObjekt;
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
        const anzeigebereichv = document.getElementById("anzeigebereichV");
        const anzeigebereicht = document.getElementById("tabelleAdd");
        const anzeigebereichD = document.getElementById("tabelleDelete");
        console.log("Update wird aufgerufen mit CardObjektID: " + cardObjID);

        this.temp_list = [];
        this.temp_list_remove = [];
        console.log();

        this.list.forEach(element => {
            console.log(`Überprüfe Element: ${element.cardObjektID} mit CardObjektID: ${cardObjID}`);
            if (element.cardObjektID == cardObjID) {
                console.log(`Beziehung gefunden: ${element.id} mit CardObjektID: ${element.cardObjektID}`);
                this.temp_list.push(element);
            }
        });
        console.log("Temp Liste: " + this.temp_list);

        leereListe(anzeigebereichv);
        leereListe(anzeigebereicht);
        leereListe(anzeigebereichD);

        for (let i = 0; i < this.temp_list.length; i++) {
            const element = this.temp_list[i];
            let obj = erstelleObj(element);
            if (!obj) {
                console.warn("Kein passendes Umgebung-Objekt gefunden für:", element);
                continue; // Überspringe diesen Durchlauf
            }
            if (anzeigebereichv != null) {
                anzeigebereichv.innerHTML += `<div style="display: flex;">
                    <span name="${obj.titel}" id="${obj.id}" style="float: left;  margin-right: 10px;">${obj.ipAdresse}</span>
                    <label for="Schulaula" class="text-wrap" value="15">${obj.titel}</label>
                </div>`;
            }
            if (anzeigebereichD != null) {
                anzeigebereichD.innerHTML += `<tr>
                    <td>${obj.id}</td>
                    <td>${obj.ipAdresse}</td>
                    <td>${obj.titel}</td>
                    <td><input type="checkbox" name="${obj.id}" id="checkAdd${obj.id}" onchange="Beziehungen.event_remove( ${obj.id})"></td>
                </tr>`;
            }



            if (anzeigebereicht != null) {
                Umgebung.list.forEach(umgebung => {
                    const istInTempList = this.temp_list.some(beziehung => beziehung.umgebungsID == umgebung.id);
                    if (!istInTempList && !this.temp_list_add.includes(umgebung.id)) {
                        this.temp_list_add.push(umgebung.id);
                        anzeigebereicht.innerHTML += `<tr>
                            <td>${umgebung.id}</td>
                            <td>${umgebung.ipAdresse}</td>
                            <td>${umgebung.titel}</td>
                            <td><input type="checkbox" name="${umgebung.id}" id="checkAdd${umgebung.id}" onchange="Beziehungen.event_remove(${this.temp_remove}, ${umgebung.id})"></td>
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
                    this.deletee(element.umgebungsID, "deleteInfotherminal");
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

    static remove_generate(id) {
        console.log(Beziehungen.list);
        this.removeFromListLogik()
        this.update(id);
    }
}
function leereListe(anzeigebereich) {
    if (anzeigebereich != null) {
        anzeigebereich.innerHTML = "";
    }
}

function checkeID(obj) {


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
        if (umgebung.id === element.umgebungsID) {
            obj = {
                titel: umgebung.titel,
                ipAdresse: umgebung.ipAdresse,
                id: umgebung.id,
                umgebungID: element.umgebungsID,
                cardObjektID: element.cardObjektID,
            };

        }
    });
    return obj;
}