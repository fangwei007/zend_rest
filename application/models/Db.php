<?php

class Db
{
   public static function conn()
    {
        $connParams = array("host" => "localhost",
                "port" => "8889",
                "username" => "root",
                "password" => "root",
                "dbname" => "zend"
        );
        $db = new Zend_Db_Adapter_Pdo_Mysql($connParams);
        return $db;
    }
}
