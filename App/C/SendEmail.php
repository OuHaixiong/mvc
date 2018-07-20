<?php

/**
 * 测试发送邮件
 * @author Bear[258333309@163.com]
 * @version 1.0
 * @created 2018年7月20日 下午5:09:25
 */
class C_SendEmail extends BController
{
	public function init() {
        parent::init();
        
	}
	
	/**
	 * 测试发送邮件
	 */
	public function index() {
        $configs = array();
        $configs['host'] = 'smtp.office365.com';
        $configs['port'] = 587;
        $configs['username'] = 'ouyanghaixiong@outlook.com';
        $configs['password'] = 'Xx830815Ou';
        $configs['fromAddress'] = 'ouyanghaixiong@outlook.com';
        $configs['fromName'] = 'company at Bear';
        $configs['secure'] = 'tls';
        
        $subject = '来个测试主题';
        $html = '<h4>测试就测试呗</h4><p>这里是测试内容<br />来点不一样的</p>';
        $addressList = 'ouhaixiong@yunfan.com';
        $appendix = array();
        $appendix[] = array(
            'path' => ROOT_PATH . '/../data/Config.zip',
            'name' => 'config.zip'
        );
        $appendix[] = array(
            'path' => ROOT_PATH . '/../data/mEos_zh-CN.csv',
            'name' => 'mEos_zh-CN.csv',
        );
        $appendix[] = array(
            'path' => ROOT_PATH . '/../data/locationListEnglish.xml',
            'name' => 'locationListEnglish.xml'
        );
// 	    $sendEmail = new Share_SendEmail($configs);
        $sendEmail = new Share_SendEmail();
        $boolean = $sendEmail->send($subject, $html, $addressList, $appendix);
        if ($boolean) {
            echo 'Send email successful!!!!';
        } else {
            print_r("error message:::::: ");
            print_r($sendEmail->getErrorInfo());
        }
	}
	
	public function test() {
	    
	}
	

}
