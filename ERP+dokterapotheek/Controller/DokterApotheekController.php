<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DokterApotheekController
 *
 * @author Bert
 */


require ("Model/Dokter.php");
class DokterApotheekController {
    
    private $doktoor;
    
    public function getDoktoren()
    {
        $doktoor = new Dokter();
        return $doktoor->GetDoktoren();
        
    }
}

?>
