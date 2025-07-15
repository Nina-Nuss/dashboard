class Beziehungen {
    static beziehungsListe = [];
    beziehungen = [];
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





    update(){
        var delInfo = document.getElementById("deleteInfotherminal")
        if (delInfo != null) {
            delInfo.innerHTML = ""
        }
        var anzeigebereichv = document.getElementById("anzeigebereichV")
        if (anzeigebereichv != null) {
            anzeigebereichv.innerHTML = "";
        }
        const anzeigebereicht = document.getElementById("tabelleAdd");
        if (anzeigebereicht != null) {
            anzeigebereicht.innerHTML = "";
        }
        const anzeigebereichD = document.getElementById("tabelleDelete");
        if (anzeigebereichD != null) {
            anzeigebereichD.innerHTML = "";
        }
        var selectAddUmgebung = document.getElementById("selectAddUmgebung");
        if (selectAddUmgebung != null) {
            selectAddUmgebung.innerHTML = "";
        }   
        const anzeigebereichS = document.getElementById("anzeigebereichS");
        if (anzeigebereichS != null) {  
            anzeigebereichS.innerHTML = "";
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
                                                <td><input type="checkbox" name="${element.id}" id="checkAdd${element.id}" onchange="Umgebung.event_remove(${Umgebung.temp_add}, ${Umgebung.eleListeForAdd}, ${element.id})"></td>
                                           </tr>`
            }
            if (advorhanden) {
                anzeigebereichD.innerHTML += `<tr>
                                                <td>${element.id}</td>
                                                <td>${element.ipAdresse}</td>
                                                <td>${element.titel}</td>
                                                <td><input type="checkbox" name="${element.id}" id="checkDel${element.id}" onchange="Umgebung.event_remove(${Umgebung.temp_remove_info}, ${Umgebung.eleListeForRemove}, ${element.id})"></td>
                                           </tr>`
            }

        }
    }

}