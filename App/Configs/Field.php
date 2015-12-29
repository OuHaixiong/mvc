<?php

/**
 * 所有表里的字段
 */
return array(
    'id' => 'id', // 公共主键字段名
    'sort' => 'sort', // 公共排序字段名
    'status' => 'status', // 公共状态字段名
    'createdTime' => 'createdTime', // 公共创建字段名
    'updatedTime' => 'updatedTime', // 公共更新字段名
    
    
    'CategoryProperty' => array( // 分类和属性关联表
        'categoryId' => 'categoryId',
        'propertyId' => 'propertyId',
        'id' =>  'id',
        'sort' => 'sort',
        'status' => 'status',
        'createdTime' => 'createdTime',
        'updatedTime' => 'updatedTime',
    ),
    
    'Product' => array( // 产品表
        'name' => 'name',
        'categoryId' => 'categoryId',
        'description' => 'description',
        'price' => 'price',
        'createdTime' => 'createdTime',
        'updatedTime' => 'updatedTime',
    ),
    
    'Property' => array( // 属性表
        'id' => 'id',
        'name' => 'name',
        'value' => 'value',
        'isParent' => 'isParent',
        'remark' => 'remark',
        'createdTime' => 'createdTime',
        'updatedTime' => 'updatedTime',
    ),
    
    'ProductProperty' => array( // 产品和属性表关联表
        'id' => 'id',
        'productId' => 'productId',
        'propertyId' => 'propertyId',
        'value' => 'value',
        'createdTime' => 'createdTime',
        'updatedTime' => 'updatedTime',
    ),
    
    'Category' => array( // 分类表
        'id' => 'id',
        'name' => 'name', // 分类名称
        'parentId' => 'parentId', // 父分类id
        'isParent' => 'isParent', // 是否父级分类，默认0：否；1：是（备用）
        'sort' => 'sort', // 排序
        'createdTime' => 'createdTime',
        'updatedTime' => 'updatedTime',
    ),
    
    
);