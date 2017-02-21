<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SalesStaffController
 *
 * @author Bert
 */
require ("/xampp/htdocs/SalariesSales/Model/SalesStaff.php");
class SalesStaffController {
   
    
    
    public $result = array();
    
    
    private function amountOfDays($month2Digits, $year)
    {
        return cal_days_in_month(CAL_GREGORIAN, $month2Digits, $year);
    }
    
    public function returnMonth($date){
        
        //full month name
        //return date('F',  strtotime($date));
        //shortened month name
         return date('M',  strtotime($date));
        
    }
    
    public function PaymentDatesMonth($lastDayMonth, $fifteenthDayOfMonth)
    {
       /****************************PAYMENT SALARIES DATES**************************************************************************************/
        if(date('w', strtotime($lastDayMonth))== 6 || date('w', strtotime($lastDayMonth)) == 0)
        {
            
               echo nl2br("salary won't be paid !!!!\n");
               echo nl2br("because it's a ".date('l', strtotime($lastDayMonth))."\n");
               $result['Month'] = $this->returnMonth($lastDayMonth);
            if(date('l', strtotime($lastDayMonth))=="Saturday")
            {
               $salarypayment = date('d/m/Y', strtotime($lastDayMonth. ' - 1 days')); 
               echo nl2br("salary payment op ".$salarypayment."\n\n");
               $result['Salary Date'] = $salarypayment;
            }
            elseif(date('l', strtotime($lastDayMonth))=="Sunday")
            {
                 $salarypayment = date('d/m/Y', strtotime($lastDayMonth. ' - 2 days')); 
                 echo nl2br("salary payment op ".$salarypayment."\n");
                 $result['Salary Date'] = $salarypayment;
            }
        } 
        else
        {
                 echo nl2br("salary will be paid on ".date('d/m/Y', strtotime($lastDayMonth))."\n");
                 $result['Month'] = $this->returnMonth($lastDayMonth);
                 $result['Salary Date'] = date('d/m/Y', strtotime($lastDayMonth));
        }

        
      /****************************BONUS DATES*********************************************************************************/
        if (date('w',  strtotime($fifteenthDayOfMonth)) == 6 || date('w',  strtotime($fifteenthDayOfMonth)) == 0)
        {
                echo nl2br("THE bonus is not allowed to be paid on a saturday or a sunday if it's the 15th\n");
                echo nl2br("The 15th is a ".date('l',  strtotime($fifteenthDayOfMonth))."\n");
     
            if(date('l',  strtotime($fifteenthDayOfMonth)) == "Saturday")
            {
                $wedAfter15th = date('d/m/Y', strtotime($fifteenthDayOfMonth. ' + 4 days'));
                echo nl2br("bonus Payment op ".$wedAfter15th."\n\n");
                $result['Bonus'] = $wedAfter15th;
       
            }
            elseif(date('l',  strtotime($fifteenthDayOfMonth)) == "Sunday")
            {
                $wedAfter15th = date('d/m/Y', strtotime($fifteenthDayOfMonth. ' + 3 days')); 
                echo nl2br("bonus Payment op ".$wedAfter15th."\n");
                $result['Bonus'] = $wedAfter15th;
                
            }
        }
        else{
                echo nl2br("bonus will be paid on ".date('d/m/Y', strtotime($fifteenthDayOfMonth))."\n");
                $result['Bonus'] = date('d/m/Y', strtotime($fifteenthDayOfMonth));
            }
            
        return $result;    
        
    }
    
    
    public function openCSVFile($file)
    {
        
        if(file_exists($file))
        {
          fopen($file, "w");
          
        }
        else 
         {
           echo "error while opening a none existant file";
         }
    }
    
    public function writeCSV($file,$handle, $csvkolomnamen, $csvdata)
    {
       
        if($file!=false)
        {
         fputcsv($handle, $csvkolomnamen);
         echo "kolomnamen toegevoegd";
         
         foreach($csvdata as $row)
         {
             echo "\n";
             fputcsv($handle, $row);
             echo "\n";
         }
         
         
        }
        else
        {
            echo "cannot write to file";
        }
        
      
    }
    
    public function closeCSVFile($handle)
    {
        fclose($handle);
        
    }
    
    
    
    
    public function insertPaymentDatesIntoDB($month, $monthlySalaryDate,$bonusDate)
    {
        $salesStaff = new SalesStaff();
        $salesStaff->InsertPaymentDatesMonth(new SalesStaffEntity($month, $monthlySalaryDate, $bonusDate));
    }
    
    
    
    public function checkDuplicatesDatabase($query)
    {
        require '/xampp/htdocs/SalariesSales/Database/DatabaseAuth.php';
        mysql_connect($host,$user,$passwd) or die(mysql_error()) ;
        mysql_select_db($database);
        
        
    }
    
    
    
    
    
}

?>
