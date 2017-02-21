<?php

class Application_Model_DbTable_QuestionTranslation extends Zend_Db_Table_Abstract
{

    protected $_name = 'question_translation';
    protected $_primary = 'id';

    protected $_schema = 'QuestionBankDB';

    protected $_referenceMap = array(
        'Question' => array(
            'columns' => 'question_id',
            'refTableClass' => 'Application_Model_DbTable_Question',
            'refColumns' => 'id'
        ),
        'Language' => array(
            'columns' => 'language_id',
            'refTableClass' => 'Application_Model_DbTable_Language',
            'refColumns' => 'id')
        );


    /*******methode om de alles question translations op te halen volgens een bepaalde language id*******/
    public function getQuestionTranslationByLanguageId($lid)
    {
        $lid = (int)$lid;
        $row = $this->fetchRow('language_id' . $lid);
        if (!$row) {
            throw new Exception("Could not find row $lid");
        }
        return $row->toArray();
    }

    /*******methode om alle question translation op te halen volgens een id van de question translation*******/
    public function getQuestionTranslationById($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }

    /*******methode om de text van de question translation te updaten in de questionbank dataset*******/
    public function updateQuestionTranslationByQuestionId($id,$text)
    {
        $data = array(
            'text'=>$text
        );
        $this->update($data, 'question_id = '. (int)$id);

    }


}

