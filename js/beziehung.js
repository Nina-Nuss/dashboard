

class Beziehungen {
    static beziehungsListe = [];
    static temp_list = [];

    static eleListe = []


    constructor(id, umgebungsID, cardObjektID) {
        this.id = id;
        this.umgebungsID = umgebungsID;
        this.cardObjektID = cardObjektID;
        Beziehungen.beziehungsListe.push(this);
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
        var relationListe = await response.json();
        return relationListe;
    }
    update() {
        const anzeigebereichv = document.getElementById("anzeigebereichV");
        const anzeigebereicht = document.getElementById("tabelleAdd");
        const anzeigebereichD = document.getElementById("tabelleDelete");
        console.log("Update der Beziehung: " + this.id);
        this.temp_list = [];
        Beziehungen.beziehungsListe.forEach(element => {
            if (element.cardObjektID === this.id) {
                console.log(`Beziehung gefunden: ${element.id} mit CardObjektID: ${element.cardObjektID}`);
                this.temp_list.push(element);

            }
        });
        leereListe(anzeigebereichv);
        leereListe(anzeigebereicht);
        leereListe(anzeigebereichD);

        console.log(anzeigebereichv);

        for (let i = 0; i < this.temp_list.length; i++) {
            const element = this.temp_list[i];
            let obj = erstelleObj(element);
            console.log("Objekt erstellt:", obj);
            if (anzeigebereichv != null) {
                console.log("anzeigebereichv vorhanden");

                anzeigebereichv.innerHTML += `<div style="display: flex;">
                                <span name="${obj.titel}" id="${obj.id}" style="float: left;  margin-right: 10px;">${obj.ipAdresse}</span>

                                <label for="Schulaula" class="text-wrap" value="15">${obj.titel}</label>
                            </div>
                            `;
            }
            if (anzeigebereicht != null) {
                anzeigebereicht.innerHTML += `<tr>
                                                <td>${obj.id}</td>
                                                <td>${obj.ipAdresse}</td>
                                                <td>${obj.titel}</td>
                                                <td><input type="checkbox" name="${obj.id}" id="checkAdd${obj.id}" onchange="Crud.event_remove('beziehungsListe', this.id, ${obj.id})"></td>
                                           </tr>`
            }
            if (anzeigebereichD != null) {
                Umgebung.umgebungsListe.forEach(element => {
                    if (!element.id == obj.umgebungID) {
                        anzeigebereichD.innerHTML += `<tr>
                                                <td>${element.id}</td>
                                                <td>${element.ipAdresse}</td>
                                                <td>${element.titel}</td>
                                                <td><input type="checkbox" name="${element.id}" id="checkDel${element.id}" onchange="Crud.event_remove('beziehungsListe', this.id, ${element.id})"></td>
                                           </tr>`
                    }
                });

            }
        }
    }
}


function leereListe(anzeigebereich) {
    if (anzeigebereich != null) {
        anzeigebereich.innerHTML = "";
        console.log("anzeigebereich: " + anzeigebereich.id + " geleert");
    }
}

window.addEventListener("load", async () => {




    const relationListe = await Beziehungen.getRelation();
    console.log(relationListe);
    relationListe.forEach(element => {
        new Beziehungen(element[0], element[1], element[2]);
    });
    console.log(Beziehungen.beziehungsListe);
})


function erstelleObj(element) {
    obj = {};
    Umgebung.umgebungsListe.forEach(umgebung => {
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