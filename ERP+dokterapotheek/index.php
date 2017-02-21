<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Overzicht geplande evenementen</title>
    </head>
    <body>
        <?php
        include './Controller/EvenementController.php';
        
        $e = new EvenementController();
        $evtnArray = $e->GetAlleEvenementen();
        echo "<table border='1'>";
        echo "<tr colspan='25px'>";
        //echo "<td>";
        
       
       
          print "<pre>";
          
         unset($evtnArray[0]);
         $evtnArray = array_filter($evtnArray);
         
         echo "<tr><th>Id</th><th>Datum</th><th>Beschrijving</th></tr>";
         foreach($evtnArray as $key => $values)
         {
             
             echo "<tr><td>".$key."</td>";
             foreach($values as $val)
             {
                 
                 echo "<td>".$val."</td>";
                 echo "<td><a href = 'EvenementAdd.php?update='$key'>Update</a></td>";
             }
         }
          //print_r($e->GetAlleEvenementen());
       echo "</tr>";  
       print "</pre>"; 
        
        echo "</td>";
        echo "</tr>";
        echo "</table>";
        echo "<button type='submit'><a href='EvenementAdd.php?update=$key'>Update</a></button>";
        echo "<button type='submit'><a href='EvenementAdd.php?delete=$key'>Delete</a></button>";
        echo "<button type='submit'><a href='EvenementAdd.php'>Add new Evenement</a></button>";
        ?>
        
        
    </body>
</html>
