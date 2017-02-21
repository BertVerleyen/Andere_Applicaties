<?php

class Application_Model_DbTable_Quiztranslationqb extends Zend_Db_Table_Abstract
{

    protected $_name = 'qbank_quiz_translation';

    protected $_primary = 'id';


    protected $_schema = 'QuestionBankDB';



   protected $_dependentTables = array('Application_Model_DbTable_Quizqb',);

    protected $_referenceMap = array(

            'Language' => array('columns' => 'language_id',
            'refTableClass' => 'Application_Model_DbTable_Language',
            'refColumns' => 'id'),

    );

    /*******methode om quizzes op te slaan volgens een bepaalde language id en zelf gekozen titel*******/
    public function saveQuiztranslationQB($quiz_qb_id,$title,$lid){
        $data=array('quiz_qb_id'=>$quiz_qb_id,

            'language_id'=>$lid,
            'title'=>$title
        );
        $this->insert($data);
    }


    /*******methode om een random quiz title te genereren indien en geen quiz gecreëerd geweest id*******/
    function generateRandomQuiztranslationqbtitle($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

}

