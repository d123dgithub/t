CREATE TABLE `admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '管理员姓名',
  `phone` char(11) NOT NULL COMMENT '管理员电话',
  `created_at` int(11) NOT NULL COMMENT '注册时间',
  `updated_at` int(11) DEFAULT NULL,
  `password` char(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


CREATE TABLE `beituijianren` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `phone` char(11) NOT NULL,
  `tuijianren_id` int(10) unsigned NOT NULL COMMENT '推荐人id',
  `created_at` int(11) unsigned NOT NULL COMMENT '添加时间',
  `updated_at` int(11) unsigned NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `shop` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shopname` varchar(100) NOT NULL COMMENT '商家名称',
  `doorno` varchar(20) NOT NULL COMMENT '门牌号',
  `username` varchar(50) NOT NULL COMMENT '联系人',
  `phone` char(11) NOT NULL COMMENT '电话',
  `is_delete` tinyint(2) NOT NULL DEFAULT '0' COMMENT '状态',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `szm` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL COMMENT '被推荐人姓名',
  `phone` char(11) NOT NULL COMMENT '被推荐人电话',
  `shop` int(10) unsigned NOT NULL COMMENT '商家id',
  `order_time` int(10) unsigned NOT NULL COMMENT '消费时间',
  `money` decimal(10,2) unsigned NOT NULL COMMENT '金额',
  `tuijianren` int(10) unsigned NOT NULL COMMENT '推荐人id',
  `szm` char(18) NOT NULL COMMENT '数字码',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) NOT NULL COMMENT '结算时间',
  `is_over` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否结算',
  `commission` decimal(10,2) NOT NULL COMMENT '佣金',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `tuijianren` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '推荐人姓名',
  `phone` char(11) NOT NULL COMMENT '推荐人电话',
  `created_at` int(11) NOT NULL COMMENT '注册时间',
  `updated_at` int(11) DEFAULT NULL,
  `password` char(32) NOT NULL,
  `is_delete` tinyint(4) DEFAULT '0' COMMENT '删除状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;