<?php

// 有些帮助类，可以命名为：XXXHelper.php
set_time_limit(60); // 指定了当前所在php脚本的最大执行时间为60秒
ini_set('max_execution_time', 60); // 一定要在脚本中设置最大超时时间，不要删这里两行

ini_set('session.cookie_path', '/'); // 设置cookie保存在跟目录
ini_set('session.cookie_domain', '.mvc.com'); // cookie保存在主域下
ini_set('session.cookie_lifetime', '1800'); // 设置cookie的生命周期（时间）
// 上面三句是跨子域，保存cookie
header('Content-Type:text/html;charset=utf-8'); //定义字符集
header("Cache-Control: no-store, no-cache, must-revalidate"); // 定义不缓存页面

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

defined('ROOT_PATH') || define('ROOT_PATH', realpath(dirname(__FILE__))); //定义根目录(最后不包含/): /home/xiqiyanyan/www/mvc/public 
defined('BASE_PATH') || define('BASE_PATH', realpath(ROOT_PATH . '/../Base')); //定义本框架基本类库目录(不包括/) ，这里如果是多个项目公用一个框架时，是可以外移的
defined('APP_PATH') || define('APP_PATH', realpath(ROOT_PATH . '/../App')); //定义应用根目录
defined('IMG_PATH') || define('IMG_PATH', realpath(ROOT_PATH . '/../../img')); // 定义上传图片的目录
defined('CONFIG_PATH') || define('CONFIG_PATH', ROOT_PATH . '/../../mvcConfigs'); // 定义config文件的目录(不包括/)
defined('STATIC_URL') || define('STATIC_URL', 'http://res.mvc.com'); // 定义静态文件（css、js、样式图片、flash等）的url路径(不包括/)
defined('IMG_URL') || define('IMG_URL', 'http://img.mvc.com'); // 定义图片服务器的url路径(不包括/)

require_once BASE_PATH . '/BAutoLoad.php';

// require(__DIR__ . '/../../common/AutoLoader.php'); // 注册第三方类库

// 保存session进redis
$masterRedis = BConfig::getConfig('master_redis');
ini_set('session.save_handler', 'redis');
if (isset($masterRedis['password'])) {
    ini_set('session.save_path', "tcp://{$masterRedis['host']}:{$masterRedis['port']}?auth={$masterRedis['password']}");    
} else {
    ini_set('session.save_path', "tcp://{$masterRedis['host']}:{$masterRedis['port']}");
}
session_start();

// 设置错误信息处理函数；
set_error_handler(array('BLog', 'errorHandler'), E_ALL);
// 静态方法就可以在数组中直接写类名，否则需要new出来塞对象

// 启动应用
$app = new BApp();
$app->run();
