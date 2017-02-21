<?php

class Application_Model_DbTable_UserQuiz extends Zend_Db_Table_Abstract
{

    protected $_name = 'user_quiz';
    protected $_primary = 'id';


    protected $_schema = 'QuestionBankDB';




    protected $_referenceMap = array(

        'User' => array('columns' => 'user_id',
                        'refTableClass' => 'Application_Model_DbTable_User',
                        'refColumns' => 'id'),
        'Quiz' => array('columns' => 'quiz_id',
            'refTableClass' => 'Application_Model_DbTable_Quiz',
            'refColumns' => 'id'),
    );




}

