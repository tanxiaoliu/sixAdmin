/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : six

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-07-04 11:16:15
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='会员表';

-- ----------------------------
-- Records of k_member
-- ----------------------------
INSERT INTO `k_member` VALUES ('1', '刘德华', '132884812111', '252525@qq.com', '广州天河区智慧谷1号', '0', '1552964957', null);
INSERT INTO `k_member` VALUES ('2', '长221', '', '', '', '1553139563', '1555986595', '1555986595');
INSERT INTO `k_member` VALUES ('3', '刘', '', '', '', '1553139570', '1555986599', '1555986599');
INSERT INTO `k_member` VALUES ('4', '213', '13255555555', '', '', '1553150214', '1555986709', '1555986709');
INSERT INTO `k_member` VALUES ('5', '2432', '', '', '', '1553823544', '1555986603', '1555986603');
INSERT INTO `k_member` VALUES ('6', '123', '', '', '', '1553823554', '1553827539', '1553827539');
INSERT INTO `k_member` VALUES ('7', '234', '', '', '', '1553823571', '1553827458', '1553827458');
INSERT INTO `k_member` VALUES ('8', '345', '', '', '', '1553823588', '1553827454', '1553827454');
INSERT INTO `k_member` VALUES ('9', '234', '', '', '', '1553849581', '1555986607', '1555986607');

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='权限表';

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
INSERT INTO `k_power` VALUES ('11', '新增会员', '10', '/admin/member/add', '', '0', '0', null, '0', null, '1');
INSERT INTO `k_power` VALUES ('12', '编辑会员', '10', '/admin/member/edit', '', '0', '0', null, '0', null, '1');

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
INSERT INTO `k_project` VALUES ('7', '56', '565463', '/uploads/project/20190318/666d5809b24a312aed7cbef32273a078.jpg', '4546', '1552903506', '1553146722', null, '1');
INSERT INTO `k_project` VALUES ('8', '3243266', '2342', '/uploads/project/20190318/1d3ff09d7614d3b63542f871c77ae1be.jpg', '234234', '0', '1562209298', null, '1');

-- ----------------------------
-- Table structure for k_project_view
-- ----------------------------
DROP TABLE IF EXISTS `k_project_view`;
CREATE TABLE `k_project_view` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(25) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '标题名称',
  `member_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员id',
  `project_ids` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '项目id',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `ind_member_id` (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='项目页面表';

-- ----------------------------
-- Records of k_project_view
-- ----------------------------
INSERT INTO `k_project_view` VALUES ('1', '23', '2', '234', '1552966262', '1553751442', null);
INSERT INTO `k_project_view` VALUES ('2', '213324', '5', '123', '1554359731', '1554360196', null);

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
  `power_ids` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '角色权限id集合',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='角色表';

-- ----------------------------
-- Records of k_role
-- ----------------------------
INSERT INTO `k_role` VALUES ('4', '普通员工', '', '1553764483', '1553764483', null, '0', '');
INSERT INTO `k_role` VALUES ('5', '测试', '', '1553764492', '1555486328', null, '0', '1,3,2,7,8,9,10,11,12');
INSERT INTO `k_role` VALUES ('6', '管理员', '测试', '1553764500', '1555474310', null, '0', '1,3,9,10,11,12');

-- ----------------------------
-- Table structure for k_user
-- ----------------------------
DROP TABLE IF EXISTS `k_user`;
CREATE TABLE `k_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(25) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '用户账号',
  `nickname` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '用户昵称',
  `password` varchar(60) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '密码',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0正常 1禁用',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) DEFAULT NULL COMMENT '删除时间',
  `phone` varchar(20) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '手机',
  `email` varchar(30) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '邮箱',
  `role_id` int(11) NOT NULL DEFAULT '0' COMMENT '角色id',
  `last_login_ip` varchar(12) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '最后登录ip',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='用户表';

-- ----------------------------
-- Records of k_user
-- ----------------------------
INSERT INTO `k_user` VALUES ('1', 'admin', '超级管理员', '$2y$10$GccDr.TM5umFn72u1/OxS.XLffcgXuDuJwLHsEjm02ZcTLI2Y0oGG', '0', '0', '1554774232', null, '', '', '0', '');
INSERT INTO `k_user` VALUES ('6', 'test', '测试', '$2y$10$Lnoh/GYPE6G9vdM0oZgC8eHhTFnemKpx/aDquBs1ATo4Clowqp.R.', '0', '1553765094', '1555482271', null, '13288456565', '530022151@qq.com', '5', '');
