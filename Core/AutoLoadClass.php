<?php

//defined('ROOT_PATH') || define('ROOT_PATH', realpath(dirname(__FILE__))); 
// 需设置 ROOT_PATH、 CORE_PATH、 APP_PATH

/**
 * 自动加载类
 * @param string $classname 以 _ 分割的类名
 * @return NULL
 */
function __autoload($classname) {
	$classPath = explode('_', $classname);
	$filePath = '';
	foreach ($classPath as $path) {
// 		$filePath .= '/' . ucfirst($path);
		$filePath .= '/' . $path;
	}
	$filePath .= '.php';
    // ROOT_PATH 暂不考虑根目录下的类
	// 1, 查找本Lib下的类
	$absolutePath = CORE_PATH . '/' . $filePath;
	if (is_file($absolutePath)) {
	    include_once $absolutePath;
	    return;
	}
	// 2, 查找应用下的类(第一查找默认模块下的类，第二查找新增模块下的类)
	$absolutePath = APP_PATH . $filePath;
	if (is_file($absolutePath)) {
		include_once $absolutePath;
		return;
	}
	$absolutePath = APP_PATH . '/Modules' . $filePath;
	if (is_file($absolutePath)) {
	    include_once $absolutePath;
	    return;
	}
	// 3, 查找第三方类库下的类
	include_once CORE_PATH . '/Config.php';
	$libraries = CConfig::getConfig('thireLibrariesPath');
	foreach ($libraries as $lib) {
	    $absolutePath = $lib . $filePath;
	    if (is_file($absolutePath)) {
	        include_once $absolutePath;
	        return;
	    }
	}

	die('文件： ' . $filePath . ' 不存在！');
}
