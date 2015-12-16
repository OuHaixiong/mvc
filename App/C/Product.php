<?php

/**
 * 产品管理的操作
 * @author Bear
 * @version 2.0.0
 * @copyright http://maimengmei.com
 * @created 2015-12-16 10:35
 */
class C_Product extends BController
{
    public function init() {}
    
    /**
     * 上传产品
     */
    public function add() {
        $this->title = '上传产品';
        if (Common_Tool::isPost()) {
            $product = new M_Product();
            $entity = $product->getEntity('Product');
            $fieldName = BConfig::getFieldName($entity->tableName, 'name'); // 产品名
            $fieldCategoryId = BConfig::getFieldName($entity->tableName, 'categoryId'); // 分类id
            $fieldDescription = BConfig::getFieldName($entity->tableName, 'description'); // 产品描述
            $fieldPrice = BConfig::getFieldName($entity->tableName, 'price'); // 产品单价，单位：分
            $data[$fieldName] = $this->getPost('name');
            $data[$fieldCategoryId] = $this->getPost('category_id');
            $data[$fieldDescription] = $this->getPost('description');
            $data[$fieldPrice] = $this->getPost('price');
            $id = $product->save($data);
            if ($id) {
                Common_Ajax::output('保存成功', 1);
            } else {
                Common_Ajax::output('保存失败', -1);
            }
        }
        $category = new M_Category();
        $rootCategory = $category->root();
        $this->rootCategory = $rootCategory;
        
        $this->render('/Product/save');
    }
    
}