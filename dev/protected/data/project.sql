/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : project

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2014-06-13 10:33:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for pro_auth_assignment
-- ----------------------------
DROP TABLE IF EXISTS `pro_auth_assignment`;
CREATE TABLE `pro_auth_assignment` (
  `itemname` varchar(64) NOT NULL COMMENT '角色名称，和auth_items中对应，区分大小写；',
  `userid` varchar(64) NOT NULL COMMENT '用户ID，须在配置部分中预先定义所对应实际用户表的字段名；',
  `bizrule` text COMMENT '同auth_items中的代码段；',
  `data` text COMMENT '长字符串，序列化后的数组。用于给bizrule提供参数；',
  PRIMARY KEY (`itemname`,`userid`),
  CONSTRAINT `pro_auth_assignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `pro_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='记录 用户->角色 之间的对应关系，将不同的用户分配至不同的角色(用户组)。';

-- ----------------------------
-- Records of pro_auth_assignment
-- ----------------------------
INSERT INTO `pro_auth_assignment` VALUES ('admin', 'adminD', null, 'N;');
INSERT INTO `pro_auth_assignment` VALUES ('author', 'authorB', null, 'N;');
INSERT INTO `pro_auth_assignment` VALUES ('editor', 'editorC', null, 'N;');
INSERT INTO `pro_auth_assignment` VALUES ('reader', 'readerA', null, 'N;');

-- ----------------------------
-- Table structure for pro_auth_item
-- ----------------------------
DROP TABLE IF EXISTS `pro_auth_item`;
CREATE TABLE `pro_auth_item` (
  `name` varchar(64) NOT NULL COMMENT '存放对象名称，字符串；',
  `type` int(11) NOT NULL COMMENT '对象类型，(0, 1, 2); 0 - Operation 操作;1 - Task 任务;2 - Role 角色',
  `description` text COMMENT '相关的描述，长字符串；',
  `bizrule` text COMMENT '长字符串，可以在这里定义一个PHP的代码块，以增强验证的扩展性；',
  `data` text COMMENT '长字符串，序列化后的数组。用于给bizrule提供参数；',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用来记录RBAC中的对象。';

-- ----------------------------
-- Records of pro_auth_item
-- ----------------------------
INSERT INTO `pro_auth_item` VALUES ('admin', '2', '', null, 'N;');
INSERT INTO `pro_auth_item` VALUES ('author', '2', '', null, 'N;');
INSERT INTO `pro_auth_item` VALUES ('createPost', '0', 'create a post', null, 'N;');
INSERT INTO `pro_auth_item` VALUES ('deletePost', '0', 'delete a post', null, 'N;');
INSERT INTO `pro_auth_item` VALUES ('editor', '2', '', null, 'N;');
INSERT INTO `pro_auth_item` VALUES ('reader', '2', '', null, 'N;');
INSERT INTO `pro_auth_item` VALUES ('readPost', '0', 'read a post', null, 'N;');
INSERT INTO `pro_auth_item` VALUES ('updateOwnPost', '1', 'update a post by author himself', 'return Yii::app()->user->id==$params[\"post\"]->authID;', 'N;');
INSERT INTO `pro_auth_item` VALUES ('updatePost', '0', 'update a post', null, 'N;');

-- ----------------------------
-- Table structure for pro_auth_item_child
-- ----------------------------
DROP TABLE IF EXISTS `pro_auth_item_child`;
CREATE TABLE `pro_auth_item_child` (
  `parent` varchar(64) NOT NULL COMMENT '父级名称。可以是角色名，也可以是任务名；',
  `child` varchar(64) NOT NULL COMMENT '子对象名称。可以是任务名，也可以是操作名；',
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `pro_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `pro_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pro_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `pro_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='记录 角色->任务 、 角色->操作 和 任务->操作 之间的对应关系。';

-- ----------------------------
-- Records of pro_auth_item_child
-- ----------------------------
INSERT INTO `pro_auth_item_child` VALUES ('admin', 'author');
INSERT INTO `pro_auth_item_child` VALUES ('author', 'createPost');
INSERT INTO `pro_auth_item_child` VALUES ('admin', 'deletePost');
INSERT INTO `pro_auth_item_child` VALUES ('admin', 'editor');
INSERT INTO `pro_auth_item_child` VALUES ('author', 'reader');
INSERT INTO `pro_auth_item_child` VALUES ('editor', 'reader');
INSERT INTO `pro_auth_item_child` VALUES ('reader', 'readPost');
INSERT INTO `pro_auth_item_child` VALUES ('author', 'updateOwnPost');
INSERT INTO `pro_auth_item_child` VALUES ('editor', 'updatePost');
INSERT INTO `pro_auth_item_child` VALUES ('updateOwnPost', 'updatePost');

-- ----------------------------
-- Table structure for pro_bug
-- ----------------------------
DROP TABLE IF EXISTS `pro_bug`;
CREATE TABLE `pro_bug` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` smallint(2) NOT NULL,
  `create_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `principal` int(11) DEFAULT NULL COMMENT '负责人',
  `schedule` smallint(3) NOT NULL DEFAULT '0' COMMENT '进度',
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `file` varchar(200) NOT NULL,
  `path` varchar(200) DEFAULT NULL,
  `url` varchar(200) NOT NULL,
  `time_created` int(11) NOT NULL,
  `time_updated` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`,`create_id`,`project_id`,`principal`,`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='存储Bug数据';

-- ----------------------------
-- Records of pro_bug
-- ----------------------------

-- ----------------------------
-- Table structure for pro_cases
-- ----------------------------
DROP TABLE IF EXISTS `pro_cases`;
CREATE TABLE `pro_cases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` smallint(2) NOT NULL,
  `create_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `principal` int(11) DEFAULT NULL COMMENT '负责人',
  `schedule` smallint(3) DEFAULT '0',
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `file` varchar(200) NOT NULL,
  `path` varchar(200) DEFAULT NULL,
  `url` varchar(200) NOT NULL,
  `time_created` int(11) NOT NULL,
  `time_updated` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`,`status`,`create_id`,`project_id`,`principal`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='存储用例数据';

-- ----------------------------
-- Records of pro_cases
-- ----------------------------

-- ----------------------------
-- Table structure for pro_category
-- ----------------------------
DROP TABLE IF EXISTS `pro_category`;
CREATE TABLE `pro_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` smallint(2) NOT NULL,
  `create_id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` varchar(500) NOT NULL,
  `time_created` int(11) NOT NULL,
  `time_updated` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`,`status`,`create_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文档类型';

-- ----------------------------
-- Records of pro_category
-- ----------------------------

-- ----------------------------
-- Table structure for pro_document
-- ----------------------------
DROP TABLE IF EXISTS `pro_document`;
CREATE TABLE `pro_document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` smallint(2) NOT NULL,
  `create_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `file` varchar(200) DEFAULT NULL,
  `path` varchar(200) DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `time_created` int(11) NOT NULL,
  `time_updated` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`,`status`,`create_id`,`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文档表';

-- ----------------------------
-- Records of pro_document
-- ----------------------------

-- ----------------------------
-- Table structure for pro_log_access
-- ----------------------------
DROP TABLE IF EXISTS `pro_log_access`;
CREATE TABLE `pro_log_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` smallint(2) NOT NULL,
  `create_id` int(11) NOT NULL,
  `session` varchar(40) NOT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `time_created` int(11) NOT NULL,
  `time_updated` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`,`status`,`create_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='记录用户登录状态';

-- ----------------------------
-- Records of pro_log_access
-- ----------------------------

-- ----------------------------
-- Table structure for pro_log_error
-- ----------------------------
DROP TABLE IF EXISTS `pro_log_error`;
CREATE TABLE `pro_log_error` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` smallint(2) NOT NULL,
  `create_id` int(11) NOT NULL,
  `error_code` int(11) NOT NULL COMMENT '错误代码，例如404，403，405，500',
  `content` varchar(225) NOT NULL,
  `error_url` varchar(225) NOT NULL COMMENT '出错时的url',
  `from_url` varchar(225) NOT NULL COMMENT '从哪个url转到出错url',
  `time_created` int(11) NOT NULL,
  `time_updated` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='记录页面出错时的信息';

-- ----------------------------
-- Records of pro_log_error
-- ----------------------------

-- ----------------------------
-- Table structure for pro_memo
-- ----------------------------
DROP TABLE IF EXISTS `pro_memo`;
CREATE TABLE `pro_memo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `create_id` int(11) DEFAULT NULL,
  `status` smallint(2) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `time_start` int(11) DEFAULT NULL,
  `time_end` int(11) DEFAULT NULL,
  `time_created` int(11) DEFAULT NULL,
  `time_updated` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`,`create_id`,`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='储存用户的备忘录信息';

-- ----------------------------
-- Records of pro_memo
-- ----------------------------

-- ----------------------------
-- Table structure for pro_message
-- ----------------------------
DROP TABLE IF EXISTS `pro_message`;
CREATE TABLE `pro_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `receive_status` smallint(2) NOT NULL COMMENT '收件人信件状态',
  `output_status` smallint(2) NOT NULL COMMENT '发件人信件状态',
  `create_id` int(11) NOT NULL COMMENT '发信人',
  `receive_id` int(11) NOT NULL COMMENT '收信人',
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `file` varchar(200) NOT NULL,
  `path` varchar(200) NOT NULL,
  `url` varchar(200) NOT NULL,
  `time_created` int(11) NOT NULL,
  `time_updated` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`output_status`,`create_id`,`receive_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='信息表';

-- ----------------------------
-- Records of pro_message
-- ----------------------------

-- ----------------------------
-- Table structure for pro_operation
-- ----------------------------
DROP TABLE IF EXISTS `pro_operation`;
CREATE TABLE `pro_operation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` smallint(2) NOT NULL,
  `create_id` int(11) NOT NULL,
  `object_type` tinyint(1) DEFAULT NULL,
  `object_id` int(11) NOT NULL,
  `action` varchar(200) NOT NULL,
  `time_created` int(11) NOT NULL,
  `time_updated` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`,`status`,`create_id`,`object_type`,`object_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='储存用户在网站进行的操作';

-- ----------------------------
-- Records of pro_operation
-- ----------------------------

-- ----------------------------
-- Table structure for pro_project
-- ----------------------------
DROP TABLE IF EXISTS `pro_project`;
CREATE TABLE `pro_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `create_id` int(11) NOT NULL,
  `status` smallint(2) NOT NULL,
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `file` varchar(200) NOT NULL,
  `path` varchar(200) DEFAULT NULL,
  `url` varchar(200) NOT NULL,
  `principal` int(11) NOT NULL COMMENT '负责人',
  `team` varchar(200) DEFAULT NULL COMMENT '团队，数据格式是 1,2,3,4,5,6',
  `total_expected` int(11) NOT NULL COMMENT '总预计',
  `total_expend` int(11) NOT NULL COMMENT '总消耗',
  `total_residue` int(11) NOT NULL COMMENT '总剩余',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '是否为子模块',
  `schedule` smallint(3) NOT NULL COMMENT '进度',
  `time_created` int(11) NOT NULL,
  `time_updated` int(11) NOT NULL,
  `time_end` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`,`create_id`,`status`,`principal`,`parent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='项目列表';

-- ----------------------------
-- Records of pro_project
-- ----------------------------

-- ----------------------------
-- Table structure for pro_promission
-- ----------------------------
DROP TABLE IF EXISTS `pro_promission`;
CREATE TABLE `pro_promission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `create_id` int(11) NOT NULL,
  `status` smallint(2) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` varchar(200) NOT NULL,
  `parent_id` int(11) NOT NULL COMMENT '父节点',
  `staff` tinyint(1) NOT NULL COMMENT '职员或者是职位',
  `time_created` int(11) NOT NULL,
  `time_updated` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`) USING BTREE,
  KEY `title` (`title`) USING BTREE,
  KEY `parent_id` (`parent_id`) USING BTREE,
  KEY `id_2` (`id`,`create_id`,`status`,`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COMMENT='公司职位结构表';

-- ----------------------------
-- Records of pro_promission
-- ----------------------------
INSERT INTO `pro_promission` VALUES ('1', '1', '1', '欧派家具集团', '', '0', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('2', '1', '1', '集团总部', '', '1', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('3', '1', '1', '欧派家居集团股份有限公司', '', '1', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('4', '1', '1', '橱柜总经理室', '', '3', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('5', '1', '1', '橱柜营销线', '', '3', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('6', '1', '1', '主动营销经理', '', '5', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('7', '1', '1', '橱柜营销行政办', '', '5', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('8', '1', '1', '橱柜经销一部', '', '5', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('9', '1', '1', '广州分公司', '', '5', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('10', '1', '1', '橱柜经销二部', '', '5', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('11', '1', '1', '橱柜经销三部', '', '5', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('12', '1', '1', '橱柜经销四部', '', '5', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('13', '1', '1', '电商运营部', '', '5', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('14', '1', '1', '电商运营部总监', '', '13', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('15', '1', '1', '行政管理员', '', '13', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('16', '1', '1', '质量监督员', '', '13', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('17', '1', '1', '销售组', '', '13', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('18', '1', '1', '网络运营组', '', '13', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('19', '1', '1', '技术组', '', '13', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('20', '1', '1', '客服组', '', '13', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('21', '1', '1', '销售主管', '', '17', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('22', '1', '1', '区域营销专员', '', '17', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('23', '1', '1', '营销策划专员', '', '17', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('24', '1', '1', '销售助理', '', '17', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('25', '1', '1', '网络运营经理', '', '18', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('26', '1', '1', '运营组', '', '18', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('27', '1', '1', '产品策划组', '', '18', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('28', '1', '1', '市场推广组', '', '18', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('29', '1', '1', '技术副经理', '', '19', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('30', '1', '1', '高级程序专员', '', '19', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('31', '1', '1', '初级程序专员', '', '19', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('32', '1', '1', '前端工程师', '', '19', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('33', '1', '1', '运维专员', '', '19', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('34', '1', '1', '客服主管', '', '20', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('35', '1', '1', '官网客服', '', '20', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('36', '1', '1', '在线客服', '', '20', '0', '1400000000', '0');
INSERT INTO `pro_promission` VALUES ('37', '1', '1', '电话客服', '', '20', '0', '1400000000', '0');

-- ----------------------------
-- Table structure for pro_requires
-- ----------------------------
DROP TABLE IF EXISTS `pro_requires`;
CREATE TABLE `pro_requires` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` smallint(2) NOT NULL,
  `create_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `principal` int(11) DEFAULT NULL COMMENT '负责人',
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `file` varchar(200) NOT NULL,
  `path` varchar(200) DEFAULT NULL,
  `url` varchar(200) NOT NULL,
  `time_created` int(11) NOT NULL,
  `time_updated` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`,`status`,`create_id`,`project_id`,`principal`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='存储需求数据';

-- ----------------------------
-- Records of pro_requires
-- ----------------------------

-- ----------------------------
-- Table structure for pro_task
-- ----------------------------
DROP TABLE IF EXISTS `pro_task`;
CREATE TABLE `pro_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` smallint(2) NOT NULL,
  `create_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `principal` int(11) DEFAULT NULL COMMENT '负责人',
  `schedule` smallint(3) DEFAULT '0',
  `title` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `file` varchar(200) NOT NULL,
  `path` varchar(200) DEFAULT NULL,
  `url` varchar(200) NOT NULL,
  `time_created` int(11) NOT NULL,
  `time_updated` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `title` (`title`) USING BTREE,
  KEY `id` (`id`,`status`,`create_id`,`project_id`,`principal`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='存储任务数据';

-- ----------------------------
-- Records of pro_task
-- ----------------------------

-- ----------------------------
-- Table structure for pro_user
-- ----------------------------
DROP TABLE IF EXISTS `pro_user`;
CREATE TABLE `pro_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` smallint(2) NOT NULL,
  `username` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `birthday` int(11) NOT NULL,
  `sex` tinyint(1) NOT NULL,
  `position` varchar(100) NOT NULL COMMENT '职位',
  `password` varchar(100) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `profile` varchar(200) NOT NULL,
  `role` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:user; 1:admin; 2:super admin',
  `time_created` int(11) NOT NULL,
  `time_updated` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`,`status`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户及管理员表';

-- ----------------------------
-- Records of pro_user
-- ----------------------------
INSERT INTO `pro_user` VALUES ('1', '1', 'admin', 'administrator', '723254400', '2', '超级管理员', '$2a$10$IYH.esNzng1wPe.fiea4peSmvbvwARdeH1p6fH9LJGfchFmYzYsKy', '18620461262', '359426334@qq.com', '这个账号是网站的超级管理员，拥有最高权限。', '2', '1400000000', '1402625990');
