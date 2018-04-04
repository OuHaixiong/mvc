<?php
$dirPath = dirname(__FILE__); // /data/www/mblock.cc/docs
require_once $dirPath . '/class.phpmailer.php';
$emailConfig = array();
$emailConfig['host'] = 'ssl://smtp.exmail.qq.com';
$emailConfig['port'] = 465;
$emailConfig['username'] = 'no-reply@makeblock.com';
$emailConfig['password'] = 'Maker2016';
$emailConfig['name'] = 'Makeblock Customer Service at Bear';

$appendixPath = $dirPath . '/education_makeblock_db_backup.tar.gz';
$addressList = array(
    'bear.ou@makeblock.com',
    'tongsen@makeblock.com',
    'susie.xu@makeblock.com'
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
    $mail->Subject = '今日官网和教育站数据库备份';
    $mail->MsgHTML($today . ' 官网和教育站数据库备份，详见附件。');
    foreach ($addressList as $address) {
        $mail->AddAddress($address);
    }
    $mail->AddAttachment($appendixPath, 'education_makeblock_db_backup_' . $today . '.tar.gz'); // 添加附件,并指定名称
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
