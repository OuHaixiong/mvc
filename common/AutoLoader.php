<?php

class AutoLoader
{
    private static $_vendorMap = array( // 路径映射
        'common' => __DIR__
    );

    /**
     * 自动加载器
     */
    public static function autoload($class) // common\dd\TestAbc
    {
        $file = self::findFile($class);
		if (!$file) {
			return false;
		}
        if (file_exists($file)) {
            include $file; // 引入文件
        } else {
			return false;
		}
    }

    /**
     * 解析文件路径
     */
    private static function findFile($class)
    {
        $vendor = substr($class, 0, strpos($class, '\\')); // 顶级命名空间
		if (!isset(self::$_vendorMap[$vendor])) {
			return false;
		}
        $vendorDir = self::$_vendorMap[$vendor]; // 文件基目录
        $filePath = substr($class, strlen($vendor)) . '.php'; // 文件相对路径
        $filePath = strtr($vendorDir . $filePath, '\\', DIRECTORY_SEPARATOR); // 文件标准路径
		return $filePath;
    }
}

spl_autoload_register('AutoLoader::autoload'); // 注册自动加载
