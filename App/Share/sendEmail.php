<?php
$dirPath = dirname(__FILE__); // /data/www/mblock.cc/docs
require_once $dirPath . '/class.phpmailer.php';
$emailConfig = array();
$emailConfig['host'] = 'smtp.exmail.qq.com';
$emailConfig['port'] = 25;
$emailConfig['username'] = 'bear.ou@makeblock.com';
$emailConfig['password'] = '@Bear123';
$emailConfig['name'] = 'Makeblock Customer Service';

$appendixPath = $dirPath . '/edu_wordpress.sql';
$addressList = array(
    'bear.ou@makeblock.com',
    'tongsen@makeblock.com'
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
    $mail->Subject = '今日mblock.cc数据库备份';
    $mail->MsgHTML($today . ' mblock.cc数据库备份，详见附件。');
    foreach ($addressList as $address) {
        $mail->AddAddress($address);
    }
    $mail->AddAttachment($appendixPath, 'edu_wordpress_' . $today . '.sql'); // 添加附件,并指定名称
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
