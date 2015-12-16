<?php

/**
 * 模型实体和业务逻辑层最高抽象类
 * @author Bear
 * @copyright http://maimengmei.com
 * @version 2.0.0 2015-12-16 
 * @created 2015-04-16 09:59
 * @property 
 * @property 
 * @property Db_Master $master 主数据库对象
 * @property Db_Slave $slave 从数据库对象
 */
abstract class BAbstract
{
    /**
     * 主数据库对象
     * @var Db_Master
     */
    static private $_master; 

    /**
     * 从数据库对象
     * @var Db_Slave
     */
    static private $_slave;

    /**
     * 错误信息
     * @var string
     */
    protected $_error;

    /**
     * 魔术方法
     * @param string $k 变量名
     */
    public function __get($k) {
//         if ($k == 'pdo') {
//             return $this->getPdo();
//         }
//         if ($k == 'db') {
//             return $this->getDb();
//         }
        if ($k == 'master') {
            return $this->getMaster();
        }
        if ($k == 'slave') {
            return $this->getSlave();
        }
        return $this->$k;
    }

    /**
     * 获取Db_Master(主数据库)对象
     * @param string $masterConfig 配置文件中主数据库配置的key TODO 传入配置
     * @throws PDOException
     * @return Db_Master
     */
    public function getMaster($masterConfig = null) {
//         $masterConfig = BConfig::getConfig($masterConfig);
        if(self::$_master === null) {
            self::$_master = new Db_Master();
        }

        return self::$_master;
    }

    /**
     * 获取Db_Slave(从数据库)对象
     * @param string $slaveConfig 配置文件中从数据库配置的key TODO 传入配置
     * @throws PDOException
     * @return Db_Slave
     */
    public function getSlave($slaveConfig = null) {
        // $slaveConfig = BConfig::getConfig($slaveConfig)
        if(self::$_slave === null) {
            self::$_slave = new Db_Slave();
        }
        
        return self::$_slave;
    }
    
    /**
     * 获取错误信息
     * @return string
     */
    public function getError() {
        return $this->_error;
    }
    
    /**
     * 设置错误信息
     * @param string $error
     * @return void
     */
    protected function setError($error) {
        $this->_error = $error;
    }
  
}
