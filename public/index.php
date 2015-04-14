<?php
header('Content-Type:text/html;charset=utf-8'); //定义字符集
// $httpHost = $_SERVER['HTTP_HOST'];
// var_dump($httpHost);
// echo '<br />';

// $httpGetVars = $_SERVER['HTTP_GET_VARS'];
// var_dump($httpGetVars);
// echo '<br />';

// $requestUri = $_SERVER['REQUEST_URI'];
// var_dump($requestUri);

defined('ROOT_PATH') || define('ROOT_PATH', realpath(dirname(__FILE__))); //定义根目录: /home/xiqiyanyan/www/mvc 
defined('CORE_PATH') || define('CORE_PATH', realpath(ROOT_PATH . '/../Core')); //定义本框架基本类库目录(不包括/) 
defined('APP_PATH') || define('APP_PATH', realpath(ROOT_PATH . '/../App')); //定义应用根目录

require_once CORE_PATH . '/AutoLoadClass.php';

$app = new CApp();
$app->run();
