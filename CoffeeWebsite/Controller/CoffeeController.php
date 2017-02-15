<script>
  function showConfirm(id)
  {
      var c = confirm("Are you sure you want to delete this item?");
          if (c)
          {
            window.location = "CoffeeOverview.php?delete=" + id;  
          }
  }
</script>

<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CoffeeController
 *
 * @author Bert
 */

require ("Model/CoffeeModel.php");
class CoffeeController {
    
    function CreateOverviewTable()
    {
        $result = "
             <table class='overviewTable'>
                <tr>
                  <td></td>
                  <td></td>
                  <td><b>Id</b></td>
                  <td><b>Name</b></td>
                  <td><b>Type</b></td>
                  <td><b>Price</b></td>
                  <td><b>Roast</b></td>
                  <td><b>Country</b></td>
                </tr>";
        
        $coffeeArray = $this->GetCoffeeByType('%');
        
        foreach ($coffeeArray as $key => $value)
        {
            $result = $result . 
                        "<tr>
                            <td><a href = 'CoffeeAdd.php?update=$value->id'>Update</a></td>
                            <td><a href = '#' onclick=showConfirm($value->id)>Delete</a></td>
                            <td>$value->id</td>
                            <td>$value->name</td>
                            <td>$value->type</td>
                            <td>$value->price</td>
                            <td>$value->roast</td>
                            <td>$value->country</td>
                         </tr>";   
            
                                                 
        }
        
        $result = $result . "</table>";
        
        return $result;
    }
    
    
    function CreateCoffeeDropdownlist()
    {
        $coffeeModel = new CoffeeModel();
        $result = "<form action='' method='post' width='200px'>
                    Please select a type:
                    <select name='types'>
                       <option value='%'>All</option>
                       ".$this->CreateOptionValues($coffeeModel->GetCoffeeTypes()).
                     "</select>
                         <input type='submit' value='Search'/>
                         </form>";
        
        return $result;
    }
    
    function CreateOptionValues(array $valueArray)
    {
        $result="";
        
        foreach($valueArray as $value)
        {
            $result = $result . "<option value='$value'>$value</option>";
        }
        
        
        return $result;
    }
    
    function CreateCoffeeTables($types)
    {
        $coffee = new CoffeeModel();
        $coffeeArray = $coffee->GetCoffeeByType($types);
        $result="";
        
        foreach($coffeeArray as $key=>$coffee)
            {
            $result=$result . "<table class = 'coffeeTable'>
                                   <tr>
                                      <th rowspan='6' width='150px'><img runat='server' src='$coffee->image'/></th>
                                      <th width='75px'>Name: </th>
                                      <td width ='75px'>$coffee->name</td>
                                   </tr>
                    
                    
                                     <tr>
                                      <th></th>
                                      <th>Type: </th>
                                      <td>$coffee->type</td>
                                   </tr>
                    
                    
                                   <tr>
                                     <th></th>
                                      <th>Price: </th>
                                      <td>$coffee->price</td>
                                   </tr>
                    
                      <tr>
                                      <tr>
                                      <th></th>
                                      <th>Roast: </th>
                                      <td>$coffee->roast</td>
                                   </tr>
                    
                      <tr>
                                      <th></th>
                                      <th>Origin: </th>
                                      <td>$coffee->country</td>
                                   </tr>
                    
                      <tr>
                                      <th></th>
                                      <td colspan = '2'>$coffee->review</td>
                                   </tr>
                    
                    </table>";
        }
        return $result;
    }
    
    function GetImages()
    {
        $handle = opendir("Images/Coffee");
        
        while($image = readdir($handle))
        {
           $images[] = $image; 
        }
        
        closedir($handle);
        
        $imageArray = array();
        foreach($images as $image)
        {
           if(strlen($image) > 2) 
           {
               array_push($imageArray, $image);
           }
        }
        
        $result = $this->CreateOptionValues($imageArray);
        return $result;
    }
    
    function InsertCoffee()
    {
        $name = $_POST['txtName']; 
        $type = $_POST['ddlType']; 
        $price = $_POST['txtPrice']; 
        $roast = $_POST['txtRoast']; 
        $country = $_POST['txtCountry']; 
        $image = $_POST['ddlImage']; 
        $review = $_POST['txtReview']; 
        
        $coffee = new CoffeeEntity(-1, $name, $type, $price, $roast, $country, $image, $review);
        $coffeeModel = new CoffeeModel();
        $coffeeModel->InsertCoffee($coffee);
    }
    
    function UpdateCoffee($id)
    {
        $name = $_POST['txtName']; 
        $type = $_POST['ddlType']; 
        $price = $_POST['txtPrice']; 
        $roast = $_POST['txtRoast']; 
        $country = $_POST['txtCountry']; 
        $image = $_POST['ddlImage']; 
        $review = $_POST['txtReview']; 
        
        $coffee = new CoffeeEntity($id, $name, $type, $price, $roast, $country, $image, $review);
        $coffeeModel = new CoffeeModel();
        $coffeeModel->UpdateCoffee($id, $coffee);
        
        
    }
    
    function DeleteCoffee($id)
    {
        $coffeeModel = new CoffeeModel();
        $coffeeModel->DeleteCoffee($id);
    }
    
    function GetCoffeeByType($type)
    {
       $coffee = new CoffeeModel();
       return $coffee->GetCoffeeByType($type);
    }
    
    function GetCoffeeById($id)
    {
        $coffee = new CoffeeModel();
        return $coffee->GetCoffeeById($id);
        
    }
    
    function GetCoffeeTypes()
    {
        $coffee = new CoffeeModel();
        return $coffee->GetCoffeeTypes();
    }
}

?>
