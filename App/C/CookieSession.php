<?php
/**
 * cookie和session的练习
 * @author Bear
 * @copyright http://maimengmei.com
 * @version 1.0.0
 * @created 2015-8-5
 */
class C_CookieSession extends BController
{
    public function init() {}

    /**
     * cookie的设置和读取，js操作cookie
     */
    public function cookies() {
        $this->render();
    }
    
    /**
     * 测试多主机共享session
     */
    public function session() {
        session_start();
        $_SESSION['wokao'] = '我靠';
        var_dump($_SESSION);
        var_dump($_SERVER['SERVER_PORT']);
        var_dump($_SERVER['HTTP_HOST']);
        var_dump($_SERVER);
    }
    
}
