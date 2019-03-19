/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : six

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-03-19 11:28:48
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for k_member
-- ----------------------------
DROP TABLE IF EXISTS `k_member`;
CREATE TABLE `k_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_name` varchar(25) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '会员名称',
  `phone` varchar(20) COLLATE utf8_bin DEFAULT '' COMMENT '联系电话',
  `email` varchar(30) COLLATE utf8_bin DEFAULT '' COMMENT '邮箱',
  `address` varchar(50) COLLATE utf8_bin DEFAULT '' COMMENT '联系地址',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='会员表';

-- ----------------------------
-- Records of k_member
-- ----------------------------
INSERT INTO `k_member` VALUES ('1', '刘德华', '132884812111', '252525@qq.com', '广州天河区智慧谷1号', '0', '1552964957', null);

-- ----------------------------
-- Table structure for k_power
-- ----------------------------
DROP TABLE IF EXISTS `k_power`;
CREATE TABLE `k_power` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `power_name` varchar(25) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '权限名称',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父级菜单id',
  `uri` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT 'uri地址',
  `icon` varchar(50) COLLATE utf8_bin DEFAULT '' COMMENT '图标',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `remark` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT '备注',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '权限类型:菜单0 按钮1',
  PRIMARY KEY (`id`),
  KEY `ind_type_parent_id` (`type`,`parent_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='权限表';

-- ----------------------------
-- Records of k_power
-- ----------------------------
INSERT INTO `k_power` VALUES ('1', '项目管理', '0', '', 'template-1', '0', '0', null, '100', null, '0');
INSERT INTO `k_power` VALUES ('2', '系统管理', '0', '', 'set', '0', '0', null, '300', null, '0');
INSERT INTO `k_power` VALUES ('3', '项目列表', '1', '/admin/project/lists', '', '0', '0', null, '100', null, '0');
INSERT INTO `k_power` VALUES ('4', '项目页面列表', '1', '/admin/projectview/lists', '', '0', '0', null, '200', null, '0');
INSERT INTO `k_power` VALUES ('5', '用户管理', '2', '/admin/user/lists', '', '0', '0', null, '0', null, '0');
INSERT INTO `k_power` VALUES ('7', '权限管理', '2', '/admin/power/lists', '', '0', '0', null, '0', null, '0');
INSERT INTO `k_power` VALUES ('8', '角色管理', '2', '/admin/role/lists', '', '0', '0', null, '0', null, '0');
INSERT INTO `k_power` VALUES ('9', '会员管理', '0', '', 'user', '0', '0', null, '200', null, '0');
INSERT INTO `k_power` VALUES ('10', '会员列表', '9', '/admin/member/lists', '', '0', '0', null, '0', null, '0');

-- ----------------------------
-- Table structure for k_project
-- ----------------------------
DROP TABLE IF EXISTS `k_project`;
CREATE TABLE `k_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '项目名称',
  `tag` varchar(20) COLLATE utf8_bin DEFAULT '' COMMENT '标签',
  `cover` varchar(80) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '项目封面图',
  `path` varchar(150) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '项目路径',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
  `member_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员id',
  PRIMARY KEY (`id`),
  KEY `ind_member_id` (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='项目表';

-- ----------------------------
-- Records of k_project
-- ----------------------------
INSERT INTO `k_project` VALUES ('5', '王企鹅无群二二', '王企鹅二', '/uploads/project/20190318/1c6c7e94dfe730ab6eaf9af07beb6fd9.jpg', '王企鹅二恶烷若', '1552900126', '1552908802', null, '0');
INSERT INTO `k_project` VALUES ('6', '123', '123', '/uploads/project/20190318/df5bcd99e0bbce0a35e19bdd8decc2f7.jpg', '213', '1552901439', '1552908794', null, '0');
INSERT INTO `k_project` VALUES ('7', '56', '565463', '/uploads/project/20190318/666d5809b24a312aed7cbef32273a078.jpg', '4546', '1552903506', '1552908970', null, '0');
INSERT INTO `k_project` VALUES ('8', '32432', '2342', '/uploads/project/20190318/1d3ff09d7614d3b63542f871c77ae1be.jpg', '234234', '0', '1552908965', null, '0');

-- ----------------------------
-- Table structure for k_project_view
-- ----------------------------
DROP TABLE IF EXISTS `k_project_view`;
CREATE TABLE `k_project_view` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(25) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '标题名称',
  `member_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员id',
  `project_ids` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '项目id',
  `url` varchar(100) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '页面地址',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `ind_member_id` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='项目页面表';

-- ----------------------------
-- Records of k_project_view
-- ----------------------------

-- ----------------------------
-- Table structure for k_role
-- ----------------------------
DROP TABLE IF EXISTS `k_role`;
CREATE TABLE `k_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '角色名称',
  `remark` varchar(50) COLLATE utf8_bin DEFAULT '' COMMENT '备注',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态：0正常 1禁用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='角色表';

-- ----------------------------
-- Records of k_role
-- ----------------------------
INSERT INTO `k_role` VALUES ('1', '123', '213', '1552961852', '1552961852', null, '12');

-- ----------------------------
-- Table structure for k_role_power
-- ----------------------------
DROP TABLE IF EXISTS `k_role_power`;
CREATE TABLE `k_role_power` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL DEFAULT '0' COMMENT '角色id',
  `power_id` int(11) NOT NULL DEFAULT '0' COMMENT '权限id',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='角色权限关联表';

-- ----------------------------
-- Records of k_role_power
-- ----------------------------

-- ----------------------------
-- Table structure for k_user
-- ----------------------------
DROP TABLE IF EXISTS `k_user`;
CREATE TABLE `k_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(25) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '用户名',
  `nickname` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '用户昵称',
  `password` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '密码',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0正常 1禁用',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
  `phone` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '手机',
  `email` varchar(30) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '邮箱',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='用户表';

-- ----------------------------
-- Records of k_user
-- ----------------------------
INSERT INTO `k_user` VALUES ('1', 'admin', '超级管理员', '$2y$10$5amXYmtBy7jApvYhxh8BK.KQ.OjH04Ck8', '0', '0', '1552911597', null, '234', '324');
INSERT INTO `k_user` VALUES ('2', 'test', '超级管', '$2y$10$p.CDF/KJ6BK4tCnZUJk/MenIaK5sK2nLr', '0', '0', '1552910838', null, '21321', '3213');
INSERT INTO `k_user` VALUES ('3', '213', '23', '', '1', '1552911627', '1552911627', null, '213', '213');
INSERT INTO `k_user` VALUES ('4', '234', '324', '', '0', '1552959635', '1552959814', null, '324', '324');

-- ----------------------------
-- Table structure for k_user_role
-- ----------------------------
DROP TABLE IF EXISTS `k_user_role`;
CREATE TABLE `k_user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `role_id` int(11) NOT NULL DEFAULT '0' COMMENT '角色id',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='用户角色关联表';

-- ----------------------------
-- Records of k_user_role
-- ----------------------------
INSERT INTO `k_user_role` VALUES ('1', '1', '1', '0');
INSERT INTO `k_user_role` VALUES ('2', '1', '2', '0');
INSERT INTO `k_user_role` VALUES ('3', '2', '2', '0');
INSERT INTO `k_user_role` VALUES ('4', '2', '3', '0');
