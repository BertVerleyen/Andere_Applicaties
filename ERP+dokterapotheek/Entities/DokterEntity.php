<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DokterEntity
 *
 * @author Bert
 */
class DokterEntity {
    
    public $id;
    public $naam;
    
    function __construct($id, $naam) {
        $this->id = $id;
        $this->naam = $naam;
    }

}

?>
