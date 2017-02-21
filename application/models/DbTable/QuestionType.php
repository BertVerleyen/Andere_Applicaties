<?php

class Application_Model_DbTable_QuestionType extends Zend_Db_Table_Abstract
{

    protected $_name = 'question_type';

    protected $_primary = 'id';


    protected $_schema = 'QuestionBankDB';


    protected $_referenceMap = array(

        'Question' => array(   'columns' => 'question_id',
                                    'refTableClass' => 'Application_Model_DbTable_Question',
                                    'refColumns' => 'id')
    );


    /*******methode die gebruikt wordt om de questiontype op te halen volgens id*******/
    public function getQuestionType($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('question_id = ' . $id);
        if (!$row) {
            throw new Exception("C
            ould not find row $id");
        }
        return $row->toArray();
    }

}

