let createFormatDate
let createFormatTime
let dateTimeformat
let justTime
let data
let listDate = []
let tempListStartAndEnd = []


window.onload = function () {
    ladeDaten();
};
// Asynchrone Funktion definieren
async function warteBisEndDatumErreicht(startDatumZeit, endDatumZeit) {
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

async function takeDate(event, start, end) {
    event.preventDefault();
    tempListStartAndEnd = []
    var formData = new FormData(document.getElementById('uploadForm'));
    var data = await processFormData(formData);
    if (data == null) { alert("bitte bild einsetzten"); return }
    let createStartEnd = createDateTimeFormat(start, end)
    let startAndEndDateTime = createDateTime()
    sendData(startAndEndDateTime, data)
    console.log(createStartEnd[0]);
    
    warteBisEndDatumErreicht(createStartEnd[0], createStartEnd[1]);
}

async function processFormData(formData) {
    try {
        const response = await fetch('moveAndgetBildInfo.php', {
            method: 'POST',
            body: formData
        });
        const data = await response.json();
        return data
    } catch (error) {
        console.error('Error:', error);
    }
}

async function sendData(startAndEndDateTime, data) {
   
    const daten = {
        startDate: startAndEndDateTime[0][0],
        startTime: startAndEndDateTime[0][1],
        endTime: startAndEndDateTime[1][1],
        endDate: startAndEndDateTime[1][0],
        imageName: data[0],
        imagePath: data[1]
    };
    try {
        const response = await fetch('test.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(daten) // Convert the data object to JSON
        });
        const responseData = await response.text();
        console.log('Success:', responseData);
        return responseData;
    } catch (error) {
        console.error('Error:', error);
        throw error;
    }
}

function createDateTime() {
    let startTime = tempListStartAndEnd.at(0).time
    let startDate = tempListStartAndEnd.at(0).date
    let endTime = tempListStartAndEnd.at(1).time
    let endDate = tempListStartAndEnd.at(1).date

    let startDateTime = createDateTime2(startDate, startTime)
    let endDateTime = createDateTime2(endDate, endTime)

    return [startDateTime, endDateTime]
}
function createDateTime2(date, time) {
    var year = date.split("-")[0]
    var month = date.split("-")[1]
    var day = date.split("-")[2]
    date = day + "-" + month + "-" + year
    return [date, time]
}

function createDateTimeFormat(dateTimeStart, dateTimeEnd) {
    let start = createDateTimeFormat2(dateTimeStart)
    let end = createDateTimeFormat2(dateTimeEnd)
    return [start, end]
}

function createDateTimeFormat2(dateTime) {
    var datumTeil = dateTime.split(" ")[0];  // "10/12/2024"   l
    var datumTeil1 = datumTeil.split("/");
    var zeit = dateTime.split(" ")[1];
    var minuten = zeit.split(":")[1]
    let amOrpm = dateTime.split(" ")[2];

    if (amOrpm == "PM") {
        console.log(amOrpm);
        let stunde = Math.floor(parseInt(zeit))
        var Stunde = stunde + 12
        var zeit = `${Stunde}.${minuten}`
        let zeitPrüfen = parseFloat(zeit)
        if (zeitPrüfen > 25.00) {
            alert("unvalide zeiteingabe " + zeitPrüfen)
            return
        } else {
            var zeit = `${Stunde}:${minuten}`
        }
    } if (amOrpm == "AM") {
        console.log(amOrpm);
        var stunde = Math.floor(parseInt(zeit))
        console.log(stunde);

        if (stunde < 10) {
            console.log(stunde);
            var stunde = stunde.toString().padStart(2, '0');
        }
        var zeit = `${stunde}.${minuten}`
        let zeitPrüfen = parseFloat(zeit)
        if (zeitPrüfen > 13.00) {
            alert("unvalide zeiteingabe " + zeitPrüfen)
            return
        } else {
            var zeit = `${stunde}:${minuten}`
        }
    }
    for (let i = 0; i < datumTeil1.length; i++) {
        const element = datumTeil1[i];
        listDate.push(element)
    }
    createFormatDate = `${listDate[2]}-${listDate[0]}-${listDate[1]}`
    createFormatTime = `T${zeit}`
    justTime = `${zeit}`
    const listDateTime =
    {
        "time": justTime,
        "date": createFormatDate,
    }
    tempListStartAndEnd.push(listDateTime)
    dateTimeformat = createFormatDate + createFormatTime

    listDate = []
    return new Date(dateTimeformat)
}

async function ladeDaten() {
    const url = "select.php";
    try {
        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }
        const json = await response.json();
        zeigeDataAn(json);
    } catch (error) {
        console.error(error.message);
    }
}
function zeigeDataAn(json) {
    for (let i = 0; i < json.length; i++) {
        var ele = json[i]
        var imageName = ele[0].imageName
        document.getElementById("inhalt").innerHTML += `<img src="${imageName}" style="padding: 10px; width: 200px; height: auto;">`;
    }
}
