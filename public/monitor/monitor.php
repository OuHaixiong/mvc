<?php

$url = 'http://www.mblock.cc/zh-home/';
$timeout = 10;
$maxExecuteTime = 5; // 超过此时间，发邮件
$method = 'GET';
$data = null;

$startTime = microtime(true);
/**
 * 通过curl发送HTTP请求
 */
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
$ch = curl_init($url); // curl_setopt ( $ch, CURLOPT_URL, $url );
curl_setopt($ch, CURLOPT_HEADER, 0); // 不返回header部分
curl_setopt($ch, CURLOPT_AUTOREFERER, true); // 当根据Location:重定向时，自动设置header中的Referer:信息
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 将curl_exec()获取的信息以文件流的形式返回，而不是直接输出。
curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
if ('POST' === $method) {
    curl_setopt($ch, CURLOPT_POST, 1); // curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
    curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
    if (!empty($data)) {
        if (is_string($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        } else {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data)); // http_build_query对应application/x-www-form-urlencoded
        }
    }
}
curl_exec($ch);
$info = curl_getinfo($ch);
curl_close($ch);

$httpCode = $info['http_code'];
$endTime = microtime(true);
$executeTime = $endTime - $startTime;
if ($httpCode != 200 || ($executeTime > $maxExecuteTime)) { //非200或超时，即发邮件
    $messageHtml = date('Y-m-d H:i:s') . "\n" .' www.mblock.cc状态：' . $httpCode . '，执行时间（秒）：' . $executeTime;
    
    $dirPath = dirname(__FILE__); // /data/www/mblock.cc/docs
    require_once $dirPath . '/class.phpmailer.php';
    $emailConfig = array();
    $emailConfig['host'] = 'ssl://smtp.exmail.qq.com';
    $emailConfig['port'] = 465;
    $emailConfig['username'] = 'no-reply@makeblock.com';
    $emailConfig['password'] = 'Maker2016';
    $emailConfig['name'] = 'Makeblock Customer Service at Bear';
    
    //$appendixPath = $dirPath . '/education_makeblock_db_backup.tar.gz';
    $addressList = array(
            'bear.ou@makeblock.com',
            'tongsen@makeblock.com',
            'wuzhicong@makeblock.com'
    );
    
    $today = date('Y-m-d');
    try {
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->SMTPAuth = true;
        $mail->Host = $emailConfig['host'];
        $mail->Port = $emailConfig['port'];
        $mail->Username = $emailConfig['username'];
        $mail->Password = $emailConfig['password'];
        $mail->SetFrom($emailConfig['username'], $emailConfig['name']); // 发件人邮箱和发件人
        $mail->Subject = '今日mblock.cc教育站异常';
        $mail->MsgHTML($messageHtml);
        foreach ($addressList as $address) {
            $mail->AddAddress($address);
        }
        //$mail->AddAttachment($appendixPath, 'education_makeblock_db_backup_' . $today . '.tar.gz'); // 添加附件,并指定名称
        $boolean = $mail->Send();
        if ($boolean == false) { // 发送失败
            print_r($mail->ErrorInfo);
        } else {
            echo 'Send email success！！';
        }
    } catch (Exception $e) {
        echo '发生错误了：';
        print_r($e);die();
    }

}



















