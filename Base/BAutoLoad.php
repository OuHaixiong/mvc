<?php

//defined('ROOT_PATH') || define('ROOT_PATH', realpath(dirname(__FILE__))); 
// 需设置 ROOT_PATH、 BASE_PATH、 APP_PATH

/**
 * 框架自动加载类
 * @author Bear[258333309@163.com]
 * @version 1.0
 * @created 2018年7月20日 下午5:55:19
 */
class BAutoLoad
{
    /**
     * 自动加载类
     * @param string $classname 以 _ 分割的类名
     * @return NULL
     */
    public static function autoload($classname) {
    	$classPath = explode('_', $classname);
    	$filePath = '';
    	foreach ($classPath as $path) {
    // 		$filePath .= '/' . ucfirst($path);
    		$filePath .= '/' . $path;
    	}
    	$filePath .= '.php';
        // ROOT_PATH 暂不考虑根目录下的类
    	// 1, 查找本Base下的类
    	$absolutePath = BASE_PATH . $filePath;
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
    	include_once BASE_PATH . '/BConfig.php';
    	$libraries = BConfig::getConfig('thireLibrariesPath');
    	foreach ($libraries as $lib) {
    	    $absolutePath = $lib . $filePath;
    	    if (is_file($absolutePath)) {
    	        include_once $absolutePath;
    	        return;
    	    }
    	}
    	die('File(' . __FILE__ . ') on line 47: 文件 ' . $filePath . ' 不存在！');
    }

}

spl_autoload_register(['BAutoLoad', 'autoload'], true, true);
