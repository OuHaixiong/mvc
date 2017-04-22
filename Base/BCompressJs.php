<?php

/**
 * @author Bear
 *
 */
class BCompressJs
{
    const CONFIG_KEY ='compressJs';
    const WRITE_FOLDER = '/assets/';
    
    /**
     * @param unknown $fileName
     * @param unknown $filePathArray
     * @throws Exception
     */
    public static function render($fileName, $filePathArray = array()) {
        $compressJsConfig = BConfig::getConfig(self::CONFIG_KEY);
        if ($compressJsConfig['isDevelop']) { // 开发者模式
            $scriptHtml = '';
            foreach ($filePathArray as $path) {
                $scriptHtml .= '<script type="text/javascript" src="' . STATIC_URL . $path . '"></script>';
            }
            echo $scriptHtml;
        } else { // 线上正式环境模式
            // 获取各文件的hash值，并判断生成的文件是否存在，如果存在，说明文件没有修改过，直接返回，如果不存在，重新写入文件
            $writeFiles = array(); // 所有需要写入的源文件
            $cryptString = '';
            foreach ($filePathArray as $k=>$v) {
                $originPath = $compressJsConfig['originPath'] . $v;
                if (is_file($originPath)) { // 源文件存在
                    $cryptString .= filemtime($originPath);
                    $writeFiles[] = $originPath;
                }
            }
            $writeFileName =  md5($cryptString) . '.js'; // 需要写入的文件名
            $writeFileFolder = ROOT_PATH . self::WRITE_FOLDER . $fileName . '/';
            $writePath = $writeFileFolder . $writeFileName;
            $scriptHtml = '<script type="text/javascript" src="' . STATIC_URL . self::WRITE_FOLDER . $fileName . '/' . $writeFileName . '"></script>';
            if (is_file($writePath)) { // 判断文件是否存在，如果存在则直接返回
                echo $scriptHtml;
                return;
            }
            // 需要写入的文件夹是否存在，如果不存在则创建
            if (!file_exists($writeFileFolder)) { // 特别注意了is_file不能用来判断一个文件夹是否存在
                $boolean = mkdir($writeFileFolder, 0777, true);
                if (!$boolean) {
                    throw new Exception('文件目录的父级目录没有写的权限：' . $writeFileFolder, 500);
                }
            } else {
                if (!is_writeable($writeFileFolder)) {
                    throw new Exception('文件目录没有写的权限： ' . $writeFileFolder, 501);
                }
            }
            // TODO 一定几率会触发相关文件的删除
            //  合并写入文件；    TODO 压缩和乱序（加密、混淆）
            $handle = fopen($writePath, 'a');
            foreach ($writeFiles as $file) {
                fwrite($handle, file_get_contents($file) . ';');
            }
            fclose($handle);
            echo $scriptHtml;  
        }
    }
    
    
}