<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Evenement
 *
 * @author Bert
 */
require ("Entities/EvenementEntity.php");
class Evenement {
    
   
    function getAllEvenementen(){
            
    $evtn = array(array());
    
     require 'Credentials.php';
         mysql_connect($host,$user,$passwd) or die(mysql_error()) ;
          mysql_select_db($database);
          
          
          $query = "SELECT * FROM evenement";
          $result = mysql_query($query) or die(mysql_error());
          
         
          while($row = mysql_fetch_array($result))
          {
              $id=$row[0];
             // $name = $row[1];
               $datum = $row[1];
               $beschrijving = $row[2];
                /*$stringUur = $row[3];
                 
                  $remindersTo = $row[5]; */
                  
                   
                   //$evenement = new EvenementEntity($id, null, $datum, null, $beschrijving, null); 
                      
                      //$evtn[]= $id;
                      $evtn[$id] = array("datum"=>$datum, "beschrijving"=>$beschrijving);
                      //$evtn[$datum]= $beschrijving;
                      
                   
          }
         mysql_close();
         return $evtn;

    }
    
    
     function InsertEvenement($evt)
    {
     $query = sprintf("INSERT INTO evenement (datum,beschrijving)
                                     VALUES ('%s','%s')",
                                    mysql_escape_string($evt->datum),
                                    mysql_escape_string($evt->beschrijving)
                                    
                                      );
     $this->PerformQuery($query);   
                   
    }
    
    
    function UpdateEvenement($id, $evt)
    {
      $query = sprintf("UPDATE evenement SET datum = '%s',
                                          beschrijving = '%s', 
                                          
                                      WHERE id = $id",
                                    mysql_escape_string($evt->datum),
                                    mysql_escape_string($evt->beschrijving)
                                    
                                      );
     $this->PerformQuery($query); 
    }
    
    function DeleteEvenement($id)
    {
       $query = sprintf("DELETE FROM evenement 
                                 WHERE id = $id"
                                 );
     $this->PerformQuery($query); 
    
    }
    
     function GetEvenementById($id)
     {
         $evtn = array();
          require 'Credentials.php';
         mysql_connect($host,$user,$passwd) or die(mysql_error()) ;
          mysql_select_db($database);
          
          
          $query = "SELECT * FROM evenement WHERE id = $id";
          $result = mysql_query($query) or die(mysql_error());
          
         
          while($row = mysql_fetch_array($result))
          {
              $datum = $row[1];
               $beschrijving = $row[2];
               
                   $evenement = new EvenementEntity($id, null, $datum, null, $beschrijving, null); 
                    //$evtn[$id] = array("datum"=>$datum, "beschrijving"=>$beschrijving);        
          }
         mysql_close();
         return $evenement;
     }
    
    
    function PerformQuery($query)
    {
         require 'Credentials.php';
         mysql_connect($host,$user,$passwd) or die(mysql_error()) ;
          mysql_select_db($database);
                  
         mysql_query($query) or die(mysql_error());          
         mysql_close();
    }

}

?>
