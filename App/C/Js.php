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
    
}
