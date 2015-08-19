<?php

/**
 * 测试下载文件
 * @author Bear
 * @copyright http://maimengmei.com
 * @version 1.0.0
 * @created 2015-8-19
 */
class C_Download extends BController
{
    /**
     * 测试下载文件
     */
    public function down() {
        $name = $this->getParam('name');
        $filePath = ROOT_PATH . '/data/' . $name;
        if (is_file($filePath)) {
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $extension = strtolower($extension);
            if ($extension == 'doc') {
                header('Content-Type:application/msword;charset=utf-8');
            } else if ($extension == 'docx') {
                header('Content-Type:application/vnd.openxmlformats-officedocument.wordprocessingml.document;charset=utf-8');
            } else if ($extension == 'pdf') {
                header('Content-Type:application/pdf;charset=utf-8');
            } else {
                header('Content-Type:application/octet-stream');
            }
            
            header('Content-Length:' . filesize($filePath));
            
            // 处理中文文件名
            $encodeName = rawurlencode($name);
            $userAgent = $_SERVER['HTTP_USER_AGENT'];
            if ((strpos($userAgent, 'MSIE')) !== false) {
                header('Content-Disposition:attachment; filename="' . $encodeName . '"');
            } else if ((strpos($userAgent, 'Firefox')) !== false) {
                header('Content-Disposition:attachment; filename*="utf8\'\'' . $encodeName . '"');
            } else { // 貌似这里的文件名有一点点问题
                header('Content-Disposition:attachment; filename="' . $encodeName . '"');
            }
            readfile($filePath);
        }
    }
}
