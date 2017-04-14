<?php

/**
 * 一些js的测试
 * @author Bear
 * @copyright http://maimengmei.com
 * @created 2016-09-23
 */
class C_Js extends BController
{
    /**
     * 弹框测试
     */
    public function popup() {
        $this->render();
    }
    
    /**
     * Summernote 在线编辑器测试
     */
    public function summernote() {
        if (Common_Tool::isPost()) {
            var_dump($_POST);exit;
        }
        $this->render();
    }
    
    public function test() {
        $this->_view->setLayoutFile('html5Layout.php');
        $this->render();
    }
    
    /**
     * 测试关闭浏览器后请求后端处理数据
     */
    public function ajaxWriteClose() {
        if (Common_Ajax::isAJAX()) {
            $string = '浏览器关闭了，现在时间：' . date('Y-m-d H:i:s');
            $filePath = ROOT_PATH . '/data/log/is_close_browser';
            $boolean = Common_Tool::writeFileFromString($filePath, $string, true);
            if ($boolean) {
                Common_Ajax::output('写入浏览器关闭时间 成功。', 1); 
            } else {
                Common_Ajax::output('写入浏览器关闭时间失败！', -1);
            }
        }
    }
    
}
