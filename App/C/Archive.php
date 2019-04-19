<?php

/**
 * 测试解压缩相关
 * @author Bear[258333309@163.com] 
 * @version 1.0.0
 * @date 2019年4月17日
 */
class C_Archive extends BController
{
    public function init() {
        parent::init();
    }
    
    /**
     * 读取zip文件里面的所有文件列表
     */
    public function listZip() {
        $zipFilePath = ROOT_PATH . '/../data/ff.zip';
        $archive = new Common_Archive();
        $fileList = $archive->getFileListByZip($zipFilePath);
        var_dump($fileList);
    }
    
    /**
     * 读取zip文件里面的某一个文件的内容
     */
    public function readZip() {
        $zip = new ZipArchive;
        if ($zip->open(ROOT_PATH . '/../data/ff.zip') === true) {
            echo $zip->getFromName('ff/d/临时记录.txt'); // 这里输出字符串
            $zip->close();
        }
    }
    
    public function test() {
        
    }
    
}
