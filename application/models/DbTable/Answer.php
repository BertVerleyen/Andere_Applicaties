<?php

class Application_Model_DbTable_Answer extends Zend_Db_Table_Abstract
{

    protected $_name = 'answer';


    protected $_primary = 'id';

    protected $_schema = 'QuestionBankDB';




    protected $_dependentTables = array('Application_Model_DbTable_AnswerTranslation');

    protected $_referenceMap = array(
        'Question' => array(
            'columns' => 'question_id',
            'refTableClass' => 'Application_Model_DbTable_Question',
            'refColumns' => 'id')
    );



    /*************eventueel voor later bij uitbreidingen
    methode die zoekt naar de grootste primary key om de laatst toegevoegde primary key op te kunnen halen
    -> ter vervanging van de bestaande methode lastinsertid() binnen Zend Framework******************/
    public function getMaxPK()
    {
        $max=$this->fetchRow($this->select()
            ->from($this, array('maxId'=>'max(id)')));
        return (int)$max['maxId'];
    }



    /*******Methode die controleerd of een antwoord al dan niet is toegevoegd via de deleted tabel->gebruikt voor flags*******/
    public function editControlAnswer($id)
    {
        $select = $this->select();

        $select->where('id = ?', $id)->where('deleted = ?',0);
        $row = $this->fetchRow($select);
        $edited=false;
        if($row){
            return $edited;
        }
        else{
            $edited=true;
            return $edited;
        }
    }


    /*******Methode die gebrukt wordt om de records binnen de surveyanyplace dataset een waarde mee te geven,
     * zodat er kan gecontroleerd worden of ze al dan niet zijn toegevoegd
     -> bij waarde 1-> answer toegevoegd aan de questionbank dataset*******/
    public function updateAnswerDeleted($id)
    {
        $data = array(

            'deleted' => 1
        );
        $this->update($data,'id= '.$id);
    }


    /*******Methode die gebruikt wordt om de deleted tabel op 0 te zetten indien er records gedelete worden binnen de questionbank dataset
     -> dit is nodig om te controleren of een antwoord al dan niet is toegevoegd
     -> indien het deleted veld de waarde 0 heeft kan het antwoord opnieuw worden toegevoegd*******/
    public function setAnswerNotDeleted($id)
    {
        $data = array(

            'deleted' => 0
        );
        $this->update($data,'id = ' .$id);
    }


    /*******Methode voor het deleten van answers indien er een checkbox is aangevinkt*******/
    public function deleteAnswer($id)
    {
        $this->delete('id =' . (int)$id);
    }


    /*******methode die alle answers met de daarbijhorende answer translation ophaalt*******/
    public function getAnswersFromLanguage($lid, $qid)
    {

        $select = $this->select()->from(array('a'=>'answer'),array('at.text')/*array('a.question_id')*/)->setIntegrityCheck(false)
            ->where('question_id =?', $qid)
            ->join(array('at'=>'answer_translation', 'a'=>'answer'), 'a.id = at.answer_id')
            ->join(array('q'=>'question', 'a'=>'answer'),'a.question_id = q.id');

        $row = $this->fetchAll($select);

        return $row->toArray();
    }

    /*******methode die alle answers ophaald volgens een bepaalde question*******/
    public function getAnswersFromQuestion($qid, $lid)
    {
        $select = $this->select()->from(array('a'=>'answer'),array('a.id as answer_id'))->setIntegrityCheck(false)
            ->where('question_id =?', $qid)
            ->join(array('at'=>'answer_translation', 'a'=>'answer'), 'a.id = at.answer_id')
            ->join(array('q'=>'question', 'a'=>'answer'),'a.question_id = q.id');

        $row = $this->fetchAll($select);

        return $row->toArray();
    }


}

