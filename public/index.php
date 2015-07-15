<?php
header('Content-Type:text/html;charset=utf-8'); //定义字符集
defined('ROOT_PATH') || define('ROOT_PATH', realpath(dirname(__FILE__))); //定义根目录: /home/xiqiyanyan/www/mvc


// var_dump(123);exit;
/*
$logFilePath = ROOT_PATH . '/data/log/';//日志记录文件保存目录
$fileht = ROOT_PATH . '/data/.htaccess2';//被禁止的ip记录文件
$allowtime=60;//防刷新时间
$allownum=5;//防刷新次数
$allowRefresh=120;//在允许刷新次数之后加入禁止ip文件中

if(!file_exists($fileht)){
    file_put_contents($fileht,'');
}
$filehtarr = file($fileht);//var_dump($filehtarr);exit;
if(in_array($ip."\r\n",$filehtarr)){
    exit('警告：你的IP已经被禁止了！');
}
//加入禁止ip
$time = time();
$fileforbid=$logFilePath.'forbidchk.dat';
if(file_exists($fileforbid)){
    if($time-filemtime($fileforbid)>30){
        unlink($fileforbid);
    } else {
        $fileforbidarr = file($fileforbid);
        if($ip == substr($fileforbidarr[0], 0, strlen($ip))){
            if($time-substr($fileforbidarr[1],0,10)>120){
                unlink($fileforbid);
            }else if($fileforbidarr[2]>$allowRefresh){
                file_put_contents($fileht,$ip."\r\n",FILE_APPEND);
                @unlink($fileforbid);
            }else{
                $fileforbidarr[2]++;
                file_put_contents($fileforbid,$fileforbidarr);
            }
        }
    }
}
//防刷新
$str='';
$file=$logFilePath.'ipdate.dat';
if(!file_exists($logFilePath)&&!is_dir($logFilePath)){
    mkdir($logFilePath,0777);
}
if(!file_exists($file)){
    file_put_contents($file,'');
}
$uri=$_SERVER['REQUEST_URI'];//获取当前访问的网页文件地址
$checkip=md5($ip);
$checkuri=md5($uri);
$yesno=true;
$ipdate=@file($file);
foreach($ipdate as $k=>$v){
    $iptem=substr($v,0,32);
    $uritem=substr($v,32,32);
    $timetem=substr($v,64,10);
    $numtem=substr($v,74);
    if($time-$timetem<$allowtime){
        if($iptem!=$checkip){
            $str.=$v;
        }else{
            $yesno=false;
            if($uritem!=$checkuri){
                $str.=$iptem.$checkuri.$time."\r\n";
            }else if($numtem<$allownum){
                $str.=$iptem.$uritem.$timetem.($numtem+1)."\r\n";
            }
            else{
                if(!file_exists($fileforbid)){
                    $addforbidarr=array($ip."\r\n",time()."\r\n",1);
                    file_put_contents($fileforbid,$addforbidarr);
                }
                file_put_contents($logFilePath.'forbided_ip.log',$ip.'--'.date('Y-m-d H:i:s',time()).'--'.$uri."\r\n",FILE_APPEND);
                $timepass=$timetem+$allowtime-$time;
                exit('警告：不要刷新的太频繁！');
            }
        }
    }
}
if($yesno){
    $str.=$checkip.$checkuri.$time."\r\n";
}
file_put_contents($file,$str);



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

defined('DEBUG') || define('DEBUG', true); // 是否开启调试模式

require_once BASE_PATH . '/AutoLoadClass.php';

$app = new BApp();
$app->run();
