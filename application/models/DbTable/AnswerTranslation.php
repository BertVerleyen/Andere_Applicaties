<?php

class Application_Model_DbTable_AnswerTranslation extends Zend_Db_Table_Abstract
{

    protected $_name = 'answer_translation';
    protected $_primary = 'id';


    protected $_schema = 'QuestionBankDB';



    protected $_referenceMap = array(
        'Answer' => array(
            'columns' => 'answer_id',
            'refTableClass' => 'Application_Model_DbTable_Answer',
            'refColumns' => 'id'
        ),
        'Language' => array(
            'columns' => 'language_id',
            'refTableClass' => 'Application_Model_DbTable_Language',
            'refColumns' => 'id')
    );


    /*******methode die gebruikt wordt om de answer translation op te halen bij een bepaalde language_id*******/
    public function getAnswerTranslationByLanguageId($lid)
    {
        $lid = (int)$lid;
        $row = $this->fetchRow('language_id' . $lid);
        if (!$row) {
            throw new Exception("Could not find row $lid");
        }
        return $row->toArray();
    }

}

