<?php

class Application_Model_DbTable_Quiz extends Zend_Db_Table_Abstract
{

    protected $_name = 'quiz';

    protected $_primary = 'id';


    protected $_schema = 'QuestionBankDB';



    protected $_dependentTables = array('Application_Model_DbTable_QuestionBlock',
        'Application_Model_DbTable_QuizTranslation',
        'Application_Model_DbTable_UserQuiz');

    protected $_referenceMap = array(

        'Language' => array('columns' => 'language_id',
            'refTableClass' => 'Application_Model_DbTable_Language',
            'refColumns' => 'id'),

    );


    /*******methode die gebruikt wordt om een aantal quizzes met quiz, question, question_translation,
     * answer en answer translation op te halen volgens een bepaalde language id*******/
    public function getQuizzes($aantal,$limit,$lid)
    {
        $quizfl = $this->getQuizzesFromLanguage($aantal,$limit,$lid);

        foreach($quizfl as $index=>$quiz) {

            $questions = new Application_Model_DbTable_Question();
            $questionsfromblock = $questions->getQuestionsWithTranslation($lid,$quiz['questionblockid']);

            $quiz['questionsfromquiz'] = $questionsfromblock;

            $quizfl[$index] = $quiz;

            $answers = new Application_Model_DbTable_Answer();

            foreach($quiz['questionsfromquiz'] as $questionsfromquizid=>$questionsfromquizvalue)
            {

                $answersfromquestions = $answers->getAnswersFromQuestion($questionsfromquizvalue['question_id'],$lid);

                $quizfl[$index]['questionsfromquiz'][$questionsfromquizid]['answersfromquestion'] = $answersfromquestions;
            }

            $questionsfromquizvalue['answersfromquestion'] = $answersfromquestions;
        }

        return $quizfl;
    }

    /*******methode die gebruikt wordt om een antal quizzes op te halen volgens een bepaalde language id*******/
    public function getQuizzesFromLanguage($aantal,$limit,$lid)
    {

        $select = $this->select()->from(array('qui'=>'quiz'),array('qbl.id as questionblockid','quit.title as quiztitle'))->setIntegrityCheck(false)
            ->where('language_id=?',$lid)
            ->join(array('quit'=>'quiz_translation', 'qui'=>'quiz'), 'qui.id = quit.quiz_id')
            ->join(array('qbl'=>'question_block', 'qui'=>'quiz'),'qui.id = qbl.quiz_id');

        $row = $this->fetchAll($select);

        return $row->toArray();
    }


    /***********************MYSQL SEARCH on specific QUIZ*************************************************************/
    public function getQuizzesSearch($aantal,$limit,$lid,$searchquiz)
    {
//aantalquizzes= 10
        $quizfl = $this->getQuizzesFromLanguageSearch($aantal,$limit,$lid,$searchquiz);


        foreach($quizfl as $index=>$quiz) {


            $questions = new Application_Model_DbTable_Question();
            $questionsfromblock = $questions->getQuestionsWithTranslation($lid,$quiz['questionblockid']);




            $quiz['questionsfromquiz'] = $questionsfromblock;

            $quizfl[$index] = $quiz;

            $answers = new Application_Model_DbTable_Answer();


            foreach($quiz['questionsfromquiz'] as $questionsfromquizid=>$questionsfromquizvalue)
            {

//                echo'<pre>';var_dump($questionsfromquizid);echo'</pre>';

                $answersfromquestions = $answers->getAnswersFromQuestion($questionsfromquizvalue['question_id'],$lid);

                $quizfl[$index]['questionsfromquiz'][$questionsfromquizid]['answersfromquestion'] = $answersfromquestions;
            }




            $questionsfromquizvalue['answersfromquestion'] = $answersfromquestions;





            //echo'<pre>';var_dump($questionsfromquizvalue);echo'</pre>';







            // echo'<pre>';var_dump($quiz);echo'</pre>';



        }
        //echo'<pre>';var_dump($quizfl);echo'</pre>';

        return $quizfl;


    }

    public function getQuizzesFromLanguageSearch($aantal,$limit,$lid,$searchquiz)
    {
//        $qt = new Application_Model_DbTable_QuizTranslation();
//        $select = $qt->select();
//        $select->where('language_id = ?', $lid);
//        $select->limit($aantal,$limit);
//        $row = $qt->fetchAll($select);


        $select = $this->select()->from(array('qui'=>'quiz'),array('qbl.id as questionblockid','quit.title as quiztitle'))->setIntegrityCheck(false)
            ->where('language_id=?',$lid)->where('quit.title LIKE ?','%'.$searchquiz.'%')
            ->join(array('quit'=>'quiz_translation', 'qui'=>'quiz'), 'qui.id = quit.quiz_id')
            ->join(array('qbl'=>'question_block', 'qui'=>'quiz'),'qui.id = qbl.quiz_id');

        $row = $this->fetchAll($select);

        return $row->toArray();






    }
    
    
    
    

    /*******methode die gebruikt wordt om question blocks op te halen volgens een quizid*******/
    public function getQuestions_blocks($quizid)
    {
        $resultset = $this->select()->from('question_block')->where('quiz_id = ' . $quizid);
        $questions = $this->fetchAll($resultset);

        return $questions;
    }

    /*******methode om questionblocks op te halen volgens een question_block_id*******/
    public function getQuestionBlock($questionblockid)
    {
        $id = (int)$questionblockid;
        $row = $this->fetchRow('question_block_id = ' . $questionblockid);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }

    /*******methode om question blocks toe te voegen aan de questionbank dataset*******/
    public function addQuestionBlock($questionblockid)
    {
        $data = array(
            'question_block_id' =>$questionblockid
        );
        $this->insert($data);
    }

    /*******methode om question blocks te updaten volgens id en questionblockid binnen de questionbank dataset*******/
    public function updateQuestionBlock($id,$questionblockid)
    {
        $data = array(
            'question_block_id' =>$questionblockid
        );
        $this->update($data, 'id = '. (int)$id);
    }

    /*******methode om questionblocks te verwijderen volgens een bepaalde id binnen de questionbank dataset*******/
    public function deleteQuestionBlock($id)
    {
        $this->delete('id =' . (int)$id);
    }

    /*******methode om alle questionblocks op te halen volgens questions*******/
    public function fetchAllQuestionBlock()
    {
        $questionBlock = QuestionBlockQuery::create()
            ->join('question_block.Question')
            ->useQuery('question')
            //->getSelect()
            ->endUse()
            ->find();
        return $questionBlock->toArray();
    }


}

