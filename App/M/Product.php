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
            return $this->add($data);
        } else { // 修改产品数据
            $id = (int) $id;
            return $this->modify($data, $id);
        }
    }
    
    /**
     * 添加新产品数据
     * @param array $data
     * @return integer
     */
    public function add($data) {
        // TODO 验证各个数据的有效性
        
        $d = array();
        $entity = $this->getEntity('Product');
        $fieldName = BConfig::getFieldName($entity->tableName, 'name'); // 产品名
        $fieldCategoryId = BConfig::getFieldName($entity->tableName, 'categoryId'); // 分类id
        $fieldDescription = BConfig::getFieldName($entity->tableName, 'description'); // 产品描述
        $fieldPrice = BConfig::getFieldName($entity->tableName, 'price'); // 产品单价，单位：分
        $fieldCreatedTime = BConfig::getFieldName('createdTime');
        $d[$fieldName] = $data[$fieldName];
        $d[$fieldCategoryId] = $data[$fieldCategoryId];
        $d[$fieldDescription] = $data[$fieldDescription];
        $d[$fieldPrice] = $data[$fieldPrice];
        $nowTime = date('Y-m-d H:i:s');
        $d[$fieldCreatedTime] = $nowTime;
        
        // 使用事务
        $pdo = $entity->master->pdo;
        $pdo->beginTransaction();
        $id = $entity->add($d);
        if ($id < 1) {
            $pdo->rollBack();
            return 0;
        }
        
        // 写入产品的属性
        if ((isset($data['properties'])) && (is_array($data['properties'])) && (!empty($data['properties']))) {
            $entity = $this->getEntity('ProductProperty');
            $fieldProductId = BConfig::getFieldName($entity->tableName, 'productId');
            $fieldPropertyId = BConfig::getFieldName($entity->tableName, 'propertyId');
            $fieldValue = BConfig::getFieldName($entity->tableName, 'value');
            foreach ($data['properties'] as $k=>$v) {// 写属性
                // TODO 判断属性是否存在，或是否合理
                
                $data = array();
                $data[$fieldProductId] = $id; // 产品id
                $data[$fieldPropertyId] = $k; // 属性id
                $data[$fieldValue] = $v; // 属性值
                $data[$fieldCreatedTime] = $nowTime;
                $num = $entity->add($data);
                if ($num < 1) {
                    $pdo->rollBack();
                    return 0;
                }
            }
        }
        
        $pdo->commit();
        return $id;
    }
    
    /**
     * 修改产品数据
     * @param array $data
     * @param integer $id
     * @return boolean
     */
    public function modify($data, $id) {
        $id = (int) $id;
        
    }
    
    /**
     * 通过分类id和属性，查找相关的产品
     * @param integer $categoryId 分类id
     * @param array $properties 属性（属性id和属性值的数组）
     * @param number $page
     * @param number $pageSize
     * @return array
     */
    public function selectByCategoryIdProperties($categoryId, $properties = array(), $page = 1, $pageSize = 10) {
        $categoryId = (int) $categoryId;
        // TODO $properties 验证属性是否合理
        if (!is_array($properties)) {
            $properties = array();
        }
        $page = (int) $page;
        if ($page < 1) {
            $page = 1;
        }
        $pageSize = (int) $pageSize;
        $offset = ($page - 1)*$pageSize;
        $pdo = $this->slave->pdo;
//         $pdo = new PDO($dsn, $username, $passwd, $options);
        if (count($properties) == 1) { // 只支持单属性查找，多个是没法查找的(如果多个需要通过搜索引擎来查找)
            list($key, $value) = each($properties);
            $sql = "select `Product`.`id`,`Product`.`name`,`Product`.`categoryId`,`Product`.`description`,`Product`.`price`,
            `Product`.`createdTime`,`Product`.`updatedTime`,`ProductProperty`.`productId`,`ProductProperty`.`propertyId`,`ProductProperty`.`value`
            from `Product` LEFT JOIN `ProductProperty` ON `Product`.`id`=`ProductProperty`.`productId`
            where `Product`.`categoryId`={$categoryId} AND `ProductProperty`.`propertyId`='{$key}' AND `ProductProperty`.`value`='{$value}' limit {$offset},{$pageSize}";
        } else {
            $sql = "select `Product`.`id`,`Product`.`name`,`Product`.`categoryId`,`Product`.`description`,
            `Product`.`price`,`Product`.`createdTime`,`Product`.`updatedTime` 
            from `Product` where `Product`.`categoryId`={$categoryId} limit {$offset},{$pageSize}";
        }
        $statement = $pdo->query($sql);
        if ($statement instanceof PDOStatement) {
            $sum = $this->slave->getSum($sql);
            $data['sum'] = $sum;
            $data['rowset'] = $statement->fetchAll(PDO::FETCH_OBJ);
            $data['page'] = $page;
            $data['pageSize'] = $pageSize;
            // 循环，把该产品的所有属性列出来
            $propertyModel = new M_Property();
            $fieldId = BConfig::getFieldName('id');
            foreach ($data['rowset'] as $k=>$v) {
                $properties = $propertyModel->getPropertiesByProductId($v->$fieldId);
                $data['rowset'][$k]->properties = $properties;
            }
            return $data;
        } else {
            return array();
        }
    }
    
}
