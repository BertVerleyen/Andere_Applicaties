<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Voorschrift
 *
 * @author Bert
 */
class Voorschrift {
    
     private $patientid;
     private $dokterid;
     private $beschrijving;
     private $medicamenten;
     
     
     public function getPatientid() {
       return $this->patientid;
}    

    public function setPatientid($patientid) {
            $this->patientid = $patientid;
}    

    public function getDokterid() {
    return $this->dokterid;
}    

    public function setDokterid($dokterid) {
            $this->dokterid = $dokterid;
}    

    public function getBeschrijving() {
    return $this->beschrijving;
}    

    public function setBeschrijving($beschrijving) {
            $this->beschrijving = $beschrijving;
}    

    public function getMedicamenten() {
    return $this->medicamenten;
}    

    public function setMedicamenten($medicamenten) {
            $this->medicamenten = $medicamenten;
}


}

?>
