<?php

/**
 * url网址生成和解析规则
 * TODO url优化时，如何去做
 * @author Bear
 * @copyright http://maimengmei.com
 * @version 1.0.0
 * @created 2015-04-11 22:17
 */
class BUrlRule
{
    const URL_SUFFIX = '.html';
    
    /**
     * 生成url地址
     * @param string $route 路由，由 “模块/控制器/行为” 组成， 如果是默认模块，也可以是 “控制器/行为”
     * 如果是默认行为（index），也可以不传，如果传空字符串或/，默认为/Default/Index/index
     * @param array $params 参数(最多支持二维数组；比如三维数组或以上，直接舍弃掉)
     * @param string $ampersand 连接两个参数之前的&符号
     * @return string
     */
    public function createUrl($route, $params = array(), $ampersand='/') {
        if (!is_string($route)) {
            return '';
        }
        $route = trim($route);
        $route = trim($route, '/');
        if (strlen($route) == 0) {
            $route = BApp::CONTROLLER_DEFAULT_NAME . '/' . BApp::ACTION_DEFAULT_NAME;
        }
        $route = explode('/', $route);
        if (ucfirst($route[0]) == BApp::MODULE_DEFAULT_NAME) { // 默认模块
            unset($route[0]);
        }
        foreach ($route as $key=>$value) {
            $route[$key] = lcfirst($value);
        }
        if (count($route) < 2) {
            if (empty($params)) {
                if (empty($route)) {
                    return '';
                } else {
                    $route = implode('/', $route);
                    return '/' . $route . self::URL_SUFFIX;
                }
            } else {
                if (empty($route)) {
                    $route[] = lcfirst(BApp::CONTROLLER_DEFAULT_NAME);
                    $route[] = lcfirst(BApp::ACTION_DEFAULT_NAME);
                } else {
                    $route[] = BApp::ACTION_DEFAULT_NAME;
                }
            }
        }
        $route = implode('/', $route);
        $route = '/' . $route;
        
        $p = '';
        $arrayParams = array();
        if (is_array($params)) {
            // TODO 考虑多维数组
            $p = array();
            foreach ($params as $k=>$v) {//var_dump($v);
                if (is_array($v)) { // 数组
                    foreach ($v as $vKey=>$vValue) {
                        if (is_array($vValue)) {
                            // 舍弃
                        } else {
                            $arrayParams[] = $k . '[' . $vKey .']=' . urlencode($vValue);
                        }
                    }
                } else { // 所有都当字符串
                    $p[] = $k . '/' . urlencode($v); // 如果是中文,是需要编码的
                }
            }
            if (empty($p)) {
                $p = '';
            } else {
                $p = implode($ampersand, $p);
                $p = '/' . $p;
            }
        }
        
        $url = $route . $p . self::URL_SUFFIX;
        if (!empty($arrayParams)) {
            $arrayParams = implode('&', $arrayParams);
            $url .= '?' . $arrayParams;
        }
        return $url;
    }
    
    /**
     * 分析url地址（拆解url）
     * @param string $urlPath 完整的url地址
     * @return array 
     */
    public function parseUrl($urlPath) {
        foreach ($_GET as $k=>$v) {
            if (is_array($v)) {
                foreach ($v as $vKey=>$vValue) {
                    if (is_string($vValue)) {
                        $_GET[$k][$vKey] = trim($vValue);
                    } else {
                        // 多维数组不考虑，切记在控制器端，一定是单个参数获取，然后再传入业务逻辑层
                    }
                }
            } else {
                $_GET[$k] = trim($v);
            }
        }
        foreach ($_POST as $k=>$v) {
            if (is_string($v)) {
                $_POST[$k] = trim($v);
            }
        }

        $urlPath = preg_replace('/\?.*/', '', $urlPath);
        $charlist = '/';
        $urlPath = trim($urlPath, $charlist);
        $count = strlen(self::URL_SUFFIX);
        $suffixString = substr($urlPath, -$count);
        if ($suffixString == self::URL_SUFFIX) {
            $urlPath = substr($urlPath, 0, -$count);
        }
        $urlPath = explode($charlist, $urlPath);
        $modules = BConfig::getConfig('modules');
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
