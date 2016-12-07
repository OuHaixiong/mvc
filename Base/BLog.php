<?php

/**
 * @desc 日记处理类，包括错误日记处理
 * @author bear
 * @version 0.1.0
 * @created 2016-12-06 11:20
 */
class BLog
{

	
    /**
     * 错误消息处理函数，所有的错误信息都会到这里来 [其实错误日记是不需要写这个函数来处理的，在php.ini中是可以配置出来的]
     * @param integer $errorNumber 错误类型
     * @param string $errorString 错误消息
     * @param string $errorFile 错误所在文件
     * @param integer $errorLine 错误所在行数
     * @return boolean
     */
    public static function errorHandler($errorNumber, $errorString, $errorFile, $errorLine) {
        $debug = BConfig::getConfig('debug');
        if ($debug) { // 报所有错误
            ini_set('display_errors', 'On');
            ini_set('error_reporting', E_ALL); // 低于5.4版 error_reporting(E_ALL | E_STRICT);
            error_reporting(E_ALL);
            return false;
        } else { // 不报任何错误，把错误信息写入日记文件
            ini_set('error_reporting', 0);
            error_reporting(0);
            $isExit = false;
            $errorInput = '';
            switch ($errorNumber) {
                case E_DEPRECATED   :
                case E_NOTICE       : // 提醒级别;程序继续执行
                case E_USER_NOTICE  : $errorType = 'Notice:'; break;
                case E_STRICT       : // 兼容性级别[严谨的];程序继续执行
                    $errorType = 'Strict:'; break;
                case E_WARNING      : // 警告级别;可能得不到想要的结果;程序继续执行
                case E_USER_WARNING : $errorType = 'Warning:'; break;
                case E_ERROR        : // 致命错误级别;程序不往下执行
                case E_USER_ERROR   : 
                    $errorType = 'Fatal:'; 
                    $isExit = true; 
                    break;
                default           : $errorType = 'Unknown:'; break; // 其他未知错误
            }
            $errorInput .= $errorType;
            $errorInput .= $errorString . ' ' . $errorFile . ':' . $errorLine . "\n";
            // 写入文件或写入数据库
            $filePath = BConfig::getConfig('logPath');
            if ($filePath != false) {
                $filePath .= '/error.log';
                self::_appendWriteFile($filePath, $errorInput);
            }

            // 如果错误影响到程序的正常执行，跳转到友好的错误提示页面
            if ($isExit) { // TODO 友好错误提示页面
                
            }
            return true;
        }
    }
	
    /**
     * 把一个字符串追加写入文件
     * 如果该文件不存在则自动创建，如果文件超过了2m则备份旧的文件，创建新的文件
     * @param string $filePath 要写入的文件路径（绝对路径）
     * @param string $string 写入的字符串
     * @return boolean 成功返回true，失败返回false
     */
    private static function _appendWriteFile($filePath, $string) {
        if (!is_file($filePath)) { // 文件不存在
            $dirname = dirname($filePath);
            if (!file_exists($dirname)) { // 文件夹不存在，创建所有的文件夹
                $boolean = mkdir($dirname, 0777, true);
                if ($boolean == false) {
                    exit('无权限创建目录：' . $dirname);
                }
            }
            // 文件夹没有写的权限
            $boolean = is_writable($dirname);
            if (!$boolean) {
                exit('目录不可写：' . $dirname);
            }
        } else { // 文件已存在
            if (!is_writeable($filePath)) {
                exit($filePath . '文件没有写的权限');
            }
            // 判断文件大小是否超过2M
            $fileSize = filesize($filePath);
            if ($fileSize > 2097152) { // 超过最大限制，重命名文件
                $newname = $filePath . '_' . date('YmdHis') . '_' . microtime(true);
                rename($filePath, $newname);
            }
        }
        $handle = fopen($filePath, 'a');
        $length = fwrite($handle, $string . "\n");
        fclose($handle);
        return true;
    }
	
}
