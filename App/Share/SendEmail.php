<?php
$dirPath = dirname(__FILE__); // /data/www/mvc/App/Share
require_once $dirPath . '/class.phpmailer.php';

/**
 * 发送邮件类
 * 这里只是发邮件的一个简单的封装，如果需要高级的用法请直接调取PHPMailer
 * @author Bear[258333309@163.com]
 * @version 1.0
 * @created 2018年7月20日 下午3:19:58
 */
class Share_SendEmail
{
    /**
     * 主机头
     * @var string
     */
    private $_host;
    
    /**
     * 端口号
     * @var integer
     */
    private $_port;
    
    /**
     * [邮箱]用户名
     * @var string
     */
    private $_username;
    
    /**
     * [邮箱]密码
     * @var string
     */
    private $_password;
    
    /**
     * 发件人姓名（这个参数在某些邮件服务器中也是没有用的，邮件服务器用的是自己在那里注册的姓名，比如outlook）
     * @var string
     */
    private $_fromName;
    
    /**
     * 发件人邮箱
     * @var string
     */
    private $_fromAddress;
    
    /**
     * 设置加密方式；取值"", "ssl" 或 "tls"
     * @var string
     */
    private $_secure = '';
    
    /**
     * 编码方式
     * @var string
     */
    private $_charSet = 'UTF-8';
    
    /**
     * 发送失败错误信息
     * @var string
     */
    private $_errorInfo;
    
    /**
     * 发送邮件构造函数
     * @param array $configs 邮件配置，如果为空则读取配置文件。邮件配置如：
     * 
     */
    public function __construct($configs = array()) {
        if ((!is_array($configs)) || empty($configs)) { // 从配置文件中读取
            $configs = BConfig::getConfig('email');
        }
        if (isset($configs['host'])) {
            $this->_host = $configs['host'];
        }
        if (isset($configs['port'])) {
            $this->_port = $configs['port'];
        }
        if (isset($configs['username'])) {
            $this->_username = $configs['username'];
        }
        if (isset($configs['password'])) {
            $this->_password = $configs['password'];
        }
        if (isset($configs['fromName'])) { // 这个参数在某些邮件服务器中也是没有用的，邮件服务器用的是自己在那里注册的姓名，比如outlook
            $this->_fromName = $configs['fromName'];
        }
        if (isset($configs['fromAddress'])) { // 去掉，实践证明发件人邮箱一定需要和[邮箱]用户名一样（大部分情况是这样的），也有一些特殊的需求
            $this->_fromAddress = $configs['fromAddress'];
        }
        if (isset($configs['secure'])) {
            $this->_secure = $configs['secure'];
        }
    }
    
    /**
     * 发送邮件
     * @param string $subject 主题
     * @param string $html 发送内容
     * @param array|string $addressList 收件人邮箱地址列表。可以传字符串（如果是一个人）和数组 
     * @param array $attachments 附件列表，结构类似：
     * [
     *     ['path'=>'XXX', 'name'=>'xxx'], 
     *     ...
     * ]
     * @return boolean
     */
    public function send($subject, $html, $addressList, $attachments = array()) {
        $addressList = (array) $addressList;
        try {
            $mail = new PHPMailer(); // 如果是开发环境还可以开启debug模式，进行调试
            $mail->IsSMTP();
            $mail->SMTPSecure = $this->_secure; // 设置使用什么样的加密方式登录鉴权
            $mail->CharSet = $this->_charSet;
            $mail->SMTPAuth = true; // smtp需要鉴权 这个必须是true
            $mail->Host = $this->_host;
            $mail->Port = $this->_port;
            $mail->Username = $this->_username;
            $mail->Password = $this->_password;
            if (empty($this->_fromName)) {
                $fromName = $this->_username;
            } else {
                $fromName = $this->_fromName;
            }
            if (empty($this->_fromAddress)) {
                $fromAddress = $this->_username;
            } else {
                $fromAddress = $this->_fromAddress;
            }
            $mail->SetFrom($fromAddress, $fromName); // 发件人邮箱和发件人
            $mail->Subject = $subject;
            $mail->MsgHTML($html); // 如果是纯文本，可以直接设置内容： $mail->body = $html;
            foreach ($addressList as $address) {
                $mail->AddAddress($address);
            }
            if (is_array($attachments) && (!empty($attachments))) {
                foreach ($attachments as $attachment) {
                    if (is_array($attachment) && isset($attachment['path']) && isset($attachment['name'])) {
                        $mail->AddAttachment($attachment['path'], $attachment['name']); // 添加附件,并指定名称 $appendixPath
                    }
                }
            }
            $boolean = $mail->Send();
            if ($boolean == false) { // 发送失败
                $this->_errorInfo = $mail->ErrorInfo;
                return false;
            } else {
                return true;
            }
        } catch (Exception $e) { // TODO 写日记
//             echo '发生错误了：';
//             print_r($e);die();
            $this->_errorInfo = $e->getMessage();
            return false;
        }
    }
    
    /**
     * 设置配置文件
     * @param array $configs
     */
    public function setConfigs($configs) {
        if (is_array($configs) && (!empty($configs))) {
            if (isset($configs['host'])) {
                $this->_host = $configs['host'];
            }
            if (isset($configs['port'])) {
                $this->_port = $configs['port'];
            }
            if (isset($configs['username'])) {
                $this->_username = $configs['username'];
            }
            if (isset($configs['password'])) {
                $this->_password = $configs['password'];
            }
            if (isset($configs['fromName'])) {
                $this->_fromName = $configs['fromName'];
            }
            if (isset($configs['secure'])) {
                $this->_secure = $configs['secure'];
            }
        }
    }
    
    /**
     * 设置编码方式
     * @param string $charSet 编码方式
     */
    public function setCharSet($charSet) {
        $this->_charSet = $charSet;
    }
    
    /**
     * 获取发送失败后的错误信息
     * @return string
     */
    public function getErrorInfo() {
        return $this->_errorInfo;
    }
}
