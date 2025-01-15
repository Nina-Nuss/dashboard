personen = new Object();

window.onload = async function () {
    var anzeige = await fetch("select.php");
    var response = await anzeige.text();
    document.getElementById("tabelle").innerHTML = response;
    // const objLocal = localStorage.getItem('Object');
    // document.getElementById("tabelle2").innerHTML = objLocal;
    // Gibt den Wert der Straße aus
    await select(["ID", "Name"], personen)
}
async function GetValues(ID, name) {
    var prepare = "?ID=" + ID + "&Name=" + name;
    var result = await fetch("insert.php" + prepare);
   
    alert("bin drin " +  await result.text())
   
}
async function select(colum, personen){
    var select = await  fetch("select.php")
    var anzeige = await select.text()
    erstelleListe(colum , anzeige, personen)
    console.log(personen);
}
// async function get(file, colum, obj) {
//     await fetch(file).
//         then(async (antwort) => {
//             mitarbeiter_array = await antwort.text();
//             // mitarbeiter_array gibt folgendes zurück
//             // [[1,"Nina"],[4,"Josef"],[5,"hans"],[4,"Josef"],[4,"Josef"]]
            
//             erstelleListe(
//                 colum,               
//                 mitarbeiter_array,
//                 obj
//             )
//         });
// }
function erstelleListe(columnsVonDatenbankVonDirAngegeben, columnsVonDatenbankArray, endliste) {
    var db = columnsVonDatenbankArray.split("],[");

    for (let i = 0; i < db.length; i++) {
        const zeile = db[i].replace("[[", "").replace("[", "").replace("]]", "").replace("]", "").split(",");
        var tempListe = new Object();
        for (let i = 0; i < zeile.length; i++) {
            const element = zeile[i];
            // console.log(element);
            // console.log( "spalte: " + columnsVonDatenbankVonDirAngegeben[i]  +  " element: " + element );
            tempListe[columnsVonDatenbankVonDirAngegeben[i]] = element;
        }
        endliste[i] = tempListe;
        // console.log("");
    }
}
async function deletee(idDelete){
    prepare = "?idDelete=" + idDelete;
    result = await fetch("delete.php" + prepare)
}