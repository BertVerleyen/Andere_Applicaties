<?php

class Application_Form_CreateQuizForm extends Zend_Form
{

    public function init()
    {
        $this->setMethod('POST');

        $quizid = $this->createElement('hidden','quizid');
        $quizid->addFilter('Int');


        $quiztitle=$this->createElement('text','quiztitle');
        $quiztitle->setLabel('Quiztitle')->setAttrib('maxlength',75)

            ->setRequired(true)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')

            ->setRequired(true);






        $urlextensie=$this->createElement('text','urlextensienaam');
        $urlextensie->setLabel('urlName') ->setAttrib('maxlength',75)


            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty')

            ->setRequired(true);


        $urlextensie->setLabel('urlName')
        ->addPrefixPath('My_Form', 'My/Form/')
        ->setDecorators(array(
            'Label',
            array(array('before'=>'PlainText'), array('text' => 'http://su.vc/')),
            'ViewHelper'
        ));






        $create=$this->createElement('submit','create');
        $create->setLabel("create")->setIgnore(true);



        $this->addElements(array($quiztitle,$urlextensie,$create));





    }





}

class My_Form_Decorator_PlainText extends Zend_Form_Decorator_Abstract
{
    public function render($content)
    {
        return $content . $this->getOption('text');
    }
}


