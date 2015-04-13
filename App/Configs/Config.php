<?php

return array(
    'db' => array(
        'connectionString' => 'mysql:host=localhost;dbname=vragon_debug',
        'emulatePrepare' => true,
        'username' => 'root',
        'password' => '123456',
        'charset' => 'utf8',
    ),
    'modules' => array(
        'backend',
    ),
    'thireLibrariesPath' => array(
        realpath(ROOT_PATH . '/../../libraries')
    ),
);
