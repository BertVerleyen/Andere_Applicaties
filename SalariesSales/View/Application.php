<?php

require ("/xampp/htdocs/SalariesSales/Controller/SalesStaffController.php");
date_default_timezone_set('UTC');
//huidige datum
/*echo date("l d/m/Y");
echo "\n";
//$date = date_create("2017/02/01");
//echo date_format($date, "d/m/Y");
echo "\n";
//$d = new DateTime( '2017-01-01' ); 
echo "\n";
//echo $d->format( 't/m/Y' );
echo "\n";*/


$controller = new SalesStaffController();

//laatste dag van elke maand

//$strdate = date("2017/m/t");
//15de van elke maand
//$str2date = date('2017/m/15', strtotime('+ '.$i.' months '));
//$strdate = date('2017/m/t',strtotime('+ '.$i.' months '));


$csvdata = array();

for($i=-1;$i<=10;$i++)
{
    $str2date = date('2017/m/15', strtotime('+ '.$i.' months '));
    $strdate = date('2017/m/t',strtotime('+ '.$i.' months '));
    $csvdata[] = $controller->PaymentDatesMonth($strdate, $str2date);
    
}

/************************ADD*****DATA***TO DATABASE*********************************************************/
foreach($csvdata as $databaseRow)
{
      
     
    $query = sprintf("SELECT * FROM overview_year_salary_payment
    WHERE Monthly_salary_Date='%s' AND Bonus_month_Date = '%s'",
    mysql_real_escape_string($databaseRow['Salary Date']),
    mysql_real_escape_string($databaseRow['Bonus']));
    
    $controller->checkDuplicatesDatabase($query);
                             
    $checkRecord = mysql_query($query);;
     
     if (!$checkRecord) 
     {
          die('Query failed to execute');
     }
    
    if (mysql_num_rows($checkRecord) >= 1) 
    {  
       echo "There are duplicate records. Inserting has been prohibited!!! ";
    }
    else
    {
      $controller->insertPaymentDatesIntoDB($databaseRow['Month'], $databaseRow['Salary Date'], $databaseRow['Bonus']);

    }
}
/*********************WRITE TO CSV FILE*****************************************************************************************/


$csvkolomnamen = array("Month", "Salary date", "Bonus month");
$file = 'SalesStaffMonthlyPayments.csv';
//$handle = $controller->openCSVFile($file); => Gives warnings and doesn't let you write CSV output **

$handle = fopen($file, 'w');
$line_sep = array("______________________________________________________________");
$newline = array("");
//You can choose if you wanna use a comma separator or not
//You would have to use fputcsv($handle, $csvkolomnamen); and ****
fputcsv($handle, $csvkolomnamen,"\t\t\t");
fputcsv($handle,$line_sep,"\r");
fputcsv($handle,$newline,"\r");

foreach($csvdata as $row)
{
    //**** fputcsv($handle, $row);
     fputcsv($handle, $row,"\t\t\t\t\t");
     fputcsv($handle,$newline,"\r");
   
}
         
 fclose($handle);

//$controller->writeCSV($file,$handle, $csvkolomnamen, $csvdata); =>Same issue as **




//$controller->closeCSVFile($handle); => Same issue as **




?>
