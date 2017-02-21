<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConsultatieEntity
 *
 * @author Bert
 */
class ConsultatieEntity {
    private $id;
    private $dokter;
    private $patient;
    private $diagnose;
    private $voorschriften;
    private $van;
    private $tot;
    private $datum;
    
    function __construct($id, $dokter, $patient, $diagnose, $voorschriften, $van, $tot, $datum) {
        $this->id = $id;
        $this->dokter = $dokter;
        $this->patient = $patient;
        $this->diagnose = $diagnose;
        $this->voorschriften = $voorschriften;
        $this->van = $van;
        $this->tot = $tot;
        $this->datum = $datum;
    }

}

?>
