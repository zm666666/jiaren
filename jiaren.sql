/*
Navicat MySQL Data Transfer

Source Server         : bysjWeb
Source Server Version : 50173
Source Host           : bdm289023678.my3w.com:3306
Source Database       : bdm289023678_db

Target Server Type    : MYSQL
Target Server Version : 50173
File Encoding         : 65001

Date: 2018-06-12 21:37:17
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `psd` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', 'admin', '123456');

-- ----------------------------
-- Table structure for `bool`
-- ----------------------------
DROP TABLE IF EXISTS `bool`;
CREATE TABLE `bool` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of bool
-- ----------------------------
INSERT INTO `bool` VALUES ('1', '是');
INSERT INTO `bool` VALUES ('2', '否');

-- ----------------------------
-- Table structure for `course`
-- ----------------------------
DROP TABLE IF EXISTS `course`;
CREATE TABLE `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL COMMENT '课程名|140',
  `address` varchar(32) NOT NULL COMMENT '上课地址|240',
  `teacher` int(11) NOT NULL COMMENT '任课教师|140|teacher|id|name|name',
  `startDate` date NOT NULL COMMENT '开课日期|140',
  `finishDate` date NOT NULL COMMENT '结课日期|140',
  `weekWorkDay` int(11) NOT NULL COMMENT '上课日期|140|workday|id|workdayValue',
  `courseIndexId` int(11) NOT NULL COMMENT '上课时间|200|course_time|id|value',
  PRIMARY KEY (`id`),
  KEY `weekWorkDay` (`weekWorkDay`) USING BTREE,
  KEY `courseIndexId` (`courseIndexId`) USING BTREE,
  CONSTRAINT `course_ibfk_1` FOREIGN KEY (`weekWorkDay`) REFERENCES `workday` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `course_ibfk_2` FOREIGN KEY (`courseIndexId`) REFERENCES `course_time` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of course
-- ----------------------------
INSERT INTO `course` VALUES ('28', 'name1', 'dizhi1', '3', '2018-06-04', '2018-06-20', '3', '3');
INSERT INTO `course` VALUES ('29', 'name2', 'dizhi2dsadsasddsadsadsadsadsadsd', '3', '2017-12-11', '2017-12-18', '2', '1');
INSERT INTO `course` VALUES ('30', 'name3', 'dizhi3', '3', '2018-06-25', '2018-07-04', '5', '4');
INSERT INTO `course` VALUES ('31', 'name4', 'dizhi4', '3', '2018-06-13', '2018-06-13', '3', '3');
INSERT INTO `course` VALUES ('32', 'name5', 'dizhi5', '3', '2018-06-11', '2018-06-13', '5', '5');
INSERT INTO `course` VALUES ('33', 'name6', 'dizhi6', '3', '2018-06-04', '2018-06-22', '5', '3');
INSERT INTO `course` VALUES ('34', 'name7', 'dizhi7', '3', '2018-06-12', '2018-06-20', '3', '5');

-- ----------------------------
-- Table structure for `course_time`
-- ----------------------------
DROP TABLE IF EXISTS `course_time`;
CREATE TABLE `course_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of course_time
-- ----------------------------
INSERT INTO `course_time` VALUES ('1', '第一节-第二节');
INSERT INTO `course_time` VALUES ('2', '第三节-第四节');
INSERT INTO `course_time` VALUES ('3', '第五节-第六节');
INSERT INTO `course_time` VALUES ('4', '第七节-第八节');
INSERT INTO `course_time` VALUES ('5', '第九节-第十节');

-- ----------------------------
-- Table structure for `elective`
-- ----------------------------
DROP TABLE IF EXISTS `elective`;
CREATE TABLE `elective` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course` int(11) NOT NULL COMMENT '课程名|140|course|id|name',
  `member` int(11) NOT NULL COMMENT '会员名|140|member|id|name',
  `allow` int(11) NOT NULL COMMENT '是否同意|140|bool|id|value',
  PRIMARY KEY (`id`),
  KEY `course` (`course`) USING BTREE,
  KEY `member` (`member`) USING BTREE,
  KEY `allow` (`allow`) USING BTREE,
  CONSTRAINT `elective_ibfk_1` FOREIGN KEY (`course`) REFERENCES `course` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `elective_ibfk_2` FOREIGN KEY (`member`) REFERENCES `member` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `elective_ibfk_3` FOREIGN KEY (`allow`) REFERENCES `bool` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of elective
-- ----------------------------
INSERT INTO `elective` VALUES ('1', '28', '3', '1');
INSERT INTO `elective` VALUES ('2', '29', '3', '1');
INSERT INTO `elective` VALUES ('3', '31', '3', '2');

-- ----------------------------
-- Table structure for `evaluationcourse`
-- ----------------------------
DROP TABLE IF EXISTS `evaluationcourse`;
CREATE TABLE `evaluationcourse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `courseId` int(11) NOT NULL,
  `memberId` int(11) NOT NULL,
  `date` date NOT NULL,
  `evaluation` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of evaluationcourse
-- ----------------------------
INSERT INTO `evaluationcourse` VALUES ('1', '28', '3', '2018-06-11', 'dsdsad');
INSERT INTO `evaluationcourse` VALUES ('2', '28', '3', '0000-00-00', 'dasdasd');

-- ----------------------------
-- Table structure for `member`
-- ----------------------------
DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(12) NOT NULL COMMENT '姓名|140',
  `sex` int(11) NOT NULL COMMENT '性别|140|sex|id|value',
  `psd` varchar(12) NOT NULL COMMENT '密码|140',
  `mail` varchar(32) NOT NULL COMMENT '邮箱|140',
  `tel` varchar(32) NOT NULL COMMENT '电话|140',
  `address` varchar(32) NOT NULL COMMENT '地址|140',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE,
  KEY `sex` (`sex`) USING BTREE,
  CONSTRAINT `member_ibfk_1` FOREIGN KEY (`sex`) REFERENCES `sex` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of member
-- ----------------------------
INSERT INTO `member` VALUES ('3', 'czj', '1', '123456', '123654@qq.com', '1326547', 'asdasds');
INSERT INTO `member` VALUES ('4', 'zm', '1', '123456', 'dsadsa@163.com', '1234123', 'fafa');

-- ----------------------------
-- Table structure for `sex`
-- ----------------------------
DROP TABLE IF EXISTS `sex`;
CREATE TABLE `sex` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sex
-- ----------------------------
INSERT INTO `sex` VALUES ('1', '男');
INSERT INTO `sex` VALUES ('2', '女');

-- ----------------------------
-- Table structure for `teacher`
-- ----------------------------
DROP TABLE IF EXISTS `teacher`;
CREATE TABLE `teacher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL COMMENT '姓名|140',
  `workYear` varchar(32) NOT NULL COMMENT '工龄|140',
  `sex` int(11) NOT NULL COMMENT '性别|140|sex|id|value',
  `birthday` date NOT NULL COMMENT '生日|140',
  `tel` varchar(32) NOT NULL COMMENT '联系电话|140',
  PRIMARY KEY (`id`),
  KEY `sex` (`sex`) USING BTREE,
  CONSTRAINT `teacher_ibfk_1` FOREIGN KEY (`sex`) REFERENCES `sex` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of teacher
-- ----------------------------
INSERT INTO `teacher` VALUES ('3', '教师1', '13', '1', '2018-00-19', '1231212');

-- ----------------------------
-- Table structure for `workday`
-- ----------------------------
DROP TABLE IF EXISTS `workday`;
CREATE TABLE `workday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `workdayValue` varchar(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of workday
-- ----------------------------
INSERT INTO `workday` VALUES ('1', '周一');
INSERT INTO `workday` VALUES ('2', '周二');
INSERT INTO `workday` VALUES ('3', '周三');
INSERT INTO `workday` VALUES ('4', '周四');
INSERT INTO `workday` VALUES ('5', '周五');
INSERT INTO `workday` VALUES ('6', '周六');
INSERT INTO `workday` VALUES ('7', '周日');
