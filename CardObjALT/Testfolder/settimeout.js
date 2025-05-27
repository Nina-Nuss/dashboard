


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
