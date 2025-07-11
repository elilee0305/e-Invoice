-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 13, 2023 at 05:34 AM
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

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
(7, 'OPERATING EXPENSES', 5100, 5),
(8, 'NON-OPERATING EXPENSES', 5200, 5);

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

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
(11, 'ROUNDING ACCOUNT', 5190, 7, '', ''),
(12, 'PURCHASE ACCOUNT', 5001, 7, '', ''),
(13, 'ELECTRICITY', 5101, 7, 'UT', ''),
(14, 'WATER', 5102, 7, 'UT', '');

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
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbaccount4`
--

INSERT INTO `tbaccount4` (`account4_id`, `account4_account3ID`, `account4_date`, `account4_reference`, `account4_documentType`, `account4_documentTypeID`, `account4_description`, `account4_debit`, `account4_credit`, `account4_sort`) VALUES
(1, 6, '2023-03-01', 'PB/2023/001', 'PB', 1, 'AMERICAN TABACCO MALAYSIA BERHAD', '0.00', '3000.00', 1),
(2, 12, '2023-03-01', 'PB/2023/001', 'PB', 1, 'AMERICAN TABACCO MALAYSIA BERHAD', '3000.00', '0.00', 1),
(3, 6, '2023-03-01', 'PB/2023/002', 'PB', 2, 'ALAGAPAS CURRY POWDER (M) SDN BHD', '0.00', '2000.00', 1),
(4, 12, '2023-03-01', 'PB/2023/002', 'PB', 2, 'ALAGAPAS CURRY POWDER (M) SDN BHD', '2000.00', '0.00', 1),
(5, 6, '2023-03-01', 'PB/2023/003', 'PB', 3, 'AHSN DYNAMIC (M) SDN BHD', '0.00', '1000.00', 1),
(6, 12, '2023-03-01', 'PB/2023/003', 'PB', 3, 'AHSN DYNAMIC (M) SDN BHD', '1000.00', '0.00', 1),
(7, 6, '2023-03-01', 'PB/2023/001', 'PB', 4, 'AMERICAN TABACCO MALAYSIA BERHAD', '0.00', '3000.00', 1),
(8, 12, '2023-03-01', 'PB/2023/001', 'PB', 4, 'AMERICAN TABACCO MALAYSIA BERHAD', '3000.00', '0.00', 1),
(9, 6, '2023-03-01', 'PB/2023/004', 'PB', 5, 'CARSOME MALAYSIA SDN BHD', '0.00', '5000.00', 1),
(10, 12, '2023-03-01', 'PB/2023/004', 'PB', 5, 'CARSOME MALAYSIA SDN BHD', '5000.00', '0.00', 1),
(13, 6, '2023-03-01', 'RPT0002', 'PAYV', 2, 'AHSN DYNAMIC (M) SDN BHD', '1000.00', '0.00', 1),
(14, 1, '2023-03-01', 'RPT0002', 'PAYV', 2, 'AHSN DYNAMIC (M) SDN BHD', '0.00', '1000.00', 1),
(17, 2, '2023-03-01', 'IN/2023/100', 'INV', 70, 'IOI PROPERTIES (M) SDN BHD', '3075.35', '0.00', 1),
(18, 4, '2023-03-01', 'IN/2023/100', 'INV', 70, 'IOI PROPERTIES (M) SDN BHD', '0.00', '3075.35', 1),
(19, 6, '2023-03-01', 'BALANCE C/F', 'CA', 193, 'PREMIO STATIONARY SDN BHD', '0.00', '2500.00', 1),
(20, 6, '2023-03-01', 'PB/2023/005', 'PB', 6, 'PREMIO STATIONARY SDN BHD', '0.00', '150.00', 1),
(21, 12, '2023-03-01', 'PB/2023/005', 'PB', 6, 'PREMIO STATIONARY SDN BHD', '150.00', '0.00', 1),
(24, 6, '2023-03-01', 'PB/2023/006', 'PB', 7, 'BADAN PENGURUSAN BERSAMA LAKEVILLE RESIDENCE', '0.00', '1820.98', 1),
(25, 12, '2023-03-01', 'PB/2023/006', 'PB', 7, 'BADAN PENGURUSAN BERSAMA LAKEVILLE RESIDENCE', '1820.98', '0.00', 1),
(26, 2, '2023-03-03', 'RPT/2023/069', 'PAY', 67, 'IOI PROPERTIES (M) SDN BHD', '0.00', '3075.35', 1),
(27, 1, '2023-03-03', 'RPT/2023/069', 'PAY', 67, 'IOI PROPERTIES (M) SDN BHD', '3075.35', '0.00', 1),
(28, 6, '2023-03-07', 'PB/2023/007', 'PB', 8, 'YONG SOON FATT SDN BHD', '0.00', '600.00', 1),
(29, 12, '2023-03-07', 'PB/2023/007', 'PB', 8, 'YONG SOON FATT SDN BHD', '600.00', '0.00', 1),
(30, 2, '2023-03-12', 'IN/2023/101', 'INV', 71, 'AHSN DYNAMIC (M) SDN BHD', '25095.22', '0.00', 1),
(31, 4, '2023-03-12', 'IN/2023/101', 'INV', 71, 'AHSN DYNAMIC (M) SDN BHD', '0.00', '25095.22', 1),
(32, 2, '2023-03-12', 'IN/2023/102', 'INV', 72, 'AHSN DYNAMIC (M) SDN BHD', '796.15', '0.00', 1),
(33, 4, '2023-03-12', 'IN/2023/102', 'INV', 72, 'AHSN DYNAMIC (M) SDN BHD', '0.00', '601.97', 1),
(34, 10, '2023-03-12', 'IN/2023/102', 'INV', 72, 'AHSN DYNAMIC (M) SDN BHD', '194.17', '0.00', 1),
(35, 11, '2023-03-12', 'IN/2023/102', 'INV', 72, 'AHSN DYNAMIC (M) SDN BHD', '0.00', '0.01', 1),
(36, 2, '2023-03-12', 'IN/2023/103', 'INV', 73, 'ALAGAPAS CURRY POWDER (M) SDN BHD', '796.15', '0.00', 1),
(37, 4, '2023-03-12', 'IN/2023/103', 'INV', 73, 'ALAGAPAS CURRY POWDER (M) SDN BHD', '0.00', '601.97', 1),
(38, 10, '2023-03-12', 'IN/2023/103', 'INV', 73, 'ALAGAPAS CURRY POWDER (M) SDN BHD', '194.17', '0.00', 1),
(39, 11, '2023-03-12', 'IN/2023/103', 'INV', 73, 'ALAGAPAS CURRY POWDER (M) SDN BHD', '0.00', '0.01', 1),
(40, 2, '2023-03-12', 'IN/2023/104', 'INV', 74, 'AHSN DYNAMIC (M) SDN BHD', '806.65', '0.00', 1),
(41, 4, '2023-03-12', 'IN/2023/104', 'INV', 74, 'AHSN DYNAMIC (M) SDN BHD', '0.00', '612.46', 1),
(44, 10, '2023-03-12', 'IN/2023/104', 'INV', 74, 'AHSN DYNAMIC (M) SDN BHD', '194.17', '0.00', 1),
(45, 11, '2023-03-12', 'IN/2023/104', 'INV', 74, 'AHSN DYNAMIC (M) SDN BHD', '0.00', '0.02', 1),
(46, 2, '2023-03-12', 'IN/2023/105', 'INV', 75, 'ALAGAPAS CURRY POWDER (M) SDN BHD', '0.00', '0.00', 1),
(47, 4, '2023-03-12', 'IN/2023/105', 'INV', 75, 'ALAGAPAS CURRY POWDER (M) SDN BHD', '0.00', '0.00', 1),
(48, 2, '2023-03-12', 'CN/2023/024', 'CN', 7, 'AHSN DYNAMIC (M) SDN BHD', '0.00', '6407.90', 1),
(49, 4, '2023-03-12', 'CN/2023/024', 'CN', 7, 'AHSN DYNAMIC (M) SDN BHD', '6213.72', '0.00', 1),
(54, 10, '2023-03-12', 'CN/2023/024', 'CN', 7, 'AHSN DYNAMIC (M) SDN BHD', '0.00', '194.17', 1),
(55, 11, '2023-03-12', 'CN/2023/024', 'CN', 7, 'AHSN DYNAMIC (M) SDN BHD', '0.01', '0.00', 1);

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbaccountingperioddetail`
--

INSERT INTO `tbaccountingperioddetail` (`accountingPeriodDetail_id`, `accountingPeriodDetail_accountingPeriodID`, `accountingPeriodDetail_openDebitBalance`, `accountingPeriodDetail_closeDebitBalance`, `accountingPeriodDetail_openCreditBalance`, `accountingPeriodDetail_closeCreditBalance`, `accountingPeriodDetail_debitAmount`, `accountingPeriodDetail_creditAmount`, `accountingPeriodDetail_dateCreated`, `accountingPeriodDetail_generated`, `accountingPeriodDetail_account3ID`) VALUES
(1, 8, '1000.00', '0.00', '0.00', '0.00', '0.00', '0.00', '2023-01-01', 'm', 2);

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
(1, 'KSN SEWERAGE ENGINEERING SERVICE', '001395230- A', 'NO 4 JALAN SS 2/4, TAMAN BAHAGIA', '47300 PETALING JAYA', 'TEL 016 2916107', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>All cheques must be crossed &quot;A/C PAYEE ONLY&quot; and made payable to &quot;<strong>KSN SEWERAGE ENGINEERING SERVICES</strong> &quot; at Public Bank 3122 136 534 &nbsp;<br />&nbsp;</li></ol>', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', '<p><strong>Delivery Order Terms</strong></p><p>a.) All necessary documentation permit to enter the jobsite shall be arranged by the Hirer.<br />b.) All lifting Gears to be provided by the Hirer.<br />c.) Sunday &amp; Public Holiday considered as overtime and minimum 8hrs.</p>', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'logo3969.jpg', 15);

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbcreditnote`
--

INSERT INTO `tbcreditnote` (`creditNote_id`, `creditNote_no`, `creditNote_date`, `creditNote_invoiceID`, `creditNote_title`, `creditNote_from`, `creditNote_terms`, `creditNote_attention`, `creditNote_email`, `creditNote_subTotal`, `creditNote_taxTotal`, `creditNote_grandTotal`, `creditNote_discountTotal`, `creditNote_totalAfterDiscount`, `creditNote_roundAmount`, `creditNote_grandTotalRound`, `creditNote_roundStatus`, `creditNote_content`) VALUES
(1, 'CN/2023/020', '2023-01-24', 13, '', '', '', 'Mr Ramachandrean', 'caresome_90@gmail.com', '1511.50', '104.69', '1589.19', '27.00', '1484.50', '0.01', '1589.20', 1, ''),
(2, 'CN/2023/021', '2023-01-30', 33, '', '', '', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '9220.00', '549.98', '9617.58', '152.40', '9067.60', '0.02', '9617.60', 1, ''),
(5, 'CN/2023/022', '2023-02-01', 51, '', '', '', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '60.00', '0.00', '60.00', '0.00', '60.00', '0.00', '60.00', 0, ''),
(6, 'CN/2023/023', '2023-02-06', 50, '', '', '', '', '', '1627.45', '48.28', '1662.41', '13.32', '1614.13', '-0.01', '1662.40', 1, ''),
(7, 'CN/2023/024', '2023-03-12', 72, '', '', '', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '6258.22', '194.17', '6407.89', '44.50', '6213.72', '0.01', '6407.90', 1, '');

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
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbcreditnotedetail`
--

INSERT INTO `tbcreditnotedetail` (`creditNoteDetail_id`, `creditNoteDetail_creditNoteID`, `creditNoteDetail_no1`, `creditNoteDetail_no2`, `creditNoteDetail_no3`, `creditNoteDetail_no4`, `creditNoteDetail_bold`, `creditNoteDetail_sortID`, `creditNoteDetail_no5`, `creditNoteDetail_rowTotal`, `creditNoteDetail_taxRateID`, `creditNoteDetail_taxPercent`, `creditNoteDetail_taxTotal`, `creditNoteDetail_rowGrandTotal`, `creditNoteDetail_discountPercent`, `creditNoteDetail_discountAmount`, `creditNoteDetail_rowTotalAfterDiscount`) VALUES
(1, 1, '1', 'AUTOMATIC TRANSMISSION FLUID', '0.00', 'unit', 1, 1, '102.50', '102.50', 4, '34.00', '34.85', '137.35', '0.00', '0.00', '102.50'),
(2, 1, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '1.00', 'pcs', 0, 2, '450.00', '450.00', 1, '0.00', '0.00', '450.00', '0.00', '0.00', '450.00'),
(3, 1, '1', 'NOKIA CHARGER TYPE CARBON 4598BK', '0.00', 'UNIT', 1, 3, '59.00', '59.00', 1, '0.00', '0.00', '59.00', '0.00', '0.00', '59.00'),
(4, 1, '', 'Screw made in taiwan 67 size', '1.00', '', 0, 4, '900.00', '900.00', 5, '8.00', '69.84', '942.84', '3.00', '27.00', '873.00'),
(5, 1, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(6, 2, '', 'DESLUDGING SERVICES FOR SLUDGE & OTHER RELATED WORKS', '0.00', '', 1, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(7, 2, '1.', 'TO USE 4.5m3 DESLDUDGING TANKER TO VACUUM AND REMOVE SLUDGE / WASTE WATER INCLUDING DISPOSAL. 20/10/2022', '3.00', 'TRIPS', 0, 2, '450.00', '1350.00', 4, '34.00', '459.00', '1809.00', '0.00', '0.00', '1350.00'),
(8, 2, '2.', 'TO USE 10.00m3 DESLDUDGING TANKER TO VACUUM AND REMOVE SLUDGE / WASTE WATER INCLUDING DISPOSAL  20/10/2022', '2.00', 'TRIPS', 0, 3, '750.00', '1500.00', 1, '0.00', '0.00', '1500.00', '0.00', '0.00', '1500.00'),
(9, 2, '3.', 'REWINDING AND SERVICING WASTE WATER PUMP 16/10/2022', '0.00', '', 0, 4, '3450.00', '3450.00', 1, '0.00', '0.00', '3450.00', '0.00', '0.00', '3450.00'),
(10, 2, '4.', 'ELECTRICAL WIRING WORKS FROM PUMP TO THE ELECTRICAL PANEL BOX.', '0.00', '', 0, 5, '120.00', '120.00', 4, '34.00', '39.98', '157.58', '2.00', '2.40', '117.60'),
(11, 2, '5.', 'TO USE HIGH PRESSURE JETTER TRUCK MACHINE TO CLEAN AND BREAK ALL BLOCKAGES WITHIN THE SEWERAGE PIPELINES.', '0.00', '', 0, 6, '1800.00', '1800.00', 1, '0.00', '0.00', '1800.00', '0.00', '0.00', '1800.00'),
(12, 2, '', 'LABOUR CHARGES', '0.00', '', 1, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(13, 2, '1.', 'TO USE DESLUDGING TANKER TO VACUUM AND REMOVE ALL SLUDGE / WASTE WATER TO ENABLE THE SUBMERSIBLE PUMP AND SENSOR TO BE INSTALLED.', '2.00', 'UNITS', 0, 8, '500.00', '1000.00', 2, '6.00', '51.00', '901.00', '15.00', '150.00', '850.00'),
(46, 5, '', '', '0.00', '', 0, 1, '60.00', '60.00', 1, '0.00', '0.00', '60.00', '0.00', '0.00', '60.00'),
(47, 5, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(48, 5, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(49, 5, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(50, 5, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(60, 6, '1', 'A4 Bahasa Malaysia Exam papers9', '4.00', 'pcs', 0, 1, '6.49', '25.96', 2, '6.00', '1.46', '25.86', '6.00', '1.56', '24.40'),
(61, 6, '2', 'Desludging Tanker 10 cubic metres (Cina Made)', '5.00', 'units', 0, 2, '99.00', '495.00', 1, '0.00', '0.00', '495.00', '0.00', '0.00', '495.00'),
(62, 6, '3', 'LABOUR TO REPLACE PARTS & SERVICE', '2.00', '', 0, 3, '56.00', '112.00', 1, '0.00', '0.00', '105.28', '6.00', '6.72', '105.28'),
(63, 6, '5', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '1.00', '', 0, 4, '450.00', '450.00', 1, '0.00', '0.00', '450.00', '0.00', '0.00', '450.00'),
(64, 6, '6', 'TOP RADIATOR HOSE ORIGINAL', '1.00', '', 0, 5, '450.00', '450.00', 3, '10.00', '45.00', '495.00', '0.00', '0.00', '450.00'),
(65, 6, '7', 'Jetting Works and Clear blockages with rodder machine', '14.00', 'unit', 0, 6, '6.00', '84.00', 6, '1.50', '1.18', '80.14', '6.00', '5.04', '78.96'),
(66, 6, '', 'Electrical Cable Malaysia Made', '0.00', 'pc', 0, 7, '10.49', '10.49', 2, '6.00', '0.63', '11.12', '0.00', '0.00', '10.49'),
(83, 7, '1', 'Curry Puff Flour 1.8kg', '3.00', 'packet', 1, 1, '6.49', '19.47', 2, '6.00', '1.11', '19.61', '5.00', '0.97', '18.50'),
(84, 7, '2', 'LABOUR TO REPLACE PARTS & SERVICE', '3.00', 'pc', 0, 2, '56.00', '168.00', 4, '34.00', '54.26', '213.86', '5.00', '8.40', '159.60'),
(85, 7, '3', 'NOKIA CHARGER TYPE CARBON 4598BK', '3.00', 'UNIT', 0, 3, '59.00', '177.00', 4, '34.00', '55.97', '220.58', '7.00', '12.39', '164.61'),
(86, 7, '4', 'Teak Wood furniture sofa chair', '4.00', 'kg', 0, 4, '66.00', '264.00', 4, '34.00', '82.58', '325.46', '8.00', '21.12', '242.88'),
(87, 7, '5', 'Jetting Works and Clear blockages with rodder machine', '3.00', 'unit', 0, 5, '6.00', '18.00', 6, '1.50', '0.25', '16.63', '9.00', '1.62', '16.38'),
(88, 7, '', 'MOTOROLLA HANDPHONE MODEL X-9', '0.00', 'unit', 0, 6, '5006.75', '5006.75', 1, '0.00', '0.00', '5006.75', '0.00', '0.00', '5006.75'),
(89, 7, '', 'Desludging Tanker 10 cubic metres (Cina Made)', '0.00', 'units', 0, 7, '99.00', '99.00', 1, '0.00', '0.00', '99.00', '0.00', '0.00', '99.00'),
(90, 7, '', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 0, 8, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(91, 7, '', '', '0.00', '', 0, 9, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(92, 7, '', '', '0.00', '', 0, 10, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(93, 7, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '0.00', '', 0, 11, '450.00', '450.00', 1, '0.00', '0.00', '450.00', '0.00', '0.00', '450.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbcustomer`
--

DROP TABLE IF EXISTS `tbcustomer`;
CREATE TABLE IF NOT EXISTS `tbcustomer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) NOT NULL,
  `customer_address` varchar(250) NOT NULL,
  `customer_tel` varchar(30) NOT NULL,
  `customer_type` int(1) NOT NULL DEFAULT '1' COMMENT '1=customer, 2 = supplier 3=staff',
  `customer_email` varchar(100) NOT NULL,
  `customer_attention` varchar(50) NOT NULL,
  `customer_deliveryAddress` varchar(250) NOT NULL,
  PRIMARY KEY (`customer_id`),
  KEY `customer_name` (`customer_name`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbcustomer`
--

INSERT INTO `tbcustomer` (`customer_id`, `customer_name`, `customer_address`, `customer_tel`, `customer_type`, `customer_email`, `customer_attention`, `customer_deliveryAddress`) VALUES
(1, 'Suhumaran Duraisamy', 'No 34 Jalan Petaling Jaya\r\nJalan 45000 Kuala Lumpur', '012 654 9809', 1, 'suhu556@gmail.com', '', ''),
(2, 'Sham Sredar', 'No 23 Jalan Kelaing', '324243511', 3, 'ewfqrwe tn tqnwt@gmail.com', '', ''),
(3, 'AMERICAN TABACCO MALAYSIA BERHAD', '', '', 3, '', '', ''),
(4, 'Vinmura Trading Company', 'NO  9 jalan 9/345 Petaling Garden\r\nSubang Jaya', '03 3456 0098', 1, '', '', ''),
(5, 'Jurong Port Klang Sdn Bhd', 'Lot 67 Jalan Port Kalng 56/45 Taman Berkeley Selangor', '012 654 9809', 3, 'port_klang@hotmail.com', 'Ms Prema Nair', ''),
(6, 'VENICE VISION SDN BHD', 'NO 45 JALAN SS 6/90,\r\nKELANA JAYA\r\nPETALING JAYA, SELANGOR', '03 - 5600 9067', 1, 'lim_90@gmail.com', 'Ms Lim Ah Keong', ''),
(7, 'Restoran Saji Sdn Bhd', '', '', 1, '', '', ''),
(8, 'Ayurvedic Lestari Centre Sdn Bhd', 'No 34 Jalan USJ2/3, \r\nTaman Subang Jaya, \r\nSelangor D.E, \r\nMalaysia (South East Asia)', '03-6764 0987', 1, 'ayur_90@gmail.com', 'Hariharan', ''),
(9, 'PERCETAKAN CHEMY SDN BHD', '', '', 1, '', '', ''),
(10, 'Peter Pan', '', '', 1, '', '', ''),
(11, 'Jernih Sewerage Maintenance Sdn Bhd', 'No 45 Jalan SS 3/90 Taman Bahagia PJ', '03 7865 9098', 1, 'sara_98@hotmail.com', 'Mr Saravanan', ''),
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
(23, 'YONG SOON FATT SDN BHD', 'LOT 1504, BATU 8 1/2 JALAN KLANG LAMA PETALING JAYA, SELANGOR D.E', '', 1, '', '', ''),
(24, 'PERSATUAN TELUGU MALAYSIA (CAWANGAN KAJANG)', 'NO 56 JALAN SS 6/90, PETALING JAYA\r\nSELANGOR D.E', '03-6750 0098', 1, 'telug_assc@gmail.com', 'MR KUMAR RAO', ''),
(25, 'VIENDA RESOURCES', 'SHAH ALAM', '', 1, '', 'DATIN AIDA', ''),
(26, 'WXX 7985 ( VW POLO )', '', '', 1, '', 'DR CHOW', ''),
(27, 'SYARIKAT XYZ SDN BHD', 'LOT 1001-015 NO 80 JLN BARU\r\nSRI BUNGA KERTAS\r\n50490 KUALA LUMPUR', '', 1, '', 'Encik Joy', ''),
(28, 'WYM 8219 ( TOYOTA VELLFIRE  )', '', '', 1, '', 'DATO YM TONG', ''),
(29, 'WPN 1027 ( TOYOTA VIOS)', '', '', 1, '', 'MR CHRIS', ''),
(30, 'JAYA GROCER SDN BHD', 'NO 45, JALAM PJS 45/90,\r\nTAMAN SUBANG JAYA,\r\nSELANGOR D.E', '03-5670 98088', 1, 'jaya_grocer@hotmail.com', 'MR ALEX CHAN', ''),
(31, 'OK Radio Sdn Bhd', '', '', 1, '', '', ''),
(32, 'Ramesh Nair', 'No 34 Jalan SS5C/23 Taman Kelana Jaya, Selangor D.E', '', 2, '', '', ''),
(33, 'DAman Crimson Management Corporation', 'Crimson Apt, 2nd Floor (Club House), No 1,Jalan PJU 1A/41, Ara Jaya,47301 Petaling Jaya,\r\nSelangor D.E', '', 1, 'dcmc.crimson@gmail.com', 'Mr.Rajan', ''),
(34, 'ROYAL PORT DICKSON YACHT CLUB', 'BATU 4 1/2 , JALAN PANTAI, SI RUSA, 71050, \r\nNEGERI SEMBILAN DK', '', 1, 'gobalan2829@gmail.com', 'Mr Gobalan', ''),
(35, 'S & J BARCODE SDN BHD', 'NO 27, FIRST FLOOR, LORONG HELANG 2, DESA PERMAI INDAH, PENANG', '012 4181 890', 1, '', 'MR DERICK', ''),
(36, 'JMB TENDERFIELDS', 'NO 1 LINGKARAN ECO MAJESTIC\r\n43500 SEMENYIH SELANGOR', '', 1, '', '', ''),
(37, 'NESTLE (M) SDN BHD', 'NO 34 JALAN TANDANG, TAMAN SENTOSA, OLD TOWN, PETALING JAYA, SELANGOR D.E', '03-8986 0098', 1, 'kenny_nestle@nestlemalaysia.com', 'MR KENNY (MANAGER)', 'NO 34 JALAN TANDANG, TAMAN SENTOSA, OLD TOWN, PETALING JAYA, SELANGOR D.E'),
(38, 're', '', '', 1, '', '', ''),
(39, 'IMPIAN WATER CONSORTIUM BERHAD', '', '', 1, '', 'MR GANESON', ''),
(40, 'CITY SEWERAGE SDN BHD', '', '', 1, '', 'MR RAMESH (DATOK)', ''),
(41, 'TEST', '', '', 1, '', '', ''),
(42, 'TEST 2', '', '', 1, '', '', ''),
(43, 'TEST 5', '', '', 1, '', '', ''),
(44, 'VINMURA TRADING SDN BHD', '', '', 1, '', 'MR CHANDRAN', ''),
(45, 'TEST 6', '', '', 1, '', '', ''),
(46, 'TEST 10', '', '', 1, '', '', ''),
(47, 'TEST 11', '', '', 1, '', '', ''),
(48, 'Melati Abdul Hai', '', '', 1, '', '', ''),
(49, 'Priyadharshini Nair', '', '', 1, '', '', ''),
(50, 'IMPIAN WATER CONSORTIUM BERHAD', '', '', 1, '', '', ''),
(51, 'AHSN DYNAMIC (M) SDN BHD', 'No 45 Jalan Pinang, Taman Midah, 45600 Cheras, Malaysia', '03 56789009', 1, 'ahsn_90@gmail.com', 'Mr Balvinder Singh', 'No 45 Jalan Pinang, Taman Midah, 45600 Cheras, Malaysia'),
(52, 'MELEWAR STEEL (M) SDN BHD', '', '', 3, '', '', ''),
(53, 'CITY ENVIRONMENT SDN BHD', '', '', 1, '', '', ''),
(54, 'CASIO SDN BHD', 'Lot 34 Petaling garden 33400 Petaling Jaya', '03 5677 9098', 1, '', 'Ms Faridah', ''),
(55, 'PRUDENTIAL INSURANCE', '', '', 1, '', '', ''),
(56, 'PROTON BERHAD', '', '', 1, '', 'MR TEE CHONG', ''),
(57, 'IOI Properties Group Berhad', 'Level 25, IOI City Tower 2, Lebuh IRC, IOI Resort City, 62502 Putrajaya, Malaysia.', '+603-8947 6659', 1, 'shanice.wong@ioigroup.com', 'Shanice Wong  ( Contracts Executive )', ''),
(58, 'INDAH KOTA SDN BHD', '', '', 1, '', '', ''),
(59, 'RIANA GREEN JOINT MANAGEMENT BODY', 'No. 1, Jalan PJU 3/1C (Jalan Tropicana Utara)\r\n47410 Petaling Jaya', '03-78064409', 1, 'manager.rianagreen@gmail.com', 'Vegan - Building Manager', ''),
(60, 'MATSHUSHITA SDN BHD', '', '', 1, '', '', ''),
(61, 'AZAM BARU ENTERPRISE', 'NO 31 JALAN INDAH 3/8 \r\nPUCHONG INDAH \r\nPUCHONG 47150\r\nSELANGOR D.E', '', 1, 'jumaatengineering@gmail.com', '', ''),
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
(73, 'TESTING', '', '', 1, '', '', ''),
(74, 'ALAGAPAS CURRY POWDER (M) SDN BHD', '', '', 1, '', '', ''),
(75, 'CALTEX OILS SDN BHD', '', '', 1, '', 'MR RAYMOND', ''),
(76, 'BADAN PENGURUSAN BERSAMA LAKEVILLE RESIDENCE', 'NO 68 JALAN SIBU, TAMAN WAHYU 68100 BATU CAVES, KUALA LUMPUR', '', 1, '', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', ''),
(77, 'UKRAINE FLOOR MILL SDN BHD', '', '', 1, '', '', ''),
(78, 'PJ INDUSTRIAL PARK', 'JLN KEMAJUAN,SEKSYEN 13\r\nPETALING JAYA 460200 SELANGOR', '', 1, '', '', ''),
(79, 'PANASONIC MALAYSIA (M) SDN BHD', 'NO 45 LOT 6690 TAMAN SRI MUDA, SHAH ALAM', '03-8909 6755', 1, 'panasonic_malaysia@gmail.com', 'MR CHANDRAN', ''),
(80, 'KELAB SUKAN GOLD SELANGOR SDN BHD', '', '', 1, '', 'MR KAMARUDDING', ''),
(81, 'AVINOR SDN BHD', '', '', 1, '', '', ''),
(82, 'MATSHUSHITA (M) SDN BHD', '', '', 1, '', '', ''),
(83, 'DESA DAMANSARA MANAGEMENT CORPORATION', 'NO 99 JALAN SETIAKASIH, BUKIT DAMANSARA, 50490 KUALA LUMPUR', '03 2095 5099', 1, 'desa_90@gmail.com', 'Ms Fatimah Kassim', ''),
(84, 'HAZLAN SABTU GRAB ENTERPRIZE', '', '', 1, '', '', ''),
(85, 'NASIR AIRMAS SDN BHD', '', '', 1, '', '', ''),
(86, 'HAZLAN SABTU GRAB ENTERPRIZE', '', '', 1, '', 'reqdsdsd', ''),
(87, 'RAINE HORNE & ZAKI PROPERTY MANAGEMENT SDN BHD', 'NO 10 JALAN JALIL JAYA 2 JALIL LINK, BUKIT JALIL 57000 KUALA LUMPUR', '', 1, 'timothy@rainehome.com.my', 'MR TIMOTHY', ''),
(88, 'KEN HUAT HARDWARE SDN BHD', 'NO 4 JALAN SS 2/4 TAMAN BAHAGIA, PETALING JAYA, SELANGOR', '03-8976 5434', 2, 'ken_huat89@gmail.com', 'MR HUAT', ''),
(89, 'JAYA GROCER SDN BHD', '', '', 2, '', '', ''),
(90, 'VILLAGE GROCER SDN BHD', '', '', 2, '', '', ''),
(91, 'PETRONAS BERHAD', '', '', 2, '', '', ''),
(92, 'PREMIO STATIONARY SDN BHD', '', '', 2, '', '', ''),
(93, 'RIGHTONTRACK SDN BHD', 'E-12-1, BLOCK E, PLAZA GLOMAC, JALAN SS7/19, KELANA JAYA, 47300 PETALING JAYA, SELANGOR', '603-7805 2999', 1, 'info@rightontrack.com.my', '', ''),
(94, 'CLEAN SEWERS SERVICES SDN BHD', 'SHAH ALAM', '03 5640 0031', 1, 'admin@clean_sewers.com', 'MR RAMESH / SHOBA', '');

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
) ENGINE=InnoDB AUTO_INCREMENT=205 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbcustomeraccount`
--

INSERT INTO `tbcustomeraccount` (`customerAccount_id`, `customerAccount_customerID`, `customerAccount_date`, `customerAccount_reference`, `customerAccount_documentType`, `customerAccount_documentTypeID`, `customerAccount_description`, `customerAccount_debit`, `customerAccount_credit`) VALUES
(1, 51, '2023-01-21', 'IN/2023/001', 'INV', 1, 'INVOICE', '1000.00', '0.00'),
(2, 51, '2023-01-21', 'IN/2023/002', 'INV', 2, 'INVOICE', '500.00', '0.00'),
(3, 67, '2023-01-21', 'IN/2023/003', 'INV', 3, 'INVOICE', '6500.00', '0.00'),
(8, 76, '2023-01-21', 'IN/2023/004', 'INV', 4, '', '3206.00', '0.00'),
(9, 76, '2023-01-21', 'IN/2023/005', 'INV', 5, 'INVOICE', '3374.95', '0.00'),
(12, 53, '2023-01-21', 'IN/2023/009', 'INV', 7, 'INVOICE', '17000.00', '0.00'),
(16, 53, '2023-01-19', 'RPT/2023/009', 'PAY', 9, 'PAYMENT', '0.00', '4897.75'),
(18, 76, '2023-01-22', 'IN/2023/010', 'INV', 8, 'INVOICE', '6214.00', '0.00'),
(19, 80, '2023-01-22', 'IN/2023/011', 'INV', 9, 'INVOICE', '5000.00', '0.00'),
(21, 76, '2023-01-23', 'IN/2023/012', 'INV', 10, 'INVOICE', '1000.00', '0.00'),
(22, 76, '2023-01-23', 'IN/2023/015', 'INV', 11, 'INVOICE', '5600.00', '0.00'),
(23, 76, '2023-01-23', 'IN/2023/019', 'INV', 12, 'INVOICE', '3683.55', '0.00'),
(26, 67, '2023-01-24', 'IN/2023/020', 'INV', 13, 'INVOICE', '5682.05', '0.00'),
(27, 67, '2023-01-24', 'CN/2023/020', 'CN', 1, 'CREDIT NOTE', '0.00', '1589.20'),
(29, 75, '2023-01-24', 'IN/2023/021', 'INV', 14, '', '3758.50', '0.00'),
(30, 76, '2023-01-24', 'IN/2023/022', 'INV', 15, 'INVOICE', '9070.00', '0.00'),
(31, 74, '2023-01-24', 'IN/2023/023', 'INV', 16, 'INVOICE', '9517.50', '0.00'),
(32, 51, '2023-01-24', 'IN/2023/024', 'INV', 17, 'INVOICE', '10000.00', '0.00'),
(34, 61, '2023-01-25', 'IN/2023/025', 'INV', 18, 'INVOICE', '1000.00', '0.00'),
(35, 61, '2023-01-25', 'RPT/2023/016', 'PAY', 16, 'PAYMENT', '0.00', '575.00'),
(36, 81, '2023-01-26', 'IN/2023/026', 'INV', 19, 'INVOICE', '1000.00', '0.00'),
(37, 81, '2023-01-26', 'IN/2023/028', 'INV', 20, 'INVOICE', '5000.00', '0.00'),
(39, 76, '2023-01-26', 'IN/2023/029', 'INV', 21, 'INVOICE', '15000.00', '0.00'),
(58, 76, '2023-01-26', 'RPT/2023/036', 'PAY', 36, 'PAYMENT', '0.00', '3153.45'),
(60, 81, '2023-01-26', 'RPT/2023/038', 'PAY', 38, 'PAYMENT', '0.00', '170.00'),
(61, 67, '2023-01-27', 'RPT/2023/039', 'PAY', 39, 'PAYMENT', '0.00', '300.00'),
(63, 74, '2023-01-27', 'RPT/2023/041', 'PAY', 41, 'PAYMENT', '0.00', '35.00'),
(64, 81, '2023-01-27', 'RPT/2023/042', 'PAY', 42, 'PAYMENT', '0.00', '107.00'),
(65, 67, '2023-01-27', 'RPT/2023/043', 'PAY', 43, 'PAYMENT', '0.00', '120.00'),
(66, 82, '2023-01-27', '', 'MAD', 0, 'BALANCE C/F', '15450.00', '0.00'),
(67, 51, '2023-01-28', 'IN/2023/030', 'INV', 22, 'INVOICE', '5300.00', '0.00'),
(68, 74, '2023-01-28', 'IN/2023/031', 'INV', 23, 'INVOICE', '34452.00', '0.00'),
(69, 51, '2023-01-29', 'IN/2023/032', 'INV', 24, 'INVOICE', '38692.55', '0.00'),
(70, 81, '2023-01-30', 'IN/2023/033', 'INV', 25, 'INVOICE', '38692.55', '0.00'),
(71, 81, '2023-01-30', 'RPT/2023/045', 'PAY', 44, 'PAYMENT', '0.00', '6523.00'),
(72, 81, '2023-01-30', 'IN/2023/034', 'INV', 26, 'INVOICE', '10452.50', '0.00'),
(73, 53, '2023-01-30', 'IN/2023/035', 'INV', 27, 'INVOICE', '40851.65', '0.00'),
(74, 76, '2023-01-30', 'IN/2023/036', 'INV', 28, 'INVOICE', '16239.52', '0.00'),
(75, 54, '2023-01-30', 'IN/2023/037', 'INV', 29, 'INVOICE', '9070.00', '0.00'),
(76, 51, '2023-01-30', 'IN/2023/038', 'INV', 30, 'INVOICE', '9070.00', '0.00'),
(78, 63, '2023-01-30', 'IN/2023/040', 'INV', 32, 'INVOICE', '69917.36', '0.00'),
(79, 51, '2023-01-30', 'IN/2023/041', 'INV', 33, 'INVOICE', '9617.60', '0.00'),
(80, 51, '2023-01-30', 'CN/2023/021', 'CN', 2, 'CREDIT NOTE', '0.00', '9617.60'),
(81, 74, '2023-01-30', 'IN/2023/042', 'INV', 34, 'INVOICE', '9617.60', '0.00'),
(83, 51, '2023-01-30', 'RPT/2023/046', 'PAY', 45, 'PAYMENT', '0.00', '64562.55'),
(84, 51, '2023-01-31', 'IN/2023/045', 'INV', 35, '', '3656.00', '0.00'),
(87, 63, '2023-01-31', 'RPT/2023/048', 'PAY', 47, 'PAYMENT', '0.00', '500.00'),
(88, 51, '2023-01-31', 'IN/2023/046', 'INV', 36, 'INVOICE', '9033.50', '0.00'),
(89, 51, '2023-01-31', 'RPT/2023/049', 'PAY', 48, 'PAYMENT', '0.00', '155.00'),
(99, 76, '2023-02-01', 'IN/2023/049', 'INV', 42, 'INVOICE', '9070.00', '0.00'),
(100, 40, '2023-02-01', 'IN/2023/050', 'INV', 43, 'INVOICE', '38692.55', '0.00'),
(101, 76, '2023-02-01', 'IN/2023/051', 'INV', 44, 'INVOICE', '11720.80', '0.00'),
(102, 76, '2023-02-01', 'RPT/2023/054', 'PAY', 53, 'PAYMENT', '0.00', '74126.87'),
(103, 40, '2023-02-01', 'RPT/2023/055', 'PAY', 54, 'PAYMENT', '0.00', '1000.00'),
(104, 75, '2023-02-01', 'RPT/2023/056', 'PAY', 55, 'PAYMENT', '0.00', '500.00'),
(105, 53, '2023-02-01', 'RPT/2023/057', 'PAY', 56, 'PAYMENT', '0.00', '856.00'),
(106, 81, '2023-02-01', 'IN/2023/052', 'INV', 45, 'INVOICE', '11720.79', '0.00'),
(110, 76, '2023-02-01', 'IN/2023/055', 'INV', 48, 'INVOICE', '4644.20', '0.00'),
(111, 8, '2023-02-01', 'IN/2023/056', 'INV', 49, 'INVOICE', '11720.79', '0.00'),
(112, 74, '2023-02-01', 'IN/2023/057', 'INV', 50, 'INVOICE', '11720.80', '0.00'),
(113, 51, '2023-02-01', 'IN/2023/058', 'INV', 51, 'INVOICE', '1000.00', '0.00'),
(114, 51, '2023-02-01', 'CN/2023/022', 'CN', 5, 'CREDIT NOTE', '0.00', '60.00'),
(115, 51, '2023-02-01', 'RPT/2023/059', 'PAY', 58, 'PAYMENT', '0.00', '55.00'),
(116, 83, '2023-02-02', 'IN/2023/059', 'INV', 52, '', '7000.00', '0.00'),
(117, 74, '2023-02-22', 'IN/2023/060', 'INV', 53, 'INVOICE', '999.00', '0.00'),
(118, 74, '2023-02-06', 'CN/2023/023', 'CN', 6, 'CREDIT NOTE', '0.00', '1662.40'),
(119, 74, '2023-02-06', 'IN/2023/061', 'INV', 54, '', '2636.65', '0.00'),
(121, 74, '2023-02-12', 'RPT/2023/061', 'PAY', 60, 'PAYMENT', '0.00', '57187.75'),
(122, 74, '2023-02-12', 'RPT/2023/062', 'PAY', 61, 'PAYMENT', '0.00', '500.00'),
(123, 84, '2023-02-13', '', 'MAD', 0, 'BALANCE C/F', '5600.00', '0.00'),
(124, 85, '2023-02-13', '', 'MAD', 0, 'BALANCE C/F (OVERPAID)', '0.00', '3500.00'),
(125, 61, '2023-02-15', 'IN/2023/062', 'INV', 55, 'INVOICE', '6000.00', '0.00'),
(126, 61, '2023-02-15', 'RPT/2023/063', 'PAY', 62, 'PAYMENT', '0.00', '6000.00'),
(127, 8, '2023-02-15', 'IN/2023/063', 'INV', 56, 'INVOICE', '6090.00', '0.00'),
(128, 8, '2023-02-15', 'RPT/2023/064', 'PAY', 63, 'PAYMENT', '0.00', '350.00'),
(129, 61, '2023-01-01', 'IN/2023/064', 'INV', 57, 'INVOICE', '3150.00', '0.00'),
(130, 71, '2023-01-01', 'IN/2023/065', 'INV', 58, 'INVOICE', '888.00', '0.00'),
(131, 81, '2023-01-01', 'IN/2023/066', 'INV', 59, 'INVOICE', '999.00', '0.00'),
(132, 76, '2023-01-18', 'IN/2023/067', 'INV', 60, 'INVOICE', '3136.00', '0.00'),
(133, 76, '2023-02-15', 'IN/2023/068', 'INV', 61, '', '5062.75', '0.00'),
(134, 87, '2023-02-18', '', 'MAD', 0, 'BALANCE C/F', '5000.00', '0.00'),
(135, 87, '2023-02-18', 'IN/2023/069', 'INV', 62, '', '10139.83', '0.00'),
(136, 51, '2023-02-18', 'IN/2023/070', 'INV', 63, '', '10139.83', '0.00'),
(137, 88, '2023-02-19', '', 'MAD', 0, 'BALANCE C/F', '0.00', '3500.00'),
(138, 67, '2023-02-22', 'IN/2023/071', 'INV', 64, 'INVOICE', '2330.45', '0.00'),
(139, 89, '2023-02-22', '', 'MAD', 0, 'BALANCE C/F', '0.00', '7500.00'),
(140, 90, '2023-02-22', '', 'MAD', 0, 'BALANCE C/F', '0.00', '600.00'),
(141, 71, '2023-02-23', 'IN/2023/072', 'INV', 65, 'INVOICE', '3152.90', '0.00'),
(142, 71, '2023-02-23', 'RPT/2023/065', 'PAY', 64, 'PAYMENT', '0.00', '4040.90'),
(143, 51, '2023-02-23', 'PB/2023/005', 'PB', 19, 'Payment Bill', '0.00', '350.00'),
(144, 51, '2023-02-24', 'PB/001', 'PB', 1, 'Payment Bill', '0.00', '1000.00'),
(145, 51, '2023-02-27', 'PB/005', 'PB', 2, 'Payment Bill', '0.00', '3965.80'),
(146, 91, '2023-02-25', '', 'MAD', 0, 'BALANCE C/F', '0.00', '5000.00'),
(147, 10, '2023-02-25', 'PB/006', 'PB', 3, 'Payment Bill', '0.00', '1600.00'),
(148, 91, '2023-02-25', 'PB/007', 'PB', 4, 'Payment Bill', '0.00', '1315.00'),
(149, 51, '2023-09-09', 'IN/2023/075', 'INV', 66, '', '7000.00', '0.00'),
(150, 51, '2023-02-26', 'IN/2023/076', 'INV', 67, '', '18337.40', '0.00'),
(151, 51, '2023-02-26', 'RPT/2023/067', 'PAY', 65, 'PAYMENT', '0.00', '48896.73'),
(152, 67, '2023-02-27', 'PB/008', 'PB', 5, 'Payment Bill', '0.00', '350.45'),
(153, 0, '0000-00-00', 'PB/009', 'PB', 6, 'Payment Bill', '0.00', '8457.00'),
(154, 0, '0000-00-00', 'PB/2023/001', 'PB', 7, 'Payment Bill', '0.00', '1074.95'),
(155, 51, '0000-00-00', 'PB/2023/001', 'PB', 1, 'Payment Bill', '0.00', '770.35'),
(156, 67, '2023-02-28', 'PB/2023/001', 'PB', 1, 'Payment Bill', '0.00', '5168.15'),
(157, 51, '2023-02-27', 'PB/2023/001', 'PB', 2, 'Payment Bill', '0.00', '3965.80'),
(158, 53, '2023-02-27', 'PB/2023/002', 'PB', 3, 'Payment Bill', '0.00', '45.00'),
(159, 63, '2023-02-27', 'PB/2023/003', 'PB', 4, 'Payment Bill', '0.00', '4115.80'),
(160, 61, '2023-02-27', 'PB/2023/004', 'PB', 5, 'Payment Bill', '0.00', '3965.80'),
(161, 33, '2023-02-27', 'PB/2023/005', 'PB', 6, 'Payment Bill', '0.00', '4544.35'),
(162, 51, '2023-02-27', 'PB/2023/006', 'PB', 7, 'Payment Bill', '0.00', '7350.00'),
(163, 51, '2023-02-28', 'PB/2023/007', 'PB', 8, 'Payment Bill', '0.00', '22410.00'),
(165, 53, '2023-02-28', 'PV/2023/002', 'PAYV', 2, 'PAYMENT VOUCHER', '45.00', '0.00'),
(166, 8, '2023-02-28', 'PB/2023/008', 'PB', 9, 'Payment Bill', '0.00', '4965.80'),
(168, 33, '2023-02-28', 'PB/2023/009', 'PB', 10, 'Payment Bill', '0.00', '5000.00'),
(170, 16, '2023-02-28', 'PB/2023/010', 'PB', 11, 'Payment Bill', '0.00', '5000.00'),
(171, 16, '2023-02-28', 'PV/2023/006', 'PAYV', 5, 'PAYMENT VOUCHER', '2340.45', '0.00'),
(179, 51, '2023-03-01', 'PV/2023/010', 'PAYV', 9, 'PAYMENT VOUCHER', '33125.80', '0.00'),
(180, 33, '2023-02-28', 'PV/2023/011', 'PAYV', 10, 'PAYMENT VOUCHER', '9544.35', '0.00'),
(181, 53, '2023-03-01', 'PB/2023/012', 'PB', 13, 'Payment Bill', '0.00', '371.00'),
(182, 53, '2023-03-01', 'PV/2023/012', 'PAYV', 11, 'PAYMENT VOUCHER', '371.00', '0.00'),
(186, 51, '2023-03-01', 'PB/2023/003', 'PB', 3, 'Payment Bill', '0.00', '1000.00'),
(188, 67, '2023-03-01', 'PB/2023/004', 'PB', 5, 'Payment Bill', '0.00', '5000.00'),
(190, 51, '2023-03-01', 'RPT0002', 'PAYV', 2, 'PAYMENT VOUCHER', '1000.00', '0.00'),
(192, 65, '2023-03-01', 'IN/2023/100', 'INV', 70, '', '3075.35', '0.00'),
(193, 92, '2023-03-01', '', 'MAD', 0, 'BALANCE C/F', '0.00', '2500.00'),
(194, 92, '2023-03-01', 'PB/2023/005', 'PB', 6, 'Payment Bill', '0.00', '150.00'),
(196, 76, '2023-03-01', 'PB/2023/006', 'PB', 7, 'Payment Bill', '0.00', '1820.98'),
(197, 65, '2023-03-03', 'RPT/2023/069', 'PAY', 67, 'PAYMENT', '0.00', '3075.35'),
(198, 23, '2023-03-07', 'PB/2023/007', 'PB', 8, 'Payment Bill', '0.00', '600.00'),
(199, 51, '2023-03-12', 'IN/2023/101', 'INV', 71, 'INVOICE', '25095.22', '0.00'),
(200, 51, '2023-03-12', 'IN/2023/102', 'INV', 72, '', '796.15', '0.00'),
(201, 74, '2023-03-12', 'IN/2023/103', 'INV', 73, 'INVOICE', '796.15', '0.00'),
(202, 51, '2023-03-12', 'IN/2023/104', 'INV', 74, 'INVOICE', '806.65', '0.00'),
(203, 74, '2023-03-12', 'IN/2023/105', 'INV', 75, 'INVOICE', '0.00', '0.00'),
(204, 51, '2023-03-12', 'CN/2023/024', 'CN', 7, 'CREDIT NOTE', '0.00', '6407.90');

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbdeliveryorder`
--

INSERT INTO `tbdeliveryorder` (`deliveryOrder_id`, `deliveryOrder_no`, `deliveryOrder_date`, `deliveryOrder_customerID`, `deliveryOrder_title`, `deliveryOrder_from`, `deliveryOrder_terms`, `deliveryOrder_attention`, `deliveryOrder_email`, `deliveryOrder_subTotal`, `deliveryOrder_taxTotal`, `deliveryOrder_grandTotal`, `deliveryOrder_discountTotal`, `deliveryOrder_totalAfterDiscount`, `deliveryOrder_roundAmount`, `deliveryOrder_grandTotalRound`, `deliveryOrder_roundStatus`, `deliveryOrder_content`, `deliveryOrder_quotationNo`, `deliveryOrder_quotationID`, `deliveryOrder_invoiceNo`, `deliveryOrder_invoiceID`) VALUES
(1, 'DO/2023/001', '2023-01-21', 76, '', '', '<p><strong>Delivery Order Terms</strong></p><p>a.) All necessary documentation permit to enter the jobsite shall be arranged by the Hirer.<br />b.) All lifting Gears to be provided by the Hirer.<br />c.) Sunday &amp; Public Holiday considered as overtime and minimum 8hrs.</p>', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', '', '3206.00', '0.00', '3206.00', '0.00', '3206.00', '0.00', '3206.00', 0, '', 'QUO/2023/001', 1, 'IN/2023/004', 4),
(2, 'DO/2023/002', '2023-01-24', 75, '', '', '<p><strong>Delivery Order Terms</strong></p><p>a.) All necessary documentation permit to enter the jobsite shall be arranged by the Hirer.<br />b.) All lifting Gears to be provided by the Hirer.<br />c.) Sunday &amp; Public Holiday considered as overtime and minimum 8hrs.</p>', 'MR RAYMOND', '', '3758.50', '0.00', '3758.50', '0.00', '3758.50', '0.00', '3758.50', 0, '', 'QUO/2023/002', 2, 'IN/2023/021', 14),
(3, 'DO/2023/003', '2023-01-24', 76, '', '', '<p><strong>Delivery Order Terms</strong></p><p>a.) All necessary documentation permit to enter the jobsite shall be arranged by the Hirer.<br />b.) All lifting Gears to be provided by the Hirer.<br />c.) Sunday &amp; Public Holiday considered as overtime and minimum 8hrs.</p>', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', '', '9220.00', '0.00', '9070.00', '150.00', '9070.00', '0.00', '9070.00', 0, '', '', 0, 'IN/2023/022', 15),
(4, 'DO/2023/004', '2023-01-31', 51, 'SEND AUTOMOTIVE PARTS TO WAREHOUSE LOCATED IN PORT KLANG ( GATE 56)', 'MS LIEW (CATHRINE)', '<p><strong>Delivery Order Terms</strong></p><p>a.) All necessary documentation permit to enter the jobsite shall be arranged by the Hirer.<br />b.) All lifting Gears to be provided by the Hirer.<br />c.) Sunday &amp; Public Holiday considered as overtime and minimum 8hrs.</p>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '3656.00', '0.00', '3656.00', '0.00', '3656.00', '0.00', '3656.00', 0, '<p>TO</p><p>PORT KLANG MANAGER</p><p>PLEASE RELEASE ALL OUR CONTAINERS AS SOON AS POSSIBLE.</p><ul><li>CONTAINER NO 65722 - 1 UNIT</li><li>CONTAINER NO 5664BH - 3 UNITS</li></ul>', 'QUO/2023/003', 3, 'IN/2023/045', 35),
(5, 'DO/2023/005', '2023-02-01', 3, '', '', '<p><strong>Delivery Order Terms</strong></p><p>a.) All necessary documentation permit to enter the jobsite shall be arranged by the Hirer.<br />b.) All lifting Gears to be provided by the Hirer.<br />c.) Sunday &amp; Public Holiday considered as overtime and minimum 8hrs.</p>', '', '', '4328.50', '387.81', '4644.21', '72.10', '4256.40', '-0.01', '4644.20', 1, '', '', 0, '', 0),
(6, 'DO/2023/006', '2023-02-02', 83, 'BLOCKED SEWERAGE PIPING CLEARING AND MANHOLE CLEANING FOR ABOVE LOCATION', '', '<p><strong>Delivery Order Terms</strong></p><p>a.) All necessary documentation permit to enter the jobsite shall be arranged by the Hirer.<br />b.) All lifting Gears to be provided by the Hirer.<br />c.) Sunday &amp; Public Holiday considered as overtime and minimum 8hrs.</p>', '', '', '7000.00', '0.00', '7000.00', '0.00', '7000.00', '0.00', '7000.00', 0, '<p>To</p><p>Manager</p><p>DESA DAMANSARA MANAGEMENT CORPORATION</p><p>&nbsp;</p>', 'QUO/2023/005', 5, 'IN/2023/059', 52),
(7, 'DO/2023/007', '2023-02-07', 3, '', '', '<p><strong>Delivery Order Terms</strong></p><p>a.) All necessary documentation permit to enter the jobsite shall be arranged by the Hirer.<br />b.) All lifting Gears to be provided by the Hirer.<br />c.) Sunday &amp; Public Holiday considered as overtime and minimum 8hrs.</p>', '', '', '33485.00', '0.00', '33485.00', '0.00', '33485.00', '0.00', '33485.00', 0, '', '', 0, '', 0),
(8, 'DO/2023/008', '2023-02-18', 87, '', '', '<p><strong>Delivery Order Terms</strong></p><p>a.) All necessary documentation permit to enter the jobsite shall be arranged by the Hirer.<br />b.) All lifting Gears to be provided by the Hirer.<br />c.) Sunday &amp; Public Holiday considered as overtime and minimum 8hrs.</p>', 'MR TIMOTHY', 'timothy@rainehome.com.my', '8454.03', '1702.30', '10139.83', '16.50', '8437.53', '0.00', '10139.83', 0, '', 'QUO/2023/008', 8, 'IN/2023/069', 62),
(9, 'DO/2023/009', '2023-02-25', 81, '', '', '<p><strong>Delivery Order Terms</strong></p><p>a.) All necessary documentation permit to enter the jobsite shall be arranged by the Hirer.<br />b.) All lifting Gears to be provided by the Hirer.<br />c.) Sunday &amp; Public Holiday considered as overtime and minimum 8hrs.</p>', '', '', '230.00', '0.00', '230.00', '0.00', '230.00', '0.00', '230.00', 0, '', '', 0, '', 0),
(10, 'DO/2023/010', '2023-02-26', 71, '', '', '<p><strong>Delivery Order Terms</strong></p><p>a.) All necessary documentation permit to enter the jobsite shall be arranged by the Hirer.<br />b.) All lifting Gears to be provided by the Hirer.<br />c.) Sunday &amp; Public Holiday considered as overtime and minimum 8hrs.</p>', '', '', '2902.20', '366.11', '3152.91', '115.40', '2786.80', '-0.01', '3152.90', 1, '', '', 0, 'IN/2023/072', 65),
(11, 'DO/2023/016', '2023-02-26', 51, '', '', '<p><strong>Delivery Order Terms</strong></p><p>a.) All necessary documentation permit to enter the jobsite shall be arranged by the Hirer.<br />b.) All lifting Gears to be provided by the Hirer.<br />c.) Sunday &amp; Public Holiday considered as overtime and minimum 8hrs.</p>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '18061.50', '275.91', '18337.41', '0.00', '18061.50', '-0.01', '18337.40', 1, '', 'QUO/2023/012', 12, 'IN/2023/076', 67),
(12, 'DO/2023/017', '2023-03-12', 8, '', '', '<p><strong>Delivery Order Terms</strong></p><p>a.) All necessary documentation permit to enter the jobsite shall be arranged by the Hirer.<br />b.) All lifting Gears to be provided by the Hirer.<br />c.) Sunday &amp; Public Holiday considered as overtime and minimum 8hrs.</p>', 'Hariharan', 'ayur_90@gmail.com', '646.47', '194.17', '796.14', '44.50', '601.97', '0.01', '796.15', 1, '', '', 0, '', 0),
(13, 'DO/2023/018', '2023-03-12', 51, '', '', '<p><strong>Delivery Order Terms</strong></p><p>a.) All necessary documentation permit to enter the jobsite shall be arranged by the Hirer.<br />b.) All lifting Gears to be provided by the Hirer.<br />c.) Sunday &amp; Public Holiday considered as overtime and minimum 8hrs.</p>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '646.47', '194.17', '796.14', '44.50', '601.97', '0.01', '796.15', 1, '', '', 0, '', 0),
(14, 'DO/2023/019', '2023-03-12', 51, '', '', '<p><strong>Delivery Order Terms</strong></p><p>a.) All necessary documentation permit to enter the jobsite shall be arranged by the Hirer.<br />b.) All lifting Gears to be provided by the Hirer.<br />c.) Sunday &amp; Public Holiday considered as overtime and minimum 8hrs.</p>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '646.47', '194.17', '796.14', '44.50', '601.97', '0.01', '796.15', 1, '', '', 0, 'IN/2023/102', 72),
(15, 'DO/2023/020', '2023-03-13', 21, '', '', '<p><strong>Delivery Order Terms</strong></p><p>a.) All necessary documentation permit to enter the jobsite shall be arranged by the Hirer.<br />b.) All lifting Gears to be provided by the Hirer.<br />c.) Sunday &amp; Public Holiday considered as overtime and minimum 8hrs.</p>', 'Madam Devi Nair', 'devi_epson@gmail.com', '617.50', '0.00', '617.50', '0.00', '617.50', '0.00', '617.50', 0, '', 'QUO/2023/024', 24, '', 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=138 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbdeliveryorderdetail`
--

INSERT INTO `tbdeliveryorderdetail` (`deliveryOrderDetail_id`, `deliveryOrderDetail_deliveryOrderID`, `deliveryOrderDetail_no1`, `deliveryOrderDetail_no2`, `deliveryOrderDetail_no3`, `deliveryOrderDetail_no4`, `deliveryOrderDetail_bold`, `deliveryOrderDetail_sortID`, `deliveryOrderDetail_no5`, `deliveryOrderDetail_rowTotal`, `deliveryOrderDetail_taxRateID`, `deliveryOrderDetail_taxPercent`, `deliveryOrderDetail_taxTotal`, `deliveryOrderDetail_rowGrandTotal`, `deliveryOrderDetail_discountPercent`, `deliveryOrderDetail_discountAmount`, `deliveryOrderDetail_rowTotalAfterDiscount`) VALUES
(1, 1, '', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 0, 1, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(2, 1, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '2.00', '', 0, 2, '450.00', '900.00', 1, '0.00', '0.00', '900.00', '0.00', '0.00', '900.00'),
(3, 1, '', 'NOKIA CHARGER TYPE CARBON 4598BK2', '5.00', 'UNIT', 0, 3, '450.00', '2250.00', 1, '0.00', '0.00', '2250.00', '0.00', '0.00', '2250.00'),
(4, 1, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(5, 1, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(6, 2, '', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 0, 1, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(7, 2, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '2.00', '', 0, 2, '450.00', '900.00', 1, '0.00', '0.00', '900.00', '0.00', '0.00', '900.00'),
(8, 2, '', 'NOKIA CHARGER TYPE CARBON 4598BK2', '5.00', 'UNIT', 0, 3, '450.00', '2250.00', 1, '0.00', '0.00', '2250.00', '0.00', '0.00', '2250.00'),
(9, 2, '', 'TOP RADIATOR HOSE ORIGINAL', '0.00', '', 0, 4, '450.00', '450.00', 1, '0.00', '0.00', '450.00', '0.00', '0.00', '450.00'),
(10, 2, '', 'AUTOMATIC TRANSMISSION FLUID', '0.00', 'unit', 0, 5, '102.50', '102.50', 1, '0.00', '0.00', '102.50', '0.00', '0.00', '102.50'),
(19, 3, '', 'DESLUDGING SERVICES FOR SLUDGE & OTHER RELATED WORKS', '0.00', '', 1, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(20, 3, '1.', 'TO USE 4.5m3 DESLDUDGING TANKER TO VACUUM AND REMOVE SLUDGE / WASTE WATER INCLUDING DISPOSAL. 20/10/2022', '3.00', 'TRIPS', 0, 2, '450.00', '1350.00', 1, '0.00', '0.00', '1350.00', '0.00', '0.00', '1350.00'),
(21, 3, '2.', 'TO USE 10.00m3 DESLDUDGING TANKER TO VACUUM AND REMOVE SLUDGE / WASTE WATER INCLUDING DISPOSAL  20/10/2022', '2.00', 'TRIPS', 0, 3, '750.00', '1500.00', 1, '0.00', '0.00', '1500.00', '0.00', '0.00', '1500.00'),
(22, 3, '3.', 'REWINDING AND SERVICING WASTE WATER PUMP 16/10/2022', '0.00', '', 0, 4, '3450.00', '3450.00', 1, '0.00', '0.00', '3450.00', '0.00', '0.00', '3450.00'),
(23, 3, '4.', 'ELECTRICAL WIRING WORKS FROM PUMP TO THE ELECTRICAL PANEL BOX.', '0.00', '', 0, 5, '120.00', '120.00', 1, '0.00', '0.00', '120.00', '0.00', '0.00', '120.00'),
(24, 3, '5.', 'TO USE HIGH PRESSURE JETTER TRUCK MACHINE TO CLEAN AND BREAK ALL BLOCKAGES WITHIN THE SEWERAGE PIPELINES.', '0.00', '', 0, 6, '1800.00', '1800.00', 1, '0.00', '0.00', '1800.00', '0.00', '0.00', '1800.00'),
(25, 3, '', 'LABOUR CHARGES', '0.00', '', 1, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(26, 3, '1.', 'TO USE DESLUDGING TANKER TO VACUUM AND REMOVE ALL SLUDGE / WASTE WATER TO ENABLE THE SUBMERSIBLE PUMP AND SENSOR TO BE INSTALLED.', '2.00', 'UNITS', 0, 8, '500.00', '1000.00', 1, '0.00', '0.00', '850.00', '15.00', '150.00', '850.00'),
(41, 4, '', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 1, 1, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(42, 4, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '2.00', '', 0, 2, '450.00', '900.00', 1, '0.00', '0.00', '900.00', '0.00', '0.00', '900.00'),
(43, 4, '', 'NOKIA CHARGER TYPE CARBON 4598BK2', '5.00', 'UNIT', 1, 3, '450.00', '2250.00', 1, '0.00', '0.00', '2250.00', '0.00', '0.00', '2250.00'),
(44, 4, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(45, 4, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '0.00', '', 0, 5, '450.00', '450.00', 1, '0.00', '0.00', '450.00', '0.00', '0.00', '450.00'),
(46, 4, '', '', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(47, 4, '', '', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(48, 5, '', 'LABOUR TO REPLACE PARTS & SERVICE', '12.00', '', 0, 1, '56.00', '672.00', 1, '0.00', '0.00', '638.40', '5.00', '33.60', '638.40'),
(49, 5, '', 'Screw Holland made 6 type', '5.00', '', 0, 2, '77.00', '385.00', 4, '34.00', '117.81', '464.31', '10.00', '38.50', '346.50'),
(50, 5, '', 'AUTOMATIC TRANSMISSION FLUID', '5.00', 'unit', 0, 3, '102.50', '512.50', 1, '0.00', '0.00', '512.50', '0.00', '0.00', '512.50'),
(51, 5, '', 'TOP RADIATOR HOSE ORIGINAL', '6.00', '', 0, 4, '450.00', '2700.00', 3, '10.00', '270.00', '2970.00', '0.00', '0.00', '2700.00'),
(52, 5, '', 'NOKIA CHARGER TYPE CARBON 4598BK', '1.00', 'UNIT', 0, 5, '59.00', '59.00', 1, '0.00', '0.00', '59.00', '0.00', '0.00', '59.00'),
(53, 6, '', 'MANHOLE CLEANING WORKS', '0.00', '', 0, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(54, 6, '1.', 'STAFF NEED TO ENTER THE MANHOLES MANUALLY AND REMOVE ALL RUBBISH, DIRT AND SAND FROM THE BOTTOM OF MANHOLE.', '1.00', 'LOT', 0, 2, '2500.00', '2500.00', 1, '0.00', '0.00', '2500.00', '0.00', '0.00', '2500.00'),
(55, 6, '2.', 'COLLECT ALL THE RUBBISH AND SAND AND DISPOSE IN RORO RUBBISH BIN\r\nTO BE SEND TO DISPOSAL SITE USING LORRY.', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(56, 6, '3.', 'DISPOSAL AMOUNT INCLUDED IN THE QUOTATION.', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(57, 6, '', 'SEWERAGE PIPE CLEARING', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(58, 6, '1.', 'USE MANUAL RODDING TO CLEAR THE BLOCKAGES', '1.00', 'LOT', 0, 6, '3500.00', '3500.00', 1, '0.00', '0.00', '3500.00', '0.00', '0.00', '3500.00'),
(59, 6, '2.', 'USE JETTING MACHINE WITH HIGH POWERED WATER PRESSURE TO CLEAR ALL BLOCKAGES.', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(60, 6, '3.', 'REMOVE ALL THE CLEARED BLOCKAGES AND DISPOSE IN RORO BIN FOR DISPOSAL.', '0.00', '', 0, 8, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(61, 6, '', 'WORK SITE CLEANING WORKS', '0.00', '', 0, 9, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(62, 6, '1.', 'CLEAN ALL THE WORKSITE AREA OF DEBRIS, SLUDGE ETC AFTER THE WORKS IS COMPLETED.', '1.00', 'LOT', 0, 10, '1000.00', '1000.00', 1, '0.00', '0.00', '1000.00', '0.00', '0.00', '1000.00'),
(63, 6, '', 'PAYMENT TERMS', '0.00', '', 0, 11, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(64, 6, '1.', 'OFFICIAL PURCHASE ORDER NEED TO BE ISSUED BY CUSTOMER.', '0.00', '', 0, 12, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(65, 6, '2.', 'DEPOSIT AMOUNT OF 50 PERCENT OF TOTAL COST TO BE PAID BEFORE WORK STARTS.', '0.00', '', 0, 13, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(66, 6, '3.', 'BALANCE PAYMENT OF 50 PERCENT TO BE PAID WITHIN 7 DAYS OF WORK COMPLETION.', '0.00', '', 0, 14, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(67, 7, '', 'MOTOROLLA HANDPHONE MODEL X-9', '45.00', 'unit', 0, 1, '650.00', '29250.00', 1, '0.00', '0.00', '29250.00', '0.00', '0.00', '29250.00'),
(68, 7, '', 'Screw Holland made 6 type', '55.00', '', 0, 2, '77.00', '4235.00', 1, '0.00', '0.00', '4235.00', '0.00', '0.00', '4235.00'),
(69, 7, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(70, 7, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(71, 7, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(72, 8, '', 'A4 Bahasa Malaysia Exam papers9', '6.00', 'pcs', 0, 1, '6.49', '38.94', 1, '0.00', '0.00', '38.94', '0.00', '0.00', '38.94'),
(73, 8, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '6.00', '', 0, 2, '450.00', '2700.00', 1, '0.00', '0.00', '2700.00', '0.00', '0.00', '2700.00'),
(74, 8, '', 'Teak Wood furniture sofa chair', '5.00', '', 0, 3, '66.00', '330.00', 1, '0.00', '0.00', '313.50', '5.00', '16.50', '313.50'),
(75, 8, '', 'NOKIA CHARGER TYPE CARBON 4598BK', '1.00', 'UNIT', 0, 4, '59.00', '59.00', 1, '0.00', '0.00', '59.00', '0.00', '0.00', '59.00'),
(76, 8, '', 'MOTOROLLA HANDPHONE MODEL X-9', '1.00', 'unit', 0, 5, '5006.75', '5006.75', 4, '34.00', '1702.30', '6709.05', '0.00', '0.00', '5006.75'),
(77, 8, '', 'Chicken Eggs \r\nMount Road Poulty Farm', '0.00', '', 0, 6, '77.85', '77.85', 1, '0.00', '0.00', '77.85', '0.00', '0.00', '77.85'),
(78, 8, '', 'Screw Holland made 6 type', '3.00', '', 0, 7, '77.00', '231.00', 1, '0.00', '0.00', '231.00', '0.00', '0.00', '231.00'),
(79, 8, '', 'Electrical Cable Malaysia Made', '1.00', 'pc', 0, 8, '10.49', '10.49', 1, '0.00', '0.00', '10.49', '0.00', '0.00', '10.49'),
(80, 9, '', 'LABOUR TO REPLACE PARTS & SERVICE', '2.00', '', 0, 1, '56.00', '112.00', 1, '0.00', '0.00', '112.00', '0.00', '0.00', '112.00'),
(81, 9, '', 'NOKIA CHARGER TYPE CARBON 4598BK', '2.00', 'UNIT', 0, 2, '59.00', '118.00', 1, '0.00', '0.00', '118.00', '0.00', '0.00', '118.00'),
(82, 9, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(83, 9, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(84, 9, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(85, 10, '', 'LABOUR TO REPLACE PARTS & SERVICE', '3.00', '', 0, 1, '56.00', '168.00', 4, '34.00', '54.84', '216.12', '4.00', '6.72', '161.28'),
(86, 10, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '4.00', '', 0, 2, '450.00', '1800.00', 1, '0.00', '0.00', '1710.00', '5.00', '90.00', '1710.00'),
(87, 10, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(88, 10, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(89, 10, '', 'Chicken Eggs \r\nMount Road Poulty Farm', '12.00', '', 0, 5, '77.85', '934.20', 4, '34.00', '311.28', '1226.80', '2.00', '18.68', '915.52'),
(90, 11, '', 'LABOUR TO REPLACE PARTS & SERVICE', '1.00', '', 0, 1, '4560.00', '4560.00', 2, '6.00', '273.60', '4833.60', '0.00', '0.00', '4560.00'),
(91, 11, '', 'Screw Holland made 6 type', '2.00', '', 0, 2, '77.00', '154.00', 6, '1.50', '2.31', '156.31', '0.00', '0.00', '154.00'),
(92, 11, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '1.00', '', 0, 3, '450.00', '450.00', 1, '0.00', '0.00', '450.00', '0.00', '0.00', '450.00'),
(93, 11, '', 'Teak Wood furniture sofa chair', '1.00', '', 0, 4, '66.00', '66.00', 1, '0.00', '0.00', '66.00', '0.00', '0.00', '66.00'),
(94, 11, '', 'Parts Repair', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(95, 11, '1.', 'NOKIA CHARGER TYPE CARBON 4598BK', '2.00', 'UNIT', 0, 6, '59.00', '118.00', 1, '0.00', '0.00', '118.00', '0.00', '0.00', '118.00'),
(96, 11, '2.', 'MOTOROLLA HANDPHONE MODEL X-9', '2.00', 'unit', 0, 7, '5006.75', '10013.50', 1, '0.00', '0.00', '10013.50', '0.00', '0.00', '10013.50'),
(97, 11, '3.', 'TOP RADIATOR HOSE ORIGINAL', '6.00', '', 0, 8, '450.00', '2700.00', 1, '0.00', '0.00', '2700.00', '0.00', '0.00', '2700.00'),
(98, 12, '1', 'Curry Puff Flour 1.8kg', '3.00', 'packet', 0, 1, '6.49', '19.47', 2, '6.00', '1.11', '19.61', '5.00', '0.97', '18.50'),
(99, 12, '2', 'LABOUR TO REPLACE PARTS & SERVICE', '3.00', '', 0, 2, '56.00', '168.00', 4, '34.00', '54.26', '213.86', '5.00', '8.40', '159.60'),
(100, 12, '3', 'NOKIA CHARGER TYPE CARBON 4598BK', '3.00', 'UNIT', 0, 3, '59.00', '177.00', 4, '34.00', '55.97', '220.58', '7.00', '12.39', '164.61'),
(101, 12, '4', 'Teak Wood furniture sofa chair', '4.00', '', 0, 4, '66.00', '264.00', 4, '34.00', '82.58', '325.46', '8.00', '21.12', '242.88'),
(102, 12, '5', 'Jetting Works and Clear blockages with rodder machine', '3.00', 'unit', 0, 5, '6.00', '18.00', 6, '1.50', '0.25', '16.63', '9.00', '1.62', '16.38'),
(103, 13, '1', 'Curry Puff Flour 1.8kg', '3.00', 'packet', 0, 1, '6.49', '19.47', 2, '6.00', '1.11', '19.61', '5.00', '0.97', '18.50'),
(104, 13, '2', 'LABOUR TO REPLACE PARTS & SERVICE', '3.00', 'pc', 1, 2, '56.00', '168.00', 4, '34.00', '54.26', '213.86', '5.00', '8.40', '159.60'),
(105, 13, '3', 'NOKIA CHARGER TYPE CARBON 4598BK', '3.00', 'UNIT', 0, 3, '59.00', '177.00', 4, '34.00', '55.97', '220.58', '7.00', '12.39', '164.61'),
(106, 13, '4', 'Teak Wood furniture sofa chair', '4.00', 'kg', 0, 4, '66.00', '264.00', 4, '34.00', '82.58', '325.46', '8.00', '21.12', '242.88'),
(107, 13, '5', 'Jetting Works and Clear blockages with rodder machine', '3.00', 'unit', 1, 5, '6.00', '18.00', 6, '1.50', '0.25', '16.63', '9.00', '1.62', '16.38'),
(128, 14, '1', 'Curry Puff Flour 1.8kg', '3.00', 'packet', 1, 1, '6.49', '19.47', 2, '6.00', '1.11', '19.61', '5.00', '0.97', '18.50'),
(129, 14, '2', 'LABOUR TO REPLACE PARTS & SERVICE', '3.00', 'pc', 0, 2, '56.00', '168.00', 4, '34.00', '54.26', '213.86', '5.00', '8.40', '159.60'),
(130, 14, '3', 'NOKIA CHARGER TYPE CARBON 4598BK', '3.00', 'UNIT', 1, 3, '59.00', '177.00', 4, '34.00', '55.97', '220.58', '7.00', '12.39', '164.61'),
(131, 14, '4', 'Teak Wood furniture sofa chair', '4.00', 'kg', 0, 4, '66.00', '264.00', 4, '34.00', '82.58', '325.46', '8.00', '21.12', '242.88'),
(132, 14, '5', 'Jetting Works and Clear blockages with rodder machine', '3.00', 'unit', 1, 5, '6.00', '18.00', 6, '1.50', '0.25', '16.63', '9.00', '1.62', '16.38'),
(133, 15, '', 'AUTOMATIC TRANSMISSION FLUID', '0.00', 'unit', 0, 1, '102.50', '102.50', 1, '0.00', '0.00', '102.50', '0.00', '0.00', '102.50'),
(134, 15, '', 'NOKIA CHARGER TYPE CARBON 4598BK', '0.00', 'UNIT', 0, 2, '59.00', '59.00', 1, '0.00', '0.00', '59.00', '0.00', '0.00', '59.00'),
(135, 15, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '0.00', '', 0, 3, '450.00', '450.00', 1, '0.00', '0.00', '450.00', '0.00', '0.00', '450.00'),
(136, 15, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(137, 15, '', 'Jetting Works and Clear blockages with rodder machine', '0.00', 'unit', 0, 5, '6.00', '6.00', 1, '0.00', '0.00', '6.00', '0.00', '0.00', '6.00');

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
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbinvoice`
--

INSERT INTO `tbinvoice` (`invoice_id`, `invoice_no`, `invoice_date`, `invoice_customerID`, `invoice_title`, `invoice_from`, `invoice_terms`, `invoice_attention`, `invoice_email`, `invoice_subTotal`, `invoice_taxTotal`, `invoice_grandTotal`, `invoice_discountTotal`, `invoice_totalAfterDiscount`, `invoice_roundAmount`, `invoice_grandTotalRound`, `invoice_roundStatus`, `invoice_content`, `invoice_quotationNo`, `invoice_quotationID`, `invoice_deliveryOrderNo`, `invoice_deliveryOrderID`, `invoice_dueDate`, `invoice_dueDateNo`, `invoice_creditNote`, `invoice_debitNote`, `invoice_paid`, `invoice_status`) VALUES
(1, 'IN/2023/001', '2023-01-21', 51, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '1000.00', '0.00', '1000.00', '0.00', '1000.00', '0.00', '1000.00', 0, '', '', 0, '', 0, '2023-02-05', 15, '0.00', '0.00', '1000.00', 'a'),
(2, 'IN/2023/002', '2023-01-21', 51, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '500.00', '0.00', '500.00', '0.00', '500.00', '0.00', '500.00', 0, '', '', 0, '', 0, '2023-02-05', 15, '0.00', '0.00', '500.00', 'a'),
(3, 'IN/2023/003', '2023-01-21', 67, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'Mr Ramachandrean', 'caresome_90@gmail.com', '6500.00', '0.00', '6500.00', '0.00', '6500.00', '0.00', '6500.00', 0, '', '', 0, '', 0, '2023-02-05', 15, '0.00', '0.00', '-445.00', 'a'),
(4, 'IN/2023/004', '2023-01-21', 76, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', '', '3206.00', '0.00', '3206.00', '0.00', '3206.00', '0.00', '3206.00', 0, '', 'QUO/2023/001', 1, 'DO/2023/001', 1, '2023-02-05', 15, '0.00', '0.00', '3206.00', 'a'),
(5, 'IN/2023/005', '2023-01-21', 76, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', '', '3371.00', '3.96', '3374.96', '0.00', '3371.00', '-0.01', '3374.95', 1, '', '', 0, '', 0, '2023-02-05', 15, '0.00', '0.00', '70.00', 'a'),
(7, 'IN/2023/009', '2023-01-21', 53, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', '', '', '17000.00', '0.00', '17000.00', '0.00', '17000.00', '0.00', '17000.00', 0, '', '', 0, '', 0, '2023-02-05', 15, '0.00', '0.00', '800.00', 'a'),
(8, 'IN/2023/010', '2023-01-22', 76, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', '', '7040.28', '573.70', '6213.98', '1400.00', '5640.28', '0.02', '6214.00', 1, '', '', 0, '', 0, '2023-02-06', 15, '0.00', '0.00', '6214.00', 'a'),
(9, 'IN/2023/011', '2023-01-22', 80, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', '', '', '5000.00', '0.00', '5000.00', '0.00', '5000.00', '0.00', '5000.00', 0, '', '', 0, '', 0, '2023-02-06', 15, '0.00', '0.00', '0.00', 'a'),
(10, 'IN/2023/012', '2023-01-23', 76, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', '', '1000.00', '0.00', '1000.00', '0.00', '1000.00', '0.00', '1000.00', 0, '', '', 0, '', 0, '2023-02-07', 15, '0.00', '0.00', '90.00', 'a'),
(11, 'IN/2023/015', '2023-01-23', 76, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', '', '5600.00', '0.00', '5600.00', '0.00', '5600.00', '0.00', '5600.00', 0, '', '', 0, '', 0, '2023-02-07', 15, '0.00', '0.00', '5600.00', 'a'),
(12, 'IN/2023/019', '2023-01-23', 76, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', '', '2748.90', '934.63', '3683.53', '0.00', '2748.90', '0.02', '3683.55', 1, '', '', 0, '', 0, '2023-02-07', 15, '0.00', '0.00', '1000.00', 'a'),
(13, 'IN/2023/020', '2023-01-24', 67, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'Mr Ramachandrean', 'caresome_90@gmail.com', '5561.50', '174.53', '5682.03', '54.00', '5507.50', '0.02', '5682.05', 1, '', '', 0, '', 0, '2023-02-08', 15, '1589.20', '0.00', '115.00', 'a'),
(14, 'IN/2023/021', '2023-01-24', 75, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'MR RAYMOND', '', '3758.50', '0.00', '3758.50', '0.00', '3758.50', '0.00', '3758.50', 0, '', 'QUO/2023/002', 2, 'DO/2023/002', 2, '2023-02-08', 15, '0.00', '0.00', '500.00', 'a'),
(15, 'IN/2023/022', '2023-01-24', 76, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', '', '9220.00', '0.00', '9070.00', '150.00', '9070.00', '0.00', '9070.00', 0, '<p>Attention : <strong>Mr Manimaran</strong></p><p>Dear Sir,<br />This is the Quotation for the Computer Repair, transport and department delays etc for the <strong>Warehouse</strong></p>', '', 0, 'DO/2023/003', 3, '2023-02-08', 15, '0.00', '0.00', '9070.00', 'a'),
(16, 'IN/2023/023', '2023-01-24', 74, '', 'MR SUHUMARAN', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'MR PETER JUDE NATHAN', 'petter_jude@gmail.com', '9378.50', '289.00', '9517.50', '150.00', '9228.50', '0.00', '9517.50', 1, '<p><em><strong>PLEASE PAY THE PAYMENT AS SOON AS POSSIBLE FOR US TO WORK ON ON THE SYSTEM.</strong></em></p><ol><li>TRANSPORT CHARGES FOR THE PORT KLANG WAREHOUSE&nbsp;LOGISTIC APPLICATION SYSTEM SHOWS OVER DUE PAYMENT STATUS</li><li>FOR THE MR MANI EMA PRIMAAX SDN BHD PARTNER</li></ol>', '', 0, '', 0, '2023-02-23', 30, '0.00', '0.00', '9517.50', 'a'),
(17, 'IN/2023/024', '2023-01-24', 51, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '10000.00', '0.00', '10000.00', '0.00', '10000.00', '0.00', '10000.00', 0, '', '', 0, '', 0, '2023-02-08', 15, '0.00', '0.00', '10000.00', 'a'),
(18, 'IN/2023/025', '2023-01-25', 61, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', '', 'jumaatengineering@gmail.com', '1000.00', '0.00', '1000.00', '0.00', '1000.00', '0.00', '1000.00', 0, '', '', 0, '', 0, '2023-02-09', 15, '0.00', '0.00', '575.00', 'a'),
(19, 'IN/2023/026', '2023-01-26', 81, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', '', '', '1000.00', '0.00', '1000.00', '0.00', '1000.00', '0.00', '1000.00', 0, '', '', 0, '', 0, '2023-02-10', 15, '0.00', '0.00', '1000.00', 'a'),
(20, 'IN/2023/028', '2023-01-26', 81, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', '', '', '5000.00', '0.00', '5000.00', '0.00', '5000.00', '0.00', '5000.00', 0, '', '', 0, '', 0, '2023-02-10', 15, '0.00', '0.00', '5000.00', 'a'),
(21, 'IN/2023/029', '2023-01-26', 76, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', '', '15000.00', '0.00', '15000.00', '0.00', '15000.00', '0.00', '15000.00', 0, '', '', 0, '', 0, '2023-02-10', 15, '0.00', '0.00', '15000.00', 'a'),
(22, 'IN/2023/030', '2023-01-28', 51, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '5000.00', '300.00', '5300.00', '0.00', '5000.00', '0.00', '5300.00', 0, '', '', 0, '', 0, '2023-02-12', 15, '0.00', '0.00', '5300.00', 'a'),
(23, 'IN/2023/031', '2023-01-28', 74, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', '', '', '32400.00', '2052.00', '34452.00', '0.00', '32400.00', '0.00', '34452.00', 0, '', '', 0, '', 0, '2023-02-12', 15, '0.00', '0.00', '34452.00', 'a'),
(24, 'IN/2023/032', '2023-01-29', 51, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '36294.00', '2398.56', '38692.56', '0.00', '36294.00', '-0.01', '38692.55', 1, '', '', 0, '', 0, '2023-02-13', 15, '0.00', '0.00', '38692.55', 'a'),
(25, 'IN/2023/033', '2023-01-30', 81, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', '', '', '36294.00', '2398.56', '38692.56', '0.00', '36294.00', '-0.01', '38692.55', 1, '', '', 0, '', 0, '2023-02-14', 15, '0.00', '0.00', '800.00', 'a'),
(26, 'IN/2023/034', '2023-01-30', 81, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', '', '', '8947.26', '1775.23', '10452.49', '270.00', '8677.26', '0.01', '10452.50', 1, '', '', 0, '', 0, '2023-02-14', 15, '0.00', '0.00', '0.00', 'a'),
(27, 'IN/2023/035', '2023-01-30', 53, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', '', '', '38423.41', '2489.10', '40851.67', '60.84', '38362.57', '-0.02', '40851.65', 1, '', '', 0, '', 0, '2023-02-14', 15, '0.00', '0.00', '56.00', 'a'),
(28, 'IN/2023/036', '2023-01-30', 76, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', '', '13385.07', '3374.80', '16239.52', '520.34', '12864.72', '0.00', '16239.52', 0, '', '', 0, '', 0, '2023-02-14', 15, '0.00', '0.00', '16239.52', 'a'),
(29, 'IN/2023/037', '2023-01-30', 54, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', '', '', '9220.00', '0.00', '9070.00', '150.00', '9070.00', '0.00', '9070.00', 0, '', '', 0, '', 0, '2023-02-14', 15, '0.00', '0.00', '0.00', 'a'),
(30, 'IN/2023/038', '2023-01-30', 51, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '9220.00', '0.00', '9070.00', '150.00', '9070.00', '0.00', '9070.00', 0, '', '', 0, '', 0, '2023-02-14', 15, '0.00', '0.00', '9070.00', 'a'),
(32, 'IN/2023/040', '2023-01-30', 63, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'MR GANAESON', '', '70660.00', '1616.56', '69917.36', '2359.20', '68300.80', '0.00', '69917.36', 0, '', '', 0, '', 0, '2023-02-14', 15, '0.00', '0.00', '500.00', 'a'),
(33, 'IN/2023/041', '2023-01-30', 51, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '9220.00', '549.98', '9617.58', '152.40', '9067.60', '0.02', '9617.60', 1, '', '', 0, '', 0, '2023-02-14', 15, '9617.60', '0.00', '0.00', 'a'),
(34, 'IN/2023/042', '2023-01-30', 74, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', '', '', '9220.00', '549.98', '9617.58', '152.40', '9067.60', '0.02', '9617.60', 1, '', '', 0, '', 0, '2023-02-14', 15, '0.00', '0.00', '9617.60', 'a'),
(35, 'IN/2023/045', '2023-01-31', 51, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'Mr Balvinder Singh', '', '3656.00', '0.00', '3656.00', '0.00', '3656.00', '0.00', '3656.00', 0, '', 'QUO/2023/003', 3, 'DO/2023/004', 4, '2023-02-15', 15, '0.00', '0.00', '3656.00', 'a'),
(36, 'IN/2023/046', '2023-01-31', 51, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '8900.00', '133.50', '9033.50', '0.00', '8900.00', '0.00', '9033.50', 0, '', '', 0, '', 0, '2023-02-15', 15, '0.00', '0.00', '9033.50', 'a'),
(40, 'IN/2023/047', '2023-02-01', 81, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0, '', '', 0, '', 0, '2023-02-16', 15, '0.00', '0.00', '0.00', 'c'),
(41, 'IN/2023/048', '2023-02-01', 76, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0, '', '', 0, '', 0, '2023-02-16', 15, '0.00', '0.00', '0.00', 'c'),
(42, 'IN/2023/049', '2023-02-01', 76, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', '', '9220.00', '0.00', '9070.00', '150.00', '9070.00', '0.00', '9070.00', 0, '', '', 0, '', 0, '2023-02-16', 15, '0.00', '0.00', '9070.00', 'a'),
(43, 'IN/2023/050', '2023-02-01', 40, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'MR RAMESH (DATOK)', '', '36294.00', '2398.56', '38692.56', '0.00', '36294.00', '-0.01', '38692.55', 1, '', '', 0, '', 0, '2023-02-16', 15, '0.00', '0.00', '1000.00', 'a'),
(44, 'IN/2023/051', '2023-02-01', 76, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', '', '11686.46', '47.65', '11720.79', '13.32', '11673.14', '0.01', '11720.80', 1, '', '', 0, '', 0, '2023-02-16', 15, '0.00', '0.00', '11720.80', 'a'),
(45, 'IN/2023/052', '2023-02-01', 81, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', '', '', '11686.46', '47.65', '11720.79', '13.32', '11673.14', '0.00', '11720.79', 0, '', '', 0, '', 0, '2023-02-16', 15, '0.00', '0.00', '0.00', 'a'),
(47, 'IN/2023/054', '2023-02-01', 61, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', '', 'jumaatengineering@gmail.com', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0, '', '', 0, '', 0, '2023-02-16', 15, '0.00', '0.00', '0.00', 'c'),
(48, 'IN/2023/055', '2023-02-01', 76, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', '', '4328.50', '387.81', '4644.21', '72.10', '4256.40', '-0.01', '4644.20', 1, '', '', 0, '', 0, '2023-02-16', 15, '0.00', '0.00', '0.00', 'a'),
(49, 'IN/2023/056', '2023-02-01', 8, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'Hariharan', 'ayur_90@gmail.com', '11686.46', '47.65', '11720.79', '13.32', '11673.14', '0.00', '11720.79', 0, '', '', 0, '', 0, '2023-02-16', 15, '0.00', '0.00', '0.00', 'a'),
(50, 'IN/2023/057', '2023-02-01', 74, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', '', '', '11686.46', '47.65', '11720.79', '13.32', '11673.14', '0.01', '11720.80', 1, '', '', 0, '', 0, '2023-02-16', 15, '1662.40', '0.00', '500.00', 'a'),
(51, 'IN/2023/058', '2023-02-01', 51, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '1000.00', '0.00', '1000.00', '0.00', '1000.00', '0.00', '1000.00', 0, '', '', 0, '', 0, '2023-02-16', 15, '60.00', '0.00', '940.00', 'a'),
(52, 'IN/2023/059', '2023-02-02', 83, 'BLOCKED SEWERAGE PIPING CLEARING AND MANHOLE CLEANING FOR ABOVE LOCATION', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', '', '', '7000.00', '0.00', '7000.00', '0.00', '7000.00', '0.00', '7000.00', 0, '<p>To</p><p>Manager<br />DESA DAMANSARA MANAGEMENT CORPORATION</p>', 'QUO/2023/005', 5, 'DO/2023/006', 6, '2023-02-17', 15, '0.00', '0.00', '0.00', 'a'),
(53, 'IN/2023/060', '2023-02-22', 74, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', '', '', '999.00', '0.00', '999.00', '0.00', '999.00', '0.00', '999.00', 0, '', '', 0, '', 0, '2023-05-23', 90, '0.00', '0.00', '999.00', 'a'),
(54, 'IN/2023/061', '2023-02-06', 74, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', '', '', '2619.00', '143.64', '2636.64', '126.00', '2493.00', '0.01', '2636.65', 1, '', '', 0, '', 0, '2023-02-21', 15, '0.00', '0.00', '2636.65', 'a'),
(55, 'IN/2023/062', '2023-02-15', 61, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', '', 'jumaatengineering@gmail.com', '6000.00', '0.00', '6000.00', '0.00', '6000.00', '0.00', '6000.00', 0, '', '', 0, '', 0, '2023-03-02', 15, '0.00', '0.00', '6000.00', 'a'),
(56, 'IN/2023/063', '2023-02-15', 8, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'Hariharan', 'ayur_90@gmail.com', '6090.00', '0.00', '6090.00', '0.00', '6090.00', '0.00', '6090.00', 0, '', '', 0, '', 0, '2023-03-02', 15, '0.00', '0.00', '350.00', 'a'),
(57, 'IN/2023/064', '2023-01-01', 61, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', '', 'jumaatengineering@gmail.com', '3150.00', '0.00', '3150.00', '0.00', '3150.00', '0.00', '3150.00', 0, '', '', 0, '', 0, '2023-01-16', 15, '0.00', '0.00', '0.00', 'a'),
(58, 'IN/2023/065', '2023-01-01', 71, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', '', '', '888.00', '0.00', '888.00', '0.00', '888.00', '0.00', '888.00', 0, '', '', 0, '', 0, '2023-01-16', 15, '0.00', '0.00', '888.00', 'a'),
(59, 'IN/2023/066', '2023-01-01', 81, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', '', '', '999.00', '0.00', '999.00', '0.00', '999.00', '0.00', '999.00', 0, '', '', 0, '', 0, '2023-01-16', 15, '0.00', '0.00', '0.00', 'a'),
(60, 'IN/2023/067', '2023-01-18', 76, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', '', '3136.00', '0.00', '3136.00', '0.00', '3136.00', '0.00', '3136.00', 0, '', '', 0, '', 0, '2023-02-02', 15, '0.00', '0.00', '0.00', 'a'),
(61, 'IN/2023/068', '2023-02-15', 76, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', '', '5062.75', '0.00', '5062.75', '0.00', '5062.75', '0.00', '5062.75', 0, '', 'QUO/2023/006', 6, '', 0, '2023-03-02', 15, '0.00', '0.00', '0.00', 'a'),
(62, 'IN/2023/069', '2023-02-18', 87, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'MR TIMOTHY', 'timothy@rainehome.com.my', '8454.03', '1702.30', '10139.83', '16.50', '8437.53', '0.00', '10139.83', 0, '', 'QUO/2023/008', 8, 'DO/2023/008', 8, '2023-03-05', 15, '0.00', '0.00', '0.00', 'a'),
(63, 'IN/2023/070', '2023-02-18', 51, 'To use fully equipped pick up van with usage of water and necessary materials to desludge', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '8454.03', '1702.30', '10139.83', '16.50', '8437.53', '0.00', '10139.83', 0, '', 'QUO/2023/009', 9, '', 0, '2023-03-05', 15, '0.00', '0.00', '10139.83', 'a'),
(64, 'IN/2023/071', '2023-02-22', 67, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'Mr Ramachandrean', 'caresome_90@gmail.com', '2357.25', '77.72', '2330.46', '104.50', '2252.74', '-0.01', '2330.45', 1, '', '', 0, '', 0, '2023-03-09', 15, '0.00', '0.00', '0.00', 'a'),
(65, 'IN/2023/072', '2023-02-23', 71, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', '', '', '2902.20', '366.11', '3152.91', '115.40', '2786.80', '-0.01', '3152.90', 1, '', '', 0, 'DO/2023/010', 10, '2023-03-10', 15, '0.00', '0.00', '3152.90', 'a'),
(66, 'IN/2023/075', '2023-09-09', 51, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '7000.00', '0.00', '7000.00', '0.00', '7000.00', '0.00', '7000.00', 0, '', 'QUO/2023/011', 11, '', 0, '2023-09-24', 15, '0.00', '0.00', '7000.00', 'a'),
(67, 'IN/2023/076', '2023-02-26', 51, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '18061.50', '275.91', '18337.41', '0.00', '18061.50', '-0.01', '18337.40', 1, '', 'QUO/2023/012', 12, 'DO/2023/016', 11, '2023-03-13', 15, '0.00', '0.00', '18337.40', 'a'),
(69, 'IN/2023/077', '2023-02-28', 65, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0, '<p>Thank you for considering our pest control services. We understand that pests can be a nuisance and can potentially cause harm to your property, health, and well-being. We are committed to providing effective and safe pest control solutions to help you eliminate pests from your home or business.</p>', '', 0, '', 0, '2023-03-15', 15, '0.00', '0.00', '0.00', 'c'),
(70, 'IN/2023/100', '2023-03-01', 65, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', '', '', '2890.00', '257.35', '3075.35', '72.00', '2818.00', '0.00', '3075.35', 0, '<p>Thank you for considering our pest control services. We understand that pests can be a nuisance and can potentially cause harm to your property, health, and well-being. We are committed to providing effective and safe pest control solutions to help you eliminate pests from your home or business.</p>', 'QUO/2023/017', 17, '', 0, '2023-03-16', 15, '0.00', '0.00', '3075.35', 'a'),
(71, 'IN/2023/101', '2023-03-12', 51, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '25095.22', '0.00', '25095.22', '0.00', '25095.22', '0.00', '25095.22', 0, '', '', 0, '', 0, '2023-03-27', 15, '0.00', '0.00', '0.00', 'a'),
(72, 'IN/2023/102', '2023-03-12', 51, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'Mr Balvinder Singh', '', '646.47', '194.17', '796.14', '44.50', '601.97', '0.01', '796.15', 1, '', '', 0, 'DO/2023/019', 14, '2023-03-27', 15, '6407.90', '0.00', '0.00', 'a'),
(73, 'IN/2023/103', '2023-03-12', 74, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', '', '', '646.47', '194.17', '796.14', '44.50', '601.97', '0.01', '796.15', 1, '', '', 0, '', 0, '2023-03-27', 15, '0.00', '0.00', '0.00', 'a'),
(74, 'IN/2023/104', '2023-03-12', 51, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '656.96', '194.17', '806.63', '44.50', '612.46', '0.02', '806.65', 1, '', '', 0, '', 0, '2023-03-27', 15, '0.00', '0.00', '0.00', 'a'),
(75, 'IN/2023/105', '2023-03-12', 74, '', '', '<p><strong>Invoice Terms</strong></p><ul><li>All payment paid to the company BER SEWERAGE SOLUTION (M) SDN BHD and its correct account.</li><li>a.) Account No : 876009887 <strong>CIMB</strong></li></ul>', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0, '', '', 0, '', 0, '2023-03-27', 15, '0.00', '0.00', '0.00', 'a');

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
) ENGINE=InnoDB AUTO_INCREMENT=767 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbinvoicedetail`
--

INSERT INTO `tbinvoicedetail` (`invoiceDetail_id`, `invoiceDetail_invoiceID`, `invoiceDetail_no1`, `invoiceDetail_no2`, `invoiceDetail_no3`, `invoiceDetail_no4`, `invoiceDetail_bold`, `invoiceDetail_sortID`, `invoiceDetail_no5`, `invoiceDetail_rowTotal`, `invoiceDetail_taxRateID`, `invoiceDetail_taxPercent`, `invoiceDetail_taxTotal`, `invoiceDetail_rowGrandTotal`, `invoiceDetail_discountPercent`, `invoiceDetail_discountAmount`, `invoiceDetail_rowTotalAfterDiscount`) VALUES
(1, 1, '', '', '0.00', '', 0, 1, '1000.00', '1000.00', 1, '0.00', '0.00', '1000.00', '0.00', '0.00', '1000.00'),
(2, 1, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(3, 1, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(4, 1, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(5, 1, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(6, 2, '', '', '0.00', '', 0, 1, '500.00', '500.00', 1, '0.00', '0.00', '500.00', '0.00', '0.00', '500.00'),
(7, 2, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(8, 2, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(9, 2, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(10, 2, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(11, 3, '', '', '0.00', '', 0, 1, '6500.00', '6500.00', 1, '0.00', '0.00', '6500.00', '0.00', '0.00', '6500.00'),
(12, 3, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(13, 3, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(14, 3, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(15, 3, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(16, 4, '', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 0, 1, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(17, 4, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '2.00', '', 0, 2, '450.00', '900.00', 1, '0.00', '0.00', '900.00', '0.00', '0.00', '900.00'),
(18, 4, '', 'NOKIA CHARGER TYPE CARBON 4598BK2', '5.00', 'UNIT', 0, 3, '450.00', '2250.00', 1, '0.00', '0.00', '2250.00', '0.00', '0.00', '2250.00'),
(19, 4, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(20, 4, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(21, 5, '', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 0, 1, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(22, 5, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '2.00', '', 0, 2, '450.00', '900.00', 1, '0.00', '0.00', '900.00', '0.00', '0.00', '900.00'),
(23, 5, '', 'NOKIA CHARGER TYPE CARBON 4598BK2', '5.00', 'UNIT', 0, 3, '450.00', '2250.00', 1, '0.00', '0.00', '2250.00', '0.00', '0.00', '2250.00'),
(24, 5, '', 'Desludging Tanker 10 cubic metres (Cina Made)', '0.00', 'units', 0, 4, '99.00', '99.00', 1, '0.00', '0.00', '99.00', '0.00', '0.00', '99.00'),
(25, 5, '', 'Teak Wood furniture sofa chair', '0.00', '', 0, 5, '66.00', '66.00', 2, '6.00', '3.96', '69.96', '0.00', '0.00', '66.00'),
(31, 7, '', '', '0.00', '', 0, 1, '17000.00', '17000.00', 1, '0.00', '0.00', '17000.00', '0.00', '0.00', '17000.00'),
(32, 7, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(33, 7, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(34, 7, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(35, 7, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(41, 9, '', '', '0.00', '', 0, 1, '5000.00', '5000.00', 1, '0.00', '0.00', '5000.00', '0.00', '0.00', '5000.00'),
(42, 9, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(43, 9, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(44, 9, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(45, 9, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(46, 10, '', '', '0.00', '', 0, 1, '1000.00', '1000.00', 1, '0.00', '0.00', '1000.00', '0.00', '0.00', '1000.00'),
(47, 10, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(48, 10, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(49, 10, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(50, 10, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(51, 11, '', '', '0.00', '', 0, 1, '5600.00', '5600.00', 1, '0.00', '0.00', '5600.00', '0.00', '0.00', '5600.00'),
(52, 11, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(53, 11, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(54, 11, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(55, 11, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(56, 12, '', '', '3.00', '', 0, 1, '34.00', '102.00', 4, '34.00', '34.68', '136.68', '0.00', '0.00', '102.00'),
(57, 12, '', 'Chicken Eggs \r\nMount Road Poulty Farm', '34.00', '', 0, 2, '77.85', '2646.90', 4, '34.00', '899.95', '3546.85', '0.00', '0.00', '2646.90'),
(58, 12, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(59, 12, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(60, 12, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(66, 14, '', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 0, 1, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(67, 14, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '2.00', '', 0, 2, '450.00', '900.00', 1, '0.00', '0.00', '900.00', '0.00', '0.00', '900.00'),
(68, 14, '', 'NOKIA CHARGER TYPE CARBON 4598BK2', '5.00', 'UNIT', 0, 3, '450.00', '2250.00', 1, '0.00', '0.00', '2250.00', '0.00', '0.00', '2250.00'),
(69, 14, '', 'TOP RADIATOR HOSE ORIGINAL', '0.00', '', 0, 4, '450.00', '450.00', 1, '0.00', '0.00', '450.00', '0.00', '0.00', '450.00'),
(70, 14, '', 'AUTOMATIC TRANSMISSION FLUID', '0.00', 'unit', 0, 5, '102.50', '102.50', 1, '0.00', '0.00', '102.50', '0.00', '0.00', '102.50'),
(144, 16, '', 'DESLUDGING SERVICES FOR SLUDGE & OTHER RELATED WORKS', '0.00', '', 1, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(145, 16, '1.', 'TO USE 4.5m3 DESLDUDGING TANKER TO VACUUM AND REMOVE SLUDGE / WASTE WATER INCLUDING DISPOSAL. 20/10/2022', '3.00', 'TRIPS', 0, 2, '450.00', '1350.00', 1, '0.00', '0.00', '1350.00', '0.00', '0.00', '1350.00'),
(146, 16, '2.', 'TO USE 10.00m3 DESLDUDGING TANKER TO VACUUM AND REMOVE SLUDGE / WASTE WATER INCLUDING DISPOSAL  20/10/2022', '2.00', 'TRIPS', 0, 3, '750.00', '1500.00', 1, '0.00', '0.00', '1500.00', '0.00', '0.00', '1500.00'),
(147, 16, '3.', 'REWINDING AND SERVICING WASTE WATER PUMP 16/10/2022', '0.00', '', 0, 4, '3450.00', '3450.00', 1, '0.00', '0.00', '3450.00', '0.00', '0.00', '3450.00'),
(148, 16, '4.', 'ELECTRICAL WIRING WORKS FROM PUMP TO THE ELECTRICAL PANEL BOX.', '0.00', '', 0, 5, '120.00', '120.00', 1, '0.00', '0.00', '120.00', '0.00', '0.00', '120.00'),
(149, 16, '5.', 'TO USE HIGH PRESSURE JETTER TRUCK MACHINE TO CLEAN AND BREAK ALL BLOCKAGES WITHIN THE SEWERAGE PIPELINES.', '0.00', '', 0, 6, '1800.00', '1800.00', 1, '0.00', '0.00', '1800.00', '0.00', '0.00', '1800.00'),
(150, 16, '', 'LABOUR CHARGES', '0.00', '', 1, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(151, 16, '1.', 'TO USE DESLUDGING TANKER TO VACUUM AND REMOVE ALL SLUDGE / WASTE WATER TO ENABLE THE SUBMERSIBLE PUMP AND SENSOR TO BE INSTALLED.', '2.00', 'UNITS', 0, 8, '500.00', '1000.00', 4, '34.00', '289.00', '1139.00', '15.00', '150.00', '850.00'),
(152, 16, '2.', 'AUTOMATIC TRANSMISSION FLUID', '0.00', 'unit', 0, 9, '102.50', '102.50', 1, '0.00', '0.00', '102.50', '0.00', '0.00', '102.50'),
(153, 16, '3.', 'LABOUR TO REPLACE PARTS & SERVICE MOTOROLLA HANDPHONE MODEL X-9', '0.00', '', 0, 10, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(154, 17, '', '', '0.00', '', 0, 1, '10000.00', '10000.00', 1, '0.00', '0.00', '10000.00', '0.00', '0.00', '10000.00'),
(155, 17, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(156, 17, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(157, 17, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(158, 17, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(164, 19, '', '', '0.00', '', 0, 1, '1000.00', '1000.00', 1, '0.00', '0.00', '1000.00', '0.00', '0.00', '1000.00'),
(165, 19, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(166, 19, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(167, 19, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(168, 19, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(169, 20, '', '', '0.00', '', 0, 1, '5000.00', '5000.00', 1, '0.00', '0.00', '5000.00', '0.00', '0.00', '5000.00'),
(170, 20, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(171, 20, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(172, 20, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(173, 20, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(174, 21, '', '', '0.00', '', 0, 1, '15000.00', '15000.00', 1, '0.00', '0.00', '15000.00', '0.00', '0.00', '15000.00'),
(175, 21, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(176, 21, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(177, 21, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(178, 21, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(184, 23, '', '', '45.00', '', 0, 1, '600.00', '27000.00', 2, '6.00', '1620.00', '28620.00', '0.00', '0.00', '27000.00'),
(185, 23, '', '', '6.00', '', 0, 2, '900.00', '5400.00', 5, '8.00', '432.00', '5832.00', '0.00', '0.00', '5400.00'),
(186, 23, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(187, 23, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(188, 23, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(189, 22, '', '', '5.00', '', 0, 1, '1000.00', '5000.00', 2, '6.00', '300.00', '5300.00', '0.00', '0.00', '5000.00'),
(190, 22, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(191, 22, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(192, 22, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(193, 22, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(194, 8, '', '', '0.00', '', 0, 1, '7000.00', '7000.00', 3, '10.00', '560.00', '6160.00', '20.00', '1400.00', '5600.00'),
(195, 8, '', '', '0.00', '', 0, 2, '40.28', '40.28', 4, '34.00', '13.70', '53.98', '0.00', '0.00', '40.28'),
(196, 8, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(197, 8, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(198, 8, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(204, 25, '', '', '45.00', '', 0, 1, '789.00', '35505.00', 2, '6.00', '2130.30', '37635.30', '0.00', '0.00', '35505.00'),
(205, 25, '', '', '0.00', '', 0, 2, '789.00', '789.00', 4, '34.00', '268.26', '1057.26', '0.00', '0.00', '789.00'),
(206, 25, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(207, 25, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(208, 25, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(209, 24, '', '', '45.00', '', 0, 1, '789.00', '35505.00', 2, '6.00', '2130.30', '37635.30', '0.00', '0.00', '35505.00'),
(210, 24, '', '', '0.00', '', 0, 2, '789.00', '789.00', 4, '34.00', '268.26', '1057.26', '0.00', '0.00', '789.00'),
(211, 24, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(212, 24, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(213, 24, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(220, 26, '', '', '0.09', '', 0, 1, '678.00', '61.02', 4, '34.00', '20.75', '81.77', '0.00', '0.00', '61.02'),
(221, 26, '', '', '0.00', '', 0, 2, '900.00', '900.00', 1, '0.00', '0.00', '900.00', '0.00', '0.00', '900.00'),
(222, 26, '', '', '0.00', '', 0, 3, '0.00', '0.00', 4, '34.00', '0.00', '0.00', '5.00', '0.00', '0.00'),
(223, 26, '', '', '56.00', '', 0, 4, '0.54', '30.24', 4, '34.00', '10.28', '40.52', '0.00', '0.00', '30.24'),
(224, 26, '', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 0, 5, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(225, 26, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '12.00', '', 0, 6, '450.00', '5400.00', 4, '34.00', '1744.20', '6874.20', '5.00', '270.00', '5130.00'),
(226, 26, '', '', '5.00', '', 0, 7, '500.00', '2500.00', 1, '0.00', '0.00', '2500.00', '0.00', '0.00', '2500.00'),
(268, 28, '', 'AUTOMATIC TRANSMISSION FLUID', '0.09', 'unit', 1, 1, '102.50', '9.22', 4, '34.00', '3.13', '12.35', '0.00', '0.00', '9.22'),
(269, 28, '1.', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '0.00', '', 0, 2, '450.00', '450.00', 1, '0.00', '0.00', '450.00', '0.00', '0.00', '450.00'),
(270, 28, '2.', 'MOTOROLLA HANDPHONE MODEL X-9', '0.00', 'unit', 0, 3, '5006.75', '5006.75', 4, '34.00', '1617.18', '6373.59', '5.00', '250.34', '4756.41'),
(271, 28, '', '', '56.00', '', 0, 4, '0.54', '30.24', 4, '34.00', '10.28', '40.52', '0.00', '0.00', '30.24'),
(272, 28, '', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 1, 5, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(273, 28, '1.', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '12.00', '', 0, 6, '450.00', '5400.00', 4, '34.00', '1744.20', '6874.20', '5.00', '270.00', '5130.00'),
(274, 28, '2.', 'TOP RADIATOR HOSE ORIGINAL', '5.00', '', 0, 7, '450.00', '2250.00', 1, '0.00', '0.00', '2250.00', '0.00', '0.00', '2250.00'),
(275, 28, '3.', 'Jetting Works and Clear blockages with rodder machine', '0.00', 'unit', 0, 8, '6.00', '6.00', 1, '0.00', '0.00', '6.00', '0.00', '0.00', '6.00'),
(276, 28, '4.', 'Desludging Tanker 10 cubic metres (Cina Made)', '0.00', 'units', 0, 9, '99.00', '99.00', 1, '0.00', '0.00', '99.00', '0.00', '0.00', '99.00'),
(277, 28, '5.', 'Chicken Eggs Mount Road Poulty Farm', '0.00', '', 0, 10, '77.85', '77.85', 1, '0.00', '0.00', '77.85', '0.00', '0.00', '77.85'),
(292, 27, '', '', '45.00', '', 0, 1, '789.02', '35505.90', 2, '6.00', '2130.35', '37636.25', '0.00', '0.00', '35505.90'),
(293, 27, '', '', '0.00', '', 0, 2, '789.01', '789.01', 4, '34.00', '268.26', '1057.27', '0.00', '0.00', '789.01'),
(294, 27, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(295, 27, '', '', '0.00', '', 0, 4, '568.00', '568.00', 6, '1.50', '8.52', '576.52', '0.00', '0.00', '568.00'),
(296, 27, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(297, 27, '', '', '0.00', '', 0, 6, '800.00', '800.00', 6, '1.50', '12.00', '812.00', '0.00', '0.00', '800.00'),
(298, 27, '', '', '0.00', '', 0, 7, '760.50', '760.50', 3, '10.00', '69.97', '769.63', '8.00', '60.84', '699.66'),
(299, 13, '1', 'AUTOMATIC TRANSMISSION FLUID', '0.00', 'unit', 1, 1, '102.50', '102.50', 4, '34.00', '34.85', '137.35', '0.00', '0.00', '102.50'),
(300, 13, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '8.00', 'pcs', 0, 2, '450.00', '3600.00', 1, '0.00', '0.00', '3600.00', '0.00', '0.00', '3600.00'),
(301, 13, '1', 'NOKIA CHARGER TYPE CARBON 4598BK', '0.00', 'UNIT', 1, 3, '59.00', '59.00', 1, '0.00', '0.00', '59.00', '0.00', '0.00', '59.00'),
(302, 13, '', 'Screw made in taiwan 67 size', '2.00', '', 0, 4, '900.00', '1800.00', 5, '8.00', '139.68', '1885.68', '3.00', '54.00', '1746.00'),
(303, 13, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(309, 18, '', '', '0.00', '', 0, 1, '1000.00', '1000.00', 1, '0.00', '0.00', '1000.00', '0.00', '0.00', '1000.00'),
(310, 18, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(311, 18, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(312, 18, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(313, 18, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(330, 29, '', 'DESLUDGING SERVICES FOR SLUDGE & OTHER RELATED WORKS', '0.00', '', 1, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(331, 29, '1.', 'TO USE 4.5m3 DESLDUDGING TANKER TO VACUUM AND REMOVE SLUDGE / WASTE WATER INCLUDING DISPOSAL. 20/10/2022', '3.00', 'TRIPS', 0, 2, '450.00', '1350.00', 1, '0.00', '0.00', '1350.00', '0.00', '0.00', '1350.00'),
(332, 29, '2.', 'TO USE 10.00m3 DESLDUDGING TANKER TO VACUUM AND REMOVE SLUDGE / WASTE WATER INCLUDING DISPOSAL  20/10/2022', '2.00', 'TRIPS', 0, 3, '750.00', '1500.00', 1, '0.00', '0.00', '1500.00', '0.00', '0.00', '1500.00'),
(333, 29, '3.', 'REWINDING AND SERVICING WASTE WATER PUMP 16/10/2022', '0.00', '', 0, 4, '3450.00', '3450.00', 1, '0.00', '0.00', '3450.00', '0.00', '0.00', '3450.00'),
(334, 29, '4.', 'ELECTRICAL WIRING WORKS FROM PUMP TO THE ELECTRICAL PANEL BOX.', '0.00', '', 0, 5, '120.00', '120.00', 1, '0.00', '0.00', '120.00', '0.00', '0.00', '120.00'),
(335, 29, '5.', 'TO USE HIGH PRESSURE JETTER TRUCK MACHINE TO CLEAN AND BREAK ALL BLOCKAGES WITHIN THE SEWERAGE PIPELINES.', '0.00', '', 0, 6, '1800.00', '1800.00', 1, '0.00', '0.00', '1800.00', '0.00', '0.00', '1800.00'),
(336, 29, '', 'LABOUR CHARGES', '0.00', '', 1, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(337, 29, '1.', 'TO USE DESLUDGING TANKER TO VACUUM AND REMOVE ALL SLUDGE / WASTE WATER TO ENABLE THE SUBMERSIBLE PUMP AND SENSOR TO BE INSTALLED.', '2.00', 'UNITS', 0, 8, '500.00', '1000.00', 1, '0.00', '0.00', '850.00', '15.00', '150.00', '850.00'),
(338, 30, '', 'DESLUDGING SERVICES FOR SLUDGE & OTHER RELATED WORKS', '0.00', '', 1, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(339, 30, '1.', 'TO USE 4.5m3 DESLDUDGING TANKER TO VACUUM AND REMOVE SLUDGE / WASTE WATER INCLUDING DISPOSAL. 20/10/2022', '3.00', 'TRIPS', 0, 2, '450.00', '1350.00', 1, '0.00', '0.00', '1350.00', '0.00', '0.00', '1350.00'),
(340, 30, '2.', 'TO USE 10.00m3 DESLDUDGING TANKER TO VACUUM AND REMOVE SLUDGE / WASTE WATER INCLUDING DISPOSAL  20/10/2022', '2.00', 'TRIPS', 0, 3, '750.00', '1500.00', 1, '0.00', '0.00', '1500.00', '0.00', '0.00', '1500.00'),
(341, 30, '3.', 'REWINDING AND SERVICING WASTE WATER PUMP 16/10/2022', '0.00', '', 0, 4, '3450.00', '3450.00', 1, '0.00', '0.00', '3450.00', '0.00', '0.00', '3450.00'),
(342, 30, '4.', 'ELECTRICAL WIRING WORKS FROM PUMP TO THE ELECTRICAL PANEL BOX.', '0.00', '', 0, 5, '120.00', '120.00', 1, '0.00', '0.00', '120.00', '0.00', '0.00', '120.00'),
(343, 30, '5.', 'TO USE HIGH PRESSURE JETTER TRUCK MACHINE TO CLEAN AND BREAK ALL BLOCKAGES WITHIN THE SEWERAGE PIPELINES.', '0.00', '', 0, 6, '1800.00', '1800.00', 1, '0.00', '0.00', '1800.00', '0.00', '0.00', '1800.00'),
(344, 30, '', 'LABOUR CHARGES', '0.00', '', 1, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(345, 30, '1.', 'TO USE DESLUDGING TANKER TO VACUUM AND REMOVE ALL SLUDGE / WASTE WATER TO ENABLE THE SUBMERSIBLE PUMP AND SENSOR TO BE INSTALLED.', '2.00', 'UNITS', 0, 8, '500.00', '1000.00', 1, '0.00', '0.00', '850.00', '15.00', '150.00', '850.00'),
(375, 32, '', 'DESLUDGING SERVICES FOR SLUDGE & OTHER RELATED WORKS', '90.00', '', 1, 1, '89.00', '8010.00', 3, '10.00', '801.00', '8811.00', '0.00', '0.00', '8010.00'),
(376, 32, '1.', 'TO USE 4.5m3 DESLDUDGING TANKER TO VACUUM AND REMOVE SLUDGE / WASTE WATER INCLUDING DISPOSAL. 20/10/2022', '3.00', 'TRIPS', 0, 2, '450.00', '1350.00', 6, '1.50', '20.25', '1370.25', '0.00', '0.00', '1350.00'),
(377, 32, '2.', 'TO USE 10.00m3 DESLDUDGING TANKER TO VACUUM AND REMOVE SLUDGE / WASTE WATER INCLUDING DISPOSAL  20/10/2022', '2.00', 'TRIPS', 0, 3, '750.00', '1500.00', 1, '0.00', '0.00', '1500.00', '0.00', '0.00', '1500.00'),
(378, 32, '3.', 'REWINDING AND SERVICING WASTE WATER PUMP 16/10/2022', '0.00', '', 0, 4, '3450.00', '3450.00', 1, '0.00', '0.00', '3450.00', '0.00', '0.00', '3450.00'),
(379, 32, '4.', 'ELECTRICAL WIRING WORKS FROM PUMP TO THE ELECTRICAL PANEL BOX.', '0.00', '', 0, 5, '120.00', '120.00', 1, '0.00', '0.00', '120.00', '0.00', '0.00', '120.00'),
(380, 32, '5.', 'TO USE HIGH PRESSURE JETTER TRUCK MACHINE TO CLEAN AND BREAK ALL BLOCKAGES WITHIN THE SEWERAGE PIPELINES.', '7.00', '', 0, 6, '7890.00', '55230.00', 6, '1.50', '795.31', '53816.11', '4.00', '2209.20', '53020.80'),
(381, 32, '', 'LABOUR CHARGES', '0.00', '', 1, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(382, 32, '1.', 'TO USE DESLUDGING TANKER TO VACUUM AND REMOVE ALL SLUDGE / WASTE WATER TO ENABLE THE SUBMERSIBLE PUMP AND SENSOR TO BE INSTALLED.', '2.00', 'UNITS', 0, 8, '500.00', '1000.00', 1, '0.00', '0.00', '850.00', '15.00', '150.00', '850.00'),
(383, 33, '', 'DESLUDGING SERVICES FOR SLUDGE & OTHER RELATED WORKS', '0.00', '', 1, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(384, 33, '1.', 'TO USE 4.5m3 DESLDUDGING TANKER TO VACUUM AND REMOVE SLUDGE / WASTE WATER INCLUDING DISPOSAL. 20/10/2022', '3.00', 'TRIPS', 0, 2, '450.00', '1350.00', 4, '34.00', '459.00', '1809.00', '0.00', '0.00', '1350.00'),
(385, 33, '2.', 'TO USE 10.00m3 DESLDUDGING TANKER TO VACUUM AND REMOVE SLUDGE / WASTE WATER INCLUDING DISPOSAL  20/10/2022', '2.00', 'TRIPS', 0, 3, '750.00', '1500.00', 1, '0.00', '0.00', '1500.00', '0.00', '0.00', '1500.00'),
(386, 33, '3.', 'REWINDING AND SERVICING WASTE WATER PUMP 16/10/2022', '0.00', '', 0, 4, '3450.00', '3450.00', 1, '0.00', '0.00', '3450.00', '0.00', '0.00', '3450.00'),
(387, 33, '4.', 'ELECTRICAL WIRING WORKS FROM PUMP TO THE ELECTRICAL PANEL BOX.', '0.00', '', 0, 5, '120.00', '120.00', 4, '34.00', '39.98', '157.58', '2.00', '2.40', '117.60'),
(388, 33, '5.', 'TO USE HIGH PRESSURE JETTER TRUCK MACHINE TO CLEAN AND BREAK ALL BLOCKAGES WITHIN THE SEWERAGE PIPELINES.', '0.00', '', 0, 6, '1800.00', '1800.00', 1, '0.00', '0.00', '1800.00', '0.00', '0.00', '1800.00'),
(389, 33, '', 'LABOUR CHARGES', '0.00', '', 1, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(390, 33, '1.', 'TO USE DESLUDGING TANKER TO VACUUM AND REMOVE ALL SLUDGE / WASTE WATER TO ENABLE THE SUBMERSIBLE PUMP AND SENSOR TO BE INSTALLED.', '2.00', 'UNITS', 0, 8, '500.00', '1000.00', 2, '6.00', '51.00', '901.00', '15.00', '150.00', '850.00'),
(391, 34, '', 'DESLUDGING SERVICES FOR SLUDGE & OTHER RELATED WORKS', '0.00', '', 1, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(392, 34, '1.', 'TO USE 4.5m3 DESLDUDGING TANKER TO VACUUM AND REMOVE SLUDGE / WASTE WATER INCLUDING DISPOSAL. 20/10/2022', '3.00', 'TRIPS', 0, 2, '450.00', '1350.00', 4, '34.00', '459.00', '1809.00', '0.00', '0.00', '1350.00'),
(393, 34, '2.', 'TO USE 10.00m3 DESLDUDGING TANKER TO VACUUM AND REMOVE SLUDGE / WASTE WATER INCLUDING DISPOSAL  20/10/2022', '2.00', 'TRIPS', 0, 3, '750.00', '1500.00', 1, '0.00', '0.00', '1500.00', '0.00', '0.00', '1500.00'),
(394, 34, '3.', 'REWINDING AND SERVICING WASTE WATER PUMP 16/10/2022', '0.00', '', 0, 4, '3450.00', '3450.00', 1, '0.00', '0.00', '3450.00', '0.00', '0.00', '3450.00'),
(395, 34, '4.', 'ELECTRICAL WIRING WORKS FROM PUMP TO THE ELECTRICAL PANEL BOX.', '0.00', '', 0, 5, '120.00', '120.00', 4, '34.00', '39.98', '157.58', '2.00', '2.40', '117.60'),
(396, 34, '5.', 'TO USE HIGH PRESSURE JETTER TRUCK MACHINE TO CLEAN AND BREAK ALL BLOCKAGES WITHIN THE SEWERAGE PIPELINES.', '0.00', '', 0, 6, '1800.00', '1800.00', 1, '0.00', '0.00', '1800.00', '0.00', '0.00', '1800.00'),
(397, 34, '', 'LABOUR CHARGES', '0.00', '', 1, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(398, 34, '1.', 'TO USE DESLUDGING TANKER TO VACUUM AND REMOVE ALL SLUDGE / WASTE WATER TO ENABLE THE SUBMERSIBLE PUMP AND SENSOR TO BE INSTALLED.', '2.00', 'UNITS', 0, 8, '500.00', '1000.00', 2, '6.00', '51.00', '901.00', '15.00', '150.00', '850.00'),
(399, 35, '', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 0, 1, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(400, 35, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '2.00', '', 0, 2, '450.00', '900.00', 1, '0.00', '0.00', '900.00', '0.00', '0.00', '900.00'),
(401, 35, '', 'NOKIA CHARGER TYPE CARBON 4598BK2', '5.00', 'UNIT', 0, 3, '450.00', '2250.00', 1, '0.00', '0.00', '2250.00', '0.00', '0.00', '2250.00'),
(402, 35, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(403, 35, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '0.00', '', 0, 5, '450.00', '450.00', 1, '0.00', '0.00', '450.00', '0.00', '0.00', '450.00'),
(404, 35, '', '', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(405, 35, '', '', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(406, 36, '', '', '0.00', '', 0, 1, '8900.00', '8900.00', 6, '1.50', '133.50', '9033.50', '0.00', '0.00', '8900.00'),
(407, 36, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(408, 36, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(409, 36, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(410, 36, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(436, 40, '', '', '0.00', '', 0, 1, '8000.00', '8000.00', 1, '0.00', '0.00', '8000.00', '0.00', '0.00', '8000.00'),
(437, 40, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(438, 40, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(439, 40, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(440, 40, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(441, 41, '1', 'A4 Bahasa Malaysia Exam papers9', '4.00', 'pcs', 0, 1, '6.49', '25.96', 2, '6.00', '1.46', '25.86', '6.00', '1.56', '24.40'),
(442, 41, '2', 'Desludging Tanker 10 cubic metres (Cina Made)', '5.00', 'units', 0, 2, '99.00', '495.00', 1, '0.00', '0.00', '495.00', '0.00', '0.00', '495.00'),
(443, 41, '3', 'LABOUR TO REPLACE PARTS & SERVICE', '2.00', '', 0, 3, '56.00', '112.00', 1, '0.00', '0.00', '105.28', '6.00', '6.72', '105.28'),
(444, 41, '4', 'MOTOROLLA HANDPHONE MODEL X-9', '2.00', 'unit', 0, 4, '5006.75', '10013.50', 1, '0.00', '0.00', '10013.50', '0.00', '0.00', '10013.50'),
(445, 41, '5', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '1.00', '', 0, 5, '450.00', '450.00', 1, '0.00', '0.00', '450.00', '0.00', '0.00', '450.00'),
(446, 41, '6', 'TOP RADIATOR HOSE ORIGINAL', '1.00', '', 0, 6, '450.00', '450.00', 3, '10.00', '45.00', '495.00', '0.00', '0.00', '450.00'),
(447, 41, '7', 'Jetting Works and Clear blockages with rodder machine', '14.00', 'unit', 0, 7, '6.00', '84.00', 6, '1.50', '1.18', '80.14', '6.00', '5.04', '78.96'),
(448, 41, '8', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 0, 8, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(449, 42, '', 'DESLUDGING SERVICES FOR SLUDGE & OTHER RELATED WORKS', '0.00', '', 1, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(450, 42, '1.', 'TO USE 4.5m3 DESLDUDGING TANKER TO VACUUM AND REMOVE SLUDGE / WASTE WATER INCLUDING DISPOSAL. 20/10/2022', '3.00', 'TRIPS', 0, 2, '450.00', '1350.00', 1, '0.00', '0.00', '1350.00', '0.00', '0.00', '1350.00'),
(451, 42, '2.', 'TO USE 10.00m3 DESLDUDGING TANKER TO VACUUM AND REMOVE SLUDGE / WASTE WATER INCLUDING DISPOSAL  20/10/2022', '2.00', 'TRIPS', 0, 3, '750.00', '1500.00', 1, '0.00', '0.00', '1500.00', '0.00', '0.00', '1500.00'),
(452, 42, '3.', 'REWINDING AND SERVICING WASTE WATER PUMP 16/10/2022', '0.00', '', 0, 4, '3450.00', '3450.00', 1, '0.00', '0.00', '3450.00', '0.00', '0.00', '3450.00'),
(453, 42, '4.', 'ELECTRICAL WIRING WORKS FROM PUMP TO THE ELECTRICAL PANEL BOX.', '0.00', '', 0, 5, '120.00', '120.00', 1, '0.00', '0.00', '120.00', '0.00', '0.00', '120.00'),
(454, 42, '5.', 'TO USE HIGH PRESSURE JETTER TRUCK MACHINE TO CLEAN AND BREAK ALL BLOCKAGES WITHIN THE SEWERAGE PIPELINES.', '0.00', '', 0, 6, '1800.00', '1800.00', 1, '0.00', '0.00', '1800.00', '0.00', '0.00', '1800.00'),
(455, 42, '', 'LABOUR CHARGES', '0.00', '', 1, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(456, 42, '1.', 'TO USE DESLUDGING TANKER TO VACUUM AND REMOVE ALL SLUDGE / WASTE WATER TO ENABLE THE SUBMERSIBLE PUMP AND SENSOR TO BE INSTALLED.', '2.00', 'UNITS', 0, 8, '500.00', '1000.00', 1, '0.00', '0.00', '850.00', '15.00', '150.00', '850.00'),
(457, 43, '', '', '45.00', '', 0, 1, '789.00', '35505.00', 2, '6.00', '2130.30', '37635.30', '0.00', '0.00', '35505.00'),
(458, 43, '', '', '0.00', '', 0, 2, '789.00', '789.00', 4, '34.00', '268.26', '1057.26', '0.00', '0.00', '789.00'),
(459, 43, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(460, 43, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(461, 43, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(462, 44, '1', 'A4 Bahasa Malaysia Exam papers9', '4.00', 'pcs', 0, 1, '6.49', '25.96', 2, '6.00', '1.46', '25.86', '6.00', '1.56', '24.40'),
(463, 44, '2', 'Desludging Tanker 10 cubic metres (Cina Made)', '5.00', 'units', 0, 2, '99.00', '495.00', 1, '0.00', '0.00', '495.00', '0.00', '0.00', '495.00'),
(464, 44, '3', 'LABOUR TO REPLACE PARTS & SERVICE', '2.00', '', 0, 3, '56.00', '112.00', 1, '0.00', '0.00', '105.28', '6.00', '6.72', '105.28'),
(465, 44, '4', 'MOTOROLLA HANDPHONE MODEL X-9', '2.00', 'unit', 0, 4, '5006.75', '10013.50', 1, '0.00', '0.00', '10013.50', '0.00', '0.00', '10013.50'),
(466, 44, '5', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '1.00', '', 0, 5, '450.00', '450.00', 1, '0.00', '0.00', '450.00', '0.00', '0.00', '450.00'),
(467, 44, '6', 'TOP RADIATOR HOSE ORIGINAL', '1.00', '', 0, 6, '450.00', '450.00', 3, '10.00', '45.00', '495.00', '0.00', '0.00', '450.00'),
(468, 44, '7', 'Jetting Works and Clear blockages with rodder machine', '14.00', 'unit', 0, 7, '6.00', '84.00', 6, '1.50', '1.18', '80.14', '6.00', '5.04', '78.96'),
(469, 44, '8', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 0, 8, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(470, 45, '1', 'A4 Bahasa Malaysia Exam papers9', '4.00', 'pcs', 0, 1, '6.49', '25.96', 2, '6.00', '1.46', '25.86', '6.00', '1.56', '24.40'),
(471, 45, '2', 'Desludging Tanker 10 cubic metres (Cina Made)', '5.00', 'units', 0, 2, '99.00', '495.00', 1, '0.00', '0.00', '495.00', '0.00', '0.00', '495.00'),
(472, 45, '3', 'LABOUR TO REPLACE PARTS & SERVICE', '2.00', '', 0, 3, '56.00', '112.00', 1, '0.00', '0.00', '105.28', '6.00', '6.72', '105.28'),
(473, 45, '4', 'MOTOROLLA HANDPHONE MODEL X-9', '2.00', 'unit', 0, 4, '5006.75', '10013.50', 1, '0.00', '0.00', '10013.50', '0.00', '0.00', '10013.50'),
(474, 45, '5', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '1.00', '', 0, 5, '450.00', '450.00', 1, '0.00', '0.00', '450.00', '0.00', '0.00', '450.00'),
(475, 45, '6', 'TOP RADIATOR HOSE ORIGINAL', '1.00', '', 0, 6, '450.00', '450.00', 3, '10.00', '45.00', '495.00', '0.00', '0.00', '450.00'),
(476, 45, '7', 'Jetting Works and Clear blockages with rodder machine', '14.00', 'unit', 0, 7, '6.00', '84.00', 6, '1.50', '1.18', '80.14', '6.00', '5.04', '78.96'),
(477, 45, '8', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 0, 8, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(488, 47, '', 'LABOUR TO REPLACE PARTS & SERVICE', '12.00', '', 0, 1, '56.00', '672.00', 1, '0.00', '0.00', '638.40', '5.00', '33.60', '638.40'),
(489, 47, '', 'Screw Holland made 6 type', '5.00', '', 0, 2, '77.00', '385.00', 4, '34.00', '117.81', '464.31', '10.00', '38.50', '346.50'),
(490, 47, '', 'AUTOMATIC TRANSMISSION FLUID', '5.00', 'unit', 0, 3, '102.50', '512.50', 1, '0.00', '0.00', '512.50', '0.00', '0.00', '512.50'),
(491, 47, '', 'TOP RADIATOR HOSE ORIGINAL', '6.00', '', 0, 4, '450.00', '2700.00', 3, '10.00', '270.00', '2970.00', '0.00', '0.00', '2700.00'),
(492, 47, '', 'NOKIA CHARGER TYPE CARBON 4598BK', '1.00', 'UNIT', 0, 5, '59.00', '59.00', 1, '0.00', '0.00', '59.00', '0.00', '0.00', '59.00'),
(493, 48, '', 'LABOUR TO REPLACE PARTS & SERVICE', '12.00', '', 0, 1, '56.00', '672.00', 1, '0.00', '0.00', '638.40', '5.00', '33.60', '638.40'),
(494, 48, '', 'Screw Holland made 6 type', '5.00', '', 0, 2, '77.00', '385.00', 4, '34.00', '117.81', '464.31', '10.00', '38.50', '346.50'),
(495, 48, '', 'AUTOMATIC TRANSMISSION FLUID', '5.00', 'unit', 0, 3, '102.50', '512.50', 1, '0.00', '0.00', '512.50', '0.00', '0.00', '512.50'),
(496, 48, '', 'TOP RADIATOR HOSE ORIGINAL', '6.00', '', 0, 4, '450.00', '2700.00', 3, '10.00', '270.00', '2970.00', '0.00', '0.00', '2700.00'),
(497, 48, '', 'NOKIA CHARGER TYPE CARBON 4598BK', '1.00', 'UNIT', 0, 5, '59.00', '59.00', 1, '0.00', '0.00', '59.00', '0.00', '0.00', '59.00'),
(498, 49, '1', 'A4 Bahasa Malaysia Exam papers9', '4.00', 'pcs', 0, 1, '6.49', '25.96', 2, '6.00', '1.46', '25.86', '6.00', '1.56', '24.40'),
(499, 49, '2', 'Desludging Tanker 10 cubic metres (Cina Made)', '5.00', 'units', 0, 2, '99.00', '495.00', 1, '0.00', '0.00', '495.00', '0.00', '0.00', '495.00'),
(500, 49, '3', 'LABOUR TO REPLACE PARTS & SERVICE', '2.00', '', 0, 3, '56.00', '112.00', 1, '0.00', '0.00', '105.28', '6.00', '6.72', '105.28'),
(501, 49, '4', 'MOTOROLLA HANDPHONE MODEL X-9', '2.00', 'unit', 0, 4, '5006.75', '10013.50', 1, '0.00', '0.00', '10013.50', '0.00', '0.00', '10013.50'),
(502, 49, '5', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '1.00', '', 0, 5, '450.00', '450.00', 1, '0.00', '0.00', '450.00', '0.00', '0.00', '450.00'),
(503, 49, '6', 'TOP RADIATOR HOSE ORIGINAL', '1.00', '', 0, 6, '450.00', '450.00', 3, '10.00', '45.00', '495.00', '0.00', '0.00', '450.00'),
(504, 49, '7', 'Jetting Works and Clear blockages with rodder machine', '14.00', 'unit', 0, 7, '6.00', '84.00', 6, '1.50', '1.18', '80.14', '6.00', '5.04', '78.96'),
(505, 49, '8', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 0, 8, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(506, 50, '1', 'A4 Bahasa Malaysia Exam papers9', '4.00', 'pcs', 0, 1, '6.49', '25.96', 2, '6.00', '1.46', '25.86', '6.00', '1.56', '24.40'),
(507, 50, '2', 'Desludging Tanker 10 cubic metres (Cina Made)', '5.00', 'units', 0, 2, '99.00', '495.00', 1, '0.00', '0.00', '495.00', '0.00', '0.00', '495.00'),
(508, 50, '3', 'LABOUR TO REPLACE PARTS & SERVICE', '2.00', '', 0, 3, '56.00', '112.00', 1, '0.00', '0.00', '105.28', '6.00', '6.72', '105.28'),
(509, 50, '4', 'MOTOROLLA HANDPHONE MODEL X-9', '2.00', 'unit', 0, 4, '5006.75', '10013.50', 1, '0.00', '0.00', '10013.50', '0.00', '0.00', '10013.50'),
(510, 50, '5', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '1.00', '', 0, 5, '450.00', '450.00', 1, '0.00', '0.00', '450.00', '0.00', '0.00', '450.00'),
(511, 50, '6', 'TOP RADIATOR HOSE ORIGINAL', '1.00', '', 0, 6, '450.00', '450.00', 3, '10.00', '45.00', '495.00', '0.00', '0.00', '450.00'),
(512, 50, '7', 'Jetting Works and Clear blockages with rodder machine', '14.00', 'unit', 0, 7, '6.00', '84.00', 6, '1.50', '1.18', '80.14', '6.00', '5.04', '78.96'),
(513, 50, '8', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 0, 8, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(514, 51, '', '', '0.00', '', 0, 1, '1000.00', '1000.00', 1, '0.00', '0.00', '1000.00', '0.00', '0.00', '1000.00'),
(515, 51, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(516, 51, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(517, 51, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(518, 51, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(547, 52, '', 'MANHOLE CLEANING WORKS', '0.00', '', 1, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(548, 52, '1.', 'STAFF NEED TO ENTER THE MANHOLES MANUALLY AND REMOVE ALL RUBBISH, DIRT AND SAND FROM THE BOTTOM OF MANHOLE.', '1.00', 'LOT', 0, 2, '2500.00', '2500.00', 1, '0.00', '0.00', '2500.00', '0.00', '0.00', '2500.00'),
(549, 52, '2.', 'COLLECT ALL THE RUBBISH AND SAND AND DISPOSE IN RORO RUBBISH BIN\r\nTO BE SEND TO DISPOSAL SITE USING LORRY.', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(550, 52, '3.', 'DISPOSAL AMOUNT INCLUDED IN THE QUOTATION.', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(551, 52, '', 'SEWERAGE PIPE CLEARING', '0.00', '', 1, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(552, 52, '1.', 'USE MANUAL RODDING TO CLEAR THE BLOCKAGES', '1.00', 'LOT', 0, 6, '3500.00', '3500.00', 1, '0.00', '0.00', '3500.00', '0.00', '0.00', '3500.00'),
(553, 52, '2.', 'USE JETTING MACHINE WITH HIGH POWERED WATER PRESSURE TO CLEAR ALL BLOCKAGES.', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(554, 52, '3.', 'REMOVE ALL THE CLEARED BLOCKAGES AND DISPOSE IN RORO BIN FOR DISPOSAL.', '0.00', '', 0, 8, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(555, 52, '', 'WORK SITE CLEANING WORKS', '0.00', '', 1, 9, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(556, 52, '1.', 'CLEAN ALL THE WORKSITE AREA OF DEBRIS, SLUDGE ETC AFTER THE WORKS IS COMPLETED.', '1.00', 'LOT', 0, 10, '1000.00', '1000.00', 1, '0.00', '0.00', '1000.00', '0.00', '0.00', '1000.00'),
(557, 52, '', 'PAYMENT TERMS', '0.00', '', 1, 11, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(558, 52, '1.', 'OFFICIAL PURCHASE ORDER NEED TO BE ISSUED BY CUSTOMER.', '0.00', '', 0, 12, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(559, 52, '2.', 'DEPOSIT AMOUNT OF 50 PERCENT OF TOTAL COST TO BE PAID BEFORE WORK STARTS.', '0.00', '', 0, 13, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(560, 52, '3.', 'BALANCE PAYMENT OF 50 PERCENT TO BE PAID WITHIN 7 DAYS OF WORK COMPLETION.', '0.00', '', 0, 14, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(561, 53, '', '', '0.00', '', 0, 1, '999.00', '999.00', 1, '0.00', '0.00', '999.00', '0.00', '0.00', '999.00'),
(562, 53, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(563, 53, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(564, 53, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(565, 53, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(566, 54, '', 'LABOUR TO REPLACE PARTS & SERVICE', '45.00', '', 0, 1, '56.00', '2520.00', 2, '6.00', '143.64', '2537.64', '5.00', '126.00', '2394.00'),
(567, 54, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(568, 54, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(569, 54, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(570, 54, '', 'Desludging Tanker 10 cubic metres (Cina Made)', '0.00', 'units', 0, 5, '99.00', '99.00', 1, '0.00', '0.00', '99.00', '0.00', '0.00', '99.00'),
(571, 54, '', '', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(572, 55, '', '', '0.00', '', 0, 1, '6000.00', '6000.00', 1, '0.00', '0.00', '6000.00', '0.00', '0.00', '6000.00'),
(573, 55, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(574, 55, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(575, 55, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(576, 55, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(577, 56, '', '', '0.00', '', 0, 1, '6090.00', '6090.00', 1, '0.00', '0.00', '6090.00', '0.00', '0.00', '6090.00'),
(578, 56, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(579, 56, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(580, 56, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(581, 56, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(582, 57, '', '', '0.00', '', 0, 1, '3150.00', '3150.00', 1, '0.00', '0.00', '3150.00', '0.00', '0.00', '3150.00'),
(583, 57, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(584, 57, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(585, 57, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(586, 57, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(587, 58, '', '', '0.00', '', 0, 1, '888.00', '888.00', 1, '0.00', '0.00', '888.00', '0.00', '0.00', '888.00'),
(588, 58, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(589, 58, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(590, 58, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(591, 58, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(592, 59, '', '', '0.00', '', 0, 1, '999.00', '999.00', 1, '0.00', '0.00', '999.00', '0.00', '0.00', '999.00'),
(593, 59, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(594, 59, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(595, 59, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(596, 59, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(597, 60, '', '', '56.00', '', 0, 1, '56.00', '3136.00', 1, '0.00', '0.00', '3136.00', '0.00', '0.00', '3136.00'),
(598, 60, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(599, 60, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(600, 60, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(601, 60, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(602, 61, '', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 0, 1, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(603, 61, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(604, 61, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(605, 61, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(606, 61, '', 'MOTOROLLA HANDPHONE MODEL X-9', '0.00', 'unit', 0, 5, '5006.75', '5006.75', 1, '0.00', '0.00', '5006.75', '0.00', '0.00', '5006.75'),
(607, 62, '', 'A4 Bahasa Malaysia Exam papers9', '6.00', 'pcs', 0, 1, '6.49', '38.94', 1, '0.00', '0.00', '38.94', '0.00', '0.00', '38.94'),
(608, 62, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '6.00', '', 0, 2, '450.00', '2700.00', 1, '0.00', '0.00', '2700.00', '0.00', '0.00', '2700.00'),
(609, 62, '', 'Teak Wood furniture sofa chair', '5.00', '', 0, 3, '66.00', '330.00', 1, '0.00', '0.00', '313.50', '5.00', '16.50', '313.50'),
(610, 62, '', 'NOKIA CHARGER TYPE CARBON 4598BK', '1.00', 'UNIT', 0, 4, '59.00', '59.00', 1, '0.00', '0.00', '59.00', '0.00', '0.00', '59.00'),
(611, 62, '', 'MOTOROLLA HANDPHONE MODEL X-9', '1.00', 'unit', 0, 5, '5006.75', '5006.75', 4, '34.00', '1702.30', '6709.05', '0.00', '0.00', '5006.75'),
(612, 62, '', 'Chicken Eggs \r\nMount Road Poulty Farm', '0.00', '', 0, 6, '77.85', '77.85', 1, '0.00', '0.00', '77.85', '0.00', '0.00', '77.85'),
(613, 62, '', 'Screw Holland made 6 type', '3.00', '', 0, 7, '77.00', '231.00', 1, '0.00', '0.00', '231.00', '0.00', '0.00', '231.00'),
(614, 62, '', 'Electrical Cable Malaysia Made', '1.00', 'pc', 0, 8, '10.49', '10.49', 1, '0.00', '0.00', '10.49', '0.00', '0.00', '10.49'),
(623, 64, '', 'LABOUR TO REPLACE PARTS & SERVICE', '3.00', '', 0, 1, '56.00', '168.00', 4, '34.00', '54.84', '216.12', '4.00', '6.72', '161.28'),
(624, 64, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '4.00', '', 0, 2, '450.00', '1800.00', 1, '0.00', '0.00', '1710.00', '5.00', '90.00', '1710.00'),
(625, 64, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(626, 64, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(627, 64, '', 'Chicken Eggs \r\nMount Road Poulty Farm', '5.00', '', 0, 5, '77.85', '389.25', 2, '6.00', '22.89', '404.35', '2.00', '7.79', '381.46'),
(628, 63, '', 'A4 Bahasa Malaysia Exam papers9', '6.00', 'pcs', 0, 1, '6.49', '38.94', 1, '0.00', '0.00', '38.94', '0.00', '0.00', '38.94'),
(629, 63, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '6.00', '', 0, 2, '450.00', '2700.00', 1, '0.00', '0.00', '2700.00', '0.00', '0.00', '2700.00'),
(630, 63, '', 'Teak Wood furniture sofa chair', '5.00', '', 0, 3, '66.00', '330.00', 1, '0.00', '0.00', '313.50', '5.00', '16.50', '313.50'),
(631, 63, '', 'NOKIA CHARGER TYPE CARBON 4598BK', '1.00', 'UNIT', 0, 4, '59.00', '59.00', 1, '0.00', '0.00', '59.00', '0.00', '0.00', '59.00'),
(632, 63, '', 'MOTOROLLA HANDPHONE MODEL X-9', '1.00', 'unit', 0, 5, '5006.75', '5006.75', 4, '34.00', '1702.30', '6709.05', '0.00', '0.00', '5006.75'),
(633, 63, '', 'Chicken Eggs \r\nMount Road Poulty Farm', '0.00', '', 0, 6, '77.85', '77.85', 1, '0.00', '0.00', '77.85', '0.00', '0.00', '77.85'),
(634, 63, '', 'Screw Holland made 6 type', '3.00', '', 0, 7, '77.00', '231.00', 1, '0.00', '0.00', '231.00', '0.00', '0.00', '231.00'),
(635, 63, '', 'Electrical Cable Malaysia Made', '1.00', 'pc', 0, 8, '10.49', '10.49', 1, '0.00', '0.00', '10.49', '0.00', '0.00', '10.49'),
(636, 65, '', 'LABOUR TO REPLACE PARTS & SERVICE', '3.00', '', 0, 1, '56.00', '168.00', 4, '34.00', '54.84', '216.12', '4.00', '6.72', '161.28');
INSERT INTO `tbinvoicedetail` (`invoiceDetail_id`, `invoiceDetail_invoiceID`, `invoiceDetail_no1`, `invoiceDetail_no2`, `invoiceDetail_no3`, `invoiceDetail_no4`, `invoiceDetail_bold`, `invoiceDetail_sortID`, `invoiceDetail_no5`, `invoiceDetail_rowTotal`, `invoiceDetail_taxRateID`, `invoiceDetail_taxPercent`, `invoiceDetail_taxTotal`, `invoiceDetail_rowGrandTotal`, `invoiceDetail_discountPercent`, `invoiceDetail_discountAmount`, `invoiceDetail_rowTotalAfterDiscount`) VALUES
(637, 65, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '4.00', '', 0, 2, '450.00', '1800.00', 1, '0.00', '0.00', '1710.00', '5.00', '90.00', '1710.00'),
(638, 65, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(639, 65, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(640, 65, '', 'Chicken Eggs \r\nMount Road Poulty Farm', '12.00', '', 0, 5, '77.85', '934.20', 4, '34.00', '311.28', '1226.80', '2.00', '18.68', '915.52'),
(641, 66, '1', 'HACK AND BREAK THE TILES AND CONCRETE ON THE TOILET\r\n(ONLY THE BROKEN PIPE SECTION)', '0.00', '', 0, 1, '7000.00', '7000.00', 1, '0.00', '0.00', '7000.00', '0.00', '0.00', '7000.00'),
(642, 66, '2', '2.) NEED TO BREAK AND REMOVE THE EXISTING TOILET BOWL.', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(643, 66, '3', '3.) NEED TO DIG TO THE DEPTH OF TWO AND HALF FEET TO ACCESS THE BROKEN SEWERAGE PIPE', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(644, 66, '4', '4.) CUT AND REMOVE THE EXISTING DAMAGED SEWERAGE PIPE        (ONLY THE BROKEN SECTION)', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(645, 66, '5', '5.) TO SUPPLY NEW UPVC UNDERGROUND SEWERAGE PIPE', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(646, 66, '6', '6.) TO LAY, INSTALL AND JOIN THIS NEW PIPE TO THE   EXISTING UNDAMAGED  SEWERAGE PIPE.', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(647, 66, '1', '7.) TO COVER THE PIPE WITH SAND AND GRAVEL .', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(648, 66, '2', '8.) TO LAY NEW CONCRETE FLOORING', '0.00', '', 0, 8, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(649, 66, '3', '9.) TO LAY NEW TILES TO REPLACE ALL THE DAMAGES TILES.', '0.00', '', 0, 9, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(650, 66, '4', '10.) TO SUPPLY AND REINSTALL NEW TOILET BOWL', '0.00', '', 0, 10, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(651, 66, '5', '11.) TO CLEAN AND CLEAR WORKSITE OF ALL SAND AND DEBRIS', '0.00', '', 0, 11, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(665, 67, '', 'LABOUR TO REPLACE PARTS & SERVICE', '1.00', '', 0, 1, '4560.00', '4560.00', 2, '6.00', '273.60', '4833.60', '0.00', '0.00', '4560.00'),
(666, 67, '', 'Screw Holland made 6 type', '2.00', '', 0, 2, '77.00', '154.00', 6, '1.50', '2.31', '156.31', '0.00', '0.00', '154.00'),
(667, 67, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '1.00', '', 0, 3, '450.00', '450.00', 1, '0.00', '0.00', '450.00', '0.00', '0.00', '450.00'),
(668, 67, '', 'Teak Wood furniture sofa chair', '1.00', '', 0, 4, '66.00', '66.00', 1, '0.00', '0.00', '66.00', '0.00', '0.00', '66.00'),
(669, 67, '', 'Parts Repair', '0.00', '', 1, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(670, 67, '1.', 'NOKIA CHARGER TYPE CARBON 4598BK', '2.00', 'UNIT', 0, 6, '59.00', '118.00', 1, '0.00', '0.00', '118.00', '0.00', '0.00', '118.00'),
(671, 67, '2.', 'MOTOROLLA HANDPHONE MODEL X-9', '2.00', 'unit', 0, 7, '5006.75', '10013.50', 1, '0.00', '0.00', '10013.50', '0.00', '0.00', '10013.50'),
(672, 67, '3.', 'TOP RADIATOR HOSE ORIGINAL', '6.00', '', 0, 8, '450.00', '2700.00', 1, '0.00', '0.00', '2700.00', '0.00', '0.00', '2700.00'),
(678, 69, '1.', 'General Pest Control: Our general pest control service includes the treatment of common household pests such as ants, cockroaches, spiders, and rodents.', '0.00', '', 0, 1, '700.00', '700.00', 4, '34.00', '238.00', '938.00', '0.00', '0.00', '700.00'),
(679, 69, '2.', 'This service involves a thorough inspection of of your property to identify pest infestations and potential problem areas, followed by the application of targeted pest control treatments to eliminate', '0.00', '', 0, 2, '900.00', '900.00', 1, '0.00', '0.00', '828.00', '8.00', '72.00', '828.00'),
(680, 69, '3.', 'Termite Control: Termites can cause significant damage to your property and can be difficult to detect without professional assistance. Our termite control service includes a comprehensive inspection', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(681, 69, '4.', 'We then use industry-leading termite control treatments to eliminate termites and protect your property from further damage.', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(682, 69, '5.', 'Bed Bug Control: Bed bugs can be a persistent and frustrating problem for homeowners and businesses.', '0.00', '', 0, 5, '1290.00', '1290.00', 6, '1.50', '19.35', '1309.35', '0.00', '0.00', '1290.00'),
(683, 69, '', '', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(684, 69, '', '', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(685, 70, '1.', 'General Pest Control: Our general pest control service includes the treatment of common household pests such as ants, cockroaches, spiders, and rodents.', '0.00', '', 0, 1, '700.00', '700.00', 4, '34.00', '238.00', '938.00', '0.00', '0.00', '700.00'),
(686, 70, '2.', 'This service involves a thorough inspection of of your property to identify pest infestations and potential problem areas, followed by the application of targeted pest control treatments to eliminate', '0.00', '', 0, 2, '900.00', '900.00', 1, '0.00', '0.00', '828.00', '8.00', '72.00', '828.00'),
(687, 70, '3.', 'Termite Control: Termites can cause significant damage to your property and can be difficult to detect without professional assistance. Our termite control service includes a comprehensive inspection', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(688, 70, '4.', 'We then use industry-leading termite control treatments to eliminate termites and protect your property from further damage.', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(689, 70, '5.', 'Bed Bug Control: Bed bugs can be a persistent and frustrating problem for homeowners and businesses.', '0.00', '', 0, 5, '1290.00', '1290.00', 6, '1.50', '19.35', '1309.35', '0.00', '0.00', '1290.00'),
(690, 70, '', '', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(691, 70, '', '', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(708, 15, '', 'DESLUDGING SERVICES FOR SLUDGE & OTHER RELATED WORKS', '0.00', '', 1, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(709, 15, '1.', 'TO USE 4.5m3 DESLDUDGING TANKER TO VACUUM AND REMOVE SLUDGE / WASTE WATER INCLUDING DISPOSAL. 20/10/2022', '3.00', 'TRIPS', 0, 2, '450.00', '1350.00', 1, '0.00', '0.00', '1350.00', '0.00', '0.00', '1350.00'),
(710, 15, '2.', 'TO USE 10.00m3 DESLDUDGING TANKER TO VACUUM AND REMOVE SLUDGE / WASTE WATER INCLUDING DISPOSAL  20/10/2022', '2.00', 'TRIPS', 0, 3, '750.00', '1500.00', 1, '0.00', '0.00', '1500.00', '0.00', '0.00', '1500.00'),
(711, 15, '3.', 'REWINDING AND SERVICING WASTE WATER PUMP 16/10/2022', '0.00', '', 0, 4, '3450.00', '3450.00', 1, '0.00', '0.00', '3450.00', '0.00', '0.00', '3450.00'),
(712, 15, '4.', 'ELECTRICAL WIRING WORKS FROM PUMP TO THE ELECTRICAL PANEL BOX.', '0.00', '', 0, 5, '120.00', '120.00', 1, '0.00', '0.00', '120.00', '0.00', '0.00', '120.00'),
(713, 15, '5.', 'TO USE HIGH PRESSURE JETTER TRUCK MACHINE TO CLEAN AND BREAK ALL BLOCKAGES WITHIN THE SEWERAGE PIPELINES.', '0.00', '', 0, 6, '1800.00', '1800.00', 1, '0.00', '0.00', '1800.00', '0.00', '0.00', '1800.00'),
(714, 15, '', 'LABOUR CHARGES', '0.00', '', 1, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(715, 15, '1.', 'TO USE DESLUDGING TANKER TO VACUUM AND REMOVE ALL SLUDGE / WASTE WATER TO ENABLE THE SUBMERSIBLE PUMP AND SENSOR TO BE INSTALLED.', '2.00', 'UNITS', 0, 8, '500.00', '1000.00', 1, '0.00', '0.00', '850.00', '15.00', '150.00', '850.00'),
(726, 72, '1', 'Curry Puff Flour 1.8kg', '3.00', 'packet', 1, 1, '6.49', '19.47', 2, '6.00', '1.11', '19.61', '5.00', '0.97', '18.50'),
(727, 72, '2', 'LABOUR TO REPLACE PARTS & SERVICE', '3.00', 'pc', 0, 2, '56.00', '168.00', 4, '34.00', '54.26', '213.86', '5.00', '8.40', '159.60'),
(728, 72, '3', 'NOKIA CHARGER TYPE CARBON 4598BK', '3.00', 'UNIT', 0, 3, '59.00', '177.00', 4, '34.00', '55.97', '220.58', '7.00', '12.39', '164.61'),
(729, 72, '4', 'Teak Wood furniture sofa chair', '4.00', 'kg', 0, 4, '66.00', '264.00', 4, '34.00', '82.58', '325.46', '8.00', '21.12', '242.88'),
(730, 72, '5', 'Jetting Works and Clear blockages with rodder machine', '3.00', 'unit', 1, 5, '6.00', '18.00', 6, '1.50', '0.25', '16.63', '9.00', '1.62', '16.38'),
(731, 73, '1', 'Curry Puff Flour 1.8kg', '3.00', 'packet', 1, 1, '6.49', '19.47', 2, '6.00', '1.11', '19.61', '5.00', '0.97', '18.50'),
(732, 73, '2', 'LABOUR TO REPLACE PARTS & SERVICE', '3.00', 'pc', 0, 2, '56.00', '168.00', 4, '34.00', '54.26', '213.86', '5.00', '8.40', '159.60'),
(733, 73, '3', 'NOKIA CHARGER TYPE CARBON 4598BK', '3.00', 'UNIT', 0, 3, '59.00', '177.00', 4, '34.00', '55.97', '220.58', '7.00', '12.39', '164.61'),
(734, 73, '4', 'Teak Wood furniture sofa chair', '4.00', 'kg', 0, 4, '66.00', '264.00', 4, '34.00', '82.58', '325.46', '8.00', '21.12', '242.88'),
(735, 73, '5', 'Jetting Works and Clear blockages with rodder machine', '3.00', 'unit', 1, 5, '6.00', '18.00', 6, '1.50', '0.25', '16.63', '9.00', '1.62', '16.38'),
(744, 74, '1', 'Curry Puff Flour 1.8kg', '3.00', 'packet', 1, 1, '6.49', '19.47', 2, '6.00', '1.11', '19.61', '5.00', '0.97', '18.50'),
(745, 74, '2', 'LABOUR TO REPLACE PARTS & SERVICE', '3.00', 'pc', 0, 2, '56.00', '168.00', 4, '34.00', '54.26', '213.86', '5.00', '8.40', '159.60'),
(746, 74, '3', 'NOKIA CHARGER TYPE CARBON 4598BK', '3.00', 'UNIT', 0, 3, '59.00', '177.00', 4, '34.00', '55.97', '220.58', '7.00', '12.39', '164.61'),
(747, 74, '4', 'Teak Wood furniture sofa chair', '4.00', 'kg', 0, 4, '66.00', '264.00', 4, '34.00', '82.58', '325.46', '8.00', '21.12', '242.88'),
(748, 74, '5', 'Jetting Works and Clear blockages with rodder machine', '3.00', 'unit', 1, 5, '6.00', '18.00', 6, '1.50', '0.25', '16.63', '9.00', '1.62', '16.38'),
(749, 74, '', '', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(750, 74, '', '', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(751, 74, '', 'Electrical Cable Malaysia Made', '0.00', 'pc', 1, 8, '10.49', '10.49', 1, '0.00', '0.00', '10.49', '0.00', '0.00', '10.49'),
(757, 75, '', '', '0.00', '', 0, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(758, 75, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(759, 75, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(760, 75, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(761, 75, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(762, 71, '', 'Jetting Works and Clear blockages with rodder machine', '5.00', 'unit', 1, 1, '6.00', '30.00', 1, '0.00', '0.00', '30.00', '0.00', '0.00', '30.00'),
(763, 71, '', 'MOTOROLLA HANDPHONE MODEL X-9', '5.00', 'unit', 0, 2, '5006.75', '25033.75', 1, '0.00', '0.00', '25033.75', '0.00', '0.00', '25033.75'),
(764, 71, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(765, 71, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(766, 71, '', 'Electrical Cable Malaysia Made', '3.00', 'pc', 0, 5, '10.49', '31.47', 1, '0.00', '0.00', '31.47', '0.00', '0.00', '31.47');

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
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbpayment`
--

INSERT INTO `tbpayment` (`payment_id`, `payment_no`, `payment_date`, `payment_paymentMethodID`, `payment_chequeInfo`, `payment_amount`, `payment_userID`, `payment_remark`, `payment_status`, `payment_cancelDate`, `payment_cancelReason`, `payment_cancelUserID`, `payment_customerID`) VALUES
(1, 'RPT/2023/001', '2023-01-21', 1, '', '56.00', 4, '', 0, NULL, '', 0, 67),
(2, 'RPT/2023/002', '2023-01-21', 1, '', '55.00', 4, '', 0, NULL, '', 0, 67),
(3, 'RPT/2023/003', '2023-01-21', 2, 'ALLICANCE BANK 65009874', '6389.00', 4, '', 0, NULL, '', 0, 67),
(4, 'RPT/2023/004', '2023-01-21', 3, 'maybank', '1500.00', 4, '', 0, NULL, '', 0, 51),
(5, 'RPT/2023/005', '2023-01-21', 3, 'ALLIANCE TRAF NO 769900064', '967.00', 4, '', 0, NULL, '', 0, 76),
(6, 'RPT/2023/006', '2023-01-21', 1, '', '90.00', 4, '', 0, NULL, '', 0, 53),
(7, 'RPT/2023/007', '2023-01-21', 1, '', '56.00', 4, '', 0, NULL, '', 0, 53),
(8, 'RPT/2023/008', '2023-01-21', 1, '', '108.00', 4, '', 0, NULL, '', 0, 53),
(9, 'RPT/2023/009', '2023-01-19', 1, '', '4897.75', 4, '', 0, NULL, '', 0, 53),
(10, 'RPT/2023/010', '2023-01-22', 2, 'RHB Bank 76000221', '2474.95', 4, '', 0, NULL, '', 0, 76),
(11, 'RPT/2023/011', '2023-01-22', 1, '', '600.00', 4, '', 0, NULL, '', 0, 80),
(12, 'RPT/2023/012', '2023-01-23', 1, '', '314.25', 4, '', 0, NULL, '', 0, 76),
(13, 'RPT/2023/013', '2023-01-23', 1, '', '233.45', 4, '', 0, NULL, '', 0, 76),
(14, 'RPT/2023/014', '2023-01-24', 1, '', '1000.00', 4, '', 0, NULL, '', 0, 67),
(15, 'RPT/2023/015', '2023-01-24', 1, '', '4500.00', 4, '', 0, NULL, '', 0, 51),
(16, 'RPT/2023/016', '2023-01-25', 1, '', '575.00', 4, '', 0, NULL, '', 0, 61),
(17, 'RPT/2023/017', '2023-01-26', 1, '', '500.00', 4, '', 0, NULL, '', 0, 81),
(18, 'RPT/2023/018', '2023-01-26', 1, '', '711.25', 4, '', 0, NULL, '', 0, 76),
(19, 'RPT/2023/019', '2023-01-26', 1, '', '706.00', 4, '', 0, NULL, '', 0, 51),
(20, 'RPT/2023/020', '2023-01-26', 3, '', '245.95', 4, '', 0, NULL, '', 0, 51),
(21, 'RPT/2023/021', '2023-01-26', 1, '', '642.00', 4, '', 0, NULL, '', 0, 51),
(22, 'RPT/2023/022', '2023-01-26', 1, '', '10592.85', 4, '', 0, NULL, '', 0, 67),
(23, 'RPT/2023/023', '2023-01-26', 1, '', '8818.05', 4, '', 0, NULL, '', 0, 51),
(24, 'RPT/2023/024', '2023-01-25', 1, '', '935.00', 4, '', 0, NULL, '', 0, 53),
(25, 'RPT/2023/025', '2023-01-26', 1, '', '4683.55', 4, '', 0, NULL, '', 0, 76),
(26, 'RPT/2023/026', '2023-01-26', 1, '', '9230.00', 4, '', 0, NULL, '', 0, 76),
(27, 'RPT/2023/027', '2023-01-26', 1, '', '168.00', 4, '', 0, NULL, '', 0, 67),
(28, 'RPT/2023/028', '2023-01-26', 1, '', '105.00', 4, '', 0, NULL, '', 0, 53),
(29, 'RPT/2023/029', '2023-01-26', 1, '', '15000.00', 4, '', 0, NULL, '', 0, 76),
(30, 'RPT/2023/030', '2023-01-26', 1, '', '145.00', 4, '', 0, NULL, '', 0, 67),
(31, 'RPT/2023/031', '2023-01-26', 4, '', '248.00', 4, '', 0, NULL, '', 0, 76),
(32, 'RPT/2023/032', '2023-01-26', 1, '', '202.00', 4, '', 0, NULL, '', 0, 76),
(33, 'RPT/2023/033', '2023-01-26', 1, '', '10000.00', 4, '', 0, NULL, '', 0, 51),
(34, 'RPT/2023/034', '2023-01-26', 1, '', '9517.50', 4, '', 0, NULL, '', 0, 74),
(35, 'RPT/2023/035', '2023-01-26', 1, '', '12284.85', 4, '', 0, NULL, '', 0, 76),
(36, 'RPT/2023/036', '2023-01-26', 1, '', '3153.45', 4, '', 1, NULL, '', 0, 76),
(37, 'RPT/2023/037', '2023-01-26', 1, '', '6898.50', 4, '', 0, NULL, '', 0, 76),
(38, 'RPT/2023/038', '2023-01-26', 1, '', '170.00', 4, '', 1, NULL, '', 0, 81),
(39, 'RPT/2023/039', '2023-01-27', 1, '', '300.00', 4, '', 1, NULL, '', 0, 67),
(40, 'RPT/2023/040', '2023-01-27', 1, '', '750.00', 4, '', 0, NULL, '', 0, 67),
(41, 'RPT/2023/041', '2023-01-27', 1, '', '35.00', 4, '', 1, NULL, '', 0, 74),
(42, 'RPT/2023/042', '2023-01-27', 1, '', '107.00', 4, '', 1, NULL, '', 0, 81),
(43, 'RPT/2023/043', '2023-01-27', 1, '', '120.00', 4, '', 1, NULL, '', 0, 67),
(44, 'RPT/2023/045', '2023-01-30', 1, '', '6523.00', 4, '', 1, NULL, '', 0, 81),
(45, 'RPT/2023/046', '2023-01-30', 1, '', '64562.55', 4, '', 1, NULL, '', 0, 51),
(46, 'RPT/2023/047', '2023-01-31', 1, '', '1000.00', 4, '', 0, NULL, '', 0, 51),
(47, 'RPT/2023/048', '2023-01-31', 1, '', '500.00', 4, '', 1, NULL, '', 0, 63),
(48, 'RPT/2023/049', '2023-01-31', 1, '', '155.00', 4, '', 1, NULL, '', 0, 51),
(49, 'RPT/2023/050', '2023-02-01', 1, '', '17484.50', 4, '', 0, NULL, '', 0, 51),
(50, 'RPT/2023/051', '2023-02-01', 1, '', '300.00', 4, '', 0, NULL, '', 0, 71),
(51, 'RPT/2023/052', '2023-02-01', 1, '', '253.00', 4, '', 0, NULL, '', 0, 81),
(52, 'RPT/2023/053', '2023-02-01', 1, '', '65056.87', 4, '', 0, NULL, '', 0, 76),
(53, 'RPT/2023/054', '2023-02-01', 1, '', '74126.87', 4, '', 1, NULL, '', 0, 76),
(54, 'RPT/2023/055', '2023-02-01', 2, 'maybank 76009846', '1000.00', 4, '', 1, NULL, '', 0, 40),
(55, 'RPT/2023/056', '2023-02-01', 3, 'ID 7678884 public bank', '500.00', 4, '', 1, NULL, '', 0, 75),
(56, 'RPT/2023/057', '2023-02-01', 6, 'Maxis payment Code 76644094', '856.00', 4, '', 1, NULL, '', 0, 53),
(57, 'RPT/2023/058', '2023-02-01', 1, '', '5069.20', 4, '', 0, NULL, '', 0, 61),
(58, 'RPT/2023/059', '2023-02-01', 1, '', '55.00', 1, '', 1, NULL, '', 0, 51),
(59, 'RPT/2023/060', '2023-02-09', 3, 'public bank 65400094', '222.00', 4, '', 0, NULL, '', 0, 74),
(60, 'RPT/2023/061', '2023-02-12', 3, 'Transfre ID 0984000456', '57187.75', 4, '', 1, NULL, '', 0, 74),
(61, 'RPT/2023/062', '2023-02-12', 6, 'Maxis payment 5677884801', '500.00', 4, '', 1, NULL, '', 0, 74),
(62, 'RPT/2023/063', '2023-02-15', 3, 'bank transfer 769904', '6000.00', 4, '', 1, NULL, '', 0, 61),
(63, 'RPT/2023/064', '2023-02-15', 2, '67900ID6553', '350.00', 4, '', 1, NULL, '', 0, 8),
(64, 'RPT/2023/065', '2023-02-23', 3, 'Public Bank 349904ID', '4040.90', 4, '', 1, NULL, '', 0, 71),
(65, 'RPT/2023/067', '2023-02-26', 3, '5643333 Public Bank', '48896.73', 4, '', 1, NULL, '', 0, 51),
(66, 'RPT/2023/068', '2023-02-28', 1, '', '500.00', 4, '', 0, NULL, '', 0, 65),
(67, 'RPT/2023/069', '2023-03-03', 1, '', '3075.35', 4, '', 1, NULL, '', 0, 65);

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
) ENGINE=InnoDB AUTO_INCREMENT=165 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbpaymentdetail`
--

INSERT INTO `tbpaymentdetail` (`paymentDetail_id`, `paymentDetail_paymentID`, `paymentDetail_invoiceID`, `paymentDetail_amount`) VALUES
(1, 1, 3, '56.00'),
(2, 2, 3, '55.00'),
(3, 3, 3, '6389.00'),
(4, 4, 1, '1000.00'),
(5, 4, 2, '500.00'),
(6, 5, 4, '67.00'),
(7, 5, 5, '900.00'),
(8, 6, 6, '34.00'),
(9, 6, 7, '56.00'),
(10, 7, 6, '23.00'),
(11, 7, 7, '33.00'),
(12, 8, 6, '52.00'),
(13, 8, 7, '56.00'),
(14, 9, 6, '4897.75'),
(15, 10, 5, '2474.95'),
(16, 11, 9, '600.00'),
(17, 12, 4, '34.00'),
(18, 12, 8, '45.00'),
(19, 12, 10, '90.75'),
(20, 12, 11, '99.00'),
(21, 12, 12, '45.50'),
(22, 13, 4, '45.00'),
(23, 13, 8, '24.00'),
(24, 13, 10, '5.85'),
(25, 13, 11, '67.85'),
(26, 13, 12, '90.75'),
(27, 14, 13, '1000.00'),
(28, 15, 17, '4500.00'),
(29, 16, 18, '575.00'),
(30, 17, 19, '200.00'),
(31, 17, 20, '300.00'),
(32, 18, 4, '50.00'),
(33, 18, 10, '60.75'),
(34, 18, 21, '600.50'),
(35, 19, 1, '56.00'),
(36, 19, 2, '90.00'),
(37, 19, 17, '560.00'),
(38, 20, 1, '78.00'),
(39, 20, 2, '89.00'),
(40, 20, 17, '78.95'),
(41, 21, 1, '9.00'),
(42, 21, 2, '90.00'),
(43, 21, 17, '543.00'),
(44, 22, 3, '6500.00'),
(45, 22, 13, '4092.85'),
(46, 23, 17, '8818.05'),
(47, 24, 6, '35.00'),
(48, 24, 7, '900.00'),
(49, 25, 10, '1000.00'),
(50, 25, 12, '3683.55'),
(51, 26, 5, '70.00'),
(52, 26, 8, '90.00'),
(53, 26, 15, '9070.00'),
(54, 27, 3, '90.00'),
(55, 27, 13, '78.00'),
(56, 28, 6, '7.00'),
(57, 28, 7, '98.00'),
(58, 29, 21, '15000.00'),
(59, 30, 3, '56.00'),
(60, 30, 13, '89.00'),
(61, 31, 4, '23.00'),
(62, 31, 5, '45.00'),
(63, 31, 8, '90.00'),
(64, 31, 11, '90.00'),
(65, 32, 4, '90.00'),
(66, 32, 5, '15.00'),
(67, 32, 8, '65.00'),
(68, 32, 11, '32.00'),
(69, 33, 17, '10000.00'),
(70, 34, 16, '9517.50'),
(71, 35, 4, '78.00'),
(72, 35, 5, '89.00'),
(73, 35, 8, '6214.00'),
(74, 35, 10, '80.00'),
(75, 35, 11, '5600.00'),
(76, 35, 12, '78.00'),
(77, 35, 15, '65.90'),
(78, 35, 21, '79.95'),
(79, 36, 4, '78.00'),
(80, 36, 5, '70.00'),
(81, 36, 8, '78.00'),
(82, 36, 10, '90.00'),
(83, 36, 11, '250.00'),
(84, 36, 12, '1000.00'),
(85, 36, 15, '908.00'),
(86, 36, 21, '679.45'),
(87, 37, 5, '3304.95'),
(88, 37, 10, '910.00'),
(89, 37, 12, '2683.55'),
(90, 38, 19, '80.00'),
(91, 38, 20, '90.00'),
(92, 39, 3, '100.00'),
(93, 39, 13, '200.00'),
(94, 40, 3, '600.00'),
(95, 40, 13, '150.00'),
(96, 41, 16, '35.00'),
(97, 42, 19, '30.00'),
(98, 42, 20, '77.00'),
(99, 43, 3, '55.00'),
(100, 43, 13, '65.00'),
(101, 44, 19, '890.00'),
(102, 44, 20, '4833.00'),
(103, 44, 25, '800.00'),
(104, 45, 1, '1000.00'),
(105, 45, 2, '500.00'),
(106, 45, 17, '10000.00'),
(107, 45, 22, '5300.00'),
(108, 45, 24, '38692.55'),
(109, 45, 30, '9070.00'),
(110, 46, 35, '1000.00'),
(111, 47, 32, '500.00'),
(112, 48, 35, '55.00'),
(113, 48, 36, '100.00'),
(114, 49, 35, '3601.00'),
(115, 49, 36, '8933.50'),
(116, 49, 37, '4950.00'),
(117, 50, 31, '100.00'),
(118, 50, 38, '200.00'),
(119, 51, 25, '88.00'),
(120, 51, 26, '76.00'),
(121, 51, 40, '89.00'),
(122, 52, 4, '3128.00'),
(123, 52, 8, '6136.00'),
(124, 52, 11, '5350.00'),
(125, 52, 15, '8162.00'),
(126, 52, 21, '14320.55'),
(127, 52, 28, '16239.52'),
(128, 52, 41, '11720.80'),
(129, 53, 4, '3128.00'),
(130, 53, 8, '6136.00'),
(131, 53, 11, '5350.00'),
(132, 53, 15, '8162.00'),
(133, 53, 21, '14320.55'),
(134, 53, 28, '16239.52'),
(135, 53, 42, '9070.00'),
(136, 53, 44, '11720.80'),
(137, 54, 43, '1000.00'),
(138, 55, 14, '500.00'),
(139, 56, 7, '800.00'),
(140, 56, 27, '56.00'),
(141, 57, 18, '425.00'),
(142, 57, 47, '4644.20'),
(143, 58, 51, '55.00'),
(144, 59, 16, '89.00'),
(145, 59, 23, '99.00'),
(146, 59, 34, '34.00'),
(147, 60, 16, '9482.50'),
(148, 60, 23, '34452.00'),
(149, 60, 34, '9617.60'),
(150, 60, 54, '2636.65'),
(151, 60, 53, '999.00'),
(152, 61, 50, '500.00'),
(153, 62, 55, '6000.00'),
(154, 63, 56, '350.00'),
(155, 64, 58, '888.00'),
(156, 64, 65, '3152.90'),
(157, 65, 35, '3601.00'),
(158, 65, 36, '8933.50'),
(159, 65, 51, '885.00'),
(160, 65, 63, '10139.83'),
(161, 65, 67, '18337.40'),
(162, 65, 66, '7000.00'),
(163, 66, 69, '500.00'),
(164, 67, 70, '3075.35');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbpaymentvoucher`
--

INSERT INTO `tbpaymentvoucher` (`paymentVoucher_id`, `paymentVoucher_no`, `paymentVoucher_date`, `paymentVoucher_paymentMethodID`, `paymentVoucher_chequeInfo`, `paymentVoucher_amount`, `paymentVoucher_userID`, `paymentVoucher_remark`, `paymentVoucher_status`, `paymentVoucher_cancelDate`, `paymentVoucher_cancelReason`, `paymentVoucher_cancelUserID`, `paymentVoucher_customerID`) VALUES
(1, 'RPT0001', '2023-03-01', 1, '', '2000.00', 4, '', 0, NULL, '', 0, 74),
(2, 'RPT0002', '2023-03-01', 1, '', '1000.00', 4, '', 1, NULL, '', 0, 51),
(3, 'RPT0003', '2023-03-01', 1, '', '2000.00', 4, '', 0, NULL, '', 0, 74),
(4, 'PV/2023/021', '2023-03-01', 2, 'maybank 76052121', '150.00', 4, '', 0, NULL, '', 0, 92);

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbpaymentvoucherdetail`
--

INSERT INTO `tbpaymentvoucherdetail` (`paymentVoucherDetail_id`, `paymentVoucherDetail_paymentVoucherID`, `paymentVoucherDetail_purchaseBillID`, `paymentVoucherDetail_amount`) VALUES
(1, 1, 2, '2000.00'),
(2, 2, 3, '1000.00'),
(3, 3, 2, '2000.00'),
(4, 4, 6, '150.00');

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
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbproduct`
--

INSERT INTO `tbproduct` (`product_id`, `product_code`, `product_name`, `product_description`, `product_type`, `product_buyingPrice`, `product_sellingPrice`, `product_stock`, `product_uom`) VALUES
(1, 'A0009834', 'Electrical Cable Malaysia Made', '', 'p', '9.49', '10.49', '0.00', 'pc'),
(26, '', 'Curry Puff Flour 1.8kg', '', 'p', '5.49', '6.49', '0.00', 'packet'),
(35, '', 'A4 Bahasa Malaysia Exam papers9', '', 's', '5.49', '6.49', '0.00', 'pcs'),
(36, '', 'Desludging Tanker 10 cubic metres (Cina Made)', '', 'p', '77.00', '99.00', '0.00', 'units'),
(37, '', 'Jetting Works and Clear blockages with rodder machine', '', 'p', '5.00', '6.00', '0.00', 'unit'),
(38, '', 'MOTOROLLA HANDPHONE MODEL X-9', '', 'p', '1340.00', '5006.75', '0.00', 'unit'),
(39, '', 'Screw Holland made 6 type', '', 'p', '55.00', '77.00', '0.00', ''),
(40, '', 'Teak Wood furniture sofa chair', '', 'p', '34.00', '66.00', '0.00', ''),
(41, '', 'Screw made in taiwan 67 size', '', 'p', '0.00', '0.00', '0.00', ''),
(42, '', 'AUTOMATIC TRANSMISSION FLUID', '', 'p', '89.00', '102.50', '0.00', 'unit'),
(43, '', 'LABOUR TO REPLACE PARTS & SERVICE', '', 'p', '45.00', '56.00', '0.00', ''),
(44, '', 'TOP RADIATOR HOSE ORIGINAL', '', 'p', '300.00', '450.00', '0.00', ''),
(45, '', 'NOKIA CHARGER TYPE CARBON 4598BK', '', 'p', '50.00', '59.00', '0.00', 'UNIT'),
(46, '', 'Chicken Eggs \r\nMount Road Poulty Farm', '', 'p', '45.00', '77.85', '0.00', ''),
(47, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '', 'p', '0.00', '450.00', '0.00', '');

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbpurchasebill`
--

INSERT INTO `tbpurchasebill` (`purchaseBill_id`, `purchaseBill_no`, `purchaseBill_date`, `purchaseBill_customerID`, `purchaseBill_title`, `purchaseBill_from`, `purchaseBill_terms`, `purchaseBill_attention`, `purchaseBill_email`, `purchaseBill_subTotal`, `purchaseBill_taxTotal`, `purchaseBill_grandTotal`, `purchaseBill_discountTotal`, `purchaseBill_totalAfterDiscount`, `purchaseBill_roundAmount`, `purchaseBill_grandTotalRound`, `purchaseBill_roundStatus`, `purchaseBill_content`, `purchaseBill_account3ID`, `purchaseBill_customerInvoiceNo`, `purchaseBill_purchaseOrderID`, `purchaseBill_purchaseOrderNo`, `purchaseBill_paid`, `purchaseBill_status`) VALUES
(2, 'PB/2023/002', '2023-03-01', 74, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0, '', 12, '', 0, '', '0.00', 'c'),
(3, 'PB/2023/003', '2023-03-01', 51, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '1000.00', '0.00', '1000.00', '0.00', '1000.00', '0.00', '1000.00', 0, '', 12, '', 1, 'PO/2023/001', '1000.00', 'a'),
(5, 'PB/2023/004', '2023-03-01', 67, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'Mr Ramachandrean', 'caresome_90@gmail.com', '5000.00', '0.00', '5000.00', '0.00', '5000.00', '0.00', '5000.00', 0, '', 12, '', 4, 'PO/2023/004', '0.00', 'a'),
(6, 'PB/2023/005', '2023-03-01', 92, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', '', '', '150.00', '0.00', '150.00', '0.00', '150.00', '0.00', '150.00', 0, '', 12, '', 5, 'PO/2023/005', '0.00', 'a'),
(7, 'PB/2023/006', '2023-03-01', 76, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', '', '1820.98', '0.00', '1820.98', '0.00', '1820.98', '0.00', '1820.98', 0, '', 12, '', 11, 'PO/2023/011', '0.00', 'a'),
(8, 'PB/2023/007', '2023-03-07', 23, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', '', '', '600.00', '0.00', '600.00', '0.00', '600.00', '0.00', '600.00', 0, '', 12, '', 28, 'PO/2023/028', '0.00', 'a');

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
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbpurchasebilldetail`
--

INSERT INTO `tbpurchasebilldetail` (`purchaseBillDetail_id`, `purchaseBillDetail_purchaseBillID`, `purchaseBillDetail_no1`, `purchaseBillDetail_no2`, `purchaseBillDetail_no3`, `purchaseBillDetail_no4`, `purchaseBillDetail_bold`, `purchaseBillDetail_sortID`, `purchaseBillDetail_no5`, `purchaseBillDetail_rowTotal`, `purchaseBillDetail_taxRateID`, `purchaseBillDetail_taxPercent`, `purchaseBillDetail_taxTotal`, `purchaseBillDetail_rowGrandTotal`, `purchaseBillDetail_discountPercent`, `purchaseBillDetail_discountAmount`, `purchaseBillDetail_rowTotalAfterDiscount`) VALUES
(6, 2, '', '', '0.00', '', 0, 1, '1000.00', '1000.00', 1, '0.00', '0.00', '1000.00', '0.00', '0.00', '1000.00'),
(7, 2, '', '', '0.00', '', 0, 2, '1000.00', '1000.00', 1, '0.00', '0.00', '1000.00', '0.00', '0.00', '1000.00'),
(8, 2, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(9, 2, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(10, 2, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(11, 3, '', '', '0.00', '', 0, 1, '1000.00', '1000.00', 1, '0.00', '0.00', '1000.00', '0.00', '0.00', '1000.00'),
(12, 3, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(13, 3, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(14, 3, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(15, 3, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(21, 5, '', '', '0.00', '', 0, 1, '5000.00', '5000.00', 1, '0.00', '0.00', '5000.00', '0.00', '0.00', '5000.00'),
(22, 5, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(23, 5, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(24, 5, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(25, 5, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(26, 6, '', 'Jetting Works and Clear blockages with rodder machine', '30.00', 'unit', 0, 1, '5.00', '150.00', 1, '0.00', '0.00', '150.00', '0.00', '0.00', '150.00'),
(27, 6, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(28, 6, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(29, 6, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(30, 6, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(31, 7, '1', 'Jetting Works and Clear blockages with rodder machine', '2.00', 'unit', 0, 1, '5.00', '10.00', 1, '0.00', '0.00', '10.00', '0.00', '0.00', '10.00'),
(32, 7, '2', 'A4 Bahasa Malaysia Exam papers9', '2.00', 'pcs', 0, 2, '5.49', '10.98', 1, '0.00', '0.00', '10.98', '0.00', '0.00', '10.98'),
(33, 7, '3', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '1.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(34, 7, '4', 'Jetting Works and Clear blockages with rodder machine', '1.00', 'unit', 0, 4, '5.00', '5.00', 1, '0.00', '0.00', '5.00', '0.00', '0.00', '5.00'),
(35, 7, '5', 'NOKIA CHARGER TYPE CARBON 4598BK', '0.00', 'UNIT', 0, 5, '50.00', '50.00', 1, '0.00', '0.00', '50.00', '0.00', '0.00', '50.00'),
(36, 7, '5', 'MOTOROLLA HANDPHONE MODEL X-9', '0.00', 'unit', 0, 6, '1340.00', '1340.00', 1, '0.00', '0.00', '1340.00', '0.00', '0.00', '1340.00'),
(37, 7, '1', 'Screw Holland made 6 type', '0.00', '', 0, 7, '55.00', '55.00', 1, '0.00', '0.00', '55.00', '0.00', '0.00', '55.00'),
(38, 7, '2', 'NOKIA CHARGER TYPE CARBON 4598BK', '0.00', 'UNIT', 0, 8, '50.00', '50.00', 1, '0.00', '0.00', '50.00', '0.00', '0.00', '50.00'),
(39, 7, '3', 'TOP RADIATOR HOSE ORIGINAL', '0.00', '', 0, 9, '300.00', '300.00', 1, '0.00', '0.00', '300.00', '0.00', '0.00', '300.00'),
(40, 8, '', 'RENTAL OPTION', '0.00', '', 0, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(41, 8, '', 'Contract Renewal\r\n6 - Month Subscription Fee\r\nSubscription Date : March 2023 - August 2023', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(42, 8, '', 'Vehicle List:', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(43, 8, '1.', 'WEN 9196 (139)', '1.00', 'unit', 0, 4, '300.00', '300.00', 1, '0.00', '0.00', '300.00', '0.00', '0.00', '300.00'),
(44, 8, '2.', 'MDB 9196 (140)', '1.00', 'unit', 0, 5, '300.00', '300.00', 1, '0.00', '0.00', '300.00', '0.00', '0.00', '300.00'),
(45, 8, '', '', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(46, 8, '', '', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(47, 8, '', '', '0.00', '', 0, 8, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(48, 8, '', '', '0.00', '', 0, 9, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(49, 8, '', '', '0.00', '', 0, 10, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00');

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
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbpurchaseorder`
--

INSERT INTO `tbpurchaseorder` (`purchaseOrder_id`, `purchaseOrder_no`, `purchaseOrder_date`, `purchaseOrder_customerID`, `purchaseOrder_title`, `purchaseOrder_from`, `purchaseOrder_terms`, `purchaseOrder_attention`, `purchaseOrder_email`, `purchaseOrder_subTotal`, `purchaseOrder_taxTotal`, `purchaseOrder_grandTotal`, `purchaseOrder_discountTotal`, `purchaseOrder_totalAfterDiscount`, `purchaseOrder_roundAmount`, `purchaseOrder_grandTotalRound`, `purchaseOrder_roundStatus`, `purchaseOrder_content`, `purchaseOrder_purchaseBillID`, `purchaseOrder_purchaseBillNo`) VALUES
(1, 'PO/2023/001', '2023-03-01', 51, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '132.49', '0.00', '132.49', '0.00', '132.49', '0.00', '132.49', 0, '', 3, 'PB/2023/003'),
(2, 'PO/2023/002', '2023-03-01', 74, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', '', '', '2000.00', '0.00', '2000.00', '0.00', '2000.00', '0.00', '2000.00', 0, '', 0, ''),
(3, 'PO/2023/003', '2023-03-01', 3, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', '', '', '3000.00', '0.00', '3000.00', '0.00', '3000.00', '0.00', '3000.00', 0, '', 0, ''),
(4, 'PO/2023/004', '2023-03-01', 67, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'Mr Ramachandrean', 'caresome_90@gmail.com', '5000.00', '0.00', '5000.00', '0.00', '5000.00', '0.00', '5000.00', 0, '', 5, 'PB/2023/004'),
(5, 'PO/2023/005', '2023-03-01', 92, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', '', '', '150.00', '0.00', '150.00', '0.00', '150.00', '0.00', '150.00', 0, '', 6, 'PB/2023/005'),
(6, 'PO/2023/006', '2023-03-01', 51, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '16.47', '0.23', '15.88', '0.82', '15.65', '0.00', '15.88', 0, '', 0, ''),
(7, 'PO/2023/007', '2023-03-01', 83, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', '', '', '1440.00', '0.00', '1440.00', '0.00', '1440.00', '0.00', '1440.00', 0, '', 0, ''),
(8, 'PO/2023/008', '2023-03-01', 51, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '177.49', '0.00', '177.49', '0.00', '177.49', '0.00', '177.49', 0, '', 0, ''),
(9, 'PO/2023/009', '2023-03-01', 75, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'MR RAYMOND', '', '127.00', '0.00', '127.00', '0.00', '127.00', '0.00', '127.00', 0, '', 0, ''),
(10, 'PO/2023/010', '2023-03-01', 8, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'Hariharan', 'ayur_90@gmail.com', '127.00', '0.00', '127.00', '0.00', '127.00', '0.00', '127.00', 0, '', 0, ''),
(11, 'PO/2023/011', '2023-03-01', 76, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', '', '1942.98', '0.00', '1942.98', '0.00', '1942.98', '0.00', '1942.98', 0, '', 7, 'PB/2023/006'),
(12, 'PO/2023/012', '2023-03-01', 81, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', '', '', '1192.98', '16.83', '1209.81', '0.00', '1192.98', '-0.01', '1209.80', 1, '', 0, ''),
(13, 'PO/2023/013', '2023-03-02', 40, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'MR RAMESH (DATOK)', '', '4172.00', '1309.00', '5472.99', '8.01', '4163.99', '0.01', '5473.00', 1, '', 0, ''),
(14, 'PO/2023/014', '2023-03-02', 8, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'Hariharan', 'ayur_90@gmail.com', '77.00', '0.00', '77.00', '0.00', '77.00', '0.00', '77.00', 0, '', 0, ''),
(15, 'PO/2023/015', '2023-03-02', 3, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', '', '', '6000.00', '0.00', '6000.00', '0.00', '6000.00', '0.00', '6000.00', 0, '', 0, ''),
(16, 'PO/2023/016', '2023-03-02', 51, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '8859.94', '101.25', '8211.19', '750.00', '8109.94', '0.00', '8211.19', 0, '', 0, ''),
(17, 'PO/2023/017', '2023-03-02', 76, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', '', '474.45', '16.13', '490.58', '0.00', '474.45', '0.02', '490.60', 1, '', 0, ''),
(18, 'PO/2023/018', '2023-03-02', 81, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0, '<p>testing</p>', 0, ''),
(19, 'PO/2023/019', '2023-03-03', 71, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', '', '', '1735.00', '0.00', '1735.00', '0.00', '1735.00', '0.00', '1735.00', 0, '', 0, ''),
(20, 'PO/2023/020', '2023-03-03', 93, 'Oncore Fleet Solution Version 3.0 Half Year Fee', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'MR ANAND MUNIANDY', 'info@rightontrack.com.my', '600.00', '0.00', '600.00', '0.00', '600.00', '0.00', '600.00', 0, '', 0, ''),
(21, 'PO/2023/021', '2023-03-05', 75, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', '', 'jumaatengineering@gmail.com', '888.00', '0.00', '888.00', '0.00', '888.00', '0.00', '888.00', 0, '', 0, ''),
(22, 'PO/2023/022', '2023-03-06', 12, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'Mr Paramisivam', 'berjaya_eara@yahoo.com', '99.00', '0.00', '99.00', '0.00', '99.00', '0.00', '99.00', 0, '', 0, ''),
(23, 'PO/2023/023', '2023-03-06', 11, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'reqdsdsd', '', '555.00', '0.00', '555.00', '0.00', '555.00', '0.00', '555.00', 0, '', 0, ''),
(24, 'PO/2023/024', '2023-03-06', 33, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'Hariharan', 'ayur_90@gmail.com', '2277.00', '0.00', '2277.00', '0.00', '2277.00', '0.00', '2277.00', 0, '', 0, ''),
(25, 'PO/2023/025', '2023-03-07', 51, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'undefined', 'ahsn_90@gmail.com', '267.45', '0.00', '267.45', '0.00', '267.45', '0.00', '267.45', 0, '', 0, ''),
(26, 'PO/2023/026', '2023-03-07', 11, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'Mr Saravanan', 'sara_98@hotmail.com', '2562.00', '703.80', '3265.80', '0.00', '2562.00', '0.00', '3265.80', 0, '', 0, ''),
(27, 'PO/2023/027', '2023-03-07', 67, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'Mr Ramachandrean', 'caresome_90@gmail.com', '6000.00', '0.00', '5400.00', '600.00', '5400.00', '0.00', '5400.00', 0, '', 0, ''),
(28, 'PO/2023/028', '2023-03-07', 23, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', '', '', '600.00', '0.00', '600.00', '0.00', '600.00', '0.00', '600.00', 0, '', 8, 'PB/2023/007'),
(29, 'PO/2023/029', '2023-03-09', 51, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '1277.00', '0.00', '1277.00', '0.00', '1277.00', '0.00', '1277.00', 0, '', 0, ''),
(30, 'PO/2023/030', '2023-03-08', 11, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'Mr Saravanan', 'sara_98@hotmail.com', '600.00', '0.00', '600.00', '0.00', '600.00', '0.00', '600.00', 0, '', 0, ''),
(31, 'PO/2023/031', '2023-03-09', 76, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', '', '4177.00', '1.53', '4178.53', '0.00', '4177.00', '0.02', '4178.55', 1, '', 0, ''),
(32, 'PO/2023/032', '2023-03-09', 11, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'Mr Saravanan', 'sara_98@hotmail.com', '4177.00', '1.53', '4178.53', '0.00', '4177.00', '0.02', '4178.55', 1, '', 0, ''),
(33, 'PO/2023/033', '2023-03-11', 94, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'MR RAMESH / SHOBA', 'admin@clean_sewers.com', '333.00', '0.00', '333.00', '0.00', '333.00', '0.00', '333.00', 0, '', 0, ''),
(34, 'PO/2023/034', '2023-03-11', 54, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'Ms Faridah Binti Noor', '', '400.00', '0.00', '400.00', '0.00', '400.00', '0.00', '400.00', 0, '', 0, ''),
(35, 'PO/2023/035', '2023-03-11', 82, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', '', '', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 0, '', 0, ''),
(36, 'PO/2023/036', '2023-03-12', 76, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', '', '900.00', '12.42', '840.42', '72.00', '828.00', '-0.02', '840.40', 1, '', 0, ''),
(37, 'PO/2023/037', '2023-03-12', 21, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'Madam Devi Nair', 'devi_epson@gmail.com', '900.00', '12.42', '840.42', '72.00', '828.00', '-0.02', '840.40', 1, '', 0, ''),
(38, 'PO/2023/038', '2023-03-12', 21, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'Madam Devi Nair', 'devi_epson@gmail.com', '1277.00', '0.00', '1277.00', '0.00', '1277.00', '0.00', '1277.00', 0, '', 0, ''),
(39, 'PO/2023/039', '2023-03-12', 51, 'PURCHASE OF MEDICINES FROM INDIA KERALA ( TY466663)', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '748.00', '53.75', '779.17', '22.58', '725.42', '-0.02', '779.15', 1, '<p>PLEASE SEND ALL THE MEDICINES AFTER CHECKING ALL EXPIRY DATES AND THE TRANSPORT CONDITIONS.</p><p>SEND TO PORT KLANG WAREHOUES 45B LOT 675</p>', 0, ''),
(40, 'PO/2023/040', '2023-03-12', 80, '', '', '<p><strong>Purchase Order Terms</strong></p><ol><li>PO terms annd te ther day</li><li>f.) Hirer have to issue the Purchase Order before we can proceed the job.</li></ol>', 'MR KAMARUDDING', '', '2998.00', '85.82', '2948.74', '135.08', '2862.92', '0.01', '2948.75', 1, '<p>PLEASE SEND ALL THE MEDICINES AFTER CHECKING ALL EXPIRY DATES AND THE TRANSPORT CONDITIONS.</p><p>SEND TO PORT KLANG WAREHOUES 45B LOT 675</p>', 0, '');

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
) ENGINE=InnoDB AUTO_INCREMENT=485 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbpurchaseorderdetail`
--

INSERT INTO `tbpurchaseorderdetail` (`purchaseOrderDetail_id`, `purchaseOrderDetail_purchaseOrderID`, `purchaseOrderDetail_no1`, `purchaseOrderDetail_no2`, `purchaseOrderDetail_no3`, `purchaseOrderDetail_no4`, `purchaseOrderDetail_bold`, `purchaseOrderDetail_sortID`, `purchaseOrderDetail_no5`, `purchaseOrderDetail_rowTotal`, `purchaseOrderDetail_taxRateID`, `purchaseOrderDetail_taxPercent`, `purchaseOrderDetail_taxTotal`, `purchaseOrderDetail_rowGrandTotal`, `purchaseOrderDetail_discountPercent`, `purchaseOrderDetail_discountAmount`, `purchaseOrderDetail_rowTotalAfterDiscount`) VALUES
(6, 2, '', '', '0.00', '', 0, 1, '1000.00', '1000.00', 1, '0.00', '0.00', '1000.00', '0.00', '0.00', '1000.00'),
(7, 2, '', '', '0.00', '', 0, 2, '1000.00', '1000.00', 1, '0.00', '0.00', '1000.00', '0.00', '0.00', '1000.00'),
(8, 2, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(9, 2, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(10, 2, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(16, 3, '', '', '0.00', '', 0, 1, '1000.00', '1000.00', 1, '0.00', '0.00', '1000.00', '0.00', '0.00', '1000.00'),
(17, 3, '', '', '0.00', '', 0, 2, '2000.00', '2000.00', 1, '0.00', '0.00', '2000.00', '0.00', '0.00', '2000.00'),
(18, 3, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(19, 3, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(20, 3, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(21, 4, '', '', '0.00', '', 0, 1, '5000.00', '5000.00', 1, '0.00', '0.00', '5000.00', '0.00', '0.00', '5000.00'),
(22, 4, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(23, 4, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(24, 4, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(25, 4, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(26, 5, '', 'Jetting Works and Clear blockages with rodder machine', '30.00', 'unit', 0, 1, '5.00', '150.00', 1, '0.00', '0.00', '150.00', '0.00', '0.00', '150.00'),
(27, 5, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(28, 5, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(29, 5, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(30, 5, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(41, 6, '', 'Curry Puff Flour 1.8kg', '3.00', 'packet', 0, 1, '5.49', '16.47', 6, '1.50', '0.23', '15.88', '5.00', '0.82', '15.65'),
(42, 6, '', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 1, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(43, 6, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(44, 6, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(45, 6, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(59, 8, '1', 'A4 Bahasa Malaysia Exam papers9', '0.00', 'pcs', 0, 1, '5.49', '5.49', 1, '0.00', '0.00', '5.49', '0.00', '0.00', '5.49'),
(60, 8, '2', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 0, 2, '45.00', '45.00', 1, '0.00', '0.00', '45.00', '0.00', '0.00', '45.00'),
(61, 8, '3', 'Desludging Tanker 10 cubic metres (Cina Made)', '0.00', 'units', 0, 3, '77.00', '77.00', 1, '0.00', '0.00', '77.00', '0.00', '0.00', '77.00'),
(62, 8, '', 'NOKIA CHARGER TYPE CARBON 4598BK', '0.00', '', 1, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(63, 8, '1', 'Jetting Works and Clear blockages with rodder machine', '0.00', 'unit', 0, 5, '5.00', '5.00', 1, '0.00', '0.00', '5.00', '0.00', '0.00', '5.00'),
(64, 8, '2', 'Screw made in taiwan 67 size', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(65, 8, '', 'Transport', '0.00', '', 1, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(66, 8, '1', 'Chicken Eggs \r\nMount Road Poulty Farm', '0.00', '', 0, 8, '45.00', '45.00', 1, '0.00', '0.00', '45.00', '0.00', '0.00', '45.00'),
(67, 9, '', 'Jetting Works and Clear blockages with rodder machine', '0.00', 'unit', 1, 1, '5.00', '5.00', 1, '0.00', '0.00', '5.00', '0.00', '0.00', '5.00'),
(68, 9, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(69, 9, '', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 0, 3, '45.00', '45.00', 1, '0.00', '0.00', '45.00', '0.00', '0.00', '45.00'),
(70, 9, '', 'Screw made in taiwan 67 size', '0.00', '', 1, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(71, 9, '', 'Desludging Tanker 10 cubic metres (Cina Made)', '0.00', 'units', 1, 5, '77.00', '77.00', 1, '0.00', '0.00', '77.00', '0.00', '0.00', '77.00'),
(77, 10, '', 'Jetting Works and Clear blockages with rodder machine', '0.00', 'unit', 1, 1, '5.00', '5.00', 1, '0.00', '0.00', '5.00', '0.00', '0.00', '5.00'),
(78, 10, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only. This information please s', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(79, 10, '', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 0, 3, '45.00', '45.00', 1, '0.00', '0.00', '45.00', '0.00', '0.00', '45.00'),
(80, 10, '', 'Screw made in taiwan 67 size', '0.00', '', 1, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(81, 10, '', 'Desludging Tanker 10 cubic metres (Cina Made)', '0.00', 'units', 1, 5, '77.00', '77.00', 1, '0.00', '0.00', '77.00', '0.00', '0.00', '77.00'),
(141, 1, '', 'Desludging Tanker 10 cubic metres (Cina Made)', '0.00', 'units', 0, 1, '77.00', '77.00', 1, '0.00', '0.00', '77.00', '0.00', '0.00', '77.00'),
(142, 1, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(143, 1, '', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 1, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(144, 1, '', 'A4 Bahasa Malaysia Exam papers9', '0.00', 'pcs', 0, 4, '5.49', '5.49', 1, '0.00', '0.00', '5.49', '0.00', '0.00', '5.49'),
(145, 1, '', 'NOKIA CHARGER TYPE CARBON 4598BK', '0.00', 'UNIT', 0, 5, '50.00', '50.00', 1, '0.00', '0.00', '50.00', '0.00', '0.00', '50.00'),
(156, 12, '1.', 'Please send all the warehouse goods to Port Klang', '0.00', '', 1, 1, '0.00', '0.00', 6, '1.50', '0.00', '0.00', '0.00', '0.00', '0.00'),
(157, 12, 'a.', 'A4 Bahasa Malaysia Exam papers9', '2.00', 'pcs', 1, 2, '5.49', '10.98', 1, '0.00', '0.00', '10.98', '0.00', '0.00', '10.98'),
(158, 12, 'b.', 'Jetting Works and Clear blockages with rodder machine', '12.00', 'unit', 0, 3, '5.00', '60.00', 1, '0.00', '0.00', '60.00', '0.00', '0.00', '60.00'),
(159, 12, 'c.', 'Teak Wood furniture sofa chair', '33.00', '', 0, 4, '34.00', '1122.00', 6, '1.50', '16.83', '1138.83', '0.00', '0.00', '1122.00'),
(160, 12, 'd.', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '6.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(161, 12, '', '', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(162, 12, '', '', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(163, 12, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '0.00', '', 1, 8, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(164, 13, '', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 1, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(165, 13, '', 'NOKIA CHARGER TYPE CARBON 4598BK', '5.00', 'UNIT', 0, 2, '50.00', '250.00', 4, '34.00', '85.00', '335.00', '0.00', '0.00', '250.00'),
(166, 13, '', 'Screw Holland made 6 type', '0.00', '', 0, 3, '55.00', '55.00', 1, '0.00', '0.00', '55.00', '0.00', '0.00', '55.00'),
(167, 13, '', 'AUTOMATIC TRANSMISSION FLUID', '3.00', 'unit', 0, 4, '89.00', '267.00', 1, '0.00', '0.00', '258.99', '3.00', '8.01', '258.99'),
(168, 13, '', 'TOP RADIATOR HOSE ORIGINAL', '12.00', 'litres', 0, 5, '300.00', '3600.00', 4, '34.00', '1224.00', '4824.00', '0.00', '0.00', '3600.00'),
(169, 14, '', 'Desludging Tanker 10 cubic metres (Cina Made)', '0.00', 'units', 0, 1, '77.00', '77.00', 1, '0.00', '0.00', '77.00', '0.00', '0.00', '77.00'),
(170, 14, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only. All the next issue can be', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(171, 14, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(172, 14, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(173, 14, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(174, 7, '1', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 1, 1, '45.00', '45.00', 1, '0.00', '0.00', '45.00', '0.00', '0.00', '45.00'),
(175, 7, '', 'Jetting Works and Clear blockages with rodder machine', '0.00', 'unit', 0, 2, '5.00', '5.00', 1, '0.00', '0.00', '5.00', '0.00', '0.00', '5.00'),
(176, 7, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(177, 7, '2', 'MOTOROLLA HANDPHONE MODEL X-9', '0.00', 'unit', 1, 4, '1340.00', '1340.00', 1, '0.00', '0.00', '1340.00', '0.00', '0.00', '1340.00'),
(178, 7, '3', 'NOKIA CHARGER TYPE CARBON 4598BK', '0.00', 'UNIT', 1, 5, '50.00', '50.00', 1, '0.00', '0.00', '50.00', '0.00', '0.00', '50.00'),
(179, 7, '', '', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(180, 7, '', '', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(181, 7, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '0.00', '', 0, 8, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(192, 15, '1.', 'Cut the tree and dispose all the branches into the Roro industrial bin. Compulsory for the write off and see its final verrsoion\r\nPrice quoted including disposal rates at authorised site.', '0.00', '', 0, 1, '6000.00', '6000.00', 1, '0.00', '0.00', '6000.00', '0.00', '0.00', '6000.00'),
(193, 15, '', 'ncacvavcaxv xvv dvda vwdvdvdvjhvjhdvj for this reason and its not normal fnq fkbfjdb b bd gg\r\nd gdgbdkbgdsb gdbgbgsd g\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\ngd gadsg d', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(194, 15, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(195, 15, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(196, 15, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(209, 11, '1', 'Jetting Works and Clear blockages with rodder machine', '2.00', 'unit', 0, 1, '5.00', '10.00', 1, '0.00', '0.00', '10.00', '0.00', '0.00', '10.00'),
(210, 11, '2', 'A4 Bahasa Malaysia Exam papers9', '2.00', 'pcs', 0, 2, '5.49', '10.98', 1, '0.00', '0.00', '10.98', '0.00', '0.00', '10.98'),
(211, 11, '3', 'NOKIA CHARGER TYPE CARBON 4598BK', '1.00', 'UNIT', 1, 3, '50.00', '50.00', 1, '0.00', '0.00', '50.00', '0.00', '0.00', '50.00'),
(212, 11, '4', 'Desludging Tanker 10 cubic metres (Cina Made)', '1.00', 'units', 0, 4, '77.00', '77.00', 1, '0.00', '0.00', '77.00', '0.00', '0.00', '77.00'),
(213, 11, '5', 'NOKIA CHARGER TYPE CARBON 4598BK', '0.00', 'UNIT', 0, 5, '50.00', '50.00', 1, '0.00', '0.00', '50.00', '0.00', '0.00', '50.00'),
(214, 11, '5', 'MOTOROLLA HANDPHONE MODEL X-9', '0.00', 'unit', 1, 6, '1340.00', '1340.00', 1, '0.00', '0.00', '1340.00', '0.00', '0.00', '1340.00'),
(215, 11, '1', 'Screw Holland made 6 type', '0.00', '', 0, 7, '55.00', '55.00', 1, '0.00', '0.00', '55.00', '0.00', '0.00', '55.00'),
(216, 11, '2', 'NOKIA CHARGER TYPE CARBON 4598BK', '0.00', 'UNIT', 0, 8, '50.00', '50.00', 1, '0.00', '0.00', '50.00', '0.00', '0.00', '50.00'),
(217, 11, '3', 'TOP RADIATOR HOSE ORIGINAL', '0.00', '', 0, 9, '300.00', '300.00', 1, '0.00', '0.00', '300.00', '0.00', '0.00', '300.00'),
(218, 11, '', '', '0.00', '', 0, 10, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(219, 11, '', '', '0.00', '', 0, 11, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(220, 11, '', '', '0.00', '', 0, 12, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(268, 17, '1', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '0.00', '', 1, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(269, 17, '2', 'Electrical Cable Malaysia Made', '5.00', 'pc', 0, 2, '9.49', '47.45', 4, '34.00', '16.13', '63.58', '0.00', '0.00', '47.45'),
(270, 17, '3', 'Desludging Tanker 10 cubic metres (Cina Made)', '0.00', 'units', 1, 3, '77.00', '77.00', 1, '0.00', '0.00', '77.00', '0.00', '0.00', '77.00'),
(271, 17, '4', 'NOKIA CHARGER TYPE CARBON 4598BK', '0.00', 'UNIT', 0, 4, '50.00', '50.00', 1, '0.00', '0.00', '50.00', '0.00', '0.00', '50.00'),
(272, 17, '5', 'TOP RADIATOR HOSE ORIGINAL', '0.00', '', 0, 5, '300.00', '300.00', 1, '0.00', '0.00', '300.00', '0.00', '0.00', '300.00'),
(274, 18, '', '', '0.00', '', 0, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(275, 18, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(276, 18, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(277, 18, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(278, 18, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(279, 18, '', '', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(280, 18, '', '', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(281, 19, '', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 1, 1, '45.00', '45.00', 1, '0.00', '0.00', '45.00', '0.00', '0.00', '45.00'),
(282, 19, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(283, 19, '', 'MOTOROLLA HANDPHONE MODEL X-9', '0.00', 'unit', 0, 3, '1340.00', '1340.00', 1, '0.00', '0.00', '1340.00', '0.00', '0.00', '1340.00'),
(284, 19, '', 'TOP RADIATOR HOSE ORIGINAL', '0.00', '', 0, 4, '300.00', '300.00', 1, '0.00', '0.00', '300.00', '0.00', '0.00', '300.00'),
(285, 19, '', 'NOKIA CHARGER TYPE CARBON 4598BK', '0.00', 'UNIT', 0, 5, '50.00', '50.00', 1, '0.00', '0.00', '50.00', '0.00', '0.00', '50.00'),
(286, 19, '', '', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(287, 19, '', '', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(295, 16, '1.', 'Jetting Works', '0.00', '', 1, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '10.00', '0.00', '0.00'),
(296, 16, 'a.', 'Use Jetter Truck machine for the jetting sewerage Pipe works.', '0.00', 'l/s', 0, 2, '7500.00', '7500.00', 6, '1.50', '101.25', '6851.25', '10.00', '750.00', '6750.00'),
(297, 16, 'b.', 'Jetting uses very high pressure work flow to clear the pipes of all blockages and dirt.\r\nThe complete package is valid for 14 days only from date issued.', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(298, 16, '2.', 'Labour', '0.00', '', 1, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(299, 16, 'a.', 'Supply skilled labour and tools including materials', '0.00', '', 0, 5, '1350.45', '1350.45', 1, '0.00', '0.00', '1350.45', '0.00', '0.00', '1350.45'),
(300, 16, 'b.', 'All the staff have CIDB, SPAN and other relevant Licences.\r\nPlease check with the company for further information.\r\nAll the business is legal and IWK Compliant.', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(301, 16, 'c.', 'Electrical Cable Malaysia Made', '0.00', 'pc', 0, 7, '9.49', '9.49', 1, '0.00', '0.00', '9.49', '0.00', '0.00', '9.49'),
(302, 16, '', '', '0.00', '', 0, 8, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(303, 16, '', '', '0.00', '', 0, 9, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(304, 20, '', 'RENTAL OPTION', '0.00', '', 1, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(305, 20, '', 'Contract Renewal\r\n6 - Month Subscription Fee\r\nSubscription Date : March 2023 - August 2023', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(306, 20, '', 'Vehicle List:', '0.00', '', 1, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(307, 20, '1.', 'WEN 9196 (139)', '1.00', 'unit', 0, 4, '300.00', '300.00', 1, '0.00', '0.00', '300.00', '0.00', '0.00', '300.00'),
(308, 20, '2.', 'MDB 9196 (140)', '1.00', 'unit', 0, 5, '300.00', '300.00', 1, '0.00', '0.00', '300.00', '0.00', '0.00', '300.00'),
(309, 20, '', '', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(310, 20, '', '', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(311, 20, '', '', '0.00', '', 0, 8, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(312, 20, '', '', '0.00', '', 0, 9, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(313, 20, '', '', '0.00', '', 0, 10, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(314, 21, '', '', '0.00', '', 0, 1, '888.00', '888.00', 1, '0.00', '0.00', '888.00', '0.00', '0.00', '888.00'),
(315, 21, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(316, 21, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(317, 21, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(318, 21, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(319, 22, '', '', '0.00', '', 0, 1, '99.00', '99.00', 1, '0.00', '0.00', '99.00', '0.00', '0.00', '99.00'),
(320, 22, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(321, 22, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(322, 22, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(323, 22, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(324, 23, '', '', '0.00', '', 0, 1, '555.00', '555.00', 1, '0.00', '0.00', '555.00', '0.00', '0.00', '555.00'),
(325, 23, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(326, 23, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(327, 23, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(328, 23, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(329, 24, '', '', '0.00', '', 0, 1, '700.00', '700.00', 1, '0.00', '0.00', '700.00', '0.00', '0.00', '700.00'),
(330, 24, '', '', '0.00', '', 0, 2, '800.00', '800.00', 1, '0.00', '0.00', '800.00', '0.00', '0.00', '800.00'),
(331, 24, '', '', '0.00', '', 0, 3, '777.00', '777.00', 1, '0.00', '0.00', '777.00', '0.00', '0.00', '777.00'),
(332, 24, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(333, 24, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(334, 25, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '5.00', '', 0, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(335, 25, '', 'Screw Holland made 6 type', '4.00', '', 1, 2, '55.00', '220.00', 1, '0.00', '0.00', '220.00', '0.00', '0.00', '220.00'),
(336, 25, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(337, 25, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(338, 25, '', 'Electrical Cable Malaysia Made', '5.00', 'pc', 0, 5, '9.49', '47.45', 1, '0.00', '0.00', '47.45', '0.00', '0.00', '47.45'),
(344, 26, '1', 'LABOUR TO REPLACE PARTS & SERVICE', '3.00', '', 1, 1, '45.00', '135.00', 1, '0.00', '0.00', '135.00', '0.00', '0.00', '135.00'),
(345, 26, '2', 'NOKIA CHARGER TYPE CARBON 4598BK', '4.00', 'UNIT', 0, 2, '50.00', '200.00', 1, '0.00', '0.00', '200.00', '0.00', '0.00', '200.00'),
(346, 26, '3', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '3.00', '', 0, 3, '690.00', '2070.00', 4, '34.00', '703.80', '2773.80', '0.00', '0.00', '2070.00'),
(347, 26, '4', 'Teak Wood furniture sofa chair', '3.00', '', 0, 4, '34.00', '102.00', 1, '0.00', '0.00', '102.00', '0.00', '0.00', '102.00'),
(348, 26, '5', 'Screw Holland made 6 type', '1.00', '', 0, 5, '55.00', '55.00', 1, '0.00', '0.00', '55.00', '0.00', '0.00', '55.00'),
(349, 27, '', '', '0.00', '', 0, 1, '6000.00', '6000.00', 1, '0.00', '0.00', '5400.00', '10.00', '600.00', '5400.00'),
(350, 27, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(351, 27, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(352, 27, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(353, 27, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(354, 28, '', 'RENTAL OPTION', '0.00', '', 1, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(355, 28, '', 'Contract Renewal\r\n6 - Month Subscription Fee\r\nSubscription Date : March 2023 - August 2023', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(356, 28, '', 'Vehicle List:', '0.00', '', 1, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(357, 28, '1.', 'WEN 9196 (139)', '1.00', 'unit', 0, 4, '300.00', '300.00', 1, '0.00', '0.00', '300.00', '0.00', '0.00', '300.00'),
(358, 28, '2.', 'MDB 9196 (140)', '1.00', 'unit', 0, 5, '300.00', '300.00', 1, '0.00', '0.00', '300.00', '0.00', '0.00', '300.00'),
(359, 28, '', '', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(360, 28, '', '', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(361, 28, '', '', '0.00', '', 0, 8, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(362, 28, '', '', '0.00', '', 0, 9, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(363, 28, '', '', '0.00', '', 0, 10, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(364, 29, '1', 'LABOUR TO REPLACE PARTS & SERVICE', '11.00', '', 1, 1, '45.00', '495.00', 1, '0.00', '0.00', '495.00', '0.00', '0.00', '495.00'),
(365, 29, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(366, 29, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(367, 29, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(368, 29, '2', 'Teak Wood furniture sofa chair', '23.00', '', 0, 5, '34.00', '782.00', 1, '0.00', '0.00', '782.00', '0.00', '0.00', '782.00'),
(369, 30, '', 'RENTAL OPTION', '0.00', '', 1, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(370, 30, '', 'Contract Renewal\r\n6 - Month Subscription Fee\r\nSubscription Date : March 2023 - August 2023', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(371, 30, '', 'Vehicle List:', '0.00', '', 1, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(372, 30, '1.', 'WEN 9196 (139)', '1.00', 'unit', 0, 4, '300.00', '300.00', 1, '0.00', '0.00', '300.00', '0.00', '0.00', '300.00'),
(373, 30, '2.', 'MDB 9196 (140)', '1.00', 'unit', 0, 5, '300.00', '300.00', 1, '0.00', '0.00', '300.00', '0.00', '0.00', '300.00'),
(374, 30, '', '', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(375, 30, '', '', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(376, 30, '', '', '0.00', '', 0, 8, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(377, 30, '', '', '0.00', '', 0, 9, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(378, 30, '', '', '0.00', '', 0, 10, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(379, 31, '1', 'MOTOROLLA HANDPHONE MODEL X-9', '3.00', 'unit', 0, 1, '1340.00', '4020.00', 1, '0.00', '0.00', '4020.00', '0.00', '0.00', '4020.00'),
(380, 31, '2', 'Teak Wood furniture sofa chair', '3.00', '', 0, 2, '34.00', '102.00', 6, '1.50', '1.53', '103.53', '0.00', '0.00', '102.00'),
(381, 31, '3', 'Jetting Works and Clear blockages with rodder machine', '0.00', 'unit', 0, 3, '5.00', '5.00', 1, '0.00', '0.00', '5.00', '0.00', '0.00', '5.00'),
(382, 31, '4', 'NOKIA CHARGER TYPE CARBON 4598BK', '0.00', 'UNIT', 0, 4, '50.00', '50.00', 1, '0.00', '0.00', '50.00', '0.00', '0.00', '50.00'),
(383, 31, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '0.00', '', 1, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(384, 31, '', '', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(385, 32, '1', 'MOTOROLLA HANDPHONE MODEL X-9', '3.00', 'unit', 0, 1, '1340.00', '4020.00', 1, '0.00', '0.00', '4020.00', '0.00', '0.00', '4020.00'),
(386, 32, '2', 'Teak Wood furniture sofa chair', '3.00', '', 0, 2, '34.00', '102.00', 6, '1.50', '1.53', '103.53', '0.00', '0.00', '102.00'),
(387, 32, '3', 'Jetting Works and Clear blockages with rodder machine', '0.00', 'unit', 0, 3, '5.00', '5.00', 1, '0.00', '0.00', '5.00', '0.00', '0.00', '5.00'),
(388, 32, '4', 'NOKIA CHARGER TYPE CARBON 4598BK', '0.00', 'UNIT', 0, 4, '50.00', '50.00', 1, '0.00', '0.00', '50.00', '0.00', '0.00', '50.00'),
(389, 32, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '0.00', '', 1, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(390, 32, '', '', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(391, 33, '', '', '0.00', '', 0, 1, '333.00', '333.00', 1, '0.00', '0.00', '333.00', '0.00', '0.00', '333.00'),
(392, 33, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(393, 33, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(394, 33, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(395, 33, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(396, 34, '', '', '2.00', '', 0, 1, '200.00', '400.00', 1, '0.00', '0.00', '400.00', '0.00', '0.00', '400.00'),
(397, 34, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(398, 34, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(399, 34, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(400, 34, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(401, 35, '', '', '0.00', '', 0, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(402, 35, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(403, 35, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(404, 35, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(405, 35, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(406, 36, '', '', '0.00', '', 0, 1, '0.00', '0.00', 2, '6.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(407, 36, '', '', '0.00', '', 0, 2, '900.00', '900.00', 6, '1.50', '12.42', '840.42', '8.00', '72.00', '828.00'),
(408, 36, '', '', '0.00', '', 0, 3, '0.00', '0.00', 2, '6.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(409, 36, '', '', '0.00', '', 0, 4, '0.00', '0.00', 5, '8.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(410, 36, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(411, 37, '', '', '0.00', '', 0, 1, '0.00', '0.00', 2, '6.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(412, 37, '', '', '0.00', '', 0, 2, '900.00', '900.00', 6, '1.50', '12.42', '840.42', '8.00', '72.00', '828.00'),
(413, 37, '', '', '0.00', '', 0, 3, '0.00', '0.00', 2, '6.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(414, 37, '', '', '0.00', '', 0, 4, '0.00', '0.00', 5, '8.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(415, 37, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(416, 38, '1', 'LABOUR TO REPLACE PARTS & SERVICE', '11.00', '', 1, 1, '45.00', '495.00', 1, '0.00', '0.00', '495.00', '0.00', '0.00', '495.00'),
(417, 38, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(418, 38, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(419, 38, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(420, 38, '2', 'Teak Wood furniture sofa chair', '23.00', '', 0, 5, '34.00', '782.00', 1, '0.00', '0.00', '782.00', '0.00', '0.00', '782.00'),
(429, 39, '', 'TABLET', '0.00', '', 1, 1, '0.00', '0.00', 3, '10.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(430, 39, '1.', 'AUTOMATIC TRANSMISSION FLUID', '2.00', 'unit', 0, 2, '89.00', '178.00', 1, '0.00', '0.00', '167.32', '6.00', '10.68', '167.32'),
(431, 39, '2.', 'NOKIA CHARGER TYPE CARBON 4598BK', '2.00', 'UNIT', 0, 3, '50.00', '100.00', 1, '0.00', '0.00', '100.00', '0.00', '0.00', '100.00'),
(432, 39, '3.', 'Jetting Works and Clear blockages with rodder machine', '5.00', 'unit', 0, 4, '5.00', '25.00', 1, '0.00', '0.00', '25.00', '0.00', '0.00', '25.00'),
(433, 39, '', 'OINTMENT', '0.00', '', 1, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(434, 39, '1.', 'Teak Wood furniture sofa chair', '5.00', '', 0, 6, '34.00', '170.00', 4, '34.00', '53.75', '211.85', '7.00', '11.90', '158.10'),
(435, 39, '2.', 'Screw Holland made 6 type', '5.00', '', 0, 7, '55.00', '275.00', 1, '0.00', '0.00', '275.00', '0.00', '0.00', '275.00'),
(436, 39, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '13.00', '', 0, 8, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(437, 39, '', '', '0.00', '', 0, 9, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(438, 39, '', '', '0.00', '', 0, 10, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(439, 39, '', '', '0.00', '', 0, 11, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(440, 39, '', '', '0.00', '', 0, 12, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(441, 39, '', '', '0.00', '', 0, 13, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(442, 39, '', '', '0.00', '', 0, 14, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(471, 40, '1', 'TABLET', '45.00', 'pc', 1, 1, '50.00', '2250.00', 6, '1.50', '32.06', '2169.56', '5.00', '112.50', '2137.50'),
(472, 40, '1.', 'AUTOMATIC TRANSMISSION FLUID', '2.00', 'unit', 0, 2, '89.00', '178.00', 1, '0.00', '0.00', '167.32', '6.00', '10.68', '167.32'),
(473, 40, '2.', 'NOKIA CHARGER TYPE CARBON 4598BK', '2.00', 'UNIT', 0, 3, '50.00', '100.00', 1, '0.00', '0.00', '100.00', '0.00', '0.00', '100.00'),
(474, 40, '3.', 'Jetting Works and Clear blockages with rodder machine', '5.00', 'unit', 0, 4, '5.00', '25.00', 1, '0.00', '0.00', '25.00', '0.00', '0.00', '25.00'),
(475, 40, '', 'OINTMENT', '0.00', '', 1, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(476, 40, '1.', 'Teak Wood furniture sofa chair', '5.00', '', 0, 6, '34.00', '170.00', 4, '34.00', '53.75', '211.85', '7.00', '11.90', '158.10'),
(477, 40, '2.', 'Screw Holland made 6 type', '5.00', '', 0, 7, '55.00', '275.00', 1, '0.00', '0.00', '275.00', '0.00', '0.00', '275.00'),
(478, 40, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '13.00', '', 0, 8, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(479, 40, '', '', '0.00', '', 0, 9, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(480, 40, '', '', '0.00', '', 0, 10, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(481, 40, '', '', '0.00', '', 0, 11, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(482, 40, '', '', '0.00', '', 0, 12, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(483, 40, '', '', '0.00', '', 0, 13, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(484, 40, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '0.00', '', 1, 14, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00');

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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbquotation`
--

INSERT INTO `tbquotation` (`quotation_id`, `quotation_no`, `quotation_date`, `quotation_customerID`, `quotation_title`, `quotation_from`, `quotation_terms`, `quotation_attention`, `quotation_email`, `quotation_subTotal`, `quotation_taxTotal`, `quotation_grandTotal`, `quotation_discountTotal`, `quotation_totalAfterDiscount`, `quotation_roundAmount`, `quotation_grandTotalRound`, `quotation_roundStatus`, `quotation_content`, `quotation_invoiceNo`, `quotation_invoiceID`, `quotation_deliveryOrderNo`, `quotation_deliveryOrderID`) VALUES
(1, 'QUO/2023/001', '2023-01-21', 76, '', '', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>All cheques must be crossed &quot;A/C PAYEE ONLY&quot; and made payable to &quot;<strong>KSN SEWERAGE ENGINEERING SERVICES</strong> &quot; at Public Bank 3122 136 534 &nbsp;<br />&nbsp;</li></ol>', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', '', '3206.00', '0.00', '3206.00', '0.00', '3206.00', '0.00', '3206.00', 0, '', 'IN/2023/004', 4, 'DO/2023/001', 1),
(2, 'QUO/2023/002', '2023-01-24', 75, '', '', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>All cheques must be crossed &quot;A/C PAYEE ONLY&quot; and made payable to &quot;<strong>KSN SEWERAGE ENGINEERING SERVICES</strong> &quot; at Public Bank 3122 136 534 &nbsp;<br />&nbsp;</li></ol>', 'MR RAYMOND', '', '3758.50', '0.00', '3758.50', '0.00', '3758.50', '0.00', '3758.50', 0, '', 'IN/2023/021', 14, 'DO/2023/002', 2),
(3, 'QUO/2023/003', '2023-01-30', 51, '', '', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>All cheques must be crossed &quot;A/C PAYEE ONLY&quot; and made payable to &quot;<strong>KSN SEWERAGE ENGINEERING SERVICES</strong> &quot; at Public Bank 3122 136 534 &nbsp;<br />&nbsp;</li></ol>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '3656.00', '0.00', '3656.00', '0.00', '3656.00', '0.00', '3656.00', 0, '', 'IN/2023/045', 35, 'DO/2023/004', 4),
(4, 'QUO/2023/004', '2023-02-01', 71, '', '', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>All cheques must be crossed &quot;A/C PAYEE ONLY&quot; and made payable to &quot;<strong>KSN SEWERAGE ENGINEERING SERVICES</strong> &quot; at Public Bank 3122 136 534 &nbsp;<br />&nbsp;</li></ol>', '', '', '23533.00', '0.84', '23533.84', '0.00', '23533.00', '0.01', '23533.85', 1, '', '', 0, '', 0),
(5, 'QUO/2023/005', '2023-02-02', 83, 'BLOCKED SEWERAGE PIPING CLEARING AND MANHOLE CLEANING FOR ABOVE LOCATION', '', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid till 28th February 2023</li><li>All payment made payable to &quot;<strong>KSN SEWERAGE ENGINEERING SERVICES</strong> &quot; at Public Bank 3122 136 534&nbsp; either by cheque or bank transfer.<br />&nbsp;</li></ol>', '', '', '7000.00', '0.00', '7000.00', '0.00', '7000.00', '0.00', '7000.00', 0, '<p>To</p><p>Manager</p><p>DESA DAMANSARA MANAGEMENT CORPORATION</p><p>&nbsp;</p>', 'IN/2023/059', 52, 'DO/2023/006', 6),
(6, 'QUO/2023/006', '2023-02-07', 76, '', '', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>All cheques must be crossed &quot;A/C PAYEE ONLY&quot; and made payable to &quot;<strong>KSN SEWERAGE ENGINEERING SERVICES</strong> &quot; at Public Bank 3122 136 534 &nbsp;<br />&nbsp;</li></ol>', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', '', '5062.75', '0.00', '5062.75', '0.00', '5062.75', '0.00', '5062.75', 0, '', 'IN/2023/068', 61, '', 0),
(8, 'QUO/2023/008', '2023-02-18', 87, '', '', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>All cheques must be crossed &quot;A/C PAYEE ONLY&quot; and made payable to &quot;<strong>KSN SEWERAGE ENGINEERING SERVICES</strong> &quot; at Public Bank 3122 136 534 &nbsp;<br />&nbsp;</li></ol>', 'MR TIMOTHY', 'timothy@rainehome.com.my', '8454.03', '1702.30', '10139.83', '16.50', '8437.53', '0.00', '10139.83', 0, '', 'IN/2023/069', 62, 'DO/2023/008', 8),
(9, 'QUO/2023/009', '2023-02-18', 51, '', '', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>All cheques must be crossed &quot;A/C PAYEE ONLY&quot; and made payable to &quot;<strong>KSN SEWERAGE ENGINEERING SERVICES</strong> &quot; at Public Bank 3122 136 534 &nbsp;<br />&nbsp;</li></ol>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '8454.03', '1702.30', '10139.83', '16.50', '8437.53', '0.00', '10139.83', 0, '', 'IN/2023/070', 63, '', 0),
(10, 'QUO/2023/010', '2023-02-22', 83, 'CUT AND REMOVE BROKEN UNDERGROUND SEWERAGE PIPE AND OTHER  RELATED WORKS', '', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>All cheques must be crossed &quot;A/C PAYEE ONLY&quot; and made payable to &quot;<strong>KSN SEWERAGE ENGINEERING SERVICES</strong> &quot; at Public Bank 3122 136 534 &nbsp;<br />&nbsp;</li></ol>', '', '', '6000.00', '1876.80', '7396.80', '480.00', '5520.00', '0.00', '7396.80', 0, '', '', 0, '', 0),
(11, 'QUO/2023/011', '2023-02-25', 51, '', '', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>All cheques must be crossed &quot;A/C PAYEE ONLY&quot; and made payable to &quot;<strong>KSN SEWERAGE ENGINEERING SERVICES</strong> &quot; at Public Bank 3122 136 534 &nbsp;<br />&nbsp;</li></ol>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '7000.00', '0.00', '7000.00', '0.00', '7000.00', '0.00', '7000.00', 0, '', 'IN/2023/075', 66, '', 0),
(12, 'QUO/2023/012', '2023-02-26', 51, '', '', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>All cheques must be crossed &quot;A/C PAYEE ONLY&quot; and made payable to &quot;<strong>KSN SEWERAGE ENGINEERING SERVICES</strong> &quot; at Public Bank 3122 136 534 &nbsp;<br />&nbsp;</li></ol>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '5230.00', '275.91', '5505.91', '0.00', '5230.00', '-0.01', '5505.90', 1, '', 'IN/2023/076', 67, 'DO/2023/016', 11),
(13, 'QUO/2023/013', '2023-02-26', 76, 'Based on our inspection of your property, we recommend the following pest control services:', '', '<p>We understand that <strong>pest control can be a significant investment</strong>, which is why we offer a variety of payment options and financing plans to help make our services more accessible. We also offer a satisfaction guarantee to ensure that you are completely satisfied with our services.</p><p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>All cheques must be crossed &quot;A/C PAYEE ONLY&quot; and made payable to &quot;<strong>KSN SEWERAGE ENGINEERING SERVICES</strong> &quot; at Public Bank 3122 136 534 &nbsp;<br />&nbsp;</li></ol>', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', '', '2890.00', '257.35', '3075.35', '72.00', '2818.00', '0.00', '3075.35', 0, '<p>Thank you for considering our pest control services. We understand that pests can be a nuisance and can potentially cause harm to your property, health, and well-being. We are committed to providing effective and safe pest control solutions to help you eliminate pests from your home or business.</p>', '', 0, '', 0),
(14, 'QUO/2023/014', '2023-02-26', 83, 'Based on our inspection of your property, we recommend the following pest control services:', '', '<p>We understand that <strong>pest control can be a significant investment</strong>, which is why we offer a variety of payment options and financing plans to help make our services more accessible. We also offer a satisfaction guarantee to ensure that you are completely satisfied with our services.</p><p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>All cheques must be crossed &quot;A/C PAYEE ONLY&quot; and made payable to &quot;<strong>KSN SEWERAGE ENGINEERING SERVICES</strong> &quot; at Public Bank 3122 136 534 &nbsp;<br />&nbsp;</li></ol>', '', '', '2936.00', '300.77', '3169.99', '66.78', '2869.22', '0.01', '3170.00', 1, '<p>Thank you for considering our pest control services. We understand that pests can be a nuisance and can potentially cause harm to your property, health, and well-being. We are committed to providing effective and safe pest control solutions to help you eliminate pests from your home or business.</p>', '', 0, '', 0),
(15, 'QUO/2023/015', '2023-02-26', 63, 'Our team of experienced painters will perform the following tasks as part of the project:', '', '<p>We hope that this quotation meets your expectations and we look forward to the opportunity to work with you. Please do not hesitate to contact us if you have any questions or concerns.</p><p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>All cheques must be crossed &quot;A/C PAYEE ONLY&quot; and made payable to &quot;<strong>KSN SEWERAGE ENGINEERING SERVICES</strong> &quot; at Public Bank 3122 136 534 &nbsp;<br />&nbsp;</li></ol>', 'MR GANAESON', '', '2280.00', '278.35', '2477.35', '81.00', '2199.00', '0.00', '2477.35', 0, '<p>Thank you for considering us for your building painting project. We appreciate the opportunity to provide you with our services. After discussing the details of your project with you, we have put together a comprehensive quotation that outlines the costs and timeline for the project.</p>', '', 0, '', 0),
(16, 'QUO/2023/016', '2023-02-28', 74, '', '', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>All cheques must be crossed &quot;A/C PAYEE ONLY&quot; and made payable to &quot;<strong>KSN SEWERAGE ENGINEERING SERVICES</strong> &quot; at Public Bank 3122 136 534 &nbsp;<br />&nbsp;</li></ol>', '', '', '10452.05', '88.38', '10540.43', '0.00', '10452.05', '0.02', '10540.45', 1, '', '', 0, '', 0),
(17, 'QUO/2023/017', '2023-02-28', 65, '', '', '<p>We understand that <strong>pest control can be a significant investment</strong>, which is why we offer a variety of payment options and financing plans to help make our services more accessible. We also offer a satisfaction guarantee to ensure that you are completely satisfied with our services.</p><p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>All cheques must be crossed &quot;A/C PAYEE ONLY&quot; and made payable to &quot;<strong>KSN SEWERAGE ENGINEERING SERVICES</strong> &quot; at Public Bank 3122 136 534 &nbsp;<br />&nbsp;</li></ol>', '', '', '2890.00', '257.35', '3075.35', '72.00', '2818.00', '0.00', '3075.35', 0, '<p>Thank you for considering our pest control services. We understand that pests can be a nuisance and can potentially cause harm to your property, health, and well-being. We are committed to providing effective and safe pest control solutions to help you eliminate pests from your home or business.</p>', 'IN/2023/100', 70, '', 0),
(18, 'QUO/2023/018', '2023-03-12', 51, '', '', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>All cheques must be crossed &quot;A/C PAYEE ONLY&quot; and made payable to &quot;<strong>KSN SEWERAGE ENGINEERING SERVICES</strong> &quot; at Public Bank 3122 136 534 &nbsp;<br />&nbsp;</li></ol>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '617.50', '0.00', '617.50', '0.00', '617.50', '0.00', '617.50', 0, '', '', 0, '', 0),
(19, 'QUO/2023/019', '2023-03-12', 74, '', '', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>All cheques must be crossed &quot;A/C PAYEE ONLY&quot; and made payable to &quot;<strong>KSN SEWERAGE ENGINEERING SERVICES</strong> &quot; at Public Bank 3122 136 534 &nbsp;<br />&nbsp;</li></ol>', '', '', '5754.60', '0.00', '5754.60', '0.00', '5754.60', '0.00', '5754.60', 0, '', '', 0, '', 0),
(20, 'QUO/2023/020', '2023-03-12', 51, '', '', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>All cheques must be crossed &quot;A/C PAYEE ONLY&quot; and made payable to &quot;<strong>KSN SEWERAGE ENGINEERING SERVICES</strong> &quot; at Public Bank 3122 136 534 &nbsp;<br />&nbsp;</li></ol>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '1330.98', '7.05', '1313.28', '24.75', '1306.23', '0.00', '1313.28', 0, '', '', 0, '', 0),
(21, 'QUO/2023/021', '2023-03-12', 51, '', '', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>All cheques must be crossed &quot;A/C PAYEE ONLY&quot; and made payable to &quot;<strong>KSN SEWERAGE ENGINEERING SERVICES</strong> &quot; at Public Bank 3122 136 534 &nbsp;<br />&nbsp;</li></ol>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '617.50', '0.00', '617.50', '0.00', '617.50', '0.00', '617.50', 0, '', '', 0, '', 0),
(22, 'QUO/2023/022', '2023-03-12', 51, '', '', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>All cheques must be crossed &quot;A/C PAYEE ONLY&quot; and made payable to &quot;<strong>KSN SEWERAGE ENGINEERING SERVICES</strong> &quot; at Public Bank 3122 136 534 &nbsp;<br />&nbsp;</li></ol>', 'Mr Balvinder Singh', 'ahsn_90@gmail.com', '1064.50', '0.00', '1064.50', '0.00', '1064.50', '0.00', '1064.50', 0, '', '', 0, '', 0),
(23, 'QUO/2023/023', '2023-03-13', 76, '', '', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>All cheques must be crossed &quot;A/C PAYEE ONLY&quot; and made payable to &quot;<strong>KSN SEWERAGE ENGINEERING SERVICES</strong> &quot; at Public Bank 3122 136 534 &nbsp;<br />&nbsp;</li></ol>', 'SERI WAHYU RESINDENCE MANAGEMENT OFFICE', '', '1114.00', '0.00', '1114.00', '0.00', '1114.00', '0.00', '1114.00', 0, '', '', 0, '', 0),
(24, 'QUO/2023/024', '2023-03-13', 21, '', '', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>All cheques must be crossed &quot;A/C PAYEE ONLY&quot; and made payable to &quot;<strong>KSN SEWERAGE ENGINEERING SERVICES</strong> &quot; at Public Bank 3122 136 534 &nbsp;<br />&nbsp;</li></ol>', 'Madam Devi Nair', 'devi_epson@gmail.com', '617.50', '0.00', '617.50', '0.00', '617.50', '0.00', '617.50', 0, '', '', 0, 'DO/2023/020', 15),
(25, 'QUO/2023/025', '2023-03-13', 34, '', '', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>All cheques must be crossed &quot;A/C PAYEE ONLY&quot; and made payable to &quot;<strong>KSN SEWERAGE ENGINEERING SERVICES</strong> &quot; at Public Bank 3122 136 534 &nbsp;<br />&nbsp;</li></ol>', 'Mr Gobalan', 'gobalan2829@gmail.com', '1330.98', '7.05', '1313.28', '24.75', '1306.23', '0.00', '1313.28', 0, '', '', 0, '', 0),
(26, 'QUO/2023/026', '2023-03-13', 76, 'RESIDENTIAL WATER TANK CLEANING AND SERVICE', '', '<p><strong>Quotation Terms</strong></p><ol><li>Quatation is valid two weeks from date above.</li><li>All cheques must be crossed &quot;A/C PAYEE ONLY&quot; and made payable to &quot;<strong>KSN SEWERAGE ENGINEERING SERVICES</strong> &quot; at Public Bank 3122 136 534 &nbsp;<br />&nbsp;</li></ol>', 'MS PREMA (BUILDING MANAGER)', '', '86000.00', '0.00', '86000.00', '0.00', '86000.00', '0.00', '86000.00', 0, '', '', 0, '', 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=398 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbquotationdetail`
--

INSERT INTO `tbquotationdetail` (`quotationDetail_id`, `quotationDetail_quotationID`, `quotationDetail_no1`, `quotationDetail_no2`, `quotationDetail_no3`, `quotationDetail_no4`, `quotationDetail_bold`, `quotationDetail_sortID`, `quotationDetail_no5`, `quotationDetail_rowTotal`, `quotationDetail_taxRateID`, `quotationDetail_taxPercent`, `quotationDetail_taxTotal`, `quotationDetail_rowGrandTotal`, `quotationDetail_discountPercent`, `quotationDetail_discountAmount`, `quotationDetail_rowTotalAfterDiscount`) VALUES
(1, 1, '', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 0, 1, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(2, 1, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '2.00', '', 0, 2, '450.00', '900.00', 1, '0.00', '0.00', '900.00', '0.00', '0.00', '900.00'),
(3, 1, '', 'NOKIA CHARGER TYPE CARBON 4598BK2', '5.00', 'UNIT', 0, 3, '450.00', '2250.00', 1, '0.00', '0.00', '2250.00', '0.00', '0.00', '2250.00'),
(4, 1, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(5, 1, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(6, 2, '', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 1, 1, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(7, 2, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '2.00', '', 0, 2, '450.00', '900.00', 1, '0.00', '0.00', '900.00', '0.00', '0.00', '900.00'),
(8, 2, '', 'NOKIA CHARGER TYPE CARBON 4598BK2', '5.00', 'UNIT', 1, 3, '450.00', '2250.00', 1, '0.00', '0.00', '2250.00', '0.00', '0.00', '2250.00'),
(9, 2, '', 'TOP RADIATOR HOSE ORIGINAL', '0.00', '', 0, 4, '450.00', '450.00', 1, '0.00', '0.00', '450.00', '0.00', '0.00', '450.00'),
(10, 2, '', 'AUTOMATIC TRANSMISSION FLUID', '0.00', 'unit', 0, 5, '102.50', '102.50', 1, '0.00', '0.00', '102.50', '0.00', '0.00', '102.50'),
(21, 3, '', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 0, 1, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(22, 3, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '2.00', '', 0, 2, '450.00', '900.00', 1, '0.00', '0.00', '900.00', '0.00', '0.00', '900.00'),
(23, 3, '', 'NOKIA CHARGER TYPE CARBON 4598BK2', '5.00', 'UNIT', 0, 3, '450.00', '2250.00', 1, '0.00', '0.00', '2250.00', '0.00', '0.00', '2250.00'),
(24, 3, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(25, 3, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '0.00', '', 0, 5, '450.00', '450.00', 1, '0.00', '0.00', '450.00', '0.00', '0.00', '450.00'),
(26, 3, '', '', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(27, 3, '', '', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(28, 4, '', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 1, 1, '56.00', '56.00', 6, '1.50', '0.84', '56.84', '0.00', '0.00', '56.00'),
(29, 4, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '2.00', '', 0, 2, '450.00', '900.00', 1, '0.00', '0.00', '900.00', '0.00', '0.00', '900.00'),
(30, 4, '', 'NOKIA CHARGER TYPE CARBON 4598BK2', '5.00', 'UNIT', 0, 3, '450.00', '2250.00', 1, '0.00', '0.00', '2250.00', '0.00', '0.00', '2250.00'),
(31, 4, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '45.00', '', 0, 4, '450.00', '20250.00', 1, '0.00', '0.00', '20250.00', '0.00', '0.00', '20250.00'),
(32, 4, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(33, 4, '', 'Screw Holland made 6 type', '0.00', '', 0, 6, '77.00', '77.00', 1, '0.00', '0.00', '77.00', '0.00', '0.00', '77.00'),
(127, 5, '', 'MANHOLE CLEANING WORKS', '0.00', '', 1, 1, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(128, 5, '1.', 'STAFF NEED TO ENTER THE MANHOLES MANUALLY AND REMOVE ALL RUBBISH, DIRT AND SAND FROM THE BOTTOM OF MANHOLE.', '1.00', 'LOT', 0, 2, '2500.00', '2500.00', 1, '0.00', '0.00', '2500.00', '0.00', '0.00', '2500.00'),
(129, 5, '2.', 'COLLECT ALL THE RUBBISH AND SAND AND DISPOSE IN RORO RUBBISH BIN\r\nTO BE SEND TO DISPOSAL SITE USING LORRY.', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(130, 5, '3.', 'DISPOSAL AMOUNT INCLUDED IN THE QUOTATION.', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(131, 5, '', 'SEWERAGE PIPE CLEARING', '0.00', '', 1, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(132, 5, '1.', 'USE MANUAL RODDING TO CLEAR THE BLOCKAGES', '1.00', 'LOT', 0, 6, '3500.00', '3500.00', 1, '0.00', '0.00', '3500.00', '0.00', '0.00', '3500.00'),
(133, 5, '2.', 'USE JETTING MACHINE WITH HIGH POWERED WATER PRESSURE TO CLEAR ALL BLOCKAGES.', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(134, 5, '3.', 'REMOVE ALL THE CLEARED BLOCKAGES AND DISPOSE IN RORO BIN FOR DISPOSAL.', '0.00', '', 0, 8, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(135, 5, '', 'WORK SITE CLEANING WORKS', '0.00', '', 1, 9, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(136, 5, '1.', 'CLEAN ALL THE WORKSITE AREA OF DEBRIS, SLUDGE ETC AFTER THE WORKS IS COMPLETED.', '1.00', 'LOT', 0, 10, '1000.00', '1000.00', 1, '0.00', '0.00', '1000.00', '0.00', '0.00', '1000.00'),
(137, 5, '', 'PAYMENT TERMS', '0.00', '', 1, 11, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(138, 5, '1.', 'OFFICIAL PURCHASE ORDER NEED TO BE ISSUED BY CUSTOMER.', '0.00', '', 0, 12, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(139, 5, '2.', 'DEPOSIT AMOUNT OF 50 PERCENT OF TOTAL COST TO BE PAID BEFORE WORK STARTS.', '0.00', '', 0, 13, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(140, 5, '3.', 'BALANCE PAYMENT OF 50 PERCENT TO BE PAID WITHIN 7 DAYS OF WORK COMPLETION.', '0.00', '', 0, 14, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(141, 6, '', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 0, 1, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(142, 6, '', '', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(143, 6, '', '', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(144, 6, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(145, 6, '', 'MOTOROLLA HANDPHONE MODEL X-9', '0.00', 'unit', 0, 5, '5006.75', '5006.75', 1, '0.00', '0.00', '5006.75', '0.00', '0.00', '5006.75'),
(158, 8, '', 'A4 Bahasa Malaysia Exam papers9', '6.00', 'pcs', 0, 1, '6.49', '38.94', 1, '0.00', '0.00', '38.94', '0.00', '0.00', '38.94'),
(159, 8, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '6.00', '', 0, 2, '450.00', '2700.00', 1, '0.00', '0.00', '2700.00', '0.00', '0.00', '2700.00'),
(160, 8, '', 'Teak Wood furniture sofa chair', '5.00', '', 0, 3, '66.00', '330.00', 1, '0.00', '0.00', '313.50', '5.00', '16.50', '313.50'),
(161, 8, '', 'NOKIA CHARGER TYPE CARBON 4598BK', '1.00', 'UNIT', 0, 4, '59.00', '59.00', 1, '0.00', '0.00', '59.00', '0.00', '0.00', '59.00'),
(162, 8, '', 'MOTOROLLA HANDPHONE MODEL X-9', '1.00', 'unit', 0, 5, '5006.75', '5006.75', 4, '34.00', '1702.30', '6709.05', '0.00', '0.00', '5006.75'),
(163, 8, '', 'Chicken Eggs \r\nMount Road Poulty Farm', '0.00', '', 0, 6, '77.85', '77.85', 1, '0.00', '0.00', '77.85', '0.00', '0.00', '77.85'),
(164, 8, '', 'Screw Holland made 6 type', '3.00', '', 0, 7, '77.00', '231.00', 1, '0.00', '0.00', '231.00', '0.00', '0.00', '231.00'),
(165, 8, '', 'Electrical Cable Malaysia Made', '1.00', 'pc', 0, 8, '10.49', '10.49', 1, '0.00', '0.00', '10.49', '0.00', '0.00', '10.49'),
(166, 9, '', 'A4 Bahasa Malaysia Exam papers9', '6.00', 'pcs', 0, 1, '6.49', '38.94', 1, '0.00', '0.00', '38.94', '0.00', '0.00', '38.94'),
(167, 9, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '6.00', '', 0, 2, '450.00', '2700.00', 1, '0.00', '0.00', '2700.00', '0.00', '0.00', '2700.00'),
(168, 9, '', 'Teak Wood furniture sofa chair', '5.00', '', 0, 3, '66.00', '330.00', 1, '0.00', '0.00', '313.50', '5.00', '16.50', '313.50'),
(169, 9, '', 'NOKIA CHARGER TYPE CARBON 4598BK', '1.00', 'UNIT', 0, 4, '59.00', '59.00', 1, '0.00', '0.00', '59.00', '0.00', '0.00', '59.00'),
(170, 9, '', 'MOTOROLLA HANDPHONE MODEL X-9', '1.00', 'unit', 0, 5, '5006.75', '5006.75', 4, '34.00', '1702.30', '6709.05', '0.00', '0.00', '5006.75'),
(171, 9, '', 'Chicken Eggs \r\nMount Road Poulty Farm', '0.00', '', 0, 6, '77.85', '77.85', 1, '0.00', '0.00', '77.85', '0.00', '0.00', '77.85'),
(172, 9, '', 'Screw Holland made 6 type', '3.00', '', 0, 7, '77.00', '231.00', 1, '0.00', '0.00', '231.00', '0.00', '0.00', '231.00'),
(173, 9, '', 'Electrical Cable Malaysia Made', '1.00', 'pc', 0, 8, '10.49', '10.49', 1, '0.00', '0.00', '10.49', '0.00', '0.00', '10.49'),
(185, 11, '1', 'HACK AND BREAK THE TILES AND CONCRETE ON THE TOILET\r\n(ONLY THE BROKEN PIPE SECTION)', '0.00', '', 0, 1, '7000.00', '7000.00', 1, '0.00', '0.00', '7000.00', '0.00', '0.00', '7000.00'),
(186, 11, '2', '2.) NEED TO BREAK AND REMOVE THE EXISTING TOILET BOWL.', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(187, 11, '3', '3.) NEED TO DIG TO THE DEPTH OF TWO AND HALF FEET TO ACCESS THE BROKEN SEWERAGE PIPE', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(188, 11, '4', '4.) CUT AND REMOVE THE EXISTING DAMAGED SEWERAGE PIPE        (ONLY THE BROKEN SECTION)', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(189, 11, '5', '5.) TO SUPPLY NEW UPVC UNDERGROUND SEWERAGE PIPE', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(190, 11, '6', '6.) TO LAY, INSTALL AND JOIN THIS NEW PIPE TO THE   EXISTING UNDAMAGED  SEWERAGE PIPE.', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(191, 11, '1', '7.) TO COVER THE PIPE WITH SAND AND GRAVEL .', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(192, 11, '2', '8.) TO LAY NEW CONCRETE FLOORING', '0.00', '', 0, 8, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(193, 11, '3', '9.) TO LAY NEW TILES TO REPLACE ALL THE DAMAGES TILES.', '0.00', '', 0, 9, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(194, 11, '4', '10.) TO SUPPLY AND REINSTALL NEW TOILET BOWL', '0.00', '', 0, 10, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(195, 11, '5', '11.) TO CLEAN AND CLEAR WORKSITE OF ALL SAND AND DEBRIS', '0.00', '', 0, 11, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(196, 10, '1', 'HACK AND BREAK THE TILES AND CONCRETE ON THE TOILET\r\n(ONLY THE BROKEN PIPE SECTION)', '0.00', '', 0, 1, '6000.00', '6000.00', 4, '34.00', '1876.80', '7396.80', '8.00', '480.00', '5520.00'),
(197, 10, '2', '2.) NEED TO BREAK AND REMOVE THE EXISTING TOILET BOWL.', '0.00', '', 0, 2, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(198, 10, '3', '3.) NEED TO DIG TO THE DEPTH OF TWO AND HALF FEET TO ACCESS THE BROKEN SEWERAGE PIPE', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(199, 10, '4', '4.) CUT AND REMOVE THE EXISTING DAMAGED SEWERAGE PIPE        (ONLY THE BROKEN SECTION)', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(200, 10, '5', '5.) TO SUPPLY NEW UPVC UNDERGROUND SEWERAGE PIPE', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(201, 10, '6', '6.) TO LAY, INSTALL AND JOIN THIS NEW PIPE TO THE   EXISTING UNDAMAGED  SEWERAGE PIPE.', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(202, 10, '1', '7.) TO COVER THE PIPE WITH SAND AND GRAVEL .', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(203, 10, '2', '8.) TO LAY NEW CONCRETE FLOORING', '0.00', '', 0, 8, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(204, 10, '3', '9.) TO LAY NEW TILES TO REPLACE ALL THE DAMAGES TILES.', '0.00', '', 0, 9, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(205, 10, '4', '10.) TO SUPPLY AND REINSTALL NEW TOILET BOWL', '0.00', '', 0, 10, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(206, 10, '5', '11.) TO CLEAN AND CLEAR WORKSITE OF ALL SAND AND DEBRIS', '0.00', '', 0, 11, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(207, 12, '', 'LABOUR TO REPLACE PARTS & SERVICE', '1.00', '', 0, 1, '4560.00', '4560.00', 2, '6.00', '273.60', '4833.60', '0.00', '0.00', '4560.00'),
(208, 12, '', 'Screw Holland made 6 type', '2.00', '', 0, 2, '77.00', '154.00', 6, '1.50', '2.31', '156.31', '0.00', '0.00', '154.00'),
(209, 12, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '1.00', '', 0, 3, '450.00', '450.00', 1, '0.00', '0.00', '450.00', '0.00', '0.00', '450.00'),
(210, 12, '', 'Teak Wood furniture sofa chair', '1.00', '', 0, 4, '66.00', '66.00', 1, '0.00', '0.00', '66.00', '0.00', '0.00', '66.00'),
(211, 12, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(219, 13, '1.', 'General Pest Control: Our general pest control service includes the treatment of common household pests such as ants, cockroaches, spiders, and rodents.', '0.00', '', 0, 1, '700.00', '700.00', 4, '34.00', '238.00', '938.00', '0.00', '0.00', '700.00'),
(220, 13, '2.', 'This service involves a thorough inspection of of your property to identify pest infestations and potential problem areas, followed by the application of targeted pest control treatments to eliminate', '0.00', '', 0, 2, '900.00', '900.00', 1, '0.00', '0.00', '828.00', '8.00', '72.00', '828.00'),
(221, 13, '3.', 'Termite Control: Termites can cause significant damage to your property and can be difficult to detect without professional assistance. Our termite control service includes a comprehensive inspection', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(222, 13, '4.', 'We then use industry-leading termite control treatments to eliminate termites and protect your property from further damage.', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(223, 13, '5.', 'Bed Bug Control: Bed bugs can be a persistent and frustrating problem for homeowners and businesses.', '0.00', '', 0, 5, '1290.00', '1290.00', 6, '1.50', '19.35', '1309.35', '0.00', '0.00', '1290.00'),
(224, 13, '', '', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(225, 13, '', '', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(233, 14, '1.', 'General Pest Control: Our general pest control service includes the treatment of common household pests such as ants, cockroaches, spiders, and rodents.', '0.00', '', 0, 1, '890.00', '890.00', 4, '34.00', '281.42', '1109.12', '7.00', '62.30', '827.70'),
(234, 14, '2.', 'This service involves a thorough inspection of of your property to identify pest infestations and potential problem areas, followed by the application of targeted pest control treatments to eliminate', '0.00', '', 0, 2, '56.00', '56.00', 1, '0.00', '0.00', '51.52', '8.00', '4.48', '51.52'),
(235, 14, '3.', 'Termite Control: Termites can cause significant damage to your property and can be difficult to detect without professional assistance. Our termite control service includes a comprehensive inspection', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(236, 14, '4.', 'We then use industry-leading termite control treatments to eliminate termites and protect your property from further damage.', '0.00', '', 0, 4, '700.00', '700.00', 1, '0.00', '0.00', '700.00', '0.00', '0.00', '700.00'),
(237, 14, '5.', 'Bed Bug Control: Bed bugs can be a persistent and frustrating problem for homeowners and businesses.', '0.00', '', 0, 5, '1290.00', '1290.00', 6, '1.50', '19.35', '1309.35', '0.00', '0.00', '1290.00'),
(238, 14, '', '', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(239, 14, '', '', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(245, 15, '1.', 'Exterior surface preparation, including power washing and scraping loose paint', '0.00', '', 0, 1, '800.00', '800.00', 4, '34.00', '272.00', '1072.00', '0.00', '0.00', '800.00'),
(246, 15, '2.', 'Applying primer to bare surfaces', '0.00', '', 0, 2, '900.00', '900.00', 1, '0.00', '0.00', '846.00', '6.00', '54.00', '846.00'),
(247, 15, '3.', 'Applying two coats of high-quality paint to all surfaces', '0.00', '', 0, 3, '450.00', '450.00', 6, '1.50', '6.34', '429.35', '6.00', '27.00', '423.00'),
(248, 15, '4.', 'Thorough cleanup of the job site upon completion', '0.00', '', 0, 4, '130.00', '130.00', 1, '0.00', '0.00', '130.00', '0.00', '0.00', '130.00'),
(249, 15, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(250, 15, '', '', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(251, 15, '', '', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(252, 15, '', '', '0.00', '', 0, 8, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(253, 15, '', '', '0.00', '', 0, 9, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(254, 16, '1', 'AUTOMATIC TRANSMISSION FLUID', '2.00', 'unit', 0, 1, '102.50', '205.00', 4, '34.00', '69.70', '274.70', '0.00', '0.00', '205.00'),
(255, 16, '2', 'MOTOROLLA HANDPHONE MODEL X-9', '2.00', 'unit', 0, 2, '5006.75', '10013.50', 1, '0.00', '0.00', '10013.50', '0.00', '0.00', '10013.50'),
(256, 16, '3', 'Chicken Eggs \r\nMount Road Poulty Farm', '3.00', '', 0, 3, '77.85', '233.55', 5, '8.00', '18.68', '252.23', '0.00', '0.00', '233.55'),
(257, 16, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(258, 16, '', '', '0.00', '', 0, 5, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(259, 17, '1.', 'General Pest Control: Our general pest control service includes the treatment of common household pests such as ants, cockroaches, spiders, and rodents.', '0.00', '', 0, 1, '700.00', '700.00', 4, '34.00', '238.00', '938.00', '0.00', '0.00', '700.00'),
(260, 17, '2.', 'This service involves a thorough inspection of of your property to identify pest infestations and potential problem areas, followed by the application of targeted pest control treatments to eliminate', '0.00', '', 0, 2, '900.00', '900.00', 1, '0.00', '0.00', '828.00', '8.00', '72.00', '828.00'),
(261, 17, '3.', 'Termite Control: Termites can cause significant damage to your property and can be difficult to detect without professional assistance. Our termite control service includes a comprehensive inspection', '0.00', '', 0, 3, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(262, 17, '4.', 'We then use industry-leading termite control treatments to eliminate termites and protect your property from further damage.', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(263, 17, '5.', 'Bed Bug Control: Bed bugs can be a persistent and frustrating problem for homeowners and businesses.', '0.00', '', 0, 5, '1290.00', '1290.00', 6, '1.50', '19.35', '1309.35', '0.00', '0.00', '1290.00'),
(264, 17, '', '', '0.00', '', 0, 6, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(265, 17, '', '', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(266, 18, '', 'AUTOMATIC TRANSMISSION FLUID', '0.00', 'unit', 1, 1, '102.50', '102.50', 1, '0.00', '0.00', '102.50', '0.00', '0.00', '102.50'),
(267, 18, '', 'NOKIA CHARGER TYPE CARBON 4598BK', '0.00', 'UNIT', 0, 2, '59.00', '59.00', 1, '0.00', '0.00', '59.00', '0.00', '0.00', '59.00'),
(268, 18, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '0.00', '', 1, 3, '450.00', '450.00', 1, '0.00', '0.00', '450.00', '0.00', '0.00', '450.00'),
(269, 18, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(270, 18, '', 'Jetting Works and Clear blockages with rodder machine', '0.00', 'unit', 1, 5, '6.00', '6.00', 1, '0.00', '0.00', '6.00', '0.00', '0.00', '6.00'),
(271, 19, '', 'Desludging Tanker 10 cubic metres (Cina Made)', '0.00', 'units', 1, 1, '99.00', '99.00', 1, '0.00', '0.00', '99.00', '0.00', '0.00', '99.00'),
(272, 19, '', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 0, 2, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(273, 19, '', 'Chicken Eggs \r\nMount Road Poulty Farm', '0.00', '', 0, 3, '77.85', '77.85', 1, '0.00', '0.00', '77.85', '0.00', '0.00', '77.85'),
(274, 19, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '0.00', '', 1, 4, '450.00', '450.00', 1, '0.00', '0.00', '450.00', '0.00', '0.00', '450.00'),
(275, 19, '', 'NOKIA CHARGER TYPE CARBON 4598BK', '0.00', 'UNIT', 0, 5, '59.00', '59.00', 1, '0.00', '0.00', '59.00', '0.00', '0.00', '59.00'),
(276, 19, '', 'Jetting Works and Clear blockages with rodder machine', '0.00', 'unit', 0, 6, '6.00', '6.00', 1, '0.00', '0.00', '6.00', '0.00', '0.00', '6.00'),
(277, 19, '', 'MOTOROLLA HANDPHONE MODEL X-9', '0.00', 'unit', 1, 7, '5006.75', '5006.75', 1, '0.00', '0.00', '5006.75', '0.00', '0.00', '5006.75'),
(338, 21, '', 'AUTOMATIC TRANSMISSION FLUID', '0.00', 'unit', 1, 1, '102.50', '102.50', 1, '0.00', '0.00', '102.50', '0.00', '0.00', '102.50'),
(339, 21, '', 'NOKIA CHARGER TYPE CARBON 4598BK', '0.00', 'UNIT', 0, 2, '59.00', '59.00', 1, '0.00', '0.00', '59.00', '0.00', '0.00', '59.00'),
(340, 21, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '0.00', '', 1, 3, '450.00', '450.00', 1, '0.00', '0.00', '450.00', '0.00', '0.00', '450.00'),
(341, 21, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(342, 21, '', 'Jetting Works and Clear blockages with rodder machine', '0.00', 'unit', 1, 5, '6.00', '6.00', 1, '0.00', '0.00', '6.00', '0.00', '0.00', '6.00'),
(343, 20, '1.', '', '0.00', 'unit', 1, 1, '102.50', '102.50', 1, '0.00', '0.00', '102.50', '0.00', '0.00', '102.50'),
(344, 20, '3', 'NOKIA CHARGER TYPE CARBON 4598BK', '0.00', 'UNIT', 0, 2, '59.00', '59.00', 1, '0.00', '0.00', '59.00', '0.00', '0.00', '59.00'),
(345, 20, '4', 'Desludging Tanker 10 cubic metres (Cina Made)', '5.00', 'units', 1, 3, '99.00', '495.00', 6, '1.50', '7.05', '477.30', '5.00', '24.75', '470.25'),
(346, 20, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(347, 20, '2.', '', '0.00', 'unit', 1, 5, '6.00', '6.00', 1, '0.00', '0.00', '6.00', '0.00', '0.00', '6.00'),
(348, 20, '', 'A4 Bahasa Malaysia Exam papers9', '0.00', 'pcs', 0, 6, '6.49', '6.49', 1, '0.00', '0.00', '6.49', '0.00', '0.00', '6.49'),
(349, 20, '', 'AUTOMATIC TRANSMISSION FLUID', '0.00', 'unit', 0, 7, '102.50', '102.50', 1, '0.00', '0.00', '102.50', '0.00', '0.00', '102.50'),
(350, 20, '', 'Desludging Tanker 10 cubic metres (Cina Made)', '0.00', 'units', 0, 8, '99.00', '99.00', 1, '0.00', '0.00', '99.00', '0.00', '0.00', '99.00'),
(351, 20, '', 'Electrical Cable Malaysia Made', '0.00', 'pc', 0, 9, '10.49', '10.49', 1, '0.00', '0.00', '10.49', '0.00', '0.00', '10.49'),
(352, 20, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '0.00', '', 1, 10, '450.00', '450.00', 1, '0.00', '0.00', '450.00', '0.00', '0.00', '450.00'),
(353, 22, '', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 0, 1, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(354, 22, '', 'Jetting Works and Clear blockages with rodder machine', '0.00', 'unit', 0, 2, '6.00', '6.00', 1, '0.00', '0.00', '6.00', '0.00', '0.00', '6.00'),
(355, 22, '', 'AUTOMATIC TRANSMISSION FLUID', '0.00', 'unit', 0, 3, '102.50', '102.50', 1, '0.00', '0.00', '102.50', '0.00', '0.00', '102.50'),
(356, 22, '', 'TOP RADIATOR HOSE ORIGINAL', '0.00', '', 0, 4, '450.00', '450.00', 1, '0.00', '0.00', '450.00', '0.00', '0.00', '450.00'),
(357, 22, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '0.00', '', 1, 5, '450.00', '450.00', 1, '0.00', '0.00', '450.00', '0.00', '0.00', '450.00'),
(358, 23, '1', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '0.00', '', 0, 1, '450.00', '450.00', 1, '0.00', '0.00', '450.00', '0.00', '0.00', '450.00'),
(359, 23, '2', 'LABOUR TO REPLACE PARTS & SERVICE', '0.00', '', 1, 2, '56.00', '56.00', 1, '0.00', '0.00', '56.00', '0.00', '0.00', '56.00'),
(360, 23, '3', 'NOKIA CHARGER TYPE CARBON 4598BK', '0.00', 'UNIT', 0, 3, '59.00', '59.00', 1, '0.00', '0.00', '59.00', '0.00', '0.00', '59.00'),
(361, 23, '4', 'TOP RADIATOR HOSE ORIGINAL', '0.00', '', 0, 4, '450.00', '450.00', 1, '0.00', '0.00', '450.00', '0.00', '0.00', '450.00'),
(362, 23, '5', 'Desludging Tanker 10 cubic metres (Cina Made)', '0.00', 'units', 0, 5, '99.00', '99.00', 1, '0.00', '0.00', '99.00', '0.00', '0.00', '99.00'),
(363, 24, '', 'AUTOMATIC TRANSMISSION FLUID', '0.00', 'unit', 1, 1, '102.50', '102.50', 1, '0.00', '0.00', '102.50', '0.00', '0.00', '102.50'),
(364, 24, '', 'NOKIA CHARGER TYPE CARBON 4598BK', '0.00', 'UNIT', 0, 2, '59.00', '59.00', 1, '0.00', '0.00', '59.00', '0.00', '0.00', '59.00'),
(365, 24, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '0.00', '', 1, 3, '450.00', '450.00', 1, '0.00', '0.00', '450.00', '0.00', '0.00', '450.00'),
(366, 24, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(367, 24, '', 'Jetting Works and Clear blockages with rodder machine', '0.00', 'unit', 1, 5, '6.00', '6.00', 1, '0.00', '0.00', '6.00', '0.00', '0.00', '6.00'),
(368, 25, '1.', '', '0.00', 'unit', 1, 1, '102.50', '102.50', 1, '0.00', '0.00', '102.50', '0.00', '0.00', '102.50'),
(369, 25, '3', 'NOKIA CHARGER TYPE CARBON 4598BK', '0.00', 'UNIT', 0, 2, '59.00', '59.00', 1, '0.00', '0.00', '59.00', '0.00', '0.00', '59.00'),
(370, 25, '4', 'Desludging Tanker 10 cubic metres (Cina Made)', '5.00', 'units', 1, 3, '99.00', '495.00', 6, '1.50', '7.05', '477.30', '5.00', '24.75', '470.25'),
(371, 25, '', '', '0.00', '', 0, 4, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(372, 25, '2.', '', '0.00', 'unit', 1, 5, '6.00', '6.00', 1, '0.00', '0.00', '6.00', '0.00', '0.00', '6.00'),
(373, 25, '', 'A4 Bahasa Malaysia Exam papers9', '0.00', 'pcs', 0, 6, '6.49', '6.49', 1, '0.00', '0.00', '6.49', '0.00', '0.00', '6.49'),
(374, 25, '', 'AUTOMATIC TRANSMISSION FLUID', '0.00', 'unit', 0, 7, '102.50', '102.50', 1, '0.00', '0.00', '102.50', '0.00', '0.00', '102.50'),
(375, 25, '', 'Desludging Tanker 10 cubic metres (Cina Made)', '0.00', 'units', 0, 8, '99.00', '99.00', 1, '0.00', '0.00', '99.00', '0.00', '0.00', '99.00'),
(376, 25, '', 'Electrical Cable Malaysia Made', '0.00', 'pc', 0, 9, '10.49', '10.49', 1, '0.00', '0.00', '10.49', '0.00', '0.00', '10.49'),
(377, 25, '', 'Latest we have also include the salary range RM 4000.00 â€“ RM 5000.00 into Socso table as instructed by PERKESO. Previously it was maximum calculation until RM 4000.00 only.', '0.00', '', 1, 10, '450.00', '450.00', 1, '0.00', '0.00', '450.00', '0.00', '0.00', '450.00'),
(388, 26, '1.', 'TO SUPPLY LABOUR AND TOOLS FOR CLEAR RUSTY AND SLUDGE IN CONCRETE WATER TANK.', '12.00', 'UNITS', 0, 1, '1650.00', '19800.00', 1, '0.00', '0.00', '19800.00', '0.00', '0.00', '19800.00'),
(389, 26, '2.', 'TO SUPPLY LABOUR AND TOOLS FOR CLEAR RUSTY AND SLUDGE IN FIBER WATER TANK ( SIZE  1600 X 800 X 1600)', '12.00', 'UNITS', 0, 2, '0.00', '16200.00', 1, '0.00', '0.00', '16200.00', '0.00', '0.00', '16200.00'),
(390, 26, '3.', 'TO SUPPLY LABOUR AND TOOLS FOR CLEAR RUSTY AND SLUDGE IN FIBER WATER TANK ( SIZE  2800 X 2000 X 3200 )', '24.00', 'UNITS', 0, 3, '1850.00', '44400.00', 1, '0.00', '0.00', '44400.00', '0.00', '0.00', '44400.00'),
(391, 26, '4.', 'BOLT & NUT FOR FITTINGS, BRACKETS ETC', '200.00', 'PCS', 0, 4, '5.00', '1000.00', 1, '0.00', '0.00', '1000.00', '0.00', '0.00', '1000.00'),
(392, 26, '5.', 'TO SUPPLY ELBOW AND FITTINGS TO REPAIR LEAKING  (USE SCAFFFOLDING)', '2.00', '', 0, 5, '1900.00', '3800.00', 1, '0.00', '0.00', '3800.00', '0.00', '0.00', '3800.00'),
(393, 26, '6.', 'TO REMOVE ALL DEBRIS AND UNUSED PARTS / MATERIALS FROM WORKSITE AND DISPOSE AT AUTHORISED SITE', '0.00', '', 0, 6, '800.00', '800.00', 1, '0.00', '0.00', '800.00', '0.00', '0.00', '800.00'),
(394, 26, '7.', 'TO SUPPLY ALL TOOLS, MATERIALS AND SKILLED WORKERS TO COMPLETE THE JOB.', '0.00', '', 0, 7, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(395, 26, '8.', 'TO FOLLOW ALL SAFETY PROCEDURES AT WORK SITE AT ALL TIMES', '0.00', '', 0, 8, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(396, 26, '', '', '0.00', '', 0, 9, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00'),
(397, 26, '', '', '0.00', '', 0, 10, '0.00', '0.00', 1, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00');

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
