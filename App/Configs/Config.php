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
        'dsn' => 'mysql:host=172.16.51.131;dbname=mvc',
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
            'dsn' => 'mysql:host=172.16.51.131;dbname=mvc',
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
        realpath(ROOT_PATH . '/../../libraries') // 如果有此第三方库，此目录必需存在且可写
    ),
    'master_redis' => array( // redis 主服务器配置
        'host' => '172.16.51.133',
        'port' => 6379,
        'password' => 'ouhaixiong',
        'timeout' => 0
	),
    'slave_redis' => array( // 多个 redis 从服务器配置
        array(
            'host' => '172.16.51.133',
            'port' => 6379,
            'timeout' => 0
        ),
//         array(
//             'host' => '192.168.17.139',
//             'port' => 6379,
//             'timeout' => 0
//         ),
    ),
    'isIntercept' => false, // 是否开启拦截功能；false：未开启拦截功能，不对频繁请求的用户进行屏蔽操作
    'debug' => true, // 是否开启调试模式；true：直接报错，false：不报错，把错误写入日记文件
    'logPath' => realpath(ROOT_PATH . '/../../logs/mvc'), // 日记文件目录；特别注意此文件需要存在且可写
    'compressJs' => array(
        'originPath' => ROOT_PATH . '/js', // [源]引入页面的js文件根目录
        //'targetPath' => ROOT_PATH . '/assets', // [目标]打包后的js文件存放路径 (此配置作废，目前固定为网站根目录下的assets文件夹)
        'isDevelop' => false, // 是否开启开发者模式，true：是，所有的js文件不会进行打包，原样输出；false：否【线上正式环境】，所有的js文件会自动打包压缩
    ),
);
