<?php

return array(
    'pdo_db' => array(
        'dsn' => 'mysql:host=127.0.0.1;dbname=vragon_debug',
        'emulatePrepare' => true,
        'username' => 'root',
        'password' => '123456',
        'charset' => 'utf8',
    ),
    'mysqli_db' => array(
        'host'     => '127.0.0.1',
        'database' => 'vragon_debug',
        'username' => 'root',
        'password' => '123456',
        'charset'  => 'utf8'
    ),
    'modules' => array(
        'backend',
    ),
    'thireLibrariesPath' => array(
        realpath(ROOT_PATH . '/../../libraries')
    ),
);
