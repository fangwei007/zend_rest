<?php

class UserController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        // action body
    }

    public function loginAction() {
        try {

            $loginForm = new Application_Form_Login();
            $this->view->form = $loginForm;

            if ($loginForm->isValid($_POST)) {
                $input = $loginForm->getValues();
                $users = new Application_Model_User();
                if ($users->verifyUser($input['email'], $input['password'])) {
                    $input['email'] . '<br>';
                    $users->setSession($input['email']);
                    $this->_redirect('user/dashboard');
                } else {
                    $this->view->errorMessage = "Email/Password is invalid!!";
                    return;
                }
            }
        } catch (Exception $ex) {
            echo "error: " . $ex->getMessage() . " at line: " . $ex->getLine() . "<br/>";
        }
    }

    public function logoutAction() {
        //action code here
    }

    public function registerAction() {
        try {

            $registerForm = new Application_Form_Register();
            $users = new Application_Model_User();
            $this->view->form = $registerForm;
            if ($registerForm->isValid($_POST)) {
                $input = $registerForm->getValues();
//                var_dump($input);
                if ($input['Password'] !== $input['pwd_conf']) {
                    $this->view->errorMessage = "Password and password confirm don't match.";
                    return;
                }
                unset($input['pwd_conf']);
                $input['CreatedOn'] = date('Y-m-d H:i:s', time());
                $input['Ip'] = $_SERVER['REMOTE_ADDR'];
//                var_dump($input);
                $users->insert($input);
                echo $users->setSession($input['Email']);
                if (Zend_Session::sessionExists()) {
                    $this->_redirect('user/dashboard');
                }
                $this->_redirect('user/login');
            }
        } catch (Exception $ex) {
            echo "error: " . $ex->getMessage() . " at line: " . $ex->getLine() . "<br/>";
        }
    }

    public function dashboardAction() {
        //这辈子都要记住这个函数，妈的目前可行的用session方法
        Zend_Session::start();
        try {

            if (Zend_Session::sessionExists()) {
                $session = Zend_Session::namespaceGet('auth');
                var_dump($session);
                echo "Welcome " . $session['email'];
            }
        } catch (Exception $e) {
            echo $e->getLine() . $e->getMessage();
        }
        $this->_helper->viewRenderer->setNoRender();
    }

}
