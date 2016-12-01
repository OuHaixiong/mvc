<?php

/**
 * 测试
 * @author bear
 * @copyright http://maimengmei.com
 */
class C_Test extends BController
{
	public function init() {
//         parent::init();
        
	}
	
	public function index() {
//        $newfile = new M_New_Newfile();
//        $newfile->mm();
        $supportLanguages = array('cn', 'en', 'zh-cn', 'zh');
        Common_Tool::prePrint(Common_Tool::getClientLanguage($supportLanguages));
	}
	
	/**
	 * 猴子选大王
	 */
	public function numKing() {
	    $this->_view->setIsView();
	    $this->_view->setIsLayout();
		//测试100只猴子 出局报数5 算出猴王的编号为47
		var_dump($this->monkeyKing(9, 5));
	}
	
	/**
	 * 猴子选大王
	 * @param int $m 猴子总数
	 * @param int $n 出局报数
	 */
	private function monkeyKing($m, $n) {
	    for ($i=1; $i<=$m; $i++) {
	        $arr[] = $i; // 把所有的猴子存在一个数组
 	    }
 	    
 	    $i = 0; // 数组指针
 	    while(count($arr)>1) {
 	        if (($i+1)%$n == 0) { // 出局了,直接删除
 	            unset($arr[$i]);
 	        } else { // 未出局的放在数组的后面组成新的数组进行下次循环
 	            array_push($arr, $arr[$i]);
 	            unset($arr[$i]);
 	        }
 	        $i++;
 	    }
 	    return $arr;
	}
	
	public function testPost() {
        $result = array();
        $result['status'] = 1;
        $result['msg'] = '返回数据成功';
        $result['data'] = array(
            'rowset' => array(
                array('id'=>8, 'name'=>'欧海雄'),
                array('id'=>9, 'name'=>'李欢')
            ),
            'total' => 108,
            'page' => 2
        );
        $jsonString = json_encode($result);
        print_r($jsonString);
        echo '<br /><pre>';
        print_r(json_decode($jsonString));
        echo '</pre>';
	}
	
	/**
	 * 测试用的表单
	 */
	public function testForm() {
	    $this->render();
	}

	/**
	 * 测试z轴，遮罩层
	 */
	public function zIndex() {
	    $this->render();
	}
	
	public function testRep() {
	    $str = "<a href='aa' alt=\"ni你们啊你好\">hi 你</a>你fd 我的<你的 \"你的\"<img alt='ffxx你' title=\"你d\">";
	    var_dump($str);
	    $pattern = '/你/';
	    $replacement = '他';
	    $strstr = preg_replace($pattern, $replacement, $str);
	    var_dump($strstr);
	    $pattern = '/alt=\'([^他]*)他([^\']*)\'/'; // alt='ffxx他'
// 	    $pattern = '/alt=(\'|\")([^他]*)他([^\']*)(\'|\")/'; // alt='ffxx他'
	    $replacement = 'alt="$1你$2"';
	    $str = preg_replace($pattern, $replacement, $strstr);
	    var_dump($strstr);
	    $pattern = '/alt=\"([^他]*)他([^\"]*)\"/'; // alt=\"ni你们\"
	    $str = preg_replace($pattern, $replacement, $str);
	    var_dump($strstr);
	    $pattern = '/title=\"([^他]*)他([^\"]*)\"/';
	    $replacement = 'title="$1你$2"';
	    $str = preg_replace($pattern, $replacement, $str);
	    var_dump($str);
	    
	    
	    $pattern = "/(alt|title)\s*=\s*\"([^\"]*)(你)([^\"]*)\"/";
	    
	    $count = preg_match_all($pattern, $str, $matches, PREG_SET_ORDER|PREG_OFFSET_CAPTURE);
	    print_r($matches);
	    ///预先替换
	    $noise = array();
	    for ($i=$count-1; $i>-1; --$i)
	    {
	        $key = '___noise___'.sprintf('% 5d', count($noise)+1000);
	         
	        $idx = 0;print_r($matches[$i][0]);
	        $noise[$key] = $matches[$i][$idx][0];
	        $str = substr_replace($str, $key, $matches[$i][$idx][1], strlen($matches[$i][$idx][0]));
	    }
	    print_r($noise);
	    echo "\n".$str;
	    //替换
	    $str = str_replace("你","他",$str);
	    //
	    //恢复
	    while (($pos=strpos($str, '___noise___'))!==false){
	        $key = '___noise___'.$str[$pos+11].$str[$pos+12].$str[$pos+13].$str[$pos+14].$str[$pos+15];
	        echo "pos=".$pos."\n key=".$key;
	        if (isset($noise[$key]))
	        {
	            $str = substr($str, 0, $pos).$noise[$key].substr($str, $pos+16);
	        }
	    }
	    echo $str;
	    
	}

    /**
     * 测试跨域加载页面，并读取密码
     * 经过测试，同源策略下iframe下面的元素是可以获取的，非同源是无法获取的，提示没有权限
     * 在iframe中获取父窗口的元素
     * window.parent.document.getElementById("父窗口的元素ID").click();
     */
    public function iframe() {
        $this->render();
    }
    
    /**
     * 测试跨域加载页面，内嵌页面
     */
    public function innerIframe() {
    	$this->_view->setIsLayout();
        $this->render();
    }

    /**
     * 获取html中图片img的src属性值
     */
    public function isImg() {
        $arrayHttpImg[] = ' http://4r4weyxd/product_images/uploaded_images/stem-header-01.php ';
        $arrayHttpImg[] = ' https://img.alicdn.com/tps/TB1A5jbMVXXXXboXFXXXXXXXXXX-476-260.jpg_240x5000q100.jpg';
        
        $folderPath = '/temp/abc';
        $result = Common_Tool::httpImg2LocalFolder($arrayHttpImg, $folderPath);
        var_dump($result);exit;
    }
    
    /**
     * 临时测试
     */
    public function test() {
        $url = 'http://m.com/en';
        $savePath = ROOT_PATH . '/data/log/curl_get_cookies';
        $str = Common_Tool::getCookie($url, $savePath);
        var_dump($str);exit;
    }


}
