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
    
    public function index() {
        
    }
    
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
            $data['properties'] = $this->getPost('properties', array());
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
    
    /**
     * 搜索产品
     */
    public function search() {
        $keyword = $this->getParam('keyword', '');
        $properties = $this->getParam('properties', array());
        $page = (int) $this->getParam('page', 1);
        $pageSize = 20;
        $params = $this->getParams();

        if (!empty($keyword)) {
            // 查找是否有这个类别
            $categoryModel = new M_Category();
            $categoryRow = $categoryModel->findOneByName($keyword);
            $fieldId = BConfig::getFieldName('id');
//             Common_Tool::prePrint($categoryRow);
            // 通过分类，把分类对应的属性列出来
            if (!empty($categoryRow)) {
                $propertyModel = new M_Property();
                $rowset = $propertyModel->getPropertiesByCategoryId($categoryRow->$fieldId);
                $this->propertyEntity = $propertyModel->getEntity('Property');
                $this->properties = $rowset;
//                 Common_Tool::prePrint($rowset, false);
                // 根据分类查找产品，条件：分类+属性
                $productModel = new M_Product();
                $productResult = $productModel->selectByCategoryIdProperties($categoryRow->$fieldId, $properties, $page, $pageSize);
                $this->productEntity = $productModel->getEntity('Product');
                $this->productResult = $productResult;
            }
            // TODO 不存在的属性，需要容错
            
            
        }
//         Common_Tool::prePrint($params);
        $this->params = $params;
        $this->keyword = $keyword;
        $this->render();
    }
    
    /**
     * 创建产品索引
     */
    public function createIndex() {
        $product = new M_Product();
        $product->createIndex();
    }
    
    /**
     * 搜索微盟成员索引
     */
    public function searchProduct() {
        require_once ROOT_PATH . '/../../libraries/xunsearch/lib/XS.php';

        $xs = new XS('product');
        $search = $xs->search;
//         $search->setMultiSort(array('fansNumber'=>false)); // true：正序，小到大；flase：倒序，大到小
//                 $search->setQuery('qq.com');
//         $search->setLimit(20, 0); // limit(条数, 偏移量)
//         $search->setFuzzy();
        $docs = $search->search('properties:black AND properties:P_4=1');
        //         $docs = $search->search('id:3');
        //         $docs = $xs->search->search('140 OR id:3');
        //         $docs = $xs->search->setFuzzy()->search('13');
        $html = '';
        foreach ($docs as $doc) {
            $html .= 'id:' . $doc->id . '  
                    name:' . $doc->name . '  
             description:' . $doc->description . '  
              categoryId:' . $doc->categoryId . '  
                   price:' . $doc->price . '  
             createdTime:' . date('Y-m-d H:i:s', $doc->createdTime) . '
              properties:' . $doc->properties . '
                 
                 <br />';
             
        }
        //Common_Tool::prePrint($xs->search->getQuery(), false);
        echo $html;
    }
    
    
}