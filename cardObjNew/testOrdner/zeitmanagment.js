import { CardObj } from './timepicker.html';

//TestObjekte---------------------------
class DateTime {
    static objList = []
    static id = 0
    startDateTime
    endDateTime
    imBereich
    constructor(startDateTime, endDateTime) {
        this.id = DateTime.id++
        this.startDateTime = startDateTime
        this.endDateTime = endDateTime
        this.imBereich = false
        DateTime.objList.push(this);
    }
}
function generateFutureDates() {
    const currentTime = new Date();
    // Generate a random number of seconds to add to the current time
    const randomSeconds1 = Math.floor(Math.random() * 30);
    const randomSeconds2 = Math.floor(Math.random() * 30) + randomSeconds1; // Sicherstellen, dass futureDate2 später liegt
    const futureDate1 = new Date(currentTime.getTime() + randomSeconds1 * 1000);
    const futureDate2 = new Date(currentTime.getTime() + randomSeconds2 * 10000);
    return { futureDate1, futureDate2 };
}
function create(){
    for (let i = 0; i < 3; i++) {
        dates[i] = generateFutureDates(); 
        new DateTime(dates[i].futureDate1, dates[i].futureDate2)
    }
}
//TestObjekte------------------------------

const dates = []; // Initialize an empty array to store the dates

async function wait() {
    while (true) {
        // Iterate through the objects in DateTime.objList
        for (let obj of CardObj.objList) {
            await new Promise(resolve => setTimeout(resolve, 1000)); // Delay for 3 seconds
            await prüfen(obj); // Call the prüfen function to check the current object
            console.log("---------------------------");
            // Iterate through the listAnzeige objects
            for (let obj2 of listAnzeige) {
                await new Promise(resolve => setTimeout(resolve, 300)); // Delay for 1 second
                console.log("objekt in liste: ", obj2.id);
            }
     
        }
    }
}
async function prüfen(obj) {
    let now = new Date();
    // Compare the current time with the start and end time of obj
    if (obj.startDateTime < now && obj.endDateTime > now) {
        obj.imBereich = true;
    } else {
        obj.imBereich = false;
    }
    // If obj is in range, add it to listAnzeige
    if (obj.imBereich) {
        if (!listAnzeige.some(e => e.id === obj.id)) {
            listAnzeige.push(obj);
            console.log("---------------------------");
            console.log(`Object with id ${obj.id} added to listAnzeige.`);
        }
    } else {
        // If obj is not in range, remove it from listAnzeige if it exists
        if (listAnzeige.length !== 0) {
            let index = listAnzeige.findIndex(e => e.id === obj.id);
            if (index !== -1) {
                listAnzeige.splice(index, 1); // Remove the object from the array
                console.log("---------------------------");
                console.log(`Object with id ${obj.id} removed from listAnzeige.`);
            } else {
                console.log("---------------------------");
                console.log(`Object with id ${obj.id} not found in listAnzeige.`);
            }
        } else {
            console.log("---------------------------");
            console.log("listAnzeige is empty.");
        }
    }
}
















// while(true){
  
// }