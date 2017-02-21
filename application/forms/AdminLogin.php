<?php

class Application_Form_AdminLogin extends Zend_Form
{

    public function init()
    {



        $this->setMethod('POST');
        $username=$this->createElement('text','username');
        $username->setLabel('Username')->setAttrib('maxlength',75);

        $password=$this->createElement('password','password');
        $password->setLabel('password:')->setAttrib('maxlength',75);

        $signin=$this->createElement('submit','signin');
        $signin->setLabel("sign in")->setIgnore(true);



        $this->addElements(array($username,$password,$signin));






    }


}




