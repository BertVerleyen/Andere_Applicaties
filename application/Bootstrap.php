<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');

        $view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");
        $view->jQuery()->addStylesheet('/js/jquery/css/ui-lightness/jquery-ui-1.10.4.custom.css')
            ->setLocalPath('/js/jquery/js/jquery-1.10.2.js')
            ->setUiLocalPath('/js/jquery/js/jquery-ui-1.10.4.custom.min.js');

        $view->jQuery()->enable();
        $view->jQuery()->uiEnable();


        //elasticsearch
        require 'C:/xampp/htdocs/stage/vendor/autoload.php';

        $client = new Elasticsearch\Client();


    }



    protected function _initRoutes()
    {
       /* $router = Zend_Controller_Front::getInstance()->getRouter();
        include APPLICATION_PATH . "/configs/routes.php";
        include _PATH . '/var/www/surveyanyplace/stage/application/../library:/var/www/surveyanyplace/stage/library:.:/usr/share/php:/usr/share/pear';


        $router->addRoute('indexpagina1',
            new Zend_Controller_Router_Route('Index/index/id/:id', array(
                    'module'     => 'default',
                    'controller' => 'Index',
                    'action'     => 'index',
                    'id'     => ':id'
                )
            ));*/

    }

}

