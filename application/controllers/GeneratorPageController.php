<?php

class GeneratorPageController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }


    /*******actie om te testen om alle quizzes weer te geven in een lijst
    kan ook gebruikt worden voor het tonen van quizzes via de zoekfunctie
    kan ook gebruikt worden om via de shorturl de quiz te kunnen raadplegen*******/
    public function toonQuizzesAction()
    {
        // action body

        $quizzes = new Application_Model_DbTable_Quiz();

        $this->view->quizzes=$quizzes->getQuizzes(10,0,1);
    }
    /*******END toonQuizzesAction()*******/


    /*******actie om geselecteerde questions en eventuele geselecteerde antwoorden an de gecrëerde quiz toe te voegen*******/
    public function pagegeneratorAction()
    {
        $questblock = new Application_Model_DbTable_Questionblockqb();
        $quizqb = new Application_Model_DbTable_Quizqb();

        $questionqb = new Application_Model_DbTable_Questionqb();

        if(isset($_POST['Add_to_your_quiz']))
        {
            if(isset($_POST['checkboxquestionarray']))
            {
                foreach($_POST['checkboxquestionarray'] as $boxid=>$boxvalue)
                {
                    foreach($_GET as $qid=>$qvalue)
                    {
                        if($boxvalue == $qvalue['geselecteerde_question']['questionqbid'] )
                        {
                            $quizlastinsertedid = $quizqb->getMaxPK();
                            if(!is_null($quizlastinsertedid))
                            {
                                $questblock->saveQuestionblockQB($quizlastinsertedid);

                                $questblocklastinsertedid=$questblock->getMaxPK();
                                $questionqb->saveQuestionsQB($questblocklastinsertedid,2);
                            }
                            else
                            {
                                $this->view->noquiz = "You didn't make your quiz";
                            }
                        }
                    }
                }
                /**parameters voor shorturl link**/
//                $setarraytourlstring = http_build_query($_POST['qarray']);
//                echo $setarraytourlstring;
            }

            else
            {
                $this->view->nocheckboxselected = 'no checkboxes were selected';
            }
        }
        else
        {
            echo 'please post/check a question!!';
        }
    }
    /*******END action pagegeneratorAction()*******/


    /********actie om eigen quiz te creëeren binnen de questionbank dataset van de QuestionBankDB Database*
     om dan in de pagegenerator action er bestaande questions en answers aan toe te kunnen voegen*******/
    public function createQuizAction()
    {
        $quizform = new Application_Form_CreateQuizForm();
        $qbankuserquiz = new Application_Model_DbTable_Userquizqb();


        $this->view->form = $quizform;
        $storage = new Zend_Auth_Storage_Session();
        $data =  $storage->read();

        $currentuserid = $data->id;

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($quizform->isValid($formData)) {

                //$id = (int)$quizform->getValue('quizid');
                $quiztitle = $quizform->getValue('quiztitle');

                $url = $quizform->getValue('urlextensienaam');
                $quizqbtrans = new Application_Model_DbTable_Quiztranslationqb();
                $quizqb = new Application_Model_DbTable_Quizqb();
                $quizqb->saveQuizQB($url,1);


                $quizinsertedid= $quizqb->getAdapter()->lastInsertId('qbank_quiz');
                $quizqbtrans->saveQuiztranslationQB($quizinsertedid, $quiztitle,1);
                $qbankuserquiz->SaveUserIdAndQuizId($currentuserid,$quizinsertedid);

                $this->redirect('/Index/home');
            } else {
                $quizform->populate($formData);
            }
        }
    }
    /*******END createQuizAction*******/

}