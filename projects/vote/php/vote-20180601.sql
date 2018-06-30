-- MySQL dump 10.13  Distrib 5.7.22, for Linux (x86_64)
--
-- Host: localhost    Database: vote
-- ------------------------------------------------------
-- Server version	5.7.22-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章id',
  `title` varchar(155) NOT NULL COMMENT '文章标题',
  `description` varchar(255) NOT NULL COMMENT '文章描述',
  `keywords` varchar(155) NOT NULL COMMENT '文章关键字',
  `thumbnail` varchar(255) NOT NULL COMMENT '文章缩略图',
  `content` text NOT NULL COMMENT '文章内容',
  `add_time` datetime NOT NULL COMMENT '发布时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articles`
--

LOCK TABLES `articles` WRITE;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `country` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '国家ID',
  `cname` varchar(100) NOT NULL DEFAULT '' COMMENT '国家名(中文)',
  `ename` varchar(100) NOT NULL DEFAULT '' COMMENT '国家名(英文)',
  `pic` varchar(255) DEFAULT NULL COMMENT '国旗',
  `is_valid` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：0无效，1有效',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `country`
--

LOCK TABLES `country` WRITE;
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
INSERT INTO `country` VALUES (1,'俄罗斯','Russia','/upload/country/Russia.png',1),(2,'德国','Germany','/upload/country/Germany.png',1),(3,'巴西','Brazil','/upload/country/Brazil.png',1),(4,'葡萄牙','Portugal','/upload/country/Portugal.png',1),(5,'阿根廷','Argentina','/upload/country/Argentina.png',1),(6,'比利时','Belgium','/upload/country/Belgium.png',1),(7,'波兰','Poland','/upload/country/Poland.png',1),(8,'法国','France','/upload/country/France.png',1),(9,'西班牙','Spain','/upload/country/Spain.png',1),(10,'秘鲁','Peru','/upload/country/Peru.png',1),(11,'瑞士','Switzerland','/upload/country/Switzerland.png',1),(12,'英格兰','England','/upload/country/England.png',1),(13,'哥伦比亚','Colombia','/upload/country/Colombia.png',1),(14,'墨西哥','Mexico','/upload/country/Mexico.png',1),(15,'乌拉圭','Uruguay','/upload/country/Uruguay.png',1),(16,'克罗地亚','Croatia','/upload/country/Croatia.png',1),(17,'丹麦','Denmark','/upload/country/Denmark.png',1),(18,'冰岛','Iceland','/upload/country/Iceland.png',1),(19,'哥斯达黎加','CostaRica','/upload/country/CostaRica.png',1),(20,'瑞典','Sweden','/upload/country/Sweden.png',1),(21,'突尼斯','Tunisia','/upload/country/Tunisia.png',1),(22,'埃及','Egypt','/upload/country/Egypt.png',1),(23,'塞内加尔','Senegal','/upload/country/Senegal.png',1),(24,'伊朗','Iran','/upload/country/Iran.png',1),(25,'塞尔维亚','Serbia','/upload/country/Serbia.png',1),(26,'尼日利亚','Nigeria','/upload/country/Nigeria.png',1),(27,'澳大利亚','Australia','/upload/country/Australia.png',1),(28,'日本','Japan','/upload/country/Japan.png',1),(29,'摩洛哥','Morocco','/upload/country/Morocco.png',1),(30,'巴拿马','Panama','/upload/country/Panama.png',1),(31,'韩国','SouthKorea','/upload/country/SouthKorea.png',1),(32,'沙特阿拉伯','SaudiArabia','/upload/country/SaudiArabia.png',1);
/*!40000 ALTER TABLE `country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `elastos_articles`
--

DROP TABLE IF EXISTS `elastos_articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `elastos_articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '文章id',
  `title` varchar(155) NOT NULL COMMENT '文章标题',
  `description` varchar(255) NOT NULL COMMENT '文章描述',
  `keywords` varchar(155) NOT NULL COMMENT '文章关键字',
  `thumbnail` varchar(255) NOT NULL COMMENT '文章缩略图',
  `content` text NOT NULL COMMENT '文章内容',
  `add_time` datetime NOT NULL COMMENT '发布时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `elastos_articles`
--

LOCK TABLES `elastos_articles` WRITE;
/*!40000 ALTER TABLE `elastos_articles` DISABLE KEYS */;
/*!40000 ALTER TABLE `elastos_articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `elastos_country`
--

DROP TABLE IF EXISTS `elastos_country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `elastos_country` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '国家ID',
  `cname` varchar(100) NOT NULL DEFAULT '' COMMENT '国家名(中文)',
  `ename` varchar(100) NOT NULL DEFAULT '' COMMENT '国家名(英文)',
  `pic` varchar(255) DEFAULT NULL COMMENT '国旗',
  `is_valid` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：0无效，1有效',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `elastos_country`
--

LOCK TABLES `elastos_country` WRITE;
/*!40000 ALTER TABLE `elastos_country` DISABLE KEYS */;
INSERT INTO `elastos_country` VALUES (1,'俄罗斯','Russia','/upload/country/Russia.png',1),(2,'德国','Germany','/upload/country/Germany.png',1),(3,'巴西','Brazil','/upload/country/Brazil.png',1),(4,'葡萄牙','Portugal','/upload/country/Portugal.png',1),(5,'阿根廷','Argentina','/upload/country/Argentina.png',1),(6,'比利时','Belgium','/upload/country/Belgium.png',1),(7,'波兰','Poland','/upload/country/Poland.png',1),(8,'法国','France','/upload/country/France.png',1),(9,'西班牙','Spain','/upload/country/Spain.png',1),(10,'秘鲁','Peru','/upload/country/Peru.png',1),(11,'瑞士','Switzerland','/upload/country/Switzerland.png',1),(12,'英格兰','England','/upload/country/England.png',1),(13,'哥伦比亚','Colombia','/upload/country/Colombia.png',1),(14,'墨西哥','Mexico','/upload/country/Mexico.png',1),(15,'乌拉圭','Uruguay','/upload/country/Uruguay.png',1),(16,'克罗地亚','Croatia','/upload/country/Croatia.png',1),(17,'丹麦','Denmark','/upload/country/Denmark.png',1),(18,'冰岛','Iceland','/upload/country/Iceland.png',1),(19,'哥斯达黎加','CostaRica','/upload/country/CostaRica.png',1),(20,'瑞典','Sweden','/upload/country/Sweden.png',1),(21,'突尼斯','Tunisia','/upload/country/Tunisia.png',1),(22,'埃及','Egypt','/upload/country/Egypt.png',1),(23,'塞内加尔','Senegal','/upload/country/Senegal.png',1),(24,'伊朗','Iran','/upload/country/Iran.png',1),(25,'塞尔维亚','Serbia','/upload/country/Serbia.png',1),(26,'尼日利亚','Nigeria','/upload/country/Nigeria.png',1),(27,'澳大利亚','Australia','/upload/country/Australia.png',1),(28,'日本','Japan','/upload/country/Japan.png',1),(29,'摩洛哥','Morocco','/upload/country/Morocco.png',1),(30,'巴拿马','Panama','/upload/country/Panama.png',1),(31,'韩国','SouthKorea','/upload/country/SouthKorea.png',1),(32,'沙特阿拉伯','SaudiArabia','/upload/country/SaudiArabia.png',1);
/*!40000 ALTER TABLE `elastos_country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `elastos_members`
--

DROP TABLE IF EXISTS `elastos_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `elastos_members` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` varchar(100) DEFAULT '' COMMENT '用户名',
  `password` varchar(100) DEFAULT '' COMMENT '密码',
  `mobile` varchar(45) DEFAULT '' COMMENT '手机号',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `referee` int(10) DEFAULT '0',
  `is_official` int(1) DEFAULT '0' COMMENT '是否是官方用户:0非官方，1官方',
  `fate_num` int(10) DEFAULT '0' COMMENT '获取的命数',
  `used_fate_num` int(10) DEFAULT '0' COMMENT '用掉的命数',
  `medal_num` int(3) DEFAULT '0' COMMENT '奖牌等级',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '状态：0禁用，1启用',
  `ident_code` varchar(10) NOT NULL COMMENT '唯一识别码',
  `parent_ident_code` varchar(10) DEFAULT NULL COMMENT '父级识别码',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `wallet_addr` varchar(255) DEFAULT NULL COMMENT '钱包地址',
  `topic_addr` varchar(150) DEFAULT NULL COMMENT '主题区块链地址',
  `txId` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `elastos_members`
--

LOCK TABLES `elastos_members` WRITE;
/*!40000 ALTER TABLE `elastos_members` DISABLE KEYS */;
INSERT INTO `elastos_members` VALUES (1,'xlt','e10adc3949ba59abbe56e057f20f883e','8618516563559',1527733967,0,0,0,0,0,1,'v1te4d',NULL,1527733967,NULL,NULL,NULL),(2,'周后红','ebc48f94306ce71548f74b6dcff4bab6','8618701835519',1527739317,0,0,0,0,0,1,'ijs6tg',NULL,1527739317,NULL,NULL,NULL),(3,'elastos','e10adc3949ba59abbe56e057f20f883e','8619921411631',1527739368,0,1,0,0,0,1,'y34eb0',NULL,1527739368,NULL,NULL,NULL),(4,'Forrest','d39e1ac5c9a97991eb693fad5ab49a47','8613771862012',1527739569,0,0,0,0,0,1,'v10tgt',NULL,1527739569,NULL,NULL,NULL),(5,'lifayi','ac93fcd6b9e89ea98630cb52b229c26c','8615002168646',1527739741,0,0,0,0,0,1,'n9af0g',NULL,1527739741,NULL,NULL,NULL),(6,'zhiming','e10adc3949ba59abbe56e057f20f883e','8613764022652',1527747534,0,0,0,0,0,1,'wrhzwg',NULL,1527747534,NULL,NULL,NULL),(7,'万里','e10adc3949ba59abbe56e057f20f883e','8615000602731',1527769231,1,0,0,0,0,1,'z3nluf',NULL,1527769231,NULL,NULL,NULL),(8,'zhiming2','e10adc3949ba59abbe56e057f20f883e','',1527747534,6,0,0,0,0,1,'1234',NULL,0,NULL,NULL,NULL);
/*!40000 ALTER TABLE `elastos_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `elastos_node`
--

DROP TABLE IF EXISTS `elastos_node`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `elastos_node` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `node_name` varchar(155) NOT NULL DEFAULT '' COMMENT '节点名称',
  `control_name` varchar(155) NOT NULL DEFAULT '' COMMENT '控制器名',
  `action_name` varchar(155) NOT NULL COMMENT '方法名',
  `is_menu` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否是菜单项 1不是 2是',
  `type_id` int(11) NOT NULL COMMENT '父级节点id',
  `style` varchar(155) DEFAULT '' COMMENT '菜单样式',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `elastos_node`
--

LOCK TABLES `elastos_node` WRITE;
/*!40000 ALTER TABLE `elastos_node` DISABLE KEYS */;
INSERT INTO `elastos_node` VALUES (1,'用户管理','#','#',2,0,'fa fa-users'),(2,'管理员管理','user','index',2,1,''),(3,'添加管理员','user','useradd',1,2,''),(4,'编辑管理员','user','useredit',1,2,''),(5,'删除管理员','user','userdel',1,2,''),(6,'角色管理','role','index',2,1,''),(7,'添加角色','role','roleadd',1,6,''),(8,'编辑角色','role','roleedit',1,6,''),(9,'删除角色','role','roledel',1,6,''),(15,'节点管理','node','index',2,1,''),(16,'添加节点','node','nodeadd',1,15,''),(17,'编辑节点','node','nodeedit',1,15,''),(18,'删除节点','node','nodedel',1,15,''),(19,'文章管理','articles','index',2,0,'fa fa-book'),(20,'文章列表','articles','index',2,19,''),(21,'添加文章','articles','articleadd',1,19,''),(22,'编辑文章','articles','articleedit',1,19,''),(23,'删除文章','articles','articledel',1,19,''),(24,'上传图片','articles','uploadImg',1,19,'');
/*!40000 ALTER TABLE `elastos_node` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `elastos_operator_logs`
--

DROP TABLE IF EXISTS `elastos_operator_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `elastos_operator_logs` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '日志编号',
  `op_id` int(10) DEFAULT NULL COMMENT '操作人ID',
  `op_account` varchar(50) DEFAULT NULL COMMENT '操作员账号',
  `op_name` varchar(50) DEFAULT NULL COMMENT '姓名',
  `op_bn` varchar(50) DEFAULT NULL COMMENT '操作人编号',
  `app` varchar(50) NOT NULL COMMENT '程序目录',
  `ctl` varchar(50) NOT NULL COMMENT '控制器',
  `act` varchar(50) DEFAULT NULL COMMENT '动作',
  `method` enum('post','get') NOT NULL DEFAULT 'post' COMMENT '提交方法',
  `module` varchar(255) NOT NULL COMMENT '日志模块',
  `operate_type` varchar(255) NOT NULL COMMENT '操作类型',
  `param` varchar(255) DEFAULT NULL COMMENT '参数',
  `dateline` int(11) unsigned NOT NULL COMMENT '操作时间',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `elastos_operator_logs`
--

LOCK TABLES `elastos_operator_logs` WRITE;
/*!40000 ALTER TABLE `elastos_operator_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `elastos_operator_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `elastos_role`
--

DROP TABLE IF EXISTS `elastos_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `elastos_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `role_name` varchar(155) NOT NULL COMMENT '角色名称',
  `rule` varchar(255) DEFAULT '' COMMENT '权限节点数据',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `elastos_role`
--

LOCK TABLES `elastos_role` WRITE;
/*!40000 ALTER TABLE `elastos_role` DISABLE KEYS */;
INSERT INTO `elastos_role` VALUES (1,'超级管理员','*'),(2,'系统维护员','1,2,3,4,5,6,7,8,9,10');
/*!40000 ALTER TABLE `elastos_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `elastos_sms_log`
--

DROP TABLE IF EXISTS `elastos_sms_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `elastos_sms_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '日志ID',
  `mobile` varchar(45) NOT NULL DEFAULT '0' COMMENT '手机号',
  `content` int(11) DEFAULT '0' COMMENT '内容',
  `send_time` varchar(100) NOT NULL DEFAULT '' COMMENT '发送时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态：0未发送，1发送成功，2发送失败',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `elastos_sms_log`
--

LOCK TABLES `elastos_sms_log` WRITE;
/*!40000 ALTER TABLE `elastos_sms_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `elastos_sms_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `elastos_topic`
--

DROP TABLE IF EXISTS `elastos_topic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `elastos_topic` (
  `topic_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主题ID',
  `title` varchar(100) DEFAULT '' COMMENT '标题',
  `desc` varchar(200) DEFAULT '' COMMENT '描述',
  `start_time` int(11) NOT NULL DEFAULT '0' COMMENT '开始时间',
  `start_date` int(11) NOT NULL DEFAULT '0' COMMENT '开始日期',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `user_id` int(10) DEFAULT '0' COMMENT '创建人ID',
  `choice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '选择类型：0单选，1多选',
  `is_official` int(1) DEFAULT '0' COMMENT '是否是官方用户:0非官方，1官方',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `total_vote_num` int(10) DEFAULT '0' COMMENT '投票总数',
  `type` int(2) NOT NULL DEFAULT '1' COMMENT '类型：0其他，1世界杯',
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '投票活动状态：0未开始，1待设置答案，2已设置答案，3结束',
  `answer` varchar(100) DEFAULT NULL COMMENT '答案选项',
  `answer_status` int(1) NOT NULL DEFAULT '0' COMMENT '设置答案状态：0未设置，1已设置',
  `is_valid` tinyint(1) NOT NULL DEFAULT '0' COMMENT '有效状态：0无效，1有效',
  `start_gmt_time` int(11) NOT NULL DEFAULT '0' COMMENT '格林威治开始时间（世界时间）',
  PRIMARY KEY (`topic_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `elastos_topic`
--

LOCK TABLES `elastos_topic` WRITE;
/*!40000 ALTER TABLE `elastos_topic` DISABLE KEYS */;
INSERT INTO `elastos_topic` VALUES (2,'测试单选查看是否显示正常','单选',1527744566,1527696000,1527742766,1,0,0,1527742658,0,1,1,NULL,0,1,1527715766),(3,'测试时间显示是否正常','复选',1527744900,1527696000,1527743100,1,1,0,1527742782,1,1,1,NULL,0,1,1527716100),(4,'测试内容较长觉咯莫我们乐扣乐扣么弄弄弄虚退了吧看看极乐净土健健康康弄的极乐净土天天用没法看了生日快乐模具凸透镜土农民','内容较长钢甲卡卡龙都弄考虑兔兔弄的某土龙路信用贷款哭哭啼啼我我弄',1527745200,1527696000,1527743400,1,1,0,1527743069,0,1,1,NULL,0,1,1527716400),(5,'周末high','测试',1530425731,1530374400,1530423931,5,0,0,1527745599,0,1,1,NULL,0,1,1530396931),(6,'测试1','test',1527751800,1527696000,1527750000,6,0,0,1527747668,0,1,1,NULL,0,1,1527723000),(10,'法国vs瑞典','法国vs瑞典',1530432257,1530374400,1530430457,3,0,1,1527752169,2,1,2,'28',1,1,1530403457),(11,'摩洛哥vs伊朗','世界杯',1529064000,1528992000,1529062200,3,0,1,1527752498,3,1,2,'30',1,1,1529035200),(12,'晚饭吃什么','有人不吃猪肉',1527758940,1527696000,1527757140,1,0,0,1527753454,0,1,1,NULL,0,1,1527730140),(13,'俄罗斯vs沙特','世界杯',1528988400,1528905600,1528986600,3,0,1,1527756818,0,1,0,NULL,0,0,1528959600),(14,'俄罗斯vs沙特阿拉伯','世界杯',1528988400,1528905600,1528986600,3,0,1,1527756883,1,1,1,NULL,0,1,1528959600),(15,'埃及vs乌拉圭','世界杯',1529064000,1528992000,1529062200,3,0,1,1527756981,0,1,1,NULL,0,1,1529035200),(16,'葡萄牙vs西班牙','世界杯',1528999200,1528992000,1528997400,3,0,1,1527763651,0,1,0,NULL,0,0,1528970400),(17,'测试看返回','哈哈哈',1530443953,1530374400,1530442153,1,0,0,1527763782,0,1,0,NULL,0,0,1530415153),(18,'推荐','看看',1527765621,1527696000,1527763821,1,0,0,1527763836,0,1,0,NULL,0,0,1527736821),(19,'把的么图片','回来',1530444107,1530374400,1530442307,3,0,1,1527763932,0,1,0,NULL,0,0,1530415307),(20,'葡萄牙vs西班牙','世界杯',1528999200,1528992000,1528997400,3,0,1,1527764255,1,1,1,NULL,0,1,1528970400),(21,'法国vs澳大利亚','世界杯',1529056800,1528992000,1529055000,3,0,1,1527764333,0,1,1,NULL,0,1,1529028000),(22,'阿根廷vs冰岛','世界杯',1529067600,1528992000,1529065800,3,0,1,1527764533,1,1,1,NULL,0,1,1529038800),(23,'感觉','看看',1527770148,1527696000,1527768348,1,0,0,1527768362,0,1,0,NULL,0,0,1527741348);
/*!40000 ALTER TABLE `elastos_topic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `elastos_topic_option`
--

DROP TABLE IF EXISTS `elastos_topic_option`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `elastos_topic_option` (
  `option_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主题选项ID',
  `topic_id` int(11) NOT NULL DEFAULT '0' COMMENT '主题ID',
  `content` varchar(100) DEFAULT '' COMMENT '选项内容',
  `vote_num` int(11) NOT NULL DEFAULT '0' COMMENT '投票次数',
  `is_answer` tinyint(1) NOT NULL DEFAULT '0' COMMENT '答案：0无，1是，2否',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '选项状态：0废弃，1正常',
  `country_id` int(11) DEFAULT '0' COMMENT '国旗ID',
  `txId` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`option_id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `elastos_topic_option`
--

LOCK TABLES `elastos_topic_option` WRITE;
/*!40000 ALTER TABLE `elastos_topic_option` DISABLE KEYS */;
INSERT INTO `elastos_topic_option` VALUES (1,1,'食堂',0,0,1527741507,1527741507,0,0,NULL),(2,1,'外面',0,0,1527741507,1527741507,0,0,NULL),(3,2,'选项1',0,0,1527742658,1527742658,0,0,NULL),(4,2,'选项2',0,0,1527742658,1527742658,0,0,NULL),(5,2,'选项3',0,0,1527742658,1527742658,0,0,NULL),(6,3,'选项1',1,0,1527742782,1527753780,0,0,NULL),(7,3,'选项2',1,0,1527742782,1527753780,0,0,NULL),(8,3,'选项3',0,0,1527742782,1527742782,0,0,NULL),(9,3,'选项4',0,0,1527742782,1527742782,0,0,NULL),(10,4,'选项1856658855啊据统计弄的东西额截图看看里面我等嗯我亏路路通美女图是弄弄拉出来旅途空拉拉扯扯不听我的啊鸡兔同笼动物我饿了吗魔域同学哦今天太累了农用把的么图片阿里通浓郁说白了与',0,0,1527743069,1527743069,0,0,NULL),(11,4,'选项2总局偷摸摸动植物喇叭裤通用嗯就是力量基本农作物下雨天了吧天冷肯用也许是吧了啊具体时间空附图家里下雨吐了阿龙英语听力默默楼回去屋里国庆节选',0,0,1527743069,1527743069,0,0,NULL),(12,4,'选项3',0,0,1527743069,1527743069,0,0,NULL),(13,4,'选项4',0,0,1527743069,1527743069,0,0,NULL),(14,5,'在家看电视',0,0,1527745599,1527745599,0,0,NULL),(15,5,'在家睡觉',0,0,1527745599,1527745599,0,0,NULL),(16,5,'在家打游戏',0,0,1527745599,1527745599,0,0,NULL),(17,6,'a胜',0,0,1527747668,1527747668,0,0,NULL),(18,6,'b胜',0,0,1527747668,1527747668,0,0,NULL),(27,10,'France',2,2,1527752169,1527756258,0,8,NULL),(28,10,'Sweden',0,1,1527752169,1527753207,0,20,NULL),(29,11,'Morocco',2,2,1527752498,1527756223,0,29,NULL),(30,11,'Iran',1,1,1527752498,1527753063,0,24,NULL),(31,11,'TIE',0,2,1527752498,1527753063,0,0,NULL),(32,12,'食堂',0,0,1527753454,1527753454,0,0,NULL),(33,12,'餐厅',0,0,1527753454,1527753454,0,0,NULL),(34,12,'外面吃',0,0,1527753454,1527753454,0,0,NULL),(35,13,'俄罗斯',0,0,1527756818,1527756818,0,1,NULL),(36,13,'沙特阿拉伯',0,0,1527756818,1527756818,0,32,NULL),(37,13,'平局',0,0,1527756818,1527756818,0,0,NULL),(38,14,'俄罗斯',1,0,1527756883,1527762741,0,1,NULL),(39,14,'沙特阿拉伯',0,0,1527756883,1527756883,0,32,NULL),(40,14,'平局',0,0,1527756883,1527756883,0,0,NULL),(41,15,'埃及',0,0,1527756981,1527756981,0,22,NULL),(42,15,'乌拉圭',0,0,1527756981,1527756981,0,15,NULL),(43,15,'平局',0,0,1527756981,1527756981,0,0,NULL),(44,16,'葡萄牙',0,0,1527763651,1527763651,0,4,NULL),(45,16,'西班牙',0,0,1527763651,1527763651,0,9,NULL),(46,16,'平局',0,0,1527763651,1527763651,0,0,NULL),(47,17,'选项1',0,0,1527763782,1527763782,0,0,NULL),(48,17,'选项2',0,0,1527763782,1527763782,0,0,NULL),(49,17,'选项3',0,0,1527763782,1527763782,0,0,NULL),(50,18,'1',0,0,1527763836,1527763836,0,0,NULL),(51,18,'2',0,0,1527763836,1527763836,0,0,NULL),(52,19,'1',0,0,1527763932,1527763932,0,0,NULL),(53,19,'2',0,0,1527763932,1527763932,0,0,NULL),(54,20,'西班牙',0,0,1527764255,1527764255,0,9,NULL),(55,20,'葡萄牙',0,0,1527764255,1527764255,0,4,NULL),(56,20,'平局',1,0,1527764255,1527766908,0,0,NULL),(57,21,'法国',0,0,1527764333,1527764333,0,8,NULL),(58,21,'澳大利亚',0,0,1527764333,1527764333,0,27,NULL),(59,21,'平局',0,0,1527764333,1527764333,0,0,NULL),(60,22,'阿根廷',0,0,1527764533,1527764533,0,5,NULL),(61,22,'冰岛',1,0,1527764533,1527766843,0,18,NULL),(62,22,'平局',0,0,1527764533,1527764533,0,0,NULL),(63,23,'就',0,0,1527768362,1527768362,0,0,NULL),(64,23,'看看',0,0,1527768362,1527768362,0,0,NULL);
/*!40000 ALTER TABLE `elastos_topic_option` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `elastos_user`
--

DROP TABLE IF EXISTS `elastos_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `elastos_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '密码',
  `login_times` int(11) NOT NULL DEFAULT '0' COMMENT '登陆次数',
  `last_login_ip` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '最后登录IP',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `real_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '真实姓名',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `role_id` int(11) NOT NULL DEFAULT '1' COMMENT '用户角色id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `elastos_user`
--

LOCK TABLES `elastos_user` WRITE;
/*!40000 ALTER TABLE `elastos_user` DISABLE KEYS */;
INSERT INTO `elastos_user` VALUES (1,'admin','21232f297a57a5a743894a0e4a801fc3',41,'127.0.0.1',1505559479,'admin',1,1);
/*!40000 ALTER TABLE `elastos_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `elastos_user_wins`
--

DROP TABLE IF EXISTS `elastos_user_wins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `elastos_user_wins` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `user_id` int(10) NOT NULL COMMENT '用户id',
  `wins` varchar(255) NOT NULL COMMENT '连赢的局数，以‘，’做字符串拼接',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `elastos_user_wins`
--

LOCK TABLES `elastos_user_wins` WRITE;
/*!40000 ALTER TABLE `elastos_user_wins` DISABLE KEYS */;
/*!40000 ALTER TABLE `elastos_user_wins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `elastos_vote`
--

DROP TABLE IF EXISTS `elastos_vote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `elastos_vote` (
  `vote_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '投票ID',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `topic_id` int(11) NOT NULL DEFAULT '0' COMMENT '主题ID',
  `option_id` int(11) NOT NULL DEFAULT '0' COMMENT '选项ID',
  `vote_time` int(11) NOT NULL DEFAULT '0' COMMENT '答案：0无，1是，2否',
  `txId` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`vote_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `elastos_vote`
--

LOCK TABLES `elastos_vote` WRITE;
/*!40000 ALTER TABLE `elastos_vote` DISABLE KEYS */;
INSERT INTO `elastos_vote` VALUES (1,1,9,25,1527752070,NULL),(2,1,11,30,1527752963,NULL),(3,1,10,27,1527753133,NULL),(4,3,3,6,1527753780,NULL),(5,3,3,7,1527753780,NULL),(6,6,11,29,1527756163,NULL),(7,6,11,29,1527756223,NULL),(8,6,10,27,1527756258,NULL),(9,6,14,38,1527762741,NULL),(10,1,22,61,1527766843,NULL),(11,1,20,56,1527766908,NULL);
/*!40000 ALTER TABLE `elastos_vote` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` varchar(100) DEFAULT '' COMMENT '用户名',
  `password` varchar(100) DEFAULT '' COMMENT '密码',
  `mobile` varchar(45) DEFAULT '' COMMENT '手机号',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `referee` int(10) DEFAULT '0',
  `is_official` int(1) DEFAULT '0' COMMENT '是否是官方用户:0非官方，1官方',
  `fate_num` int(10) DEFAULT '0' COMMENT '获取的命数',
  `used_fate_num` int(10) DEFAULT '0' COMMENT '用掉的命数',
  `medal_num` int(3) DEFAULT '0' COMMENT '奖牌等级',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '状态：0禁用，1启用',
  `ident_code` varchar(10) NOT NULL COMMENT '唯一识别码',
  `parent_ident_code` varchar(10) DEFAULT NULL COMMENT '父级识别码',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `wallet_addr` varchar(255) DEFAULT NULL COMMENT '钱包地址',
  `topic_addr` varchar(150) DEFAULT NULL COMMENT '主题区块链地址',
  `txId` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `node`
--

DROP TABLE IF EXISTS `node`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `node` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `node_name` varchar(155) NOT NULL DEFAULT '' COMMENT '节点名称',
  `control_name` varchar(155) NOT NULL DEFAULT '' COMMENT '控制器名',
  `action_name` varchar(155) NOT NULL COMMENT '方法名',
  `is_menu` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否是菜单项 1不是 2是',
  `type_id` int(11) NOT NULL COMMENT '父级节点id',
  `style` varchar(155) DEFAULT '' COMMENT '菜单样式',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `node`
--

LOCK TABLES `node` WRITE;
/*!40000 ALTER TABLE `node` DISABLE KEYS */;
INSERT INTO `node` VALUES (1,'用户管理','#','#',2,0,'fa fa-users'),(2,'管理员管理','user','index',2,1,''),(3,'添加管理员','user','useradd',1,2,''),(4,'编辑管理员','user','useredit',1,2,''),(5,'删除管理员','user','userdel',1,2,''),(6,'角色管理','role','index',2,1,''),(7,'添加角色','role','roleadd',1,6,''),(8,'编辑角色','role','roleedit',1,6,''),(9,'删除角色','role','roledel',1,6,''),(15,'节点管理','node','index',2,1,''),(16,'添加节点','node','nodeadd',1,15,''),(17,'编辑节点','node','nodeedit',1,15,''),(18,'删除节点','node','nodedel',1,15,''),(19,'文章管理','articles','index',2,0,'fa fa-book'),(20,'文章列表','articles','index',2,19,''),(21,'添加文章','articles','articleadd',1,19,''),(22,'编辑文章','articles','articleedit',1,19,''),(23,'删除文章','articles','articledel',1,19,''),(24,'上传图片','articles','uploadImg',1,19,'');
/*!40000 ALTER TABLE `node` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `operator_logs`
--

DROP TABLE IF EXISTS `operator_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `operator_logs` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '日志编号',
  `op_id` int(10) DEFAULT NULL COMMENT '操作人ID',
  `op_account` varchar(50) DEFAULT NULL COMMENT '操作员账号',
  `op_name` varchar(50) DEFAULT NULL COMMENT '姓名',
  `op_bn` varchar(50) DEFAULT NULL COMMENT '操作人编号',
  `app` varchar(50) NOT NULL COMMENT '程序目录',
  `ctl` varchar(50) NOT NULL COMMENT '控制器',
  `act` varchar(50) DEFAULT NULL COMMENT '动作',
  `method` enum('post','get') NOT NULL DEFAULT 'post' COMMENT '提交方法',
  `module` varchar(255) NOT NULL COMMENT '日志模块',
  `operate_type` varchar(255) NOT NULL COMMENT '操作类型',
  `param` varchar(255) DEFAULT NULL COMMENT '参数',
  `dateline` int(11) unsigned NOT NULL COMMENT '操作时间',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `operator_logs`
--

LOCK TABLES `operator_logs` WRITE;
/*!40000 ALTER TABLE `operator_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `operator_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `role_name` varchar(155) NOT NULL COMMENT '角色名称',
  `rule` varchar(255) DEFAULT '' COMMENT '权限节点数据',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'超级管理员','*'),(2,'系统维护员','1,2,3,4,5,6,7,8,9,10');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sms_log`
--

DROP TABLE IF EXISTS `sms_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sms_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '日志ID',
  `mobile` varchar(45) NOT NULL DEFAULT '0' COMMENT '手机号',
  `content` int(11) DEFAULT '0' COMMENT '内容',
  `send_time` varchar(100) NOT NULL DEFAULT '' COMMENT '发送时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态：0未发送，1发送成功，2发送失败',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms_log`
--

LOCK TABLES `sms_log` WRITE;
/*!40000 ALTER TABLE `sms_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `sms_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `topic`
--

DROP TABLE IF EXISTS `topic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `topic` (
  `topic_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主题ID',
  `title` varchar(100) DEFAULT '' COMMENT '标题',
  `desc` varchar(200) DEFAULT '' COMMENT '描述',
  `start_time` int(11) NOT NULL DEFAULT '0' COMMENT '开始时间',
  `start_date` int(11) NOT NULL DEFAULT '0' COMMENT '开始日期',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `user_id` int(10) DEFAULT '0' COMMENT '创建人ID',
  `choice` tinyint(1) NOT NULL DEFAULT '0' COMMENT '选择类型：0单选，1多选',
  `is_official` int(1) DEFAULT '0' COMMENT '是否是官方用户:0非官方，1官方',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `total_vote_num` int(10) DEFAULT '0' COMMENT '投票总数',
  `type` int(2) NOT NULL DEFAULT '1' COMMENT '类型：0其他，1世界杯',
  `status` int(2) NOT NULL DEFAULT '0' COMMENT '投票活动状态：0未开始，1待设置答案，2已设置答案，3结束',
  `answer` varchar(100) DEFAULT NULL COMMENT '答案选项',
  `answer_status` int(1) NOT NULL DEFAULT '0' COMMENT '设置答案状态：0未设置，1已设置',
  `is_valid` tinyint(1) NOT NULL DEFAULT '0' COMMENT '有效状态：0无效，1有效',
  `start_gmt_time` int(11) NOT NULL DEFAULT '0' COMMENT '格林威治开始时间（世界时间）',
  PRIMARY KEY (`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topic`
--

LOCK TABLES `topic` WRITE;
/*!40000 ALTER TABLE `topic` DISABLE KEYS */;
/*!40000 ALTER TABLE `topic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `topic_option`
--

DROP TABLE IF EXISTS `topic_option`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `topic_option` (
  `option_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主题选项ID',
  `topic_id` int(11) NOT NULL DEFAULT '0' COMMENT '主题ID',
  `content` varchar(100) DEFAULT '' COMMENT '选项内容',
  `vote_num` int(11) NOT NULL DEFAULT '0' COMMENT '投票次数',
  `is_answer` tinyint(1) NOT NULL DEFAULT '0' COMMENT '答案：0无，1是，2否',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '选项状态：0废弃，1正常',
  `country_id` int(11) DEFAULT '0' COMMENT '国旗ID',
  `txId` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topic_option`
--

LOCK TABLES `topic_option` WRITE;
/*!40000 ALTER TABLE `topic_option` DISABLE KEYS */;
/*!40000 ALTER TABLE `topic_option` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '密码',
  `login_times` int(11) NOT NULL DEFAULT '0' COMMENT '登陆次数',
  `last_login_ip` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '最后登录IP',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `real_name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' COMMENT '真实姓名',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `role_id` int(11) NOT NULL DEFAULT '1' COMMENT '用户角色id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','21232f297a57a5a743894a0e4a801fc3',41,'127.0.0.1',1505559479,'admin',1,1);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vote`
--

DROP TABLE IF EXISTS `vote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vote` (
  `vote_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '投票ID',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `topic_id` int(11) NOT NULL DEFAULT '0' COMMENT '主题ID',
  `option_id` int(11) NOT NULL DEFAULT '0' COMMENT '选项ID',
  `vote_time` int(11) NOT NULL DEFAULT '0' COMMENT '答案：0无，1是，2否',
  `txId` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`vote_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vote`
--

LOCK TABLES `vote` WRITE;
/*!40000 ALTER TABLE `vote` DISABLE KEYS */;
/*!40000 ALTER TABLE `vote` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-06-01  3:21:31
