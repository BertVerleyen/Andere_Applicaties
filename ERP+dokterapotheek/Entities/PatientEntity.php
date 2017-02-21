<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PatientEntity
 *
 * @author Bert
 */
class PatientEntity {
    public $id;
    public $naam;
    public $rijksreg;
    public $gbdatum;
    
    function __construct($id, $naam, $rijksreg, $gbdatum) {
        $this->id = $id;
        $this->naam = $naam;
        $this->rijksreg = $rijksreg;
        $this->gbdatum = $gbdatum;
}

}

?>
