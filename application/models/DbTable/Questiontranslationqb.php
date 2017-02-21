<?php

class Application_Model_DbTable_Questiontranslationqb extends Zend_Db_Table_Abstract
{

    protected $_name = 'qbank_question_translation';

    protected $_primary = 'id';


    protected $_schema = 'QuestionBankDB';

    //protected $_adapter = 'db2';

    protected $_referenceMap = array(
        'Qbank_Question' => array(
            'columns' => 'question_qb_id',
            'refTableClass' => 'Application_Model_DbTable_Questionqb',
            'refColumns' => 'id'
        ),
        'Language' => array(
            'columns' => 'language_id',
            'refTableClass' => 'Application_Model_DbTable_Language',
            'refColumns' => 'id')
    );


    /*************eventueel voor later bij uitbreidingen******************/
    /*******methode die gebruikt wordt om de laatst toegevoegde question op te vragen
     -> ter vervanging van de bestaande methode lastinsertid() in Zend Framework*******/
    public function getMaxQuestionID()
    {
        $max=$this->fetchRow($this->select()
            ->from($this, array('maxId'=>'max(question_id)')));
        return (int)$max['maxId'];
    }

    /*******methode om de question translation op te halen volgens de question_qb_id van de question translation*******/
    public function getQuestionTranslationByIdQB($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('question_qb_id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }

    /*******toevoegen van data in de question translation binnen questionbank dataset van de zelf toegevoegde vragen via de jQuery 'Add question'*******/
    public function insertJavascriptData($jstext,$jslsid,$jslastinsertid,$languageid)
    {
      $this->insert(array('text'=>$jstext,'question_id'=>$jslsid,'question_qb_id'=>$jslastinsertid,'language_id'=>$languageid));


    }

    /*******methode om data in de question translation tabel op te slaan binnen de questionbank dataset*******/
    public function saveQuestionTranslationQB($text,$qid,$qqbid,$lid)
    {
       $data = array(
           'text' =>$text,
           'question_id'=>$qid ,
           'question_qb_id'=>$qqbid,
           'language_id'=>$lid
       );

       $this->insert($data);
    }


    /*******methode om de text van question translation te wijzigen volgens een bepaalde id binnen de questionbank dataset*******/
    public function updateQuestionTranslationQB($text,$id)
    {
        $data=array(

            'text'=>$text

        );

        $this->update($data,'id='. $id);

    }

    /*******methode om de question translation te deleten volgens een bepaalde id*******/
    public function deleteQuestionTrQB($id)
    {
        $this->delete('question_qb_id=' . (int)$id);
    }





}

