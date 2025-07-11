-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 11, 2023 at 02:01 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

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
  `account4_sort` int(1) NOT NULL DEFAULT '1' COMMENT '0=opening/closing balance, 1 = normal ledger accounts, 2=closing balance',
  PRIMARY KEY (`account4_id`),
  KEY `account4_documentType` (`account4_documentType`)
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbaccount4`
--

INSERT INTO `tbaccount4` (`account4_id`, `account4_account3ID`, `account4_date`, `account4_reference`, `account4_documentType`, `account4_documentTypeID`, `account4_description`, `account4_debit`, `account4_credit`, `account4_sort`) VALUES
(108, 5, '2023-01-01', 'AP', 'APO', 135, 'Opening Balance', '1000.00', '0.00', 0),
(109, 1, '2023-01-01', 'AP', 'APO', 136, 'Opening Balance', '2000.00', '0.00', 0),
(110, 7, '2023-01-01', 'AP', 'APO', 137, 'Opening Balance', '3000.00', '0.00', 0),
(111, 8, '2023-01-01', 'AP', 'APO', 138, 'Opening Balance', '4000.00', '0.00', 0),
(112, 9, '2023-01-01', 'AP', 'APO', 139, 'Opening Balance', '5000.00', '0.00', 0),
(113, 2, '2023-01-01', 'AP', 'APO', 140, 'Opening Balance', '12000.00', '0.00', 0),
(114, 3, '2023-01-01', 'AP', 'APO', 141, 'Opening Balance', '5000.00', '0.00', 0),
(115, 6, '2023-01-01', 'AP', 'APO', 142, 'Opening Balance', '0.00', '15000.00', 0),
(116, 10, '2023-01-01', 'AP', 'APO', 143, 'Opening Balance', '0.00', '5000.00', 0),
(117, 19, '2023-01-01', 'AP', 'APO', 144, 'Opening Balance', '0.00', '7000.00', 0),
(118, 20, '2023-01-01', 'AP', 'APO', 145, 'Opening Balance', '0.00', '5000.00', 0),
(119, 2, '2023-07-08', 'INV/2023/001', 'INV', 1, 'CLEAN SEWERS SERVICES SDN BHD', '1000.00', '0.00', 1),
(120, 4, '2023-07-08', 'INV/2023/001', 'INV', 1, 'CLEAN SEWERS SERVICES SDN BHD', '0.00', '1000.00', 1),
(121, 2, '2023-07-08', 'INV/2023/002', 'INV', 2, 'CLEAN SEWERS SERVICES SDN BHD', '1222.80', '0.00', 1),
(122, 4, '2023-07-08', 'INV/2023/002', 'INV', 2, 'CLEAN SEWERS SERVICES SDN BHD', '0.00', '1222.80', 1),
(123, 2, '2023-07-08', 'RPT/2023/001', 'PAY', 13, 'CLEAN SEWERS SERVICES SDN BHD', '0.00', '1000.00', 1),
(124, 1, '2023-07-08', 'RPT/2023/001', 'PAY', 13, 'CLEAN SEWERS SERVICES SDN BHD', '1000.00', '0.00', 1),
(125, 6, '2023-07-10', 'PB001', 'PB', 1, 'TNB SDN BHD', '0.00', '45.00', 1),
(126, 13, '2023-07-10', 'PB001', 'PB', 1, 'TNB SDN BHD', '45.00', '0.00', 1),
(127, 2, '2023-07-10', 'INV/2023/003', 'INV', 3, '', '7000.00', '0.00', 1),
(128, 4, '2023-07-10', 'INV/2023/003', 'INV', 3, '', '0.00', '7000.00', 1),
(129, 2, '2023-07-10', 'CN/2023/001', 'CN', 1, 'F & N MALAYSIA BERHAD', '0.00', '500.00', 1),
(130, 4, '2023-07-10', 'CN/2023/001', 'CN', 1, 'F & N MALAYSIA BERHAD', '500.00', '0.00', 1);

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
) ENGINE=MyISAM AUTO_INCREMENT=146 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbaccountingperioddetail`
--

INSERT INTO `tbaccountingperioddetail` (`accountingPeriodDetail_id`, `accountingPeriodDetail_accountingPeriodID`, `accountingPeriodDetail_openDebitBalance`, `accountingPeriodDetail_closeDebitBalance`, `accountingPeriodDetail_openCreditBalance`, `accountingPeriodDetail_closeCreditBalance`, `accountingPeriodDetail_debitAmount`, `accountingPeriodDetail_creditAmount`, `accountingPeriodDetail_dateCreated`, `accountingPeriodDetail_generated`, `accountingPeriodDetail_account3ID`) VALUES
(145, 8, '0.00', '0.00', '5000.00', '0.00', '0.00', '0.00', '2023-01-01', 'm', 20),
(144, 8, '0.00', '0.00', '7000.00', '0.00', '0.00', '0.00', '2023-01-01', 'm', 19),
(143, 8, '0.00', '0.00', '5000.00', '0.00', '0.00', '0.00', '2023-01-01', 'm', 10),
(142, 8, '0.00', '0.00', '15000.00', '0.00', '0.00', '0.00', '2023-01-01', 'm', 6),
(141, 8, '5000.00', '0.00', '0.00', '0.00', '0.00', '0.00', '2023-01-01', 'm', 3),
(140, 8, '12000.00', '0.00', '0.00', '0.00', '0.00', '0.00', '2023-01-01', 'm', 2),
(139, 8, '5000.00', '0.00', '0.00', '0.00', '0.00', '0.00', '2023-01-01', 'm', 9),
(138, 8, '4000.00', '0.00', '0.00', '0.00', '0.00', '0.00', '2023-01-01', 'm', 8),
(137, 8, '3000.00', '0.00', '0.00', '0.00', '0.00', '0.00', '2023-01-01', 'm', 7),
(136, 8, '2000.00', '0.00', '0.00', '0.00', '0.00', '0.00', '2023-01-01', 'm', 1),
(135, 8, '1000.00', '0.00', '0.00', '0.00', '0.00', '0.00', '2023-01-01', 'm', 5);

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
(1, 'HYBRID TECHNOLOGIES SOLUTIONS', '002184186-A', 'NO 4 JALAN 2/3, TAMAN BAHAGIA, PETALING JAYA', '47300,  SELANGOR D.E', '+60 16 291 6107  ksnsewerageworks@gmail.com', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>Payment should be made to <strong>KSN SEWERAGE ENGINEERING SERVICE</strong> &quot; at Public Bank 3122 136 534&nbsp;</li></ol>', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', '<p><strong>Delivery Order Terms</strong></p><p>a.) All necessary documentation permit to enter the jobsite shall be arranged by the Hirer.<br />b.) All lifting Gears to be provided by the Hirer.<br />c.) Sunday &amp; Public Holiday considered as overtime and minimum 8hrs.</p>', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li></ul>', 'logo5981.png', 15);

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
) ENGINE=InnoDB AUTO_INCREMENT=231 DEFAULT CHARSET=latin1;

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
(18, 'F & N MALAYSIA BERHAD', 'NO 45 JALAN KLANG, PORT KLANG 43009 SELANGOR D.E', '05-78765 0098', 1, 'fn_malaysia@gmail.com', 'ENCIK KAMARUDDIN', 'NO 333 LOT 45 PANDAMARAN WAREHOUSE, PORT KLANG'),
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
(88, 'KEN HUAT HARDWARE SDN BHD', 'NO 4 JALAN SS 2/4 TAMAN BAHAGIA, PETALING JAYA, SELANGOR', '03-8976 5434', 2, 'ken_huat89@gmail.com', 'MR HUAT', ''),
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
(132, 'INDAH WATER KONSORTIUM  BERHAD', 'LOT 73 JALAN DAMANSARA, KL', '03 4560 2003', 2, 'care@iwk.com.my', 'MR ALI KAMARUDDIN', 'LOT 73 JALAN DAMANSARA, KL'),
(139, 'PRINTING ALLEN SDN BHD', '', '', 1, '', '', ''),
(142, 'RESTORAN SPICE GARDEN', '', '', 1, '', '', ''),
(143, 'GREAT EASTERN SDN BHD', 'WISMA GREAT ESTERN, AMPANG', '03 785 9099', 1, '', 'MR TEE', ''),
(144, 'WESTERN DIGITAL (M) SDN BHD', 'KELANA JAYA, FREE TRADE ZONE', '03 7650 0091', 1, '', 'MR YOGI', ''),
(145, 'MOTOROLLA BERHAD', '', '', 1, '', 'MR PREM ANAN', ''),
(146, 'SEKOLAH MENENGAH KEBANGSAAN PEREMPUAN SRI AMAN', '', '', 1, '', 'CIKGU RAMESH', ''),
(147, 'AA PHARMACY SDN BHD', 'KELANA JAYA', '012 7654 900', 1, '', '', ''),
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
(174, 'PERBADANAN PENGURUSAN PANGSAPURI DESA PALMA', 'Block C, Ground Floor,\nDesa Palma Apartment\n71800 Nilai, Negeri Sembilan,\nAttention: Ms. Kithana', '', 1, '', 'MANAGEMENT OFFICE', ''),
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
(222, 'Arvin Samy', '', '', 2, '', '', ''),
(223, 'Muthu Samy', '', '', 2, '', '', ''),
(224, 'DATO RAVI', '', '', 1, '', '', ''),
(225, 'GREENHILL RESOURCES SDN BHD', 'No 2, Jalan Setia Indah X U13/X\nSetia Alam, 40170 Shah Alam\nSelangor', '', 1, '', '', ''),
(226, 'HP COMPUTER  COMPANY', 'LOT 3232 JALAN PUDU, KUALA LUMPUR', '03 4560 8700', 1, 'hp_computer@gmail.com', 'MR ALEX TAN', ''),
(227, 'AJK 6 ( PORSCHE PANAMERA )', '', '', 1, '', 'DR CHOW', ''),
(228, 'PELITA RESTORAN', 'KLCC TOWER', '03-9087 9908', 1, '', 'MR SAID ISKANDAR', ''),
(229, 'SEKOLAH (M) SEAPORT', 'KELANA JAYA', '', 1, '', 'MS MALANI', ''),
(230, 'PEJABAT TANAH DAN GALIAN NEGERI SELANGOR', '', '', 1, '', '', '');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbcustomeraccount`
--

INSERT INTO `tbcustomeraccount` (`customerAccount_id`, `customerAccount_customerID`, `customerAccount_date`, `customerAccount_reference`, `customerAccount_documentType`, `customerAccount_documentTypeID`, `customerAccount_description`, `customerAccount_debit`, `customerAccount_credit`) VALUES
(1, 94, '2023-07-08', 'INV/2023/001', 'INV', 1, '', '1000.00', '0.00'),
(2, 94, '2023-07-08', 'INV/2023/002', 'INV', 2, '', '1222.80', '0.00'),
(3, 94, '2023-07-08', 'RPT/2023/001', 'PAY', 13, 'PAYMENT', '0.00', '1000.00'),
(4, 208, '2023-07-10', 'PB001', 'PB', 1, 'Payment Bill', '0.00', '45.00'),
(5, 18, '2023-07-10', 'INV/2023/003', 'INV', 3, 'INVOICE', '7000.00', '0.00'),
(6, 18, '2023-07-10', 'CN/2023/001', 'CN', 1, 'CREDIT NOTE', '0.00', '500.00');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbdeliveryorder`
--

INSERT INTO `tbdeliveryorder` (`deliveryOrder_id`, `deliveryOrder_no`, `deliveryOrder_date`, `deliveryOrder_customerID`, `deliveryOrder_title`, `deliveryOrder_from`, `deliveryOrder_terms`, `deliveryOrder_attention`, `deliveryOrder_email`, `deliveryOrder_subTotal`, `deliveryOrder_taxTotal`, `deliveryOrder_grandTotal`, `deliveryOrder_discountTotal`, `deliveryOrder_totalAfterDiscount`, `deliveryOrder_roundAmount`, `deliveryOrder_grandTotalRound`, `deliveryOrder_roundStatus`, `deliveryOrder_content`, `deliveryOrder_quotationNo`, `deliveryOrder_quotationID`, `deliveryOrder_invoiceNo`, `deliveryOrder_invoiceID`) VALUES
(1, 'DO/2023/001', '2023-07-08', 94, '', '', '<p><strong>Delivery Order Terms</strong></p><p>a.) All necessary documentation permit to enter the jobsite shall be arranged by the Hirer.<br />b.) All lifting Gears to be provided by the Hirer.<br />c.) Sunday &amp; Public Holiday considered as overtime and minimum 8hrs.</p>', 'MR RAMESH / SHOBA', 'admin@clean_sewers.com', '1222.80', '0.00', '1222.80', '0.00', '1222.80', '0.00', '1222.80', 0, '', '', 0, 'INV/2023/002', 2);

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbdeliveryorderdetail`
--

INSERT INTO `tbdeliveryorderdetail` (`deliveryOrderDetail_id`, `deliveryOrderDetail_deliveryOrderID`, `deliveryOrderDetail_no1`, `deliveryOrderDetail_no2`, `deliveryOrderDetail_no3`, `deliveryOrderDetail_no4`, `deliveryOrderDetail_bold`, `deliveryOrderDetail_sortID`, `deliveryOrderDetail_no5`, `deliveryOrderDetail_rowTotal`, `deliveryOrderDetail_taxRateID`, `deliveryOrderDetail_taxPercent`, `deliveryOrderDetail_taxTotal`, `deliveryOrderDetail_rowGrandTotal`, `deliveryOrderDetail_discountPercent`, `deliveryOrderDetail_discountAmount`, `deliveryOrderDetail_rowTotalAfterDiscount`) VALUES
(1, 1, '', 'CALENDAR FOR YEAR 2023 INCLUDING STICKERS MICKEY MOUSE', '24.00', 'PCS', 0, 1, '50.95', '1222.80', 1, '0.00', '0.00', '1222.80', '0.00', '0.00', '1222.80'),
(2, 1, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(3, 1, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(4, 1, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(5, 1, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbinvoice`
--

INSERT INTO `tbinvoice` (`invoice_id`, `invoice_no`, `invoice_date`, `invoice_customerID`, `invoice_title`, `invoice_from`, `invoice_terms`, `invoice_attention`, `invoice_email`, `invoice_subTotal`, `invoice_taxTotal`, `invoice_grandTotal`, `invoice_discountTotal`, `invoice_totalAfterDiscount`, `invoice_roundAmount`, `invoice_grandTotalRound`, `invoice_roundStatus`, `invoice_content`, `invoice_quotationNo`, `invoice_quotationID`, `invoice_deliveryOrderNo`, `invoice_deliveryOrderID`, `invoice_dueDate`, `invoice_dueDateNo`, `invoice_creditNote`, `invoice_debitNote`, `invoice_paid`, `invoice_status`) VALUES
(1, 'INV/2023/001', '2023-07-08', 94, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li></ul>', 'MR RAMESH / SHOBA', 'admin@clean_sewers.com', '1000.00', '0.00', '1000.00', '0.00', '1000.00', '0.00', '1000.00', 0, '', 'QO/2023/001', 1, '', 0, '2023-07-23', 15, '0.00', '0.00', '500.00', 'a'),
(2, 'INV/2023/002', '2023-07-08', 94, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li></ul>', 'MR RAMESH / SHOBA', '', '1222.80', '0.00', '1222.80', '0.00', '1222.80', '0.00', '1222.80', 0, '', '', 0, 'DO/2023/001', 1, '2023-07-23', 15, '0.00', '0.00', '500.00', 'a'),
(3, 'INV/2023/003', '2023-07-10', 18, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>Payment should be made to ( <strong>Maybank </strong>) <strong>AJ HYBRID EURO TECH</strong> <strong>512491169957</strong></li></ul>', 'ENCIK KAMARUDDIN', 'fn_malaysia@gmail.com', '7000.00', '0.00', '7000.00', '0.00', '7000.00', '0.00', '7000.00', 0, '', '', 0, '', 0, '2023-07-25', 15, '500.00', '0.00', '0.00', 'a');

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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

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
(20, 3, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00');

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbpayment`
--

INSERT INTO `tbpayment` (`payment_id`, `payment_no`, `payment_date`, `payment_paymentMethodID`, `payment_chequeInfo`, `payment_amount`, `payment_userID`, `payment_remark`, `payment_status`, `payment_cancelDate`, `payment_cancelReason`, `payment_cancelUserID`, `payment_customerID`) VALUES
(13, 'RPT/2023/001', '2023-07-08', 1, '', '1000.00', 4, '', 1, NULL, '', 0, 94);

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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbpaymentdetail`
--

INSERT INTO `tbpaymentdetail` (`paymentDetail_id`, `paymentDetail_paymentID`, `paymentDetail_invoiceID`, `paymentDetail_amount`) VALUES
(27, 13, 1, '500.00'),
(28, 13, 2, '500.00');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=latin1;

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
(48, '', 'TO USE TOOLS AND MANUALLY ENTER THE  DRAIN TO REMOVE ALL SAND, STONES, DEBRIS ETC FROM THE SIDES AND BOTTOM OF DRAIN.', '', 's', '3400.00', '3700.00', '0.00', 'LOT'),
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
(98, '', 'APPLE WATCH SMART', '', 'p', '450.00', '665.00', '0.00', 'PCS');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbpurchasebill`
--

INSERT INTO `tbpurchasebill` (`purchaseBill_id`, `purchaseBill_no`, `purchaseBill_date`, `purchaseBill_customerID`, `purchaseBill_title`, `purchaseBill_from`, `purchaseBill_terms`, `purchaseBill_attention`, `purchaseBill_email`, `purchaseBill_subTotal`, `purchaseBill_taxTotal`, `purchaseBill_grandTotal`, `purchaseBill_discountTotal`, `purchaseBill_totalAfterDiscount`, `purchaseBill_roundAmount`, `purchaseBill_grandTotalRound`, `purchaseBill_roundStatus`, `purchaseBill_content`, `purchaseBill_account3ID`, `purchaseBill_customerInvoiceNo`, `purchaseBill_purchaseOrderID`, `purchaseBill_purchaseOrderNo`, `purchaseBill_paid`, `purchaseBill_status`) VALUES
(1, 'PB001', '2023-07-10', 208, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', '', '', '45.00', '0.00', '45.00', '0.00', '45.00', '0.00', '45.00', 0, '', 13, '', 0, '', '0.00', 'a');

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbpurchasebilldetail`
--

INSERT INTO `tbpurchasebilldetail` (`purchaseBillDetail_id`, `purchaseBillDetail_purchaseBillID`, `purchaseBillDetail_no1`, `purchaseBillDetail_no2`, `purchaseBillDetail_no3`, `purchaseBillDetail_no4`, `purchaseBillDetail_bold`, `purchaseBillDetail_sortID`, `purchaseBillDetail_no5`, `purchaseBillDetail_rowTotal`, `purchaseBillDetail_taxRateID`, `purchaseBillDetail_taxPercent`, `purchaseBillDetail_taxTotal`, `purchaseBillDetail_rowGrandTotal`, `purchaseBillDetail_discountPercent`, `purchaseBillDetail_discountAmount`, `purchaseBillDetail_rowTotalAfterDiscount`) VALUES
(1, 1, '', '', '0.00', '', 0, 1, '45.00', '45.00', 1, '0.00', '0.00', '45.00', '0.00', '0.00', '45.00'),
(2, 1, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(3, 1, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(4, 1, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(5, 1, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbquotation`
--

INSERT INTO `tbquotation` (`quotation_id`, `quotation_no`, `quotation_date`, `quotation_customerID`, `quotation_title`, `quotation_from`, `quotation_terms`, `quotation_attention`, `quotation_email`, `quotation_subTotal`, `quotation_taxTotal`, `quotation_grandTotal`, `quotation_discountTotal`, `quotation_totalAfterDiscount`, `quotation_roundAmount`, `quotation_grandTotalRound`, `quotation_roundStatus`, `quotation_content`, `quotation_invoiceNo`, `quotation_invoiceID`, `quotation_deliveryOrderNo`, `quotation_deliveryOrderID`) VALUES
(1, 'QO/2023/001', '2023-07-08', 94, '', '', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>Payment should be made to <strong>KSN SEWERAGE ENGINEERING SERVICE</strong> &quot; at Public Bank 3122 136 534&nbsp;</li></ol>', 'MR RAMESH / SHOBA', 'admin@clean_sewers.com', '1000.00', '0.00', '1000.00', '0.00', '1000.00', '0.00', '1000.00', 0, '', 'INV/2023/001', 1, '', 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbquotationdetail`
--

INSERT INTO `tbquotationdetail` (`quotationDetail_id`, `quotationDetail_quotationID`, `quotationDetail_no1`, `quotationDetail_no2`, `quotationDetail_no3`, `quotationDetail_no4`, `quotationDetail_bold`, `quotationDetail_sortID`, `quotationDetail_no5`, `quotationDetail_rowTotal`, `quotationDetail_taxRateID`, `quotationDetail_taxPercent`, `quotationDetail_taxTotal`, `quotationDetail_rowGrandTotal`, `quotationDetail_discountPercent`, `quotationDetail_discountAmount`, `quotationDetail_rowTotalAfterDiscount`) VALUES
(1, 1, '', 'DHLD PACKAGE DELIVERY CHARGES', '20.00', 'LOT', 0, 1, '50.00', '1000.00', 1, '0.00', '0.00', '1000.00', '0.00', '0.00', '1000.00'),
(2, 1, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(3, 1, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(4, 1, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(5, 1, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00');

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
