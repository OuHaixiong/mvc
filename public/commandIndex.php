<?php

set_time_limit(0); //设置运行不超时，命令行默认也是不超时
// ini_set('max_execution_time', 0); // ini_get('max_execution_time')

// ini_set('session.cookie_path', '/'); // 设置cookie保存在跟目录
// ini_set('session.cookie_domain', '.mvc.com'); // cookie保存在主域下
// ini_set('session.cookie_lifetime', '1800'); // 设置cookie的生命周期（时间）
// 上面三句是跨子域，保存cookie
header('Content-Type:text/html;charset=utf-8'); //定义字符集

if (isset($argv[1])) { // 命令行的参数都包含在$argv变量中
    unset($argv[0]);
    $parameters = array();
    foreach ($argv as $a) {
        $casual = explode('=', $a);
        if (count($casual) > 1) {
            $parameters[$casual[0]] = $casual[1];
        }
    }
    // 规定r(route)参数为路由
    if (isset($parameters['r'])) {
        $_SERVER['REQUEST_URI'] = $parameters['r']; // /product/createIndex
        unset($parameters['r']);
        $_GET = $parameters;
    } else {
        echo '请输入r参数。r参数类似：r=/product/createIndex' . "\n";exit;
    }
} else {
   echo '请至少输入一个参数：请求的controller/action' . "\n";die();
}

defined('ROOT_PATH') || define('ROOT_PATH', realpath(dirname(__FILE__))); //定义根目录(最后不包含/): /home/xiqiyanyan/www/mvc 
defined('BASE_PATH') || define('BASE_PATH', realpath(ROOT_PATH . '/../Base')); //定义本框架基本类库目录(不包括/) 
defined('APP_PATH') || define('APP_PATH', realpath(ROOT_PATH . '/../App')); //定义应用根目录
defined('IMG_PATH') || define('IMG_PATH', realpath(ROOT_PATH . '/../../img')); // 定义上传图片的目录
defined('CONFIG_PATH') || define('CONFIG_PATH', ROOT_PATH . '/../../Configs'); // 定义config文件的目录(不包括/)
defined('STATIC_URL') || define('STATIC_URL', 'http://res.mvc.com'); // 定义静态文件（css、js、样式图片、flash等）的url路径(不包括/)
defined('IMG_URL') || define('IMG_URL', 'http://img.mvc.com'); // 定义图片服务器的url路径(不包括/)
defined('DEBUG') || define('DEBUG', true); // 是否开启调试模式

if (DEBUG) { // 报所有错误
    ini_set('error_reporting', E_ALL);
    error_reporting(E_ALL);
} else { // 不报任何错误
    ini_set('error_reporting', 0);
    error_reporting(0);
}

require_once BASE_PATH . '/AutoLoadClass.php';

// 保存session进redis
// $masterRedis = BConfig::getConfig('master_redis');
// ini_set('session.save_handler', 'redis');
// if (isset($masterRedis['password'])) {
//     ini_set('session.save_path', "tcp://{$masterRedis['host']}:{$masterRedis['port']}?auth={$masterRedis['password']}");    
// } else {
//     ini_set('session.save_path', "tcp://{$masterRedis['host']}:{$masterRedis['port']}");
// }

// 启动应用
$app = new BApp();
$app->run();
