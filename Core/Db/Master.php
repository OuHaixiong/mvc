<?php

/**
 * 主数据库操作pdo类，封装了PDO的一些函数
 * TODO 多主键的考虑
 * @author Bear
 * @version 1.0.0
 * @copyright http://maimengmei.com
 * @property PDO $pdo pdo对象
 * @created 2015-5-7 15:37
 * @example
 */
class Db_Master
{
    /**
     * pdo对象
     * @var PDO
     */
    protected $pdo;
    
    /**
     * 执行错误信息
     * @var array
     */
    protected $error;
    
    /**
     * 实例化数据库pdo类
     * @param array $config 主数据库配置（一维数组）
     * @throws PDOException
     */
    public function __construct($config = null) {
        if (empty($config)) {
            $config = CConfig::getConfig('master_db');
        }
        if (!is_array($config)) {
            throw new PDOException('无数据库配置');
        }
        if (isset($config['charset'])) {
            $driverOptions = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '{$config['charset']}'");
            // PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
        } else {
            throw new PDOException('未设置数据库编码');
        }
        $this->pdo = new PDO($config['dsn'], $config['username'], $config['password'], $driverOptions);
    }
    
    /**
     * 获取pdo对象
     * @return PDO
     */
    public function getPdo() {
        return $this->pdo;
    }
    
    /**
     * 获取属性
     * @param string $k
     * @return PDO | mixed
     */
    public function __get($k) {
        if ($k == 'pdo') {
            return $this->getPdo();
        }
    }
    
    /**
     * 执行sql语句时，报错后的错误信息
     * @return array
     */
    public function getError() {
        return $this->error;
    }
    
    /**
     * 获取数据库信息
     * @return array
     */
    public function info() {
        $output = array(
            'server' => 'SERVER_INFO',
            'driver' => 'DRIVER_NAME',
            'client' => 'CLIENT_VERSION',
            'version' => 'SERVER_VERSION',
            'connection' => 'CONNECTION_STATUS',
            'autocommit' => 'AUTOCOMMIT'
        );
    
        foreach ($output as $key => $value) {
            $output[ $key ] = $this->pdo->getAttribute(constant('PDO::ATTR_' . $value));
        }
    
        return $output;
    }
    
    /**
     * 插入一条数据
     * @param string $tableName 表名
     * @param array $data 需要插入的数据；键值对的数组
     * @return number 0：插入数据失败，大于0：插入成功（返回插入的主键值）
     */
    public function insert($tableName, $data) {
        if (empty($tableName)) {
            return 0;
        }
        if ((!is_array($data)) || empty($data)) {
            return 0;
        }
        $keys = array_keys($data);
        $fields = '`' . implode('`, `', $keys) . '`';
        $placeholder = substr(str_repeat('?,', count($keys)), 0, -1);
        $statement = $this->pdo->prepare("INSERT INTO `{$tableName}` ({$fields}) VALUES ({$placeholder})");
        $boolean = $statement->execute(array_values($data));
        if ($boolean) {
            return (int) $this->pdo->lastInsertId();
        } else {
            $this->error = $statement->errorInfo();
            return 0;
        }
    }
    
    /**
     * 删除符合条件的数据
     * @param string $tableName 表名
     * @param array $where 条件
     * @return number 返回删除的行数（受影响的行数）
     */
    public function delete($tableName, array $where) {
        if (empty($where)) {
            return 0;
        }
        foreach ($where as $k=>$v) {
            $where[$k] = "`{$k}`={$this->pdo->quote($v)}";
        }
        $where = implode(' AND ', $where);
        $sql = "DELETE FROM `{$tableName}` WHERE {$where}";
        return $this->pdo->exec($sql);
    }
    
    /**
     * 更新付款条件的数据
     * @param string $tableName 表名
     * @param array $data 要更新的数据
     * @param array | string $where 条件
     * @return boolean
     */
    public function update($tableName, $data, $where) {
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
     * 单表简单查询
     * @param unknown $tableName
     * @param unknown $where
     * @param string $column
     * @param unknown $orderBy
     * @param string $offset
     * @param string $limit
     */
    public function select($tableName, $where = null, $column = '*', $orderBy, $offset = null, $limit = null) {
        if ($offset != null && $limit != null) {
            
        }
    }
    
    
}
