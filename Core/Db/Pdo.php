<?php

/**
 * 数据库操作pdo类，封装了PDO的一些函数; 数据库操作层（数据持久层）
 * TODO 多主键的考虑
 * @author Bear
 * @version 1.0.0
 * @copyright http://maimengmei.com
 * @created 2015-4-17 10:37
 * @example
 */
class Db_Pdo
{
    /**
     * pdo对象
     * @var PDO
     */
    protected $pdo;

    /**
     * 实例化数据库pdo类
     * @param array $config
     * @throws PDOException
     */
    public function __construct($config = null) {
        if (empty($config)) {
            $config = CConfig::getConfig('pdo_db');
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

}
