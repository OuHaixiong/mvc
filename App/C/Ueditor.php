<?php

/**
 * 百度的Ueditor练习
 * @author Bear
 * @copyright http://maimengmei.com
 * @version 1.0.0
 * @created 2015-6-15
 */
class C_Ueditor extends BController
{
    public function init() {
        
    }
    
    public function index() {
        $this->_view->setIsLayout();
        $this->render();
    }
    
    /**
     * 编辑器上传图片
     */
    public function upload() {
        
    }
    
    /**
     * 编辑器上传上来的参数
     */
    public function post() {
        Common_Tool::prePrint($this->getParams(), false);
        Common_Tool::prePrint($_POST);
    }

}
