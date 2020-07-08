<?php

/**
 * json测试
 * @author bear
 * @copyright http://maimengmei.com
 */
class C_Jsonp extends BController
{
    public function init() {}
    
    public function index() {
        
    }
    
    /**
     * 原生的jsonp实现
     */
    public function connate() {
        $this->render();
    }
    
    /**
     * 原生的jsonp请求回调
     */
    public function connateCallback() {
        // jsonp 过来的请求都是不ajax请求；也不是post请求
        $callback= $this->getParam('callback');
        $data = array(
                'status' => 'success',
                'msg' => '成功提示'
        );
        Common_Ajax::output('成功返回jsonp数据', 1, $data, 'jsonp', $callback);
    }
    
    /**
     * jquery的Jsonp实现
     */
    public function jquery() {
        $this->render();
    }

    /**
     * 测试跨域请求
     */
    public function testInterface() {
        $this->title = '测试接口';
        $this->render();
    }
    
}
