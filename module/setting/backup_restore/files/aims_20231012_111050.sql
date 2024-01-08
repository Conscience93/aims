-- MariaDB dump 10.19  Distrib 10.4.27-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: aims
-- ------------------------------------------------------
-- Server version	10.4.27-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `aims_asset`
--

DROP TABLE IF EXISTS `aims_asset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_asset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_tag` varchar(255) NOT NULL,
  `nfc_code` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'ACTIVE',
  `date_created` varchar(255) DEFAULT NULL,
  `date_purchase` varchar(255) DEFAULT NULL,
  `value` varchar(255) NOT NULL,
  `price` varchar(10) DEFAULT '',
  `supplier` varchar(255) DEFAULT '',
  `branch` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT '',
  `department` varchar(255) DEFAULT '',
  `date_transfer` varchar(255) NOT NULL,
  `transfer_branch` varchar(255) NOT NULL,
  `transfer_department` varchar(255) NOT NULL,
  `transfer_location` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `particular` varchar(255) DEFAULT '',
  `document` varchar(255) DEFAULT '',
  `picture` varchar(255) DEFAULT '',
  `invoice` varchar(255) DEFAULT NULL,
  `start_warranty` varchar(255) DEFAULT NULL,
  `end_warranty` varchar(255) DEFAULT NULL,
  `warranty` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_asset`
--

LOCK TABLES `aims_asset` WRITE;
/*!40000 ALTER TABLE `aims_asset` DISABLE KEYS */;
INSERT INTO `aims_asset` VALUES (41,'ATA00003',NULL,'asset','table','ACTIVE',NULL,'','','110','','','','','','','','','','','','','','',NULL,NULL,'');
/*!40000 ALTER TABLE `aims_asset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_asset_category_run_no`
--

DROP TABLE IF EXISTS `aims_asset_category_run_no`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_asset_category_run_no` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) DEFAULT '',
  `display_name` varchar(255) DEFAULT NULL,
  `prefix` varchar(255) DEFAULT NULL,
  `next_no` int(11) DEFAULT NULL,
  `digit_no` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `prefix` (`prefix`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_asset_category_run_no`
--

LOCK TABLES `aims_asset_category_run_no` WRITE;
/*!40000 ALTER TABLE `aims_asset_category_run_no` DISABLE KEYS */;
INSERT INTO `aims_asset_category_run_no` VALUES (1,'table','Table','ATA',4,6),(2,'chair','Chair','ACH',1,6),(3,'stationary','Stationary','AST',1,6),(4,'board','Board','ABD',1,6),(5,'book','Book','ABK',1,6),(6,'device','Device','ADV',1,6),(7,'drawer','Drawer','ADW',1,6),(8,'others','Others','AOT',1,6);
/*!40000 ALTER TABLE `aims_asset_category_run_no` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_billing_adjustment`
--

DROP TABLE IF EXISTS `aims_billing_adjustment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_billing_adjustment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` varchar(255) NOT NULL,
  `adjustment_id` varchar(255) NOT NULL,
  `adjustment_date` date NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `adjustment_type` varchar(255) NOT NULL,
  `adjustment_reason` varchar(255) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `total_tax` double(10,2) NOT NULL,
  `total_amount_with_tax` double(10,2) NOT NULL,
  `total_amount_round` double(10,2) NOT NULL,
  `rounding_change` double(10,2) NOT NULL,
  `posting_status` varchar(255) NOT NULL DEFAULT 'UNPOSTED',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_billing_adjustment`
--

LOCK TABLES `aims_billing_adjustment` WRITE;
/*!40000 ALTER TABLE `aims_billing_adjustment` DISABLE KEYS */;
/*!40000 ALTER TABLE `aims_billing_adjustment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_billing_card_type`
--

DROP TABLE IF EXISTS `aims_billing_card_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_billing_card_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `card_type` varchar(20) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_billing_card_type`
--

LOCK TABLES `aims_billing_card_type` WRITE;
/*!40000 ALTER TABLE `aims_billing_card_type` DISABLE KEYS */;
INSERT INTO `aims_billing_card_type` VALUES (1,'Credit card'),(2,'Debit card'),(3,'ATM card'),(4,'UOB-Credit Card');
/*!40000 ALTER TABLE `aims_billing_card_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_billing_ewallet`
--

DROP TABLE IF EXISTS `aims_billing_ewallet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_billing_ewallet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ewallet_name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_billing_ewallet`
--

LOCK TABLES `aims_billing_ewallet` WRITE;
/*!40000 ALTER TABLE `aims_billing_ewallet` DISABLE KEYS */;
INSERT INTO `aims_billing_ewallet` VALUES (1,'Sarawak pay'),(2,'Touch n go'),(3,'Boost'),(4,'Grab pay'),(5,'Shopee pay');
/*!40000 ALTER TABLE `aims_billing_ewallet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_billing_invoice`
--

DROP TABLE IF EXISTS `aims_billing_invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_billing_invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` varchar(255) NOT NULL,
  `invoice_date` date NOT NULL,
  `invoice_date_due` date NOT NULL,
  `invoice_amount` double(10,2) NOT NULL,
  `invoice_amount_with_tax` double(10,2) NOT NULL,
  `invoice_amount_with_tax_rounding` double(10,2) NOT NULL,
  `rounding_change` double(10,2) NOT NULL,
  `total_tax` double(10,2) NOT NULL,
  `discount` double(10,2) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) NOT NULL DEFAULT 'UNPAID',
  `receipt_id` varchar(255) DEFAULT NULL,
  `posting_status` varchar(20) DEFAULT 'UNPOSTED' COMMENT 'UNPOSTED/POSTED',
  `display_status` varchar(20) NOT NULL DEFAULT 'SHOW' COMMENT 'SHOW/DELETED',
  `overdue` double(10,2) NOT NULL DEFAULT 0.00,
  `is_invoice_sent` tinyint(1) NOT NULL DEFAULT 0,
  `remark` varchar(255) DEFAULT NULL,
  `is_recurring` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `invoice_no` (`invoice_id`) USING BTREE,
  KEY `member_no` (`user`) USING BTREE,
  KEY `receipt_no` (`receipt_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2347 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_billing_invoice`
--

LOCK TABLES `aims_billing_invoice` WRITE;
/*!40000 ALTER TABLE `aims_billing_invoice` DISABLE KEYS */;
INSERT INTO `aims_billing_invoice` VALUES (1,'1','2023-09-05','2023-11-29',100.00,100.00,100.00,0.00,0.00,0.00,1,'kik1','UNPAID','1','UNPOSTED','SHOW',0.00,0,'good good',0);
/*!40000 ALTER TABLE `aims_billing_invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_billing_item`
--

DROP TABLE IF EXISTS `aims_billing_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_billing_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_code` varchar(20) NOT NULL,
  `item_description` varchar(255) NOT NULL,
  `item_uom` varchar(20) NOT NULL DEFAULT 'Pax',
  `item_price` decimal(10,2) NOT NULL,
  `tax_id` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `item_code` (`item_code`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_billing_item`
--

LOCK TABLES `aims_billing_item` WRITE;
/*!40000 ALTER TABLE `aims_billing_item` DISABLE KEYS */;
INSERT INTO `aims_billing_item` VALUES (1,'ITEM01','AL RAJHI - NB CLUBHOUSE','Pax',11.00,1),(2,'ITEM02','OTHER DEBTORS','Pax',50.00,2),(3,'ITEM03','OTHER INCOME','Pax',30.00,2),(4,'ITEM04','PETTY CASH - CLUBHOUSE','Pax',10.00,1),(5,'ITEM05','TURNOVER - FOOD','Pax',600.00,1),(6,'ITEM06','COST OF SALES - CLUB FOOD','Pax',10.00,1),(7,'ITEM07','TURNOVER - BEVERAGES','Pax',8.00,1),(8,'ITEM08','COST OF SALES - CLUB BEVERAGES','Pax',10.00,1),(9,'ITEM09','TURNOVER - BEVERAGES - LIQUOR','Pax',10.00,1),(10,'ITEM10','COST OF SALES - CLUB BEVERAGES - LIQUOR','Pax',10.00,1),(11,'ITEM11','TURNOVER - CORKAGE CHARGES','Pax',50.00,1),(12,'ITEM12','TURNOVER - CLUB MEMBERSHIP SUBSCRIPTION (MEMBER)','Pax',110.00,1),(13,'ITEM13','TURNOVER - CLUB JOINING FEE ','Pax',2500.00,1),(14,'ITEM14','TURNOVER - GUEST ENTRANCE FEE (WEEKDAY)','Pax',10.00,1),(15,'ITEM15','TURNOVER - FACILITY BOOKING FEE - BADMINTON COURT','Pax',10.00,1),(16,'ITEM16','TURNOVER - FACILITY BOOKING FEE - MULTI-PURPOSE COURT','Pax',10.00,1),(17,'ITEM17','TURNOVER - COACHING & LESSON FEE - BADMINTON (4 LESSONS)','Pax',110.00,1),(18,'ITEM18','TURNOVER - COACHING & LESSON FEE - BASKETBALL (4 LESSONS)','Pax',110.00,1),(19,'ITEM19','TURNOVER - COACHING & LESSON FEE - FITNESS (5 LESSONS)','Pax',600.00,1),(20,'ITEM20','TURNOVER - COACHING & LESSON FEE - NETBALL (4 LESSONS)','Pax',110.00,1),(21,'ITEM21','TURNOVER - COACHING & LESSON FEE - SWIMMING (4 LESSONS)','Pax',110.00,1),(22,'ITEM22','TURNOVER - GYM SUBSCRIPTION FEE','Pax',20.00,1),(23,'ITEM23','SALES SERVICE TAX','Pax',10.00,1),(24,'ITEM24','TRADE DEBTORS - CLUB MEMBERS','Pax',10.00,1),(25,'ITEM25','TURNOVER - CLUB MEMBERSHIP SUBSCRIPTION (SPOUSE)','Pax',20.00,1),(26,'ITEM26','TURNOVER - CLUB MEMBERSHIP SUBSCRIPTION (CHILDREN,7-20 YO)','Pax',20.00,1),(27,'ITEM27','DEPOSIT','Pax',200.00,1),(28,'ITEM28','TURNOVER - FACILITY BOOKING FEE - BASKETBALL COURT','Pax',50.00,1),(29,'ITEM29','TURNOVER - CLUB JOINING FEE --- CORPORATE STAFF (LHS/NB PROPERTY OWNER/TENANT)','Pax',1800.00,1),(30,'ITEM30','TURNOVER - CLUB JOINING FEE --- INVITEE/OTHER IB PROPERTY OWNER/TENANT','Pax',2500.00,1),(31,'ITEM31','TURNOVER - CLUB MEMBERSHIP SUBSCRIPTION (MEMBER) --- 1 YEAR','Pax',1320.00,1),(32,'ITEM32','TURNOVER - GYM SUBSCRIPTION FEE (1 YEAR)','Pax',240.00,1),(33,'ITEM33','TURNOVER - CLUB MEMBERSHIP SUBSCRIPTION (SPOUSE) --- 1 YEAR','Pax',240.00,1),(34,'ITEM34','TURNOVER - CLUB MEMBERSHIP SUBSCRIPTION (CHILDREN,7-20 YO) --- 1 YEAR','Pax',240.00,1),(35,'ITEM35','TURNOVER - GUEST ENTRANCE FEE (WEEKEND, PUBLIC HOLIDAY)','Pax',15.00,1),(36,'ITEM36','TURNOVER - FOOD (BUFFET)','Pax',60.00,1),(37,'ITEM37','TURNOVER - CIGARETTE','Pax',8.00,1),(38,'ITEM38','TURNOVER - OTHERS','Pax',10.00,1),(39,'ITEM39','TURNOVER - PENALTY OF DAMAGING DART','Pax',5.00,1),(40,'ITEM40','TURNOVER - PARKING FEE','Pax',4.00,1),(41,'ITEM41','TURNOVER - CLUB JOINING FEE (ALYVIA/CRESTWOOD)','Pax',1800.00,1),(42,'ITEM42','TURNOVER - COACHING & LESSON FEE - FITNESS (10 LESSONS)','Pax',1100.00,1),(43,'ITEM43','TURNOVER - PRIVATE COACHING & LESSON FEE - SWIMMING (4 LESSONS)','Pax',320.00,1),(44,'ITEM44','TURNOVER - CLUB MEMBERSHIP SUBSCRIPTION (MEMBER) --- 5 YEARS','Pax',6600.00,1),(45,'ITEM45','TURNOVER - CLUB MEMBERSHIP SUBSCRIPTION (MEMBER) ---  ADVANCE','Pax',110.00,1),(46,'ITEM46','TURNOVER - CLUB MEMBERSHIP SUBSCRIPTION (SPOUSE) --- ADVANCE','Pax',20.00,1),(47,'ITEM47','TURNOVER - CLUB MEMBERSHIP SUBSCRIPTION (CHILDREN,7-20 YO) --- ADVANCE','Pax',20.00,1),(48,'ITEM48','TURNOVER - GYM SUBSCRIPTION FEE (ADVANCE)','Pax',20.00,1);
/*!40000 ALTER TABLE `aims_billing_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_billing_payment`
--

DROP TABLE IF EXISTS `aims_billing_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_billing_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `receipt_id` varchar(20) NOT NULL,
  `payment_date` datetime NOT NULL,
  `user` varchar(255) DEFAULT NULL,
  `invoice_id` varchar(20) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method_id` int(11) NOT NULL,
  `card_type_id` int(11) DEFAULT NULL,
  `ewallet_type_id` int(11) DEFAULT NULL,
  `remark` varchar(255) DEFAULT '',
  `total_amount_round` double(10,2) DEFAULT NULL,
  `rounding_change` double(10,2) DEFAULT NULL,
  `payment_received` decimal(10,2) DEFAULT NULL,
  `cash_change` decimal(10,2) DEFAULT NULL,
  `display_status` varchar(20) NOT NULL DEFAULT 'SHOW' COMMENT 'SHOW/DELETED',
  `posting_status` varchar(20) NOT NULL DEFAULT 'UNPOSTED' COMMENT 'UNPOSTED/POSTED',
  `actual_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `receipt_no` (`receipt_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2170 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_billing_payment`
--

LOCK TABLES `aims_billing_payment` WRITE;
/*!40000 ALTER TABLE `aims_billing_payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `aims_billing_payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_billing_payment_method`
--

DROP TABLE IF EXISTS `aims_billing_payment_method`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_billing_payment_method` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_method` varchar(20) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_billing_payment_method`
--

LOCK TABLES `aims_billing_payment_method` WRITE;
/*!40000 ALTER TABLE `aims_billing_payment_method` DISABLE KEYS */;
INSERT INTO `aims_billing_payment_method` VALUES (1,'cash'),(2,'card'),(3,'e-wallet'),(4,'bank transfer'),(5,'cheque'),(6,'IPAY-CC'),(7,'IPAY-ECOMMERCE'),(8,'IPAY-FPX'),(9,'UOB-Credit Card');
/*!40000 ALTER TABLE `aims_billing_payment_method` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_billing_receipt`
--

DROP TABLE IF EXISTS `aims_billing_receipt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_billing_receipt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `receipt_no` varchar(20) NOT NULL,
  `payment_date` datetime NOT NULL,
  `user` varchar(255) DEFAULT NULL,
  `invoice_no` varchar(20) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method_id` int(11) NOT NULL,
  `card_type_id` int(11) DEFAULT NULL,
  `ewallet_type_id` int(11) DEFAULT NULL,
  `remark` varchar(255) DEFAULT '',
  `total_amount_round` double(10,2) DEFAULT NULL,
  `rounding_change` double(10,2) DEFAULT NULL,
  `payment_received` decimal(10,2) DEFAULT NULL,
  `cash_change` decimal(10,2) DEFAULT NULL,
  `display_status` varchar(20) NOT NULL DEFAULT 'SHOW' COMMENT 'SHOW/DELETED',
  `posting_status` varchar(20) NOT NULL DEFAULT 'UNPOSTED' COMMENT 'UNPOSTED/POSTED',
  `actual_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `receipt_no` (`receipt_no`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2170 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_billing_receipt`
--

LOCK TABLES `aims_billing_receipt` WRITE;
/*!40000 ALTER TABLE `aims_billing_receipt` DISABLE KEYS */;
/*!40000 ALTER TABLE `aims_billing_receipt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_billing_reminder_item`
--

DROP TABLE IF EXISTS `aims_billing_reminder_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_billing_reminder_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item` varchar(255) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `units` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_billing_reminder_item`
--

LOCK TABLES `aims_billing_reminder_item` WRITE;
/*!40000 ALTER TABLE `aims_billing_reminder_item` DISABLE KEYS */;
INSERT INTO `aims_billing_reminder_item` VALUES (1,'Payment Term',7,'days');
/*!40000 ALTER TABLE `aims_billing_reminder_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_billing_tax`
--

DROP TABLE IF EXISTS `aims_billing_tax`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_billing_tax` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_code` varchar(255) NOT NULL,
  `tax_description` varchar(255) NOT NULL,
  `tax_percentage` double(10,2) NOT NULL,
  `tax_status` varchar(20) NOT NULL DEFAULT 'ACTIVE',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_billing_tax`
--

LOCK TABLES `aims_billing_tax` WRITE;
/*!40000 ALTER TABLE `aims_billing_tax` DISABLE KEYS */;
INSERT INTO `aims_billing_tax` VALUES (1,'NO TAX','NO TAX',0.00,'ACTIVE'),(2,'SST','SERVICE TAX 6%',6.00,'ACTIVE');
/*!40000 ALTER TABLE `aims_billing_tax` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_company`
--

DROP TABLE IF EXISTS `aims_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_company`
--

LOCK TABLES `aims_company` WRITE;
/*!40000 ALTER TABLE `aims_company` DISABLE KEYS */;
INSERT INTO `aims_company` VALUES (1,'Softworld','test@gmail.com','123','123','test','include/upload/logo/neko.png');
/*!40000 ALTER TABLE `aims_company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_computer`
--

DROP TABLE IF EXISTS `aims_computer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_computer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_tag` varchar(255) NOT NULL,
  `nfc_code` varchar(255) DEFAULT '',
  `status` varchar(255) NOT NULL DEFAULT 'ACTIVE',
  `name` varchar(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `value` varchar(255) NOT NULL,
  `date_purchase` varchar(255) NOT NULL,
  `date_created` varchar(255) NOT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `supplier` varchar(255) DEFAULT '',
  `computer_brand` varchar(255) DEFAULT NULL,
  `phone_brand` varchar(255) DEFAULT NULL,
  `ram` varchar(255) DEFAULT NULL,
  `hard_drive` varchar(255) DEFAULT NULL,
  `processor` varchar(255) DEFAULT NULL,
  `graphic_card` varchar(255) DEFAULT NULL,
  `casing` varchar(255) DEFAULT NULL,
  `psu` varchar(255) DEFAULT NULL,
  `motherboard` varchar(255) DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `mac_address` varchar(255) DEFAULT NULL,
  `vpn_address` varchar(255) DEFAULT NULL,
  `port` varchar(255) DEFAULT NULL,
  `start_warranty` varchar(255) DEFAULT NULL,
  `end_warranty` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `invoice` varchar(255) DEFAULT NULL,
  `document` varchar(255) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `warranty` varchar(255) DEFAULT NULL,
  `date_transfer` varchar(255) NOT NULL,
  `transfer_branch` varchar(255) NOT NULL,
  `transfer_department` varchar(255) NOT NULL,
  `transfer_location` varchar(255) NOT NULL,
  `software` varchar(255) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=165 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_computer`
--

LOCK TABLES `aims_computer` WRITE;
/*!40000 ALTER TABLE `aims_computer` DISABLE KEYS */;
INSERT INTO `aims_computer` VALUES (156,'CSV00001','','ACTIVE','TEST','server','','','','111','','2023-10-10','','TEST','','','','',NULL,'','','','','',NULL,NULL,NULL,NULL,'','','','','','','','','','','',''),(158,'CCP00006','','ACTIVE','computer','computer','','','','15','','2023-10-11','','TEST','','Lenovo','','TEST',NULL,'TEST','TEST','TEST','TEST','TEST',NULL,NULL,NULL,NULL,'','','','','','','','','','','',''),(164,'CSP00003','','ACTIVE','TEST COMPUTER','smartphone','','','','','','','','','','','','',NULL,'','','','','',NULL,NULL,NULL,NULL,'','','','','','','','','','','','');
/*!40000 ALTER TABLE `aims_computer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_computer_category_run_no`
--

DROP TABLE IF EXISTS `aims_computer_category_run_no`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_computer_category_run_no` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) DEFAULT '',
  `display_name` varchar(255) DEFAULT NULL,
  `prefix` varchar(255) DEFAULT NULL,
  `next_no` int(11) DEFAULT NULL,
  `digit_no` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_computer_category_run_no`
--

LOCK TABLES `aims_computer_category_run_no` WRITE;
/*!40000 ALTER TABLE `aims_computer_category_run_no` DISABLE KEYS */;
INSERT INTO `aims_computer_category_run_no` VALUES (1,'computer','Computer','CCP',9,6),(2,'server','Server','CSV',2,6),(3,'smartphone','Smartphone','CSP',4,6),(4,'tablet','Tablet','CTB',1,6),(5,'laptop','Laptop','CLT',2,6),(6,'others','Others','COT',1,6);
/*!40000 ALTER TABLE `aims_computer_category_run_no` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_computer_hard_drive`
--

DROP TABLE IF EXISTS `aims_computer_hard_drive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_computer_hard_drive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_tag` varchar(255) NOT NULL,
  `hard_disk_name` varchar(255) NOT NULL,
  `hard_drive` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `storage` varchar(255) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `end_warranty_disk` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_computer_hard_drive`
--

LOCK TABLES `aims_computer_hard_drive` WRITE;
/*!40000 ALTER TABLE `aims_computer_hard_drive` DISABLE KEYS */;
INSERT INTO `aims_computer_hard_drive` VALUES (32,'CSV00001','TEST','SSD','TEST','TEST','TEST','2023-10-09'),(34,'CCP00006','TEST','SSD','TEST','TEST','TEST','2023-10-11'),(40,'CSP00003','','SSD','','','','2023-10-11');
/*!40000 ALTER TABLE `aims_computer_hard_drive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_computer_network`
--

DROP TABLE IF EXISTS `aims_computer_network`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_computer_network` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_tag` varchar(255) DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `mac_address` varchar(255) DEFAULT NULL,
  `port` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_computer_network`
--

LOCK TABLES `aims_computer_network` WRITE;
/*!40000 ALTER TABLE `aims_computer_network` DISABLE KEYS */;
INSERT INTO `aims_computer_network` VALUES (2,'CCP00003','TEST23','TEST23','TEST23'),(6,'CCP00003','Ronan','Ronan','Ronan'),(7,'CCP00004','TEST2','TEST2','TEST2'),(8,'CSV00001','TEST','TEST','TEST'),(9,'CCP00005','TEST','TEST','TEST'),(10,'CCP00006','TEST','TEST','TEST'),(11,'CCP00007','','',''),(12,'CSP00001','','',''),(13,'CSP00002','','',''),(14,'CCP00008','','',''),(15,'CLT00001','','',''),(16,'CSP00003','','','');
/*!40000 ALTER TABLE `aims_computer_network` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_computer_user`
--

DROP TABLE IF EXISTS `aims_computer_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_computer_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_tag` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_computer_user`
--

LOCK TABLES `aims_computer_user` WRITE;
/*!40000 ALTER TABLE `aims_computer_user` DISABLE KEYS */;
INSERT INTO `aims_computer_user` VALUES (47,'CSV00001','TEST','TEST','','ADMINISTRATOR'),(49,'CCP00006','TEST','TEST','Ali','ADMINISTRATOR'),(55,'CSP00003','USER','12345','USER','ADMINISTRATOR');
/*!40000 ALTER TABLE `aims_computer_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_computers_category_run_no`
--

DROP TABLE IF EXISTS `aims_computers_category_run_no`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_computers_category_run_no` (
  `id` int(11) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `prefix` varchar(255) DEFAULT NULL,
  `next_no` int(11) DEFAULT NULL,
  `digit_no` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_computers_category_run_no`
--

LOCK TABLES `aims_computers_category_run_no` WRITE;
/*!40000 ALTER TABLE `aims_computers_category_run_no` DISABLE KEYS */;
INSERT INTO `aims_computers_category_run_no` VALUES (1,'computer','Computer','CP',1,6);
/*!40000 ALTER TABLE `aims_computers_category_run_no` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_electronics`
--

DROP TABLE IF EXISTS `aims_electronics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_electronics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_tag` varchar(255) NOT NULL,
  `nfc_code` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT '' COMMENT '''ACTIVE''',
  `brand` varchar(255) DEFAULT NULL,
  `model_no` varchar(255) DEFAULT NULL,
  `price` varchar(65) DEFAULT '',
  `value` varchar(65) DEFAULT '',
  `date_created` varchar(255) DEFAULT NULL,
  `date_purchase` varchar(255) DEFAULT NULL,
  `start_warranty` varchar(255) DEFAULT NULL,
  `end_warranty` varchar(255) DEFAULT NULL,
  `warranty` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) NOT NULL,
  `supplier` varchar(255) DEFAULT '',
  `remark` varchar(255) DEFAULT NULL,
  `invoice` varchar(255) DEFAULT NULL,
  `document` varchar(255) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `transfer_branch` varchar(255) NOT NULL,
  `transfer_department` varchar(255) NOT NULL,
  `transfer_location` varchar(255) NOT NULL,
  `date_transfer` varchar(255) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_electronics`
--

LOCK TABLES `aims_electronics` WRITE;
/*!40000 ALTER TABLE `aims_electronics` DISABLE KEYS */;
INSERT INTO `aims_electronics` VALUES (16,'ECA00002',NULL,'electronic','camera','ACTIVE','','','','',NULL,'','','',NULL,'','','','','','','','','','','','','','');
/*!40000 ALTER TABLE `aims_electronics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_electronics_category_run_no`
--

DROP TABLE IF EXISTS `aims_electronics_category_run_no`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_electronics_category_run_no` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) DEFAULT '',
  `display_name` varchar(255) DEFAULT NULL,
  `prefix` varchar(255) DEFAULT NULL,
  `next_no` int(11) DEFAULT NULL,
  `digit_no` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `prefix` (`prefix`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_electronics_category_run_no`
--

LOCK TABLES `aims_electronics_category_run_no` WRITE;
/*!40000 ALTER TABLE `aims_electronics_category_run_no` DISABLE KEYS */;
INSERT INTO `aims_electronics_category_run_no` VALUES (1,'camera','Camera','ECA',3,6),(2,'air_conditioner','Air Conditioner','EAC',1,6),(3,'monitor','Monitor','EMN',1,6),(4,'network_device','Network Devices','END',1,6),(5,'speaker','Speaker','ESP',1,6),(6,'headphone','Headphone','EHP',1,6),(7,'printer','Printer','EPR',1,6),(8,'water_filter','Water Filter','EWF',1,6),(9,'refrigerator','Refrigerator','ERE',1,6),(10,'others','Others','EOT',1,6);
/*!40000 ALTER TABLE `aims_electronics_category_run_no` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_izzat`
--

DROP TABLE IF EXISTS `aims_izzat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_izzat` (
  `id` int(65) NOT NULL AUTO_INCREMENT,
  `nfc_code` varchar(255) DEFAULT NULL,
  `asset_tag` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_izzat`
--

LOCK TABLES `aims_izzat` WRITE;
/*!40000 ALTER TABLE `aims_izzat` DISABLE KEYS */;
INSERT INTO `aims_izzat` VALUES (1,'NFC0001','ATA00002','asset keycaps'),(2,'NFC0002','CCP00001','Test'),(3,'NFC0003','CLT00003','Acer Predator Helios 300'),(4,'NFC0004','CCP00031','PC1'),(5,'NFC0005','END00003','Cable'),(6,'NFC0006','ATA00003','peepee'),(7,'NFC0007','ECA00001','TESTING'),(8,'NFC0008',NULL,NULL),(9,'NFC0009',NULL,NULL),(10,'NFC0010',NULL,NULL);
/*!40000 ALTER TABLE `aims_izzat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_location`
--

DROP TABLE IF EXISTS `aims_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `address` varchar(255) DEFAULT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `contact_number` int(11) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `google_coordinate` varchar(255) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_location`
--

LOCK TABLES `aims_location` WRITE;
/*!40000 ALTER TABLE `aims_location` DISABLE KEYS */;
/*!40000 ALTER TABLE `aims_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_maintenance_asset`
--

DROP TABLE IF EXISTS `aims_maintenance_asset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_maintenance_asset` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `asset_tag` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `maintenance` varchar(255) DEFAULT '',
  `title` varchar(255) DEFAULT '',
  `expenses` varchar(255) DEFAULT NULL,
  `maintenance_date` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `vendors` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `maintenance_tag` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_maintenance_asset`
--

LOCK TABLES `aims_maintenance_asset` WRITE;
/*!40000 ALTER TABLE `aims_maintenance_asset` DISABLE KEYS */;
/*!40000 ALTER TABLE `aims_maintenance_asset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_maintenance_computer`
--

DROP TABLE IF EXISTS `aims_maintenance_computer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_maintenance_computer` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `asset_tag` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `maintenance` varchar(255) DEFAULT '',
  `title` varchar(255) DEFAULT '',
  `expenses` varchar(255) NOT NULL DEFAULT '',
  `maintenance_date` varchar(255) DEFAULT '',
  `category` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `vendors` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `maintenance_tag` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_maintenance_computer`
--

LOCK TABLES `aims_maintenance_computer` WRITE;
/*!40000 ALTER TABLE `aims_maintenance_computer` DISABLE KEYS */;
INSERT INTO `aims_maintenance_computer` VALUES (14,'CCP00006','computer','','REQUIREDREQUIRED','300','2023-10-11','computer','REQUIREDREQUIRED','','with_fee','WIF00001');
/*!40000 ALTER TABLE `aims_maintenance_computer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_maintenance_electronics`
--

DROP TABLE IF EXISTS `aims_maintenance_electronics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_maintenance_electronics` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `asset_tag` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `maintenance` varchar(255) DEFAULT '',
  `title` varchar(255) DEFAULT '',
  `expenses` varchar(255) DEFAULT NULL,
  `maintenance_date` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `vendors` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `maintenance_tag` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_maintenance_electronics`
--

LOCK TABLES `aims_maintenance_electronics` WRITE;
/*!40000 ALTER TABLE `aims_maintenance_electronics` DISABLE KEYS */;
INSERT INTO `aims_maintenance_electronics` VALUES (11,'ECA00002','electronic','','TEST','234','2023-10-19','electronics','TEST','','prevantive_maintenance','PRM00001'),(12,'ECA00002','electronic','','TESTTEST','92','2023-10-11','electronics','TESTTEST','','prevantive_maintenance','PRM00001');
/*!40000 ALTER TABLE `aims_maintenance_electronics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_maintenance_type_run_no`
--

DROP TABLE IF EXISTS `aims_maintenance_type_run_no`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_maintenance_type_run_no` (
  `id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `prefix` varchar(255) DEFAULT NULL,
  `next_no` int(11) DEFAULT NULL,
  `digit_no` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_maintenance_type_run_no`
--

LOCK TABLES `aims_maintenance_type_run_no` WRITE;
/*!40000 ALTER TABLE `aims_maintenance_type_run_no` DISABLE KEYS */;
INSERT INTO `aims_maintenance_type_run_no` VALUES (1,'with_fee','With Fee','WIF',1,6),(2,'without_fee','Without Fee','WOF',1,6),(3,'prevantive_maintenance','Prevantive Maintenance ','PRM',1,6);
/*!40000 ALTER TABLE `aims_maintenance_type_run_no` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_module`
--

DROP TABLE IF EXISTS `aims_module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(255) NOT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_module`
--

LOCK TABLES `aims_module` WRITE;
/*!40000 ALTER TABLE `aims_module` DISABLE KEYS */;
INSERT INTO `aims_module` VALUES (1,'dashboard','Dashboard','dashboard.svg'),(2,'asset','Asset','asset.svg'),(3,'people','People','software.svg'),(4,'development','Activity','development.svg'),(5,'location','Location','location.svg'),(6,'report',' NFC Tag','report.svg'),(7,'billing','Billing & Payment','billing.svg');
/*!40000 ALTER TABLE `aims_module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_news`
--

DROP TABLE IF EXISTS `aims_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_news` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_news`
--

LOCK TABLES `aims_news` WRITE;
/*!40000 ALTER TABLE `aims_news` DISABLE KEYS */;
INSERT INTO `aims_news` VALUES (1,'New Commit','News','HELLO WELCOME EVERYBOIDY','2023-09-04 17:01:32');
/*!40000 ALTER TABLE `aims_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_people_customer`
--

DROP TABLE IF EXISTS `aims_people_customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_people_customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `display_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact_no` int(11) DEFAULT NULL,
  `nric` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_people_customer`
--

LOCK TABLES `aims_people_customer` WRITE;
/*!40000 ALTER TABLE `aims_people_customer` DISABLE KEYS */;
/*!40000 ALTER TABLE `aims_people_customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_people_staff`
--

DROP TABLE IF EXISTS `aims_people_staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_people_staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `display_name` varchar(255) DEFAULT '',
  `email` varchar(255) DEFAULT NULL,
  `contact_no` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `nric` int(11) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_people_staff`
--

LOCK TABLES `aims_people_staff` WRITE;
/*!40000 ALTER TABLE `aims_people_staff` DISABLE KEYS */;
INSERT INTO `aims_people_staff` VALUES (6,'TEST','test@gmail.com',123,'TEST',123,'TEST','TEST');
/*!40000 ALTER TABLE `aims_people_staff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_people_supplier`
--

DROP TABLE IF EXISTS `aims_people_supplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_people_supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `display_name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_people_supplier`
--

LOCK TABLES `aims_people_supplier` WRITE;
/*!40000 ALTER TABLE `aims_people_supplier` DISABLE KEYS */;
/*!40000 ALTER TABLE `aims_people_supplier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_people_vendors`
--

DROP TABLE IF EXISTS `aims_people_vendors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_people_vendors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `display_name` varchar(255) DEFAULT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_people_vendors`
--

LOCK TABLES `aims_people_vendors` WRITE;
/*!40000 ALTER TABLE `aims_people_vendors` DISABLE KEYS */;
/*!40000 ALTER TABLE `aims_people_vendors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_preset_category_run_no`
--

DROP TABLE IF EXISTS `aims_preset_category_run_no`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_preset_category_run_no` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_preset_category_run_no`
--

LOCK TABLES `aims_preset_category_run_no` WRITE;
/*!40000 ALTER TABLE `aims_preset_category_run_no` DISABLE KEYS */;
INSERT INTO `aims_preset_category_run_no` VALUES (1,'supplier','Supplier'),(2,'department','Department'),(3,'location','Location'),(4,'choose','Choose Category');
/*!40000 ALTER TABLE `aims_preset_category_run_no` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_preset_computer_branch`
--

DROP TABLE IF EXISTS `aims_preset_computer_branch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_preset_computer_branch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch` varchar(255) NOT NULL,
  `branch_contact_no` varchar(255) NOT NULL,
  `branch_email` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `contact_no` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_preset_computer_branch`
--

LOCK TABLES `aims_preset_computer_branch` WRITE;
/*!40000 ALTER TABLE `aims_preset_computer_branch` DISABLE KEYS */;
/*!40000 ALTER TABLE `aims_preset_computer_branch` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_preset_department`
--

DROP TABLE IF EXISTS `aims_preset_department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_preset_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `display_name` varchar(255) DEFAULT '',
  `staff` varchar(255) DEFAULT NULL,
  `noe` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_preset_department`
--

LOCK TABLES `aims_preset_department` WRITE;
/*!40000 ALTER TABLE `aims_preset_department` DISABLE KEYS */;
/*!40000 ALTER TABLE `aims_preset_department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_preset_devices_computer_brand`
--

DROP TABLE IF EXISTS `aims_preset_devices_computer_brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_preset_devices_computer_brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_preset_devices_computer_brand`
--

LOCK TABLES `aims_preset_devices_computer_brand` WRITE;
/*!40000 ALTER TABLE `aims_preset_devices_computer_brand` DISABLE KEYS */;
INSERT INTO `aims_preset_devices_computer_brand` VALUES (1,'Apple'),(2,'Acer'),(3,'Asus'),(4,'Razer'),(5,'Dell'),(6,'Microsoft'),(7,'MSI'),(8,'Lenovo'),(9,'HP'),(10,'Google'),(11,'Toshiba'),(12,'Alienware'),(13,'Gigabyte'),(14,'Illegear'),(15,'Level 51'),(16,'Others');
/*!40000 ALTER TABLE `aims_preset_devices_computer_brand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_preset_devices_phone_brand`
--

DROP TABLE IF EXISTS `aims_preset_devices_phone_brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_preset_devices_phone_brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_preset_devices_phone_brand`
--

LOCK TABLES `aims_preset_devices_phone_brand` WRITE;
/*!40000 ALTER TABLE `aims_preset_devices_phone_brand` DISABLE KEYS */;
INSERT INTO `aims_preset_devices_phone_brand` VALUES (1,'Oppo'),(2,'Huawei'),(3,'Samsung'),(4,'Vivo'),(5,'Apple'),(6,'Xiaomi'),(7,'Realme'),(8,'OnePlus'),(9,'Google'),(10,'Sony'),(11,'Motorola'),(12,'Asus'),(13,'LG'),(14,'ZTE'),(15,'Nokia'),(16,'HTC'),(17,'Others');
/*!40000 ALTER TABLE `aims_preset_devices_phone_brand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_preset_item`
--

DROP TABLE IF EXISTS `aims_preset_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_preset_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_code` varchar(20) NOT NULL,
  `item_description` varchar(255) NOT NULL,
  `item_uom` varchar(20) NOT NULL DEFAULT 'Pax',
  `item_price` decimal(10,2) NOT NULL,
  `tax_id` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `item_code` (`item_code`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_preset_item`
--

LOCK TABLES `aims_preset_item` WRITE;
/*!40000 ALTER TABLE `aims_preset_item` DISABLE KEYS */;
INSERT INTO `aims_preset_item` VALUES (1,'ITEM01','AL RAJHI - NB CLUBHOUSE','Pax',11.00,1),(2,'ITEM02','OTHER DEBTORS','Pax',50.00,2),(3,'ITEM03','OTHER INCOME','Pax',30.00,2),(4,'ITEM04','PETTY CASH - CLUBHOUSE','Pax',10.00,1),(5,'ITEM05','TURNOVER - FOOD','Pax',600.00,1),(6,'ITEM06','COST OF SALES - CLUB FOOD','Pax',10.00,1),(7,'ITEM07','TURNOVER - BEVERAGES','Pax',8.00,1),(8,'ITEM08','COST OF SALES - CLUB BEVERAGES','Pax',10.00,1),(9,'ITEM09','TURNOVER - BEVERAGES - LIQUOR','Pax',10.00,1),(10,'ITEM10','COST OF SALES - CLUB BEVERAGES - LIQUOR','Pax',10.00,1),(11,'ITEM11','TURNOVER - CORKAGE CHARGES','Pax',50.00,1),(12,'ITEM12','TURNOVER - CLUB MEMBERSHIP SUBSCRIPTION (MEMBER)','Pax',110.00,1),(13,'ITEM13','TURNOVER - CLUB JOINING FEE ','Pax',2500.00,1),(14,'ITEM14','TURNOVER - GUEST ENTRANCE FEE (WEEKDAY)','Pax',10.00,1),(15,'ITEM15','TURNOVER - FACILITY BOOKING FEE - BADMINTON COURT','Pax',10.00,1),(16,'ITEM16','TURNOVER - FACILITY BOOKING FEE - MULTI-PURPOSE COURT','Pax',10.00,1),(17,'ITEM17','TURNOVER - COACHING & LESSON FEE - BADMINTON (4 LESSONS)','Pax',110.00,1),(18,'ITEM18','TURNOVER - COACHING & LESSON FEE - BASKETBALL (4 LESSONS)','Pax',110.00,1),(19,'ITEM19','TURNOVER - COACHING & LESSON FEE - FITNESS (5 LESSONS)','Pax',600.00,1),(20,'ITEM20','TURNOVER - COACHING & LESSON FEE - NETBALL (4 LESSONS)','Pax',110.00,1),(21,'ITEM21','TURNOVER - COACHING & LESSON FEE - SWIMMING (4 LESSONS)','Pax',110.00,1),(22,'ITEM22','TURNOVER - GYM SUBSCRIPTION FEE','Pax',20.00,1),(23,'ITEM23','SALES SERVICE TAX','Pax',10.00,1),(24,'ITEM24','TRADE DEBTORS - CLUB MEMBERS','Pax',10.00,1),(25,'ITEM25','TURNOVER - CLUB MEMBERSHIP SUBSCRIPTION (SPOUSE)','Pax',20.00,1),(26,'ITEM26','TURNOVER - CLUB MEMBERSHIP SUBSCRIPTION (CHILDREN,7-20 YO)','Pax',20.00,1),(27,'ITEM27','DEPOSIT','Pax',200.00,1),(28,'ITEM28','TURNOVER - FACILITY BOOKING FEE - BASKETBALL COURT','Pax',50.00,1),(29,'ITEM29','TURNOVER - CLUB JOINING FEE --- CORPORATE STAFF (LHS/NB PROPERTY OWNER/TENANT)','Pax',1800.00,1),(30,'ITEM30','TURNOVER - CLUB JOINING FEE --- INVITEE/OTHER IB PROPERTY OWNER/TENANT','Pax',2500.00,1),(31,'ITEM31','TURNOVER - CLUB MEMBERSHIP SUBSCRIPTION (MEMBER) --- 1 YEAR','Pax',1320.00,1),(32,'ITEM32','TURNOVER - GYM SUBSCRIPTION FEE (1 YEAR)','Pax',240.00,1),(33,'ITEM33','TURNOVER - CLUB MEMBERSHIP SUBSCRIPTION (SPOUSE) --- 1 YEAR','Pax',240.00,1),(34,'ITEM34','TURNOVER - CLUB MEMBERSHIP SUBSCRIPTION (CHILDREN,7-20 YO) --- 1 YEAR','Pax',240.00,1),(35,'ITEM35','TURNOVER - GUEST ENTRANCE FEE (WEEKEND, PUBLIC HOLIDAY)','Pax',15.00,1),(36,'ITEM36','TURNOVER - FOOD (BUFFET)','Pax',60.00,1),(37,'ITEM37','TURNOVER - CIGARETTE','Pax',8.00,1),(38,'ITEM38','TURNOVER - OTHERS','Pax',10.00,1),(39,'ITEM39','TURNOVER - PENALTY OF DAMAGING DART','Pax',5.00,1),(40,'ITEM40','TURNOVER - PARKING FEE','Pax',4.00,1),(41,'ITEM41','TURNOVER - CLUB JOINING FEE (ALYVIA/CRESTWOOD)','Pax',1800.00,1),(42,'ITEM42','TURNOVER - COACHING & LESSON FEE - FITNESS (10 LESSONS)','Pax',1100.00,1),(43,'ITEM43','TURNOVER - PRIVATE COACHING & LESSON FEE - SWIMMING (4 LESSONS)','Pax',320.00,1),(44,'ITEM44','TURNOVER - CLUB MEMBERSHIP SUBSCRIPTION (MEMBER) --- 5 YEARS','Pax',6600.00,1),(45,'ITEM45','TURNOVER - CLUB MEMBERSHIP SUBSCRIPTION (MEMBER) ---  ADVANCE','Pax',110.00,1),(46,'ITEM46','TURNOVER - CLUB MEMBERSHIP SUBSCRIPTION (SPOUSE) --- ADVANCE','Pax',20.00,1),(47,'ITEM47','TURNOVER - CLUB MEMBERSHIP SUBSCRIPTION (CHILDREN,7-20 YO) --- ADVANCE','Pax',20.00,1),(48,'ITEM48','TURNOVER - GYM SUBSCRIPTION FEE (ADVANCE)','Pax',20.00,1);
/*!40000 ALTER TABLE `aims_preset_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_preset_location`
--

DROP TABLE IF EXISTS `aims_preset_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_preset_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `display_name` varchar(255) NOT NULL DEFAULT '',
  `staff` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_preset_location`
--

LOCK TABLES `aims_preset_location` WRITE;
/*!40000 ALTER TABLE `aims_preset_location` DISABLE KEYS */;
/*!40000 ALTER TABLE `aims_preset_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_running_no`
--

DROP TABLE IF EXISTS `aims_running_no`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_running_no` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_name` varchar(255) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `prefix` varchar(255) DEFAULT NULL,
  `next_no` int(11) DEFAULT NULL,
  `digit_no` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `prefix` (`prefix`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_running_no`
--

LOCK TABLES `aims_running_no` WRITE;
/*!40000 ALTER TABLE `aims_running_no` DISABLE KEYS */;
INSERT INTO `aims_running_no` VALUES (1,'invoice_num','Invoice Number','INV',1,6),(2,'receipt_number','Receipt Number','RCP',1,6),(3,'invoice_adjustment_number','Invoice Adjustment Number','IAN',1,6),(4,'credit_note','Credit Note','CN',1,6),(5,'debit_note','Debit Note','DN',1,6);
/*!40000 ALTER TABLE `aims_running_no` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_software`
--

DROP TABLE IF EXISTS `aims_software`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_software` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_tag` varchar(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `license_key` varchar(255) DEFAULT NULL,
  `expiry_date` varchar(255) DEFAULT NULL,
  `bill` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_software`
--

LOCK TABLES `aims_software` WRITE;
/*!40000 ALTER TABLE `aims_software` DISABLE KEYS */;
INSERT INTO `aims_software` VALUES (82,'CSV00001','operating_system','TEST','TEST','TEST','2023-10-11',NULL),(84,'CCP00006','test','TEST','TEST','TEST','2023-10-11',NULL),(90,'CSP00003','','','','','',NULL);
/*!40000 ALTER TABLE `aims_software` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_software_category`
--

DROP TABLE IF EXISTS `aims_software_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_software_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `display_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_software_category`
--

LOCK TABLES `aims_software_category` WRITE;
/*!40000 ALTER TABLE `aims_software_category` DISABLE KEYS */;
INSERT INTO `aims_software_category` VALUES (18,'test'),(19,'test 5');
/*!40000 ALTER TABLE `aims_software_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_software_category_run_no`
--

DROP TABLE IF EXISTS `aims_software_category_run_no`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_software_category_run_no` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) DEFAULT '',
  `display_name` varchar(255) DEFAULT NULL,
  `prefix` varchar(255) DEFAULT NULL,
  `next_no` int(11) DEFAULT NULL,
  `digit_no` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `prefix` (`prefix`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_software_category_run_no`
--

LOCK TABLES `aims_software_category_run_no` WRITE;
/*!40000 ALTER TABLE `aims_software_category_run_no` DISABLE KEYS */;
INSERT INTO `aims_software_category_run_no` VALUES (1,'operating_system','Operating System','SOS',1,6),(2,'application','Application','SAP',1,6),(3,'multimedia','Multimedia','SMM',1,6),(4,'cloud','Cloud','SCL',1,6),(5,'security','Security','SSE',2,6),(6,'utility','Utility','SUT',1,6),(7,'shareware','Shareware','SSW',1,6),(8,'game','Game','SGA',1,6),(9,'enterprise','Enterprise','SEP',1,6),(10,'accounting','Accounting','SAC',1,6),(11,'others','Others','SOT',1,6);
/*!40000 ALTER TABLE `aims_software_category_run_no` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_submodule`
--

DROP TABLE IF EXISTS `aims_submodule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_submodule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(255) NOT NULL,
  `submodule` varchar(255) NOT NULL DEFAULT '',
  `module_id` int(11) NOT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_submodule`
--

LOCK TABLES `aims_submodule` WRITE;
/*!40000 ALTER TABLE `aims_submodule` DISABLE KEYS */;
INSERT INTO `aims_submodule` VALUES (1,'dashboard','dashboard',1,'Dashboard'),(2,'asset','asset',2,'Asset'),(3,'people','supplier',3,'Supplier'),(4,'development','transfer',4,'Transfer'),(5,'development','maintenance',4,'Maintenance'),(6,'development','development',4,'Scheduler'),(7,'development','development',4,'IoT Devices'),(8,'report','report',5,'Generate Report'),(9,'report','announcement',5,'Announcement'),(10,'report','update',5,'Technical Update'),(11,'billing','billing',6,'Billing & Payment'),(12,'people','staff',3,'Staff'),(13,'people','customer',3,'Customer'),(14,'people','vendors',3,'Vendors');
/*!40000 ALTER TABLE `aims_submodule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_submodule_access`
--

DROP TABLE IF EXISTS `aims_submodule_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_submodule_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `submodule_id` int(11) NOT NULL,
  `user_group_id` int(11) NOT NULL,
  `crud` bit(4) NOT NULL DEFAULT b'0',
  `approve1` tinyint(1) NOT NULL DEFAULT 0,
  `approve2` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=181 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_submodule_access`
--

LOCK TABLES `aims_submodule_access` WRITE;
/*!40000 ALTER TABLE `aims_submodule_access` DISABLE KEYS */;
INSERT INTO `aims_submodule_access` VALUES (1,1,1,'',1,1),(2,2,1,'',1,1),(3,3,1,'',1,1),(4,4,1,'',1,1),(5,5,1,'',1,1),(6,6,1,'',1,1),(7,7,1,'',1,1),(8,8,1,'',1,1),(9,9,1,'',1,1),(10,10,1,'',1,1),(11,11,1,'',1,1),(12,12,1,'',1,1),(13,13,1,'',1,1),(14,14,1,'',1,1),(15,15,1,'',1,1),(16,16,1,'',1,1),(17,17,1,'',1,1),(18,18,1,'',1,1),(19,19,1,'',1,1),(20,20,1,'',1,1),(21,21,1,'',1,1),(22,22,1,'',1,1),(23,23,1,'',1,1),(24,24,1,'',1,1),(25,25,1,'',1,1),(26,26,1,'',1,1),(27,27,1,'',1,1),(28,28,1,'',1,1),(29,29,1,'',1,1),(30,30,1,'',1,1),(31,31,1,'',1,1),(32,32,1,'',1,1),(33,33,1,'',1,1),(34,34,1,'',1,1),(35,35,1,'',1,1),(36,36,1,'',1,1),(37,37,1,'',1,1),(38,38,1,'',1,1),(39,39,1,'',1,1),(40,1,2,'',0,0),(41,2,2,'',0,0),(42,3,2,'',0,0),(43,4,2,'',0,0),(44,5,2,'',0,0),(45,6,2,'',0,0),(46,7,2,'',0,0),(47,8,2,'',0,0),(48,9,2,'',0,0),(49,10,2,'',0,0),(50,11,2,'',0,0),(51,12,2,'',0,0),(52,13,2,'',0,0),(53,14,2,'',0,0),(54,15,2,'',0,0),(55,16,2,'',0,0),(56,17,2,'',0,0),(57,18,2,'',0,0),(58,19,2,'',0,0),(59,20,2,'',0,0),(60,21,2,'\0',0,0),(61,22,2,'\0',0,0),(62,23,2,'\0',0,0),(63,24,2,'\0',0,0),(64,25,2,'\0',0,0),(65,26,2,'\0',0,0),(66,27,2,'\0',0,0),(67,28,2,'\0',0,0),(68,29,2,'\0',0,0),(69,30,2,'\0',0,0),(70,31,2,'\0',0,0),(71,32,2,'\0',0,0),(72,33,2,'\0',0,0),(73,34,2,'\0',0,0),(74,35,2,'\0',0,0),(75,36,2,'\0',0,0),(76,37,2,'\0',0,0),(77,38,2,'\0',0,0),(78,39,2,'\0',0,0),(79,1,3,'\0',0,0),(80,2,3,'\0',0,0),(81,3,3,'\0',0,0),(82,4,3,'\0',0,0),(83,5,3,'\0',0,0),(84,6,3,'\0',0,0),(85,7,3,'\0',0,0),(86,8,3,'\0',0,0),(87,9,3,'\0',0,0),(88,10,3,'\0',0,0),(89,11,3,'\0',0,0),(90,12,3,'\0',0,0),(91,13,3,'\0',0,0),(92,14,3,'\0',0,0),(93,15,3,'\0',0,0),(94,16,3,'\0',0,0),(95,17,3,'\0',0,0),(96,18,3,'\0',0,0),(97,19,3,'\0',0,0),(98,20,3,'\0',0,0),(99,21,3,'\0',0,0),(100,22,3,'\0',0,0),(101,23,3,'\0',0,0),(102,24,3,'\0',0,0),(103,25,3,'\0',0,0),(104,26,3,'\0',0,0),(105,27,3,'\0',0,0),(106,28,3,'\0',0,0),(107,29,3,'\0',0,0),(108,30,3,'\0',0,0),(109,31,3,'\0',0,0),(110,32,3,'\0',0,0),(111,33,3,'\0',0,0),(112,34,3,'\0',0,0),(113,35,3,'\0',0,0),(114,36,3,'\0',0,0),(115,37,3,'\0',0,0),(116,38,3,'\0',0,0),(117,39,3,'\0',0,0),(118,1,4,'\0',0,0),(119,2,4,'\0',0,0),(120,3,4,'\0',0,0),(121,4,4,'\0',0,0),(122,5,4,'\0',0,0),(123,6,4,'\0',0,0),(124,7,4,'\0',0,0),(125,8,4,'\0',0,0),(126,9,4,'\0',0,0),(127,10,4,'\0',0,0),(128,11,4,'\0',0,0),(129,12,4,'\0',0,0),(130,13,4,'\0',0,0),(131,14,4,'\0',0,0),(132,15,4,'\0',0,0),(133,16,4,'\0',0,0),(134,17,4,'\0',0,0),(135,18,4,'\0',0,0),(136,19,4,'\0',0,0),(137,20,4,'\0',0,0),(138,21,4,'\0',0,0),(139,22,4,'\0',0,0),(140,23,4,'\0',0,0),(141,24,4,'\0',0,0),(142,25,4,'\0',0,0),(143,26,4,'\0',0,0),(144,27,4,'\0',0,0),(145,28,4,'\0',0,0),(146,29,4,'\0',0,0),(147,30,4,'\0',0,0),(148,31,4,'\0',0,0),(149,32,4,'\0',0,0),(150,33,4,'\0',0,0),(151,34,4,'\0',0,0),(152,35,4,'\0',0,0),(153,36,4,'\0',0,0),(154,37,4,'\0',0,0),(155,38,4,'\0',0,0),(156,39,4,'\0',0,0),(157,1,5,'\0',0,0),(158,2,5,'\0',0,0),(159,3,5,'\0',0,0),(160,4,5,'\0',0,0),(161,5,5,'\0',0,0),(162,6,5,'\0',0,0),(163,7,5,'\0',0,0),(164,8,5,'\0',0,0),(165,9,5,'\0',0,0),(166,10,5,'\0',0,0),(167,11,5,'\0',0,0),(168,12,5,'\0',0,0),(169,13,5,'\0',0,0),(170,14,5,'\0',0,0),(171,15,5,'\0',0,0),(172,16,5,'\0',0,0),(173,17,5,'\0',0,0),(174,18,5,'\0',0,0),(175,19,5,'\0',0,0),(176,20,5,'\0',0,0),(177,21,5,'\0',0,0),(178,22,5,'\0',0,0),(179,23,5,'\0',0,0),(180,24,5,'\0',0,0);
/*!40000 ALTER TABLE `aims_submodule_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_transfer_asset`
--

DROP TABLE IF EXISTS `aims_transfer_asset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_transfer_asset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_tag` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `branch` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `transfer_branch` varchar(255) NOT NULL,
  `transfer_department` varchar(255) NOT NULL,
  `transfer_location` varchar(255) NOT NULL,
  `date_transfer` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_transfer_asset`
--

LOCK TABLES `aims_transfer_asset` WRITE;
/*!40000 ALTER TABLE `aims_transfer_asset` DISABLE KEYS */;
INSERT INTO `aims_transfer_asset` VALUES (67,'ATA00002','asset keycaps','asset','','','','LOL','TEST','Munchkin','2023-10-09');
/*!40000 ALTER TABLE `aims_transfer_asset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_transfer_computer`
--

DROP TABLE IF EXISTS `aims_transfer_computer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_transfer_computer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_tag` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `branch` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `transfer_branch` varchar(255) NOT NULL,
  `transfer_department` varchar(255) NOT NULL,
  `transfer_location` varchar(255) NOT NULL,
  `date_transfer` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_transfer_computer`
--

LOCK TABLES `aims_transfer_computer` WRITE;
/*!40000 ALTER TABLE `aims_transfer_computer` DISABLE KEYS */;
INSERT INTO `aims_transfer_computer` VALUES (3,'CCP00001','Test','computer','','','','Munchkin','Munchkin','Munchkin','2023-10-25');
/*!40000 ALTER TABLE `aims_transfer_computer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_transfer_electronics`
--

DROP TABLE IF EXISTS `aims_transfer_electronics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_transfer_electronics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_tag` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `branch` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `transfer_branch` varchar(255) NOT NULL,
  `transfer_department` varchar(255) NOT NULL,
  `transfer_location` varchar(255) NOT NULL,
  `date_transfer` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_transfer_electronics`
--

LOCK TABLES `aims_transfer_electronics` WRITE;
/*!40000 ALTER TABLE `aims_transfer_electronics` DISABLE KEYS */;
/*!40000 ALTER TABLE `aims_transfer_electronics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_user`
--

DROP TABLE IF EXISTS `aims_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `nric` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `date_created` datetime(6) NOT NULL,
  `full_name` varchar(255) DEFAULT '',
  `company_name` varchar(255) DEFAULT '',
  `department` varchar(255) DEFAULT '',
  `position` varchar(255) DEFAULT '',
  `phone` varchar(255) DEFAULT '',
  `address` varchar(255) DEFAULT '',
  `city` varchar(255) DEFAULT '',
  `state` varchar(255) DEFAULT '',
  `country` varchar(255) DEFAULT '',
  `user_group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_user`
--

LOCK TABLES `aims_user` WRITE;
/*!40000 ALTER TABLE `aims_user` DISABLE KEYS */;
INSERT INTO `aims_user` VALUES (1,'root','admin@dev.com','999999135435','$2y$10$lnXWEUPtGHzStaq1nHJUf.cmIu.1NNcGPYy0vcB7yKcVZLyoKJg6.','2023-09-01 16:37:05.000000','GROOT','Softworld Software','','admin','','','','','',1),(16,'Raymond','raymond.lai@softworld.com.my','888888114322','$2y$10$lnXWEUPtGHzStaq1nHJUf.cmIu.1NNcGPYy0vcB7yKcVZLyoKJg6.','2023-09-07 16:38:31.000000','Raymond','Lynx Solution','','Manager','','','','','',2),(20,'Piano','piano@fordona.com.my','777777111111','$2y$10$lnXWEUPtGHzStaq1nHJUf.cmIu.1NNcGPYy0vcB7yKcVZLyoKJg6.','2023-09-04 14:02:54.000000','Piano Rest','Music Society','','Data Custodian','','','','','',4),(31,'Howard','howard@lead.dev','777777222222','$2y$10$lnXWEUPtGHzStaq1nHJUf.cmIu.1NNcGPYy0vcB7yKcVZLyoKJg6.','2023-09-03 14:03:51.000000','Howard Lop','Hogwart Legacy','','Team Lead','','','','','',3),(40,'Elisa','elisa@example.com.my','888888112345','$2y$10$lnXWEUPtGHzStaq1nHJUf.cmIu.1NNcGPYy0vcB7yKcVZLyoKJg6.','2023-09-04 09:49:17.000000','Elisa','Maybank Solution','','Officer','','','','','',5);
/*!40000 ALTER TABLE `aims_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_user_account`
--

DROP TABLE IF EXISTS `aims_user_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_user_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_tag` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_user_account`
--

LOCK TABLES `aims_user_account` WRITE;
/*!40000 ALTER TABLE `aims_user_account` DISABLE KEYS */;
/*!40000 ALTER TABLE `aims_user_account` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aims_user_group`
--

DROP TABLE IF EXISTS `aims_user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aims_user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_group_name` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `user_group_rank` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aims_user_group`
--

LOCK TABLES `aims_user_group` WRITE;
/*!40000 ALTER TABLE `aims_user_group` DISABLE KEYS */;
INSERT INTO `aims_user_group` VALUES (1,'ROOT','Root',1),(2,'ADMIN','Admin',1),(3,'MANAGER','Manager',2),(4,'CUSTODIAN','Data Custodian',3),(5,'LEAD','Team Lead',4),(6,'STAFF','Staff',5);
/*!40000 ALTER TABLE `aims_user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_temp`
--

DROP TABLE IF EXISTS `password_reset_temp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_temp` (
  `phone` varchar(250) NOT NULL,
  `key` varchar(250) NOT NULL,
  `expDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_temp`
--

LOCK TABLES `password_reset_temp` WRITE;
/*!40000 ALTER TABLE `password_reset_temp` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_temp` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-10-12 11:04:51
