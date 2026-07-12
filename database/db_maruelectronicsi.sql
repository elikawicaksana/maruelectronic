/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 8.0.30 : Database - db_maruelectronics
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_maruelectronics` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `db_maruelectronics`;

/*Table structure for table `tb_order` */

DROP TABLE IF EXISTS `tb_order`;

CREATE TABLE `tb_order` (
  `id_order` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  `total` double(17,2) DEFAULT '0.00',
  `status` tinyint DEFAULT NULL,
  `shipping_status` int DEFAULT '0',
  `delivery_address` text,
  `payment_type` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_order`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `tb_order` */

insert  into `tb_order`(`id_order`,`id_user`,`total`,`status`,`shipping_status`,`delivery_address`,`payment_type`,`created_at`) values 
(8,3,204000.00,1,2,'Jl. Teknik Udayana, Gang II No.5','bank_transfer','2026-07-12 20:33:40'),
(13,2,414000.00,1,2,'Jl. Fakultas Kedokteran Udayana, Denpasar','bank_transfer','2026-07-12 22:35:38');

/*Table structure for table `tb_order_detail` */

DROP TABLE IF EXISTS `tb_order_detail`;

CREATE TABLE `tb_order_detail` (
  `id_order_det` int NOT NULL AUTO_INCREMENT,
  `id_order` int DEFAULT NULL,
  `id_product` int DEFAULT NULL,
  `qty` bigint DEFAULT NULL,
  `price` double(17,2) DEFAULT '0.00',
  PRIMARY KEY (`id_order_det`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `tb_order_detail` */

insert  into `tb_order_detail`(`id_order_det`,`id_order`,`id_product`,`qty`,`price`) values 
(12,8,17,4,4000.00),
(13,8,15,1,200000.00),
(17,12,15,2,400000.00),
(18,13,15,2,400000.00),
(19,13,17,14,14000.00);

/*Table structure for table `tb_product` */

DROP TABLE IF EXISTS `tb_product`;

CREATE TABLE `tb_product` (
  `id_product` int NOT NULL AUTO_INCREMENT,
  `product_name` varchar(75) DEFAULT NULL,
  `price` double(17,2) DEFAULT '0.00',
  `stock` bigint DEFAULT NULL,
  `desc` text,
  `img` text,
  PRIMARY KEY (`id_product`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `tb_product` */

insert  into `tb_product`(`id_product`,`product_name`,`price`,`stock`,`desc`,`img`) values 
(2,'ESP32 WiFi Bluetooth CH340 / CP2102 Type C – Board IoT Development NodeMCU',70000.00,11,'Board development ESP32 dengan chip WROOM-32, dilengkapi konektivitas WiFi dan Bluetooth (BLE) dalam satu modul, cocok untuk proyek IoT, robotika, home automation, hingga wearable device. Sudah pakai port USB Type-C yang lebih modern dan reversible dibanding Micro USB. Tersedia 2 pilihan varian brand board, keduanya sama-sama 30-pin dan fungsinya identik.','dist/img/20260711-234615PRODUCT-esp32.webp'),
(15,'WEP 947 IX Portable Soldering Iron Temperature Range 220c-480c',200000.00,5,'WEP 947 IX Portable Soldering Iron Temperature Range 220c-480c\r\nModel : WEP 947 IX\r\nControl Unit Dimensions : L220xW28xH28mm\r\nOperating Ambient Temperature : 0-40°c/32°F-104°F\r\nTemperature Range : 220°C-480°C/428°F-896°F\r\nTemperature Contro : Sensor-Controlled Temperature\r\nOperation Indicator light : YES\r\n1xpcs WEP 947 IX Portable Soldering Iron Temperature Range 220c-480c','dist/img/20260711-230138PRODUCT-solder.jpg'),
(17,'LDR GL5516 5MM PHOTORESISTOR PHOTO RESISTOR GL 5516',1000.00,44,'LDR, photosensitive resistor berdiameter 5mm ini resistansinya berubah ketika ada perubahan intensitas cahaya. Ketika kondisi gelap, resistansinya besar hingga 0.5MOhm tetapi ketika kondisi terang, resistansinya mengecil menjadi 5-10kOhm. Perubahan resistansi ini bisa agan pake sebagai input analog di arduino agan.','dist/img/20260712-172802PRODUCT-LDR.webp');

/*Table structure for table `tb_user` */

DROP TABLE IF EXISTS `tb_user`;

CREATE TABLE `tb_user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `username` varchar(75) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `passwd` varchar(255) DEFAULT NULL,
  `role` enum('Customer','Admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `address` text,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

/*Data for the table `tb_user` */

insert  into `tb_user`(`id_user`,`username`,`name`,`email`,`passwd`,`role`,`address`) values 
(1,'doejohn','John Doe','johndoe@gmail.com','$2y$10$iP0dnnmJsFpg93zAplE7OuaEKiOieanq7XgqXSjbiycWRaerwcrVS','Admin',NULL),
(2,'doejane','Jane Doe','janedoe@gmail.com','$2y$10$iP0dnnmJsFpg93zAplE7OuaEKiOieanq7XgqXSjbiycWRaerwcrVS','Customer','Jl. Fakultas Kedokteran Udayana, Denpasar'),
(3,'marumnrv','Maru Minerva','maruminerva11@gmail.com','$2y$10$QVFMytev2AJpkd.6ZuSEou9AuT1I9F8Aql3Rpkmnufgg9JXh85ebu','Customer','Jl. Teknik Prabhu Udayana, Gg. II, No.5, Jimbaran');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
