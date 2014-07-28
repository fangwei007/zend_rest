<?php

class ServiceController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {
        // action body
    }

    public function testDbAction() {
        try {
            require_once APPLICATION_PATH . '/models/Db.php';
            $db = Db::conn();

            $data = array(
                'title' => 'Harry Poter'
            );

            $db->insert('books', $data);
            $id = $db->lastInsertId();
        } catch (Exception $ex) {
            $ex->getMessage();
        }

        $this->view->id = $id;
    }

    public function testConnAction() {
        try {
            //use database config in application.in
            $dbAdapter = Zend_Db_Table::getDefaultAdapter();
            $data = array(
                'title' => 'Harry Poter'
            );
            $dbAdapter->insert('books', $data);
            $id = $dbAdapter->lastInsertId();
//            $dbAdapter = Zend_Db_Table::getDefaultAdapter();
//            $table = 'books';
//            $result = $dbAdapter->fetchAll($dbAdapter->select()->from($table));
//            print_r($result);
        } catch (Zend_Db_Exception $ex) {
            echo $ex->getMessage();
        }
        $this->view->id = $id;
    }

    public function restDataAction() {
        require_once APPLICATION_PATH . '/models/WebServices.php';
        $server = new Zend_Rest_Server();
        $server->setClass('WebServices');
        $server->handle(array('method' => 'getNews'));

        $this->_helper->viewRenderer->setNoRender();
    }

    public function restClientAction() {
        $url = "http://127.0.0.1:8888/zend_rest/public/service/rest-data";
        $Client = new Zend_Rest_Client($url);
        try {
            $json = json_encode(array('id' => 1, 'title' => 'magic'));
            $results = $Client->restPost('', $json);
            echo $results;
        } catch (Zend_Service_Exception $e) {
            echo $e->getMessage();
        }

        //Suppress the view
        $this->_helper->viewRenderer->setNoRender();
    }

    public function newsAction() {
        try {
            //use database config in application.in
            $dbAdapter = Zend_Db_Table::getDefaultAdapter();
            $data = array(
                'title' => 'Harry Poter'
            );
            $dbAdapter->insert('books', $data);
            $id = $dbAdapter->lastInsertId();
        } catch (Zend_Db_Exception $ex) {
            echo $ex->getMessage();
        }
    }

    public function showNewsAction() {
        $url = "http://127.0.0.1:8888/zend_rest/public/service/rest-data";
        $Client = new Zend_Rest_Client($url);
        try {

            $results = $Client->get();
            print_r($results->response());
            echo '<br/>';
            $arr = json_decode($results->response());
            print_r($arr);
            echo '<br/>';
            foreach ($arr as $news) {
                echo $news->id . ' ' . $news->title . '<br/>';
            }
        } catch (Zend_Service_Exception $e) {
            echo $e->getMessage();
        }

        //Suppress the view
        $this->_helper->viewRenderer->setNoRender();
    }

    public function testYoutubeAction() {
        Zend_Loader::loadClass("Zend_Gdata_YouTube");

        try {
            $YouTube = new Zend_Gdata_YouTube();

            //Get the specific video
//            $video = $YouTube->getVideoEntry("4JZhGYrgCPg");
//            $this->view->video = $video;
            $query = $YouTube->newVideoQuery();
            $query->category = 'Game';
//            echo $query->queryUrl . "\n";
//            $videoFeed = $YouTube->getVideoFeed($query);
//            $videoFeed = $YouTube->getTopRatedVideoFeed();
            $videoFeed = $YouTube->getUserUploads('jobs');
//            $videoFeed = $YouTube->getUserFavorites('jobs');
            $this->view->videos = $videoFeed;
        } catch (Zend_Service_Exception $e) {
            echo $e->getMessage();
        }
    }

    public function uploadYoutubeAction() {
//        $authenticationURL = 'https://www.google.com/accounts/ClientLogin';
//        $httpClient = Zend_Gdata_ClientLogin::getHttpClient(
//                        $username = 'fangwei4608@gmail.com', $password = 'f87548221', $service = 'youtube', $client = null, $source = '', // a short string identifying your application
//                        $loginToken = null, $loginCaptcha = null, $authenticationURL);
    }
    
//    public function openGL() {
//        //very powerful for building games 
//        $array = array('a','b','c');
//        $me = new ArrayObject($array);
//        var_dump($me);        
//    }

}
