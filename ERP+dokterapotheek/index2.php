<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<?php include './Controller/DokterApotheekController.php';

       $controller = new DokterApotheekController();
        

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Homepagina Dokter Apotheek</title>
    </head>
    <body>
         <div id="wrapper">
            <div id ="banner">
                
            </div>
            
            <nav id="navigation">
                <ul id="nav">
                    <li><a href="index2.php">Home</a></li>
                    <li><a href="Voorschrift.php">Voorschriften</a></li>
                    <li><a href="Apotheek.php">Apotheek</a></li>
                    <li><a href="#">About</a></li>
                    
                </ul>
            </nav>
            
            <div id="content_area">
             <h2><?php
        echo "Welkom bij de doktoren die voorschriften zullen voorzien voor apotheken!!!!"
        ?></h2>
        
        <h3>
            in aanmerking komende Doktoren momenteel 
        </h3>
        
        <table>
            <tr>
                <th>id</th>
                <th>naam</th>
            </tr>
            
            <pre><?php foreach($controller->getDoktoren() as $id=>$values)
            {
                foreach($values as $naam)
                {
                    echo "<tr><td>".$id."</td>"."<td>".$naam."</td></tr>";
                       
                }
            }
            
            
          ?></pre>
            
         </table>
            </div>
            
            <div id="sidebar">
                
                
            </div>
            
            <footer>
                <p>All rights reserved</p>
            </footer>
            
        </div>        
       
    </body>
</html>
