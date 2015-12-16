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
            $config = BConfig::getConfig('master_db');
        }
        if ((!is_array($config)) || (empty($config))) {
            throw new PDOException('无主数据库配置');
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
     * @param array | string $where 条件;如果为数组时，全为and条件
     * @return number 返回删除的行数（受影响的行数）
     */
    public function delete($tableName, $where) {
        if (empty($where)) {
            return 0;
        }
        if (is_array($where)) {
            if (empty($where)) {
                return 0;
            } else {
                foreach ($where as $k=>$v) {
                    $where[$k] = "`{$k}`={$this->pdo->quote($v)}";
                }
                $where = implode(' AND ', $where);
            }
        }
        $sql = "DELETE FROM `{$tableName}` WHERE {$where}";
        return $this->pdo->exec($sql);
    }
    
    /**
     * 更新符合条件的数据
     * @param string $tableName 表名
     * @param array $data 要更新的数据
     * @param array | string $where 条件
     * @return boolean 执行成功返回true，执行失败返回false
     */
    public function update($tableName, $data, $where) {
        if (empty($data)) {
            return false;
        }
        $bindValue = array();
        if (is_array($where)) {
            foreach ($where as $k=>$v) {
                $where[$k] = "`{$k}`=:{$k}";
                $bindValue[$k] = $v;
            }
            $where = implode(' AND ', $where);
        }
        $values = array();
        foreach ($data as $k=>$v) {
            $values[] = "`{$k}`=:{$k}";
            $bindValue[$k] = $v;
        }
        $values = implode(',', $values);
        $sql = "UPDATE `{$tableName}` SET {$values} ";
        if (strlen($where) > 0 ) {
            $sql .= " WHERE {$where}";
        }
        $statement = $this->pdo->prepare($sql);
        foreach ($bindValue as $k=>$v) {
//             $statement->bindParam(':' . $k, $bindValue[$k]); // 特别注意这里，不能用$v
            $statement->bindValue(':' . $k, $v);
        }
        return $statement->execute();
    }
    
    /**
     * 单表批量查询,可用于翻页
     * @param string $tableName 表名
     * @param string | array $where 条件
     * @param integer $offset 从第几条开始查询
     * @param integer $limit 需要查询多少条，如果不需要limit，传null即可
     * @param string $orderField 排序字段，如果不需要排序传null即可
     * @param string $orderMode 排序模式，desc：降序；asc：升序。（只能为这两个值）
     * @param string $column 需要查询的字段
     * @return array
     */
    public function select($tableName, $where = null, $offset = null, $limit = null, $orderField = null, $orderMode = null, $column = '*') {
        $sql = "SELECT {$column} FROM `{$tableName}`";
        
        if (is_array($where) && (!empty($where))) {
            foreach ($where as $k=>$v) {
                $where[$k] = "`{$k}`={$this->pdo->quote($v)}";
            }
            $where = implode(' AND ', $where);
        }
        if (strlen($where) > 0) {
            $sql .= " WHERE {$where}";
        }

        if (($orderField != null) && is_string($orderField)) { // 需要排序
            $modes = array('DESC', 'ASC');
            $orderMode = strtoupper($orderMode);
            if (in_array($orderMode, $modes)) {
                $sql .= " ORDER BY {$orderField} {$orderMode}";
            } else {
                $sql .= " ORDER BY {$orderField}";
            }
        }
        
        if ($offset != null && $limit != null) {
            $offset = (int) $offset;
            $limit = (int) $limit;
            $limits = " LIMIT {$offset},{$limit}";
        } else {
            $offset = 0;
            $limit = 0;
            $limits = '';
        }
        $sql .= $limits;
        
        $data['sum'] = 0;
        $data['offset'] = $offset;
        $data['limit'] = $limit;
        $data['rowset'] = array();
//         var_dump($sql);exit;
        $statement = $this->pdo->query($sql);
        if ($statement instanceof PDOStatement) {
            $sum = $this->getSum($sql);
            $data['sum'] = $sum;
            $data['rowset'] = $statement->fetchAll(PDO::FETCH_OBJ);
        }
        return $data;
    }
    
    /**
     * 单表单条查询
     * @param string $tableName 表名
     * @param string | array $where 条件
     * @param string $column 查询字段
     * @return boolean | object 有数据返回对象，无数据返回false
     */
    public function load($tableName, $where = '', $column = '*') {
        if (is_array($where) && (!empty($where))) {
            foreach ($where as $k=>$v) {
                $where[$k] = "`{$k}`={$this->pdo->quote($v)}";
            }
            $where = implode(' AND ', $where);
        }
        $sql = "SELECT {$column} FROM `{$tableName}`";
        if (strlen($where) > 0) {
            $sql .= " WHERE {$where}";
        }
        $statement = $this->pdo->query($sql);
        if ($statement instanceof PDOStatement) {
            return $statement->fetchObject();
        } else {
            return false;
        }
    }
    
    /**
     * 获取总记录数（total row number）
     * @param string $sql
     * @return number
     */
    public function getSum($sql) {
        if (is_string($sql) && (strlen($sql) > 0)) {
            $sql = preg_replace('/SELECT(.+)FROM/is', 'SELECT count(*) FROM', $sql);
            $position = strripos($sql, 'LIMIT');
            if ($position) {
                $sql = substr($sql, 0, $position);
            }
            $statement = $this->pdo->query($sql);
            return intval($statement->fetchColumn(0));
        } else {
            return 0;
        }
    }
    
}
