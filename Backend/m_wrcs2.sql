/*
SQLyog Ultimate v11.24 (32 bit)
MySQL - 5.7.19-0ubuntu0.16.04.1 : Database - m_wrcs
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`m_wrcs` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `m_wrcs`;

/*Table structure for table `z_locklog` */

DROP TABLE IF EXISTS `z_locklog`;

CREATE TABLE `z_locklog` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `mobile` varchar(128) NOT NULL COMMENT '用户手机号',
  `detail` text NOT NULL COMMENT '详情',
  `create_time` int(10) unsigned NOT NULL,
  `update_time` int(10) unsigned NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '0进门，1出门',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='该表用来记录开门的请求状态';

/*Table structure for table `z_logs` */

DROP TABLE IF EXISTS `z_logs`;

CREATE TABLE `z_logs` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `store_id` int(10) NOT NULL COMMENT '店铺Id',
  `action` varchar(256) NOT NULL COMMENT '日志类型',
  `picture` varchar(256) DEFAULT NULL COMMENT '日志图片',
  `detail` text NOT NULL COMMENT '日志详情',
  `create_time` int(10) unsigned NOT NULL,
  `update_time` int(10) unsigned NOT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36716 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='日志表';

/*Table structure for table `z_members` */

DROP TABLE IF EXISTS `z_members`;

CREATE TABLE `z_members` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `mobile` varchar(128) NOT NULL COMMENT '手机号',
  `card_num` varchar(128) DEFAULT NULL COMMENT '会员卡号（已弃用）',
  `money` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '账户余额',
  `wechat_id` varchar(128) DEFAULT NULL COMMENT '微信open_id(暂未启用)',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `title` varchar(128) NOT NULL COMMENT '称呼',
  `store_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺Id',
  `login_ip` varchar(128) DEFAULT NULL COMMENT '登录ip',
  `create_time` int(10) unsigned NOT NULL,
  `update_time` int(10) unsigned NOT NULL,
  `login_time` int(10) unsigned NOT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`mobile`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='会员表';

/*Table structure for table `z_options` */

DROP TABLE IF EXISTS `z_options`;

CREATE TABLE `z_options` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `store_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺Id',
  `key` varchar(128) NOT NULL,
  `value` text NOT NULL,
  `create_time` int(10) unsigned NOT NULL,
  `update_time` int(10) unsigned NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1727 DEFAULT CHARSET=utf8 COMMENT='设置表';

/*Table structure for table `z_order_products` */

DROP TABLE IF EXISTS `z_order_products`;

CREATE TABLE `z_order_products` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `orders_id` bigint(20) NOT NULL COMMENT '订单Id',
  `product_id` bigint(20) NOT NULL COMMENT '商品Id',
  `product_title` varchar(128) NOT NULL COMMENT '商品名称',
  `count` int(10) unsigned NOT NULL COMMENT '商品数量',
  `price` decimal(18,2) NOT NULL COMMENT '价格',
  `picture` varchar(256) DEFAULT NULL COMMENT '图片路径（已弃用）',
  `create_time` int(10) unsigned NOT NULL,
  `update_time` int(10) unsigned NOT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1805 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='与订单相关的产品信息';

/*Table structure for table `z_orders` */

DROP TABLE IF EXISTS `z_orders`;

CREATE TABLE `z_orders` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `store_id` int(10) NOT NULL COMMENT '店铺Id',
  `total_price` decimal(18,2) NOT NULL COMMENT '总价',
  `create_time` int(10) unsigned NOT NULL,
  `update_time` int(10) unsigned NOT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  `pay_method` varchar(128) NOT NULL DEFAULT '' COMMENT '付款方式',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1189 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='订单表';

/*Table structure for table `z_product_logs` */

DROP TABLE IF EXISTS `z_product_logs`;

CREATE TABLE `z_product_logs` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `store_id` int(10) NOT NULL COMMENT '店铺Id',
  `log_type` varchar(16) NOT NULL DEFAULT '入库' COMMENT '类型（入库，出库）',
  `products_id` bigint(20) NOT NULL COMMENT '商品Id',
  `product_tag` varchar(128) NOT NULL COMMENT '与商品绑定的标签号',
  `create_time` int(10) unsigned NOT NULL,
  `update_time` int(10) unsigned NOT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5200 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='出入库记录';

/*Table structure for table `z_product_tags` */

DROP TABLE IF EXISTS `z_product_tags`;

CREATE TABLE `z_product_tags` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `store_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺Id',
  `products_id` bigint(20) NOT NULL COMMENT '商品Id',
  `tag` varchar(128) NOT NULL COMMENT '标签号',
  `create_time` int(10) unsigned NOT NULL,
  `update_time` int(10) unsigned NOT NULL,
  `status` int(10) NOT NULL DEFAULT '0' COMMENT '1为入库状态，2为出库状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3205 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='与商品绑定的标签';

/*Table structure for table `z_products` */

DROP TABLE IF EXISTS `z_products`;

CREATE TABLE `z_products` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `store_id` int(10) NOT NULL COMMENT '店铺Id',
  `tag` varchar(128) NOT NULL COMMENT '商品编码',
  `title` varchar(128) NOT NULL COMMENT '名称',
  `price` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `member_price` decimal(18,2) NOT NULL DEFAULT '0.00' COMMENT '会员价（已弃用）',
  `unit` varchar(32) DEFAULT '' COMMENT '单位',
  `picture` varchar(256) DEFAULT NULL COMMENT '图片路径（已弃用）',
  `produce_time` int(10) unsigned DEFAULT NULL COMMENT '生产日期',
  `expired_time` int(10) unsigned DEFAULT NULL COMMENT '保质期',
  `create_time` int(10) unsigned NOT NULL,
  `update_time` int(10) unsigned NOT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=224 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品表';

/*Table structure for table `z_readers` */

DROP TABLE IF EXISTS `z_readers`;

CREATE TABLE `z_readers` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL DEFAULT ' ' COMMENT '名称',
  `store_id` int(10) NOT NULL COMMENT '店铺Id',
  `serial_port` varchar(128) DEFAULT NULL COMMENT '串口号或者IP',
  `baudrate` int(10) NOT NULL COMMENT '波特率或者端口',
  `channels` text COMMENT '已弃用',
  `channels_addrs` text COMMENT '已弃用',
  `sleep_time` int(11) NOT NULL COMMENT '读写器读卡时间间隔',
  `remark` text COMMENT '备注',
  `create_time` int(10) unsigned NOT NULL,
  `update_time` int(10) unsigned NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `current_tags` text COMMENT '保存每次读到的所有标签',
  `count` int(11) NOT NULL DEFAULT '0' COMMENT '每次读到的标签数量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*Table structure for table `z_shelf` */

DROP TABLE IF EXISTS `z_shelf`;

CREATE TABLE `z_shelf` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `store_id` int(10) NOT NULL,
  `title` varchar(128) NOT NULL,
  `shelf_index` int(10) NOT NULL,
  `start_num` int(10) NOT NULL,
  `end_num` int(10) NOT NULL,
  `create_time` int(10) unsigned NOT NULL,
  `update_time` int(10) unsigned NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='货架（已弃用）';

/*Table structure for table `z_shelf_windows` */

DROP TABLE IF EXISTS `z_shelf_windows`;

CREATE TABLE `z_shelf_windows` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `shelf_id` int(10) NOT NULL,
  `shelf_index` int(10) NOT NULL,
  `window_index` int(10) NOT NULL,
  `address` int(10) NOT NULL DEFAULT '0' COMMENT '数码管地址',
  `count` int(10) NOT NULL DEFAULT '0' COMMENT '当前数量',
  `current_tags` text,
  `create_time` int(10) unsigned NOT NULL,
  `update_time` int(10) unsigned NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='货位（已弃用）';

/*Table structure for table `z_stores` */

DROP TABLE IF EXISTS `z_stores`;

CREATE TABLE `z_stores` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL COMMENT '店铺标题',
  `address` varchar(256) DEFAULT NULL COMMENT '地址',
  `remark` text COMMENT '备注',
  `shop_sn` varchar(255) NOT NULL COMMENT '店铺编号加密标识',
  `create_time` int(10) unsigned NOT NULL,
  `update_time` int(10) unsigned NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='店铺表';

/*Table structure for table `z_users` */

DROP TABLE IF EXISTS `z_users`;

CREATE TABLE `z_users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `mobile` varchar(128) NOT NULL COMMENT '手机号',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `title` varchar(128) NOT NULL COMMENT '名字',
  `store_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺Id',
  `role_id` int(10) NOT NULL DEFAULT '0' COMMENT '角色ID，暂未启用',
  `login_ip` varchar(128) DEFAULT NULL COMMENT '登录IP',
  `create_time` int(10) unsigned NOT NULL,
  `update_time` int(10) unsigned NOT NULL,
  `login_time` int(10) unsigned NOT NULL,
  `status` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`mobile`)
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户表';

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
