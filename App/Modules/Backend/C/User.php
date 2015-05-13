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
    
}
