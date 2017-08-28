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

    public function index() {
        
    }
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
//         session_start();
//         $_SESSION['wokao'] = '我靠';
//         $_SESSION['isLogin'] = 'Y';

        var_dump($_SESSION);
        var_dump($_SERVER['SERVER_PORT']);
        var_dump($_SERVER['SERVER_ADDR']);
    }
    
    public function login() {
        // 登录验证成功：用户名和密码都正确
        // 根据用户名(或ID)获取用户之前的sessionID
        $oldSessionId = file_get_contents(ROOT_PATH . '/data/sessionid');
        if ($oldSessionId != '') {
            // 获取当前的sessionID和老的进行比对
            $currentSessionId = session_id();
            if ($currentSessionId != $oldSessionId) {
                // 不一样，说明之前在另一台电脑上登录过，需要把之前的登录状态清空掉
                session_id($oldSessionId);
                session_destroy();
//                 unset($_SESSION['isLogin']);
                echo '已经把之前登录的下线了<br />';
            } else {
                // 一样，说明是同一台机器登录，不需要处理
            }
        } else {
            // 如果为空，说明之前正确退出了，或从没有登录过
        }
        // 生成新的sessionId，并写入文件 (设置新的sessionID，并写入文件)
        $sessionId = Common_Tool::random(32);
//         session_regenerate_id();
        session_id($sessionId);
        $sessionName = session_name();
        setcookie($sessionName, $sessionId);
        file_put_contents(ROOT_PATH . '/data/sessionid', $sessionId);
        $_SESSION['isLogin'] = true;
        var_dump(session_id());
        echo '<br />';
        var_dump($_SESSION);
        echo '<br />';
        echo '登录成功！';
    }
    
    /**
     * 验证是否还在登录中
     */
    public function logined() {
        var_dump($_COOKIE);
        echo '<br />';
        var_dump(session_id());
        echo '<br />';
        var_dump($_SESSION);
        echo '<br />';
        if (isset($_SESSION['isLogin']) && $_SESSION['isLogin']) {
            echo '登录中ing';
        } else {
            echo '已退出';
        }
    }
    
    /**
     * 测试退出登录
     */
    public function logout() {
        $isLogin = $_SESSION['isLogin'];
        if ($isLogin) {
            echo '已登录，正在处理退出登录ing';
            session_destroy();
            file_put_contents(ROOT_PATH . '/data/sessionid', '');
            echo '已成功退出登录！';
        } else {
            echo '未登录，无需退出';
        }
    }
    
    /**
     * 通过redis实现，登录系统
     * 【同样的道理，如果想在这里登录后，对之前的登录自动进行退出，只需要找到之前的tokenKey，并删除之】
     */
    public function redisLogin() {
        // 每次登录之前判断，本机是否已经登录了，如果已经登录跳转到登录后的首页
        $username = 'ouhaixiong';
        $userId = 8;
        // 读取缓存，判断是否存在当前用户已登录的信息
        $redisMaster = BRedis::getMaster();
        $usernameKey = 'user_login_' . $username;
        if ($redisMaster->exists($usernameKey)) {
            echo '您的帐号已经在另一台电脑上登录了，请退出后，方可登录';exit();
        }
        // 已经验证用户名和密码正确
        // 将登录信息存入redis
        $tokenValue = Common_Tool::random(64);
        setcookie('verifyUniquenessCode', $tokenValue);
        $redisMaster->hSet($tokenValue, 'usernameKey', $usernameKey);
        $redisMaster->hSet($tokenValue, 'userId', $userId);
        $redisMaster->hSet($tokenValue, 'username', $username);
        $redisMaster->hSet($usernameKey, 'tokenKey', $tokenValue);
        // 记录登录时间等信息入数据库
        // 设置过期时间（设好后，需要在用户已登录的情况下，每次请求都更新此时间，如果用户在有效时间能未操作，将自动退出）
        $redisMaster->setTimeout($tokenValue, 120); // 两分钟后过期
        $redisMaster->setTimeout($usernameKey, 120); // 设置两分钟后过期
        echo '登录成功！';
    }
    
    /**
     * 通过redis实现，判断是否已经登录
     * usernameKey {
     *     'isLogin' ：也可以不需要，存在一定是已登录
     *     'userid' ：用户id，也可以不要，在token中已经知道
     *     'tokenKey'：登录时用的判断用户唯一身份的
     *     'loginTime'： 登录时间， 也可以不要，每次登录的信息都会记录入数据库
     *     'updateTime' : 更新时间 （可以不要，因为有效时间在redis中已经控制了）
     * }
     * tokenValue {    // 存成hash
     *     'isLogin' : true:已登录，false：未登录 （可以不要）
     *     'usernameKey' : 用户缓存中的唯一key：user_login_[username] 
     *     'userId' : 用户id
     *     'username' : 用户名
     * }
     */
    public function redisLogined() {
        if (isset($_COOKIE['verifyUniquenessCode'])) { // 查看redis是否存在此token
            $uniquenessKey = $_COOKIE['verifyUniquenessCode'];
            $redisMaster = BRedis::getMaster();
            if ($redisMaster->exists($uniquenessKey)) { // 存在，说明已经登录
                echo '已经登录';
            } else { // 不存在，说明未登录
                echo '未登录';
            }
        } else { // 不存在，从来没有登录过hexists
            echo '未登录';
        }
    }
    
    // 每一次请求，对verifyUniquenessCode的时间进行更新
    
    /**
     * 通过redis实现，退出登录
     */
    public function redisLogout() {
        if (isset($_COOKIE['verifyUniquenessCode'])) {
            $redisMaster = BRedis::getMaster();
            if ($redisMaster->exists($_COOKIE['verifyUniquenessCode'])) {
                $usernameKey = $redisMaster->hGet($_COOKIE['verifyUniquenessCode'], 'usernameKey');
                $redisMaster->delete($usernameKey);
                $redisMaster->delete($_COOKIE['verifyUniquenessCode']);
                echo '已成功退出登录！';
            } else {
                echo '退出了（已经退出过，无需再退出）';
            }
        } else {
            echo '未登录，无需退出';
        }
    }



}
