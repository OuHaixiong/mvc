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
        var_dump($fileUpdateTime); // 1492506946
        var_dump('MD5：', md5($string)); // f7df65c6296afea19bf482fea708be2e
        var_dump('有加盐值crypt:', crypt($string, $salt)); // Bend0yOJ0iPLE
        var_dump('sha1:', sha1($string)); // a08c07d4c3b53e5f5bbdc9349be1815af3f728f4
        var_dump('base64:', base64_encode($string)); // string '5oiR5piv5qyn5rW36ZuE' (length=20)
        echo '<br />';
        var_dump('MD5：', md5($fileUpdateTime)); // a03bb83763d7486f9254e4e6c6ce940c
//         var_dump('PHP默认crypt:', crypt($fileUpdateTime)); // PHP 默认;类似：$1$qoTUWPST$pYStTwS3.NYkJYq9MEsZz/  （如果不传入第二个参数或报notic）
        var_dump('sha1:', sha1($fileUpdateTime)); // d1bbf17dad82ce32398d7deda258c8ba953e4a51
        var_dump('base64:', base64_encode($fileUpdateTime)); // string 'MTQ5MjUwNjk0Ng==' (length=16)
    }
    
}