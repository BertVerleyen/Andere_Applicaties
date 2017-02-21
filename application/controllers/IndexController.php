<?php

class IndexController extends Zend_Controller_Action
{
    const aantalrecordsperpage= 10;

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
    /************************************END uitbreidingen**************************************************/

    public function init()
    {
        // $ajaxrequest=new Zend_Controller_Action_Helper_AjaxContext();


        $contextSwitch = $this->_helper->getHelper('AjaxContext');
        $contextSwitch->addActionContext('switch', array('json'))
            ->initContext();
    }

    /********INDEX ACTION******/
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

                    $this->redirect('/Index/home',array('username'=>$_POST['username']));

                } else {

                    $this->view->errorMessage = "Invalid username or password. Please try again.";

                }

            }else
            {
                $this->view->errorMessage2="sorry you ain't an admin";

            }

        }
    }
    /********END INDEX ACTION******/

    /*******Action die ervoor zorgt dat er kan uitgelogd worden en er teruggekeerd wordt naar de login pagina*******/
    public function signoutAction()
    {
        $storage = new Zend_Auth_Storage_Session();

        $storage->clear();

        $this->redirect("Index/index");
    }


    /***************************HOME action********************************************************/
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


        $qu=new Application_Model_DbTable_Question();
        $q = new Application_Model_DbTable_Questionqb();
        $au=new Application_Model_DbTable_Answer();

        $a = new Application_Model_DbTable_Answerqb();
        $at = new Application_Model_DbTable_Answertranslationqb();
        $qt = new Application_Model_DbTable_Questiontranslationqb();

        $quizzes = new Application_Model_DbTable_Quiz();
        
        $totalq = $qu->getMaxPK();
        $totala = $au->getMaxPK();

        if($actual_link == "http://local.stage/Index/home" || $actual_link == "http://local.stage/Index/home/?page=1&ipp=10")
        {
            $limiet=0;
            $this->view->questionssearch = $questions->getQuestionsSearch($totalq,$limiet,1,$_POST['query']);
            $this->view->quizzessearch = $quizzes->getQuizzesSearch($totalq,$limiet,1,$_POST['query']);
            // $this->view->answerssearch =
            $database_questions = $questions->getQuestions($totalq,$limiet,1);

            //Opnieuw size gebruikt om de fouten van dbcounter die >415 op te vangen
            //Size gaat tot 415, totalq is hier niet nodig omdat de eerste waarde gewoon geïncrementeerd wordt om de array te doorlopen
            $size = sizeof($database_questions);

            array_unshift($database_questions,array('answers'));
            unset($database_questions[0]);


            //SEARCH
            /***********URL scraping**************/
            if(isset($_POST['image_x']))
            {
                $this->view->urlgenerated =  $this->getData('https://www.google.be/search?q='.$_POST["search"]);
                //$this->scrape($_POST['search']);
            }


            /***************SAVE van search via elasticsearch-> kan vervangen worden door MySQL search query***************/
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

                                                if($flagqtextvalue == $_POST['questionqb'][$flagqtextvalue]['id']){

                                                    $narray[$flagqtextvalue] = "question "."$flagqtextvalue"." already edited";

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

                                    /**FLAGS voor de Search***/
                                    else
                                    {

                                        $flagsq=$this->_getParam('checkboxquestionsearch');

                                        foreach($flagsq as $flagqtextkey2=>$flagqtextvalue)
                                        {

                                            if($flagqtextvalue == $_POST['questionqb'][$flagqtextvalue]['id']){

                                                $narray[$flagqtextvalue] = "question "."$flagqtextvalue"." already edited";

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
            /********************END SAVE van search************************/


            /**********************SAVE van data uit database****************/
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
                                            if($flagqtextvalue == $_POST['question'][$flagqtextvalue]['id']){

                                                $narray[$flagqtextvalue] = "question "."$flagqtextvalue"." already edited";

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

            array_unshift($database_questions,array('answers'));
            unset($database_questions[0]);

            /***********SEARCH SAVE voor paginatie, oorspronkelijk elasticsearch -> kan vervangen worden door MySQL Search query**********/
            if(isset($_POST['Savesearch'])) {

                if(isset($_POST['checkboxquestionsearch'])){

                    foreach($_POST['checkboxquestionsearch'] as $key => $value){

                        if($value == $_POST['questionqb'][$value]['id']){

                            for($dbcounter=1;$dbcounter<=$sizeqb;$dbcounter++){
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

                                            if(!empty($_POST['questionqb'][$value]['at_text']))
                                            {
                                                foreach($_POST['questionqb'][$value]['at_text'] as $qqbkey => $qqbvalue)
                                                {
                                                    if($i<=$totala){

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
                                            $flagsq=$this->_getParam('checkboxquestionsearch');

                                            foreach($flagsq as $flagqtextkey2=>$flagqtextvalue)
                                            {

                                                if($flagqtextvalue == $_POST['questionqb'][$flagqtextvalue]['id'])
                                                {

                                                    $narray[$flagqtextvalue] = "question "."$flagqtextvalue"." already edited";

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
                                            if($flagqtextvalue == $_POST['questionqb'][$flagqtextvalue]['id']){

                                                $narray[$flagqtextvalue] = "question "."$flagqtextvalue"." already edited";

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
            /*****************END Search save voor paginatie*****************/



            /**********DATABASE SAVE voor data list in pagina**************/
            if(isset($_POST['Save'])) {
                if(isset($_POST['checkboxquestion']))
                {
                    foreach($_POST['checkboxquestion'] as $key => $value)
                    {
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

                                                if($flagqtextvalue == $_POST['question'][$flagqtextvalue]['id']){

                                                    $narray[$flagqtextvalue] = "question "."$flagqtextvalue"." already edited";

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
            /***********End Database save*************/
        }
    }
    /******************END home action*************************/


    /**************************SWITCH ACTION************************/
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



        $qu=new Application_Model_DbTable_Question();
        $q = new Application_Model_DbTable_Questionqb();
        $au=new Application_Model_DbTable_Answer();

        $a = new Application_Model_DbTable_Answerqb();
        $at = new Application_Model_DbTable_Answertranslationqb();
        $qt = new Application_Model_DbTable_Questiontranslationqb();


        $limit = 0;

        $limitAnswers = 0;

        $totala = $a->getMaxPK();
        $totalq = $q->getMaxPK();


        /********************Start IF voor de eerste pagina***********************************/
        if($actual_link_switch == "http://local.stage/Index/switch" || $actual_link_switch == "http://local.stage/Index/switch?pageid=1&ipp=10" || $actual_link_switch == "http://local.stage/Index/switch#")
        {
            $database_questions = $questionsQB->getQuestionsQB($totalq,$limit,1);

            //nodig voor delete van answers volgens answercheckboxes
            $database_answers = $a->getAnswersFromQB($totala,$limitAnswers,1);

            array_unshift($database_questions,array('answers'=>array()));
            unset($database_questions[0]);


            /*******DELETE VIA SEARCH VAN QUESTIONS-> oorspronkelijk via elasticsearch-> kan aangepast worden naar MySQL Search query***********/
            if(isset($_POST['delete_questions_search'])) {

                if(isset($_POST['checkboxquestionsearchqb'])){

                    foreach($_POST['checkboxquestionsearchqb'] as $searchkey => $searchvalue){

                        if($searchvalue == $_POST['questionqb'][$searchvalue]['id']);
                        {

                            if(!is_null($_POST['questionqb'][$searchvalue]['qbqt_question_id']) && !empty($_POST['questionqb'][$searchvalue]['qbqt_question_id']))
                            {
                                $qu->setQuestionNotDeleted($_POST['questionqb'][$searchvalue]['qbqt_question_id']);
                            }

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
            /*******END delete search van questions***********/

            /**********DELETE VIA SEARCH VAN ANSWERS->oorspronkelijk via elasticsearch-> kan aangepast worden naar MySQL search query********/
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
                                        $at->deleteAnswerTrQB($qqbvalue['qbat_answer_qb_id'][$fi]);
                                        $a->deleteAnswerQB($qqbvalue['qbat_answer_qb_id'][$fi]);
                                        if(!is_null($qqbvalue['qbat_answer_id'][$fi]) && !empty($qqbvalue['qbat_answer_id'][$fi]))
                                        {
                                            $au->setAnswerNotDeleted($qqbvalue['qbat_answer_id'][$fi]);
                                        }

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
            /*******End delete via search van answers***************/

            /******Delete questions uit lijst*******/
            if(isset($_POST['delete_question'])) {

                if(isset($_POST['checkboxquestionqb'])){

                    foreach($_POST['checkboxquestionqb'] as $key => $value){


                        if($value == $_POST['question'][$value]['id'])
                        {

                            if(!is_null($_POST['question'][$value]['question_id']) && !empty($_POST['question'][$value]['question_id']))
                            {
                                $qu->setQuestionNotDeleted($_POST['question'][$value]['question_id']);
                            }

                            $qt->deleteQuestionTrQB($_POST['question'][$value]['id']);

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
                $this->redirect("http://local.stage/Index/switch");
            }
            /************End delete questions uit lijst*************/

            /************Delete answers uit lijst********************/
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

                                $at->deleteAnswerTrQB($database_answers[$d]['answer_qb_id']);
                                $a->deleteAnswerQB($database_answers[$d]['answer_qb_id']);
                            }
                        }
                    }
                }
                $this->redirect("http://local.stage/Index/switch");
            }
            /************End delete answers uit lijst*************/


            /********SAVE via search, update records-> oorspronkelijk elasticsearch-> kan uitgebreid worden naar MySQL search Query******/
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
            /*********End save via search**************/

            /**************Save van data uit lijst-> update van questions en answers &&
             * add van toegevoegde questions en answers via 'Add answer' en 'Add question' button opslaan in de QuestionBank dataset**********************/
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


                if(isset($_POST['addedquestiontext'])){

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
            /************END save van data uit lijst***********/

            /************Opent een nieuwe pagina met de geselecteerde questions en answers******************/
            if(isset($_POST['GeneratePage']))
            {
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
                            else
                            {
                                foreach($_POST['question'][$chkboxvalue]['answers'] as $partialviewanswer_postid => $partialviewanswer_postdata)
                                {
                                    $partialviewarray['questionarray'.$chkboxqid]['geselecteerde_answers'][$partialviewanswer_postid] ['answertext']  = $partialviewanswer_postdata['text'];
                                    $partialviewarray['questionarray'.$chkboxqid]['geselecteerde_answers'] [$partialviewanswer_postid] ['questionqbid'] = $partialviewanswer_postdata['id'];
                                    $partialviewarray['questionarray'.$chkboxqid]['geselecteerde_answers'] [$partialviewanswer_postid]['answer_qb_id']  = $partialviewanswer_postdata['answer_qb_id'];
                                }
                            }
                        }
                    }
                }
                else
                {
                    echo 'no questioncheckbox checked with the current answers';
                }
                $this->redirect('http://local.stage/Generator-Page/pagegenerator?'.http_build_query($partialviewarray));
            }
            /**************END $_POST['GeneratorPage']*************************/

        }
        /************************END IF voor de eerste pagina***************************************/


        /***********ELSE voor andere pagina's************************/
        else
        {
            $totalPerPage = ($pageid*self::aantalrecordsperpage);
            $countStart = $totalPerPage-9;

            $database_answers = $a->getAnswersFromQB($totala,$limitAnswers,1);
            $answertotal = sizeof($database_answers);

            $database_questions = $questionsQB->getQuestionsQB($totalq,$limit,1);

            array_unshift($database_questions,array('answers'=>array()));
            unset($database_questions[0]);


            /**********DELETE VIA SEARCH VAN QUESTIONS->oorspronkelijk via elasticsearch-> kan gebruikt worden voor MySQL Search query********************/
            if(isset($_POST['delete_questions_search'])) {

                if(isset($_POST['checkboxquestionsearchqb'])){

                    foreach($_POST['checkboxquestionsearchqb'] as $searchkey => $searchvalue){

                        if($searchvalue == $_POST['questionqb'][$searchvalue]['id']);
                        {
                            if(!is_null($_POST['questionqb'][$searchvalue]['qbqt_question_id']) && !empty($_POST['questionqb'][$searchvalue]['qbqt_question_id']))
                            {
                                $qu->setQuestionNotDeleted($_POST['questionqb'][$searchvalue]['qbqt_question_id']);
                            }

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
            /***********END delete via search van questions**********************/

            /************DELETE VIA SEARCH VAN ANSWERS->oorspronkelijk via elasticsearch->kan gebruikt worden voor MySQL Search query******************/
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
            /******************END delete via search***************************/

            /**************Delete van questions uit lijst van questionbank dataset uit de QuestionBankDB database*****************************/
            if(isset($_POST['delete_question'])) {
                if(isset($_POST['checkboxquestionqb'])){
                    foreach($_POST['checkboxquestionqb'] as $key => $value){

                        if($value == $_POST['question'][$value]['id'])
                        {
                            if(!empty($_POST['question'][$value] ['question_id'])&& !is_null($_POST['question'][$value]['question_id']))
                            { $qu->setQuestionNotDeleted($_POST['question'][$value]['question_id']);}

                            $qt->deleteQuestionTrQB($_POST['question'][$value]['id']);

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
            /**************End delete van questions uit lijst*****************************/

            /**************Delete van answers uit lijst van questionbank dataset uit de QuestionBankDB database*****************************/
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

                                $at->deleteAnswerTrQB($database_answers[$d]['answer_qb_id']);
                                $a->deleteAnswerQB($database_answers[$d]['answer_qb_id']);
                            }
                        }
                    }
                }
                $this->redirect("http://local.stage/Index/switch?page=".$_GET['page']."&ipp=10");
            }
            /*************End Delete van answers uit lijst******************************/



            /************Save van search(update) van data uit de questionbank dataset uit de QuestionBank database-> oorspronkelijk elasticsearch-> kan vervangen worden door MySQL Search query*******************************/
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
            /*************END save van search******************************/

            /****************Save & update van questions en answers die geselecteerd zijn uit de questionbank dataset van de QuestionBankDB database***************************/
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
                                        foreach($question_postdata['answers'] as $answer_postid => $answer_postdata)
                                        {
                                            if($t<sizeof($database_questions[$counter]['answers'])){

                                                $controlanswer= $a->editControlAnswerQB($database_questions[$counter]['answers'][$t]['answer_qb_id']);

                                                if(!$controlanswer && (!empty($answer_postdata['text']) && !is_null($answer_postdata['text']))){

                                                    $at->updateAnswerTranslationQB($answer_postdata['text'],$database_questions[$counter]['answers'][$t]['answer_qb_id']);
                                                }
                                                else
                                                {
                                                    echo 'leeg answer inputveld kunn je neit opslaan';
                                                }
                                            }
                                            $t++;
                                        }
                                    }else{echo 'geen antwoorden om up te daten';}
                                }
                                else
                                {
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
            /*************END save & Update van questions en answers******************************/
        }
        /*************END else voor andere pagina's******************************/
    }
    /*******************END switch action************************/

}





