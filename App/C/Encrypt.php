<?php

/**
 * 测试加密操作
 * @author Bear
 * @version 2.0.0
 * @copyright http://maimengmei.com
 * @created 2017-02-20 12:30
 */
class C_Encrypt extends BController
{
    /**
     * 测试加密过后的长度
     */
    public function length() {
        $string = '我是欧海雄';
        $fileUpdateTime = filemtime(__FILE__);
        $salt = 'Bear';
        var_dump($fileUpdateTime);
        var_dump('MD5：', md5($string));
        var_dump('有加盐值crypt:', crypt($string, $salt));
        var_dump('sha1:', sha1($string));
        var_dump('base64:', base64_encode($string));
        echo '<br />';
        var_dump('MD5：', md5($fileUpdateTime));
        var_dump('PHP默认crypt:', crypt($fileUpdateTime)); // PHP 默认类似：$1$qoTUWPST$pYStTwS3.NYkJYq9MEsZz/
        var_dump('sha1:', sha1($fileUpdateTime));
        var_dump('base64:', base64_encode($fileUpdateTime));
    }
    
}