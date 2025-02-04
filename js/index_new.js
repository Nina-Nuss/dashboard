class anzeigebereich {
    ipAdresse = ""
    titel = ""
    beschreibung = ""
    von = ""
    bis = ""
    static check = false
    static list = [];
    static listDataBase = [];

    constructor(ipAdresse, titel, beschreibung, von, bis, id) {
        this.id = id;
        this.ipAdresse = ipAdresse;
        this.titel = titel;
        this.beschreibung = beschreibung;
        this.bis = bis;
        this.von = von;
        // console.log(`${this.id} ${this.titel} ${this.ipAdresse}`);
        anzeigebereich.list.push(this);
        console.log("Liste: " + anzeigebereich.list);
        console.log("Liste: " + anzeigebereich.list);
        
    }

    static temp_remove = []
    static eleListe = []
    static responseText = ""
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
            this.list = this.removeFromListViaID(id, this.list);

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
        let beschreibung = document.getElementById("modal_hinzufuegen_txtbox_beschreibung");
        let von = document.getElementById("modal_hinzufuegen_datepicker_von");
        let bis = document.getElementById("modal_hinzufuegen_datepicker_bis");
        
        listeObj.push(ip.value, title.value, beschreibung.value, von.value, bis.value)
        
        var prepare = "?ip=" + ip.value + "&titel=" + title.value + "&beschreibung=" + beschreibung.value + "&von=" + von.value + "&bis=" + bis.value;
        var result = await fetch("insert.php" + prepare);
       
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
        new anzeigebereich(ip.value, title.value, beschreibung.value, von.value, bis.value);
        anzeigebereich.update();
    }

    static update() {
        var anzeigebereichv = document.getElementById("anzeigebereichV")
        const anzeigebereicht = document.getElementById("tabelle")
        anzeigebereichv.innerHTML = ""
        anzeigebereicht.innerHTML = ""
        console.log("Update: " + this.list)
        for(let i = 0; i < this.list.length; i++){
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

window.onload = function () {
    anzeigebereich.update();
    var slider = document.getElementById("dokumente");
    slider.innerHTML += new Itemslider("test").body;
    slider.innerHTML += new Itemslider("test").body;
    slider.innerHTML += new Itemslider("test").body;
    slider.innerHTML += new Itemslider("test").body;
    select()
}
function select() {
    getCuttedList = []
    fetch("select.php").then(async (response) => {
        var responseText = await response.text();
        cutAndCreate(responseText)
        anzeigebereich.update()

        
    });
}
function cutAndCreate(responseText) {
    var obj = responseText.split("],[");
    for (let i = 0; i < obj.length; i++) {
            var zeile = obj[i].replace("[[", "").replace("]]", "").replace("[", "").replace("]", "").replace(/"/g, '')
            const inZeile = zeile.split(",");
            new anzeigebereich(inZeile[0], inZeile[1], inZeile[2], inZeile[3], inZeile[4], inZeile[5], inZeile[6])   
    }
}
function insert() {
    fetch("insert.php").then(async (response) => {
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
    prepare = "?idDelete=" + idDelete;
    result = await fetch("delete.php" + prepare)
    var meow = await result.text()
    console.log(meow)
}