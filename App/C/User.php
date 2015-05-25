<?php

/**
 * 用户控制器
 * @author Bear
 * @version 1.0.0
 * @copyright http://maimengmei.com
 * @created 2015-5-13 14:37
 */
class C_User extends BController
{
    /**
     * 注册会员
     */
    public function register() {
        $successInfo = '';
        if (Common_Tool::isPost()) {
            $data['username'] = $this->getPost('username');
            $data['password'] = $this->getPost('password');
            $user = new M_User();
            $id = $user->register($data);
            if ($id > 0) {
                $successInfo = '注册会员成功';
            } else {
                $successInfo = '注册失败';
            }
        }
        $this->successInfo = $successInfo;
        $this->_view->setIsLayout();
        $this->render();
    }
    
    
}
