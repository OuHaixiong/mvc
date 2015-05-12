<?php

/**
 * 数据表行实体类
 * TODO 多主键的考虑
 * @author Bear
 * @version 1.0.0
 * @copyright http://maimengmei.com
 * @property Db_Master $master 主数据库对象
 * @property Db_Slave $slave 从数据库对象
 * @created 2015-5-6 17:04
 * @example
 */
abstract class Db_Entity
{
    protected $tableName;
    protected $primaryKey = 'id';
    
    /**
     * 主数据库对象
     * @var Db_Master
     */
    protected $master;
    
    /**
     * 从数据库对象
     * @var Db_Slave
     */
    protected $slave;

    /**
     * 获取属性
     * @param string $k
     * @return PDO | mixed
     */
    public function __get($k) {
        return $this->$k;
    }

    /**
     * 连接主数据库
     * @param string $masterConfig 配置文件中主数据库配置的key
     * @throws Exception
     * @return Db_Master
     */
    public function connectMaster($masterConfig = null) {
        if ($this->master != null) {
            return $this->master;
        }
        if ($masterConfig == null) {
            $masterConfig = 'master_db';
        }
        $masterConfig = CConfig::getConfig($masterConfig);
        if (empty($masterConfig)) {
            throw new Exception('无主数据库配置'); 
        }
        $this->master = new Db_Master($masterConfig);
        return $this->master;
    }

    /**
     * 连接从数据库
     * @param string $slaveConfig 配置文件中从数据库配置的key
     * @throws Exception
     * @return Db_Slave
     */
    public function connectSlave($slaveConfig = null) {
        if ($this->slave != null) {
            return $this->slave;
        }
        if ($slaveConfig == null) {
            $slaveConfig = 'slave_db';
        }
        $slaveConfig = CConfig::getConfig($slaveConfig);
        if (empty($slaveConfig)) {
            throw new Exception('无从数据库配置');
        }
        $this->slave = new Db_Slave($slaveConfig);
        return $this->slave;
    }
    
    public function save($data) {
    
    }
    
    /**
     * 新增一行记录
     * @param array $data 插入的键值对数据
     * @return integer 成功返回大于0的整数(插入记录的主键id)，失败返回0
     */
    public function add($data) {
        $this->connectMaster();
        return $this->master->insert($this->tableName, $data);
    }
    
    /**
     * 根据主键删除一条记录
     * @param integer $primaryKey 主键值
     * @return integer 失败返回0；成功返回删除的行数
     */
    public function del($primaryKey) {
        $this->connectMaster();
        $primaryKey = (int) $primaryKey;
        $where = array($this->primaryKey=>$primaryKey);
        return $this->master->delete($this->tableName, $where);
    }
    
    /**
     * 根据主键修改一条记录
     * @param array $data 需要更新的数据
     * @param integer $primaryKey 主键值
     * @return boolean 执行成功返回true，执行失败返回false
     */
    public function modify($data, $primaryKey) {
        if ((!is_array($data)) || (empty($data))) {
            return false;
        }
        $primaryKey = (int) $primaryKey;
        $where = array($this->primaryKey=>$primaryKey);
        $this->connectMaster();
        return $this->master->update($this->tableName, $data, $where);
    }
    
    /**
     * 获取一行记录;用从库查询
     * @param integer $primaryKey 主键值
     * @param string $column 需要查询的字段
     * @return boolean | object 有数据返回对象，无数据返回false
     */
    public function load($primaryKey, $column = '*') {
        $primaryKey = (int) $primaryKey;
        $this->connectSlave();
        $where = array($this->primaryKey=>$primaryKey);
        return $this->slave->load($this->tableName, $where, $column);
    }
    
    /**
     * 从主数据库获取一行记录（主库查询）
     * @param integer $primaryKey 主键值
     * @param string $column 需要查询的字段
     * @return boolean | object 有数据返回对象，无数据返回false
     */
    public function loadByMaster($primaryKey, $column = '*') {
        $primaryKey = (int) $primaryKey;
        $this->connectMaster();
        $where = array($this->primaryKey=>$primaryKey);
        return $this->master->load($this->tableName, $where, $column);
    }
    
    /**
     * 新增一批数据
     * @param array $data 二维数组
     * @return boolean 插入成功返回true，失败返回false
     */
    public function batchAdd(array $datas) {
        if (empty($datas)) {
            return false;
        }
        $this->connectMaster();
        $this->master->pdo->beginTransaction();
        foreach ($datas as $data) {
            $id = $this->add($data);
            if ($id == 0) {
                $this->master->pdo->rollBack();
                return false;
            }
        }
        $this->master->pdo->commit();
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
        $where = "{$this->primaryKey} in ({$primaryKeys})";
        $this->connectMaster();
        return $this->master->delete($this->tableName, $where);
    }
    
    /**
     * 根据主键id集，批量修改数据
     * @param array $data 需要修改的数据（键值对）
     * @param array $primaryKeys 主键集
     * @return boolean 执行成功返回true，执行失败返回false  
     */
    public function batchModify(array $data, array $primaryKeys) {
        if (empty($data) || empty($primaryKeys)) {
            return false;
        }
        foreach ($primaryKeys as $k=>$v) {
            $primaryKeys[$k] = (int) $v;
        }
        $primaryKeys = implode(',', $primaryKeys);
        $where = "{$this->primaryKey} in ({$primaryKeys})";
        $this->connectMaster();
        return $this->master->update($this->tableName, $data, $where);
    }
    
    /**
     * 批量查询一批数据
     * @param array $primaryKeys 主键集
     * @param string $column 需要查询的字段
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
        $this->connectSlave();
        $result = $this->slave->select($this->tableName, "`{$this->primaryKey}` in ({$primaryKeys})", null, null, null, null, $column);
        return $result['rowset'];
    }
    
    
    
}
