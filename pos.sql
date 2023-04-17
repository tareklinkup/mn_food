-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 01, 2020 at 06:20 AM
-- Server version: 5.7.24
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `mn-food`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_account`
--

DROP TABLE IF EXISTS `tbl_account`;
CREATE TABLE IF NOT EXISTS `tbl_account` (
  `Acc_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) NOT NULL,
  `Acc_Code` varchar(50) NOT NULL,
  `Acc_Tr_Type` varchar(25) DEFAULT NULL,
  `Acc_Name` varchar(200) NOT NULL,
  `Acc_Type` varchar(50) NOT NULL,
  `Acc_Description` varchar(255) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`Acc_SlNo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_account`
--

INSERT INTO `tbl_account` (`Acc_SlNo`, `branch_id`, `Acc_Code`, `Acc_Tr_Type`, `Acc_Name`, `Acc_Type`, `Acc_Description`, `status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`) VALUES
(1, 1, 'A0001', '', 'Office Expense', '', '', 'a', 'Admin', '2020-07-09 14:56:09', NULL, NULL),
(2, 1, 'A0002', '', 'Investment', '', '', 'a', 'Admin', '2020-07-09 14:56:22', NULL, NULL),
(3, 1, 'A0003', '', 'Rubayet Sir- DMD', '', 'Rubayet Sir- DMD', 'a', 'Admin', '2020-09-28 13:38:11', NULL, NULL),
(4, 1, 'A0004', '', 'Asif Advance', '', '', 'a', 'Admin', '2020-11-16 18:34:39', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_assets`
--

DROP TABLE IF EXISTS `tbl_assets`;
CREATE TABLE IF NOT EXISTS `tbl_assets` (
  `as_id` int(11) NOT NULL AUTO_INCREMENT,
  `as_date` date DEFAULT NULL,
  `as_name` varchar(50) DEFAULT NULL,
  `as_qty` int(11) DEFAULT NULL,
  `as_rate` decimal(10,2) DEFAULT NULL,
  `as_amount` decimal(10,2) DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `branchid` int(11) DEFAULT NULL,
  PRIMARY KEY (`as_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_assets`
--

INSERT INTO `tbl_assets` (`as_id`, `as_date`, `as_name`, `as_qty`, `as_rate`, `as_amount`, `status`, `AddBy`, `AddTime`, `branchid`) VALUES
(1, '2020-10-27', 'Eugenia England', 715, '95.00', '67925.00', 'd', 'Admin', '2020-10-27 16:58:31', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bank_accounts`
--

DROP TABLE IF EXISTS `tbl_bank_accounts`;
CREATE TABLE IF NOT EXISTS `tbl_bank_accounts` (
  `account_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_name` varchar(250) NOT NULL,
  `account_number` varchar(250) NOT NULL,
  `account_type` varchar(200) NOT NULL,
  `bank_name` varchar(250) NOT NULL,
  `branch_name` varchar(250) DEFAULT NULL,
  `initial_balance` float NOT NULL,
  `description` varchar(2000) NOT NULL,
  `saved_by` int(11) NOT NULL,
  `saved_datetime` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_datetime` datetime DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`account_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_bank_accounts`
--

INSERT INTO `tbl_bank_accounts` (`account_id`, `account_name`, `account_number`, `account_type`, `bank_name`, `branch_name`, `initial_balance`, `description`, `saved_by`, `saved_datetime`, `updated_by`, `updated_datetime`, `branch_id`, `status`) VALUES
(1, 'Mahin', '1235546', 'saving', 'Dbbl', 'ihjgjg', 10000, '', 1, '2020-07-09 16:19:13', NULL, NULL, 1, 1),
(2, 'Saif', '534533', 'Current', 'Ncc', 'Mirpur', 5000, '', 1, '2020-07-09 18:46:43', NULL, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bank_transactions`
--

DROP TABLE IF EXISTS `tbl_bank_transactions`;
CREATE TABLE IF NOT EXISTS `tbl_bank_transactions` (
  `transaction_id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL,
  `transaction_date` date NOT NULL,
  `transaction_type` varchar(10) NOT NULL,
  `amount` float NOT NULL,
  `note` varchar(500) DEFAULT NULL,
  `saved_by` int(11) NOT NULL,
  `saved_datetime` datetime NOT NULL,
  `branch_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`transaction_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_bank_transactions`
--

INSERT INTO `tbl_bank_transactions` (`transaction_id`, `account_id`, `transaction_date`, `transaction_type`, `amount`, `note`, `saved_by`, `saved_datetime`, `branch_id`, `status`) VALUES
(1, 1, '2020-07-09', 'withdraw', 50000, '', 1, '2020-07-09 18:27:16', 1, 1),
(2, 1, '2020-07-06', 'deposit', 200000, '', 1, '2020-07-09 18:27:51', 1, 1),
(3, 1, '2020-07-09', 'deposit', 851500, '', 1, '2020-07-09 18:30:08', 1, 1),
(4, 1, '2020-07-09', 'deposit', 200000, '', 1, '2020-07-09 18:30:47', 1, 1),
(5, 1, '2020-07-09', 'withdraw', 50000, '', 1, '2020-07-09 18:36:59', 1, 1),
(6, 1, '2020-07-09', 'deposit', 400000, '', 1, '2020-07-09 18:41:18', 1, 1),
(7, 2, '2020-07-09', 'withdraw', 5000, '', 1, '2020-07-09 18:47:19', 1, 1),
(8, 2, '2020-07-09', 'deposit', 500, '', 1, '2020-07-09 18:47:39', 1, 1),
(9, 2, '2020-07-09', 'withdraw', 500, '', 1, '2020-07-09 18:47:54', 1, 1),
(10, 1, '2020-08-29', 'deposit', 200000, '', 1, '2020-08-29 14:12:27', 1, 1),
(11, 2, '2020-09-27', 'deposit', 10000, 'rhh', 1, '2020-09-27 11:13:39', 1, 1),
(12, 1, '2020-09-28', 'withdraw', 500000, 'cash', 1, '2020-09-28 13:35:33', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_brand`
--

DROP TABLE IF EXISTS `tbl_brand`;
CREATE TABLE IF NOT EXISTS `tbl_brand` (
  `brand_SiNo` int(11) NOT NULL AUTO_INCREMENT,
  `ProductCategory_SlNo` int(11) NOT NULL,
  `brand_name` varchar(100) NOT NULL,
  `status` char(2) NOT NULL,
  `brand_branchid` int(11) NOT NULL,
  PRIMARY KEY (`brand_SiNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_brunch`
--

DROP TABLE IF EXISTS `tbl_brunch`;
CREATE TABLE IF NOT EXISTS `tbl_brunch` (
  `brunch_id` int(11) NOT NULL AUTO_INCREMENT,
  `Brunch_name` varchar(250) NOT NULL,
  `Brunch_title` varchar(250) CHARACTER SET utf8mb4 NOT NULL,
  `Brunch_address` text CHARACTER SET utf8mb4 NOT NULL,
  `Brunch_sales` varchar(1) NOT NULL COMMENT 'Wholesales = 1, Retail = 2',
  `add_date` date NOT NULL,
  `add_time` datetime NOT NULL,
  `add_by` char(50) NOT NULL,
  `update_by` char(50) NOT NULL,
  `status` char(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`brunch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_brunch`
--

INSERT INTO `tbl_brunch` (`brunch_id`, `Brunch_name`, `Brunch_title`, `Brunch_address`, `Brunch_sales`, `add_date`, `add_time`, `add_by`, `update_by`, `status`) VALUES
(1, 'Main Branch', 'Main Branch', 'Branch address here', '', '2020-07-07', '2020-07-07 11:57:47', '', '', 'a'),
(2, 'Branch 2', 'Branch 2', 'Dhanmondi, Dhaka', '2', '0000-00-00', '2020-07-07 22:02:45', 'Admin', 'Admin', 'd'),
(3, 'Muladuli Agro main', 'Muladuli Agro 1', 'Muladuli Rail gate', '2', '0000-00-00', '2020-09-02 13:03:31', 'Admin', '', 'a'),
(4, 'Muladuli Agro Poultry Farm', 'Poultry Farm', 'Muladuli, Ishwardi pabna', '2', '0000-00-00', '2020-09-02 13:13:09', 'Admin', '', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cashregister`
--

DROP TABLE IF EXISTS `tbl_cashregister`;
CREATE TABLE IF NOT EXISTS `tbl_cashregister` (
  `Transaction_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Transaction_Date` varchar(20) NOT NULL,
  `IdentityNo` varchar(50) DEFAULT NULL,
  `Narration` varchar(100) NOT NULL,
  `InAmount` decimal(18,2) NOT NULL,
  `OutAmount` decimal(18,2) NOT NULL,
  `Description` longtext NOT NULL,
  `Status` char(1) DEFAULT NULL,
  `Saved_By` varchar(50) DEFAULT NULL,
  `Saved_Time` datetime DEFAULT NULL,
  `Edited_By` varchar(50) DEFAULT NULL,
  `Edited_Time` datetime DEFAULT NULL,
  PRIMARY KEY (`Transaction_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cashtransaction`
--

DROP TABLE IF EXISTS `tbl_cashtransaction`;
CREATE TABLE IF NOT EXISTS `tbl_cashtransaction` (
  `Tr_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `Tr_Id` varchar(50) NOT NULL,
  `Tr_date` date NOT NULL,
  `Tr_Type` varchar(20) NOT NULL,
  `Tr_account_Type` varchar(50) NOT NULL,
  `Acc_SlID` int(11) NOT NULL,
  `Tr_Description` varchar(255) NOT NULL,
  `In_Amount` decimal(18,2) NOT NULL,
  `Out_Amount` decimal(18,2) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `AddBy` varchar(100) NOT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `Tr_branchid` int(11) NOT NULL,
  PRIMARY KEY (`Tr_SlNo`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_cashtransaction`
--

INSERT INTO `tbl_cashtransaction` (`Tr_SlNo`, `Tr_Id`, `Tr_date`, `Tr_Type`, `Tr_account_Type`, `Acc_SlID`, `Tr_Description`, `In_Amount`, `Out_Amount`, `status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `Tr_branchid`) VALUES
(1, 'TR00001', '2020-07-09', 'In Cash', '', 2, '', '200000.00', '0.00', 'a', 'Admin', '2020-07-09 18:34:55', NULL, NULL, 1),
(2, 'TR00001', '2020-07-09', 'In Cash', '', 2, '', '1316850.00', '0.00', 'a', 'Admin', '2020-07-09 18:35:24', 'Admin', '2020-07-09 18:35:34', 1),
(3, 'TR00003', '2020-07-09', 'In Cash', '', 2, '', '500000.00', '0.00', 'a', 'Admin', '2020-07-09 18:44:11', NULL, NULL, 1),
(4, 'TR00004', '2020-08-29', 'In Cash', '', 1, '', '500.00', '0.00', 'a', 'Admin', '2020-08-29 14:10:02', NULL, NULL, 1),
(5, 'TR00005', '2020-08-29', 'Out Cash', '', 2, '', '0.00', '1000.00', 'a', 'Admin', '2020-08-29 14:10:37', NULL, NULL, 1),
(6, 'TR00006', '2020-09-28', 'Out Cash', '', 3, 'City Corporation Visit', '0.00', '500.00', 'a', 'Admin', '2020-09-28 13:38:40', NULL, NULL, 1),
(7, 'TR00007', '2020-09-28', 'In Cash', '', 3, 'City Corporation Visit Return', '200.00', '0.00', 'a', 'Admin', '2020-09-28 13:39:08', NULL, NULL, 1),
(8, 'TR00008', '2020-09-28', 'In Cash', '', 2, 'Ashik Sir', '1000000.00', '0.00', 'a', 'Admin', '2020-09-28 13:39:41', NULL, NULL, 1),
(9, 'TR00009', '2020-11-16', 'Out Cash', '', 4, '', '0.00', '500.00', 'a', 'Admin', '2020-11-16 18:35:05', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_chalan`
--

DROP TABLE IF EXISTS `tbl_chalan`;
CREATE TABLE IF NOT EXISTS `tbl_chalan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice` varchar(200) NOT NULL,
  `chalan_date` date NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `total` float NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'a',
  `branch_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_date` timestamp NOT NULL,
  `updated_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_chalan`
--

INSERT INTO `tbl_chalan` (`id`, `invoice`, `chalan_date`, `purchase_id`, `total`, `status`, `branch_id`, `added_by`, `updated_by`, `created_date`, `updated_date`) VALUES
(1, 'CH0001', '2020-11-29', 2, 275, 'a', 1, 1, 1, '2020-11-29 06:45:07', '2020-11-29 06:54:21'),
(2, 'CH0002', '2020-11-29', 2, 390, 'a', 1, 1, 1, '2020-11-29 06:54:53', '2020-11-29 06:55:37'),
(3, 'CH0003', '2020-11-29', 1, 1248, 'a', 1, 1, NULL, '2020-11-29 07:04:09', NULL),
(4, 'CH0004', '2020-11-29', 1, 412, 'a', 1, 1, 1, '2020-11-29 09:18:26', '2020-11-29 09:34:25'),
(5, 'CH0005', '2020-11-29', 2, 2880, 'a', 1, 1, 1, '2020-11-29 09:38:16', '2020-11-29 09:43:16'),
(6, 'CH0006', '2020-11-29', 3, 6.2, 'a', 1, 1, NULL, '2020-11-29 09:45:59', NULL),
(7, 'CH0007', '2020-11-29', 4, 5, 'a', 1, 1, NULL, '2020-11-29 09:47:18', NULL),
(8, 'CH0008', '2020-11-29', 4, 5, 'a', 1, 1, NULL, '2020-11-29 09:47:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_chalan_details`
--

DROP TABLE IF EXISTS `tbl_chalan_details`;
CREATE TABLE IF NOT EXISTS `tbl_chalan_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) NOT NULL,
  `chalan_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `purchase_rate` float NOT NULL,
  `qty` int(11) NOT NULL,
  `chalan_date` date NOT NULL,
  `status` varchar(2) NOT NULL DEFAULT 'a',
  `branch_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_chalan_details`
--

INSERT INTO `tbl_chalan_details` (`id`, `purchase_id`, `chalan_id`, `product_id`, `purchase_rate`, `qty`, `chalan_date`, `status`, `branch_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 36, 55, 5, '2020-11-29', 'a', 1, 1, 1, '2020-11-29 06:45:07', '2020-11-29 06:54:21'),
(2, 2, 2, 36, 55, 6, '2020-11-29', 'a', 1, 1, 1, '2020-11-29 06:54:53', '2020-11-29 06:55:37'),
(3, 2, 2, 38, 6, 10, '2020-11-29', 'a', 1, 1, 1, '2020-11-29 06:54:53', '2020-11-29 06:55:37'),
(4, 1, 3, 38, 6, 8, '2020-11-29', 'a', 1, 1, NULL, '2020-11-29 07:04:09', NULL),
(5, 1, 3, 37, 80, 15, '2020-11-29', 'a', 1, 1, NULL, '2020-11-29 07:04:09', NULL),
(6, 1, 4, 38, 6, 2, '2020-11-29', 'a', 1, 1, 1, '2020-11-29 09:18:26', '2020-11-29 09:34:25'),
(7, 1, 4, 37, 80, 5, '2020-11-29', 'a', 1, 1, 1, '2020-11-29 09:18:26', '2020-11-29 09:34:25'),
(8, 2, 5, 36, 55, 48, '2020-11-29', 'a', 1, 1, 1, '2020-11-29 09:38:16', '2020-11-29 09:43:16'),
(9, 2, 5, 38, 6, 40, '2020-11-29', 'a', 1, 1, 1, '2020-11-29 09:38:16', '2020-11-29 09:43:16'),
(10, 3, 6, 30, 0.62, 10, '2020-11-29', 'a', 1, 1, NULL, '2020-11-29 09:45:59', NULL),
(11, 4, 7, 32, 1, 5, '2020-11-29', 'a', 1, 1, NULL, '2020-11-29 09:47:18', NULL),
(12, 4, 8, 32, 1, 5, '2020-11-29', 'a', 1, 1, NULL, '2020-11-29 09:47:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_checks`
--

DROP TABLE IF EXISTS `tbl_checks`;
CREATE TABLE IF NOT EXISTS `tbl_checks` (
  `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cus_id` int(20) DEFAULT NULL,
  `SM_id` int(20) UNSIGNED DEFAULT NULL,
  `bank_name` varchar(250) DEFAULT NULL,
  `branch_name` varchar(250) DEFAULT NULL,
  `check_no` varchar(250) DEFAULT NULL,
  `check_amount` decimal(18,2) DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `check_date` timestamp NULL DEFAULT NULL,
  `remid_date` timestamp NULL DEFAULT NULL,
  `sub_date` timestamp NULL DEFAULT NULL,
  `note` varchar(250) DEFAULT NULL,
  `check_status` char(5) DEFAULT 'Pe' COMMENT 'Pe =Pending, Pa = Paid',
  `status` char(5) NOT NULL DEFAULT 'a',
  `created_by` varchar(250) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `branch_id` int(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_color`
--

DROP TABLE IF EXISTS `tbl_color`;
CREATE TABLE IF NOT EXISTS `tbl_color` (
  `color_SiNo` int(11) NOT NULL AUTO_INCREMENT,
  `color_name` varchar(100) NOT NULL,
  `status` char(2) NOT NULL,
  PRIMARY KEY (`color_SiNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_company`
--

DROP TABLE IF EXISTS `tbl_company`;
CREATE TABLE IF NOT EXISTS `tbl_company` (
  `Company_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `Company_Name` varchar(150) NOT NULL,
  `Repot_Heading` text NOT NULL,
  `Company_Logo_org` varchar(250) NOT NULL,
  `Company_Logo_thum` varchar(250) NOT NULL,
  `Invoice_Type` int(11) NOT NULL,
  `Currency_Name` varchar(50) DEFAULT NULL,
  `Currency_Symbol` varchar(10) DEFAULT NULL,
  `SubCurrency_Name` varchar(50) DEFAULT NULL,
  `print_type` int(11) NOT NULL,
  `company_BrunchId` int(11) NOT NULL,
  PRIMARY KEY (`Company_SlNo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_company`
--

INSERT INTO `tbl_company` (`Company_SlNo`, `Company_Name`, `Repot_Heading`, `Company_Logo_org`, `Company_Logo_thum`, `Invoice_Type`, `Currency_Name`, `Currency_Symbol`, `SubCurrency_Name`, `print_type`, `company_BrunchId`) VALUES
(1, 'MN Food Ltd', '01645026688', 'unnamed.jpg', 'unnamed.jpg', 1, 'BDT', NULL, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_country`
--

DROP TABLE IF EXISTS `tbl_country`;
CREATE TABLE IF NOT EXISTS `tbl_country` (
  `Country_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `CountryName` varchar(50) NOT NULL,
  `Status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`Country_SlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_currentinventory`
--

DROP TABLE IF EXISTS `tbl_currentinventory`;
CREATE TABLE IF NOT EXISTS `tbl_currentinventory` (
  `inventory_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `purchase_quantity` float NOT NULL,
  `purchase_return_quantity` float NOT NULL,
  `production_quantity` float NOT NULL,
  `sales_quantity` float NOT NULL,
  `sales_return_quantity` float NOT NULL,
  `damage_quantity` float NOT NULL,
  `transfer_from_quantity` float NOT NULL,
  `transfer_to_quantity` float NOT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`inventory_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_currentinventory`
--

INSERT INTO `tbl_currentinventory` (`inventory_id`, `product_id`, `purchase_quantity`, `purchase_return_quantity`, `production_quantity`, `sales_quantity`, `sales_return_quantity`, `damage_quantity`, `transfer_from_quantity`, `transfer_to_quantity`, `branch_id`) VALUES
(1, 36, 59, 0, 0, 5, 0, 0, 0, 0, 1),
(2, 38, 60, 0, 0, 21, 0, 0, 0, 0, 1),
(3, 37, 17, 0, 0, 2, 0, 0, 0, 0, 1),
(4, 30, 10, 0, 0, 0, 0, 0, 0, 0, 1),
(5, 32, 10, 0, 0, 0, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

DROP TABLE IF EXISTS `tbl_customer`;
CREATE TABLE IF NOT EXISTS `tbl_customer` (
  `Customer_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `Customer_Code` varchar(50) NOT NULL,
  `Customer_Name` varchar(150) NOT NULL,
  `Customer_Type` varchar(50) NOT NULL,
  `Customer_Phone` varchar(50) NOT NULL,
  `Customer_Mobile` varchar(15) NOT NULL,
  `Customer_Email` varchar(50) NOT NULL,
  `Customer_OfficePhone` varchar(50) NOT NULL,
  `Customer_Address` varchar(300) NOT NULL,
  `owner_name` varchar(250) DEFAULT NULL,
  `Country_SlNo` int(11) NOT NULL,
  `area_ID` int(11) NOT NULL,
  `Customer_Web` varchar(50) NOT NULL,
  `Customer_Credit_Limit` decimal(18,2) NOT NULL,
  `previous_due` decimal(18,2) NOT NULL,
  `image_name` varchar(1000) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `Customer_brunchid` int(11) NOT NULL,
  PRIMARY KEY (`Customer_SlNo`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_customer`
--

INSERT INTO `tbl_customer` (`Customer_SlNo`, `Customer_Code`, `Customer_Name`, `Customer_Type`, `Customer_Phone`, `Customer_Mobile`, `Customer_Email`, `Customer_OfficePhone`, `Customer_Address`, `owner_name`, `Country_SlNo`, `area_ID`, `Customer_Web`, `Customer_Credit_Limit`, `previous_due`, `image_name`, `status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `Customer_brunchid`) VALUES
(1, 'C00001', 'Faruk Enterprise', 'retail', '', '5453453', '', '', 'Mirpur', 'Faruk', 0, 1, '', '50000.00', '5000.00', NULL, 'a', 'Admin', '2020-07-09 13:54:16', NULL, NULL, 1),
(2, 'C00002', 'Rahihim Enterprice', 'retail', '', '01771625732', '', '', 'Rajbari', 'Rahim', 0, 2, '', '20000.00', '0.00', NULL, 'a', 'Admin', '2020-07-09 14:47:06', 'Admin', '2020-07-09 15:35:16', 1),
(3, 'C00003', 'Rahoman stor', 'retail', '', '01773251452', '', '', 'Rajbari', 'Rahoman', 0, 2, '', '10000.00', '0.00', NULL, 'a', 'Admin', '2020-07-09 15:25:10', 'Admin', '2020-07-09 15:29:59', 1),
(4, 'C00004', 'Akter store', 'retail', '', '017445522541', '', '', '', 'jyrfyj', 0, 2, '', '10000.00', '0.00', NULL, 'a', 'Admin', '2020-07-09 17:05:45', NULL, NULL, 1),
(5, 'C00005', 'Mahin Enterprise', 'retail', '', '0144451041', '', '', 'svsv', 'dfvds', 0, 2, '', '122000.00', '0.00', NULL, 'a', 'Admin', '2020-07-09 17:06:11', NULL, NULL, 1),
(6, 'C00006', '', 'G', '', '', '', '', '', NULL, 0, 0, '', '0.00', '0.00', NULL, 'a', 'Admin', '2020-07-09 18:20:19', NULL, NULL, 1),
(7, 'C00007', '', 'G', '', '', '', '', '', NULL, 0, 0, '', '0.00', '0.00', NULL, 'a', 'Admin', '2020-07-09 18:25:14', NULL, NULL, 1),
(8, 'C00008', '', 'G', '', '', '', '', '', NULL, 0, 0, '', '0.00', '0.00', NULL, 'a', 'Admin', '2020-07-09 18:39:18', NULL, NULL, 1),
(9, 'C00009', 'Salauddin Enterprise', 'retail', '', '01771625752', '', '', 'Rajbari', 'Salauddin', 0, 2, '', '10000.00', '0.00', NULL, 'a', 'Admin', '2020-07-10 22:03:21', NULL, NULL, 1),
(10, 'C00010', 'akter store', 'G', '', '01713571290', '', '', '', NULL, 0, 0, '', '0.00', '0.00', NULL, 'a', 'Admin', '2020-07-11 17:42:06', NULL, NULL, 1),
(11, 'C00011', 'Sorif', 'G', '', '', '', '', 'Chandpur', NULL, 0, 0, '', '0.00', '0.00', NULL, 'a', 'Admin', '2020-07-28 22:33:57', NULL, NULL, 1),
(12, 'C00012', 'shuvo', 'retail', '', '01645026688', '', '', 'muladuli', 'shahid', 0, 1, '', '100000.00', '0.00', NULL, 'a', 'Admin', '2020-08-30 12:33:21', 'Admin', '2020-08-30 15:29:12', 1),
(13, 'C00013', 'Md. Raisul Islam', 'retail', '', '01955581116', '', '', '123 Dhaka', '', 0, 1, '', '1000000.00', '0.00', NULL, 'a', 'Admin', '2020-10-16 02:31:00', NULL, NULL, 1),
(14, 'C00014', 'Mr x', 'G', '', '22', '', '', 'ddd', NULL, 0, 0, '', '0.00', '0.00', NULL, 'a', 'Admin', '2020-10-29 16:32:43', NULL, NULL, 1),
(15, 'C00015', 'ee', 'G', '', 'eee', '', '', 'eeee', NULL, 0, 0, '', '0.00', '0.00', NULL, 'a', 'Admin', '2020-10-29 16:34:05', NULL, NULL, 1),
(16, 'C00016', '', 'G', '', '', '', '', '', NULL, 0, 0, '', '0.00', '0.00', NULL, 'a', 'Admin', '2020-10-31 11:50:24', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer_payment`
--

DROP TABLE IF EXISTS `tbl_customer_payment`;
CREATE TABLE IF NOT EXISTS `tbl_customer_payment` (
  `CPayment_id` int(11) NOT NULL AUTO_INCREMENT,
  `CPayment_date` date DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `CPayment_invoice` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `CPayment_customerID` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `CPayment_TransactionType` varchar(20) DEFAULT NULL,
  `CPayment_amount` decimal(18,2) DEFAULT NULL,
  `out_amount` float NOT NULL DEFAULT '0',
  `CPayment_Paymentby` varchar(50) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `CPayment_notes` varchar(225) CHARACTER SET latin1 DEFAULT NULL,
  `CPayment_brunchid` int(11) DEFAULT NULL,
  `CPayment_previous_due` float NOT NULL DEFAULT '0',
  `CPayment_Addby` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `CPayment_AddDAte` date DEFAULT NULL,
  `CPayment_status` varchar(1) DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `CPayment_UpdateDAte` date DEFAULT NULL,
  PRIMARY KEY (`CPayment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_customer_payment`
--

INSERT INTO `tbl_customer_payment` (`CPayment_id`, `CPayment_date`, `sale_id`, `CPayment_invoice`, `CPayment_customerID`, `CPayment_TransactionType`, `CPayment_amount`, `out_amount`, `CPayment_Paymentby`, `account_id`, `CPayment_notes`, `CPayment_brunchid`, `CPayment_previous_due`, `CPayment_Addby`, `CPayment_AddDAte`, `CPayment_status`, `update_by`, `CPayment_UpdateDAte`) VALUES
(1, '2020-12-01', 1, 'TR00001', '13', 'CR', '20.00', 0, 'cash', NULL, 'note', 1, -52, 'Admin', '2020-12-01', 'd', 0, '2020-12-01'),
(2, '2020-12-01', 1, 'TR00002', '13', 'CR', '10.00', 0, 'cash', NULL, '', 1, 28, 'Admin', '2020-12-01', 'a', 0, '2020-12-01'),
(3, '2020-12-01', 1, 'TR00003', '13', 'CP', '20.00', 0, 'cash', NULL, '', 1, 38, 'Admin', '2020-12-01', 'a', NULL, NULL),
(4, '2020-12-01', 1, 'TR00004', '13', 'CR', '8.00', 0, 'cash', NULL, 'jj', 1, 58, 'Admin', '2020-12-01', 'a', NULL, NULL),
(5, '2020-12-01', 1, 'TR00005', '13', 'CR', '4.00', 0, 'cash', NULL, '', 1, 45, 'Admin', '2020-12-01', 'a', 0, '2020-12-01'),
(6, '2020-12-01', 1, 'TR00006', '13', 'CR', '10.00', 0, 'cash', NULL, '', 1, 46, 'Admin', '2020-12-01', 'a', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_damage`
--

DROP TABLE IF EXISTS `tbl_damage`;
CREATE TABLE IF NOT EXISTS `tbl_damage` (
  `Damage_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `Damage_InvoiceNo` varchar(50) NOT NULL,
  `Damage_Date` date NOT NULL,
  `Damage_Description` varchar(300) NOT NULL,
  `status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `Damage_brunchid` int(11) NOT NULL,
  PRIMARY KEY (`Damage_SlNo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_damage`
--

INSERT INTO `tbl_damage` (`Damage_SlNo`, `Damage_InvoiceNo`, `Damage_Date`, `Damage_Description`, `status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `Damage_brunchid`) VALUES
(1, 'D0001', '2020-07-09', 'lokoikm', 'a', 'Admin', '2020-07-09 17:22:59', NULL, NULL, 1),
(2, 'D0002', '2020-07-09', 'Damage', 'a', 'Admin', '2020-07-09 18:00:11', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_damagedetails`
--

DROP TABLE IF EXISTS `tbl_damagedetails`;
CREATE TABLE IF NOT EXISTS `tbl_damagedetails` (
  `DamageDetails_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `Damage_SlNo` int(11) NOT NULL,
  `Product_SlNo` int(11) NOT NULL,
  `DamageDetails_DamageQuantity` float NOT NULL,
  `damage_amount` float NOT NULL,
  `status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`DamageDetails_SlNo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_damagedetails`
--

INSERT INTO `tbl_damagedetails` (`DamageDetails_SlNo`, `Damage_SlNo`, `Product_SlNo`, `DamageDetails_DamageQuantity`, `damage_amount`, `status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`) VALUES
(1, 1, 12, 1, 20, 'a', 'Admin', '2020-07-09 17:22:59', NULL, NULL),
(2, 2, 8, 50, 5000, 'a', 'Admin', '2020-07-09 18:00:11', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_department`
--

DROP TABLE IF EXISTS `tbl_department`;
CREATE TABLE IF NOT EXISTS `tbl_department` (
  `Department_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `Department_Name` varchar(50) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`Department_SlNo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_department`
--

INSERT INTO `tbl_department` (`Department_SlNo`, `Department_Name`, `status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`) VALUES
(1, 'Sales', 'a', 'Admin', '2020-07-09 13:56:10', NULL, NULL),
(2, 'Sells', 'a', 'Admin', '2020-07-09 16:56:11', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_designation`
--

DROP TABLE IF EXISTS `tbl_designation`;
CREATE TABLE IF NOT EXISTS `tbl_designation` (
  `Designation_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `Designation_Name` varchar(50) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`Designation_SlNo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_designation`
--

INSERT INTO `tbl_designation` (`Designation_SlNo`, `Designation_Name`, `status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`) VALUES
(1, 'Computer Operator ', 'a', 'Admin', '2020-07-09 13:56:00', NULL, NULL),
(2, 'Manager', 'a', 'Admin', '2020-07-09 16:55:58', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_district`
--

DROP TABLE IF EXISTS `tbl_district`;
CREATE TABLE IF NOT EXISTS `tbl_district` (
  `District_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `District_Name` varchar(50) NOT NULL,
  `status` char(10) NOT NULL DEFAULT 'a',
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`District_SlNo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_district`
--

INSERT INTO `tbl_district` (`District_SlNo`, `District_Name`, `status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`) VALUES
(1, 'Dhaka', 'a', 'Admin', '2020-07-09 13:53:22', NULL, NULL),
(2, 'Baradanga', 'a', 'Admin', '2020-07-09 14:44:51', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee`
--

DROP TABLE IF EXISTS `tbl_employee`;
CREATE TABLE IF NOT EXISTS `tbl_employee` (
  `Employee_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `Designation_ID` int(11) NOT NULL,
  `Department_ID` int(11) NOT NULL,
  `Employee_ID` varchar(50) NOT NULL,
  `Employee_Name` varchar(150) NOT NULL,
  `Employee_JoinDate` date NOT NULL,
  `Employee_Gender` varchar(20) NOT NULL,
  `Employee_BirthDate` date NOT NULL,
  `Employee_NID` varchar(50) NOT NULL,
  `Employee_ContactNo` varchar(20) NOT NULL,
  `Employee_Email` varchar(50) NOT NULL,
  `Employee_MaritalStatus` varchar(50) NOT NULL,
  `Employee_FatherName` varchar(150) NOT NULL,
  `Employee_MotherName` varchar(150) NOT NULL,
  `Employee_PrasentAddress` text NOT NULL,
  `Employee_PermanentAddress` text NOT NULL,
  `Employee_Pic_org` varchar(250) NOT NULL,
  `Employee_Pic_thum` varchar(250) NOT NULL,
  `salary_range` int(11) NOT NULL,
  `status` char(10) NOT NULL DEFAULT 'a',
  `AddBy` varchar(50) NOT NULL,
  `AddTime` varchar(50) NOT NULL,
  `UpdateBy` varchar(50) NOT NULL,
  `UpdateTime` varchar(50) NOT NULL,
  `Employee_brinchid` int(11) NOT NULL,
  PRIMARY KEY (`Employee_SlNo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_employee`
--

INSERT INTO `tbl_employee` (`Employee_SlNo`, `Designation_ID`, `Department_ID`, `Employee_ID`, `Employee_Name`, `Employee_JoinDate`, `Employee_Gender`, `Employee_BirthDate`, `Employee_NID`, `Employee_ContactNo`, `Employee_Email`, `Employee_MaritalStatus`, `Employee_FatherName`, `Employee_MotherName`, `Employee_PrasentAddress`, `Employee_PermanentAddress`, `Employee_Pic_org`, `Employee_Pic_thum`, `salary_range`, `status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `Employee_brinchid`) VALUES
(1, 1, 1, 'E1001', 'Salauddin', '2020-07-09', 'Male', '2020-07-09', '', '77', '', 'unmarried', '', '', 'jghfg', 'frhgfh', '', '', 15000, 'a', 'Admin', '2020-07-09 13:56:43', '', '', 1),
(2, 2, 1, 'E1002', 'Mahin', '2020-07-09', 'Male', '2019-07-31', '', '01745541', '', 'unmarried', 'GTRFS', 'FVSDFVS', 'fgvdfg', '', '', '', 20000, 'a', 'Admin', '2020-07-09 16:57:11', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee_payment`
--

DROP TABLE IF EXISTS `tbl_employee_payment`;
CREATE TABLE IF NOT EXISTS `tbl_employee_payment` (
  `employee_payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `Employee_SlNo` int(11) NOT NULL,
  `payment_date` date DEFAULT NULL,
  `month_id` int(11) NOT NULL,
  `payment_amount` decimal(18,2) NOT NULL,
  `deduction_amount` decimal(18,2) NOT NULL,
  `status` varchar(1) DEFAULT NULL,
  `save_by` char(30) NOT NULL,
  `save_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_by` int(11) DEFAULT NULL,
  `update_date` varchar(12) NOT NULL,
  `paymentBranch_id` int(11) NOT NULL,
  PRIMARY KEY (`employee_payment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_employee_payment`
--

INSERT INTO `tbl_employee_payment` (`employee_payment_id`, `Employee_SlNo`, `payment_date`, `month_id`, `payment_amount`, `deduction_amount`, `status`, `save_by`, `save_date`, `update_by`, `update_date`, `paymentBranch_id`) VALUES
(1, 2, '2020-08-29', 1, '2000.00', '0.00', 'a', '1', '2020-08-29 18:32:36', NULL, '', 1),
(2, 2, '2020-08-29', 1, '18000.00', '0.00', 'a', '1', '2020-08-29 18:33:27', NULL, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_expense_head`
--

DROP TABLE IF EXISTS `tbl_expense_head`;
CREATE TABLE IF NOT EXISTS `tbl_expense_head` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `head_name` varchar(100) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `status` enum('a','d') DEFAULT 'a',
  `saved_by` int(11) DEFAULT NULL,
  `saved_datetime` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `update_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_materials`
--

DROP TABLE IF EXISTS `tbl_materials`;
CREATE TABLE IF NOT EXISTS `tbl_materials` (
  `material_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `reorder_level` float NOT NULL,
  `purchase_rate` float NOT NULL,
  `unit_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`material_id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_materials`
--

INSERT INTO `tbl_materials` (`material_id`, `code`, `name`, `category_id`, `reorder_level`, `purchase_rate`, `unit_id`, `status`) VALUES
(1, 'M0001', 'MCP', 12, 100, 56, 3, 1),
(2, 'M0002', 'DDGS', 12, 10, 32, 3, 1),
(3, 'M0003', 'DL-Methionine', 12, 100, 225, 3, 1),
(4, 'M0004', 'Limestone', 12, 0, 10, 3, 1),
(5, 'M0005', 'meiz', 12, 4444, 19, 3, 1),
(6, 'M0006', 'Soyabin Mail', 12, 44444400, 31, 3, 1),
(7, 'M0007', 'Full Fat Soya', 12, 1000, 36, 3, 1),
(8, 'M0008', 'MBM', 12, 100, 60, 3, 1),
(9, 'M0009', 'Soyabean Oil ', 13, 1000, 75, 3, 1),
(10, 'M0010', 'L-Lysine', 12, 0, 160, 3, 1),
(11, 'M0011', 'Brolier Vitamin', 14, 0, 450, 3, 1),
(12, 'M0012', 'Brolier Mineral', 14, 0, 210, 3, 1),
(13, 'M0013', 'MN Grow', 14, 0, 375, 3, 1),
(14, 'M0014', 'Sd Mos', 14, 0, 140, 3, 1),
(15, 'M0015', 'Hal Q', 14, 0, 440, 3, 1),
(16, 'M0016', 'Rosszyme', 14, 0, 500, 3, 1),
(17, 'M0017', 'SGS', 14, 0, 160, 3, 1),
(18, 'M0018', 'Salt', 14, 0, 12, 3, 1),
(19, 'M0019', 'Phytase', 14, 0, 700, 3, 1),
(20, 'M0020', 'Anti Oxidint', 14, 0, 250, 3, 1),
(21, 'M0021', 'L- Threonin', 14, 0, 150, 3, 1),
(22, 'M0022', 'Soda', 14, 0, 40, 3, 1),
(23, 'M0023', 'Bio-Choline', 14, 0, 110, 3, 1),
(24, 'M0024', 'Liposorb', 14, 0, 440, 3, 1),
(25, 'M0025', 'GrowMax', 14, 0, 450, 3, 1),
(26, 'M0026', 'Protoxy Forts/Acinor', 14, 0, 700, 3, 1),
(27, 'M0027', 'Organic Mineral', 14, 0, 450, 3, 1),
(28, 'M0028', 'GP', 14, 0, 750, 3, 1),
(29, 'M0029', 'Butimax', 14, 0, 750, 3, 1),
(30, 'M0030', 'Nof Mold', 14, 0, 140, 3, 1),
(31, 'M0031', 'Betain vet', 14, 0, 500, 3, 1),
(32, 'M0032', 'Bag', 12, 0, 30, 1, 1),
(33, 'M0033', 'Sorisha', 13, 20, 20, 3, 1),
(34, 'M0034', 'mortin', 3, 100, 5, 1, 1),
(35, 'M0035', 'Fresh Deshi Chicken', 16, 0, 100, 3, 1),
(36, 'M0036', 'Best Bread ', 17, 0, 20, 1, 1),
(37, 'M0037', ' Mixed Spice', 19, 0, 1000, 3, 1),
(38, 'M0038', ' Salad ', 20, 0, 5, 7, 1),
(39, 'M0039', 'Pran Tomato Sauce ', 20, 0, 200, 3, 1),
(40, 'M0040', 'Vutta', 12, 10000, 20, 3, 1),
(41, 'M0041', 'Layer', 24, 0, 0, 1, 1),
(42, 'M0042', 'ssss', 4, 10, 5, 1, 1),
(43, 'M0043', 'Fan 80ml', 2, 0, 0.5, 1, 1),
(44, 'M0044', 'Fan 100ml', 2, 0, 0.52, 1, 1),
(45, 'M0045', 'Bottom Layer 80ml', 3, 0, 0.12, 1, 1),
(46, 'M0046', 'Bottom Layer 100ml', 3, 0, 0.13, 1, 1),
(47, 'M0047', 'xyz', 9, 100, 50, 1, 1),
(48, 'M0048', '200+ GSM Fan 80ml-5gm', 20, 1000, 0.5, 1, 1),
(49, 'M0049', 'GSM-150+ Bottom Layer 80ml-6gm', 20, 100, 200, 5, 1),
(50, 'M0050', 'GSM 200+ Fan 100ml-6gm', 20, 100, 0.6, 1, 1),
(51, 'M0051', 'GSM-150+ Bottom Layer 100ml-10kg', 20, 100, 30, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_material_damage`
--

DROP TABLE IF EXISTS `tbl_material_damage`;
CREATE TABLE IF NOT EXISTS `tbl_material_damage` (
  `damage_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice` varchar(50) NOT NULL,
  `damage_date` date NOT NULL,
  `description` varchar(2000) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'a',
  `added_by` int(11) NOT NULL,
  `added_datetime` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`damage_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_material_damage`
--

INSERT INTO `tbl_material_damage` (`damage_id`, `invoice`, `damage_date`, `description`, `status`, `added_by`, `added_datetime`, `updated_by`, `updated_datetime`) VALUES
(1, 'MD0001', '2001-08-19', 'Minim et consequatur', 'a', 1, '2020-10-27 11:59:48', 1, '2020-10-27 12:00:12'),
(2, 'MD0002', '1979-05-17', 'Molestiae dolor volu', 'a', 1, '2020-10-27 12:00:00', NULL, NULL),
(3, 'MD0003', '1977-04-19', 'Esse aliquam duis co', 'a', 1, '2020-10-27 12:01:04', NULL, NULL),
(4, 'MD0004', '1977-04-19', 'Esse aliquam duis co', 'a', 1, '2020-10-27 12:01:32', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_material_damage_details`
--

DROP TABLE IF EXISTS `tbl_material_damage_details`;
CREATE TABLE IF NOT EXISTS `tbl_material_damage_details` (
  `damage_details_id` int(11) NOT NULL AUTO_INCREMENT,
  `damage_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `damage_quantity` float NOT NULL,
  `damage_amount` float NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'a',
  PRIMARY KEY (`damage_details_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_material_damage_details`
--

INSERT INTO `tbl_material_damage_details` (`damage_details_id`, `damage_id`, `material_id`, `damage_quantity`, `damage_amount`, `status`) VALUES
(1, 1, 2, 29, 66, 'a'),
(2, 2, 4, 87, 70, 'a'),
(3, 3, 7, 46, 41, 'a'),
(4, 4, 13, 10, 33, 'a');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_material_purchase`
--

DROP TABLE IF EXISTS `tbl_material_purchase`;
CREATE TABLE IF NOT EXISTS `tbl_material_purchase` (
  `purchase_id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) NOT NULL,
  `invoice_no` varchar(100) DEFAULT NULL,
  `purchase_date` date NOT NULL,
  `purchase_for` int(11) NOT NULL,
  `sub_total` float DEFAULT NULL,
  `vat` float DEFAULT NULL,
  `transport_cost` float DEFAULT NULL,
  `discount` float DEFAULT NULL,
  `total` float DEFAULT NULL,
  `paid` float DEFAULT NULL,
  `due` float DEFAULT NULL,
  `previous_due` float NOT NULL,
  `note` varchar(2000) NOT NULL DEFAULT '0',
  `status` varchar(10) NOT NULL DEFAULT 'a',
  PRIMARY KEY (`purchase_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_material_purchase_details`
--

DROP TABLE IF EXISTS `tbl_material_purchase_details`;
CREATE TABLE IF NOT EXISTS `tbl_material_purchase_details` (
  `purchase_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `purchase_rate` float NOT NULL,
  `quantity` float NOT NULL,
  `total` float NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'a',
  PRIMARY KEY (`purchase_detail_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_month`
--

DROP TABLE IF EXISTS `tbl_month`;
CREATE TABLE IF NOT EXISTS `tbl_month` (
  `month_id` int(11) NOT NULL AUTO_INCREMENT,
  `month_name` char(30) NOT NULL,
  PRIMARY KEY (`month_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_month`
--

INSERT INTO `tbl_month` (`month_id`, `month_name`) VALUES
(1, 'january'),
(2, 'feb');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

DROP TABLE IF EXISTS `tbl_order`;
CREATE TABLE IF NOT EXISTS `tbl_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entry_date` date NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `purchase_rate` float NOT NULL,
  `sale_rate` float NOT NULL,
  `qty` int(11) NOT NULL,
  `total_amount` float NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_order`
--

INSERT INTO `tbl_order` (`id`, `entry_date`, `customer_id`, `product_id`, `purchase_rate`, `sale_rate`, `qty`, `total_amount`, `created_by`, `updated_by`, `created_at`, `updated_at`, `branch_id`) VALUES
(24, '2020-11-29', 5, 36, 55, 20, 5, 100, 1, NULL, '2020-11-30 06:58:30', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

DROP TABLE IF EXISTS `tbl_product`;
CREATE TABLE IF NOT EXISTS `tbl_product` (
  `Product_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `Product_Code` varchar(50) NOT NULL,
  `Product_Name` varchar(150) NOT NULL,
  `ProductCategory_ID` int(11) NOT NULL,
  `color` int(11) NOT NULL,
  `brand` int(11) NOT NULL,
  `size` varchar(11) NOT NULL DEFAULT 'na',
  `vat` float NOT NULL,
  `Product_ReOrederLevel` int(11) NOT NULL,
  `Product_Purchase_Rate` decimal(18,2) NOT NULL,
  `Product_SellingPrice` decimal(18,2) NOT NULL,
  `Product_MinimumSellingPrice` decimal(18,2) NOT NULL,
  `Product_WholesaleRate` decimal(18,2) NOT NULL,
  `one_cartun_equal` varchar(20) NOT NULL,
  `is_service` varchar(10) NOT NULL DEFAULT 'false',
  `Unit_ID` int(11) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `AddBy` varchar(100) NOT NULL,
  `AddTime` varchar(30) NOT NULL,
  `UpdateBy` varchar(50) NOT NULL,
  `UpdateTime` varchar(30) NOT NULL,
  `Product_branchid` int(11) NOT NULL,
  PRIMARY KEY (`Product_SlNo`),
  UNIQUE KEY `Product_Code` (`Product_Code`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`Product_SlNo`, `Product_Code`, `Product_Name`, `ProductCategory_ID`, `color`, `brand`, `size`, `vat`, `Product_ReOrederLevel`, `Product_Purchase_Rate`, `Product_SellingPrice`, `Product_MinimumSellingPrice`, `Product_WholesaleRate`, `one_cartun_equal`, `is_service`, `Unit_ID`, `status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `Product_branchid`) VALUES
(1, 'P00001', 'Fair & Lovely Face wash 100ml', 2, 0, 0, 'na', 0, 10, '54.00', '60.00', '0.00', '56.00', '', 'false', 1, 'a', 'Admin', '2020-07-09 13:59:15', '', '', 1),
(2, 'P00002', 'Garnier Face wash 100ml', 2, 0, 0, 'na', 0, 10, '80.00', '100.00', '0.00', '90.00', '', 'false', 1, 'a', 'Admin', '2020-07-09 14:00:01', '', '', 1),
(3, 'P00003', 'Good Night ', 1, 0, 0, 'na', 0, 0, '10.00', '15.00', '0.00', '0.00', '', 'false', 1, 'a', 'Admin', '2020-07-09 14:22:37', '', '', 1),
(4, 'P00004', 'Red Coil Box', 3, 0, 0, 'na', 0, 100, '60.00', '50.00', '0.00', '90.00', '', 'false', 4, 'a', 'Admin', '2020-07-09 14:24:05', '', '', 1),
(5, 'P00005', '120 Vajatissu', 5, 0, 0, 'na', 0, 0, '25.00', '30.00', '0.00', '0.00', '', 'false', 1, 'a', 'Admin', '2020-07-09 14:25:29', '', '', 1),
(6, 'P00006', '160 Vaja Tissu', 5, 0, 0, 'na', 0, 0, '2.00', '6.00', '0.00', '4.00', '', 'false', 1, 'a', 'Admin', '2020-07-09 14:29:46', '', '', 1),
(7, 'P00007', 'Small Diapant', 6, 0, 0, 'na', 0, 0, '10.00', '20.00', '0.00', '15.00', '', 'false', 1, 'a', 'Admin', '2020-07-09 15:07:51', '', '', 1),
(8, 'P00008', 'Kalohit400ml', 1, 0, 0, 'na', 0, 5, '10.00', '20.00', '0.00', '0.00', '', 'false', 1, 'a', 'Admin', '2020-07-09 15:21:34', '', '', 1),
(9, 'P00009', 'Finlay Dust', 7, 0, 0, 'na', 0, 10, '100.00', '120.00', '0.00', '0.00', '', 'false', 3, 'a', 'Admin', '2020-07-09 16:12:46', '', '', 1),
(10, 'P00010', 'Salt ', 8, 0, 0, 'na', 0, 10, '10.00', '15.00', '0.00', '0.00', '', 'false', 3, 'a', 'Admin', '2020-07-09 16:51:54', '', '', 1),
(11, 'P00011', 'Sahi Jira', 9, 0, 0, 'na', 0, 10, '110.00', '150.00', '0.00', '0.00', '', 'false', 3, 'a', 'Admin', '2020-07-09 16:52:19', '', '', 1),
(12, 'P00012', 'holud', 10, 0, 0, 'na', 0, 10, '50.00', '70.00', '0.00', '0.00', '', 'false', 3, 'a', 'Admin', '2020-07-09 16:52:55', '', '', 1),
(13, 'P00013', 'Chini', 11, 0, 0, 'na', 0, 10, '40.00', '50.00', '0.00', '0.00', '', 'false', 3, 'a', 'Admin', '2020-07-09 17:02:23', '', '', 1),
(14, 'P00014', 'Elach', 11, 0, 0, 'na', 0, 10, '100.00', '120.00', '0.00', '0.00', '', 'false', 3, 'a', 'Admin', '2020-07-09 17:02:44', '', '', 1),
(15, 'P00015', 'Daruchini', 11, 0, 0, 'na', 0, 10, '200.00', '230.00', '0.00', '0.00', '', 'false', 3, 'a', 'Admin', '2020-07-09 17:03:04', '', '', 1),
(16, 'P00016', 'Tokma', 11, 0, 0, 'na', 0, 10, '200.00', '230.00', '0.00', '0.00', '', 'false', 3, 'a', 'Admin', '2020-07-09 17:03:32', '', '', 1),
(17, 'P00017', 'Brick', 4, 0, 0, 'na', 0, 0, '7.00', '10.00', '0.00', '0.00', '', 'false', 1, 'a', 'Admin', '2020-07-18 10:26:48', '', '', 1),
(18, 'P00018', 'Brolir Statre', 12, 0, 0, 'na', 0, 22222, '2050.00', '2200.00', '0.00', '2100.00', '', 'true', 2, 'a', 'Admin', '2020-07-26 18:04:57', 'Admin', '2020-07-26 18:23:52', 1),
(19, 'P00019', 'Broiler Grower', 12, 0, 0, 'na', 0, 0, '2050.00', '2200.00', '0.00', '2100.00', '', 'true', 2, 'a', 'Admin', '2020-07-26 18:27:31', 'Admin', '2020-07-26 18:27:54', 1),
(20, 'P00020', 'meiz', 12, 0, 0, 'na', 0, 5555, '19.00', '19.00', '0.00', '0.00', '', 'false', 2, 'a', 'Admin', '2020-07-26 18:36:53', '', '', 1),
(21, 'P00021', 'Burger King', 15, 0, 0, 'na', 0, 100, '90.00', '120.00', '0.00', '100.00', '', 'false', 1, 'a', 'Admin', '2020-08-15 22:56:07', '', '', 1),
(22, 'P00022', 'Rupchada plastic bosta 25kg', 21, 0, 0, 'na', 0, 0, '13.00', '0.00', '0.00', '0.00', '', 'false', 1, 'a', 'Admin', '2020-08-29 10:56:52', 'Admin', '2020-08-29 10:57:59', 1),
(23, 'P00023', 'Rupchada Plastic bosta 50kg', 21, 0, 0, 'na', 0, 0, '17.00', '0.00', '0.00', '0.00', '', 'false', 1, 'a', 'Admin', '2020-08-29 10:57:23', 'Admin', '2020-08-29 10:58:21', 1),
(24, 'P00024', 'Rupchada Choter Bosta 50kg', 21, 0, 0, 'na', 0, 0, '33.00', '0.00', '0.00', '0.00', '', 'false', 1, 'a', 'Admin', '2020-08-29 10:58:54', '', '', 1),
(25, 'P00025', 'L.L', 12, 0, 0, 'na', 0, 0, '2327.50', '0.00', '0.00', '0.00', '', 'false', 2, 'a', 'Admin', '2020-08-30 14:56:58', '', '', 1),
(26, 'P00026', 'L.G', 12, 0, 0, 'na', 0, 0, '2382.50', '0.00', '0.00', '0.00', '', 'false', 2, 'a', 'Admin', '2020-08-30 14:57:32', '', '', 1),
(27, 'P00027', 'Layer Hens', 24, 0, 0, 'na', 0, 0, '15.00', '0.00', '0.00', '0.00', '', 'false', 1, 'a', 'Admin', '2020-09-02 13:26:27', '', '', 1),
(28, 'P00028', 'Egg', 24, 0, 0, 'na', 0, 0, '10.00', '0.00', '0.00', '0.00', '', 'false', 1, 'a', 'Admin', '2020-09-02 13:37:43', '', '', 1),
(29, 'P00029', 'Nascafe 100 ml', 2, 0, 0, 'na', 0, 0, '0.65', '1.00', '0.00', '0.00', '', 'false', 1, 'a', 'Admin', '2020-10-01 14:23:31', '', '', 1),
(30, 'P00030', 'Nascafe 80 ml', 2, 0, 0, 'na', 0, 0, '0.62', '0.80', '0.00', '0.00', '', 'false', 1, 'a', 'Admin', '2020-10-01 14:24:07', '', '', 1),
(31, 'P00031', 'GSM 200+ 80ml Cup 7gm', 20, 0, 0, 'na', 0, 100, '0.90', '1.25', '0.00', '1.25', '', 'false', 1, 'a', 'Admin', '2020-10-19 18:21:23', '', '', 1),
(32, 'P00032', 'GSM 200+ 100ml Cup 8gm', 20, 0, 0, 'na', 0, 2000, '1.00', '1.50', '0.00', '1.50', '', 'false', 1, 'a', 'Admin', '2020-10-19 18:22:00', '', '', 1),
(33, 'P00033', '81 bottom Black', 25, 0, 0, 'na', 0, 50, '24.00', '0.00', '0.00', '30.00', '', 'false', 1, 'a', 'Admin', '2020-10-31 11:41:07', '', '', 1),
(34, 'P00034', '81 bottom red', 25, 0, 0, 'na', 0, 50, '24.00', '30.00', '0.00', '30.00', '', 'false', 1, 'a', 'Admin', '2020-10-31 11:41:49', '', '', 1),
(35, 'P00035', 'Atta', 15, 0, 0, 'na', 0, 40, '18.00', '30.00', '0.00', '25.00', '', 'false', 3, 'a', 'Admin', '2020-11-16 18:15:37', '', '', 1),
(36, 'P00036', 'suger', 15, 0, 0, 'na', 0, 40, '55.00', '0.00', '0.00', '58.00', '', 'false', 3, 'a', 'Admin', '2020-11-16 18:16:42', '', '', 1),
(37, 'P00037', 'oil', 15, 0, 0, 'na', 0, 50, '80.00', '0.00', '0.00', '85.00', '', 'false', 3, 'a', 'Admin', '2020-11-16 18:17:32', '', '', 1),
(38, 'P00038', 'egg 1', 15, 0, 0, 'na', 0, 24, '6.00', '8.00', '0.00', '7.00', '', 'false', 1, 'a', 'Admin', '2020-11-16 18:18:49', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_productcategory`
--

DROP TABLE IF EXISTS `tbl_productcategory`;
CREATE TABLE IF NOT EXISTS `tbl_productcategory` (
  `ProductCategory_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `ProductCategory_Name` varchar(150) NOT NULL,
  `ProductCategory_Description` varchar(300) NOT NULL,
  `status` char(1) NOT NULL,
  `AddBy` varchar(50) NOT NULL,
  `AddTime` varchar(30) NOT NULL,
  `UpdateBy` varchar(50) NOT NULL,
  `UpdateTime` varchar(30) NOT NULL,
  `category_branchid` int(11) NOT NULL,
  PRIMARY KEY (`ProductCategory_SlNo`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_productcategory`
--

INSERT INTO `tbl_productcategory` (`ProductCategory_SlNo`, `ProductCategory_Name`, `ProductCategory_Description`, `status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `category_branchid`) VALUES
(1, 'Godrej', '', 'd', 'Admin', '2020-07-09 13:57:44', '', '', 1),
(2, 'Facewash', '', 'a', 'Admin', '2020-07-09 13:58:30', '', '', 1),
(3, 'Coil', '', 'a', 'Admin', '2020-07-09 14:14:48', '', '', 1),
(4, 'Lalbag', '', 'a', 'Admin', '2020-07-09 14:19:01', '', '', 1),
(5, 'Thai ', '', 'a', 'Admin', '2020-07-09 14:19:24', '', '', 1),
(6, 'Boshundhara Diapant', '', 'a', 'Admin', '2020-07-09 15:04:42', '', '', 1),
(7, 'Tea', '', 'd', 'Admin', '2020-07-09 16:11:20', '', '', 1),
(8, 'Salt', '', 'd', 'Admin', '2020-07-09 16:50:28', '', '', 1),
(9, 'Jira', '', 'a', 'Admin', '2020-07-09 16:50:42', '', '', 1),
(10, 'Holud', '', 'a', 'Admin', '2020-07-09 16:50:50', '', '', 1),
(11, 'Mudi Group', '', 'a', 'Admin', '2020-07-09 17:01:28', '', '', 1),
(12, 'feed', 'Feed', 'a', 'Admin', '2020-07-26 00:10:22', '', '', 1),
(13, 'Oil', 'Oil', 'a', 'Admin', '2020-07-27 17:53:37', '', '', 1),
(14, 'ME', '', 'a', 'Admin', '2020-08-02 22:00:00', '', '', 1),
(15, 'Burger ', '', 'a', 'Admin', '2020-08-15 22:23:53', 'Admin', '2020-08-15 22:24:29', 1),
(16, 'Meat', '', 'a', 'Admin', '2020-08-15 22:27:07', '', '', 1),
(17, 'Bread ', '', 'a', 'Admin', '2020-08-15 22:30:04', '', '', 1),
(18, 'Mayonnaise', '', 'a', 'Admin', '2020-08-15 22:31:08', '', '', 1),
(19, 'Spice', '', 'a', 'Admin', '2020-08-15 23:01:56', '', '', 1),
(20, 'Others', '', 'a', 'Admin', '2020-08-15 23:02:13', '', '', 1),
(21, 'Bosta', '', 'a', 'Admin', '2020-08-29 10:53:28', '', '', 1),
(22, 'Dhan', '', 'a', 'Admin', '2020-08-29 10:54:02', '', '', 1),
(23, 'Chal', '', 'a', 'Admin', '2020-08-29 10:54:07', '', '', 1),
(24, 'Layer', 'Hens', 'a', 'Admin', '2020-09-02 13:25:01', '', '', 1),
(25, 'Parking Tiles', '', 'a', 'Admin', '2020-10-31 11:38:05', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_productions`
--

DROP TABLE IF EXISTS `tbl_productions`;
CREATE TABLE IF NOT EXISTS `tbl_productions` (
  `production_id` int(11) NOT NULL AUTO_INCREMENT,
  `production_sl` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `incharge_id` int(11) DEFAULT NULL,
  `shift` varchar(250) DEFAULT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `labour_cost` float NOT NULL,
  `material_cost` float NOT NULL,
  `other_cost` float NOT NULL,
  `total_cost` float NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'a',
  PRIMARY KEY (`production_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_productions`
--

INSERT INTO `tbl_productions` (`production_id`, `production_sl`, `date`, `incharge_id`, `shift`, `note`, `labour_cost`, `material_cost`, `other_cost`, `total_cost`, `status`) VALUES
(1, 'PR-0001', '2020-07-09', 1, 'Day', 'ddd', 0, 20500, 500, 21000, 'a'),
(2, 'PR-0002', '2020-07-12', 1, 'Day', '', 400, 100, 50, 550, 'a'),
(3, 'PR-0003', '2020-07-18', 1, 'Day', '', 10, 1000, 0, 1010, 'a'),
(4, 'PR-0004', '2020-07-18', 2, 'Day', '', 100, 20000, 0, 20100, 'a'),
(5, 'PR-0005', '2020-07-18', 1, 'Day', '', 0, 12525, 0, 12525, 'a'),
(6, 'PR-0006', '2020-07-26', 1, 'Day', '', 100, 200320, 1000, 201420, 'a'),
(7, 'PR-0007', '2020-07-26', 2, 'Day', '', 300, 11150, 100, 11550, 'a'),
(8, 'PR-0008', '2020-07-27', 2, 'Day', '', 500, 12812.5, 500, 13812.5, 'a'),
(9, 'PR-0009', '2020-07-28', 2, 'Day', '', 0, 50, 0, 50, 'a'),
(10, 'PR-0010', '2020-07-28', 1, 'Day', '', 0, 125, 0, 125, 'a'),
(11, 'PR-0011', '2020-08-02', 1, 'Day', '', 160, 15969.5, 250, 16379.5, 'a'),
(12, 'PR-0012', '2020-08-10', 1, 'Day', '', 200, 100, 50, 350, 'a'),
(13, 'PR-0013', '2020-08-16', 2, 'Day', '', 10, 67.5, 10, 87.5, 'a'),
(14, 'PR-0014', '2020-08-29', 2, 'Day', '', 1500, 106350, 500, 108350, 'a'),
(15, 'PR-0015', '2020-08-30', 2, 'Day', '', 0, 6060, 500, 6560, 'a'),
(16, 'PR-0016', '2020-09-01', 2, 'Night', '1 bag layer grower feed', 10, 1620, 10, 1640, 'a'),
(17, 'PR-0017', '2020-09-09', 1, 'Day', '', 0, 4019, 0, 4019, 'a'),
(18, 'PR-0018', '2020-09-27', 1, 'Day', 'iluil', 100, 1000, 20, 1120, 'a'),
(19, 'PR-0019', '2020-09-28', 1, 'Day', '', 0, 35800, 0, 35800, 'a'),
(20, 'PR-0020', '2020-10-01', 1, 'Day', '', 0, 12700, 0, 12700, 'a'),
(21, 'PR-0021', '2020-10-06', 1, 'Day', '', 200, 2799, 70, 3069, 'a'),
(22, 'PR-0022', '2020-10-19', 1, 'Day', '', 1000, 1360, 0, 2360, 'a'),
(23, 'PR-0023', '2020-10-28', 1, 'Day', 'yty', 200, 2730, 50, 2980, 'a'),
(24, 'PR-0024', '2020-11-07', 1, 'Day', '', 100, 2795, 0, 2895, 'a'),
(25, 'PR-0025', '2020-11-16', 1, 'Day', '', 20000, 1668, 500, 22168, 'a');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_production_details`
--

DROP TABLE IF EXISTS `tbl_production_details`;
CREATE TABLE IF NOT EXISTS `tbl_production_details` (
  `production_id` int(11) NOT NULL,
  `material_id` int(11) NOT NULL,
  `quantity` float NOT NULL,
  `purchase_rate` float NOT NULL,
  `total` decimal(18,2) NOT NULL DEFAULT '0.00',
  `status` varchar(10) NOT NULL DEFAULT 'a'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_production_details`
--

INSERT INTO `tbl_production_details` (`production_id`, `material_id`, `quantity`, `purchase_rate`, `total`, `status`) VALUES
(1, 2, 2, 10000, '20000.00', 'a'),
(1, 1, 10, 50, '500.00', 'a'),
(2, 3, 20, 5, '100.00', 'a'),
(3, 4, 100, 10, '1000.00', 'a'),
(4, 4, 2000, 10, '20000.00', 'a'),
(5, 3, 5, 5, '25.00', 'a'),
(5, 1, 30, 50, '1500.00', 'a'),
(5, 2, 1, 10000, '10000.00', 'a'),
(5, 4, 100, 10, '1000.00', 'a'),
(6, 3, 10, 5, '50.00', 'a'),
(6, 1, 5, 50, '250.00', 'a'),
(6, 2, 20, 10000, '200000.00', 'a'),
(6, 4, 2, 10, '20.00', 'a'),
(7, 3, 10, 5, '50.00', 'a'),
(7, 1, 2, 50, '100.00', 'a'),
(7, 2, 1, 10000, '10000.00', 'a'),
(7, 4, 100, 10, '1000.00', 'a'),
(8, 5, 250, 19, '4750.00', 'a'),
(8, 6, 150, 31, '4650.00', 'a'),
(8, 7, 50, 36, '1800.00', 'a'),
(8, 8, 5, 60, '300.00', 'a'),
(8, 9, 17.5, 75, '1312.50', 'a'),
(9, 3, 10, 5, '50.00', 'a'),
(10, 3, 5, 5, '25.00', 'a'),
(10, 1, 2, 50, '100.00', 'a'),
(11, 1, 5, 56, '280.00', 'a'),
(11, 2, 15, 32, '480.00', 'a'),
(11, 3, 1.35, 225, '303.75', 'a'),
(11, 4, 7, 10, '70.00', 'a'),
(11, 7, 50, 36, '1800.00', 'a'),
(11, 9, 17.5, 75, '1312.50', 'a'),
(11, 10, 0.8, 160, '128.00', 'a'),
(11, 11, 0.25, 450, '112.50', 'a'),
(11, 12, 0.25, 210, '52.50', 'a'),
(11, 13, 0.25, 375, '93.75', 'a'),
(11, 14, 0.5, 140, '70.00', 'a'),
(11, 15, 0.5, 440, '110.00', 'a'),
(11, 16, 0.15, 500, '75.00', 'a'),
(11, 17, 1, 160, '80.00', 'a'),
(11, 18, 1, 12, '12.00', 'a'),
(11, 19, 0.05, 700, '35.00', 'a'),
(11, 20, 0.12, 250, '15.00', 'a'),
(11, 21, 0.25, 150, '37.50', 'a'),
(11, 22, 0.8, 40, '32.00', 'a'),
(11, 23, 0.25, 110, '27.50', 'a'),
(11, 24, 0.25, 440, '110.00', 'a'),
(11, 25, 0.25, 450, '112.50', 'a'),
(11, 26, 0.15, 700, '105.00', 'a'),
(11, 27, 0.25, 450, '112.50', 'a'),
(11, 28, 0.2, 750, '150.00', 'a'),
(11, 29, 0.15, 750, '112.50', 'a'),
(11, 30, 0.5, 140, '70.00', 'a'),
(11, 31, 0.25, 500, '125.00', 'a'),
(11, 32, 10, 30, '300.00', 'a'),
(11, 5, 255, 20, '5100.00', 'a'),
(11, 6, 135, 31, '4185.00', 'a'),
(11, 8, 6, 60, '360.00', 'a'),
(12, 34, 20, 5, '100.00', 'a'),
(13, 35, 0.25, 100, '25.00', 'a'),
(13, 36, 1, 20, '20.00', 'a'),
(13, 37, 0.01, 1000, '10.00', 'a'),
(13, 9, 0.1, 75, '7.50', 'a'),
(13, 38, 1, 5, '5.00', 'a'),
(14, 4, 100, 10, '1000.00', 'a'),
(14, 3, 10, 225, '2250.00', 'a'),
(14, 6, 100, 31, '3100.00', 'a'),
(14, 39, 500, 200, '100000.00', 'a'),
(15, 4, 500, 10, '5000.00', 'a'),
(15, 6, 10, 31, '310.00', 'a'),
(15, 9, 10, 75, '750.00', 'a'),
(16, 1, 10, 56, '560.00', 'a'),
(16, 2, 20, 32, '320.00', 'a'),
(16, 4, 10, 10, '100.00', 'a'),
(16, 5, 10, 19, '190.00', 'a'),
(16, 11, 1, 450, '450.00', 'a'),
(17, 2, 2, 32, '64.00', 'a'),
(17, 6, 5, 31, '155.00', 'a'),
(17, 5, 200, 19, '3800.00', 'a'),
(18, 5, 20, 19, '380.00', 'a'),
(18, 6, 20, 31, '620.00', 'a'),
(19, 1, 30, 60, '1800.00', 'a'),
(19, 8, 300, 90, '27000.00', 'a'),
(19, 4, 700, 10, '7000.00', 'a'),
(20, 43, 10000, 0.5, '5000.00', 'a'),
(20, 44, 10000, 0.52, '5200.00', 'a'),
(20, 45, 10000, 0.12, '1200.00', 'a'),
(20, 46, 10000, 0.13, '1300.00', 'a'),
(21, 6, 23, 31, '713.00', 'a'),
(21, 9, 23, 75, '1725.00', 'a'),
(21, 5, 19, 19, '361.00', 'a'),
(22, 48, 1000, 0.5, '500.00', 'a'),
(22, 49, 1, 200, '200.00', 'a'),
(22, 50, 1000, 0.6, '600.00', 'a'),
(22, 51, 2, 30, '60.00', 'a'),
(23, 6, 20, 31, '620.00', 'a'),
(23, 5, 10, 19, '190.00', 'a'),
(23, 10, 12, 160, '1920.00', 'a'),
(24, 1, 25, 56, '1400.00', 'a'),
(24, 6, 45, 31, '1395.00', 'a'),
(25, 1, 8, 56, '448.00', 'a'),
(25, 4, 122, 10, '1220.00', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_production_products`
--

DROP TABLE IF EXISTS `tbl_production_products`;
CREATE TABLE IF NOT EXISTS `tbl_production_products` (
  `production_products_id` int(11) NOT NULL AUTO_INCREMENT,
  `production_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` float NOT NULL,
  `price` decimal(18,2) NOT NULL,
  `total` decimal(18,2) NOT NULL DEFAULT '0.00',
  `status` varchar(10) NOT NULL DEFAULT 'a',
  PRIMARY KEY (`production_products_id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_production_products`
--

INSERT INTO `tbl_production_products` (`production_products_id`, `production_id`, `product_id`, `quantity`, `price`, `total`, `status`) VALUES
(2, 1, 4, 500, '60.00', '30000.00', 'a'),
(3, 2, 2, 10, '80.00', '800.00', 'a'),
(4, 3, 17, 10, '7.00', '70.00', 'a'),
(5, 4, 17, 1000, '7.00', '7000.00', 'a'),
(6, 5, 4, 2000, '60.00', '120000.00', 'a'),
(7, 6, 17, 100, '7.00', '700.00', 'a'),
(8, 7, 15, 100, '200.00', '20000.00', 'a'),
(9, 8, 19, 10, '2050.00', '20500.00', 'a'),
(10, 9, 14, 20, '100.00', '2000.00', 'a'),
(11, 10, 20, 5, '19.00', '95.00', 'a'),
(12, 11, 19, 10, '1640.00', '16400.00', 'a'),
(13, 12, 19, 5, '2050.00', '10250.00', 'a'),
(14, 13, 21, 1, '90.00', '90.00', 'a'),
(15, 14, 18, 75, '2050.00', '153750.00', 'a'),
(16, 15, 19, 10, '2050.00', '20500.00', 'a'),
(17, 16, 26, 1, '2382.50', '2382.50', 'a'),
(18, 17, 21, 20, '90.00', '1800.00', 'a'),
(19, 18, 28, 10, '200.00', '2000.00', 'a'),
(20, 19, 20, 500, '19.00', '9500.00', 'a'),
(29, 20, 30, 10000, '0.62', '6200.00', 'a'),
(28, 20, 29, 10000, '0.65', '6500.00', 'a'),
(23, 21, 26, 20, '2382.50', '47650.00', 'a'),
(24, 22, 32, 980, '1.00', '980.00', 'a'),
(25, 22, 31, 975, '0.90', '877.50', 'a'),
(30, 23, 30, 20, '0.62', '12.40', 'a'),
(31, 24, 33, 25, '24.00', '600.00', 'a'),
(32, 25, 34, 24, '24.00', '288.00', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchasedetails`
--

DROP TABLE IF EXISTS `tbl_purchasedetails`;
CREATE TABLE IF NOT EXISTS `tbl_purchasedetails` (
  `PurchaseDetails_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `PurchaseMaster_IDNo` int(11) NOT NULL,
  `Product_IDNo` int(11) NOT NULL,
  `PurchaseDetails_TotalQuantity` float NOT NULL,
  `PurchaseDetails_Rate` decimal(18,2) NOT NULL,
  `purchase_cost` decimal(18,2) NOT NULL,
  `PurchaseDetails_Discount` decimal(18,2) NOT NULL,
  `PurchaseDetails_TotalAmount` decimal(18,2) NOT NULL,
  `Status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `PurchaseDetails_branchID` int(11) NOT NULL,
  PRIMARY KEY (`PurchaseDetails_SlNo`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_purchasedetails`
--

INSERT INTO `tbl_purchasedetails` (`PurchaseDetails_SlNo`, `PurchaseMaster_IDNo`, `Product_IDNo`, `PurchaseDetails_TotalQuantity`, `PurchaseDetails_Rate`, `purchase_cost`, `PurchaseDetails_Discount`, `PurchaseDetails_TotalAmount`, `Status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `PurchaseDetails_branchID`) VALUES
(1, 1, 38, 10, '6.00', '0.00', '0.00', '60.00', 'a', 'Admin', '2020-11-29 12:44:38', NULL, NULL, 1),
(2, 1, 37, 20, '80.00', '0.00', '0.00', '1600.00', 'a', 'Admin', '2020-11-29 12:44:38', NULL, NULL, 1),
(3, 2, 36, 60, '55.00', '0.00', '0.00', '3300.00', 'a', 'Admin', '2020-11-29 12:44:53', NULL, NULL, 1),
(4, 2, 38, 50, '6.00', '0.00', '0.00', '300.00', 'a', 'Admin', '2020-11-29 12:44:53', NULL, NULL, 1),
(5, 3, 30, 10, '0.62', '0.00', '0.00', '6.20', 'a', 'Admin', '2020-11-29 15:43:59', NULL, NULL, 1),
(6, 4, 32, 5, '1.00', '0.00', '0.00', '5.00', 'a', 'Admin', '2020-11-29 15:47:05', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchasemaster`
--

DROP TABLE IF EXISTS `tbl_purchasemaster`;
CREATE TABLE IF NOT EXISTS `tbl_purchasemaster` (
  `PurchaseMaster_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `Supplier_SlNo` int(11) NOT NULL,
  `Employee_SlNo` int(11) NOT NULL,
  `PurchaseMaster_InvoiceNo` varchar(50) NOT NULL,
  `PurchaseMaster_OrderDate` date NOT NULL,
  `PurchaseMaster_PurchaseFor` varchar(50) NOT NULL,
  `PurchaseMaster_Description` longtext NOT NULL,
  `PurchaseMaster_TotalAmount` decimal(18,2) NOT NULL,
  `PurchaseMaster_DiscountAmount` decimal(18,2) NOT NULL,
  `PurchaseMaster_Tax` decimal(18,2) NOT NULL,
  `PurchaseMaster_Freight` decimal(18,2) NOT NULL,
  `PurchaseMaster_SubTotalAmount` decimal(18,2) NOT NULL,
  `PurchaseMaster_PaidAmount` decimal(18,2) NOT NULL,
  `PurchaseMaster_DueAmount` decimal(18,2) NOT NULL,
  `previous_due` float DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `purchase_type` varchar(20) DEFAULT 'pending',
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `PurchaseMaster_BranchID` int(11) NOT NULL,
  PRIMARY KEY (`PurchaseMaster_SlNo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_purchasemaster`
--

INSERT INTO `tbl_purchasemaster` (`PurchaseMaster_SlNo`, `Supplier_SlNo`, `Employee_SlNo`, `PurchaseMaster_InvoiceNo`, `PurchaseMaster_OrderDate`, `PurchaseMaster_PurchaseFor`, `PurchaseMaster_Description`, `PurchaseMaster_TotalAmount`, `PurchaseMaster_DiscountAmount`, `PurchaseMaster_Tax`, `PurchaseMaster_Freight`, `PurchaseMaster_SubTotalAmount`, `PurchaseMaster_PaidAmount`, `PurchaseMaster_DueAmount`, `previous_due`, `status`, `purchase_type`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `PurchaseMaster_BranchID`) VALUES
(1, 13, 0, '2020000001', '2020-11-29', '1', '', '1660.00', '0.00', '0.00', '0.00', '1660.00', '0.00', '1660.00', 0, 'a', 'pending', 'Admin', '2020-11-29 12:44:38', NULL, NULL, 1),
(2, 11, 0, '2020000002', '2020-11-29', '1', '', '3600.00', '0.00', '0.00', '0.00', '3600.00', '0.00', '3600.00', 2000000, 'a', 'delivered', 'Admin', '2020-11-29 12:44:53', NULL, NULL, 1),
(3, 1, 0, '2020000003', '2020-11-29', '1', '', '6.20', '0.00', '0.00', '0.00', '6.20', '0.00', '6.20', 2000, 'a', 'pending', 'Admin', '2020-11-29 15:43:59', NULL, NULL, 1),
(4, 8, 0, '2020000004', '2020-11-29', '1', '', '5.00', '0.00', '0.00', '0.00', '5.00', '0.00', '5.00', 0, 'a', 'pending', 'Admin', '2020-11-29 15:47:05', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchasereturn`
--

DROP TABLE IF EXISTS `tbl_purchasereturn`;
CREATE TABLE IF NOT EXISTS `tbl_purchasereturn` (
  `PurchaseReturn_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `PurchaseMaster_InvoiceNo` varchar(50) NOT NULL,
  `Supplier_IDdNo` int(11) NOT NULL,
  `PurchaseReturn_ReturnDate` date NOT NULL,
  `PurchaseReturn_ReturnAmount` decimal(18,2) NOT NULL,
  `PurchaseReturn_Description` varchar(300) NOT NULL,
  `Status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `PurchaseReturn_brunchID` int(11) NOT NULL,
  PRIMARY KEY (`PurchaseReturn_SlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchasereturndetails`
--

DROP TABLE IF EXISTS `tbl_purchasereturndetails`;
CREATE TABLE IF NOT EXISTS `tbl_purchasereturndetails` (
  `PurchaseReturnDetails_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `PurchaseReturn_SlNo` int(11) NOT NULL,
  `PurchaseReturnDetailsProduct_SlNo` int(11) NOT NULL,
  `PurchaseReturnDetails_ReturnQuantity` float NOT NULL,
  `PurchaseReturnDetails_ReturnAmount` decimal(18,2) NOT NULL,
  `Status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `PurchaseReturnDetails_brachid` int(11) NOT NULL,
  PRIMARY KEY (`PurchaseReturnDetails_SlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quotaion_customer`
--

DROP TABLE IF EXISTS `tbl_quotaion_customer`;
CREATE TABLE IF NOT EXISTS `tbl_quotaion_customer` (
  `quotation_customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` char(50) NOT NULL,
  `contact_number` varchar(35) NOT NULL,
  `customer_address` text NOT NULL,
  `quation_customer_branchid` int(11) NOT NULL,
  PRIMARY KEY (`quotation_customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quotation_details`
--

DROP TABLE IF EXISTS `tbl_quotation_details`;
CREATE TABLE IF NOT EXISTS `tbl_quotation_details` (
  `SaleDetails_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `SaleMaster_IDNo` int(11) NOT NULL,
  `Product_IDNo` int(11) NOT NULL,
  `SaleDetails_TotalQuantity` float NOT NULL,
  `SaleDetails_Rate` decimal(18,2) NOT NULL,
  `SaleDetails_Discount` decimal(18,2) NOT NULL,
  `SaleDetails_Tax` decimal(18,2) NOT NULL,
  `SaleDetails_Freight` decimal(18,2) NOT NULL,
  `SaleDetails_TotalAmount` decimal(18,2) NOT NULL,
  `Status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `SaleDetails_BranchId` int(11) NOT NULL,
  PRIMARY KEY (`SaleDetails_SlNo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_quotation_details`
--

INSERT INTO `tbl_quotation_details` (`SaleDetails_SlNo`, `SaleMaster_IDNo`, `Product_IDNo`, `SaleDetails_TotalQuantity`, `SaleDetails_Rate`, `SaleDetails_Discount`, `SaleDetails_Tax`, `SaleDetails_Freight`, `SaleDetails_TotalAmount`, `Status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `SaleDetails_BranchId`) VALUES
(1, 1, 16, 10, '230.00', '0.00', '0.00', '0.00', '2300.00', 'a', 'Admin', '2020-07-09 19:46:56', NULL, NULL, 1),
(2, 2, 17, 2000, '10.00', '0.00', '0.00', '0.00', '20000.00', 'a', 'Admin', '2020-07-25 22:49:57', NULL, NULL, 1),
(4, 4, 21, 10, '120.00', '0.00', '0.00', '0.00', '1200.00', 'a', 'Admin', '2020-09-28 14:43:45', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quotation_master`
--

DROP TABLE IF EXISTS `tbl_quotation_master`;
CREATE TABLE IF NOT EXISTS `tbl_quotation_master` (
  `SaleMaster_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `SaleMaster_InvoiceNo` varchar(50) NOT NULL,
  `SaleMaster_customer_name` varchar(500) NOT NULL,
  `SaleMaster_customer_mobile` varchar(50) NOT NULL,
  `SaleMaster_customer_address` varchar(1000) NOT NULL,
  `SaleMaster_SaleDate` date NOT NULL,
  `SaleMaster_Description` longtext,
  `SaleMaster_TotalSaleAmount` decimal(18,2) NOT NULL,
  `SaleMaster_TotalDiscountAmount` decimal(18,2) NOT NULL,
  `SaleMaster_TaxAmount` decimal(18,2) NOT NULL,
  `SaleMaster_Freight` decimal(18,2) NOT NULL,
  `SaleMaster_SubTotalAmount` decimal(18,2) NOT NULL,
  `Status` char(1) NOT NULL DEFAULT 'a',
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `SaleMaster_branchid` int(11) NOT NULL,
  PRIMARY KEY (`SaleMaster_SlNo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_quotation_master`
--

INSERT INTO `tbl_quotation_master` (`SaleMaster_SlNo`, `SaleMaster_InvoiceNo`, `SaleMaster_customer_name`, `SaleMaster_customer_mobile`, `SaleMaster_customer_address`, `SaleMaster_SaleDate`, `SaleMaster_Description`, `SaleMaster_TotalSaleAmount`, `SaleMaster_TotalDiscountAmount`, `SaleMaster_TaxAmount`, `SaleMaster_Freight`, `SaleMaster_SubTotalAmount`, `Status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `SaleMaster_branchid`) VALUES
(1, 'Q-202000001', 'ghj', 'vbnv', 'vn', '2020-07-09', NULL, '2300.00', '0.00', '0.00', '0.00', '2300.00', 'a', 'Admin', '2020-07-09 19:46:56', NULL, NULL, 1),
(2, 'Q-202000002', '', '', '', '2020-07-25', NULL, '20000.00', '0.00', '0.00', '0.00', '20000.00', 'a', 'Admin', '2020-07-25 22:49:57', NULL, NULL, 1),
(4, 'Q-202000003', 'ASAP Solutions Limited', '+8801711520125', '', '2020-09-28', NULL, '1200.00', '120.00', '120.00', '0.00', '1200.00', 'a', 'Admin', '2020-09-28 14:43:45', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_saledetails`
--

DROP TABLE IF EXISTS `tbl_saledetails`;
CREATE TABLE IF NOT EXISTS `tbl_saledetails` (
  `SaleDetails_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `SaleMaster_IDNo` int(11) NOT NULL,
  `Product_IDNo` int(11) NOT NULL,
  `SaleDetails_TotalQuantity` float NOT NULL,
  `Purchase_Rate` decimal(18,2) DEFAULT NULL,
  `SaleDetails_Rate` decimal(18,2) NOT NULL,
  `SaleDetails_Discount` decimal(18,2) NOT NULL,
  `Discount_amount` decimal(18,2) DEFAULT NULL,
  `SaleDetails_Tax` decimal(18,2) NOT NULL,
  `SaleDetails_TotalAmount` decimal(18,2) NOT NULL,
  `Status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `SaleDetails_BranchId` int(11) NOT NULL,
  PRIMARY KEY (`SaleDetails_SlNo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_saledetails`
--

INSERT INTO `tbl_saledetails` (`SaleDetails_SlNo`, `SaleMaster_IDNo`, `Product_IDNo`, `SaleDetails_TotalQuantity`, `Purchase_Rate`, `SaleDetails_Rate`, `SaleDetails_Discount`, `Discount_amount`, `SaleDetails_Tax`, `SaleDetails_TotalAmount`, `Status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `SaleDetails_BranchId`) VALUES
(1, 1, 38, 5, '6.00', '8.00', '0.00', NULL, '0.00', '40.00', 'a', 'Admin', '2020-11-30 12:57:14', NULL, NULL, 1),
(2, 1, 38, 1, '6.00', '8.00', '0.00', NULL, '0.00', '8.00', 'a', 'Admin', '2020-11-30 05:43:21', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_salereturn`
--

DROP TABLE IF EXISTS `tbl_salereturn`;
CREATE TABLE IF NOT EXISTS `tbl_salereturn` (
  `SaleReturn_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `SaleMaster_InvoiceNo` varchar(50) NOT NULL,
  `SaleReturn_ReturnDate` date NOT NULL,
  `SaleReturn_ReturnAmount` decimal(18,2) NOT NULL,
  `SaleReturn_Description` varchar(300) NOT NULL,
  `Status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `SaleReturn_brunchId` int(11) NOT NULL,
  PRIMARY KEY (`SaleReturn_SlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_salereturndetails`
--

DROP TABLE IF EXISTS `tbl_salereturndetails`;
CREATE TABLE IF NOT EXISTS `tbl_salereturndetails` (
  `SaleReturnDetails_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `SaleReturn_IdNo` int(11) NOT NULL,
  `SaleReturnDetailsProduct_SlNo` int(11) NOT NULL,
  `SaleReturnDetails_ReturnQuantity` float NOT NULL,
  `SaleReturnDetails_ReturnAmount` decimal(18,2) NOT NULL,
  `Status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `SaleReturnDetails_brunchID` int(11) NOT NULL,
  PRIMARY KEY (`SaleReturnDetails_SlNo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_salesmaster`
--

DROP TABLE IF EXISTS `tbl_salesmaster`;
CREATE TABLE IF NOT EXISTS `tbl_salesmaster` (
  `SaleMaster_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `SaleMaster_InvoiceNo` varchar(50) NOT NULL,
  `SalseCustomer_IDNo` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `SaleMaster_SaleDate` date NOT NULL,
  `SaleMaster_Description` longtext,
  `SaleMaster_SaleType` varchar(50) DEFAULT NULL,
  `payment_type` varchar(50) DEFAULT 'Cash',
  `SaleMaster_TotalSaleAmount` decimal(18,2) NOT NULL,
  `SaleMaster_TotalDiscountAmount` decimal(18,2) NOT NULL,
  `SaleMaster_TaxAmount` decimal(18,2) NOT NULL,
  `SaleMaster_Freight` decimal(18,2) DEFAULT '0.00',
  `SaleMaster_SubTotalAmount` decimal(18,2) NOT NULL,
  `SaleMaster_PaidAmount` decimal(18,2) NOT NULL,
  `SaleMaster_DueAmount` decimal(18,2) NOT NULL,
  `SaleMaster_Previous_Due` double(18,2) DEFAULT NULL,
  `Status` char(1) NOT NULL DEFAULT 'a',
  `is_service` varchar(10) NOT NULL DEFAULT 'false',
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `SaleMaster_branchid` int(11) NOT NULL,
  PRIMARY KEY (`SaleMaster_SlNo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_salesmaster`
--

INSERT INTO `tbl_salesmaster` (`SaleMaster_SlNo`, `SaleMaster_InvoiceNo`, `SalseCustomer_IDNo`, `employee_id`, `SaleMaster_SaleDate`, `SaleMaster_Description`, `SaleMaster_SaleType`, `payment_type`, `SaleMaster_TotalSaleAmount`, `SaleMaster_TotalDiscountAmount`, `SaleMaster_TaxAmount`, `SaleMaster_Freight`, `SaleMaster_SubTotalAmount`, `SaleMaster_PaidAmount`, `SaleMaster_DueAmount`, `SaleMaster_Previous_Due`, `Status`, `is_service`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `SaleMaster_branchid`) VALUES
(1, '200100001', 13, NULL, '2020-11-30', NULL, 'retail', 'Cash', '48.00', '0.00', '0.00', '0.00', '48.00', '0.00', '48.00', 0.00, 'a', '0', 'Admin', '2020-11-30 17:43:33', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_shifts`
--

DROP TABLE IF EXISTS `tbl_shifts`;
CREATE TABLE IF NOT EXISTS `tbl_shifts` (
  `shift_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`shift_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_shifts`
--

INSERT INTO `tbl_shifts` (`shift_id`, `name`) VALUES
(1, 'Day'),
(2, 'Night');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sms`
--

DROP TABLE IF EXISTS `tbl_sms`;
CREATE TABLE IF NOT EXISTS `tbl_sms` (
  `row_id` int(11) NOT NULL AUTO_INCREMENT,
  `number` varchar(30) NOT NULL,
  `sms_text` varchar(500) NOT NULL,
  `sent_by` int(11) NOT NULL,
  `sent_datetime` datetime NOT NULL,
  PRIMARY KEY (`row_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sms_settings`
--

DROP TABLE IF EXISTS `tbl_sms_settings`;
CREATE TABLE IF NOT EXISTS `tbl_sms_settings` (
  `sms_enabled` varchar(10) NOT NULL DEFAULT 'false',
  `api_key` varchar(500) NOT NULL,
  `url` varchar(1000) NOT NULL,
  `bulk_url` varchar(1000) NOT NULL,
  `sms_type` varchar(50) NOT NULL,
  `sender_id` varchar(200) NOT NULL,
  `sender_name` varchar(200) NOT NULL,
  `sender_phone` varchar(50) NOT NULL,
  `saved_by` int(11) DEFAULT NULL,
  `saved_datetime` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_sms_settings`
--

INSERT INTO `tbl_sms_settings` (`sms_enabled`, `api_key`, `url`, `bulk_url`, `sms_type`, `sender_id`, `sender_name`, `sender_phone`, `saved_by`, `saved_datetime`) VALUES
('false', 'C20036315d8f41beb57b36.68545984', 'http://esms.linktechbd.com/smsapi', 'http://esms.linktechbd.com/smsapimany', 'text', 'Link-UpTech', 'Link-Up Technology', '01911-978897', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier`
--

DROP TABLE IF EXISTS `tbl_supplier`;
CREATE TABLE IF NOT EXISTS `tbl_supplier` (
  `Supplier_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `Supplier_Code` varchar(50) NOT NULL,
  `Supplier_Name` varchar(150) NOT NULL,
  `Supplier_Type` varchar(50) NOT NULL,
  `Supplier_Phone` varchar(50) NOT NULL,
  `Supplier_Mobile` varchar(15) NOT NULL,
  `Supplier_Email` varchar(50) NOT NULL,
  `Supplier_OfficePhone` varchar(50) NOT NULL,
  `Supplier_Address` varchar(300) NOT NULL,
  `contact_person` varchar(250) DEFAULT NULL,
  `District_SlNo` int(11) NOT NULL,
  `Country_SlNo` int(11) NOT NULL,
  `Supplier_Web` varchar(150) NOT NULL,
  `previous_due` decimal(18,2) NOT NULL,
  `image_name` varchar(1000) DEFAULT NULL,
  `Status` char(1) NOT NULL DEFAULT 'a',
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `Supplier_brinchid` int(11) NOT NULL,
  PRIMARY KEY (`Supplier_SlNo`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_supplier`
--

INSERT INTO `tbl_supplier` (`Supplier_SlNo`, `Supplier_Code`, `Supplier_Name`, `Supplier_Type`, `Supplier_Phone`, `Supplier_Mobile`, `Supplier_Email`, `Supplier_OfficePhone`, `Supplier_Address`, `contact_person`, `District_SlNo`, `Country_SlNo`, `Supplier_Web`, `previous_due`, `image_name`, `Status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `Supplier_brinchid`) VALUES
(1, 'S00001', 'Rafiq Enterprise', '', '', '323413', '', '', 'dfdfdf', 'Rafiq', 0, 0, '', '2000.00', NULL, 'a', 'Admin', '2020-07-09 14:00:47', NULL, NULL, 1),
(2, 'S00002', 'Godrej Conjuamr', '', '', '01771626520', '', '', 'Mirpur Dhaka', 'Rahim', 0, 0, '', '100000.00', NULL, 'a', 'Admin', '2020-07-09 14:36:02', NULL, NULL, 1),
(3, 'S00003', 'Bashundhara Diapant', '', '', '01913094424', '', '', 'Dhaka Bangladesh', 'RIpon', 0, 0, '', '0.00', NULL, 'a', 'Admin', '2020-07-09 15:14:29', NULL, NULL, 1),
(4, 'S00004', 'Finly Grup', '', '', '01443625142', '', '', '', '', 0, 0, '', '0.00', NULL, 'a', 'Admin', '2020-07-09 16:10:07', NULL, NULL, 1),
(5, 'S00005', 'calk bazar ', '', '', '01744145252', '', '', '', 'khkh', 0, 0, '', '0.00', NULL, 'a', 'Admin', '2020-07-09 16:29:53', NULL, NULL, 1),
(6, 'S00006', 'Mudi Group', '', '', '04024040410', '', '', '', '', 0, 0, '', '0.00', NULL, 'a', 'Admin', '2020-07-09 16:50:00', NULL, NULL, 1),
(7, 'S00007', '', 'G', '', '', '', '', '', NULL, 0, 0, '', '0.00', NULL, 'a', 'Admin', '2020-07-18 10:24:58', NULL, NULL, 1),
(8, 'S00008', 'M H Feed LTD', '', '', '01670521025', 'khanpff@gmail.com', '', 'Chandpur', 'Hasanat Khan', 0, 0, '', '0.00', NULL, 'a', 'Admin', '2020-07-26 18:15:32', NULL, NULL, 1),
(9, 'S00009', 'Dinajpur Khaddo Bhandar', '', '', '011213', 'A', '', '0', 'ABC', 0, 0, '', '0.00', NULL, 'a', 'Admin', '2020-08-29 11:01:04', NULL, NULL, 1),
(10, 'S00010', 'New Hope', '', '', '0170000000', '', '', 'mauna', 'AAA', 0, 0, '', '0.00', NULL, 'a', 'Admin', '2020-08-30 14:48:50', NULL, NULL, 1),
(11, 'S00011', 'kashem', '', '', '01456', 'nfh', '', 'natore', 'kashem', 0, 0, '', '2000000.00', NULL, 'a', 'Admin', '2020-09-01 11:42:08', NULL, NULL, 1),
(12, 'S00012', '', 'G', '', '', '', '', '', NULL, 0, 0, '', '0.00', NULL, 'a', 'Admin', '2020-10-01 14:17:37', NULL, NULL, 1),
(13, 'S00013', 'power parking', '', '', '01704173301', '', '', 'jg opoph ', 'jkhbg', 0, 0, '', '0.00', NULL, 'a', 'Admin', '2020-10-31 11:44:42', NULL, NULL, 1),
(14, 'S00014', '', 'G', '', '', '', '', '', NULL, 0, 0, '', '0.00', NULL, 'a', 'Admin', '2020-11-18 09:59:03', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_supplier_payment`
--

DROP TABLE IF EXISTS `tbl_supplier_payment`;
CREATE TABLE IF NOT EXISTS `tbl_supplier_payment` (
  `SPayment_id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) NOT NULL,
  `SPayment_date` date DEFAULT NULL,
  `SPayment_invoice` varchar(20) DEFAULT NULL,
  `SPayment_customerID` varchar(20) DEFAULT NULL,
  `SPayment_TransactionType` varchar(25) DEFAULT NULL,
  `SPayment_amount` decimal(18,2) DEFAULT NULL,
  `SPayment_Paymentby` varchar(20) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `SPayment_notes` varchar(225) DEFAULT NULL,
  `SPayment_brunchid` int(11) DEFAULT NULL,
  `SPayment_status` varchar(2) DEFAULT NULL,
  `SPayment_Addby` varchar(100) DEFAULT NULL,
  `SPayment_AddDAte` date DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `SPayment_UpdateDAte` date DEFAULT NULL,
  PRIMARY KEY (`SPayment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_supplier_payment`
--

INSERT INTO `tbl_supplier_payment` (`SPayment_id`, `purchase_id`, `SPayment_date`, `SPayment_invoice`, `SPayment_customerID`, `SPayment_TransactionType`, `SPayment_amount`, `SPayment_Paymentby`, `account_id`, `SPayment_notes`, `SPayment_brunchid`, `SPayment_status`, `SPayment_Addby`, `SPayment_AddDAte`, `update_by`, `SPayment_UpdateDAte`) VALUES
(10, 1, '2020-12-01', 'TR00001', '13', 'CP', '60.00', 'cash', NULL, '', 1, 'a', 'Admin', '2020-12-01', 0, '2020-12-01'),
(11, 2, '2020-12-01', 'TR00011', '11', 'CP', '600.00', 'cash', NULL, '', 1, 'a', 'Admin', '2020-12-01', NULL, NULL),
(12, 1, '2020-12-01', 'TR00012', '13', 'CP', '600.00', 'cash', NULL, '', 1, 'a', 'Admin', '2020-12-01', NULL, NULL),
(13, 1, '2020-12-01', 'TR00013', '13', 'CR', '60.00', 'cash', NULL, '', 1, 'a', 'Admin', '2020-12-01', 0, '2020-12-01'),
(14, 2, '2020-12-01', 'TR00014', '11', 'CP', '50.00', 'cash', NULL, '', 1, 'a', 'Admin', '2020-12-01', NULL, NULL),
(15, 2, '2020-12-01', 'TR00015', '11', 'CP', '50.00', 'cash', NULL, '', 1, 'a', 'Admin', '2020-12-01', NULL, NULL),
(16, 1, '2020-12-01', 'TR00016', '13', 'CP', '60.00', 'cash', NULL, 'sw', 1, 'a', 'Admin', '2020-12-01', NULL, NULL),
(17, 1, '2020-12-01', 'TR00017', '13', 'CP', '900.00', 'cash', NULL, '', 1, 'a', 'Admin', '2020-12-01', 0, '2020-12-01'),
(18, 1, '2020-12-01', 'TR00018', '13', 'CP', '90.00', 'cash', NULL, '', 1, 'a', 'Admin', '2020-12-01', NULL, NULL),
(19, 1, '2020-12-01', 'TR00019', '13', 'CP', '10.00', 'cash', NULL, '', 1, 'a', 'Admin', '2020-12-01', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transferdetails`
--

DROP TABLE IF EXISTS `tbl_transferdetails`;
CREATE TABLE IF NOT EXISTS `tbl_transferdetails` (
  `transferdetails_id` int(11) NOT NULL AUTO_INCREMENT,
  `transfer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` float NOT NULL,
  `purchase_rate` decimal(18,2) NOT NULL DEFAULT '0.00',
  `total` decimal(18,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`transferdetails_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_transferdetails`
--

INSERT INTO `tbl_transferdetails` (`transferdetails_id`, `transfer_id`, `product_id`, `quantity`, `purchase_rate`, `total`) VALUES
(1, 1, 9, 12, '100.00', '1200.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transfermaster`
--

DROP TABLE IF EXISTS `tbl_transfermaster`;
CREATE TABLE IF NOT EXISTS `tbl_transfermaster` (
  `transfer_id` int(11) NOT NULL AUTO_INCREMENT,
  `transfer_date` date NOT NULL,
  `transfer_by` int(11) NOT NULL,
  `transfer_from` int(11) NOT NULL,
  `transfer_to` int(11) NOT NULL,
  `total_amount` decimal(18,2) NOT NULL DEFAULT '0.00',
  `note` varchar(500) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `added_datetime` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`transfer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_transfermaster`
--

INSERT INTO `tbl_transfermaster` (`transfer_id`, `transfer_date`, `transfer_by`, `transfer_from`, `transfer_to`, `total_amount`, `note`, `added_by`, `added_datetime`, `updated_by`, `updated_datetime`) VALUES
(1, '2020-07-28', 1, 1, 2, '1200.00', 'ijlj', 0, '0000-00-00 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_unit`
--

DROP TABLE IF EXISTS `tbl_unit`;
CREATE TABLE IF NOT EXISTS `tbl_unit` (
  `Unit_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `Unit_Name` varchar(150) NOT NULL,
  `status` char(1) NOT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`Unit_SlNo`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_unit`
--

INSERT INTO `tbl_unit` (`Unit_SlNo`, `Unit_Name`, `status`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`) VALUES
(1, 'PCS', 'a', NULL, NULL, NULL, NULL),
(2, 'Bosta', 'a', 'Admin', '2020-07-09 14:15:41', NULL, NULL),
(3, 'Kg.', 'a', 'Admin', '2020-07-09 14:15:51', NULL, NULL),
(4, 'Box', 'a', 'Admin', '2020-07-09 14:21:24', NULL, NULL),
(5, 'Sft', 'a', 'Admin', '2020-07-18 10:22:42', NULL, NULL),
(6, 'Grams ', 'a', 'Admin', '2020-08-15 22:22:42', NULL, NULL),
(7, 'tablespoon', 'a', 'Admin', '2020-08-15 22:59:30', NULL, NULL),
(8, 'Teaspoon', 'a', 'Admin', '2020-08-15 22:59:56', NULL, NULL),
(9, 'Case', 'a', 'Admin', '2020-09-02 13:15:35', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE IF NOT EXISTS `tbl_user` (
  `User_SlNo` int(11) NOT NULL AUTO_INCREMENT,
  `User_ID` varchar(50) NOT NULL,
  `FullName` varchar(150) NOT NULL,
  `User_Name` varchar(150) NOT NULL,
  `UserEmail` varchar(200) NOT NULL,
  `userBrunch_id` int(11) NOT NULL,
  `User_Password` varchar(50) NOT NULL,
  `UserType` varchar(50) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'a',
  `verifycode` int(11) NOT NULL,
  `image_name` varchar(1000) DEFAULT NULL,
  `AddBy` varchar(50) DEFAULT NULL,
  `AddTime` datetime DEFAULT NULL,
  `UpdateBy` varchar(50) DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  `Brunch_ID` int(11) NOT NULL,
  PRIMARY KEY (`User_SlNo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`User_SlNo`, `User_ID`, `FullName`, `User_Name`, `UserEmail`, `userBrunch_id`, `User_Password`, `UserType`, `status`, `verifycode`, `image_name`, `AddBy`, `AddTime`, `UpdateBy`, `UpdateTime`, `Brunch_ID`) VALUES
(1, 'U0001', 'Admin', 'admin', 'admin@host.com', 1, 'c4ca4238a0b923820dcc509a6f75849b', 'm', 'a', 1, '1.png', NULL, NULL, NULL, NULL, 1),
(2, '', 'user', 'user', 'user@gmail.com', 1, '81dc9bdb52d04dc20036dbd8313ed055', 'u', 'a', 0, NULL, NULL, '2020-07-27 16:03:53', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_access`
--

DROP TABLE IF EXISTS `tbl_user_access`;
CREATE TABLE IF NOT EXISTS `tbl_user_access` (
  `access_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `access` text NOT NULL,
  `saved_by` int(11) NOT NULL,
  `saved_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`access_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user_access`
--

INSERT INTO `tbl_user_access` (`access_id`, `user_id`, `access`, `saved_by`, `saved_datetime`) VALUES
(1, 2, '[\"sales\\/product\"]', 1, '2020-09-28 17:51:55');
COMMIT;
