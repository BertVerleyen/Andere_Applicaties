<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Consultatie
 *
 * @author Bert
 */
class Consultatie {
    
    private $id;
    private $dokter;
    private $patient;
    private $diagnose;
    private $voorschriften;
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getDokter() {
        return $this->dokter;
    }

    public function setDokter($dokter) {
        $this->dokter = $dokter;
    }

    public function getPatient() {
        return $this->patient;
    }

    public function setPatient($patient) {
        $this->patient = $patient;
    }

    public function getDiagnose() {
        return $this->diagnose;
    }

    public function setDiagnose($diagnose) {
        $this->diagnose = $diagnose;
    }

    public function getVoorschriften() {
        return $this->voorschriften;
    }

    public function setVoorschriften($voorschriften) {
        $this->voorschriften = $voorschriften;
    }


    
    
}

?>
