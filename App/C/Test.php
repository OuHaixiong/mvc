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
     * 测试curl请求
     */
    public function testCurl() {
        $url = 'https://openlab.makeblock.com/user/delete';
		$params = array(
            'loginname' => 'ouhaixiong@bear.com',
            'accessKey' => 'xxx'
        );
		$httpHeader = array('Content-Type' => 'application/json');
		$method = 'POST';
        $userAgent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0';
// Mozilla/5.0 (Macintosh; Intel Mac OS X 10.12; rv:59.0) Gecko/20100101 Firefox/59.0
		// $result = Common_HttpClient::sendRequest($url, $params, $method, $httpHeader, '', '', $userAgent, false, 20);
        $result = Common_HttpClient::sendRequest($url, $params, $method, $httpHeader, '', '', $_SERVER['HTTP_USER_AGENT']);
		
		// $url = 'https://openlab.makeblock.com';
		// $method = 'GET';
		// $result = Common_HttpClient::sendRequest($url, '', $method, '', '', '', $userAgent, false, 20); 
		// $result = Common_HttpClient::sendRequest($url, '', $method); // 如果是https的话，最好带上user_agent
        var_dump($result);
    }
    
    /**
     * 600个人站一排，每次随机杀掉一个奇数位的人，几号最安全？
     * 反正不是第一个人，靠一半的后面的人几率大些
     */
    public function killMan() {
        $sum = 600; // 总人数
        $liveTimes = array(); // 存活统计
        for($i=1; $i<=$sum; $i++) {
            $liveTimes[$i] = 0;
        }
        
        for ($p=0; $p<30000; $p++) {
            $allMan = array();
            for($i=1; $i<=$sum; $i++) {
                $allMan[] = $i;
            }
            while (count($allMan) != 1) { // 每次随机杀死一个奇数位的人
                if (count($allMan) == 2) {
                    array_splice($allMan, 0, 1);
                    continue;
                }
                $randNumber = mt_rand(0, (count($allMan)-1));
                $remainder = $randNumber%2;
                if ($remainder) { // 下标为偶数的数，即是奇数位
                } else {
                    $randNumber = $randNumber-1;
                }
                array_splice($allMan, $randNumber, 1);
            }
            $liveTimes[$allMan[0]] += 1;
        }
        
        //var_dump($liveTimes);
        echo '最有可能存活（存活概率最高）的是：';
        $max = max($liveTimes);
        $liveTimes = array_flip($liveTimes);
        var_dump($liveTimes[$max]);
    }

    /**
     * 测试ga设置事件代码
     */
    public function ga() {
        $this->title = '测试ga事件跟踪代码';
        $this->_view->setLayoutFile('gaLayout.php');
        $this->render();
    }
    
    /**
     * 测试读取区域信息
     */
    public function readLocation() {
/*         $filePath = ROOT_PATH . '/../data/locationListEnglish.xml';
        $xmlString = file_get_contents($filePath);
        $xmlObj = new SimpleXMLElement($xmlString);
        $country = '';
        foreach ($xmlObj->CountryRegion as $k=>$v) {
            $attributes = $v->attributes();
            $country .= "\n" . $attributes['Name'];
        }
        $country = trim($country, "\n");
        $countryWriteFilePath = ROOT_PATH . '/data/localtionListEnglish';
        file_put_contents($countryWriteFilePath, $country);
        
        $filePath = ROOT_PATH . '/../data/locationListChinese.xml';
        $xmlString = file_get_contents($filePath);
        $xmlObj = new SimpleXMLElement($xmlString);
        $country = '';
        foreach ($xmlObj->CountryRegion as $k=>$v) {
            $attributes = $v->attributes();
            $country .= "\n" . $attributes['Name'];
        }
        $country = trim($country, "\n");
        $countryWriteFilePath = ROOT_PATH . '/data/localtionListChinese';
        file_put_contents($countryWriteFilePath, $country); */
        $locationArea = new M_LocationArea();
//         $boolean = $locationArea->loadFileToDatabase();
        $boolean = $locationArea->loadFileToDatabaseForEnUs();
        var_dump($boolean);
    }
    
    /**
     * 测试上传图片
     */
    public function upload() {
        $this->render();
    }

}
