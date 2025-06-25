<?php
include ("../connection.php");

// gettabelle.php?tabelle=mitarbeiter&spalten=ID // Fehlerfrei zeigt ALLE Elemente
// gettabelle.php?tabelle=mitarbeiter&spalten=ID,Name&id=2 // Fehlerfrei zeigt nur das angegebene Element => 2 mit ID und Name
// gettabelle.php?tabelle=mitarbeiter&spalten=ID,Name&id=2,1,4 // Fehlerfrei zeigt die angegebenen Element => 1,2,4 mit ID und Name
// gettabelle.php?tabelle=mitarbeiter&spalten= // ERROR keine Spalten angegeben
// gettabelle.php?spalten=ID // ERROR keine Spalten angegeben
// gettabelle.php?tabelle= // ERROR keine Tabelle angegeben

// SQL-Abfrage ausführen
$sql = "";
$ids = "";
$tabelle = "";
$spalten = "";
$typ = "";

$str = $_POST;

function getids($str) {
    $ids = explode(",", $str);
        $where = "";

        for ($i=0; $i < count($ids); $i++) { 
            $where .= "id = " . $ids[$i] . " OR ";
        }

        return substr($where, 0, strlen($where)-4);
}

if (isset($_POST["id"]) || isset($_GET["id"])) {
    if (isset($_POST["id"])) {
        // POST REQUEST für 1 id
        if (!isset($_POST["tabelle"])) {
            echo "[POST]" . $sql . " - Fehlercode 404 - Tabellen angabe war leer";
            return;
        }

        if (!isset($_POST["spalten"])) {
            echo "[POST]" . $sql . " - Fehlercode 404 - Spalten angabe war leer";
            return;
        }
        $data = json_decode(file_get_contents('php://input'), true);

        $tabelle = $_POST["tabelle"];
        $spalten = $_POST["spalten"];

        $sql = 'SELECT ' . $spalten . ' FROM ' . $tabelle . ' WHERE ' . getids($_POST["id"]);
        $typ = "POST";
    } else {
        // GET REQUEST für 1 id
        if (!isset($_GET["tabelle"])) {
            echo "[GET]" . $sql . " - Fehlercode 404 - Tabellen angabe war leer";
            return;
        }

        if (!isset($_GET["spalten"])) {
            echo "[GET]" . $sql . " - Fehlercode 404 - Spalten angabe war leer";
            return;
        }
        $tabelle = $_GET["tabelle"];
        $spalten = $_GET["spalten"];
        $sql = 'SELECT ' . $spalten . ' FROM ' . $tabelle . ' WHERE ' . getids($_GET["id"]);
        $typ = "GET";
    }
} else {
    // Für alle Einträge (SELECT * FROM ...)
    if (isset($_GET["tabelle"])) {
        $tabelle = $_GET["tabelle"];
        $spalten = $_GET["spalten"];
    } else if (isset($_POST["tabelle"])) {
        $tabelle = $_POST["tabelle"];
        $spalten = $_POST["spalten"];
    }

    $sql = 'SELECT ' . $spalten . ' FROM ' . $tabelle;
}

$result = sqlsrv_query($conn, $sql);
if ($result === false) {
    echo $sql . " - Fehlercode 404 - ID/Tabelle/Spalten nicht gefunden\n Tabellenhandler benötigt folgende Angaben: /gettabelle.php?tabelle=TABELLE&spalten=SPALTE,SPALTE,..,...,...";
    return;
}


$list = [];
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {

    $obj_temp = [];
    for ($i = 0; $i < count(explode(',', $spalten)); $i++) {
        $spalten_split = trim(explode(',', $spalten)[$i]);
        array_push($obj_temp, $row[$spalten_split]);
    }
    array_push($list, $obj_temp);
}

echo json_encode($list);