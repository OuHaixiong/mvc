<?php

/**
 * 数据表行实体类
 * TODO 多主键的考虑
 * @author Bear
 * @version 1.0.0
 * @copyright http://maimengmei.com
 * @property string $tableName 数据库的表名
 * @created 2015-5-6 17:04
 * @example
 */
abstract class Db_Entity extends BAbstract
{
    /**
     * 数据表名
     * @var string
     */
    protected $tableName;
    protected $primaryKey = 'id';

    /**
     * 公共保存方法
     * @param unknown $data
     */
    public function save($data) {
    
    }
    
    /**
     * 新增一行记录
     * @param array $data 插入的键值对数据
     * @return integer 成功返回大于0的整数(插入记录的主键id)，失败返回0
     */
    public function add($data) {
        return $this->master->insert($this->tableName, $data);
    }
    
    /**
     * 根据主键删除一条记录
     * @param integer $primaryKey 主键值
     * @return integer 失败返回0；成功返回删除的行数
     */
    public function del($primaryKey) {
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
        return $this->master->update($this->tableName, $data, $where);
    }
    
    /**
     * 批量查询一批数据;用从库查询
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
        $result = $this->slave->select($this->tableName, "`{$this->primaryKey}` in ({$primaryKeys})", null, null, null, null, $column);
        return $result['rowset'];
    }
    
    
    
}
