<?php

/**
 * 从数据库操作pdo类，主要提供查询操作
 * TODO 多主键的考虑; 查询字段防注入
 * @author Bear
 * @version 1.0.0
 * @copyright http://maimengmei.com
 * @property PDO $pdo pdo对象
 * @created 2015-5-5 15:37
 * @example
 */
class Db_Slave
{
    /**
     * pdo对象
     * @var PDO
     */
    protected $pdo;
    
    /**
     * 实例化数据库pdo类
     * @param array $config 从数据库配置文件，这里一定是二维数组，如果为null默认获取配置文件中slave_db中的配置
     * @throws PDOException
     */
    public function __construct($configs = null) {
        if (empty($configs)) {
            $configs = BConfig::getConfig('slave_db');
        }
        if (!is_array($configs) || empty($configs)) {
            throw new PDOException('无从数据库配置');
        }
        $sum = count($configs);
        $rand = mt_rand(0, $sum-1);
        $config = $configs[$rand];
        if (isset($config['charset'])) {
            $driverOptions = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '{$config['charset']}'");
            // PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
        } else {
            throw new PDOException('未设置数据库编码');
        }
        $this->pdo = new PDO($config['dsn'], $config['username'], $config['password'], $driverOptions);
        //$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
        $w = '';
        if (is_array($where) && (!empty($where))) {
            foreach ($where as $k=>$v) {
                $where[$k] = "`{$k}`={$this->pdo->quote($v)}";
            }
            $w = implode(' AND ', $where);
        } else if (is_string($where)) {
            $w = $where;
        }
        if (strlen($w) > 0) {
            $sql .= " WHERE {$w}";
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

        if ($offset !== null && $limit != null) {
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
        if (is_array($where)) {
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
