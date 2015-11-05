<?php

/**
 * 读取配置文件信息
 * @author Bear
 * @version 1.0.0
 * @copyright http://maimengmei.com
 * @created 2015-04-11 16:53
 */
class BConfig
{
	private static $_constant;
	private static $_config;
	private static $_imgThumbnail;
	
	/**
	 * 通过键名读取站点常量
	 * @param string $key
	 * @return array | string | mixed
	 */
// 	public static function getConstant($key) {
// 		if (self::$_constant === null) {
// 			self::$_constant = require_once APPLICATION_PATH . '/configs/constant.php';
// 		}
// 		return self::$_constant[$key];
// 	}
	
	/**
	 * 通过键名读取站点配置文件
	 * @param string $key 配置名（键名）
	 * @return array | string | mixed | false | null 没有找到该项返回null
	 */
	public static function getConfig($key) {
		if (self::$_config === null) {
		    $configPath = CONFIG_PATH . '/Config.php';
		    if (!(is_file($configPath))) {
		        $configPath = APP_PATH . '/Configs/Config.php';
		    }
			self::$_config = require_once $configPath; //  __DIR__ . '/config/config.php' __DIR__ 获取本页脚本执行的绝对路径
		}
		if (isset(self::$_config[$key])) {
		    return self::$_config[$key];
		} else {
		    return null;
		}
	}

    /**
     * 通过键名读取图片缩略图配置文件
     * @param string $key
     * @return array | null 没有找到该项返回null
     */
    public static function getImgThumbnail($key) {
        // 其实以下代码可以提取出来成一个公共方法，供多个配置使用 TODO
        if (self::$_imgThumbnail === null) {
            $configPath = CONFIG_PATH . '/ImgThumbnail.php';
            if (!(is_file($configPath))) {
                $configPath = APP_PATH . '/Configs/ImgThumbnail.php';
            }
            if (is_file($configPath)) {
                self::$_imgThumbnail = require_once $configPath;
            } else {
                return null;
            }
        }
        if (isset(self::$_imgThumbnail[$key])) {
            return self::$_imgThumbnail[$key];
        } else {
            return null;
        }
    }

}
