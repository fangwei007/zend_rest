<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
        $fb = new Facebook_Facebook($config);
//        $fb->require_login();
//        $facebook = new Facebook_Facebook($config);
    }


}

