class Beziehungen {
    static beziehungsListe = [];
    static temp_list = [];
    static eleListe = []
    constructor(id, umgebung, cardObjekt) {
        this.id = id;
        this.umgebung = umgebung;
        this.cardObjekt = cardObjekt;
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
        console.log("Update der Beziehung: " + this.id);
    
        this.tempBeziehungen.push(this);

        var anzeigebereichv = document.getElementById("anzeigebereichV")
        if (anzeigebereichv != null) {
            anzeigebereichv.innerHTML = "";
            console.log("anzeigebereichv geleert");
        }
        const anzeigebereicht = document.getElementById("tabelleAdd");
        if (anzeigebereicht != null) {
            anzeigebereicht.innerHTML = "";
            console.log("tabelleAdd geleert");
        }
        const anzeigebereichD = document.getElementById("tabelleDelete");
        if (anzeigebereichD != null) {
            anzeigebereichD.innerHTML = "";
            console.log("tabelleDelete geleert");
        }  
       
        // for (let i = 0; i < this.umgebungsListe.length; i++) {
        //     const element = this.umgebungsListe[i];
        //     if (sAu) {
        //         selectAddUmgebung.innerHTML += `<option value="${element.id}">${element.titel}</option>`;
        //     }
        //     if (avvorhanden) {
        //         anzeigebereichv.innerHTML += `<div style="display: flex;">
        //                         <span name="${element.titel}" id="${element.id}" style="float: left;  margin-right: 10px;">${element.ipAdresse}</span>
                                
        //                         <label for="Schulaula" clSs="text-wrap"value="15">${element.titel}</label>
        //                     </div>
        //                     `;
        //     }
        //     if (atvorhanden) {
        //         anzeigebereicht.innerHTML += `<tr>
        //                                         <td>${element.id}</td>
        //                                         <td>${element.ipAdresse}</td>
        //                                         <td>${element.titel}</td>
        //                                         <td><input type="checkbox" name="${element.id}" id="checkAdd${element.id}" onchange="Umgebung.event_remove(${Umgebung.temp_add}, ${Umgebung.eleListeForAdd}, ${element.id})"></td>
        //                                    </tr>`
        //     }
        //     if (advorhanden) {
        //         anzeigebereichD.innerHTML += `<tr>
        //                                         <td>${element.id}</td>
        //                                         <td>${element.ipAdresse}</td>
        //                                         <td>${element.titel}</td>
        //                                         <td><input type="checkbox" name="${element.id}" id="checkDel${element.id}" onchange="Umgebung.event_remove(${Umgebung.temp_remove_info}, ${Umgebung.eleListeForRemove}, ${element.id})"></td>
        //                                    </tr>`
        //     }

        // }
    }


}

window.addEventListener("load", async () => {
    const relationListe =  await Beziehungen.getRelation();
    console.log(relationListe);

    relationListe.forEach(element => {
        new Beziehungen(element[0], element[1], element[2]);
    });

    console.log(Beziehungen.beziehungsListe);

})

