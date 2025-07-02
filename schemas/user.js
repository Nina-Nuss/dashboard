class User {
    constructor(id, loginname, passwort, zugriffsrechte, zugriffsumgebungen) {
        this.id = id;
        this.loginname = loginname;
        this.passwort = passwort;

        this.zugriffsrechte = {
            infoterminal: Boolean(zugriffsrechte[0]),
            templatebereich: Boolean(zugriffsrechte[1]),
            adminbereich: Boolean(zugriffsrechte[2])
        };

        this.zugriffsumgebungen = {
            aula: Boolean(zugriffsumgebungen[0]),
            empfang: Boolean(zugriffsumgebungen[1])
        };
    }
    hatZugriff(bereich) {
        return this.zugriffsrechte[bereich] || this.zugriffsumgebungen[bereich] || false;
        
    }
}
const newUser = new User(2,"editor", "editorPasswort", [true, false, true], [true, false]);
console.log(newUser.hatZugriff("infoterminal")); // true
console.log(newUser.hatZugriff("templatebereich")); // true
console.log(newUser.hatZugriff("adminbereich")); // true
console.log(newUser.hatZugriff("aula")); // true
console.log(newUser.hatZugriff("empfang")); // false



