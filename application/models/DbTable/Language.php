<?php

class Application_Model_DbTable_Language extends Zend_Db_Table_Abstract
{

    protected $_name = 'language';

    protected $_key = 'id';


    protected $_schema = 'QuestionBankDB';


    protected $_dependentTables = array('Application_Model_DbTable_QuestionTranslation',
                                        'Application_Model_DbTable_AnswerTranslation',
                                        'Application_Model_DbTable_QuizTranslation',
                                        'Application_Model_DbTable_Quiz',
                                        'Application_Model_DbTable_User');



}

