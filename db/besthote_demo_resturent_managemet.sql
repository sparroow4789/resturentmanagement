-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 28, 2021 at 12:02 AM
-- Server version: 5.7.36-log-cll-lve
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `besthote_demo_resturent_managemet`
--

-- --------------------------------------------------------

--
-- Table structure for table `grocery_bill_details`
--

CREATE TABLE `grocery_bill_details` (
  `grocery_bill_id` int(11) NOT NULL,
  `grocery_name` mediumtext,
  `grocery_bill_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grocery_bill_details`
--

INSERT INTO `grocery_bill_details` (`grocery_bill_id`, `grocery_name`, `grocery_bill_datetime`) VALUES
(1, 'test shop', '2021-10-13 16:46:49'),
(2, 'test 1 shop', '2021-10-18 14:36:36'),
(3, 'test shop', '2021-10-19 12:07:57');

-- --------------------------------------------------------

--
-- Table structure for table `grocery_bill_item`
--

CREATE TABLE `grocery_bill_item` (
  `grocery_bill_item_id` int(11) NOT NULL,
  `grocery_bill_id` varchar(255) DEFAULT NULL,
  `grocery_item_id` varchar(255) DEFAULT NULL,
  `stock` varchar(255) DEFAULT NULL,
  `cost` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `grocery_bill_item`
--

INSERT INTO `grocery_bill_item` (`grocery_bill_item_id`, `grocery_bill_id`, `grocery_item_id`, `stock`, `cost`) VALUES
(1, '1', '1', '10', '5000'),
(2, '1', '2', '5', '1500'),
(3, '2', '1', '5', '1000'),
(4, '2', '2', '10', '2100'),
(5, '3', '1', '10', '1500'),
(6, '3', '2', '5', '2000');

-- --------------------------------------------------------

--
-- Table structure for table `grocery_item`
--

CREATE TABLE `grocery_item` (
  `grocery_item_id` int(11) NOT NULL,
  `grocery_item_name` mediumtext,
  `item_unit_type` varchar(20) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `grocery_item_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grocery_item`
--

INSERT INTO `grocery_item` (`grocery_item_id`, `grocery_item_name`, `item_unit_type`, `quantity`, `grocery_item_datetime`) VALUES
(1, 'Samba Rice', 'kg', '19', '2021-10-12 20:19:43'),
(2, 'Carrot', 'kg', '25', '2021-10-13 11:10:07');

-- --------------------------------------------------------

--
-- Table structure for table `grocery_kitchen_item`
--

CREATE TABLE `grocery_kitchen_item` (
  `grocery_kitchen_item_id` int(11) NOT NULL,
  `grocery_item_id` varchar(255) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `grocery_kitchen_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grocery_kitchen_item`
--

INSERT INTO `grocery_kitchen_item` (`grocery_kitchen_item_id`, `grocery_item_id`, `quantity`, `grocery_kitchen_datetime`) VALUES
(1, '1', '4', '2021-10-12 21:17:56'),
(2, '1', '1', '2021-10-12 21:18:18'),
(3, '1', '1', '2021-10-12 22:05:10'),
(4, '1', '10', '2021-10-18 14:37:11'),
(5, '1', '10', '2021-10-19 12:09:13'),
(6, '1', '1', '2021-10-28 13:11:37');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_details`
--

CREATE TABLE `invoice_details` (
  `invoice_details_id` int(11) NOT NULL,
  `resturent_table_id` varchar(255) DEFAULT NULL,
  `payment_status` varchar(3) DEFAULT NULL,
  `invoice_type` varchar(3) DEFAULT NULL,
  `waiter_id` varchar(3) DEFAULT NULL,
  `discount` varchar(255) DEFAULT NULL,
  `invoice_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice_details`
--

INSERT INTO `invoice_details` (`invoice_details_id`, `resturent_table_id`, `payment_status`, `invoice_type`, `waiter_id`, `discount`, `invoice_datetime`) VALUES
(1, '1', '2', '1', '1', '0', '2021-10-18 15:53:41'),
(2, '6', '2', '1', '1', '0', '2021-10-18 15:54:57'),
(3, '1', '2', '1', '1', '2', '2021-10-18 16:06:45'),
(4, '2', '2', '1', '1', '0', '2021-10-19 12:11:00'),
(6, '5', '2', '1', '1', '0', '2021-10-24 01:10:53'),
(7, '1', '2', '1', '1', '0', '2021-10-27 14:35:41'),
(8, '1', '2', '1', '1', '0', '2021-10-27 17:31:25'),
(9, NULL, '2', '2', NULL, '0', '2021-10-27 20:56:43'),
(17, NULL, '2', '2', NULL, '0', '2021-11-01 21:43:40'),
(18, NULL, '2', '2', NULL, '0', '2021-11-01 21:46:14'),
(19, NULL, '2', '2', NULL, '0', '2021-11-01 21:55:21'),
(20, '1', '2', '1', '1', '0', '2021-11-01 21:59:12'),
(27, '1', '2', '1', '1', '0', '2021-11-02 02:02:48'),
(28, '7', '2', '1', '1', '0', '2021-11-02 02:17:38'),
(29, '1', '2', '1', '1', '0', '2021-11-02 11:19:20'),
(30, NULL, '2', '2', NULL, '0', '2021-11-02 11:33:43'),
(33, '1', '2', '1', '1', '0', '2021-11-02 12:58:59'),
(34, '1', '2', '1', '1', '0', '2021-11-02 13:00:42'),
(36, '1', '2', '1', '1', '0', '2021-11-02 20:09:30'),
(37, '1', '2', '1', '1', '0', '2021-11-02 20:10:05'),
(39, '1', '2', '1', '1', '5', '2021-11-16 10:27:31'),
(40, NULL, '2', '2', NULL, '0', '2021-12-24 15:45:10'),
(41, '1', '0', '1', '1', '0', '2021-12-27 15:46:56'),
(42, '2', '2', '1', '1', '0', '2021-12-27 16:00:04'),
(43, '5', '1', '1', '1', '0', '2021-12-27 16:10:56'),
(44, NULL, '2', '2', NULL, '0', '2021-12-27 16:25:58'),
(45, '6', '1', '1', '1', '0', '2021-12-27 17:03:24'),
(46, NULL, '2', '2', NULL, '0', '2021-12-27 17:11:27'),
(47, NULL, '2', '2', NULL, '0', '2021-12-27 23:52:20');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_product`
--

CREATE TABLE `invoice_product` (
  `invoice_product_id` int(11) NOT NULL,
  `invoice_id` varchar(3) DEFAULT NULL,
  `product_badge_id` varchar(3) DEFAULT NULL,
  `product_quantity` varchar(3) DEFAULT NULL,
  `invoice_product_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice_product`
--

INSERT INTO `invoice_product` (`invoice_product_id`, `invoice_id`, `product_badge_id`, `product_quantity`, `invoice_product_datetime`) VALUES
(1, '3', '11', '6', '2021-10-27 04:56:53'),
(3, '3', '14', '4', '2021-10-27 06:44:26'),
(4, '4', '13', '3', '2021-10-27 10:02:29'),
(5, '3', '12', '5', '2021-10-27 04:57:45'),
(6, '3', '13', '5', '2021-10-27 06:59:52'),
(9, '6', '13', '1', '2021-10-23 20:42:14'),
(10, '6', '9', '1', '2021-10-23 20:42:25'),
(12, '3', '9', '4', '2021-10-24 18:26:07'),
(13, '2', '13', '1', '2021-10-27 06:56:13'),
(14, '4', '9', '2', '2021-10-27 10:02:23'),
(15, '4', '14', '3', '2021-10-27 10:11:17'),
(16, '7', '13', '1', '2021-10-27 09:05:50'),
(17, '7', '10', '1', '2021-10-27 09:05:54'),
(18, '4', '11', '2', '2021-10-27 10:11:13'),
(19, '4', '3', '2', '2021-10-27 10:02:39'),
(20, '4', '12', '1', '2021-10-27 10:11:15'),
(21, '8', '13', '1', '2021-10-27 12:01:38'),
(22, '8', '11', '1', '2021-10-27 12:01:44'),
(25, '9', '13', '1', '2021-10-27 15:42:41'),
(26, '9', '14', '2', '2021-10-27 15:42:50'),
(27, '9', '11', '2', '2021-10-27 15:42:49'),
(31, '17', '13', '2', '2021-11-01 16:13:46'),
(32, '17', '12', '3', '2021-11-01 16:13:57'),
(33, '17', '3', '1', '2021-11-01 16:14:00'),
(34, '18', '13', '2', '2021-11-01 16:16:26'),
(35, '18', '10', '1', '2021-11-01 16:16:19'),
(36, '18', '11', '2', '2021-11-01 16:16:33'),
(37, '18', '12', '1', '2021-11-01 16:16:31'),
(38, '19', '13', '1', '2021-11-01 16:25:48'),
(39, '19', '10', '3', '2021-11-01 16:25:59'),
(40, '19', '9', '1', '2021-11-01 16:25:52'),
(41, '20', '13', '1', '2021-11-01 16:29:56'),
(42, '20', '10', '2', '2021-11-01 16:29:59'),
(53, '27', '13', '1', '2021-11-01 20:32:54'),
(54, '27', '15', '1', '2021-11-01 20:32:58'),
(55, '28', '13', '1', '2021-11-01 21:01:24'),
(56, '28', '15', '1', '2021-11-01 21:01:27'),
(57, '28', '3', '1', '2021-11-01 21:01:30'),
(58, '29', '9', '1', '2021-11-02 05:55:02'),
(59, '30', '3', '1', '2021-11-02 06:07:52'),
(60, '33', '16', '3', '2021-11-02 07:29:52'),
(61, '33', '15', '3', '2021-11-02 07:29:48'),
(62, '34', '15', '1', '2021-11-02 07:30:54'),
(63, '36', '16', '3', '2021-11-02 14:40:20'),
(64, '36', '9', '1', '2021-11-02 14:40:35'),
(65, '37', '13', '1', '2021-12-24 09:15:48'),
(66, '37', '9', '1', '2021-12-24 09:15:51'),
(67, '37', '10', '1', '2021-12-24 09:15:54'),
(68, '40', '13', '1', '2021-12-27 05:50:02'),
(69, '40', '9', '1', '2021-12-27 05:50:05'),
(70, '40', '11', '2', '2021-12-27 05:50:35'),
(74, '39', '9', '2', '2021-12-27 10:22:06'),
(75, '39', '13', '1', '2021-12-27 10:22:11'),
(76, '42', '3', '1', '2021-12-27 10:31:03'),
(77, '42', '15', '1', '2021-12-27 10:31:09'),
(78, '42', '13', '1', '2021-12-27 10:31:13'),
(79, '42', '9', '1', '2021-12-27 10:31:16'),
(80, '43', '10', '1', '2021-12-27 10:41:08'),
(81, '43', '15', '1', '2021-12-27 10:41:12'),
(82, '43', '12', '1', '2021-12-27 10:41:15'),
(83, '44', '9', '1', '2021-12-27 10:59:01'),
(84, '44', '13', '1', '2021-12-27 10:59:17'),
(85, '45', '13', '2', '2021-12-27 11:36:06'),
(86, '45', '9', '3', '2021-12-27 11:36:11'),
(87, '46', '13', '2', '2021-12-27 11:43:55'),
(88, '46', '15', '2', '2021-12-27 11:43:52'),
(89, '46', '14', '4', '2021-12-27 11:42:44'),
(90, '46', '3', '2', '2021-12-27 11:41:54'),
(91, '47', '13', '1', '2021-12-27 18:23:22'),
(92, '47', '9', '1', '2021-12-27 18:23:24'),
(93, '47', '16', '1', '2021-12-27 18:23:30'),
(94, '47', '14', '1', '2021-12-27 18:23:32');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_save`
--

CREATE TABLE `invoice_save` (
  `invoice_save_id` int(11) NOT NULL,
  `invoice_id` varchar(255) DEFAULT NULL,
  `invoice_waiter_id` varchar(255) DEFAULT NULL,
  `subtotal` varchar(255) DEFAULT NULL,
  `service_charge` varchar(255) DEFAULT NULL,
  `discount` varchar(255) DEFAULT NULL,
  `grand_total` varchar(255) DEFAULT NULL,
  `invoice_save_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice_save`
--

INSERT INTO `invoice_save` (`invoice_save_id`, `invoice_id`, `invoice_waiter_id`, `subtotal`, `service_charge`, `discount`, `grand_total`, `invoice_save_datetime`) VALUES
(1, '3', '1', '9040', '904', '180.8', '9763.2', '2021-10-27 13:37:15'),
(2, '7', '1', '1350', '135', '0', '1485', '2021-10-27 14:36:01'),
(3, '4', '1', '5160', '516', '0', '5676', '2021-10-27 15:41:20'),
(4, '6', '1', '1250', '125', '0', '1375', '2021-10-27 16:59:08'),
(5, '2', '1', '350', '35', '0', '385', '2021-10-27 16:59:18'),
(7, '9', NULL, '1680', '0', '0', '1680', '2021-10-27 21:12:54'),
(8, '8', '1', '415', '41.5', '0', '456.5', '2021-10-28 12:38:56'),
(9, '17', NULL, '1340', '0', '0', '1340', '2021-11-01 21:45:28'),
(10, '18', NULL, '2010', '0', '0', '2010', '2021-11-01 21:46:36'),
(11, '19', NULL, '4250', '0', '0', '4250', '2021-11-01 21:56:04'),
(12, '20', '1', '2350', '235', '0', '2585', '2021-11-01 22:02:07'),
(13, '28', '1', '550', '55', '0', '605', '2021-11-02 02:31:35'),
(14, '27', '1', '450', '45', '0', '495', '2021-11-02 02:31:47'),
(15, '29', '1', '900', '90', '0', '990', '2021-11-02 11:25:30'),
(16, '30', NULL, '100', '0', '0', '100', '2021-11-02 11:37:56'),
(17, '33', '1', '510', '51', '0', '561', '2021-11-02 13:00:00'),
(18, '34', '1', '100', '10', '0', '110', '2021-11-02 13:09:13'),
(19, '36', '1', '1110', '111', '0', '1221', '2021-11-02 20:11:09'),
(20, '37', '1', '2250', '225', '0', '2475', '2021-12-24 14:46:03'),
(21, '40', NULL, '1380', '0', '0', '1380', '2021-12-27 11:21:26'),
(22, '39', '1', '2150', '215', '0', '2365', '2021-12-27 15:52:59'),
(23, '42', '1', '1450', '145', '0', '1595', '2021-12-27 16:01:32'),
(24, '43', '1', '1280', '128', '0', '1408', '2021-12-27 16:11:35'),
(25, '44', NULL, '1250', '0', '0', '1250', '2021-12-27 17:02:40'),
(26, '45', '1', '3400', '340', '0', '3740', '2021-12-27 17:11:10'),
(27, '46', NULL, '3500', '0', '0', '3500', '2021-12-27 17:13:59'),
(28, '47', NULL, '1920', '0', '0', '1920', '2021-12-27 23:53:38');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_save_product`
--

CREATE TABLE `invoice_save_product` (
  `invoice_save_product_id` int(11) NOT NULL,
  `invoice_id` varchar(255) DEFAULT NULL,
  `product_badge_id` varchar(255) DEFAULT NULL,
  `product_details` mediumtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice_save_product`
--

INSERT INTO `invoice_save_product` (`invoice_save_product_id`, `invoice_id`, `product_badge_id`, `product_details`) VALUES
(1, '3', '11', '1,Sprite - Mediam,65.00,6,390'),
(2, '3', '14', '2,New Product - Regular,600.00,4,2400'),
(3, '3', '12', '3,Sprite - Large,180.00,5,900'),
(4, '3', '13', '4,test999 - Regular,350.00,5,1750'),
(5, '3', '9', '5,Chicken Drums - Mediam,900.00,4,3600'),
(6, '7', '13', '1,test999 - Regular,350.00,1,350'),
(7, '7', '10', '2,Chicken Drums - Large,1,000.00,1,1000'),
(8, '4', '13', '1,test999 - Regular,350.00,3,1050'),
(9, '4', '9', '2,Chicken Drums - Mediam,900.00,2,1800'),
(10, '4', '14', '3,New Product - Regular,600.00,3,1800'),
(11, '4', '11', '4,Sprite - Mediam,65.00,2,130'),
(12, '4', '3', '5,Coke - Mediam,100.00,2,200'),
(13, '4', '12', '6,Sprite - Large,180.00,1,180'),
(14, '6', '13', '1,test999 - Regular,350.00,1,350'),
(15, '6', '9', '2,Chicken Drums - Mediam,900.00,1,900'),
(16, '2', '13', '1,test999 - Regular,350.00,1,350'),
(17, '9', '13', '1,test999 - Regular,350.00,1,350'),
(18, '9', '11', '2,Sprite - Mediam,65.00,1,65'),
(19, '9', '13', '1,test999 - Regular,350.00,1,350'),
(20, '9', '14', '2,New Product - Regular,600.00,2,1200'),
(21, '9', '11', '3,Sprite - Mediam,65.00,2,130'),
(22, '8', '13', '1,test999 - Regular,350.00,1,350'),
(23, '8', '11', '2,Sprite - Mediam,65.00,1,65'),
(24, '17', '13', '1,test999 - Regular,350.00,2,700'),
(25, '17', '12', '2,Sprite - Large,180.00,3,540'),
(26, '17', '3', '3,Coke - Mediam,100.00,1,100'),
(27, '18', '13', '1,test999 - Regular,350.00,2,700'),
(28, '18', '10', '2,Chicken Drums - Large,1000,1,1000'),
(29, '18', '11', '3,Sprite - Mediam,65.00,2,130'),
(30, '18', '12', '4,Sprite - Large,180.00,1,180'),
(31, '19', '13', '1,test999 - Regular,350,1,350'),
(32, '19', '10', '2,Chicken Drums - Large,1000,3,3000'),
(33, '19', '9', '3,Chicken Drums - Mediam,900,1,900'),
(34, '20', '13', '1,test999 - Regular,350,1,350'),
(35, '20', '10', '2,Chicken Drums - Large,1000,2,2000'),
(36, '28', '13', '1,test999 - Regular,350,1,350'),
(37, '28', '15', '2,Coffee - Mediam,100,1,100'),
(38, '28', '3', '3,Coke - Mediam,100,1,100'),
(39, '27', '13', '1,test999 - Regular,350,1,350'),
(40, '27', '15', '2,Coffee - Mediam,100,1,100'),
(41, '29', '9', '1,Chicken Drums - Mediam,900,1,900'),
(42, '30', '3', '1,Coke - Mediam,100,1,100'),
(43, '33', '16', '1,Tea - Mediam,70,3,210'),
(44, '33', '15', '2,Coffee - Mediam,100,3,300'),
(45, '34', '15', '1,Coffee - Mediam,100,1,100'),
(46, '36', '16', '1,Tea - Mediam,70,3,210'),
(47, '36', '9', '2,Chicken Drums - Mediam,900,1,900'),
(48, '37', '13', '1,test999 - Regular,350,1,350'),
(49, '37', '9', '2,Chicken Drums - Mediam,900,1,900'),
(50, '37', '10', '3,Chicken Drums - Large,1000,1,1000'),
(51, '40', '13', '1,test999 - Regular,350,1,350'),
(52, '40', '9', '2,Chicken Drums - Mediam,900,1,900'),
(53, '40', '11', '3,Sprite - Mediam,65,2,130'),
(54, '39', '9', '1,Chicken Drums - Mediam,900,2,1800'),
(55, '39', '13', '2,test999 - Regular,350,1,350'),
(56, '42', '3', '1,Coke - Mediam,100,1,100'),
(57, '42', '15', '2,Coffee - Mediam,100,1,100'),
(58, '42', '13', '3,test999 - Regular,350,1,350'),
(59, '42', '9', '4,Chicken Drums - Mediam,900,1,900'),
(60, '43', '10', '1,Chicken Drums - Large,1000,1,1000'),
(61, '43', '15', '2,Coffee - Mediam,100,1,100'),
(62, '43', '12', '3,Sprite - Large,180,1,180'),
(63, '44', '9', '1,Chicken Drums - Mediam,900,1,900'),
(64, '44', '13', '2,test999 - Regular,350,1,350'),
(65, '45', '13', '1,test999 - Regular,350,2,700'),
(66, '45', '9', '2,Chicken Drums - Mediam,900,3,2700'),
(67, '46', '13', '1,test999 - Regular,350,2,700'),
(68, '46', '15', '2,Coffee - Mediam,100,2,200'),
(69, '46', '14', '3,New Product - Regular,600,4,2400'),
(70, '46', '3', '4,Coke - Mediam,100,2,200'),
(71, '47', '13', '1,test999 - Regular,350,1,350'),
(72, '47', '9', '2,Chicken Drums - Mediam,900,1,900'),
(73, '47', '16', '3,Tea - Mediam,70,1,70'),
(74, '47', '14', '4,New Product - Regular,600,1,600');

-- --------------------------------------------------------

--
-- Table structure for table `product_badge_details`
--

CREATE TABLE `product_badge_details` (
  `product_badge_id` int(11) NOT NULL,
  `product_name_id` varchar(255) DEFAULT NULL,
  `product_badge_label` mediumtext,
  `cost_price` varchar(255) DEFAULT NULL,
  `selling_price` varchar(255) DEFAULT NULL,
  `enable_stat` varchar(50) DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `product_badge_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_badge_details`
--

INSERT INTO `product_badge_details` (`product_badge_id`, `product_name_id`, `product_badge_label`, `cost_price`, `selling_price`, `enable_stat`, `quantity`, `product_badge_datetime`) VALUES
(3, '1', 'Mediam', '90', '100', '1', '3', '2021-10-12 00:15:15'),
(8, '1', 'Large', '180', '200', '1', '0', '2021-10-12 02:51:20'),
(9, '2', 'Mediam', '600', '900', '0', NULL, '2021-10-12 02:53:15'),
(10, '2', 'Large', '800', '1000', '0', NULL, '2021-10-12 02:57:24'),
(11, '3', 'Mediam', '60', '65', '1', '84', '2021-10-18 21:10:22'),
(12, '3', 'Large', '150', '180', '1', '9', '2021-10-18 21:10:59'),
(13, '5', 'Regular', '300', '350', '0', NULL, '2021-10-18 21:11:23'),
(14, '4', 'Regular', '500', '600', '0', NULL, '2021-10-18 21:11:57'),
(15, '6', 'Mediam', '60', '100', '0', NULL, '2021-11-02 01:14:20'),
(16, '7', 'Mediam', '50', '70', '0', NULL, '2021-11-02 01:15:45');

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `category_id` int(11) NOT NULL,
  `category` mediumtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`category_id`, `category`) VALUES
(1, 'Portion'),
(2, 'Hot Beverage'),
(3, 'Cold Beverage');

-- --------------------------------------------------------

--
-- Table structure for table `product_details`
--

CREATE TABLE `product_details` (
  `product_id` int(11) NOT NULL,
  `product_name` mediumtext,
  `product_code` varchar(255) DEFAULT NULL,
  `product_details` mediumtext,
  `product_category` varchar(255) DEFAULT NULL,
  `prep_time` varchar(255) DEFAULT NULL,
  `calories` varchar(255) DEFAULT NULL,
  `product_img` varchar(255) DEFAULT NULL,
  `stat` varchar(3) DEFAULT NULL,
  `product_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_details`
--

INSERT INTO `product_details` (`product_id`, `product_name`, `product_code`, `product_details`, `product_category`, `prep_time`, `calories`, `product_img`, `stat`, `product_datetime`) VALUES
(1, 'Coke', '1SD5DX', 'seg d dsg sdg dZG\r\nhdf hf hdzfh ', 'Hot Beverage', '5 Min', '13kCal', '1633974846.JPEG', '1', '2021-10-11 23:24:06'),
(2, 'Chicken Drums', 'ZSXF521', 'Good Product', 'Portion', '20 Min', '2KCAL', '1633987344.jpg', '1', '2021-10-12 02:52:24'),
(3, 'Sprite', 'DFE215DRF', 'ng ds gds\r\nsg dg ds', 'Hot Beverage', '-', '13kCal', '1634571381.jpg', '1', '2021-10-18 21:06:21'),
(4, 'New Product', 'DFE2251ygrf', 'jhdgjhdfg', 'Hot Beverage', '-', '13kCal', '1634571549.PNG', '1', '2021-10-18 21:09:09'),
(5, 'test999', 'DZZZDS56S', 'hdh dfh dfh', 'Portion', '10 Min', '13kCal', '1634571579.PNG', '1', '2021-10-18 21:09:39'),
(6, 'Coffee', 'fdshfdsh', 'gsgsdg', 'Hot Beverage', '10 Min', '15KCAL', '1635795828.jpg', '1', '2021-11-02 01:13:48'),
(7, 'Tea', 'HGHJ98DS', 'bdf hfdh df h', 'Hot Beverage', '5 Min', '13kCal', '1635795931.jpg', '1', '2021-11-02 01:15:31');

-- --------------------------------------------------------

--
-- Table structure for table `product_stock_history`
--

CREATE TABLE `product_stock_history` (
  `product_stock_history_id` int(11) NOT NULL,
  `product_badge_id` varchar(255) DEFAULT NULL,
  `product_quantity` varchar(255) DEFAULT NULL,
  `product_cost` varchar(255) DEFAULT NULL,
  `product_selling` varchar(255) DEFAULT NULL,
  `stock_history_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_stock_history`
--

INSERT INTO `product_stock_history` (`product_stock_history_id`, `product_badge_id`, `product_quantity`, `product_cost`, `product_selling`, `stock_history_datetime`) VALUES
(1, '8', '5', '180', '200', '2021-10-12 12:18:03'),
(2, '8', '2', '180', '200', '2021-10-12 12:18:46'),
(3, '3', '10', '90', '100', '2021-10-12 12:19:33'),
(4, '11', '100', '60', '65', '2021-10-18 21:12:16'),
(5, '12', '20', '150', '180', '2021-10-18 21:12:22');

-- --------------------------------------------------------

--
-- Table structure for table `resturent_table`
--

CREATE TABLE `resturent_table` (
  `resturent_table_id` int(11) NOT NULL,
  `resturent_type_id` varchar(255) DEFAULT NULL,
  `resturent_table_number` varchar(255) DEFAULT NULL,
  `resturent_table_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `resturent_table`
--

INSERT INTO `resturent_table` (`resturent_table_id`, `resturent_type_id`, `resturent_table_number`, `resturent_table_datetime`) VALUES
(1, '1', '01', '2021-10-18 12:51:09'),
(2, '1', '02', '2021-10-18 12:51:13'),
(5, '1', '03', '2021-10-18 12:54:32'),
(6, '1', '04', '2021-10-18 12:54:36'),
(7, '2', '01', '2021-11-02 01:35:04');

-- --------------------------------------------------------

--
-- Table structure for table `resturent_table_availability`
--

CREATE TABLE `resturent_table_availability` (
  `table_availability_id` int(11) NOT NULL,
  `resturent_table_id` varchar(255) DEFAULT NULL,
  `availability` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `resturent_table_availability`
--

INSERT INTO `resturent_table_availability` (`table_availability_id`, `resturent_table_id`, `availability`) VALUES
(1, '1', '0'),
(2, '2', '0'),
(5, '5', '1'),
(6, '6', '1'),
(7, '7', '0');

-- --------------------------------------------------------

--
-- Table structure for table `resturent_type`
--

CREATE TABLE `resturent_type` (
  `resturent_type_id` int(11) NOT NULL,
  `resturent_name` varchar(255) DEFAULT NULL,
  `resturent_place` varchar(255) DEFAULT NULL,
  `resturent_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `resturent_type`
--

INSERT INTO `resturent_type` (`resturent_type_id`, `resturent_name`, `resturent_place`, `resturent_datetime`) VALUES
(1, 'Test 1', 'Inside', '2021-10-18 12:50:54'),
(2, 'Test 2', 'Outside', '2021-10-18 12:51:04');

-- --------------------------------------------------------

--
-- Table structure for table `service_charge`
--

CREATE TABLE `service_charge` (
  `service_charge_id` int(11) NOT NULL,
  `service_charge_price` varchar(255) DEFAULT NULL,
  `service_charge_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service_charge`
--

INSERT INTO `service_charge` (`service_charge_id`, `service_charge_price`, `service_charge_datetime`) VALUES
(1, '10', '2021-10-24 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `todo`
--

CREATE TABLE `todo` (
  `todo_id` int(11) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `subject` mediumtext,
  `todo_message` mediumtext,
  `todo_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `todo`
--

INSERT INTO `todo` (`todo_id`, `user_id`, `subject`, `todo_message`, `todo_datetime`) VALUES
(1, '2', 'test', 'test 1', '2021-10-15 13:23:51'),
(2, '2', '2222', 'fdsg dsg dsg sd sd ', '2021-10-15 13:26:21'),
(3, '2', 'gsfdg sdgsd', 'hrd jhdh dfh ', '2021-10-15 13:26:29'),
(4, '2', 'ndf', 'nbdfndf', '2021-10-28 12:07:48'),
(5, '2', 'fsfa', 'afsfaf', '2021-11-02 01:08:17');

-- --------------------------------------------------------

--
-- Table structure for table `users_login`
--

CREATE TABLE `users_login` (
  `user_id` int(3) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(3) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_login`
--

INSERT INTO `users_login` (`user_id`, `name`, `email`, `password`, `role`, `tel`, `create_date`) VALUES
(1, 'Admin', 'admin@mail.com', '$2y$10$A93HZpfy53BhOpNkEhA1/uQii9sGDHQ4g7pNs5chssb/oTPH67csK', '1', '0771188218', '2021-06-23 06:22:17'),
(2, 'Demo Name', 'demo@mail.com', '$2y$10$Ebvmz9shKZwPEJ4HY0luOuUciSnU/XyLH7UCQeVbb1AdYgu6OL762', '1', '0771188218', '2021-06-23 06:24:54');

-- --------------------------------------------------------

--
-- Table structure for table `users_profile_pic`
--

CREATE TABLE `users_profile_pic` (
  `users_profile_pic_id` int(11) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `profile_pic_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_profile_pic`
--

INSERT INTO `users_profile_pic` (`users_profile_pic_id`, `user_id`, `profile_image`, `profile_pic_datetime`) VALUES
(2, '9', '1624183565.jpg', '0000-00-00 00:00:00'),
(3, '2', '1634322791.jpg', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `grocery_bill_details`
--
ALTER TABLE `grocery_bill_details`
  ADD PRIMARY KEY (`grocery_bill_id`);

--
-- Indexes for table `grocery_bill_item`
--
ALTER TABLE `grocery_bill_item`
  ADD PRIMARY KEY (`grocery_bill_item_id`);

--
-- Indexes for table `grocery_item`
--
ALTER TABLE `grocery_item`
  ADD PRIMARY KEY (`grocery_item_id`);

--
-- Indexes for table `grocery_kitchen_item`
--
ALTER TABLE `grocery_kitchen_item`
  ADD PRIMARY KEY (`grocery_kitchen_item_id`);

--
-- Indexes for table `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD PRIMARY KEY (`invoice_details_id`);

--
-- Indexes for table `invoice_product`
--
ALTER TABLE `invoice_product`
  ADD PRIMARY KEY (`invoice_product_id`);

--
-- Indexes for table `invoice_save`
--
ALTER TABLE `invoice_save`
  ADD PRIMARY KEY (`invoice_save_id`);

--
-- Indexes for table `invoice_save_product`
--
ALTER TABLE `invoice_save_product`
  ADD PRIMARY KEY (`invoice_save_product_id`);

--
-- Indexes for table `product_badge_details`
--
ALTER TABLE `product_badge_details`
  ADD PRIMARY KEY (`product_badge_id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `product_details`
--
ALTER TABLE `product_details`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_stock_history`
--
ALTER TABLE `product_stock_history`
  ADD PRIMARY KEY (`product_stock_history_id`);

--
-- Indexes for table `resturent_table`
--
ALTER TABLE `resturent_table`
  ADD PRIMARY KEY (`resturent_table_id`);

--
-- Indexes for table `resturent_table_availability`
--
ALTER TABLE `resturent_table_availability`
  ADD PRIMARY KEY (`table_availability_id`);

--
-- Indexes for table `resturent_type`
--
ALTER TABLE `resturent_type`
  ADD PRIMARY KEY (`resturent_type_id`);

--
-- Indexes for table `service_charge`
--
ALTER TABLE `service_charge`
  ADD PRIMARY KEY (`service_charge_id`);

--
-- Indexes for table `todo`
--
ALTER TABLE `todo`
  ADD PRIMARY KEY (`todo_id`);

--
-- Indexes for table `users_login`
--
ALTER TABLE `users_login`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `users_profile_pic`
--
ALTER TABLE `users_profile_pic`
  ADD PRIMARY KEY (`users_profile_pic_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `grocery_bill_details`
--
ALTER TABLE `grocery_bill_details`
  MODIFY `grocery_bill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `grocery_bill_item`
--
ALTER TABLE `grocery_bill_item`
  MODIFY `grocery_bill_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `grocery_item`
--
ALTER TABLE `grocery_item`
  MODIFY `grocery_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `grocery_kitchen_item`
--
ALTER TABLE `grocery_kitchen_item`
  MODIFY `grocery_kitchen_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `invoice_details`
--
ALTER TABLE `invoice_details`
  MODIFY `invoice_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `invoice_product`
--
ALTER TABLE `invoice_product`
  MODIFY `invoice_product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `invoice_save`
--
ALTER TABLE `invoice_save`
  MODIFY `invoice_save_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `invoice_save_product`
--
ALTER TABLE `invoice_save_product`
  MODIFY `invoice_save_product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `product_badge_details`
--
ALTER TABLE `product_badge_details`
  MODIFY `product_badge_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_details`
--
ALTER TABLE `product_details`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product_stock_history`
--
ALTER TABLE `product_stock_history`
  MODIFY `product_stock_history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `resturent_table`
--
ALTER TABLE `resturent_table`
  MODIFY `resturent_table_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `resturent_table_availability`
--
ALTER TABLE `resturent_table_availability`
  MODIFY `table_availability_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `resturent_type`
--
ALTER TABLE `resturent_type`
  MODIFY `resturent_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `service_charge`
--
ALTER TABLE `service_charge`
  MODIFY `service_charge_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `todo`
--
ALTER TABLE `todo`
  MODIFY `todo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users_login`
--
ALTER TABLE `users_login`
  MODIFY `user_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users_profile_pic`
--
ALTER TABLE `users_profile_pic`
  MODIFY `users_profile_pic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
