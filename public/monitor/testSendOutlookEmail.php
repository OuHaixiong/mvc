<?php
$dirPath = dirname(__FILE__);
require_once $dirPath . '/class.phpmailer.php';
$emailConfig = array();
// $emailConfig['host'] = 'smtp.office365.com';
$emailConfig['host'] = 'smtp-mail.outlook.com';
$emailConfig['port'] = 587;
$emailConfig['username'] = 'ouyanghaixiong@outlook.com';
$emailConfig['password'] = '****';
$emailConfig['name'] = 'yunfan at Bear';

// $appendixPath = $dirPath . '/education_makeblock_db_backup.tar.gz';
$addressList = array(
    'weilijian@yunfan.com',
    'ouhaixiong@yunfan.com',
);

$today = date('Y-m-d');
try {
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPSecure = 'tls'; // 设置加密方式，可以为空，也可以为ssl或tls
    $mail->CharSet = 'UTF-8';
    $mail->SMTPAuth = true;
    $mail->Host = $emailConfig['host'];
    $mail->Port = $emailConfig['port'];
    $mail->Username = $emailConfig['username'];
    $mail->Password = $emailConfig['password'];
    $mail->SetFrom($emailConfig['username'], $emailConfig['name']); // 发件人邮箱和发件人
    $mail->Subject = '测试发送邮件';
    $mail->MsgHTML($today . ' 测试测试看看。');
    foreach ($addressList as $address) {
        $mail->AddAddress($address);
    }
//     $mail->AddAttachment($appendixPath, 'education_makeblock_db_backup_' . $today . '.tar.gz'); // 添加附件,并指定名称
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
