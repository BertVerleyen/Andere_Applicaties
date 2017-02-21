<?php

class Application_Model_DbTable_Answerqb extends Zend_Db_Table_Abstract
{

    protected $_name = 'qbank_answer';


    protected $_primary = 'id';


    protected $_schema = 'QuestionBankDB';

    protected $_dependentTables = array('Application_Model_DbTable_Answertranslationqb');

    protected $_referenceMap = array(
        'Qbank_Question' => array(
            'columns' => 'question_qb_id',
            'refTableClass' => 'Application_Model_DbTable_Questionqb',
            'refColumns' => 'id')
    );


    /*******Methode die gebruikt wordt om te controleren wat het laatst toegevoegde answer is
     -> ter vervanging van de bestaande methode lastinsertid() binnen Zend Framework*******/
    public function getMaxPK()
    {
        $max=$this->fetchRow($this->select()
            ->from($this, array('maxId'=>'max(id)')));
        return (int)$max['maxId'];

    }


    /*******methode die alle answers ophaalt volgens een bepaald aantal via de parameters $aantal en $limiet*******/
    public function getAnswersQB($aantal,$limiet)
    {
        $select = $this->select();

        $select->limit($aantal,$limiet);
        $row = $this->fetchAll($select);

        return $row->toArray();
    }

    /*******methode die alle answers met de daarbij horende answer translation*******/
    public function getAnswersFromQB($aantal,$limiet,$lid)
    {
        $a = new Application_Model_DbTable_Answertranslationqb();
        $select = $a->select()->from(array('a'=>'qbank_answer'),array('at.text'))->setIntegrityCheck(false)
            ->join(array('at'=>'qbank_answer_translation'), 'a.id = at.answer_qb_id')
            ->join(array('q'=>'qbank_question', 'a'=>'answer'),'a.question_qb_id = q.id')
            ->where('language_id = ?', $lid)
            ->limit($aantal,$limiet);

        $row = $a->fetchAll($select);

        return $row->toArray();
    }

    /*******methode die gebruikt wordt of een antwoord al dan niet is toegevoegd aan de hand van de waarde in de deleted tabel*******/
    public function editControlAnswerQB($id)
    {
        $select = $this->select();

        $select->where('id = ?', $id)->where('deleted = ?',0);
        $row = $this->fetchRow($select);
        $editedanswer=false;
        if($row){

               return $editedanswer;
        }
        else{
                $editedanswer=true;
            return $editedanswer;
        }
    }

    /*******methode die de waarde in de deleted tabel op 1 zet
     ->wordt aangeroepen als er een answer wordt toegevoegd aan de questionbank dataset*******/
    public function updateAnswerQBDeleted($id)
    {

        $data = array(

            'deleted' => 1
        );
        $this->update($data,'id = ' .$id);


    }

    /*******methode die de waarde in de deleted tabel op  zet
    ->wordt aangeroepen als er een answer wordt verwijderd uit de questionbank datase*******/
    public function updateAnswerQBNotDeleted($id)
    {

        $data = array(

            'deleted' => 0
        );
        $this->update($data,'id = ' .$id);


    }


    /*******methode die alle answers met answer translation ophaald met een bepaalde language id*******/
    public function getAnswersFromLanguageQB($lid,$qid)
    {

        $a = new Application_Model_DbTable_Answertranslationqb();
        $select = $a->select()->from(array('a'=>'qbank_answer'),array('at.text'))->setIntegrityCheck(false)


           ->where('question_qb_id = ?' , $qid)
            ->join(array('at'=>'qbank_answer_translation'), 'a.id = at.answer_qb_id')
            ->join(array('q'=>'qbank_question', 'a'=>'answer'),'a.question_qb_id = q.id');

        $row = $a->fetchAll($select);



        return $row->toArray();

    }

    /*******methode die gebruikt wordt om data in de answer tabel van de questionbank dataset op te slaan*******/
    public function saveAnswerQB($qid,$qqbid)
    {
        $data = array(

            'question_id'=>$qid,
            'question_qb_id'=>$qqbid
        );
        $this->insert($data);
    }

    /*******methode die gebruikt wordt om een record uit de answers tabel van de questionbank dataset te verwijderen*******/
    public function deleteAnswerQB($id)
    {
        $this->delete('id =' . (int)$id);
    }


}

