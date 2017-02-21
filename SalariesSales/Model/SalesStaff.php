<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SalesStaff
 *
 * @author Bert
 */

require '/xampp/htdocs/SalariesSales/Database/SalesStaffEntity.php';
class SalesStaff {
   
      function GetOverviewYearPayment()
     {
        require 'DatabaseAuth.php'; 
         
        mysql_connect($host,$user,$passwd) or die(mysql_error()) ;
        mysql_select_db($database);
        $result = mysql_query("SELECT * FROM Overview_Year_Salary_Payment") or die(mysql_error());
        $data = array();
        
        while($row = mysql_fetch_array($result))
        {
            $month = $row[1];
            $monthlySalaryDate = $row[2]; 
            $bonusDate = $row[3];
    
           
            
            $overview = new SalesStaffEntity($month, $monthlySalaryDate, $bonusDate);
            $data[] = $overview;
        }
        
        mysql_close();
        return $data;
        
        
     }
     
     
     
     function SelectPaymentDatesByMonth($month)
     {
          require 'DatabaseAuth.php';
         mysql_connect($host,$user,$passwd) or die(mysql_error()) ;
          mysql_select_db($database);
          
          
          $query = "SELECT * FROM Overview_Year_Salary_Payment WHERE Month = $month";
          $result = mysql_query($query) or die(mysql_error());
          
         
          while($row = mysql_fetch_array($result))
          {
              $month = $row[1];
               $monthlySalaryDate = $row[2];
                $bonusDate = $row[3];
                
                   
                   $overviewByMonth = new SalesStaffEntity($month, $monthlySalaryDate, $bonusDate);       
          }
         mysql_close();
         return $overviewByMonth;
     }
     
    function InsertPaymentDatesMonth(SalesStaffEntity $salesStaff)
    {
     $query = sprintf("INSERT INTO Overview_Year_Salary_Payment (Month,Monthly_salary_Date,Bonus_month_Date)
                                     VALUES ('%s','%s','%s')",
                                    mysql_escape_string($salesStaff->month),
                                    mysql_escape_string($salesStaff->monthlySalaryDate),
                                    mysql_escape_string($salesStaff->bonusDate)
                                      );
     $this->PerformQuery($query);   
                 

    }
    
    
    function UpdatePaymentDatesMonth($month, SalesStaffEntity $salesStaff)
    {
      $query = sprintf("UPDATE Overview_Year_Salary_Payment
                                          SET Monthly_salary_Date = '%s', 
                                          Bonus_month_Date = '%s',
                                          
                                      WHERE Month = $month",
                                    mysql_escape_string($salesStaff->month),
                                    mysql_escape_string($salesStaff->monthlySalaryDate),
                                    mysql_escape_string($salesStaff->bonusDate)
                                      );
     $this->PerformQuery($query); 
    }
    
    function DeletePaymentDatesMonth($month)
    {
       $query = sprintf("DELETE FROM Overview_Year_Salary_Payment 
                                 WHERE Month = $month"
                                 );
     $this->PerformQuery($query); 
    
    }
    
    function PerformQuery($query)
    {
         require '/xampp/htdocs/SalariesSales/Database/DatabaseAuth.php';
         mysql_connect($host,$user,$passwd) or die(mysql_error()) ;
          mysql_select_db($database);         
         mysql_query($query) or die(mysql_error());          
         mysql_close();
    }
    
     
     
     
     
     
}

?>
