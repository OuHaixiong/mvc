<?php

/**
 * 主数据库操作pdo类，封装了PDO的一些函数; 数据库操作层（数据持久层）
 * TODO 多主键的考虑
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
     * @param array $config 数据库配置文件
     * @throws PDOException
     */
    public function __construct($config = null) {
        if (empty($config)) {
            $config = CConfig::getConfig('slave_db');
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
     * 单表简单查询
     * @param unknown $tableName
     * @param unknown $where
     * @param string $column
     * @param unknown $orderBy
     * @param string $offset
     * @param string $limit
     */
    public function select($tableName, $where, $column = '*', $orderBy, $offset = null, $limit = null) {
        if ($offset != null && $limit != null) {
    
        }
    }
    
    
}
