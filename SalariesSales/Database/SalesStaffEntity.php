<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SalesStaffEntity
 *
 * @author Bert
 */
class SalesStaffEntity {
    
    public $id;
    public $month;
    public $monthlySalaryDate;
    public $bonusDate;
    
    function __construct($month, $monthlySalaryDate, $bonusDate) {
        $this->month = $month;
        $this->monthlySalaryDate = $monthlySalaryDate;
        $this->bonusDate = $bonusDate;
    }

    
    
}

?>
