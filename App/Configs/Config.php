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
        'dsn' => 'mysql:host=127.0.0.1;dbname=mvc',
        'emulatePrepare' => true,
        'username' => 'root',
        'password' => '123456',
        'charset' => 'utf8',
    ),
    'slave_db' => array( // 多个从数据库，这里要设置为二维数组
        array(
            'dsn' => 'mysql:host=127.0.0.1;dbname=mvc',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '123456',
            'charset' => 'utf8'
        ),
//         array(
            
//         ),
    ),
    'modules' => array( // 多模块设置
        'backend',
    ),
    'thireLibrariesPath' => array( // 第三方类库路径
        realpath(ROOT_PATH . '/../../libraries')
    ),
    'master_redis' => array( // redis 主服务器配置
        'host' => '120.XXX.XXX.XXX',
        'port' => 6379,
        'timeout' => 0
	),
		
);
