<?php

class Application_Model_DbTable_Userqb extends Zend_Db_Table_Abstract
{

    protected $_name = 'user';

    protected $_primary = 'id';


    protected $_schema = 'QuestionBankDB';


    protected $_dependentTables = array('Application_Model_DbTable_Userquizqb');



    /*******methode om de users uit de questionbank dataset op te vragen*******/
    public function getUser($username)
    {
        $select = $this->select()
            ->from($this,array("username"))
            ->where('username=?',$username);

        $stmt = $select->query();

        $result = $stmt->fetchAll();

        if($result)
        {
            return true;
        }

        return false;
    }
}

