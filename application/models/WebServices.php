<?php

/**
 * WebServices.php
 * Containst full logic for web services
 * 
 * @auther
 */
class WebServices {

    /**
     * Return a single aritst
     * 
     * @return SimpleXML
     */
    public function getArtists() {
        $xml = '<?xml version="1.0" standalone="yes"?><response>';
        $xml .= '<artists><artist><name>Poison</name>';
        $xml .= '<genre>Rock</genre></artist></artists>';
        $xml .= '</response>';

        return simplexml_load_string($xml);
    }

    public function getResponse() {
        $xml = <<<EOD
<?xml version="1.0" encoding="utf-8"?>
<!-- generator="Technorati API version 1.0 /bloginfo" -->
<!DOCTYPE tapi PUBLIC "-//Technorati, Inc.//DTD TAPI 0.02//EN"
                      "http://api.technorati.com/dtd/tapi-002.xml">
<tapi version="1.0">
    <document>
        <result>
            <url>http://pixelated-dreams.com</url>
            <weblog>
                <name>Pixelated Dreams</name>
                <url>http://pixelated-dreams.com</url>
                <author>
                    <username>DShafik</username>
                    <firstname>Davey</firstname>
                    <lastname>Shafik</lastname>
                </author>
                <rssurl>
                    http://pixelated-dreams.com/feeds/index.rss2
                </rssurl>
                <atomurl>
                    http://pixelated-dreams.com/feeds/atom.xml
                </atomurl>
                <inboundblogs>44</inboundblogs>
                <inboundlinks>218</inboundlinks>
                <lastupdate>2006-04-26 04:36:36 GMT</lastupdate>
                <rank>60635</rank>
            </weblog>
            <inboundblogs>44</inboundblogs>
            <inboundlinks>218</inboundlinks>
        </result>
    </document>
</tapi>
EOD;
        $json = <<<EOD
{
    "glossary": {
        "title": "example glossary",
		"GlossDiv": {
            "title": "S",
			"GlossList": {
                "GlossEntry": {
                    "ID": "SGML",
					"SortAs": "SGML",
					"GlossTerm": "Standard Generalized Markup Language",
					"Acronym": "SGML",
					"Abbrev": "ISO 8879:1986",
					"GlossDef": {
                        "para": "A meta-markup language, used to create markup languages such as DocBook.",
						"GlossSeeAlso": ["GML", "XML"]
                    },
					"GlossSee": "markup"
                }
            }
        }
    }
EOD;
//            return simplexml_load_string($xml);
//            $json = json_encode(simplexml_load_string($xml));
        return json_encode($json);
    }

    public function getNews() {
        try {
            //use database config in application.in
            $dbAdapter = Zend_Db_Table::getDefaultAdapter();
            $table = 'books';
            $result = $dbAdapter->fetchAll($dbAdapter->select()->from($table));
//            print_r($result);
            
            
        } catch (Zend_Db_Exception $ex) {
            echo $ex->getMessage();
        }
        return json_encode($result);
    }

}
