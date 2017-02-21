<?php

class Application_Model_DbTable_QuizTranslation extends Zend_Db_Table_Abstract
{

    protected $_name = 'quiz_translation';
    protected $_primary = 'id';


    protected $_schema = 'QuestionBankDB';



    protected $_dependentTables = array('Application_Model_DbTable_Quiz',
                                        'Application_Model_DbTable_Language');




}

