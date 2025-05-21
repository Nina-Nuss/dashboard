class Beziehung {
    beziehungsListe = [];

    constructor(umgebung, cardObjekt) {
        this.aktuelleUmgebung = umgebung;
        this.cardObjekt = cardObjekt;  
        beziehungsListe.push(this);
    }

    setUmgebung(umgebung) {
        this.aktuelleUmgebung = umgebung;
    } 
    getUmgebung() {
        return this.aktuelleUmgebung;
    }
}