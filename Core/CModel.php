<?php

abstract class CModel
{
    private $_db;
    
    private $_pdo;
    
    
    
    /**
     * 魔术方法
     * @param string $k 变量名
     */
    public function __get($k) {
        if ($k == 'db') {
            return $this->getDb();
        }

    }
    
    public function getDb() {
        if ($this->_db === null) {
            $this->_db = new Db_Mysqli();
        }
        return $this->_db;
    }
    
    public function getPdo() {
        
    }    
}