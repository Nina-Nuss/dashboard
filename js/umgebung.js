class Umgebung {
    ipAdresse = ""
    static id = 1;
    static umgebungsListe = [];
    static allCardList = [];
    static currentSelect = 0;
    check = false;
    static temp_remove = []
    static list = [];
    static ipList = [];
    static eleListe = []
    static responseText = ""
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
        Umgebung.list.push(this);
    }


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
    static async update() {
        uncheckAllCheckboxes();
        const delInfo = document.getElementById("deleteInfotherminal");
        const selector = document.getElementById('infotherminalSelect');

        if (delInfo != null) {
            // Performance: String-Building statt innerHTML +=
            let tableContent = "";
            let selectorOptions = '<option value="">-- Bitte wählen --</option>';

            this.list = [];
            this.temp_remove = [];
            Beziehungen.update();

            const result = await readDatabase("selectInfotherminal");
            console.log("result: ", result);

            // Performance: Normale forEach statt await forEach
            result.forEach(listInfo => {
                // Neue Umgebung-Objekte erzeugen
                new Umgebung(listInfo[0], listInfo[1], listInfo[2]);

                // Tabellencontent sammeln
                tableContent += `<tr class="border-bottom">
                    <td class="p-2">${listInfo[0]}</td>
                    <td class="p-2">${listInfo[2]}</td>
                    <td class="p-2">${listInfo[1]}</td>
                    <td class="p-2 text-center"><input type="checkbox" name="${listInfo[0]}" id="checkDelInfo${listInfo[0]}" onchange="Umgebung.event_remove(${listInfo[0]})"></td>
                </tr>`;

                // Selector-Optionen sammeln
                selectorOptions += `<option value="${listInfo[1]}">${listInfo[1]}</option>`;
            });

            // DOM nur einmal aktualisieren (bessere Performance)
            delInfo.innerHTML = tableContent;
            if (selector) {
                selector.innerHTML = selectorOptions;
            }
        }
        console.log(this.list);
    }
    static removeFromListViaID(id, list) {
        var temp = [];
        console.log(list);
        list.forEach(element => {
            if (element.id != id) {
                //ID muss aus Liste gelöscht werden
                temp.push(element);
            } else {
                this.deletee(element.id, "deleteInfotherminal");
                console.log("Das Element wurde gefunden und wird gelöscht! " + element.id);
            }
        });
        return temp;
    }
    static event_remove(id) {
        var element = document.getElementById(`checkDelInfo${id}`);
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

    static async deletee(idDelete, databaseUrl) {
        console.log("deletee wurde aufgerufen");
        try {
            const prepare = "?idDelete=" + idDelete;
            console.log(prepare);

            const response = await fetch(`/database/${databaseUrl}.php` + prepare);

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
    static async removeFromListLogik() {
        // DIese Methode wird aufgerufen sobald wir auf Minus (-) klicken
        // Hier benötigen wir die Aktuellen IDS der Datenbank zum löschen
        console.log(this.list);
        this.temp_remove.forEach(id => {
            this.list = this.removeFromListViaID(id, this.list);

        });
        this.temp_remove = []
        console.log(this.list);
    }

    static async remove_generate() {
        if (this.temp_remove.length == 0) {
            alert("Bitte wählen Sie mindestens ein Infotherminal aus, um es zu löschen.");
            return;
        }

        // Bessere Bestätigungsdialog mit Namen der zu löschenden Terminals
        const terminalsToDelete = this.list
            .filter(terminal => this.temp_remove.includes(terminal.id))
            .map(terminal => terminal.titel)
            .join(', ');

        const confirmed = confirm(
            `Sind Sie sicher, dass Sie folgende ${this.temp_remove.length} Infotherminal(s) löschen möchten?\n\n` +
            `${terminalsToDelete}\n\n` +
            `Diese Aktion kann nicht rückgängig gemacht werden.`
        );

        if (!confirmed) {
            console.log("Löschvorgang vom Benutzer abgebrochen");
            return;
        }

        try {
            // Loading-State anzeigen
            const deleteButton = document.querySelector('[onclick*="remove_generate"]');
            if (deleteButton) {
                deleteButton.disabled = true;
                deleteButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Lösche...';
            }

            await this.removeFromListLogik();
            await this.update();

            // Erfolgreiche Löschung anzeigen
            alert(`${this.temp_remove.length} Infotherminal(s) wurden erfolgreich gelöscht.`);

        } catch (error) {
            console.error("Fehler beim Löschen:", error);
            alert("Fehler beim Löschen der Infotherminals. Bitte versuchen Sie es erneut.");
        } finally {
            // Button zurücksetzen
            const deleteButton = document.querySelector('[onclick*="remove_generate"]');
            if (deleteButton) {
                deleteButton.disabled = false;
                deleteButton.innerHTML = '<i class="fas fa-trash"></i> Löschen';
            }
        }
    }

    static erstelleSelector() {
        const selector = document.getElementById('infotherminalSelect');
        const button = document.getElementById('openTerminalBtn');

        // Selector nur einmal befüllen und Event-Listener nur einmal hinzufügen

        // Selector leeren
        selector.innerHTML = '<option value="">-- Bitte wählen --</option>';

        // Event-Listener nur einmal hinzufügen (außerhalb der forEach-Schleife)
        button.addEventListener('click', function () {
            const selectedTerminal = selector.value;
            if (selectedTerminal !== '') {
                const url = `./anzeigeTherminal/index.php?ip=${encodeURIComponent(selectedTerminal)}`;
                window.open(url, '_blank');
            }
        });

        // Change-Event nur einmal hinzufügen
        selector.addEventListener('change', function () {
            button.disabled = this.value === '';
        });

        Umgebung.list.forEach(element => {
            console.log(element);
            
            // Selector Option hinzufügen
            const option = document.createElement("option");
            option.value = element.titel;
            option.textContent = element.titel;
            selector.appendChild(option);
        });
    }

}

console.log("Umgebung.js loaded");

window.addEventListener("load", function () {
    var adminBereich = document.getElementById("adminBereich")
    if (adminBereich != null) {
        document.getElementById("adminBereich").addEventListener("click", async function () {
            const settingsPanel = document.getElementById("settingsPanel")
            uncheckAllTableCheckboxes()
            deakCb(true);
            Umgebung.temp_remove = [];
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
                form.reset(); // Formular zurücksetzen
            });
            const cardBodyDelInfo = document.getElementById("cardBodyForDelInfo");
            const delInfo = document.getElementById("deleteInfotherminal")

            // Umgebungen durchgehen und sowohl Tabelle als auch Selector befüllen
            Umgebung.list.forEach(element => {
                // Tabelle befüllen
                delInfo.innerHTML += `<tr class="border-bottom">
                        <td class="p-2">${element.id}</td>
                        <td class="p-2">${element.ipAdresse}</td>
                        <td class="p-2">${element.titel}</td>
                        <td class="p-2 text-center"><input type="checkbox" name="${element.id}" id="checkDelInfo${element.id}" onchange="Umgebung.event_remove(${element.id})"></td>
                    </tr>`;

                // Selector Option hinzufügen

            });
        });
    }
});

function wait(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

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
        // new Umgebung(inZeile[0], inZeile[1], inZeile[2])
    }
}




