<?php

require 'Controller/EvenementController.php';
$EvtController = new EvenementController();

$title = 'Add a new Evenement to planning';

if(isset($_GET["update"]))
{
  $evt = $EvtController->GetEvenementById($_GET["update"]); 
  
  $content = "<form action='' method='post'>

    <fieldset>
        <legend>Update Evenement object with id ".$_GET['update']."</legend>
        
        <label for='datum'>Datum: </label>
        <input type='text' class='inputField' name='txtDatum' value='$evt->datum' /><br/>
        
        
        
        
        
       <label for='beschrijving'>Beschrijving: </label>
        <textarea cols='70' rows='12' name='txtBeschrijving' value='$evt->beschrijving'>
       </textarea>
       
       
        <input type='submit' value='Submit'>
    </fieldset>
    
</form>"; 
  
  
} 
else
{
   $content = "<form action='' method='post'>

    <fieldset>
        <legend>Add a new Coffee</legend>
        
        <label for='datum'>Datum: </label>
        <input type='text' class='inputField' name='txtDatum' /><br/>
        
     
        
    
        <label for='beschrijving'>Beschrijving: </label>
        <textarea cols='70' rows='12' name='txtBeschrijving'>
       </textarea>
       
        <input type='submit' value='Submit'>
    </fieldset>
    
</form>"; 
}


if(isset($_GET["update"]))
{
    if(isset($_POST["txtDatum"]))
  {
    $EvtController->UpdateEvenement($_GET["update"]);
  } 
}
else{
//andere checks ook doen

  if(isset($_POST["txtDatum"]))
  {
    $EvtController->InsertEvenement();
  }
}
include 'index.php';

?>
