<?php

/**
 * 业务逻辑层抽象类
 * @author Bear
 * @copyright http://maimengmei.com
 * @version 1.0.0
 * @created 2015-04-16 09:59
 * @property Db_Mysqli $db mysqli对象
 * @property Db_Pdo $pdo pdo对象
 */
abstract class CModel
{
    /**
     * 数据库mysqli对象
     * @var Db_Mysqli
     */
    private $_db;
    
    /**
     * 数据库pdo对象
     * @var Db_Pdo
     */
    private $_pdo;
    
    
    
    
    
    
    
    
    /**
     * 魔术方法
     * @param string $k 变量名
     */
    public function __get($k) {
        if ($k == 'pdo') {
            return $this->getPdo();
        }
        if ($k == 'db') {
            return $this->getDb();
        }

    }
    
    /**
     * 获取mysqli对象
     * @return Db_Mysqli
     */
    public function getDb() {
        if ($this->_db === null) {
            $this->_db = new Db_Mysqli();
        }
        return $this->_db;
    }

    /**
     * 获取Db_Pdo对象
     * @return Db_Pdo
     */
    public function getPdo() {
        if($this->_pdo === null) {
            $this->_pdo = new Db_Pdo();
        }
        return $this->_pdo;
    }
    
}
