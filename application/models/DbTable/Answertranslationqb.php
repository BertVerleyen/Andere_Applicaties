<?php

class Application_Model_DbTable_Answertranslationqb extends Zend_Db_Table_Abstract
{

    protected $_name = 'qbank_answer_translation';


    protected $_primary = 'id';


    protected $_schema = 'QuestionBankDB';


    protected $_referenceMap = array(
        'Qbank_Answer' => array(
            'columns' => 'answer_qb_id',
            'refTableClass' => 'Application_Model_DbTable_Answerqb',
            'refColumns' => 'id'
        ),
        'Language' => array(
            'columns' => 'language_id',
            'refTableClass' => 'Application_Model_DbTable_Language',
            'refColumns' => 'id')
    );



    /*************eventueel voor later bij uitbreidingen******************/
    /********methode die gebruikt kan worden om de laatst toegevoegde answer_id op te vragen
     -> ter vervanging van de bestaande methode listinsertid() van Zend Framework******/
    public function getMaxAnswer_id()
    {
        $max=$this->fetchRow($this->select()
            ->from($this, array('maxId'=>'max(answer_id)')));
        return (int)$max['maxId'];

    }


    /********methode die gebruikt wordt om de answer translation op te vragen bij een bepaalde language id******/
    public function getAnswerTranslationByLanguageIdQB($lid)
    {
        $lid = (int)$lid;
        $row = $this->fetchRow('language_id' . $lid);
        if (!$row) {
            throw new Exception("Could not find row $lid");
        }
        return $row->toArray();
    }

    /********methode die gebruikt wordt om de answer translation van een bepaalde id op te vragen******/
    public function getAnswerTranslationByIdQB($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");

        }
        return $row->toArray();
    }

    /*******methode die gebruikt wordt om de answer translation bij een answer_qb_id op te halen*******/
    public function getAnswerTranslationByAnswerIdQB($anid){

        $id = (int)$anid;
        $row = $this->fetchRow('answer_qb_id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();

    }

    /*******methode die gebruikt wordt om het veld text van answer translation up te daten binnen de questionbank dataset*******/
    public function updateAnswerTranslationQB($text,$id){
        $data = array(

            'text' => $text
        );

        $this->update($data, 'id = ' . $id);
    }


    /*******methode die ervoor zorgt dat zelf gemaakte antwoorden a.d.h.v. de jQuery button 'Add answer' wordt opgeslagen in de questionbank dataset********/
    public function insertJavascriptanswerdata($jstext,$aid,$aqbid,$lid)
    {
        $this->insert(array('text'=>$jstext,'answer_id'=>$aid,'answer_qb_id'=>$aqbid,'language_id'=>$lid));
    }


    /********methode die gebruikt wordt om answer translation op te slaan binnen de questionbank dataset******/
    public function saveAnswerTranslationQB($text,$aid,$aqbid,$lid)
    {
        $data = array(
            'language_id'=>$lid,
            'answer_id'=>$aid ,
            'answer_qb_id'=>$aqbid,
            'text' =>$text
        );

        $this->insert($data);
    }

    /*******methode die gebruikt wordt om een answer binnen de questionbank dataset te deleten a.d.h.v. de answer_qb_id*******/
    public function deleteAnswerTrQB($id)
    {
        $this->delete('answer_qb_id =' . (int)$id);
    }

}

