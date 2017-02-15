<?php
require './Controller/CoffeeController.php';

$title = 'Manage coffee objects';

$coffeeController = new CoffeeController();

$content = $coffeeController->CreateOverviewTable();

if(isset($_GET["delete"]))
{
    $coffeeController->DeleteCoffee($_GET["delete"]);
}


include './Template.php';
?>
