<?php

class Db_Pdo extends PDO
{
    public function __construct() ($dsn, $username, $password, array $driver_options = array(), $charset = 'utf8') {
        $db = new PDO('mysql:host=myhost;dbname=mydb', 'login', 'password', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
    }
    
    $con = new PDO("mysql:dbname=dbname;host=some.ip", "user", "pass", array(
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
    ));
    
    $dsn = 'mysql:host=localhost;dbname=testdb';
    $username = 'username';
    $password = 'password';
    $options = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    );
    
    $dbh = new PDO($dsn, $username, $password, $options);
    
    
}
