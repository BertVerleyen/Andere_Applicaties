<?php

class Application_Model_DbTable_Quizqb extends Zend_Db_Table_Abstract
{

    protected $_name = 'qbank_quiz';

    protected $_primary = 'id';


    protected $_schema = 'QuestionBankDB';

    protected $_dependentTables = array('Application_Model_DbTable_Questionblock',
        'Application_Model_DbTable_Quiztranslationqb',
        'Application_Model_DbTable_Userquizqb');

    protected $_referenceMap = array(

        //language_id aangepast naar default_language_id omdat dit zo ook in het EERD staat
        'Language' => array('columns' => 'default_language_id',
            'refTableClass' => 'Application_Model_DbTable_Language',
            'refColumns' => 'id'),

    );


    /*******methode om de laatst toegevoegde quiz op te vragen
     -> ter vervanging van de bestaande methode lastinsertid() in Zend Framework*******/
    public function getMaxPK()
    {
        $max=$this->fetchRow($this->select()
            ->from($this, array('maxId'=>'MAX(id)')));
        return (int)$max['maxId'];
    }

    /*******mehode voor shortlink op te halen-> UITBREIDING*******/
    public function getyourUrl()
    {



    }

    /*******methode om een gecreëerde quiz op te slaan met url en default_language*******/
    public function saveQuizQB($url,$defaultlanguage){

        $data=array('url'=>$url,
                    'default_language_id'=>$defaultlanguage);


        $this->insert($data);
    }

}



