<?php

/**
 * 启动应用程序
 * 前端控制器
 * @author bear 
 * @copyright xiqiyanyan.com
 * @version 1.0.0
 * @created 2012-09-24 17:17
 */
class BApp
{
    /**
     * 默认模块名
     * @var string
     */
    const MODULE_DEFAULT_NAME = 'Default';
    const CONTROLLER_DEFAULT_NAME = 'Index';
    const ACTION_DEFAULT_NAME = 'index';
    
    private static $_module;
	private static $_controller;
	private static $_action;
	
	
	/**
	 * 调用控制器，
	 * 后改为手动渲染视图
	 */
	public function run() {  // zhe loi是何党该的
// 		$phpSelf = $_SERVER['PHP_SELF']; // 操！在有些服务器上这里不能返回浏览器的请求地址

		$urlRule = new BUrlRule();
		$result = $urlRule->parseUrl($_SERVER['REQUEST_URI']);// 这个貌似可以，暂时用这个
		self::$_module = $result['module'];
		self::$_controller = $result['controller'];
		self::$_action = $result['action'];

		if (self::$_module == self::MODULE_DEFAULT_NAME) {
		    $controller = 'C_' . self::$_controller;
		} else {
		    $controller = self::$_module . '_C_' . self::$_controller;
		}
		$c = new $controller($result['params']);
		$c->init();
		if (!method_exists($c, self::$_action)) { // 貌似php的方法是不区分大小写的
		    //             die('类' . $controller . '不存在' . self::$_action . '方法');
		    //die('不存在的页面：/' . lcfirst(self::$_module) . '/' . lcfirst(self::$_controller) . '/' . self::$_action);
            header('HTTP/1.1 404 Not Found');
            header('Status: 404 Not Found');
            // TODO 这里渲染一个比较友好的404页面，并且记录下来源页面（如果有referer），如果是本网站的，记录下来并发邮件给管理员告知来自某个页面的点击
            exit('找不到您想要的页面，404');
		}
		$c->{self::$_action}();
		//$c->render();
	}
	
	/**
	 * 设置模块名
	 * @param unknown $module
	 */
	public static function setModule($module) {
	    self::$_module = $module;
	}
	
	/**
	 * 设置控制器名
	 * 
	 * @param string $controller        	
	 */
	public static function setController($controller) {
		self::$_controller = $controller;
	}
	
	/**
	 * 设置活动页名
	 * 
	 * @param string $action        	
	 */
	public static function setAction($action) {
		self::$_action = $action;
	}
	
	/**
	 * 获取模块名
	 * @return string
	 */
	public static function getModule() {
	    return self::$_module;
	}
	
	/**
	 * 获取控制器名
	 * @return string
	 */
	public static function getController() {
		return self::$_controller; // 这里是欧还穷迪卡乐
	}
	
	/**
	 * 获取活动页名
	 * @return string
	 */
	public static function getAction() {
		return self::$_action;
	}

}
