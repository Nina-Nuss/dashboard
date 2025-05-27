<?php 

class Image {
    public $imagePath;
    public $imageName;
    public $id;
    public $startDatum;
    public $endDatum;

    public static $liste;

    public function __construct($id, $imagePath, $imageName, $startDatum, $endDatum) {
        $this->imagePath = $imagePath;
        $this->imageName = $imageName;
        $this->id = $id;
        $this->startDatum = $startDatum;
        $this->endDatum = $endDatum;
        
        self::$liste[] = $this; 
    }
}

