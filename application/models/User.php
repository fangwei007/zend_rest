<?php

class Application_Model_User extends Zend_Db_Table {

    protected $_name = 'users';

    public function verifyUser($email, $password) {
        $query = $this->_db->select()->from($this->_name)->where('Email=?', $email)->where('Password=?', $password);
        $result = $this->getAdapter()->fetchOne($query);

        if ($result) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function setSession($email) {

        //here mainly set a session, but how to use it between actions?
        $query = $this->_db->select()->from($this->_name)->where('Email=?', $email);
        $result = $this->getAdapter()->fetchRow($query);
        var_dump($result);echo '<br>';
        try {
            $session = new Zend_Session_Namespace('auth');
            $session->id = $result['UserId'];
            $session->email = $result['Email'];
            $session->logged_in = true;

            echo $session->id;
            return 1;
        } catch (Exception $e) {
            echo $e->getLine();
        }
        return 0;
    }

    public function checkUnique($username) {
        $select = $this->_db->select()
                ->from($this->_name)
                ->where('username=?', $username);
        $result = $this->getAdapter()->fetchOne($select);
        if ($result) {
            return true;
        }
        return false;
    }

}
