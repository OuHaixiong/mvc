<?php
header('Content-Type:text/html;charset=utf-8'); //定义字符集
defined('ROOT_PATH') || define('ROOT_PATH', realpath(dirname(__FILE__))); //定义根目录(最后不包含/): /home/xiqiyanyan/www/mvc

/*
var_dump($_SERVER['REMOTE_ADDR']);
var_dump($_COOKIE);
var_dump($_SERVER["HTTP_USER_AGENT"]);
echo '<br />
  下面是代理访问的：  <br />';
var_dump(isset($_SERVER['HTTP_X_FORWARDED_FOR']));
var_dump(isset($_SERVER['HTTP_VIA']));
var_dump(isset($_SERVER['HTTP_PROXY_CONNECTION']));
var_dump(isset($_SERVER['HTTP_USER_AGENT_VIA']));
var_dump(isset($_SERVER['HTTP_CACHE_INFO']));
var_dump(isset($_SERVER['HTTP_PROXY_CONNECTION'])); // 有这些变量代表是代理访问过来的

// setcookie('abc', 158);
exit; */

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

 
defined('BASE_PATH') || define('BASE_PATH', realpath(ROOT_PATH . '/../Base')); //定义本框架基本类库目录(不包括/) 
defined('APP_PATH') || define('APP_PATH', realpath(ROOT_PATH . '/../App')); //定义应用根目录
defined('STATIC_URL') || define('STATIC_URL', 'http://res.mvc.com'); // 定义静态文件（css、js、样式图片、flash等）的url路径(不包括/)
defined('IMG_URL') || define('IMG_URL', 'http://img.mvc.com'); // 定义图片服务器的url路径(不包括/)

defined('DEBUG') || define('DEBUG', true); // 是否开启调试模式

require_once BASE_PATH . '/AutoLoadClass.php';

$app = new BApp();
$app->run();
