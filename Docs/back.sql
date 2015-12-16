
-- 本网站练习相关sql


-- 预存用户账号表
DROP TABLE IF EXISTS `UserAccount`;
CREATE TABLE `UserAccount` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `accountNumber` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户数字账号',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：1：未使用，0：已使用',
  `createdTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `accountNumber` (`accountNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='预存用户账号表' AUTO_INCREMENT=1;

-- 用户表
DROP TABLE IF EXISTS `UserMember`;
CREATE TABLE `UserMember` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `username` varchar(50) DEFAULT '' COMMENT '用户名',
  `password` char(64) DEFAULT '' COMMENT '密码',
  `accountNumber` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户数字账号',
  `createdTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `accountNumber` (`accountNumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=1;


-- 实现分类和属性挂钩，并通过属性值来筛选产品 （2015-11-29）

-- 产品表
DROP TABLE IF EXISTS `Product`;
CREATE TABLE `Product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `name` varchar(50) DEFAULT '' COMMENT '产品名',
  `categoryId` int(10) unsigned DEFAULT 0 COMMENT '分类id',
  `description` text NOT NULL COMMENT '产品描述',
  `price` int(10) unsigned DEFAULT 0 COMMENT '产品单价，单位：分',
  `createdTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `updatedTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品表' AUTO_INCREMENT=1;

-- 分类表
DROP TABLE IF EXISTS `Category`;
CREATE TABLE `Category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `name` varchar(50) DEFAULT '' COMMENT '分类名称',
  `parentId` int(10) unsigned DEFAULT 0 COMMENT '父分类id',
  `isParent` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '是否父级分类，默认0：否；1：是（备用）',
  `sort` tinyint(2) unsigned NOT NULL DEFAULT 0 COMMENT '排序',
  `createdTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `updatedTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分类表' AUTO_INCREMENT=1;

-- 属性表
DROP TABLE IF EXISTS `Property`;
CREATE TABLE `Property` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `name` varchar(50) DEFAULT '' COMMENT '属性名称',
  `value` varchar(255) DEFAULT '' COMMENT '属性值（多个属性值用数组存储）',
  `isParent` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '是否父级属性，默认0：否；1：是。',
  `remark` varchar(255)  DEFAULT '' COMMENT '备注',
  `createdTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `updatedTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='属性表' AUTO_INCREMENT=1;

-- 分类和属性关联表 （属性永远是挂在末级【叶子】分类下）
DROP TABLE IF EXISTS `CategoryProperty`;
CREATE TABLE `CategoryProperty` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `categoryId` int(10) unsigned default 0 COMMENT '分类id',
  `propertyId` int(10) unsigned DEFAULT 0 COMMENT '属性id',
  `sort` tinyint(2) unsigned NOT NULL DEFAULT 0 COMMENT '排序',
  `status` tinyint(2) unsigned NOT NULL DEFAULT 1 COMMENT '状态：默认1：已关联（有效）；0：已删除（无效）',
  `createdTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `updatedTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `categoryId` (`categoryId`,`propertyId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分类和属性关联表' AUTO_INCREMENT=1;

-- 产品和属性表关联表
DROP TABLE IF EXISTS `ProductProperty`;
CREATE TABLE `ProductProperty` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `productId` int(10) unsigned default 0 COMMENT '产品id',
  `propertyId` int(10) unsigned DEFAULT 0 COMMENT '属性id',
  `value` varchar(50) DEFAULT '' COMMENT '属性值',
  `createdTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `updatedTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='产品和属性关联表' AUTO_INCREMENT=1;

-- 产品和分类的关联表（可以不要，在产品表里有体现，只有系统很复杂时才需要分开）

-- 用户自定义属性表 (可以设计成竖表)
-- 产品id
-- 属性名
-- 属性值


