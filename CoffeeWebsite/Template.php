<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
  
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" type="text/css" href="Styles/Stylesheet.css"/>  
        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">﻿
    </head>
    <body>
        <div id="wrapper">
            <div id ="banner">
                
            </div>
            
            <nav id="navigation">
                <ul id="nav">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="Coffee.php">Coffee</a></li>
                    <li><a href="#">Shop</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="Management.php">Management</a></li>
                </ul>
            </nav>
            
            <div id="content_area">
            <?php echo $content; ?>
            </div>
            
            <div id="sidebar">
                
                
            </div>
            
            <footer>
                <p>All rights reserved</p>
            </footer>
            
        </div>        
</html>
