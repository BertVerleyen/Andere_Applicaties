<?php

class Application_Model_DbTable_Question extends Zend_Db_Table_Abstract
{

    protected $_name = 'question';

    protected $_primary = 'id';


    protected $_schema = 'QuestionBankDB';


    protected $_dependentTables = array('Application_Model_DbTable_QuestionTranslation',
        'Application_Model_DbTable_Answer');



    protected $_referenceMap = array(

        'QuestionType' => array(   'columns' => 'question_type_id',
            'refTableClass' => 'Application_Model_DbTable_QuestionType',
            'refColumns' => 'id'),

        'QuestionBlock' => array(  'columns' => 'question_block_id',
            'refTableClass' => 'Application_Model_DbTable_QuestionBlock',
            'refColumns' => 'id'),
    );



    /*******methode die de questions ophaalt die waarde 1 hebben binnen de deleted tabel*******/
    public function getDeleted()
    {
        $select = $this->select()->where('deleted = ?', 1);

        $row = $this->fetchAll($select);

        return $row->toArray();
    }


    /*************methode die de laatst toegevoegde primary key van question ophaalt
    -> ter vervanging van de methode lastinsertid() in Zend Framework*****************/
    public function getMaxPK()
    {
        $max=$this->fetchRow($this->select()
            ->from($this, array('maxId'=>'max(id)')));
        return (int)$max['maxId'];
    }


    /*******methode die de deleted tabel van question op 1 zet indien er een question wordt toegevoegd aan de questionbank dataset
    -> nodig ter controle of een question al dan niet is toegevoegd-> flags*******/
    public function updateQuestionDeleted($id)
    {
        $data = array(

            'deleted' => 1
        );
        $this->update($data,'id = ' .$id);
    }


    /*******methode die controleert of een question al dan niet is toegevoegd
     * ->flags worden teruggegeven indien een question reeds is toegevoegd*******/
    public function editControlQuestion($id)
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


    /*******methode die er voor zorgt dat de questions met de questiontranslations worden opgehaald bij een bepaalde question_block*******/
    public function getQuestionsWithTranslation($lid,$questionblock_id)
    {
        $select = $this->select()->from(array('q'=>'question'))->setIntegrityCheck(false)
            ->where('question_block_id=?',$questionblock_id)
            ->join(array('qt'=>'question_translation', 'q'=>'question'), 'q.id = qt.question_id')
            ->join(array('qbl'=>'question_block', 'q'=>'question'),'qbl.id = q.question_block_id');

        $row = $this->fetchAll($select);

        return $row->toArray();
    }

    /**************************************zend query om search keyword matched records eruit te filteren********************************************/
    public function getQuestionsSearch($aantal,$limit,$lid,$searchkeyword)
    {
        $qfl = $this->getQuestionsFromLanguageSearch($aantal,$limit,$lid,$searchkeyword);

        foreach($qfl as $index=>$q) {
            $answer = new Application_Model_DbTable_Answer();
            $afl = $answer->getAnswersFromLanguage($lid, $q['question_id']);


            $q['answers']=$afl;



            $qfl[$index] = $q;



        }

        return $qfl;
    }
    /**************************************************************************************/



    /*******methode die alle questions met hun questiontranslation en de daarbij gekoppelde answers met hun answer translation ophaalt*******/
    public function getQuestions($aantal,$limit,$lid)
    {
        $qfl = $this->getQuestionsFromLanguage($aantal,$limit,$lid);

        foreach($qfl as $index=>$q) {
            $answer = new Application_Model_DbTable_Answer();
            $afl = $answer->getAnswersFromLanguage($lid, $q['question_id']);


            $q['answers']=$afl;



            $qfl[$index] = $q;



        }

        return $qfl;
    }


    /*******methode die gebruikt wordt om het aantal rows te tellen
    -> nodig voor mee te geven als parameter bij de paginatie*******/
    public function getNumRows()
    {
        $select = $this->select()
            ->from('question', array('id' => 'COUNT(*)'));
        $result = $this->fetchRow($select);


        return (int) $result['id'];

    }

    public function getQuestionsFromLanguageSearch($aantal,$limit,$lid,$searchkeyword)
    {
        $qt = new Application_Model_DbTable_QuestionTranslation();
        $select = $qt->select();
        $select->where('language_id = ?', $lid)->where('text LIKE ?','%'.$searchkeyword.'%');
        $select->limit($aantal,$limit);
        $row = $qt->fetchAll($select);

        return $row->toArray();
    }





    /*******methode die gebruikt wordt om een aantal questions met hun question translation om te halen volgens een bepaalde language id
    ->aantal is nodig om questions weer te geven binnen de paginatie*******/
    public function getQuestionsFromLanguage($aantal,$limit,$lid)
    {
        $qt = new Application_Model_DbTable_QuestionTranslation();
        $select = $qt->select();
        $select->where('language_id = ?', $lid);
        $select->limit($aantal,$limit);
        $row = $qt->fetchAll($select);

        return $row->toArray();
    }


    /*******methode die gebruikt wordt om questions op te halen volgens een bepaalde id van question*******/
    public function getQuestionById($id)
    {
        $id = (int)$id;
        $row = $this->fetchRow('id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }


    /*******methode die gebruikt wordt om questions op te slaan binnen de questionbank dataset in de QuestionBankDB database*******/
    public function addQuestion($id)
    {
        $data = array(
            'id'=>$id
        );
        $this->insert($data);
    }


    /*******methode die gebruikt wordt om questions te updaten binnen de questionbank dataset
    ->originele data van de surveyanyplace dataset wordt niet gewijzigd*******/
    public function updateQuestion($id, $questionblockid,$questiontypeid)
    {
        $data = array(
            'question_block_id' => $questionblockid,
            'question_type_id' => $questiontypeid,
        );
        $this->update($data, 'id = '. (int)$id);
    }


    /*******methode om de waarde van de deleted tabel op 0 te zetten indien er een vraag wordt verwijderd
    ->nodig om te kunnen controleren of de question al dan niet opnieuw mag worden toegevoegd*******/
    public function setQuestionNotDeleted($id)
    {
        $data = array(

            'deleted' => 0
        );
        $this->update($data,'id = ' .$id);
    }

}

