


class Crud {
    constructor() {
        this.tempBeziehungen = [];
    }
    static async readDatabase(databaseUrl) {
        const listUmgebung = await selectObj(`/database/${databaseUrl}.php`)
        return listUmgebung;
    }
    static removeFromListViaID(id, liste) {
        var temp = [];
        console.log(liste);
        liste.forEach(element => {
            if (element.id != id) {
                //ID muss aus Liste gelöscht werden
                temp.push(element);

            } else {
                // Verhindere das Löschen der Hauptumgebung (ID 0 - "Alle Schemas")
                if (element.id != 0) {
                    Crud.deletee(element.id, "deleteInfotherminal");
                    console.log("Das Element wurde gefunden und wird gelöscht! " + element.id);
                    // Delete muss in der Datenbank nun hier ausgefuehrt werden
                } else {
                    console.warn("Hauptumgebung (Alle Schemas) kann nicht gelöscht werden!");
                }
                return;
            }
        });
        return temp;
    }
    static event_remove(liste, nodeObjId, id) {
        // Nur mit Listen-Namen arbeiten, keine Liste als String übergeben!
        if (liste === "umgebungsListe") {
            var listRef = Umgebung.umgebungsListe;
            var temp_list = Umgebung.temp_list;
            var nodeObj = document.getElementById(nodeObjId);
            if (!nodeObj) {
                console.warn(`Element mit ID ${nodeObjId} nicht gefunden.`);
                return;
            }
        }
        if (nodeObj.checked && !temp_list.includes(id)) {
            console.log(`Checkbox mit ID ${id} wurde aktiviert.`);
            listRef.forEach(checkID => {
                if (checkID.id == id) {
                    checkID.check = true;
                }
            });
            temp_list.push(id);
        } else {
            listRef.forEach(checkID => {
                if (checkID.id == id) {
                    checkID.check = false;
                }
            });
            // Entferne die ID aus temp_list
            temp_list = temp_list.filter(idd => idd !== id);
        }
        if (liste === "umgebungsListe") {
            Umgebung.temp_list = temp_list; // Aktualisiere die globale Liste
        }
        console.log("Aktuelle temp_list:", temp_list);
    }

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
    static async removeFromListLogik(Klasse) {
        // DIese Methode wird aufgerufen sobald wir auf Minus (-) klicken
        // Hier benötigen wir die Aktuellen IDS der Datenbank zum löschen
        console.log(Klasse.temp_list);

        Klasse.temp_list.forEach(id => {
            Klasse.umgebungsListe = Crud.removeFromListViaID(id, Klasse.umgebungsListe);
        });
        console.log(Klasse.umgebungsListe);
        Klasse.temp_list = []
        Klasse.eleListe = []
    }

    static remove_generate(Klasse) {
        console.log("remove_generate wurde aufgerufen");
        Crud.removeFromListLogik(Klasse)
        Klasse.update()

    }
    static findObj(liste, id) {
        const number = extractNumberFromString(id); // Extrahiere die ID
        console.log(`ID: ${number}`);

        for (const cardList of liste) {
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
    async updateDataBase(cardObj, databaseUrl,) {
        // Erstellen eines FormData-Objekts
        try {
            console.log("updateDataBase wurde aufgerufen");
            const jsObj = JavaScriptCardObj(cardObj);
            const createJsObj = JSON.stringify(jsObj)
            console.log(jsObj);
            var result = await fetch(`database/${databaseUrl}.php`, {
                method: "POST",
                body: createJsObj
            });
            const responseText = await result.text();
            console.log("Antwort vom Server:", responseText);
        } catch (error) {
            console.error("Fehler in updateDataBase:", error);
        }
    }

}
