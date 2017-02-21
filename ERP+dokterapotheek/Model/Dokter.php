<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Dokter
 *
 * @author Bert
 */
class Dokter {
    
    private $id;
    private $naam;
    
   
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNaam() {
        return $this->naam;
    }

    public function setNaam($naam) {
        $this->naam = $naam;
    }

   function GetDoktoren()
     {
        require 'Credentials2.php'; 
         
        mysql_connect($host,$user,$passwd) or die(mysql_error()) ;
        mysql_select_db($database);
        $result = mysql_query("SELECT * FROM dokter") or die(mysql_error());
        $doktoren = array();
        
        while($row = mysql_fetch_array($result))
        {
            $id = $row[0];
            $naam = $row[1];
            
            $doktoren[$id]= array("naam"=>$naam);
        }
        
        
        mysql_close();
        return $doktoren;
        
        
     }

    
}

?>
