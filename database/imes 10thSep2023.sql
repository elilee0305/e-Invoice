-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 10, 2023 at 03:17 AM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `imes`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbaccount1`
--

DROP TABLE IF EXISTS `tbaccount1`;
CREATE TABLE IF NOT EXISTS `tbaccount1` (
  `account1_id` int(11) NOT NULL AUTO_INCREMENT,
  `account1_name` varchar(50) NOT NULL,
  `account1_number` int(6) NOT NULL DEFAULT '0',
  `account1_chartAccountID` int(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`account1_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbaccount1`
--

INSERT INTO `tbaccount1` (`account1_id`, `account1_name`, `account1_number`, `account1_chartAccountID`) VALUES
(1, 'ASSETS', 1000, 1),
(2, 'LIABILITIES', 2000, 1),
(3, 'EQUITY', 3000, 1),
(4, 'REVENUE', 4000, 2),
(5, 'EXPENSE', 5000, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbaccount2`
--

DROP TABLE IF EXISTS `tbaccount2`;
CREATE TABLE IF NOT EXISTS `tbaccount2` (
  `account2_id` int(11) NOT NULL AUTO_INCREMENT,
  `account2_name` varchar(50) NOT NULL,
  `account2_number` int(6) NOT NULL DEFAULT '0',
  `account2_account1ID` int(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`account2_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbaccount2`
--

INSERT INTO `tbaccount2` (`account2_id`, `account2_name`, `account2_number`, `account2_account1ID`) VALUES
(1, 'CURRENT ASSET', 1100, 1),
(2, 'FIXED ASSET', 1200, 1),
(3, 'CURRENT LIABILITIES', 2100, 2),
(4, 'NON-CURRENT LIABILITIES', 2200, 2),
(5, 'OPERATING  REVENUE', 4100, 4),
(6, 'NON-OPERATING REVENUE', 4200, 4),
(7, 'COGS', 5100, 5),
(8, 'OPERATING EXPENSES', 5200, 5),
(9, 'EQUITY ACCOUNT', 3100, 3),
(10, 'NON OPERATING EXPENSE', 5300, 5);

-- --------------------------------------------------------

--
-- Table structure for table `tbaccount3`
--

DROP TABLE IF EXISTS `tbaccount3`;
CREATE TABLE IF NOT EXISTS `tbaccount3` (
  `account3_id` int(11) NOT NULL AUTO_INCREMENT,
  `account3_name` varchar(50) NOT NULL,
  `account3_number` int(6) NOT NULL DEFAULT '0',
  `account3_account2ID` int(6) NOT NULL DEFAULT '0',
  `account3_group` varchar(2) NOT NULL COMMENT 'CA = Cash Account, UT=Utilities Account',
  `account3_accountNumber` varchar(100) NOT NULL COMMENT 'account number, other identity etc',
  PRIMARY KEY (`account3_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbaccount3`
--

INSERT INTO `tbaccount3` (`account3_id`, `account3_name`, `account3_number`, `account3_account2ID`, `account3_group`, `account3_accountNumber`) VALUES
(1, 'CASH ON HAND', 1102, 1, 'CA', ''),
(2, 'ACCOUNTS RECEIVABLE', 1150, 1, '', ''),
(3, 'INVENTORY', 1151, 1, '', ''),
(4, 'SALES', 4101, 5, '', ''),
(5, 'PETTY CASH', 1101, 1, '', ''),
(6, 'ACCOUNTS PAYABLE', 2101, 3, '', ''),
(7, 'MAYBANK', 1103, 1, 'CA', ''),
(8, 'PUBLIC BANK', 1104, 1, 'CA', ''),
(9, 'BANK NAME', 1105, 1, 'CA', ''),
(10, 'SALES TAX PAYABLE', 2102, 3, '', ''),
(11, 'ROUNDING ACCOUNT', 5290, 8, '', ''),
(12, 'PURCHASE ACCOUNT', 5201, 8, '', ''),
(13, 'ELECTRICITY', 5202, 8, 'UT', ''),
(14, 'WATER', 5203, 8, 'UT', ''),
(16, 'COGS', 5101, 7, '', ''),
(17, 'INCOME TAX', 5301, 10, '', ''),
(19, 'OWNERS CAPITAL', 3101, 9, '', ''),
(20, 'RETAINED EARNINGS', 3102, 9, '', ''),
(21, 'VEHICLE 1', 1201, 2, '', ''),
(22, 'VEHICLE 2', 1202, 2, '', ''),
(23, 'DEPRECIATION', 5302, 10, '', ''),
(24, 'ACC DEP VEHICLE 1', 1261, 2, '', 'ADCONT'),
(25, 'ACC DEP VEHICLE 2', 1262, 2, '', 'ADCONT');

-- --------------------------------------------------------

--
-- Table structure for table `tbaccount4`
--

DROP TABLE IF EXISTS `tbaccount4`;
CREATE TABLE IF NOT EXISTS `tbaccount4` (
  `account4_id` int(11) NOT NULL AUTO_INCREMENT,
  `account4_account3ID` int(6) NOT NULL DEFAULT '0',
  `account4_date` date NOT NULL,
  `account4_reference` varchar(100) NOT NULL,
  `account4_documentType` varchar(4) NOT NULL,
  `account4_documentTypeID` int(10) NOT NULL DEFAULT '0',
  `account4_description` varchar(100) NOT NULL,
  `account4_debit` decimal(10,2) NOT NULL DEFAULT '0.00',
  `account4_credit` decimal(10,2) NOT NULL DEFAULT '0.00',
  `account4_sort` int(1) NOT NULL DEFAULT '1' COMMENT '0=opening balance, 1 = normal ledger accounts, 2=closing balance, 3=double entry manual',
  PRIMARY KEY (`account4_id`),
  KEY `account4_documentType` (`account4_documentType`)
) ENGINE=InnoDB AUTO_INCREMENT=230 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbaccount4`
--

INSERT INTO `tbaccount4` (`account4_id`, `account4_account3ID`, `account4_date`, `account4_reference`, `account4_documentType`, `account4_documentTypeID`, `account4_description`, `account4_debit`, `account4_credit`, `account4_sort`) VALUES
(1, 7, '2023-01-01', 'AP', 'APO', 1, 'Opening Balance', '1000.00', '0.00', 0),
(2, 8, '2023-01-01', 'AP', 'APO', 2, 'Opening Balance', '2000.00', '0.00', 0),
(3, 19, '2023-01-01', 'AP', 'APO', 3, 'Opening Balance', '0.00', '3000.00', 0),
(4, 2, '2023-07-17', 'INV/2023/009', 'INV', 8, '', '4266.95', '0.00', 1),
(5, 4, '2023-07-17', 'INV/2023/009', 'INV', 8, '', '0.00', '4266.95', 1),
(6, 2, '2023-07-17', 'RPT/2023/003', 'PAY', 15, 'BADAN PENGURUSAN BERSAMA LAKEVILLE RESIDENCE', '0.00', '350.00', 1),
(7, 1, '2023-07-17', 'RPT/2023/003', 'PAY', 15, 'BADAN PENGURUSAN BERSAMA LAKEVILLE RESIDENCE', '350.00', '0.00', 1),
(8, 2, '2023-07-24', 'INV/2023/010', 'INV', 9, 'PERBADANAN PENGURUSAN PANGSAPURI DESA PALMA', '5293.45', '0.00', 1),
(9, 4, '2023-07-24', 'INV/2023/010', 'INV', 9, 'PERBADANAN PENGURUSAN PANGSAPURI DESA PALMA', '0.00', '4953.45', 1),
(11, 2, '2023-07-25', 'INV/2023/011', 'INV', 10, '', '3325.95', '0.00', 1),
(12, 4, '2023-07-25', 'INV/2023/011', 'INV', 10, '', '0.00', '3325.95', 1),
(13, 2, '2023-07-25', 'INV/2023/012', 'INV', 11, '', '3325.95', '0.00', 1),
(14, 4, '2023-07-25', 'INV/2023/012', 'INV', 11, '', '0.00', '3325.95', 1),
(15, 2, '2023-08-01', 'INV/2023/013', 'INV', 12, '', '6295.95', '0.00', 1),
(16, 4, '2023-08-01', 'INV/2023/013', 'INV', 12, '', '0.00', '6295.95', 1),
(17, 6, '2023-08-03', 'PV/2023/001', 'PAYV', 1, 'F & N MALAYSIA BERHAD', '70.00', '0.00', 1),
(18, 7, '2023-08-03', 'PV/2023/001', 'PAYV', 1, 'F & N MALAYSIA BERHAD', '0.00', '70.00', 1),
(19, 2, '2023-08-03', 'INV/2023/014', 'INV', 13, '', '6545.35', '0.00', 1),
(20, 4, '2023-08-03', 'INV/2023/014', 'INV', 13, '', '0.00', '6482.07', 1),
(25, 10, '2023-07-24', 'INV/2023/010', 'INV', 9, 'PERBADANAN PENGURUSAN PANGSAPURI DESA PALMA', '0.00', '340.00', 1),
(26, 2, '2023-08-04', 'INV/2023/015', 'INV', 14, '', '7177.65', '0.00', 1),
(27, 4, '2023-08-04', 'INV/2023/015', 'INV', 14, '', '0.00', '6953.95', 1),
(44, 10, '2023-08-03', 'INV/2023/014', 'INV', 13, 'INDAH WATER KONSORTIUM  BERHAD', '0.00', '63.28', 1),
(45, 2, '2023-08-10', 'INV/2023/016', 'INV', 15, '', '16902.00', '0.00', 1),
(46, 4, '2023-08-10', 'INV/2023/016', 'INV', 15, '', '0.00', '16902.00', 1),
(47, 10, '2023-08-04', 'INV/2023/015', 'INV', 14, 'F & N MALAYSIA BERHAD', '0.00', '223.72', 1),
(48, 11, '2023-08-04', 'INV/2023/015', 'INV', 14, 'F & N MALAYSIA BERHAD', '0.02', '0.00', 1),
(49, 2, '2023-08-10', 'INV/2023/017', 'INV', 16, '', '21552.95', '0.00', 1),
(50, 4, '2023-08-10', 'INV/2023/017', 'INV', 16, '', '0.00', '21552.95', 1),
(51, 2, '2023-08-10', 'INV/2023/018', 'INV', 17, '', '4718.09', '0.00', 1),
(52, 4, '2023-08-10', 'INV/2023/018', 'INV', 17, '', '0.00', '4684.09', 1),
(78, 2, '2023-08-12', 'INV/2023/019', 'INV', 18, '', '5088.09', '0.00', 1),
(79, 4, '2023-08-12', 'INV/2023/019', 'INV', 18, '', '0.00', '4684.09', 1),
(85, 2, '2023-08-14', 'INV/2023/020', 'INV', 19, '', '0.00', '0.00', 1),
(86, 4, '2023-08-14', 'INV/2023/020', 'INV', 19, '', '0.00', '0.00', 1),
(91, 2, '2023-08-14', 'INV/2023/021', 'INV', 20, '', '21116.09', '0.00', 1),
(92, 4, '2023-08-14', 'INV/2023/021', 'INV', 20, '', '0.00', '18532.09', 1),
(97, 2, '2023-08-14', 'INV/2023/022', 'INV', 21, '', '2075.05', '0.00', 1),
(98, 4, '2023-08-14', 'INV/2023/022', 'INV', 21, '', '0.00', '2075.05', 1),
(101, 2, '2023-08-14', 'INV/2023/023', 'INV', 22, '', '6622.70', '0.00', 1),
(102, 4, '2023-08-14', 'INV/2023/023', 'INV', 22, '', '0.00', '6622.70', 1),
(104, 2, '2023-08-15', 'INV/2023/024', 'INV', 23, '', '3998.65', '0.00', 1),
(105, 4, '2023-08-15', 'INV/2023/024', 'INV', 23, '', '0.00', '3998.65', 1),
(109, 2, '2023-08-16', 'INV/2023/025', 'INV', 24, '', '88311.70', '0.00', 1),
(110, 4, '2023-08-16', 'INV/2023/025', 'INV', 24, '', '0.00', '88311.65', 1),
(137, 10, '2023-08-16', 'INV/2023/025', 'INV', 24, 'AAA INSURANCE SDN BHD', '0.00', '0.06', 1),
(138, 11, '2023-08-16', 'INV/2023/025', 'INV', 24, 'AAA INSURANCE SDN BHD', '0.01', '0.00', 1),
(139, 2, '2023-08-17', 'INV/2023/026', 'INV', 25, '', '18186.29', '0.00', 1),
(140, 4, '2023-08-17', 'INV/2023/026', 'INV', 25, '', '0.00', '18168.65', 1),
(143, 10, '2023-08-17', 'INV/2023/026', 'INV', 25, 'WKV2191', '0.00', '17.64', 1),
(148, 10, '2023-08-14', 'INV/2023/021', 'INV', 20, 'F & N MALAYSIA BERHAD', '0.00', '2584.00', 1),
(151, 2, '2023-08-17', 'INV/2023/027', 'INV', 27, '', '600.02', '0.00', 1),
(152, 4, '2023-08-17', 'INV/2023/027', 'INV', 27, '', '0.00', '600.02', 1),
(153, 2, '2023-08-17', 'INV/2023/028', 'INV', 28, '', '2319.18', '0.00', 1),
(154, 4, '2023-08-17', 'INV/2023/028', 'INV', 28, '', '0.00', '2319.18', 1),
(155, 2, '2023-08-17', 'INV/2023/029', 'INV', 29, '', '414534.20', '0.00', 1),
(156, 4, '2023-08-17', 'INV/2023/029', 'INV', 29, '', '0.00', '412786.72', 1),
(163, 10, '2023-08-12', 'INV/2023/019', 'INV', 18, 'KEN HUAT HARDWARE SDN BHD', '0.00', '404.00', 1),
(178, 10, '2023-08-17', 'INV/2023/029', 'INV', 29, 'MICROSOFT SDN BHD', '0.00', '1747.50', 1),
(179, 11, '2023-08-17', 'INV/2023/029', 'INV', 29, 'MICROSOFT SDN BHD', '0.02', '0.00', 1),
(180, 2, '2023-08-23', 'INV/2023/030', 'INV', 30, 'INDAH WATER KONSORTIUM  BERHAD', '14793.85', '0.00', 1),
(181, 4, '2023-08-23', 'INV/2023/030', 'INV', 30, 'INDAH WATER KONSORTIUM  BERHAD', '0.00', '14225.05', 1),
(182, 10, '2023-08-23', 'INV/2023/030', 'INV', 30, 'INDAH WATER KONSORTIUM  BERHAD', '0.00', '568.80', 1),
(183, 2, '2023-08-23', 'INV/2023/031', 'INV', 31, 'WPR 4597 ( TOYOTA VIOS NCP42 )', '13121.55', '0.00', 1),
(184, 4, '2023-08-23', 'INV/2023/031', 'INV', 31, 'WPR 4597 ( TOYOTA VIOS NCP42 )', '0.00', '13121.55', 1),
(185, 2, '2023-08-25', 'INV/2023/032', 'INV', 32, '', '5455.95', '0.00', 1),
(186, 4, '2023-08-25', 'INV/2023/032', 'INV', 32, '', '0.00', '5455.95', 1),
(187, 2, '2023-08-25', 'RPT/2023/005', 'PAY', 16, 'CLEAN SEWERS SERVICES SDN BHD', '0.00', '48250.17', 1),
(188, 8, '2023-08-25', 'RPT/2023/005', 'PAY', 16, 'CLEAN SEWERS SERVICES SDN BHD', '48250.17', '0.00', 1),
(189, 2, '2023-08-25', 'INV/2023/033', 'INV', 33, '', '3900.95', '0.00', 1),
(190, 4, '2023-08-25', 'INV/2023/033', 'INV', 33, '', '0.00', '3900.95', 1),
(192, 10, '2023-08-10', 'INV/2023/018', 'INV', 17, 'CLEAN SEWERS SERVICES SDN BHD', '0.00', '34.00', 1),
(193, 2, '2023-08-26', 'INV/2023/034', 'INV', 34, '', '0.00', '0.00', 1),
(194, 4, '2023-08-26', 'INV/2023/034', 'INV', 34, '', '0.00', '0.00', 1),
(195, 2, '2023-08-27', 'BALANCE C/F', 'CA', 43, 'HICOM GLENMARIE SDN BHD', '7000.00', '0.00', 1),
(196, 4, '2023-08-27', 'BALANCE C/F', 'CA', 43, 'HICOM GLENMARIE SDN BHD', '0.00', '7000.00', 1),
(197, 2, '2023-08-27', 'INV/2023/035', 'INV', 35, '', '13492.62', '0.00', 1),
(198, 4, '2023-08-27', 'INV/2023/035', 'INV', 35, '', '0.00', '13366.70', 1),
(199, 10, '2023-08-27', 'INV/2023/035', 'INV', 35, '', '0.00', '125.92', 1),
(200, 2, '2023-09-01', 'INV/2023/036', 'INV', 36, '', '1408.77', '0.00', 1),
(201, 4, '2023-09-01', 'INV/2023/036', 'INV', 36, '', '0.00', '1338.48', 1),
(202, 2, '2023-09-02', 'INV/2023/037', 'INV', 37, '', '1935.00', '0.00', 1),
(203, 4, '2023-09-02', 'INV/2023/037', 'INV', 37, '', '0.00', '1935.00', 1),
(205, 10, '2023-09-01', 'INV/2023/036', 'INV', 36, 'CADBURY CDN BHD', '0.00', '70.29', 1),
(206, 2, '2023-09-05', 'RPT/2023/006', 'PAY', 17, 'WTU 8116 ( PROTON SAGA 1.3 )', '0.00', '33.00', 1),
(207, 1, '2023-09-05', 'RPT/2023/006', 'PAY', 17, 'WTU 8116 ( PROTON SAGA 1.3 )', '33.00', '0.00', 1),
(208, 6, '2023-09-05', 'PB003', 'PB', 3, 'LANGKAVI TOURISM SDN BHD', '0.00', '700.00', 1),
(209, 12, '2023-09-05', 'PB003', 'PB', 3, 'LANGKAVI TOURISM SDN BHD', '700.00', '0.00', 1),
(210, 2, '2023-09-05', 'INV/2023/038', 'INV', 38, 'BADAN PENGURUSAN BERSAMA KENNY HILL', '3700.00', '0.00', 1),
(211, 4, '2023-09-05', 'INV/2023/038', 'INV', 38, 'BADAN PENGURUSAN BERSAMA KENNY HILL', '0.00', '3700.00', 1),
(212, 2, '2023-09-05', 'INV/2023/039', 'INV', 39, 'SEKOLAH MENENGAH KEBANGSAAN PEREMPUAN SRI AMAN', '13121.55', '0.00', 1),
(213, 4, '2023-09-05', 'INV/2023/039', 'INV', 39, 'SEKOLAH MENENGAH KEBANGSAAN PEREMPUAN SRI AMAN', '0.00', '13121.55', 1),
(214, 2, '2023-09-07', 'INV/2023/040', 'INV', 40, '', '5000.00', '0.00', 1),
(215, 4, '2023-09-07', 'INV/2023/040', 'INV', 40, '', '0.00', '5000.00', 1),
(216, 2, '2023-09-07', 'INV/2023/041', 'INV', 41, '', '888.00', '0.00', 1),
(217, 4, '2023-09-07', 'INV/2023/041', 'INV', 41, '', '0.00', '888.00', 1),
(218, 2, '2023-09-07', 'INV/2023/042', 'INV', 42, '', '999.00', '0.00', 1),
(219, 4, '2023-09-07', 'INV/2023/042', 'INV', 42, '', '0.00', '999.00', 1),
(220, 2, '2023-09-07', 'INV/2023/043', 'INV', 43, '', '6565.00', '0.00', 1),
(221, 4, '2023-09-07', 'INV/2023/043', 'INV', 43, '', '0.00', '6565.00', 1),
(222, 2, '2023-09-07', 'INV/2023/045', 'INV', 44, 'F & N MALAYSIA BERHAD', '1717.00', '0.00', 1),
(223, 4, '2023-09-07', 'INV/2023/045', 'INV', 44, 'F & N MALAYSIA BERHAD', '0.00', '1717.00', 1),
(224, 2, '2023-09-08', 'INV/2023/046', 'INV', 45, 'INDAH WATER KONSORTIUM  BERHAD', '666.00', '0.00', 1),
(225, 4, '2023-09-08', 'INV/2023/046', 'INV', 45, 'INDAH WATER KONSORTIUM  BERHAD', '0.00', '666.00', 1),
(226, 2, '2023-09-08', 'INV/2023/047', 'INV', 46, 'BADAN PENGURUSAN BERSAMA LAKEVILLE RESIDENCE', '3232.00', '0.00', 1),
(227, 4, '2023-09-08', 'INV/2023/047', 'INV', 46, 'BADAN PENGURUSAN BERSAMA LAKEVILLE RESIDENCE', '0.00', '3232.00', 1),
(228, 2, '2023-09-08', 'INV/2023/048', 'INV', 47, 'RESTORAN ACCHA CURRY HOUSE SDN BHD', '29700.00', '0.00', 1),
(229, 4, '2023-09-08', 'INV/2023/048', 'INV', 47, 'RESTORAN ACCHA CURRY HOUSE SDN BHD', '0.00', '29700.00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbaccountingperiod`
--

DROP TABLE IF EXISTS `tbaccountingperiod`;
CREATE TABLE IF NOT EXISTS `tbaccountingperiod` (
  `accountingPeriod_id` int(11) NOT NULL AUTO_INCREMENT,
  `accountingPeriod_dateStart` date DEFAULT NULL,
  `accountingPeriod_dateEnd` date DEFAULT NULL,
  `accountingPeriod_status` varchar(1) NOT NULL DEFAULT 'o' COMMENT 'o=open, c=close, t=temporary close',
  `accountingPeriod_userID` int(11) NOT NULL DEFAULT '0' COMMENT 'user id of person who create',
  `accountingPeriod_yearInfo` varchar(50) NOT NULL COMMENT 'year info, the finacial year etc',
  PRIMARY KEY (`accountingPeriod_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbaccountingperiod`
--

INSERT INTO `tbaccountingperiod` (`accountingPeriod_id`, `accountingPeriod_dateStart`, `accountingPeriod_dateEnd`, `accountingPeriod_status`, `accountingPeriod_userID`, `accountingPeriod_yearInfo`) VALUES
(8, '2023-01-01', '2023-12-31', 'o', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbaccountingperioddetail`
--

DROP TABLE IF EXISTS `tbaccountingperioddetail`;
CREATE TABLE IF NOT EXISTS `tbaccountingperioddetail` (
  `accountingPeriodDetail_id` int(11) NOT NULL AUTO_INCREMENT,
  `accountingPeriodDetail_accountingPeriodID` int(11) NOT NULL COMMENT 'FK from tbaccountingperiod',
  `accountingPeriodDetail_openDebitBalance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `accountingPeriodDetail_closeDebitBalance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `accountingPeriodDetail_openCreditBalance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `accountingPeriodDetail_closeCreditBalance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `accountingPeriodDetail_debitAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `accountingPeriodDetail_creditAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `accountingPeriodDetail_dateCreated` date DEFAULT NULL,
  `accountingPeriodDetail_generated` varchar(1) NOT NULL COMMENT 'a=auto generated, m=manual key in',
  `accountingPeriodDetail_account3ID` int(11) NOT NULL,
  PRIMARY KEY (`accountingPeriodDetail_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbaccountingperioddetail`
--

INSERT INTO `tbaccountingperioddetail` (`accountingPeriodDetail_id`, `accountingPeriodDetail_accountingPeriodID`, `accountingPeriodDetail_openDebitBalance`, `accountingPeriodDetail_closeDebitBalance`, `accountingPeriodDetail_openCreditBalance`, `accountingPeriodDetail_closeCreditBalance`, `accountingPeriodDetail_debitAmount`, `accountingPeriodDetail_creditAmount`, `accountingPeriodDetail_dateCreated`, `accountingPeriodDetail_generated`, `accountingPeriodDetail_account3ID`) VALUES
(1, 8, '1000.00', '0.00', '0.00', '0.00', '0.00', '0.00', '2023-01-01', 'm', 7),
(2, 8, '2000.00', '0.00', '0.00', '0.00', '0.00', '0.00', '2023-01-01', 'm', 8),
(3, 8, '0.00', '0.00', '3000.00', '0.00', '0.00', '0.00', '2023-01-01', 'm', 19);

-- --------------------------------------------------------

--
-- Table structure for table `tbchartaccount`
--

DROP TABLE IF EXISTS `tbchartaccount`;
CREATE TABLE IF NOT EXISTS `tbchartaccount` (
  `chartAccount_id` int(11) NOT NULL AUTO_INCREMENT,
  `chartAccount_name` varchar(50) NOT NULL,
  PRIMARY KEY (`chartAccount_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbchartaccount`
--

INSERT INTO `tbchartaccount` (`chartAccount_id`, `chartAccount_name`) VALUES
(1, 'BALANCE SHEET'),
(2, 'INCOME STATEMENT');

-- --------------------------------------------------------

--
-- Table structure for table `tbcompany`
--

DROP TABLE IF EXISTS `tbcompany`;
CREATE TABLE IF NOT EXISTS `tbcompany` (
  `company_id` int(2) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(100) NOT NULL,
  `company_no` varchar(25) NOT NULL,
  `company_address1` varchar(100) NOT NULL,
  `company_address2` varchar(100) NOT NULL,
  `company_telFax` varchar(100) NOT NULL,
  `company_quotationTerms` text NOT NULL,
  `company_purchaseOrderTerms` text NOT NULL,
  `company_deliveryOrderTerms` text NOT NULL,
  `company_invoiceTerms` text NOT NULL,
  `company_logo` varchar(50) NOT NULL,
  `company_dueDate` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbcompany`
--

INSERT INTO `tbcompany` (`company_id`, `company_name`, `company_no`, `company_address1`, `company_address2`, `company_telFax`, `company_quotationTerms`, `company_purchaseOrderTerms`, `company_deliveryOrderTerms`, `company_invoiceTerms`, `company_logo`, `company_dueDate`) VALUES
(1, 'HYBRID TECHNOLOGIES SOLUTIONS', 'SA0460092-K', 'B-11-03 SURIA JELUTONG, JALAN BAZAAR U8/99', '40500, SHAH ALAM, SELANGOR D.E', '013-677 6693  Email : hybridtech33@gmail.com', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>Payment should be made to <strong>KSN SEWERAGE ENGINEERING SERVICE</strong> &quot; at Public Bank 3122 136 534&nbsp;</li></ol>', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', '<p><strong>Delivery Order Terms</strong></p><p>a.) All necessary documentation permit to enter the jobsite shall be arranged by the Hirer.<br />b.) All lifting Gears to be provided by the Hirer.<br />c.) Sunday &amp; Public Holiday considered as overtime and minimum 8hrs.</p>', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li><li>Our payment terms is 30 days and 5% interest per day after that will be charged.</li></ul>', 'logo4572.jpg', 15);

-- --------------------------------------------------------

--
-- Table structure for table `tbcreditnote`
--

DROP TABLE IF EXISTS `tbcreditnote`;
CREATE TABLE IF NOT EXISTS `tbcreditnote` (
  `creditNote_id` int(11) NOT NULL AUTO_INCREMENT,
  `creditNote_no` varchar(30) NOT NULL,
  `creditNote_date` date NOT NULL,
  `creditNote_invoiceID` int(11) NOT NULL,
  `creditNote_title` varchar(200) NOT NULL,
  `creditNote_from` varchar(50) NOT NULL,
  `creditNote_terms` text NOT NULL,
  `creditNote_attention` varchar(100) NOT NULL,
  `creditNote_email` varchar(100) NOT NULL,
  `creditNote_subTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `creditNote_taxTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `creditNote_grandTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `creditNote_discountTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `creditNote_totalAfterDiscount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `creditNote_roundAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `creditNote_grandTotalRound` decimal(10,2) NOT NULL DEFAULT '0.00',
  `creditNote_roundStatus` int(1) NOT NULL DEFAULT '0',
  `creditNote_content` text NOT NULL,
  PRIMARY KEY (`creditNote_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbcreditnote`
--

INSERT INTO `tbcreditnote` (`creditNote_id`, `creditNote_no`, `creditNote_date`, `creditNote_invoiceID`, `creditNote_title`, `creditNote_from`, `creditNote_terms`, `creditNote_attention`, `creditNote_email`, `creditNote_subTotal`, `creditNote_taxTotal`, `creditNote_grandTotal`, `creditNote_discountTotal`, `creditNote_totalAfterDiscount`, `creditNote_roundAmount`, `creditNote_grandTotalRound`, `creditNote_roundStatus`, `creditNote_content`) VALUES
(1, 'CN/2023/001', '2023-07-10', 3, '', '', '', 'ENCIK KAMARUDDIN', 'fn_malaysia@gmail.com', '500.00', '0.00', '500.00', '0.00', '500.00', '0.00', '500.00', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbcreditnotedetail`
--

DROP TABLE IF EXISTS `tbcreditnotedetail`;
CREATE TABLE IF NOT EXISTS `tbcreditnotedetail` (
  `creditNoteDetail_id` int(11) NOT NULL AUTO_INCREMENT,
  `creditNoteDetail_creditNoteID` int(10) NOT NULL,
  `creditNoteDetail_no1` varchar(200) NOT NULL,
  `creditNoteDetail_no2` varchar(200) NOT NULL,
  `creditNoteDetail_no3` decimal(10,2) NOT NULL DEFAULT '0.00',
  `creditNoteDetail_no4` varchar(200) NOT NULL,
  `creditNoteDetail_bold` int(11) NOT NULL DEFAULT '0' COMMENT '0=normal, 1=bold',
  `creditNoteDetail_sortID` int(2) NOT NULL DEFAULT '0',
  `creditNoteDetail_no5` decimal(10,2) NOT NULL DEFAULT '0.00',
  `creditNoteDetail_rowTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `creditNoteDetail_taxRateID` int(10) NOT NULL DEFAULT '0',
  `creditNoteDetail_taxPercent` decimal(10,2) NOT NULL DEFAULT '0.00',
  `creditNoteDetail_taxTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `creditNoteDetail_rowGrandTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `creditNoteDetail_discountPercent` decimal(10,2) NOT NULL DEFAULT '0.00',
  `creditNoteDetail_discountAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `creditNoteDetail_rowTotalAfterDiscount` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`creditNoteDetail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbcreditnotedetail`
--

INSERT INTO `tbcreditnotedetail` (`creditNoteDetail_id`, `creditNoteDetail_creditNoteID`, `creditNoteDetail_no1`, `creditNoteDetail_no2`, `creditNoteDetail_no3`, `creditNoteDetail_no4`, `creditNoteDetail_bold`, `creditNoteDetail_sortID`, `creditNoteDetail_no5`, `creditNoteDetail_rowTotal`, `creditNoteDetail_taxRateID`, `creditNoteDetail_taxPercent`, `creditNoteDetail_taxTotal`, `creditNoteDetail_rowGrandTotal`, `creditNoteDetail_discountPercent`, `creditNoteDetail_discountAmount`, `creditNoteDetail_rowTotalAfterDiscount`) VALUES
(1, 1, '', '', '0.00', '', 0, 1, '500.00', '500.00', 1, '0.00', '0.00', '500.00', '0.00', '0.00', '500.00'),
(2, 1, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(3, 1, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(4, 1, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(5, 1, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbcustomer`
--

DROP TABLE IF EXISTS `tbcustomer`;
CREATE TABLE IF NOT EXISTS `tbcustomer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(150) NOT NULL,
  `customer_address` varchar(250) NOT NULL,
  `customer_tel` varchar(30) NOT NULL,
  `customer_type` int(1) NOT NULL DEFAULT '1' COMMENT '1=customer, 2 = supplier 3=staff',
  `customer_email` varchar(100) NOT NULL,
  `customer_attention` varchar(50) NOT NULL,
  `customer_deliveryAddress` varchar(250) NOT NULL,
  PRIMARY KEY (`customer_id`),
  KEY `customer_name` (`customer_name`)
) ENGINE=InnoDB AUTO_INCREMENT=236 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbcustomer`
--

INSERT INTO `tbcustomer` (`customer_id`, `customer_name`, `customer_address`, `customer_tel`, `customer_type`, `customer_email`, `customer_attention`, `customer_deliveryAddress`) VALUES
(1, 'Suhumaran Duraisamy', 'No 34 Jalan Petaling Jaya\r\nJalan 45000 Kuala Lumpur', '012 654 9809', 1, 'suhu556@gmail.com', '', ''),
(2, 'Sham Sredar', 'No 23 Jalan Kelaing', '324243511', 3, 'ewfqrwe tn tqnwt@gmail.com', '', ''),
(3, 'AMERICAN TABACCO MALAYSIA BERHAD', 'Putra Perdana', '06-7800 5640', 3, 'american_88@hotmailcom', 'Mr John Tan', 'Puchong, Selangor'),
(5, 'Jurong Port Klang Sdn Bhd', 'Lot 67 Jalan Port Kalng 56/45 Taman Berkeley Selangor', '012 654 9809', 3, 'port_klang@hotmail.com', 'Ms Prema Nair', ''),
(6, 'VENICE VISION SDN BHD', 'NO 45 JALAN SS 6/90,\r\nKELANA JAYA\r\nPETALING JAYA, SELANGOR', '03 - 5600 9067', 1, 'lim_90@gmail.com', 'Ms Lim Ah Keong', ''),
(7, 'Restoran Saji Sdn Bhd', '', '', 1, '', '', ''),
(8, 'Ayurvedic Lestari Centre Sdn Bhd', 'No 34 Jalan USJ2/3, \r\nTaman Subang Jaya, \r\nSelangor D.E, \r\nMalaysia (South East Asia)', '03-6764 0987', 1, 'ayur_90@gmail.com', 'Hariharan', ''),
(9, 'PERCETAKAN CHEMY SDN BHD', '', '', 1, '', '', ''),
(10, 'CHURCH LOURDES', '', '', 1, '', '', ''),
(11, 'JERNIH SEWERAGE MAINTENANCE SDN BHD', 'No 45 Jalan SS 3/90 Taman Bahagia PJ', '03 7865 9098', 1, 'sara_98@hotmail.com', 'Mr Saravanan', ''),
(12, 'Berjaya Eara Resources', 'No 45 Jalan SS 5/7 Taman Kelana Jaya,\r\nSelangor D.E', '012 543 9008', 2, 'berjaya_eara@yahoo.com', 'Mr Paramisivam', ''),
(13, 'Proslip Sheet (M) Sdn Bhd', 'No 90, Jalan Klang Lama 4/5,\r\nTaman Sentosa, Selangor D.E, Malaysia', '012 8884 889', 2, 'jevah89@hotmail.com', 'Mr Jeevah', 'No 344 Jalan Suruhan Jaya, Centro Building, Klang, Malaysia'),
(14, 'PUSAT NIAGA SDN BHD', 'PUCHONG, SELANGOR', '3143253532', 1, 'CCDahgfdahfj', 'MR ALI', ''),
(15, 'KSN Sewerage Engineering Services', 'No 4, Jalan SS 5C/23, Taman Kelana Jaya', '603-7865 9073', 1, 'ksnsewerageworks@gmail.com', 'Madam Kavita', ''),
(16, 'INTEL CORPORATION SDN BHD', '', '', 1, '', '', ''),
(17, 'VKPT Payroll Sdn Bhd', 'No 45 Jalan Klang Lama, 34900 Ipoh, Perak', '05-78765 0098', 1, 'vkptpayroll@yahoo.com', 'Mr Vellu', ''),
(18, 'F & N MALAYSIA BERHAD', 'NO 45 JALAN KLANG, \nPORT KLANG 43009 \nSELANGOR D.E', '05-78765 0098', 1, 'fn_malaysia@gmail.com', 'ENCIK KAMARUDDIN', 'NO 333 LOT 45 PANDAMARAN WAREHOUSE, PORT KLANG'),
(19, 'RESTORAN ACCHA CURRY HOUSE SDN BHD', '', '', 1, '', '', ''),
(20, 'PES OIL & GAS SDN BHD', 'NO 54-09 JALAN UP78/345 TAMAN SRI DAMANSARA, 56400 SELANGOR D.E', '05-876543200', 1, 'pes_oilgas@gmail.com', 'MR ALBERT', ''),
(21, 'EPSON PRECISION MALAYSIA SDN BHD', 'Lot No 1, Jalan Persiaran Industri, Taman Perindustrian Sri Damansara, \r\n52200 Kuala Lumpur', '03-6272 9078', 1, 'devi_epson@gmail.com', 'Madam Devi Nair', 'No 45 Warehouse Klang 45099 Port Klang'),
(22, 'GIANT SUPERMARKET SDN BHD (SELAYANG)', 'No 34 Jalan Puchong 45/90 Taman Puchong Prima, Selangor D.E, Malaysia', '03 7654 0098', 1, 'giant_selayang@gmail.com', 'Mr Teng Ken Fatt', 'No 112 Jalan Puchong 45/90 Taman Puchong Prima, Selangor D.E, Malaysia (Warehouse)'),
(23, 'YONG SOON FATT SDN BHD', 'LOT 1504, BATU 8 1/2 JALAN KLANG LAMA KLANG, SELANGOR D.E Malaysia', '03 56782009', 0, 'soonfatt@hotmail.com', 'Mr Alex Tan', 'Port Klang'),
(24, 'PERSATUAN TELUGU MALAYSIA (CAWANGAN KAJANG)', 'NO 56 JALAN SS 6/90, PETALING JAYA\r\nSELANGOR D.E', '03-6750 0098', 1, 'telug_assc@gmail.com', 'MR KUMAR RAO', ''),
(25, 'VIENDA RESOURCES', 'SHAH ALAM', '', 1, '', 'DATIN AIDA', ''),
(26, 'WXX 7985 ( VW POLO )', '', '', 1, '', 'DR CHOW', ''),
(27, 'SYARIKAT XYZ SDN BHD', 'LOT 1001-015 NO 80 JLN BARU\r\nSRI BUNGA KERTAS\r\n50490 KUALA LUMPUR', '', 1, '', 'Encik Joy', ''),
(28, 'WYM 8219 ( TOYOTA VELLFIRE  )', '', '', 1, '', 'DATO YM TONG', ''),
(29, 'WPN 1027 ( TOYOTA VIOS)', '', '', 1, '', 'MR CHRIS', ''),
(30, 'JAYA GROCER SDN BHD', 'NO 45, JALAM PJS 45/90,\r\nTAMAN SUBANG JAYA,\r\nSELANGOR D.E', '03-5670 98088', 1, 'jaya_grocer@hotmail.com', 'MR ALEX CHAN', ''),
(31, 'OK Radio Sdn Bhd', '', '', 1, '', '', ''),
(32, 'RAMESH SINGH', 'No 34 Jalan SS5C/23 Taman Kelana Jaya, Selangor D.E', '', 1, '', 'Mr kARPAL Singh', ''),
(33, 'DAman Crimson Management Corporation', 'Crimson Apt, 2nd Floor (Club House), No 1,Jalan PJU 1A/41, Ara Jaya,47301 Petaling Jaya,\r\nSelangor D.E', '', 1, 'dcmc.crimson@gmail.com', 'Mr.Rajan', ''),
(34, 'ROYAL PORT DICKSON YACHT CLUB', 'BATU 4 1/2 , JALAN PANTAI, SI RUSA, 71050, \r\nNEGERI SEMBILAN DK', '', 1, 'gobalan2829@gmail.com', 'Mr Gobalan', ''),
(35, 'S & J BARCODE SDN BHD', 'NO 27, FIRST FLOOR, LORONG HELANG 2, DESA PERMAI INDAH, PENANG', '012 4181 890', 1, '', 'MR DERICK', ''),
(36, 'JMB TENDERFIELDS', 'NO 1 LINGKARAN ECO MAJESTIC\r\n43500 SEMENYIH SELANGOR', '', 1, '', '', ''),
(37, 'NESTLE (M) SDN BHD', 'NO 34 JALAN TANDANG, TAMAN SENTOSA, OLD TOWN, PETALING JAYA, SELANGOR D.E', '03-8986 0098', 1, 'kenny_nestle@nestlemalaysia.com', 'MR KENNY (MANAGER)', 'NO 34 JALAN TANDANG, TAMAN SENTOSA, OLD TOWN, PETALING JAYA, SELANGOR D.E'),
(39, 'IMPIAN WATER CONSORTIUM BERHAD', '', '', 1, '', 'MR GANESON', ''),
(40, 'CITY SEWERAGE SDN BHD', '', '', 1, '', 'MR RAMESH (DATOK)', ''),
(42, 'TEST 2', '', '', 1, '', '', ''),
(44, 'VINMURA TRADING SDN BHD', '', '', 1, '', 'MR CHANDRAN', ''),
(46, 'TEST 10', '', '', 1, '', '', ''),
(47, 'TEST 11', '', '', 1, '', '', ''),
(48, 'Melati Abdul Hai', '', '', 1, '', '', ''),
(51, 'AHSN DYNAMIC (M) SDN BHD', 'No 45 Jalan Pinang, Taman Midah, 45600 Cheras, Malaysia', '03 56782191', 2, 'ahsn_90@gmail.com', 'Mr Balvinder Singh', 'No 45 Jalan Pinang, Taman Midah, 45600 Cheras, Malaysia'),
(52, 'MELEWAR STEEL (M) SDN BHD', '', '', 3, '', '', ''),
(53, 'CITY ENVIRONMENT SDN BHD', '', '', 1, '', '', ''),
(54, 'CASIO SDN BHD', 'Lot 34 Petaling garden 33400 Petaling Jaya', '03 5677 9098', 1, '', 'Ms Faridah', ''),
(55, 'PRUDENTIAL INSURANCE', '', '', 1, '', '', ''),
(56, 'PROTON BERHAD', '', '', 1, '', 'MR TEE CHONG', ''),
(57, 'IOI Properties Group Berhad', 'Level 25, IOI City Tower 2, Lebuh IRC, IOI Resort City, 62502 Putrajaya, Malaysia.', '+603-8947 6659', 1, 'shanice.wong@ioigroup.com', 'Shanice Wong  ( Contracts Executive )', ''),
(58, 'INDAH KOTA SDN BHD', '', '', 1, '', '', ''),
(59, 'RIANA GREEN JOINT MANAGEMENT BODY', 'No. 1, Jalan PJU 3/1C (Jalan Tropicana Utara)\r\n47410 Petaling Jaya', '03-78064409', 1, 'manager.rianagreen@gmail.com', 'Vegan - Building Manager', ''),
(60, 'MATSHUSHITA SDN BHD', '', '', 1, '', '', ''),
(61, 'AZAM BARU ENTERPRISE', 'NO 31 JALAN INDAH 3/8 \r\nPUCHONG INDAH \r\nPUCHONG 47150\r\nSELANGOR D.E', '05 8765 9008', 1, 'jumaatengineering@gmail.com', 'Mr Kamaruddin', ''),
(62, 'KIMGRES MARKETING SDN BHD', 'LOT 5 JALAN KILANG / JALAN 217 46050 PETALING JAYA, SELANGOR', '', 1, 'azhar.rahman@kimgres.com', 'ENCIK AZHAR', ''),
(63, 'IMPIAN WATER KONSORTIUM SDN BHD', '', '', 1, '', 'MR GANAESON', ''),
(64, 'RESTORAN YEE SUNG', '', '', 1, '', '', ''),
(65, 'IOI PROPERTIES (M) SDN BHD', '', '', 1, '', '', ''),
(66, 'INDAH WATER KORSITIUM SDN BHD', '', '', 1, '', '', ''),
(67, 'CARSOME MALAYSIA SDN BHD', 'No 45 Jalan Petaling 5/6 Taman Midah Jaya, Petaling Jaya, Selangor D.E', '03 7865 9088', 3, 'caresome_90@gmail.com', 'Mr Ramachandrean', 'Lot 4590 Warehouse Taman Midah Jaya, Petaling Jaya, Selangor D.E'),
(68, 'SPAN BERHAD', '', '', 1, '', '', ''),
(69, 'TENAGA NASIONAL BERHAD', 'NO 34 JALAN BANGSAR, KL', '012 654 8976', 1, 'guru_tnb@gmail.com', 'MR GURU PALANISAMY', 'NO 67 JALAN BENTONG KARAK, PAHANG'),
(70, 'SURUHANJAYA SYARIKAT MALAYSIA', '', '', 1, '', 'MR EZWAN', ''),
(71, 'CALTEX (M) SDN BHD', '', '', 1, '', '', ''),
(72, 'COKE COLA SDN BHD', '', '', 1, '', '', ''),
(74, 'ALAGAPAS CURRY POWDER (M) SDN BHD', 'Lot 19 Jalan Bangsar, Selangor', '03 3490 0032', 0, 'alagapas@hotmail.com', 'Mr Anamalai', ''),
(75, 'CALTEX OILS SDN BHD', '', '', 1, '', 'MR RAYMOND', ''),
(76, 'BADAN PENGURUSAN BERSAMA LAKEVILLE RESIDENCE', 'NO 68 JALAN SIBU, TAMAN WAHYU 68100 BATU CAVES, KUALA LUMPUR', '016 7876009', 2, '', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', ''),
(77, 'UKRAINE FLOOR MILL SDN BHD', '', '', 1, '', '', ''),
(79, 'PANASONIC MALAYSIA (M) SDN BHD', 'NO 45 LOT 6690 TAMAN SRI MUDA, SHAH ALAM', '03-8909 6755', 1, 'panasonic_malaysia@gmail.com', 'MR CHANDRAN', ''),
(80, 'KELAB SUKAN GOLD SELANGOR SDN BHD', '', '', 1, '', 'MR KAMARUDDING', ''),
(81, 'AVINOR SDN BHD', 'Damansara', '012 653 9009', 0, 'avinor@gmail.com', 'Mr Zeizen', 'Klang'),
(82, 'MATSHUSHITA (M) SDN BHD', '', '', 1, '', '', ''),
(83, 'DESA DAMANSARA MANAGEMENT CORPORATION', 'NO 99 JALAN SETIAKASIH, BUKIT DAMANSARA, 50490 KUALA LUMPUR', '03 2095 5099', 1, 'desa_90@gmail.com', 'Ms Fatimah Kassim', ''),
(84, 'HAZLAN SABTU GRAB ENTERPRIZE', '', '', 1, '', '', ''),
(85, 'NASIR AIRMAS SDN BHD', '', '', 1, '', '', ''),
(87, 'RAINE HORNE & ZAKI PROPERTY MANAGEMENT SDN BHD', 'NO 10 JALAN JALIL JAYA 2 JALIL LINK, BUKIT JALIL 57000 KUALA LUMPUR', '', 1, 'timothy@rainehome.com.my', 'MR TIMOTHY', ''),
(88, 'KEN HUAT HARDWARE SDN BHD', 'NO 4 JALAN SS 2/4 \nTAMAN BAHAGIA, \nPETALING JAYA, SELANGOR', '03-8976 5434', 2, 'ken_huat89@gmail.com', 'MR HUAT', ''),
(89, 'JAYA GROCER SDN BHD', '', '', 2, '', '', ''),
(90, 'VILLAGE GROCER SDN BHD', '', '', 2, '', '', ''),
(91, 'PETRONAS BERHAD', '', '', 2, '', '', ''),
(92, 'PREMIO STATIONARY SDN BHD', '', '', 2, '', '', ''),
(93, 'RIGHTONTRACK SDN BHD', 'E-12-1, BLOCK E, PLAZA GLOMAC, \nJALAN SS7/19, KELANA JAYA, \n47300 PETALING JAYA, SELANGOR', '603-7805 2999', 1, 'info@rightontrack.com.my', '', ''),
(94, 'CLEAN SEWERS SERVICES SDN BHD', 'NO 34 JALAN SR PETALING 4/5, \nTAMAN WAHYU, \nSHAH ALAM, \nSELANGOR D.E', '03 5640 0031', 1, 'admin@clean_sewers.com', 'MR RAMESH / SHOBA', ''),
(95, 'WPR 4597 ( TOYOTA VIOS NCP42 )', '', '', 1, '', 'JAMES LOWERENCE', ''),
(96, 'COLGATE PALMOLIVE SDN BHD', '', '', 1, '', '', ''),
(97, 'MOTOROLLA SDN BHD', 'NO 45 JALAN FREE TRADE ZONE, 56000 KELANA JAYA, SELANGOR', '03-9988 7700', 1, '', 'MR SELVAM', 'NO 90 JALAN FREE TRADE ZONE, 56000 KELANA JAYA, SELANGOR'),
(99, 'PEPSI COLA', '', '', 1, '', '', ''),
(100, 'MICROSOFT SDN BHD', '', '', 1, '', '', ''),
(102, 'SDDSD', '', '', 1, '', '', ''),
(105, 'TEMPLE ISWASRI', '', '', 3, '', '', ''),
(106, 'VASANTHI', '', '', 1, '', '', ''),
(107, 'RAJU', '', '', 1, '', '', ''),
(109, 'MUTHU AIRCOND SDN BHD', '', '', 3, '', '', ''),
(111, 'EVERGLADE SDN BHD', '', '', 3, '', '', ''),
(112, 'YONG SOON hardware', '', '', 3, '', '', ''),
(114, 'APPLE COMPUTER BERHAD', '', '', 1, '', '', ''),
(115, 'TOSHIBA MANAFACTURES', '', '', 1, '', '', ''),
(116, 'Zoo Negara', '', '', 3, '', '', ''),
(117, 'RESTORAN CHUTNEY BOX', '', '', 1, '', '', ''),
(118, 'BADAN PENGURUSAN BERSAMA KENNY HILL', '', '', 3, '', '', ''),
(119, 'RESTORAN SAJI SDN BHD', 'TAMAN SIA ALAM', '03 6540 9009', 3, 'saji@gmail.com', '', ''),
(120, 'BATERY TECHNICAN SDN BHD', '', '03 4589 7665', 3, '', 'Mr Frank', ''),
(122, 'MOTROLLA', '', '', 3, '', '', ''),
(123, 'COMPUTER SALES', '', '', 3, '', '', ''),
(124, 'APPLE CHINA MADE', '', '', 3, '', '', ''),
(131, 'SERDANG MEDICAL CENTRE', 'LOT 45 TAMAN SERI SERDANG, SELANGOR', '03 9098 3450', 2, 'serdang_hospital@gmail.com', 'DR YAMESH', ''),
(132, 'INDAH WATER KONSORTIUM  BERHAD', 'LOT 73 JALAN DAMANSARA,\nPETALING JAYA\nSELANGOR', '03 4560 2003', 2, 'care@iwk.com.my', 'MR ALI KAMARUDDIN', 'LOT 73 JALAN DAMANSARA, KL'),
(139, 'PRINTING ALLEN SDN BHD', '', '', 1, '', '', ''),
(142, 'RESTORAN SPICE GARDEN', '', '', 1, '', '', ''),
(143, 'GREAT EASTERN SDN BHD', 'WISMA GREAT ESTERN, AMPANG', '03 785 9099', 1, '', 'MR TEE', ''),
(144, 'WESTERN DIGITAL (M) SDN BHD', 'KELANA JAYA, FREE TRADE ZONE', '03 7650 0091', 1, '', 'MR YOGI', ''),
(145, 'MOTOROLLA BERHAD', '', '', 1, '', 'MR PREM ANAN', ''),
(146, 'SEKOLAH MENENGAH KEBANGSAAN PEREMPUAN SRI AMAN', '', '', 1, '', 'CIKGU RAMESH', ''),
(147, 'AA PHARMACY SDN BHD', 'KELANA JAYA', '012 7654 900', 1, 'aa_pharmacy@gmail.com', '', ''),
(148, 'AJININOMOTO SDN BHD', '', '', 1, '', '', ''),
(149, 'TESTING E232', '', '', 1, '', '', ''),
(150, 'MUTHU TESTING', '', '', 1, '', '', ''),
(151, 'SONY (M) SDN BHD', '', '', 1, '', '', ''),
(152, 'SEKOLAH MENENGAH LA SALLE PJ', 'JALAN GASING, PETALING JAYA', '03 - 6530 9870', 1, 'lasalle_pj@gmail.com', 'BRO FELIX', ''),
(153, 'SEKOLAH SERI PETALING', '', '', 1, '', '', ''),
(154, 'REGINA DELETE', '', '', 1, '', '', ''),
(156, 'SAMY DELETE', '', '', 1, '', '', ''),
(158, 'RESTORAN CHETTIES KLANG BRANCH', '', '', 1, '', '', ''),
(161, 'JUNIOR', '', '', 1, '', '', ''),
(162, 'testing', '', '', 1, '', '', ''),
(163, 'SELIYAN swaminthan', '', '', 1, '', '', ''),
(164, 'melati abdul hai', '', '', 1, '', '', ''),
(166, 'KUMAR  RAO', '', '', 1, '', '', ''),
(167, 'MARUMAN CORPORATION SDN BHD', '', '', 1, '', '', ''),
(168, 'RAMESH KARUMAN', '', '', 1, '', '', ''),
(169, 'MUTH SAMY', '', '', 1, '', '', ''),
(170, 'McDonald Sdn Bhd', '', '', 1, '', '', ''),
(171, 'GUARDIAN PHARMACY', '', '', 1, '', '', ''),
(172, 'CADBURY CDN BHD', 'PUCHONG, SELANGOR', '09 4500 2312', 2, '', 'MR LEE SOOK KENG', ''),
(173, 'muruga', '', '', 1, '', '', ''),
(174, 'PERBADANAN PENGURUSAN PANGSAPURI DESA PALMA', 'Block C, Ground Floor,\nDesa Palma Apartment\n71800 Nilai, Negeri Sembilan,', '', 1, '', 'Ms. Kithana', ''),
(175, 'ENGINEERING COLLEGE', '', '', 1, '', '', ''),
(176, 'GRAND CITY RESTORAN', '', '', 1, '', '', ''),
(177, 'SAMY', '', '', 1, '', '', ''),
(178, 'MEL SYSTEMS COMPUTER SDN BHD', 'KELANA JAYA', '012 653 9434', 1, 'suhupriya@gmail.com', 'SUHUMARAN', ''),
(179, 'yogeswari', '', '', 1, '', '', ''),
(180, 'barbara', '', '', 1, '', '', ''),
(181, 'MS ALICIA LEGAL SOLITOR', '', '', 1, '', '', ''),
(182, 'thyalan', '', '', 1, '', '', ''),
(183, 'RESTORAN KRISHANA', 'KAMPUNG TUNGKU', '03 6764 8976', 1, 'restorankrishna@gmail.com', 'MR GOPAL', ''),
(184, 'MURAGESU', '', '', 1, '', '', ''),
(185, 'APPLE COMPUTERS', 'CYBERJAYA', '', 1, '', 'MR JOBS', ''),
(186, 'MALAVIKA MENON', '', '', 1, '', '', ''),
(187, 'JAPAN CORPORATION', '', '', 1, '', '', ''),
(188, 'ANITA KERESHWANAN', '', '', 1, '', '', ''),
(189, 'WKV2191', '', '012 653 9434', 1, '', 'SUHUMARAN DURAISAMY', ''),
(190, 'SRS MAINTENANCE SDN BHD', '', '', 1, '', 'MDM LOGES', ''),
(191, 'ASSUNTA SECONDARY SCHOOL', 'JALAN GASING, SELANGOR D.E', '603-7865 9002', 1, 'sister_assunta@hotmail.com', 'SISTER ENDA', ''),
(192, 'special', '', '', 1, '', '', ''),
(193, 'AYURVEDIC CENTRE SUBANG BRANCH', 'SUBANG JAYA SELANGOR', '012 654 9087', 2, 'hari@gmail.com', 'MR HARIHAREN', ''),
(195, 'MPSJ SEPANG COUNCIL', 'SEPANG', '06-8700 9865', 2, 'sepang@gov.com.my', 'ENCIK RAHMAN MOHD', ''),
(196, 'GLENEAGLE MEDICAL CENTRE', 'AMPANG', '012 5690 876', 3, 'ganesh_doctor@gmail.com', 'DOCTOR GANESH', ''),
(197, 'CARTIER WATCH SDN BHD', '', '', 1, '', 'Mr Cartier', ''),
(198, 'WEST PORT HOLDINGS SDN BHD', '', '', 1, '', 'MR GNALINGAM', ''),
(199, 'INTEL CORPORATION', '', '', 1, '', 'MR GROVE', ''),
(200, 'MICROSOFT SDN BHD', 'ampang', '03 5430 0098', 1, 'patrick@gmail.com', 'PATRICK DUTTON', 'klang'),
(201, 'NESTLE SDN BHD', 'NO 34 JALAN SS5C/34 KELANA JAYA', '03 5640 9987', 1, 'kenny_67@gmail.com', 'KENNY TAN', 'SELANGOR'),
(202, 'AAA INSURANCE SDN BHD', 'PENANG TOWN', '09 5439 0098', 1, 'aaa_insurance@gmail.com', 'MADAM AISAH', ''),
(203, 'VOLLEY BALL ASSOCIATION MALAYSIA', 'NO 34 JALAN PETALING STREET, \nKUALA LUMPUR, PENANG', '05 8900 9800', 1, 'volleyball_msia@gmail.com', 'MR KAMARUL', ''),
(204, 'fgfgfgfhfhfhfhfhf', '', '', 1, '', '', ''),
(205, 'ramesh', '', '', 1, '', '', ''),
(206, 'SEREMBAN TELUGU ASSOCIATION', '', '', 1, '', '', ''),
(207, 'RESTORAN KAYU ARA SDN BHD', '', '', 1, '', 'MR KADIR', ''),
(208, 'TNB SDN BHD', '', '', 1, '', '', ''),
(209, 'ASIAN CURRY POT SDN BHD', 'KELANA JAYA', '', 1, '', 'THOMAS RAJ', ''),
(210, 'TOYATA (M) SDN BHD', 'NO 990 JALAN YAP SENG LONG, KL', '03 4300 9951', 1, '', 'MR KARPAL SINGH', ''),
(211, 'KLINIK SIVA SDN BHD', '', '', 1, '', '', ''),
(212, 'SEKOLAH MENENGAH SUNGAI WAY (CINA)', 'SUNGAI WAY', '', 1, '', 'MS LEE SOOK LING', ''),
(213, 'SEKOLAH MENENGAH TAMIL BRICKFILED', '', '', 1, '', '', ''),
(214, 'CHURCH OF LOURDES (TAMPIN)', '', '', 1, '', '', ''),
(215, 'GEORGE KENT SDN BHD', 'PUTRA PERDANA', '03 6549 0087', 1, 'george_kent@hotmail.com', 'MR ALFRED CHONG', 'klang warehouse'),
(216, 'THE CHICKEN RICE SDN BHD', '', '', 2, '', '', ''),
(217, 'DIGI MALAYSIA SDN BHD', '', '', 1, '', '', ''),
(218, 'WATER SUPPLY SDN BHD', '', '', 2, '', '', ''),
(219, 'WATER CLEANER SDN BHD', '', '', 2, '', '', ''),
(220, 'LOTUS CINEMAS SDN BHD', '', '', 2, '', '', ''),
(221, 'LANGKAVI TOURISM SDN BHD', '', '', 2, '', '', ''),
(223, 'Muthu Samy', '', '', 2, '', '', ''),
(224, 'DATO RAVI', '', '', 1, '', '', ''),
(225, 'GREENHILL RESOURCES SDN BHD', 'No 2, Jalan Setia Indah X U13/X\nSetia Alam, 40170 Shah Alam\nSelangor', '', 1, '', '', ''),
(226, 'HP COMPUTER  COMPANY', 'LOT 3232 JALAN PUDU, KUALA LUMPUR', '03 4560 8700', 1, 'hp_computer@gmail.com', 'MR ALEX TAN', ''),
(227, 'AJK 6 ( PORSCHE PANAMERA )', '', '', 1, 'porshe6@gmail.com', 'DR CHOW', ''),
(228, 'PELITA RESTORAN', 'KLCC TOWER', '03-9087 9908', 1, '', 'MR SAID ISKANDAR', ''),
(229, 'SEKOLAH (M) SEAPORT', 'KELANA JAYA', '', 1, '', 'MS MALANI', ''),
(230, 'PEJABAT TANAH DAN GALIAN NEGERI SELANGOR', '', '', 1, '', '', ''),
(231, 'WYK 983 (  MERCEDES BENZ E200 )', '', '', 1, '', 'DATO TONG YM', ''),
(232, 'CASH', '', '', 1, '', '', ''),
(233, 'HICOM GLENMARIE SDN BHD', 'NO 45 JALAN SS15 SUBANG JAYA, \nSELANGOR', '03 5490 8856', 1, 'hicom_glenmarie@gmail.com', 'MR KENNY', ''),
(234, 'WTU 8116 ( PROTON SAGA 1.3 )', '', '', 1, '', 'SKALI', ''),
(235, 'RESTORAN MANI SDN BHD', 'SS2, PETALING JAYA', '', 1, '', 'MR THIRU', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbcustomeraccount`
--

DROP TABLE IF EXISTS `tbcustomeraccount`;
CREATE TABLE IF NOT EXISTS `tbcustomeraccount` (
  `customerAccount_id` int(11) NOT NULL AUTO_INCREMENT,
  `customerAccount_customerID` int(11) NOT NULL DEFAULT '0',
  `customerAccount_date` date NOT NULL,
  `customerAccount_reference` varchar(100) NOT NULL,
  `customerAccount_documentType` varchar(4) NOT NULL,
  `customerAccount_documentTypeID` int(11) NOT NULL DEFAULT '0',
  `customerAccount_description` varchar(100) NOT NULL,
  `customerAccount_debit` decimal(10,2) NOT NULL DEFAULT '0.00',
  `customerAccount_credit` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`customerAccount_id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbcustomeraccount`
--

INSERT INTO `tbcustomeraccount` (`customerAccount_id`, `customerAccount_customerID`, `customerAccount_date`, `customerAccount_reference`, `customerAccount_documentType`, `customerAccount_documentTypeID`, `customerAccount_description`, `customerAccount_debit`, `customerAccount_credit`) VALUES
(1, 94, '2023-07-08', 'INV/2023/001', 'INV', 1, '', '1000.00', '0.00'),
(2, 94, '2023-07-08', 'INV/2023/002', 'INV', 2, '', '1222.80', '0.00'),
(3, 94, '2023-07-08', 'RPT/2023/001', 'PAY', 13, 'PAYMENT', '0.00', '1000.00'),
(4, 208, '2023-07-10', 'PB001', 'PB', 1, 'Payment Bill', '0.00', '45.00'),
(5, 18, '2023-07-10', 'INV/2023/003', 'INV', 3, 'INVOICE', '7000.00', '0.00'),
(6, 18, '2023-07-10', 'CN/2023/001', 'CN', 1, 'CREDIT NOTE', '0.00', '500.00'),
(7, 18, '2023-07-12', 'PB002', 'PB', 2, 'Payment Bill', '0.00', '70.00'),
(8, 94, '2023-07-12', 'INV/2023/004', 'INV', 4, 'INVOICE', '6000.00', '0.00'),
(9, 94, '2023-07-12', 'INV/2023/005', 'INV', 5, 'INVOICE', '7030.50', '0.00'),
(10, 94, '2023-07-12', 'RPT/2023/002', 'PAY', 14, 'PAYMENT', '0.00', '888.00'),
(11, 94, '2023-07-15', 'INV/2023/007', 'INV', 6, 'INVOICE', '4482.88', '0.00'),
(12, 213, '2023-07-17', 'INV/2023/008', 'INV', 7, 'INVOICE', '3000.00', '0.00'),
(13, 76, '2023-07-17', 'INV/2023/009', 'INV', 8, 'INVOICE', '4266.95', '0.00'),
(14, 76, '2023-07-17', 'RPT/2023/003', 'PAY', 15, 'PAYMENT', '0.00', '350.00'),
(15, 174, '2023-07-24', 'INV/2023/010', 'INV', 9, '', '5293.45', '0.00'),
(16, 189, '2023-07-25', 'INV/2023/011', 'INV', 10, 'INVOICE', '3325.95', '0.00'),
(17, 94, '2023-07-25', 'INV/2023/012', 'INV', 11, 'INVOICE', '3325.95', '0.00'),
(18, 18, '2023-08-01', 'INV/2023/013', 'INV', 12, 'INVOICE', '6295.95', '0.00'),
(19, 18, '2023-08-03', 'PV/2023/001', 'PAYV', 1, 'PAYMENT VOUCHER', '70.00', '0.00'),
(20, 132, '2023-08-03', 'INV/2023/014', 'INV', 13, 'INVOICE', '6545.35', '0.00'),
(21, 18, '2023-08-04', 'INV/2023/015', 'INV', 14, 'INVOICE', '7177.65', '0.00'),
(22, 94, '2023-08-10', 'INV/2023/016', 'INV', 15, 'INVOICE', '16902.00', '0.00'),
(23, 18, '2023-08-10', 'INV/2023/017', 'INV', 16, 'INVOICE', '21552.95', '0.00'),
(24, 94, '2023-08-10', 'INV/2023/018', 'INV', 17, 'INVOICE', '4718.09', '0.00'),
(25, 88, '2023-08-12', 'INV/2023/019', 'INV', 18, 'INVOICE', '5088.09', '0.00'),
(26, 76, '2023-08-14', 'INV/2023/020', 'INV', 19, 'INVOICE', '0.00', '0.00'),
(27, 18, '2023-08-14', 'INV/2023/021', 'INV', 20, 'INVOICE', '21116.09', '0.00'),
(28, 231, '2023-08-14', 'INV/2023/022', 'INV', 21, 'INVOICE', '2075.05', '0.00'),
(29, 232, '2023-08-14', 'INV/2023/023', 'INV', 22, 'INVOICE', '6622.70', '0.00'),
(30, 189, '2023-08-15', 'INV/2023/024', 'INV', 23, 'INVOICE', '3998.65', '0.00'),
(31, 202, '2023-08-16', 'INV/2023/025', 'INV', 24, 'INVOICE', '88311.70', '0.00'),
(32, 189, '2023-08-17', 'INV/2023/026', 'INV', 25, 'INVOICE', '18186.29', '0.00'),
(34, 118, '2023-08-17', 'INV/2023/027', 'INV', 27, 'INVOICE', '600.02', '0.00'),
(35, 202, '2023-08-17', 'INV/2023/028', 'INV', 28, 'INVOICE', '2319.18', '0.00'),
(36, 200, '2023-08-17', 'INV/2023/029', 'INV', 29, 'INVOICE', '414534.20', '0.00'),
(37, 132, '2023-08-23', 'INV/2023/030', 'INV', 30, '', '14793.85', '0.00'),
(38, 95, '2023-08-23', 'INV/2023/031', 'INV', 31, '', '13121.55', '0.00'),
(39, 94, '2023-08-25', 'INV/2023/032', 'INV', 32, 'INVOICE', '5455.95', '0.00'),
(40, 94, '2023-08-25', 'RPT/2023/005', 'PAY', 16, 'PAYMENT', '0.00', '48250.17'),
(41, 94, '2023-08-25', 'INV/2023/033', 'INV', 33, 'INVOICE', '3900.95', '0.00'),
(42, 88, '2023-08-26', 'INV/2023/034', 'INV', 34, 'INVOICE', '0.00', '0.00'),
(43, 233, '2023-08-27', '', 'MAD', 0, 'BALANCE C/F', '7000.00', '0.00'),
(44, 233, '2023-08-27', 'INV/2023/035', 'INV', 35, 'INVOICE', '13492.62', '0.00'),
(45, 172, '2023-09-01', 'INV/2023/036', 'INV', 36, 'INVOICE', '1408.77', '0.00'),
(46, 234, '2023-09-02', 'INV/2023/037', 'INV', 37, 'INVOICE', '1935.00', '0.00'),
(47, 234, '2023-09-05', 'RPT/2023/006', 'PAY', 17, 'PAYMENT', '0.00', '33.00'),
(48, 221, '2023-09-05', 'PB003', 'PB', 3, 'Payment Bill', '0.00', '700.00'),
(49, 118, '2023-09-05', 'INV/2023/038', 'INV', 38, '', '3700.00', '0.00'),
(50, 146, '2023-09-05', 'INV/2023/039', 'INV', 39, '', '13121.55', '0.00'),
(51, 235, '2023-09-07', 'INV/2023/040', 'INV', 40, 'INVOICE', '5000.00', '0.00'),
(52, 132, '2023-09-07', 'INV/2023/041', 'INV', 41, 'INVOICE', '888.00', '0.00'),
(53, 94, '2023-09-07', 'INV/2023/042', 'INV', 42, 'INVOICE', '999.00', '0.00'),
(54, 87, '2023-09-07', 'INV/2023/043', 'INV', 43, 'INVOICE', '6565.00', '0.00'),
(55, 18, '2023-09-07', 'INV/2023/045', 'INV', 44, 'INVOICE', '1717.00', '0.00'),
(56, 132, '2023-09-08', 'INV/2023/046', 'INV', 45, '', '666.00', '0.00'),
(57, 76, '2023-09-08', 'INV/2023/047', 'INV', 46, '', '3232.00', '0.00'),
(58, 19, '2023-09-08', 'INV/2023/048', 'INV', 47, '', '29700.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbdeliveryorder`
--

DROP TABLE IF EXISTS `tbdeliveryorder`;
CREATE TABLE IF NOT EXISTS `tbdeliveryorder` (
  `deliveryOrder_id` int(11) NOT NULL AUTO_INCREMENT,
  `deliveryOrder_no` varchar(30) NOT NULL,
  `deliveryOrder_date` date NOT NULL,
  `deliveryOrder_customerID` int(11) NOT NULL,
  `deliveryOrder_title` varchar(200) NOT NULL,
  `deliveryOrder_from` varchar(50) NOT NULL,
  `deliveryOrder_terms` text NOT NULL,
  `deliveryOrder_attention` varchar(100) NOT NULL,
  `deliveryOrder_email` varchar(100) NOT NULL,
  `deliveryOrder_subTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `deliveryOrder_taxTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `deliveryOrder_grandTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `deliveryOrder_discountTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `deliveryOrder_totalAfterDiscount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `deliveryOrder_roundAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `deliveryOrder_grandTotalRound` decimal(10,2) NOT NULL DEFAULT '0.00',
  `deliveryOrder_roundStatus` int(1) NOT NULL DEFAULT '0',
  `deliveryOrder_content` text NOT NULL,
  `deliveryOrder_quotationNo` varchar(30) NOT NULL,
  `deliveryOrder_quotationID` int(11) NOT NULL DEFAULT '0',
  `deliveryOrder_invoiceNo` varchar(30) NOT NULL,
  `deliveryOrder_invoiceID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`deliveryOrder_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbdeliveryorder`
--

INSERT INTO `tbdeliveryorder` (`deliveryOrder_id`, `deliveryOrder_no`, `deliveryOrder_date`, `deliveryOrder_customerID`, `deliveryOrder_title`, `deliveryOrder_from`, `deliveryOrder_terms`, `deliveryOrder_attention`, `deliveryOrder_email`, `deliveryOrder_subTotal`, `deliveryOrder_taxTotal`, `deliveryOrder_grandTotal`, `deliveryOrder_discountTotal`, `deliveryOrder_totalAfterDiscount`, `deliveryOrder_roundAmount`, `deliveryOrder_grandTotalRound`, `deliveryOrder_roundStatus`, `deliveryOrder_content`, `deliveryOrder_quotationNo`, `deliveryOrder_quotationID`, `deliveryOrder_invoiceNo`, `deliveryOrder_invoiceID`) VALUES
(1, 'DO/2023/001', '2023-07-08', 94, '', '', '<p><strong>Delivery Order Terms</strong></p><p>a.) All necessary documentation permit to enter the jobsite shall be arranged by the Hirer.<br />b.) All lifting Gears to be provided by the Hirer.<br />c.) Sunday &amp; Public Holiday considered as overtime and minimum 8hrs.</p>', 'MR RAMESH / SHOBA', 'admin@clean_sewers.com', '1222.80', '0.00', '1222.80', '0.00', '1222.80', '0.00', '1222.80', 0, '', '', 0, 'INV/2023/002', 2),
(2, 'DO/2023/002', '2023-08-17', 200, '', '', '<p><strong>Delivery Order Terms</strong></p><p>a.) All necessary documentation permit to enter the jobsite shall be arranged by the Hirer.<br />b.) All lifting Gears to be provided by the Hirer.<br />c.) Sunday &amp; Public Holiday considered as overtime and minimum 8hrs.</p>', 'PATRICK DUTTON', 'patrick@gmail.com', '412796.20', '1747.50', '414534.22', '9.48', '412786.72', '-0.02', '414534.20', 1, '', '', 0, 'INV/2023/029', 29),
(3, 'DO/2023/003', '2023-08-23', 132, 'SENT PARTS TO IPOH AND ALL THE PORT KLANG ( BY AIR KARGO YT00098764-89  rap tank waste collected from HAIDILAO INTERNATIONAL FOOD SERVICES MALAYSIA', 'Mr Alex Teoh', '<p><strong>Delivery Order Terms</strong></p><p>a.) All necessary documentation permit to enter the jobsite shall be arranged by the Hirer.<br />b.) All lifting Gears to be provided by the Hirer.<br />c.) Sunday &amp; Public Holiday considered as overtime and minimum 8hrs.</p>', 'MR ALI KAMARUDDIN', 'care@iwk.com.my', '4004.95', '0.00', '4004.95', '0.00', '4004.95', '0.00', '4004.95', 0, '<p>SENT PARTS TO IPOH AND ALL THE PORT KLANG ( BY AIR KARGO YT00098764-89 &nbsp;rap tank waste collected from</p><p>HAIDILAO INTERNATIONAL FOOD SERVICES MALAYSIA</p>', '', 0, '', 0),
(4, 'DO/2023/004', '2023-08-26', 189, '', '', '<p><strong>Delivery Order Terms</strong></p><p>a.) All necessary documentation permit to enter the jobsite shall be arranged by the Hirer.<br />b.) All lifting Gears to be provided by the Hirer.<br />c.) Sunday &amp; Public Holiday considered as overtime and minimum 8hrs.</p>', 'MR SUHUMARAN DURAISAMY', '', '18168.65', '17.64', '18186.29', '0.00', '18168.65', '0.00', '18186.29', 0, '', '', 0, 'INV/2023/026', 25),
(5, 'DO/2023/005', '2023-09-05', 146, '', '', '<p><strong>Delivery Order Terms</strong></p><p>a.) All necessary documentation permit to enter the jobsite shall be arranged by the Hirer.<br />b.) All lifting Gears to be provided by the Hirer.<br />c.) Sunday &amp; Public Holiday considered as overtime and minimum 8hrs.</p>', 'CIKGU RAMESH', '', '13121.55', '0.00', '13121.55', '0.00', '13121.55', '0.00', '13121.55', 0, '<p>SENT PARTS TO IPOH AND ALL THE PORT KLANG ( BY AIR KARGO YT00098764-89 &nbsp;rap tank waste collected from HAIDILAO INTERNATIONAL FOOD SERVICES MALAYSIA SDN BHD</p>', 'QO/2023/010', 9, 'INV/2023/039', 39),
(6, 'DO/2023/006', '2023-09-08', 76, '', '', '<p><strong>Delivery Order Terms</strong></p><p>a.) All necessary documentation permit to enter the jobsite shall be arranged by the Hirer.<br />b.) All lifting Gears to be provided by the Hirer.<br />c.) Sunday &amp; Public Holiday considered as overtime and minimum 8hrs.</p>', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', '', '3232.00', '0.00', '3232.00', '0.00', '3232.00', '0.00', '3232.00', 0, '', 'QO/2023/012', 11, 'INV/2023/047', 46),
(7, 'DO/2023/007', '2023-09-08', 19, '', '', '<p><strong>Delivery Order Terms</strong></p><p>a.) All necessary documentation permit to enter the jobsite shall be arranged by the Hirer.<br />b.) All lifting Gears to be provided by the Hirer.<br />c.) Sunday &amp; Public Holiday considered as overtime and minimum 8hrs.</p>', '', '', '29700.00', '0.00', '29700.00', '0.00', '29700.00', '0.00', '29700.00', 0, '', '', 0, 'INV/2023/048', 47);

-- --------------------------------------------------------

--
-- Table structure for table `tbdeliveryorderdetail`
--

DROP TABLE IF EXISTS `tbdeliveryorderdetail`;
CREATE TABLE IF NOT EXISTS `tbdeliveryorderdetail` (
  `deliveryOrderDetail_id` int(11) NOT NULL AUTO_INCREMENT,
  `deliveryOrderDetail_deliveryOrderID` int(10) NOT NULL,
  `deliveryOrderDetail_no1` varchar(200) NOT NULL,
  `deliveryOrderDetail_no2` varchar(200) NOT NULL,
  `deliveryOrderDetail_no3` decimal(10,2) NOT NULL DEFAULT '0.00',
  `deliveryOrderDetail_no4` varchar(200) NOT NULL,
  `deliveryOrderDetail_bold` int(11) NOT NULL DEFAULT '0' COMMENT '0=normal, 1=bold',
  `deliveryOrderDetail_sortID` int(2) NOT NULL DEFAULT '0',
  `deliveryOrderDetail_no5` decimal(10,2) NOT NULL DEFAULT '0.00',
  `deliveryOrderDetail_rowTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `deliveryOrderDetail_taxRateID` int(10) NOT NULL DEFAULT '0',
  `deliveryOrderDetail_taxPercent` decimal(10,2) NOT NULL DEFAULT '0.00',
  `deliveryOrderDetail_taxTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `deliveryOrderDetail_rowGrandTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `deliveryOrderDetail_discountPercent` decimal(10,2) NOT NULL DEFAULT '0.00',
  `deliveryOrderDetail_discountAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `deliveryOrderDetail_rowTotalAfterDiscount` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`deliveryOrderDetail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbdeliveryorderdetail`
--

INSERT INTO `tbdeliveryorderdetail` (`deliveryOrderDetail_id`, `deliveryOrderDetail_deliveryOrderID`, `deliveryOrderDetail_no1`, `deliveryOrderDetail_no2`, `deliveryOrderDetail_no3`, `deliveryOrderDetail_no4`, `deliveryOrderDetail_bold`, `deliveryOrderDetail_sortID`, `deliveryOrderDetail_no5`, `deliveryOrderDetail_rowTotal`, `deliveryOrderDetail_taxRateID`, `deliveryOrderDetail_taxPercent`, `deliveryOrderDetail_taxTotal`, `deliveryOrderDetail_rowGrandTotal`, `deliveryOrderDetail_discountPercent`, `deliveryOrderDetail_discountAmount`, `deliveryOrderDetail_rowTotalAfterDiscount`) VALUES
(1, 1, '', 'CALENDAR FOR YEAR 2023 INCLUDING STICKERS MICKEY MOUSE', '24.00', 'PCS', 0, 1, '50.95', '1222.80', 1, '0.00', '0.00', '1222.80', '0.00', '0.00', '1222.80'),
(2, 1, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(3, 1, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(4, 1, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(5, 1, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(6, 2, '', 'WORK SCOPE', '0.00', '', 0, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(7, 2, '1', 'CALENDAR FOR YEAR 2023 INCLUDING STICKERS MICKEY MOUSE', '1.00', 'PCS', 0, 2, '50.95', '50.95', 2, '6.00', '3.06', '54.01', '0.00', '0.00', '50.95'),
(8, 2, '2', 'NOKIA CHARGER TYPE CARBON 4598BK', '1.00', 'UNIT', 0, 3, '59.00', '59.00', 1, '0.00', '0.00', '56.05', '5.00', '2.95', '56.05'),
(9, 2, '3', 'DHLD PACKAGE DELIVERY CHARGES', '1.00', 'LOT', 0, 4, '50.00', '50.00', 1, '0.00', '0.00', '50.00', '0.00', '0.00', '50.00'),
(10, 2, '4', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '2.00', 'LOT', 0, 5, '3700.00', '7400.00', 1, '0.00', '0.00', '7400.00', '0.00', '0.00', '7400.00'),
(11, 2, '5', 'MAZDA X5 TYRE CHANGE 175/90PSI JAPAN MADE', '1.00', 'PCS', 0, 6, '130.50', '130.50', 4, '34.00', '42.15', '166.12', '5.00', '6.53', '123.97'),
(12, 2, '6', 'COMPUTER DELL XPS 15 16GB RAM 512GB SSD INTEL I9 PROCESSOR', '1.00', 'PCS', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(13, 2, '', 'TOP RADIATOR HOSE ORIGINAL', '0.00', 'litre', 0, 8, '0.00', '0.00', 6, '1.50', '0.00', '0.00', '3.00', '0.00', '0.00'),
(14, 2, '1', 'RATTAN CHAIR (japan made)', '0.00', 'PCS', 0, 9, '99.00', '99.00', 1, '0.00', '0.00', '99.00', '0.00', '0.00', '99.00'),
(15, 2, '2', 'MOTOROLLA HANDPHONE MODEL X-9', '1.00', 'unit', 0, 10, '5006.75', '5006.75', 4, '34.00', '1702.30', '6709.05', '0.00', '0.00', '5006.75'),
(16, 2, '3', 'TEAK WOOD IKEA TABLE 5 X 7 FEET', '4.00', 'PCS', 0, 11, '100000.00', '400000.00', 1, '0.00', '0.00', '400000.00', '0.00', '0.00', '400000.00'),
(62, 3, '1.', 'CALENDAR FOR YEAR 2023 INCLUDING STICKERS MICKEY MOUSE', '0.00', 'PCS', 0, 1, '50.95', '50.95', 1, '0.00', '0.00', '50.95', '0.00', '0.00', '50.95'),
(63, 3, '2.', 'REMOVE WINDSCREEN AND TINTING WORKS DONE FOR THE WHOLE CAR', '0.00', 'UNITS', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(64, 3, '3.', 'FRANCE PERFUME ( LAVENDAR SMELL)', '0.00', '', 0, 3, '98.00', '98.00', 1, '0.00', '0.00', '98.00', '0.00', '0.00', '98.00'),
(65, 3, '4.', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', 'bundles', 0, 4, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(66, 3, '5.', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '0.00', 'LOT', 0, 5, '3700.00', '3700.00', 1, '0.00', '0.00', '3700.00', '0.00', '0.00', '3700.00'),
(67, 3, '', '', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(68, 3, '', '', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(69, 3, '', 'COMPUTER HP 16GB RAM 256 GB RAM JAPAN MADE', '0.00', 'PC', 1, 8, '100.00', '100.00', 1, '0.00', '0.00', '100.00', '0.00', '0.00', '100.00'),
(70, 3, '', '', '0.00', '', 0, 9, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(82, 4, '1.', 'APPLE CIDER', '3.00', 'bottles', 0, 1, '111.00', '333.00', 1, '0.00', '0.00', '333.00', '0.00', '0.00', '333.00'),
(83, 4, '2.', 'CAR AIRCOND REFILL GAS AND SERVICE', '3.00', '', 0, 2, '99.65', '298.95', 1, '0.00', '0.00', '298.95', '0.00', '0.00', '298.95'),
(84, 4, '3.', 'CALENDAR FOR YEAR 2023 INCLUDING STICKERS MICKEY MOUSE', '0.00', 'PCS', 0, 3, '50.95', '50.95', 1, '0.00', '0.00', '50.95', '0.00', '0.00', '50.95'),
(85, 4, '4.', 'COMPUTER HP 16GB RAM 256 GB RAM JAPAN MADE', '0.00', 'PC', 0, 4, '100.00', '100.00', 1, '0.00', '0.00', '100.00', '0.00', '0.00', '100.00'),
(86, 4, '5.', 'FRANCE PERFUME ( LAVENDAR SMELL)', '3.00', '', 0, 5, '98.00', '294.00', 2, '6.00', '17.64', '311.64', '0.00', '0.00', '294.00'),
(87, 4, '6.', 'CAR DENT KNOCKING AND PAINTING', '0.00', 'LOT', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(88, 4, '7.', 'CHANGE CAR TYRES', '0.00', 'PERSON', 0, 7, '66.00', '66.00', 1, '0.00', '0.00', '66.00', '0.00', '0.00', '66.00'),
(89, 4, '', 'LABOUR', '0.00', '', 1, 8, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(90, 4, '1.', 'CAR POLISH 2.5 LITRES', '0.00', 'BOX', 0, 9, '19.00', '19.00', 1, '0.00', '0.00', '19.00', '0.00', '0.00', '19.00'),
(91, 4, '2.', 'MOTOROLLA HANDPHONE MODEL X-9', '0.00', 'unit', 0, 10, '5006.75', '5006.75', 1, '0.00', '0.00', '5006.75', '0.00', '0.00', '5006.75'),
(92, 4, '3.', 'GRAND TURISMO 2.4', '0.00', 'UNIT', 0, 11, '12000.00', '12000.00', 1, '0.00', '0.00', '12000.00', '0.00', '0.00', '12000.00'),
(93, 5, '', 'BUTTER CHICKEN', '0.00', 'pcs', 0, 1, '67.55', '67.55', 1, '0.00', '0.00', '67.55', '0.00', '0.00', '67.55'),
(94, 5, '', 'PREPARE HOUSE TENANCY AGREEMENT FOR CUSTOMER FOR THE YEAR 2023 AND 2024', '0.00', 'LOT', 0, 2, '900.00', '900.00', 1, '0.00', '0.00', '900.00', '0.00', '0.00', '900.00'),
(95, 5, '', 'FRANCE PERFUME ( LAVENDAR SMELL)', '0.00', '', 0, 3, '98.00', '98.00', 1, '0.00', '0.00', '98.00', '0.00', '0.00', '98.00'),
(96, 5, '', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', 'bundles', 0, 4, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(97, 5, '', 'GRAND TURISMO 2.4', '0.00', 'UNIT', 0, 5, '12000.00', '12000.00', 1, '0.00', '0.00', '12000.00', '0.00', '0.00', '12000.00'),
(98, 6, '', '', '0.00', '', 0, 1, '3232.00', '3232.00', 1, '0.00', '0.00', '3232.00', '0.00', '0.00', '3232.00'),
(99, 6, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(100, 6, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(101, 6, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(102, 6, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(103, 7, '', 'COMPUTER DELL XPS 15 16GB RAM 512GB SSD INTEL I9 PROCESSOR', '34.00', 'PCS', 0, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(104, 7, '', 'PREPARE HOUSE TENANCY AGREEMENT FOR CUSTOMER FOR THE YEAR 2023 AND 2024', '33.00', 'LOT', 0, 2, '900.00', '29700.00', 1, '0.00', '0.00', '29700.00', '0.00', '0.00', '29700.00'),
(105, 7, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(106, 7, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(107, 7, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbinvoice`
--

DROP TABLE IF EXISTS `tbinvoice`;
CREATE TABLE IF NOT EXISTS `tbinvoice` (
  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_no` varchar(30) NOT NULL,
  `invoice_date` date NOT NULL,
  `invoice_customerID` int(11) NOT NULL,
  `invoice_title` varchar(200) NOT NULL,
  `invoice_from` varchar(50) NOT NULL,
  `invoice_terms` text NOT NULL,
  `invoice_attention` varchar(100) NOT NULL,
  `invoice_email` varchar(100) NOT NULL,
  `invoice_subTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invoice_taxTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invoice_grandTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invoice_discountTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invoice_totalAfterDiscount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invoice_roundAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invoice_grandTotalRound` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invoice_roundStatus` int(1) NOT NULL DEFAULT '0',
  `invoice_content` text NOT NULL,
  `invoice_quotationNo` varchar(30) NOT NULL,
  `invoice_quotationID` int(11) NOT NULL DEFAULT '0',
  `invoice_deliveryOrderNo` varchar(30) NOT NULL,
  `invoice_deliveryOrderID` int(11) NOT NULL DEFAULT '0',
  `invoice_dueDate` date NOT NULL,
  `invoice_dueDateNo` int(3) NOT NULL DEFAULT '0',
  `invoice_creditNote` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invoice_debitNote` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invoice_paid` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invoice_status` varchar(1) NOT NULL DEFAULT 'a' COMMENT 'a = active, c = cancelled',
  PRIMARY KEY (`invoice_id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbinvoice`
--

INSERT INTO `tbinvoice` (`invoice_id`, `invoice_no`, `invoice_date`, `invoice_customerID`, `invoice_title`, `invoice_from`, `invoice_terms`, `invoice_attention`, `invoice_email`, `invoice_subTotal`, `invoice_taxTotal`, `invoice_grandTotal`, `invoice_discountTotal`, `invoice_totalAfterDiscount`, `invoice_roundAmount`, `invoice_grandTotalRound`, `invoice_roundStatus`, `invoice_content`, `invoice_quotationNo`, `invoice_quotationID`, `invoice_deliveryOrderNo`, `invoice_deliveryOrderID`, `invoice_dueDate`, `invoice_dueDateNo`, `invoice_creditNote`, `invoice_debitNote`, `invoice_paid`, `invoice_status`) VALUES
(1, 'INV/2023/001', '2023-07-08', 94, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li></ul>', 'MR RAMESH / SHOBA', 'admin@clean_sewers.com', '1000.00', '0.00', '1000.00', '0.00', '1000.00', '0.00', '1000.00', 0, '', 'QO/2023/001', 1, '', 0, '2023-07-23', 15, '0.00', '0.00', '1000.00', 'a'),
(2, 'INV/2023/002', '2023-07-08', 94, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li></ul>', 'MR RAMESH / SHOBA', '', '1222.80', '0.00', '1222.80', '0.00', '1222.80', '0.00', '1222.80', 0, '', '', 0, 'DO/2023/001', 1, '2023-07-23', 15, '0.00', '0.00', '1222.80', 'a'),
(3, 'INV/2023/003', '2023-07-10', 18, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li></ul>', 'ENCIK KAMARUDDIN', 'fn_malaysia@gmail.com', '7000.00', '0.00', '7000.00', '0.00', '7000.00', '0.00', '7000.00', 0, '', '', 0, '', 0, '2023-07-25', 15, '500.00', '0.00', '0.00', 'a'),
(4, 'INV/2023/004', '2023-07-12', 94, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li></ul>', 'MR RAMESH / SHOBA', 'admin@clean_sewers.com', '6000.00', '0.00', '6000.00', '0.00', '6000.00', '0.00', '6000.00', 0, '', '', 0, '', 0, '2023-07-27', 15, '0.00', '0.00', '6000.00', 'a'),
(5, 'INV/2023/005', '2023-07-12', 94, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li></ul>', 'MR RAMESH / SHOBA', 'admin@clean_sewers.com', '7030.50', '0.00', '7030.50', '0.00', '7030.50', '0.00', '7030.50', 0, '', '', 0, '', 0, '2023-07-27', 15, '0.00', '0.00', '7030.50', 'a'),
(6, 'INV/2023/007', '2023-07-15', 94, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li></ul>', 'MR RAMESH / SHOBA', 'admin@clean_sewers.com', '4492.00', '0.00', '4482.88', '9.12', '4482.88', '0.00', '4482.88', 0, '', '', 0, '', 0, '2023-07-30', 15, '0.00', '0.00', '4482.88', 'a'),
(7, 'INV/2023/008', '2023-07-17', 213, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li></ul>', '', '', '3000.00', '0.00', '3000.00', '0.00', '3000.00', '0.00', '3000.00', 0, '', '', 0, '', 0, '2023-08-01', 15, '0.00', '0.00', '0.00', 'a'),
(8, 'INV/2023/009', '2023-07-17', 76, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li></ul>', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', '', '4266.95', '0.00', '4266.95', '0.00', '4266.95', '0.00', '4266.95', 0, '', '', 0, '', 0, '2023-08-01', 15, '0.00', '0.00', '350.00', 'a'),
(9, 'INV/2023/010', '2023-07-24', 174, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li></ul>', 'Ms Kirthana', '', '4953.45', '340.00', '5293.45', '0.00', '4953.45', '0.00', '5293.45', 0, '', 'QO/2023/002', 2, '', 0, '2023-08-08', 15, '0.00', '0.00', '0.00', 'a'),
(10, 'INV/2023/011', '2023-07-25', 189, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li></ul>', 'SUHUMARAN DURAISAMY', '', '3501.00', '0.00', '3325.95', '175.05', '3325.95', '0.00', '3325.95', 1, '', '', 0, '', 0, '2023-08-09', 15, '0.00', '0.00', '0.00', 'a'),
(11, 'INV/2023/012', '2023-07-25', 94, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li></ul>', 'MR RAMESH / SHOBA', 'admin@clean_sewers.com', '3501.00', '0.00', '3325.95', '175.05', '3325.95', '0.00', '3325.95', 1, '', '', 0, '', 0, '2023-08-09', 15, '0.00', '0.00', '3325.95', 'a'),
(12, 'INV/2023/013', '2023-08-01', 18, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li></ul>', 'ENCIK KAMARUDDIN', 'fn_malaysia@gmail.com', '6471.00', '0.00', '6295.95', '175.05', '6295.95', '0.00', '6295.95', 1, '', '', 0, '', 0, '2023-08-16', 15, '0.00', '0.00', '0.00', 'a'),
(13, 'INV/2023/014', '2023-08-03', 132, 'TRANSPORT ALL PARTS TO CONTAINTER ( PORT KLANG TO KEDAH JITRA)', 'Andreas', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li><li>Once work done, payment to be paid within 30 days maximum from work completion date.</li></ul>', 'MR ALI KAMARUDDIN', 'care@iwk.com.my', '6669.00', '63.28', '6545.35', '186.93', '6482.07', '0.00', '6545.35', 1, '<p>Please send all this parts to the desiganted area. All parts need to be checked throughly before sending to&nbsp;<strong>Alor Star</strong>.</p><p>Accept the delayed electrical parts as well.</p>', '', 0, '', 0, '2023-08-18', 15, '0.00', '0.00', '0.00', 'a'),
(14, 'INV/2023/015', '2023-08-04', 18, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li></ul>', 'ENCIK KAMARUDDIN', 'fn_malaysia@gmail.com', '7171.00', '223.72', '7177.67', '217.05', '6953.95', '-0.02', '7177.65', 1, '<p>Please send all this parts to the desiganted area. All parts need to be checked throughly before sending to&nbsp;<strong>Alor Star</strong>.</p><p>Accept the delayed electrical parts as well.</p>', '', 0, '', 0, '2023-08-19', 15, '0.00', '0.00', '0.00', 'a'),
(15, 'INV/2023/016', '2023-08-10', 94, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li></ul>', 'MR RAMESH / SHOBA', 'admin@clean_sewers.com', '16902.00', '0.00', '16902.00', '0.00', '16902.00', '0.00', '16902.00', 0, '', '', 0, '', 0, '2023-08-25', 15, '0.00', '0.00', '16902.00', 'a'),
(16, 'INV/2023/017', '2023-08-10', 18, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li></ul>', 'ENCIK KAMARUDDIN', 'fn_malaysia@gmail.com', '21552.95', '0.00', '21552.95', '0.00', '21552.95', '0.00', '21552.95', 0, '', '', 0, '', 0, '2023-08-25', 15, '0.00', '0.00', '0.00', 'a'),
(17, 'INV/2023/018', '2023-08-10', 94, 'TRANSPORT ALL PARTS TO CONTAINTER ( PORT KLANG TO KEDAH JITRA)', 'Mr Amedeus', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li><li>Our payment terms is 30 days and 5% interest per day after that will be charged.</li></ul>', 'MR RAMESH / SHOBA', 'admin@clean_sewers.com', '4697.95', '34.00', '4718.09', '13.86', '4684.09', '0.00', '4718.09', 0, '<p>KSN Sewerage Engineering Service takes full responsibility on all Grease Trap tank waste collected from HAIDILAO INTERNATIONAL FOOD SERVICES MALAYSIA SDN BHD</p>', '', 0, '', 0, '2023-08-25', 15, '0.00', '0.00', '4718.09', 'a'),
(18, 'INV/2023/019', '2023-08-12', 88, 'SENT PARTS TO IPOH AND ALL THE PORT KLANG ( BY AIR KARGO YT00098764-89  rap tank waste collected from HAIDILAO INTERNATIONAL FOOD SERVICES MALAYSIA SDN BHD', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li></ul>', 'MR HUAT', 'ken_huat89@gmail.com', '4697.95', '404.00', '5088.09', '13.86', '4684.09', '0.00', '5088.09', 0, '<p>KSN Sewerage Engineering Service takes full responsibility on all Grease Trap tank waste collected from HAIDILAO INTERNATIONAL FOOD SERVICES MALAYSIA SDN BHD<br />We collect all the Grease waste and send to our main waste disposal vendor VPJ PLUMBING &amp; SANITARY SERVICES. (Company No 000889704-A).&nbsp;</p><p>SENT PARTS TO IPOH AND ALL THE PORT KLANG ( BY AIR KARGO YT00098764-89 &nbsp;rap tank waste collected from HAIDILAO INTERNATIONAL FOOD SERVICES&nbsp;</p>', '', 0, '', 0, '2023-08-27', 15, '0.00', '0.00', '0.00', 'a'),
(19, 'INV/2023/020', '2023-08-14', 76, '', 'Mr Navin Paramasivam', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li></ul>', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', 'kavita@hotmail.com', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0, '', '', 0, '', 0, '2023-08-29', 15, '0.00', '0.00', '0.00', 'a'),
(20, 'INV/2023/021', '2023-08-14', 18, 'SENT PARTS TO IPOH AND ALL THE PORT KLANG ( BY AIR KARGO YT00098764-89  rap tank waste collected from HAIDILAO INTERNATIONAL FOOD SERVICES MALAYSIA', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li><li>Our payment terms is 30 days and 5% interest per day after that will be charged.<br />&nbsp;</li></ul>', 'ENCIK KAMARUDDIN AHMAD', 'fn_malaysia@gmail.com', '18545.95', '2584.00', '21116.09', '13.86', '18532.09', '0.00', '21116.09', 0, '<p>KSN Sewerage Engineering Service takes full responsibility on all Grease Trap tank waste collected from HAIDILAO INTERNATIONAL FOOD SERVICES MALAYSIA SDN BHD<br />We collect all the Grease waste and send to our main waste disposal vendor VPJ PLUMBING &amp; SANITARY SERVICES. (Company No 000889704-A).&nbsp;</p>', '', 0, '', 0, '2023-08-29', 15, '0.00', '0.00', '0.00', 'a'),
(21, 'INV/2023/022', '2023-08-14', 231, 'CAR REPAIR AND SERVICING INCLUDING AIR COND', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li></ul>', 'DATO TONG YM', '', '2075.05', '0.00', '2075.05', '0.00', '2075.05', '0.00', '2075.05', 0, '<p>PLEASE REMEMBER TO CHECK OIL EVERYDAY.</p><p>NEXT MILLEAGE IS 45000 KM AND <strong>BLACK OIL CHANGE RECOMMENDED.</strong></p>', '', 0, '', 0, '2023-08-29', 15, '0.00', '0.00', '0.00', 'a'),
(22, 'INV/2023/023', '2023-08-14', 232, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li></ul>', '', '', '6622.70', '0.00', '6622.70', '0.00', '6622.70', '0.00', '6622.70', 0, '<p>SENT PARTS TO IPOH AND ALL THE PORT KLANG ( BY AIR KARGO YT00098764-89 &nbsp;rap tank waste collected from HAIDILAO INTERNATIONAL FOOD SERVICES MALAYSIA SDN BHD</p>', '', 0, '', 0, '2023-08-29', 15, '0.00', '0.00', '0.00', 'a'),
(23, 'INV/2023/024', '2023-08-15', 189, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li></ul>', 'SUHUMARAN DURAISAMY', 'kavita@hotmail.com', '3998.65', '0.00', '3998.65', '0.00', '3998.65', '0.00', '3998.65', 0, '', '', 0, '', 0, '2023-08-30', 15, '0.00', '0.00', '0.00', 'a'),
(24, 'INV/2023/025', '2023-08-16', 202, 'TRANSPORT TO PORT KLANG TO KLUANG ( BY AIR CARGO N0 98944-976/87 )', 'Mr Hassan Ayob', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li><li>Transport charges shall be borne by the customer and paid on COD basics.</li></ul>', 'MADAM AISAH', 'aaa_insurance@gmail.com', '88311.65', '0.06', '88311.71', '0.00', '88311.65', '-0.01', '88311.70', 1, '<p>KSN Sewerage Engineering Service takes full responsibility on all Grease Trap tank waste collected from <strong>HAIDILAO INTERNATIONAL FOOD SERVICES&nbsp;</strong><strong>MALAYSIA SDN BHD</strong>. We collect all the Grease waste and send to our main waste disposal vendor&nbsp;<strong>VPJ PLUMBING &amp; SANITARY SERVICES</strong>. (Company No 000889704-A).&nbsp;</p>', '', 0, '', 0, '2023-08-31', 15, '0.00', '0.00', '0.00', 'a'),
(25, 'INV/2023/026', '2023-08-17', 189, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li><li>Our payment terms is 30 days and 5% interest per day after that will be charged.</li></ul>', 'MR SUHUMARAN DURAISAMY', '', '18168.65', '17.64', '18186.29', '0.00', '18168.65', '0.00', '18186.29', 0, '', '', 0, 'DO/2023/004', 4, '2023-09-01', 15, '0.00', '0.00', '0.00', 'a'),
(27, 'INV/2023/027', '2023-08-17', 118, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li><li>Our payment terms is 30 days and 5% interest per day after that will be charged.</li></ul>', '', '', '600.02', '0.00', '600.02', '0.00', '600.02', '0.00', '600.02', 0, '<p>.</p>', '', 0, '', 0, '2023-09-01', 15, '0.00', '0.00', '0.00', 'a'),
(28, 'INV/2023/028', '2023-08-17', 202, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li><li>Our payment terms is 30 days and 5% interest per day after that will be charged.</li></ul>', 'MADAM AISAH', 'aaa_insurance@gmail.com', '2319.18', '0.00', '2319.18', '0.00', '2319.18', '0.00', '2319.18', 0, '', '', 0, '', 0, '2023-09-01', 15, '0.00', '0.00', '0.00', 'a'),
(29, 'INV/2023/029', '2023-08-17', 200, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li><li>Our payment terms is 30 days and 5% interest per day after that will be charged.</li></ul>', 'PATRICK DUTTON', 'patrick@gmail.com', '412796.20', '1747.50', '414534.22', '9.48', '412786.72', '-0.02', '414534.20', 1, '', '', 0, 'DO/2023/002', 2, '2023-09-01', 15, '0.00', '0.00', '0.00', 'a'),
(30, 'INV/2023/030', '2023-08-23', 132, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li><li>Our payment terms is 30 days and 5% interest per day after that will be charged.</li></ul>', 'MR ALI KAMARUDDIN', 'care@iwk.com.my', '14412.65', '568.80', '14793.85', '187.60', '14225.05', '0.00', '14793.85', 0, '<p>Please send all the Drawings and report from MPPJ Selangor. All other related works need to get MPSJ Subang approval first.</p><p>Please acknowledge delivery of report.</p>', 'QO/2023/007', 6, '', 0, '2023-09-07', 15, '0.00', '0.00', '0.00', 'a'),
(31, 'INV/2023/031', '2023-08-23', 95, 'SENT PARTS TO IPOH AND ALL THE PORT KLANG ( BY AIR KARGO YT00098764-89  rap tank waste collected from HAIDILAO INTERNATIONAL FOOD SERVICES MALAYSIA', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li><li>Our payment terms is 30 days and 5% interest per day after that will be charged.</li></ul>', 'JAMES LOWERENCE', '', '13121.55', '0.00', '13121.55', '0.00', '13121.55', '0.00', '13121.55', 0, '<p>SENT PARTS TO IPOH AND ALL THE PORT KLANG ( BY AIR KARGO YT00098764-89 &nbsp;rap tank waste collected from HAIDILAO INTERNATIONAL FOOD SERVICES MALAYSIA SDN BHD</p>', 'QO/2023/005', 4, '', 0, '2023-09-07', 15, '0.00', '0.00', '0.00', 'a'),
(32, 'INV/2023/032', '2023-08-25', 94, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li><li>Our payment terms is 30 days and 5% interest per day after that will be charged.</li></ul>', 'MR RAMESH / SHOBA', 'admin@clean_sewers.com', '5455.95', '0.00', '5455.95', '0.00', '5455.95', '0.00', '5455.95', 0, '', '', 0, '', 0, '2023-09-09', 15, '0.00', '0.00', '5455.95', 'a'),
(33, 'INV/2023/033', '2023-08-25', 94, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li><li>Our payment terms is 30 days and 5% interest per day after that will be charged.</li></ul>', 'MR RAMESH / SHOBA', 'admin@clean_sewers.com', '3900.95', '0.00', '3900.95', '0.00', '3900.95', '0.00', '3900.95', 0, '', '', 0, '', 0, '2023-09-09', 15, '0.00', '0.00', '0.00', 'a'),
(34, 'INV/2023/034', '2023-08-26', 88, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li><li>Our payment terms is 30 days and 5% interest per day after that will be charged.</li></ul>', 'MR HUAT', 'ken_huat89@gmail.com', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0, '', '', 0, '', 0, '2023-09-10', 15, '0.00', '0.00', '0.00', 'a'),
(35, 'INV/2023/035', '2023-08-27', 233, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li><li>Our payment terms is 30 days and 5% interest per day after that will be charged.</li></ul>', 'MR KENNY', 'hicom_glenmarie@gmail.com', '13449.90', '125.92', '13492.62', '83.20', '13366.70', '0.00', '13492.62', 0, '', '', 0, '', 0, '2023-11-25', 90, '0.00', '0.00', '0.00', 'a'),
(36, 'INV/2023/036', '2023-09-01', 172, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li><li>Our payment terms is 30 days and 5% interest per day after that will be charged.</li></ul>', 'MR LEE SOOK KENG', '', '1468.65', '70.29', '1408.77', '130.17', '1338.48', '0.00', '1408.77', 0, '', '', 0, '', 0, '2023-09-16', 15, '0.00', '0.00', '0.00', 'a'),
(37, 'INV/2023/037', '2023-09-02', 234, '', 'ANDREAS', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to <strong>Hybrid Technologies Solutions 562085613738 (Maybank)</strong></li></ul>', 'SKALI', '', '1935.00', '0.00', '1935.00', '0.00', '1935.00', '0.00', '1935.00', 0, '', '', 0, '', 0, '2023-09-02', 0, '0.00', '0.00', '33.00', 'a'),
(38, 'INV/2023/038', '2023-09-05', 118, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li><li>Our payment terms is 30 days and 5% interest per day after that will be charged.</li></ul>', '', '', '3700.00', '0.00', '3700.00', '0.00', '3700.00', '0.00', '3700.00', 0, '', 'QO/2023/009', 8, '', 0, '2023-09-20', 15, '0.00', '0.00', '0.00', 'a'),
(39, 'INV/2023/039', '2023-09-05', 146, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li><li>Our payment terms is 30 days and 5% interest per day after that will be charged.</li></ul>', 'CIKGU RAMESH', '', '13121.55', '0.00', '13121.55', '0.00', '13121.55', '0.00', '13121.55', 0, '<p>SENT PARTS TO IPOH AND ALL THE PORT KLANG ( BY AIR KARGO YT00098764-89 &nbsp;rap tank waste collected from HAIDILAO INTERNATIONAL FOOD SERVICES MALAYSIA SDN BHD</p>', 'QO/2023/010', 9, 'DO/2023/005', 5, '2023-09-20', 15, '0.00', '0.00', '0.00', 'a'),
(40, 'INV/2023/040', '2023-09-07', 235, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li><li>Our payment terms is 30 days and 5% interest per day after that will be charged.</li></ul>', 'MR THIRU', '', '5000.00', '0.00', '5000.00', '0.00', '5000.00', '0.00', '5000.00', 0, '', '', 0, '', 0, '2023-09-22', 15, '0.00', '0.00', '0.00', 'a'),
(41, 'INV/2023/041', '2023-09-07', 132, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li><li>Our payment terms is 30 days and 5% interest per day after that will be charged.</li></ul>', 'MR ALI KAMARUDDIN', 'care@iwk.com.my', '888.00', '0.00', '888.00', '0.00', '888.00', '0.00', '888.00', 0, '', '', 0, '', 0, '2023-09-22', 15, '0.00', '0.00', '0.00', 'a'),
(42, 'INV/2023/042', '2023-09-07', 94, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li><li>Our payment terms is 30 days and 5% interest per day after that will be charged.</li></ul>', 'MR RAMESH / SHOBA', 'admin@clean_sewers.com', '999.00', '0.00', '999.00', '0.00', '999.00', '0.00', '999.00', 0, '', '', 0, '', 0, '2023-09-22', 15, '0.00', '0.00', '0.00', 'a'),
(43, 'INV/2023/043', '2023-09-07', 87, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li><li>Our payment terms is 30 days and 5% interest per day after that will be charged.</li></ul>', 'MR TIMOTHY', 'timothy@rainehome.com.my', '6565.00', '0.00', '6565.00', '0.00', '6565.00', '0.00', '6565.00', 0, '', '', 0, '', 0, '2023-09-22', 15, '0.00', '0.00', '0.00', 'a'),
(44, 'INV/2023/045', '2023-09-07', 18, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li><li>Our payment terms is 30 days and 5% interest per day after that will be charged.</li></ul>', 'ENCIK KAMARUDDIN', 'fn_malaysia@gmail.com', '1717.00', '0.00', '1717.00', '0.00', '1717.00', '0.00', '1717.00', 0, '', '', 0, '', 0, '2023-09-22', 15, '0.00', '0.00', '0.00', 'a'),
(45, 'INV/2023/046', '2023-09-08', 132, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li><li>Our payment terms is 30 days and 5% interest per day after that will be charged.</li></ul>', 'MR ALI KAMARUDDIN', 'care@iwk.com.my', '666.00', '0.00', '666.00', '0.00', '666.00', '0.00', '666.00', 0, '', 'QO/2023/011', 10, '', 0, '2023-09-23', 15, '0.00', '0.00', '0.00', 'a'),
(46, 'INV/2023/047', '2023-09-08', 76, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li><li>Our payment terms is 30 days and 5% interest per day after that will be charged.</li></ul>', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', '', '3232.00', '0.00', '3232.00', '0.00', '3232.00', '0.00', '3232.00', 0, '', 'QO/2023/012', 11, 'DO/2023/006', 6, '2023-09-23', 15, '0.00', '0.00', '0.00', 'a'),
(47, 'INV/2023/048', '2023-09-08', 19, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li><li>Our payment terms is 30 days and 5% interest per day after that will be charged.</li></ul>', '', '', '29700.00', '0.00', '29700.00', '0.00', '29700.00', '0.00', '29700.00', 0, '', '', 0, 'DO/2023/007', 7, '2023-09-23', 15, '0.00', '0.00', '0.00', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `tbinvoicedetail`
--

DROP TABLE IF EXISTS `tbinvoicedetail`;
CREATE TABLE IF NOT EXISTS `tbinvoicedetail` (
  `invoiceDetail_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoiceDetail_invoiceID` int(10) NOT NULL,
  `invoiceDetail_no1` varchar(200) NOT NULL,
  `invoiceDetail_no2` varchar(200) NOT NULL,
  `invoiceDetail_no3` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invoiceDetail_no4` varchar(200) NOT NULL,
  `invoiceDetail_bold` int(11) NOT NULL DEFAULT '0' COMMENT '0=normal, 1=bold',
  `invoiceDetail_sortID` int(2) NOT NULL DEFAULT '0',
  `invoiceDetail_no5` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invoiceDetail_rowTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invoiceDetail_taxRateID` int(10) NOT NULL DEFAULT '0',
  `invoiceDetail_taxPercent` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invoiceDetail_taxTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invoiceDetail_rowGrandTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invoiceDetail_discountPercent` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invoiceDetail_discountAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `invoiceDetail_rowTotalAfterDiscount` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`invoiceDetail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2626 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbinvoicedetail`
--

INSERT INTO `tbinvoicedetail` (`invoiceDetail_id`, `invoiceDetail_invoiceID`, `invoiceDetail_no1`, `invoiceDetail_no2`, `invoiceDetail_no3`, `invoiceDetail_no4`, `invoiceDetail_bold`, `invoiceDetail_sortID`, `invoiceDetail_no5`, `invoiceDetail_rowTotal`, `invoiceDetail_taxRateID`, `invoiceDetail_taxPercent`, `invoiceDetail_taxTotal`, `invoiceDetail_rowGrandTotal`, `invoiceDetail_discountPercent`, `invoiceDetail_discountAmount`, `invoiceDetail_rowTotalAfterDiscount`) VALUES
(1, 1, '', 'DHLD PACKAGE DELIVERY CHARGES', '20.00', 'LOT', 0, 1, '50.00', '1000.00', 1, '0.00', '0.00', '1000.00', '0.00', '0.00', '1000.00'),
(2, 1, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(3, 1, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(4, 1, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(5, 1, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(6, 2, '', 'CALENDAR FOR YEAR 2023 INCLUDING STICKERS MICKEY MOUSE', '24.00', 'PCS', 0, 1, '50.95', '1222.80', 1, '0.00', '0.00', '1222.80', '0.00', '0.00', '1222.80'),
(7, 2, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(8, 2, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(9, 2, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(10, 2, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(16, 3, '', '', '0.00', '', 0, 1, '7000.00', '7000.00', 1, '0.00', '0.00', '7000.00', '0.00', '0.00', '7000.00'),
(17, 3, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(18, 3, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(19, 3, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(20, 3, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(21, 4, '', 'COMPUTER DELL XPS 15 16GB RAM 512GB SSD INTEL I9 PROCESSOR', '0.00', 'PCS', 0, 1, '6000.00', '6000.00', 1, '0.00', '0.00', '6000.00', '0.00', '0.00', '6000.00'),
(22, 4, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(23, 4, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(24, 4, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(25, 4, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(31, 5, '', 'COMPUTER DELL XPS 15 16GB RAM 512GB SSD INTEL I9 PROCESSOR', '0.00', 'PCS', 0, 1, '6000.00', '6000.00', 1, '0.00', '0.00', '6000.00', '0.00', '0.00', '6000.00'),
(32, 5, '', 'MAZDA X5 TYRE CHANGE 175/90PSI JAPAN MADE', '0.00', 'PCS', 0, 2, '130.50', '130.50', 1, '0.00', '0.00', '130.50', '0.00', '0.00', '130.50'),
(33, 5, '', 'PREPARE HOUSE TENANCY AGREEMENT FOR CUSTOMER FOR THE YEAR 2023 AND 2024', '0.00', 'LOT', 0, 3, '900.00', '900.00', 1, '0.00', '0.00', '900.00', '0.00', '0.00', '900.00'),
(34, 5, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(35, 5, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(43, 6, '', 'bxbxcbxbxbb', '7.00', '', 0, 1, '89.00', '623.00', 1, '0.00', '0.00', '623.00', '0.00', '0.00', '623.00'),
(44, 6, '', 'COLGATE MEDIUM PACKET', '0.00', 'bottle', 0, 2, '55.00', '55.00', 1, '0.00', '0.00', '55.00', '0.00', '0.00', '55.00'),
(45, 6, '', 'CAR POLISH 2.5 LITRES', '6.00', 'BOTTLE', 0, 3, '19.00', '114.00', 1, '0.00', '0.00', '104.88', '8.00', '9.12', '104.88'),
(46, 6, '', 'gsfshyrsy', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(47, 6, '', 'REMOVE WINDSCREEN AND TINTING WORKS DONE FOR THE WHOLE CAR', '0.00', 'UNITS', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(48, 6, '', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '0.00', 'LOT', 0, 6, '3700.00', '3700.00', 1, '0.00', '0.00', '3700.00', '0.00', '0.00', '3700.00'),
(49, 6, '', '', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(50, 7, '', '', '0.00', '', 0, 1, '3000.00', '3000.00', 1, '0.00', '0.00', '3000.00', '0.00', '0.00', '3000.00'),
(51, 7, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(52, 7, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(53, 7, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(54, 7, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(78, 8, '1.', 'CALENDAR FOR YEAR 2023 INCLUDING STICKERS MICKEY MOUSE', '0.00', 'PCS', 0, 1, '50.95', '50.95', 1, '0.00', '0.00', '50.95', '0.00', '0.00', '50.95'),
(79, 8, '2.', 'COMPUTER DELL XPS 15 16GB RAM 512GB SSD INTEL I9 PROCESSOR', '0.00', 'PCS', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(80, 8, '3.', 'REMOVE WINDSCREEN AND TINTING WORKS DONE FOR THE WHOLE CAR', '0.00', 'UNITS', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(81, 8, '4.', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '0.00', 'LOT', 0, 4, '3700.00', '3700.00', 1, '0.00', '0.00', '3700.00', '0.00', '0.00', '3700.00'),
(82, 8, '5.', 'TOP RADIATOR HOSE ORIGINAL', '0.00', '', 0, 5, '450.00', '450.00', 1, '0.00', '0.00', '450.00', '0.00', '0.00', '450.00'),
(83, 8, '', 'labiur', '0.00', '', 1, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(84, 8, '', 'CAR TINTING SERVICE - V COOL HOLLAND TYPE', '0.00', 'PCS', 0, 7, '66.00', '66.00', 1, '0.00', '0.00', '66.00', '0.00', '0.00', '66.00'),
(99, 10, '1', 'COMPUTER DELL XPS 15 16GB RAM 512GB SSD INTEL I9 PROCESSOR', '1.00', 'PCS', 0, 1, '234.00', '234.00', 1, '0.00', '0.00', '222.30', '5.00', '11.70', '222.30'),
(100, 10, '2', 'REMOVE WINDSCREEN AND TINTING WORKS DONE FOR THE WHOLE CAR', '1.00', 'UNITS', 0, 2, '55.00', '55.00', 1, '0.00', '0.00', '52.25', '5.00', '2.75', '52.25'),
(101, 10, '3', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '4.00', 'LOT', 0, 3, '56.00', '224.00', 1, '0.00', '0.00', '212.80', '5.00', '11.20', '212.80'),
(102, 10, '4', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '6.00', 'LOT', 0, 4, '400.00', '2400.00', 1, '0.00', '0.00', '2280.00', '5.00', '120.00', '2280.00'),
(103, 10, '5', 'FRANCE PERFUME ( LAVENDAR SMELL)', '6.00', '', 0, 5, '98.00', '588.00', 1, '0.00', '0.00', '558.60', '5.00', '29.40', '558.60'),
(109, 12, '1', 'COMPUTER DELL XPS 15 16GB RAM 512GB SSD INTEL I9 PROCESSOR', '1.00', 'PCS', 0, 1, '234.00', '234.00', 1, '0.00', '0.00', '222.30', '5.00', '11.70', '222.30'),
(110, 12, '2', 'REMOVE WINDSCREEN AND TINTING WORKS DONE FOR THE WHOLE CAR', '1.00', 'UNITS', 0, 2, '55.00', '55.00', 1, '0.00', '0.00', '52.25', '5.00', '2.75', '52.25'),
(111, 12, '3', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '4.00', 'LOT', 0, 3, '56.00', '224.00', 1, '0.00', '0.00', '212.80', '5.00', '11.20', '212.80'),
(112, 12, '4', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '6.00', 'LOT', 0, 4, '400.00', '2400.00', 1, '0.00', '0.00', '2280.00', '5.00', '120.00', '2280.00'),
(113, 12, '5', 'FRANCE PERFUME ( LAVENDAR SMELL)', '6.00', '', 0, 5, '98.00', '588.00', 1, '0.00', '0.00', '558.60', '5.00', '29.40', '558.60'),
(114, 12, '', 'CAR CARBURATOR CHANGE', '90.00', '', 0, 6, '33.00', '2970.00', 1, '0.00', '0.00', '2970.00', '0.00', '0.00', '2970.00'),
(115, 12, '', 'REMOVE WINDSCREEN AND TINTING WORKS DONE FOR THE WHOLE CAR', '0.00', 'UNITS', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(132, 9, '1', 'DHLD PACKAGE DELIVERY CHARGES', '20.00', 'LOT', 0, 1, '50.00', '1000.00', 4, '34.00', '340.00', '1340.00', '0.00', '0.00', '1000.00'),
(133, 9, '2', 'CALENDAR FOR YEAR 2023 INCLUDING STICKERS MICKEY MOUSE', '0.00', 'PCS', 0, 2, '50.95', '50.95', 1, '0.00', '0.00', '50.95', '0.00', '0.00', '50.95'),
(134, 9, '3', 'REMOVE WINDSCREEN AND TINTING WORKS DONE FOR THE WHOLE CAR', '0.00', 'UNITS', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(135, 9, '4', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '0.00', 'LOT', 0, 4, '3700.00', '3700.00', 1, '0.00', '0.00', '3700.00', '0.00', '0.00', '3700.00'),
(136, 9, '5', 'Jetting Works and Clear blockages with rodder machine', '0.00', 'unit', 0, 5, '6.00', '6.00', 1, '0.00', '0.00', '6.00', '0.00', '0.00', '6.00'),
(137, 9, '6', 'MAZDA X5 TYRE CHANGE 175/90PSI JAPAN MADE', '0.00', 'PCS', 0, 6, '130.50', '130.50', 1, '0.00', '0.00', '130.50', '0.00', '0.00', '130.50'),
(138, 9, '7', 'MILO TIN BIG ( MADE IN HOLLAND)', '0.00', 'TIN', 0, 7, '66.00', '66.00', 1, '0.00', '0.00', '66.00', '0.00', '0.00', '66.00'),
(230, 11, '1', 'COMPUTER DELL XPS 15 16GB RAM 512GB SSD INTEL I9 PROCESSOR', '1.00', 'PCS', 0, 1, '234.00', '234.00', 1, '0.00', '0.00', '222.30', '5.00', '11.70', '222.30'),
(231, 11, '2', 'REMOVE WINDSCREEN AND TINTING WORKS DONE FOR THE WHOLE CAR', '1.00', 'UNITS', 0, 2, '55.00', '55.00', 1, '0.00', '0.00', '52.25', '5.00', '2.75', '52.25'),
(232, 11, '3', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '4.00', 'LOT', 0, 3, '56.00', '224.00', 1, '0.00', '0.00', '212.80', '5.00', '11.20', '212.80'),
(233, 11, '4', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '6.00', 'LOT', 0, 4, '400.00', '2400.00', 1, '0.00', '0.00', '2280.00', '5.00', '120.00', '2280.00'),
(234, 11, '5', 'FRANCE PERFUME ( LAVENDAR SMELL)', '6.00', '', 0, 5, '98.00', '588.00', 1, '0.00', '0.00', '558.60', '5.00', '29.40', '558.60'),
(235, 11, '', '', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(236, 11, '', '', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(237, 11, '', '', '0.00', '', 0, 8, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(238, 11, '', '', '0.00', '', 0, 9, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(239, 11, '', '', '0.00', '', 0, 10, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(240, 11, '', '', '0.00', '', 0, 11, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(241, 11, '', '', '0.00', '', 0, 12, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(242, 11, '', '', '0.00', '', 0, 13, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(243, 11, '', '', '0.00', '', 0, 14, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(244, 11, '', '', '0.00', '', 0, 15, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(295, 13, '1', 'COMPUTER DELL XPS 15 16GB RAM 512GB SSD INTEL I9 PROCESSOR', '1.00', 'PCS', 0, 1, '234.00', '234.00', 1, '0.00', '0.00', '222.30', '5.00', '11.70', '222.30'),
(296, 13, '2', 'REMOVE WINDSCREEN AND TINTING WORKS DONE FOR THE WHOLE CAR', '1.00', 'UNITS', 0, 2, '55.00', '55.00', 1, '0.00', '0.00', '52.25', '5.00', '2.75', '52.25'),
(297, 13, '3', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '4.00', 'LOT', 0, 3, '56.00', '224.00', 1, '0.00', '0.00', '212.80', '5.00', '11.20', '212.80'),
(298, 13, '4', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '6.00', 'LOT', 0, 4, '400.00', '2400.00', 1, '0.00', '0.00', '2280.00', '5.00', '120.00', '2280.00'),
(299, 13, '5', 'FRANCE PERFUME ( LAVENDAR SMELL)', '6.00', '', 1, 5, '98.00', '588.00', 1, '0.00', '0.00', '558.60', '5.00', '29.40', '558.60'),
(300, 13, '6', 'CAR CARBURATOR CHANGE', '90.00', '', 0, 6, '33.00', '2970.00', 1, '0.00', '0.00', '2970.00', '0.00', '0.00', '2970.00'),
(301, 13, '7', 'REMOVE WINDSCREEN AND TINTING WORKS DONE FOR THE WHOLE CAR', '0.00', 'UNITS', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(302, 13, '8', 'CAR TINTING SERVICE - V COOL HOLLAND TYPE', '3.00', 'PCS', 0, 8, '66.00', '198.00', 4, '34.00', '63.28', '249.40', '6.00', '11.88', '186.12'),
(303, 13, '', '', '0.00', '', 0, 9, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(304, 13, '', '', '0.00', '', 0, 10, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(305, 13, '', '', '0.00', '', 0, 11, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(306, 13, '', '', '0.00', '', 0, 12, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(307, 13, '', '', '0.00', '', 0, 13, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(308, 13, '', '', '0.00', '', 0, 14, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(309, 13, '', '', '0.00', '', 0, 15, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(310, 13, '', '', '0.00', '', 0, 16, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(311, 13, '', '', '0.00', '', 0, 17, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(317, 14, '1', 'COMPUTER DELL XPS 15 16GB RAM 512GB SSD INTEL I9 PROCESSOR', '1.00', 'PCS', 0, 1, '234.00', '234.00', 1, '0.00', '0.00', '222.30', '5.00', '11.70', '222.30'),
(318, 14, '2', 'REMOVE WINDSCREEN AND TINTING WORKS DONE FOR THE WHOLE CAR', '1.00', 'UNITS', 0, 2, '55.00', '55.00', 1, '0.00', '0.00', '52.25', '5.00', '2.75', '52.25'),
(319, 14, '3', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '4.00', 'LOT', 0, 3, '56.00', '224.00', 1, '0.00', '0.00', '212.80', '5.00', '11.20', '212.80'),
(320, 14, '4', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '6.00', 'LOT', 0, 4, '400.00', '2400.00', 1, '0.00', '0.00', '2280.00', '5.00', '120.00', '2280.00'),
(321, 14, '5', 'FRANCE PERFUME ( LAVENDAR SMELL)', '6.00', '', 0, 5, '98.00', '588.00', 1, '0.00', '0.00', '558.60', '5.00', '29.40', '558.60'),
(322, 14, '6', 'CAR CARBURATOR CHANGE', '90.00', '', 0, 6, '33.00', '2970.00', 1, '0.00', '0.00', '2970.00', '0.00', '0.00', '2970.00'),
(323, 14, '7', 'REMOVE WINDSCREEN AND TINTING WORKS DONE FOR THE WHOLE CAR', '0.00', 'UNITS', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(324, 14, '', '', '0.00', '', 0, 8, '700.00', '700.00', 4, '34.00', '223.72', '881.72', '6.00', '42.00', '658.00'),
(325, 14, '', '', '0.00', '', 0, 9, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(326, 14, '', '', '0.00', '', 0, 10, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(327, 14, '', '', '0.00', '', 0, 11, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(328, 14, '', '', '0.00', '', 0, 12, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(329, 14, '', '', '0.00', '', 0, 13, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(330, 14, '', '', '0.00', '', 0, 14, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(331, 14, '', '', '0.00', '', 0, 15, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(332, 16, '', 'Apple Laptop Air', '2.00', 'unit', 0, 1, '6590.55', '13181.10', 1, '0.00', '0.00', '13181.10', '0.00', '0.00', '13181.10'),
(333, 16, '', 'BEZA CAR Malaysia Made', '0.00', 'PCS', 0, 2, '3500.90', '3500.90', 1, '0.00', '0.00', '3500.90', '0.00', '0.00', '3500.90'),
(334, 16, '', 'CAR POLISH 2.5 LITRES', '0.00', 'BOTTLE', 0, 3, '19.00', '19.00', 1, '0.00', '0.00', '19.00', '0.00', '0.00', '19.00'),
(335, 16, '', 'APPLE CIDER', '0.00', 'bottles', 0, 4, '111.00', '111.00', 1, '0.00', '0.00', '111.00', '0.00', '0.00', '111.00'),
(336, 16, '', 'EYE CHECKUP', '0.00', '', 0, 5, '90.00', '90.00', 1, '0.00', '0.00', '90.00', '0.00', '0.00', '90.00'),
(337, 16, '', '', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(338, 16, '', 'CALENDAR FOR YEAR 2023 INCLUDING STICKERS MICKEY MOUSE', '0.00', 'PCS', 0, 7, '50.95', '50.95', 1, '0.00', '0.00', '50.95', '0.00', '0.00', '50.95'),
(339, 16, '', '', '0.00', '', 0, 8, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(340, 16, '', 'REMOVE WINDSCREEN AND TINTING WORKS DONE FOR THE WHOLE CAR', '0.00', 'UNITS', 0, 9, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(341, 16, '', '', '0.00', '', 0, 10, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(342, 16, '', 'PREPARE HOUSE TENANCY AGREEMENT FOR CUSTOMER FOR THE YEAR 2023 AND 2024', '0.00', 'LOT', 0, 11, '900.00', '900.00', 1, '0.00', '0.00', '900.00', '0.00', '0.00', '900.00'),
(343, 16, '', '', '0.00', '', 0, 12, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(344, 16, '', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '0.00', 'LOT', 0, 13, '3700.00', '3700.00', 1, '0.00', '0.00', '3700.00', '0.00', '0.00', '3700.00'),
(931, 19, '', '', '0.00', '', 0, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(932, 19, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(933, 19, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(934, 19, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(935, 19, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(936, 19, '', '', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(937, 19, '', '', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(938, 19, '', '', '0.00', '', 0, 8, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(939, 19, '', '', '0.00', '', 0, 9, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(940, 19, '', '', '0.00', '', 0, 10, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(941, 19, '', '', '0.00', '', 0, 11, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1134, 22, '', 'APPLE WATCH SMART', '0.00', 'PCS', 0, 1, '665.00', '665.00', 1, '0.00', '0.00', '665.00', '0.00', '0.00', '665.00'),
(1135, 22, '', 'CALENDAR FOR YEAR 2023 INCLUDING STICKERS MICKEY MOUSE', '0.00', 'PCS', 0, 2, '50.95', '50.95', 1, '0.00', '0.00', '50.95', '0.00', '0.00', '50.95'),
(1136, 22, '', 'MOTOROLLA HANDPHONE MODEL X-9', '0.00', 'unit', 0, 3, '5006.75', '5006.75', 1, '0.00', '0.00', '5006.75', '0.00', '0.00', '5006.75'),
(1137, 22, '', 'PREPARE HOUSE TENANCY AGREEMENT FOR CUSTOMER FOR THE YEAR 2023 AND 2024', '0.00', 'LOT', 0, 4, '900.00', '900.00', 1, '0.00', '0.00', '900.00', '0.00', '0.00', '900.00'),
(1138, 22, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1195, 23, '1.', 'CABBAGE PRODUCE', '0.00', '', 0, 1, '77.00', '77.00', 1, '0.00', '0.00', '77.00', '0.00', '0.00', '77.00'),
(1196, 23, '2.', 'COMPUTER DELL XPS 15 16GB RAM 512GB SSD INTEL I9 PROCESSOR', '0.00', 'PCS', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1197, 23, '3.', 'CAR TINTING SERVICE - V COOL HOLLAND TYPE', '0.00', 'PCS', 0, 3, '66.00', '66.00', 1, '0.00', '0.00', '66.00', '0.00', '0.00', '66.00'),
(1198, 23, '4.', 'CAR AIRCOND REFILL GAS AND SERVICE', '0.00', '', 0, 4, '99.65', '99.65', 1, '0.00', '0.00', '99.65', '0.00', '0.00', '99.65'),
(1199, 23, '5.', 'REMOVE WINDSCREEN AND TINTING WORKS DONE FOR THE WHOLE CAR', '0.00', 'UNITS', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1200, 23, '6.', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', 'bundle', 0, 6, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(1201, 23, '7.', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '0.00', 'LOT', 0, 7, '3700.00', '3700.00', 1, '0.00', '0.00', '3700.00', '0.00', '0.00', '3700.00'),
(1202, 23, '8.', '', '0.00', '', 0, 8, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1203, 23, '9.', '', '0.00', '', 0, 9, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1204, 23, '10.', '', '0.00', '', 0, 10, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1205, 23, '11.', '', '0.00', '', 0, 11, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1206, 23, '12.', '', '0.00', '', 0, 12, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1207, 23, '13.', '', '0.00', '', 0, 13, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1208, 23, '14.', '', '0.00', '', 0, 14, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1209, 23, '15.', '', '0.00', '', 0, 15, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1210, 23, '16.', '', '0.00', '', 0, 16, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1211, 23, '17.', '', '0.00', '', 0, 17, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1212, 23, '18.', '', '0.00', '', 0, 18, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1213, 23, '19.', '', '0.00', '', 0, 19, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1214, 23, '20.', '', '0.00', '', 0, 20, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1613, 24, '1A', 'CABBAGE PRODUCE', '0.00', '', 1, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1614, 24, '2.', 'COMPUTER DELL XPS 15 16GB RAM 512GB SSD INTEL I9 PROCESSOR', '1.00', 'PCS', 0, 2, '87000.00', '87000.00', 1, '0.00', '0.00', '87000.00', '0.00', '0.00', '87000.00'),
(1615, 24, '3.', 'CAR TINTING SERVICE - V COOL HOLLAND TYPE', '15.50', 'PCS', 0, 3, '66.00', '1023.00', 1, '0.00', '0.00', '1023.00', '0.00', '0.00', '1023.00'),
(1616, 24, '4.', 'CAR AIRCOND REFILL GAS AND SERVICE', '0.00', '', 0, 4, '99.65', '99.65', 1, '0.00', '0.00', '99.65', '0.00', '0.00', '99.65'),
(1617, 24, '5.', 'REMOVE WINDSCREEN AND TINTING WORKS DONE FOR THE WHOLE CAR', '0.00', 'UNITS', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1618, 24, '6.', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', 'bundle', 0, 6, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(1619, 24, '7.', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '0.00', 'LOT', 0, 7, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(1620, 24, '2B', 'LABOUR', '0.00', '', 1, 8, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1621, 24, '9.', 'COMPUTER DELL XPS 15 16GB RAM 512GB SSD INTEL I9 PROCESSOR', '0.00', 'PCS', 0, 9, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1622, 24, '10.', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '0.00', 'LOT', 0, 10, '6.00', '6.00', 1, '0.00', '0.00', '6.00', '0.00', '0.00', '6.00'),
(1623, 24, '11.', 'REMOVE WINDSCREEN AND TINTING WORKS DONE FOR THE WHOLE CAR', '0.00', 'UNITS', 0, 11, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1624, 24, '12.', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', 'bundles', 0, 12, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(1625, 24, '13.', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '0.00', 'LOT', 0, 13, '4.00', '4.00', 6, '1.50', '0.06', '4.06', '0.00', '0.00', '4.00'),
(1626, 24, '14.', 'CAR TINTING SERVICE - V COOL HOLLAND TYPE', '0.00', 'PCS', 0, 14, '5.00', '5.00', 1, '0.00', '0.00', '5.00', '0.00', '0.00', '5.00'),
(1627, 24, '15.', 'REMOVE WINDSCREEN AND TINTING WORKS DONE FOR THE WHOLE CAR', '0.00', 'UNITS', 0, 15, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1628, 24, '16.', 'TOP RADIATOR HOSE ORIGINAL', '0.00', '', 0, 16, '6.00', '6.00', 1, '0.00', '0.00', '6.00', '0.00', '0.00', '6.00'),
(1651, 25, '1.', 'APPLE CIDER', '3.00', 'bottles', 0, 1, '111.00', '333.00', 1, '0.00', '0.00', '333.00', '0.00', '0.00', '333.00'),
(1652, 25, '2.', 'CAR AIRCOND REFILL GAS AND SERVICE', '3.00', '', 0, 2, '99.65', '298.95', 1, '0.00', '0.00', '298.95', '0.00', '0.00', '298.95'),
(1653, 25, '3.', 'CALENDAR FOR YEAR 2023 INCLUDING STICKERS MICKEY MOUSE', '0.00', 'PCS', 0, 3, '50.95', '50.95', 1, '0.00', '0.00', '50.95', '0.00', '0.00', '50.95'),
(1654, 25, '4.', 'COMPUTER HP 16GB RAM 256 GB RAM JAPAN MADE', '0.00', 'PC', 0, 4, '100.00', '100.00', 1, '0.00', '0.00', '100.00', '0.00', '0.00', '100.00'),
(1655, 25, '5.', 'FRANCE PERFUME ( LAVENDAR SMELL)', '3.00', '', 0, 5, '98.00', '294.00', 2, '6.00', '17.64', '311.64', '0.00', '0.00', '294.00'),
(1656, 25, '6.', 'CAR DENT KNOCKING AND PAINTING', '0.00', 'LOT', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1657, 25, '7.', 'CHANGE CAR TYRES', '0.00', 'PERSON', 0, 7, '66.00', '66.00', 1, '0.00', '0.00', '66.00', '0.00', '0.00', '66.00'),
(1658, 25, '', 'LABOUR', '0.00', '', 1, 8, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1659, 25, '1.', 'CAR POLISH 2.5 LITRES', '0.00', 'BOX', 0, 9, '19.00', '19.00', 1, '0.00', '0.00', '19.00', '0.00', '0.00', '19.00'),
(1660, 25, '2.', 'MOTOROLLA HANDPHONE MODEL X-9', '0.00', 'unit', 0, 10, '5006.75', '5006.75', 1, '0.00', '0.00', '5006.75', '0.00', '0.00', '5006.75'),
(1661, 25, '3.', 'GRAND TURISMO 2.4', '0.00', 'UNIT', 0, 11, '12000.00', '12000.00', 1, '0.00', '0.00', '12000.00', '0.00', '0.00', '12000.00'),
(1703, 20, '1.', 'KUFAAN CHEESE PASTRY', '3.00', 'PCS', 0, 1, '30.00', '90.00', 1, '0.00', '0.00', '90.00', '0.00', '0.00', '90.00'),
(1704, 20, '2.', 'REMOVE WINDSCREEN AND TINTING WORKS DONE FOR THE WHOLE CAR', '3.50', 'UNITS', 0, 2, '66.00', '231.00', 1, '0.00', '0.00', '217.14', '6.00', '13.86', '217.14'),
(1705, 20, '3.', 'COMPUTER HP 16GB RAM 256 GB RAM JAPAN MADE', '76.00', 'PC', 0, 3, '100.00', '7600.00', 4, '34.00', '2584.00', '10184.00', '0.00', '0.00', '7600.00'),
(1706, 20, '', 'COMPUTER DELL XPS 15 16GB RAM 512GB SSD INTEL I9 PROCESSOR', '2.00', 'PCS', 1, 4, '34.00', '68.00', 1, '0.00', '0.00', '68.00', '0.00', '0.00', '68.00'),
(1707, 20, '1.', 'TEAK WOOD IKEA TABLE 5 X 7 FEET', '0.00', 'PCS', 0, 5, '45.00', '45.00', 1, '0.00', '0.00', '45.00', '0.00', '0.00', '45.00'),
(1708, 20, '', 'COMPUTER DELL XPS 15 16GB RAM 512GB SSD INTEL I9 PROCESSOR', '2.50', 'PCS', 1, 6, '78.80', '197.00', 1, '0.00', '0.00', '197.00', '0.00', '0.00', '197.00'),
(1709, 20, '1.', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '0.00', 'LOT', 0, 7, '80.00', '80.00', 1, '0.00', '0.00', '80.00', '0.00', '0.00', '80.00'),
(1710, 20, '2.', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE \r\nALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '1.00', 'LOT', 0, 8, '10184.00', '10184.00', 1, '0.00', '0.00', '10184.00', '0.00', '0.00', '10184.00'),
(1711, 20, '', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 1, 9, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1712, 20, '1.', 'CALENDAR FOR YEAR 2023 INCLUDING STICKERS MICKEY MOUSE', '0.00', 'PCS', 0, 10, '50.95', '50.95', 1, '0.00', '0.00', '50.95', '0.00', '0.00', '50.95'),
(1718, 21, '1.', 'OIL FILTER HOUSING', '0.00', '', 0, 1, '430.00', '430.00', 1, '0.00', '0.00', '430.00', '0.00', '0.00', '430.00'),
(1719, 21, '2.', 'PURGE VALVE', '0.00', '', 0, 2, '480.00', '480.00', 1, '0.00', '0.00', '480.00', '0.00', '0.00', '480.00'),
(1720, 21, '3.', 'ENGINE OIL 5W40 FULLY SYNTHETIC', '6.00', 'litre', 0, 3, '70.00', '420.00', 1, '0.00', '0.00', '420.00', '0.00', '0.00', '420.00'),
(1721, 21, '4.', 'OIL FILTER', '0.00', '', 0, 4, '80.00', '80.00', 1, '0.00', '0.00', '80.00', '0.00', '0.00', '80.00'),
(1722, 21, '5.', 'AIR HOSE WITH VALVE', '0.00', '', 0, 5, '210.00', '210.00', 1, '0.00', '0.00', '210.00', '0.00', '0.00', '210.00'),
(1723, 21, '6.', 'COOLANT MERCEDES ORIGINAL 1L', '0.00', '', 0, 6, '60.00', '60.00', 1, '0.00', '0.00', '60.00', '0.00', '0.00', '60.00'),
(1724, 21, '7.', 'BRAKE CLEANER WURTH', '0.00', '', 0, 7, '35.00', '35.00', 1, '0.00', '0.00', '35.00', '0.00', '0.00', '35.00'),
(1725, 21, '8.', 'LABOUR TO REPLACE PARTS & ENGINE WASH', '0.00', '', 0, 8, '360.00', '360.00', 1, '0.00', '0.00', '360.00', '0.00', '0.00', '360.00'),
(1726, 21, '9.', '', '0.00', '', 0, 9, '0.05', '0.05', 1, '0.00', '0.00', '0.05', '0.00', '0.00', '0.05'),
(1727, 21, '10.', '', '0.00', '', 0, 10, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1848, 28, '', '', '0.00', '', 0, 1, '2319.18', '2319.18', 1, '0.00', '0.00', '2319.18', '0.00', '0.00', '2319.18'),
(1849, 28, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1850, 28, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1851, 28, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1852, 28, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1863, 27, '', '', '0.00', '', 0, 1, '600.02', '600.02', 1, '0.00', '0.00', '600.02', '0.00', '0.00', '600.02'),
(1864, 27, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1865, 27, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1866, 27, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1867, 27, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1901, 18, '1.', 'KUFAAN CHEESE PASTRY', '3.00', 'PCS', 0, 1, '30.00', '90.00', 1, '0.00', '0.00', '90.00', '0.00', '0.00', '90.00'),
(1902, 18, '2.', 'REMOVE WINDSCREEN AND TINTING WORKS DONE FOR THE WHOLE CAR', '3.50', 'UNITS', 0, 2, '66.00', '231.00', 1, '0.00', '0.00', '217.14', '6.00', '13.86', '217.14'),
(1903, 18, '3.', 'COMPUTER HP 16GB RAM 256 GB RAM JAPAN MADE', '0.00', 'PC', 0, 3, '100.00', '100.00', 4, '34.00', '34.00', '134.00', '0.00', '0.00', '100.00'),
(1904, 18, '', 'COMPUTER DELL XPS 15 16GB RAM 512GB SSD INTEL I9 PROCESSOR', '2.00', 'PCS', 1, 4, '34.00', '68.00', 1, '0.00', '0.00', '68.00', '0.00', '0.00', '68.00'),
(1905, 18, '1.', 'TEAK WOOD IKEA TABLE 5 X 7 FEET', '0.00', 'PCS', 0, 5, '45.00', '45.00', 1, '0.00', '0.00', '45.00', '0.00', '0.00', '45.00'),
(1906, 18, '', 'COMPUTER DELL XPS 15 16GB RAM 512GB SSD INTEL I9 PROCESSOR', '2.50', 'PCS', 1, 6, '78.80', '197.00', 1, '0.00', '0.00', '197.00', '0.00', '0.00', '197.00'),
(1907, 18, '1.', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '0.00', 'LOT', 0, 7, '80.00', '80.00', 1, '0.00', '0.00', '80.00', '0.00', '0.00', '80.00'),
(1908, 18, '2.', 'TO USE TOOLS AND MANUALLY \r\nENTER THE  DRAIN TO REMOVE \r\nALL SAND, STONES, DEBRIS ETC \r\nFROM THE SIDES AND BOTTOM OF DRAIN.', '0.00', 'LOT', 0, 8, '80.00', '80.00', 1, '0.00', '0.00', '80.00', '0.00', '0.00', '80.00'),
(1909, 18, '3.', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', 'bundle', 0, 9, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(1910, 18, '1.', 'CALENDAR FOR YEAR 2023 INCLUDING STICKERS MICKEY MOUSE', '0.00', 'PCS', 0, 10, '50.95', '50.95', 1, '0.00', '0.00', '50.95', '0.00', '0.00', '50.95'),
(1911, 18, '2.', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '0.00', 'LOT', 0, 11, '3700.00', '3700.00', 3, '10.00', '370.00', '4070.00', '0.00', '0.00', '3700.00'),
(1912, 18, '', '', '0.00', '', 0, 12, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1913, 18, '', '', '0.00', '', 0, 13, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1914, 18, '', '', '0.00', '', 0, 14, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1915, 18, '', '', '0.00', '', 0, 15, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1916, 18, '', '', '0.00', '', 0, 16, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1917, 18, '', '', '0.00', '', 0, 17, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1918, 18, '', '', '0.00', '', 0, 18, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1919, 18, '', '', '0.00', '', 0, 19, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1920, 18, '', '', '0.00', '', 0, 20, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1921, 18, '', '', '0.00', '', 0, 21, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1922, 18, '', '', '0.00', '', 0, 22, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1923, 18, '', '', '0.00', '', 0, 23, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1924, 18, '', '', '0.00', '', 0, 24, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1925, 18, '', '', '0.00', '', 0, 25, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(1926, 18, '', '', '0.00', '', 0, 26, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2175, 29, '', 'WORK SCOPE', '0.00', '', 1, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2176, 29, '1', 'CALENDAR FOR YEAR 2023 INCLUDING STICKERS MICKEY MOUSE', '1.00', 'PCS', 0, 2, '50.95', '50.95', 2, '6.00', '3.06', '54.01', '0.00', '0.00', '50.95'),
(2177, 29, '2', 'NOKIA CHARGER TYPE CARBON 4598BK', '1.00', 'UNIT', 0, 3, '59.00', '59.00', 1, '0.00', '0.00', '56.05', '5.00', '2.95', '56.05'),
(2178, 29, '3', 'DHLD PACKAGE DELIVERY CHARGES', '1.00', 'LOT', 0, 4, '50.00', '50.00', 1, '0.00', '0.00', '50.00', '0.00', '0.00', '50.00'),
(2179, 29, '4', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '2.00', 'LOT', 0, 5, '3700.00', '7400.00', 1, '0.00', '0.00', '7400.00', '0.00', '0.00', '7400.00'),
(2180, 29, '5', 'MAZDA X5 TYRE CHANGE 175/90PSI JAPAN MADE', '1.00', 'PCS', 0, 6, '130.50', '130.50', 4, '34.00', '42.15', '166.12', '5.00', '6.53', '123.97'),
(2181, 29, '6', 'COMPUTER DELL XPS 15 16GB RAM 512GB SSD INTEL I9 PROCESSOR', '1.00', 'PCS', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2182, 29, '', 'TOP RADIATOR HOSE ORIGINAL', '0.00', 'litre', 1, 8, '0.00', '0.00', 6, '1.50', '0.00', '0.00', '3.00', '0.00', '0.00'),
(2183, 29, '1', 'RATTAN CHAIR (japan made)', '0.00', 'PCS', 0, 9, '99.00', '99.00', 1, '0.00', '0.00', '99.00', '0.00', '0.00', '99.00'),
(2184, 29, '2', 'MOTOROLLA HANDPHONE MODEL X-9', '1.00', 'unit', 0, 10, '5006.75', '5006.75', 4, '34.00', '1702.30', '6709.05', '0.00', '0.00', '5006.75'),
(2185, 29, '3', 'TEAK WOOD IKEA TABLE 5 X 7 FEET', '4.00', 'PCS', 0, 11, '100000.00', '400000.00', 1, '0.00', '0.00', '400000.00', '0.00', '0.00', '400000.00'),
(2186, 29, '', '', '0.00', '', 0, 12, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2187, 29, '', '', '0.00', '', 0, 13, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2188, 29, '', '', '0.00', '', 0, 14, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2189, 29, '', '', '0.00', '', 0, 15, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2190, 29, '', '', '0.00', '', 0, 16, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2191, 29, '', '', '0.00', '', 0, 17, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2192, 29, '', '', '0.00', '', 0, 18, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2193, 29, '', '', '0.00', '', 0, 19, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2194, 29, '', '', '0.00', '', 0, 20, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2195, 29, '', '', '0.00', '', 0, 21, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2196, 29, '', '', '0.00', '', 0, 22, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2197, 29, '', '', '0.00', '', 0, 23, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2198, 29, '', '', '0.00', '', 0, 24, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2199, 29, '', '', '0.00', '', 0, 25, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2200, 29, '', '', '0.00', '', 0, 26, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2201, 29, '', '', '0.00', '', 0, 27, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2202, 29, '', '', '0.00', '', 0, 28, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2203, 29, '', '', '0.00', '', 0, 29, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2204, 29, '', '', '0.00', '', 0, 30, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2205, 15, '', 'Apple Laptop Air', '2.00', 'unit', 0, 1, '6590.55', '13181.10', 1, '0.00', '0.00', '13181.10', '0.00', '0.00', '13181.10'),
(2206, 15, '', 'BEZA CAR Malaysia Made', '0.00', 'PCS', 0, 2, '3500.90', '3500.90', 1, '0.00', '0.00', '3500.90', '0.00', '0.00', '3500.90'),
(2207, 15, '', 'CAR POLISH 2.5 LITRES', '0.00', 'BOTTLE', 0, 3, '19.00', '19.00', 1, '0.00', '0.00', '19.00', '0.00', '0.00', '19.00'),
(2208, 15, '', 'APPLE CIDER', '0.00', 'bottles', 0, 4, '111.00', '111.00', 1, '0.00', '0.00', '111.00', '0.00', '0.00', '111.00'),
(2209, 15, '', 'EYE CHECKUP', '0.00', '', 0, 5, '90.00', '90.00', 1, '0.00', '0.00', '90.00', '0.00', '0.00', '90.00'),
(2210, 15, '', '', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2211, 15, '', '', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2212, 15, '', '', '0.00', '', 0, 8, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2213, 30, '', 'WORK SCOPE', '0.00', '', 0, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2214, 30, '1.', 'CAR CARBURATOR CHANGE', '12.00', '', 0, 2, '33.00', '396.00', 4, '34.00', '121.18', '477.58', '10.00', '39.60', '356.40'),
(2215, 30, '2.', 'PREPARE HOUSE TENANCY AGREEMENT FOR CUSTOMER FOR THE YEAR 2023 AND 2024', '0.00', 'LOT', 0, 3, '900.00', '900.00', 1, '0.00', '0.00', '900.00', '0.00', '0.00', '900.00'),
(2216, 30, '3.', 'REMOVE WINDSCREEN AND TINTING WORKS DONE FOR THE WHOLE CAR', '2.00', 'UNITS', 0, 4, '65.00', '130.00', 1, '0.00', '0.00', '130.00', '0.00', '0.00', '130.00'),
(2217, 30, '4.', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '0.00', 'LOT', 0, 5, '3700.00', '3700.00', 1, '0.00', '0.00', '3700.00', '0.00', '0.00', '3700.00'),
(2218, 30, '', 'TRANSPORT', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2219, 30, '1.', 'CALENDAR FOR YEAR 2023 INCLUDING STICKERS MICKEY MOUSE', '0.00', 'PCS', 0, 7, '50.95', '50.95', 4, '34.00', '17.32', '68.27', '0.00', '0.00', '50.95'),
(2220, 30, '2.', 'MOTOROLLA HANDPHONE MODEL X-9', '1.00', 'unit', 0, 8, '5006.75', '5006.75', 6, '1.50', '75.10', '5081.85', '0.00', '0.00', '5006.75'),
(2221, 30, '3.', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '0.00', 'LOT', 0, 9, '3700.00', '3700.00', 3, '10.00', '355.20', '3907.20', '4.00', '148.00', '3552.00'),
(2222, 30, '5.', 'TEAK WOOD IKEA TABLE 5 X 7 FEET', '0.00', 'PCS', 0, 10, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2223, 30, '', 'LABOUR', '0.00', '', 0, 11, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2224, 30, '1.', 'NOKIA CHARGER TYPE CARBON 4598BK', '2.00', 'UNIT', 0, 12, '59.00', '118.00', 1, '0.00', '0.00', '118.00', '0.00', '0.00', '118.00'),
(2225, 30, '2.', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '6.00', 'LOT', 0, 13, '60.00', '360.00', 1, '0.00', '0.00', '360.00', '0.00', '0.00', '360.00'),
(2226, 30, '', 'CALENDAR FOR YEAR 2023 INCLUDING STICKERS MICKEY MOUSE', '0.00', 'PCS', 0, 14, '50.95', '50.95', 1, '0.00', '0.00', '50.95', '0.00', '0.00', '50.95'),
(2227, 31, '', 'BUTTER CHICKEN', '0.00', 'pcs', 0, 1, '67.55', '67.55', 1, '0.00', '0.00', '67.55', '0.00', '0.00', '67.55'),
(2228, 31, '', 'PREPARE HOUSE TENANCY AGREEMENT FOR CUSTOMER FOR THE YEAR 2023 AND 2024', '0.00', 'LOT', 0, 2, '900.00', '900.00', 1, '0.00', '0.00', '900.00', '0.00', '0.00', '900.00'),
(2229, 31, '', 'FRANCE PERFUME ( LAVENDAR SMELL)', '0.00', '', 0, 3, '98.00', '98.00', 1, '0.00', '0.00', '98.00', '0.00', '0.00', '98.00'),
(2230, 31, '', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', 'bundles', 0, 4, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(2231, 31, '', 'GRAND TURISMO 2.4', '0.00', 'UNIT', 0, 5, '12000.00', '12000.00', 1, '0.00', '0.00', '12000.00', '0.00', '0.00', '12000.00'),
(2232, 32, '', 'FTFFTGFRTFRTF', '6.00', '', 0, 1, '900.00', '5400.00', 1, '0.00', '0.00', '5400.00', '0.00', '0.00', '5400.00'),
(2233, 32, '', 'CALENDAR FOR YEAR 2023 INCLUDING STICKERS MICKEY MOUSE', '0.00', 'PCS', 0, 2, '50.95', '50.95', 1, '0.00', '0.00', '50.95', '0.00', '0.00', '50.95'),
(2234, 32, '', 'COLORED PAPER A4', '0.00', '', 0, 3, '5.00', '5.00', 1, '0.00', '0.00', '5.00', '0.00', '0.00', '5.00'),
(2235, 32, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2236, 32, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2237, 32, '', '', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2238, 32, '', '', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2239, 33, '', 'FRAGRANCE SHAMPOO', '0.00', 'PCS', 0, 1, '78.95', '78.95', 1, '0.00', '0.00', '78.95', '0.00', '0.00', '78.95'),
(2240, 33, '', 'COMPUTER DELL XPS 15 16GB RAM 512GB SSD INTEL I9 PROCESSOR', '0.00', 'PCS', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2241, 33, '', 'CAR TINTING SERVICE - V COOL HOLLAND TYPE', '0.00', 'PCS', 0, 3, '66.00', '66.00', 1, '0.00', '0.00', '66.00', '0.00', '0.00', '66.00'),
(2242, 33, '', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', 'bundles', 0, 4, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(2243, 33, '', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '0.00', 'LOT', 0, 5, '3700.00', '3700.00', 1, '0.00', '0.00', '3700.00', '0.00', '0.00', '3700.00'),
(2255, 17, '1.', 'KUFAAN CHEESE PASTRY', '3.00', 'PCS', 0, 1, '30.00', '90.00', 1, '0.00', '0.00', '90.00', '0.00', '0.00', '90.00'),
(2256, 17, '2.', 'REMOVE WINDSCREEN AND TINTING WORKS DONE FOR THE WHOLE CAR', '3.50', 'UNITS', 0, 2, '66.00', '231.00', 1, '0.00', '0.00', '217.14', '6.00', '13.86', '217.14'),
(2257, 17, '3.', 'COMPUTER HP 16GB RAM 256 GB RAM JAPAN MADE', '0.00', 'PC', 0, 3, '100.00', '100.00', 4, '34.00', '34.00', '134.00', '0.00', '0.00', '100.00'),
(2258, 17, '', 'COMPUTER DELL XPS 15 16GB RAM 512GB SSD INTEL I9 PROCESSOR', '2.00', 'PCS', 1, 4, '34.00', '68.00', 1, '0.00', '0.00', '68.00', '0.00', '0.00', '68.00'),
(2259, 17, '1.', 'TEAK WOOD IKEA TABLE 5 X 7 FEET', '0.00', 'PCS', 0, 5, '45.00', '45.00', 1, '0.00', '0.00', '45.00', '0.00', '0.00', '45.00'),
(2260, 17, '', 'COMPUTER DELL XPS 15 16GB RAM 512GB SSD INTEL I9 PROCESSOR', '2.50', 'PCS', 1, 6, '78.80', '197.00', 1, '0.00', '0.00', '197.00', '0.00', '0.00', '197.00'),
(2261, 17, '1.', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '0.00', 'LOT', 0, 7, '80.00', '80.00', 1, '0.00', '0.00', '80.00', '0.00', '0.00', '80.00'),
(2262, 17, '2.', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE \r\nALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '0.00', 'LOT', 0, 8, '80.00', '80.00', 1, '0.00', '0.00', '80.00', '0.00', '0.00', '80.00'),
(2263, 17, '', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', 'bundles', 1, 9, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(2264, 17, '1.', 'CALENDAR FOR YEAR 2023 INCLUDING STICKERS MICKEY MOUSE', '0.00', 'PCS', 0, 10, '50.95', '50.95', 1, '0.00', '0.00', '50.95', '0.00', '0.00', '50.95'),
(2265, 17, '2.', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '0.00', 'LOT', 0, 11, '3700.00', '3700.00', 1, '0.00', '0.00', '3700.00', '0.00', '0.00', '3700.00'),
(2276, 34, '', '', '0.00', '', 0, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2277, 34, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2278, 34, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2279, 34, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2280, 34, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2281, 34, '', '', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2282, 34, '', '', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2283, 34, '', '', '0.00', '', 0, 8, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2284, 34, '', '', '0.00', '', 0, 9, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2285, 34, '', '', '0.00', '', 0, 10, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2286, 34, '', '', '0.00', '', 0, 11, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2287, 34, '', '', '0.00', '', 0, 12, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2288, 34, '', '', '0.00', '', 0, 13, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2289, 34, '', '', '0.00', '', 0, 14, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2290, 34, '', '', '0.00', '', 0, 15, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2291, 34, '', '', '0.00', '', 0, 16, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2292, 34, '', '', '0.00', '', 0, 17, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2293, 35, '1', 'PREPARE HOUSE TENANCY AGREEMENT FOR CUSTOMER FOR THE YEAR 2023 AND 2024', '2.00', 'LOT', 0, 1, '900.00', '1800.00', 2, '6.00', '103.68', '1831.68', '4.00', '72.00', '1728.00'),
(2294, 35, '2', 'FRAGRANCE SHAMPOO', '2.00', 'PCS', 0, 2, '78.95', '157.90', 2, '6.00', '9.47', '167.37', '0.00', '0.00', '157.90'),
(2295, 35, '3', 'LABOUR TO REPLACE PARTS & SERVICE', '4.00', 'bundles', 0, 3, '56.00', '224.00', 2, '6.00', '12.77', '225.57', '5.00', '11.20', '212.80'),
(2296, 35, '4', 'REMOVE WINDSCREEN AND TINTING WORKS DONE FOR THE WHOLE CAR', '3.00', 'UNITS', 0, 4, '56.00', '168.00', 1, '0.00', '0.00', '168.00', '0.00', '0.00', '168.00'),
(2297, 35, '5', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '3.00', 'LOT', 0, 5, '3700.00', '11100.00', 1, '0.00', '0.00', '11100.00', '0.00', '0.00', '11100.00'),
(2525, 37, '1.', 'TOP HOSE ORI', '0.00', '', 0, 1, '35.00', '35.00', 1, '0.00', '0.00', '35.00', '0.00', '0.00', '35.00'),
(2526, 37, '2.', 'LOWER HOSE ORI', '0.00', '', 0, 2, '55.00', '55.00', 1, '0.00', '0.00', '55.00', '0.00', '0.00', '55.00'),
(2527, 37, '3.', 'IRON PIPE ORI', '0.00', '', 0, 3, '115.00', '115.00', 1, '0.00', '0.00', '115.00', '0.00', '0.00', '115.00'),
(2528, 37, '4.', 'BY PASS LONG HOSE ORI', '0.00', '', 0, 4, '38.00', '38.00', 1, '0.00', '0.00', '38.00', '0.00', '0.00', '38.00'),
(2529, 37, '5.', 'THERMOSTAT ORI', '0.00', '', 0, 5, '55.00', '55.00', 1, '0.00', '0.00', '55.00', '0.00', '0.00', '55.00'),
(2530, 37, '6.', 'CLIP', '0.00', '', 0, 6, '15.00', '15.00', 1, '0.00', '0.00', '15.00', '0.00', '0.00', '15.00'),
(2531, 37, '7.', 'WASHER', '0.00', '', 0, 7, '8.00', '8.00', 1, '0.00', '0.00', '8.00', '0.00', '0.00', '8.00'),
(2532, 37, '8.', 'PIPER O RING', '0.00', '', 0, 8, '8.00', '8.00', 1, '0.00', '0.00', '8.00', '0.00', '0.00', '8.00'),
(2533, 37, '9.', 'WATER PUMP', '0.00', '', 0, 9, '120.00', '120.00', 1, '0.00', '0.00', '120.00', '0.00', '0.00', '120.00'),
(2534, 37, '10.', 'TOP SET GASKET TAIWAN CARBON -1set', '0.00', '', 0, 10, '150.00', '150.00', 1, '0.00', '0.00', '150.00', '0.00', '0.00', '150.00'),
(2535, 37, '11.', 'TIMING KIT SET', '0.00', '', 0, 11, '160.00', '160.00', 1, '0.00', '0.00', '160.00', '0.00', '0.00', '160.00'),
(2536, 37, '12.', 'FAN BELT', '0.00', '', 0, 12, '65.00', '65.00', 1, '0.00', '0.00', '65.00', '0.00', '0.00', '65.00'),
(2537, 37, '13.', 'ENGINE OIL', '0.00', '', 0, 13, '128.00', '128.00', 1, '0.00', '0.00', '128.00', '0.00', '0.00', '128.00'),
(2538, 37, '14.', 'OIL FILTER', '0.00', '', 0, 14, '15.00', '15.00', 1, '0.00', '0.00', '15.00', '0.00', '0.00', '15.00'),
(2539, 37, '15.', 'COOLANT', '0.00', '', 0, 15, '35.00', '35.00', 1, '0.00', '0.00', '35.00', '0.00', '0.00', '35.00'),
(2540, 37, '16.', 'RADIATOR SERVICE', '0.00', '', 0, 16, '160.00', '160.00', 1, '0.00', '0.00', '160.00', '0.00', '0.00', '160.00'),
(2541, 37, '17.', 'RADIATOR CAP', '0.00', '', 0, 17, '30.00', '30.00', 1, '0.00', '0.00', '30.00', '0.00', '0.00', '30.00'),
(2542, 37, '18.', 'ENGINE HEAD SKIMMING', '0.00', '', 0, 18, '60.00', '60.00', 1, '0.00', '0.00', '60.00', '0.00', '0.00', '60.00');
INSERT INTO `tbinvoicedetail` (`invoiceDetail_id`, `invoiceDetail_invoiceID`, `invoiceDetail_no1`, `invoiceDetail_no2`, `invoiceDetail_no3`, `invoiceDetail_no4`, `invoiceDetail_bold`, `invoiceDetail_sortID`, `invoiceDetail_no5`, `invoiceDetail_rowTotal`, `invoiceDetail_taxRateID`, `invoiceDetail_taxPercent`, `invoiceDetail_taxTotal`, `invoiceDetail_rowGrandTotal`, `invoiceDetail_discountPercent`, `invoiceDetail_discountAmount`, `invoiceDetail_rowTotalAfterDiscount`) VALUES
(2543, 37, '19.', 'NGK R SPARK PLUGS', '0.00', '', 0, 19, '65.00', '65.00', 1, '0.00', '0.00', '65.00', '0.00', '0.00', '65.00'),
(2544, 37, '20.', 'BRAKE CLEANER', '0.00', '', 0, 20, '45.00', '45.00', 1, '0.00', '0.00', '45.00', '0.00', '0.00', '45.00'),
(2545, 37, '21.', 'INJECTOR & PLUG COIL SOCKET', '3.00', '', 0, 21, '38.00', '114.00', 1, '0.00', '0.00', '114.00', '0.00', '0.00', '114.00'),
(2546, 37, '22.', 'FUSE', '3.00', '', 0, 22, '3.00', '9.00', 1, '0.00', '0.00', '9.00', '0.00', '0.00', '9.00'),
(2547, 37, '23.', 'LABOUR', '0.00', '', 0, 23, '450.00', '450.00', 1, '0.00', '0.00', '450.00', '0.00', '0.00', '450.00'),
(2548, 37, '', 'REMARKS', '0.00', '', 1, 24, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2549, 37, '1.', 'PISTON RING', '0.00', '', 0, 25, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2550, 37, '2.', 'ABSORBERS', '0.00', '', 0, 26, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2557, 36, '1.', 'CALENDAR FOR YEAR 2023 INCLUDING STICKERS MICKEY MOUSE', '0.00', 'PCS', 0, 1, '50.95', '50.95', 1, '0.00', '0.00', '50.95', '0.00', '0.00', '50.95'),
(2558, 36, '2.', 'COMPUTER DELL XPS 15 16GB RAM 512GB SSD INTEL I9 PROCESSOR', '0.00', 'PCS', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2559, 36, '3.', 'CAR TINTING SERVICE - V COOL HOLLAND TYPE', '0.00', 'PCS', 0, 3, '66.00', '66.00', 1, '0.00', '0.00', '66.00', '0.00', '0.00', '66.00'),
(2560, 36, '4.', 'DHLD PACKAGE DELIVERY CHARGES', '0.00', 'LOT', 0, 4, '50.00', '50.00', 1, '0.00', '0.00', '50.00', '0.00', '0.00', '50.00'),
(2561, 36, '5.', 'REMOVE WINDSCREEN AND TINTING WORKS DONE FOR THE WHOLE CAR', '0.00', 'UNITS', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2562, 36, '6.', 'CASIO SCIENTIFIC CALCULATOR\r\nMODEL 4590-J', '2.00', 'UNIT', 0, 6, '650.85', '1301.70', 2, '6.00', '70.29', '1241.82', '10.00', '130.17', '1171.53'),
(2563, 38, '', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAINAGE.', '0.00', 'LOT', 0, 1, '3700.00', '3700.00', 1, '0.00', '0.00', '3700.00', '0.00', '0.00', '3700.00'),
(2564, 38, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2565, 38, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2566, 38, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2567, 38, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2568, 38, '', '', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2569, 38, '', '', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2570, 38, '', '', '0.00', '', 0, 8, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2571, 38, '', '', '0.00', '', 0, 9, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2572, 38, '', '', '0.00', '', 0, 10, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2573, 38, '', '', '0.00', '', 0, 11, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2574, 38, '', '', '0.00', '', 0, 12, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2575, 38, '', '', '0.00', '', 0, 13, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2576, 39, '', 'BUTTER CHICKEN', '0.00', 'pcs', 0, 1, '67.55', '67.55', 1, '0.00', '0.00', '67.55', '0.00', '0.00', '67.55'),
(2577, 39, '', 'PREPARE HOUSE TENANCY AGREEMENT FOR CUSTOMER FOR THE YEAR 2023 AND 2024', '0.00', 'LOT', 0, 2, '900.00', '900.00', 1, '0.00', '0.00', '900.00', '0.00', '0.00', '900.00'),
(2578, 39, '', 'FRANCE PERFUME ( LAVENDAR SMELL)', '0.00', '', 0, 3, '98.00', '98.00', 1, '0.00', '0.00', '98.00', '0.00', '0.00', '98.00'),
(2579, 39, '', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', 'bundles', 0, 4, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(2580, 39, '', 'GRAND TURISMO 2.4', '0.00', 'UNIT', 0, 5, '12000.00', '12000.00', 1, '0.00', '0.00', '12000.00', '0.00', '0.00', '12000.00'),
(2581, 40, '', '', '5.00', '', 0, 1, '1000.00', '5000.00', 1, '0.00', '0.00', '5000.00', '0.00', '0.00', '5000.00'),
(2582, 40, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2583, 40, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2584, 40, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2585, 40, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2586, 41, '', '', '0.00', '', 0, 1, '888.00', '888.00', 1, '0.00', '0.00', '888.00', '0.00', '0.00', '888.00'),
(2587, 41, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2588, 41, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2589, 41, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2590, 41, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2591, 42, '', '', '0.00', '', 0, 1, '999.00', '999.00', 1, '0.00', '0.00', '999.00', '0.00', '0.00', '999.00'),
(2592, 42, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2593, 42, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2594, 42, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2595, 42, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2596, 43, '', '', '0.00', '', 0, 1, '6565.00', '6565.00', 1, '0.00', '0.00', '6565.00', '0.00', '0.00', '6565.00'),
(2597, 43, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2598, 43, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2599, 43, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2600, 43, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2606, 44, '', '', '0.00', '', 0, 1, '1717.00', '1717.00', 1, '0.00', '0.00', '1717.00', '0.00', '0.00', '1717.00'),
(2607, 44, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2608, 44, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2609, 44, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2610, 44, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2611, 45, '', '', '0.00', '', 0, 1, '666.00', '666.00', 1, '0.00', '0.00', '666.00', '0.00', '0.00', '666.00'),
(2612, 45, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2613, 45, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2614, 45, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2615, 45, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2616, 46, '', '', '0.00', '', 0, 1, '3232.00', '3232.00', 1, '0.00', '0.00', '3232.00', '0.00', '0.00', '3232.00'),
(2617, 46, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2618, 46, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2619, 46, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2620, 46, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2621, 47, '', 'COMPUTER DELL XPS 15 16GB RAM 512GB SSD INTEL I9 PROCESSOR', '34.00', 'PCS', 0, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2622, 47, '', 'PREPARE HOUSE TENANCY AGREEMENT FOR CUSTOMER FOR THE YEAR 2023 AND 2024', '33.00', 'LOT', 0, 2, '900.00', '29700.00', 1, '0.00', '0.00', '29700.00', '0.00', '0.00', '29700.00'),
(2623, 47, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2624, 47, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(2625, 47, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbpayment`
--

DROP TABLE IF EXISTS `tbpayment`;
CREATE TABLE IF NOT EXISTS `tbpayment` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_no` varchar(30) NOT NULL,
  `payment_date` date NOT NULL,
  `payment_paymentMethodID` int(11) NOT NULL DEFAULT '0',
  `payment_chequeInfo` varchar(100) NOT NULL,
  `payment_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_userID` int(11) NOT NULL,
  `payment_remark` varchar(100) NOT NULL,
  `payment_status` int(1) NOT NULL DEFAULT '1' COMMENT '1=paid, 0=cancel, 2=post date',
  `payment_cancelDate` date DEFAULT NULL,
  `payment_cancelReason` varchar(150) NOT NULL,
  `payment_cancelUserID` int(11) NOT NULL,
  `payment_customerID` int(11) NOT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbpayment`
--

INSERT INTO `tbpayment` (`payment_id`, `payment_no`, `payment_date`, `payment_paymentMethodID`, `payment_chequeInfo`, `payment_amount`, `payment_userID`, `payment_remark`, `payment_status`, `payment_cancelDate`, `payment_cancelReason`, `payment_cancelUserID`, `payment_customerID`) VALUES
(13, 'RPT/2023/001', '2023-07-08', 1, '', '1000.00', 4, '', 1, NULL, '', 0, 94),
(14, 'RPT/2023/002', '2023-07-12', 1, '', '888.00', 4, '', 1, NULL, '', 0, 94),
(15, 'RPT/2023/003', '2023-07-17', 1, '', '350.00', 4, '', 1, NULL, '', 0, 76),
(16, 'RPT/2023/005', '2023-08-25', 2, '', '48250.17', 4, 'DHDH', 1, NULL, '', 0, 94),
(17, 'RPT/2023/006', '2023-09-05', 1, '', '33.00', 4, '', 1, NULL, '', 0, 234);

-- --------------------------------------------------------

--
-- Table structure for table `tbpaymentdetail`
--

DROP TABLE IF EXISTS `tbpaymentdetail`;
CREATE TABLE IF NOT EXISTS `tbpaymentdetail` (
  `paymentDetail_id` int(11) NOT NULL AUTO_INCREMENT,
  `paymentDetail_paymentID` int(11) NOT NULL,
  `paymentDetail_invoiceID` int(11) NOT NULL,
  `paymentDetail_amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`paymentDetail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbpaymentdetail`
--

INSERT INTO `tbpaymentdetail` (`paymentDetail_id`, `paymentDetail_paymentID`, `paymentDetail_invoiceID`, `paymentDetail_amount`) VALUES
(27, 13, 1, '500.00'),
(28, 13, 2, '500.00'),
(29, 14, 5, '888.00'),
(30, 15, 8, '350.00'),
(31, 16, 1, '500.00'),
(32, 16, 2, '722.80'),
(33, 16, 4, '6000.00'),
(34, 16, 5, '6142.50'),
(35, 16, 6, '4482.88'),
(36, 16, 11, '3325.95'),
(37, 16, 15, '16902.00'),
(38, 16, 17, '4718.09'),
(39, 16, 32, '5455.95'),
(40, 17, 37, '33.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbpaymentmethod`
--

DROP TABLE IF EXISTS `tbpaymentmethod`;
CREATE TABLE IF NOT EXISTS `tbpaymentmethod` (
  `paymentMethod_id` int(11) NOT NULL AUTO_INCREMENT,
  `paymentMethod_name` varchar(50) NOT NULL,
  PRIMARY KEY (`paymentMethod_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbpaymentmethod`
--

INSERT INTO `tbpaymentmethod` (`paymentMethod_id`, `paymentMethod_name`) VALUES
(1, 'CASH'),
(2, 'CHEQUE'),
(3, 'BANK TRANSFER'),
(4, 'DEBIT CARD'),
(5, 'CREDIT CARD'),
(6, 'MOBILE PAYMENTS');

-- --------------------------------------------------------

--
-- Table structure for table `tbpaymentvoucher`
--

DROP TABLE IF EXISTS `tbpaymentvoucher`;
CREATE TABLE IF NOT EXISTS `tbpaymentvoucher` (
  `paymentVoucher_id` int(11) NOT NULL AUTO_INCREMENT,
  `paymentVoucher_no` varchar(30) NOT NULL,
  `paymentVoucher_date` date NOT NULL,
  `paymentVoucher_paymentMethodID` int(11) NOT NULL DEFAULT '0',
  `paymentVoucher_chequeInfo` varchar(100) NOT NULL,
  `paymentVoucher_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `paymentVoucher_userID` int(11) NOT NULL,
  `paymentVoucher_remark` varchar(100) NOT NULL,
  `paymentVoucher_status` int(1) NOT NULL DEFAULT '1' COMMENT '1=paid, 0=cancel, 2=post date',
  `paymentVoucher_cancelDate` date DEFAULT NULL,
  `paymentVoucher_cancelReason` varchar(150) NOT NULL,
  `paymentVoucher_cancelUserID` int(11) NOT NULL,
  `paymentVoucher_customerID` int(11) NOT NULL,
  PRIMARY KEY (`paymentVoucher_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbpaymentvoucher`
--

INSERT INTO `tbpaymentvoucher` (`paymentVoucher_id`, `paymentVoucher_no`, `paymentVoucher_date`, `paymentVoucher_paymentMethodID`, `paymentVoucher_chequeInfo`, `paymentVoucher_amount`, `paymentVoucher_userID`, `paymentVoucher_remark`, `paymentVoucher_status`, `paymentVoucher_cancelDate`, `paymentVoucher_cancelReason`, `paymentVoucher_cancelUserID`, `paymentVoucher_customerID`) VALUES
(1, 'PV/2023/001', '2023-08-03', 2, 'public bank 657744', '70.00', 4, '', 1, NULL, '', 0, 18);

-- --------------------------------------------------------

--
-- Table structure for table `tbpaymentvoucherdetail`
--

DROP TABLE IF EXISTS `tbpaymentvoucherdetail`;
CREATE TABLE IF NOT EXISTS `tbpaymentvoucherdetail` (
  `paymentVoucherDetail_id` int(11) NOT NULL AUTO_INCREMENT,
  `paymentVoucherDetail_paymentVoucherID` int(11) NOT NULL,
  `paymentVoucherDetail_purchaseBillID` int(11) NOT NULL,
  `paymentVoucherDetail_amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`paymentVoucherDetail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbpaymentvoucherdetail`
--

INSERT INTO `tbpaymentvoucherdetail` (`paymentVoucherDetail_id`, `paymentVoucherDetail_paymentVoucherID`, `paymentVoucherDetail_purchaseBillID`, `paymentVoucherDetail_amount`) VALUES
(1, 1, 2, '70.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbproduct`
--

DROP TABLE IF EXISTS `tbproduct`;
CREATE TABLE IF NOT EXISTS `tbproduct` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_code` varchar(30) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `product_description` varchar(200) NOT NULL,
  `product_type` varchar(1) NOT NULL DEFAULT 'p' COMMENT 'p=product, s=service',
  `product_buyingPrice` decimal(10,2) NOT NULL DEFAULT '0.00',
  `product_sellingPrice` decimal(10,2) NOT NULL DEFAULT '0.00',
  `product_stock` decimal(10,2) NOT NULL DEFAULT '0.00',
  `product_uom` varchar(15) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbproduct`
--

INSERT INTO `tbproduct` (`product_id`, `product_code`, `product_name`, `product_description`, `product_type`, `product_buyingPrice`, `product_sellingPrice`, `product_stock`, `product_uom`) VALUES
(36, '', 'Desludging Tanker 10 cubic metres (Cina Made)', '', 's', '77.00', '99.00', '0.00', 'units'),
(37, '', 'Jetting Works and Clear blockages with rodder machine', '', 'p', '5.00', '6.00', '0.00', 'unit'),
(38, '', 'MOTOROLLA HANDPHONE MODEL X-9', '', 'p', '1340.00', '5006.75', '0.00', 'unit'),
(43, '', 'LABOUR TO REPLACE PARTS & SERVICE', '', 's', '45.00', '56.00', '0.00', 'bundles'),
(44, '', 'TOP RADIATOR HOSE ORIGINAL', '', 'p', '345.00', '450.00', '0.00', ''),
(45, '', 'NOKIA CHARGER TYPE CARBON 4598BK', '', 'p', '50.00', '59.00', '0.00', 'UNIT'),
(48, '', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAINAGE.', '', 's', '3400.00', '3700.00', '0.00', 'LOT'),
(55, '', 'REMOVE WINDSCREEN AND TINTING WORKS DONE FOR THE WHOLE CAR', '', 's', '0.00', '0.00', '0.00', 'UNITS'),
(56, '', 'COMPUTER DELL XPS 15 16GB RAM 512GB SSD INTEL I9 PROCESSOR', '', 'p', '0.00', '0.00', '0.00', 'PCS'),
(57, '', 'PREPARE HOUSE TENANCY AGREEMENT FOR CUSTOMER FOR THE YEAR 2023 AND 2024', '', 's', '800.00', '900.00', '0.00', 'LOT'),
(58, '', 'CAR DENT KNOCKING AND PAINTING', '', 's', '0.00', '0.00', '0.00', 'LOT'),
(59, '', 'TEAK WOOD IKEA TABLE 5 X 7 FEET', '', 's', '0.00', '0.00', '0.00', 'PCS'),
(61, '', 'KUFAAN CHEESE PASTRY', '', 'p', '15.00', '30.00', '0.00', 'PCS'),
(62, '', 'COLGATE MEDIUM PACKET', '', 'p', '33.00', '55.00', '0.00', 'bottle'),
(69, '', 'CHANGE CAR TYRES', '', 's', '55.00', '66.00', '0.00', 'PERSON'),
(70, '', 'COMPUTER HP 16GB RAM 256 GB RAM JAPAN MADE', '', 'p', '500.00', '100.00', '0.00', 'PC'),
(71, '', 'MILO TIN BIG ( MADE IN HOLLAND)', '', 'p', '55.00', '66.00', '0.00', 'TIN'),
(73, '', 'RATTAN CHAIR (japan made)', '', 's', '55.00', '99.00', '0.00', 'PCS'),
(74, '', 'STEEL CHAIR', '', 'p', '33.00', '209.50', '0.00', 'UNIT'),
(75, '', 'PLASTIC CHAIR', '', 's', '32.50', '421.00', '0.00', 'CRATE'),
(76, '', 'CAR AIRCOND REFILL GAS AND SERVICE', '', 's', '77.00', '99.65', '0.00', ''),
(77, '', 'EYE CHECKUP', '', 's', '33.00', '90.00', '0.00', ''),
(78, '', 'LADDER', '', 'p', '36.00', '55.00', '0.00', ''),
(79, '', 'DHLD PACKAGE DELIVERY CHARGES', '', 's', '23.50', '50.00', '0.00', 'LOT'),
(80, '', 'COLORED PAPER A4', '', 'p', '3.50', '5.00', '0.00', ''),
(81, '', 'GRAND TURISMO 2.4', '', 'p', '11500.00', '12000.00', '0.00', 'UNIT'),
(82, '', 'CALENDAR FOR YEAR 2023 INCLUDING STICKERS MICKEY MOUSE', '', 'p', '41.55', '50.95', '0.00', 'PCS'),
(83, '', 'CAR POLISH 2.5 LITRES', '', 'p', '16.90', '19.00', '0.00', 'BOTTLE'),
(84, '', 'CAR TINTING SERVICE - V COOL HOLLAND TYPE', '', 'p', '100.00', '66.00', '0.00', 'PCS'),
(85, '', 'MAZDA X5 TYRE CHANGE 175/90PSI JAPAN MADE', '', 's', '100.00', '130.50', '0.00', 'PCS'),
(86, '', 'CAR AIRCOND HOSE 99', '', 'p', '45.00', '65.65', '0.00', 'UNITS'),
(87, '', 'CAR CARBURATOR CHANGE', '', 's', '0.00', '33.00', '0.00', ''),
(91, '', 'FRANCE PERFUME ( LAVENDAR SMELL)', '', 's', '67.00', '98.00', '0.00', ''),
(92, '', 'FRAGRANCE SHAMPOO', '', 's', '55.00', '78.95', '0.00', 'PCS'),
(93, '', 'BEZA CAR Malaysia Made', '', 'p', '2500.45', '3500.90', '0.00', 'PCS'),
(94, '', 'BUTTER CHICKEN', '', 'p', '56.00', '67.55', '0.00', 'pcs'),
(95, '', 'CABBAGE PRODUCE', '', 's', '34.00', '77.00', '0.00', ''),
(96, '', 'APPLE CIDER', '', 'p', '99.00', '111.00', '0.00', 'bottles'),
(97, '', 'Apple Laptop Air', '', 'p', '4500.00', '6590.55', '0.00', 'unit'),
(98, '', 'APPLE WATCH SMART', '', 'p', '450.00', '665.00', '0.00', 'PCS'),
(99, '', 'CASIO SCIENTIFIC CALCULATOR\nMODEL 4590-J', '', 'p', '560.75', '650.85', '0.00', 'UNIT');

-- --------------------------------------------------------

--
-- Table structure for table `tbproject`
--

DROP TABLE IF EXISTS `tbproject`;
CREATE TABLE IF NOT EXISTS `tbproject` (
  `project_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(100) NOT NULL,
  `project_status` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbproject`
--

INSERT INTO `tbproject` (`project_id`, `project_name`, `project_status`) VALUES
(1, 'No Project', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbpurchasebill`
--

DROP TABLE IF EXISTS `tbpurchasebill`;
CREATE TABLE IF NOT EXISTS `tbpurchasebill` (
  `purchaseBill_id` int(11) NOT NULL AUTO_INCREMENT,
  `purchaseBill_no` varchar(30) NOT NULL,
  `purchaseBill_date` date NOT NULL,
  `purchaseBill_customerID` int(11) NOT NULL,
  `purchaseBill_title` varchar(200) NOT NULL,
  `purchaseBill_from` varchar(50) NOT NULL,
  `purchaseBill_terms` text NOT NULL,
  `purchaseBill_attention` varchar(100) NOT NULL,
  `purchaseBill_email` varchar(100) NOT NULL,
  `purchaseBill_subTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchaseBill_taxTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchaseBill_grandTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchaseBill_discountTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchaseBill_totalAfterDiscount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchaseBill_roundAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchaseBill_grandTotalRound` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchaseBill_roundStatus` int(1) NOT NULL DEFAULT '0',
  `purchaseBill_content` text NOT NULL,
  `purchaseBill_account3ID` int(6) NOT NULL,
  `purchaseBill_customerInvoiceNo` varchar(80) NOT NULL,
  `purchaseBill_purchaseOrderID` int(11) NOT NULL DEFAULT '0',
  `purchaseBill_purchaseOrderNo` varchar(30) NOT NULL,
  `purchaseBill_paid` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchaseBill_status` varchar(1) NOT NULL DEFAULT 'a' COMMENT 'a=active, c=cancel',
  PRIMARY KEY (`purchaseBill_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbpurchasebill`
--

INSERT INTO `tbpurchasebill` (`purchaseBill_id`, `purchaseBill_no`, `purchaseBill_date`, `purchaseBill_customerID`, `purchaseBill_title`, `purchaseBill_from`, `purchaseBill_terms`, `purchaseBill_attention`, `purchaseBill_email`, `purchaseBill_subTotal`, `purchaseBill_taxTotal`, `purchaseBill_grandTotal`, `purchaseBill_discountTotal`, `purchaseBill_totalAfterDiscount`, `purchaseBill_roundAmount`, `purchaseBill_grandTotalRound`, `purchaseBill_roundStatus`, `purchaseBill_content`, `purchaseBill_account3ID`, `purchaseBill_customerInvoiceNo`, `purchaseBill_purchaseOrderID`, `purchaseBill_purchaseOrderNo`, `purchaseBill_paid`, `purchaseBill_status`) VALUES
(1, 'PB001', '2023-07-10', 208, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', '', '', '45.00', '0.00', '45.00', '0.00', '45.00', '0.00', '45.00', 0, '', 13, '', 0, '', '0.00', 'a'),
(2, 'PB002', '2023-07-12', 18, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'ENCIK KAMARUDDIN', 'fn_malaysia@gmail.com', '70.00', '0.00', '70.00', '0.00', '70.00', '0.00', '70.00', 0, '', 17, '', 0, '', '70.00', 'a'),
(3, 'PB003', '2023-09-05', 221, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', '', '', '700.00', '0.00', '700.00', '0.00', '700.00', '0.00', '700.00', 0, '', 12, 'IN5609-8786', 0, '', '0.00', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `tbpurchasebilldetail`
--

DROP TABLE IF EXISTS `tbpurchasebilldetail`;
CREATE TABLE IF NOT EXISTS `tbpurchasebilldetail` (
  `purchaseBillDetail_id` int(11) NOT NULL AUTO_INCREMENT,
  `purchaseBillDetail_purchaseBillID` int(10) NOT NULL,
  `purchaseBillDetail_no1` varchar(200) NOT NULL,
  `purchaseBillDetail_no2` varchar(200) NOT NULL,
  `purchaseBillDetail_no3` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchaseBillDetail_no4` varchar(200) NOT NULL,
  `purchaseBillDetail_bold` int(11) NOT NULL DEFAULT '0' COMMENT '0=normal, 1=bold',
  `purchaseBillDetail_sortID` int(2) NOT NULL DEFAULT '0',
  `purchaseBillDetail_no5` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchaseBillDetail_rowTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchaseBillDetail_taxRateID` int(10) NOT NULL DEFAULT '0',
  `purchaseBillDetail_taxPercent` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchaseBillDetail_taxTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchaseBillDetail_rowGrandTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchaseBillDetail_discountPercent` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchaseBillDetail_discountAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchaseBillDetail_rowTotalAfterDiscount` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`purchaseBillDetail_id`),
  KEY `purchaseBillDetail_purchaseBillID` (`purchaseBillDetail_purchaseBillID`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbpurchasebilldetail`
--

INSERT INTO `tbpurchasebilldetail` (`purchaseBillDetail_id`, `purchaseBillDetail_purchaseBillID`, `purchaseBillDetail_no1`, `purchaseBillDetail_no2`, `purchaseBillDetail_no3`, `purchaseBillDetail_no4`, `purchaseBillDetail_bold`, `purchaseBillDetail_sortID`, `purchaseBillDetail_no5`, `purchaseBillDetail_rowTotal`, `purchaseBillDetail_taxRateID`, `purchaseBillDetail_taxPercent`, `purchaseBillDetail_taxTotal`, `purchaseBillDetail_rowGrandTotal`, `purchaseBillDetail_discountPercent`, `purchaseBillDetail_discountAmount`, `purchaseBillDetail_rowTotalAfterDiscount`) VALUES
(1, 1, '', '', '0.00', '', 0, 1, '45.00', '45.00', 1, '0.00', '0.00', '45.00', '0.00', '0.00', '45.00'),
(2, 1, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(3, 1, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(4, 1, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(5, 1, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(6, 2, '', '', '0.00', '', 0, 1, '70.00', '70.00', 1, '0.00', '0.00', '70.00', '0.00', '0.00', '70.00'),
(7, 2, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(8, 2, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(9, 2, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(10, 2, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(11, 3, '', '', '0.00', '', 0, 1, '700.00', '700.00', 1, '0.00', '0.00', '700.00', '0.00', '0.00', '700.00'),
(12, 3, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(13, 3, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(14, 3, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(15, 3, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbpurchaseorder`
--

DROP TABLE IF EXISTS `tbpurchaseorder`;
CREATE TABLE IF NOT EXISTS `tbpurchaseorder` (
  `purchaseOrder_id` int(11) NOT NULL AUTO_INCREMENT,
  `purchaseOrder_no` varchar(30) NOT NULL,
  `purchaseOrder_date` date NOT NULL,
  `purchaseOrder_customerID` int(11) NOT NULL,
  `purchaseOrder_title` varchar(200) NOT NULL,
  `purchaseOrder_from` varchar(50) NOT NULL,
  `purchaseOrder_terms` text NOT NULL,
  `purchaseOrder_attention` varchar(100) NOT NULL,
  `purchaseOrder_email` varchar(100) NOT NULL,
  `purchaseOrder_subTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchaseOrder_taxTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchaseOrder_grandTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchaseOrder_discountTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchaseOrder_totalAfterDiscount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchaseOrder_roundAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchaseOrder_grandTotalRound` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchaseOrder_roundStatus` int(1) NOT NULL DEFAULT '0',
  `purchaseOrder_content` text NOT NULL,
  `purchaseOrder_purchaseBillID` int(11) NOT NULL DEFAULT '0',
  `purchaseOrder_purchaseBillNo` varchar(30) NOT NULL,
  PRIMARY KEY (`purchaseOrder_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbpurchaseorder`
--

INSERT INTO `tbpurchaseorder` (`purchaseOrder_id`, `purchaseOrder_no`, `purchaseOrder_date`, `purchaseOrder_customerID`, `purchaseOrder_title`, `purchaseOrder_from`, `purchaseOrder_terms`, `purchaseOrder_attention`, `purchaseOrder_email`, `purchaseOrder_subTotal`, `purchaseOrder_taxTotal`, `purchaseOrder_grandTotal`, `purchaseOrder_discountTotal`, `purchaseOrder_totalAfterDiscount`, `purchaseOrder_roundAmount`, `purchaseOrder_grandTotalRound`, `purchaseOrder_roundStatus`, `purchaseOrder_content`, `purchaseOrder_purchaseBillID`, `purchaseOrder_purchaseBillNo`) VALUES
(1, 'PO/2023/001', '2023-08-17', 94, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'MR RAMESH / SHOBA', 'admin@clean_sewers.com', '1000.07', '0.00', '1000.07', '0.00', '1000.07', '0.00', '1000.07', 0, '', 0, ''),
(2, 'PO/2023/002', '2023-08-22', 18, 'PARTS FOR KELANA JAYA PHARMACY', 'RANJIV SINGH', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'ENCIK KAMARUDDIN', 'fn_malaysia@gmail.com', '8941.00', '472.86', '9254.86', '159.00', '8782.00', '0.00', '9254.86', 0, '<p><strong>Sewerage Engineering Service</strong> takes full responsibility on all Grease Trap tank waste collected from <strong>HAIDILAO INTERNATIONAL FOOD SERVICES MALAYSIA SDN BHD</strong></p>', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbpurchaseorderdetail`
--

DROP TABLE IF EXISTS `tbpurchaseorderdetail`;
CREATE TABLE IF NOT EXISTS `tbpurchaseorderdetail` (
  `purchaseOrderDetail_id` int(11) NOT NULL AUTO_INCREMENT,
  `purchaseOrderDetail_purchaseOrderID` int(10) NOT NULL,
  `purchaseOrderDetail_no1` varchar(200) NOT NULL,
  `purchaseOrderDetail_no2` varchar(200) NOT NULL,
  `purchaseOrderDetail_no3` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchaseOrderDetail_no4` varchar(200) NOT NULL,
  `purchaseOrderDetail_bold` int(11) NOT NULL DEFAULT '0' COMMENT '0=normal, 1=bold',
  `purchaseOrderDetail_sortID` int(2) NOT NULL DEFAULT '0',
  `purchaseOrderDetail_no5` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchaseOrderDetail_rowTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchaseOrderDetail_taxRateID` int(10) NOT NULL DEFAULT '0',
  `purchaseOrderDetail_taxPercent` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchaseOrderDetail_taxTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchaseOrderDetail_rowGrandTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchaseOrderDetail_discountPercent` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchaseOrderDetail_discountAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `purchaseOrderDetail_rowTotalAfterDiscount` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`purchaseOrderDetail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbpurchaseorderdetail`
--

INSERT INTO `tbpurchaseorderdetail` (`purchaseOrderDetail_id`, `purchaseOrderDetail_purchaseOrderID`, `purchaseOrderDetail_no1`, `purchaseOrderDetail_no2`, `purchaseOrderDetail_no3`, `purchaseOrderDetail_no4`, `purchaseOrderDetail_bold`, `purchaseOrderDetail_sortID`, `purchaseOrderDetail_no5`, `purchaseOrderDetail_rowTotal`, `purchaseOrderDetail_taxRateID`, `purchaseOrderDetail_taxPercent`, `purchaseOrderDetail_taxTotal`, `purchaseOrderDetail_rowGrandTotal`, `purchaseOrderDetail_discountPercent`, `purchaseOrderDetail_discountAmount`, `purchaseOrderDetail_rowTotalAfterDiscount`) VALUES
(1, 1, '', '', '0.00', '', 0, 1, '1000.07', '1000.07', 1, '0.00', '0.00', '1000.07', '0.00', '0.00', '1000.07'),
(2, 1, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(3, 1, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(4, 1, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(5, 1, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(55, 2, '', 'PARTS AND SPARES', '0.00', '', 1, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(56, 2, '1.', 'CAR AIRCOND REFILL GAS AND SERVICE', '3.00', '', 0, 2, '77.00', '231.00', 2, '6.00', '13.86', '244.86', '0.00', '0.00', '231.00'),
(57, 2, '2.', 'CAR CARBURATOR CHANGE', '0.00', '', 0, 3, '77.00', '77.00', 1, '0.00', '0.00', '77.00', '0.00', '0.00', '77.00'),
(58, 2, '3.', 'CAR TINTING SERVICE - V COOL HOLLAND TYPE', '0.00', 'PCS', 0, 4, '100.00', '100.00', 1, '0.00', '0.00', '91.00', '9.00', '9.00', '91.00'),
(59, 2, '', 'ELECTRICAL PARTS', '0.00', '', 1, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(60, 2, '1.', 'COLGATE MEDIUM PACKET', '0.00', 'bottle', 0, 6, '33.00', '33.00', 1, '0.00', '0.00', '33.00', '0.00', '0.00', '33.00'),
(61, 2, '2.', 'MAZDA X5 TYRE CHANGE 175/90PSI JAPAN MADE', '0.00', 'PCS', 0, 7, '100.00', '100.00', 1, '0.00', '0.00', '100.00', '0.00', '0.00', '100.00'),
(62, 2, '3.', 'PREPARE HOUSE TENANCY AGREEMENT FOR CUSTOMER FOR THE YEAR 2023 AND 2024', '5.00', 'LOT', 0, 8, '690.00', '3450.00', 1, '0.00', '0.00', '3450.00', '0.00', '0.00', '3450.00'),
(63, 2, '4.', 'NOKIA CHARGER TYPE CARBON 4598BK', '0.00', 'UNIT', 0, 9, '50.00', '50.00', 1, '0.00', '0.00', '50.00', '0.00', '0.00', '50.00'),
(64, 2, '5.', 'REMOVE WINDSCREEN AND TINTING WORKS DONE FOR THE WHOLE CAR', '3.00', 'UNITS', 0, 10, '500.00', '1500.00', 4, '34.00', '459.00', '1809.00', '10.00', '150.00', '1350.00'),
(65, 2, '', 'LABOUR', '0.00', '', 1, 11, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(66, 2, '1.', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '0.00', 'LOT', 0, 12, '3400.00', '3400.00', 1, '0.00', '0.00', '3400.00', '0.00', '0.00', '3400.00'),
(67, 2, '', '', '0.00', '', 0, 13, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(68, 2, '', '', '0.00', '', 0, 14, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbquotation`
--

DROP TABLE IF EXISTS `tbquotation`;
CREATE TABLE IF NOT EXISTS `tbquotation` (
  `quotation_id` int(11) NOT NULL AUTO_INCREMENT,
  `quotation_no` varchar(30) NOT NULL,
  `quotation_date` date NOT NULL,
  `quotation_customerID` int(11) NOT NULL,
  `quotation_title` varchar(200) NOT NULL,
  `quotation_from` varchar(50) NOT NULL,
  `quotation_terms` text NOT NULL,
  `quotation_attention` varchar(100) NOT NULL,
  `quotation_email` varchar(100) NOT NULL,
  `quotation_subTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quotation_taxTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quotation_grandTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quotation_discountTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quotation_totalAfterDiscount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quotation_roundAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quotation_grandTotalRound` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quotation_roundStatus` int(1) NOT NULL DEFAULT '0',
  `quotation_content` text NOT NULL,
  `quotation_invoiceNo` varchar(30) NOT NULL,
  `quotation_invoiceID` int(11) NOT NULL DEFAULT '0',
  `quotation_deliveryOrderNo` varchar(30) NOT NULL,
  `quotation_deliveryOrderID` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`quotation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbquotation`
--

INSERT INTO `tbquotation` (`quotation_id`, `quotation_no`, `quotation_date`, `quotation_customerID`, `quotation_title`, `quotation_from`, `quotation_terms`, `quotation_attention`, `quotation_email`, `quotation_subTotal`, `quotation_taxTotal`, `quotation_grandTotal`, `quotation_discountTotal`, `quotation_totalAfterDiscount`, `quotation_roundAmount`, `quotation_grandTotalRound`, `quotation_roundStatus`, `quotation_content`, `quotation_invoiceNo`, `quotation_invoiceID`, `quotation_deliveryOrderNo`, `quotation_deliveryOrderID`) VALUES
(1, 'QO/2023/001', '2023-07-08', 94, '', '', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>Payment should be made to <strong>KSN SEWERAGE ENGINEERING SERVICE</strong> &quot; at Public Bank 3122 136 534&nbsp;</li></ol>', 'MR RAMESH / SHOBA', 'admin@clean_sewers.com', '1000.00', '0.00', '1000.00', '0.00', '1000.00', '0.00', '1000.00', 0, '', 'INV/2023/001', 1, '', 0),
(2, 'QO/2023/002', '2023-07-24', 174, '', '', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>Payment should be made to <strong>KSN SEWERAGE ENGINEERING SERVICE</strong> &quot; at Public Bank 3122 136 534&nbsp;</li></ol>', 'MANAGEMENT OFFICE', '', '4953.45', '0.00', '4953.45', '0.00', '4953.45', '0.00', '4953.45', 0, '', 'INV/2023/010', 9, '', 0),
(3, 'QO/2023/003', '2023-08-14', 132, '', '', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>Payment should be made to <strong>KSN SEWERAGE ENGINEERING SERVICE</strong> &quot; at Public Bank 3122 136 534&nbsp;</li></ol>', 'MR ALI KAMARUDDIN', 'care@iwk.com.my', '5088.05', '0.00', '5088.05', '0.00', '5088.05', '0.00', '5088.05', 0, '', '', 0, '', 0),
(4, 'QO/2023/005', '2023-08-17', 95, 'SENT PARTS TO IPOH AND ALL THE PORT KLANG ( BY AIR KARGO YT00098764-89  rap tank waste collected from HAIDILAO INTERNATIONAL FOOD SERVICES MALAYSIA', '', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>Payment should be made to <strong>KSN SEWERAGE ENGINEERING SERVICE</strong> &quot; at Public Bank 3122 136 534&nbsp;</li></ol>', 'JAMES LOWERENCE', '', '13121.55', '0.00', '13121.55', '0.00', '13121.55', '0.00', '13121.55', 0, '<p>SENT PARTS TO IPOH AND ALL THE PORT KLANG ( BY AIR KARGO YT00098764-89 &nbsp;rap tank waste collected from HAIDILAO INTERNATIONAL FOOD SERVICES MALAYSIA SDN BHD</p>', 'INV/2023/031', 31, '', 0),
(5, 'QO/2023/006', '2023-08-18', 94, 'QUOTATION FOR TREE CUTTING, HOUSE DEMOLISHMENT AND OTHER RELATED WORKS', 'Mr Subramaniam', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>Payment should be made to <strong>KSN SEWERAGE ENGINEERING SERVICE</strong> &quot; at Public Bank 3122 136 534&nbsp;</li></ol>', 'MR RAMESH / SHOBA', 'admin@clean_sewers.com', '13520.70', '447.62', '13817.02', '151.30', '13369.40', '0.00', '13817.02', 0, '<p>Please send all the Drawings and report from MPPJ Selangor. All other related works need to get MPSJ Subang approval first.</p><p>Please acknowledge delivery of report.</p>', '', 0, '', 0),
(6, 'QO/2023/007', '2023-08-19', 132, '', '', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>Payment should be made to <strong>KSN SEWERAGE ENGINEERING SERVICE</strong> &quot; at Public Bank 3122 136 534&nbsp;</li></ol>', 'MR ALI KAMARUDDIN', 'care@iwk.com.my', '14412.65', '568.80', '14793.85', '187.60', '14225.05', '0.00', '14793.85', 0, '<p>Please send all the Drawings and report from MPPJ Selangor. All other related works need to get MPSJ Subang approval first.</p><p>Please acknowledge delivery of report.</p>', 'INV/2023/030', 30, '', 0),
(7, 'QO/2023/008', '2023-08-23', 34, '', '', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>Payment should be made to <strong>KSN SEWERAGE ENGINEERING SERVICE</strong> &quot; at Public Bank 3122 136 534&nbsp;</li></ol>', 'Mr Gobalan', 'gobalan2829@gmail.com', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0, '', '', 0, '', 0),
(8, 'QO/2023/009', '2023-08-28', 118, '', '', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>Payment should be made to <strong>KSN SEWERAGE ENGINEERING SERVICE</strong> &quot; at Public Bank 3122 136 534&nbsp;</li></ol>', '', '', '3700.00', '0.00', '3700.00', '0.00', '3700.00', '0.00', '3700.00', 0, '', 'INV/2023/038', 38, '', 0),
(9, 'QO/2023/010', '2023-09-05', 146, '', '', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>Payment should be made to <strong>KSN SEWERAGE ENGINEERING SERVICE</strong> &quot; at Public Bank 3122 136 534&nbsp;</li></ol>', 'CIKGU RAMESH', '', '13121.55', '0.00', '13121.55', '0.00', '13121.55', '0.00', '13121.55', 0, '<p>SENT PARTS TO IPOH AND ALL THE PORT KLANG ( BY AIR KARGO YT00098764-89 &nbsp;rap tank waste collected from HAIDILAO INTERNATIONAL FOOD SERVICES MALAYSIA SDN BHD</p>', 'INV/2023/039', 39, 'DO/2023/005', 5),
(10, 'QO/2023/011', '2023-09-08', 132, '', '', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>Payment should be made to <strong>KSN SEWERAGE ENGINEERING SERVICE</strong> &quot; at Public Bank 3122 136 534&nbsp;</li></ol>', 'MR ALI KAMARUDDIN', 'care@iwk.com.my', '666.00', '0.00', '666.00', '0.00', '666.00', '0.00', '666.00', 0, '', 'INV/2023/046', 45, '', 0),
(11, 'QO/2023/012', '2023-09-08', 76, '', '', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>Payment should be made to <strong>KSN SEWERAGE ENGINEERING SERVICE</strong> &quot; at Public Bank 3122 136 534&nbsp;</li></ol>', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', '', '3232.00', '0.00', '3232.00', '0.00', '3232.00', '0.00', '3232.00', 0, '', 'INV/2023/047', 46, 'DO/2023/006', 6);

-- --------------------------------------------------------

--
-- Table structure for table `tbquotationdetail`
--

DROP TABLE IF EXISTS `tbquotationdetail`;
CREATE TABLE IF NOT EXISTS `tbquotationdetail` (
  `quotationDetail_id` int(11) NOT NULL AUTO_INCREMENT,
  `quotationDetail_quotationID` int(10) NOT NULL,
  `quotationDetail_no1` varchar(200) NOT NULL,
  `quotationDetail_no2` varchar(200) NOT NULL,
  `quotationDetail_no3` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quotationDetail_no4` varchar(200) NOT NULL,
  `quotationDetail_bold` int(11) NOT NULL DEFAULT '0' COMMENT '0=normal, 1=bold',
  `quotationDetail_sortID` int(2) NOT NULL DEFAULT '0',
  `quotationDetail_no5` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quotationDetail_rowTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quotationDetail_taxRateID` int(10) NOT NULL DEFAULT '0',
  `quotationDetail_taxPercent` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quotationDetail_taxTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quotationDetail_rowGrandTotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quotationDetail_discountPercent` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quotationDetail_discountAmount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quotationDetail_rowTotalAfterDiscount` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`quotationDetail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=349 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbquotationdetail`
--

INSERT INTO `tbquotationdetail` (`quotationDetail_id`, `quotationDetail_quotationID`, `quotationDetail_no1`, `quotationDetail_no2`, `quotationDetail_no3`, `quotationDetail_no4`, `quotationDetail_bold`, `quotationDetail_sortID`, `quotationDetail_no5`, `quotationDetail_rowTotal`, `quotationDetail_taxRateID`, `quotationDetail_taxPercent`, `quotationDetail_taxTotal`, `quotationDetail_rowGrandTotal`, `quotationDetail_discountPercent`, `quotationDetail_discountAmount`, `quotationDetail_rowTotalAfterDiscount`) VALUES
(1, 1, '', 'DHLD PACKAGE DELIVERY CHARGES', '20.00', 'LOT', 0, 1, '50.00', '1000.00', 1, '0.00', '0.00', '1000.00', '0.00', '0.00', '1000.00'),
(2, 1, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(3, 1, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(4, 1, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(5, 1, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(11, 2, '1', 'DHLD PACKAGE DELIVERY CHARGES', '20.00', 'LOT', 0, 1, '50.00', '1000.00', 1, '0.00', '0.00', '1000.00', '0.00', '0.00', '1000.00'),
(12, 2, '2', 'CALENDAR FOR YEAR 2023 INCLUDING STICKERS MICKEY MOUSE', '0.00', 'PCS', 0, 2, '50.95', '50.95', 1, '0.00', '0.00', '50.95', '0.00', '0.00', '50.95'),
(13, 2, '3', 'REMOVE WINDSCREEN AND TINTING WORKS DONE FOR THE WHOLE CAR', '0.00', 'UNITS', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(14, 2, '4', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '0.00', 'LOT', 0, 4, '3700.00', '3700.00', 1, '0.00', '0.00', '3700.00', '0.00', '0.00', '3700.00'),
(15, 2, '5', 'Jetting Works and Clear blockages with rodder machine', '0.00', 'unit', 0, 5, '6.00', '6.00', 1, '0.00', '0.00', '6.00', '0.00', '0.00', '6.00'),
(16, 2, '6', 'MAZDA X5 TYRE CHANGE 175/90PSI JAPAN MADE', '0.00', 'PCS', 0, 6, '130.50', '130.50', 1, '0.00', '0.00', '130.50', '0.00', '0.00', '130.50'),
(17, 2, '7', 'MILO TIN BIG ( MADE IN HOLLAND)', '0.00', 'TIN', 0, 7, '66.00', '66.00', 1, '0.00', '0.00', '66.00', '0.00', '0.00', '66.00'),
(33, 3, '', '', '0.00', '', 0, 1, '5088.05', '5088.05', 1, '0.00', '0.00', '5088.05', '0.00', '0.00', '5088.05'),
(34, 3, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(35, 3, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(36, 3, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(37, 3, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(53, 4, '', 'BUTTER CHICKEN', '0.00', 'pcs', 0, 1, '67.55', '67.55', 1, '0.00', '0.00', '67.55', '0.00', '0.00', '67.55'),
(54, 4, '', 'PREPARE HOUSE TENANCY AGREEMENT FOR CUSTOMER FOR THE YEAR 2023 AND 2024', '0.00', 'LOT', 0, 2, '900.00', '900.00', 1, '0.00', '0.00', '900.00', '0.00', '0.00', '900.00'),
(55, 4, '', 'FRANCE PERFUME ( LAVENDAR SMELL)', '0.00', '', 0, 3, '98.00', '98.00', 1, '0.00', '0.00', '98.00', '0.00', '0.00', '98.00'),
(56, 4, '', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', 'bundles', 0, 4, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(57, 4, '', 'GRAND TURISMO 2.4', '0.00', 'UNIT', 0, 5, '12000.00', '12000.00', 1, '0.00', '0.00', '12000.00', '0.00', '0.00', '12000.00'),
(76, 5, '', 'WORK SCOPE', '0.00', '', 1, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(77, 5, '1.', 'CAR CARBURATOR CHANGE', '0.00', '', 0, 2, '33.00', '33.00', 1, '0.00', '0.00', '29.70', '10.00', '3.30', '29.70'),
(78, 5, '2.', 'PREPARE HOUSE TENANCY AGREEMENT FOR CUSTOMER FOR THE YEAR 2023 AND 2024', '0.00', 'LOT', 0, 3, '900.00', '900.00', 1, '0.00', '0.00', '900.00', '0.00', '0.00', '900.00'),
(79, 5, '3.', 'REMOVE WINDSCREEN AND TINTING WORKS DONE FOR THE WHOLE CAR', '2.00', 'UNITS', 0, 4, '65.00', '130.00', 1, '0.00', '0.00', '130.00', '0.00', '0.00', '130.00'),
(80, 5, '4.', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '0.00', 'LOT', 0, 5, '3700.00', '3700.00', 1, '0.00', '0.00', '3700.00', '0.00', '0.00', '3700.00'),
(81, 5, '', 'TRANSPORT', '0.00', '', 1, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(82, 5, '1.', 'CALENDAR FOR YEAR 2023 INCLUDING STICKERS MICKEY MOUSE', '0.00', 'PCS', 0, 7, '50.95', '50.95', 4, '34.00', '17.32', '68.27', '0.00', '0.00', '50.95'),
(83, 5, '2.', 'MOTOROLLA HANDPHONE MODEL X-9', '1.00', 'unit', 0, 8, '5006.75', '5006.75', 6, '1.50', '75.10', '5081.85', '0.00', '0.00', '5006.75'),
(84, 5, '3.', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '0.00', 'LOT', 0, 9, '3700.00', '3700.00', 3, '10.00', '355.20', '3907.20', '4.00', '148.00', '3552.00'),
(176, 7, '', '', '0.00', '', 0, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(177, 7, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(178, 7, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(179, 7, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(180, 7, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(181, 7, '', '', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(182, 7, '', '', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(183, 7, '', '', '0.00', '', 0, 8, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(184, 7, '', '', '0.00', '', 0, 9, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(185, 7, '', '', '0.00', '', 0, 10, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(186, 7, '', '', '0.00', '', 0, 11, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(187, 7, '', '', '0.00', '', 0, 12, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(188, 7, '', '', '0.00', '', 0, 13, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(189, 7, '', '', '0.00', '', 0, 14, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(190, 7, '', '', '0.00', '', 0, 15, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(191, 7, '', '', '0.00', '', 0, 16, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(192, 7, '', '', '0.00', '', 0, 17, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(193, 7, '', '', '0.00', '', 0, 18, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(194, 7, '', '', '0.00', '', 0, 19, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(195, 7, '', '', '0.00', '', 0, 20, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(196, 7, '', '', '0.00', '', 0, 21, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(197, 7, '', '', '0.00', '', 0, 22, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(198, 7, '', '', '0.00', '', 0, 23, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(199, 7, '', '', '0.00', '', 0, 24, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(200, 7, '', '', '0.00', '', 0, 25, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(201, 7, '', '', '0.00', '', 0, 26, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(202, 7, '', '', '0.00', '', 0, 27, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(203, 7, '', '', '0.00', '', 0, 28, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(204, 7, '', '', '0.00', '', 0, 29, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(205, 7, '', '', '0.00', '', 0, 30, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(206, 7, '', '', '0.00', '', 0, 31, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(207, 7, '', '', '0.00', '', 0, 32, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(208, 7, '', '', '0.00', '', 0, 33, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(209, 7, '', '', '0.00', '', 0, 34, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(210, 7, '', '', '0.00', '', 0, 35, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(211, 7, '', '', '0.00', '', 0, 36, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(212, 7, '', '', '0.00', '', 0, 37, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(213, 7, '', '', '0.00', '', 0, 38, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(214, 7, '', '', '0.00', '', 0, 39, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(215, 7, '', '', '0.00', '', 0, 40, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(216, 7, '', '', '0.00', '', 0, 41, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(217, 7, '', '', '0.00', '', 0, 42, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(218, 7, '', '', '0.00', '', 0, 43, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(219, 7, '', '', '0.00', '', 0, 44, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(220, 7, '', '', '0.00', '', 0, 45, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(286, 6, '', 'WORK SCOPE', '0.00', '', 1, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(287, 6, '1.', 'CAR CARBURATOR CHANGE', '12.00', '', 0, 2, '33.00', '396.00', 4, '34.00', '121.18', '477.58', '10.00', '39.60', '356.40'),
(288, 6, '2.', 'PREPARE HOUSE TENANCY AGREEMENT FOR CUSTOMER FOR THE YEAR 2023 AND 2024', '0.00', 'LOT', 0, 3, '900.00', '900.00', 1, '0.00', '0.00', '900.00', '0.00', '0.00', '900.00'),
(289, 6, '3.', 'REMOVE WINDSCREEN AND TINTING WORKS DONE FOR THE WHOLE CAR', '2.00', 'UNITS', 0, 4, '65.00', '130.00', 1, '0.00', '0.00', '130.00', '0.00', '0.00', '130.00'),
(290, 6, '4.', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '0.00', 'LOT', 0, 5, '3700.00', '3700.00', 1, '0.00', '0.00', '3700.00', '0.00', '0.00', '3700.00'),
(291, 6, '', 'TRANSPORT', '0.00', '', 1, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(292, 6, '1.', 'CALENDAR FOR YEAR 2023 INCLUDING STICKERS MICKEY MOUSE', '0.00', 'PCS', 0, 7, '50.95', '50.95', 4, '34.00', '17.32', '68.27', '0.00', '0.00', '50.95'),
(293, 6, '2.', 'MOTOROLLA HANDPHONE MODEL X-9', '1.00', 'unit', 0, 8, '5006.75', '5006.75', 6, '1.50', '75.10', '5081.85', '0.00', '0.00', '5006.75'),
(294, 6, '3.', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '0.00', 'LOT', 0, 9, '3700.00', '3700.00', 3, '10.00', '355.20', '3907.20', '4.00', '148.00', '3552.00'),
(295, 6, '5.', 'TEAK WOOD IKEA TABLE 5 X 7 FEET', '0.00', 'PCS', 0, 10, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(296, 6, '', 'LABOUR', '0.00', '', 1, 11, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(297, 6, '1.', 'NOKIA CHARGER TYPE CARBON 4598BK', '2.00', 'UNIT', 0, 12, '59.00', '118.00', 1, '0.00', '0.00', '118.00', '0.00', '0.00', '118.00'),
(298, 6, '2.', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '6.00', 'LOT', 0, 13, '60.00', '360.00', 1, '0.00', '0.00', '360.00', '0.00', '0.00', '360.00'),
(299, 6, '', 'CALENDAR FOR YEAR 2023 INCLUDING STICKERS MICKEY MOUSE', '0.00', 'PCS', 1, 14, '50.95', '50.95', 1, '0.00', '0.00', '50.95', '0.00', '0.00', '50.95'),
(300, 6, '', '', '0.00', '', 0, 15, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(301, 6, '', '', '0.00', '', 0, 16, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(302, 6, '', '', '0.00', '', 0, 17, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(303, 6, '', '', '0.00', '', 0, 18, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(304, 6, '', '', '0.00', '', 0, 19, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(305, 6, '', '', '0.00', '', 0, 20, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(306, 6, '', '', '0.00', '', 0, 21, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(307, 6, '', '', '0.00', '', 0, 22, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(308, 6, '', '', '0.00', '', 0, 23, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(309, 6, '', '', '0.00', '', 0, 24, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(310, 6, '', '', '0.00', '', 0, 25, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(311, 6, '', '', '0.00', '', 0, 26, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(312, 6, '', '', '0.00', '', 0, 27, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(313, 6, '', '', '0.00', '', 0, 28, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(314, 6, '', '', '0.00', '', 0, 29, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(315, 6, '', '', '0.00', '', 0, 30, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(321, 8, '', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAINAGE.', '0.00', 'LOT', 0, 1, '3700.00', '3700.00', 1, '0.00', '0.00', '3700.00', '0.00', '0.00', '3700.00'),
(322, 8, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(323, 8, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(324, 8, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(325, 8, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(326, 8, '', '', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(327, 8, '', '', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(328, 8, '', '', '0.00', '', 0, 8, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(329, 8, '', '', '0.00', '', 0, 9, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(330, 8, '', '', '0.00', '', 0, 10, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(331, 8, '', '', '0.00', '', 0, 11, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(332, 8, '', '', '0.00', '', 0, 12, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(333, 8, '', '', '0.00', '', 0, 13, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(334, 9, '', 'BUTTER CHICKEN', '0.00', 'pcs', 0, 1, '67.55', '67.55', 1, '0.00', '0.00', '67.55', '0.00', '0.00', '67.55'),
(335, 9, '', 'PREPARE HOUSE TENANCY AGREEMENT FOR CUSTOMER FOR THE YEAR 2023 AND 2024', '0.00', 'LOT', 0, 2, '900.00', '900.00', 1, '0.00', '0.00', '900.00', '0.00', '0.00', '900.00'),
(336, 9, '', 'FRANCE PERFUME ( LAVENDAR SMELL)', '0.00', '', 0, 3, '98.00', '98.00', 1, '0.00', '0.00', '98.00', '0.00', '0.00', '98.00'),
(337, 9, '', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', 'bundles', 0, 4, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(338, 9, '', 'GRAND TURISMO 2.4', '0.00', 'UNIT', 0, 5, '12000.00', '12000.00', 1, '0.00', '0.00', '12000.00', '0.00', '0.00', '12000.00'),
(339, 10, '', '', '0.00', '', 0, 1, '666.00', '666.00', 1, '0.00', '0.00', '666.00', '0.00', '0.00', '666.00'),
(340, 10, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(341, 10, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(342, 10, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(343, 10, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(344, 11, '', '', '0.00', '', 0, 1, '3232.00', '3232.00', 1, '0.00', '0.00', '3232.00', '0.00', '0.00', '3232.00'),
(345, 11, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(346, 11, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(347, 11, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(348, 11, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbsecret`
--

DROP TABLE IF EXISTS `tbsecret`;
CREATE TABLE IF NOT EXISTS `tbsecret` (
  `secret_id` int(2) NOT NULL AUTO_INCREMENT,
  `secret_name` varchar(100) NOT NULL,
  `secret_login` varchar(10) NOT NULL,
  `secret_password` varchar(255) NOT NULL,
  `secret_status` int(1) NOT NULL COMMENT '1=boss, 2=clerk',
  PRIMARY KEY (`secret_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbsecret`
--

INSERT INTO `tbsecret` (`secret_id`, `secret_name`, `secret_login`, `secret_password`, `secret_status`) VALUES
(2, '', 'john', '$2y$10$7rVKW2jNJIx2RP58ggHmc.cfAMHiEcplaz/oDmu1.s7B2/MaE/0OO', 1),
(3, '', 'palani', '$2y$10$CSe7O.UTL0kII8RIHr72Y.ik7w8pRtO8CSrWDuRdbDVVWqDg0U/hG', 1),
(4, 'melati', 'admin', '$2y$10$nXLhXGp.fxeOPH1UT3n4meRdFfyYW/QqJEGDuBH3zweiseb.G5Al6', 1),
(5, '', 'melati', '$2y$10$XbiatjnoX5jhXRxNdOl5PO/3765QySuDkKHntVbczqE0E3ZK1jptm', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbtaxrate`
--

DROP TABLE IF EXISTS `tbtaxrate`;
CREATE TABLE IF NOT EXISTS `tbtaxrate` (
  `taxRate_id` int(11) NOT NULL AUTO_INCREMENT,
  `taxRate_code` varchar(10) NOT NULL,
  `taxRate_rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `taxRate_description` varchar(100) NOT NULL,
  `taxRate_default` int(1) NOT NULL DEFAULT '0' COMMENT '1= default, rest all follow code',
  PRIMARY KEY (`taxRate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbtaxrate`
--

INSERT INTO `tbtaxrate` (`taxRate_id`, `taxRate_code`, `taxRate_rate`, `taxRate_description`, `taxRate_default`) VALUES
(1, 'NRT', '0.00', 'NR = No Rate, default rate = 0, dont DELETE', 1),
(2, 'SST', '6.00', 'Standard Rate', 0),
(3, 'STX', '10.00', 'Sales Tax', 0),
(4, 'PRG', '34.00', 'Electronic Items', 0),
(5, 'SXF', '8.00', 'Services Tax', 0),
(6, 'PPP', '1.50', 'Agriculture Products', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbtest`
--

DROP TABLE IF EXISTS `tbtest`;
CREATE TABLE IF NOT EXISTS `tbtest` (
  `test_id` int(11) NOT NULL AUTO_INCREMENT,
  `test_name` varchar(100) NOT NULL,
  PRIMARY KEY (`test_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
