<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Patient
 *
 * @author Bert
 */
class Patient {
    
     private $id;
     private $naam;
     private $rijksreg;
     private $gbdatum;
     
     public function getId() {

    return 

    $this->id;
}    

public function setId($id) {
           $this->id = $id;
}    

public function getNaam() {
    return $this->naam;
}    

public function setNaam($naam) {
            $this->naam = $naam;
}    

public function getRijksreg() {
    return $this->rijksreg;
}    

public function setRijksreg($rijksreg) {
    $this->rijksreg = $rijksreg;
}    

public function getGbdatum() {
    return $this->gbdatum;
}    

public function setGbdatum($gbdatum) {
    $this->gbdatum = $gbdatum;
}


     
     
}

?>
