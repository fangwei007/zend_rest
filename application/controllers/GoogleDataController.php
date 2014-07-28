<?php

class GoogleDataController extends Zend_Controller_Action
{

    private $email = 'wayne@ralphandco.com';

    private $password = 'f87549221';

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function youtubeAction()
    {
        Zend_Loader::loadClass("Zend_Gdata_YouTube");
        try {
            $yt = new Zend_Gdata_YouTube();

            //get single video by its ID
//            $video = $yt->getVideoEntry("4JZhGYrgCPg");
//            $this->view->video = $video;
            //retrieve videos by category
            $query = $yt->newVideoQuery();
            if (isset($_GET)) {
                $query->category = $_GET['input'];
            }
            $videos = $yt->getVideoFeed($query);

            //by normal options
//            $videos = $YouTube->getTopRatedVideoFeed();
            //by user info
//            $videos = $yt->getUserUploads('jobs');
//            $videos = $yt->getUserFavorites('jobs');
            $form = new Application_Form_Api();

            $this->view->form = $form;
            $this->view->videos = $videos;
        } catch (Exception $ex) {
            echo "There is an error: " . $ex->getMessage() . " at line: " . $ex->getLine() . "<br>";
        }
    }

    public function analyticsAction()
    {
        try {
            $service = Zend_Gdata_Analytics::AUTH_SERVICE_NAME;
            $form = new Application_Form_Analytics();
            $this->view->form = $form;
            if (isset($_POST['search'])) {
                $client = Zend_Gdata_ClientLogin::getHttpClient($_POST['email'], $_POST['password'], $service);
                $analytics = new Zend_Gdata_Analytics($client);


                //retrieving account data
                $accounts = $analytics->getAccountFeed();

//                foreach ($accounts as $account) {
//                    echo "{$account->title}<br>";
//                }

                $this->view->accounts = $accounts;

//                //retrieving report data --debugging
//                $query = $service->newDataQuery()->setProfileId(84010742)
//                        ->addMetric(Zend_Gdata_Analytics_DataQuery::METRIC_BOUNCES)
//                        ->addMetric(Zend_Gdata_Analytics_DataQuery::METRIC_VISITS)
//                        ->addDimension(Zend_Gdata_Analytics_DataQuery::DIMENSION_MEDIUM)
//                        ->addDimension(Zend_Gdata_Analytics_DataQuery::DIMENSION_SOURCE)
//                        ->addFilter("ga:browser==Chrome")
//                        ->setStartDate('2011-05-01')
//                        ->setEndDate('2015-05-31')
//                        ->addSort(Zend_Gdata_Analytics_DataQuery::METRIC_VISITS, true)
//                        ->addSort(Zend_Gdata_Analytics_DataQuery::METRIC_BOUNCES, true)
//                        ->setMaxResults(50);
//                $result = $analytics->getDataFeed($query);
//                foreach ($result as $row) {
//                    echo $row->getMetric('ga:visits') . "\t";
//                    echo $row->getValue('ga:bounces') . "\n";
//                }
//                $this->view->result = $result;
            }
//            }
//            $this->_helper->viewRenderer->setNoRender();
        } catch (Exception $ex) {
            echo "There is an error: " . $ex->getMessage() . " at line: " . $ex->getLine() . "<br>";
        }
    }

    public function calendarAction()
    {
        $service = Zend_Gdata_Calendar::AUTH_SERVICE_NAME;
        $form = new Application_Form_Analytics();
        $this->view->form = $form;
        if (isset($_POST['search'])) {
            $email = $_POST['email'];
//$this->email;
            $password = $_POST['password'];
//$this->password;
            //create an authenticated http client
            $client = Zend_Gdata_ClientLogin::getHttpClient($email, $password, $service);

            //create an instance of the calendar service
            $calendar = new Zend_Gdata_Calendar($client);

            try {
                $listFeed = $calendar->getCalendarListFeed();
                $this->view->listFeed = $listFeed;

                //create an event
                $event = $calendar->newEventEntry();


                $event->title = $calendar->newTitle("My Event");
//            echo 'here';
                $event->where = array($calendar->newWhere("NYC, NY, United States"));
                $event->content = $calendar->newContent("This is my awesome event. RSVP required.");

                $startDate = "2014-05-01";
                $startTime = "14:00";
                $endDate = "2014-05-01";
                $endTime = "16:00";
                $tzOffset = "-08";

                $when = $calendar->newWhen();
                $when->startTime = "{$startDate}T{$startTime}:00.000{$tzOffset}:00";
                $when->endTime = "{$endDate}T{$endTime}:00.000{$tzOffset}:00";
                $event->when = array($when);
//            var_dump($event);

                $calendar->insertEvent($event);

                $listFeed2 = $calendar->getCalendarListFeed();
                $this->view->listFeed = $listFeed2;
            } catch (Exception $ex) {
                echo "There is an error: " . $ex->getMessage() . " at line: " . $ex->getLine() . "<br>";
            }
        }
    }

    public function documentsListDataAction()
    {
        // action body
    }

    public function spreadsheetsAction()
    {
        // action body
    }

    public function picasaWebAlbumsAction()
    {
        // action body
    }

    public function bookSearchAction()
    {
        try {
            $form = new Application_Form_Api();
            $this->view->form = $form;

            //retrieve books
            $books = new Zend_Gdata_Books();
            $query = $books->newVolumeQuery();

            if (isset($_GET['search']) && $_GET['input'] != null) {
                $query->setQuery($_GET['input']);
            } else {
                $query->setQuery('harry poter');
            }
//            $query->setQuery('harry poter');
            $query->setMinViewability('partial_view');

            $feed = $books->getVolumeFeed($query);
            $this->view->feed = $feed;

//            foreach ($feed as $entry) {
//                echo "id: " . $entry->getVolumeId();
//                echo "  title: " . $entry->getTitle() . "<br>";
////                echo "  view ability: ".$entry->getViewability();
//            }
            //adding a rating --debugging
//            $item = new Zend_Gdata_Books_VolumeEntry();
//            $item->setId(new Zend_Gdata_App_Extension_Id(VOLUME_ID));
//            $item->setRating(new Zend_Gdata_Extension_Rating(3, 1, 5, 1));
//            $items->insertVolume($item, Zend_Gdata_Books::MY_ANNOTATION_FEED_URI);
//
//            //book collections and my library
//            //retrieving all books in a user's library --debugging
//            $feed = $books->getUserLibraryFeed();
////            var_dump($feed);
//
//            $query = $books->newVolumeQuery(
//                    'http://www.google.com/books/feeds/users/' .
//                    'me/collections/library/volumes');
//            $query->setCategory('favorites');
//            $feed = $books->getVolumeFeed($query);
//            var_dump($feed);
        } catch (Exception $ex) {
            echo "There is an error: " . $ex->getMessage() . " at line: " . $ex->getLine() . "<br>";
        }
    }

    public function geoAction()
    {
        // action body
    }

    public function flickrAction()
    {
        try {
            $flickr = new Zend_Service_Flickr('573a545285a6aefd33ab5ac98ee624cc');
            $form = new Application_Form_Api();
            $this->view->form = $form;

            //Get the photos by the user. Find the user by the email.
//            $photos = $flickr->tagSearch($_GET['input']); //$flickr->userSearch('fangwei007@yahoo.com.cn');
            if (isset($_GET['search']) && $_GET['input'] != null) {
                $photos = $flickr->tagSearch($_GET['input']);
            } else {
                $photos = $flickr->tagSearch('zend');
            }
            $this->view->photos = $photos;
        } catch (Exception $ex) {
            echo "There is an error: " . $ex->getMessage() . " at line: " . $ex->getLine() . "<br>";
        }
    }

    public function amazonAction()
    {
        try {

            $amazon = new Zend_Service_Amazon('AKIAITX37YRUAQSKMIXQ', 'FR', 'CxaCNPy8v/wzKt75E6lTzebYYvS4AizRENXxTZ/h');
            $results = $amazon->itemLookup("1430218258", array('Condition' => 'Used',
                'AssociateTag' => 'ralph',
                'Publisher' => 'Apress',
                'ResponseGroup' =>
                'Small,Similarities,Reviews,EditorialReview'));
            echo "<b>" . $results->Title . "</b><br>";
        } catch (Zend_Service_Exception $e) {
            throw $e;
        }
        $this->_helper->viewRenderer->setNoRender();
    }

    public function amazonMultiAction()
    {
        try {
            $form = new Application_Form_Api();
            $this->view->form = $form;


            $amazon = new Zend_Service_Amazon('AKIAITX37YRUAQSKMIXQ', 'FR', 'CxaCNPy8v/wzKt75E6lTzebYYvS4AizRENXxTZ/h');
            $key = (isset($_GET) && $_GET['input'] != null) ? $_GET['input'] : 'ralph';
            $results = $amazon->itemSearch(array('SearchIndex' => 'Books',
//                    'Keywords' => 'ralph',
                'Keywords' => $key,
                'AssociateTag' => 'ralph',
                'Condition' => 'All',
//         			'Sort' => 'titlerank',
//         			'Publisher' => 'Apress',
                'ItemPage' => '2',
                'ResponseGroup' => 'Small,Similarities,Reviews, EditorialReview'));
            $this->view->results = $results;
//            foreach ($results as $result) {
//                echo '<br>' . $result->Title . '<br>';
//
//                //Fetch the Customer Reviews and display the content. 
//                $customerReviews = $result->CustomerReviews;
//                if (empty($customerReviews)) {
//                    echo "No customer reviews.<br>";
//                } else {
//                    foreach ($result->CustomerReviews as $customerReview) {
//                        echo "Review Summary: " . $customerReview->Summary . "...<br>";
//                    }
//                }
//
//                $similarProduct = $result->SimilarProducts;
//
//                if (empty($similarProduct)) {
//                    echo "No recommendation.";
//                } else {
//                    foreach ($similarProduct as $similar) {
//                        echo "Recommended Books:" . $similar->Title . "<br>";
//                    }
//                }
//                echo "<br><br>";
//            }
        } catch (Zend_Service_Exception $e) {
            throw $e;
        }
        echo "<br>";
        echo "Total Books: " . $results->totalResults();
        echo "<br>";
        echo "Total Pages: " . $results->totalPages();
//        $this->_helper->viewRenderer->setNoRender();
    }

    public function rssAction()
    {
        //Load the RSS document
        try {

            $form = new Application_Form_Api();
            $this->view->form = $form;
            if (isset($_GET['search']) && $_GET['input'] != null) {
                $url = $_GET['input'];
            } else {
                $url = "http://www.aweber.com/blog/feed/";
            }
            $feed = Zend_Feed::import($url);

            $rssFeedAsString = '<?xml version="1.0"?> <rss version="2.0">
        	<channel>
        	<title>My Music Web Site Home Page</title> 
        	<link>http://www.ralph.com</link>
        	<description>Weekly articles diving head first into the gossip,
new releases, concert dates, and anything related to the music industry around the world. </description>
<!-- Cache for 3 hours --> <ttl>180</ttl>
<!-- Set the copyright info --> <copyright>Music News 2008</copyright>
<!-- Set the language info --> <language>English</language>
<category>Music</category> <pubDate>October 03, 2008</pubDate>
<!-- Start list of articles --> <item>
<author>fuglymaggie@ficticiousexample.com</author> <enclosure url="" type="" />
<title>Criss Cross, now 35, continue wearing pants backward
to look cool.</title>
<link>http://www.ralph.com/full link to your article</link> <description>Rap duo, Criss Cross continue to wear pants backward
after repeated attemps to inform them, the 90s are over...let it go...let it go. </description>
</item> <item>
<author>someeditor@ficticiousexample.com</author>
<enclosure url="" type="" />
<title>New PWG LP released!</title> <link>htp://www.ralph.com/link to this articles page</link> <description>The new Puppies Wearing Glasses LP has hit the street.
First slated for October 3rd its now officially out. </description> </item>
</channel> </rss>';
//            $feed = Zend_Feed::importString($rssFeedAsString);
            //Parse and store the RSS data. 
            $this->view->title = $feed->title();
            $this->view->link = $feed->link();
            $this->view->description = $feed->description();
            $this->view->ttl = $feed->ttl();
            $this->view->copyright = $feed->copyright();
            $this->view->language = $feed->language();
            $this->view->category = $feed->category();
            $this->view->pubDate = $feed->pubDate();
            //Get the articles
            $articles = array();
            foreach ($feed as $article) {
                $articles[] = array(
                    "title" => $article->title(),
                    "description" => $article->description(),
                    "link" => $article->link(),
                    "author" => $article->author(),
                    "enclosure" =>
                    array("url" => $article->enclosure['url'],
                        "type" => $article->enclosure['type']));
            }
            $this->view->articles = $articles;
        } catch (Zend_Feed_Exception $ex) {
//            throw $ex;
            echo "There is an error: " . $ex->getMessage() . " at line: " . $ex->getLine() . "<br>";
            //Parse and store the RSSdata
        }
    }

    public function restServerAction()
    {
        require_once APPLICATION_PATH . '/models/WebServices.php';
        $server = new Zend_Rest_Server();
        $server->setClass('WebServices');
        $server->handle(array('method' => 'getResponse'));

        $this->_helper->viewRenderer->setNoRender();
    }

    public function restClientAction()
    {
        $url = "http://127.0.0.1:8888/zend_rest/public/GoogleData/rest-server";
        $Client = new Zend_Rest_Client($url);
        try {

            $results = $Client->get();
//            print_r($results->response());
//            echo '<br/>';
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

    public function twitterAction()
    {
        // action body
    }


}


