<?php

class IndexController extends Zend_Controller_Action
{

    protected $questions = null;

    protected $qu = null;

    protected $q = null;

    protected $au = null;

    protected $a = null;

    protected $at = null;

    protected $qt = null;

    protected $questionsQB = null;

    const aantalrecordsperpage= 10;

    public function _construct()
    {
        $this->questions = new Application_Model_DbTable_Question();
        $this->qu=new Application_Model_DbTable_Question();
        $this->q = new Application_Model_DbTable_Questionqb();
        $this->au=new Application_Model_DbTable_Answer();

        $this->a = new Application_Model_DbTable_Answerqb();
        $this->at = new Application_Model_DbTable_Answertranslationqb();
        $this->qt = new Application_Model_DbTable_Questiontranslationqb();

        $this->questionsQB = new Application_Model_DbTable_Questionqb();

        // $GLOBALS[''];
        //Zend_Registry::set('index', $value);
    }




    /*************************UITBREIDINGEN*****************************************************************/
    public function getData($url)
    {
        include('simple_html_dom (2).php');

        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: www.google.be'));
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);

//var_dump($data);
        curl_close($ch);


        $html= str_get_html($url);
        //print_r($html);



        $keywords = array();
        $domain = array($url);
        $doc = new DOMDocument;
        $doc->preserveWhiteSpace = FALSE;

        foreach ($domain as $key => $value) {



            @$doc->loadHTMLFile($value);

            $anchor_tags = $doc->getElementsByTagName('a');

            // var_dump($anchor_tags);
            foreach ($anchor_tags as $tag) {
                // var_dump($tag);
                $keywords[] = strtolower($tag->nodeValue);
            }
        }

        //var_dump($keywords);







        $i = 0;


        // var_dump($html->find('li[class=g]'));

        foreach($html->find('li[class=g]') as $element) {

            foreach($element->find('h3') as $item)
            {

                $title[$i] = ''.$item->plaintext.'' ;
                //var_dump($title[$i]);
            }
            $i++;

        }



        return $data;
    }

    public function scrape($postsearch)
    {
//        try {
//            $dom = new Zend_Dom_Query($this->_getXhtml());
//            $httpclient=new Zend_Http_Client();
//        } catch (Exception $e) {
//            throw $e;
//        }
//
//        $html = file_get_html('http://www.microsoft.com/');
//
//// Extract links
//        foreach($html->find('a') as $element)
//            echo $element->href . '<br>';
//
//// Extract images
//        foreach($html->find('img') as $element)
//            echo $element->src . '<br>';
//
//
//        $html = str_get_html('<div id="simple">Simple</div><div id="parser">Parser</div>');
////
//        $html->find('div', 1)->class = 'bar';
////
//        $html->find('div[id=simple]', 0)->innertext = 'Foo';
//
//// Output: <div id="simple">Foo</div><div id="parser" class="bar">Parser</div>
//        echo $html;






        /*****************UITBREIDINGEN****************/
        try{
            $opts = array(
                'http'=>array(
                    'method'=>"GET",
                    'header'=>"Accept-language: en\r\n" .
                    "Cookie: foo=bar\r\n"
                )
            );
            $context = stream_context_create($opts);
            $file_string = file_get_contents('https://www.google.be/search?q='.$postsearch);//,false,$context);
            //preg_match('/<em>'.$postsearch.'<\/em>/i', $file_string, $title);

            // $parsedstringurl= parse_url('https://www.google.be/search?q='.$postsearch, PHP_URL_QUERY);
            // parse_str($parsedstringurl,$string);
            // preg_match('/\[([^\]]+)\]\[(https?:[^\]"]+)\]/i'.[$postsearch].'" \/> /i',$file_string,$url);
            preg_match('/<\s*a[^>]href="(.*?)"\s?(.*?)>/i',$file_string,$url);
            //preg_match( '/Page 1 of (.+?) results/',$file_string,$url);



            //var_dump($file_string);
            // $title_out = $title[1];
            // var_dump($string);
            // var_dump($url);
            // echo $url[0];
            //preg_match('/<data href="(.*)" \/> /i', $file_string, $keywords);

            //var_dump($keywords);
            return $file_string;  //$keywords_out = $keywords[0];
        }catch(Exception $e)
        {
            echo $e;
        }



        /***************************************************************************************************************/

    }

    public function init()
    {
        // $ajaxrequest=new Zend_Controller_Action_Helper_AjaxContext();


        $contextSwitch = $this->_helper->getHelper('AjaxContext');
        $contextSwitch->addActionContext('switch', array('json'))
            ->initContext();
    }

    public function indexAction()
    {

        $users = new Application_Model_DbTable_User();

        $form = new Application_Form_AdminLogin();

        $this->view->form = $form;

        if($this->getRequest()->isPost()){


            if($form->isValid($_POST) && $users->isAdmin($form->getValue('username'))){

                $data = $form->getValues();

                $auth = Zend_Auth::getInstance();




                $authAdapter = new Zend_Auth_Adapter_DbTable($users->getAdapter(),"user");



                $authAdapter->setIdentityColumn("username")->setCredentialColumn("password");

                $authAdapter->setIdentity($data['username'])->setCredential($data['password']);

                $result = $auth->authenticate($authAdapter);


                $_SESSION['username'] = $authAdapter->getResultRowObject();
                $_SESSION['password'] = $authAdapter->getResultRowObject();


                if($result->isValid() ){

                    $storage = new Zend_Auth_Storage_Session();

                    $storage->write($authAdapter->getResultRowObject());
                    //$this->_redirector->setUseAbsoluteUri(true);
                    // $this->_helper->redirector("http://$_SERVER[HTTP_HOST]/Index/switch");
                    // $this->_helper->redirector('admintest');
                    $this->redirect('/Index/home',array('username'=>$_POST['username']));
                    // var_dump($this->getServerUrl());

                } else {

                    $this->view->errorMessage = "Invalid username or password. Please try again.";

                }

            }else
            {
                $this->view->errorMessage2="sorry you ain't an admin";

            }






        }
    }



    public function signoutAction()
    {
        $storage = new Zend_Auth_Storage_Session();

        $storage->clear();

        $this->redirect("Index/index");
    }

/********************************************************************************************************************************/
    /***************************HOME action**********************************************************************************/


    public function homeAction()
    {

        $storage = new Zend_Auth_Storage_Session();

        $data = $storage->read();



        if($data){


            $this->view->username = $data->username;
        }

        //global $questions;
        $questions = new Application_Model_DbTable_Question();

        $this->view->numRows = $questions->getNumRows();






        $_GET['page'] = (isset($_GET['page']) ? $_GET['page'] :'geen pageid:undefined,hij neemt 0');

        $pageid = $_GET['page'];





        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


        $limiet=($pageid*self::aantalrecordsperpage)-self::aantalrecordsperpage;


        if( $limiet == -10)
        {
            $this->view->questions = $questions->getQuestions(self::aantalrecordsperpage,$limiet+10,1);
        }
        else
        {
            $this->view->questions=$questions->getQuestions(self::aantalrecordsperpage,$limiet,1);
        }





//elasticsearch WERKT!!!
//met index_elastic.phtml als gewoon index.phtml
//fuzziness wordt gebruikt om te zoeken op waarden die ongeveer overeenkomen met de zoekopdracht
//        $client = new Elasticsearch\Client();
//        if(isset($_POST['checkbox'])){
//
//            foreach($_POST['checkbox'] as $value)
//            {
//                $number = count($_POST['checkbox']);
//                //if(isset($_POST['checkbox']))// == 2)
//                if($value == 1)
//                {
//                    //print_r($_POST);
//                    //$client = new Elasticsearch\Client();
//
//                    $params['index'] = 'questionbankdb';
//                    $params['type']  = 'quiz';
//                    $params['body']['query']['match']['quiztr_title'] = array(
//                        'query' => $_POST['search'],
//                        //'fuzziness' => 0.5,
//                    );
//                    $results = $client->search($params);
//
//                    $this->view->quizresults = $results;
//
//                    $questparams['index'] = 'questionbankdb';
//                    $questparams['type']  = 'quiz';
//                    $questparams['body']['query']['match']['qt_text'] = array(
//                        'query' => '',
//                        //'fuzziness' => 0.5,
//                    );
//                    $questresults = $client->search($questparams);
//
//                    $this->view->questionresults = $questresults;
//
//
//                    $answerparams['index'] = 'questionbankdb';
//                    $answerparams['type']  = 'quiz';
//                    $answerparams['body']['query']['match']['at_text'] = array(
//                        'query' => '',
//                        //'fuzziness' => 0.5,
//                    );
//
//                    $answerresults = $client->search($answerparams);
//
//                    $this->view->answerresults = $answerresults;
//
//                }
//
//
//                if($value == 2){
//
//                    $quizparams['index'] = 'questionbankdb';
//                    $quizparams['type']  = 'quiz';
//                    $quizparams['body']['query']['match']['quiztr_title'] = array(
//                        'query' => '',
//                        //'fuzziness' => 0.5,
//                    );
//                    $quizresults = $client->search($quizparams);
//
//                    $this->view->quizresults = $quizresults;
//
//
//
//                    $params['index'] = 'questionbankdb';
//                    $params['type']  = 'question';
//                    $params['body']['query']['match']['qt_text'] = array(
//                        'query' => $_POST['search'],
//                        //'fuzziness' => 0.5,
//                        //'boost' => 0
//                    );
//
//
//                    $results = $client->search($params);
//
//                    $this->view->questionresults = $results;
////
//
//                    $params2['index'] = 'questionbankdb';
//                    $params2['type']  = 'question';
//                    $params2['body']['query']['match']['at_text'] = array(
//                        'query' => '',
//                        //'fuzziness' => 0.5,
//                    );
//
//
//                    $results2 = $client->search($params2);
//
//                    $this->view->answerresults = $results2;
//                }
//
//
//                if($value == 3){
//                    //print_r($_POST);
//                    //$client = new Elasticsearch\Client();
//                    $quizparams['index'] = 'questionbankdb';
//                    $quizparams['type']  = 'quiz';
//                    $quizparams['body']['query']['match']['quiztr_title'] = array(
//                        'query' => '',
//                        //'fuzziness' => 0.5,
//                    );
//                    $quizresults = $client->search($quizparams);
//
//                    $this->view->quizresults = $quizresults;
//
//
//                    $params['index'] = 'questionbankdb';
//                    $params['type']  = 'question';
//                    $params['body']['query']['match']['qt_text'] = array(
//                        'query' => '',
//                        //'fuzziness' => 0.5,
//                        //'boost' => 0
//                    );
//
//                    $results = $client->search($params);
//
//                    $this->view->questionresults = $results;
//
//
//                    $params2['index'] = 'questionbankdb';
//                    $params2['type']  = 'question';
//                    $params2['body']['query']['match']['at_text'] = array(
//                        'query' => $_POST['search'],
//                        //'fuzziness' => 0.5,
//                    );
//
//                    $results2 = $client->search($params2);
//
//                    $this->view->answerresults = $results2;
//
//                }
//
//
//
//                if($number > 2){
//                    //print_r($_POST);
//                    //$client = new Elasticsearch\Client();
//                    //return "Please select other checkboxes";
//                    $quizparams['index'] = 'questionbankdb';
//                    $quizparams['type']  = 'quiz';
//                    $quizparams['body']['query']['match']['quiztr_title'] = array(
//                        'query' => '',
//                        //'fuzziness' => 0.5,
//                    );
//                    $quizresults = $client->search($quizparams);
//
//                    $this->view->quizresults = $quizresults;
//
//                    $params['index'] = 'questionbankdb';
//                    $params['type']  = 'question';
//                    $params['body']['query']['match']['qt_text'] = array(
//                        'query' => '',
//                        //'fuzziness' => 0.5,
//                        //'boost' => 0
//                    );
//
//                    $results = $client->search($params);
//
//                    $this->view->questionresults = $results;
//
//                    $params2['index'] = 'questionbankdb';
//                    $params2['type']  = 'question';
//                    $params2['body']['query']['match']['at_text'] = array(
//                        'query' => '',
//                        //'fuzziness' => 0.5,
//                    );
//
//                    $results2 = $client->search($params2);
//
//                    $this->view->answerresults = $results2;
//
//                }
//
//                //moet nog verder gedebugd worden, want als quiz aangevinkt is mag er niets verschijnen
//                if($number == 2){
//                    //print_r($_POST);
//                    //$client = new Elasticsearch\Client();
//                    //return "Please select other checkboxes";
//                    $params['index'] = 'questionbankdb';
//                    $params['type']  = 'question';
//                    $params['body']['query']['match']['qt_text'] = array(
//                        'query' => $_POST['search'],
//                        //'fuzziness' => 0.5,
//                        //'boost' => 0
//                    );
//
//                    $results = $client->search($params);
//
//                    $this->view->questionresults = $results;
//
//                    $params2['index'] = 'questionbankdb';
//                    $params2['type']  = 'question';
//                    $params2['body']['query']['match']['at_text'] = array(
//                        'query' => $_POST['search'],
//                        //'fuzziness' => 0.5,
//                    );
//
//                    $results2 = $client->search($params2);
//
//                    $this->view->answerresults = $results2;
//
//                }
//
//
//            }
//
//        }
//
//        else
//        {
//            //print_r($_POST);
//            $client = new Elasticsearch\Client();
//            $quizparams['index'] = 'questionbankdb';
//            $quizparams['type']  = 'quiz';
//            $quizparams['body']['query']['match']['quiztr_title'] = array(
//                'query' => '',
//                //'fuzziness' => 0.5,
//            );
//            $quizresults = $client->search($quizparams);
//
//            $this->view->quizresults = $quizresults;
//
//            $params['index'] = 'questionbankdb';
//            $params['type']  = 'question';
//            $params['body']['query']['match']['qt_text'] = array(
//                'query' => '',
//                //'fuzziness' => 0.5,
//            );
//            try{
//                $results = $client->search($params);
//            }catch(Exception $e)
//            {
//                $results = null;
//            }
//            $this->view->questionresults = $results;
//
//            $params2['index'] = 'questionbankdb';
//            $params2['type']  = 'question';
//            $params2['body']['query']['match']['at_text'] = array(
//                'query' => '',
//                //'fuzziness' => 0.5,
//            );
//
//            $results2 = $client->search($params2);
//
//            $this->view->answerresults = $results2;
//        }


        $qu=new Application_Model_DbTable_Question();
        $q = new Application_Model_DbTable_Questionqb();
        $au=new Application_Model_DbTable_Answer();

        $a = new Application_Model_DbTable_Answerqb();
        $at = new Application_Model_DbTable_Answertranslationqb();
        $qt = new Application_Model_DbTable_Questiontranslationqb();
        $quizqb = new Application_Model_DbTable_Quizqb();
        $quizqbtranslation = new Application_Model_DbTable_Quiztranslationqb();
        $questblock= new Application_Model_DbTable_Questionblockqb();


        $quizzes = new Application_Model_DbTable_Quiz();
        $database_quizzes = $quizzes->getQuizzes(10,0,1);

//        echo '<pre>';


//        if($actual_link == "http://local.stage/".$_SERVER['REQUEST_URI'] || $actual_link == "http://local.stage/".$_SERVER['REQUEST_URI']."/index.php?page=1&ipp=10")
        if($actual_link == "http://local.stage/Index/home" || $actual_link == "http://local.stage/Index/home?page=1&ipp=10")
        {
             //print_r($actual_link);
            echo '<br/>';
           // print_R( $_SERVER);
        }
        else
        {
           // print_r($actual_link);

            echo '<br/>';
         // print_R( $_SERVER);
        }
        $totalq = $qu->getMaxPK();
        $totala = $au->getMaxPK();

        //werkt voor http://local.stage/ niet voor page 1
//        if($actual_link == "http://local.stage/Index/home" || $actual_link == "http://local.stage/Index/home/index.php?page=1&ipp=10")
        if($actual_link == "http://local.stage/Index/home" || $actual_link == "http://local.stage/Index/home/?page=1&ipp=10")
        {
            $limiet=0;

            $database_questions = $questions->getQuestions($totalq,$limiet,1);

            //Opnieuw size gebruikt om de fouten van dbcounter die >415 op te vangen
            //Size gaat tot 415, totalq is hier niet nodig omdat de eerste waarde gewoon geïncrementeerd wordt om de array te doorlopen
            $size = sizeof($database_questions);

            array_unshift($database_questions,array('answers'));
            unset($database_questions[0]);


            //SEARCH   /***********URL scraping**************/
            // print_r($_POST);
            if(isset($_POST['image_x']))
            {
                $this->view->urlgenerated =  $this->getData('https://www.google.be/search?q='.$_POST["search"]);
                //$this->scrape($_POST['search']);
                //
            }


            //SAVE van search-----------------------------------------------------------

            if(isset($_POST['Savesearch'])) {

                if(isset($_POST['checkboxquestionsearch'])){

                    foreach($_POST['checkboxquestionsearch'] as $key => $value){

                        if($value == $_POST['questionqb'][$value]['id']){

                            for($dbcounter=1;$dbcounter<=$size;$dbcounter++){
                                if($dbcounter<=$totalq && $value==$database_questions[$dbcounter]['id']){

                                    $controlquestion= $qu->editControlQuestion($database_questions[$dbcounter]['id']);


                                    if($value<=$totalq){
                                        if(!$controlquestion)
                                        {




                                            $q->saveQuestionsQB(null,2);
                                            $lastinsertedid= $q->getAdapter()->lastInsertId();

                                            $qt->saveQuestionTranslationQB($_POST['questionqb'][$value]['qt_text'],$_POST['questionqb'][$value]['id'],$lastinsertedid,1);

                                            $qu->updateQuestionDeleted($database_questions[$dbcounter]['id']);


                                            $i=0;
                                            //print_r( $_POST['questionqb'][$value]);

                                            foreach($_POST['questionqb'][$value]['at_text'] as $qqbkey => $qqbvalue)
                                            {
                                                if($i<=$totala){
                                                    //$controlanswer = $au->editControlAnswer($database_questions[$value]['answers'][$i]['answer_id']);

                                                    $a->saveAnswerQB($database_questions[$dbcounter]['id'],$lastinsertedid);
                                                    $lastinsertedid2= $a->getAdapter()->lastInsertId();

                                                    $at->saveAnswerTranslationQB($qqbvalue,$_POST['questionqb'][$value]['a_id'][$i],$lastinsertedid2,1);

                                                    $au->updateAnswerDeleted($database_questions[$dbcounter]['answers'][$i]['answer_id']);

                                                }
                                                $i++;
                                            }
                                        }
                                        else
                                        {
                                            $flagsq=$this->_getParam('checkboxquestionsearch');

                                            foreach($flagsq as $flagqtextkey2=>$flagqtextvalue)
                                            {
                                                echo '<br/>';


                                                if($flagqtextvalue == $_POST['questionqb'][$flagqtextvalue]['id']){
                                                    // print_r($flagqtextkey2);


                                                    $narray[$flagqtextvalue] = "question "."$flagqtextvalue"." already edited";
//                                                    print_r($narray);

                                                    echo 'Unable to edit question '.$flagqtextvalue . ', ' .$narray[$flagqtextvalue] . '.';
                                                    $this->view->flagquestion=$narray;

                                                }
                                                else
                                                {
                                                    echo 'je mag vraag '.$flagqtextvalue." editen ";
                                                    echo '-------------------------------------------';
                                                }

                                            }

                                        }
                                    }

                                    /**FLAGS voor de SEarch***/
                                    else
                                    {

                                        $flagsq=$this->_getParam('checkboxquestionsearch');

                                        foreach($flagsq as $flagqtextkey2=>$flagqtextvalue)
                                        {
                                            echo '<br/>';


                                            if($flagqtextvalue == $_POST['questionqb'][$flagqtextvalue]['id']){
                                                // print_r($flagqtextkey2);


                                                $narray[$flagqtextvalue] = "question "."$flagqtextvalue"." already edited";
//                                                    print_r($narray);

                                                echo 'Unable to edit question '.$flagqtextvalue . ', ' .$narray[$flagqtextvalue] . '.';
                                                $this->view->flagquestion=$narray;

                                            }
                                            else
                                            {
                                                echo 'je mag vraag '.$flagqtextvalue." editen ";
                                                echo '-------------------------------------------';
                                            }

                                        }
                                    }
                                }

                            }
                        }
                    }
                }

            }



//END SAVE van search-------------------------------------------------------



//SAVE van data uit database------------------------------------------------

            if(isset($_POST['Save'])) {
                if(isset($_POST['checkboxquestion'])){

                    foreach($_POST['checkboxquestion'] as $key => $value){

                        if($value == $_POST['question'][$value]['id'])
                        {

                            $controlquestion= $qu->editControlQuestion($database_questions[$value]['id']);

                            if($value==$database_questions[$value]['id'])
                            {
                                if($value<=$size){

                                    if(!$controlquestion)
                                    {

                                        $q->saveQuestionsQB(null,2);
                                        $lastinsertedid= $q->getAdapter()->lastInsertId();

                                        $qt->saveQuestionTranslationQB($_POST['question'][$value]['text'],$_POST['question'][$value]['id'],$lastinsertedid,1);

                                        $qu->updateQuestionDeleted($database_questions[$value]['id']);



                                        if(!empty($_POST['question'][$value]['answers']))
                                        {
                                            $i = 0;
                                            foreach($_POST['question'][$value]['answers'] as $answer_postid => $answer_postdata)
                                            {

                                                if($i<=sizeof($database_questions[$value]['answers']))
                                                {

                                                    $controlanswer = $au->editControlAnswer($database_questions[$value]['answers'][$i]['answer_id']);

                                                    if(!$controlanswer)
                                                    {

                                                        $a->saveAnswerQB($database_questions[$value]['id'],$lastinsertedid);
                                                        $lastinsertedid2= $a->getAdapter()->lastInsertId();

                                                        $at->saveAnswerTranslationQB($answer_postdata['text'],$answer_postid,$lastinsertedid2,1);


                                                        $au->updateAnswerDeleted($database_questions[$value]['answers'][$i]['answer_id']);

                                                    }
                                                }
                                                $i++;
                                            }

                                        }



                                    }
                                    else
                                    {
                                        $flagsq=$this->_getParam('checkboxquestion');

                                        foreach($flagsq as $flagqtextkey2=>$flagqtextvalue)
                                        {
                                            echo '<br/>';


                                            if($flagqtextvalue == $_POST['question'][$flagqtextvalue]['id']){
                                                // print_r($flagqtextkey2);


                                                $narray[$flagqtextvalue] = "question "."$flagqtextvalue"." already edited";
//                                                    print_r($narray);

                                                echo 'Unable to edit question '.$flagqtextvalue . ', ' .$narray[$flagqtextvalue] . '.';
                                                $this->view->flagquestion=$narray;

                                            }
                                            else
                                            {
                                                echo 'je mag vraag '.$flagqtextvalue." editen ";
                                                echo '-------------------------------------------';
                                            }

                                        }
                                    }
                                }
                            }


                        }
                    }
                }

            }

        }

        else
        {


            $limiet = 0;
            $database_questions = $questions->getQuestions($totalq,$limiet,1);

            $sizeqb = sizeof($database_questions);

            //$total = sizeof($database_questions)+5;
            array_unshift($database_questions,array('answers'/*=>array()*/));
            unset($database_questions[0]);

//SEARCH SAVE

            if(isset($_POST['Savesearch'])) {

                if(isset($_POST['checkboxquestionsearch'])){

                    foreach($_POST['checkboxquestionsearch'] as $key => $value){

                        if($value == $_POST['questionqb'][$value]['id']){

                            for($dbcounter=1;$dbcounter<=$sizeqb;$dbcounter++){
                                if($dbcounter<=$totalq && $value==$database_questions[$dbcounter]['id']){

                                    $controlquestion= $qu->editControlQuestion($database_questions[$dbcounter]['id']);
//                                    print_r($database_questions[$dbcounter]);

                                    if($value<=$totalq){
                                        if(!$controlquestion)
                                        {
                                            $q->saveQuestionsQB(null,2);
                                            $lastinsertedid= $q->getAdapter()->lastInsertId();

                                            $qt->saveQuestionTranslationQB($_POST['questionqb'][$value]['qt_text'],$_POST['questionqb'][$value]['id'],$lastinsertedid,1);

                                            $qu->updateQuestionDeleted($database_questions[$dbcounter]['id']);


                                            $i=0;
                                            //print_r( $_POST['questionqb'][$value]);

                                            if(!empty($_POST['questionqb'][$value]['at_text']))
                                            {
                                                foreach($_POST['questionqb'][$value]['at_text'] as $qqbkey => $qqbvalue)
                                                {
                                                    if($i<=$totala){
                                                        //$controlanswer = $au->editControlAnswer($database_questions[$value]['answers'][$i]['answer_id']);

                                                        $a->saveAnswerQB($database_questions[$dbcounter]['id'],$lastinsertedid);
                                                        $lastinsertedid2= $a->getAdapter()->lastInsertId();

                                                        $at->saveAnswerTranslationQB($qqbvalue,$_POST['questionqb'][$value]['a_id'][$i],$lastinsertedid2,1);

                                                        $au->updateAnswerDeleted($database_questions[$dbcounter]['answers'][$i]['answer_id']);

                                                    }
                                                    $i++;
                                                }
                                            }
                                        }
                                        else
                                        {
                                            //echo "Question " . $_POST['questionqb'][$value]['id'] . " with text " . $_POST['questionqb'][$value]['qt_text'] . " is already added.";

                                            $flagsq=$this->_getParam('checkboxquestionsearch');

                                            foreach($flagsq as $flagqtextkey2=>$flagqtextvalue)
                                            {
                                                echo '<br/>';


                                                if($flagqtextvalue == $_POST['questionqb'][$flagqtextvalue]['id']){
                                                    // print_r($flagqtextkey2);


                                                    $narray[$flagqtextvalue] = "question "."$flagqtextvalue"." already edited";
//                                                    print_r($narray);

                                                    echo 'Unable to edit question '.$flagqtextvalue . ', ' .$narray[$flagqtextvalue] . '.';
                                                    $this->view->flagquestion=$narray;

                                                }
                                                else
                                                {
                                                    echo 'je mag vraag '.$flagqtextvalue." editen ";
                                                    echo '-------------------------------------------';
                                                }

                                            }
                                        }
                                    }
                                    /**FLAGS voor de Search, zichtbaar in database list***/
                                    else
                                    {

                                        $flagsq=$this->_getParam('checkboxquestionsearch');

                                        foreach($flagsq as $flagqtextkey2=>$flagqtextvalue)
                                        {
                                            echo '<br/>';


                                            if($flagqtextvalue == $_POST['questionqb'][$flagqtextvalue]['id']){
                                                // print_r($flagqtextkey2);


                                                $narray[$flagqtextvalue] = "question "."$flagqtextvalue"." already edited";
//                                                    print_r($narray);

                                                echo 'Unable to edit question '.$flagqtextvalue . ', ' .$narray[$flagqtextvalue] . '.';
                                                $this->view->flagquestion=$narray;

                                            }
                                            else
                                            {
                                                echo 'je mag vraag '.$flagqtextvalue." editen ";
                                                echo '-------------------------------------------';
                                            }

                                        }
                                    }
                                }
                            }
                        }
                    }
                }

            }




//DATABASE SAVE
            if(isset($_POST['Save'])) {
                if(isset($_POST['checkboxquestion']))
                {

                    foreach($_POST['checkboxquestion'] as $key => $value){

                        if($value == $_POST['question'][$value]['id'])
                        {
                            for($d=1;$d<=$sizeqb;$d++)
                            {

                                if($d <= $sizeqb && $value == $database_questions[$d]['id'])
                                {

                                    $controlquestion= $qu->editControlQuestion($value);

                                    if($value<=$totalq)
                                    {

                                        if(!$controlquestion)
                                        {
                                            $q->saveQuestionsQB(null,2);
                                            $lastinsertedid= $q->getAdapter()->lastInsertId();

                                            $qt->saveQuestionTranslationQB($_POST['question'][$value]['text'],$_POST['question'][$value]['id'],$lastinsertedid,1);


                                            $qu->updateQuestionDeleted($database_questions[$d]['id']);
                                        }
                                        else
                                        {


                                            $flagsq=$this->_getParam('checkboxquestion');


                                            foreach($flagsq as $flagqtextkey2=>$flagqtextvalue)
                                            {
                                                echo '<br/>';


                                                if($flagqtextvalue == $_POST['question'][$flagqtextvalue]['id']){
                                                    // print_r($flagqtextkey2);


                                                    $narray[$flagqtextvalue] = "question "."$flagqtextvalue"." already edited";
//                                                    print_r($narray);

                                                    echo 'Unable to edit question '.$flagqtextvalue . ', ' .$narray[$flagqtextvalue] . '.';
                                                    $this->view->flagquestion=$narray;

                                                }
                                                else
                                                {
                                                    echo 'je mag vraag '.$flagqtextvalue." editen ";
                                                    echo '-------------------------------------------';
                                                }

                                            }
                                        }


                                        $i = 0;

                                        if(!empty ($_POST['question'][$value]['answers']))
                                        {
                                            foreach($_POST['question'][$value]['answers'] as $answer_postid => $answer_postdata)
                                            {

                                                if($i<=$totalq)
                                                {

                                                    $controlanswer = $au->editControlAnswer($database_questions[$d]['answers'][$i]['answer_id']);

                                                    if(!$controlanswer)
                                                    {

                                                        $a->saveAnswerQB($database_questions[$d]['id'],$lastinsertedid);

                                                        $lastinsertedid2= $a->getAdapter()->lastInsertId();

                                                        $at->saveAnswerTranslationQB($answer_postdata['text'],$answer_postid,$lastinsertedid2,1);

                                                        $au->updateAnswerDeleted($database_questions[$d]['answers'][$i]['answer_id']);

                                                    }
                                                }

                                                $i++;
                                            }
                                        }
                                    }
                                }
                            }

                        }
                    }
                }

            }
        }



    }

    /**************************SWITCH ACTION***********************************************************************************************/


    public function switchAction()
    {

        $questionsQB = new Application_Model_DbTable_Questionqb();


        $this->view->numRowsQB = $questionsQB->getNumRowsQB();

        $_GET['page'] = (isset($_GET['page']) ? $_GET['page'] :'geen pageid:undefined,hij neemt 0');

        $pageid = $_GET['page'];


        $actual_link_switch = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $limiet=($pageid*self::aantalrecordsperpage)-self::aantalrecordsperpage;

        if($limiet == -10)
        {
            $this->view->questionsqb = $questionsQB->getQuestionsQB(self::aantalrecordsperpage,$limiet+10,1);
        }
        else
        {
            $this->view->questionsqb = $questionsQB->getQuestionsQB(self::aantalrecordsperpage,$limiet,1);
        }

//        echo '<pre>';
        // echo $actual_link_switch;


//DATA VAN QB DIENT TELKENS OPNIEUW GEINDEXEERD TE WORDEN BINNEN ELASTICSEARCH ALS ER NIEUWE RECORDS WORDEN TOEGEVOEGD!!!
//        $client = new Elasticsearch\Client();
//        if(isset($_POST['checkbox'])){
//
//            foreach($_POST['checkbox'] as $value)
//            {
//                $number = count($_POST['checkbox']);
//                //if(isset($_POST['checkbox']))// == 2)
//                if($value == 1)
//                {
//                    //print_r($_POST);
//                    //$client = new Elasticsearch\Client();
//
//                    $params['index'] = 'questionbankdb';
//                    $params['type']  = 'qbank_question';
//                    $params['body']['query']['match']['qbqt_text'] = array(
//                        'query' => $_POST['search'],
//                        //'fuzziness' => 0.5,
//                    );
//                    $results = $client->search($params);
//
//                    $this->view->questionresultsqb = $results;
//
//
//                    $params2['index'] = 'questionbankdb';
//                    $params2['type']  = 'qbank_question';
//                    $params2['body']['query']['match']['qbat_text'] = array(
//                        'query' => $_POST['search'],
//                        //'fuzziness' => 0.5,
//                    );
//
//                    $results2 = $client->search($params2);
//
//                    $this->view->answerresultsqb = $results2;
//
//                }
//
//
//                if($value == 2){
//                    //print_r($_POST);
//                    //$client = new Elasticsearch\Client();
//                    $params['index'] = 'questionbankdb';
//                    $params['type']  = 'qbank_question';
//                    $params['body']['query']['match']['qbqt_text'] = array(
//                        'query' => $_POST['search'],
//
//                        //'fuzziness' => 0.5,
//                        //'boost' => 0
//                    );
//
//                    $results = $client->search($params);
//
//                    $this->view->questionresultsqb = $results;
//
//                    $params2['index'] = 'questionbankdb';
//                    $params2['type']  = 'qbank_question';
//                    $params2['body']['query']['match']['qbat_text'] = array(
//                        'query' => '',
//                        //'fuzziness' => 0.5,
//                    );
//
//                    $results2 = $client->search($params2);
//
//                    $this->view->answerresultsqb = $results2;
//                }
//
//
//                if($value == 3){
//                    //print_r($_POST);
//                    //$client = new Elasticsearch\Client();
//                    $params['index'] = 'questionbankdb';
//                    $params['type']  = 'qbank_question';
//                    $params['body']['query']['match']['qbqt_text'] = array(
//                        'query' => '',
//                        //'fuzziness' => 0.5,
//                        //'boost' => 0
//                    );
//
//                    $results = $client->search($params);
//
//                    $this->view->questionresultsqb = $results;
//
//
//                    $params2['index'] = 'questionbankdb';
//                    $params2['type']  = 'qbank_question';
//                    $params2['body']['query']['match']['qbat_text'] = array(
//                        'query' => $_POST['search'],
//                        //'fuzziness' => 0.5,
//                    );
//
//                    $results2 = $client->search($params2);
//
//                    $this->view->answerresultsqb = $results2;
//
//                }
//
//
//
//                if($number > 2){
//                    //print_r($_POST);
//                    //$client = new Elasticsearch\Client();
//                    //return "Please select other checkboxes";
//                    $params['index'] = 'questionbankdb';
//                    $params['type']  = 'qbank_question';
//                    $params['body']['query']['match']['qbqt_text'] = array(
//                        'query' => '',
//                        //'fuzziness' => 0.5,
//                        //'boost' => 0
//                    );
//
//                    $results = $client->search($params);
//
//                    $this->view->questionresultsqb = $results;
//
//                    $params2['index'] = 'questionbankdb';
//                    $params2['type']  = 'qbank_question';
//                    $params2['body']['query']['match']['qbat_text'] = array(
//                        'query' => '',
//                        //'fuzziness' => 0.5,
//                    );
//
//                    $results2 = $client->search($params2);
//
//                    $this->view->answerresultsqb = $results2;
//
//                }
//
//                //moet nog verder gedebugd worden, want als quiz aangevinkt is mag er niets verschijnen
//                if($number == 2){
//                    //print_r($_POST);
//                    //$client = new Elasticsearch\Client();
//                    //return "Please select other checkboxes";
//                    $params['index'] = 'questionbankdb';
//                    $params['type']  = 'qbank_question';
//                    $params['body']['query']['match']['qbqt_text'] = array(
//                        'query' => $_POST['search'],
//                        //'fuzziness' => 0.5,
//                        //'boost' => 0
//                    );
//
//                    $results = $client->search($params);
//
//                    $this->view->questionresultsqb = $results;
//
//                    $params2['index'] = 'questionbankdb';
//                    $params2['type']  = 'qbank_question';
//                    $params2['body']['query']['match']['qbat_text'] = array(
//                        'query' => $_POST['search'],
//                        //'fuzziness' => 0.5,
//                    );
//
//                    $results2 = $client->search($params2);
//
//                    $this->view->answerresultsqb = $results2;
//
//                }
//
//
//            }
//
//        }
//
//        else
//        {
//            //print_r($_POST);
//            $client = new Elasticsearch\Client();
//
//
//            $params['index'] = 'questionbankdb';
//            $params['type']  = 'qbank_question';
//            $params['body']['query']['match']['qbqt_text'] = array(
//                'query' => '',
//                //'fuzziness' => 0.5,
//            );
//            try {
//                $results = $client->search($params);
//            } catch(Exception $e) {
//                $results = null;
//            }
//
//
//            $this->view->questionresultsqb = $results;
//
//            $params2['index'] = 'questionbankdb';
//            $params2['type']  = 'qbank_question';
//            $params2['body']['query']['match']['qbat_text'] = array(
//                'query' => '',
//                //'fuzziness' => 0.5,
//            );
//            try {
//                $results2 = $client->search($params2);
//
//            } catch (Exception $e) {
//                $results2 = null;
//            }
//
//            $this->view->answerresultsqb = $results2;
//        }


        $qu=new Application_Model_DbTable_Question();
        $q = new Application_Model_DbTable_Questionqb();
        $au=new Application_Model_DbTable_Answer();

        $a = new Application_Model_DbTable_Answerqb();
        $answertranslation = new Application_Model_DbTable_AnswerTranslation();
        $at = new Application_Model_DbTable_Answertranslationqb();
        $qt = new Application_Model_DbTable_Questiontranslationqb();

//        echo '<pre>';

        $limit = 0;

        $limitAnswers = 0;


        $totala = $a->getMaxPK();
        $totalq = $q->getMaxPK();




        if($actual_link_switch == "http://local.stage/Index/switch" || $actual_link_switch == "http://local.stage/Index/switch?pageid=1&ipp=10" || $actual_link_switch == "http://local.stage/Index/switch#")
        {

            $database_questions = $questionsQB->getQuestionsQB($totalq,$limit,1);



            //nodig voor delete van answers volgens answercheckboxes
            $database_answers = $a->getAnswersFromQB($totala,$limitAnswers,1);



            array_unshift($database_questions,array('answers'=>array()));
            unset($database_questions[0]);


//DELETE VIA SEARCH VAN QUESTIONS
//---------------------------------------
            if(isset($_POST['delete_questions_search'])) {


                //print_r($_POST);
                if(isset($_POST['checkboxquestionsearchqb'])){

                    foreach($_POST['checkboxquestionsearchqb'] as $searchkey => $searchvalue){



                        if($searchvalue == $_POST['questionqb'][$searchvalue]['id']);
                        {


                            if(!is_null($_POST['questionqb'][$searchvalue]['qbqt_question_id']) && !empty($_POST['questionqb'][$searchvalue]['qbqt_question_id']))
                            {
                                $qu->setQuestionNotDeleted($_POST['questionqb'][$searchvalue]['qbqt_question_id']);
                            }

//                            try
//                            {
//                                $deleteQuestionParams = array();
//                                $deleteQuestionParams['index'] = 'questionbankdb';
//                                $deleteQuestionParams['type'] = 'qbank_question';
//                                $deleteQuestionParams['body']['query']['match']['_id'] = array(
//                                    'query' => $_POST['questionqb'][$searchvalue]['id']);
//
//                                $client->deleteByQuery($deleteQuestionParams);
//                            }
//                            catch(Exception $e)
//                            {
//                                return $e;
//                            }

                            $qt->deleteQuestionTrQB($_POST['questionqb'][$searchvalue]['id']);



                            if(!empty($_POST['questionqb'][$searchvalue]['qbat_text']) && !is_null($_POST['questionqb'][$searchvalue]['qbat_text']))
                            {

                                $si = 0;
                                foreach($_POST['questionqb'][$searchvalue]['qbat_text'] as $searchanswer_postid => $searchanswer_postdata)
                                {


                                    if(!empty($_POST['questionqb'][$searchvalue]['qbat_answer_id'][$si]) && !is_null($_POST['questionqb'][$searchvalue]['qbat_answer_id'][$si]))
                                    {
                                        $au->setAnswerNotDeleted($_POST['questionqb'][$searchvalue]['qbat_answer_id'][$si]);
                                    }


                                    $at->deleteAnswerTrQB($_POST['questionqb'][$searchvalue]['qbat_answer_qb_id'][$si]);
                                    $a->deleteAnswerQB($_POST['questionqb'][$searchvalue]['qbat_answer_qb_id'][$si]);

                                    $si++;

                                }
                            }
                            $q->deleteQuestionQB($_POST['questionqb'][$searchvalue]['id']);

                        }

                        $this->redirect("http://local.stage/Index/switch");
                    }
                }
            }
//---------------------------------------
//DELETE VIA SEARCH VAN ANSWERS
//-----------------------------
            if(isset($_POST['delete_answers_search'])) {


                if(isset($_POST['checkboxanswersearchqb'])){

                    foreach($_POST['checkboxanswersearchqb'] as $searchakey => $searchavalue){

                        foreach($_POST['questionqb'] as $qqbkey => $qqbvalue)
                        {

                            if(!empty($qqbvalue['qba_id']) && !is_null($qqbvalue['qba_id']))
                            {
                                $fi = 0;
                                foreach($qqbvalue['qba_id'] as $qbakey => $qbavalue)
                                {


                                    if($searchavalue == $qbavalue)
                                    {
//                                        print_r($qqbvalue['qbat_answer_qb_id'][$fi]);
//                                        echo '<br/>';
//                                        $at->deleteAnswerTrQB($qqbvalue['qbat_answer_qb_id'][$fi]);
//                                        $a->deleteAnswerQB($qqbvalue['qbat_answer_qb_id'][$fi]);
//                                        if(!is_null($qqbvalue['qbat_answer_id'][$fi]) && !empty($qqbvalue['qbat_answer_id'][$fi]))
//                                        {
//                                            $au->setAnswerNotDeleted($qqbvalue['qbat_answer_id'][$fi]);
//                                        }
//
//                                        try
//                                        {
//                                            $deleteAnswerParams = array();
//                                            $deleteAnswerParams['index'] = 'questionbankdb';
//                                            $deleteAnswerParams['type'] = 'qbank_question';
//                                            $deleteAnswerParams['body']['query']['match']['_id'] = array(
//                                                'query' => $qqbvalue['qbat_answer_qb_id'][$fi]);
//
//                                            $client->deleteByQuery($deleteAnswerParams);
//                                        }
//                                        catch(Exception $e)
//                                        {
//                                            return $e;
//                                        }
//
                                        $at->deleteAnswerTrQB($qqbvalue['qbat_answer_qb_id'][$fi]);
                                        $a->deleteAnswerQB($qqbvalue['qbat_answer_qb_id'][$fi]);

                                    }
                                    $fi++;
                                }
                            }

                        }
                        $this->redirect("http://local.stage/Index/switch");
                    }
                }
            }
//-----------------------------


            if(isset($_POST['delete_question'])) {


                if(isset($_POST['checkboxquestionqb'])){

                    foreach($_POST['checkboxquestionqb'] as $key => $value){


                        if($value == $_POST['question'][$value]['id'])
                        {
//                            echo '<pre>';
//                            echo '<br/>';
//                            print_r($_POST['question'][$value]['id']);


                            if(!is_null($_POST['question'][$value]['question_id']) && !empty($_POST['question'][$value]['question_id']))
                            {
                                $qu->setQuestionNotDeleted($_POST['question'][$value]['question_id']);
                            }

//                            try
//                            {
//                                $deleteQuestionParams = array();
//                                $deleteQuestionParams['index'] = 'questionbankdb';
//                                $deleteQuestionParams['type'] = 'qbank_question';
//                                $deleteQuestionParams['body']['query']['match']['_id'] = array(
//                                    'query' => $_POST['question'][$value]['id']);
//
//                                $client->deleteByQuery($deleteQuestionParams);
//                            }
//                            catch(Exception $e)
//                            {
//                                return $e;
//                            }

                            $qt->deleteQuestionTrQB($_POST['question'][$value]['id']);
//                            $q->deleteQuestionQB($_POST['question'][$value]['id']);



                            if(!empty($_POST['question'][$value]['answers']))
                            {

                                foreach($_POST['question'][$value]['answers'] as $answer_postid => $answer_postdata)
                                {

                                    print_r($_POST['question'][$value]['answers'][$answer_postdata['answer_qb_id']]['answer_qb_id']);

                                    if(!empty($_POST['question'][$value]['answers'][$answer_postdata['answer_qb_id']]['answer_id']) && !is_null($_POST['question'][$value]['answers'][$answer_postdata['answer_qb_id']]['answer_id']))
                                    {
                                        $au->setAnswerNotDeleted($_POST['question'][$value]['answers'][$answer_postdata['answer_qb_id']]['answer_id']);
                                    }

                                    $at->deleteAnswerTrQB($_POST['question'][$value]['answers'][$answer_postdata['answer_qb_id']]['answer_qb_id']);
                                    $a->deleteAnswerQB($_POST['question'][$value]['answers'][$answer_postdata['answer_qb_id']]['answer_qb_id']);
                                }

                            }
                            else
                            {
                                echo "";
                            }
                            $q->deleteQuestionQB($_POST['question'][$value]['id']);

//                                }
                        }
//                        }
                    }
                }
                $this->redirect("http://local.stage/Index/switch");
            }


            if(isset($_POST['delete_answer'])) {

                if(isset($_POST['checkboxanswersqb'])){
                    foreach($_POST['checkboxanswersqb'] as $key => $value){

                        array_unshift($database_answers, array());
                        unset($database_answers[0]);


                        for($d=1;$d<=$totala;$d++)
                        {

                            if($value == $database_answers[$d]['answer_qb_id'])
                            {

                                if(!is_null($database_answers[$d]['answer_id']))
                                {
                                    $au->setAnswerNotDeleted($database_answers[$d]['answer_id']);
                                }

//                                try
//                                {
//                                    $deleteAnswerParams = array();
//                                    $deleteAnswerParams['index'] = 'questionbankdb';
//                                    $deleteAnswerParams['type'] = 'qbank_question';
//                                    $deleteAnswerParams['body']['query']['match']['_id'] = array(
//                                        'query' => $database_answers[$d]['answer_qb_id']);
//
//                                    $client->deleteByQuery($deleteAnswerParams);
//                                }
//                                catch(Exception $e)
//                                {
//                                    return $e;
//                                }

                                $at->deleteAnswerTrQB($database_answers[$d]['answer_qb_id']);
                                $a->deleteAnswerQB($database_answers[$d]['answer_qb_id']);
                            }
                        }
                    }
                }
                $this->redirect("http://local.stage/Index/switch");
            }




            //SAVE van search
            //update het database veld en de elasticsearch

            if(isset($_POST['Savesearch']))
            {
                if(isset($_POST['questionqb']))
                {
                    foreach($_POST['questionqb'] as $skey => $svalue)
                    {

                        if($skey == $svalue['id'])
                        {
                            $qt->updateQuestionTranslationQB($svalue['qbqt_text'],$skey);
                        }

                        echo '<br/>';

                        if(!empty($svalue['qbat_text']) && !is_null($svalue['qbat_text']))
                        {

                            $i = 0;

                            foreach($svalue['qbat_text'] as $askey => $asvalue)
                            {

                                if($i<= $totala)
                                {
                                    $at->updateAnswerTranslationQB($asvalue,$svalue['qbat_answer_qb_id'][$i]);
                                }

                                $i++;
                            }


                        }
                    }
                }

                $this->redirect("http://local.stage/Index/switch");
            }



            //  if($this->getRequest()->isXmlHttpRequest() && $this->getRequest()->isPost() )  {

            if(isset($_POST['Save']))
            {

                if(isset($_POST['question']))
                {
                    $c=1;
                    foreach($_POST['question'] as $question_postid => $question_postdata)
                    {

                        if ($question_postdata['text'] != $database_questions[$c]['text']) {

                            $controlquestion= $q->editControlQuestionQB($database_questions[$c]['id']);

                            if(!$controlquestion && (!empty($question_postdata['text']) && !is_null($question_postdata['text']))){


                                $qt->updateQuestionTranslationQB($question_postdata['text'],$question_postdata['id']);

                                if(!empty($question_postdata['answers']))
                                {

                                    $t=0;
                                    foreach($question_postdata['answers'] as $answer_postid => $answer_postdata) {
                                        print_r($question_postdata['answers']);


                                        echo'<br/>';
                                        if($t<sizeof($database_questions[$c]['answers'])){



                                            $controlanswer= $a->editControlAnswerQB($database_questions[$c]['answers'][$t]['answer_qb_id']);

                                            if(!$controlanswer && (!empty($answer_postdata['text']) && !is_null($answer_postdata['text']))){


                                                $at->updateAnswerTranslationQB($answer_postdata['text'],$database_questions[$c]['answers'][$t]['answer_qb_id']);

                                            }
                                        }
                                        $t++;
                                    }
                                }else{echo 'geen antwoorden om up te daten';}
                            }
                        }
                        $c++;
                    }

                    $z=1;
                    foreach($_POST['question'] as $qid=>$qval)
                    {


                        $t=0;


                        if(!empty($qval['answers']) && !is_null($qval['answers']))
                        {
                            foreach($qval['answers'] as $answer_postid => $a_postdata)
                            {


                                if($t<sizeof($database_questions[$z]['answers'])){

                                    $controlanswer= $a->editControlAnswerQB($database_questions[$z]['answers'][$t]['answer_qb_id']);

                                    if(!$controlanswer && (!empty($a_postdata['text']) && !is_null($a_postdata['text']))){

                                        $at->updateAnswerTranslationQB($a_postdata['text'],$database_questions[$z]['answers'][$t]['answer_qb_id']);
                                    }

                                }
                                $t++;

                            }
                        }
                        $z++;
                    }
                }
//                $this->redirect("http://local.stage/Index/switch");





                if(isset($_POST['addedquestiontext'])){
                    print_r($_POST['addedquestiontext']);


                    foreach($_POST['addedquestiontext'] as $jskey=>$javascriptaddquestion)
                    {

                        if(!empty($javascriptaddquestion['questiontext']) && !is_null($javascriptaddquestion['questiontext']))
                        {
                            $q->saveQuestionsQB(null,2);

                            $jslastinsertid=$q->getAdapter()->lastInsertId();


                            $qt->insertJavascriptData($javascriptaddquestion['questiontext'],null,$jslastinsertid,1);


                            foreach($_POST['addedquestiontext'][$jskey]['answertexts'] as $jskey2=>$jsaddanswer )
                            {

                                if(!empty($jsaddanswer['answertext']) && !is_null($jsaddanswer['answertext']))
                                {
                                    $a->saveAnswerQB(null,$jslastinsertid);
                                    $jslastinsertid2=$a->getAdapter()->lastInsertId();

                                    $at->insertJavascriptanswerdata($jsaddanswer['answertext'],null,$jslastinsertid2,1);

                                }
                            }
                        }
                    }
                }

                if(isset($_POST['addednewanswer']))
                {
                    print_r($_POST['addednewanswer']);
                    foreach($_POST['addednewanswer'] as $newkeyanswer=>$newanswer)
                    {

                        if(!empty($newanswer['answers']) && !is_null($newanswer['answers']))
                        {
                            foreach($newanswer['answers'] as $addnewanswerkey=>$addnewanswer)
                            {

                                if(!empty($newanswer['questionid']))
                                {
                                    $a->saveAnswerQB($newanswer['questionid'],$newkeyanswer);
                                }
                                else{ $a->saveAnswerQB(null,$newkeyanswer);}

                                $jslastinsertid2=$a->getAdapter()->lastInsertId();
                                $at->insertJavascriptanswerdata($addnewanswer,null,$jslastinsertid2,1);

                            }
                        }
                    }
                }
                $this->redirect("http://local.stage/Index/switch");
            }
            echo '<pre>';

            //$partialviewarray = array(array('geselecteerde_question'=>'','geselecteerde_answers'=>array()));



            if(isset($_POST['GeneratePage']))
            {
                //print_r($_POST['question']);

                if(isset($_POST['checkboxquestionqb']))
                {


                    foreach($_POST['checkboxquestionqb'] as $chkboxqid=>$chkboxvalue)
                    {
                        if($chkboxvalue == $_POST['question'][$chkboxvalue]['id'])
                        {


                            $partialviewarray['questionarray'.$chkboxqid]['geselecteerde_question']['questiontext']=$_POST['question'][$chkboxvalue]['text'];
                            $partialviewarray['questionarray'.$chkboxqid]['geselecteerde_question']['questionqbid']=$_POST['question'][$chkboxvalue]['question_qb_id'];





                            if(isset($_POST['checkboxanswersqb']))

                            {

                                foreach($_POST['checkboxanswersqb'] as $chkboxaid=>$chkboxavalue)
                                {

                                    foreach($_POST['question'][$chkboxvalue]['answers'] as $partialviewanswer_postid => $partialviewanswer_postdata)
                                    {



                                        if($chkboxavalue == $partialviewanswer_postdata['answer_qb_id'])
                                        {




                                            $partialviewarray['questionarray'.$chkboxqid]['geselecteerde_answers'][$partialviewanswer_postid] ['answertext']  = $partialviewanswer_postdata['text'];
                                            $partialviewarray['questionarray'.$chkboxqid]['geselecteerde_answers'] [$partialviewanswer_postid] ['questionqbid'] = $partialviewanswer_postdata['id'];
                                            $partialviewarray['questionarray'.$chkboxqid]['geselecteerde_answers'] [$partialviewanswer_postid]['answer_qb_id']  = $partialviewanswer_postdata['answer_qb_id'];
                                        }



                                    }

                                }

                            }
                            else{

                                   foreach($_POST['question'][$chkboxvalue]['answers'] as $partialviewanswer_postid => $partialviewanswer_postdata)
                                   {

                                    $partialviewarray['questionarray'.$chkboxqid]['geselecteerde_answers'][$partialviewanswer_postid] ['answertext']  = $partialviewanswer_postdata['text'];
                                    $partialviewarray['questionarray'.$chkboxqid]['geselecteerde_answers'] [$partialviewanswer_postid] ['questionqbid'] = $partialviewanswer_postdata['id'];
                                    $partialviewarray['questionarray'.$chkboxqid]['geselecteerde_answers'] [$partialviewanswer_postid]['answer_qb_id']  = $partialviewanswer_postdata['answer_qb_id'];

                                   }




                                }
                        }

                    }


                }else
                {
                    echo 'no questioncheckbox checked with the current answers';



                }


               // print_r($partialviewarray);
                echo '</pre>';







                $this->redirect('http://local.stage/Generator-Page/pagegenerator?'.http_build_query($partialviewarray));


            }
        }
        //END IF for first page


        //ELSE voor andere pagina's
        else
        {

            $totalPerPage = ($pageid*self::aantalrecordsperpage);
            $countStart = $totalPerPage-9;


            $database_answers = $a->getAnswersFromQB($totala,$limitAnswers,1);
            $answertotal = sizeof($database_answers);

            $database_questions = $questionsQB->getQuestionsQB($totalq,$limit,1);


            array_unshift($database_questions,array('answers'=>array()));
            unset($database_questions[0]);


            //$total moet hier niet vermeerdert worden met 5 omdat de size nu klopt met het aantal records
            $total = sizeof($database_questions);

//DELETE VIA SEARCH VAN QUESTIONS
//---------------------------------------
            if(isset($_POST['delete_questions_search'])) {


                if(isset($_POST['checkboxquestionsearchqb'])){

                    foreach($_POST['checkboxquestionsearchqb'] as $searchkey => $searchvalue){



                        if($searchvalue == $_POST['questionqb'][$searchvalue]['id']);
                        {


                            if(!is_null($_POST['questionqb'][$searchvalue]['qbqt_question_id']) && !empty($_POST['questionqb'][$searchvalue]['qbqt_question_id']))
                            {
                                $qu->setQuestionNotDeleted($_POST['questionqb'][$searchvalue]['qbqt_question_id']);
                            }

//                            try
//                            {
//                                $deleteQuestionParams = array();
//                                $deleteQuestionParams['index'] = 'questionbankdb';
//                                $deleteQuestionParams['type'] = 'qbank_question';
//                                $deleteQuestionParams['body']['query']['match']['_id'] = array(
//                                    'query' => $_POST['questionqb'][$searchvalue]['id']);
//
//                                $client->deleteByQuery($deleteQuestionParams);
//                            }
//                            catch(Exception $e)
//                            {
//                                return $e;
//                            }

                            $qt->deleteQuestionTrQB($_POST['questionqb'][$searchvalue]['id']);


                            if(!empty($_POST['questionqb'][$searchvalue]['qbat_text']) && !is_null($_POST['questionqb'][$searchvalue]['qbat_text']))
                            {

                                $si = 0;
                                foreach($_POST['questionqb'][$searchvalue]['qbat_text'] as $searchanswer_postid => $searchanswer_postdata)
                                {



                                    if(!empty($_POST['questionqb'][$searchvalue]['qbat_answer_id']) && !is_null($_POST['questionqb'][$searchvalue]['qbat_answer_id']))
                                    {
                                        $au->setAnswerNotDeleted($_POST['questionqb'][$searchvalue]['qbat_answer_id'][$si]);
                                    }


                                    $at->deleteAnswerTrQB($_POST['questionqb'][$searchvalue]['qbat_answer_qb_id'][$si]);
                                    $a->deleteAnswerQB($_POST['questionqb'][$searchvalue]['qbat_answer_qb_id'][$si]);

                                    $si++;



                                }
                            }
                            $q->deleteQuestionQB($_POST['questionqb'][$searchvalue]['id']);

                        }
                        $this->redirect("http://local.stage/Index/switch?page=".$_GET['page']."&ipp=10");
                    }
                }
            }
//---------------------------------------
//DELETE VIA SEARCH VAN ANSWERS
//-----------------------------
            if(isset($_POST['delete_answers_search'])) {


                if(isset($_POST['checkboxanswersearchqb'])){

                    foreach($_POST['checkboxanswersearchqb'] as $searchakey => $searchavalue){

                        foreach($_POST['questionqb'] as $qqbkey => $qqbvalue)
                        {


                            if(!empty($qqbvalue['qba_id']) && !is_null($qqbvalue['qba_id']))
                            {
                                $fi = 0;
                                foreach($qqbvalue['qba_id'] as $qbakey => $qbavalue)
                                {



                                    if($searchavalue == $qbavalue)
                                    {
                                        if(!empty($qqbvalue['qbat_answer_id'][$fi]) && !is_null($qqbvalue['qbat_answer_id'][$fi]))
                                        {
                                            $au->setAnswerNotDeleted($qqbvalue['qbat_answer_id'][$fi]);
                                        }

//                                        try
//                                        {
//                                            $deleteAnswerParams = array();
//                                            $deleteAnswerParams['index'] = 'questionbankdb';
//                                            $deleteAnswerParams['type'] = 'qbank_question';
//                                            $deleteAnswerParams['body']['query']['match']['_id'] = array(
//                                                'query' => $qbavalue);
//
//                                            $client->deleteByQuery($deleteAnswerParams);
//                                        }
//                                        catch(Exception $e)
//                                        {
//                                            return $e;
//                                        }

                                        $at->deleteAnswerTrQB($qbavalue);
                                        $a->deleteAnswerQB($qbavalue);

                                    }
                                    $fi++;
                                }
                            }

                        }
                        $this->redirect("http://local.stage/Index/switch?page=".$_GET['page']."&ipp=10");
                    }
                }
            }
//-----------------------------

            if(isset($_POST['delete_question'])) {
                if(isset($_POST['checkboxquestionqb'])){
                    foreach($_POST['checkboxquestionqb'] as $key => $value){



                        if($value == $_POST['question'][$value]['id'])
                        {


                            if(!empty($_POST['question'][$value] ['question_id'])&& !is_null($_POST['question'][$value]['question_id']))
                            { $qu->setQuestionNotDeleted($_POST['question'][$value]['question_id']);}

//                            try
//                            {
//                                $deleteQuestionParams = array();
//                                $deleteQuestionParams['index'] = 'questionbankdb';
//                                $deleteQuestionParams['type'] = 'qbank_question';
//                                $deleteQuestionParams['body']['query']['match']['_id'] = array(
//                                    'query' => $_POST['question'][$value]['id']);
//
//                                $client->deleteByQuery($deleteQuestionParams);
//                            }
//                            catch(Exception $e)
//                            {
//                                return $e;
//                            }

                            $qt->deleteQuestionTrQB($_POST['question'][$value]['id']);
//                            $q->deleteQuestionQB($_POST['question'][$value]['id']);
//                                  //Voorlopige oplossing door hidden field met question_id






                            if(!empty($_POST['question'][$value]['answers']))
                            {

                                foreach($_POST['question'][$value]['answers'] as $answer_postid => $answer_postdata)
                                {




                                    if(!empty($_POST['question'][$value]['answers'][$answer_postdata['answer_qb_id']]['answer_id']) && !is_null($_POST['question'][$value]['answers'][$answer_postdata['answer_qb_id']]['answer_id']))
                                    {
                                        $au->setAnswerNotDeleted($_POST['question'][$value]['answers'][$answer_postdata['answer_qb_id']]['answer_id']);
                                    }

                                    $at->deleteAnswerTrQB($_POST['question'][$value]['answers'][$answer_postdata['answer_qb_id']]['answer_qb_id']);
                                    $a->deleteAnswerQB($_POST['question'][$value]['answers'][$answer_postdata['answer_qb_id']]['answer_qb_id']);

                                }

                            }
                            else
                            {
                                echo "";
                            }
                            $q->deleteQuestionQB($_POST['question'][$value]['id']);

                        }
                    }
                }
                $this->redirect("http://local.stage/Index/switch?page=".$_GET['page']."&ipp=10");
            }


            if(isset($_POST['delete_answer'])) {
                if(isset($_POST['checkboxanswersqb'])){
                    foreach($_POST['checkboxanswersqb'] as $key => $value){

                        array_unshift($database_answers, array());
                        unset($database_answers[0]);


                        for($d=1;$d<=$totala;$d++)
                        {

                            if($value == $database_answers[$d]['answer_qb_id'])
                            {

                                if(!is_null($database_answers[$d]['answer_id'])){
                                    $au->setAnswerNotDeleted($database_answers[$d]['answer_id']);
                                }

//                                try
//                                {
//                                    $deleteAnswerParams = array();
//                                    $deleteAnswerParams['index'] = 'questionbankdb';
//                                    $deleteAnswerParams['type'] = 'qbank_question';
//                                    $deleteAnswerParams['body']['query']['match']['_id'] = array(
//                                        'query' => $database_answers[$d]['answer_qb_id']);
//
//                                    $client->deleteByQuery($deleteAnswerParams);
//                                }
//                                catch(Exception $e)
//                                {
//                                    return $e;
//                                }

                                $at->deleteAnswerTrQB($database_answers[$d]['answer_qb_id']);
                                $a->deleteAnswerQB($database_answers[$d]['answer_qb_id']);

                            }
                        }
                    }
                }
                $this->redirect("http://local.stage/Index/switch?page=".$_GET['page']."&ipp=10");
            }




            //$_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';


//            if($this->getRequest()->isXmlHttpRequest() && $this->getRequest()->isPost() )  {

            if(isset($_POST['Savesearch']))
            {

                if(isset($_POST['questionqb']))
                {
                    foreach($_POST['questionqb'] as $skey => $svalue)
                    {


                        if($skey == $svalue['id'])
                        {
                            $qt->updateQuestionTranslationQB($svalue['qbqt_text'],$skey);
                        }

                        echo '<br/>';

                        if(!empty($svalue['qbat_text']) && !is_null($svalue['qbat_text']))
                        {

                            $i = 0;

                            foreach($svalue['qbat_text'] as $askey => $asvalue)
                            {

                                if($i<= $totala)
                                {
                                    $at->updateAnswerTranslationQB($asvalue,$svalue['qbat_answer_qb_id'][$i]);
                                }

                                $i++;
                            }


                        }
                    }
                }

                $this->redirect("http://local.stage/Index/switch?page=".$_GET['page']."&ipp=10");
            }

            if(isset($_POST['Save'])){

                if(isset($_POST['question']))
                {

                    $counter= $countStart;

                    foreach($_POST['question'] as $question_postid => $question_postdata)
                    {


                        if($counter<=sizeof($database_questions))
                        {
                            if ($question_postdata['text'] != $database_questions[$counter]['text'])
                            {


                                $controlquestion= $q->editControlQuestionQB($database_questions[$counter]['id']);

                                if(!$controlquestion && (!empty($question_postdata['text']) && !is_null($question_postdata['text'])))
                                {


                                    $qt->updateQuestionTranslationQB($question_postdata['text'],$question_postdata['id']);
                                    if(!empty($question_postdata['answers']) && !is_null($question_postdata['answers']))
                                    {


                                        $t=0;
                                        foreach($question_postdata['answers'] as $answer_postid => $answer_postdata) {


                                            if($t<sizeof($database_questions[$counter]['answers'])){



                                                $controlanswer= $a->editControlAnswerQB($database_questions[$counter]['answers'][$t]['answer_qb_id']);

                                                if(!$controlanswer && (!empty($answer_postdata['text']) && !is_null($answer_postdata['text']))){


                                                    $at->updateAnswerTranslationQB($answer_postdata['text'],$database_questions[$counter]['answers'][$t]['answer_qb_id']);

                                                }
                                                else{
                                                    echo 'leeg answer inputveld kunn je neit opslaan';

                                                }
                                            }
                                            $t++;
                                        }
                                    }else{echo 'geen antwoorden om up te daten';}
                                }
                                else{
                                    echo 'leeg question inputveld kunn je neit opslaan';
                                }
                            }

                        }
                        $counter++;
                    }


                    foreach($_POST['question'] as $qid=>$qval)
                    {


                        if(!empty($qval['answers']) && !is_null($qval['answers']))
                        {

                            foreach($qval['answers'] as $answer_postid => $a_postdata)
                            {

                                for($t=0;$t<=sizeof($database_answers);$t++)
                                {

                                    if($answer_postid == $database_answers[$t]['answer_qb_id'])
                                    {
                                        if ($a_postdata['text'] != $database_answers[$t]['text'])
                                        {

                                            if(!empty($a_postdata['text']) && !is_null($a_postdata['text']))
                                            {
                                                $at->updateAnswerTranslationQB($a_postdata['text'],$database_answers[$t]['answer_qb_id']);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }


                if(isset($_POST['addedquestiontext'])){
                    print_r($_POST['addedquestiontext']);


                    foreach($_POST['addedquestiontext'] as $jskey=>$javascriptaddquestion)
                    {

                        if(!empty($javascriptaddquestion['questiontext']) && !is_null($javascriptaddquestion['questiontext']))
                        {
                            $q->saveQuestionsQB(null,2);

                            $jslastinsertid=$q->getAdapter()->lastInsertId();


                            $qt->insertJavascriptData($javascriptaddquestion['questiontext'],null,$jslastinsertid,1);


                            foreach($_POST['addedquestiontext'][$jskey]['answertexts'] as $jskey2=>$jsaddanswer )
                            {

                                if(!empty($jsaddanswer['answertext']) && !is_null($jsaddanswer['answertext']))
                                {
                                    $a->saveAnswerQB(null,$jslastinsertid);
                                    $jslastinsertid2=$a->getAdapter()->lastInsertId();

                                    $at->insertJavascriptanswerdata($jsaddanswer['answertext'],null,$jslastinsertid2,1);

                                }
                            }
                        }
                    }
                }

                if(isset($_POST['addednewanswer']))
                {
                    print_r($_POST['addednewanswer']);
                    foreach($_POST['addednewanswer'] as $newkeyanswer=>$newanswer)
                    {

                        if(!empty($newanswer['answers']) && !is_null($newanswer['answers']))
                        {
                            foreach($newanswer['answers'] as $addnewanswerkey=>$addnewanswer)
                            {

                                if(!empty($newanswer['questionid']))
                                {
                                    $a->saveAnswerQB($newanswer['questionid'],$newkeyanswer);
                                }
                                else{ $a->saveAnswerQB(null,$newkeyanswer);}

                                $jslastinsertid2=$a->getAdapter()->lastInsertId();
                                $at->insertJavascriptanswerdata($addnewanswer,null,$jslastinsertid2,1);

                            }
                        }
                    }
                }

                $this->redirect("http://local.stage/Index/switch?page=".$_GET['page']."&ipp=10");
            }


        }
    }











}





