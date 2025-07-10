class Beziehungen {
    static beziehungsListe = [];
    constructor(id, umgebung, cardObjekt) {
        this.id = id;
        this.umgebung = umgebung;
        this.cardObjekt = cardObjekt;  
        Beziehungen.beziehungsListe.push(this);
    }
    setUmgebung(umgebung) {
        this.umgebung = umgebung;
    } 
    getUmgebung() {
        return this.umgebung;
    }
    getCardObjekt() {
        return this.cardObjekt;
    }
    setCardObjekt(cardObjekt) {
        this.cardObjekt = cardObjekt;
    }
}