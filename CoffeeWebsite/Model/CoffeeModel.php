<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoffeeModel
 *
 * @author Bert
 */

require ("Entities/CoffeeEntity.php");
class CoffeeModel {
    
     function GetCoffeeTypes()
     {
        require 'Credentials.php'; 
         
        mysql_connect($host,$user,$passwd) or die(mysql_error()) ;
        mysql_select_db($database);
        $result = mysql_query("SELECT DISTINCT type FROM coffee") or die(mysql_error());
        $types = array();
        
        while($row = mysql_fetch_array($result))
        {
            array_push($types,$row[0]);
        }
        
        mysql_close();
        return $types;
        
        
     }
     
     function GetCoffeeByType($type)
     {
        require 'Credentials.php';
         mysql_connect($host,$user,$passwd) or die(mysql_error()) ;
          mysql_select_db($database);
          
          
          $query = "SELECT * FROM coffee WHERE type LIKE '$type'";
          $result = mysql_query($query) or die(mysql_error());
          $coffeeArray = array();
         
          while($row = mysql_fetch_array($result))
          {
              $id = $row[0];
              $name = $row[1];
               $type = $row[2];
                $price = $row[3];
                 $roast = $row[4];
                  $country = $row[5]; 
                   $image = $row[6];
                   $review = $row[7];
                   
                   $coffee = new CoffeeEntity($id,$name,$type,$price,$roast,$country,$image,$review);
                   array_push($coffeeArray,$coffee);
                   
                   
                   
          }
          mysql_close();
          return $coffeeArray;
     }
     
     function GetCoffeeById($id)
     {
          require 'Credentials.php';
         mysql_connect($host,$user,$passwd) or die(mysql_error()) ;
          mysql_select_db($database);
          
          
          $query = "SELECT * FROM coffee WHERE id = $id";
          $result = mysql_query($query) or die(mysql_error());
          
         
          while($row = mysql_fetch_array($result))
          {
              $name = $row[1];
               $type = $row[2];
                $price = $row[3];
                 $roast = $row[4];
                  $country = $row[5]; 
                   $image = $row[6];
                   $review = $row[7];
                   
                   $coffee = new CoffeeEntity($id,$name,$type,$price,$roast,$country,$image,$review);        
          }
         mysql_close();
         return $coffee;
     }
     
    function InsertCoffee(CoffeeEntity $coffee)
    {
     $query = sprintf("INSERT INTO coffee (name,type,price,roast,country,image,review)
                                     VALUES ('%s','%s','%s','%s','%s','%s','%s')",
                                    mysql_escape_string($coffee->name),
                                    mysql_escape_string($coffee->type),
                                    mysql_escape_string($coffee->price),
                                    mysql_escape_string($coffee->roast),
                                    mysql_escape_string($coffee->country),
                                    mysql_escape_string("Images/Coffee/" . $coffee->image),
                                    mysql_escape_string($coffee->review)
                                      );
     $this->PerformQuery($query);   
                   
    }
    
    
    function UpdateCoffee($id, CoffeeEntity $coffee)
    {
      $query = sprintf("UPDATE coffee SET name = '%s',
                                          type = '%s', 
                                          price = '%s',
                                          roast = '%s',
                                          country = '%s',
                                          image = '%s',
                                          review = '%s'
                                      WHERE id = $id",
                                    mysql_escape_string($coffee->name),
                                    mysql_escape_string($coffee->type),
                                    mysql_escape_string($coffee->price),
                                    mysql_escape_string($coffee->roast),
                                    mysql_escape_string($coffee->country),
                                    mysql_escape_string("Images/Coffee/" . $coffee->image),
                                    mysql_escape_string($coffee->review)
                                      );
     $this->PerformQuery($query); 
    }
    
    function DeleteCoffee($id)
    {
       $query = sprintf("DELETE FROM coffee 
                                 WHERE id = $id"
                                 );
     $this->PerformQuery($query); 
    
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
