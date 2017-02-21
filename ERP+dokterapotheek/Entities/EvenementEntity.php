<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EvenementEntity
 *
 * @author Bert
 */
class EvenementEntity {
    
    private $id;
    private $datum;
    private $stringUur;
    private $beschrijving;
    private $remindersTo;
    
    function __construct($id, $datum,$stringUur,$beschrijving,$remindersTo) {
        $this->id = $id;
        $this->datum = $datum;
        $this->stringUur = $stringUur;
        $this->beschrijving = $beschrijving;
        $this->remindersTo = $remindersTo;
       
    }
}

?>
