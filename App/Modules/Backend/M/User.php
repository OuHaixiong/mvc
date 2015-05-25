<?php

/**
 * 后台管理员类
 * @author Bear
 * @copyright http://maimengmei.com
 * @version 1.0.0
 * @created 2015-04-11
 */
class Backend_M_User extends BModel
{
    public function login($username, $password) {
        $sql = "select * from `tb_admin`";
        $database = new Db_Pdo();
        $statement = $database->pdo->query($sql);
        Common_Tool::prePrint($statement->fetchAll());
    }
    
    public function logout() {
        
    }
    
    /**
     * 删除一条后台用户数据
     * @param integer $id
     * @return integer 成功返回1，失败返回0
     */
    public function del($id) {
        $row = $this->getDefaultRow();
        return $row->del($id);
    }
    
    /**
     * 获取后台用户默认行对象
     * @return Db_Row
     */
    public function getDefaultRow() {
        return new Db_Row('bage_admin', 'id');
    }
    
    
}