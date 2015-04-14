<?php

/**
 * url网址生成和解析规则
 * @author Bear
 * @copyright http://maimengmei.com
 * @version 1.0.0
 * @created 2015-04-11 22:17
 */
class CUrlRule
{
    const URL_SUFFIX = '.html';
    
    /**
     * 生成url地址
     * @param string $route 路由，由 模块/控制器/行为 组成 且不能省略（index）
     * @param array $params 参数
     * @param string $ampersand 连接两个参数之前的&符号
     * @return string
     */
    public function createUrl($route, $params = array(), $ampersand='/') {
        foreach ($params as $k=>$v) {
            $params[$k] = $k . '/' . $v;
        }
        $params = implode($ampersand, $params);
        $route = trim($route, '/');
        $route = trim($route);
        $route = '/' . $route . '/';
        return $route . $params . self::URL_SUFFIX;
    }
    
    /**
     * 分析url地址（拆解url）
     * @param string $urlPath 完整的url地址
     * @return array 
     */
    public function parseUrl($urlPath) {
        foreach ($_GET as $k=>$v) {
            $_GET[$k] = trim($v);
        }
        foreach ($_POST as $k=>$v) {
            $_POST[$k] = trim($v);
        }
        
        $urlPath = preg_replace('/\?.*/', '', $urlPath);
        $charlist = '/';
        $urlPath = trim($urlPath, $charlist);
        $urlPath = trim($urlPath, self::URL_SUFFIX);
        $urlPath = explode($charlist, $urlPath);
        $modules = CConfig::getConfig('modules');
        $result = array();
        if ($modules !== null) {
            if (isset($urlPath[0]) && $urlPath[0] != '') {
                $isExist = false;
                foreach ($modules as $v) {
                    if ($v == $urlPath[0]) {
                        $isExist = true;
                        break;
                    }
                }
                if ($isExist) {
                    $result['module'] = ucfirst($urlPath[0]);
                    if (isset($urlPath[1]) && $urlPath[1] != '') {
                        $result['controller'] = ucfirst($urlPath[1]);
                    } else {
                        $result['controller'] = 'Index';
                    }
                    if (isset($urlPath[2])) {
                        $result['action'] = lcfirst($urlPath[2]);
                    } else {
                        $result['action'] = 'index';
                    }
                    unset($urlPath[0], $urlPath[1], $urlPath[2]);
                    if (empty($urlPath)) {
                        $result['params'] = array();
                        return $result;
                    }
                    $sum = count($urlPath);
                    $p = array();
                    if ( $sum > 0) {
                        $sum = $sum+2;
                        for ($i = 3; $i < $sum;) {
                            if (!isset($urlPath[$i+1])) {
                                $urlPath[$i+1] = '';
                            }
                            $p[$urlPath[$i]] = urldecode($urlPath[$i+1]);
                            $i = $i+2;
                        }
                    }
                    $p = array_merge($p, $_GET); // 重名参数以?后面的为主
                    $result['params'] = $p;
                    return $result;
                }
            }
        }
        
        if (isset($urlPath[0]) && $urlPath[0] != '') {
            $result['controller'] = ucfirst($urlPath[0]);
        } else {
            $result['controller'] = 'Index';
        }
        if (isset($urlPath[1])) {
            $result['action'] = lcfirst($urlPath[1]);
        } else {
            $result['action'] = 'index';
        }
        $result['module'] = 'Default';
        unset($urlPath[0], $urlPath[1]);
        $sum = count($urlPath);
        $p = array();
        if ( $sum > 0) {
            $sum = $sum+2;
            for ($i = 2; $i < $sum;) {
                if (!isset($urlPath[$i+1])) {
                    $urlPath[$i+1] = '';
                }
                $p[$urlPath[$i]] = urldecode($urlPath[$i+1]);
                $i = $i+2;
            }
        }
        $p = array_merge($p, $_GET); // 重名参数以?后面的为主
        $result['params'] = $p;
        return $result; 
    }
    
}
