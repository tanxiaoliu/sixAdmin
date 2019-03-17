/*
 Navicat Premium Data Transfer

 Source Server         : 本地
 Source Server Type    : MySQL
 Source Server Version : 100130
 Source Host           : localhost:3306
 Source Schema         : six

 Target Server Type    : MySQL
 Target Server Version : 100130
 File Encoding         : 65001

 Date: 17/03/2019 16:19:09
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for member
-- ----------------------------
DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_name` varchar(25) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '会员名称',
  `phone` varchar(20) COLLATE utf8_bin DEFAULT '' COMMENT '联系电话',
  `email` varchar(30) COLLATE utf8_bin DEFAULT '' COMMENT '邮箱',
  `address` varchar(50) COLLATE utf8_bin DEFAULT '' COMMENT '联系地址',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='会员表';

-- ----------------------------
-- Table structure for member_copy2
-- ----------------------------
DROP TABLE IF EXISTS `member_copy2`;
CREATE TABLE `member_copy2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_name` varchar(25) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '会员名称',
  `phone` varchar(20) COLLATE utf8_bin DEFAULT '' COMMENT '联系电话',
  `email` varchar(30) COLLATE utf8_bin DEFAULT '' COMMENT '邮箱',
  `address` varchar(50) COLLATE utf8_bin DEFAULT '' COMMENT '联系地址',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='会员表';

-- ----------------------------
-- Table structure for member_copy3
-- ----------------------------
DROP TABLE IF EXISTS `member_copy3`;
CREATE TABLE `member_copy3` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_name` varchar(25) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '会员名称',
  `phone` varchar(20) COLLATE utf8_bin DEFAULT '' COMMENT '联系电话',
  `email` varchar(30) COLLATE utf8_bin DEFAULT '' COMMENT '邮箱',
  `address` varchar(50) COLLATE utf8_bin DEFAULT '' COMMENT '联系地址',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='会员表';

-- ----------------------------
-- Table structure for member_copy4
-- ----------------------------
DROP TABLE IF EXISTS `member_copy4`;
CREATE TABLE `member_copy4` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_name` varchar(25) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '会员名称',
  `phone` varchar(20) COLLATE utf8_bin DEFAULT '' COMMENT '联系电话',
  `email` varchar(30) COLLATE utf8_bin DEFAULT '' COMMENT '邮箱',
  `address` varchar(50) COLLATE utf8_bin DEFAULT '' COMMENT '联系地址',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='会员表';

-- ----------------------------
-- Table structure for member_copy5
-- ----------------------------
DROP TABLE IF EXISTS `member_copy5`;
CREATE TABLE `member_copy5` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_name` varchar(25) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '会员名称',
  `phone` varchar(20) COLLATE utf8_bin DEFAULT '' COMMENT '联系电话',
  `email` varchar(30) COLLATE utf8_bin DEFAULT '' COMMENT '邮箱',
  `address` varchar(50) COLLATE utf8_bin DEFAULT '' COMMENT '联系地址',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='会员表';

-- ----------------------------
-- Table structure for member_copy6
-- ----------------------------
DROP TABLE IF EXISTS `member_copy6`;
CREATE TABLE `member_copy6` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_name` varchar(25) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '会员名称',
  `phone` varchar(20) COLLATE utf8_bin DEFAULT '' COMMENT '联系电话',
  `email` varchar(30) COLLATE utf8_bin DEFAULT '' COMMENT '邮箱',
  `address` varchar(50) COLLATE utf8_bin DEFAULT '' COMMENT '联系地址',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='会员表';

-- ----------------------------
-- Table structure for member_copy7
-- ----------------------------
DROP TABLE IF EXISTS `member_copy7`;
CREATE TABLE `member_copy7` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_name` varchar(25) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '会员名称',
  `phone` varchar(20) COLLATE utf8_bin DEFAULT '' COMMENT '联系电话',
  `email` varchar(30) COLLATE utf8_bin DEFAULT '' COMMENT '邮箱',
  `address` varchar(50) COLLATE utf8_bin DEFAULT '' COMMENT '联系地址',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='会员表';

-- ----------------------------
-- Table structure for member_copy8
-- ----------------------------
DROP TABLE IF EXISTS `member_copy8`;
CREATE TABLE `member_copy8` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_name` varchar(25) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '会员名称',
  `phone` varchar(20) COLLATE utf8_bin DEFAULT '' COMMENT '联系电话',
  `email` varchar(30) COLLATE utf8_bin DEFAULT '' COMMENT '邮箱',
  `address` varchar(50) COLLATE utf8_bin DEFAULT '' COMMENT '联系地址',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='会员表';

-- ----------------------------
-- Table structure for project
-- ----------------------------
DROP TABLE IF EXISTS `project`;
CREATE TABLE `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '项目名称',
  `tag` varchar(20) COLLATE utf8_bin DEFAULT '' COMMENT '标签',
  `cover` varchar(80) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '项目封面图',
  `path` varchar(150) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '项目路径',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `delete_time` int(10) NOT NULL DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='项目表';

SET FOREIGN_KEY_CHECKS = 1;
