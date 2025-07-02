class Umgebung {
      static lastId = 0; // Statischer Zähler für IDs
      static allUmgebungen = []; // Liste aller Umgebungen
      constructor() {
        this.id = Umgebung.lastId++;
        this.cardObjects = []; // Liste der zugewiesenen CardObj-Instanzen
        Umgebung.allUmgebungen.push(this); // Diese Umgebung zu allen Umgebungen hinzufügen
      }
      addCardObj(cardObj) {
        this.cardObjects.push(cardObj); // CardObj zu dieser Umgebung hinzufügen
      }
}
class CardObj {
    constructor(umgebung) {
      this.id = Symbol(); // Einzigartige ID für das Objekt
      this.umgebung = umgebung; // Verweis auf die zugewiesene Umgebung
      umgebung.addCardObj(this); // Füge das Objekt der Umgebung hinzu
  }
}
// Beispiel-Nutzung
const umgebung1 = new Umgebung();
const umgebung2 = new Umgebung();
const umgebung3 = new Umgebung();

const bildObj = new CardObj(umgebung1); // bildObj wird umgebung1 zugewiesen
const bildObj1 = new CardObj(umgebung2); // bildObj1 wird umgebung2 zugewiesen
const bildObj2 = new CardObj(umgebung2); // bildObj1 wird umgebung2 zugewiesen
const bildObj3 = new CardObj(umgebung2); // bildObj1 wird umgebung2 zugewiesen
const bildObj4 = new CardObj(umgebung2); // bildObj1 wird umgebung2 zugewiesen

console.log(umgebung1.cardObjects); // [bildObj]
console.log(umgebung2.cardObjects); // [bildObj1]
console.log(Umgebung.allUmgebungen); // [umgebung1, umgebung2]