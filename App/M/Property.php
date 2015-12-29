<?php

/**
 * 属性业务模块
 * 产品的普通属性，销售属性不在此
 * @author Bear
 * @version 2.0.0
 * @copyright http://maimengmei.com
 * @created 2015-12-01 10:37
 */
class M_Property extends BModel
{
    /**
     * 保存一个属性
     * @param array $data 属性数据
     * @param integer $id 属性id
     * @return boolean true:保存成功; false:保存失败
     */
    public function save($data, $id = null) {
        $entity = $this->getEntity('property');
        if (empty($id)) { // 新增属性
            // TODO 验证数据
            $d = array();
            $d['name'] = $data['name']; // 属性名称
            $d['value'] = serialize($data['value']); // 属性值 . 数组序列化进去，出来时需要反序列化：unserialize
            $d['remark'] = $data['remark']; // 备注
            $d['createdTime'] = date('Y-m-d H:i:s');
            $id = $entity->add($d);
            if ($id > 0) {
                return true;
            } else {
                $this->setError('新增属性失败！');
                return false;
            }
        } else { // 修改属性
            $id = (int) $id;
            $row = $entity->load($id);
            if (!$row) {
                $this->setError('不存在的属性！');
                return false;
            }
            // TODO 验证数据
            $boolean = $entity->modify($data, $id);
            if (!$boolean) {
                $this->setError('修改失败！');
                return false;
            }
            return $boolean;
        }
    }
    
    /**
     * 根据分类id查找所有已关联的属性
     * @param integer $categoryId
     * @return array
     */
    public function getPropertiesByCategoryId($categoryId) {
        $categoryId = (int) $categoryId;
        if ($categoryId < 1) {
            return array();
        }
        
        $entity = $this->getEntity('CategoryProperty');
        $fieldCategoryId = BConfig::getFieldName($entity->tableName, 'categoryId');
        $fieldPropertyId = BConfig::getFieldName($entity->tableName, 'propertyId');
        $where = array($fieldCategoryId => $categoryId);
        $fieldSort = BConfig::getFieldName($entity->tableName, 'sort');
        $orderMode = 'ASC';
        $result = $entity->batchSelect($entity::STATUS_YES, $where, '*', null, null, $fieldSort, $orderMode);
        $properties = array();
        if ($result['sum'] > 0) {
            $entityProperty = $this->getEntity('Property');
            $fieldValue = BConfig::getFieldName($entityProperty->tableName, 'value');
            foreach ($result['rowset'] as $v) {
                $row = $entityProperty->load($v->$fieldPropertyId);
                $row->$fieldValue = unserialize($row->$fieldValue);
                $properties[] = $row;
            }
        }
        return $properties;
    }
    
    /**
     * 根据产品id查找所有的产品属性
     * @param integer $productId
     * @return array
     */
    public function getPropertiesByProductId($productId) {
        $productId = (int) $productId;
        if ($productId < 1) {
            return array();
        }
        
        $entity = $this->getEntity('ProductProperty');
        $fieldProductId = BConfig::getFieldName($entity->tableName, 'productId');
        $fieldPropertyId = BConfig::getFieldName($entity->tableName, 'propertyId');
        $fieldPropertyValue = BConfig::getFieldName($entity->tableName, 'value');
        $where = array($fieldProductId => $productId);
        $result = $entity->slave->select($entity->tableName, $where);
        $properties = array();
        if ($result['sum'] > 0) {
            $entityProperty = $this->getEntity('Property');
            $fieldValue = BConfig::getFieldName($entityProperty->tableName, 'value');
            $fieldName = BConfig::getFieldName($entityProperty->tableName, 'name');
            
            foreach ($result['rowset'] as $v) {
                $row = $entityProperty->load($v->$fieldPropertyId);
                $row->$fieldValue = unserialize($row->$fieldValue);
                $v->propertyName = $row->$fieldName;
//                 if (is_numeric($v->$fieldPropertyValue)) { // 如果统一不转整，那么属性的值（数组的key），在数据库里，只能是字符串（如：数字1为'1'）
//                     $v->$fieldPropertyValue = (int) $v->$fieldPropertyValue;
//                 }
                $values = $row->$fieldValue;
                $v->valueName = $values[$v->$fieldPropertyValue];
                $properties[] = $v;
            }
        }
        return $properties;
    }
    
}
