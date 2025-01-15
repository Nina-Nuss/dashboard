
// 1. Oktober 2024, 18:00 Uhr
takeDate()

// Asynchrone Funktion definieren
async function warteBisEndDatumErreicht() {
    // Warten, bis das Start-Datum und die Start-Uhrzeit erreicht sind
    while (new Date() < startDatumZeit) {
        console.log("Warten auf Start-Datum und -Uhrzeit...");
        await new Promise(resolve => setTimeout(resolve, 60000));
    }

    // while-Schleife, die läuft, bis das End-Datum und die End-Uhrzeit erreicht sind
    while (new Date() < endDatumZeit) {
        console.log("Noch nicht erreicht...");
        await new Promise(resolve => setTimeout(resolve, 60000));
    }

    console.log("End-Datum und -Uhrzeit erreicht!");
}

// Funktion aufrufen
warteBisEndDatumErreicht();

function takeDate(value1) {
    listDate = []
    let start = createDateTimeFormat(value1)
    // let end = createDateTimeFormat(value2)
    console.log(start);
}

function createDateTimeFormat(dateTime){
    let datumTeil = dateTime.split(" ")[0];  // "10/12/2024"   l
    let datumTeil1 = datumTeil.split("/");
    var zeit = dateTime.split(" ")[1];
    var minuten = zeit.split(":")[1]
    let amOrpm = dateTime.split(" ")[2];
   
    if(amOrpm == "PM"){
        console.log(amOrpm); 
        let stunde = Math.floor(parseInt(zeit))
        var Stunde = stunde + 12
        var zeit = `${Stunde}.${minuten}`
        let zeitPrüfen = parseFloat(zeit)
        if(zeitPrüfen > 24.00){
            alert("unvalide zeiteingabe " + zeitPrüfen)
            return
        }else{
             var zeit = `${Stunde}:${minuten}`
        }
    }if(amOrpm == "AM"){
        console.log(amOrpm);
        var stunde = Math.floor(parseInt(zeit))
        console.log(stunde);
        
        if(stunde < 10){
            console.log(stunde);
            var stunde = stunde.toString().padStart(2, '0');
         }
        var zeit = `${stunde}.${minuten}`
        let zeitPrüfen = parseFloat(zeit)
        if(zeitPrüfen > 12.00){
            alert("unvalide zeiteingabe " + zeitPrüfen)
            return
        }else{
             var zeit = `${stunde}:${minuten}`             
        }
    }
    for (let i = 0; i < datumTeil1.length; i++) {
        const element = datumTeil1[i];
        listDate.push(element)
    }
    var createFormatDate = `${listDate[2]}-${listDate[0]}-${listDate[1]}`
    var createFormatTime = `T${zeit}:00`
    var dateTimeformat = createFormatDate + createFormatTime
    console.log(dateTimeformat);
    return new Date(dateTimeformat)
}