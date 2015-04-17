<?php

/**
 * 数据库行对象
 * TODO 多主键的考虑
 * @author Bear
 * @version 1.0.0
 * @copyright http://maimengmei.com
 * @created 2015-4-17 10:37
 * @example
 */
class Db_Row
{
    protected $tableName;
    protected $primaryKey = 'id';
    protected $dbPdo;
    
    /**
     * 实例化数据库行对象
     * @param string $tableName 表名
     * @param string $primaryKey 主键名
     * @param string $dbConfig 配置文件中数据库的配置对应的key
     * @throws PDOException
     */
    public function __construct($tableName = null, $primaryKey = null, $dbConfig = null) {
        if ($tableName !== null) {
            $this->tableName = $tableName;
        }
        if ($primaryKey !== null) {
            $this->primaryKey = $primaryKey;
        }
        if (($dbConfig !== null) && (is_string($dbConfig))) {
            $dbConfig = CConfig::getConfig($dbConfig);
        }
        $this->dbPdo = new Db_Pdo();
        
    }
    
    public function save($data) {
    
    }
    
    public function add($data) {
//         $sql = 'SELECT name, colour, calories
//     FROM fruit
//     WHERE calories < :calories AND colour = :colour';
//         $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
//         $sth->execute(array(':calories' => 150, ':colour' => 'red'));
    }
    
    /**
     * 根据主键删除一条记录
     * @param integer $primaryKey 主键值
     * @return integer 失败返回0；成功返回删除的行数
     */
    public function del($primaryKey) {
        $primaryKey = (int) $primaryKey;
        $sql = "DELETE FROM `{$this->tableName}` WHERE `{$this->primaryKey}`={$primaryKey}";
        return $this->dbPdo->pdo->exec($sql);
    }
    
    public function modify($data, $primaryKey) {
    
    }
    
    public function load($primaryKey) {
    
    }
    
    public function batchAdd(array $data) {
    
    }
    
    public function batchDel(array $primaryKeys) {
    
    }
    
    public function batchModify($data, array $primaryKeys) {
    
    }
    
    public function batchLoad(array $primaryKeys) {
    
    }
    
}
