<?php
header('Content-Type:text/html;charset=utf-8'); //定义字符集
// ini_set('error_reporting', E_ALL);
// error_reporting(E_ALL);
// $httpHost = $_SERVER['HTTP_HOST'];
// var_dump($httpHost);
// echo '<br />';

// $httpGetVars = $_SERVER['HTTP_GET_VARS'];
// var_dump($httpGetVars);
// echo '<br />';

// $requestUri = $_SERVER['REQUEST_URI'];
// var_dump($requestUri);

defined('ROOT_PATH') || define('ROOT_PATH', realpath(dirname(__FILE__))); //定义根目录: /home/xiqiyanyan/www/mvc 
defined('BASE_PATH') || define('BASE_PATH', realpath(ROOT_PATH . '/../Base')); //定义本框架基本类库目录(不包括/) 
defined('APP_PATH') || define('APP_PATH', realpath(ROOT_PATH . '/../App')); //定义应用根目录
defined('STATIC_URL') || define('STATIC_URL', 'http://res.mvc.com'); // 定义静态文件（css、js、样式图片、flash等）的url路径(不包括/)

defined('DEBUG') || define('DEBUG', true); // 是否开启调试模式

require_once BASE_PATH . '/AutoLoadClass.php';

$app = new BApp();
$app->run();
