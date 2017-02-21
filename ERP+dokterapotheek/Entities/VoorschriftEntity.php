<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VoorschriftEntity
 *
 * @author Bert
 */
class VoorschriftEntity {
   
     private $patientid;
     private $dokterid;
     private $beschrijving;
     private $medicamenten;
     
     function __construct($patientid, $dokterid, $beschrijving, $medicamenten) {
         $this->patientid = $patientid;
         $this->dokterid = $dokterid;
         $this->beschrijving = $beschrijving;
         $this->medicamenten = $medicamenten;
     }

    
}

?>
