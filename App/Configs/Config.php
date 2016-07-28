<?php

return array(
    'pdo_db' => array( // pdo普通数据库设置
        'dsn' => 'mysql:host=127.0.0.1;dbname=BageCms',
        'emulatePrepare' => true,
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
    ),
    'mysqli_db' => array( // mysqli数据库设置
        'host'     => '127.0.0.1',
        'database' => '',
        'username' => 'root',
        'password' => '123456',
        'charset'  => 'utf8'
    ),
    'master_db' => array( // 主数据库设置
        'dsn' => 'mysql:host=192.168.253.4;dbname=mvc',
        'emulatePrepare' => true,
        'username' => 'mvcUser',
        'password' => '123456',
        'charset' => 'utf8',
    ),
    'slave_db' => array( // 多个从数据库，这里要设置为二维数组
//         array(
//             'dsn' => 'mysql:host=192.168.17.134;dbname=mvc',
//             'emulatePrepare' => true,
//             'username' => 'slaveMvc',
//             'password' => '123456',
//             'charset' => 'utf8'
//         ),
//         array(
//             'dsn' => 'mysql:host=192.168.17.139;dbname=mvc',
//             'emulatePrepare' => true,
//             'username' => 'slaveMvc',
//             'password' => '123456',
//             'charset' => 'utf8',
//         ),
        array( // 主数据库设置
            'dsn' => 'mysql:host=192.168.253.4;dbname=mvc',
            'emulatePrepare' => true,
            'username' => 'mvcUser',
            'password' => '123456',
            'charset' => 'utf8',
        ),
    ),
    'modules' => array( // 多模块设置
        'backend',
    ),
    'thireLibrariesPath' => array( // 第三方类库路径
        realpath(ROOT_PATH . '/../../libraries')
    ),
    'master_redis' => array( // redis 主服务器配置
        'host' => '192.168.253.4',
        'port' => 6379,
        'password' => 'ouhaixiong',
        'timeout' => 0
	),
    'slave_redis' => array( // 多个 redis 从服务器配置
        array(
            'host' => '192.168.17.134',
            'port' => 6379,
            'timeout' => 0
        ),
        array(
            'host' => '192.168.17.139',
            'port' => 6379,
            'timeout' => 0
        ),
    ),
    'isIntercept' => false, // 是否开启拦截功能；false：未开启拦截功能，不对频繁请求的用户进行屏蔽操作
    
		
);
