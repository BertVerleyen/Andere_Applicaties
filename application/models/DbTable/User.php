<?php

class Application_Model_DbTable_User extends Zend_Db_Table_Abstract
{

    protected $_name = 'user';
    protected $_primary = 'id';


    protected $_schema = 'QuestionBankDB';



    protected $_dependentTables = array('Application_Model_DbTable_UserQuiz');


    protected $_referenceMap = array(

        'language' => array('columns' => 'language_id',
                            'refTableClass' => 'Application_Model_DbTable_Language',
                            'refColumns' => 'id'));



    /*******methode om te controleren of de user admin is volgens role id*******/
    public function getAdminUserByUserName($username)
    {
        $select = $this->select()
            ->from($this,array("username"))
            ->where('role_id=?',7)->where('username=?',$username);

        $stmt = $select->query();

        $result = $stmt->fetchAll();

        if($result)
        {
            return $result;
        }

        return null;
    }

    /*******methode om de adminusers op te vragen*******/
    public function getAdminUsers()
    {
        $select = $this->select()
            ->from($this,array("username"))
            ->where('role_id=?',7);

        $stmt = $select->query();

        $result = $stmt->fetchAll();

        if($result)
        {
            return $result;
        }

        return null;
    }


    /*******methode om te bepalen of een user al dan niet admin is*******/
    public function isAdmin($username)
    {
        $select = $this->select()
            ->from($this,array("username"))
            ->where('role_id=?',7)->where('username=?',$username);

        $stmt = $select->query();

        $result = $stmt->fetchAll();

        if($result!=null)
        {
            return true;
        }

        return false;
    }

}

