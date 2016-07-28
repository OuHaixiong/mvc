<?php

/**
 * @desc 控制器抽象类
 * ?后面的参数可以用$_GET方法获取；同理post参数也可以用$_POST获取
 * @author bear
 * @version 1.0.0
 * @copyright xiqiyanyan.com
 * @created 2012-09-24 17:20
 */
abstract class BController
{
	/**
	 * 视图对象
	 * @var BView
	 */
	protected $_view;
	
	/**
	 * 请求参数
	 * @var array
	 */
	protected $_params;
	
	public function __construct(array $params) {
		$this->_view = new BView();
		$this->_params = $params;
	}

    /**
     * 初始化控制器，对频繁请求的用户进行屏蔽操作（此判断最好的执行任何php程序的最前端）
     */
    public function init() { // $_SERVER['PHP_SELF']; // 返回 /index.php  和 $_SERVER['SCRIPT_NAME']一样
        // $_SERVER['QUERY_STRING'] 返回问号（?）后面的参数；如：ab=bc&cc=d&q=&ni=8
        $isIntercept = BConfig::getConfig('isIntercept');
        if ($isIntercept == false) { // 未开启拦截功能，不对频繁请求的用户进行屏蔽操作
            return;
        }
        $userIp = Common_Tool::getIP(); // 获取当前访问者的ip
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $requestUrl = Common_Tool::getCurrentUrl(); // http://mvc.com/ueditor/ueditor1_4_3?ab=bc&cc=d&q=&ni=8
        $urlArray = parse_url($requestUrl);   //  $urlArray['path'] = $_SERVER['REDIRECT_URL'] = /ueditor/ueditor1_4_3
        $key = $userIp . $urlArray['path'] . $userAgent;
        $key = md5($key); // 长度为32位
        // 判断用户的ip是否在白名单中（这里使用文件进行保存，后续最好使用redis之类的缓存进行操作）
        
        // 判断用户的ip是否在黑名单中
        $blacklistPath = ROOT_PATH . '/data/log/blacklist.log';
        if (is_file($blacklistPath)) {
            $blacklistString = file_get_contents($blacklistPath);
            $blacklistArray = explode("\r\n", $blacklistString);
            if (in_array($userIp, $blacklistArray)) {
                die('由于你的频繁刷新，你已列入黑名单！');
            }
            unset($blacklistString);
            unset($blacklistArray);
        }
        
        // 判断是否在已禁用一段时间中TODO
        
        // 写访问日记
        $this->_writeRequestLog($userIp, $requestUrl, $userAgent, $urlArray['path'], Common_Tool::getRefererUrl());
        
        // 刷新时间和访问次数
        $allowTime = 60; // 防刷新时间，单位：秒
        $allowNumber = 5; // 防刷新的次数。以上两项代表单位时间内如果超过请求次数，将提示“警告：不要刷新太频繁！”
        $allowRefreshTime = $allowTime;  // 允许刷新的时间 ，单位：秒。这里的时间可以自由设置，也可以和防刷时间一样。
        $allowRefreshTime = 30;
        $allowRefreshNumber = 50; // 允许刷新的最大次数。以上两项代表单位时间内如果超过了请求次数，将把此ip加入到黑名单，此ip将无法再访问该网站
        
        $nowTime = time();
        // 判断是否加入黑名单
        $allowFile = ROOT_PATH . '/data/log/allowRefresh.log';
        if (is_file($allowFile)) {
            $requestArray = file($allowFile);
        } else {
            $requestArray = array();
        }
        $isExist = false; // 是否存在日记文件中，默认false：新用户；true：已有记录
        $delimiter = ' '; // 只能为一位
        $length = strlen($delimiter);
        foreach ($requestArray as $k=>$v) {
            $requestKey = substr($v, 0, 32);
            if ($requestKey == $key) {
                $isExist = true;
                $lastTime = substr($v, (32+$length), 10);
                if (($nowTime-$lastTime) < $allowRefreshTime) {
                    $requestNumber = substr($v, (42+2*$length));
                    $requestNumber = intval($requestNumber);
                    if ($requestNumber > $allowRefreshNumber) { // 已经超过最大次数，需要警告提示，并加到限制规定时间能不能再访问
                        // 写入黑名单列表blacklist
                        Common_Tool::writeFileFromString($blacklistPath, $userIp . "\r\n");
                        die('由于你的频繁刷新，你已列入黑名单！');
                    } else {
                        $requestArray[$k] = $key . $delimiter . $lastTime . $delimiter . ($requestNumber+1) . "\r\n";
                    }
                } else {
                    $requestArray[$k] = $key . $delimiter . $nowTime . $delimiter . '1' . "\r\n";
                }
                break;
            }
        }
        if (!$isExist) {
            $requestArray[] = $key . $delimiter . $nowTime . $delimiter . '1' . "\r\n";
        }
        Common_Tool::writeFileFromString($allowFile, implode('', $requestArray));
        
        // 判断刷新频率
        $allowFile = ROOT_PATH . '/data/log/allow.log';
        if (is_file($allowFile)) {
            $requestArray = file($allowFile);
        } else {
            $requestArray = array();
        }
        $isExist = false; // 是否存在日记文件中，默认false：新用户；true：已有记录
        $delimiter = ' '; // 只能为一位
        $length = strlen($delimiter);
        foreach ($requestArray as $k=>$v) {
            $requestKey = substr($v, 0, 32);
            if ($requestKey == $key) {
                $isExist = true;
                $lastTime = substr($v, (32+$length), 10);
                if (($nowTime-$lastTime) < $allowTime) {
                    $requestNumber = substr($v, (42+2*$length));
                    $requestNumber = intval($requestNumber);
                    if ($requestNumber > $allowNumber) { // 已经超过最大次数，需要警告提示，并加到限制规定时间能不能再访问
                        // TODO 加入限制访问时段内
                        
                        exit('警告：不要刷新的太频繁！');
                    } else {
                        $requestArray[$k] = $key . $delimiter . $lastTime . $delimiter . ($requestNumber+1) . "\r\n";
                    }
                } else {
                    $requestArray[$k] = $key . $delimiter . $nowTime . $delimiter . '1' . "\r\n";
                }
                break;
            }
        }
        if (!$isExist) {
            $requestArray[] = $key . $delimiter . $nowTime . $delimiter . '1' . "\r\n";
        }
        Common_Tool::writeFileFromString($allowFile, implode('', $requestArray));
    }
    
    /**
     * 写用户请求记录
     * @param string $ip 用户IP
     * @param string $url 请求完整路径
     * @param string $userAgent 用户头信息
     * @param string $urlPath 请求url的目录部分，不包括参数
     * @param string $refererUrl 来源url
     */
    private function _writeRequestLog($ip, $url, $userAgent, $urlPath, $refererUrl = '') {
        $string = '时间：' . date('Y-m-d H:i:s') . '  IP：' . $ip . '； 请求路径：' . $urlPath . 
                  '  完整URL：' . $url . '  USER_AGENT:' . $userAgent . '  来源网址：' . $refererUrl . "\r\n";
        $filePath = ROOT_PATH . '/data/log/request.log';
        $boolean = Common_Tool::writeFileFromString($filePath, $string, true);
        if (!$boolean) {
            die(Common_Tool::getError());
        }
    }
	
	/**
	 * 获取视图类
	 * @return BView
	 */
	public function getView() {
		return $this->_view;
	}
	
	/**
	 * 渲染视图(默认是本模块本控制器下的本action.php)
	 * @param string $path 需要渲染的视图文件路径（相对V文件夹的路径；不包括后缀名.php，如： /Layouts/left）
	 */
	public function render($path = null) {
		$this->_view->display($path);
	}
	
	/**
	 * 获取所有Get方法传过来的参数
	 * @return array
	 */
	public function getParams() {
		return $this->_params;
	}
	
	/**
	 * 获取Get方法传过来的单个参数
	 * @param string $k
	 * @param mixed $defaultValue
	 * @return mixed
	 */
	public function getParam($k, $defaultValue = null) {
	    if (isset($this->_params[$k])) {
	        return $this->_params[$k];
	    } else {
	        return $defaultValue;
	    }
	}
	
	/**
	 * 获取Post方法传过来的参数
	 * @param string $k
	 * @param mixed $defaultValue
	 * @return mixed
	 */
	public function getPost($k, $defaultValue = null) {
	    if (isset($_POST[$k])) {
	        return $_POST[$k];
	    } else {
	        return $defaultValue;
	    }
	}
	
	/**
	 * 传值到视图
	 * @param string $key 健
	 * @param mixed $value 值
	 */
	public function __set($key, $value) {
	    $this->_view->$key = $value;
	}
	
}
