<?php

class Application_Model_DbTable_Questionqb extends Zend_Db_Table_Abstract
{

    protected $_name = 'qbank_question';

    protected $_primary = 'id';


    protected $_schema = 'QuestionBankDB';


    protected $_dependentTables = array('Application_Model_DbTable_Questiontranslationqb',
        'Application_Model_DbTable_Answerqb');



    protected $_referenceMap = array(

        'QuestionType' => array(   'columns' => 'question_type_id',
            'refTableClass' => 'Application_Model_DbTable_Questiontype',
            'refColumns' => 'id'),

        'QuestionBlock' => array(  'columns' => 'question_block_id',
            'refTableClass' => 'Application_Model_DbTable_Questionblock',
            'refColumns' => 'id'),
    );


    /*******methode die gebruikt wordt om de laatst toegevoegde question op te vragen
     -> ter vervanging van de bestaande methode lastinsertid() in Zend Framwork*******/
    public function getMaxPK()
    {
        $max=$this->fetchRow($this->select()
            ->from($this, array('maxId'=>'max(id)')));
        return (int)$max['maxId'];
    }

    /*******methode die gebruikt wordt om te bepalen hoeveel questions er zijn in de qbank_question tabel
     ->dit is nodig om te bepalen hoeveel pagina's er moeten voorzien worden bij de paginatie*******/
    public function getNumRowsQB()
    {
        $select = $this->select()
            ->from('qbank_question', array('id' => 'COUNT(*)'));
        $result = $this->fetchRow($select);

        return (int) $result['id'];
    }

    /*******methode die gebruikt wordt om te controleren of er al dan niet questions zijn toegevoegd aan de questionbank dataset*******/
    public function editControlQuestionqb($id)
    {
        $select = $this->select();

        $select->where('id = ?', $id);
        $row = $this->fetchRow($select);
        $editedquestion=false;
        if($row){
           return $editedquestion;
        }
        else{
            $editedquestion=true;
            return $editedquestion;
        }
    }

    /*******methode die gebruikt word om een aantal questions met de question translation,
     * de daarbij gekoppelde answers met de answer translation op te halen volgens een bepaalde language_id*******/
    public function getQuestionsQB($aantal,$limit,$lid)
    {
        $qfl = $this->getQuestionsFromLanguageQB($aantal,$limit,$lid);

        foreach($qfl as $index=>$q) {
            $answer = new Application_Model_DbTable_Answerqb();
            $afl = $answer->getAnswersFromLanguageQB($lid, $q['question_qb_id']);

            $q['answers']=$afl;
            $qfl[$index] = $q;
        }
       //var_dump($qfl);

        return $qfl;

    }

    /*******methode om een aantal questions met de question translation op te halen volgens een bepaalde language id*******/
    public function getQuestionsFromLanguageQB($aantal,$limit,$lid)
    {
        $qt = new Application_Model_DbTable_Questiontranslationqb();
        $select = $qt->select();
        $select->where('language_id = ?', $lid);
        $select->limit($aantal,$limit);
        $row = $qt->fetchAll($select);
        return $row->toArray();
    }

    /*******methode om questions op te slaan in de questionbank dataset*******/
    public function saveQuestionsQB($questionblockqb,$questiontype)
    {
        $data = array(
            'question_block_qb_id'=>$questionblockqb,

            'question_type_id'=>$questiontype

        );

        $this->insert($data);
    }

    /*******methode om questions t deleten uit de questionbank dataset*******/
    public function deleteQuestionQB($id)
    {
        $this->delete('id =' . $id);
    }

}

