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
        $email = 'addd@dd_d.com.cn';
        $boolean = Common_Validate_Base::isEmail($email);
        
        var_dump($boolean);
        $boolean = Common_Tool::isEmail($email);
        var_dump($boolean);
//         $supportLanguages = array('cn', 'en', 'zh-cn', 'zh');
//         Common_Tool::prePrint(Common_Tool::getClientLanguage($supportLanguages));

	    if (Common_Tool::isPost()) {
	        
	        var_dump($_POST['ck']);exit;
	    }
	    $this->render();
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
        $url = 'http://a.yunex.io/api/coin/bonus/snap/?count=3&day=&start=1';
		
		$httpHeader = array('Content-Type' => 'application/json');
		$method = 'GET';
        $userAgent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:49.0) Gecko/20100101 Firefox/49.0';
// Mozilla/5.0 (Macintosh; Intel Mac OS X 10.12; rv:59.0) Gecko/20100101 Firefox/59.0
		// $result = Common_HttpClient::sendRequest($url, $params, $method, $httpHeader, '', '', $userAgent, false, 20);
// 		sendRequest($url, $data = null, $method = 'GET', $httpHeader = array(), $cookie = array(), $refererUrl = '', $userAgent = '', $proxy = false, $timeout = 30) {

		$params = array(
		    'count' => 3,
		    'day' => '',
		    'start' => 1,
		);
		$str = '';
		foreach ($params as $k=>$v) {
		    $str .= $k . '=' . urlencode($v) . '&';
		}
		$str = rtrim($str, '&');
		$x_ts = time();
		$x_nonce = $this->random(3);
		$app_secrete = 'eYe5NbeLqUeVmHuMyk6NM4Lms8IC3cl64z2wmLgsu2JwwIzC8PSPk2ZqHn80RrFR';
		$app_key ='cfeeb463d508229b90ad39635d29df13596a3a6240826535ccc05384c66e49e6';
		$str .= $x_ts . $x_nonce . $app_secrete;

		$sha256 = hash('sha256', $str, true);
		$signString = bin2hex($sha256);

		$httpHeader['-x-ts'] = $x_ts;
		$httpHeader['-x-nonce'] = $x_nonce;
		$httpHeader['-x-key'] = $app_key;
		$httpHeader['-x-sign'] = $signString;
		$params = array();
//         $result = $this->sendRequest($url, $params, $method, $httpHeader, '', '', $_SERVER['HTTP_USER_AGENT']);
		

		$postParams = array(
		    'bonus'=> array(
		        array('to_uid'=>142, 'symbol'=>'usdt', 'amount'=>'0.13', 'date'=>'2018-10-18', 'order_id'=>'YBO201810180014'),
		        array('to_uid'=>142, 'symbol'=>'eth',  'amount'=>'0.02', 'date'=>'2018-10-18', 'order_id'=>'YB0201810180015')
            )
		);
		$postParamsString = json_encode($postParams);
		$url = 'http://a.yunex.io/api/coin/bonus/transfer/';
		$method = 'POST';
		$app_key = '77746177327d86cdcd92935e78de68f8f858b6259880d8c4ad911fee33537fbc';
		$app_secrete = 'SJQe3INeRe2KK2mTi3D0aisYhBbCez2nWflhSJUCTw8C87rNQaAZ23XnIFMqwz5u';
		$str = '';
		$str = $postParamsString . $x_ts . $x_nonce . $app_secrete;
		var_dump($str);
		$sha256 = hash('sha256', $str, true);
		$httpHeader['-x-key'] = $app_key;
		$httpHeader['-x-sign'] = bin2hex($sha256);
		var_dump($httpHeader['-x-sign']);
		$result = $this->sendRequest($url, $postParams, $method, $httpHeader, '', '', $userAgent, false, 20); 

		
        
        
        var_dump($result);
    }
    
    public function random($length = 6) {
        $hash = '';
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
        mt_srand((double)microtime()*1000000); // 播下一个更好的随机数发生器种子
        //自 PHP 4.2.0 起，不再需要用 srand() 或 mt_srand() 给随机数发生器播种 ，因为现在是由系统自动完成的。
        $len = strlen($chars)-1;
        for ($i=0; $i<$length; $i++) {
            $hash .= $chars[mt_rand(0, $len)];
        }
        return $hash;
    }
    
    
    public function sendRequest($url, $data = null, $method = 'GET', $httpHeader = array(), $cookie = array(), $refererUrl = '', $userAgent = '', $proxy = false, $timeout = 30) {
        $url = trim($url);
        $method = strtoupper($method);
        if (!in_array($method, array('GET', 'POST'))) {
            return false;
        }
        if ('GET' === $method) { // 如果是get请求，并且需要发送数据，就把数据拼接在url后面
            if (!empty($data)) {
                if (is_string($data)) {
                    $url .= (strpos($url, '?') === false ? '?' : '') . $data;
                } else {
                    $url .= (strpos($url, '?') === false ? '?' : '') . http_build_query($data);
                }
            }
        }
        $ch = curl_init($url); // curl_setopt($ch, CURLOPT_URL, $url); // 设置请求（抓取）url
        curl_setopt($ch, CURLOPT_HEADER, 0); // 不返回header部分（设置头文件的信息作为数据流输出）
        curl_setopt($ch, CURLOPT_AUTOREFERER, true); // 当根据Location:重定向时，自动设置header中的Referer:信息
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 将curl_exec()获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout); // 设置超时限制防止死循环
        //		curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        $isFormData = false; // Content-Type: multipart/form-data
        $isJson = false; // Content-Type: application/json
        if (!empty($httpHeader)) { // 请求头信息
            $headerData = array();
            foreach ($httpHeader as $k=>$v) {
                if ((strtolower($k) == 'content-type') && ($v == 'application/json')) {
                    $isJson = true;
                }
                if ((strtolower($k) == 'content-type') && ($v == 'multipart/form-data')) {
                    $isFormData = true;
                }
                $headerData[] = $k . ':' . $v; // array('Content-Type:application/json')
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headerData); // 声明请求头信息
            //            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        }
        if ($userAgent) {
            curl_setopt($ch, CURLOPT_USERAGENT, $userAgent); // 模拟用户使用的浏览器代理
        }
        // 判断是否https请求
        $scheme = parse_url($url, PHP_URL_SCHEME);
        if ('https' === $scheme) { // 是https请求
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 规避对认证证书来源的检查(不验证证书)
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在。这里是跳过host验证
        }
        if ((is_array($cookie)) && (!empty($cookie))) { // 请求cookie值
            $cookieData = array();
            foreach ($cookie as $k=>$v) {
                $cookieData[] = $k . '=' . $v;
            }
            $cookieData = implode(';', $cookieData);
            curl_setopt($ch, CURLOPT_COOKIE, $cookieData);
        }
        if ('POST' === $method) { // post请求
            curl_setopt($ch, CURLOPT_POST, 1); // curl_setopt($ch, CURLOPT_POST, true);
            //             curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');  // 貌似这个写法和上面是一样的（待验证）
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
            curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
            if (!empty($data)) {
                if (is_string($data)) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                } else {
                    if ($isJson) {
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                    } else if ($isFormData) {
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // 数组对应multipart/form-data，也是默认的
                    } else {
                        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); // http_build_query对应application/x-www-form-urlencoded
                    }
                }
            }
        } else {
            //             curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            //             curl_setopt($ch, CURLOPT_POST, false);
        }
        if ($refererUrl) {
            curl_setopt($ch, CURLOPT_REFERER, $refererUrl); // 来源网址
        }
        if ($proxy) {
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
        }
        $response = curl_exec($ch); // 执行命令（请求）
        $info = curl_getinfo($ch);
        //         var_dump($response);var_dump(curl_error($ch));var_dump($info);exit;
        //        TODO 如果返回码不是200，写异常日记
    
        //         $nowTime = date('Y-m-d H:i:s');
        //         $logFilePath = LOGS_PATH . '/http_response_err.log';
        //         Tool::writeFileFromString($logFilePath, $nowTime . ' 调用http请求，错误日记是：', true);
        //         $string = Tool::printVariable($info);
        //         Tool::writeFileFromString($logFilePath, $string, true);
    
        curl_close($ch); // 关闭请求
        return $response;
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

    public function test2() {

    }
    
    private function printArr($arr) {
        $str = '';
        foreach ($arr as $k=>$v) {
            $str .= $v . ',';
        }
        trim($str, ',');
        echo $str . '<br />';
    }
    
    
}
