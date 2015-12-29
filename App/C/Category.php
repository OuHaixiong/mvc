<?php

/**
 * 分类的操作
 * @author Bear
 * @version 2.0.0
 * @copyright http://maimengmei.com
 * @created 2015-11-30 19:35
 */
class C_Category extends BController
{
    public function init() {
        
    }
    
    /**
     * 添加一个分类
     */
    public function add() {
        $data = array();
        $data['name'] = '耳机';
        $data['parentId'] = 5;
        $category = new M_Category();
        $boolean = $category->save($data);
        var_dump($boolean);
    }
    
    public function del() {
        
    }
    
    public function update() {
        
    }
    
    public function index() {
        
    }
    
    /**
     * 末级分类关联属性
     */
    public function relation() {
        $this->title = '分类和属性关联';
        if (Common_Ajax::isAJAX() && Common_Tool::isPost()) {
            $categoryProperty = new M_Row_CategoryProperty();
            $propertyId = $this->getPost('property_id');
            $categoryId = $this->getPost('category_id');
            $isChecked = $this->getPost('is_checked');
            if ($isChecked == 'true') {
                $status = 1;
            } else {
                $status = 0;
            }
            $status = $categoryProperty->relation($propertyId, $categoryId, $status);
            if ($status === false) {
                Common_Ajax::output('操作失败', -1, null, 'json');
            } else {
                $data[BConfig::getFieldName('status')] = $status;
                Common_Ajax::output('操作成功', 1, $data);
            }
        }
        $category = new M_Category();
        $rootCategory = $category->root();
        $this->rootCategory = $rootCategory;
        
        // 获取属性
//         $property = new M_Property();
        $entity = $category->getEntity('Property');
        $slave = $entity->slave;
        $where = array();
        $tableName = $entity->tableName;
        $result = $slave->select($tableName, $where, 0, 20, 'id', 'desc');      
        $this->propertyResult = $result;
        $this->render();
    }
    
    /**
     * 通过父级分类的id查找所有的子级分类
     */
    public function findChildren() {
        if (Common_Ajax::isAJAX()) {
            $parentId = intval($this->getPost('parent_id'));
            $category = new M_Category();
            $rowset = $category->findChildren($parentId);
            Common_Ajax::output('获取数据成功', 1, $rowset);
        }
    }
    
    /**
     * 通过末级分类id，获取所有已关联的属性id
     */
    public function getPropertyIds() {
        if (Common_Ajax::isAJAX()) {
            $categoryId = intval($this->getParam('category_id'));
            if ($categoryId < 1) {
                Common_Ajax::output('category_id参数不对', -1, array());
            }
            $categoryProperty = new M_Row_CategoryProperty();
            $fieldCategoryId = BConfig::getFieldName($categoryProperty->tableName, 'categoryId');
            $where = array($fieldCategoryId=>$categoryId);
            $column = BConfig::getFieldName($categoryProperty->tableName, 'propertyId');
            $result = $categoryProperty->batchSelect($categoryProperty::STATUS_YES, $where, $column);
            if (empty($result['rowset'])) {
                $propertyIds = array();
            } else {
                $propertyIds = array();
                foreach ($result['rowset'] as $v) {
                    $propertyIds[] = $v->$column;
                }
            }
            Common_Ajax::output('获取属性id成功', 1, $propertyIds);
        }
    }
    
    /**
     * 通过末级分类id，获取所有已关联的属性
     */
    public function getProperties() {
        if (Common_Ajax::isAJAX()) {
            $categoryId = intval($this->getPost('category_id'));
            if ($categoryId < 1) {
                Common_Ajax::output('category_id参数不对', -1, array());
            }
            $property = new M_Property();
            $rowset = $property->getPropertiesByCategoryId($categoryId);
            Common_Ajax::output('获取已关联的属性成功', 1, $rowset);
        }
    }
    
}
