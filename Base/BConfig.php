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
	private static $_field;
	
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
    
    /**
     * 根据表名
     * @param string $tableName 表名[key]或公共字段名[key]
     * @param string $key 字段名，对应于配置文件中数组的键
     * @param string $fileName 对应的文件名（以后考虑按业务划分时，可以用到）
     * @return null | string
     */
    public static function getFieldName($tableName, $key = null, $fileName = 'Field.php') {
        $field = self::cacheConfig('_field', $fileName, $tableName);
        if (empty($field)) {
            return null;
        } else {
            if ($key === null) { // 返回整个表的所有字段名或返回公共字段名
                return $field;
            } else { // 返回表中对应的字段名
                if (isset($field[$key])) {
                    return $field[$key];
                } else {
                    return null;
                }
            }
        }
    }
    
    /**
     * 缓存配置文件，并根据key返回对应的值
     * @param string $cacheKey 当前类中对应的静态变量名
     * @param string $fileName 配置文件名(全名，包括后缀，最前面不带 / )
     * @param string $key 配置中的键
     * @return NULL | string | array | integer
     */
    private static function cacheConfig($cacheKey, $fileName, $key) {
        // 提取公共部分
        if (self::${$cacheKey} === null) {
            $configPath = CONFIG_PATH . '/' . $fileName;
            if (!(is_file($configPath))) {
                $configPath = APP_PATH . '/Configs/' . $fileName;
            }
            if (is_file($configPath)) {
                self::${$cacheKey} = include_once $configPath;
            } else {
                return null;
            }
        }
        if (isset(self::${$cacheKey}[$key])) {
            return self::${$cacheKey}[$key];
        } else {
            return null;
        }
    }

}
