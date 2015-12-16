<?php

/**
 * 分类和属性关联表类
 * @author Bear
 * @version 1.0.0
 * @copyright http://maimengmei.com
 * @created 2015-11-30 16:37
 */
class M_Row_CategoryProperty extends Db_Entity
{
    /**
     * 状态：已关联（有效）
     * @var integer
     */
    const STATUS_YES = 1;
    
    /**
     * 状态：已删除（无效）
     * @var integer
     */
    const STATUS_NO = 0;
    
    protected $tableName = 'CategoryProperty';
    protected $primaryKey = 'id';
    
    /**
     * 保存一条分类和属性关联数据
     * @see Db_Entity::save()
     */
    public function save($data) {
        if (isset($data['id']) && $data['id'] > 0) { // 更新
            $id = $data['id'];
            unset($data['id']);
            return $this->modify($data, $id);
        } else { // 新增
            $data['createdTime'] = date('Y-m-d H:i:s'); // 通用的业务逻辑，如果没有此字段，请覆盖此方法
            $this->add($data);
        }
    }
    
    /**
     * 关联分类和属性(把属性挂在末节分类里)
     * @param array $propertyId 属性id
     * @param integer $categoryId 分类id
     * @param integer $status 状态：默认1：已关联（有效）；0：已删除（无效）
     * @return boolean | integer 是否成功请用 === false 判断。 失败返回false；成功返回关联状态：1：已关联（有效）；0：已删除（无效）
     */
    public function relation($propertyId, $categoryId, $status) {
        $categoryId = (int) $categoryId;
        $propertyId = (int) $propertyId;
        if ($categoryId < 1 || $propertyId < 1) {
            return false;
        }
        // TODO 验证状态
        $status = (int) $status;
        $row = $this->getRow($propertyId, $categoryId);
        if ($row) { // 已存在，修改
            $data[BConfig::getFieldName('status')] = $status;
            $fieldId = BConfig::getFieldName('id');
            $boolean = $this->modify($data, $row->$fieldId);
            if ($boolean) {
                return $status;
            } else {
                return false;
            }
        } else { // 不存在，新加一条
            $fieldPropertyId = BConfig::getFieldName($this->tableName, 'propertyId');
            $fieldCategoryId = BConfig::getFieldName($this->tableName, 'categoryId');
            $data[$fieldCategoryId] = $categoryId;
            $data[$fieldPropertyId] = $propertyId;
//             `sort` tinyint(2) unsigned NOT NULL DEFAULT 0 COMMENT '排序',
            $data[BConfig::getFieldName('status')] = $status;
            $data[BConfig::getFieldName('createdTime')] = date('Y-m-d H:i:s');
            
            $id = $this->add($data);
            if ($id > 0) {
                return $status;
            } else {
                return false;
            }
        }
    }
    
    /**
     * 根据产品id和属性id查找一条关系数据
     * @param integer $propertyId 属性id
     * @param integer $categoryId 分类id
     * @return boolean | object 有数据返回对象，无数据返回false 
     */
    public function getRow($propertyId, $categoryId) {
        $categoryId = (int) $categoryId;
        $propertyId = (int) $propertyId;

        $fieldPropertyId = BConfig::getFieldName($this->tableName, 'propertyId');
        $fieldCategoryId = BConfig::getFieldName($this->tableName, 'categoryId');
        $where = array($fieldPropertyId => $propertyId, $fieldCategoryId => $categoryId);
        $row = $this->slave->load($this->tableName, $where, '*');
        return $row;
    }

    /**
     * 批量查询产品和属性关联记录
     * @param integer $status
     * @param array $where
     * @param string $field
     * @param string $page
     * @param string $pageSize
     * @param string $orderBy
     * @return array
     */
    public function batchSelect($status = null, $where = array(), $column = '*', $page = null, $pageSize = null, $orderBy = null) {
        if ($status !== null) {
            $status = (int) $status;
            $where[BConfig::getFieldName('status')] = $status;
        }
        $offset = null;
        if ($page !== null && $pageSize != null) {
            $page = (int) $page;
            $pageSize = (int) $pageSize;
            $offset = ($page-1)*$pageSize;
        }
        $result = $this->slave->select($this->tableName, $where, $offset, $pageSize, null, null, $column);
        return $result;
    }
    
}
