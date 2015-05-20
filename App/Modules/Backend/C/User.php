<?php

/**
 * 用户管理控制器
 * @author Bear
 * @version 1.0.0
 * @copyright http://maimengmei.com
 * @created 2015-5-13 14:37
 */
class Backend_C_User extends Backend_C_Controller
{
    /**
     * 创建一批预存数字账号
     */
    public function create() {
        $user = new M_User();
        $boolean = $user->createBatch();
        Common_Tool::prePrint($boolean);
    }
    
    /**
     * 手动添加前台用户
     */
    public function add() {
        $successInfo = '';
        if (Common_Tool::isPost()) {
            $data['username'] = $this->getPost('username');
            $data['password'] = $this->getPost('password');
            $data['number'] = $this->getPost('num');
            $user = new M_User();
            $id = $user->handAdd($data);
            if ($id > 0) {
                $successInfo = '添加会员成功';
            } else {
                $error = $user->getError();
                if (empty($error)) {
                    $error = '添加会员失败';
                }
                $successInfo = $error;
            }
        }
        $this->successInfo = $successInfo;
        $this->_view->setIsLayout();
        $this->render();
    }
    
}
