class Beziehungen {
    static beziehungsListe = [];

    constructor(umgebung, cardObjekt) {
        this.aktuelleUmgebung = umgebung;
        this.aktuellesCardObjekt = cardObjekt;  
        Beziehungen.beziehungsListe.push(this);
    }

    setUmgebung(umgebung) {
        this.aktuelleUmgebung = umgebung;
    } 
    getUmgebung() {
        return this.aktuelleUmgebung;
    }
}