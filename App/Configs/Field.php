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
    
    
    
    
);