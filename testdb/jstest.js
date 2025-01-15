class Cat {
    static id = 0
    vorname = ""
    nachname = ""
    wohnort = ""
    static check = false
    static list = [];
    
    constructor(vorname, nachname, wohnort) {
        this.id = this.constructor.id++;
        this.vorname = vorname;
        this.nachname = nachname;
        this.wohnort = wohnort;
        // console.log(`${this.id} ${this.titel} ${this.ipAdresse}`);
        Cat.list.push(this);

    }
}

var endListe = []



function show() {

    fetch("seelect.php").then(async (response) => {
        var responseText = await response.text();
        cutAndCreate(responseText)
    });
    anzeige()
}


function cutAndCreate(responseText) {
    var obj = responseText.split("],[");
    for (let i = 0; i < obj.length; i++) {
        const inZeile = obj[i].replace("[[", "").replace("]]", "").replace("[", "").replace("]", "").replace(/"/g, '');
        var variable = inZeile.split(",")
        new Cat(variable[0], variable[1], variable[2])
        // switch(i) {
        //     case 0:
        //         eins = inZeile
        //         zaehler++
        //         break;
        //     case 1:
        //         zwei = inZeile
        //         zaehler++
        //         break;
        //     case 2:
        //         drei = inZeile
        //         zaehler++
        //         break;
        //     default:
        //     if(zaehler == 3)
        //         
        // }
    }
    Cat.list.forEach(e => {
        console.log(e)
    });
}

function anzeige() {
    var anzeige = document.getElementById("anzeige")

    for (let i = 0; i < Cat.list.length; i++) {
        const obj = Cat.list[i];
        console.log(obj)

        anzeige.innerHTML += `<div>${obj.vorname}</div>
                             <div>${obj.nachname}</div>
                             <div>${obj.wohnort}</div>`
    }
}

