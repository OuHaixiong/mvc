<?php

/**
 * 产品业务模块
 * @author Bear
 * @version 1.0.0
 * @copyright http://maimengmei.com
 * @created 2015-11-30 16:37
 */
class M_Product extends BModel
{
    /**
     * 保存产品数据
     * @param array $data
     * @param integer $id
     * @return number 成功返回大于0的整数(插入/更新记录的主键id)，失败返回0
     */
    public function save($data, $id = null) {
        if (empty($id)) { // 新增产品数据
            $d = array();
            $entity = $this->getEntity('Product');
            $fieldName = BConfig::getFieldName($entity->tableName, 'name'); // 产品名
            $fieldCategoryId = BConfig::getFieldName($entity->tableName, 'categoryId'); // 分类id
            $fieldDescription = BConfig::getFieldName($entity->tableName, 'description'); // 产品描述
            $fieldPrice = BConfig::getFieldName($entity->tableName, 'price'); // 产品单价，单位：分
            $d[$fieldName] = $data[$fieldName];
            $d[$fieldCategoryId] = $data[$fieldCategoryId];
            $d[$fieldDescription] = $data[$fieldDescription];
            $d[$fieldPrice] = $data[$fieldPrice];
            $d[BConfig::getFieldName('createdTime')] = date('Y-m-d H:i:s');
            // 使用事务
            $pdo = $entity->master->pdo;
            $pdo->beginTransaction();
            $id = $entity->add($d);
            // 写入产品的属性
//             $pdo->rollBack();
            $pdo->commit();
            
            return $id;
        } else { // 修改产品数据
            $id = (int) $id;
            
            
        }
    }
    
}
