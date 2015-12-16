<?php

/**
 * 业务逻辑层抽象类
 * @author Bear
 * @copyright http://maimengmei.com
 * @version 1.0.0
 * @created 2015-04-16 09:59
 * @property 
 * @property 
 * @property Db_Master $master 主数据库对象
 * @property Db_Slave $slave 从数据库对象
 */
abstract class BModel extends BAbstract
{
    /**
     * 实体类对象集合
     * @var array
     */
    protected $entities;

    /**
     * 获取mysqli对象(此方法已作废)
     * @return Db_Mysqli
     */
    public function getDb() {
//         if ($this->_db === null) {
//             $this->_db = new Db_Mysqli();
//         }
//         return $this->_db;
    }

    /**
     * 获取Db_Pdo对象(此方法已作废)
     * @return Db_Pdo
     */
    public function getPdo() {
//         if($this->_pdo === null) {
//             $this->_pdo = new Db_Pdo();
//         }
//         return $this->_pdo;
    }

    /**
     * 获取数据库实体类对象
     * @param string $rowName 行对象类名(首字母不区分大小写)
     * @return Db_Entity
     */
    public function getEntity($rowName) {
        if (isset($this->entities[$rowName]) && ($this->entities[$rowName] instanceof Db_Entity)) {
            return $this->entities[$rowName];
        }
        $entityName = 'M_Row_' . ucfirst($rowName);
        $this->entities[$rowName] = new $entityName();
        return $this->entities[$rowName];
    }
    

    
}
