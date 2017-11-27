<?php

/**
 * redis缓存服务器
 * @author Bear
 * @version 1.0.0
 * @copyright http://maimengmei.com
 * @created 2015-9-24 16:37
 */
class BRedis
{
    const MASTER_KEY = 'master_redis';
    const SLAVE_KEY = 'slave_redis';
    
    /**
     * 主redis
     * @var Redis
     */
    private static $_master;
    
    /**
     * 从redis（其中一个）
     * @var Redis
     */
    private static $_slave;

    /**
     * 获取主redis服务，负责读和写
     * @return Redis
     */
    public static function getMaster($db = null) {
        if (self::$_master === null) {
            $masterRedis = BConfig::getConfig(self::MASTER_KEY);
            self::$_master = new Redis();
            /* try {
                self::$_master->connect($masterRedis['host'], $masterRedis['port'], $masterRedis['timeout']);
            } catch (RedisException $e) { // 链接不上时，只会超时，不会抛异常
                die('无法链接主redis');
            } catch (Exception $e) {
                print_r($e);exit;
            } */
            self::$_master->connect($masterRedis['host'], $masterRedis['port'], $masterRedis['timeout']);
            // 还可以用pconnect来进行长链接
            if (isset($masterRedis['password'])) {
                self::$_master->auth($masterRedis['password']);
            }
        }
        if (!empty($db)) {
            self::$_master->select($db);
        }
        return self::$_master;
    }
    
    /**
     * 获取从redis服务，只负责读
     * @return Redis
     */
    public static function getSlave($db = null) {
        if (self::$_slave === null) {
            $slaveRedis = BConfig::getConfig(self::SLAVE_KEY);
            self::$_slave = new Redis();
            $oneSlave = $slaveRedis[array_rand($slaveRedis, 1)];
            self::$_slave->connect($oneSlave['host'], $oneSlave['port'], $oneSlave['timeout']);
            if (isset($oneSlave['password'])) {
                self::$_slave->auth($oneSlave['password']);
            }
        }
        if (!empty($db)) {
            self::$_slave->select($db);
        }
        return self::$_slave;
    }
    
}
