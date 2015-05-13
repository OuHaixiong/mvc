<?php

/**
 * 业务逻辑层抽象类
 * @author Bear
 * @copyright http://maimengmei.com
 * @version 1.0.0
 * @created 2015-04-16 09:59
 * @property Db_Mysqli $db mysqli对象
 * @property Db_Pdo $pdo pdo对象
 * @property Db_Master $master 主数据库对象
 * @property Db_Slave $slave 从数据库对象
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
     * 主数据库对象
     * @var Db_Master
     */
    private $_master;
    
    /**
     * 从数据库对象
     * @var Db_Slave
     */
    private $_slave;
    
    
    
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
        if ($k == 'master') {
            return $this->getMaster();
        }
        if ($k == 'slave') {
            return $this->getSlave();
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
    
    /**
     * 获取Db_Master对象
     * TODO 传入配置
     * @return Db_Master
     */
    public function getMaster() {
        if($this->_master === null) {
            $this->_master = new Db_Master();
        }
        return $this->_master;
    }
    
    /**
     * 获取Db_Slave对象
     * TODO 传入配置
     * @return Db_Slave
     */
    public function getSlave() {
        if($this->_slave === null) {
            $this->_slave = new Db_Slave();
        }
        return $this->_slave;
    }
    
}
