<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EvenementCollectie
 *
 * @author Bert
 */
class EvenementCollectie {
    
     private $Evenementen;
     private $entity;
     
     function __construct($Evenementen, $entity) {
        $this->Evenementen = array();
        $this->entity = $entity;
     }
     
     public function toonEvenementen(){
         
         return $entity->geefAlleEvenementen();
     }
     
     public function getEvenementen() {
         return $this->Evenementen;
     }

     public function setEvenementen($Evenementen) {
         $this->Evenementen = $Evenementen;
     }

     public function getEntity() {
         return $this->entity;
     }

     public function setEntity($entity) {
         $this->entity = $entity;
     }



     
     
}

?>
