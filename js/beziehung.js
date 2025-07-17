
class Beziehungen {
    static list = [];
    static temp_remove = [];
    static eleListe = [];
    static temp_list = [];
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

    static update() {
        const anzeigebereichv = document.getElementById("anzeigebereichV");
        const anzeigebereicht = document.getElementById("tabelleAdd");
        const anzeigebereichD = document.getElementById("tabelleDelete");
        console.log("Update der Beziehung: " + this.id);
        this.temp_list = [];
        this.list.forEach(element => {
            if (element.cardObjektID === this.id) {
                console.log(`Beziehung gefunden: ${element.id} mit CardObjektID: ${element.cardObjektID}`);
                this.temp_list.push(element);
            }
        });
        leereListe(anzeigebereichv);
        leereListe(anzeigebereicht);
        leereListe(anzeigebereichD);

        for (let i = 0; i < this.temp_list.length; i++) {
            const element = this.temp_list[i];
            let obj = erstelleObj(element);
            if (anzeigebereichv != null) {
                anzeigebereichv.innerHTML += `<div style="display: flex;">
                    <span name="${obj.titel}" id="${obj.id}" style="float: left;  margin-right: 10px;">${obj.ipAdresse}</span>
                    <label for="Schulaula" class="text-wrap" value="15">${obj.titel}</label>
                </div>`;
            }
            if (anzeigebereicht != null) {
                anzeigebereicht.innerHTML += `<tr>
                    <td>${obj.id}</td>
                    <td>${obj.ipAdresse}</td>
                    <td>${obj.titel}</td>
                    <td><input type="checkbox" name="${obj.id}" id="checkAdd${obj.id}" onchange="beziehung.event_remove(${obj.id})"></td>
                </tr>`;
            }
            if (anzeigebereichD != null) {
                Umgebung.list.forEach(element => {
                    if (element.id !== obj.umgebungID) {
                        anzeigebereichD.innerHTML += `<tr>
                            <td>${element.id}</td>
                            <td>${element.ipAdresse}</td>
                            <td>${element.titel}</td>
                            <td><input type="checkbox" name="${element.id}" id="checkDel${element.id}" onchange="beziehung.event_remove(${element.id})"></td>
                        </tr>`;
                    }
                });
            }
        }
    }

    static removeFromListViaID(id, list) {
        var temp = [];
        list.forEach(element => {
            if (element.id != id) {
                temp.push(element);
            } else {
                if (element.id != 0) {
                    this.deletee(element.id, "deleteInfotherminal");
                    console.log("Das Element wurde gefunden und wird gelöscht! " + element.id);
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
        if (element.checked && !this.temp_remove.includes(id)) {
            this.list.forEach(checkID => {
                if (checkID.id == id) {
                    checkID.check = true;
                }
            });
            this.temp_remove.push(id);
        } else {
            this.list.forEach(checkID => {
                if (checkID.id == id) {
                    checkID.check = false;
                }
            });
            this.temp_remove = this.temp_remove.filter(idd => id != idd);
        }
        console.log(this.temp_remove);
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

    removeFromListLogik() {
        this.temp_remove.forEach(id => {
            this.list = this.removeFromListViaID(id, this.list);
        });
        this.temp_remove = [];
    }

    static remove_generate(id) {
        console.log(Beziehungen.list);
        // console.log(Beziehungen.list);

        // if (cardObj) {
        //     cardObj.update();
        // }
    }
}
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
    obj = {};
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