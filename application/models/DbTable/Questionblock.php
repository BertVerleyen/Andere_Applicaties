<?php

class Application_Model_DbTable_Questionblock extends Zend_Db_Table_Abstract
{

    protected $_name = 'question_block';
    protected $_primary = 'id';


    protected $_schema = 'QuestionBankDB';


    protected $_referenceMap = array(

        'quiz' => array('columns' => 'quiz_id',
                        'refTableClass' => 'Application_Model_DbTable_Quiz',
                        'refColumns' => 'id')
    );



    protected $_dependentTables = array('Application_Model_DbTable_Question');



    /*******methode die gebruikt wordt om question van een bepaalde questionblock op te vragen*******/
    public function getQuestionsfromblock($qblockid)
    {

        $select=$this->select()->setIntegrityCheck(false)->from(array('q'=>'question'))
                                 ->where('question_block_id=?',$qblockid)
                                ->join(array('qt'=>'question_translation', 'q'=>'question'), 'q.id = qt.question_id')
                                ->join(array('a'=>'answer', 'q'=>'question'),'q.id = a.question_id')
                                ->join(array('at'=>'answer_translation','a'=>'answer'),'a.id = at.answer_id');

        $res=$this->fetchAll($select);

        return $res->toArray();
    }

    /*******methode die gebruikt wordt om de questionblocks op te vragen a.d.h.v. een quiz_id die wordt meegegeven al parameter*******/
    public function getQuestionBlocks($quizid)
    {
        $resultset = $this->select()->from($this)
                          ->where('quiz_id=?',$quizid);

        $questionblocks = $this->fetchAll($resultset);


        return $questionblocks->toArray();
    }

    /*******methode die gebruikt wordt om question_blocks op te halen van een id van de question_block*******/
    public function getQuestionBlockById($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }

    /*******methode om questionblocks toe te voegen aan de questionbank dataset binnen de QuestionBankDB database*******/
    public function addQuestionBlock($id)
    {
        $data = array(
            'id'=>$id
        );
        $this->insert($data);
    }

    /*******methode die gebruikt wordt om questionblocks te kunnen updaten binnen de questionbank dataset*******/
    public function updateQuestionBlock($id, $questionblockid,$questiontypeid)
    {
        $data = array(
            'question_block_id' => $questionblockid,
            'question_type_id' => $questiontypeid,
        );
        $this->update($data, 'id = '. (int)$id);
    }

    /*******methode die gebruikt wordt om questionblocks uit de questionbank dataset te verwijderen*******/
    public function deleteQuestionBlock($id)
    {
        $this->delete('id =' . (int)$id);
    }

    /*******methode die gebruikt wordt om alle questionblocks op te halen*******/
    public function fetchAllQuestionBlocks()
    {
        $question = new QuestionQuery();
        $allQuestion = $question->find();
        return $allQuestion->toArray();

    }


}

