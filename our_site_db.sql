-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 14, 2017 at 08:51 PM
-- Server version: 5.7.13-log
-- PHP Version: 5.6.25

-- SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
-- SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `our_site_db`
--
CREATE DATABASE IF NOT EXISTS `our_site_db`;
USE `our_site_db`;

-- --------------------------------------------------------

--
-- Table structure for table `transit_hub`
--
DROP TABLE IF EXISTS `transit_hub`;

CREATE TABLE `transit_hub` (
  `transit_id` int(11) NOT NULL AUTO_INCREMENT,
  `transit_city` varchar(45) CHARACTER SET ucs2 NOT NULL,
  `address` varchar(45) DEFAULT NULL,
  `geo_x` decimal(8,6) DEFAULT NULL,
  `geo_y` decimal(8,6) DEFAULT NULL,
  PRIMARY KEY (`transit_id`),
  UNIQUE KEY `id_UNIQUE` (`transit_id`),
  UNIQUE KEY `city_UNIQUE` (`transit_city`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transit_hub`
--

INSERT INTO `transit_hub` (`transit_id`, `transit_city`,`address`, `geo_x`, `geo_y`) VALUES
(7, 'Αθήνα', 'Μπουμπουλίνας 25', 37.941220, 23.645425),
(8, 'Αλεξανδρούπολη', 'Λεωφ. Δημοκρατίας 320-328', 40.844915, 25.873930),
(1, 'Ηράκλειο', 'ΕΟ Ηρακλείου Φαιστού 24', 35.327223, 25.106518),
(6, 'Θεσσαλονίκη', 'Μοναστηρίου 130', 40.650034, 22.917211),
(4, 'Ιωάννινα', 'Παν. Κανελλόπουλου', 39.649420, 20.861545),
(2, 'Καλαμάτα', 'Αθηνών 117', 37.041044, 22.099247),
(5, 'Λάρισσα', 'Αστακού 10', 39.651999, 22.431938),
(9, 'Λέσβος', 'Σημαντήρη 133', 39.110327, 26.557471),
(3, 'Πάτρα', 'Ναυπάκτου 2', 38.297927, 21.782976);

-- --------------------------------------------------------


--
-- Table structure for table `hub_connections`
--
DROP TABLE IF EXISTS `hub_connections`;

CREATE TABLE `hub_connections` (
  `row_id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `hub_one` int(11) NOT NULL,
  `hub_two` int(11) NOT NULL,
  `time` int(2) UNSIGNED DEFAULT NULL,
  `money` float UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`row_id`),
  CONSTRAINT `hub_o_idx`
  FOREIGN KEY (`hub_one`)
  REFERENCES `our_site_db`.`transit_hub` (`transit_id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
  CONSTRAINT `hub_t_idx`
  FOREIGN KEY (`hub_two`)
  REFERENCES `our_site_db`.`transit_hub` (`transit_id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hub_connections`
--

INSERT INTO `hub_connections` (`row_id`, `hub_one`, `hub_two`, `time`, `money`) VALUES
(1, 1, 8, 1, 15),
(2, 1, 7, 1, 10),
(3, 1, 2, 2, 4),
(4, 2, 7, 1, 3),
(5, 2, 3, 1, 2),
(6, 3, 7, 1, 2),
(7, 3, 4, 1, 3),
(8, 4, 6, 1, 1),
(9, 5, 6, 1, 1),
(10, 5, 7, 1, 2),
(11, 6, 7, 1, 5),
(12, 6, 8, 1, 3),
(13, 7, 8, 1, 10),
(14, 7, 9, 1, 8);

-- --------------------------------------------------------

--
-- Table structure for table `store`
--
DROP TABLE IF EXISTS `store`;

CREATE TABLE `store` (
  `store_id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(45) NOT NULL,
  `route` varchar(45) NOT NULL,
  `route_number` varchar(45) NOT NULL,
  `TK` int(11) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `geo_x` decimal(8,6) DEFAULT NULL,
  `geo_y` decimal(8,6) DEFAULT NULL,
  `hub_id` int(11) NOT NULL,
  PRIMARY KEY (`store_id`),
  UNIQUE KEY `id_UNIQUE` (`store_id`),
--  UNIQUE KEY `phone_number_UNIQUE` (`phone_number`),
  CONSTRAINT `store_transit_hub_idx`
  FOREIGN KEY (`hub_id`)
  REFERENCES `our_site_db`.`transit_hub` (`transit_id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`store_id`, `city`, `route`, `route_number`, `TK`, `phone_number`, `geo_x`, `geo_y`, `hub_id`) VALUES
(1, 'Πάτρα', 'Πουκέβιλ', '12', 26223, '2610333977', 38.249750, 21.739226, 3),
(2, 'Πάτρα', 'Μαιζώνος', '84', 26221, '2610451100', 38.247101, 21.735580, 3),
(3, 'Αγρίνιο', 'Παπαστράτου', '84', 30100, '2641078961', 38.630718, 21.408701, 3),
(4, 'Ρέθυμνο', 'Γερασκάρη', '75', 74100, '2610451100', 35.366224, 24.478549, 1),
(5, 'Χανιά', 'Κυδωνίας', '14', 73136, '2610451100', 35.512425, 24.016643, 1),
(6, 'Κιάτο', 'Ελ. Βενιζέλου', '11', 20200, '2610451100', 38.014489, 22.746534, 7),
(7, 'Ηράκλειο', 'Σινά', '7', 71307, '2610451100', 35.338281, 25.144704, 1),
(8, 'Άγιος Νικόλαος', 'Δαβάκη', '18', 72100, '2610451100', 35.192385, 25.716938, 1),
(9, 'Καλαμάτα', 'Ύδρας', '66', 24100, '2610451100', 37.031863, 22.108208, 2),
(10, 'Πύργος', 'Αιόλου', '9', 27100, '2610451100', 37.672465, 21.440869, 3),
(11, 'Ιωάννινα', 'Ανεξαρτησίας', '162', 45444, '2610451100', 39.670684, 20.850234, 4),
(12, 'Θεσσαλονίκη', 'Εθ. Αμύνης', '2', 54621, '2610451100', 40.626724, 22.949294, 6),
(13, 'Λάρισσα', 'Μανδηλαρά', '15', 41222, '2610451100', 39.635370, 22.416305, 5),
(14, 'Έδεσσα', 'Αριστοτέλους', '26', 58200, '2610451100', 40.801396, 22.048190, 6),
(15, 'Αλεξανδρούπολη', 'Βισβύζη', '67', 68100, '2610451100', 40.846605, 25.870599, 8),
(16, 'Μυτιλήνη', 'Σαμπφούς', '57', 81100, '2610451100', 39.106373, 26.554890, 9),
(17, 'Αθήνα', 'Θήρας', '71Α', 11252, '2610451100', 38.002235, 23.729095, 7);

-- --------------------------------------------------------


--
-- Table structure for table `employee`
--
DROP TABLE IF EXISTS `employee`;

CREATE TABLE `employee` (
  `emp_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `surname` varchar(45) NOT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `working_store` int(11) DEFAULT NULL,
  `working_hub` int(11) DEFAULT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `work_type` enum('admin','cashier','hub') NOT NULL,
  PRIMARY KEY (`emp_id`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  CONSTRAINT `employee_store_idx`
  FOREIGN KEY (`working_store`)
  REFERENCES `our_site_db`.`store` (`store_id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE,
  CONSTRAINT `employee_hub_idx`
  FOREIGN KEY (`working_hub`)
  REFERENCES `our_site_db`.`transit_hub` (`transit_id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`emp_id`, `name`, `surname`, `gender`, `age`, `working_store`,`working_hub`, `username`, `password`, `work_type`) VALUES
(1, 'Ευθύμης', 'Κωστής', 'male', 22, DEFAULT, DEFAULT, 'kostis', 'kostis', 'admin'),
(2, 'Γιώργος', 'Καρτέρης', 'male', 22, DEFAULT, DEFAULT, 'karteris', 'karteris', 'admin'),
(3, 'Γιάννης', 'Μαλαπέρδας', 'male', 20, 1, DEFAULT,  'user3', 'user3', 'cashier'),
(4, 'Μπάμπης', 'Ματζαφλόκος', 'male', 30, 1, DEFAULT, 'user4', 'user4', 'cashier'),
(5, 'Χρήστος', 'Αποστόλου', 'male', 23, 2, DEFAULT, 'user5', 'user5', 'cashier'),
(6, 'Μιχάλης', 'Μέρκος', 'male', 26, 2, DEFAULT, 'user6', 'user6', 'cashier'),
(7, 'Νικόλαος', 'Παπαθανάσης', 'male', 26, 3, DEFAULT,'user7', 'user7', 'cashier'),
(8, 'Βασιλική', 'Δημητροπούλου', 'female', 28, 3, DEFAULT,'user8', 'user8', 'cashier'),
(9, 'Κωνσταντίνος', 'Τσουράπης', 'male', 34, 4, DEFAULT,'user9', 'user9', 'cashier'),
(10, 'Ιωάννης', 'Κατσαρής', 'male', 31, 4, DEFAULT,'user10', 'user10', 'cashier'),
(11, 'Ελένη', 'Σαμαρά', 'female', 30, 5, DEFAULT,'user11', 'user11', 'cashier'),
(12, 'Παναγιώτα', 'Συρώκου', 'female', 43, 5, DEFAULT,'user12', 'user12', 'cashier'),
(13, 'Γρηγόριος', 'Πεζούλας', 'male', 19, 6, DEFAULT,'user13', 'user13', 'cashier'),
(14, 'Βάγια', 'Βλαχογιάννη', 'female', 22, 6, DEFAULT,'user14', 'user14', 'cashier'),
(15, 'Μαρία', 'Κορδολαίμη', 'female', 23, DEFAULT, 1, 'user15', 'user15', 'hub'),
(16, 'Φώτιος', 'Σβόλης', 'male', 21, 7, DEFAULT,'user16', 'user16', 'cashier'),
(17, 'Ευάγγελος', 'Πατσαούρας', 'male', 22, 8, DEFAULT,'user17', 'user17', 'cashier'),
(18, 'Πέτρος', 'Κουτέρης', 'male', 24, 8, DEFAULT,'user18', 'user18', 'cashier'),
(19, 'Αθανάσιος', 'Πέττας', 'male', 28, DEFAULT, 2, 'user19', 'user19', 'hub'),
(20, 'Αφροδίτη', 'Τσιλιμέκη', 'female', 27, 9, DEFAULT,'user20', 'user20', 'cashier'),
(21, 'Αθανάσιος', 'Μαγιάννης', 'male', 36, 10, DEFAULT,'user21', 'user21', 'cashier'),
(22, 'Γιώργιος', 'Κοκώσης', 'male', 34, 10, DEFAULT,'user22', 'user22', 'cashier'),
(23, 'Δημήτριος', 'Μπαρμπούτης', 'male', 32, 11, DEFAULT,'user23', 'user23', 'cashier'),
(24, 'Αλέξανδρος', 'Μωρός', 'male', 31, DEFAULT, 4, 'user24', 'user24', 'hub'),
(25, 'Παντελής', 'Γκιάτης', 'male', 18, DEFAULT, 6, 'user25', 'user25', 'hub'),
(26, 'Στέλιος', 'Σαράκης', 'male', 47, 12, DEFAULT,'user26', 'user26', 'cashier'),
(27, 'Γεώργιος', 'Μπαλώτης', 'male', 32, DEFAULT, 5, 'user27', 'user27', 'hub'),
(28, 'Γεώργιος', 'Ζαμπάρας', 'male', 32, 13, DEFAULT,'user28', 'user28', 'cashier'),
(29, 'Γεράσιμος', 'Τασιούλης', 'male', 31, 14, DEFAULT,'user29', 'user29', 'cashier'),
(30, 'Ιωάννης', 'Σωτηρόπουλος', 'male', 34, 14, DEFAULT,'user30', 'user30', 'cashier'),
(31, 'Χρήστος', 'Ζαφείρης', 'male', 46, 15, DEFAULT,'user31', 'user31', 'cashier'),
(32, 'Μιχάλης', 'Χριστοδούλου', 'male', 32, DEFAULT, 8, 'user32', 'user32', 'hub'),
(33, 'Φώτιος', 'Μπάδας', 'male', 36, DEFAULT, 9, 'user33', 'user33', 'hub'),
(34, 'Παναγιώτης', 'Μάλαινος', 'male', 19, 16, DEFAULT,'user34', 'user34', 'cashier'),
(35, 'Ευαγγελία', 'Μουλοκώστα', 'female', 23, 17, DEFAULT,'user35', 'user35', 'cashier'),
(36, 'Παναγιώτης', 'Τσιρώνης', 'male', 21, DEFAULT, 7, 'user36', 'user36', 'hub'),
(37, 'Άγγελος', 'Κωστόπουλος', 'male', 26, 17, DEFAULT,'user37', 'user37', 'cashier'),
(38, 'Σταύρος', 'Ηλιόπουλος', 'male', 27, DEFAULT, 3, 'user38', 'user38', 'hub'),
(39, 'Ελένη', 'Ηλιοπούλου', 'female', 28, 1, DEFAULT,'user39', 'user39', 'cashier'),
(40, 'Σπύρος', 'Μαστρογεωργίου', 'male', 21, 2, DEFAULT,'user40', 'user40', 'cashier'),
(41, 'Ιωάννα', 'Κορμούση', 'female', 20, 2, DEFAULT,'user41', 'user41', 'cashier');

-- --------------------------------------------------------


--
-- Table structure for table `box`
--
DROP TABLE IF EXISTS `box`;

CREATE TABLE `box` (
  `box_id` int(11) NOT NULL AUTO_INCREMENT,
  `tracking_number` varchar(50) DEFAULT NULL,
  `name_sender` varchar(45) DEFAULT NULL,
  `name_receiver` varchar(45) DEFAULT NULL,
  `route_receiver` varchar(45) DEFAULT NULL,
  `starting_store_id` int(11) NOT NULL,
  `final_store_id` int(11) NOT NULL,
  `delivery_type` enum('express','regular') NOT NULL,
  `cost` int(11) DEFAULT NULL,
  `delivered` enum('no','yes') NOT NULL,
  `hub_check_1` varchar(50) DEFAULT NULL,
  `hub_check_2` varchar(50) DEFAULT NULL,
  `hub_check_3` varchar(50) DEFAULT NULL,
  `hub_check_4` varchar(50) DEFAULT NULL,
  `hub_check_5` varchar(50) DEFAULT NULL,
  `hub_check_6` varchar(50) DEFAULT NULL,
  `hub_check_7` varchar(50) DEFAULT NULL,
  `hub_check_8` varchar(50) DEFAULT NULL,
  `hub_check_9` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`box_id`),
  UNIQUE KEY `idbox_UNIQUE` (`box_id` ASC),
  UNIQUE KEY `trackbox_UNIQUE` (`tracking_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



-- --------------------------------------------------------

--
-- Table structure for table `box_hub_check_transportation`
--
DROP TABLE IF EXISTS `box_hub_check_transportation`;

CREATE TABLE `box_hub_check_transportation` (
  `box_id` int(11) NOT NULL ,
  `cur_check_1` int(2) DEFAULT NULL,
  `cur_check_2` int(2) DEFAULT NULL,
  `cur_check_3` int(2) DEFAULT NULL,
  `cur_check_4` int(2) DEFAULT NULL,
  `cur_check_5` int(2) DEFAULT NULL,
  `cur_check_6` int(2) DEFAULT NULL,
  `cur_check_7` int(2) DEFAULT NULL,
  `cur_check_8` int(2) DEFAULT NULL,
  `cur_check_9` int(2) DEFAULT NULL,
  PRIMARY KEY (`box_id`),
  UNIQUE KEY `idbox_UNIQUE` (`box_id` ASC),
  CONSTRAINT `box_id_2_idx`
  FOREIGN KEY (`box_id`)
  REFERENCES `our_site_db`.`box` (`box_id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



--
-- Table structure for table `box_history_transportation`
--
DROP TABLE IF EXISTS `box_history_transportation`;

CREATE TABLE `box_history_transportation` (
  `box_id` int(11) NOT NULL ,
  `dest_1` int(2) DEFAULT NULL,
  `dest_2` int(2) DEFAULT NULL,
  `dest_3` int(2) DEFAULT NULL,
  `dest_4` int(2) DEFAULT NULL,
  `dest_5` int(2) DEFAULT NULL,
  `dest_6` int(2) DEFAULT NULL,
  `dest_7` int(2) DEFAULT NULL,
  `dest_8` int(2) DEFAULT NULL,
  `dest_9` int(2) DEFAULT NULL,
  PRIMARY KEY (`box_id`),
  UNIQUE KEY `idbox_UNIQUE` (`box_id` ASC),
  CONSTRAINT `box_id_idx`
  FOREIGN KEY (`box_id`)
  REFERENCES `our_site_db`.`box` (`box_id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;