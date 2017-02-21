<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EvenementController
 *
 * @author Bert
 */
require ("Model/Evenement.php");
class EvenementController {
    
    
    
    function InsertEvenement()
    {
        $datum = $_POST['txtDatum']; 
        $beschrijving = $_POST['txtBeschrijving']; 
         
        
        $evt = new EvenementEntity(-1, $datum, null, $beschrijving, null);
        $EvtModel = new Evenement();
        $EvtModel->InsertEvenement($evt);
    }
    
    function UpdateEvenement($id)
    {
       $datum = $_POST['txtDatum']; 
        $beschrijving = $_POST['txtBeschrijving']; 
        
        $evt = new EvenementEntity(-1, $datum, null, $beschrijving, null);
        $EvtModel = new Evenement();
        $EvtModel->UpdateEvenement($id, $evt);
        
        
    }
    
    function DeleteCoffee($id)
    {
        $evtModel = new Evenement();
        $evtModel->DeleteEvenement($id);
    }
    
    function GetAlleEvenementen()
    {
       $evt = new Evenement();
       return $evt->getAllEvenementen();
    }
    
    function GetEvenementById($id)
    {
      $evenement = new Evenement();
      return $evenement->GetEvenementById($id);
    }
   
}

?>
