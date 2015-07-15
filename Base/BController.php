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
        $userIp = Common_Tool::getIP(); // 获取当前访问者的ip
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $requestUrl = Common_Tool::getCurrentUrl(); // http://mvc.com/ueditor/ueditor1_4_3?ab=bc&cc=d&q=&ni=8
        $urlArray = parse_url($requestUrl);   //  $urlArray['path'] = $_SERVER['REDIRECT_URL'] = /ueditor/ueditor1_4_3
        $key = $userIp . $urlArray['path'] . $userAgent;
        $key = md5($key);
        // 判断用户的ip是否在白名单中（这里使用文件进行保存，后续最好使用redis之类的缓存进行操作）
        
        // 判断用户的ip是否在黑名单中
//         Common_Tool::prePrint($_SESSION);
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
