<?php

/**
 * @desc 视图渲染类(特别注意，视图文件不能互相包含，不然就陷入死循环);所有的模板都共享参数（视图中的变量任何地方都可以获取到）
 * 貌似，只要布局，不要视图的需求很少，所以这里也没有实现
 * @author bear
 * @version 1.1.0  2015-04-13 15:09
 * @created 2012-09-24 17:08
 */
class BView
{
	/**
	 * 渲染页面路径
	 * @var string
	 */
// 	private $_renderPath = null;
	
	/**
	 * 是否需要视图
	 * @var boolean true：需要视图；false：不需要视图
	 */
	private $_viewFlag = true;
	
	/**
	 * 是否需要布局文件（布局视图）
	 * @var boolean true:需要布局；false：不需要布局文件
	 */
	private $_layoutFlag = true;
	
	/**
	 * 布局文件绝对路径
	 * @var string
	 */
	private $_layoutPath = null;
	
	/**
	 * url路由对象
	 * @var BUrlRule
	 */
	static private $_urlRule;
	
	/**
	 * 渲染页面
	 * @param string $path 需要渲染的视图文件路径,相对V文件夹的路径(不包括后缀名.php)，如： /Layouts/left
	 * @return string
	 */
	public function render($path) {
        $path = trim($path);
        if (empty($path)) {
            return '';
        }
        $path = trim($path, '/');
		$path = '/' . $path . '.php';
		$renderPath = APP_PATH . '/V' . $path;
		if (!is_file($renderPath)) {
		    die('视图文件无法找到;不存在此视图文件：' . $path);
		}
		
		ob_start();
		include $renderPath;
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
	
	/**
	 * 渲染布局和页面(默认是有视图和布局的)
	 * @param string $path 需要渲染的视图文件路径（相对V文件夹的路径；不包括后缀名.php，如： /Layouts/left）
	 * 默认null：渲染当前模块下的视图文件，如： /module/controller/action.php
	 */
	public function display($path = null) {
	    if (!$this->_viewFlag) { // 是否需要渲染视图
	        return;
	    }
	    $path = trim($path);
        if (empty($path)) {
            $module = BApp::getModule();
	        if ($module == 'Default') {
	            $module = '';
	        }
	        $path = $module . '/' . BApp::getController() . '/' . BApp::getAction();
	    }
        $layoutContent = $this->render($path);
        if ($this->_layoutFlag) { // 渲染布局
            include $this->getLayoutPath();
        } else {
            echo $layoutContent;
        }
	}
	
	/**
	 * 设置渲染视图文件路径
	 * @param string $path
	 */
// 	public function setRenderPath($path) {
// 		$this->_renderPath = $path;
// 	}
	
	/**
	 * 获取渲染视图文件路径
	 * @return NULL | string
	 */
// 	public function getRenderPath() {
// 		return $this->_renderPath;
// 	}
	
	/**
	 * 设置是否需要视图文件
	 * @param boolean $flag 默认false：不需要视图文件；true：需要视图文件
	 */
	public function setIsView($flag = false) {
		$this->_viewFlag = $flag;
	}
	
	/**
	 * 设置是否需要布局文件（布局视图）
	 * @param boolean $flag 默认false：不需要布局文件；true：需要布局文件
	 */
	public function setIsLayout($flag = false) {
		$this->_layoutFlag = $flag;
	}
	
	/**
	 * 设置布局文件的路径
	 * @param string $path 一定要绝对路径
	 */
	public function setLayout($path) {
		$this->_layoutPath = $path;
	}
	
	/**
	 * 设置布局文件,这里只需传入 /V/Layouts/ 下的完整文件名
	 * @param string $fileName Layouts下的文件名
	 */
	public function setLayoutFile($fileName) {
		$this->_layoutPath = APP_PATH . '/V/Layouts/' . $fileName;
	}
	
	/**
	 * 获取布局文件路径
	 * 默认为应用目录下的/V/Layouts/layout.php
	 * @return string
	 */
	public function getLayoutPath() {
		if ($this->_layoutPath === null) {
			$this->_layoutPath = APP_PATH . '/V/Layouts/layout.php';
		}
		return $this->_layoutPath;
	}
	
	/**
	 * 获取视图模板中值
	 * 当不存在此key值时，返回空字符串
	 * @param string $key
	 * @return string 
	 */
	public function __get($key) {
	    if (isset($this->$key)) {
	        return $this->$key;
	    } else {
	        return '';
	    }
	}
	
	/**
	 * 调用路由规则，生成url地址
	 * @param string $route 路由，由 模块/控制器/行为 组成 且不能省略（index）
	 * @param array $params 参数
	 * @param string $ampersand 连接两个参数之前的&符号
	 * @return string
	 */
    public function createUrl($route, $params = array(), $ampersand='/') {
        if (!(self::$_urlRule instanceof BUrlRule)) {
            self::$_urlRule = new BUrlRule();
        }
        return self::$_urlRule->createUrl($route, $params, $ampersand);
    }
	
    /**
     * 对输出的字符串进行编码并输出（主要为了防止XSS攻击）
     * @param string $string 需要输出的字符串
     * @param boolean $isReturn 是否返回字符串，默认false：不返回，直接输出；true：返回字符串
     * @return null | string
     */
    public function encodeEcho($string, $isReturn = false) {
        if ($isReturn) {
            return htmlspecialchars($string, ENT_QUOTES, 'UTF-8'); // htmlentities($string, [ENT_COMPAT])
        } else {
            echo htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
        }
    }
	
}
