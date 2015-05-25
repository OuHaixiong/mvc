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
    
    /**
     * 数据库对象
     * @var Db_Pdo
     */
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
            $dbConfig = BConfig::getConfig($dbConfig);
        }
        
        $this->dbPdo = new Db_Pdo($dbConfig);
    }
    
    public function save($data) {
    
    }
    
    /**
     * 新增一行记录
     * @param array $data 插入的键值对数据
     * @return integer 成功返回大于0的整数(插入记录的主键id)，失败返回0
     */
    public function add($data) {
        if (!is_array($data)) {
            return 0;
        }
        $keys = array_keys($data);
        $fields = '`' . implode('`, `', $keys) . '`';
        $placeholder = substr(str_repeat('?,', count($keys)), 0, -1);
        $statement = $this->dbPdo->pdo->prepare("INSERT INTO `{$this->tableName}` ({$fields}) VALUES ({$placeholder})");
        $boolean = $statement->execute(array_values($data));
        if ($boolean) {
            return (int) $this->dbPdo->pdo->lastInsertId();
        } else {
            return 0;
        }
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
    
    /**
     * 根据主键修改一条记录
     * @param array $data 需要更新的数据
     * @param integer $primaryKey 主键值
     * @return boolean 执行成功返回true，执行失败返回false
     */
    public function modify($data, $primaryKey) {
        $primaryKey = (int) $primaryKey;
        if ((!is_array($data)) || (empty($data))) {
            return false;
        }
        $values = array();
        foreach ($data as $k=>$v) {
            $values[] = "`$k`=:$k";
        }
        $values = implode(',', $values);
        $sql = "UPDATE `{$this->tableName}` SET {$values} WHERE `{$this->primaryKey}`={$primaryKey}";
        $statement = $this->dbPdo->pdo->prepare($sql);
        foreach ($data as $k=>$v) {
//             $statement->bindParam(':' . $k, $data[$k]); // 特别注意这里，不能用$v
            $statement->bindValue(':' . $k, $v);
        }
        return $statement->execute();
    }

    /**
     * 获取一行记录
     * @param integer $primaryKey 主键值
     * @param string $column 需要查询的字段
     * @return array | false 有记录返回一维数组，没记录返回false
     */
    public function load($primaryKey, $column = '*') {
        $primaryKey = (int) $primaryKey;
        $sql = "SELECT {$column} FROM `{$this->tableName}` WHERE `{$this->primaryKey}`={$primaryKey}";
        $statement = $this->dbPdo->pdo->query($sql);
        if ($statement instanceof PDOStatement) {
            return $statement->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }
    
    /**
     * 新增一批数据
     * @param array $data 二维数组
     * @return boolean
     */
    public function batchAdd(array $datas) {
        $this->dbPdo->pdo->beginTransaction();
        foreach ($datas as $data) {
            $id = $this->add($data);
            if ($id == 0) {
                $this->dbPdo->pdo->rollBack();
                return false;
            }
        }
        $this->dbPdo->pdo->commit();
        return true;
    }
    
    /**
     * 删除一批数据
     * @param array $primaryKeys 一组主键值
     * @return integer 返回删除的条数
     */
    public function batchDel(array $primaryKeys) {
        if (empty($primaryKeys)) {
            return 0;
        }
        foreach ($primaryKeys as $k=>$v) {
            $primaryKeys[$k] = (int) $v;
        }
        $primaryKeys = implode(',', $primaryKeys);
        $sql = "DELETE FROM `{$this->tableName}` WHERE `{$this->primaryKey}` in ({$primaryKeys})";
        return $this->dbPdo->pdo->exec($sql);
    }

    /**
     * 根据主键id集，批量修改数据
     * @param array $data 需要修改的数据（键值对）
     * @param array $primaryKeys 主键集
     * 
     */
    public function batchModify($data, array $primaryKeys) {
    
    }
    
    /**
     * 批量查询一批数据
     * @param array $primaryKeys 主键集
     * @return array
     */
    public function batchLoad(array $primaryKeys, $column = '*') {
        if (empty($primaryKeys)) {
            return array();
        }
        foreach ($primaryKeys as $k=>$v) {
            $primaryKeys[$k] = (int) $v;
        }
        $primaryKeys = implode(',', $primaryKeys);
        $sql = "SELECT {$column} FROM `{$this->tableName}` WHERE `{$this->primaryKey}` in ({$primaryKeys})";
        $statement = $this->dbPdo->pdo->query($sql);
        if ($statement instanceof PDOStatement) {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return array();
        }
    }
    
}
