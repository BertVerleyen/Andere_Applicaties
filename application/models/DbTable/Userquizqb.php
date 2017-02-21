<?php

class Application_Model_DbTable_Userquizqb extends Zend_Db_Table_Abstract
{

    protected $_name = 'qbank_user_quiz';

    protected $_primary = 'id';


    protected $_schema = 'QuestionBankDB';



    protected $_referenceMap = array(

        'User' => array('columns' => 'user_id',
            'refTableClass' => 'Application_Model_DbTable_Userqb',
            'refColumns' => 'id'),
        'Quiz' => array('columns' => 'quiz_id',
            'refTableClass' => 'Application_Model_DbTable_Quizqb',
            'refColumns' => 'id'),
    );


    /*******methode om de user en de quizid op te slaan indien er een user en quiz is aangemaakt*******/
    public function SaveUserIdAndQuizId($userid,$quizid)
    {
        $data=array(
            'quiz_id'=>$quizid,
            'user_id'=>$userid
        );

        $this->insert($data);
    }
}

