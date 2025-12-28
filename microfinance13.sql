-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2025 at 03:38 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `microfinance`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_class`
--

CREATE TABLE `account_class` (
  `class_id` int(11) NOT NULL,
  `account_group` int(11) NOT NULL,
  `sub_group` int(11) NOT NULL,
  `class` varchar(1024) NOT NULL,
  `class_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_class`
--

INSERT INTO `account_class` (`class_id`, `account_group`, `sub_group`, `class`, `class_code`) VALUES
(1, 1, 1, 'Bank', 0),
(2, 1, 1, 'Cash', 0),
(3, 1, 1, 'Inventories', 0),
(4, 1, 1, 'Loan Receivables', 0),
(5, 1, 2, 'Properties, Plants And Equipment', 0),
(6, 1, 2, 'Accum Depre Properties, Plant And Equipment', 0),
(7, 2, 3, 'Account Payables', 0),
(8, 2, 3, 'Tax Payables', 0),
(9, 2, 3, 'Other Payables', 0),
(10, 2, 4, 'Loans', 0),
(11, 3, 5, 'Revenue', 0),
(12, 4, 6, 'Admin And General Expense', 0),
(13, 4, 6, 'Other Expense', 0),
(14, 4, 7, 'Cost Of Sales', 0),
(15, 4, 8, 'Depreciation', 0),
(16, 5, 9, 'Share Capital', 0),
(17, 5, 9, 'Retained Earnings', 0),
(18, 4, 10, 'Loss On Disposal Of Asset', 0),
(19, 3, 5, 'Other Revenue', 0);

-- --------------------------------------------------------

--
-- Table structure for table `account_groups`
--

CREATE TABLE `account_groups` (
  `account_id` int(11) NOT NULL,
  `account_group` varchar(50) NOT NULL,
  `account_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_groups`
--

INSERT INTO `account_groups` (`account_id`, `account_group`, `account_code`) VALUES
(1, 'Assets', 0),
(2, 'Liabilities', 0),
(3, 'Income', 0),
(4, 'Expenses', 0),
(5, 'Equity', 0);

-- --------------------------------------------------------

--
-- Table structure for table `account_sub_groups`
--

CREATE TABLE `account_sub_groups` (
  `sub_group_id` int(11) NOT NULL,
  `account_group` int(11) NOT NULL,
  `sub_group` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_sub_groups`
--

INSERT INTO `account_sub_groups` (`sub_group_id`, `account_group`, `sub_group`) VALUES
(1, 1, 'Current Asset'),
(2, 1, 'Fixed Assets'),
(3, 2, 'Current Liabilities'),
(4, 2, 'Non Current Liabilities'),
(5, 3, 'Income'),
(6, 4, 'Operating Expenses'),
(7, 4, 'Cost Of Sales'),
(8, 4, 'Depreciation'),
(9, 5, 'Share Capital'),
(10, 4, 'Disposal Of Asset');

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `asset_id` int(11) NOT NULL,
  `asset` varchar(255) NOT NULL,
  `asset_no` varchar(50) NOT NULL,
  `location` int(11) NOT NULL,
  `supplier` varchar(255) NOT NULL,
  `cost` decimal(12,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `accum_dep` decimal(12,2) NOT NULL,
  `useful_life` float NOT NULL,
  `salvage_value` decimal(12,2) NOT NULL,
  `book_value` decimal(12,2) NOT NULL,
  `ledger` int(50) NOT NULL,
  `specification` text NOT NULL,
  `asset_status` int(11) NOT NULL,
  `purchase_date` date DEFAULT NULL,
  `deployment_date` date DEFAULT NULL,
  `post_date` datetime DEFAULT NULL,
  `posted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_locations`
--

CREATE TABLE `asset_locations` (
  `location_id` int(11) NOT NULL,
  `location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `asset_locations`
--

INSERT INTO `asset_locations` (`location_id`, `location`) VALUES
(1, 'SECURITY POST'),
(2, 'FRONT DESK'),
(3, 'ICT'),
(4, 'PROCUREMENT'),
(5, 'HEAD OFFICE');

-- --------------------------------------------------------

--
-- Table structure for table `asset_postings`
--

CREATE TABLE `asset_postings` (
  `asset_id` int(11) NOT NULL,
  `asset` int(11) NOT NULL,
  `store` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `asset_ledger` int(11) NOT NULL,
  `contra_ledger` int(11) NOT NULL,
  `details` varchar(1024) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `trx_number` varchar(50) NOT NULL,
  `trans_date` date DEFAULT NULL,
  `post_date` datetime DEFAULT NULL,
  `posted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audit_trail`
--

CREATE TABLE `audit_trail` (
  `audit_id` int(11) NOT NULL,
  `store` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `transaction` varchar(255) NOT NULL,
  `previous_qty` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `posted_by` int(11) NOT NULL,
  `post_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `bank_id` int(11) NOT NULL,
  `bank` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`bank_id`, `bank`, `account_number`) VALUES
(6, 'STANBIC IBTC', '1010150'),
(7, 'FIDELITY BANK', '1010151'),
(8, 'FIRST BANK', '1010152'),
(9, 'STANBIC IBTC 2', '1010153'),
(10, 'FOREX', '1010199'),
(11, 'ACCESS BANK', '10101119');

-- --------------------------------------------------------

--
-- Table structure for table `cash_flows`
--

CREATE TABLE `cash_flows` (
  `flow_id` int(11) NOT NULL,
  `account` int(11) NOT NULL,
  `details` varchar(1024) NOT NULL,
  `trx_number` varchar(50) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `trans_type` varchar(50) NOT NULL,
  `activity` varchar(50) NOT NULL,
  `store` int(11) NOT NULL,
  `post_date` datetime DEFAULT NULL,
  `posted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cash_flows`
--

INSERT INTO `cash_flows` (`flow_id`, `account`, `details`, `trx_number`, `amount`, `trans_type`, `activity`, `store`, `post_date`, `posted_by`) VALUES
(161, 10101119, 'loan disbursement', 'TR970080725105417', 200000.00, 'outflow', 'financing', 1, '2025-07-08 22:54:17', 1),
(162, 1010228, 'Loan Repayment', 'TR923080725105453', 90000.00, 'inflow', 'operating', 0, '2025-07-08 22:54:53', 1),
(163, 1010228, 'Loan Repayment', 'TR159080725105510', 20000.00, 'inflow', 'operating', 0, '2025-07-08 22:55:10', 1),
(164, 1010228, 'Loan Repayment', 'TR531080725105536', 100000.00, 'inflow', 'operating', 0, '2025-07-08 22:55:36', 1),
(165, 1010228, 'loan disbursement', 'TR493090725100657', 70000.00, 'outflow', 'financing', 1, '2025-07-09 10:06:57', 1),
(166, 1010228, 'Loan Repayment', 'TR438090725034307', 30000.00, 'inflow', 'operating', 0, '2025-07-09 15:43:07', 1),
(167, 1010228, 'Loan Repayment', 'TR049090725035544', 20000.00, 'inflow', 'operating', 0, '2025-07-09 15:55:44', 1),
(168, 10101119, 'Loan Repayment', 'TR391090725035943', 10000.00, 'inflow', 'operating', 0, '2025-07-09 15:59:43', 1),
(169, 10101119, 'Loan Repayment', 'TR335090725040140', 12800.04, 'inflow', 'operating', 0, '2025-07-09 16:01:40', 1),
(170, 1010228, 'loan disbursement', 'TR971100725081156', 250000.00, 'outflow', 'financing', 1, '2025-07-10 08:11:56', 1),
(171, 10101119, 'loan disbursement', 'TR331100725083729', 300000.00, 'outflow', 'financing', 1, '2025-07-10 08:37:29', 1),
(172, 1010228, 'Loan Repayment', 'TR488110725071655', 60000.00, 'inflow', 'operating', 0, '2025-07-11 07:16:55', 15),
(173, 1010228, 'Loan Repayment', 'TR054110725071816', 12000.00, 'inflow', 'operating', 0, '2025-07-11 07:18:16', 15),
(174, 1010153, 'Loan Repayment', 'TR919110725072623', 35000.00, 'inflow', 'operating', 0, '2025-07-11 07:26:23', 1),
(175, 1010228, 'Loan Repayment', 'TR212110725073938', 80000.00, 'inflow', 'operating', 0, '2025-07-11 07:39:38', 15),
(176, 1010228, 'Loan Repayment', 'TR038110725123758', 87500.00, 'inflow', 'operating', 0, '2025-07-11 12:37:58', 1),
(177, 1010228, 'loan disbursement', 'TR500110725021645', 700000.00, 'outflow', 'financing', 1, '2025-07-11 14:16:45', 1),
(178, 1010228, 'Loan Repayment', 'TR061140725094852', 50000.00, 'inflow', 'operating', 0, '2025-07-14 09:48:52', 1),
(179, 10101119, 'Loan Repayment', 'TR661150725071531', 100000.00, 'inflow', 'operating', 0, '2025-07-15 07:15:31', 15),
(180, 10101119, 'loan disbursement', 'TR938160725122658', 150000.00, 'outflow', 'financing', 1, '2025-07-16 12:26:58', 1),
(181, 10101119, 'Loan Repayment', 'TR137160725013827', 13000.00, 'inflow', 'operating', 0, '2025-07-16 13:38:27', 1),
(182, 1010228, 'Loan Repayment', 'TR840160725014845', 100000.00, 'inflow', 'operating', 0, '2025-07-16 13:48:45', 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `department` varchar(255) NOT NULL,
  `category` varchar(1024) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `company_id` int(11) NOT NULL,
  `company` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`company_id`, `company`, `logo`, `date_created`) VALUES
(1, 'Demo Microfinance Ltd', 'icon.png', '2025-06-06 14:46:39');

-- --------------------------------------------------------

--
-- Table structure for table `cost_of_sales`
--

CREATE TABLE `cost_of_sales` (
  `cost_of_sales_id` int(11) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `details` varchar(1024) NOT NULL,
  `trx_number` varchar(50) NOT NULL,
  `store` int(11) NOT NULL,
  `trans_date` date DEFAULT NULL,
  `post_date` datetime DEFAULT NULL,
  `posted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `customer` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ledger_id` int(11) NOT NULL,
  `acn` int(50) NOT NULL,
  `customer_type` varchar(20) NOT NULL,
  `phone_numbers` varchar(20) NOT NULL,
  `customer_address` varchar(100) NOT NULL,
  `customer_email` varchar(50) NOT NULL,
  `state_region` varchar(50) NOT NULL,
  `lga` varchar(255) NOT NULL,
  `landmark` varchar(255) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `dob` date DEFAULT NULL,
  `religion` varchar(50) NOT NULL,
  `marital_status` varchar(50) NOT NULL,
  `occupation` varchar(50) NOT NULL,
  `business` varchar(255) NOT NULL,
  `business_address` varchar(255) NOT NULL,
  `income` varchar(50) NOT NULL,
  `nok` varchar(255) NOT NULL,
  `nok_address` varchar(255) NOT NULL,
  `nok_phone` varchar(50) NOT NULL,
  `nok_relation` varchar(50) NOT NULL,
  `bank` varchar(50) NOT NULL,
  `account_number` varchar(50) NOT NULL,
  `account_name` varchar(50) NOT NULL,
  `photo` varchar(1024) NOT NULL,
  `reg_status` int(11) NOT NULL,
  `wallet_balance` int(11) NOT NULL,
  `amount_due` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer`, `user_id`, `ledger_id`, `acn`, `customer_type`, `phone_numbers`, `customer_address`, `customer_email`, `state_region`, `lga`, `landmark`, `gender`, `dob`, `religion`, `marital_status`, `occupation`, `business`, `business_address`, `income`, `nok`, `nok_address`, `nok_phone`, `nok_relation`, `bank`, `account_number`, `account_name`, `photo`, `reg_status`, `wallet_balance`, `amount_due`, `created_by`, `reg_date`) VALUES
(38, 'IKPEFUA KELLY', 8, 122, 10104122, '', '07068897068', '1b Ogidan Street Off Atican Beachview Estate, Okun-ajah Community', 'onostarkels@gmail.com', 'LAGOS', 'ETI-OSA', 'Abraham Adesanya Estate', 'Male', '1989-05-15', 'Christian', 'Married', 'Business Person', 'onostar media', 'Ogidan, Lagos state', '1,000,000', 'PAUL IKPEFUA', 'Abraka, Delta State', '091565677', 'BROTHER', 'Access Bank', '30596252', 'IKPEFUA KELLY ONOLUNOSE', '686beefaf3415.png', 1, 242500, 0, 1, '2025-06-09 14:21:04'),
(44, 'AKPABIA GOODLUCK', 14, 128, 10104128, '', '09012345678', '2 Akpabioway', 'akpabio@mail.com', 'AKWA-IBOM', 'AKWA', '', 'Male', '1986-04-03', 'Christian', 'Married', 'Trader', 'akjkh', 'akwa dress', '250,000', 'JKHJK', 'Jkh', 'jkh', 'JKH', 'Jaiz Bank', '0012345678', 'MOSHUD', 'user.png', 1, 0, 0, 1, '2025-07-05 10:22:29'),
(45, 'DORCAS IKPEFUA', 16, 131, 10104131, '', '08100653703', '1b Ogidan Street Off Atican Beachview Estate, Okun-ajah', 'oluwatoyi13@gmail.com', 'LAGOS', 'SANGOTEDO, LAGOS ISLAND', 'Abraham Adesanya Estate', 'Female', '1994-07-06', 'Christian', 'Married', 'Banker', 'Tad waves', 'victoria island', '500,000', 'MATTHEW AYODEJI', 'Badagry, Lagos', '00', 'BROTHER', 'Access Bank', '0012345678', 'DORCAS OLUWATOYIN FANIRAN', 'user.png', 1, 0, 0, 1, '2025-07-16 11:42:25');

-- --------------------------------------------------------

--
-- Table structure for table `customer_trail`
--

CREATE TABLE `customer_trail` (
  `id` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `description` varchar(1024) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `store` int(11) NOT NULL,
  `trx_number` varchar(50) NOT NULL,
  `posted_by` int(11) NOT NULL,
  `post_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_trail`
--

INSERT INTO `customer_trail` (`id`, `customer`, `description`, `amount`, `store`, `trx_number`, `posted_by`, `post_date`) VALUES
(146, 38, 'Loan Repayment', 90000.00, 1, 'TR923080725105453', 1, '2025-07-08 22:54:53'),
(147, 38, 'Loan Repayment', 20000.00, 1, 'TR159080725105510', 1, '2025-07-08 22:55:10'),
(148, 38, 'Loan Repayment', 100000.00, 1, 'TR531080725105536', 1, '2025-07-08 22:55:36'),
(149, 38, 'Loan Repayment', 30000.00, 1, 'TR438090725034307', 1, '2025-07-09 15:43:07'),
(150, 38, 'Loan Repayment', 20000.00, 1, 'TR049090725035544', 1, '2025-07-09 15:55:44'),
(151, 38, 'Loan Repayment', 10000.00, 1, 'TR391090725035943', 1, '2025-07-09 15:59:43'),
(152, 38, 'Loan Repayment', 12800.04, 1, 'TR335090725040140', 1, '2025-07-09 16:01:40'),
(153, 38, 'Loan Repayment', 60000.00, 1, 'TR488110725071655', 15, '2025-07-11 07:16:55'),
(154, 44, 'Loan Repayment', 12000.00, 1, 'TR054110725071816', 15, '2025-07-11 07:18:16'),
(155, 38, 'Loan Repayment', 35000.00, 1, 'TR919110725072623', 1, '2025-07-11 07:26:23'),
(156, 38, 'Loan Repayment', 80000.00, 1, 'TR212110725073938', 15, '2025-07-11 07:39:38'),
(157, 38, 'Loan Repayment', 87500.00, 1, 'TR038110725123758', 1, '2025-07-11 12:37:58'),
(158, 38, 'Loan Repayment', 50000.00, 1, 'TR061140725094852', 1, '2025-07-14 09:48:52'),
(159, 44, 'Loan Repayment', 100000.00, 1, 'TR661150725071531', 15, '2025-07-15 07:15:31'),
(160, 45, 'Loan Repayment', 13000.00, 1, 'TR137160725013827', 1, '2025-07-16 13:38:27'),
(161, 38, 'Loan Repayment', 100000.00, 1, 'TR840160725014845', 1, '2025-07-16 13:48:45');

-- --------------------------------------------------------

--
-- Table structure for table `debtors`
--

CREATE TABLE `debtors` (
  `debtor_id` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `invoice` varchar(50) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `store` int(11) NOT NULL,
  `debt_status` int(11) NOT NULL,
  `posted_by` int(11) NOT NULL,
  `post_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` int(11) NOT NULL,
  `department` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `department`) VALUES
(11, 'Raw Materials'),
(12, 'Products'),
(13, 'Consumables');

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `deposit_id` int(11) NOT NULL,
  `store` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `payment_mode` varchar(50) NOT NULL,
  `bank` int(11) NOT NULL,
  `invoice` varchar(50) NOT NULL,
  `trx_type` varchar(50) NOT NULL,
  `trx_number` varchar(50) NOT NULL,
  `details` varchar(255) NOT NULL,
  `trans_date` date DEFAULT NULL,
  `post_date` datetime DEFAULT NULL,
  `posted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `deposits`
--

INSERT INTO `deposits` (`deposit_id`, `store`, `customer`, `amount`, `payment_mode`, `bank`, `invoice`, `trx_type`, `trx_number`, `details`, `trans_date`, `post_date`, `posted_by`) VALUES
(57, 1, 38, 90000.00, 'Cash', 0, 'LP080725105433111176', 'Loan Repayment', 'TR923080725105453', 'Loan Repayment', '2025-07-08', '2025-07-08 22:54:53', 1),
(58, 1, 38, 20000.00, 'Cash', 0, 'LP080725105501222177', 'Loan Repayment', 'TR159080725105510', 'Loan Repayment', '2025-07-08', '2025-07-08 22:55:10', 1),
(59, 1, 38, 100000.00, 'Cash', 0, 'LP080725105501113177', 'Loan Repayment', 'TR531080725105536', 'Loan Repayment', '2025-07-08', '2025-07-08 22:55:36', 1),
(60, 1, 38, 30000.00, 'Cash', 0, 'LP090725034220101179', 'Loan Repayment', 'TR438090725034307', 'Loan Payment', '2025-07-09', '2025-07-09 15:43:07', 1),
(61, 1, 38, 20000.00, 'Cash', 0, 'LP090725035533003183', 'Loan Repayment', 'TR049090725035544', 'Loan Repayment', '2025-07-09', '2025-07-09 15:55:44', 1),
(62, 1, 38, 10000.00, 'Transfer', 11, 'LP090725035910320187', 'Loan Repayment', 'TR391090725035943', 'Loan Repayment', '2025-07-09', '2025-07-09 15:59:43', 1),
(63, 1, 38, 12800.04, 'Transfer', 11, 'LP090725040122022188', 'Loan Repayment', 'TR335090725040140', 'Jj', '2025-07-09', '2025-07-09 16:01:40', 1),
(64, 1, 38, 60000.00, 'Cash', 0, 'LP1107250716211111591', 'Loan Repayment', 'TR488110725071655', 'Loan Payment', '2025-07-11', '2025-07-11 07:16:55', 15),
(65, 1, 44, 12000.00, 'Cash', 0, 'LP1107250717121211594', 'Loan Repayment', 'TR054110725071816', 'Loll', '2025-07-11', '2025-07-11 07:18:16', 15),
(66, 1, 38, 35000.00, 'Transfer', 9, 'LP110725072610003191', 'Loan Repayment', 'TR919110725072623', 'Payment', '2025-07-11', '2025-07-11 07:26:23', 1),
(67, 1, 38, 80000.00, 'Cash', 0, 'LP1107250739213011592', 'Loan Repayment', 'TR212110725073938', 'Nna', '2025-07-11', '2025-07-11 07:39:38', 15),
(68, 1, 38, 87500.00, 'Cash', 0, 'LP110725123732000193', 'Loan Repayment', 'TR038110725123758', 'Loan Repayment', '2025-07-11', '2025-07-11 12:37:58', 1),
(69, 1, 38, 50000.00, 'Cash', 0, 'LP140725094820211197', 'Loan Repayment', 'TR061140725094852', 'Payment For Loan', '2025-07-14', '2025-07-14 09:48:52', 1),
(70, 1, 44, 100000.00, 'Transfer', 11, 'LP1507250715023201594', 'Loan Repayment', 'TR661150725071531', 'Payment For Loan', '2025-07-15', '2025-07-15 07:15:31', 15),
(71, 1, 45, 13000.00, 'Transfer', 11, 'LP1607250138333131109', 'Loan Repayment', 'TR137160725013827', 'Payment For Loan', '2025-07-16', '2025-07-16 13:38:27', 1),
(72, 1, 38, 100000.00, 'Cash', 0, 'LP160725014831201197', 'Loan Repayment', 'TR840160725014845', 'Loan Repyment', '2025-07-16', '2025-07-16 13:48:45', 1);

-- --------------------------------------------------------

--
-- Table structure for table `depreciation`
--

CREATE TABLE `depreciation` (
  `depreciation_id` int(11) NOT NULL,
  `asset` int(11) NOT NULL,
  `cost` decimal(12,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `useful_life` float NOT NULL,
  `salvage_value` decimal(12,2) NOT NULL,
  `dr_ledger` int(11) NOT NULL,
  `contra_ledger` int(11) NOT NULL,
  `trx_number` varchar(50) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `accum_dep` decimal(12,2) NOT NULL,
  `book_value` decimal(12,2) NOT NULL,
  `details` varchar(1024) NOT NULL,
  `trx_date` date NOT NULL,
  `post_date` datetime DEFAULT NULL,
  `posted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `director_posting`
--

CREATE TABLE `director_posting` (
  `director_id` int(11) NOT NULL,
  `financier` int(11) NOT NULL,
  `contra_ledger` int(11) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `trans_type` varchar(50) NOT NULL,
  `trx_number` varchar(50) NOT NULL,
  `details` varchar(1024) NOT NULL,
  `store` int(11) NOT NULL,
  `trans_date` date DEFAULT NULL,
  `post_date` datetime DEFAULT NULL,
  `posted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `disbursal`
--

CREATE TABLE `disbursal` (
  `disbursal_id` int(11) NOT NULL,
  `loan` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `mode` varchar(50) NOT NULL,
  `bank` int(11) NOT NULL,
  `trx_number` varchar(50) NOT NULL,
  `trx_date` date DEFAULT NULL,
  `store` int(11) NOT NULL,
  `disbursed_by` int(11) NOT NULL,
  `disbursed_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `disbursal`
--

INSERT INTO `disbursal` (`disbursal_id`, `loan`, `customer`, `amount`, `mode`, `bank`, `trx_number`, `trx_date`, `store`, `disbursed_by`, `disbursed_date`) VALUES
(24, 33, 38, 250000, 'Cash', 0, 'TR971100725081156', '2025-07-10', 1, 1, '2025-07-10 08:11:56'),
(25, 34, 44, 300000, 'Transfer', 11, 'TR331100725083729', '2025-07-10', 1, 1, '2025-07-10 08:37:29'),
(26, 37, 38, 700000, 'Cash', 0, 'TR500110725021645', '2025-07-11', 1, 1, '2025-07-11 14:16:45'),
(27, 38, 45, 150000, 'Transfer', 11, 'TR938160725122658', '2025-07-16', 1, 1, '2025-07-16 12:26:58');

-- --------------------------------------------------------

--
-- Table structure for table `disposed_assets`
--

CREATE TABLE `disposed_assets` (
  `disposed_id` int(11) NOT NULL,
  `asset` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `accum_dep` decimal(12,2) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `reason` varchar(1024) NOT NULL,
  `trx_number` varchar(50) NOT NULL,
  `disposed_date` datetime DEFAULT NULL,
  `disposed_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `document_uploads`
--

CREATE TABLE `document_uploads` (
  `document_id` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `loan` int(11) NOT NULL,
  `doc_type` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `document` varchar(1024) NOT NULL,
  `uploaded_by` int(11) NOT NULL,
  `upload_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `expense_id` int(11) NOT NULL,
  `store` int(11) NOT NULL,
  `posted_by` int(11) NOT NULL,
  `expense_head` varchar(255) NOT NULL,
  `contra` int(11) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `trx_number` varchar(50) NOT NULL,
  `details` text NOT NULL,
  `expense_date` datetime NOT NULL,
  `post_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expense_heads`
--

CREATE TABLE `expense_heads` (
  `exp_head_id` int(11) NOT NULL,
  `expense_head` varchar(255) NOT NULL,
  `ledger_id` int(11) NOT NULL,
  `acn` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expense_heads`
--

INSERT INTO `expense_heads` (`exp_head_id`, `expense_head`, `ledger_id`, `acn`) VALUES
(4, 'UTILITY BILLS', 37, 40601237),
(5, 'TRANSPORTATION', 38, 40601238),
(6, 'SALARIES AND WAGES', 39, 40601239),
(7, 'DEPRECIATION', 40, 40801540),
(8, 'AMORTIZATION - SOFTWARE COST', 41, 40801541),
(9, 'LOSS ON DISPOSAL OF ASSET', 60, 401001860),
(10, 'COST OF SALES', 63, 40701463),
(11, 'COMPANY INCOME TAX', 67, 40601267),
(12, 'LOAN FEES', 68, 40601368),
(13, 'BANK CHARGES', 69, 40601369),
(14, 'MD\'S CHILDREN SCHOOL FEES', 98, 40601398),
(15, 'COURIER EXPENSES', 108, 406012108),
(16, 'FREIGHT AND CUSTOMS  DUTIES', 109, 406012109),
(17, 'PROJECT EXPENSES', 110, 407014110),
(18, 'PETTY PROJECT EXPENSES', 111, 406013111),
(19, 'TRANSFER TO MDS ACCOUNT', 112, 406013112);

-- --------------------------------------------------------

--
-- Table structure for table `finance_cost`
--

CREATE TABLE `finance_cost` (
  `finance_id` int(11) NOT NULL,
  `financier` int(11) NOT NULL,
  `contra_ledger` int(11) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `trans_type` varchar(50) NOT NULL,
  `trx_number` varchar(50) NOT NULL,
  `details` varchar(1024) NOT NULL,
  `store` int(11) NOT NULL,
  `trans_date` date DEFAULT NULL,
  `post_date` datetime DEFAULT NULL,
  `posted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guarantors`
--

CREATE TABLE `guarantors` (
  `guarantor_id` int(11) NOT NULL,
  `client` int(11) NOT NULL,
  `loan` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `occupation` varchar(100) NOT NULL,
  `business` varchar(255) NOT NULL,
  `business_address` varchar(255) NOT NULL,
  `relationship` varchar(50) NOT NULL,
  `posted_by` int(11) NOT NULL,
  `post_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `info_request`
--

CREATE TABLE `info_request` (
  `request_id` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `loan` int(11) NOT NULL,
  `request_text` text NOT NULL,
  `request_status` int(11) NOT NULL,
  `requested_by` int(11) NOT NULL,
  `request_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `inventory_id` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `details` varchar(1024) NOT NULL,
  `item_type` varchar(50) DEFAULT NULL,
  `store` int(11) NOT NULL,
  `cost_price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `batch_number` int(11) NOT NULL,
  `expiration_date` date DEFAULT NULL,
  `reorder_level` int(11) NOT NULL,
  `post_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `invoice_id` int(11) NOT NULL,
  `invoice` varchar(50) NOT NULL,
  `po_number` varchar(50) NOT NULL,
  `service_order` varchar(50) NOT NULL,
  `manual_invoice` varchar(50) NOT NULL,
  `customer` int(11) NOT NULL,
  `details` text NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `total_amount` decimal(12,2) NOT NULL,
  `invoice_status` int(11) NOT NULL,
  `due_days` int(11) NOT NULL,
  `store` int(11) NOT NULL,
  `trx_number` varchar(50) NOT NULL,
  `trx_date` datetime DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `posted_by` int(11) NOT NULL,
  `post_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `issue_items`
--

CREATE TABLE `issue_items` (
  `issue_id` int(11) NOT NULL,
  `from_store` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `issue_status` int(11) NOT NULL,
  `invoice` varchar(50) NOT NULL,
  `cost_price` int(11) DEFAULT NULL,
  `posted_by` int(11) NOT NULL,
  `post_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `department` varchar(255) NOT NULL,
  `category` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_type` varchar(50) DEFAULT NULL,
  `cost_price` int(255) NOT NULL,
  `sales_price` int(255) NOT NULL,
  `pack_size` int(11) NOT NULL,
  `pack_price` int(11) NOT NULL,
  `wholesale` int(11) NOT NULL,
  `wholesale_pack` int(11) NOT NULL,
  `reorder_level` int(11) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `item_status` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_transfers`
--

CREATE TABLE `item_transfers` (
  `transfer_id` int(11) NOT NULL,
  `item_from` int(11) NOT NULL,
  `item_to` int(11) NOT NULL,
  `removed_qty` int(11) NOT NULL,
  `added_qty` int(11) NOT NULL,
  `store` int(11) NOT NULL,
  `posted_by` int(11) NOT NULL,
  `post_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kyc`
--

CREATE TABLE `kyc` (
  `kyc_id` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `id_type` varchar(50) NOT NULL,
  `id_number` varchar(50) NOT NULL,
  `id_card` varchar(1024) NOT NULL,
  `bvn` int(11) NOT NULL,
  `verification` int(11) NOT NULL,
  `verified_by` int(11) NOT NULL,
  `verified_date` datetime DEFAULT NULL,
  `kyc_date` datetime DEFAULT NULL,
  `posted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kyc`
--

INSERT INTO `kyc` (`kyc_id`, `customer`, `id_type`, `id_number`, `id_card`, `bvn`, `verification`, `verified_by`, `verified_date`, `kyc_date`, `posted_by`) VALUES
(5, 40, 'VOTER&#039;S CARD', '87686876ug', '26680_40.jpg', 2147483647, 1, 1, '2025-06-09 15:20:20', '2025-06-09 15:19:56', 1),
(7, 44, 'NIN', '099888', '05631_44.png', 2147483647, 1, 1, '2025-07-10 08:31:39', '2025-07-10 08:20:54', 14),
(8, 38, 'NIN', '0099889000', '57012_38.jpg', 2147483647, 1, 1, '2025-07-11 13:53:18', '2025-07-11 13:48:58', 1),
(9, 45, 'INTERNATIONAL PASSPORT', '098jjuhhhh', '10296_45.jpg', 2147483647, 1, 1, '2025-07-16 11:44:11', '2025-07-16 11:43:52', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ledgers`
--

CREATE TABLE `ledgers` (
  `ledger_id` int(11) NOT NULL,
  `account_group` int(11) NOT NULL,
  `sub_group` int(11) NOT NULL,
  `class` int(11) NOT NULL,
  `ledger` varchar(1024) NOT NULL,
  `acn` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ledgers`
--

INSERT INTO `ledgers` (`ledger_id`, `account_group`, `sub_group`, `class`, `ledger`, `acn`) VALUES
(24, 1, 2, 5, 'LAND AND BUILDING', 1020524),
(25, 1, 2, 5, 'OFFICE EQUIPMENT', 1020525),
(28, 1, 1, 2, 'CASH ACCOUNT', 1010228),
(29, 1, 1, 3, 'INVENTORIES', 1010329),
(30, 3, 5, 11, 'GENERAL REVENUE', 30501130),
(37, 4, 6, 12, 'UTILITY BILLS', 40601237),
(38, 4, 6, 12, 'TRANSPORTATION', 40601238),
(39, 4, 6, 12, 'SALARIES AND WAGES', 40601239),
(40, 4, 8, 15, 'DEPRECIATION EXPENSE', 40801540),
(41, 4, 8, 15, 'AMORTIZATION - SOFTWARE COST', 40801541),
(42, 1, 2, 6, 'ACCUM DEPRE - LAND AND BUILDING', 1020642),
(44, 1, 2, 6, 'ACCUM DEPRE - OFFICE EQUIPMENT', 1020644),
(45, 5, 9, 16, 'EQUITY CAPITAL', 50901645),
(46, 5, 9, 17, 'RETAINED EARNINGS', 50901746),
(47, 1, 2, 5, 'MOTOR VEHICLES', 1020547),
(48, 1, 2, 5, 'FURNITURE AND FITTINGS', 1020548),
(49, 5, 9, 16, 'DIRECTOR CURRENT ACCOUNT', 50901649),
(50, 1, 1, 1, 'STANBIC IBTC', 1010150),
(51, 1, 1, 1, 'FIDELITY BANK', 1010151),
(52, 1, 1, 1, 'FIRST BANK', 1010152),
(53, 1, 1, 1, 'STANBIC IBTC 2', 1010153),
(60, 4, 10, 18, 'LOSS ON DISPOSAL OF ASSET', 401001860),
(61, 3, 5, 19, 'GAIN ON DISPOSAL OF ASSET', 30501961),
(62, 1, 2, 6, 'ACCUM DEPRE - MOTOR VEHICLES', 1020662),
(63, 4, 7, 14, 'LOCAL DELIVERY', 40701463),
(67, 4, 6, 13, 'COMPANY INCOME TAX', 40601267),
(68, 4, 6, 13, 'LOAN FEES', 40601368),
(69, 4, 6, 13, 'BANK CHARGES', 40601369),
(70, 2, 3, 9, 'SHORT TERM LOANS', 2030970),
(71, 2, 4, 10, 'LONG TERM LOANS', 20401071),
(98, 4, 6, 13, 'MD\'S CHILDREN SCHOOL FEES', 40601398),
(99, 1, 1, 1, 'FOREX', 1010199),
(108, 4, 7, 14, 'COURIER EXPENSES', 406012108),
(109, 4, 7, 14, 'FREIGHT AND CUSTOMS  DUTIES', 406012109),
(110, 4, 6, 12, 'COMPUTER CONSUMABLES', 407014110),
(111, 4, 6, 13, 'PETTY PROJECT EXPENSES', 406013111),
(112, 4, 6, 13, 'TRANSFER TO MDS ACCOUNT', 406013112),
(119, 1, 1, 1, 'ACCESS BANK', 10101119),
(122, 1, 1, 4, 'IKPEFUA KELLY', 10104122),
(128, 1, 1, 4, 'AKPABIA GOODLUCK', 10104128),
(129, 3, 5, 11, 'INTEREST INCOME', 305019129),
(130, 3, 5, 11, 'PROCESSING FEE INCOME', 305019130),
(131, 1, 1, 4, 'DORCAS IKPEFUA', 10104131);

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `loan_id` int(11) NOT NULL,
  `financier` int(11) NOT NULL,
  `loan_account` int(11) NOT NULL,
  `contra_ledger` int(11) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `details` varchar(1024) NOT NULL,
  `trans_type` varchar(50) NOT NULL,
  `trx_number` varchar(50) NOT NULL,
  `trans_date` date DEFAULT NULL,
  `store` int(11) NOT NULL,
  `post_date` datetime DEFAULT NULL,
  `posted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan_applications`
--

CREATE TABLE `loan_applications` (
  `loan_id` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `purpose` varchar(255) NOT NULL,
  `frequency` varchar(50) NOT NULL,
  `installment` decimal(10,2) NOT NULL,
  `interest_rate` float NOT NULL,
  `interest` decimal(10,2) NOT NULL,
  `processing_rate` float NOT NULL,
  `processing_fee` decimal(10,2) NOT NULL,
  `total_payable` decimal(10,2) NOT NULL,
  `penalty` float NOT NULL,
  `loan_term` float NOT NULL,
  `collateral` text NOT NULL,
  `posted_by` int(11) NOT NULL,
  `store` int(11) NOT NULL,
  `application_date` datetime DEFAULT NULL,
  `loan_status` int(11) NOT NULL,
  `approved_by` int(11) NOT NULL,
  `approve_date` datetime DEFAULT NULL,
  `disbursed_date` datetime DEFAULT NULL,
  `due_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loan_applications`
--

INSERT INTO `loan_applications` (`loan_id`, `customer`, `product`, `amount`, `purpose`, `frequency`, `installment`, `interest_rate`, `interest`, `processing_rate`, `processing_fee`, `total_payable`, `penalty`, `loan_term`, `collateral`, `posted_by`, `store`, `application_date`, `loan_status`, `approved_by`, `approve_date`, `disbursed_date`, `due_date`) VALUES
(31, 38, 3, 200000.00, 'Salary Advance', 'Monthly', 70000.00, 4, 8000.00, 1, 2000.00, 210000.00, 0, 3, '', 8, 1, '2025-07-08 21:34:17', 3, 1, '2025-07-08 22:02:21', '2025-07-08 22:54:17', '2025-10-08 00:00:00'),
(32, 38, 1, 70000.00, 'Business', 'Weekly', 6066.67, 3, 2100.00, 1, 700.00, 72800.00, 0, 3, 'my shop', 8, 1, '2025-07-09 10:05:08', 3, 1, '2025-07-09 10:06:33', '2025-07-09 10:06:57', '2025-10-01 00:00:00'),
(33, 38, 3, 250000.00, 'Business', 'Monthly', 87500.00, 4, 10000.00, 1, 2500.00, 262500.00, 0, 3, '', 1, 1, '2025-07-10 08:11:14', 3, 1, '2025-07-10 08:11:29', '2025-07-10 08:11:56', '2025-10-10 00:00:00'),
(34, 44, 3, 300000.00, 'Business', 'Monthly', 105000.00, 4, 12000.00, 1, 3000.00, 315000.00, 0, 3, '', 1, 1, '2025-07-10 08:33:29', 2, 1, '2025-07-10 08:34:53', '2025-07-10 08:37:29', '2025-10-10 00:00:00'),
(35, 38, 3, 100000.00, 'Business', 'Monthly', 35000.00, 4, 4000.00, 1, 1000.00, 105000.00, 0, 3, '', 8, 1, '2025-07-11 12:42:33', -1, 0, NULL, NULL, NULL),
(36, 38, 1, 200000.00, 'Business', 'Weekly', 17333.33, 3, 6000.00, 1, 2000.00, 208000.00, 0, 3, 'non', 8, 1, '2025-07-11 13:03:36', -1, 1, '2025-07-11 13:05:02', NULL, NULL),
(37, 38, 4, 700000.00, 'Business', 'Weekly', 62416.67, 5, 35000.00, 2, 14000.00, 749000.00, 0, 3, '', 8, 1, '2025-07-11 14:15:42', 2, 15, '2025-07-11 14:16:01', '2025-07-11 14:16:45', '2025-10-03 00:00:00'),
(38, 45, 1, 150000.00, 'Business', 'Weekly', 13000.00, 3, 4500.00, 1, 1500.00, 156000.00, 0, 3, 'My house', 1, 1, '2025-07-16 11:46:40', 2, 1, '2025-07-16 11:47:01', '2025-07-16 12:26:58', '2025-10-08 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `loan_products`
--

CREATE TABLE `loan_products` (
  `product_id` int(11) NOT NULL,
  `product` varchar(1024) NOT NULL,
  `description` text NOT NULL,
  `interest` decimal(10,0) NOT NULL,
  `repayment` varchar(50) NOT NULL,
  `minimum` decimal(10,0) NOT NULL,
  `maximum` decimal(10,0) NOT NULL,
  `duration` int(11) NOT NULL,
  `processing` decimal(10,0) NOT NULL,
  `penalty` decimal(10,0) NOT NULL,
  `collateral` varchar(50) NOT NULL,
  `product_status` int(11) NOT NULL,
  `posted_by` int(11) NOT NULL,
  `post_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loan_products`
--

INSERT INTO `loan_products` (`product_id`, `product`, `description`, `interest`, `repayment`, `minimum`, `maximum`, `duration`, `processing`, `penalty`, `collateral`, `product_status`, `posted_by`, `post_date`) VALUES
(1, 'SME LOAN', 'For Small Businesess', 3, 'Weekly', 50000, 300000, 3, 1, 2, 'Yes', 0, 1, '2025-06-17 14:10:52'),
(3, 'SALARY ADVANCE', 'For Employed Individuals Needing Short-term Cash Before Payday', 4, 'Monthly', 100000, 500000, 6, 1, 2, 'No', 0, 1, '2025-06-18 15:56:22'),
(4, 'COOPERATIVE LOAN', 'Group-based Loans Under A Registered Cooperative', 5, 'Weekly', 500000, 1000000, 12, 2, 3, 'No', 0, 1, '2025-06-18 15:58:26');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `menu_id` int(11) NOT NULL,
  `menu` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`menu_id`, `menu`) VALUES
(1, 'Admin menu'),
(2, 'Sales menu'),
(3, 'Purchase menu'),
(4, 'Financial mgt'),
(5, 'Reports'),
(6, 'Financial reports'),
(8, 'Invoicing'),
(9, 'Asset Management'),
(10, 'Chart Of Account'),
(11, 'Client Module'),
(12, 'Customer'),
(13, 'Loan Management');

-- --------------------------------------------------------

--
-- Table structure for table `multiple_payments`
--

CREATE TABLE `multiple_payments` (
  `id` int(11) NOT NULL,
  `store` int(11) NOT NULL,
  `invoice` varchar(255) NOT NULL,
  `cash` int(11) NOT NULL,
  `transfer` int(11) NOT NULL,
  `pos` int(11) NOT NULL,
  `bank` int(11) NOT NULL,
  `posted_by` int(11) NOT NULL,
  `post_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `client` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `not_status` int(11) NOT NULL,
  `post_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `client`, `subject`, `message`, `not_status`, `post_date`) VALUES
(22, 38, 'Your Loan Has Been Approved', 'Dear IKPEFUA KELLY, \r\n\r\n            We’re pleased to inform you that your loan application has been approved ✅.\r\n\r\nYour loan is now awaiting disbursement, and you will receive a notification once the funds have been released to your account.\r\n\r\nThank you for choosing us. We’re excited to support your financial journey!\r\n            \r\n            Best regards,\r\n            Demo Microfinance Ltd', 0, '2025-07-07 17:03:12'),
(23, 38, 'Your Loan Has Been Disbursed', 'Dear IKPEFUA KELLY,\r\n            We are pleased to inform you that your loan of ₦100,000.00 under the SALARY ADVANCE has been successfully disbursed on 7th July, 2025\r\n            LOAN DETAILS:\r\n            * Loan Amount: NGN100,000.00\r\n            * Interest: NGN4,000.00\r\n            * Processing Fee: NGN1,000.00\r\n            * Total Payable: NGN105,000.00\r\n            * Repayment Term: 3 Months\r\n            * Repayment Frequency: Monthly\r\n            * First Repayment Date: 2025-08-07\r\n\r\n            Please ensure that your repayments are made as scheduled to maintain a good credit standing.\r\n\r\n            You can click on loan status to view your status and repayment schedule.\r\n            If you have any questions or need assistance, feel free to reach out to us.\r\n\r\n            Thank you for choosing Demo Microfinance Ltd\r\n            Warm regards,\r\n            **Administrator**Demo Microfinance Ltd', 0, '2025-07-07 17:03:40'),
(24, 38, 'Your Loan Has Been Disbursed', 'Dear IKPEFUA KELLY,\r\n            We are pleased to inform you that your loan of ₦100,000.00 under the SALARY ADVANCE has been successfully disbursed on 8th July, 2025\r\n            LOAN DETAILS:\r\n            * Loan Amount: NGN100,000.00\r\n            * Interest: NGN4,000.00\r\n            * Processing Fee: NGN1,000.00\r\n            * Total Payable: NGN105,000.00\r\n            * Repayment Term: 3 Months\r\n            * Repayment Frequency: Monthly\r\n            * First Repayment Date: 2025-08-08\r\n\r\n            Please ensure that your repayments are made as scheduled to maintain a good credit standing.\r\n\r\n            You can click on loan status to view your status and repayment schedule.\r\n            If you have any questions or need assistance, feel free to reach out to us.\r\n\r\n            Thank you for choosing Demo Microfinance Ltd\r\n            Warm regards,\r\n            **Administrator**Demo Microfinance Ltd', 0, '2025-07-08 08:19:13'),
(25, 38, 'Your Loan Has Been Approved', 'Dear IKPEFUA KELLY, \r\n\r\n            We’re pleased to inform you that your loan application has been approved ✅.\r\n\r\nYour loan is now awaiting disbursement, and you will receive a notification once the funds have been released to your account.\r\n\r\nThank you for choosing us. We’re excited to support your financial journey!\r\n            \r\n            Best regards,\r\n            Demo Microfinance Ltd', 0, '2025-07-08 08:38:13'),
(26, 38, 'Your Loan Has Been Disbursed', 'Dear IKPEFUA KELLY,\r\n            We are pleased to inform you that your loan of ₦200,000.00 under the SALARY ADVANCE has been successfully disbursed on 8th July, 2025\r\n            LOAN DETAILS:\r\n            * Loan Amount: NGN200,000.00\r\n            * Interest: NGN8,000.00\r\n            * Processing Fee: NGN2,000.00\r\n            * Total Payable: NGN210,000.00\r\n            * Repayment Term: 6 Months\r\n            * Repayment Frequency: Monthly\r\n            * First Repayment Date: 2025-08-08\r\n\r\n            Please ensure that your repayments are made as scheduled to maintain a good credit standing.\r\n\r\n            You can click on loan status to view your status and repayment schedule.\r\n            If you have any questions or need assistance, feel free to reach out to us.\r\n\r\n            Thank you for choosing Demo Microfinance Ltd\r\n            Warm regards,\r\n            **Administrator**Demo Microfinance Ltd', 0, '2025-07-08 08:38:38'),
(27, 38, 'Action Required: Additional Information Needed for Your Loan Application', 'Dear IKPEFUA KELLY, \r\n         We hope this message finds you well.\r\n         As part of the review process for your SALARY ADVANCE application, we kindly require additional information to proceed.\r\n         \r\n        Requested Information:\r\n        Please Add A Guarantor\r\n        \r\n        Please respond to this request as soon as possible. This will help us continue processing your loan application without delay.\r\n        \r\n        If you have any questions, feel free to reach out to our support team.\r\n        \r\n        Thank you for choosing Demo Microfinance Ltd We look forward to supporting your financial needs.\r\n        \r\n        Best regards,\r\n        The Loan Review Team\r\n        Demo Microfinance Ltd', 1, '2025-07-08 11:46:14'),
(28, 38, 'Action Required: Additional Information Needed for Your Loan Application', 'Dear IKPEFUA KELLY, \r\n         We hope this message finds you well.\r\n         As part of the review process for your SALARY ADVANCE application, we kindly require additional information to proceed.\r\n         \r\n        Requested Information:\r\n        Upload Gurantor Id Card\r\n        \r\n        Please respond to this request as soon as possible. This will help us continue processing your loan application without delay.\r\n        \r\n        If you have any questions, feel free to reach out to our support team.\r\n        \r\n        Thank you for choosing Demo Microfinance Ltd We look forward to supporting your financial needs.\r\n        \r\n        Best regards,\r\n        The Loan Review Team\r\n        Demo Microfinance Ltd', 1, '2025-07-08 11:49:19'),
(29, 38, 'Your Loan Has Been Approved', 'Dear IKPEFUA KELLY, \r\n\r\n            We’re pleased to inform you that your loan application has been approved ✅.\r\n\r\nYour loan is now awaiting disbursement, and you will receive a notification once the funds have been released to your account.\r\n\r\nThank you for choosing us. We’re excited to support your financial journey!\r\n            \r\n            Best regards,\r\n            Demo Microfinance Ltd', 1, '2025-07-08 11:51:29'),
(30, 38, 'Your Loan Has Been Disbursed', 'Dear IKPEFUA KELLY,\r\n            We are pleased to inform you that your loan of ₦500,000.00 under the SALARY ADVANCE has been successfully disbursed on 8th July, 2025\r\n            LOAN DETAILS:\r\n            * Loan Amount: NGN500,000.00\r\n            * Interest: NGN20,000.00\r\n            * Processing Fee: NGN5,000.00\r\n            * Total Payable: NGN525,000.00\r\n            * Repayment Term: 6 Months\r\n            * Repayment Frequency: Monthly\r\n            * First Repayment Date: 2025-08-08\r\n\r\n            Please ensure that your repayments are made as scheduled to maintain a good credit standing.\r\n\r\n            You can click on loan status to view your status and repayment schedule.\r\n            If you have any questions or need assistance, feel free to reach out to us.\r\n\r\n            Thank you for choosing Demo Microfinance Ltd\r\n            Warm regards,\r\n            **Administrator**Demo Microfinance Ltd', 0, '2025-07-08 11:53:39'),
(31, 38, 'Your Loan Has Been Disbursed', 'Dear IKPEFUA KELLY,\r\n            We are pleased to inform you that your loan of ₦500,000.00 under the SALARY ADVANCE has been successfully disbursed on 8th July, 2025\r\n            LOAN DETAILS:\r\n            * Loan Amount: NGN500,000.00\r\n            * Interest: NGN20,000.00\r\n            * Processing Fee: NGN5,000.00\r\n            * Total Payable: NGN525,000.00\r\n            * Repayment Term: 6 Months\r\n            * Repayment Frequency: Monthly\r\n            * First Repayment Date: 2025-08-08\r\n\r\n            Please ensure that your repayments are made as scheduled to maintain a good credit standing.\r\n\r\n            You can click on loan status to view your status and repayment schedule.\r\n            If you have any questions or need assistance, feel free to reach out to us.\r\n\r\n            Thank you for choosing Demo Microfinance Ltd\r\n            Warm regards,\r\n            **Administrator**Demo Microfinance Ltd', 0, '2025-07-08 13:16:38'),
(32, 38, 'Your Loan Has Been Approved', 'Dear IKPEFUA KELLY, \r\n\r\n            We’re pleased to inform you that your loan application has been approved ✅.\r\n\r\nYour loan is now awaiting disbursement, and you will receive a notification once the funds have been released to your account.\r\n\r\nThank you for choosing us. We’re excited to support your financial journey!\r\n            \r\n            Best regards,\r\n            Demo Microfinance Ltd', 0, '2025-07-08 13:24:04'),
(33, 38, 'Your Loan Has Been Disbursed', 'Dear IKPEFUA KELLY,\r\n            We are pleased to inform you that your loan of ₦100,000.00 under the SALARY ADVANCE has been successfully disbursed on 8th July, 2025\r\n            LOAN DETAILS:\r\n            * Loan Amount: NGN100,000.00\r\n            * Interest: NGN4,000.00\r\n            * Processing Fee: NGN1,000.00\r\n            * Total Payable: NGN105,000.00\r\n            * Repayment Term: 3 Months\r\n            * Repayment Frequency: Monthly\r\n            * First Repayment Date: 2025-08-08\r\n\r\n            Please ensure that your repayments are made as scheduled to maintain a good credit standing.\r\n\r\n            You can click on loan status to view your status and repayment schedule.\r\n            If you have any questions or need assistance, feel free to reach out to us.\r\n\r\n            Thank you for choosing Demo Microfinance Ltd\r\n            Warm regards,\r\n            **Administrator**Demo Microfinance Ltd', 0, '2025-07-08 13:24:24'),
(34, 38, 'Your Loan Has Been Approved', 'Dear IKPEFUA KELLY, \r\n\r\n            We’re pleased to inform you that your loan application has been approved ✅.\r\n\r\nYour loan is now awaiting disbursement, and you will receive a notification once the funds have been released to your account.\r\n\r\nThank you for choosing us. We’re excited to support your financial journey!\r\n            \r\n            Best regards,\r\n            Demo Microfinance Ltd', 0, '2025-07-08 14:20:55'),
(35, 38, 'Your Loan Has Been Disbursed', 'Dear IKPEFUA KELLY,\r\n            We are pleased to inform you that your loan of ₦100,000.00 under the SALARY ADVANCE has been successfully disbursed on 8th July, 2025\r\n            LOAN DETAILS:\r\n            * Loan Amount: NGN100,000.00\r\n            * Interest: NGN4,000.00\r\n            * Processing Fee: NGN1,000.00\r\n            * Total Payable: NGN105,000.00\r\n            * Repayment Term: 3 Months\r\n            * Repayment Frequency: Monthly\r\n            * First Repayment Date: 2025-08-08\r\n\r\n            Please ensure that your repayments are made as scheduled to maintain a good credit standing.\r\n\r\n            You can click on loan status to view your status and repayment schedule.\r\n            If you have any questions or need assistance, feel free to reach out to us.\r\n\r\n            Thank you for choosing Demo Microfinance Ltd\r\n            Warm regards,\r\n            **Administrator**Demo Microfinance Ltd', 0, '2025-07-08 14:21:12'),
(36, 38, 'Your Loan Has Been Disbursed', 'Dear IKPEFUA KELLY,\r\n            We are pleased to inform you that your loan of ₦100,000.00 under the SALARY ADVANCE has been successfully disbursed on 8th July, 2025\r\n            LOAN DETAILS:\r\n            * Loan Amount: NGN100,000.00\r\n            * Interest: NGN4,000.00\r\n            * Processing Fee: NGN1,000.00\r\n            * Total Payable: NGN105,000.00\r\n            * Repayment Term: 3 Months\r\n            * Repayment Frequency: Monthly\r\n            * First Repayment Date: 2025-08-08\r\n\r\n            Please ensure that your repayments are made as scheduled to maintain a good credit standing.\r\n\r\n            You can click on loan status to view your status and repayment schedule.\r\n            If you have any questions or need assistance, feel free to reach out to us.\r\n\r\n            Thank you for choosing Demo Microfinance Ltd\r\n            Warm regards,\r\n            **Administrator**Demo Microfinance Ltd', 0, '2025-07-08 14:27:45'),
(37, 38, 'Your Loan Has Been Disbursed', 'Dear IKPEFUA KELLY,\r\n            We are pleased to inform you that your loan of ₦100,000.00 under the SALARY ADVANCE has been successfully disbursed on 8th July, 2025\r\n            LOAN DETAILS:\r\n            * Loan Amount: NGN100,000.00\r\n            * Interest: NGN4,000.00\r\n            * Processing Fee: NGN1,000.00\r\n            * Total Payable: NGN105,000.00\r\n            * Repayment Term: 3 Months\r\n            * Repayment Frequency: Monthly\r\n            * First Repayment Date: 2025-08-08\r\n\r\n            Please ensure that your repayments are made as scheduled to maintain a good credit standing.\r\n\r\n            You can click on loan status to view your status and repayment schedule.\r\n            If you have any questions or need assistance, feel free to reach out to us.\r\n\r\n            Thank you for choosing Demo Microfinance Ltd\r\n            Warm regards,\r\n            **Administrator**Demo Microfinance Ltd', 0, '2025-07-08 15:07:35'),
(38, 38, 'Your Loan Has Been Approved', 'Dear IKPEFUA KELLY, \r\n\r\n            We’re pleased to inform you that your loan application has been approved ✅.\r\n\r\nYour loan is now awaiting disbursement, and you will receive a notification once the funds have been released to your account.\r\n\r\nThank you for choosing us. We’re excited to support your financial journey!\r\n            \r\n            Best regards,\r\n            Demo Microfinance Ltd', 0, '2025-07-08 15:14:47'),
(39, 38, 'Your Loan Has Been Disbursed', 'Dear IKPEFUA KELLY,\r\n            We are pleased to inform you that your loan of ₦200,000.00 under the SALARY ADVANCE has been successfully disbursed on 8th July, 2025\r\n            LOAN DETAILS:\r\n            * Loan Amount: NGN200,000.00\r\n            * Interest: NGN8,000.00\r\n            * Processing Fee: NGN2,000.00\r\n            * Total Payable: NGN210,000.00\r\n            * Repayment Term: 3 Months\r\n            * Repayment Frequency: Monthly\r\n            * First Repayment Date: 2025-08-08\r\n\r\n            Please ensure that your repayments are made as scheduled to maintain a good credit standing.\r\n\r\n            You can click on loan status to view your status and repayment schedule.\r\n            If you have any questions or need assistance, feel free to reach out to us.\r\n\r\n            Thank you for choosing Demo Microfinance Ltd\r\n            Warm regards,\r\n            **Administrator**Demo Microfinance Ltd', 0, '2025-07-08 15:15:07'),
(40, 38, 'Your Loan Has Been Disbursed', 'Dear IKPEFUA KELLY,\r\n            We are pleased to inform you that your loan of ₦200,000.00 under the SALARY ADVANCE has been successfully disbursed on 8th July, 2025\r\n            LOAN DETAILS:\r\n            * Loan Amount: NGN200,000.00\r\n            * Interest: NGN8,000.00\r\n            * Processing Fee: NGN2,000.00\r\n            * Total Payable: NGN210,000.00\r\n            * Repayment Term: 3 Months\r\n            * Repayment Frequency: Monthly\r\n            * First Repayment Date: 2025-08-08\r\n\r\n            Please ensure that your repayments are made as scheduled to maintain a good credit standing.\r\n\r\n            You can click on loan status to view your status and repayment schedule.\r\n            If you have any questions or need assistance, feel free to reach out to us.\r\n\r\n            Thank you for choosing Demo Microfinance Ltd\r\n            Warm regards,\r\n            **Administrator**Demo Microfinance Ltd', 0, '2025-07-08 16:06:21'),
(41, 38, 'Your Loan Has Been Disbursed', 'Dear IKPEFUA KELLY,\r\n            We are pleased to inform you that your loan of ₦200,000.00 under the SALARY ADVANCE has been successfully disbursed on 8th July, 2025\r\n            LOAN DETAILS:\r\n            * Loan Amount: NGN200,000.00\r\n            * Interest: NGN8,000.00\r\n            * Processing Fee: NGN2,000.00\r\n            * Total Payable: NGN210,000.00\r\n            * Repayment Term: 3 Months\r\n            * Repayment Frequency: Monthly\r\n            * First Repayment Date: 2025-08-08\r\n\r\n            Please ensure that your repayments are made as scheduled to maintain a good credit standing.\r\n\r\n            You can click on loan status to view your status and repayment schedule.\r\n            If you have any questions or need assistance, feel free to reach out to us.\r\n\r\n            Thank you for choosing Demo Microfinance Ltd\r\n            Warm regards,\r\n            **Administrator**Demo Microfinance Ltd', 0, '2025-07-08 16:33:22'),
(42, 38, 'Your Loan Has Been Approved', 'Dear IKPEFUA KELLY, \r\n\r\n            We’re pleased to inform you that your loan application has been approved ✅.\r\n\r\nYour loan is now awaiting disbursement, and you will receive a notification once the funds have been released to your account.\r\n\r\nThank you for choosing us. We’re excited to support your financial journey!\r\n            \r\n            Best regards,\r\n            Demo Microfinance Ltd', 0, '2025-07-08 16:37:17'),
(43, 38, 'Your Loan Has Been Disbursed', 'Dear IKPEFUA KELLY,\r\n            We are pleased to inform you that your loan of ₦100,000.00 under the SALARY ADVANCE has been successfully disbursed on 8th July, 2025\r\n            LOAN DETAILS:\r\n            * Loan Amount: NGN100,000.00\r\n            * Interest: NGN4,000.00\r\n            * Processing Fee: NGN1,000.00\r\n            * Total Payable: NGN105,000.00\r\n            * Repayment Term: 3 Months\r\n            * Repayment Frequency: Monthly\r\n            * First Repayment Date: 2025-08-08\r\n\r\n            Please ensure that your repayments are made as scheduled to maintain a good credit standing.\r\n\r\n            You can click on loan status to view your status and repayment schedule.\r\n            If you have any questions or need assistance, feel free to reach out to us.\r\n\r\n            Thank you for choosing Demo Microfinance Ltd\r\n            Warm regards,\r\n            **Administrator**Demo Microfinance Ltd', 0, '2025-07-08 16:37:27'),
(44, 38, 'Your Loan Has Been Approved', 'Dear IKPEFUA KELLY, \r\n\r\n            We’re pleased to inform you that your loan application has been approved ✅.\r\n\r\nYour loan is now awaiting disbursement, and you will receive a notification once the funds have been released to your account.\r\n\r\nThank you for choosing us. We’re excited to support your financial journey!\r\n            \r\n            Best regards,\r\n            Demo Microfinance Ltd', 0, '2025-07-08 16:47:16'),
(45, 38, 'Your Loan Has Been Disbursed', 'Dear IKPEFUA KELLY,\r\n            We are pleased to inform you that your loan of ₦150,000.00 under the SME LOAN has been successfully disbursed on 8th July, 2025\r\n            LOAN DETAILS:\r\n            * Loan Amount: NGN150,000.00\r\n            * Interest: NGN4,500.00\r\n            * Processing Fee: NGN1,500.00\r\n            * Total Payable: NGN156,000.00\r\n            * Repayment Term: 3 Months\r\n            * Repayment Frequency: Weekly\r\n            * First Repayment Date: 2025-07-15\r\n\r\n            Please ensure that your repayments are made as scheduled to maintain a good credit standing.\r\n\r\n            You can click on loan status to view your status and repayment schedule.\r\n            If you have any questions or need assistance, feel free to reach out to us.\r\n\r\n            Thank you for choosing Demo Microfinance Ltd\r\n            Warm regards,\r\n            **Administrator**Demo Microfinance Ltd', 0, '2025-07-08 17:05:41'),
(46, 38, 'Your Loan Has Been Approved', 'Dear IKPEFUA KELLY, \r\n\r\n            We’re pleased to inform you that your loan application has been approved ✅.\r\n\r\nYour loan is now awaiting disbursement, and you will receive a notification once the funds have been released to your account.\r\n\r\nThank you for choosing us. We’re excited to support your financial journey!\r\n            \r\n            Best regards,\r\n            Demo Microfinance Ltd', 0, '2025-07-08 21:09:23'),
(47, 38, 'Your Loan Has Been Disbursed', 'Dear IKPEFUA KELLY,\r\n            We are pleased to inform you that your loan of ₦300,000.00 under the SALARY ADVANCE has been successfully disbursed on 8th July, 2025\r\n            LOAN DETAILS:\r\n            * Loan Amount: NGN300,000.00\r\n            * Interest: NGN12,000.00\r\n            * Processing Fee: NGN3,000.00\r\n            * Total Payable: NGN315,000.00\r\n            * Repayment Term: 3 Months\r\n            * Repayment Frequency: Monthly\r\n            * First Repayment Date: 2025-08-08\r\n\r\n            Please ensure that your repayments are made as scheduled to maintain a good credit standing.\r\n\r\n            You can click on loan status to view your status and repayment schedule.\r\n            If you have any questions or need assistance, feel free to reach out to us.\r\n\r\n            Thank you for choosing Demo Microfinance Ltd\r\n            Warm regards,\r\n            **Administrator**Demo Microfinance Ltd', 0, '2025-07-08 21:11:38'),
(48, 38, 'Your Loan Has Been Approved', 'Dear IKPEFUA KELLY, \r\n\r\n            We’re pleased to inform you that your loan application has been approved ✅.\r\n\r\nYour loan is now awaiting disbursement, and you will receive a notification once the funds have been released to your account.\r\n\r\nThank you for choosing us. We’re excited to support your financial journey!\r\n            \r\n            Best regards,\r\n            Demo Microfinance Ltd', 0, '2025-07-08 22:02:21'),
(49, 38, 'Your Loan Has Been Disbursed', 'Dear IKPEFUA KELLY,\r\n            We are pleased to inform you that your loan of ₦200,000.00 under the SALARY ADVANCE has been successfully disbursed on 8th July, 2025\r\n            LOAN DETAILS:\r\n            * Loan Amount: NGN200,000.00\r\n            * Interest: NGN8,000.00\r\n            * Processing Fee: NGN2,000.00\r\n            * Total Payable: NGN210,000.00\r\n            * Repayment Term: 3 Months\r\n            * Repayment Frequency: Monthly\r\n            * First Repayment Date: 2025-08-08\r\n\r\n            Please ensure that your repayments are made as scheduled to maintain a good credit standing.\r\n\r\n            You can click on loan status to view your status and repayment schedule.\r\n            If you have any questions or need assistance, feel free to reach out to us.\r\n\r\n            Thank you for choosing Demo Microfinance Ltd\r\n            Warm regards,\r\n            **Administrator**Demo Microfinance Ltd', 0, '2025-07-08 22:05:08'),
(50, 38, 'Your Loan Has Been Disbursed', 'Dear IKPEFUA KELLY,\r\n            We are pleased to inform you that your loan of ₦200,000.00 under the SALARY ADVANCE has been successfully disbursed on 8th July, 2025\r\n            LOAN DETAILS:\r\n            * Loan Amount: NGN200,000.00\r\n            * Interest: NGN8,000.00\r\n            * Processing Fee: NGN2,000.00\r\n            * Total Payable: NGN210,000.00\r\n            * Repayment Term: 3 Months\r\n            * Repayment Frequency: Monthly\r\n            * First Repayment Date: 2025-08-08\r\n\r\n            Please ensure that your repayments are made as scheduled to maintain a good credit standing.\r\n\r\n            You can click on loan status to view your status and repayment schedule.\r\n            If you have any questions or need assistance, feel free to reach out to us.\r\n\r\n            Thank you for choosing Demo Microfinance Ltd\r\n            Warm regards,\r\n            **Administrator**Demo Microfinance Ltd', 0, '2025-07-08 22:35:09'),
(51, 38, 'Your Loan Has Been Disbursed', 'Dear IKPEFUA KELLY,\r\n            We are pleased to inform you that your loan of ₦200,000.00 under the SALARY ADVANCE has been successfully disbursed on 8th July, 2025\r\n            LOAN DETAILS:\r\n            * Loan Amount: NGN200,000.00\r\n            * Interest: NGN8,000.00\r\n            * Processing Fee: NGN2,000.00\r\n            * Total Payable: NGN210,000.00\r\n            * Repayment Term: 3 Months\r\n            * Repayment Frequency: Monthly\r\n            * First Repayment Date: 2025-08-08\r\n\r\n            Please ensure that your repayments are made as scheduled to maintain a good credit standing.\r\n\r\n            You can click on loan status to view your status and repayment schedule.\r\n            If you have any questions or need assistance, feel free to reach out to us.\r\n\r\n            Thank you for choosing Demo Microfinance Ltd\r\n            Warm regards,\r\n            **Administrator**Demo Microfinance Ltd', 1, '2025-07-08 22:54:17'),
(52, 38, 'Your Loan Has Been Approved', 'Dear IKPEFUA KELLY, \r\n\r\n            We’re pleased to inform you that your loan application has been approved ✅.\r\n\r\nYour loan is now awaiting disbursement, and you will receive a notification once the funds have been released to your account.\r\n\r\nThank you for choosing us. We’re excited to support your financial journey!\r\n            \r\n            Best regards,\r\n            Demo Microfinance Ltd', 0, '2025-07-09 10:06:33'),
(53, 38, 'Your Loan Has Been Disbursed', 'Dear IKPEFUA KELLY,\r\n            We are pleased to inform you that your loan of ₦70,000.00 under the SME LOAN has been successfully disbursed on 9th July, 2025\r\n            LOAN DETAILS:\r\n            * Loan Amount: NGN70,000.00\r\n            * Interest: NGN2,100.00\r\n            * Processing Fee: NGN700.00\r\n            * Total Payable: NGN72,800.00\r\n            * Repayment Term: 3 Months\r\n            * Repayment Frequency: Weekly\r\n            * First Repayment Date: 2025-07-16\r\n\r\n            Please ensure that your repayments are made as scheduled to maintain a good credit standing.\r\n\r\n            You can click on loan status to view your status and repayment schedule.\r\n            If you have any questions or need assistance, feel free to reach out to us.\r\n\r\n            Thank you for choosing Demo Microfinance Ltd\r\n            Warm regards,\r\n            **Administrator**Demo Microfinance Ltd', 1, '2025-07-09 10:06:57'),
(54, 38, 'Loan Payment Confirmation', 'Dear ,\r\n            We confirm the receipt of your payment of ₦30000 on 9th July 2025, 03:43pm towards your loan repayment.\r\n            Transaction ID: LP090725034220101179\r\n            Your account has been updated accordingly. Thank you for your commitment.\r\n            \r\n            If you have any questions or need a receipt, feel free to contact us\r\n\r\n            Warm regards,\r\n            Customer Support', 1, '2025-07-09 15:43:07'),
(55, 38, 'Loan Payment Confirmation', 'Dear IKPEFUA KELLY,\r\n            We confirm the receipt of your payment of ₦20000 on 9th July 2025, 03:55pm towards your loan repayment.\r\n            Transaction ID: LP090725035533003183\r\n            Your account has been updated accordingly. Thank you for your commitment.\r\n            \r\n            If you have any questions or need a receipt, feel free to contact us\r\n\r\n            Warm regards,Demo Microfinance Ltd\r\n            Customer Support', 1, '2025-07-09 15:55:44'),
(56, 38, 'Loan Payment Confirmation', 'Dear IKPEFUA KELLY,\r\n            We confirm the receipt of your payment of ₦10,000.00 on 9th July 2025, 03:59pm towards your loan repayment.\r\n            Transaction ID: LP090725035910320187\r\n            Your account has been updated accordingly. Thank you for your commitment.\r\n            \r\n            If you have any questions or need a receipt, feel free to contact us\r\n\r\n            Warm regards,\r\n            Demo Microfinance Ltd\r\n            Customer Support', 1, '2025-07-09 15:59:43'),
(57, 38, 'Loan Payment Confirmation', 'Dear IKPEFUA KELLY,\r\n            We confirm the receipt of your payment of ₦12,800.04 on 9th July 2025, 04:01pm towards your loan repayment.\r\n            Transaction ID: LP090725040122022188\r\n            Your account has been updated accordingly. Thank you for your commitment.\r\n            \r\n            If you have any questions or need a receipt, feel free to contact us\r\n\r\n            Warm regards,\r\n            Demo Microfinance Ltd\r\n            Customer Support', 0, '2025-07-09 16:01:40'),
(58, 38, 'Your Loan Has Been Approved', 'Dear IKPEFUA KELLY, \r\n\r\n            We’re pleased to inform you that your loan application has been approved ✅.\r\n\r\nYour loan is now awaiting disbursement, and you will receive a notification once the funds have been released to your account.\r\n\r\nThank you for choosing us. We’re excited to support your financial journey!\r\n            \r\n            Best regards,\r\n            Demo Microfinance Ltd', 0, '2025-07-10 08:11:29'),
(59, 38, 'Your Loan Has Been Disbursed', 'Dear IKPEFUA KELLY,\r\n            We are pleased to inform you that your loan of ₦250,000.00 under the SALARY ADVANCE has been successfully disbursed on 10th July, 2025\r\n            LOAN DETAILS:\r\n            * Loan Amount: NGN250,000.00\r\n            * Interest: NGN10,000.00\r\n            * Processing Fee: NGN2,500.00\r\n            * Total Payable: NGN262,500.00\r\n            * Repayment Term: 3 Months\r\n            * Repayment Frequency: Monthly\r\n            * First Repayment Date: 2025-08-10\r\n\r\n            Please ensure that your repayments are made as scheduled to maintain a good credit standing.\r\n\r\n            You can click on loan status to view your status and repayment schedule.\r\n            If you have any questions or need assistance, feel free to reach out to us.\r\n\r\n            Thank you for choosing Demo Microfinance Ltd\r\n            Warm regards,\r\n            **Administrator**Demo Microfinance Ltd', 0, '2025-07-10 08:11:56'),
(60, 44, 'KYC Verification Approved', 'Dear AKPABIA GOODLUCK, \r\n\r\n            We’re happy to inform you that your KYC verification has been successfully completed. 🎉\r\n            \r\n            Your account is now fully verified, and you can enjoy uninterrupted access to all features and services.\r\n\r\n            Thank you for completing the verification process. If you have any questions or need assistance, feel free to reach out to our support team.\r\n            \r\n            Best regards,Demo Microfinance Ltd', 0, '2025-07-10 08:31:39'),
(61, 44, 'Your Loan Has Been Approved', 'Dear AKPABIA GOODLUCK, \r\n\r\n            We’re pleased to inform you that your loan application has been approved ✅.\r\n\r\nYour loan is now awaiting disbursement, and you will receive a notification once the funds have been released to your account.\r\n\r\nThank you for choosing us. We’re excited to support your financial journey!\r\n            \r\n            Best regards,\r\n            Demo Microfinance Ltd', 0, '2025-07-10 08:34:53'),
(62, 44, 'Your Loan Has Been Disbursed', 'Dear AKPABIA GOODLUCK,\r\n            We are pleased to inform you that your loan of ₦300,000.00 under the SALARY ADVANCE has been successfully disbursed on 10th July, 2025\r\n            LOAN DETAILS:\r\n            * Loan Amount: NGN300,000.00\r\n            * Interest: NGN12,000.00\r\n            * Processing Fee: NGN3,000.00\r\n            * Total Payable: NGN315,000.00\r\n            * Repayment Term: 3 Months\r\n            * Repayment Frequency: Monthly\r\n            * First Repayment Date: 2025-08-10\r\n\r\n            Please ensure that your repayments are made as scheduled to maintain a good credit standing.\r\n\r\n            You can click on loan status to view your status and repayment schedule.\r\n            If you have any questions or need assistance, feel free to reach out to us.\r\n\r\n            Thank you for choosing Demo Microfinance Ltd\r\n            Warm regards,\r\n            **Administrator**Demo Microfinance Ltd', 0, '2025-07-10 08:37:29'),
(63, 38, 'Loan Payment Confirmation', 'Dear IKPEFUA KELLY,\r\n            We confirm the receipt of your payment of ₦60,000.00 on 11th July 2025, 07:16am towards your loan repayment.\r\n            Transaction ID: LP1107250716211111591\r\n            Your account has been updated accordingly. Thank you for your commitment.\r\n            \r\n            If you have any questions or need a receipt, feel free to contact us\r\n\r\n            Warm regards,\r\n            Demo Microfinance Ltd\r\n            Customer Support', 0, '2025-07-11 07:16:55'),
(64, 44, 'Loan Payment Confirmation', 'Dear AKPABIA GOODLUCK,\r\n            We confirm the receipt of your payment of ₦12,000.00 on 11th July 2025, 07:18am towards your loan repayment.\r\n            Transaction ID: LP1107250717121211594\r\n            Your account has been updated accordingly. Thank you for your commitment.\r\n            \r\n            If you have any questions or need a receipt, feel free to contact us\r\n\r\n            Warm regards,\r\n            Demo Microfinance Ltd\r\n            Customer Support', 0, '2025-07-11 07:18:16'),
(65, 38, 'Loan Payment Confirmation', 'Dear IKPEFUA KELLY,\r\n            We confirm the receipt of your payment of ₦35,000.00 on 11th July 2025, 07:26am towards your loan repayment.\r\n            Transaction ID: LP110725072610003191\r\n            Your account has been updated accordingly. Thank you for your commitment.\r\n            \r\n            If you have any questions or need a receipt, feel free to contact us\r\n\r\n            Warm regards,\r\n            Demo Microfinance Ltd\r\n            Customer Support', 0, '2025-07-11 07:26:23'),
(66, 38, 'Loan Payment Confirmation', 'Dear IKPEFUA KELLY,\r\n            We confirm the receipt of your payment of ₦80,000.00 on 11th July 2025, 07:39am towards your loan repayment.\r\n            Transaction ID: LP1107250739213011592\r\n            Your account has been updated accordingly. Thank you for your commitment.\r\n            \r\n            If you have any questions or need a receipt, feel free to contact us\r\n\r\n            Warm regards,\r\n            Demo Microfinance Ltd\r\n            Customer Support', 1, '2025-07-11 07:39:38'),
(67, 38, 'Loan Payment Confirmation', 'Dear IKPEFUA KELLY,\r\n            We confirm the receipt of your payment of ₦87,500.00 on 11th July 2025, 12:37pm towards your loan repayment.\r\n            Transaction ID: LP110725123732000193\r\n            Your account has been updated accordingly. Thank you for your commitment.\r\n            \r\n            If you have any questions or need a receipt, feel free to contact us\r\n\r\n            Warm regards,\r\n            Demo Microfinance Ltd\r\n            Customer Support', 0, '2025-07-11 12:37:58'),
(68, 38, 'Loan Application Declined', 'Dear IKPEFUA KELLY, \r\n            Thank you for choosing Demo Microfinance Ltd for your financial needs.\r\n            \r\n            After careful review of your recent loan application, we regret to inform you that your request has not been approved at this time. This decision was based on our internal assessment and current lending criteria.\r\n            \r\n            Your application was declined for the following reasons:\r\n            You Are Not Prompt To Payment\r\n            \r\n            We understand this may be disappointing, and we encourage you to reapply in the future or reach out to us to discuss possible alternatives or ways to strengthen your eligibility.\r\n            \r\n            Thank you once again for considering Demo Microfinance Ltd\r\n            \r\n            Warm regards,\r\n            Demo Microfinance Ltd', 1, '2025-07-11 12:43:24'),
(69, 38, 'Your Loan Has Been Approved', 'Dear IKPEFUA KELLY, \r\n\r\n            We’re pleased to inform you that your loan application has been approved ✅.\r\n\r\nYour loan is now awaiting disbursement, and you will receive a notification once the funds have been released to your account.\r\n\r\nThank you for choosing us. We’re excited to support your financial journey!\r\n            \r\n            Best regards,\r\n            Demo Microfinance Ltd', 0, '2025-07-11 13:04:34'),
(70, 38, 'Loan Application Declined', 'Dear IKPEFUA KELLY, \r\n            Thank you for choosing Demo Microfinance Ltd for your financial needs.\r\n            \r\n            After careful review of your recent loan application, we regret to inform you that your request has not been approved at this time. This decision was based on our internal assessment and current lending criteria.\r\n            \r\n            Your application was declined for the following reasons:\r\n            No Collateral\r\n            \r\n            We understand this may be disappointing, and we encourage you to reapply in the future or reach out to us to discuss possible alternatives or ways to strengthen your eligibility.\r\n            \r\n            Thank you once again for considering Demo Microfinance Ltd\r\n            \r\n            Warm regards,\r\n            Demo Microfinance Ltd', 0, '2025-07-11 13:05:02'),
(71, 38, 'KYC Verification Approved', 'Dear IKPEFUA KELLY, \r\n\r\n            We’re happy to inform you that your KYC verification has been successfully completed. 🎉\r\n            \r\n            Your account is now fully verified, and you can enjoy uninterrupted access to all features and services.\r\n\r\n            Thank you for completing the verification process. If you have any questions or need assistance, feel free to reach out to our support team.\r\n            \r\n            Best regards,Demo Microfinance Ltd', 1, '2025-07-11 13:53:18'),
(72, 38, 'Your Loan Has Been Approved', 'Dear IKPEFUA KELLY, \r\n\r\n            We’re pleased to inform you that your loan application has been approved ✅.\r\n\r\nYour loan is now awaiting disbursement, and you will receive a notification once the funds have been released to your account.\r\n\r\nThank you for choosing us. We’re excited to support your financial journey!\r\n            \r\n            Best regards,\r\n            Demo Microfinance Ltd', 1, '2025-07-11 14:16:01'),
(73, 38, 'Your Loan Has Been Disbursed', 'Dear IKPEFUA KELLY,\r\n            We are pleased to inform you that your loan of ₦700,000.00 under the COOPERATIVE LOAN has been successfully disbursed on 11th July, 2025\r\n            LOAN DETAILS:\r\n            * Loan Amount: NGN700,000.00\r\n            * Interest: NGN35,000.00\r\n            * Processing Fee: NGN14,000.00\r\n            * Total Payable: NGN749,000.00\r\n            * Repayment Term: 3 Months\r\n            * Repayment Frequency: Weekly\r\n            * First Repayment Date: 2025-07-18\r\n\r\n            Please ensure that your repayments are made as scheduled to maintain a good credit standing.\r\n\r\n            You can click on loan status to view your status and repayment schedule.\r\n            If you have any questions or need assistance, feel free to reach out to us.\r\n\r\n            Thank you for choosing Demo Microfinance Ltd\r\n            Warm regards,\r\n            **Administrator**Demo Microfinance Ltd', 0, '2025-07-11 14:16:45'),
(74, 38, 'Loan Payment Confirmation', 'Dear IKPEFUA KELLY,\r\n            We confirm the receipt of your payment of ₦50,000.00 on 14th July 2025, 09:48am towards your loan repayment.\r\n            Transaction ID: LP140725094820211197\r\n            Your account has been updated accordingly. Thank you for your commitment.\r\n            \r\n            If you have any questions or need a receipt, feel free to contact us\r\n\r\n            Warm regards,\r\n            Demo Microfinance Ltd\r\n            Customer Support', 1, '2025-07-14 09:48:52'),
(75, 44, 'Loan Payment Confirmation', 'Dear AKPABIA GOODLUCK,\r\n            We confirm the receipt of your payment of ₦100,000.00 on 15th July 2025, 07:15am towards your loan repayment.\r\n            Transaction ID: LP1507250715023201594\r\n            Your account has been updated accordingly. Thank you for your commitment.\r\n            \r\n            If you have any questions or need a receipt, feel free to contact us\r\n\r\n            Warm regards,\r\n            Demo Microfinance Ltd\r\n            Customer Support', 0, '2025-07-15 07:15:31'),
(76, 45, 'KYC Verification Approved', 'Dear DORCAS IKPEFUA, \r\n\r\n            We’re happy to inform you that your KYC verification has been successfully completed. 🎉\r\n            \r\n            Your account is now fully verified, and you can enjoy uninterrupted access to all features and services.\r\n\r\n            Thank you for completing the verification process. If you have any questions or need assistance, feel free to reach out to our support team.\r\n            \r\n            Best regards,Demo Microfinance Ltd', 0, '2025-07-16 11:44:11'),
(77, 45, 'Your Loan Has Been Approved', 'Dear DORCAS IKPEFUA, \r\n\r\n            We’re pleased to inform you that your loan application has been approved ✅.\r\n\r\nYour loan is now awaiting disbursement, and you will receive a notification once the funds have been released to your account.\r\n\r\nThank you for choosing us. We’re excited to support your financial journey!\r\n            \r\n            Best regards,\r\n            Demo Microfinance Ltd', 0, '2025-07-16 11:47:01'),
(78, 45, 'Your Loan Has Been Disbursed', 'Dear DORCAS IKPEFUA,\r\n            We are pleased to inform you that your loan of ₦150,000.00 under the SME LOAN has been successfully disbursed on 16th July, 2025\r\n            LOAN DETAILS:\r\n            * Loan Amount: NGN150,000.00\r\n            * Interest: NGN4,500.00\r\n            * Processing Fee: NGN1,500.00\r\n            * Total Payable: NGN156,000.00\r\n            * Repayment Term: 3 Months\r\n            * Repayment Frequency: Weekly\r\n            * First Repayment Date: 2025-07-23\r\n\r\n            Please ensure that your repayments are made as scheduled to maintain a good credit standing.\r\n\r\n            You can click on loan status to view your status and repayment schedule.\r\n            If you have any questions or need assistance, feel free to reach out to us.\r\n\r\n            Thank you for choosing Demo Microfinance Ltd\r\n            Warm regards,\r\n            **Administrator**Demo Microfinance Ltd', 0, '2025-07-16 12:26:58'),
(79, 45, 'Loan Payment Confirmation', 'Dear DORCAS IKPEFUA,\r\n            We confirm the receipt of your payment of ₦13,000.00 on 16th July 2025, 01:38pm towards your loan repayment.\r\n            Transaction ID: LP1607250138333131109\r\n            Your account has been updated accordingly. Thank you for your commitment.\r\n            \r\n            If you have any questions or need a receipt, feel free to contact us\r\n\r\n            Warm regards,\r\n            Demo Microfinance Ltd\r\n            Customer Support', 0, '2025-07-16 13:38:27'),
(80, 38, 'Loan Payment Confirmation', 'Dear IKPEFUA KELLY,\r\n            We confirm the receipt of your payment of ₦100,000.00 on 16th July 2025, 01:48pm towards your loan repayment.\r\n            Transaction ID: LP160725014831201197\r\n            Your account has been updated accordingly. Thank you for your commitment.\r\n            \r\n            If you have any questions or need a receipt, feel free to contact us\r\n\r\n            Warm regards,\r\n            Demo Microfinance Ltd\r\n            Customer Support', 0, '2025-07-16 13:48:45');

-- --------------------------------------------------------

--
-- Table structure for table `opening_balance`
--

CREATE TABLE `opening_balance` (
  `balance_id` int(11) NOT NULL,
  `ledger` int(11) NOT NULL,
  `trans_type` varchar(50) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `trx_number` varchar(50) NOT NULL,
  `trans_date` date DEFAULT NULL,
  `store` int(11) NOT NULL,
  `details` varchar(1024) NOT NULL,
  `post_date` datetime DEFAULT NULL,
  `posted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `opening_balance`
--

INSERT INTO `opening_balance` (`balance_id`, `ledger`, `trans_type`, `amount`, `trx_number`, `trans_date`, `store`, `details`, `post_date`, `posted_by`) VALUES
(24, 119, 'Debit', 500000.00, 'TR322080725100418', '2024-01-01', 1, 'Opening Balance As At &quot;01-Jan-2024&quot;', '2025-07-08 22:04:18', 1),
(25, 119, 'Debit', 500000.00, 'TR187080725103435', '2024-01-01', 1, 'Opening Balance As At &quot;01-Jan-2024&quot;', '2025-07-08 22:34:35', 1);

-- --------------------------------------------------------

--
-- Table structure for table `other_income`
--

CREATE TABLE `other_income` (
  `income_id` int(11) NOT NULL,
  `income_head` varchar(255) NOT NULL,
  `activity` varchar(50) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `details` varchar(1024) NOT NULL,
  `trx_number` varchar(50) NOT NULL,
  `post_date` datetime DEFAULT NULL,
  `posted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `other_transactions`
--

CREATE TABLE `other_transactions` (
  `trx_id` int(11) NOT NULL,
  `store` int(11) NOT NULL,
  `ledger` int(11) NOT NULL,
  `contra_ledger` int(11) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `details` varchar(1024) NOT NULL,
  `trans_type` varchar(50) NOT NULL,
  `trx_number` varchar(50) NOT NULL,
  `trans_date` date DEFAULT NULL,
  `post_date` datetime DEFAULT NULL,
  `posted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `outstanding`
--

CREATE TABLE `outstanding` (
  `id` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `post_date` datetime DEFAULT NULL,
  `posted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `sales_type` varchar(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `amount_due` decimal(12,2) NOT NULL,
  `store` int(11) NOT NULL,
  `amount_paid` decimal(12,2) NOT NULL,
  `discount` int(20) NOT NULL,
  `payment_mode` varchar(255) NOT NULL,
  `bank` int(11) NOT NULL,
  `trx_number` varchar(50) NOT NULL,
  `post_date` datetime DEFAULT NULL,
  `posted_by` int(11) NOT NULL,
  `invoice` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `production`
--

CREATE TABLE `production` (
  `product_id` int(11) NOT NULL,
  `product` int(11) NOT NULL,
  `product_number` varchar(50) DEFAULT NULL,
  `product_qty` int(11) NOT NULL,
  `raw_material` int(11) NOT NULL,
  `raw_quantity` int(11) NOT NULL,
  `unit_cost` int(11) NOT NULL,
  `store` int(11) NOT NULL,
  `posted_by` int(11) NOT NULL,
  `post_date` datetime DEFAULT NULL,
  `product_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `purchase_id` int(11) NOT NULL,
  `store` int(11) NOT NULL,
  `invoice` varchar(255) NOT NULL,
  `item` int(11) NOT NULL,
  `details` varchar(1024) NOT NULL,
  `cost_price` decimal(12,2) NOT NULL,
  `sales_price` decimal(12,2) NOT NULL,
  `vendor` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `waybill` decimal(12,2) NOT NULL,
  `trx_number` varchar(50) NOT NULL,
  `expiration_date` date NOT NULL,
  `purchase_status` int(11) NOT NULL,
  `purchase_date` datetime DEFAULT NULL,
  `posted_by` int(11) NOT NULL,
  `post_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_payments`
--

CREATE TABLE `purchase_payments` (
  `payment_id` int(11) NOT NULL,
  `vendor` int(11) NOT NULL,
  `invoice` varchar(50) NOT NULL,
  `product_cost` decimal(12,2) NOT NULL,
  `waybill` decimal(12,2) NOT NULL,
  `amount_due` decimal(12,2) NOT NULL,
  `amount_paid` decimal(12,2) NOT NULL,
  `payment_mode` varchar(20) NOT NULL,
  `store` int(11) NOT NULL,
  `trans_date` date DEFAULT NULL,
  `trx_number` varchar(50) NOT NULL,
  `posted_by` int(11) NOT NULL,
  `post_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `remove_items`
--

CREATE TABLE `remove_items` (
  `remove_id` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `store` int(11) NOT NULL,
  `previous_qty` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `removed_by` int(11) NOT NULL,
  `removed_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `remove_reasons`
--

CREATE TABLE `remove_reasons` (
  `remove_id` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `remove_reasons`
--

INSERT INTO `remove_reasons` (`remove_id`, `reason`) VALUES
(1, 'Expiration'),
(2, 'Damages'),
(3, 'Transfer');

-- --------------------------------------------------------

--
-- Table structure for table `repayments`
--

CREATE TABLE `repayments` (
  `payment_id` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `store` int(11) NOT NULL,
  `loan` int(11) NOT NULL,
  `schedule` int(11) NOT NULL,
  `amount` decimal(10,0) NOT NULL,
  `interest` decimal(10,0) NOT NULL,
  `processing_fee` decimal(10,0) NOT NULL,
  `penalty` decimal(10,2) NOT NULL,
  `payment_mode` varchar(50) NOT NULL,
  `details` text NOT NULL,
  `invoice` varchar(50) NOT NULL,
  `bank` int(11) NOT NULL,
  `posted_by` int(11) NOT NULL,
  `post_date` datetime DEFAULT NULL,
  `trx_number` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `repayments`
--

INSERT INTO `repayments` (`payment_id`, `customer`, `store`, `loan`, `schedule`, `amount`, `interest`, `processing_fee`, `penalty`, `payment_mode`, `details`, `invoice`, `bank`, `posted_by`, `post_date`, `trx_number`) VALUES
(87, 38, 1, 31, 76, 70000, 2667, 667, 0.00, 'Cash', 'Loan Repayment', 'LP080725105433111176', 0, 1, '2025-07-08 22:54:53', 'TR923080725105453'),
(88, 38, 1, 31, 77, 20000, 762, 190, 0.00, 'Cash', 'Excess from previous', 'LP080725105433111176', 0, 1, '2025-07-08 22:54:53', 'TR923080725105453'),
(89, 38, 1, 31, 77, 20000, 762, 190, 0.00, 'Cash', 'Loan Repayment', 'LP080725105501222177', 0, 1, '2025-07-08 22:55:10', 'TR159080725105510'),
(90, 38, 1, 31, 77, 30000, 1143, 286, 0.00, 'Cash', 'Loan Repayment', 'LP080725105501113177', 0, 1, '2025-07-08 22:55:36', 'TR531080725105536'),
(91, 38, 1, 31, 78, 70000, 2667, 667, 0.00, 'Cash', 'Excess from previous', 'LP080725105501113177', 0, 1, '2025-07-08 22:55:36', 'TR531080725105536'),
(92, 38, 1, 32, 79, 6067, 175, 58, 0.00, 'Cash', 'Loan Payment', 'LP090725034220101179', 0, 1, '2025-07-09 15:43:07', 'TR438090725034307'),
(93, 38, 1, 32, 80, 6067, 175, 58, 0.00, 'Cash', 'Excess from previous', 'LP090725034220101179', 0, 1, '2025-07-09 15:43:07', 'TR438090725034307'),
(94, 38, 1, 32, 81, 6067, 175, 58, 0.00, 'Cash', 'Excess from previous', 'LP090725034220101179', 0, 1, '2025-07-09 15:43:07', 'TR438090725034307'),
(95, 38, 1, 32, 82, 6067, 175, 58, 0.00, 'Cash', 'Excess from previous', 'LP090725034220101179', 0, 1, '2025-07-09 15:43:07', 'TR438090725034307'),
(96, 38, 1, 32, 83, 5733, 165, 55, 0.00, 'Cash', 'Excess from previous', 'LP090725034220101179', 0, 1, '2025-07-09 15:43:07', 'TR438090725034307'),
(97, 38, 1, 32, 83, 333, 10, 3, 0.00, 'Cash', 'Loan Repayment', 'LP090725035533003183', 0, 1, '2025-07-09 15:55:44', 'TR049090725035544'),
(98, 38, 1, 32, 84, 6067, 175, 58, 0.00, 'Cash', 'Excess from previous', 'LP090725035533003183', 0, 1, '2025-07-09 15:55:44', 'TR049090725035544'),
(99, 38, 1, 32, 85, 6067, 175, 58, 0.00, 'Cash', 'Excess from previous', 'LP090725035533003183', 0, 1, '2025-07-09 15:55:44', 'TR049090725035544'),
(100, 38, 1, 32, 86, 6067, 175, 58, 0.00, 'Cash', 'Excess from previous', 'LP090725035533003183', 0, 1, '2025-07-09 15:55:44', 'TR049090725035544'),
(101, 38, 1, 32, 87, 1467, 42, 14, 0.00, 'Cash', 'Excess from previous', 'LP090725035533003183', 0, 1, '2025-07-09 15:55:44', 'TR049090725035544'),
(102, 38, 1, 32, 87, 4600, 133, 44, 0.00, 'Transfer', 'Loan Repayment', 'LP090725035910320187', 11, 1, '2025-07-09 15:59:43', 'TR391090725035943'),
(103, 38, 1, 32, 88, 5400, 156, 52, 0.00, 'Transfer', 'Excess from previous', 'LP090725035910320187', 11, 1, '2025-07-09 15:59:43', 'TR391090725035943'),
(104, 38, 1, 32, 88, 667, 19, 6, 0.00, 'Transfer', 'Jj', 'LP090725040122022188', 11, 1, '2025-07-09 16:01:40', 'TR335090725040140'),
(105, 38, 1, 32, 89, 6067, 175, 58, 0.00, 'Transfer', 'Excess from previous', 'LP090725040122022188', 11, 1, '2025-07-09 16:01:40', 'TR335090725040140'),
(106, 38, 1, 32, 90, 6067, 175, 58, 0.00, 'Transfer', 'Excess from previous', 'LP090725040122022188', 11, 1, '2025-07-09 16:01:40', 'TR335090725040140'),
(107, 38, 1, 33, 91, 60000, 2286, 571, 0.00, 'Cash', 'Loan Payment', 'LP1107250716211111591', 0, 15, '2025-07-11 07:16:55', 'TR488110725071655'),
(108, 44, 1, 34, 94, 12000, 457, 114, 0.00, 'Cash', 'Loll', 'LP1107250717121211594', 0, 15, '2025-07-11 07:18:16', 'TR054110725071816'),
(109, 38, 1, 33, 91, 27500, 1048, 262, 0.00, 'Transfer', 'Payment', 'LP110725072610003191', 9, 1, '2025-07-11 07:26:23', 'TR919110725072623'),
(110, 38, 1, 33, 92, 7500, 286, 71, 0.00, 'Transfer', 'Excess from previous', 'LP110725072610003191', 9, 1, '2025-07-11 07:26:23', 'TR919110725072623'),
(111, 38, 1, 33, 92, 80000, 3048, 762, 0.00, 'Cash', 'Nna', 'LP1107250739213011592', 0, 15, '2025-07-11 07:39:38', 'TR212110725073938'),
(112, 38, 1, 33, 93, 87500, 3333, 833, 0.00, 'Cash', 'Loan Repayment', 'LP110725123732000193', 0, 1, '2025-07-11 12:37:58', 'TR038110725123758'),
(113, 38, 1, 37, 97, 50000, 2336, 935, 0.00, 'Cash', 'Payment For Loan', 'LP140725094820211197', 0, 1, '2025-07-14 09:48:52', 'TR061140725094852'),
(114, 44, 1, 34, 94, 93000, 3543, 886, 0.00, 'Transfer', 'Payment For Loan', 'LP1507250715023201594', 11, 15, '2025-07-15 07:15:31', 'TR661150725071531'),
(115, 44, 1, 34, 95, 7000, 267, 67, 0.00, 'Transfer', 'Excess from previous', 'LP1507250715023201594', 11, 15, '2025-07-15 07:15:31', 'TR661150725071531'),
(116, 45, 1, 38, 109, 13000, 375, 125, 0.00, 'Transfer', 'Payment For Loan', 'LP1607250138333131109', 11, 1, '2025-07-16 13:38:27', 'TR137160725013827'),
(117, 38, 1, 37, 97, 12417, 580, 232, 0.00, 'Cash', 'Loan Repyment', 'LP160725014831201197', 0, 1, '2025-07-16 13:48:45', 'TR840160725014845'),
(118, 38, 1, 37, 98, 62417, 2917, 1167, 0.00, 'Cash', 'Excess from previous', 'LP160725014831201197', 0, 1, '2025-07-16 13:48:45', 'TR840160725014845'),
(119, 38, 1, 37, 99, 25167, 1176, 470, 0.00, 'Cash', 'Excess from previous', 'LP160725014831201197', 0, 1, '2025-07-16 13:48:45', 'TR840160725014845');

-- --------------------------------------------------------

--
-- Table structure for table `repayment_schedule`
--

CREATE TABLE `repayment_schedule` (
  `repayment_id` int(11) NOT NULL,
  `loan` int(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `amount_due` decimal(10,2) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `penalty` decimal(10,2) NOT NULL,
  `store` int(11) NOT NULL,
  `due_date` date DEFAULT NULL,
  `payment_status` int(11) NOT NULL,
  `post_date` datetime DEFAULT NULL,
  `posted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `repayment_schedule`
--

INSERT INTO `repayment_schedule` (`repayment_id`, `loan`, `customer`, `amount_due`, `amount_paid`, `penalty`, `store`, `due_date`, `payment_status`, `post_date`, `posted_by`) VALUES
(76, 31, 38, 70000.00, 70000.00, 0.00, 1, '2025-08-08', 1, '2025-07-08 22:54:17', 1),
(77, 31, 38, 70000.00, 70000.00, 0.00, 1, '2025-09-08', 1, '2025-07-08 22:54:17', 1),
(78, 31, 38, 70000.00, 70000.00, 0.00, 1, '2025-10-08', 1, '2025-07-08 22:54:17', 1),
(79, 32, 38, 6066.67, 6066.67, 0.00, 1, '2025-07-16', 1, '2025-07-09 10:06:57', 1),
(80, 32, 38, 6066.67, 6066.67, 0.00, 1, '2025-07-23', 1, '2025-07-09 10:06:57', 1),
(81, 32, 38, 6066.67, 6066.67, 0.00, 1, '2025-07-30', 1, '2025-07-09 10:06:57', 1),
(82, 32, 38, 6066.67, 6066.67, 0.00, 1, '2025-08-06', 1, '2025-07-09 10:06:57', 1),
(83, 32, 38, 6066.67, 6066.67, 0.00, 1, '2025-08-13', 1, '2025-07-09 10:06:57', 1),
(84, 32, 38, 6066.67, 6066.67, 0.00, 1, '2025-08-20', 1, '2025-07-09 10:06:57', 1),
(85, 32, 38, 6066.67, 6066.67, 0.00, 1, '2025-08-27', 1, '2025-07-09 10:06:57', 1),
(86, 32, 38, 6066.67, 6066.67, 0.00, 1, '2025-09-03', 1, '2025-07-09 10:06:57', 1),
(87, 32, 38, 6066.67, 6066.67, 0.00, 1, '2025-09-10', 1, '2025-07-09 10:06:57', 1),
(88, 32, 38, 6066.67, 6066.67, 0.00, 1, '2025-09-17', 1, '2025-07-09 10:06:57', 1),
(89, 32, 38, 6066.67, 6066.67, 0.00, 1, '2025-09-24', 1, '2025-07-09 10:06:57', 1),
(90, 32, 38, 6066.67, 6066.67, 0.00, 1, '2025-10-01', 1, '2025-07-09 10:06:57', 1),
(91, 33, 38, 87500.00, 87500.00, 0.00, 1, '2025-08-10', 1, '2025-07-10 08:11:56', 1),
(92, 33, 38, 87500.00, 87500.00, 0.00, 1, '2025-09-10', 1, '2025-07-10 08:11:56', 1),
(93, 33, 38, 87500.00, 87500.00, 0.00, 1, '2025-10-10', 1, '2025-07-10 08:11:56', 1),
(94, 34, 44, 105000.00, 105000.00, 0.00, 1, '2025-08-10', 1, '2025-07-10 08:37:29', 1),
(95, 34, 44, 105000.00, 7000.00, 0.00, 1, '2025-09-10', 0, '2025-07-10 08:37:29', 1),
(96, 34, 44, 105000.00, 0.00, 0.00, 1, '2025-10-10', 0, '2025-07-10 08:37:29', 1),
(97, 37, 38, 62416.67, 62416.67, 0.00, 1, '2025-07-18', 1, '2025-07-11 14:16:45', 1),
(98, 37, 38, 62416.67, 62416.67, 0.00, 1, '2025-07-25', 1, '2025-07-11 14:16:45', 1),
(99, 37, 38, 62416.67, 25166.66, 0.00, 1, '2025-08-01', 0, '2025-07-11 14:16:45', 1),
(100, 37, 38, 62416.67, 0.00, 0.00, 1, '2025-08-08', 0, '2025-07-11 14:16:45', 1),
(101, 37, 38, 62416.67, 0.00, 0.00, 1, '2025-08-15', 0, '2025-07-11 14:16:45', 1),
(102, 37, 38, 62416.67, 0.00, 0.00, 1, '2025-08-22', 0, '2025-07-11 14:16:45', 1),
(103, 37, 38, 62416.67, 0.00, 0.00, 1, '2025-08-29', 0, '2025-07-11 14:16:45', 1),
(104, 37, 38, 62416.67, 0.00, 0.00, 1, '2025-09-05', 0, '2025-07-11 14:16:45', 1),
(105, 37, 38, 62416.67, 0.00, 0.00, 1, '2025-09-12', 0, '2025-07-11 14:16:45', 1),
(106, 37, 38, 62416.67, 0.00, 0.00, 1, '2025-09-19', 0, '2025-07-11 14:16:45', 1),
(107, 37, 38, 62416.67, 0.00, 0.00, 1, '2025-09-26', 0, '2025-07-11 14:16:45', 1),
(108, 37, 38, 62416.67, 0.00, 0.00, 1, '2025-10-03', 0, '2025-07-11 14:16:45', 1),
(109, 38, 45, 13000.00, 13000.00, 0.00, 1, '2025-07-23', 1, '2025-07-16 12:26:58', 1),
(110, 38, 45, 13000.00, 0.00, 0.00, 1, '2025-07-30', 0, '2025-07-16 12:26:58', 1),
(111, 38, 45, 13000.00, 0.00, 0.00, 1, '2025-08-06', 0, '2025-07-16 12:26:58', 1),
(112, 38, 45, 13000.00, 0.00, 0.00, 1, '2025-08-13', 0, '2025-07-16 12:26:58', 1),
(113, 38, 45, 13000.00, 0.00, 0.00, 1, '2025-08-20', 0, '2025-07-16 12:26:58', 1),
(114, 38, 45, 13000.00, 0.00, 0.00, 1, '2025-08-27', 0, '2025-07-16 12:26:58', 1),
(115, 38, 45, 13000.00, 0.00, 0.00, 1, '2025-09-03', 0, '2025-07-16 12:26:58', 1),
(116, 38, 45, 13000.00, 0.00, 0.00, 1, '2025-09-10', 0, '2025-07-16 12:26:58', 1),
(117, 38, 45, 13000.00, 0.00, 0.00, 1, '2025-09-17', 0, '2025-07-16 12:26:58', 1),
(118, 38, 45, 13000.00, 0.00, 0.00, 1, '2025-09-24', 0, '2025-07-16 12:26:58', 1),
(119, 38, 45, 13000.00, 0.00, 0.00, 1, '2025-10-01', 0, '2025-07-16 12:26:58', 1),
(120, 38, 45, 13000.00, 0.00, 0.00, 1, '2025-10-08', 0, '2025-07-16 12:26:58', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rights`
--

CREATE TABLE `rights` (
  `right_id` int(11) NOT NULL,
  `menu` int(11) NOT NULL,
  `sub_menu` int(11) NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sales_id` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `store` int(11) NOT NULL,
  `sales_type` varchar(11) NOT NULL,
  `customer` int(11) NOT NULL,
  `invoice` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `cost` int(11) NOT NULL,
  `posted_by` int(11) NOT NULL,
  `sales_status` int(11) NOT NULL,
  `post_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_returns`
--

CREATE TABLE `sales_returns` (
  `return_id` int(11) NOT NULL,
  `invoice` varchar(255) NOT NULL,
  `store` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `reason` varchar(1024) NOT NULL,
  `returned_by` int(11) NOT NULL,
  `return_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_adjustments`
--

CREATE TABLE `stock_adjustments` (
  `adjust_id` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `store` int(11) NOT NULL,
  `adjusted_by` int(11) NOT NULL,
  `previous_qty` int(11) NOT NULL,
  `new_qty` int(11) NOT NULL,
  `adjust_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `store_id` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `store` varchar(124) NOT NULL,
  `store_address` varchar(255) NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`store_id`, `company`, `store`, `store_address`, `phone_number`, `date_created`) VALUES
(1, 1, 'Main Office', 'Demo road', '07068897068', '2025-06-06 19:54:43');

-- --------------------------------------------------------

--
-- Table structure for table `sub_menus`
--

CREATE TABLE `sub_menus` (
  `sub_menu_id` int(11) NOT NULL,
  `menu` int(11) NOT NULL,
  `sub_menu` varchar(255) NOT NULL,
  `url` varchar(50) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_menus`
--

INSERT INTO `sub_menus` (`sub_menu_id`, `menu`, `sub_menu`, `url`, `status`) VALUES
(1, 1, 'Add Users', 'add_user', 0),
(2, 1, 'Disable User', 'disable_user', 0),
(3, 1, 'Activate User', 'activate_user', 0),
(4, 1, 'Reset Password', 'reset_password', 0),
(5, 1, 'Add Category', 'add_department', 1),
(6, 1, 'Add Sub-category', 'add_category', 1),
(7, 1, 'Add Items', 'add_item', 1),
(8, 1, 'Modify Item Name', 'modify_item', 1),
(9, 1, 'Add Bank', 'add_bank', 1),
(10, 1, 'Manage Prices', 'item_price', 1),
(11, 1, 'Add Remove Reasons', 'add_remove_reasons', 1),
(12, 2, 'Direct Sales', 'direct_sales', 1),
(13, 2, 'Sales Order', 'sales_order', 1),
(14, 2, 'Post Sales Order', 'post_sales_order', 1),
(15, 2, 'Sales Return', 'sales_return', 1),
(16, 2, 'Reprint Receipt', 'print_receipt', 1),
(17, 3, 'Set Reorder Level', 'reorder_level', 1),
(18, 3, 'Product Balance', 'stock_balance', 1),
(19, 3, 'Receive Purchases', 'stockin_purchase', 0),
(20, 3, 'Add Supplier', 'add_vendor', 0),
(21, 3, 'Adjust Quantity', 'stock_adjustment', 1),
(22, 3, 'Remove Item', 'remove_item', 1),
(23, 3, 'Adjust Expiration', 'adjust_expiration', 1),
(24, 4, 'Add Expense Head', 'add_exp_head', 1),
(25, 4, 'Post Expense', 'post_expense', 0),
(26, 5, 'Item List', 'item_list', 0),
(27, 5, 'Bank List', 'bank_list', 0),
(28, 5, 'List Of Suppliers', 'vendor_list', 0),
(29, 5, 'Sales Return Report', 'sales_return_report', 1),
(30, 5, 'Stock Adjustment Report', 'stock_adjustment_report', 1),
(31, 5, 'Item Removed Report', 'item_removed_report', 1),
(33, 3, 'Purchase Reports', 'purchase_reports', 0),
(34, 5, 'Out Of Stock', 'out_of_stock', 1),
(35, 5, 'Soon To Expire', 'expire_soon', 1),
(36, 5, 'Expired Items', 'expired_items', 1),
(37, 5, 'Reached Reorder Level', 'reached_reorder', 1),
(38, 5, 'Item History', 'item_history', 1),
(39, 5, 'Purchase By Item', 'purchase_by_item', 1),
(40, 3, 'Purchase Per Vendor', 'purchase_per_vendor', 0),
(41, 6, 'Sales Report', 'revenue_report', 0),
(42, 6, 'Cash Payments', 'cash_list', 0),
(43, 6, 'POS Payments', 'pos_list', 0),
(44, 6, 'Transfer Payments', 'transfer_list', 0),
(45, 6, 'Loan Officer Report', 'cashier_report', 0),
(46, 6, 'Revenue By Category', 'revenue_by_category', 1),
(47, 6, 'Income Statement', 'profit_and_loss', 0),
(48, 6, 'Expense Report', 'expense_report', 0),
(49, 5, 'Highest Selling Items', 'highest_selling', 1),
(50, 5, 'Fast Selling Items', 'fast_selling', 1),
(51, 1, 'Change Category', 'change_category', 1),
(52, 1, 'Update Item Barcode', 'update_barcode', 1),
(53, 3, 'Transfer Items', 'transfer_item', 1),
(54, 3, 'Pending Transfer', 'pending_transfer', 1),
(55, 3, 'Accept Items', 'accept_items', 1),
(56, 3, 'Returned Transfer', 'returned_transfer', 1),
(57, 5, 'Transferred Items Report', 'transfer_report', 1),
(58, 5, 'Accept Items Report', 'accept_report', 1),
(59, 3, 'All Store Balance', 'all_store_balance', 1),
(60, 2, 'Wholesale', 'wholesale', 1),
(62, 11, 'Add New Client', 'add_customer', 0),
(63, 11, 'Customer List', 'customer_list', 0),
(64, 6, 'Retail Sales', 'retail_sales', 1),
(65, 6, 'Wholesale Report', 'wholesale_report', 1),
(66, 6, 'Customer Statement', 'customer_statement', 0),
(67, 6, 'Credit Sales List', 'credit_sales_list', 1),
(68, 6, 'Debtors Report', 'debtors_list', 0),
(69, 4, 'Pay Debt', 'pay_debt', 1),
(70, 6, 'Debt Payment Report', 'debt_payment_report', 1),
(71, 1, 'Add Menu', 'add_menu', 1),
(72, 1, 'Add Sub-menu', 'add_sub_menu', 1),
(73, 1, 'Edit Sub Menu', 'edit_sub_menu', 1),
(74, 1, 'Manage Profile', 'manage_profile', 1),
(75, 1, 'Add Store', 'add_store', 1),
(76, 1, 'Update Store Details', 'update_store', 0),
(77, 1, 'Add User Rights', 'add_rights', 1),
(78, 1, 'Delete Rights', 'delete_right', 1),
(79, 11, 'Edit Customer Info', 'edit_customer_info', 0),
(80, 4, 'Customer Payments', 'fund_wallet', 0),
(81, 4, 'Reverse Deposit', 'reverse_deposit', 1),
(82, 1, 'Adjust Expiration', 'adjust_expiration', 1),
(83, 3, 'Transfer Qty Btw Items', 'transfer_qty', 1),
(85, 5, 'List Of Users', 'user_list', 0),
(86, 3, 'Reprint Transfer Receipt', 'reprint_transfer', 1),
(87, 1, 'Give Rights', 'give_user_right', 0),
(89, 1, 'Manage Cost Price', 'raw_material_price', 1),
(90, 3, 'Stock Balance', 'raw_material_balance', 1),
(91, 5, 'Raw Materials', 'raw_material_list', 1),
(94, 5, 'Production Report', 'production_report', 1),
(96, 2, 'Make Sales', 'wholesale', 1),
(97, 5, 'Production Statistics', 'production_statistics', 1),
(98, 3, 'Consumables', 'consumables', 1),
(99, 3, 'Issue Items', 'issue_items', 1),
(100, 5, 'Issued Items Report', 'issue_report', 1),
(101, 3, 'Pending Issued Items', 'pending_issued', 1),
(102, 5, 'Issued Item History', 'issued_item_stats', 1),
(103, 4, 'Reverse Transactions', 'reverse_transactions', 0),
(104, 6, 'Customer Payments', 'deposit_report', 0),
(105, 4, 'Post Previous Debt', 'post_debt', 1),
(106, 4, 'Post Purchases', 'post_purchase', 0),
(107, 4, 'Vendor Payments', 'post_vendor_payments', 0),
(108, 6, 'Vendor Payment Report', 'vendor_payments', 0),
(109, 6, 'Vendor Statement', 'vendor_statement', 0),
(110, 4, 'Post Vendor Balance', 'post_vendor_balance', 1),
(111, 5, 'Transfer Qty Bwt Reports', 'transfer_qty_btw_reports', 1),
(113, 5, 'Ice Cream Productions', 'ice_cream_production', 1),
(114, 6, 'Outstanding Debts Posting', 'outstanding_debts', 1),
(115, 11, 'Merge Customer Files', 'merge_files', 0),
(116, 8, 'New Invoice', 'invoicing', 0),
(117, 8, 'View Invoices', 'invoice_reports', 0),
(118, 8, 'Pending Invoice', 'pending_invoice', 0),
(119, 10, 'Account Group', 'account_group', 0),
(120, 10, 'Account Sub-group', 'account_sub_group', 0),
(121, 10, 'Account Class', 'account_class', 0),
(122, 10, 'Account Ledgers', 'account_ledger', 0),
(123, 10, 'View Chart Of Account', 'chart_of_account', 0),
(124, 9, 'Add Asset Location', 'add_asset_location', 0),
(125, 9, 'Add New Asset', 'add_asset', 0),
(126, 9, 'Asset Register', 'asset_register', 0),
(127, 9, 'Allocate Asset', 'allocate_asset', 0),
(128, 9, 'View Disposed Assets', 'disposed_assets', 0),
(129, 9, 'Dispose Asset', 'dispose_asset', 0),
(130, 9, 'Setup Depreciation', 'setup_depreciation', 1),
(131, 6, 'Trial Balance', 'trial_balance', 0),
(132, 4, 'Post Fixed Asset', 'post_fixed_asset', 0),
(133, 4, 'Post Depreciation', 'post_depreciation', 0),
(134, 6, 'Asset Postings', 'asset_posting', 0),
(135, 6, 'Depreciation Report', 'depreciation_report', 0),
(136, 6, 'Monthly Financial Position', 'monthly_financial_position', 0),
(137, 6, 'Yearly Financial Position', 'yearly_financial_position', 0),
(138, 6, 'Cash Flow', 'cash_flow', 0),
(139, 6, 'Account Statement', 'account_statement', 0),
(140, 4, 'Post Other Transactions', 'post_other_trx', 0),
(141, 6, 'Loans Received', 'loans', 0),
(142, 6, 'Loan Transactions', 'loan_postings', 0),
(143, 6, 'Director Transactions', 'director_postings', 0),
(144, 6, 'FInance Costs Trx', 'other_postings', 0),
(145, 4, 'Post Opening Balance', 'post_opening_balance', 0),
(146, 9, 'Delete Asset', 'delete_asset', 0),
(147, 8, 'Invoices Due', 'invoices_due', 0),
(148, 6, 'Inventory Postings', 'inventory_posting', 0),
(149, 6, 'Yearly Income Statement', 'yearly_income_statement', 0),
(150, 6, 'Other Transactions', 'other_transactions', 0),
(151, 10, 'Update Ledger', 'update_ledger', 0),
(152, 11, 'Verify Kyc', 'verify_kyc', 0),
(153, 12, 'Update Details', 'update_my_details', 1),
(154, 12, 'Upload Kyc', 'upload_kyc', 1),
(155, 12, 'Update Photo', 'update_my_photo', 1),
(157, 13, 'Loan Products', 'loan_products', 0),
(158, 12, 'Apply For A Loan', 'apply_loan', 1),
(159, 13, 'Apply For A Loan', 'apply_loan_customer', 0),
(160, 12, 'Loan Status', 'loan_status', 1),
(161, 13, 'Pending Applications', 'pending_applications', 0),
(162, 12, 'Upload Documents', 'upload_documents', 1),
(163, 12, 'Guarantors', 'guarantors', 1),
(164, 13, 'Disburse Loan', 'pending_disbursement', 0),
(165, 13, 'Upload Document', 'client_document_upload', 0),
(166, 11, 'Guarantors', 'client_guarantors', 0),
(167, 13, 'Active Loans', 'active_loans', 0),
(168, 12, 'Post Payment', 'post_payment', 1),
(169, 13, 'Loan Repayment', 'loan_repayment', 0),
(170, 6, 'Loan Disbursements', 'disbursement_report', 0),
(171, 13, 'Payments Due', 'invoices_due', 0),
(172, 11, 'Add Kyc', 'add_client_kyc', 0),
(173, 12, 'Transaction Hisory', 'trx_history', 0),
(174, 12, 'Loan History', 'loan_history', 0),
(175, 6, 'Loan Summary', 'loan_summary', 0);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `account_type` int(11) NOT NULL,
  `sub_group` int(11) NOT NULL,
  `class` int(11) NOT NULL,
  `account` int(50) NOT NULL,
  `debit` decimal(12,2) NOT NULL,
  `credit` decimal(12,2) NOT NULL,
  `trx_number` varchar(50) NOT NULL,
  `details` varchar(1024) NOT NULL,
  `trx_status` int(11) NOT NULL,
  `trans_date` date DEFAULT NULL,
  `post_date` datetime DEFAULT NULL,
  `posted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `account_type`, `sub_group`, `class`, `account`, `debit`, `credit`, `trx_number`, `details`, `trx_status`, `trans_date`, `post_date`, `posted_by`) VALUES
(1481, 1, 1, 0, 10101119, 500000.00, 0.00, 'TR187080725103435', 'Opening Balance As At &quot;01-Jan-2024&quot;', 1, '2024-01-01', '2025-07-08 22:34:35', 1),
(1496, 1, 1, 4, 10104122, 200000.00, 0.00, 'TR970080725105417', 'Loan Disbursement toIKPEFUA KELLY', 0, '2025-07-08', '2025-07-08 22:54:17', 1),
(1497, 1, 1, 1, 10101119, 0.00, 200000.00, 'TR970080725105417', 'Loan Disbursement toIKPEFUA KELLY', 0, '2025-07-08', '2025-07-08 22:54:17', 1),
(1498, 1, 1, 2, 1010228, 90000.00, 0.00, 'TR923080725105453', 'Loan Repayment', 0, '2025-07-08', '2025-07-08 22:54:53', 1),
(1499, 1, 1, 4, 10104122, 0.00, 85714.29, 'TR923080725105453', 'Loan Repayment', 0, '2025-07-08', '2025-07-08 22:54:53', 1),
(1500, 3, 5, 19, 305019129, 0.00, 3428.57, 'TR923080725105453', 'Interest from Loan Repayment', 0, '2025-07-08', '2025-07-08 22:54:53', 1),
(1501, 3, 5, 19, 305019130, 0.00, 857.14, 'TR923080725105453', 'Processing fee from Loan Repayment', 0, '2025-07-08', '2025-07-08 22:54:53', 1),
(1502, 1, 1, 2, 1010228, 20000.00, 0.00, 'TR159080725105510', 'Loan Repayment', 0, '2025-07-08', '2025-07-08 22:55:10', 1),
(1503, 1, 1, 4, 10104122, 0.00, 19047.62, 'TR159080725105510', 'Loan Repayment', 0, '2025-07-08', '2025-07-08 22:55:10', 1),
(1504, 3, 5, 19, 305019129, 0.00, 761.90, 'TR159080725105510', 'Interest from Loan Repayment', 0, '2025-07-08', '2025-07-08 22:55:10', 1),
(1505, 3, 5, 19, 305019130, 0.00, 190.48, 'TR159080725105510', 'Processing fee from Loan Repayment', 0, '2025-07-08', '2025-07-08 22:55:10', 1),
(1506, 1, 1, 2, 1010228, 100000.00, 0.00, 'TR531080725105536', 'Loan Repayment', 0, '2025-07-08', '2025-07-08 22:55:36', 1),
(1507, 1, 1, 4, 10104122, 0.00, 95238.10, 'TR531080725105536', 'Loan Repayment', 0, '2025-07-08', '2025-07-08 22:55:36', 1),
(1508, 3, 5, 19, 305019129, 0.00, 3809.52, 'TR531080725105536', 'Interest from Loan Repayment', 0, '2025-07-08', '2025-07-08 22:55:36', 1),
(1509, 3, 5, 19, 305019130, 0.00, 952.38, 'TR531080725105536', 'Processing fee from Loan Repayment', 0, '2025-07-08', '2025-07-08 22:55:36', 1),
(1510, 1, 1, 4, 10104122, 70000.00, 0.00, 'TR493090725100657', 'Loan Disbursement to IKPEFUA KELLY', 0, '2025-07-09', '2025-07-09 10:06:57', 1),
(1511, 1, 1, 2, 1010228, 0.00, 70000.00, 'TR493090725100657', 'Loan Disbursement toIKPEFUA KELLY', 0, '2025-07-09', '2025-07-09 10:06:57', 1),
(1512, 1, 1, 2, 1010228, 30000.00, 0.00, 'TR438090725034307', 'Loan Repayment', 0, '2025-07-09', '2025-07-09 15:43:07', 1),
(1513, 1, 1, 4, 10104122, 0.00, 28846.16, 'TR438090725034307', 'Loan Repayment', 0, '2025-07-09', '2025-07-09 15:43:07', 1),
(1514, 3, 5, 19, 305019129, 0.00, 865.38, 'TR438090725034307', 'Interest from Loan Repayment', 0, '2025-07-09', '2025-07-09 15:43:07', 1),
(1515, 3, 5, 19, 305019130, 0.00, 288.46, 'TR438090725034307', 'Processing fee from Loan Repayment', 0, '2025-07-09', '2025-07-09 15:43:07', 1),
(1516, 1, 1, 2, 1010228, 20000.00, 0.00, 'TR049090725035544', 'Loan Repayment', 0, '2025-07-09', '2025-07-09 15:55:44', 1),
(1517, 1, 1, 4, 10104122, 0.00, 19230.77, 'TR049090725035544', 'Loan Repayment', 0, '2025-07-09', '2025-07-09 15:55:44', 1),
(1518, 3, 5, 19, 305019129, 0.00, 576.92, 'TR049090725035544', 'Interest from Loan Repayment', 0, '2025-07-09', '2025-07-09 15:55:44', 1),
(1519, 3, 5, 19, 305019130, 0.00, 192.31, 'TR049090725035544', 'Processing fee from Loan Repayment', 0, '2025-07-09', '2025-07-09 15:55:44', 1),
(1520, 1, 1, 1, 10101119, 10000.00, 0.00, 'TR391090725035943', 'Loan Repayment', 0, '2025-07-09', '2025-07-09 15:59:43', 1),
(1521, 1, 1, 4, 10104122, 0.00, 9615.39, 'TR391090725035943', 'Loan Repayment', 0, '2025-07-09', '2025-07-09 15:59:43', 1),
(1522, 3, 5, 19, 305019129, 0.00, 288.46, 'TR391090725035943', 'Interest from Loan Repayment', 0, '2025-07-09', '2025-07-09 15:59:43', 1),
(1523, 3, 5, 19, 305019130, 0.00, 96.15, 'TR391090725035943', 'Processing fee from Loan Repayment', 0, '2025-07-09', '2025-07-09 15:59:43', 1),
(1524, 1, 1, 1, 10101119, 12800.04, 0.00, 'TR335090725040140', 'Loan Repayment', 0, '2025-07-09', '2025-07-09 16:01:40', 1),
(1525, 1, 1, 4, 10104122, 0.00, 12307.73, 'TR335090725040140', 'Loan Repayment', 0, '2025-07-09', '2025-07-09 16:01:40', 1),
(1526, 3, 5, 19, 305019129, 0.00, 369.23, 'TR335090725040140', 'Interest from Loan Repayment', 0, '2025-07-09', '2025-07-09 16:01:40', 1),
(1527, 3, 5, 19, 305019130, 0.00, 123.08, 'TR335090725040140', 'Processing fee from Loan Repayment', 0, '2025-07-09', '2025-07-09 16:01:40', 1),
(1528, 1, 1, 4, 10104122, 250000.00, 0.00, 'TR971100725081156', 'Loan Disbursement to IKPEFUA KELLY', 0, '2025-07-10', '2025-07-10 08:11:56', 1),
(1529, 1, 1, 2, 1010228, 0.00, 250000.00, 'TR971100725081156', 'Loan Disbursement toIKPEFUA KELLY', 0, '2025-07-10', '2025-07-10 08:11:56', 1),
(1530, 1, 1, 4, 10104128, 300000.00, 0.00, 'TR331100725083729', 'Loan Disbursement to AKPABIA GOODLUCK', 0, '2025-07-10', '2025-07-10 08:37:29', 1),
(1531, 1, 1, 1, 10101119, 0.00, 300000.00, 'TR331100725083729', 'Loan Disbursement toAKPABIA GOODLUCK', 0, '2025-07-10', '2025-07-10 08:37:29', 1),
(1532, 1, 1, 2, 1010228, 60000.00, 0.00, 'TR488110725071655', 'Loan Repayment', 0, '2025-07-11', '2025-07-11 07:16:55', 15),
(1533, 1, 1, 4, 10104122, 0.00, 57142.86, 'TR488110725071655', 'Loan Repayment', 0, '2025-07-11', '2025-07-11 07:16:55', 15),
(1534, 3, 5, 19, 305019129, 0.00, 2285.71, 'TR488110725071655', 'Interest from Loan Repayment', 0, '2025-07-11', '2025-07-11 07:16:55', 15),
(1535, 3, 5, 19, 305019130, 0.00, 571.43, 'TR488110725071655', 'Processing fee from Loan Repayment', 0, '2025-07-11', '2025-07-11 07:16:55', 15),
(1536, 1, 1, 2, 1010228, 12000.00, 0.00, 'TR054110725071816', 'Loan Repayment', 0, '2025-07-11', '2025-07-11 07:18:16', 15),
(1537, 1, 1, 4, 10104128, 0.00, 11428.57, 'TR054110725071816', 'Loan Repayment', 0, '2025-07-11', '2025-07-11 07:18:16', 15),
(1538, 3, 5, 19, 305019129, 0.00, 457.14, 'TR054110725071816', 'Interest from Loan Repayment', 0, '2025-07-11', '2025-07-11 07:18:16', 15),
(1539, 3, 5, 19, 305019130, 0.00, 114.29, 'TR054110725071816', 'Processing fee from Loan Repayment', 0, '2025-07-11', '2025-07-11 07:18:16', 15),
(1540, 1, 1, 1, 1010153, 35000.00, 0.00, 'TR919110725072623', 'Loan Repayment', 0, '2025-07-11', '2025-07-11 07:26:23', 1),
(1541, 1, 1, 4, 10104122, 0.00, 33333.34, 'TR919110725072623', 'Loan Repayment', 0, '2025-07-11', '2025-07-11 07:26:23', 1),
(1542, 3, 5, 19, 305019129, 0.00, 1333.33, 'TR919110725072623', 'Interest from Loan Repayment', 0, '2025-07-11', '2025-07-11 07:26:23', 1),
(1543, 3, 5, 19, 305019130, 0.00, 333.33, 'TR919110725072623', 'Processing fee from Loan Repayment', 0, '2025-07-11', '2025-07-11 07:26:23', 1),
(1544, 1, 1, 2, 1010228, 80000.00, 0.00, 'TR212110725073938', 'Loan Repayment', 0, '2025-07-11', '2025-07-11 07:39:38', 15),
(1545, 1, 1, 4, 10104122, 0.00, 76190.48, 'TR212110725073938', 'Loan Repayment', 0, '2025-07-11', '2025-07-11 07:39:38', 15),
(1546, 3, 5, 19, 305019129, 0.00, 3047.62, 'TR212110725073938', 'Interest from Loan Repayment', 0, '2025-07-11', '2025-07-11 07:39:38', 15),
(1547, 3, 5, 19, 305019130, 0.00, 761.90, 'TR212110725073938', 'Processing fee from Loan Repayment', 0, '2025-07-11', '2025-07-11 07:39:38', 15),
(1548, 1, 1, 2, 1010228, 87500.00, 0.00, 'TR038110725123758', 'Loan Repayment', 0, '2025-07-11', '2025-07-11 12:37:58', 1),
(1549, 1, 1, 4, 10104122, 0.00, 83333.34, 'TR038110725123758', 'Loan Repayment', 0, '2025-07-11', '2025-07-11 12:37:58', 1),
(1550, 3, 5, 19, 305019129, 0.00, 3333.33, 'TR038110725123758', 'Interest from Loan Repayment', 0, '2025-07-11', '2025-07-11 12:37:58', 1),
(1551, 3, 5, 19, 305019130, 0.00, 833.33, 'TR038110725123758', 'Processing fee from Loan Repayment', 0, '2025-07-11', '2025-07-11 12:37:58', 1),
(1552, 1, 1, 4, 10104122, 700000.00, 0.00, 'TR500110725021645', 'Loan Disbursement to IKPEFUA KELLY', 0, '2025-07-11', '2025-07-11 14:16:45', 1),
(1553, 1, 1, 2, 1010228, 0.00, 700000.00, 'TR500110725021645', 'Loan Disbursement toIKPEFUA KELLY', 0, '2025-07-11', '2025-07-11 14:16:45', 1),
(1554, 1, 1, 2, 1010228, 50000.00, 0.00, 'TR061140725094852', 'Loan Repayment', 0, '2025-07-14', '2025-07-14 09:48:52', 1),
(1555, 1, 1, 4, 10104122, 0.00, 46728.97, 'TR061140725094852', 'Loan Repayment', 0, '2025-07-14', '2025-07-14 09:48:52', 1),
(1556, 3, 5, 19, 305019129, 0.00, 2336.45, 'TR061140725094852', 'Interest from Loan Repayment', 0, '2025-07-14', '2025-07-14 09:48:52', 1),
(1557, 3, 5, 19, 305019130, 0.00, 934.58, 'TR061140725094852', 'Processing fee from Loan Repayment', 0, '2025-07-14', '2025-07-14 09:48:52', 1),
(1558, 1, 1, 1, 10101119, 100000.00, 0.00, 'TR661150725071531', 'Loan Repayment', 0, '2025-07-15', '2025-07-15 07:15:31', 15),
(1559, 1, 1, 4, 10104128, 0.00, 95238.10, 'TR661150725071531', 'Loan Repayment', 0, '2025-07-15', '2025-07-15 07:15:31', 15),
(1560, 3, 5, 19, 305019129, 0.00, 3809.52, 'TR661150725071531', 'Interest from Loan Repayment', 0, '2025-07-15', '2025-07-15 07:15:31', 15),
(1561, 3, 5, 19, 305019130, 0.00, 952.38, 'TR661150725071531', 'Processing fee from Loan Repayment', 0, '2025-07-15', '2025-07-15 07:15:31', 15),
(1562, 1, 1, 4, 10104131, 150000.00, 0.00, 'TR938160725122658', 'Loan Disbursement to DORCAS IKPEFUA', 0, '2025-07-16', '2025-07-16 12:26:58', 1),
(1563, 1, 1, 1, 10101119, 0.00, 150000.00, 'TR938160725122658', 'Loan Disbursement toDORCAS IKPEFUA', 0, '2025-07-16', '2025-07-16 12:26:58', 1),
(1564, 1, 1, 1, 10101119, 13000.00, 0.00, 'TR137160725013827', 'Loan Repayment', 0, '2025-07-16', '2025-07-16 13:38:27', 1),
(1565, 1, 1, 4, 10104131, 0.00, 12500.00, 'TR137160725013827', 'Loan Repayment', 0, '2025-07-16', '2025-07-16 13:38:27', 1),
(1566, 3, 5, 19, 305019129, 0.00, 375.00, 'TR137160725013827', 'Interest from Loan Repayment', 0, '2025-07-16', '2025-07-16 13:38:27', 1),
(1567, 3, 5, 19, 305019130, 0.00, 125.00, 'TR137160725013827', 'Processing fee from Loan Repayment', 0, '2025-07-16', '2025-07-16 13:38:27', 1),
(1568, 1, 1, 2, 1010228, 100000.00, 0.00, 'TR840160725014845', 'Loan Repayment', 0, '2025-07-16', '2025-07-16 13:48:45', 1),
(1569, 1, 1, 4, 10104122, 0.00, 93457.94, 'TR840160725014845', 'Loan Repayment', 0, '2025-07-16', '2025-07-16 13:48:45', 1),
(1570, 3, 5, 19, 305019129, 0.00, 4672.90, 'TR840160725014845', 'Interest from Loan Repayment', 0, '2025-07-16', '2025-07-16 13:48:45', 1),
(1571, 3, 5, 19, 305019130, 0.00, 1869.16, 'TR840160725014845', 'Processing fee from Loan Repayment', 0, '2025-07-16', '2025-07-16 13:48:45', 1);

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

CREATE TABLE `transfers` (
  `transfer_id` int(11) NOT NULL,
  `item` int(11) NOT NULL,
  `from_store` int(11) NOT NULL,
  `to_store` int(11) NOT NULL,
  `invoice` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `cost_price` int(11) NOT NULL,
  `sales_price` int(11) NOT NULL,
  `expiration` date NOT NULL,
  `transfer_status` int(11) NOT NULL,
  `posted_by` int(11) NOT NULL,
  `accept_by` int(11) NOT NULL,
  `post_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(1024) NOT NULL,
  `username` varchar(255) NOT NULL,
  `user_role` varchar(255) NOT NULL,
  `user_password` varchar(1024) NOT NULL,
  `status` int(11) NOT NULL,
  `store` int(11) NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `username`, `user_role`, `user_password`, `status`, `store`, `reg_date`) VALUES
(1, 'Administrator', 'Sysadmin', 'Admin', '$2y$10$dcUrnR/.PvfK7XeYcP60hOyW2qnPSSvEq/Wxee6lv5DETW8pbGXYu', 0, 1, '2022-09-27 13:47:21'),
(2, 'Admin', 'Admin', 'Admin', '$2y$10$Zg86mlW4zi3KoTPoKw1fpefZbkEH7MhhrAqQz.njT0gEtX0uvXUra', 0, 1, '2024-09-13 10:48:06'),
(8, 'IKPEFUA KELLY', '07068897068', 'Client', '$2y$10$XmlBV8k.A7XRVkuG.Ipq6Ojr1sq8uTbBUmYceMFPXcTfpLgiosMkK', 0, 1, '2025-06-09 14:21:04'),
(14, 'AKPABIA GOODLUCK', '09012345678', 'Client', '123', 0, 1, '2025-07-05 10:22:29'),
(15, 'ONOSTAR SENPAI', 'Onostar', 'Loan Officer', '$2y$10$VbNGx1cPZwlD2EgoVhLZYugQ7clziWf3QnsmMGyH8f.3haOPy3tRu', 0, 1, '2025-07-10 09:20:38'),
(16, 'DORCAS IKPEFUA', '08100653703', 'Client', '123', 0, 1, '2025-07-16 11:42:25');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `vendor_id` int(11) NOT NULL,
  `vendor` varchar(1024) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `balance` int(11) NOT NULL,
  `account_no` int(50) NOT NULL,
  `ledger_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `waybills`
--

CREATE TABLE `waybills` (
  `waybill_id` int(11) NOT NULL,
  `invoice` varchar(50) NOT NULL,
  `vendor` int(11) NOT NULL,
  `invoice_amount` decimal(12,2) NOT NULL,
  `waybill` decimal(12,2) NOT NULL,
  `trx_number` varchar(50) NOT NULL,
  `store` int(11) NOT NULL,
  `post_date` datetime DEFAULT NULL,
  `posted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_class`
--
ALTER TABLE `account_class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `account_groups`
--
ALTER TABLE `account_groups`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `account_sub_groups`
--
ALTER TABLE `account_sub_groups`
  ADD PRIMARY KEY (`sub_group_id`);

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`asset_id`);

--
-- Indexes for table `asset_locations`
--
ALTER TABLE `asset_locations`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `asset_postings`
--
ALTER TABLE `asset_postings`
  ADD PRIMARY KEY (`asset_id`);

--
-- Indexes for table `audit_trail`
--
ALTER TABLE `audit_trail`
  ADD PRIMARY KEY (`audit_id`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`bank_id`);

--
-- Indexes for table `cash_flows`
--
ALTER TABLE `cash_flows`
  ADD PRIMARY KEY (`flow_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `cost_of_sales`
--
ALTER TABLE `cost_of_sales`
  ADD PRIMARY KEY (`cost_of_sales_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `customer_trail`
--
ALTER TABLE `customer_trail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `debtors`
--
ALTER TABLE `debtors`
  ADD PRIMARY KEY (`debtor_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`deposit_id`);

--
-- Indexes for table `depreciation`
--
ALTER TABLE `depreciation`
  ADD PRIMARY KEY (`depreciation_id`);

--
-- Indexes for table `director_posting`
--
ALTER TABLE `director_posting`
  ADD PRIMARY KEY (`director_id`);

--
-- Indexes for table `disbursal`
--
ALTER TABLE `disbursal`
  ADD PRIMARY KEY (`disbursal_id`);

--
-- Indexes for table `disposed_assets`
--
ALTER TABLE `disposed_assets`
  ADD PRIMARY KEY (`disposed_id`);

--
-- Indexes for table `document_uploads`
--
ALTER TABLE `document_uploads`
  ADD PRIMARY KEY (`document_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expense_id`);

--
-- Indexes for table `expense_heads`
--
ALTER TABLE `expense_heads`
  ADD PRIMARY KEY (`exp_head_id`);

--
-- Indexes for table `finance_cost`
--
ALTER TABLE `finance_cost`
  ADD PRIMARY KEY (`finance_id`);

--
-- Indexes for table `guarantors`
--
ALTER TABLE `guarantors`
  ADD PRIMARY KEY (`guarantor_id`);

--
-- Indexes for table `info_request`
--
ALTER TABLE `info_request`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`inventory_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `issue_items`
--
ALTER TABLE `issue_items`
  ADD PRIMARY KEY (`issue_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `item_transfers`
--
ALTER TABLE `item_transfers`
  ADD PRIMARY KEY (`transfer_id`);

--
-- Indexes for table `kyc`
--
ALTER TABLE `kyc`
  ADD PRIMARY KEY (`kyc_id`);

--
-- Indexes for table `ledgers`
--
ALTER TABLE `ledgers`
  ADD PRIMARY KEY (`ledger_id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`loan_id`);

--
-- Indexes for table `loan_applications`
--
ALTER TABLE `loan_applications`
  ADD PRIMARY KEY (`loan_id`);

--
-- Indexes for table `loan_products`
--
ALTER TABLE `loan_products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `multiple_payments`
--
ALTER TABLE `multiple_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `opening_balance`
--
ALTER TABLE `opening_balance`
  ADD PRIMARY KEY (`balance_id`);

--
-- Indexes for table `other_income`
--
ALTER TABLE `other_income`
  ADD PRIMARY KEY (`income_id`);

--
-- Indexes for table `other_transactions`
--
ALTER TABLE `other_transactions`
  ADD PRIMARY KEY (`trx_id`);

--
-- Indexes for table `outstanding`
--
ALTER TABLE `outstanding`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `production`
--
ALTER TABLE `production`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`purchase_id`);

--
-- Indexes for table `purchase_payments`
--
ALTER TABLE `purchase_payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `remove_items`
--
ALTER TABLE `remove_items`
  ADD PRIMARY KEY (`remove_id`);

--
-- Indexes for table `remove_reasons`
--
ALTER TABLE `remove_reasons`
  ADD PRIMARY KEY (`remove_id`);

--
-- Indexes for table `repayments`
--
ALTER TABLE `repayments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `repayment_schedule`
--
ALTER TABLE `repayment_schedule`
  ADD PRIMARY KEY (`repayment_id`);

--
-- Indexes for table `rights`
--
ALTER TABLE `rights`
  ADD PRIMARY KEY (`right_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sales_id`);

--
-- Indexes for table `sales_returns`
--
ALTER TABLE `sales_returns`
  ADD PRIMARY KEY (`return_id`);

--
-- Indexes for table `stock_adjustments`
--
ALTER TABLE `stock_adjustments`
  ADD PRIMARY KEY (`adjust_id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`store_id`);

--
-- Indexes for table `sub_menus`
--
ALTER TABLE `sub_menus`
  ADD PRIMARY KEY (`sub_menu_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `transfers`
--
ALTER TABLE `transfers`
  ADD PRIMARY KEY (`transfer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`vendor_id`);

--
-- Indexes for table `waybills`
--
ALTER TABLE `waybills`
  ADD PRIMARY KEY (`waybill_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_class`
--
ALTER TABLE `account_class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `account_groups`
--
ALTER TABLE `account_groups`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `account_sub_groups`
--
ALTER TABLE `account_sub_groups`
  MODIFY `sub_group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `asset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `asset_locations`
--
ALTER TABLE `asset_locations`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `asset_postings`
--
ALTER TABLE `asset_postings`
  MODIFY `asset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `audit_trail`
--
ALTER TABLE `audit_trail`
  MODIFY `audit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2421;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `bank_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `cash_flows`
--
ALTER TABLE `cash_flows`
  MODIFY `flow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cost_of_sales`
--
ALTER TABLE `cost_of_sales`
  MODIFY `cost_of_sales_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `customer_trail`
--
ALTER TABLE `customer_trail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;

--
-- AUTO_INCREMENT for table `debtors`
--
ALTER TABLE `debtors`
  MODIFY `debtor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `deposit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `depreciation`
--
ALTER TABLE `depreciation`
  MODIFY `depreciation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `director_posting`
--
ALTER TABLE `director_posting`
  MODIFY `director_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `disbursal`
--
ALTER TABLE `disbursal`
  MODIFY `disbursal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `disposed_assets`
--
ALTER TABLE `disposed_assets`
  MODIFY `disposed_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `document_uploads`
--
ALTER TABLE `document_uploads`
  MODIFY `document_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `expense_heads`
--
ALTER TABLE `expense_heads`
  MODIFY `exp_head_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `finance_cost`
--
ALTER TABLE `finance_cost`
  MODIFY `finance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `guarantors`
--
ALTER TABLE `guarantors`
  MODIFY `guarantor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `info_request`
--
ALTER TABLE `info_request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inventory_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;

--
-- AUTO_INCREMENT for table `issue_items`
--
ALTER TABLE `issue_items`
  MODIFY `issue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=319;

--
-- AUTO_INCREMENT for table `item_transfers`
--
ALTER TABLE `item_transfers`
  MODIFY `transfer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `kyc`
--
ALTER TABLE `kyc`
  MODIFY `kyc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ledgers`
--
ALTER TABLE `ledgers`
  MODIFY `ledger_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `loan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `loan_applications`
--
ALTER TABLE `loan_applications`
  MODIFY `loan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `loan_products`
--
ALTER TABLE `loan_products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `multiple_payments`
--
ALTER TABLE `multiple_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `opening_balance`
--
ALTER TABLE `opening_balance`
  MODIFY `balance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `other_income`
--
ALTER TABLE `other_income`
  MODIFY `income_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `other_transactions`
--
ALTER TABLE `other_transactions`
  MODIFY `trx_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `outstanding`
--
ALTER TABLE `outstanding`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `production`
--
ALTER TABLE `production`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `purchase_payments`
--
ALTER TABLE `purchase_payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `remove_items`
--
ALTER TABLE `remove_items`
  MODIFY `remove_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `remove_reasons`
--
ALTER TABLE `remove_reasons`
  MODIFY `remove_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `repayments`
--
ALTER TABLE `repayments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `repayment_schedule`
--
ALTER TABLE `repayment_schedule`
  MODIFY `repayment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `rights`
--
ALTER TABLE `rights`
  MODIFY `right_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=385;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sales_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1165;

--
-- AUTO_INCREMENT for table `sales_returns`
--
ALTER TABLE `sales_returns`
  MODIFY `return_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `stock_adjustments`
--
ALTER TABLE `stock_adjustments`
  MODIFY `adjust_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `store_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sub_menus`
--
ALTER TABLE `sub_menus`
  MODIFY `sub_menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1572;

--
-- AUTO_INCREMENT for table `transfers`
--
ALTER TABLE `transfers`
  MODIFY `transfer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=361;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `vendor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `waybills`
--
ALTER TABLE `waybills`
  MODIFY `waybill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
