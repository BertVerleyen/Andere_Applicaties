<?php
/**
 * Created by PhpStorm.
 * User: survey2
 * Date: 5/6/14
 * Time: 1:26 PM
 */

class Application_Model_DbTable_Questionblockqb extends  Zend_Db_Table_Abstract{


    protected $_name = 'qbank_question_block';

    protected $_primary = 'id';


    protected $_schema = 'QuestionBankDB';


    protected $_dependentTables = array('Application_Model_DbTable_Questionqb');



    protected $_referenceMap = array(

        'qbank_Quiz' => array(   'columns' => 'question_block_id',
            'refTableClass' => 'Application_Model_DbTable_Quizqb',
            'refColumns' => 'id')


    );

    /*******methode die gebruikt wordt om de laatst toegevoegde questionblock te kunnen opvragen
    ->methode ter vervanging van de bestaande methode lastinsertid() in Zend Framework*******/
    public function getMaxPK()
    {
        $max=$this->fetchRow($this->select()
            ->from($this, array('maxId'=>'MAX(id)')));
        return (int)$max['maxId'];
    }

    /*******methode die gebruikt wordt om questionblocks op te slaan binnen de questionbankd dataset volgens een bepaalde quiz_qb_id*******/
    public function saveQuestionblockQB($quiz_qb_id)
    {

        $data=array('quiz_qb_id'=>$quiz_qb_id);

        $this->insert($data);
    }
} 