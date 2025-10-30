-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2025 at 06:49 AM
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
-- Database: `bill_software`
--

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `alter_code` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`id`, `name`, `alter_code`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(57, 'fdgdfg', NULL, NULL, 0, '2025-10-27 02:45:26', '2025-10-27 02:45:26'),
(58, 'fgdfgdf', NULL, NULL, 0, '2025-10-27 02:45:30', '2025-10-27 02:45:30'),
(68, 'fgdfgdf', NULL, NULL, 0, '2025-10-27 02:46:20', '2025-10-27 02:46:20');

-- --------------------------------------------------------

--
-- Table structure for table `area_managers`
--

CREATE TABLE `area_managers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `reg_mgr` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `area_managers`
--

INSERT INTO `area_managers` (`id`, `code`, `name`, `email`, `mobile`, `address`, `telephone`, `reg_mgr`, `status`, `created_at`, `updated_at`) VALUES
(1, 'AM001', 'Rajesh Kumar Sharma', 'rajesh.sharma@company.com', '9876543210', 'Plot No. 45, Sector 12, Noida, Uttar Pradesh', '0120-2345678', 'RM001', 'Active', '2025-10-15 04:19:56', '2025-10-15 04:19:56'),
(2, 'AM002', 'Priya Patel', 'priya.patel@company.com', '9876543211', 'B-204, Satellite Road, Ahmedabad, Gujarat', '079-26543210', 'RM002', 'Active', '2025-10-15 04:19:56', '2025-10-15 04:19:56'),
(3, 'AM003', 'Amit Singh', 'amit.singh@company.com', '9876543212', 'Flat 301, Koramangala, Bangalore, Karnataka', '080-25678901', 'Kavitha Reddy (RM008)', 'Active', '2025-10-15 04:19:56', '2025-10-28 07:41:55'),
(4, 'AM004', 'Sneha Reddy', 'sneha.reddy@company.com', '9876543213', 'House No. 12-3-456, Banjara Hills, Hyderabad, Telangana', '040-23456789', 'RM003', 'Active', '2025-10-15 04:19:56', '2025-10-15 04:19:56'),
(5, 'AM005', 'Vikram Agarwal', 'vikram.agarwal@company.com', '9876543214', 'C-15, Civil Lines, Jaipur, Rajasthan', '0141-2567890', 'RM002', 'Active', '2025-10-15 04:19:56', '2025-10-15 04:19:56'),
(6, 'AM006', 'Kavya Nair', 'kavya.nair@company.com', '9876543215', 'TC 25/1234, Pattom, Thiruvananthapuram, Kerala', '0471-2345678', 'RM004', 'Inactive', '2025-10-15 04:19:56', '2025-10-15 04:19:56'),
(7, 'AM007', 'Arjun Gupta', 'arjun.gupta@company.com', '9876543216', '45/2, Park Street, Kolkata, West Bengal', '033-22345678', 'RM005', 'Active', '2025-10-15 04:19:56', '2025-10-15 04:19:56'),
(8, 'AM008', 'Meera Iyer', 'meera.iyer@company.com', '9876543217', 'No. 23, T. Nagar, Chennai, Tamil Nadu', '044-24567890', 'RM003', 'Active', '2025-10-15 04:19:56', '2025-10-15 04:19:56'),
(9, 'AM009', 'Rohit Malhotra', 'rohit.malhotra@company.com', '9876543218', 'SCO 234, Sector 35, Chandigarh', '0172-2678901', 'RM001', 'Active', '2025-10-15 04:19:56', '2025-10-15 04:19:56'),
(10, 'AM010', 'Anita Desai', 'anita.desai@company.com', '9876543219', 'Flat 502, Bandra West, Mumbai, Maharashtra', '022-26789012', 'RM002', 'Active', '2025-10-15 04:19:56', '2025-10-15 04:19:56');

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `batch_number` varchar(255) NOT NULL,
  `manufacturing_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `quantity` decimal(12,2) NOT NULL DEFAULT 0.00,
  `cost_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `selling_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `godown` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `remarks` text DEFAULT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cash_bank_books`
--

CREATE TABLE `cash_bank_books` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT 'Name/Code of cash/bank book',
  `transaction_date` date NOT NULL,
  `transaction_type` varchar(50) NOT NULL COMMENT 'Cash or Bank',
  `particulars` varchar(255) NOT NULL,
  `voucher_no` varchar(50) DEFAULT NULL,
  `debit` decimal(15,2) DEFAULT 0.00,
  `credit` decimal(15,2) DEFAULT 0.00,
  `balance` decimal(15,2) DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `alter_code` varchar(255) DEFAULT NULL COMMENT 'Alternate code',
  `under` varchar(255) DEFAULT NULL COMMENT 'Under which ledger/group',
  `opening_balance` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Opening balance amount',
  `opening_balance_type` char(1) NOT NULL DEFAULT 'D' COMMENT 'Dr/Cr - Debit or Credit',
  `credit_card` char(1) DEFAULT NULL COMMENT 'Y/N/W - Credit Card/Wallet flag',
  `bank_charges` decimal(15,2) DEFAULT NULL COMMENT 'Bank charges amount',
  `address` text DEFAULT NULL COMMENT 'Address of the bank/cash location',
  `address1` text DEFAULT NULL COMMENT 'Additional address line',
  `telephone` varchar(255) DEFAULT NULL COMMENT 'Telephone number',
  `email` varchar(255) DEFAULT NULL COMMENT 'E-Mail address',
  `fax` varchar(255) DEFAULT NULL COMMENT 'Fax number',
  `birth_day` date DEFAULT NULL COMMENT 'Birthday',
  `anniversary_day` date DEFAULT NULL COMMENT 'Anniversary day',
  `contact_person_1` varchar(255) DEFAULT NULL COMMENT 'Contact Person I',
  `contact_person_2` varchar(255) DEFAULT NULL COMMENT 'Contact Person II',
  `mobile_1` varchar(255) DEFAULT NULL COMMENT 'Mobile number 1',
  `mobile_2` varchar(255) DEFAULT NULL COMMENT 'Mobile number 2',
  `input_gst_purchase` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Input GST (Purchase) flag',
  `output_gst_income` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Output GST (Income) flag',
  `account_no` varchar(255) DEFAULT NULL COMMENT 'Account number',
  `report_no` varchar(255) DEFAULT NULL COMMENT 'Report number',
  `cheque_clearance_method` char(1) NOT NULL DEFAULT 'P' COMMENT 'P/I - Pis. No. or Individual Cheques',
  `flag` varchar(255) DEFAULT NULL COMMENT 'Flag/Status field',
  `receipts` char(1) NOT NULL DEFAULT 'S' COMMENT 'S/I - Summary or Individual Receipts'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cash_bank_books`
--

INSERT INTO `cash_bank_books` (`id`, `name`, `transaction_date`, `transaction_type`, `particulars`, `voucher_no`, `debit`, `credit`, `balance`, `description`, `created_at`, `updated_at`, `alter_code`, `under`, `opening_balance`, `opening_balance_type`, `credit_card`, `bank_charges`, `address`, `address1`, `telephone`, `email`, `fax`, `birth_day`, `anniversary_day`, `contact_person_1`, `contact_person_2`, `mobile_1`, `mobile_2`, `input_gst_purchase`, `output_gst_income`, `account_no`, `report_no`, `cheque_clearance_method`, `flag`, `receipts`) VALUES
(1, 'CASH BOOK', '2025-10-15', 'Cash', 'Opening Balance', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 02:59:41', '2025-10-15 02:59:41', NULL, 'CASH IN HAND', 1401.30, 'D', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'P', NULL, 'S'),
(2, 'ELECTRICITY', '2025-10-15', 'Cash', 'Opening Balance', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 02:59:41', '2025-10-15 02:59:41', NULL, 'EXPENSE (INDIRECT)', 0.00, 'D', 'N', 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'P', NULL, 'S'),
(3, 'PUNJAB NATIONAL BANK', '2025-10-15', 'Bank', 'Opening Balance', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 02:59:41', '2025-10-15 02:59:41', NULL, 'CASH & BANK BALANCES', 36893975.00, 'D', 'N', 0.00, 'MAIN BAZAR PRAHLAD NAGAR', 'MEERUT - 250002', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '04141131001026', NULL, 'I', NULL, 'S'),
(4, 'YES BANK', '2025-10-15', 'Bank', 'Opening Balance', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 02:59:41', '2025-10-15 02:59:41', NULL, 'CASH & BANK BALANCES', 24528602.00, 'D', 'N', 0.00, 'PANCHSHEEL COLONEY GARH ROAD', 'MEERUT - 250004', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '0226619000001208', NULL, 'I', NULL, 'S'),
(5, 'YES BANK LIMITED', '2025-10-15', 'Bank', 'Opening Balance', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 02:59:41', '2025-10-15 02:59:41', NULL, 'CASH & BANK BALANCES', 0.00, 'D', 'N', 0.00, 'GARH ROAD MEERUT', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '0226846000001651', NULL, 'P', NULL, 'S'),
(6, 'HDFC BANK', '2025-10-15', 'Bank', 'Opening Balance', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:55:10', '2025-10-15 03:55:10', 'HDFC-001', 'CASH & BANK BALANCES', 15000000.00, 'D', 'N', 500.00, 'SECTOR 18, NOIDA', 'NOIDA - 201301', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '0123456789012345', NULL, 'I', NULL, 'S'),
(7, 'ICICI BANK', '2025-10-15', 'Bank', 'Opening Balance', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:55:10', '2025-10-15 03:55:10', 'ICICI-001', 'CASH & BANK BALANCES', 8500000.00, 'D', 'Y', 750.00, 'CONNAUGHT PLACE', 'NEW DELHI - 110001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '9876543210123456', NULL, 'P', NULL, 'I'),
(8, 'AXIS BANK', '2025-10-15', 'Bank', 'Opening Balance', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:55:10', '2025-10-15 00:25:46', 'AXIS-001', 'CASH & BANK BALANCES', 12000000.00, 'D', 'N', 600.00, 'BANDRA KURLA COMPLEX', 'MUMBAI - 400051', '3434534', 'abhi@11.c', '6456', '2025-10-16', '2025-10-18', 'dfgdf', 'dfgdfg', '534534545', '54345345', 0, 1, '1111222233334444', '5345345', 'I', '34534', 'S'),
(9, 'KOTAK BANK', '2025-10-15', 'Bank', 'Opening Balance', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:55:10', '2025-10-15 03:55:10', 'KOTAK-001', 'CASH & BANK BALANCES', 5500000.00, 'D', 'W', 400.00, 'FORT, MUMBAI', 'MUMBAI - 400001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '5555666677778888', NULL, 'P', NULL, 'I'),
(10, 'INDUSIND BANK', '2025-10-15', 'Bank', 'Opening Balance', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:55:10', '2025-10-15 03:55:10', 'INDUSIND-001', 'CASH & BANK BALANCES', 7200000.00, 'D', 'N', 550.00, 'BANGALORE', 'BANGALORE - 560001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '9999000011112222', NULL, 'I', NULL, 'S'),
(11, 'PETTY CASH', '2025-10-15', 'Cash', 'Opening Balance', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:55:10', '2025-10-15 03:55:10', 'PETTY-001', 'CASH IN HAND', 50000.00, 'D', NULL, NULL, 'HEAD OFFICE', 'MAIN STORE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'P', NULL, 'S'),
(12, 'OFFICE CASH', '2025-10-15', 'Cash', 'Opening Balance', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:55:10', '2025-10-15 03:55:10', 'OFFICE-001', 'CASH IN HAND', 100000.00, 'D', NULL, NULL, 'OFFICE PREMISES', 'CASH COUNTER', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'P', NULL, 'I'),
(13, 'STORE CASH', '2025-10-15', 'Cash', 'Opening Balance', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:55:10', '2025-10-15 03:55:10', 'STORE-001', 'CASH IN HAND', 75000.00, 'D', NULL, NULL, 'STORE ROOM', 'WAREHOUSE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, NULL, 'P', NULL, 'S'),
(14, 'FEDERAL BANK', '2025-10-15', 'Bank', 'Opening Balance', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:55:10', '2025-10-15 03:55:10', 'FEDERAL-001', 'CASH & BANK BALANCES', 3500000.00, 'D', 'N', 350.00, 'KOCHI', 'KOCHI - 682001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '3333444455556666', NULL, 'I', NULL, 'S'),
(15, 'IDBI BANK', '2025-10-15', 'Bank', 'Opening Balance', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:55:10', '2025-10-15 03:55:10', 'IDBI-001', 'CASH & BANK BALANCES', 4200000.00, 'D', 'Y', 450.00, 'KOLKATA', 'KOLKATA - 700001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '7777888899990000', NULL, 'P', NULL, 'I'),
(16, 'BOB BANK', '2025-10-15', 'Bank', 'Opening Balance', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:55:10', '2025-10-15 03:55:10', 'BOB-001', 'CASH & BANK BALANCES', 6800000.00, 'D', 'N', 500.00, 'PUNE', 'PUNE - 411001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '1010101010101010', NULL, 'I', NULL, 'S'),
(17, 'SBI BANK', '2025-10-15', 'Bank', 'Opening Balance', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:55:10', '2025-10-15 03:55:10', 'SBI-001', 'CASH & BANK BALANCES', 20000000.00, 'D', 'N', 400.00, 'DELHI', 'DELHI - 110001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '1212121212121212', NULL, 'I', NULL, 'S'),
(18, 'BANK_001', '2025-10-15', 'Cash', 'Opening Balance Entry 1', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-001', 'EXPENSE (INDIRECT)', 33643952.00, 'D', 'N', 928.00, 'ADDRESS LOCATION 1, CITY 1', 'POSTAL CODE 000001', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0101010101010101', NULL, 'I', NULL, 'S'),
(19, 'BANK_002', '2025-10-15', 'Cash', 'Opening Balance Entry 2', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-002', 'CASH IN HAND', 24837250.00, 'D', 'W', 529.00, 'ADDRESS LOCATION 2, CITY 2', 'POSTAL CODE 000002', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '0202020202020202', NULL, 'P', NULL, 'S'),
(20, 'BANK_003', '2025-10-15', 'Cash', 'Opening Balance Entry 3', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-003', 'CASH IN HAND', 2822817.00, 'D', 'Y', 849.00, 'ADDRESS LOCATION 3, CITY 3', 'POSTAL CODE 000003', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '0303030303030303', NULL, 'I', NULL, 'S'),
(21, 'BANK_004', '2025-10-15', 'Cash', 'Opening Balance Entry 4', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-004', 'BANK CHARGES', 35265673.00, 'D', 'W', 750.00, 'ADDRESS LOCATION 4, CITY 4', 'POSTAL CODE 000004', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0404040404040404', NULL, 'I', NULL, 'I'),
(22, 'BANK_005', '2025-10-15', 'Bank', 'Opening Balance Entry 5', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-005', 'BANK CHARGES', 4034473.00, 'D', 'Y', 714.00, 'ADDRESS LOCATION 5, CITY 5', 'POSTAL CODE 000005', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '0505050505050505', NULL, 'P', NULL, 'S'),
(23, 'BANK_006', '2025-10-15', 'Bank', 'Opening Balance Entry 6', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-006', 'EXPENSE (INDIRECT)', 21492015.00, 'D', 'N', 465.00, 'ADDRESS LOCATION 6, CITY 6', 'POSTAL CODE 000006', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '0606060606060606', NULL, 'I', NULL, 'S'),
(24, 'BANK_007', '2025-10-15', 'Bank', 'Opening Balance Entry 7', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-007', 'CASH & BANK BALANCES', 34862185.00, 'D', 'W', 182.00, 'ADDRESS LOCATION 7, CITY 7', 'POSTAL CODE 000007', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '0707070707070707', NULL, 'I', NULL, 'S'),
(25, 'BANK_008', '2025-10-15', 'Cash', 'Opening Balance Entry 8', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-008', 'CASH & BANK BALANCES', 33129375.00, 'D', 'N', 902.00, 'ADDRESS LOCATION 8, CITY 8', 'POSTAL CODE 000008', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '0808080808080808', NULL, 'P', NULL, 'S'),
(26, 'BANK_009', '2025-10-15', 'Bank', 'Opening Balance Entry 9', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-009', 'CASH & BANK BALANCES', 11095863.00, 'D', 'N', 647.00, 'ADDRESS LOCATION 9, CITY 9', 'POSTAL CODE 000009', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '0909090909090909', NULL, 'P', NULL, 'S'),
(27, 'BANK_010', '2025-10-15', 'Bank', 'Opening Balance Entry 10', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-010', 'EXPENSE (INDIRECT)', 21865478.00, 'D', 'N', 320.00, 'ADDRESS LOCATION 10, CITY 10', 'POSTAL CODE 000010', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '1010101010101010', NULL, 'P', NULL, 'S'),
(28, 'BANK_011', '2025-10-15', 'Bank', 'Opening Balance Entry 11', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-011', 'EXPENSE (INDIRECT)', 7794631.00, 'D', 'W', 299.00, 'ADDRESS LOCATION 11, CITY 11', 'POSTAL CODE 000011', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '1111111111111111', NULL, 'P', NULL, 'I'),
(29, 'BANK_012', '2025-10-15', 'Bank', 'Opening Balance Entry 12', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-012', 'CASH IN HAND', 34360621.00, 'D', 'W', 101.00, 'ADDRESS LOCATION 12, CITY 12', 'POSTAL CODE 000012', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '1212121212121212', NULL, 'I', NULL, 'I'),
(30, 'BANK_013', '2025-10-15', 'Bank', 'Opening Balance Entry 13', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-013', 'CASH IN HAND', 8002810.00, 'D', 'W', 855.00, 'ADDRESS LOCATION 13, CITY 13', 'POSTAL CODE 000013', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '1313131313131313', NULL, 'I', NULL, 'I'),
(31, 'BANK_014', '2025-10-15', 'Cash', 'Opening Balance Entry 14', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-014', 'CASH & BANK BALANCES', 5812571.00, 'D', 'W', 244.00, 'ADDRESS LOCATION 14, CITY 14', 'POSTAL CODE 000014', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '1414141414141414', NULL, 'P', NULL, 'I'),
(32, 'BANK_015', '2025-10-15', 'Bank', 'Opening Balance Entry 15', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-015', 'CASH IN HAND', 4542826.00, 'D', 'Y', 103.00, 'ADDRESS LOCATION 15, CITY 15', 'POSTAL CODE 000015', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '1515151515151515', NULL, 'I', NULL, 'S'),
(33, 'BANK_016', '2025-10-15', 'Cash', 'Opening Balance Entry 16', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-016', 'CASH IN HAND', 6276136.00, 'D', 'N', 363.00, 'ADDRESS LOCATION 16, CITY 16', 'POSTAL CODE 000016', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '1616161616161616', NULL, 'I', NULL, 'I'),
(34, 'BANK_017', '2025-10-15', 'Cash', 'Opening Balance Entry 17', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-017', 'EXPENSE (INDIRECT)', 33694624.00, 'D', 'W', 664.00, 'ADDRESS LOCATION 17, CITY 17', 'POSTAL CODE 000017', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '1717171717171717', NULL, 'I', NULL, 'S'),
(35, 'BANK_018', '2025-10-15', 'Cash', 'Opening Balance Entry 18', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-018', 'EXPENSE (INDIRECT)', 42763328.00, 'D', 'N', 743.00, 'ADDRESS LOCATION 18, CITY 18', 'POSTAL CODE 000018', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '1818181818181818', NULL, 'I', NULL, 'I'),
(36, 'BANK_019', '2025-10-15', 'Bank', 'Opening Balance Entry 19', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-019', 'CASH & BANK BALANCES', 45994615.00, 'D', 'W', 294.00, 'ADDRESS LOCATION 19, CITY 19', 'POSTAL CODE 000019', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '1919191919191919', NULL, 'I', NULL, 'S'),
(37, 'BANK_020', '2025-10-15', 'Bank', 'Opening Balance Entry 20', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-020', 'CASH & BANK BALANCES', 44022345.00, 'D', 'N', 174.00, 'ADDRESS LOCATION 20, CITY 20', 'POSTAL CODE 000020', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2020202020202020', NULL, 'I', NULL, 'I'),
(38, 'BANK_021', '2025-10-15', 'Bank', 'Opening Balance Entry 21', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-021', 'BANK CHARGES', 8675081.00, 'D', 'Y', 778.00, 'ADDRESS LOCATION 21, CITY 21', 'POSTAL CODE 000021', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2121212121212121', NULL, 'P', NULL, 'I'),
(39, 'BANK_022', '2025-10-15', 'Bank', 'Opening Balance Entry 22', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-022', 'EXPENSE (INDIRECT)', 2447713.00, 'D', 'N', 600.00, 'ADDRESS LOCATION 22, CITY 22', 'POSTAL CODE 000022', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2222222222222222', NULL, 'I', NULL, 'I'),
(40, 'BANK_023', '2025-10-15', 'Bank', 'Opening Balance Entry 23', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-023', 'CASH & BANK BALANCES', 39950172.00, 'D', 'Y', 581.00, 'ADDRESS LOCATION 23, CITY 23', 'POSTAL CODE 000023', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2323232323232323', NULL, 'I', NULL, 'S'),
(41, 'BANK_024', '2025-10-15', 'Cash', 'Opening Balance Entry 24', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-024', 'EXPENSE (INDIRECT)', 24939856.00, 'D', 'N', 443.00, 'ADDRESS LOCATION 24, CITY 24', 'POSTAL CODE 000024', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2424242424242424', NULL, 'I', NULL, 'S'),
(42, 'BANK_025', '2025-10-15', 'Bank', 'Opening Balance Entry 25', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-025', 'CASH & BANK BALANCES', 8510082.00, 'D', 'Y', 321.00, 'ADDRESS LOCATION 25, CITY 25', 'POSTAL CODE 000025', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2525252525252525', NULL, 'P', NULL, 'S'),
(43, 'BANK_026', '2025-10-15', 'Bank', 'Opening Balance Entry 26', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-026', 'CASH IN HAND', 25880811.00, 'D', 'W', 582.00, 'ADDRESS LOCATION 26, CITY 26', 'POSTAL CODE 000026', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2626262626262626', NULL, 'P', NULL, 'S'),
(44, 'BANK_027', '2025-10-15', 'Bank', 'Opening Balance Entry 27', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-027', 'CASH & BANK BALANCES', 18377865.00, 'D', 'W', 606.00, 'ADDRESS LOCATION 27, CITY 27', 'POSTAL CODE 000027', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2727272727272727', NULL, 'I', NULL, 'S'),
(45, 'BANK_028', '2025-10-15', 'Bank', 'Opening Balance Entry 28', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-028', 'BANK CHARGES', 47201791.00, 'D', 'Y', 602.00, 'ADDRESS LOCATION 28, CITY 28', 'POSTAL CODE 000028', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '2828282828282828', NULL, 'I', NULL, 'S'),
(46, 'BANK_029', '2025-10-15', 'Bank', 'Opening Balance Entry 29', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-029', 'CASH IN HAND', 20991866.00, 'D', 'Y', 146.00, 'ADDRESS LOCATION 29, CITY 29', 'POSTAL CODE 000029', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '2929292929292929', NULL, 'I', NULL, 'I'),
(47, 'BANK_030', '2025-10-15', 'Bank', 'Opening Balance Entry 30', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-030', 'BANK CHARGES', 17107753.00, 'D', 'Y', 508.00, 'ADDRESS LOCATION 30, CITY 30', 'POSTAL CODE 000030', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '3030303030303030', NULL, 'I', NULL, 'I'),
(48, 'BANK_031', '2025-10-15', 'Bank', 'Opening Balance Entry 31', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-031', 'BANK CHARGES', 43453928.00, 'D', 'Y', 853.00, 'ADDRESS LOCATION 31, CITY 31', 'POSTAL CODE 000031', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '3131313131313131', NULL, 'P', NULL, 'I'),
(49, 'BANK_032', '2025-10-15', 'Bank', 'Opening Balance Entry 32', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-032', 'EXPENSE (INDIRECT)', 16243356.00, 'D', 'W', 554.00, 'ADDRESS LOCATION 32, CITY 32', 'POSTAL CODE 000032', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '3232323232323232', NULL, 'P', NULL, 'I'),
(50, 'BANK_033', '2025-10-15', 'Cash', 'Opening Balance Entry 33', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-033', 'CASH & BANK BALANCES', 4321640.00, 'D', 'N', 308.00, 'ADDRESS LOCATION 33, CITY 33', 'POSTAL CODE 000033', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '3333333333333333', NULL, 'I', NULL, 'S'),
(51, 'BANK_034', '2025-10-15', 'Cash', 'Opening Balance Entry 34', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-034', 'CASH IN HAND', 28856942.00, 'D', 'W', 782.00, 'ADDRESS LOCATION 34, CITY 34', 'POSTAL CODE 000034', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '3434343434343434', NULL, 'P', NULL, 'S'),
(52, 'BANK_035', '2025-10-15', 'Bank', 'Opening Balance Entry 35', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-035', 'BANK CHARGES', 26037200.00, 'D', 'Y', 428.00, 'ADDRESS LOCATION 35, CITY 35', 'POSTAL CODE 000035', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '3535353535353535', NULL, 'P', NULL, 'S'),
(53, 'BANK_036', '2025-10-15', 'Cash', 'Opening Balance Entry 36', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-036', 'CASH IN HAND', 12843801.00, 'D', 'W', 951.00, 'ADDRESS LOCATION 36, CITY 36', 'POSTAL CODE 000036', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '3636363636363636', NULL, 'I', NULL, 'I'),
(54, 'BANK_037', '2025-10-15', 'Bank', 'Opening Balance Entry 37', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-037', 'CASH IN HAND', 10399137.00, 'D', 'W', 772.00, 'ADDRESS LOCATION 37, CITY 37', 'POSTAL CODE 000037', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '3737373737373737', NULL, 'I', NULL, 'S'),
(55, 'BANK_038', '2025-10-15', 'Cash', 'Opening Balance Entry 38', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-038', 'CASH IN HAND', 35268234.00, 'D', 'N', 478.00, 'ADDRESS LOCATION 38, CITY 38', 'POSTAL CODE 000038', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '3838383838383838', NULL, 'P', NULL, 'I'),
(56, 'BANK_039', '2025-10-15', 'Cash', 'Opening Balance Entry 39', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-039', 'CASH & BANK BALANCES', 15211347.00, 'D', 'N', 727.00, 'ADDRESS LOCATION 39, CITY 39', 'POSTAL CODE 000039', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '3939393939393939', NULL, 'I', NULL, 'I'),
(57, 'BANK_040', '2025-10-15', 'Bank', 'Opening Balance Entry 40', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-040', 'BANK CHARGES', 4649982.00, 'D', 'N', 518.00, 'ADDRESS LOCATION 40, CITY 40', 'POSTAL CODE 000040', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '4040404040404040', NULL, 'I', NULL, 'I'),
(58, 'BANK_041', '2025-10-15', 'Bank', 'Opening Balance Entry 41', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-041', 'CASH & BANK BALANCES', 38453101.00, 'D', 'N', 274.00, 'ADDRESS LOCATION 41, CITY 41', 'POSTAL CODE 000041', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '4141414141414141', NULL, 'P', NULL, 'I'),
(59, 'BANK_042', '2025-10-15', 'Bank', 'Opening Balance Entry 42', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-042', 'CASH & BANK BALANCES', 34915658.00, 'D', 'W', 165.00, 'ADDRESS LOCATION 42, CITY 42', 'POSTAL CODE 000042', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '4242424242424242', NULL, 'P', NULL, 'S'),
(60, 'BANK_043', '2025-10-15', 'Bank', 'Opening Balance Entry 43', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-043', 'EXPENSE (INDIRECT)', 32354496.00, 'D', 'Y', 524.00, 'ADDRESS LOCATION 43, CITY 43', 'POSTAL CODE 000043', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '4343434343434343', NULL, 'P', NULL, 'S'),
(61, 'BANK_044', '2025-10-15', 'Bank', 'Opening Balance Entry 44', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-044', 'CASH & BANK BALANCES', 39082061.00, 'D', 'W', 186.00, 'ADDRESS LOCATION 44, CITY 44', 'POSTAL CODE 000044', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '4444444444444444', NULL, 'I', NULL, 'I'),
(62, 'BANK_045', '2025-10-15', 'Cash', 'Opening Balance Entry 45', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-045', 'CASH & BANK BALANCES', 9013374.00, 'D', 'Y', 979.00, 'ADDRESS LOCATION 45, CITY 45', 'POSTAL CODE 000045', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '4545454545454545', NULL, 'P', NULL, 'S'),
(63, 'BANK_046', '2025-10-15', 'Bank', 'Opening Balance Entry 46', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-046', 'CASH IN HAND', 122987.00, 'D', 'Y', 969.00, 'ADDRESS LOCATION 46, CITY 46', 'POSTAL CODE 000046', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '4646464646464646', NULL, 'I', NULL, 'S'),
(64, 'BANK_047', '2025-10-15', 'Cash', 'Opening Balance Entry 47', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-047', 'CASH IN HAND', 4694610.00, 'D', 'N', 912.00, 'ADDRESS LOCATION 47, CITY 47', 'POSTAL CODE 000047', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '4747474747474747', NULL, 'P', NULL, 'I'),
(65, 'BANK_048', '2025-10-15', 'Cash', 'Opening Balance Entry 48', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-048', 'CASH & BANK BALANCES', 32624586.00, 'D', 'W', 284.00, 'ADDRESS LOCATION 48, CITY 48', 'POSTAL CODE 000048', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '4848484848484848', NULL, 'I', NULL, 'I'),
(66, 'BANK_049', '2025-10-15', 'Cash', 'Opening Balance Entry 49', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-049', 'CASH & BANK BALANCES', 27008560.00, 'D', 'Y', 584.00, 'ADDRESS LOCATION 49, CITY 49', 'POSTAL CODE 000049', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '4949494949494949', NULL, 'I', NULL, 'S'),
(67, 'BANK_050', '2025-10-15', 'Cash', 'Opening Balance Entry 50', NULL, 0.00, 0.00, 0.00, NULL, '2025-10-15 03:58:06', '2025-10-15 03:58:06', 'CODE-050', 'CASH IN HAND', 44179693.00, 'D', 'N', 371.00, 'ADDRESS LOCATION 50, CITY 50', 'POSTAL CODE 000050', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, '5050505050505050', NULL, 'I', NULL, 'I');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact_person_1` varchar(255) DEFAULT NULL,
  `contact_person_2` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `alter_code` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `short_name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `mobile_1` varchar(255) DEFAULT NULL,
  `mobile_2` varchar(255) DEFAULT NULL,
  `pur_sc` varchar(255) DEFAULT NULL,
  `sale_sc` varchar(255) DEFAULT NULL,
  `expiry` varchar(255) DEFAULT NULL,
  `dis_on_sale_percent` decimal(10,2) DEFAULT NULL,
  `min_gp` decimal(10,2) DEFAULT NULL,
  `pur_tax` decimal(10,2) DEFAULT NULL,
  `sale_tax` decimal(10,2) DEFAULT NULL,
  `generic` varchar(255) DEFAULT NULL,
  `invoice_print_order` varchar(255) DEFAULT NULL,
  `direct_indirect` varchar(255) DEFAULT NULL,
  `surcharge_after_dis_yn` tinyint(1) DEFAULT 0,
  `add_surcharge_yn` tinyint(1) DEFAULT 0,
  `vat_percent` decimal(10,2) DEFAULT NULL,
  `inclusive_yn` tinyint(1) DEFAULT 0,
  `lock_aiocd` char(1) NOT NULL DEFAULT 'n',
  `lock_ims` char(1) NOT NULL DEFAULT 'n',
  `disallow_expiry_after_months` int(11) DEFAULT NULL,
  `fixed_maximum` char(1) DEFAULT 'f',
  `discount` decimal(10,2) DEFAULT 0.00,
  `flag` varchar(255) DEFAULT NULL,
  `status` varchar(5) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `address`, `email`, `contact_person_1`, `contact_person_2`, `website`, `alter_code`, `telephone`, `short_name`, `location`, `mobile_1`, `mobile_2`, `pur_sc`, `sale_sc`, `expiry`, `dis_on_sale_percent`, `min_gp`, `pur_tax`, `sale_tax`, `generic`, `invoice_print_order`, `direct_indirect`, `surcharge_after_dis_yn`, `add_surcharge_yn`, `vat_percent`, `inclusive_yn`, `lock_aiocd`, `lock_ims`, `disallow_expiry_after_months`, `fixed_maximum`, `discount`, `flag`, `status`, `notes`, `is_deleted`, `deleted_at`, `created_at`, `updated_at`) VALUES
(62, 'Reliance Industries Ltd', 'Mumbai, Maharashtra', 'contact@reliance.com', 'Mukesh Ambani', 'Nita Ambani', 'https://www.ril.com', 'REL001', '02267851000', 'RIL', 'Mumbai', '9876543210', '9876543211', '0.18', '0.15', 'N', 12.50, 15.00, 18.00, 18.00, 'Y', '1', 'D', 1, 1, 18.00, 1, 'n', 'n', 12, 'f', 10.00, NULL, '1', NULL, 0, NULL, '2025-10-13 09:59:39', '2025-10-13 09:59:39'),
(63, 'Tata Consultancy Services', 'Bangalore, Karnataka', 'info@tcs.com', 'Rajesh Kumar', 'Priya Sharma', 'https://www.tcs.com', 'TCS001', '08067856000', 'TCS', 'Bangalore', '9123456789', '9123456790', '0.12', '0.10', 'N', 10.00, 12.00, 18.00, 18.00, 'Y', '2', 'I', 0, 1, 18.00, 1, 'n', 'n', 24, 'f', 8.00, NULL, '1', NULL, 0, NULL, '2025-10-13 09:59:39', '2025-10-13 09:59:39'),
(64, 'Infosys Limited', 'Electronic City, Bangalore', 'contact@infosys.com', 'Narayana Murthy', 'Sudha Murthy', 'https://www.infosys.com', 'INF001', '08028521000', 'INFY', 'Bangalore', '9988776655', '9988776656', '0.10', '0.08', 'N', 8.50, 10.00, 18.00, 18.00, 'N', '1', 'D', 1, 1, 18.00, 0, 'n', 'n', 12, 'f', 5.00, NULL, '1', NULL, 0, NULL, '2025-10-13 09:59:39', '2025-10-13 09:59:39'),
(65, 'Wipro Technologies', 'Sarjapur Road, Bangalore', 'sales@wipro.com', 'Azim Premji', 'Yasmeen Premji', 'https://www.wipro.com', 'WIP001', '08025003000', 'WIPRO', 'Bangalore', '9871234567', '9871234568', '0.15', '0.12', 'N', 11.00, 13.00, 18.00, 18.00, 'Y', '2', 'I', 1, 1, 18.00, 1, 'n', 'n', 18, 'f', 7.50, NULL, '1', NULL, 0, NULL, '2025-10-13 09:59:39', '2025-10-13 09:59:39'),
(66, 'HDFC Bank Ltd', 'Mumbai, Maharashtra', 'info@hdfcbank.com', 'Sashidhar Jagdishan', 'Renu Sud Karnad', 'https://www.hdfcbank.com', 'HDFC01', '02268521000', 'HDFC', 'Mumbai', '9765432109', '9765432108', '0.00', '0.00', 'N', 0.00, 0.00, 0.00, 0.00, 'Y', '1', 'D', 0, 0, 0.00, 0, 'n', 'n', 0, 'm', 0.00, NULL, '1', NULL, 0, NULL, '2025-10-13 09:59:39', '2025-10-13 09:59:39'),
(67, 'Bharti Airtel Ltd', 'New Delhi', 'support@airtel.com', 'Gopal Vittal', 'Shashwat Sharma', 'https://www.airtel.in', 'AIR001', '01146661000', 'AIRTEL', 'Delhi', '9654321098', '9654321097', '0.18', '0.15', 'N', 13.00, 16.00, 18.00, 18.00, 'Y', '1', 'D', 1, 1, 18.00, 1, 'n', 'n', 12, 'f', 9.00, NULL, '1', NULL, 0, NULL, '2025-10-13 09:59:39', '2025-10-13 09:59:39'),
(68, 'Hindustan Unilever Ltd', 'Andheri East, Mumbai', 'hul@unilever.com', 'Sanjiv Mehta', 'Ritesh Tiwari', 'https://www.hul.co.in', 'HUL001', '02233036000', 'HUL', 'Mumbai', '9543210987', '9543210986', '0.12', '0.10', 'Y', 9.50, 11.50, 18.00, 18.00, 'N', '2', 'I', 1, 1, 18.00, 1, 'n', 'n', 6, 'f', 6.00, NULL, '1', NULL, 0, NULL, '2025-10-13 09:59:39', '2025-10-13 09:59:39'),
(69, 'Larsen & Toubro Ltd', 'Powai, Mumbai', 'contact@lntecc.com', 'SN Subrahmanyan', 'R Shankar Raman', 'https://www.larsentoubro.com', 'LNT001', '02267525656', 'L&T', 'Mumbai', '9432109876', '9432109875', '0.18', '0.15', 'N', 14.00, 17.00, 18.00, 18.00, 'Y', '1', 'D', 1, 1, 18.00, 1, 'n', 'n', 24, 'f', 11.00, NULL, '1', NULL, 0, NULL, '2025-10-13 09:59:39', '2025-10-13 09:59:39'),
(70, 'ITC Limited', 'Kolkata, West Bengal', 'info@itc.in', 'Sanjiv Puri', 'Rajiv Tandon', 'https://www.itcportal.com', 'ITC001', '03322889371', 'ITC', 'Kolkata', '9321098765', '9321098764', '0.12', '0.10', 'Y', 10.50, 13.00, 18.00, 18.00, 'N', '2', 'D', 1, 1, 18.00, 1, 'n', 'n', 9, 'f', 7.00, NULL, '1', NULL, 0, NULL, '2025-10-13 09:59:39', '2025-10-13 09:59:39'),
(71, 'Mahindra & Mahindra', 'Mumbai, Maharashtra', 'mm@mahindra.com', 'Anand Mahindra', 'Anish Shah', 'https://www.mahindra.com', 'MAH001', '02228468800', 'M&M', 'Mumbai', '9210987654', '9210987653', '0.18', '0.15', 'N', 12.00, 15.50, 18.00, 18.00, 'Y', '1', 'I', 1, 1, 18.00, 1, 'n', 'n', 18, 'f', 8.50, NULL, '1', NULL, 0, NULL, '2025-10-13 09:59:39', '2025-10-13 09:59:39'),
(72, 'Asian Paints Ltd', 'Mumbai, Maharashtra', 'contact@asianpaints.com', 'Amit Syngle', 'KBS Anand', 'https://www.asianpaints.com', 'ASP001', '02266569000', 'ASIAN', 'Mumbai', '9109876543', '9109876542', '0.12', '0.10', 'Y', 11.50, 14.00, 18.00, 18.00, 'N', '2', 'D', 1, 1, 18.00, 1, 'n', 'n', 12, 'f', 9.50, NULL, '1', NULL, 0, NULL, '2025-10-13 09:59:39', '2025-10-13 09:59:39'),
(73, 'Sun Pharmaceutical', 'Mumbai, Maharashtra', 'info@sunpharma.com', 'Dilip Shanghvi', 'Aalok Shanghvi', 'https://www.sunpharma.com', 'SUN001', '02266455645', 'SUNPH', 'Mumbai', '9098765432', '9098765431', '0.12', '0.10', 'Y', 8.00, 10.50, 12.00, 12.00, 'Y', '1', 'D', 0, 1, 12.00, 1, 'n', 'n', 18, 'f', 5.50, NULL, '1', NULL, 0, NULL, '2025-10-13 09:59:39', '2025-10-13 09:59:39'),
(74, 'Maruti Suzuki India', 'Gurgaon, Haryana', 'service@marutisuzuki.com', 'Hisashi Takeuchi', 'Shashank Srivastava', 'https://www.marutisuzuki.com', 'MAR001', '01246781000', 'MSIL', 'Gurgaon', '8987654321', '8987654320', '0.18', '0.15', 'N', 15.00, 18.00, 28.00, 28.00, 'Y', '1', 'I', 1, 1, 28.00, 1, 'n', 'n', 36, 'f', 12.00, NULL, '1', NULL, 0, NULL, '2025-10-13 09:59:39', '2025-10-13 09:59:39'),
(75, 'Bajaj Auto Limited', 'Pune, Maharashtra', 'corporate@bajajauto.co.in', 'Rajiv Bajaj', 'Rakesh Sharma', 'https://www.bajajauto.com', 'BAJ001', '02027472851', 'BAJAJ', 'Pune', '8876543210', '8876543209', '0.18', '0.15', 'N', 13.50, 16.50, 28.00, 28.00, 'Y', '2', 'D', 1, 1, 28.00, 1, 'n', 'n', 24, 'f', 10.50, NULL, '1', NULL, 0, NULL, '2025-10-13 09:59:39', '2025-10-13 09:59:39'),
(76, 'Dr Reddys Laboratories', 'Hyderabad, Telangana', 'contact@drreddys.com', 'GV Prasad', 'Erez Israeli', 'https://www.drreddys.com', 'DRL001', '04049048400', 'DRREDDY', 'Hyderabad', '8765432109', '8765432108', '0.12', '0.10', 'Y', 9.00, 12.00, 12.00, 12.00, 'Y', '1', 'D', 1, 1, 12.00, 1, 'n', 'n', 18, 'f', 6.50, NULL, '1', NULL, 0, NULL, '2025-10-13 09:59:39', '2025-10-13 09:59:39'),
(77, 'Flipkart Internet Pvt Ltd', 'Bangalore, Karnataka', 'support@flipkart.com', 'Kalyan Krishnamurthy', 'Smita Agarwal', 'https://www.flipkart.com', 'FLP001', '08044561000', 'FLIPKART', 'Bangalore', '8109876543', '8109876542', '0.18', '0.15', 'N', 12.00, 15.00, 18.00, 18.00, 'Y', '1', 'D', 1, 1, 18.00, 1, 'n', 'n', 12, 'f', 10.00, NULL, '1', NULL, 0, NULL, '2025-10-13 10:03:25', '2025-10-13 10:03:25'),
(78, 'Paytm E-Commerce Pvt Ltd', 'Noida, Uttar Pradesh', 'care@paytm.com', 'Vijay Shekhar Sharma', 'Madhur Deora', 'https://www.paytm.com', 'PAY001', '01204456200', 'PAYTM', 'Noida', '7998765432', '7998765431', '0.18', '0.15', 'N', 10.50, 13.00, 18.00, 18.00, 'Y', '2', 'I', 1, 1, 18.00, 0, 'n', 'n', 0, 'f', 8.50, NULL, '1', NULL, 0, NULL, '2025-10-13 10:03:25', '2025-10-13 10:03:25'),
(79, 'Zomato Limited', 'Gurgaon, Haryana', 'contact@zomato.com', 'Deepinder Goyal', 'Akshant Goyal', 'https://www.zomato.com', 'ZOM001', '01246698800', 'ZOMATO', 'Gurgaon', '7887654321', '7887654320', '0.18', '0.15', 'N', 11.00, 14.00, 18.00, 18.00, 'Y', '1', 'D', 0, 1, 18.00, 1, 'n', 'n', 0, 'f', 9.00, NULL, '1', NULL, 0, NULL, '2025-10-13 10:03:25', '2025-10-13 10:03:25'),
(80, 'Ola Electric Mobility', 'Bangalore, Karnataka', 'info@olaelectric.com', 'Bhavish Aggarwal', 'Ankit Bhati', 'https://www.olaelectric.com', 'OLA001', '08067809900', 'OLA', 'Bangalore', '7776543210', '7776543209', '0.28', '0.25', 'N', 15.00, 18.00, 28.00, 28.00, 'Y', '1', 'I', 1, 1, 28.00, 1, 'n', 'n', 36, 'f', 12.50, NULL, '1', NULL, 0, NULL, '2025-10-13 10:03:25', '2025-10-13 10:03:25'),
(81, 'BYJU\'S Classes Pvt Ltd', 'Bangalore, Karnataka', 'support@byjus.com', 'Byju Raveendran', 'Divya Gokulnath', 'https://www.byjus.com', 'BYJ001', '08049201800', 'BYJUS', 'Bangalore', '7665432109', '7665432108', '0.18', '0.15', 'N', 9.50, 12.50, 18.00, 18.00, 'N', '2', 'D', 1, 1, 18.00, 1, 'n', 'n', 0, 'f', 7.50, NULL, '1', NULL, 0, NULL, '2025-10-13 10:03:25', '2025-10-13 10:03:25'),
(82, 'Swiggy Limited', 'Bangalore, Karnataka', 'care@swiggy.in', 'Sriharsha Majety', 'Nandan Reddy', 'https://www.swiggy.com', 'SWI001', '08068179900', 'SWIGGY', 'Bangalore', '7554321098', '7554321097', '0.18', '0.15', 'N', 10.00, 13.50, 18.00, 18.00, 'Y', '1', 'D', 1, 1, 18.00, 1, 'n', 'n', 0, 'f', 8.00, NULL, '1', NULL, 0, NULL, '2025-10-13 10:03:25', '2025-10-13 10:03:25'),
(83, 'Meesho Ecommerce Pvt Ltd', 'Bangalore, Karnataka', 'hello@meesho.com', 'Vidit Aatrey', 'Sanjeev Barnwal', 'https://www.meesho.com', 'MEE001', '08067455500', 'MEESHO', 'Bangalore', '7443210987', '7443210986', '0.18', '0.15', 'N', 11.50, 14.50, 18.00, 18.00, 'Y', '2', 'I', 1, 1, 18.00, 1, 'n', 'n', 12, 'f', 9.50, NULL, '1', NULL, 0, NULL, '2025-10-13 10:03:25', '2025-10-13 10:03:25'),
(84, 'PhonePe Pvt Ltd', 'Bangalore, Karnataka', 'support@phonepe.com', 'Sameer Nigam', 'Rahul Chari', 'https://www.phonepe.com', 'PHN001', '08067128800', 'PHONEPE', 'Bangalore', '7332109876', '7332109875', '0.18', '0.15', 'N', 8.50, 11.50, 18.00, 18.00, 'Y', '1', 'D', 0, 1, 18.00, 0, 'n', 'n', 0, 'f', 6.50, NULL, '1', NULL, 0, NULL, '2025-10-13 10:03:25', '2025-10-13 10:03:25'),
(85, 'Razorpay Software Pvt Ltd', 'Bangalore, Karnataka', 'care@razorpay.com', 'Harshil Mathur', 'Shashank Kumar', 'https://www.razorpay.com', 'RAZ001', '08067541100', 'RAZORPAY', 'Bangalore', '7221098765', '7221098764', '0.18', '0.15', 'N', 10.00, 12.00, 18.00, 18.00, 'Y', '2', 'I', 1, 1, 18.00, 1, 'n', 'n', 0, 'f', 7.00, NULL, '1', NULL, 0, NULL, '2025-10-13 10:03:25', '2025-10-13 10:03:25'),
(86, 'Udaan Commerce Pvt Ltd', 'Bangalore, Karnataka', 'support@udaan.com', 'Vaibhav Gupta', 'Amod Malviya', 'https://www.udaan.com', 'UDA001', '08046006100', 'UDAAN', 'Bangalore', '7110987654', '7110987653', '0.18', '0.15', 'N', 12.50, 15.50, 18.00, 18.00, 'Y', '1', 'D', 1, 1, 18.00, 1, 'n', 'n', 12, 'f', 10.50, NULL, '1', NULL, 0, NULL, '2025-10-13 10:03:25', '2025-10-13 10:03:25'),
(88, 'amansingh', 'meerut', 'admin@gmail.com', 'a', 'b', 'https://grok.com/c/0a9b8521-4aa6-4be5-b7da-57e9531bb9b8', '1', '233323', 'am', 'meerut', '322332', '322332', '0.02', '0.07', 'n', 0.07, 0.07, 0.09, 0.06, 'n', '5', 'd', 0, 0, 0.07, 0, 'n', 'n', 4, 'f', 0.00, '3232', '23', NULL, 0, NULL, '2025-10-15 05:29:31', '2025-10-15 05:29:31'),
(89, 'AMANN', 'FGFG', 'GGV@HHG.GHF', 'FGHFGH', 'FGHFG', 'https://grok.com/c/0a9b8521-4aa6-4be5-b7da-57e9531bb9b8', '`4554', '345345', 'ZXDVZ', 'BFG', '345345', '345345', '0.06', '0.01', 'n', 0.01, 0.02, 0.06, 0.03, 'n', NULL, 'd', 0, 0, 0.05, 0, 'n', 'n', 4, 'f', 0.00, '54345', '4534', NULL, 0, NULL, '2025-10-15 06:01:22', '2025-10-15 06:01:22'),
(90, 'NAMAN', '121221', 'NM@GM.COM', '2DC', 'DCSC', 'https://grok.com/c/0a9b8521-4aa6-4be5-b7da-57e9531bb9b8', '22', '12121212', 'NM', '1212', '12121212', '12121212', '0.03', '0.02', 'n', 0.03, 0.03, 0.03, 0.03, 'n', '4564365', 'd', 0, 0, 0.03, 0, 'n', 'n', 3, 'f', 0.00, '1`2`12`1', '`12`1', NULL, 0, NULL, '2025-10-15 06:09:02', '2025-10-15 06:11:05'),
(92, 'sdfszdf', 'asdfsadf', 'aditya34@gmail.com', NULL, NULL, 'http://127.0.0.1:8000/admin/companies/create', NULL, NULL, NULL, NULL, NULL, NULL, '0.00', '0.00', 'n', 0.00, 0.00, 0.00, 0.00, 'n', NULL, 'd', 0, 0, 0.00, 0, 'n', 'n', 0, 'f', 0.00, NULL, NULL, NULL, 0, NULL, '2025-10-15 01:14:44', '2025-10-15 01:14:54');

-- --------------------------------------------------------

--
-- Table structure for table `country_managers`
--

CREATE TABLE `country_managers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `country_managers`
--

INSERT INTO `country_managers` (`id`, `code`, `name`, `email`, `mobile`, `address`, `telephone`, `status`, `created_at`, `updated_at`) VALUES
(1, 'CM001', 'Sameer Verma', 'sameer.verma@company.com', '9876500010', 'Corporate Tower, Connaught Place, New Delhi', NULL, 'Active', '2025-10-27 05:41:05', '2025-10-27 05:41:05'),
(2, 'CM002', 'Leena Kapoor', 'leena.kapoor@company.com', '9876500011', 'Business Bay, BKC, Mumbai, Maharashtra', NULL, 'Active', '2025-10-27 05:41:05', '2025-10-27 05:41:05'),
(3, 'CM003', 'Arvind Rao', 'arvind.rao@company.com', '9876500012', 'Tech Park, Koramangala, Bengaluru, Karnataka', NULL, 'Active', '2025-10-27 05:41:05', '2025-10-27 05:41:05'),
(4, 'CM004', 'Radhika Iyer', 'radhika.iyer@company.com', '9876500013', 'Cyber Towers, HITEC City, Hyderabad, Telangana', NULL, 'Active', '2025-10-27 05:41:05', '2025-10-27 05:41:05'),
(5, 'CM005', 'Harshad Patel', 'harshad.patel@company.com', '9876500014', 'Commerce Center, Prahlad Nagar, Ahmedabad, Gujarat', NULL, 'Active', '2025-10-27 05:41:05', '2025-10-27 05:41:05'),
(6, 'CM006', 'Neha Singh', 'neha.singh@company.com', '9876500015', 'IT Corridor, Technopark, Thiruvananthapuram, Kerala', NULL, 'Inactive', '2025-10-27 05:41:05', '2025-10-27 05:41:05'),
(7, 'CM007', 'Suresh Banerjee', 'suresh.banerjee@company.com', '9876500016', 'Salt Lake City, Sector V, Kolkata, West Bengal', NULL, 'Active', '2025-10-27 05:41:05', '2025-10-27 05:41:05'),
(8, 'CM008', 'Trisha Nair', 'trisha.nair@company.com', '9876500017', 'OMR IT Expressway, Sholinganallur, Chennai, Tamil Nadu', NULL, 'Active', '2025-10-27 05:41:05', '2025-10-27 05:41:05'),
(9, '32', 'sdfsdf', NULL, NULL, NULL, NULL, NULL, '2025-10-27 05:41:35', '2025-10-27 05:41:35'),
(10, '33', '3333', NULL, NULL, NULL, NULL, NULL, '2025-10-27 05:41:44', '2025-10-27 05:41:44'),
(11, '3', 'sdfsdf', NULL, NULL, NULL, NULL, NULL, '2025-10-27 05:41:50', '2025-10-27 05:41:50'),
(12, '333', 'sdfgsdfg', NULL, NULL, NULL, NULL, NULL, '2025-10-27 05:41:57', '2025-10-27 05:41:57');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `tax_registration` varchar(255) DEFAULT NULL,
  `pin_code` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `address2_line2` varchar(255) DEFAULT NULL,
  `address2_line3` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `address_line2` varchar(255) DEFAULT NULL,
  `address_line3` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country_code` varchar(10) DEFAULT NULL,
  `country_name` varchar(100) DEFAULT NULL,
  `telephone_office` varchar(255) DEFAULT NULL,
  `telephone_residence` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact_person1` varchar(255) DEFAULT NULL,
  `mobile_contact1` varchar(255) DEFAULT NULL,
  `contact_person2` varchar(255) DEFAULT NULL,
  `mobile_contact2` varchar(255) DEFAULT NULL,
  `fax_number` varchar(255) DEFAULT NULL,
  `opening_balance` decimal(15,2) DEFAULT NULL,
  `balance_type` varchar(255) DEFAULT NULL,
  `local_central` varchar(255) DEFAULT NULL,
  `credit_days` int(11) DEFAULT NULL,
  `birth_day` date DEFAULT NULL,
  `anniversary_day` date DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `flag` varchar(255) DEFAULT NULL,
  `invoice_export` varchar(1) DEFAULT 'N',
  `due_list_sequence` varchar(255) DEFAULT NULL,
  `tan_number` varchar(255) DEFAULT NULL,
  `msme_license` varchar(255) DEFAULT NULL,
  `dl_number` varchar(255) DEFAULT NULL,
  `dl_expiry` date DEFAULT NULL,
  `dl_number1` varchar(255) DEFAULT NULL,
  `food_license` varchar(255) DEFAULT NULL,
  `cst_number` varchar(255) DEFAULT NULL,
  `tin_number` varchar(255) DEFAULT NULL,
  `pan_number` varchar(255) DEFAULT NULL,
  `sales_man_code` varchar(255) DEFAULT NULL,
  `sales_man_name` varchar(255) DEFAULT NULL,
  `area_code` varchar(255) DEFAULT NULL,
  `area_name` varchar(255) DEFAULT NULL,
  `route_code` varchar(255) DEFAULT NULL,
  `route_name` varchar(255) DEFAULT NULL,
  `state_code` varchar(255) DEFAULT NULL,
  `state_name` varchar(100) DEFAULT NULL,
  `business_type` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `order_required` varchar(1) DEFAULT 'N',
  `aadhar_number` varchar(255) DEFAULT NULL,
  `registration_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `day_value` int(11) DEFAULT NULL,
  `gst_number` varchar(15) DEFAULT NULL,
  `cst_registration` varchar(255) DEFAULT NULL,
  `gst_name` varchar(255) DEFAULT NULL,
  `state_code_gst` varchar(255) DEFAULT NULL,
  `registration_status` varchar(255) DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `modified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `bank` varchar(255) DEFAULT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `closed_on` date DEFAULT NULL,
  `credit_limit` decimal(10,2) DEFAULT 0.00,
  `sale_rate_type` varchar(1) DEFAULT '1',
  `add_percent` decimal(5,2) DEFAULT 0.00,
  `tax_on_br_expiry` varchar(1) DEFAULT 'N',
  `expiry_on` varchar(1) DEFAULT 'M',
  `dis_after_scheme` varchar(1) DEFAULT 'Y',
  `expiry_rn_on` varchar(1) DEFAULT 'M',
  `dis_on_excise` varchar(1) DEFAULT 'Y',
  `sale_pur_status` varchar(1) DEFAULT 'S',
  `scm_type` varchar(1) DEFAULT 'F',
  `net_rate` varchar(1) DEFAULT 'N',
  `no_of_items_in_bill` int(11) DEFAULT 0,
  `invoice_print_order` varchar(255) DEFAULT NULL,
  `sr_replacement` varchar(1) DEFAULT 'N',
  `cash_sale` varchar(1) DEFAULT 'N',
  `invoice_format` int(11) DEFAULT 0,
  `fixed_discount` decimal(10,2) DEFAULT 0.00,
  `gst_5_percent` decimal(5,2) DEFAULT 0.00,
  `gst_12_percent` decimal(5,2) DEFAULT 0.00,
  `gst_18_percent` decimal(5,2) DEFAULT 0.00,
  `gst_28_percent` decimal(5,2) DEFAULT 0.00,
  `gst_0_percent` decimal(5,2) DEFAULT 0.00,
  `ref` varchar(255) DEFAULT NULL,
  `tds` varchar(1) DEFAULT 'N',
  `add_charges_with_gst` varchar(1) DEFAULT 'N',
  `tcs_applicable` varchar(1) DEFAULT 'N',
  `be_incl` varchar(1) DEFAULT 'N',
  `brk_expiry_msg_in_sale` varchar(1) DEFAULT 'Y',
  `series_lock` varchar(255) DEFAULT NULL,
  `branch_trf` varchar(255) DEFAULT NULL,
  `trnf_account` varchar(255) DEFAULT NULL,
  `transport_code` varchar(255) DEFAULT '00',
  `transport_name` varchar(255) DEFAULT '0',
  `distance` int(11) DEFAULT NULL,
  `expiry_repl_credit` varchar(1) DEFAULT 'C',
  `max_os_amount` decimal(10,2) DEFAULT 0.00,
  `max_limit_on` varchar(1) DEFAULT 'D',
  `max_inv_amount` decimal(10,2) DEFAULT 0.00,
  `max_no_os_inv` int(11) DEFAULT 0,
  `follow_conditions_strictly` varchar(1) DEFAULT 'N',
  `credit_limit_days_lock` int(11) DEFAULT 0,
  `open_lock_once` varchar(1) DEFAULT 'N',
  `expiry_lock_type` varchar(1) DEFAULT 'A',
  `expiry_lock_value` decimal(10,2) DEFAULT 0.00,
  `no_of_expiries_per_month` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `code`, `tax_registration`, `pin_code`, `address2`, `address2_line2`, `address2_line3`, `address`, `address_line2`, `address_line3`, `city`, `country_code`, `country_name`, `telephone_office`, `telephone_residence`, `mobile`, `email`, `contact_person1`, `mobile_contact1`, `contact_person2`, `mobile_contact2`, `fax_number`, `opening_balance`, `balance_type`, `local_central`, `credit_days`, `birth_day`, `anniversary_day`, `status`, `flag`, `invoice_export`, `due_list_sequence`, `tan_number`, `msme_license`, `dl_number`, `dl_expiry`, `dl_number1`, `food_license`, `cst_number`, `tin_number`, `pan_number`, `sales_man_code`, `sales_man_name`, `area_code`, `area_name`, `route_code`, `route_name`, `state_code`, `state_name`, `business_type`, `description`, `order_required`, `aadhar_number`, `registration_date`, `end_date`, `day_value`, `gst_number`, `cst_registration`, `gst_name`, `state_code_gst`, `registration_status`, `created_date`, `modified_date`, `created_by`, `modified_by`, `is_deleted`, `deleted_at`, `bank`, `branch`, `closed_on`, `credit_limit`, `sale_rate_type`, `add_percent`, `tax_on_br_expiry`, `expiry_on`, `dis_after_scheme`, `expiry_rn_on`, `dis_on_excise`, `sale_pur_status`, `scm_type`, `net_rate`, `no_of_items_in_bill`, `invoice_print_order`, `sr_replacement`, `cash_sale`, `invoice_format`, `fixed_discount`, `gst_5_percent`, `gst_12_percent`, `gst_18_percent`, `gst_28_percent`, `gst_0_percent`, `ref`, `tds`, `add_charges_with_gst`, `tcs_applicable`, `be_incl`, `brk_expiry_msg_in_sale`, `series_lock`, `branch_trf`, `trnf_account`, `transport_code`, `transport_name`, `distance`, `expiry_repl_credit`, `max_os_amount`, `max_limit_on`, `max_inv_amount`, `max_no_os_inv`, `follow_conditions_strictly`, `credit_limit_days_lock`, `open_lock_once`, `expiry_lock_type`, `expiry_lock_value`, `no_of_expiries_per_month`) VALUES
(1, 'amansingh', NULL, 'R', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'D', 'L', NULL, NULL, NULL, NULL, NULL, 'N', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '00', NULL, '00', NULL, '00', NULL, '00', NULL, 'R', NULL, 'N', NULL, '2000-01-01', '2000-01-01', 0, NULL, NULL, NULL, '09', 'U', '2025-10-15 05:44:39', '2025-10-15 05:44:39', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0.00, '1', 0.00, 'N', 'M', 'Y', 'M', 'Y', 'S', 'F', 'N', 0, NULL, 'N', 'N', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 'N', 'N', 'N', 'N', 'Y', NULL, NULL, NULL, '00', '0', NULL, 'C', 0.00, 'D', 0.00, 0, 'N', 0, 'N', 'A', 0.00, 0),
(2, 'Mahesh Traders', 'dgffg', 'T', '35344', 'gdffdg', NULL, NULL, 'rtgert', NULL, NULL, 'meerut', NULL, NULL, '453453', '434534', '34534', 'admin@gmail.comm', 'dgsdfgd', '35353', 'fgdgfg', '345345', '234234', 0.12, 'C', 'C', NULL, '2025-10-17', '2025-10-17', '234234', '234234', 'Y', '8', NULL, NULL, '3234234', '2025-10-16', '234234234', '234234', '234342', '234234', '2342344', '00', NULL, '00', NULL, '00', NULL, '00', NULL, 'R', 'efserfwser', 'Y', '234234234', '2000-01-27', '2000-01-25', 34, '234234234', NULL, 'dsfsdfsd', '09', 'R', '2025-10-15 05:45:15', '2025-10-15 06:38:47', NULL, NULL, 0, NULL, 'KOTAK', 'sfsrftwer', NULL, 0.00, '1', 0.00, 'N', 'M', 'Y', 'M', 'Y', 'S', 'F', 'N', 0, NULL, 'N', 'N', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 'N', 'N', 'N', 'N', 'Y', NULL, NULL, NULL, '00', '0', NULL, 'C', 0.00, 'D', 0.00, 0, 'N', 0, 'N', 'A', 0.00, 0),
(3, 'fdggdv', NULL, 'R', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'D', 'L', NULL, NULL, NULL, NULL, NULL, 'N', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '00', NULL, '00', NULL, '00', NULL, '00', NULL, 'R', NULL, 'N', NULL, '2000-01-01', '2000-01-01', 0, NULL, NULL, NULL, '09', 'U', '2025-10-15 06:45:14', '2025-10-15 06:45:14', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0.00, '1', 0.00, 'N', 'M', 'Y', 'M', 'Y', 'S', 'F', 'N', 0, NULL, 'N', 'N', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 'N', 'N', 'N', 'N', 'Y', NULL, NULL, NULL, '00', '0', NULL, 'C', 0.00, 'D', 0.00, 0, 'N', 0, 'N', 'A', 0.00, 0),
(4, 'bcbcv', NULL, 'R', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'D', 'L', NULL, NULL, NULL, NULL, NULL, 'N', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '00', NULL, '00', NULL, '00', NULL, '00', NULL, 'R', NULL, 'N', NULL, '2000-01-01', '2000-01-01', 0, NULL, NULL, NULL, '09', 'U', '2025-10-15 06:45:21', '2025-10-15 06:45:21', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0.00, '1', 0.00, 'N', 'M', 'Y', 'M', 'Y', 'S', 'F', 'N', 0, NULL, 'N', 'N', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 'N', 'N', 'N', 'N', 'Y', NULL, NULL, NULL, '00', '0', NULL, 'C', 0.00, 'D', 0.00, 0, 'N', 0, 'N', 'A', 0.00, 0),
(5, 'fgdfgdg', NULL, 'R', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'D', 'L', NULL, NULL, NULL, NULL, NULL, 'N', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '00', NULL, '00', NULL, '00', NULL, '00', NULL, 'R', NULL, 'N', NULL, '2000-01-01', '2000-01-01', 0, NULL, NULL, NULL, '09', 'U', '2025-10-15 06:45:32', '2025-10-15 06:45:32', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0.00, '1', 0.00, 'N', 'M', 'Y', 'M', 'Y', 'S', 'F', 'N', 0, NULL, 'N', 'N', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 'N', 'N', 'N', 'N', 'Y', NULL, NULL, NULL, '00', '0', NULL, 'C', 0.00, 'D', 0.00, 0, 'N', 0, 'N', 'A', 0.00, 0),
(6, 'dfgdfgddfg', NULL, 'R', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'D', 'L', NULL, NULL, NULL, NULL, NULL, 'N', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '00', NULL, '00', NULL, '00', NULL, '00', NULL, 'R', NULL, 'N', NULL, '2000-01-01', '2000-01-01', 0, NULL, NULL, NULL, '09', 'U', '2025-10-15 06:45:41', '2025-10-15 06:45:41', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0.00, '1', 0.00, 'N', 'M', 'Y', 'M', 'Y', 'S', 'F', 'N', 0, NULL, 'N', 'N', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 'N', 'N', 'N', 'N', 'Y', NULL, NULL, NULL, '00', '0', NULL, 'C', 0.00, 'D', 0.00, 0, 'N', 0, 'N', 'A', 0.00, 0),
(7, 'dfgdfgd', NULL, 'R', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'D', 'L', NULL, NULL, NULL, NULL, NULL, 'N', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '00', NULL, '00', NULL, '00', NULL, '00', NULL, 'R', NULL, 'N', NULL, '2000-01-01', '2000-01-01', 0, NULL, NULL, NULL, '09', 'U', '2025-10-15 06:45:47', '2025-10-15 06:45:47', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0.00, '1', 0.00, 'N', 'M', 'Y', 'M', 'Y', 'S', 'F', 'N', 0, NULL, 'N', 'N', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 'N', 'N', 'N', 'N', 'Y', NULL, NULL, NULL, '00', '0', NULL, 'C', 0.00, 'D', 0.00, 0, 'N', 0, 'N', 'A', 0.00, 0),
(8, 'dfgdfgdfg', NULL, 'R', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'D', 'L', NULL, NULL, NULL, NULL, NULL, 'N', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '00', NULL, '00', NULL, '00', NULL, '00', NULL, 'R', NULL, 'N', NULL, '2000-01-01', '2000-01-01', 0, NULL, NULL, NULL, '09', 'U', '2025-10-15 06:45:54', '2025-10-15 06:45:54', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0.00, '1', 0.00, 'N', 'M', 'Y', 'M', 'Y', 'S', 'F', 'N', 0, NULL, 'N', 'N', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 'N', 'N', 'N', 'N', 'Y', NULL, NULL, NULL, '00', '0', NULL, 'C', 0.00, 'D', 0.00, 0, 'N', 0, 'N', 'A', 0.00, 0),
(9, 'dfgdfgd', NULL, 'R', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'D', 'L', NULL, NULL, NULL, NULL, NULL, 'N', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '00', NULL, '00', NULL, '00', NULL, '00', NULL, 'R', NULL, 'N', NULL, '2000-01-01', '2000-01-01', 0, NULL, NULL, NULL, '09', 'U', '2025-10-15 06:46:08', '2025-10-15 06:46:08', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0.00, '1', 0.00, 'N', 'M', 'Y', 'M', 'Y', 'S', 'F', 'N', 0, NULL, 'N', 'N', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 'N', 'N', 'N', 'N', 'Y', NULL, NULL, NULL, '00', '0', NULL, 'C', 0.00, 'D', 0.00, 0, 'N', 0, 'N', 'A', 0.00, 0),
(10, 'fgdfgdfg', NULL, 'R', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'D', 'L', NULL, NULL, NULL, NULL, NULL, 'N', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '00', NULL, '00', NULL, '00', NULL, '00', NULL, 'R', NULL, 'N', NULL, '2000-01-01', '2000-01-01', 0, NULL, NULL, NULL, '09', 'U', '2025-10-15 06:46:15', '2025-10-15 06:46:15', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0.00, '1', 0.00, 'N', 'M', 'Y', 'M', 'Y', 'S', 'F', 'N', 0, NULL, 'N', 'N', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 'N', 'N', 'N', 'N', 'Y', NULL, NULL, NULL, '00', '0', NULL, 'C', 0.00, 'D', 0.00, 0, 'N', 0, 'N', 'A', 0.00, 0),
(11, 'dfgdfgdf', NULL, 'R', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'D', 'L', NULL, NULL, NULL, NULL, NULL, 'N', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '00', NULL, '00', NULL, '00', NULL, '00', NULL, 'R', NULL, 'N', NULL, '2000-01-01', '2000-01-01', 0, NULL, NULL, NULL, '09', 'U', '2025-10-15 06:46:23', '2025-10-15 06:46:23', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0.00, '1', 0.00, 'N', 'M', 'Y', 'M', 'Y', 'S', 'F', 'N', 0, NULL, 'N', 'N', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 'N', 'N', 'N', 'N', 'Y', NULL, NULL, NULL, '00', '0', NULL, 'C', 0.00, 'D', 0.00, 0, 'N', 0, 'N', 'A', 0.00, 0),
(12, 'dfgdfgdfg', NULL, 'R', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'D', 'L', NULL, NULL, NULL, NULL, NULL, 'N', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '00', NULL, '00', NULL, '00', NULL, '00', NULL, 'R', NULL, 'N', NULL, '2000-01-01', '2000-01-01', 0, NULL, NULL, NULL, '09', 'U', '2025-10-15 06:46:30', '2025-10-15 06:46:30', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0.00, '1', 0.00, 'N', 'M', 'Y', 'M', 'Y', 'S', 'F', 'N', 0, NULL, 'N', 'N', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 'N', 'N', 'N', 'N', 'Y', NULL, NULL, NULL, '00', '0', NULL, 'C', 0.00, 'D', 0.00, 0, 'N', 0, 'N', 'A', 0.00, 0),
(13, 'dfgdfgd', NULL, 'R', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'D', 'L', NULL, NULL, NULL, NULL, NULL, 'N', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '00', NULL, '00', NULL, '00', NULL, '00', NULL, 'R', NULL, 'N', NULL, '2000-01-01', '2000-01-01', 0, NULL, NULL, NULL, '09', 'U', '2025-10-15 06:46:40', '2025-10-15 06:46:40', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0.00, '1', 0.00, 'N', 'M', 'Y', 'M', 'Y', 'S', 'F', 'N', 0, NULL, 'N', 'N', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 'N', 'N', 'N', 'N', 'Y', NULL, NULL, NULL, '00', '0', NULL, 'C', 0.00, 'D', 0.00, 0, 'N', 0, 'N', 'A', 0.00, 0),
(14, 'dfgdfgdf', NULL, 'R', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'D', 'L', NULL, NULL, NULL, NULL, NULL, 'N', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '00', NULL, '00', NULL, '00', NULL, '00', NULL, 'R', NULL, 'N', NULL, '2000-01-01', '2000-01-01', 0, NULL, NULL, NULL, '09', 'U', '2025-10-15 06:46:50', '2025-10-15 06:46:50', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0.00, '1', 0.00, 'N', 'M', 'Y', 'M', 'Y', 'S', 'F', 'N', 0, NULL, 'N', 'N', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 'N', 'N', 'N', 'N', 'Y', NULL, NULL, NULL, '00', '0', NULL, 'C', 0.00, 'D', 0.00, 0, 'N', 0, 'N', 'A', 0.00, 0),
(15, 'cvbcvcvvbc', NULL, 'R', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'D', 'L', NULL, NULL, NULL, NULL, NULL, 'N', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '00', NULL, '00', NULL, '00', NULL, '00', NULL, 'R', NULL, 'N', NULL, '2000-01-01', '2000-01-01', 0, NULL, NULL, NULL, '09', 'U', '2025-10-15 06:47:08', '2025-10-15 06:47:08', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0.00, '1', 0.00, 'N', 'M', 'Y', 'M', 'Y', 'S', 'F', 'N', 0, NULL, 'N', 'N', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 'N', 'N', 'N', 'N', 'Y', NULL, NULL, NULL, '00', '0', NULL, 'C', 0.00, 'D', 0.00, 0, 'N', 0, 'N', 'A', 0.00, 0),
(16, 'dfdfgdfg', NULL, 'R', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'D', 'L', NULL, NULL, NULL, NULL, NULL, 'N', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '00', NULL, '00', NULL, '00', NULL, '00', NULL, 'R', NULL, 'N', NULL, '2000-01-01', '2000-01-01', 0, NULL, NULL, NULL, '09', 'U', '2025-10-15 06:47:18', '2025-10-15 06:47:18', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0.00, '1', 0.00, 'N', 'M', 'Y', 'M', 'Y', 'S', 'F', 'N', 0, NULL, 'N', 'N', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 'N', 'N', 'N', 'N', 'Y', NULL, NULL, NULL, '00', '0', NULL, 'C', 0.00, 'D', 0.00, 0, 'N', 0, 'N', 'A', 0.00, 0),
(17, 'vcvbcvb', NULL, 'R', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'D', 'L', NULL, NULL, NULL, NULL, NULL, 'N', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '00', NULL, '00', NULL, '00', NULL, '00', NULL, 'R', NULL, 'N', NULL, '2000-01-01', '2000-01-01', 0, NULL, NULL, NULL, '09', 'U', '2025-10-15 06:47:27', '2025-10-15 06:47:27', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0.00, '1', 0.00, 'N', 'M', 'Y', 'M', 'Y', 'S', 'F', 'N', 0, NULL, 'N', 'N', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 'N', 'N', 'N', 'N', 'Y', NULL, NULL, NULL, '00', '0', NULL, 'C', 0.00, 'D', 0.00, 0, 'N', 0, 'N', 'A', 0.00, 0),
(18, 'gffgfgfg', NULL, 'R', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'D', 'L', NULL, NULL, NULL, NULL, NULL, 'N', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '00', NULL, '00', NULL, '00', NULL, '00', NULL, 'R', NULL, 'N', NULL, '2000-01-01', '2000-01-01', 0, NULL, NULL, NULL, '09', 'U', '2025-10-15 06:47:41', '2025-10-15 06:47:41', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0.00, '1', 0.00, 'N', 'M', 'Y', 'M', 'Y', 'S', 'F', 'N', 0, NULL, 'N', 'N', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 'N', 'N', 'N', 'N', 'Y', NULL, NULL, NULL, '00', '0', NULL, 'C', 0.00, 'D', 0.00, 0, 'N', 0, 'N', 'A', 0.00, 0),
(19, 'fghfgfgh', NULL, 'R', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '123456', NULL, NULL, '4534345345', NULL, '345345453', NULL, 0.00, 'D', 'L', NULL, NULL, NULL, NULL, NULL, 'N', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '00', NULL, '00', NULL, '00', NULL, '00', NULL, 'R', NULL, 'N', NULL, '2000-01-01', '2000-01-01', 0, NULL, NULL, NULL, '09', 'U', '2025-10-15 06:47:49', '2025-10-15 07:00:09', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0.00, '1', 0.00, 'N', 'M', 'Y', 'M', 'Y', 'S', 'F', 'N', 0, NULL, 'N', 'N', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 'N', 'N', 'N', 'N', 'Y', NULL, NULL, NULL, '00', '0', NULL, 'C', 0.00, 'D', 0.00, 0, 'N', 0, 'N', 'A', 0.00, 0),
(20, 'fghfgfg', NULL, 'R', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'D', 'L', NULL, NULL, NULL, NULL, NULL, 'N', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '00', NULL, '00', NULL, '00', NULL, '00', NULL, 'R', NULL, 'N', NULL, '2000-01-01', '2000-01-01', 0, NULL, NULL, NULL, '09', 'U', '2025-10-15 06:48:06', '2025-10-15 06:48:06', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0.00, '1', 0.00, 'N', 'M', 'Y', 'M', 'Y', 'S', 'F', 'N', 0, NULL, 'N', 'N', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 'N', 'N', 'N', 'N', 'Y', NULL, NULL, NULL, '00', '0', NULL, 'C', 0.00, 'D', 0.00, 0, 'N', 0, 'N', 'A', 0.00, 0),
(21, 'yyyghg', NULL, 'R', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.00, 'D', 'L', NULL, NULL, NULL, NULL, NULL, 'N', '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '00', NULL, '00', NULL, '00', NULL, '00', NULL, 'R', NULL, 'N', NULL, '2000-01-01', '2000-01-01', 0, NULL, NULL, NULL, '09', 'U', '2025-10-15 06:48:19', '2025-10-15 06:48:19', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0.00, '1', 0.00, 'N', 'M', 'Y', 'M', 'Y', 'S', 'F', 'N', 0, NULL, 'N', 'N', 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 'N', 'N', 'N', 'N', 'Y', NULL, NULL, NULL, '00', '0', NULL, 'C', 0.00, 'D', 0.00, 0, 'N', 0, 'N', 'A', 0.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `customer_challans`
--

CREATE TABLE `customer_challans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `challan_date` date NOT NULL,
  `trans_no` varchar(255) DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `hold` tinyint(1) NOT NULL DEFAULT 0,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_discounts`
--

CREATE TABLE `customer_discounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `discount_type` enum('Breakage','Expiry') NOT NULL DEFAULT 'Breakage',
  `discount_percent` decimal(5,2) NOT NULL,
  `effective_from` date NOT NULL,
  `effective_to` date DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_dues`
--

CREATE TABLE `customer_dues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `trans_no` varchar(255) DEFAULT NULL,
  `invoice_date` date NOT NULL,
  `days_from_invoice` int(11) NOT NULL DEFAULT 0,
  `due_date` date NOT NULL,
  `days_from_due` int(11) NOT NULL DEFAULT 0,
  `trans_amount` decimal(12,2) NOT NULL,
  `debit` decimal(12,2) NOT NULL DEFAULT 0.00,
  `credit` decimal(12,2) NOT NULL DEFAULT 0.00,
  `hold` tinyint(1) NOT NULL DEFAULT 0,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_dues`
--

INSERT INTO `customer_dues` (`id`, `customer_id`, `trans_no`, `invoice_date`, `days_from_invoice`, `due_date`, `days_from_due`, `trans_amount`, `debit`, `credit`, `hold`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 21, 'SB/23432', '2025-10-28', 0, '2025-11-27', -30, 2343.00, 2343.00, 0.00, 0, NULL, '2025-10-28 06:17:18', '2025-10-28 06:17:18'),
(2, 21, 'SB/98897', '2025-10-28', 0, '2025-11-27', -30, 87686.00, 87686.00, 0.00, 0, NULL, '2025-10-28 06:19:04', '2025-10-28 06:19:04'),
(3, 21, 'SB/6363', '2025-10-28', 1, '2025-11-27', -29, 765567.00, 765567.00, 0.00, 0, NULL, '2025-10-28 06:47:58', '2025-10-28 06:47:58'),
(4, 21, 'SB/544', '2025-10-28', 1, '2025-11-27', -29, 5464.00, 5464.00, 0.00, 0, NULL, '2025-10-28 06:48:13', '2025-10-28 06:48:13'),
(5, 21, 'SB/765', '2025-10-28', 1, '2025-11-27', -29, 786.00, 786.00, 0.00, 0, NULL, '2025-10-28 08:08:34', '2025-10-28 08:08:34');

-- --------------------------------------------------------

--
-- Table structure for table `customer_ledgers`
--

CREATE TABLE `customer_ledgers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_date` date NOT NULL,
  `trans_no` varchar(255) DEFAULT NULL,
  `transaction_type` enum('Sale','Return','Payment','Adjustment') NOT NULL DEFAULT 'Sale',
  `amount` decimal(12,2) NOT NULL,
  `running_balance` decimal(12,2) NOT NULL DEFAULT 0.00,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_ledgers`
--

INSERT INTO `customer_ledgers` (`id`, `customer_id`, `transaction_date`, `trans_no`, `transaction_type`, `amount`, `running_balance`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 21, '2025-10-28', 'TXN001', 'Sale', 5000.00, 0.00, 'Test Sale', '2025-10-28 04:18:38', '2025-10-28 04:18:38'),
(2, 21, '2025-10-28', 'TXN002', 'Payment', 2000.00, 0.00, 'Test Payment', '2025-10-28 04:18:38', '2025-10-28 04:18:38');

-- --------------------------------------------------------

--
-- Table structure for table `customer_prescriptions`
--

CREATE TABLE `customer_prescriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `doctor_name` varchar(255) NOT NULL,
  `patient_name` varchar(255) NOT NULL,
  `prescription_date` date NOT NULL,
  `validity_date` date NOT NULL,
  `details` text DEFAULT NULL,
  `status` enum('Active','Expired','Cancelled') NOT NULL DEFAULT 'Active',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_prescriptions`
--

INSERT INTO `customer_prescriptions` (`id`, `customer_id`, `doctor_name`, `patient_name`, `prescription_date`, `validity_date`, `details`, `status`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 21, 'Dr. Smith', 'John Doe', '2025-10-28', '2025-11-27', 'Test prescription', 'Active', NULL, '2025-10-28 04:18:38', '2025-10-28 04:18:38');

-- --------------------------------------------------------

--
-- Table structure for table `customer_special_rates`
--

CREATE TABLE `customer_special_rates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `special_rate` decimal(10,2) NOT NULL,
  `effective_from` date NOT NULL,
  `effective_to` date DEFAULT NULL,
  `rate_type` enum('Fixed','Percentage') NOT NULL DEFAULT 'Fixed',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `divisional_managers`
--

CREATE TABLE `divisional_managers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `c_mgr` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `divisional_managers`
--

INSERT INTO `divisional_managers` (`id`, `code`, `name`, `email`, `mobile`, `address`, `telephone`, `status`, `c_mgr`, `created_at`, `updated_at`) VALUES
(1, 'DC001', 'Anil Sharma', 'anil.sharma@company.com', '9876543220', 'Corporate Office, Connaught Place, New Delhi', NULL, 'Active', NULL, '2025-10-27 05:25:10', '2025-10-27 05:25:10'),
(2, 'DC002', 'Deepika Patel', 'deepika.patel@company.com', '9876543221', 'Business Center, Andheri East, Mumbai, Maharashtra', NULL, 'Active', NULL, '2025-10-27 05:25:10', '2025-10-27 05:25:10'),
(3, 'DC003', 'Ravi Kumar', 'ravi.kumar@company.com', '9876543222', 'Tech Hub, Koramangala, Bangalore, Karnataka', NULL, 'Active', NULL, '2025-10-27 05:25:10', '2025-10-27 05:25:10'),
(4, 'DC004', 'Sneha Reddy', 'sneha.reddy@company.com', '9876543223', 'Cyber Towers, HITEC City, Hyderabad, Telangana', NULL, 'Active', NULL, '2025-10-27 05:25:10', '2025-10-27 05:25:10'),
(5, 'DC005', 'Manish Gupta', 'manish.gupta@company.com', '9876543224', 'Commercial Complex, Satellite, Ahmedabad, Gujarat', NULL, 'Active', NULL, '2025-10-27 05:25:10', '2025-10-27 05:25:10'),
(6, 'DC006', 'Priyanka Nair', 'priyanka.nair@company.com', '9876543225', 'IT Park, Technopark, Thiruvananthapuram, Kerala', NULL, 'Inactive', NULL, '2025-10-27 05:25:10', '2025-10-27 05:25:10'),
(7, 'DC007', 'Sanjay Banerjee', 'sanjay.banerjee@company.com', '9876543226', 'IT Hub, Salt Lake City, Kolkata, West Bengal', NULL, 'Active', NULL, '2025-10-27 05:25:10', '2025-10-27 05:25:10'),
(8, 'DC008', 'Lakshmi Krishnan', 'lakshmi.krishnan@company.com', '9876543227', 'Software Park, Sholinganallur, Chennai, Tamil Nadu', NULL, 'Active', NULL, '2025-10-27 05:25:10', '2025-10-27 05:25:10'),
(9, 'DC009', 'Rohit Malhotra', 'rohit.malhotra@company.com', '9876543228', 'Industrial Area, Phase 8B, Mohali, Punjab', NULL, 'Active', NULL, '2025-10-27 05:25:10', '2025-10-27 05:25:10'),
(10, 'DC010', 'Kavita Agarwal', 'kavita.agarwal@company.com', '9876543229', 'Business District, Malviya Nagar, Jaipur, Rajasthan', NULL, 'Active', NULL, '2025-10-27 05:25:10', '2025-10-27 05:25:10');

-- --------------------------------------------------------

--
-- Table structure for table `expiry_ledger`
--

CREATE TABLE `expiry_ledger` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `batch_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transaction_date` date NOT NULL,
  `trans_no` varchar(255) DEFAULT NULL,
  `transaction_type` varchar(255) NOT NULL,
  `party_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `free_quantity` int(11) NOT NULL DEFAULT 0,
  `running_balance` decimal(10,2) NOT NULL,
  `expiry_date` date NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_ledgers`
--

CREATE TABLE `general_ledgers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `account_code` varchar(50) DEFAULT NULL,
  `alter_code` varchar(50) DEFAULT NULL COMMENT 'Alternate code for the ledger',
  `under` varchar(255) DEFAULT NULL COMMENT 'Parent ledger or category',
  `opening_balance` decimal(15,2) DEFAULT 0.00,
  `balance_type` char(1) DEFAULT 'C' COMMENT 'D=Debit, C=Credit',
  `input_gst_purchase` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Input GST (Purchase)',
  `output_gst_income` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Output GST (Income)',
  `flag` varchar(50) DEFAULT NULL COMMENT 'Flag for ledger',
  `address` text DEFAULT NULL COMMENT 'Address',
  `address_line2` varchar(255) DEFAULT NULL COMMENT 'Address Line 2',
  `address_line3` varchar(255) DEFAULT NULL COMMENT 'Address Line 3',
  `birth_day` varchar(10) DEFAULT NULL COMMENT 'Birth Day (DD/MM)',
  `anniversary_day` varchar(10) DEFAULT NULL COMMENT 'Anniversary Day (DD/MM)',
  `telephone` varchar(20) DEFAULT NULL COMMENT 'Telephone',
  `email` varchar(255) DEFAULT NULL COMMENT 'Email',
  `fax` varchar(20) DEFAULT NULL COMMENT 'Fax',
  `mobile_1` varchar(20) DEFAULT NULL COMMENT 'Mobile',
  `mobile_2` varchar(20) DEFAULT NULL COMMENT 'Mobile Additional',
  `contact_person_1` varchar(255) DEFAULT NULL COMMENT 'Contact Person I',
  `contact_person_2` varchar(255) DEFAULT NULL COMMENT 'Contact Person II',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_ledgers`
--

INSERT INTO `general_ledgers` (`id`, `account_name`, `account_code`, `alter_code`, `under`, `opening_balance`, `balance_type`, `input_gst_purchase`, `output_gst_income`, `flag`, `address`, `address_line2`, `address_line3`, `birth_day`, `anniversary_day`, `telephone`, `email`, `fax`, `mobile_1`, `mobile_2`, `contact_person_1`, `contact_person_2`, `created_at`, `updated_at`) VALUES
(2, 'vbn', NULL, NULL, NULL, 0.00, 'C', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-15 02:09:32', '2025-10-15 02:09:32'),
(3, 'gfdg', NULL, NULL, NULL, 0.00, 'C', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-15 02:11:44', '2025-10-15 02:11:44'),
(4, 'ert', NULL, NULL, NULL, 0.00, 'C', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-15 02:11:50', '2025-10-15 02:11:50'),
(5, 'tyuftyu', NULL, NULL, NULL, 0.00, 'C', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-15 02:14:13', '2025-10-15 02:14:13'),
(6, 'ghjfghj', NULL, NULL, NULL, 0.00, 'C', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-15 02:14:18', '2025-10-15 02:14:18'),
(7, 'ghjfg', NULL, NULL, NULL, 0.00, 'C', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-15 02:14:24', '2025-10-15 02:14:24'),
(8, 'jhgkjk', NULL, NULL, NULL, 0.00, 'C', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-15 02:14:31', '2025-10-15 02:14:31'),
(9, 'hjkghj', NULL, NULL, NULL, 0.00, 'C', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-15 02:14:40', '2025-10-15 02:14:40'),
(10, 'hjkghkghj', NULL, NULL, NULL, 0.00, 'C', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-15 02:14:45', '2025-10-15 02:14:45'),
(11, 'hjkhgjk', NULL, NULL, NULL, 0.00, 'C', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-15 02:14:50', '2025-10-15 02:14:50'),
(12, 'hjkhjkh', NULL, NULL, NULL, 0.00, 'C', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-15 02:14:55', '2025-10-15 02:14:55'),
(13, 'hjkhgkh', NULL, NULL, NULL, 0.00, 'C', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-15 02:15:02', '2025-10-15 02:15:02'),
(14, 'Testing User', NULL, NULL, 'Current', 0.00, 'C', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-15 02:15:13', '2025-10-23 07:48:05');

-- --------------------------------------------------------

--
-- Table structure for table `general_managers`
--

CREATE TABLE `general_managers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `dc_mgr` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_managers`
--

INSERT INTO `general_managers` (`id`, `name`, `code`, `address`, `telephone`, `mobile`, `email`, `status`, `dc_mgr`, `created_at`, `updated_at`) VALUES
(1, 'GERG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-28 07:40:32', '2025-10-28 07:40:32'),
(2, 'FSD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-28 07:40:37', '2025-10-28 07:40:37'),
(3, 'FVSD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-28 07:40:42', '2025-10-28 07:40:42');

-- --------------------------------------------------------

--
-- Table structure for table `general_notebooks`
--

CREATE TABLE `general_notebooks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_reminders`
--

CREATE TABLE `general_reminders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_reminders`
--

INSERT INTO `general_reminders` (`id`, `name`, `code`, `due_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Annual Meeting', 'AM001', '2025-01-15', 'Pending', '2025-10-29 01:17:46', '2025-10-29 01:17:46'),
(2, 'Tax Filing', 'TF002', '2025-01-31', 'Urgent', '2025-10-29 01:17:46', '2025-10-29 01:17:46'),
(3, 'Insurance Renewal', 'IR003', '2025-02-10', 'Pending', '2025-10-29 01:17:46', '2025-10-29 01:17:46'),
(4, 'Audit Preparation', 'AP004', '2025-02-20', 'In Progress', '2025-10-29 01:17:46', '2025-10-29 01:17:46'),
(5, 'License Renewal', 'LR005', '2025-03-05', 'Pending', '2025-10-29 01:17:46', '2025-10-29 01:17:46'),
(6, 'Contract Review', 'CR006', '2025-03-15', 'Completed', '2025-10-29 01:17:46', '2025-10-29 01:17:46'),
(7, 'Quarterly Report', 'QR007', '2025-03-31', 'Pending', '2025-10-29 01:17:46', '2025-10-29 01:17:46'),
(8, 'Staff Appraisal', 'SA008', '2025-04-10', 'In Progress', '2025-10-29 01:17:46', '2025-10-29 01:17:46'),
(9, 'Budget Planning', 'BP009', '2025-04-20', 'Pending', '2025-10-29 01:17:46', '2025-10-29 01:17:46'),
(10, 'Vendor Payment', 'VP010', '2025-05-01', 'Urgent', '2025-10-29 01:17:46', '2025-10-29 01:17:46'),
(11, 'Equipment Maintenance', 'EM011', '2025-05-15', 'Pending', '2025-10-29 01:17:46', '2025-10-29 01:17:46'),
(12, 'Safety Inspection', 'SI012', '2025-05-25', 'Scheduled', '2025-10-29 01:17:46', '2025-10-29 01:17:46'),
(13, 'Training Session', 'TS013', '2025-06-05', 'Pending', '2025-10-29 01:17:46', '2025-10-29 01:17:46'),
(14, 'Product Launch', 'PL014', '2025-06-15', 'In Progress', '2025-10-29 01:17:46', '2025-10-29 01:17:46'),
(15, 'Marketing Campaign', 'MC015', '2025-06-30', 'Pending', '2025-10-29 01:17:46', '2025-10-29 01:17:46'),
(16, 'Client Meeting', 'CM016', '2025-07-10', 'Confirmed', '2025-10-29 01:17:46', '2025-10-29 01:17:46'),
(17, 'Inventory Check', 'IC017', '2025-07-20', 'Pending', '2025-10-29 01:17:46', '2025-10-29 01:17:46'),
(18, 'System Upgrade', 'SU018', '2025-08-01', 'Planned', '2025-10-29 01:17:46', '2025-10-29 01:17:46'),
(19, 'Compliance Review', 'CR019', '2025-08-15', 'Pending', '2025-10-29 01:17:46', '2025-10-29 01:17:46'),
(20, 'Lease Renewal', 'LR020', '2025-08-31', 'Urgent', '2025-10-29 01:17:46', '2025-10-29 01:17:46'),
(21, 'Performance Review', 'PR021', '2025-09-10', 'Pending', '2025-10-29 01:17:46', '2025-10-29 01:17:46'),
(22, 'Salary Revision', 'SR022', '2025-09-20', 'In Progress', '2025-10-29 01:17:46', '2025-10-29 01:17:46'),
(23, 'Board Meeting', 'BM023', '2025-10-05', 'Scheduled', '2025-10-29 01:17:46', '2025-10-29 01:17:46'),
(24, 'Financial Audit', 'FA024', '2025-10-15', 'Pending', '2025-10-29 01:17:46', '2025-10-29 01:17:46'),
(25, 'Year End Closing', 'YE025', '2025-12-31', 'Pending', '2025-10-29 01:17:46', '2025-10-29 01:17:46'),
(26, 'GST Filing', 'GF026', '2025-01-20', 'Urgent', '2025-10-29 01:17:46', '2025-10-29 01:17:46'),
(27, 'PF Submission', 'PF027', '2025-02-15', 'Pending', '2025-10-29 01:17:46', '2025-10-29 01:17:46'),
(28, 'ESI Payment', 'EP028', '2025-03-10', 'Pending', '2025-10-29 01:17:46', '2025-10-29 01:17:46'),
(29, 'TDS Return', 'TR029', '2025-04-30', 'Urgent', '2025-10-29 01:17:46', '2025-10-29 01:17:46'),
(30, 'Stock Verification', 'SV030', '2025-05-31', 'Pending', '2025-10-29 01:17:46', '2025-10-29 01:17:46');

-- --------------------------------------------------------

--
-- Table structure for table `godown_expiry`
--

CREATE TABLE `godown_expiry` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `batch_id` bigint(20) UNSIGNED NOT NULL,
  `expiry_date` date NOT NULL,
  `quantity` int(11) NOT NULL,
  `godown_location` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hsn_codes`
--

CREATE TABLE `hsn_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT 'HSN Code Name/Description',
  `hsn_code` varchar(255) DEFAULT NULL COMMENT 'HSN Code Number',
  `cgst_percent` decimal(5,2) NOT NULL DEFAULT 0.00 COMMENT 'CGST Percentage',
  `sgst_percent` decimal(5,2) NOT NULL DEFAULT 0.00 COMMENT 'SGST Percentage',
  `igst_percent` decimal(5,2) NOT NULL DEFAULT 0.00 COMMENT 'IGST Percentage',
  `total_gst_percent` decimal(5,2) NOT NULL DEFAULT 0.00 COMMENT 'Total GST Percentage',
  `is_inactive` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Inactive flag',
  `is_service` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Service flag',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hsn_codes`
--

INSERT INTO `hsn_codes` (`id`, `name`, `hsn_code`, `cgst_percent`, `sgst_percent`, `igst_percent`, `total_gst_percent`, `is_inactive`, `is_service`, `created_at`, `updated_at`) VALUES
(1, 'Insulin Injection', '33049990', 0.00, 0.00, 0.00, 0.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(2, 'Anti-Cancer Drug - Cisplatin', '30059090', 0.00, 0.00, 0.00, 0.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(3, 'HIV Medicine - Efavirenz', '30059090', 0.00, 0.00, 0.00, 0.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(4, 'Tuberculosis Medicine - Rifampicin', '34029011', 0.00, 0.00, 0.00, 0.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(5, 'Paracetamol 500mg Tablet', '30051090', 6.00, 6.00, 12.00, 12.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(6, 'Cetirizine 10mg Tablet', '30051090', 6.00, 6.00, 12.00, 12.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(7, 'Amoxicillin 500mg Capsule', '30051090', 6.00, 6.00, 12.00, 12.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(8, 'Metformin 500mg Tablet', '90189011', 6.00, 6.00, 12.00, 12.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(9, 'Atorvastatin 10mg Tablet', '90189019', 6.00, 6.00, 12.00, 12.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(10, 'Omeprazole 20mg Capsule', '90192090', 6.00, 6.00, 12.00, 12.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(11, 'Pantoprazole 40mg Tablet', '38220090', 6.00, 6.00, 12.00, 12.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(12, 'Azithromycin 500mg Tablet', '90183990', 6.00, 6.00, 12.00, 12.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(13, 'Losartan 50mg Tablet', '90189011', 6.00, 6.00, 12.00, 12.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(14, 'Vitamin D3 Capsule', '30059090', 9.00, 9.00, 18.00, 18.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(15, 'Multivitamin Tablet', '34011190', 9.00, 9.00, 18.00, 18.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(16, 'Calcium Supplement', '34011190', 9.00, 9.00, 18.00, 18.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(17, 'Protein Powder', '34013011', 9.00, 9.00, 18.00, 18.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(18, 'Omega-3 Capsule', '34029011', 9.00, 9.00, 18.00, 18.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(19, 'Glucosamine Tablet', '38246090', 9.00, 9.00, 18.00, 18.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(20, 'Probiotic Capsule', '90251110', 9.00, 9.00, 18.00, 18.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(21, 'Biotin Tablet', '90251910', 9.00, 9.00, 18.00, 18.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(22, 'Cough Syrup - Bromhexine', '30049990', 6.00, 6.00, 12.00, 12.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(23, 'Paediatric Drops - Iron', '30051090', 6.00, 6.00, 12.00, 12.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(24, 'Antacid Syrup', '90189011', 6.00, 6.00, 12.00, 12.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(25, 'Diclofenac Gel', '30059090', 9.00, 9.00, 18.00, 18.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(26, 'Betamethasone Cream', '34011190', 9.00, 9.00, 18.00, 18.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(27, 'Clotrimazole Cream', '34029011', 9.00, 9.00, 18.00, 18.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(28, 'Diclofenac Injection', '30051090', 6.00, 6.00, 12.00, 12.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(29, 'Vitamin B12 Injection', '90189019', 6.00, 6.00, 12.00, 12.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(30, 'Chyawanprash 500g', '90192090', 6.00, 6.00, 12.00, 12.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(31, 'Triphala Churna', '90183990', 6.00, 6.00, 12.00, 12.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(32, 'Ashwagandha Capsule', '90189011', 6.00, 6.00, 12.00, 12.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(33, 'Bandage Roll', '38220090', 6.00, 6.00, 12.00, 12.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(34, 'Cotton Wool 100g', '90183990', 6.00, 6.00, 12.00, 12.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(35, 'Surgical Gloves', '90189019', 6.00, 6.00, 12.00, 12.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(36, 'Glucometer Device', '90192090', 6.00, 6.00, 12.00, 12.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(37, 'Blood Glucose Strips', '90189011', 6.00, 6.00, 12.00, 12.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(38, 'Insulin Syringe', '90189019', 6.00, 6.00, 12.00, 12.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(39, 'Ibuprofen 400mg Tablet', '30051090', 6.00, 6.00, 12.00, 12.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(40, 'Aspirin 75mg Tablet', '90189011', 6.00, 6.00, 12.00, 12.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(41, 'Dettol Liquid 500ml', '34029011', 9.00, 9.00, 18.00, 18.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(42, 'Savlon Antiseptic', '34029011', 9.00, 9.00, 18.00, 18.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(43, 'Hand Sanitizer 200ml', '38246090', 9.00, 9.00, 18.00, 18.00, 0, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(44, 'Old Formula Crocin', '30051090', 6.00, 6.00, 12.00, 12.00, 1, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17'),
(45, 'Discontinued Syrup', '30049990', 6.00, 6.00, 12.00, 12.00, 1, 0, '2025-10-15 13:11:17', '2025-10-15 13:11:17');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(255) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `company_address` text DEFAULT NULL,
  `company_email` varchar(255) DEFAULT NULL,
  `company_phone` varchar(255) DEFAULT NULL,
  `company_gst` varchar(255) DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  `customer_address` text DEFAULT NULL,
  `customer_gst` varchar(255) DEFAULT NULL,
  `customer_state` varchar(255) DEFAULT NULL,
  `customer_state_code` varchar(255) DEFAULT NULL,
  `subtotal` decimal(15,2) DEFAULT NULL,
  `tax_amount` decimal(15,2) DEFAULT NULL,
  `discount_amount` decimal(15,2) DEFAULT NULL,
  `total_amount` decimal(15,2) DEFAULT NULL,
  `paid_amount` decimal(15,2) DEFAULT NULL,
  `balance_amount` decimal(15,2) DEFAULT NULL,
  `cgst_amount` decimal(15,2) DEFAULT NULL,
  `sgst_amount` decimal(15,2) DEFAULT NULL,
  `igst_amount` decimal(15,2) DEFAULT NULL,
  `cess_amount` decimal(15,2) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `terms_conditions` text DEFAULT NULL,
  `payment_terms` text DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`invoice_id`, `invoice_number`, `invoice_date`, `due_date`, `status`, `company_id`, `company_name`, `company_address`, `company_email`, `company_phone`, `company_gst`, `customer_id`, `customer_name`, `customer_email`, `customer_phone`, `customer_address`, `customer_gst`, `customer_state`, `customer_state_code`, `subtotal`, `tax_amount`, `discount_amount`, `total_amount`, `paid_amount`, `balance_amount`, `cgst_amount`, `sgst_amount`, `igst_amount`, `cess_amount`, `notes`, `terms_conditions`, `payment_terms`, `currency`, `created_at`, `updated_at`, `created_by`, `updated_by`, `is_deleted`, `deleted_at`) VALUES
(24, 'INV-2025-1006', '2025-10-13', '2025-10-15', 'draft', 67, 'Bharti Airtel Ltd', 'New Delhi', 'support@airtel.com', '01146661000', '07AAACB2516N1ZH', 12, 'Crest Electronics', 'sales@crestelect.example', '9078563412', '45 Salt Lake Sector V', 'TR-1003', 'Kolkata', 'WB', 33.13, 5.96, 0.00, 39.09, 0.00, 39.09, 2.98, 2.98, 0.00, NULL, NULL, NULL, NULL, 'INR', '2025-10-13 04:44:48', '2025-10-13 04:59:56', NULL, NULL, 0, NULL),
(25, 'INV-2025-1007', '2025-10-13', '2025-10-16', 'draft', 83, 'Meesho Ecommerce Pvt Ltd', 'Bangalore, Karnataka', 'hello@meesho.com', '08067455500', '29AAHCM6920C1ZY', 27, 'Rival Motors', 'service@rivalmotors.example', '9301122334', 'Plot 5, Automotive Park', 'TR-1018', 'Pune', 'MH', 164.11, 29.54, 0.00, 193.65, 0.00, 193.65, 14.77, 14.77, 0.00, NULL, NULL, NULL, NULL, 'INR', '2025-10-13 04:45:08', '2025-10-13 04:45:08', NULL, NULL, 0, NULL),
(26, 'INV-2025-1008', '2025-10-13', '2025-10-16', 'draft', 71, 'Mahindra & Mahindra', 'Mumbai, Maharashtra', 'mm@mahindra.com', '02228468800', '27AAACM0307A1ZF', 12, 'Crest Electronics', 'sales@crestelect.example', '9078563412', '45 Salt Lake Sector V', 'TR-1003', 'Kolkata', 'WB', 32.48, 5.85, 0.00, 38.33, 0.00, 38.33, 2.92, 2.92, 0.00, NULL, NULL, NULL, NULL, 'INR', '2025-10-13 04:45:32', '2025-10-13 04:45:32', NULL, NULL, 0, NULL),
(27, 'INV-2025-1009', '2025-10-13', '2025-10-16', 'draft', 78, 'Paytm E-Commerce Pvt Ltd', 'Noida, Uttar Pradesh', 'care@paytm.com', '01204456200', '09AALCP6162M1ZU', 20, 'Kiran Pharma', 'info@kiranpharma.example', '9843011122', '12 Sree Krishna St', 'TR-1011', 'Coimbatore', 'TN', 28.00, 5.04, 0.00, 33.04, 0.00, 33.04, 2.52, 2.52, 0.00, NULL, NULL, NULL, NULL, 'INR', '2025-10-13 04:45:51', '2025-10-13 04:45:51', NULL, NULL, 0, NULL),
(28, 'INV-2025-1010', '2025-10-13', '2025-10-17', 'draft', 83, 'Meesho Ecommerce Pvt Ltd', 'Bangalore, Karnataka', 'hello@meesho.com', '08067455500', '29AAHCM6920C1ZY', 19, 'Jupiter Textiles', 'sales@jupitertext.example', '9811223344', 'Shop 21, Janpath', 'TR-1010', 'New Delhi', 'DL', 21.92, 3.95, 0.00, 25.87, 0.00, 25.87, 1.97, 1.97, 0.00, NULL, NULL, NULL, NULL, 'INR', '2025-10-13 04:46:09', '2025-10-13 04:46:09', NULL, NULL, 0, NULL),
(29, 'INV-2025-1011', '2025-10-13', '2025-10-15', 'draft', 86, 'Udaan Commerce Pvt Ltd', 'Bangalore, Karnataka', 'support@udaan.com', '08046006100', '29AADCU4536P1ZB', 25, 'Prism IT Solutions', 'team@prismit.example', '9876501234', '2nd Floor, Sector 17', 'TR-1016', 'Chandigarh', 'CH', 50.29, 9.05, 0.00, 59.34, 0.00, 59.34, 4.53, 4.53, 0.00, NULL, NULL, NULL, NULL, 'INR', '2025-10-13 04:46:49', '2025-10-13 05:00:07', NULL, NULL, 0, NULL),
(30, 'INV-2025-1012', '2025-10-13', '2025-10-16', 'draft', 86, 'Udaan Commerce Pvt Ltd', 'Bangalore, Karnataka', 'support@udaan.com', '08046006100', '29AADCU4536P1ZB', 27, 'Rival Motors', 'service@rivalmotors.example', '9301122334', 'Plot 5, Automotive Park', 'TR-1018', 'Pune', 'MH', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, 'INR', '2025-10-13 04:47:30', '2025-10-13 04:47:30', NULL, NULL, 0, NULL),
(32, 'INV-2025-1013', '2025-10-13', NULL, 'paid', NULL, NULL, NULL, NULL, NULL, NULL, 10, 'Alpha Traders', 'info@alphatraders.example', '9876543210', '12 MG Road, Near Park', 'TR-1001', 'Bengaluru', 'KA', 12.19, 2.19, 0.00, 14.38, 0.00, 14.38, 1.10, 1.10, 0.00, NULL, NULL, NULL, NULL, 'INR', '2025-10-14 04:13:49', '2025-10-14 04:13:49', NULL, NULL, 0, NULL),
(33, 'INV-2025-1014', '2025-10-13', NULL, 'paid', NULL, NULL, NULL, NULL, NULL, NULL, 11, 'Bright Foods', 'contact@brightfoods.example', '9123456780', '67 Ocean Ave', 'TR-1002', 'Mumbai', 'MH', 26.67, 4.80, 0.00, 31.47, 0.00, 31.47, 2.40, 2.40, 0.00, NULL, NULL, NULL, NULL, 'INR', '2025-10-14 04:17:57', '2025-10-14 04:17:57', NULL, NULL, 0, NULL),
(35, 'INV-2025-1015', '2025-10-15', NULL, 'draft', NULL, NULL, NULL, NULL, NULL, NULL, 10, 'Alpha Traders', 'info@alphatraders.example', '9876543210', '12 MG Road, Near Park', 'TR-1001', 'Bengaluru', 'KA', 228.10, 41.06, 0.00, 269.16, 0.00, 269.16, 20.53, 20.53, 0.00, NULL, NULL, NULL, NULL, 'INR', '2025-10-15 00:06:00', '2025-10-15 00:06:00', NULL, NULL, 0, NULL),
(36, 'INV-2025-1016', '2025-10-15', NULL, 'draft', NULL, NULL, NULL, NULL, NULL, NULL, 13, 'Dunya Imports', 'hello@dunya.example', '9810012345', '8 Connaught Place', 'TR-1004', 'New Delhi', 'DL', 70.18, 12.63, 0.00, 0.00, 0.00, 82.81, 6.32, 6.32, 0.00, NULL, NULL, NULL, NULL, 'INR', '2025-10-15 02:57:22', '2025-10-15 02:57:22', NULL, NULL, 0, NULL),
(37, 'INV-2025-1017', '2025-10-15', NULL, 'draft', NULL, NULL, NULL, NULL, NULL, NULL, 13, 'Dunya Imports', 'hello@dunya.example', '9810012345', '8 Connaught Place', 'TR-1004', 'New Delhi', 'DL', 70.18, 12.63, 0.00, 0.00, 0.00, 82.81, 6.32, 6.32, 0.00, NULL, NULL, NULL, NULL, 'INR', '2025-10-15 02:58:05', '2025-10-15 02:58:05', NULL, NULL, 0, NULL),
(38, 'INV-2025-1018', '2025-10-15', NULL, 'draft', NULL, NULL, NULL, NULL, NULL, NULL, 11, 'Bright Foods', 'contact@brightfoods.example', '9123456780', '67 Ocean Ave', 'TR-1002', 'Mumbai', 'MH', 99.64, 17.94, 0.00, 0.00, 0.00, 117.58, 8.97, 8.97, 0.00, NULL, NULL, NULL, NULL, 'INR', '2025-10-15 02:59:13', '2025-10-15 02:59:13', NULL, NULL, 0, NULL),
(39, 'INV-2025-1019', '2025-10-15', NULL, 'draft', NULL, NULL, NULL, NULL, NULL, NULL, 15, 'Fable Prints', 'orders@fableprints.example', '9393939393', 'Plot 9, Film Nagar', 'TR-1006', 'Hyderabad', 'TG', 99.64, 17.94, 0.00, 0.00, 0.00, 117.58, 8.97, 8.97, 0.00, NULL, NULL, NULL, NULL, 'INR', '2025-10-15 03:01:24', '2025-10-15 03:01:24', NULL, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `invoice_items`
--

CREATE TABLE `invoice_items` (
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_description` text DEFAULT NULL,
  `hsn_code` varchar(255) DEFAULT NULL,
  `quantity` decimal(15,2) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `unit_price` decimal(15,2) DEFAULT NULL,
  `discount_percent` decimal(10,2) DEFAULT NULL,
  `discount_amount` decimal(15,2) DEFAULT NULL,
  `line_total` decimal(15,2) DEFAULT NULL,
  `tax_rate` decimal(10,2) DEFAULT NULL,
  `tax_amount` decimal(15,2) DEFAULT NULL,
  `cgst_rate` decimal(10,2) DEFAULT NULL,
  `sgst_rate` decimal(10,2) DEFAULT NULL,
  `igst_rate` decimal(10,2) DEFAULT NULL,
  `cess_rate` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoice_items`
--

INSERT INTO `invoice_items` (`item_id`, `invoice_id`, `product_id`, `product_name`, `product_description`, `hsn_code`, `quantity`, `unit`, `unit_price`, `discount_percent`, `discount_amount`, `line_total`, `tax_rate`, `tax_amount`, `cgst_rate`, `sgst_rate`, `igst_rate`, `cess_rate`, `created_at`, `updated_at`) VALUES
(18, 25, 4602, 'ABAXIS-5 MG TAB.', 'ABAXIS-5 MG TAB.', '30049099.0', 1.00, '1', 164.11, 0.00, 0.00, 193.65, 18.00, 29.54, 9.00, 9.00, 0.00, 0.00, '2025-10-13 04:45:08', '2025-10-13 04:45:08'),
(19, 26, 3490, 'ACETAMIDE-250 MG TAB.', 'ACETAMIDE-250 MG TAB.', '30049081.0', 1.00, '1', 32.48, 0.00, 0.00, 38.33, 18.00, 5.85, 9.00, 9.00, 0.00, 0.00, '2025-10-13 04:45:32', '2025-10-13 04:45:32'),
(20, 27, 3436, 'ACENC-P TAB.', 'ACENC-P TAB.', '', 1.00, '1', 28.00, 0.00, 0.00, 33.04, 18.00, 5.04, 9.00, 9.00, 0.00, 0.00, '2025-10-13 04:45:51', '2025-10-13 04:45:51'),
(21, 28, 2551, 'ACEPRO TAB.', 'ACEPRO TAB.', '', 1.00, '1', 21.92, 0.00, 0.00, 25.87, 18.00, 3.95, 9.00, 9.00, 0.00, 0.00, '2025-10-13 04:46:09', '2025-10-13 04:46:09'),
(23, 30, 3655, 'ACAMPTAS-333 TAB.', 'ACAMPTAS-333 TAB.', '', 1.00, '1', 0.00, 0.00, 0.00, 0.00, 18.00, 0.00, 9.00, 9.00, 0.00, 0.00, '2025-10-13 04:47:30', '2025-10-13 04:47:30'),
(29, 24, 2357, 'A TO Z NS SYP.', 'A TO Z NS SYP.', '', 1.00, '1', 33.13, 0.00, 0.00, 39.09, 18.00, 5.96, 9.00, 9.00, 0.00, 0.00, '2025-10-13 04:59:56', '2025-10-13 04:59:56'),
(30, 29, 3627, 'A24-250MG TAB.', 'A24-250MG TAB.', '', 1.00, '1', 50.29, 0.00, 0.00, 59.34, 18.00, 9.05, 9.00, 9.00, 0.00, 0.00, '2025-10-13 05:00:07', '2025-10-13 05:00:07'),
(31, 32, 3004, '4-ON INJ.', '4-ON INJ.', '', 1.00, '1', 12.19, 0.00, 0.00, 14.38, 18.00, 2.19, 9.00, 9.00, 0.00, 0.00, '2025-10-14 04:13:49', '2025-10-14 04:13:49'),
(32, 33, 2942, '4-ON SYP.', '4-ON SYP.', '', 1.00, '1', 26.67, 0.00, 0.00, 31.47, 18.00, 4.80, 9.00, 9.00, 0.00, 0.00, '2025-10-14 04:17:57', '2025-10-14 04:17:57'),
(33, 35, 1012, 'MEFLOTAS', 'MEFLOTAS', '30049066.0', 1.00, '1', 77.98, 0.00, 0.00, 92.02, 18.00, 14.04, 9.00, 9.00, 0.00, 0.00, '2025-10-15 00:06:00', '2025-10-15 00:06:00'),
(34, 35, 1013, 'CLAVIX-AS-75', 'CLAVIX-AS-75', '30049099.0', 1.00, '1', 72.14, 0.00, 0.00, 85.13, 18.00, 12.99, 9.00, 9.00, 0.00, 0.00, '2025-10-15 00:06:00', '2025-10-15 00:06:00'),
(35, 35, 1012, 'MEFLOTAS', 'MEFLOTAS', '30049066.0', 1.00, '1', 77.98, 0.00, 0.00, 92.02, 18.00, 14.04, 9.00, 9.00, 0.00, 0.00, '2025-10-15 00:06:00', '2025-10-15 00:06:00'),
(36, 36, 1012, 'MEFLOTAS', 'MEFLOTAS', '30049066.0', 1.00, '1', 70.18, 0.00, 0.00, 82.81, 18.00, 12.63, 9.00, 9.00, 0.00, 0.00, '2025-10-15 02:57:22', '2025-10-15 02:57:22'),
(37, 37, 1012, 'MEFLOTAS', 'MEFLOTAS', '30049066.0', 1.00, '1', 70.18, 0.00, 0.00, 82.81, 18.00, 12.63, 9.00, 9.00, 0.00, 0.00, '2025-10-15 02:58:05', '2025-10-15 02:58:05'),
(38, 38, 1014, 'VENTAB XL 75', 'VENTAB XL 75', '30049099.0', 1.00, '1', 99.64, 0.00, 0.00, 117.58, 18.00, 17.94, 9.00, 9.00, 0.00, 0.00, '2025-10-15 02:59:13', '2025-10-15 02:59:13'),
(39, 39, 1014, 'VENTAB XL 75', 'VENTAB XL 75', '30049099.0', 1.00, '1', 99.64, 0.00, 0.00, 117.58, 18.00, 17.94, 9.00, 9.00, 0.00, 0.00, '2025-10-15 03:01:24', '2025-10-15 03:01:24');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_payments`
--

CREATE TABLE `invoice_payments` (
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `payment_reference` varchar(255) DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `razorpay_payment_id` varchar(255) DEFAULT NULL,
  `razorpay_order_id` varchar(255) DEFAULT NULL,
  `razorpay_signature` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_settings`
--

CREATE TABLE `invoice_settings` (
  `setting_id` bigint(20) UNSIGNED NOT NULL,
  `setting_key` varchar(255) DEFAULT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_type` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_templates`
--

CREATE TABLE `invoice_templates` (
  `template_id` bigint(20) UNSIGNED NOT NULL,
  `template_name` varchar(255) DEFAULT NULL,
  `template_type` varchar(255) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT 0,
  `header_color` varchar(255) DEFAULT NULL,
  `logo_position` varchar(255) DEFAULT NULL,
  `show_company_logo` tinyint(1) DEFAULT 0,
  `show_qr_code` tinyint(1) DEFAULT 0,
  `show_payment_terms` tinyint(1) DEFAULT 0,
  `show_notes` tinyint(1) DEFAULT 0,
  `header_html` longtext DEFAULT NULL,
  `footer_html` longtext DEFAULT NULL,
  `css_styles` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_short_name` varchar(20) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `packing` varchar(50) DEFAULT NULL,
  `mfg_by` varchar(100) DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `status` varchar(5) DEFAULT NULL,
  `schedule` varchar(10) DEFAULT '00',
  `box_qty` int(11) DEFAULT 0,
  `case_qty` int(11) DEFAULT 0,
  `bar_code` varchar(50) DEFAULT NULL,
  `division` varchar(10) DEFAULT '00',
  `flag` varchar(20) DEFAULT NULL,
  `unit` tinyint(4) NOT NULL DEFAULT 1,
  `unit_type` varchar(10) DEFAULT NULL,
  `min_level` decimal(10,2) DEFAULT 0.00,
  `max_level` decimal(10,2) DEFAULT 0.00,
  `narcotic_flag` char(1) DEFAULT 'N',
  `s_rate` decimal(10,2) DEFAULT 0.00,
  `mrp` decimal(10,2) DEFAULT 0.00,
  `ws_rate` decimal(10,2) DEFAULT 0.00,
  `ws_net_toggle` char(1) DEFAULT 'N',
  `spl_rate` decimal(10,2) DEFAULT 0.00,
  `spl_net_toggle` char(1) DEFAULT 'N',
  `scheme_plus` int(11) DEFAULT 0,
  `scheme_minus` int(11) DEFAULT 0,
  `sale_scheme` varchar(50) DEFAULT NULL,
  `min_gp` decimal(10,2) DEFAULT 0.00,
  `pur_rate` decimal(10,2) DEFAULT 0.00,
  `cost` decimal(10,2) DEFAULT 0.00,
  `pur_scheme_plus` int(11) DEFAULT 0,
  `pur_scheme_minus` int(11) DEFAULT 0,
  `pur_scheme` varchar(50) DEFAULT NULL,
  `nr` decimal(10,2) DEFAULT 0.00,
  `hsn_code` varchar(20) DEFAULT NULL,
  `cgst_percent` decimal(5,2) DEFAULT 0.00,
  `sgst_percent` decimal(5,2) DEFAULT 0.00,
  `igst_percent` decimal(5,2) DEFAULT 0.00,
  `cess_percent` decimal(5,2) DEFAULT 0.00,
  `vat_percent` decimal(5,2) DEFAULT 0.00,
  `fixed_dis` char(1) DEFAULT NULL,
  `fixed_dis_percent` decimal(5,2) DEFAULT 0.00,
  `fixed_dis_type` char(1) DEFAULT NULL,
  `expiry_flag` char(1) DEFAULT 'N',
  `inclusive_flag` char(1) DEFAULT 'N',
  `generic_flag` char(1) DEFAULT 'N',
  `h_scm_flag` char(1) DEFAULT 'N',
  `q_scm_flag` char(1) DEFAULT 'N',
  `locks_flag` char(1) NOT NULL DEFAULT 'N',
  `max_inv_qty_value` decimal(10,2) DEFAULT 0.00,
  `max_inv_qty_new` char(1) DEFAULT NULL,
  `weight_new` decimal(10,2) DEFAULT 0.00,
  `bar_code_flag` char(1) DEFAULT 'N',
  `def_qty_flag` char(1) DEFAULT 'N',
  `volume_new` decimal(10,2) DEFAULT 0.00,
  `comp_name_bc_new` char(1) DEFAULT NULL,
  `dpc_item_flag` char(1) DEFAULT 'N',
  `lock_sale_flag` char(1) DEFAULT 'N',
  `max_min_flag` char(1) DEFAULT '1',
  `mrp_for_sale_new` decimal(10,2) DEFAULT 0.00,
  `commodity` varchar(50) DEFAULT NULL,
  `current_scheme_flag` char(1) DEFAULT 'N',
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `scheme_plus_value` decimal(10,2) DEFAULT 0.00,
  `scheme_minus_value` decimal(10,2) DEFAULT 0.00,
  `category` varchar(50) DEFAULT NULL,
  `category_2` varchar(100) DEFAULT NULL,
  `upc` varchar(50) DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `company_id`, `company_short_name`, `name`, `packing`, `mfg_by`, `location`, `status`, `schedule`, `box_qty`, `case_qty`, `bar_code`, `division`, `flag`, `unit`, `unit_type`, `min_level`, `max_level`, `narcotic_flag`, `s_rate`, `mrp`, `ws_rate`, `ws_net_toggle`, `spl_rate`, `spl_net_toggle`, `scheme_plus`, `scheme_minus`, `sale_scheme`, `min_gp`, `pur_rate`, `cost`, `pur_scheme_plus`, `pur_scheme_minus`, `pur_scheme`, `nr`, `hsn_code`, `cgst_percent`, `sgst_percent`, `igst_percent`, `cess_percent`, `vat_percent`, `fixed_dis`, `fixed_dis_percent`, `fixed_dis_type`, `expiry_flag`, `inclusive_flag`, `generic_flag`, `h_scm_flag`, `q_scm_flag`, `locks_flag`, `max_inv_qty_value`, `max_inv_qty_new`, `weight_new`, `bar_code_flag`, `def_qty_flag`, `volume_new`, `comp_name_bc_new`, `dpc_item_flag`, `lock_sale_flag`, `max_min_flag`, `mrp_for_sale_new`, `commodity`, `current_scheme_flag`, `from_date`, `to_date`, `scheme_plus_value`, `scheme_minus_value`, `category`, `category_2`, `upc`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 63, 'TCS', 'amansingh', '1*10', 'dfsdf', 'sdfgsdf', '3434', '00', 4, 2, '324234', '00', '43234', 1, 'Kg.', 0.08, 0.06, 'Y', 0.06, 200.00, 0.04, 'Y', 0.04, 'Y', 3, 7, NULL, 0.03, 0.07, 0.07, 3, 4, NULL, 0.04, '90183990', 6.00, 6.00, 12.00, 0.00, 0.09, 'Y', 0.09, 'R', 'Y', 'Y', 'Y', 'Y', 'Y', 'S', 0.10, 'R', 0.00, 'Y', 'Y', 0.08, 'N', 'Y', 'Y', '2', 0.09, 'dgdtgtg', 'Y', '2025-10-22', '2025-10-24', 8.00, 3.00, 'ertert', 'ertert', 'erterter', 0, '2025-10-15 01:41:01', '2025-10-15 02:18:02'),
(2, 63, 'TCS', 'dfdfgdfg', '1*10', NULL, NULL, NULL, '00', 0, 0, NULL, '00', NULL, 1, 'Unit', 0.00, 0.00, 'N', 0.00, 0.00, 0.00, 'Y', 0.00, 'Y', 0, 0, NULL, 0.00, 0.00, 0.00, 0, 0, NULL, 0.00, '90189019', 6.00, 6.00, 12.00, 0.00, 0.00, NULL, 0.00, NULL, 'N', 'N', 'N', 'N', 'N', 'S', 0.00, NULL, 0.00, 'N', 'N', 0.00, NULL, 'N', 'N', '1', 0.00, NULL, 'N', NULL, NULL, 0.00, 0.00, NULL, NULL, NULL, 0, '2025-10-15 03:58:46', '2025-10-15 04:12:54'),
(3, 66, 'HDFC', 'abhi1', '1*10', NULL, NULL, NULL, '00', 0, 0, NULL, '00', NULL, 1, 'Unit', 0.00, 0.00, 'N', 0.00, 0.00, 0.00, 'Y', 0.00, 'Y', 0, 0, NULL, 0.00, 0.00, 0.00, 0, 0, NULL, 0.00, '34029011', 9.00, 9.00, 18.00, 0.00, 0.00, NULL, 0.00, NULL, 'N', 'N', 'N', 'N', 'N', 'S', 0.00, NULL, 0.00, 'N', 'N', 0.00, NULL, 'N', 'N', '1', 0.00, NULL, 'N', NULL, NULL, 0.00, 0.00, NULL, NULL, NULL, 0, '2025-10-15 03:59:07', '2025-10-15 04:12:43'),
(4, 68, 'HUL', 'ritik', '1*10', NULL, NULL, NULL, '00', 0, 0, NULL, '00', NULL, 1, 'Unit', 0.00, 0.00, 'N', 0.00, 0.00, 0.00, 'Y', 0.00, 'Y', 0, 0, NULL, 0.00, 0.00, 0.00, 0, 0, NULL, 0.00, '34029011', 9.00, 9.00, 18.00, 0.00, 0.00, NULL, 0.00, NULL, 'N', 'N', 'N', 'N', 'N', 'S', 0.00, NULL, 0.00, 'N', 'N', 0.00, NULL, 'N', 'N', '1', 0.00, NULL, 'N', NULL, NULL, 0.00, 0.00, NULL, NULL, NULL, 0, '2025-10-15 04:01:17', '2025-10-15 04:12:33'),
(5, 64, 'INFY', 'naman3', '1*10', NULL, NULL, NULL, '00', 0, 0, NULL, '00', NULL, 1, 'Unit', 0.00, 0.00, 'N', 0.00, 0.00, 0.00, 'Y', 0.00, 'Y', 0, 0, NULL, 0.00, 0.00, 0.00, 0, 0, NULL, 0.00, '34011190', 9.00, 9.00, 18.00, 0.00, 0.00, NULL, 0.00, NULL, 'N', 'N', 'N', 'N', 'N', 'S', 0.00, NULL, 0.00, 'N', 'N', 0.00, NULL, 'N', 'N', '1', 0.00, NULL, 'N', NULL, NULL, 0.00, 0.00, NULL, NULL, NULL, 0, '2025-10-15 04:01:30', '2025-10-15 04:12:21'),
(6, 65, 'WIPRO', 'adi1', '1*10', NULL, NULL, NULL, '00', 0, 0, NULL, '00', NULL, 1, 'Unit', 0.00, 0.00, 'N', 0.00, 0.00, 0.00, 'Y', 0.00, 'Y', 0, 0, NULL, 0.00, 0.00, 0.00, 0, 0, NULL, 0.00, '34029011', 9.00, 9.00, 18.00, 0.00, 0.00, NULL, 0.00, NULL, 'N', 'N', 'N', 'N', 'N', 'S', 0.00, NULL, 0.00, 'N', 'N', 0.00, NULL, 'N', 'N', '1', 0.00, NULL, 'N', NULL, NULL, 0.00, 0.00, NULL, NULL, NULL, 0, '2025-10-15 04:01:42', '2025-10-15 04:12:09'),
(7, 67, 'AIRTEL', 'adi2', '1*10', NULL, NULL, NULL, '00', 0, 0, NULL, '00', NULL, 1, 'Unit', 0.00, 0.00, 'N', 0.00, 0.00, 0.00, 'Y', 0.00, 'Y', 0, 0, NULL, 0.00, 0.00, 0.00, 0, 0, NULL, 0.00, '34011190', 9.00, 9.00, 18.00, 0.00, 0.00, NULL, 0.00, NULL, 'N', 'N', 'N', 'N', 'N', 'S', 0.00, NULL, 0.00, 'N', 'N', 0.00, NULL, 'N', 'N', '1', 0.00, NULL, 'N', NULL, NULL, 0.00, 0.00, NULL, NULL, NULL, 0, '2025-10-15 04:01:59', '2025-10-15 04:11:56'),
(8, 65, 'WIPRO', 'adi3', '1*10', NULL, NULL, NULL, '00', 0, 0, NULL, '00', NULL, 1, 'Unit', 0.00, 0.00, 'N', 0.00, 0.00, 0.00, 'Y', 0.00, 'Y', 0, 0, NULL, 0.00, 0.00, 0.00, 0, 0, NULL, 0.00, '30059090', 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 0.00, NULL, 'N', 'N', 'N', 'N', 'N', 'S', 0.00, NULL, 0.00, 'N', 'N', 0.00, NULL, 'N', 'N', '1', 0.00, NULL, 'N', NULL, NULL, 0.00, 0.00, NULL, NULL, NULL, 0, '2025-10-15 04:02:17', '2025-10-15 04:11:44'),
(9, 73, 'SUNPH', 'adi5', '1*10', NULL, NULL, NULL, '00', 0, 0, NULL, '00', NULL, 1, 'Unit', 0.00, 0.00, 'N', 0.00, 0.00, 0.00, 'Y', 0.00, 'Y', 0, 0, NULL, 0.00, 0.00, 0.00, 0, 0, NULL, 0.00, '30051090', 6.00, 6.00, 12.00, 0.00, 0.00, NULL, 0.00, NULL, 'N', 'N', 'N', 'N', 'N', 'S', 0.00, NULL, 0.00, 'N', 'N', 0.00, NULL, 'N', 'N', '1', 0.00, NULL, 'N', NULL, NULL, 0.00, 0.00, NULL, NULL, NULL, 0, '2025-10-15 04:02:34', '2025-10-15 04:11:28'),
(10, 66, 'HDFC', 'adi6', '1*10', NULL, NULL, NULL, '00', 0, 0, NULL, '00', NULL, 1, 'Unit', 0.00, 0.00, 'N', 0.00, 0.00, 0.00, 'Y', 0.00, 'Y', 0, 0, NULL, 0.00, 0.00, 0.00, 0, 0, NULL, 0.00, '30059090', 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 0.00, NULL, 'N', 'N', 'N', 'N', 'N', 'S', 0.00, NULL, 0.00, 'N', 'N', 0.00, NULL, 'N', 'N', '1', 0.00, NULL, 'N', NULL, NULL, 0.00, 0.00, NULL, NULL, NULL, 0, '2025-10-15 04:02:43', '2025-10-15 04:11:14'),
(15, 64, 'INFY', 'mango', NULL, NULL, NULL, NULL, '00', 0, 0, NULL, '00', NULL, 1, 'Unit', 0.00, 0.00, 'N', 0.00, 0.00, 0.00, 'Y', 0.00, 'Y', 0, 0, NULL, 0.00, 0.00, 0.00, 0, 0, NULL, 0.00, '30059090', 9.00, 9.00, 18.00, 0.00, 0.00, NULL, 0.00, NULL, 'N', 'N', 'N', 'N', 'N', 'S', 0.00, NULL, 0.00, 'N', 'N', 0.00, NULL, 'N', 'N', '1', 0.00, NULL, 'N', NULL, NULL, 0.00, 0.00, NULL, NULL, NULL, 0, '2025-10-29 06:03:27', '2025-10-29 06:03:27');

-- --------------------------------------------------------

--
-- Table structure for table `item_categories`
--

CREATE TABLE `item_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `alter_code` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_categories`
--

INSERT INTO `item_categories` (`id`, `name`, `alter_code`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Tablets', 'TAB001', 'Active', '2025-10-29 01:31:48', '2025-10-29 01:31:48'),
(2, 'Capsules', 'CAP002', 'Active', '2025-10-29 01:31:48', '2025-10-29 01:31:48'),
(3, 'Syrups', 'SYR003', 'Active', '2025-10-29 01:31:48', '2025-10-29 01:31:48'),
(4, 'Injections', 'INJ004', 'Active', '2025-10-29 01:31:48', '2025-10-29 01:31:48'),
(5, 'Ointments', 'OIN005', 'Active', '2025-10-29 01:31:48', '2025-10-29 01:31:48'),
(6, 'Drops', 'DRP006', 'Active', '2025-10-29 01:31:48', '2025-10-29 01:31:48'),
(7, 'Powders', 'POW007', 'Active', '2025-10-29 01:31:48', '2025-10-29 01:31:48'),
(8, 'Creams', 'CRM008', 'Active', '2025-10-29 01:31:48', '2025-10-29 01:31:48'),
(9, 'Gels', 'GEL009', 'Active', '2025-10-29 01:31:48', '2025-10-29 01:31:48'),
(10, 'Lotions', 'LOT010', 'Active', '2025-10-29 01:31:48', '2025-10-29 01:31:48'),
(11, 'Sprays', 'SPR011', 'Active', '2025-10-29 01:31:48', '2025-10-29 01:31:48'),
(12, 'Inhalers', 'INH012', 'Active', '2025-10-29 01:31:48', '2025-10-29 01:31:48'),
(13, 'Sachets', 'SAC013', 'Active', '2025-10-29 01:31:48', '2025-10-29 01:31:48'),
(14, 'Suspensions', 'SUS014', 'Active', '2025-10-29 01:31:48', '2025-10-29 01:31:48'),
(15, 'Solutions', 'SOL015', 'Active', '2025-10-29 01:31:48', '2025-10-29 01:31:48'),
(16, 'Emulsions', 'EMU016', 'Active', '2025-10-29 01:31:48', '2025-10-29 01:31:48'),
(17, 'Granules', 'GRA017', 'Active', '2025-10-29 01:31:48', '2025-10-29 01:31:48'),
(18, 'Patches', 'PAT018', 'Active', '2025-10-29 01:31:48', '2025-10-29 01:31:48'),
(19, 'Suppositories', 'SUP019', 'Active', '2025-10-29 01:31:48', '2025-10-29 01:31:48'),
(20, 'Pessaries', 'PES020', 'Inactive', '2025-10-29 01:31:48', '2025-10-29 01:31:48'),
(21, 'Liniments', 'LIN021', 'Active', '2025-10-29 01:31:48', '2025-10-29 01:31:48'),
(22, 'Tinctures', 'TIN022', 'Active', '2025-10-29 01:31:48', '2025-10-29 01:31:48'),
(23, 'Elixirs', 'ELI023', 'Active', '2025-10-29 01:31:48', '2025-10-29 01:31:48'),
(24, 'Mixtures', 'MIX024', 'Active', '2025-10-29 01:31:48', '2025-10-29 01:31:48'),
(25, 'Pastes', 'PAS025', 'Active', '2025-10-29 01:31:48', '2025-10-29 01:31:48'),
(26, 'Balms', 'BAL026', 'Active', '2025-10-29 01:31:48', '2025-10-29 01:31:48'),
(27, 'Oils', 'OIL027', 'Active', '2025-10-29 01:31:48', '2025-10-29 01:31:48'),
(28, 'Serums', 'SER028', 'Active', '2025-10-29 01:31:48', '2025-10-29 01:31:48'),
(29, 'Tonics', 'TON029', 'Active', '2025-10-29 01:31:48', '2025-10-29 01:31:48'),
(30, 'Vaccines', 'VAC030', 'Active', '2025-10-29 01:31:48', '2025-10-29 01:31:48');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `marketing_managers`
--

CREATE TABLE `marketing_managers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `designation` varchar(255) NOT NULL DEFAULT 'Marketing Manager',
  `target_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `reporting_to` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `created_date` timestamp NULL DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `marketing_managers`
--

INSERT INTO `marketing_managers` (`id`, `code`, `name`, `email`, `mobile`, `address`, `designation`, `target_amount`, `reporting_to`, `status`, `is_deleted`, `created_date`, `modified_date`, `created_at`, `updated_at`) VALUES
(1, 'MM001', 'Arjun Kapoor', 'arjun.kapoor@company.com', '9876543230', 'Head Office, Nariman Point, Mumbai, Maharashtra', 'Marketing Manager', 0.00, 'GM001', 'Active', 0, NULL, NULL, '2025-10-15 04:52:18', '2025-10-15 04:52:18'),
(2, 'MM002', 'Sanya Malhotra', 'sanya.malhotra@company.com', '9876543231', 'Corporate Tower, Cyber City, Gurgaon, Haryana', 'Marketing Manager', 0.00, 'GM002', 'Active', 0, NULL, NULL, '2025-10-15 04:52:18', '2025-10-15 04:52:18'),
(3, 'MM003', 'Vikash Sinha', 'vikash.sinha@company.com', '9876543232', 'IT Hub, Whitefield, Bangalore, Karnataka', 'Marketing Manager', 0.00, 'GM001', 'Active', 0, NULL, NULL, '2025-10-15 04:52:18', '2025-10-15 04:52:18'),
(4, 'MM004', 'Ritika Sharma', 'ritika.sharma@company.com', '9876543233', 'Financial District, Gachibowli, Hyderabad, Telangana', 'Marketing Manager', 0.00, 'GM003', 'Active', 0, NULL, NULL, '2025-10-15 04:52:18', '2025-10-15 04:52:18'),
(5, 'MM005', 'Karan Johar', 'karan.johar@company.com', '9876543234', 'Business Park, Vastrapur, Ahmedabad, Gujarat', 'Marketing Manager', 0.00, 'GM002', 'Active', 0, NULL, NULL, '2025-10-15 04:52:18', '2025-10-15 04:52:18'),
(6, 'MM006', 'Pooja Hegde', 'pooja.hegde@company.com', '9876543235', 'IT Corridor, Technopark, Thiruvananthapuram, Kerala', 'Marketing Manager', 0.00, 'GM004', 'Inactive', 0, NULL, NULL, '2025-10-15 04:52:18', '2025-10-15 04:52:18'),
(7, 'MM007', 'Rohit Sharma', 'rohit.sharma@company.com', '9876543236', 'New Town, Action Area II, Kolkata, West Bengal', 'Marketing Manager', 0.00, 'GM005', 'Active', 0, NULL, NULL, '2025-10-15 04:52:18', '2025-10-15 04:52:18'),
(8, 'MM008', 'Shraddha Kapoor', 'shraddha.kapoor@company.com', '9876543237', 'IT Expressway, Sholinganallur, Chennai, Tamil Nadu', 'Marketing Manager', 0.00, 'GM003', 'Active', 0, NULL, NULL, '2025-10-15 04:52:18', '2025-10-15 04:52:18'),
(9, 'MM009', 'Ayushmann Khurrana', 'ayushmann.khurrana@company.com', '9876543238', 'IT City, Mohali, Punjab', 'Marketing Manager', 0.00, 'GM001', 'Active', 0, NULL, NULL, '2025-10-15 04:52:18', '2025-10-15 04:52:18'),
(10, 'MM010', 'Kiara Advani', 'kiara.advani@company.com', '9876543239', 'Pink City Junction, Jaipur, Rajasthan', 'Marketing Manager', 0.00, 'GM002', 'Active', 0, NULL, NULL, '2025-10-15 04:52:18', '2025-10-15 04:52:18');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2025_10_06_134529_create_users_table', 1),
(4, '2025_10_06_134535_create_companies_table', 1),
(5, '2025_10_06_134541_create_customers_table', 1),
(6, '2025_10_06_134549_create_items_table', 1),
(7, '2025_10_06_134613_create_invoices_table', 1),
(8, '2025_10_06_134620_create_invoice_items_table', 1),
(9, '2025_10_06_134636_create_invoice_payments_table', 1),
(10, '2025_10_06_134643_create_suppliers_table', 1),
(11, '2025_10_06_134650_create_invoice_settings_table', 1),
(12, '2025_10_06_134657_create_invoice_templates_table', 1),
(13, '2025_10_06_200000_add_role_and_tokens_to_users_table', 1),
(14, '2025_10_07_094828_create_sessions_table', 2),
(15, '2025_10_08_064158_add_state_name_to_customers_table', 3),
(16, '2025_10_09_074239_fix_items_table_column_types', 4),
(17, '2025_10_10_063755_add_gst_number_to_companies_table', 5),
(20, '2025_10_10_064036_add_discount_to_items_table', 6),
(21, '2025_10_10_070415_add_gst_number_to_companies_table_fix', 6),
(22, '2025_10_15_101500_add_lock_fields_to_companies_table', 7),
(23, '2025_10_15_104000_update_companies_structure_drop_gst_and_change_fields', 8),
(24, '2025_10_15_105500_fix_companies_fixed_maximum_and_status_types', 9),
(25, '2025_10_15_114727_add_notes_to_companies_table', 10),
(26, '2025_10_15_114455_alter_suppliers_status_field_to_varchar', 11),
(27, '2025_10_15_115320_update_suppliers_status_to_5_digits', 12),
(28, '2025_10_15_120006_add_opening_balance_type_to_suppliers_table', 13),
(29, '2025_10_15_190800_update_expiry_and_sale_purchase_fields_in_suppliers', 14),
(30, '2025_10_15_051718_fix_expiry_on_mrp_field_data_in_suppliers', 15),
(31, '2025_10_15_125000_fix_string_fields_in_suppliers_table', 16),
(32, '2025_10_15_134504_add_notebook_and_remarks_to_suppliers_table', 17),
(33, '2025_10_15_160246_add_company_fields_to_items_table', 18),
(34, '2025_10_15_161500_restructure_items_table_fields', 19),
(35, '2025_10_15_165000_update_items_header_section', 20),
(36, '2025_10_15_170700_drop_all_items_columns', 21),
(37, '2025_10_17_181700_create_hsn_codes_table', 22),
(38, '2025_10_15_112400_update_locks_flag_to_s', 23),
(39, '2025_10_15_115430_add_fixed_dis_type_and_max_inv_qty_value_to_items_table', 24),
(40, '2025_10_15_115500_change_comp_name_bc_new_to_char_in_items_table', 25),
(41, '2025_10_15_115600_add_bottom_section_fields_to_items_table', 26),
(42, '2025_10_15_115700_update_bottom_section_fields_in_items_table', 27),
(43, '2025_10_15_183000_fix_items_data_type_mismatches', 28),
(44, '2025_10_15_184000_add_mrp_to_items_table', 29),
(45, '2025_10_15_184500_add_scheme_fields_to_items_table', 30),
(46, '2025_10_15_185000_drop_net_toggle_from_items_table', 31),
(47, '2025_10_15_190000_drop_code_from_items_table', 32),
(48, '2025_10_15_152900_clear_customers_table', 33),
(49, '2025_10_15_153500_add_new_fields_to_customers_table', 34),
(50, '2025_10_15_154000_add_other_details_fields_to_customers_table', 35),
(51, '2025_10_15_154700_add_locks_fields_to_customers_table', 36),
(52, '2025_10_15_155900_change_status_fields_in_customers_table', 37),
(53, '2025_10_15_110425_add_gst_number_to_customers_table', 38),
(54, '2025_10_15_124332_create_general_ledgers_table', 39),
(55, '2025_10_15_124342_create_cash_bank_books_table', 39),
(56, '2025_10_15_124343_create_sale_ledgers_table', 39),
(57, '2025_10_15_124344_create_purchase_ledgers_table', 39),
(58, '2025_10_15_064548_add_image_fields_to_general_ledgers_table', 40),
(59, '2025_10_15_194500_update_general_ledgers_table_fields', 41),
(60, '2025_10_15_195000_remove_extra_columns_from_general_ledgers_table', 42),
(61, '2025_10_15_195100_add_contact_fields_to_general_ledgers_table', 43),
(62, '2025_10_15_195300_rename_mobile_fields_to_contact_person_mobile', 44),
(63, '2025_10_15_200000_add_fields_to_cash_bank_books_table', 45),
(64, '2025_10_15_210000_add_receipts_field_to_cash_bank_books_table', 46),
(65, '2025_10_15_220000_add_fields_to_sale_ledger_table', 47),
(66, '2025_10_15_220100_remove_old_fields_from_sale_ledger_table', 47),
(67, '2025_10_15_220200_drop_old_fields_from_sale_ledgers_table', 47),
(68, '2025_10_15_230000_add_fields_to_purchase_ledgers_table', 48),
(69, '2025_10_15_230100_remove_old_fields_from_purchase_ledgers_table', 49),
(70, '2025_10_15_240000_add_contact_fields_to_cash_bank_books_table', 50),
(71, '2025_10_15_125012_create_sales_men_table', 51),
(72, '2025_10_15_125030_create_areas_table', 51),
(73, '2025_10_15_125036_create_routes_table', 51),
(74, '2025_10_15_125043_create_states_table', 51),
(75, '2025_10_15_125049_create_area_managers_table', 51),
(76, '2025_10_15_125055_create_regional_managers_table', 51),
(77, '2025_10_15_125101_create_marketing_managers_table', 51),
(78, '2025_10_15_125110_create_divisional_managers_table', 51),
(79, '2025_10_15_125117_create_country_managers_table', 51),
(80, '2025_10_15_045323_add_additional_fields_to_sales_men_table', 52),
(81, '2025_10_15_053300_remove_extra_fields_from_sales_men_table', 53),
(82, '2025_10_15_053443_remove_extra_fields_from_sales_men_table', 53),
(83, '2025_10_27_070000_update_areas_table_structure', 54),
(84, '2025_10_27_082657_update_routes_table_structure', 55),
(85, '2025_10_27_093147_update_states_table_structure', 56),
(86, '2025_10_15_094352_update_area_managers_table_structure', 57),
(87, '2025_10_15_100210_update_regional_managers_table_structure', 58),
(88, '2025_10_15_101141_update_marketing_managers_table_structure', 59),
(100, '2025_10_15_102754_create_general_managers_table', 60),
(101, '2025_10_27_104733_update_divisional_managers_table_structure', 60),
(102, '2025_10_27_105735_update_country_managers_table_structure', 60),
(103, '2025_10_28_104500_create_batches_table', 60),
(104, '2025_10_28_104600_create_stock_ledgers_table', 60),
(105, '2025_10_28_120000_add_party_fields_to_stock_ledgers', 60),
(106, '2025_10_28_125000_create_pending_orders_table', 60),
(107, '2025_10_28_125100_create_godown_expiry_table', 60),
(108, '2025_10_28_125200_create_expiry_ledger_table', 60),
(109, '2025_10_28_134800_create_customer_ledgers_table', 61),
(110, '2025_10_28_134900_create_customer_dues_table', 61),
(111, '2025_10_28_135000_create_customer_special_rates_table', 61),
(112, '2025_10_28_135100_create_customer_discounts_table', 61),
(113, '2025_10_28_135200_create_customer_challans_table', 61),
(114, '2025_10_28_135300_create_customer_prescriptions_table', 61),
(115, '2025_10_28_160000_recreate_customer_challans_table', 62),
(116, '2025_10_28_160100_recreate_customer_dues_table', 63),
(117, '2025_10_29_000001_create_personal_directories_table', 64),
(118, '2025_10_29_000002_create_general_reminders_table', 64),
(119, '2025_10_29_000003_create_general_notebooks_table', 64),
(120, '2025_10_29_000004_create_item_categories_table', 64),
(121, '2025_10_29_000005_create_transport_masters_table', 64),
(122, '2025_10_29_000006_add_fields_to_personal_directories_table', 65),
(123, '2025_10_29_000007_fix_personal_directories_address_fields', 66),
(124, '2025_10_29_064334_add_fields_to_general_reminders_table', 67),
(125, '2025_10_29_065817_add_fields_to_item_categories_table', 68),
(126, '2025_10_29_070510_add_fields_to_transport_masters_table', 69),
(127, '2025_10_29_081600_create_sales_table', 70),
(128, '2025_10_29_081628_create_sale_items_table', 70);

-- --------------------------------------------------------

--
-- Table structure for table `pending_orders`
--

CREATE TABLE `pending_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `order_date` date NOT NULL,
  `rate` decimal(10,2) NOT NULL,
  `tax_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `discount_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `cost` decimal(10,2) NOT NULL,
  `scm_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `quantity` int(11) NOT NULL,
  `free_quantity` int(11) NOT NULL DEFAULT 0,
  `urgent_flag` char(1) NOT NULL DEFAULT 'N',
  `scheme_plus` int(11) NOT NULL DEFAULT 0,
  `scheme_minus` int(11) NOT NULL DEFAULT 0,
  `days_pending` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_directories`
--

CREATE TABLE `personal_directories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `alt_code` varchar(255) DEFAULT NULL,
  `tel_office` varchar(255) DEFAULT NULL,
  `tel_residence` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `anniversary` date DEFAULT NULL,
  `spouse` varchar(255) DEFAULT NULL,
  `spouse_dob` date DEFAULT NULL,
  `child_1` varchar(255) DEFAULT NULL,
  `child_1_dob` date DEFAULT NULL,
  `child_2` varchar(255) DEFAULT NULL,
  `child_2_dob` date DEFAULT NULL,
  `address_office` text DEFAULT NULL,
  `address_residence` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_directories`
--

INSERT INTO `personal_directories` (`id`, `created_at`, `updated_at`, `name`, `alt_code`, `tel_office`, `tel_residence`, `mobile`, `fax`, `email`, `status`, `contact_person`, `birthday`, `anniversary`, `spouse`, `spouse_dob`, `child_1`, `child_1_dob`, `child_2`, `child_2_dob`, `address_office`, `address_residence`) VALUES
(23, '2025-10-29 00:35:35', '2025-10-29 00:35:35', 'iuy', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, '2025-10-29 00:35:40', '2025-10-29 00:35:40', 'g', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, '2025-10-29 00:35:46', '2025-10-29 00:35:46', 'gug', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, '2025-10-29 00:35:53', '2025-10-29 00:35:53', 'jhghg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, '2025-10-29 00:35:58', '2025-10-29 00:35:58', 'jgug', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, '2025-10-29 00:36:05', '2025-10-29 00:36:05', 'ggjhyg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, '2025-10-29 00:36:11', '2025-10-29 00:36:11', 'kjhgg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, '2025-10-29 00:36:16', '2025-10-29 00:36:16', 'hjbhg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, '2025-10-29 00:36:21', '2025-10-29 00:36:21', 'hgjhg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, '2025-10-29 00:36:26', '2025-10-29 00:36:26', 'jkg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, '2025-10-29 00:36:31', '2025-10-29 00:36:31', 'jkhgh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, '2025-10-29 00:36:38', '2025-10-29 00:36:38', 'jjkh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(35, '2025-10-29 00:36:44', '2025-10-29 00:36:44', 'jhghg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, '2025-10-29 00:36:49', '2025-10-29 00:36:49', 'kjhh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, '2025-10-29 00:36:55', '2025-10-29 00:36:55', 'jguyg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, '2025-10-29 00:36:59', '2025-10-29 00:36:59', 'khjgihg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, '2025-10-29 00:37:06', '2025-10-29 00:37:06', 'igg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(40, '2025-10-29 00:37:15', '2025-10-29 00:37:15', 'j', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(41, '2025-10-29 00:37:21', '2025-10-29 00:37:21', 'jhb', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(42, '2025-10-29 00:37:26', '2025-10-29 00:37:26', 'bbb', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(43, '2025-10-29 00:37:34', '2025-10-29 00:37:34', 'jhjh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44, '2025-10-29 00:37:40', '2025-10-29 00:37:40', 'jjj', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(45, '2025-10-29 00:37:46', '2025-10-29 00:37:46', 'jhg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(46, '2025-10-29 00:37:54', '2025-10-29 00:37:54', 'iugiugh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(47, '2025-10-29 00:38:02', '2025-10-29 00:38:02', 'kjhjkh', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_ledgers`
--

CREATE TABLE `purchase_ledgers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ledger_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `form_type` varchar(255) DEFAULT NULL,
  `sale_tax` decimal(10,2) DEFAULT 0.00,
  `desc` text DEFAULT NULL,
  `type` char(1) DEFAULT 'L',
  `status` varchar(255) DEFAULT NULL,
  `alter_code` varchar(255) DEFAULT NULL,
  `opening_balance` decimal(10,2) DEFAULT 0.00,
  `form_required` char(1) DEFAULT 'N',
  `charges` decimal(10,2) DEFAULT 0.00,
  `under` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `birth_day` date DEFAULT NULL,
  `anniversary` date DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact_1` varchar(255) DEFAULT NULL,
  `mobile_1` varchar(255) DEFAULT NULL,
  `contact_2` varchar(255) DEFAULT NULL,
  `mobile_2` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_ledgers`
--

INSERT INTO `purchase_ledgers` (`id`, `ledger_name`, `created_at`, `updated_at`, `form_type`, `sale_tax`, `desc`, `type`, `status`, `alter_code`, `opening_balance`, `form_required`, `charges`, `under`, `address`, `birth_day`, `anniversary`, `telephone`, `fax`, `email`, `contact_1`, `mobile_1`, `contact_2`, `mobile_2`) VALUES
(3, 'PURCHASE - INDIRECT EXPENSES', '2025-10-15 05:05:37', '2025-10-15 05:05:37', 'T', 14.37, 'Quisquam rem ullam quibusdam et nostrum et.', 'C', 'Approved', 'GY670', 19107.64, 'N', 2507.35, 'PURCHASE & DIRECT EXPENSES', '9764 Fay Circles\nRobertstad, WA 57958-2826', '1996-07-16', '2011-04-27', '+1.732.928.6353', '(470) 559-2582', 'anika49@botsford.com', 'Geovanny Hyatt', '9811121531', 'Landen Kshlerin', '9763949035'),
(4, 'PURCHASE - IMPORT', '2025-10-15 05:05:37', '2025-10-15 05:05:37', 'GRN', 14.50, 'Dolor pariatur deleniti dicta nostrum repellendus eos eos.', 'C', 'Inactive', 'XZ844', 80332.27, 'Y', 1550.20, 'OPERATING EXPENSES', '830 Enoch Locks\nEast Dianaton, KY 28745-1888', '1968-04-22', '2023-06-01', '339.449.4375', '+1 (352) 889-1294', 'collins.aliya@hermiston.com', 'Yasmeen Corkery', '9816923363', 'Miss Sunny Kiehn IV', '9720620650'),
(6, 'PURCHASE - RETAIL', '2025-10-15 05:05:37', '2025-10-15 05:05:37', 'PO', 2.87, 'Magnam quo eos repudiandae.', 'C', 'Active', 'XZ436', 74678.82, 'N', 940.38, 'PURCHASE & DIRECT EXPENSES', '96644 Franecki Heights\nLake Sydnifurt, AK 39377', '1978-09-29', '2018-12-23', '(786) 652-6747', '678.958.1486', 'lambert.hermiston@grant.org', 'Prof. Sedrick Haag I', '9885995334', 'Jaron Farrell', '9764576011'),
(7, 'PURCHASE - INDIRECT EXPENSES', '2025-10-15 05:05:37', '2025-10-15 05:05:37', 'TR', 17.77, 'Fugiat quo cumque iste perspiciatis aperiam perferendis perferendis.', 'C', 'Inactive', 'SZ141', 82881.34, 'Y', 1390.97, 'PURCHASE & DIRECT EXPENSES', '1001 Conor Locks Suite 490\nBernierview, DC 76673-5941', '1970-06-28', '2016-10-31', '283-909-1584', '+17269524367', 'zoila89@wisoky.com', 'Mabel Halvorson', '9872395700', 'Tod Ledner', '9769892373'),
(8, 'PURCHASE - LOCAL', '2025-10-15 05:05:37', '2025-10-15 05:05:37', 'TR', 4.35, 'Quis et et aut alias excepturi aut ullam.', 'C', 'Active', 'AI736', 78369.32, 'N', 4764.05, 'INVENTORY', '1765 Eleanore Canyon\nNew Flaviomouth, MS 65651-2005', '1986-07-02', '2013-08-07', '325.539.8949', '413.770.0647', 'frodriguez@kiehn.com', 'Esteban Kautzer', '9887360875', 'Irma Hudson', '9799639891'),
(9, 'PURCHASE - WHOLESALE', '2025-10-15 05:05:37', '2025-10-15 05:05:37', 'GRN', 1.57, 'Ipsam deserunt debitis qui accusantium perferendis voluptate facilis.', 'L', 'Active', 'UJ920', 51556.72, 'Y', 3168.47, 'INVENTORY', '596 Heaney Lock\nSouth Catharinemouth, FL 17152-1860', '1985-03-14', '2025-01-05', '812.614.3332', '1-646-895-8607', 'zita.ryan@yahoo.com', 'Citlalli Lueilwitz', '9855716227', 'Dennis Monahan', '9726715281'),
(10, 'PURCHASE - INDIRECT EXPENSES', '2025-10-15 05:05:37', '2025-10-15 05:05:37', 'T', 12.00, 'Accusamus voluptate aliquid ut explicabo distinctio aperiam nihil.', 'L', 'Inactive', 'VG354', 66993.54, 'N', 3118.96, 'COST OF GOODS SOLD', '274 Stamm Harbor Suite 017\nPinkiehaven, UT 08019', '1970-12-31', '2023-01-16', '+1 (219) 438-7076', '+1.820.770.2315', 'hartmann.sierra@hotmail.com', 'Mrs. Vicenta Homenick V', '9848094357', 'Declan Beatty', '9725068515'),
(11, 'PURCHASE - TAXABLE', '2025-10-15 05:05:37', '2025-10-15 05:05:37', 'TR', 8.69, 'Dolorem repellat dignissimos ut et consequatur ex exercitationem.', 'C', 'Inactive', 'BI892', 83375.66, 'N', 2747.95, 'INVENTORY', '4358 Ebert Heights\nWest Ford, NV 17841-3699', '1985-05-04', '2021-06-24', '913-651-5011', '1-989-395-2941', 'hilma.simonis@kuhn.com', 'Jessie Armstrong', '9819126846', 'Alivia Bechtelar', '9701921404'),
(12, 'PURCHASE - TAX EXEMPTED', '2025-10-15 05:05:37', '2025-10-15 05:05:37', 'PO', 16.45, 'Quia temporibus ut qui doloremque at.', 'L', 'Pending', 'PF674', 28786.95, 'Y', 684.84, 'CAPITAL PURCHASES', '31922 Dayna Grove\nPort Jasmin, LA 26827-5845', '1973-11-29', '2019-10-04', '(231) 962-5961', '928.568.7473', 'katherine15@yahoo.com', 'Prof. Charlene Armstrong IV', '9814543928', 'Rosalind Strosin', '9733797435'),
(13, 'PURCHASE - WHOLESALE', '2025-10-15 05:05:37', '2025-10-15 05:05:37', 'GRN', 8.66, 'Veniam autem et rem odit vero accusamus eum.', 'C', 'Pending', 'LJ766', 13417.21, 'N', 3862.18, 'COST OF GOODS SOLD', '872 Leora Glen\nBaileybury, VA 03534-1240', '1969-03-19', '2019-03-06', '+1 (281) 596-3149', '820.746.3159', 'cweber@mayert.net', 'Oleta McKenzie', '9881319787', 'Millie Pouros', '9758495268'),
(14, 'PURCHASE - LOCAL', '2025-10-15 05:05:37', '2025-10-15 05:05:37', 'TR', 2.04, 'Sed aperiam aut et voluptatibus dicta.', 'L', 'Active', 'BI000', 15727.59, 'N', 69.58, 'CAPITAL PURCHASES', '7206 Maggio Squares Suite 362\nNew Janaeside, NM 37682-3837', '1993-11-05', '2021-03-21', '540-812-8800', '+1 (917) 253-6243', 'ahmed.emard@yahoo.com', 'Dr. Henry Williamson', '9890866033', 'Jena Johns', '9702698207'),
(15, 'PURCHASE - INDIRECT EXPENSES', '2025-10-15 05:05:37', '2025-10-15 05:05:37', 'TR', 13.46, 'Excepturi laboriosam quo architecto enim.', 'C', 'Approved', 'XA586', 24977.25, 'Y', 4728.60, 'PURCHASE & DIRECT EXPENSES', '497 Kessler Overpass\nGrimesborough, LA 13593', '1969-11-03', '2022-08-22', '1-586-690-4355', '385.364.6324', 'kelsie.fadel@bechtelar.net', 'Kailee Cormier', '9881833867', 'Nina Beer', '9738850233'),
(16, 'PURCHASE - DIRECT EXPENSES', '2025-10-15 05:06:20', '2025-10-15 05:06:20', 'PO', 1.31, 'Est aliquid molestiae quas sit quod eos.', 'L', 'Approved', 'YB856', 13368.52, 'N', 1571.63, 'CAPITAL PURCHASES', '3287 Paucek Way\nWest Fabiolaberg, CT 62672', '1978-10-23', '2010-01-07', '+1-706-322-2504', '+1-661-234-9886', 'kayleigh25@yahoo.com', 'Selmer Tromp', '9876065762', 'Miss Violet Prohaska', '9720970461'),
(17, 'PURCHASE - TAXABLE', '2025-10-15 05:06:20', '2025-10-15 05:06:20', 'GRN', 6.53, 'Et sit eos est.', 'L', 'Inactive', 'YF651', 86960.22, 'N', 3518.51, 'COST OF GOODS SOLD', '8268 Abbott Unions\nHallefurt, NC 65749', '1991-05-26', '2021-10-10', '(681) 281-7266', '+13094171149', 'gleichner.fredy@bartoletti.com', 'Agnes Weimann DDS', '9881971174', 'Lempi Prosacco', '9722374289'),
(18, 'PURCHASE - IMPORT', '2025-10-15 05:06:20', '2025-10-15 05:06:20', 'PO', 15.97, 'Beatae et facilis nostrum ab repellendus.', 'L', 'Inactive', 'NZ421', 12928.46, 'Y', 3850.46, 'OPERATING EXPENSES', '406 Douglas Center Apt. 683\nSouth Carolyne, LA 85326-3519', '1999-04-17', '2020-02-06', '716-906-8094', '283-828-2739', 'ugaylord@hotmail.com', 'Alia Boyer', '9879247521', 'Therese Brekke', '9729658215'),
(19, 'PURCHASE - INDIRECT EXPENSES', '2025-10-15 05:06:20', '2025-10-15 05:06:20', 'PO', 7.00, 'Aut iusto voluptatem repellendus voluptatum molestias cupiditate reprehenderit non.', 'L', 'Active', 'EM745', 51515.34, 'N', 4021.72, 'CAPITAL PURCHASES', '56375 Oswald Lodge\nEast Maximillia, SD 95544-1790', '1970-03-18', '2006-11-25', '+19845586827', '(773) 868-3636', 'adickens@brakus.com', 'Kari Collins', '9813217423', 'Mr. Monserrate Hermann', '9795968207'),
(20, 'PURCHASE - TAXABLE', '2025-10-15 05:06:20', '2025-10-15 05:06:20', 'TR', 11.74, 'Voluptatem in sint qui laudantium odit pariatur accusamus.', 'L', 'Pending', 'UK762', 36558.12, 'Y', 2644.49, 'INVENTORY', '21570 Ashly Isle\nWest Opheliaberg, NY 05563', '1997-12-08', '2013-09-16', '(630) 825-2188', '+12246197672', 'caleb.oconner@wilderman.com', 'Miss Bettye Lindgren', '9852558260', 'Edmund Kessler', '9786563026'),
(21, 'PURCHASE - DIRECT EXPENSES', '2025-10-15 05:06:20', '2025-10-15 05:06:20', 'PO', 16.58, 'Adipisci vero atque voluptas consequatur itaque explicabo fugiat.', 'L', 'Pending', 'DZ889', 80754.53, 'N', 3974.97, 'INVENTORY', '84977 Marty Mountains Suite 282\nEstaview, AZ 29344-0508', '1982-03-04', '2018-08-22', '470-676-3498', '(508) 920-2943', 'cleora.schmeler@gmail.com', 'Mr. Osbaldo Cruickshank', '9816486247', 'Ms. Eda Hill MD', '9754853906'),
(22, 'PURCHASE - IMPORT', '2025-10-15 05:06:20', '2025-10-15 05:06:20', 'PO', 13.87, 'Minima delectus quos similique qui recusandae nesciunt.', 'C', 'Approved', 'CI181', 42463.87, 'N', 1352.88, 'PURCHASE & DIRECT EXPENSES', '8755 Gabriella Curve\nEmmerichton, IL 38472', '1980-04-12', '2020-03-31', '+1 (562) 993-0577', '+1 (458) 472-9494', 'berge.ulises@conroy.biz', 'Kitty Raynor MD', '9834652614', 'Dr. Shayna Thiel', '9718420431'),
(23, 'PURCHASE - LOCAL', '2025-10-15 05:06:20', '2025-10-15 05:06:20', 'GRN', 9.90, 'Nam impedit aut velit est voluptate.', 'C', 'Approved', 'NK908', 95700.20, 'N', 2699.04, 'COST OF GOODS SOLD', '83125 Kuhic Highway Apt. 703\nTorphyhaven, WA 55131', '1970-05-07', '2015-05-04', '320.885.4755', '1-281-845-7201', 'ulises.kunze@senger.com', 'Webster Robel', '9853122539', 'Miss Angelica Botsford II', '9705911495'),
(24, 'PURCHASE - WHOLESALE', '2025-10-15 05:06:20', '2025-10-15 05:06:20', 'TR', 8.53, 'Iusto dolor quod laudantium sit omnis excepturi.', 'L', 'Approved', 'BX825', 6337.34, 'N', 921.28, 'PURCHASE & DIRECT EXPENSES', '456 Lakin Burg Apt. 321\nRexland, OH 64451', '1984-07-27', '2021-08-30', '+17408557591', '+1-628-875-7576', 'aswift@hotmail.com', 'Ben Goodwin', '9899200142', 'Dr. Jace Kautzer', '9706764077'),
(25, 'PURCHASE - LOCAL', '2025-10-15 05:06:20', '2025-10-15 05:06:20', 'GRN', 3.58, 'Tempora commodi repellendus ut.', 'L', 'Approved', 'SG018', 59555.31, 'Y', 3892.02, 'INVENTORY', '5458 Uriel Mission Suite 570\nNew Norahaven, LA 74659-0323', '1971-06-05', '2016-01-16', '315-703-2368', '442-218-8148', 'trevion.connelly@yahoo.com', 'Jace Hudson Sr.', '9894002550', 'Earnest Graham', '9724976747'),
(26, 'PURCHASE - DIRECT EXPENSES', '2025-10-15 05:06:20', '2025-10-15 05:06:20', 'T', 8.40, 'Voluptatem sit mollitia suscipit impedit et odit.', 'C', 'Inactive', 'XY758', 70993.97, 'N', 2064.48, 'CAPITAL PURCHASES', '2261 Rupert Prairie\nWestfort, MN 29423', '1974-07-29', '2011-05-13', '901.743.0316', '+1 (929) 701-5065', 'lavonne13@yahoo.com', 'Pat Treutel', '9805602151', 'August Moore', '9728339930'),
(27, 'PURCHASE - INDIRECT EXPENSES', '2025-10-15 05:06:20', '2025-10-15 05:06:20', 'TR', 0.80, 'Officiis aut culpa rerum asperiores possimus delectus.', 'C', 'Inactive', 'LD690', 85255.23, 'Y', 4003.74, 'COST OF GOODS SOLD', '32352 Reichert Street Suite 833\nNew Mitchelland, AK 69534', '1973-09-23', '2021-01-07', '702-257-7623', '+1 (815) 478-7976', 'mleuschke@cronin.com', 'Kiel Berge I', '9849508669', 'Prof. Raina Champlin Sr.', '9771336809'),
(28, 'PURCHASE - TAX EXEMPTED', '2025-10-15 05:06:20', '2025-10-15 05:06:20', 'TR', 17.52, 'Animi architecto doloribus veniam qui dolores maxime sed tenetur.', 'C', 'Pending', 'IC373', 52179.60, 'N', 3796.93, 'OPERATING EXPENSES', '41516 Cleo Unions\nLake Frankhaven, VA 95587', '1994-11-07', '2012-07-15', '+1.864.803.3285', '+1 (336) 285-6641', 'stokes.charles@gmail.com', 'Prof. Obie Kohler', '9875985951', 'Dr. Roxanne Corkery DVM', '9709771960'),
(29, 'PURCHASE - LOCAL', '2025-10-15 05:06:20', '2025-10-15 05:06:20', 'PO', 7.82, 'Quia provident qui non ab placeat.', 'C', 'Active', 'JA306', 99415.03, 'N', 830.42, 'OPERATING EXPENSES', '76094 Della Viaduct Suite 272\nAufderharberg, KY 53094', '2007-05-18', '2012-06-25', '+1-978-959-7739', '+17247327981', 'gracie20@hotmail.com', 'Orpha Morissette', '9830472578', 'Toy Bartoletti', '9702728070'),
(30, 'PURCHASE - TAXABLE', '2025-10-15 05:06:20', '2025-10-15 05:06:20', 'GRN', 15.97, 'Quas excepturi itaque corrupti voluptas quisquam vel.', 'C', 'Active', 'AO093', 18843.38, 'Y', 1864.34, 'INVENTORY', '76639 Electa Fall\nNew Agustinafort, MA 97025-1092', '1995-08-31', '2012-03-26', '510.494.7285', '564-503-7488', 'kayden.kreiger@hotmail.com', 'Paul Pouros', '9859464484', 'Mrs. Modesta Greenfelder', '9717111068');

-- --------------------------------------------------------

--
-- Table structure for table `regional_managers`
--

CREATE TABLE `regional_managers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `mkt_mgr` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `regional_managers`
--

INSERT INTO `regional_managers` (`id`, `code`, `name`, `email`, `mobile`, `address`, `telephone`, `mkt_mgr`, `status`, `created_at`, `updated_at`) VALUES
(1, 'RM001', 'Suresh Kumar Agarwal', 'suresh.agarwal@company.com', '9876543220', 'Corporate Office, Connaught Place, New Delhi', '011-23456789', 'MM001', 'Active', '2025-10-15 04:39:11', '2025-10-15 04:39:11'),
(2, 'RM002', 'Deepika Sharma', 'deepika.sharma@company.com', '9876543221', 'Regional Office, Bandra Kurla Complex, Mumbai, Maharashtra', '022-26789012', 'MM002', 'Active', '2025-10-15 04:39:11', '2025-10-15 04:39:11'),
(3, 'RM003', 'Ravi Chandran', 'ravi.chandran@company.com', '9876543222', 'Tech Park, Electronic City, Bangalore, Karnataka', '080-25678901', 'MM001', 'Active', '2025-10-15 04:39:11', '2025-10-15 04:39:11'),
(4, 'RM004', 'Anjali Verma', 'anjali.verma@company.com', '9876543223', 'Business District, HITEC City, Hyderabad, Telangana', '040-23456789', 'MM003', 'Active', '2025-10-15 04:39:11', '2025-10-15 04:39:11'),
(5, 'RM005', 'Manoj Singh Rajput', 'manoj.rajput@company.com', '9876543224', 'Commercial Complex, MI Road, Jaipur, Rajasthan', '0141-2567890', 'MM002', 'Active', '2025-10-15 04:39:11', '2025-10-15 04:39:11'),
(6, 'RM006', 'Priyanka Nair', 'priyanka.nair@company.com', '9876543225', 'Marine Drive Business Center, Kochi, Kerala', '0484-2345678', 'MM004', 'Inactive', '2025-10-15 04:39:11', '2025-10-15 04:39:11'),
(7, 'RM007', 'Abhishek Ghosh', 'abhishek.ghosh@company.com', '9876543226', 'Salt Lake Sector V, Kolkata, West Bengal', '033-22345678', 'MM005', 'Active', '2025-10-15 04:39:11', '2025-10-15 04:39:11'),
(8, 'RM008', 'Kavitha Reddy', 'kavitha.reddy@company.com', '9876543227', 'Anna Salai Business District, Chennai, Tamil Nadu', '044-24567890', 'MM003', 'Active', '2025-10-15 04:39:11', '2025-10-15 04:39:11'),
(9, 'RM009', 'Harpreet Singh', 'harpreet.singh@company.com', '9876543228', 'Industrial Area Phase 1, Chandigarh', '0172-2678901', 'MM001', 'Active', '2025-10-15 04:39:11', '2025-10-15 04:39:11'),
(10, 'RM010', 'Neha Joshi', 'neha.joshi@company.com', '9876543229', 'Satellite Business Park, Ahmedabad, Gujarat', '079-26543210', 'MM002', 'Active', '2025-10-15 04:39:11', '2025-10-15 04:39:11');

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `alter_code` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `name`, `alter_code`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Mumbai Central Route', 'MCR001', 'Active', '2025-10-27 03:56:24', '2025-10-27 03:56:24'),
(2, 'Delhi North Route', 'DNR002', 'Active', '2025-10-27 03:56:24', '2025-10-27 03:56:24'),
(3, 'Bangalore South Route', 'BSR003', 'Active', '2025-10-27 03:56:24', '2025-10-27 03:56:24'),
(4, 'Chennai Express Route', 'CER004', 'Active', '2025-10-27 03:56:24', '2025-10-27 03:56:24'),
(5, 'Pune Metro Route', 'PMR005', 'Active', '2025-10-27 03:56:24', '2025-10-27 03:56:24'),
(6, 'Hyderabad Tech Route', 'HTR006', 'Active', '2025-10-27 03:56:24', '2025-10-27 03:56:24'),
(7, 'Kolkata East Route', 'KER007', 'Inactive', '2025-10-27 03:56:24', '2025-10-27 03:56:24'),
(9, 'Jaipur Heritage Route', 'JHR009', 'Active', '2025-10-27 03:56:24', '2025-10-27 03:56:24'),
(11, 'dfgdfg', NULL, NULL, '2025-10-27 03:58:29', '2025-10-27 03:58:29'),
(12, 'ddfgd', NULL, NULL, '2025-10-27 03:58:32', '2025-10-27 03:58:32'),
(13, 'dgfdffg', NULL, NULL, '2025-10-27 03:58:37', '2025-10-27 03:58:37'),
(14, 'gdfgdg', NULL, NULL, '2025-10-27 03:58:43', '2025-10-27 03:58:43'),
(15, 'dfgfg', NULL, NULL, '2025-10-27 03:58:47', '2025-10-27 03:58:47');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `series` varchar(10) NOT NULL DEFAULT 'SZ',
  `date` date NOT NULL,
  `invoice_no` varchar(50) NOT NULL,
  `due_date` date DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `salesman_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cash_type` enum('Y','N') NOT NULL DEFAULT 'N',
  `due` decimal(15,2) NOT NULL DEFAULT 0.00,
  `pdc` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `cgst_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `sgst_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `cess_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `case` int(11) NOT NULL DEFAULT 0,
  `box` int(11) NOT NULL DEFAULT 0,
  `nt_amt` decimal(15,2) NOT NULL DEFAULT 0.00,
  `sc` decimal(15,2) NOT NULL DEFAULT 0.00,
  `ft_amt` decimal(15,2) NOT NULL DEFAULT 0.00,
  `dis` decimal(15,2) NOT NULL DEFAULT 0.00,
  `scm` decimal(15,2) NOT NULL DEFAULT 0.00,
  `scm_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `tax_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `excise` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tcs` decimal(15,2) NOT NULL DEFAULT 0.00,
  `sc_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `tax` decimal(15,2) NOT NULL DEFAULT 0.00,
  `net` decimal(15,2) NOT NULL DEFAULT 0.00,
  `packing` varchar(100) DEFAULT NULL,
  `packing_nt_amt` decimal(15,2) NOT NULL DEFAULT 0.00,
  `packing_scm_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `sub_total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `unit` varchar(50) DEFAULT NULL,
  `sc_amt` decimal(15,2) NOT NULL DEFAULT 0.00,
  `scm_amt` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tax_amt` decimal(15,2) NOT NULL DEFAULT 0.00,
  `cl_qty` int(11) NOT NULL DEFAULT 0,
  `dis_amt` decimal(15,2) NOT NULL DEFAULT 0.00,
  `net_amt` decimal(15,2) NOT NULL DEFAULT 0.00,
  `location` varchar(100) DEFAULT NULL,
  `hs_amt` decimal(15,2) NOT NULL DEFAULT 0.00,
  `comp` varchar(100) DEFAULT NULL,
  `srino` varchar(100) DEFAULT NULL,
  `cost_gst` decimal(15,2) NOT NULL DEFAULT 0.00,
  `scm_final` decimal(15,2) NOT NULL DEFAULT 0.00,
  `volume` varchar(50) DEFAULT NULL,
  `batch_code` varchar(100) DEFAULT NULL,
  `status` enum('pending','completed','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `series`, `date`, `invoice_no`, `due_date`, `customer_id`, `salesman_id`, `cash_type`, `due`, `pdc`, `total`, `cgst_percent`, `sgst_percent`, `cess_percent`, `case`, `box`, `nt_amt`, `sc`, `ft_amt`, `dis`, `scm`, `scm_percent`, `tax_percent`, `excise`, `tcs`, `sc_percent`, `tax`, `net`, `packing`, `packing_nt_amt`, `packing_scm_percent`, `sub_total`, `unit`, `sc_amt`, `scm_amt`, `tax_amt`, `cl_qty`, `dis_amt`, `net_amt`, `location`, `hs_amt`, `comp`, `srino`, `cost_gst`, `scm_final`, `volume`, `batch_code`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'SZ', '2025-10-29', '1', '2025-10-29', 4, 4, 'N', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0, 0, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, 0.00, 0.00, 0.00, NULL, 0.00, 0.00, 0.00, 0, 0.00, 0.00, NULL, 0.00, NULL, NULL, 0.00, 0.00, NULL, NULL, 'pending', '2025-10-29 05:03:09', '2025-10-29 05:03:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sales_men`
--

CREATE TABLE `sales_men` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `sales_type` char(1) NOT NULL DEFAULT 'S' COMMENT 'S=Sales Man, C=Collection Boy, B=Both',
  `delivery_type` char(1) NOT NULL DEFAULT 'S' COMMENT 'S=Sales Man, D=Delivery Man, B=Both',
  `mobile` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `pin` varchar(255) DEFAULT NULL,
  `area_mgr_code` varchar(255) NOT NULL DEFAULT '00',
  `area_mgr_name` varchar(255) NOT NULL DEFAULT 'DIRECT',
  `monthly_target` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `created_date` timestamp NULL DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales_men`
--

INSERT INTO `sales_men` (`id`, `code`, `name`, `email`, `sales_type`, `delivery_type`, `mobile`, `telephone`, `address`, `city`, `pin`, `area_mgr_code`, `area_mgr_name`, `monthly_target`, `status`, `is_deleted`, `created_date`, `modified_date`, `created_at`, `updated_at`) VALUES
(1, '3423', 'dgd', NULL, 'S', 'S', NULL, NULL, NULL, NULL, NULL, '00', 'DIRECT', 0.00, '1', 0, '2025-10-14 23:28:37', '2025-10-14 23:28:37', '2025-10-14 23:28:37', '2025-10-14 23:28:37'),
(2, 'SM001', 'Rajesh Kumar', 'rajesh.kumar@company.com', 'S', 'S', '9876543210', '022-12345678', '123 MG Road, Andheri East', 'Mumbai', '400069', '01', 'MUMBAI WEST', 25000.00, '1', 0, '2025-10-14 23:36:15', '2025-10-14 23:36:15', '2025-10-14 23:36:15', '2025-10-14 23:36:15'),
(3, 'SM002', 'Priya Sharma', 'priya.sharma@company.com', 'C', 'D', '9876543211', '011-87654321', '456 CP Market, Connaught Place', 'Delhi', '110001', '02', 'DELHI CENTRAL', 20000.00, '1', 0, '2025-10-14 23:36:15', '2025-10-14 23:36:15', '2025-10-14 23:36:15', '2025-10-14 23:36:15'),
(4, 'SM003', 'Amit Patel', 'amit.patel@company.com', 'B', 'B', '9876543212', '079-11223344', '789 SG Highway, Satellite', 'Ahmedabad', '380015', '03', 'GUJARAT NORTH', 35000.00, '1', 0, '2025-10-14 23:36:15', '2025-10-14 23:36:15', '2025-10-14 23:36:15', '2025-10-14 23:36:15'),
(5, 'SM004', 'Sneha Reddy', 'sneha.reddy@company.com', 'S', 'S', '9876543213', '040-55667788', '321 Banjara Hills, Road No 12', 'Hyderabad', '500034', '04', 'TELANGANA SOUTH', 22000.00, '1', 0, '2025-10-14 23:36:15', '2025-10-14 23:36:15', '2025-10-14 23:36:15', '2025-10-14 23:36:15'),
(6, 'SM005', 'Vikram Singh', 'vikram.singh@company.com', 'S', 'D', '9876543214', '0141-99887766', '654 MI Road, C-Scheme', 'Jaipur', '302001', '05', 'RAJASTHAN EAST', 18000.00, '1', 0, '2025-10-14 23:36:15', '2025-10-14 23:36:15', '2025-10-14 23:36:15', '2025-10-14 23:36:15'),
(7, 'SM006', 'Kavya Nair', 'kavya.nair@company.com', 'C', 'S', '9876543215', '0484-44556677', '987 MG Road, Ernakulam', 'Kochi', '682016', '06', 'KERALA CENTRAL', 15000.00, '0', 0, '2025-10-14 23:36:15', '2025-10-14 23:36:15', '2025-10-14 23:36:15', '2025-10-14 23:36:15'),
(8, 'SM007', 'Arjun Gupta', 'arjun.gupta@company.com', 'S', 'S', '9876543216', '033-22334455', '111 Park Street, Kolkata', 'Kolkata', '700016', '07', 'WEST BENGAL', 40000.00, '1', 0, '2025-10-14 23:36:15', '2025-10-14 23:36:15', '2025-10-14 23:36:15', '2025-10-14 23:36:15'),
(9, 'SM008', 'Meera Iyer', 'meera.iyer@company.com', 'B', 'B', '9876543217', '044-66778899', '222 Anna Salai, T Nagar', 'Chennai', '600017', '08', 'TAMIL NADU', 30000.00, '1', 0, '2025-10-14 23:36:15', '2025-10-14 23:36:15', '2025-10-14 23:36:15', '2025-10-14 23:36:15'),
(10, '345', 'dfgsdfg', NULL, 'S', 'S', NULL, NULL, NULL, NULL, NULL, '00', 'DIRECT', 0.00, '1', 1, '2025-10-14 23:57:11', '2025-10-27 01:45:07', '2025-10-14 23:57:11', '2025-10-27 01:45:07'),
(11, '34534', 'dfgdfg', NULL, 'S', 'S', NULL, NULL, NULL, NULL, NULL, '00', 'DIRECT', 0.00, '1', 1, '2025-10-14 23:57:20', '2025-10-27 01:45:09', '2025-10-14 23:57:20', '2025-10-27 01:45:09'),
(12, '45345', 'fgdfg', NULL, 'S', 'S', NULL, NULL, NULL, NULL, NULL, '00', 'DIRECT', 0.00, '1', 1, '2025-10-14 23:57:27', '2025-10-27 01:45:05', '2025-10-14 23:57:27', '2025-10-27 01:45:05'),
(13, 'r53453', 'sdfgsgg', NULL, 'B', 'B', NULL, NULL, NULL, NULL, NULL, '00', 'DIRECT', 0.00, NULL, 1, '2025-10-27 01:44:55', '2025-10-27 01:45:00', '2025-10-27 01:44:55', '2025-10-27 01:45:00'),
(14, '234234', 'dfgdfgdfg', NULL, 'B', 'B', NULL, NULL, NULL, NULL, NULL, '00', 'DIRECT', 0.00, NULL, 1, '2025-10-27 01:56:45', '2025-10-27 02:05:10', '2025-10-27 01:56:45', '2025-10-27 02:05:10'),
(15, '345234', 'dfsdfsdf', NULL, 'B', 'B', NULL, NULL, NULL, NULL, NULL, '00', 'DIRECT', 0.00, NULL, 1, '2025-10-27 01:56:52', '2025-10-27 02:05:08', '2025-10-27 01:56:52', '2025-10-27 02:05:08'),
(16, '3453434', 'dfgddgf', NULL, 'B', 'B', NULL, NULL, NULL, NULL, NULL, '00', 'DIRECT', 0.00, NULL, 1, '2025-10-27 01:57:02', '2025-10-27 02:05:05', '2025-10-27 01:57:02', '2025-10-27 02:05:05'),
(17, '765', 'htryt', NULL, 'B', 'B', NULL, NULL, 'hgfg', NULL, NULL, '00', 'DIRECT', 0.00, NULL, 1, '2025-10-27 08:09:34', '2025-10-27 08:10:36', '2025-10-27 08:09:34', '2025-10-27 08:10:36');

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(50) DEFAULT NULL,
  `item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `item_name` varchar(255) NOT NULL,
  `batch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `batch` varchar(100) DEFAULT NULL,
  `expiry` varchar(20) DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT 0,
  `free_qty` int(11) NOT NULL DEFAULT 0,
  `rate` decimal(15,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(5,2) NOT NULL DEFAULT 0.00,
  `mrp` decimal(15,2) NOT NULL DEFAULT 0.00,
  `amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_ledgers`
--

CREATE TABLE `sale_ledgers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ledger_name` varchar(255) DEFAULT NULL COMMENT 'Sale Ledger Name',
  `form_type` varchar(255) DEFAULT NULL COMMENT 'Form Type',
  `sale_tax` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Sale Tax Amount',
  `desc` text DEFAULT NULL COMMENT 'Description',
  `type` char(1) NOT NULL DEFAULT 'L' COMMENT 'Type: L (Ledger) or C (Credit)',
  `status` varchar(255) DEFAULT NULL COMMENT 'Status',
  `alter_code` varchar(255) DEFAULT NULL COMMENT 'Alternate Code',
  `opening_balance` decimal(12,2) NOT NULL DEFAULT 0.00 COMMENT 'Opening Balance',
  `form_required` char(1) NOT NULL DEFAULT 'N' COMMENT 'Form Required: Y/N',
  `charges` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Charges Amount',
  `under` varchar(255) DEFAULT NULL COMMENT 'Under which group/ledger',
  `address` text DEFAULT NULL COMMENT 'Address',
  `birth_day` date DEFAULT NULL COMMENT 'Birth Day',
  `anniversary` date DEFAULT NULL COMMENT 'Anniversary',
  `telephone` varchar(255) DEFAULT NULL COMMENT 'Telephone Number',
  `fax` varchar(255) DEFAULT NULL COMMENT 'Fax Number',
  `email` varchar(255) DEFAULT NULL COMMENT 'Email Address',
  `contact_1` varchar(255) DEFAULT NULL COMMENT 'Contact Person 1',
  `mobile_1` varchar(255) DEFAULT NULL COMMENT 'Mobile 1',
  `contact_2` varchar(255) DEFAULT NULL COMMENT 'Contact Person 2',
  `mobile_2` varchar(255) DEFAULT NULL COMMENT 'Mobile 2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_ledgers`
--

INSERT INTO `sale_ledgers` (`id`, `created_at`, `updated_at`, `ledger_name`, `form_type`, `sale_tax`, `desc`, `type`, `status`, `alter_code`, `opening_balance`, `form_required`, `charges`, `under`, `address`, `birth_day`, `anniversary`, `telephone`, `fax`, `email`, `contact_1`, `mobile_1`, `contact_2`, `mobile_2`) VALUES
(1, '2025-10-15 04:25:35', '2025-10-15 04:25:35', 'SALE GST 12%', 'Invoice', 4.98, 'Impedit ab et amet neque.', 'L', 'PENDING', 'SL001', 47370.41, 'Y', 1985.47, 'SALE', '4163 Edwardo Extensions Suite 681\nSouth Esthermouth, IN 99465', '1994-12-05', NULL, '1-262-832-3168', '+1 (407) 248-0803', NULL, 'Dr. Chauncey Krajcik Sr.', '1-341-580-6163', 'Dalton Cormier', NULL),
(2, '2025-10-15 04:25:35', '2025-10-15 04:25:35', 'SALE GST 18%', 'Receipt', 27.80, 'Ab sit minus iure aliquid in quia est.', 'L', '', 'SL002', 64319.20, 'N', 3271.84, 'REVENUE', '94405 Altenwerth Courts Apt. 240\nWest Anjali, ME 30655-5262', '1992-09-19', NULL, NULL, '623-783-0395', 'wstehr@gmail.com', NULL, '+1.559.202.9224', NULL, '+1-810-288-9396'),
(3, '2025-10-15 04:25:35', '2025-10-15 04:25:35', 'SALE GST FREE', 'Quotation', 33.89, 'Expedita doloribus labore numquam culpa porro perspiciatis tenetur.', 'L', 'CLOSED', 'SL003', 44589.31, 'N', 483.58, 'SALE', '20872 Kayley Stream\nLake Bertram, TX 02497-5210', '1970-07-13', '2016-06-08', NULL, NULL, 'lulu.kozey@gmail.com', NULL, NULL, 'Jason Wilkinson', NULL),
(4, '2025-10-15 04:25:35', '2025-10-15 04:25:35', 'SALE CENTRAL FREE', 'Quotation', 11.22, 'Ab sapiente accusantium ea ipsa laudantium deserunt dolores.', 'L', 'CLOSED', 'SL004', 52423.01, 'Y', 3831.78, 'SALE', '187 Kreiger Ways Apt. 801\nEast Jeremyfurt, MA 79614', '1979-02-15', '2007-06-24', '+1 (757) 422-3065', '619.693.9889', 'angelita.homenick@paucek.com', 'Kelsi Bogan II', '+1.678.572.8924', NULL, NULL),
(5, '2025-10-15 04:25:35', '2025-10-15 04:25:35', 'SALE GST FREE', 'Quotation', 10.33, 'Reiciendis amet beatae nesciunt facilis consequatur aliquid sint.', 'C', 'PENDING', 'SL005', 57980.55, 'N', 1844.64, 'INCOME', '96722 Elda Points Suite 727\nTomasaburgh, RI 20458', NULL, NULL, '+1-425-571-4754', NULL, NULL, NULL, '571.423.1084', NULL, '475.550.0266'),
(6, '2025-10-15 04:25:35', '2025-10-15 04:25:35', 'SALE GST 12%', 'Quotation', 22.53, 'Id ratione ut vero at amet.', 'L', '', 'SL006', 63797.96, 'Y', 3849.76, 'SALE', '634 Blick Knoll\nBentonmouth, HI 16142-9711', '2003-02-24', '2025-06-07', NULL, '1-423-852-7980', NULL, NULL, '+1-385-289-7904', NULL, NULL),
(7, '2025-10-15 04:25:35', '2025-10-15 04:25:35', 'SALE GST FREE', 'Quotation', 3.79, 'Eos qui quos rerum reiciendis.', 'C', 'CLOSED', 'SL007', 32144.55, 'N', 4877.48, 'REVENUE', '60864 Hermann Extensions\nLuciochester, AK 98704', '2023-03-05', '1985-09-08', '+1-951-467-3155', NULL, NULL, NULL, '252-714-3642', NULL, '+1 (269) 253-9517'),
(8, '2025-10-15 04:25:35', '2025-10-15 04:25:35', 'SALE GST 18%', 'Invoice', 18.39, 'Iure ut aut molestiae vel quibusdam.', 'L', 'INACTIVE', 'SL008', 12211.97, 'Y', 3947.69, 'INCOME', '44554 Quitzon Mountains Apt. 136\nEast Norberto, MT 89334', '1975-08-03', '2005-10-23', '507.604.8321', '918.908.6832', 'alemke@hotmail.com', NULL, '(951) 908-3586', NULL, '820-938-4626'),
(9, '2025-10-15 04:25:35', '2025-10-15 04:25:35', 'SALE GST 12%', 'Quotation', 48.02, 'Ea voluptatem at sunt saepe laudantium.', 'C', 'CLOSED', 'SL009', 60389.86, 'Y', 2285.38, 'SALE', '98583 Zieme Parks Apt. 995\nHaleytown, MD 01624-2942', NULL, NULL, NULL, NULL, NULL, 'Miss Vallie D\'Amore', '1-220-503-0106', NULL, NULL),
(10, '2025-10-15 04:25:35', '2025-10-15 04:25:35', 'SALE GST FREE', 'Receipt', 23.23, 'Corrupti perspiciatis praesentium aspernatur nulla et.', 'C', 'CLOSED', 'SL010', 93790.18, 'Y', 1414.88, 'INCOME', '8019 Jacky Walks\nCelineberg, NV 13622', '2011-12-24', NULL, NULL, '(469) 793-7469', 'xlangworth@heller.net', NULL, NULL, 'Fabiola Oberbrunner', NULL),
(11, '2025-10-15 04:25:35', '2025-10-15 04:25:35', 'SALE GST 5%', 'Receipt', 48.20, 'Tempora non sit quisquam doloremque harum id.', 'C', 'INACTIVE', 'SL011', 59619.43, 'N', 829.16, 'REVENUE', '52114 Julianne Way\nPort Yvetteburgh, CT 34841-4125', NULL, '2025-02-12', '+1.310.883.3592', NULL, 'runolfsson.teresa@gmail.com', NULL, '+1-402-970-9431', NULL, NULL),
(12, '2025-10-15 04:25:35', '2025-10-15 04:25:35', 'SALE - TAXPAID', 'Bill', 32.81, 'Totam eveniet voluptatem hic id ut necessitatibus.', 'C', 'INACTIVE', 'SL012', 26400.08, 'Y', 4913.61, 'REVENUE', '37929 Rozella Bridge Apt. 046\nAndyton, WI 42703-7368', '2006-02-19', NULL, '+1-657-293-0352', NULL, NULL, NULL, '1-986-672-0558', NULL, NULL),
(13, '2025-10-15 04:25:35', '2025-10-15 04:25:35', 'SALE IGST 5%', 'Invoice', 1.78, 'Consequatur libero qui illo nam.', 'C', 'INACTIVE', 'SL013', 83904.14, 'N', 2908.44, 'REVENUE', '25011 Reilly Orchard\nLake Laceyland, IA 13381', NULL, '1972-07-06', '+1 (217) 783-7380', NULL, NULL, 'Mr. Verner Mayert DDS', '1-564-524-5816', NULL, '+1-252-250-8324'),
(14, '2025-10-15 04:25:35', '2025-10-15 04:25:35', 'SALE GST 28%', 'Invoice', 13.65, 'Deserunt voluptas repellendus atque.', 'L', 'INACTIVE', 'SL014', 89277.23, 'N', 1789.20, '', '3563 Davis Place Suite 344\nLake Wade, ID 26149', '1974-10-24', '1970-07-14', NULL, '+1.520.717.1451', NULL, NULL, NULL, NULL, '+1.414.680.9707'),
(15, '2025-10-15 04:25:35', '2025-10-15 04:25:35', 'SALE IGST 12%', 'Quotation', 13.14, 'Nam unde cupiditate error tenetur doloribus consequatur.', 'C', 'PENDING', 'SL015', 49567.64, 'Y', 286.07, 'REVENUE', '1935 Willis Drive Suite 104\nFrederikburgh, LA 06834', NULL, NULL, NULL, '609-439-1142', NULL, NULL, '+1-480-284-2318', 'Yoshiko Langworth', NULL),
(16, '2025-10-15 04:25:35', '2025-10-15 04:25:35', 'SALE IGST 12%', 'Bill', 11.38, 'Eum quisquam quibusdam esse et molestiae sit eum.', 'L', '', 'SL016', 53552.88, 'N', 1214.47, '', '8523 Maurine Pines Suite 456\nLake Allie, MT 37559', '1981-05-26', '1972-10-12', NULL, '+1.352.229.5921', 'danial98@hotmail.com', NULL, NULL, 'Mr. Tate Adams', '443.960.6540'),
(17, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE CENTRAL FREE', '', 7.65, 'Id doloribus ipsam qui et quia necessitatibus iure.', 'L', 'ACTIVE', 'SL017', 30218.65, 'N', 1152.12, 'INCOME', '908 Raymond Rapid\nWest Abagailville, CT 01907-4199', NULL, NULL, NULL, '+1 (513) 370-4075', 'johnathan.flatley@yahoo.com', 'Dr. Freeda Tremblay', NULL, 'Gunner Hirthe', NULL),
(18, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE GST 18%', 'Bill', 23.03, 'Veritatis natus non dignissimos alias similique ex.', 'L', 'INACTIVE', 'SL018', 97960.84, 'Y', 4493.01, 'SALE', '41288 Federico Burg\nNorth Baylee, DC 50869', '2019-05-26', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '986-489-8255'),
(19, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE GST 12%', 'Bill', 45.14, 'Aperiam veritatis minima tempore dolorem molestiae et asperiores.', 'C', '', 'SL019', 47338.34, 'Y', 707.62, 'INCOME', '54004 Vandervort Skyway Suite 741\nKuhnmouth, CA 56809', '1996-12-14', NULL, '430.713.9958', NULL, NULL, 'Alexandria Ritchie', NULL, 'Kristofer Pouros', '+19282586952'),
(20, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE IGST 12%', 'Quotation', 20.87, 'Et eos quia iste natus eum quis.', 'C', 'PENDING', 'SL020', 49642.82, 'Y', 875.78, 'INCOME', '232 Mckenzie Brooks\nDillonstad, NM 38092', '1990-03-01', '2023-02-22', '781.315.4025', '540-414-0907', NULL, NULL, '743.588.5384', NULL, '458-210-8628'),
(21, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE IGST 12%', 'Quotation', 35.52, 'Earum cum cum quisquam suscipit ad qui deleniti.', 'L', '', 'SL021', 6472.02, 'N', 1414.99, 'INCOME', '9344 Boyer Shores Suite 188\nShieldstown, DC 90582', '1982-06-24', NULL, NULL, '(225) 264-7965', NULL, 'Mrs. Ruthie Rippin', '+1 (865) 399-4483', 'Dr. Ahmad Predovic', '+1 (458) 778-8530'),
(22, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE IGST 12%', 'Receipt', 29.72, 'Tenetur quisquam ex quo hic enim.', 'C', 'CLOSED', 'SL022', 39161.88, 'Y', 1178.34, 'REVENUE', '177 Murray Hills Apt. 896\nHermanport, AK 76386-1310', '2007-12-08', '1994-08-27', '1-571-935-2231', NULL, NULL, 'Geo Rempel', NULL, NULL, NULL),
(23, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE CENTRAL FREE', 'Bill', 19.00, 'Quia qui necessitatibus quisquam et dolor ipsa possimus.', 'L', 'ACTIVE', 'SL023', 95906.17, 'N', 3763.90, 'SALE', '992 Kuphal Plaza\nPort Isabelberg, SD 99717', NULL, NULL, '662-628-6951', '321.632.4919', 'senger.winifred@mitchell.com', 'Micaela Balistreri', NULL, 'Erick Kilback', NULL),
(24, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE GST 5%', '', 31.49, 'Voluptate alias eum quia harum sapiente eius nesciunt.', 'C', 'ACTIVE', 'SL024', 53480.22, 'N', 14.56, 'INCOME', '508 Kellie Common Suite 876\nPort Tatyana, DE 12632-8396', '2014-01-10', NULL, '+1-930-420-9602', '(941) 526-7882', NULL, NULL, NULL, NULL, NULL),
(25, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE CENTRAL FREE', 'Receipt', 44.84, 'Repellat vero vel consequatur.', 'C', 'PENDING', 'SL025', 51082.24, 'Y', 2406.22, 'REVENUE', '607 Blair Common\nJoaquinchester, MN 36480', '1971-01-16', '1994-05-15', NULL, NULL, 'feffertz@gusikowski.com', NULL, '+1-714-776-3639', NULL, '+1-469-976-5863'),
(26, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE - TAXPAID', '', 43.37, 'Est magni magni facilis non nobis laudantium ipsum.', 'C', 'ACTIVE', 'SL026', 19164.77, 'Y', 783.94, 'REVENUE', '158 Lockman Flats Suite 710\nVallieberg, OH 59264-0007', NULL, '1990-05-20', '(316) 937-0434', '520.648.6670', 'linda06@gmail.com', 'Webster Pouros', '+1.254.202.0288', NULL, NULL),
(27, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE IGST 12%', 'Receipt', 32.73, 'Provident enim sequi incidunt velit.', 'C', '', 'SL027', 74221.58, 'Y', 3302.48, 'SALE', '480 Romaguera Skyway\nLake Laurychester, WA 35819', NULL, '1971-09-28', NULL, '+13377860607', 'abbott.gisselle@hintz.net', 'Emmitt Schoen', '(231) 334-3721', NULL, '(361) 628-0029'),
(28, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE IGST FREE', 'Bill', 2.01, 'Possimus facilis et nemo.', 'C', 'ACTIVE', 'SL028', 56161.82, 'N', 170.28, 'INCOME', '5358 Hahn Crescent\nArmstrongland, IN 10315-6047', NULL, NULL, '+1 (484) 650-0769', NULL, NULL, NULL, '+1-334-943-1079', NULL, NULL),
(29, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE - TAXPAID', 'Receipt', 26.43, 'Sed sit pariatur labore ipsum fuga tempora.', 'C', 'ACTIVE', 'SL029', 81901.40, 'N', 1994.57, '', '441 Alanis Cape Apt. 562\nStantonmouth, SD 76023-3902', NULL, '2023-07-28', NULL, NULL, 'hcrona@yahoo.com', NULL, NULL, NULL, NULL),
(30, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE IGST 5%', 'Quotation', 31.52, 'Repudiandae odit animi odit reprehenderit corporis.', 'L', 'CLOSED', 'SL030', 66924.32, 'Y', 1683.53, 'INCOME', '805 Jaden Union\nPort Natalieland, VA 02881', '2012-08-03', NULL, '+1 (225) 268-1243', NULL, NULL, NULL, '339.746.6702', NULL, NULL),
(31, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE IGST 12%', '', 44.59, 'Qui a sint autem itaque tenetur dicta.', 'C', 'INACTIVE', 'SL031', 54070.46, 'Y', 3564.09, 'SALE', '8774 Jones Mall\nLake Adonis, SC 64688', NULL, '2022-02-10', NULL, NULL, NULL, NULL, '+13324577440', NULL, '+1 (320) 288-3163'),
(32, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE GST 5%', 'Invoice', 44.02, 'Voluptates praesentium soluta numquam eligendi.', 'C', 'ACTIVE', 'SL032', 71432.24, 'Y', 514.98, 'SALE', '39396 Robel Lodge\nNorth Rae, OK 47884-9090', NULL, '2003-01-05', '(838) 393-2493', '986.604.9946', 'ron46@gmail.com', NULL, '248-332-2443', 'Lilliana Ward', '872.335.9091'),
(33, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE GST 18%', 'Bill', 42.39, 'Magnam nihil et corrupti in nostrum.', 'L', 'INACTIVE', 'SL033', 8048.61, 'N', 3094.06, '', '891 Amely Manor\nSouth Luellamouth, MD 51028', NULL, NULL, NULL, NULL, 'erna.von@dach.com', NULL, NULL, 'Dolly Gibson MD', NULL),
(34, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE GST 28%', '', 31.71, 'Quam repellat eum repellat aut sequi.', 'C', '', 'SL034', 66765.82, 'N', 736.45, 'INCOME', '5316 Maximus Street Suite 644\nHahnborough, RI 79769-0354', '2024-11-05', NULL, '(564) 608-4626', NULL, NULL, NULL, NULL, NULL, '+1 (325) 528-4870'),
(35, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE IGST 12%', 'Invoice', 4.74, 'Culpa quis et delectus amet pariatur quia accusamus.', 'L', 'PENDING', 'SL035', 57767.68, 'N', 521.47, 'REVENUE', '3293 Tremblay Views\nWest Luciemouth, VT 33947-9610', NULL, '1976-07-25', NULL, '1-520-388-3861', 'khalid.funk@hotmail.com', NULL, NULL, 'Dr. Jessie Waelchi IV', NULL),
(36, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE IGST FREE', 'Bill', 26.15, 'Sint non dolore error non.', 'C', 'INACTIVE', 'SL036', 41948.35, 'Y', 2450.93, 'SALE', '5049 Nolan Pines Apt. 367\nKeyonstad, RI 89508', NULL, '1991-11-01', NULL, NULL, NULL, NULL, '+1-626-986-3727', 'Bertram Dibbert', NULL),
(37, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE CENTRAL FREE', 'Invoice', 4.51, 'Enim voluptatum quas excepturi.', 'C', 'INACTIVE', 'SL037', 58424.14, 'N', 3767.84, 'REVENUE', '44414 Fahey Underpass\nEast Gerardborough, KS 56566', NULL, '1972-09-05', '(669) 328-2824', NULL, NULL, NULL, '+1.906.649.5981', NULL, '+1 (616) 793-9845'),
(38, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE IGST 5%', 'Receipt', 30.52, 'Aliquam consequatur ea fuga ea asperiores officiis qui.', 'L', 'INACTIVE', 'SL038', 61827.32, 'Y', 3992.66, 'INCOME', '916 Langworth Ville Apt. 137\nPort Keiramouth, RI 18689-7142', '1985-10-05', NULL, NULL, '332-663-4160', 'christy.damore@jenkins.com', NULL, NULL, NULL, '1-678-397-3096'),
(39, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE IGST 5%', 'Quotation', 21.75, 'Sint vero id inventore at.', 'C', 'CLOSED', 'SL039', 22204.71, 'N', 654.44, 'INCOME', '68865 Laurie Expressway\nEast Jermain, DE 46819', NULL, '1974-07-02', NULL, NULL, NULL, NULL, NULL, NULL, '+1-320-502-9136'),
(40, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE IGST 12%', 'Bill', 28.51, 'Earum dignissimos aut et sunt.', 'L', 'CLOSED', 'SL040', 85945.97, 'N', 3564.28, 'SALE', '96016 Norwood Greens\nMantestad, CO 49179-1861', NULL, NULL, '760-288-7992', '+1-680-607-9305', 'turcotte.camren@gmail.com', NULL, NULL, 'Prof. Jeramy Gislason IV', '731-376-5141'),
(41, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE IGST FREE', 'Quotation', 36.80, 'Ipsum sunt nesciunt dolor.', 'C', 'INACTIVE', 'SL041', 44134.67, 'Y', 4819.37, 'INCOME', '2903 Ward Hills Suite 192\nNorth Sinceremouth, CA 25828-6657', NULL, '2018-06-06', NULL, NULL, NULL, 'Abbey Bogisich', '1-234-813-3555', NULL, '+17168090970'),
(42, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE GST 5%', 'Quotation', 35.33, 'Autem perferendis magni eligendi eveniet provident maxime et.', 'C', 'CLOSED', 'SL042', 40047.35, 'N', 1802.90, '', '97818 Leif Cape\nPort Matteomouth, KS 02745', '1981-04-15', '1978-05-25', NULL, NULL, 'emmie16@beer.com', NULL, '+1.919.949.3898', 'Abigail Smith', '+1-814-890-0686'),
(43, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE - TAXPAID', 'Invoice', 26.45, 'Asperiores sapiente voluptas non provident quo ut et.', 'L', 'ACTIVE', 'SL043', 66514.60, 'Y', 1041.84, 'REVENUE', '8042 Berry Canyon Suite 292\nWest Nickolasland, NE 74820', NULL, NULL, NULL, '+1 (785) 666-3991', 'willis71@yahoo.com', 'Prof. Amir Morar I', '351-548-2848', 'Jerrold West', '808.515.5671'),
(44, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE GST 28%', 'Bill', 38.52, 'Culpa voluptas odit laboriosam dignissimos atque incidunt velit hic.', 'L', 'PENDING', 'SL044', 48106.55, 'N', 1431.29, '', '6155 Jarod Point Suite 326\nBoganton, UT 09400-2111', NULL, NULL, '1-612-995-0842', NULL, NULL, NULL, '657.522.9421', NULL, '+1-661-810-1396'),
(45, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE GST 12%', '', 24.37, 'Ratione odit beatae possimus voluptas deleniti est iusto.', 'L', '', 'SL045', 48298.81, 'N', 3403.17, '', '493 Mallory Bridge\nGreenfelderburgh, ME 23408-7089', NULL, '2015-04-10', NULL, NULL, 'onicolas@wolff.com', NULL, NULL, NULL, '1-520-691-4449'),
(46, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE IGST 12%', '', 15.76, 'Doloribus voluptas et facilis.', 'L', 'INACTIVE', 'SL046', 95266.86, 'N', 4937.93, 'INCOME', '791 Charity Trafficway\nNorth Aishaberg, AK 10351', NULL, NULL, '+1.802.461.8186', '352-832-4910', NULL, NULL, NULL, NULL, '(207) 823-1023'),
(47, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE - TAXPAID', 'Receipt', 12.47, 'Voluptas maxime libero eum nulla commodi maxime voluptas similique.', 'C', 'PENDING', 'SL047', 5468.51, 'N', 702.65, 'SALE', '651 Cremin Ridges Suite 000\nWest Eltonmouth, MT 02226-7363', NULL, '2019-02-20', '(307) 283-0900', '+17342229885', 'nichole.kovacek@von.info', 'Patsy Haag', NULL, 'Guiseppe Leffler', NULL),
(48, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE - TAXPAID', 'Receipt', 19.64, 'Totam in illo qui modi eos qui harum.', 'L', 'PENDING', 'SL048', 6999.64, 'Y', 3414.08, '', '133 Savanna Trail\nQuitzonville, GA 03829', NULL, '2007-12-26', NULL, NULL, NULL, NULL, '660-260-9690', NULL, '+1.786.873.4028'),
(49, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE GST 12%', '', 28.79, 'Culpa eligendi est accusantium facere.', 'L', 'CLOSED', 'SL049', 19767.93, 'N', 3750.41, 'INCOME', '802 Becker Flats Apt. 010\nAnkundingview, OR 40646', NULL, NULL, NULL, '+1-248-403-5898', 'pkohler@howell.info', 'Dr. Brandon Grimes', '(936) 893-5312', NULL, NULL),
(50, '2025-10-15 04:25:36', '2025-10-15 04:25:36', 'SALE IGST 18%', 'Invoice', 18.19, 'Dignissimos blanditiis ab voluptas provident eveniet maxime.', 'L', 'PENDING', 'SL050', 10793.45, 'Y', 1360.61, '', '115 Wolf Grove\nHilpertshire, AK 71363-7906', '2000-02-09', '1993-12-18', '+16627319273', '1-445-277-7036', NULL, 'Dr. Arielle Wolff IV', '+1-559-649-5638', NULL, '+1 (279) 545-3953'),
(51, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE GST FREE', 'Quotation', 16.28, 'Reprehenderit animi sit dolore quasi doloribus fuga sint.', 'C', '', 'SL001', 41676.66, 'N', 3117.81, 'INCOME', '39479 Adeline Mall\nRyanhaven, CO 56098', '1979-06-28', NULL, NULL, NULL, 'ursula.littel@gmail.com', NULL, NULL, 'Viva Parisian II', NULL),
(52, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE GST 5%', 'Invoice', 14.80, 'Necessitatibus animi eius quo aut.', 'C', 'PENDING', 'SL002', 51385.03, 'Y', 4625.45, 'REVENUE', '2325 Hamill Mills Suite 446\nEast Alysa, IN 07342', '2018-04-12', NULL, NULL, '747.404.7458', NULL, 'Dr. Jovany Strosin', '765-690-9887', 'Dr. Mariela Huel', '845-969-5019'),
(53, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE IGST 12%', 'Receipt', 1.07, 'Qui neque exercitationem consectetur numquam nobis voluptatem sed.', 'C', 'PENDING', 'SL003', 3445.21, 'Y', 4065.51, 'INCOME', '384 Selmer Avenue Apt. 708\nMissouriport, MA 51584-2442', '2010-06-05', '2009-09-21', NULL, '+1-820-407-5360', NULL, NULL, NULL, 'Winifred Feeney', '832-397-9087'),
(54, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE IGST 28%', 'Invoice', 37.67, 'Omnis doloribus aperiam nisi.', 'C', '', 'SL004', 87879.42, 'Y', 4619.11, 'SALE', '96541 Pfeffer Square\nFilibertofort, TN 32397-5145', '1989-12-30', NULL, NULL, NULL, NULL, 'Demario Yundt', NULL, NULL, NULL),
(55, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE GST FREE', '', 11.83, 'Ullam ullam dolores similique sed nobis blanditiis harum.', 'C', 'ACTIVE', 'SL005', 42864.40, 'N', 958.62, '', '1054 O\'Reilly Trace Suite 261\nMetzland, ID 12827-3780', NULL, '1990-01-03', '405-216-5744', '1-253-467-3803', 'ardith.leffler@ratke.net', NULL, NULL, NULL, NULL),
(56, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE GST 12%', 'Quotation', 38.32, 'Magni ut qui at molestiae consequatur nostrum.', 'L', '', 'SL006', 25468.88, 'N', 3126.14, 'INCOME', '55971 Brayan Keys Suite 075\nUllrichfurt, OK 52118-5960', '1988-10-02', NULL, '318.452.4241', NULL, 'cormier.evert@gmail.com', 'Dr. Theo Breitenberg', '+12483855438', 'Sigurd Kshlerin', '+1.561.396.7508'),
(57, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE IGST 18%', 'Bill', 29.28, 'Dignissimos molestias quidem illo officia.', 'L', '', 'SL007', 96496.03, 'Y', 1756.90, '', '91081 Grayce Canyon Apt. 062\nEast Jayneport, AL 36343', NULL, '2025-01-25', '+1.260.707.8649', '+16519175268', NULL, NULL, '+1 (757) 354-6913', NULL, '+1.351.546.2117'),
(58, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE CENTRAL FREE', 'Bill', 10.48, 'Et inventore sit ratione saepe.', 'L', 'CLOSED', 'SL008', 28383.89, 'N', 188.44, 'REVENUE', '595 Lakin Parkway Suite 239\nSouth Finn, OK 90888-4933', NULL, '2011-03-01', '+14359265947', NULL, NULL, NULL, NULL, NULL, '425.829.2952'),
(59, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE - TAXPAID', 'Bill', 43.25, 'Sed voluptas voluptatum praesentium dolor.', 'L', 'INACTIVE', 'SL009', 92324.75, 'N', 1638.27, 'REVENUE', '68631 Alize Meadows Suite 680\nSouth Deloresfurt, LA 11473', '1985-09-29', NULL, '+1-424-808-0102', '+16629856398', NULL, 'Ellie Turner', NULL, NULL, NULL),
(60, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE GST FREE', 'Bill', 12.65, 'Ut ea rerum cumque numquam vel voluptatem tempora in.', 'L', 'ACTIVE', 'SL010', 42987.22, 'Y', 2594.41, '', '670 Kunde Greens\nNew Terrance, ME 92129', NULL, '1973-02-14', NULL, NULL, NULL, 'Aryanna Kovacek', '559.855.7511', NULL, NULL),
(61, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE GST 5%', '', 42.85, 'Veniam corporis alias molestiae ratione corrupti.', 'L', 'CLOSED', 'SL011', 83435.69, 'Y', 1614.00, 'SALE', '7254 Lilly Rapid Suite 867\nWest Meaghan, KS 13009', '1973-12-03', NULL, '283.673.2687', '(856) 879-8758', NULL, 'Daphne Mohr', '+1-219-875-2401', NULL, NULL),
(62, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE IGST 5%', 'Bill', 29.12, 'Accusantium et officiis consectetur nemo.', 'L', 'CLOSED', 'SL012', 3777.65, 'N', 391.64, 'INCOME', '19877 Sporer Fords\nSwiftland, ME 20217-6340', NULL, '2021-06-02', '239.236.0471', '+19014265907', 'umann@yahoo.com', NULL, '830.472.7227', NULL, NULL),
(63, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE GST 18%', 'Quotation', 8.05, 'Voluptatum enim porro animi dolor cupiditate doloribus ut.', 'L', '', 'SL013', 33668.72, 'N', 4534.45, 'INCOME', '5175 Von Rue Suite 406\nLake Ila, CT 42837', NULL, NULL, '445-842-1038', '929.451.9550', 'avolkman@borer.com', NULL, '+18782299840', 'Dr. Rylee Ortiz V', '1-838-536-0390'),
(64, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE GST 12%', 'Receipt', 47.18, 'Minima deserunt omnis animi neque tempore.', 'C', 'INACTIVE', 'SL014', 51896.74, 'N', 2960.39, 'REVENUE', '2477 Janelle Manors Apt. 242\nGeraldineside, WV 80842-1517', NULL, NULL, '413.348.6245', NULL, NULL, 'Philip Reichel', '+14134593603', NULL, NULL),
(65, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE GST 18%', 'Quotation', 0.36, 'Voluptatem molestiae suscipit sit ex impedit porro dolorum.', 'C', 'PENDING', 'SL015', 48600.57, 'Y', 471.92, 'REVENUE', '68177 Alysha Underpass Suite 819\nEast Vancetown, MS 78702', '2014-11-18', NULL, '+1.620.251.1894', NULL, NULL, NULL, '+1-512-943-5889', NULL, '+1.518.870.1098'),
(66, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE GST 28%', 'Invoice', 6.74, 'Eum eos deleniti beatae veritatis ab quia.', 'L', 'CLOSED', 'SL016', 45695.28, 'Y', 2087.95, '', '11330 Blick Plains\nAlfredaburgh, MT 90258-8957', NULL, NULL, NULL, '+17404099319', NULL, 'Xzavier Daugherty', '202-544-3064', NULL, '+1.820.555.2388'),
(67, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE IGST 28%', 'Quotation', 19.62, 'Odio qui aut voluptates nihil libero voluptas.', 'L', 'CLOSED', 'SL017', 40519.86, 'N', 2028.14, 'INCOME', '3122 Wilkinson Rue\nThielchester, ID 56306-3312', '1979-11-12', NULL, '+16204184965', NULL, 'virginia65@hotmail.com', NULL, '702-852-7014', 'Dr. Zita Lesch', NULL),
(68, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE IGST FREE', 'Invoice', 4.25, 'Voluptate quisquam deleniti maxime deleniti consequatur aut illum.', 'C', 'CLOSED', 'SL018', 99132.29, 'Y', 544.55, '', '486 Osbaldo Park Apt. 767\nPort Crystal, TN 59340-4273', NULL, NULL, NULL, NULL, NULL, 'Dr. Hubert Rogahn DDS', NULL, 'Nelle Gutmann', '762-567-8658'),
(69, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE IGST 5%', 'Invoice', 16.42, 'Vero inventore nam minima consequuntur necessitatibus assumenda.', 'L', 'INACTIVE', 'SL019', 58112.51, 'N', 2733.67, '', '68325 Auer Port Suite 227\nSouth Shaniaberg, SD 01572', '2012-12-01', NULL, '1-901-393-1161', NULL, 'harris.kenyon@goyette.org', 'Prof. Glennie Aufderhar', NULL, 'Mr. Marc Kutch PhD', NULL),
(70, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE GST 28%', 'Bill', 35.02, 'Eos voluptatem cum numquam.', 'L', 'ACTIVE', 'SL020', 20625.97, 'Y', 2576.48, 'REVENUE', '7703 Efren Stravenue\nLake Viola, ME 90083', NULL, NULL, NULL, '+16513094224', 'santina.powlowski@gmail.com', 'Tamia Gleason DDS', NULL, 'Alphonso Grady', NULL),
(71, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE IGST 12%', 'Bill', 36.17, 'Accusamus sequi eius eius quibusdam minus.', 'C', 'PENDING', 'SL021', 61606.24, 'N', 2354.91, 'INCOME', '32391 Bryon Motorway Suite 948\nPort Kirkburgh, SD 14011-6460', NULL, '1976-11-16', NULL, '+1-551-695-3173', 'charlotte.kozey@murphy.com', 'Dr. Naomie Greenfelder Jr.', NULL, 'Dr. Geovany Johns V', '213.756.4912'),
(72, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE GST 5%', 'Quotation', 10.71, 'Ipsum optio sed beatae aut fugit perspiciatis id optio.', 'L', '', 'SL022', 38673.37, 'N', 3702.63, '', '536 Towne Row\nPort Myahfort, MA 26284', '1996-04-04', '2020-11-09', NULL, '1-781-474-2571', NULL, 'Sidney Wilkinson IV', NULL, 'Ms. Macie Schinner IV', '+1-718-545-8521'),
(73, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE GST 5%', 'Quotation', 49.44, 'Et modi distinctio ut reiciendis.', 'L', 'INACTIVE', 'SL023', 13254.00, 'N', 3236.93, 'SALE', '341 Myah Garden\nRathborough, ME 82146-6199', NULL, '2017-01-11', '(469) 946-2893', '+17258430779', 'skozey@hotmail.com', 'Akeem Hirthe', '+1 (478) 941-2459', 'Miss Lillie Feeney III', '(820) 704-8691'),
(74, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE IGST 12%', 'Quotation', 22.97, 'Rerum ut et deleniti dolorum et optio.', 'C', '', 'SL024', 41857.82, 'Y', 3259.39, '', '7755 Billy Track Apt. 542\nLake Hassanbury, TN 04364', '1997-03-08', NULL, NULL, NULL, NULL, NULL, '864.243.1651', NULL, '1-802-884-6151'),
(75, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE GST 28%', 'Quotation', 19.54, 'Soluta nisi facilis labore laboriosam.', 'L', 'PENDING', 'SL025', 34638.29, 'Y', 3183.63, 'INCOME', '54404 Leta Plaza Suite 544\nLafayetteland, ME 74423-9866', '2011-12-15', '2025-04-29', '(417) 735-9471', '1-520-871-9665', 'von.freda@yahoo.com', NULL, '262.491.9593', 'Dana Walter', '360-229-3117'),
(76, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE IGST 12%', '', 19.88, 'Reiciendis maxime placeat ut officiis.', 'C', 'CLOSED', 'SL026', 86582.72, 'Y', 1550.46, '', '44289 Koss Turnpike\nBrucefurt, KS 40495-7766', NULL, '2020-06-09', '(445) 730-3685', '660-452-4380', 'mariane.cole@hotmail.com', NULL, NULL, 'Dr. Kellie Blick', '(458) 767-9362'),
(77, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE GST 12%', 'Invoice', 3.44, 'Optio fugiat aut officia illo accusantium ut.', 'C', 'INACTIVE', 'SL027', 53996.12, 'Y', 1309.31, '', '887 Kling Ridges\nDeckowport, SC 09009', '1998-07-21', NULL, '1-574-501-1302', NULL, 'golda.koepp@yahoo.com', 'Jada Koss', '+1 (541) 392-1899', 'Jane Borer', '+1.424.290.9243'),
(78, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE GST 28%', 'Quotation', 17.50, 'Itaque magni non facilis et.', 'C', '', 'SL028', 98213.16, 'Y', 2574.63, 'REVENUE', '87706 Watson Forks\nNorth Kenyattaland, WA 89042-4070', '2025-06-15', NULL, '463.538.1929', '1-772-745-4232', 'shanahan.teagan@vandervort.org', 'Mattie Franecki', '1-203-919-7538', 'Kari Schinner', '(678) 493-6310'),
(79, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE GST 5%', 'Bill', 13.64, 'Dolor animi inventore ducimus voluptates rerum et dolores ipsam.', 'C', 'INACTIVE', 'SL029', 11796.79, 'N', 2150.78, 'REVENUE', '151 Bergstrom Plain Suite 670\nWest Horaciostad, OH 11687', '1981-11-09', NULL, '+1-650-201-7088', '1-805-347-6563', NULL, 'Wayne Klocko', NULL, NULL, '820-984-8478'),
(80, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE IGST 18%', 'Quotation', 12.86, 'Quia nisi sunt tenetur nisi adipisci.', 'L', 'INACTIVE', 'SL030', 89242.63, 'Y', 3432.17, 'INCOME', '69796 Mellie Summit Suite 377\nAbshireborough, ND 67110', '2023-12-21', '2014-05-24', '689.571.4475', '(727) 264-4960', 'demetris.koch@gmail.com', NULL, '1-747-681-8745', 'Gabe Feeney DVM', NULL),
(81, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE GST FREE', 'Quotation', 34.64, 'Ea enim quaerat tempore nobis.', 'L', 'INACTIVE', 'SL031', 31160.17, 'N', 4475.85, '', '95071 Jaycee Way Suite 182\nLake Eugenialand, MN 36497-3023', '1976-07-20', '2011-06-14', '240.253.8017', NULL, 'norbert02@ward.org', NULL, NULL, NULL, '631.396.3410'),
(82, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE GST 5%', 'Quotation', 20.47, 'Ut eius nemo neque.', 'L', 'INACTIVE', 'SL032', 16909.09, 'Y', 1435.06, 'SALE', '78990 Schmeler Stravenue\nGottliebburgh, NJ 53320-1405', '2020-02-21', '2008-10-31', NULL, '940.897.4876', NULL, 'Erwin Roob', NULL, NULL, NULL),
(83, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE - TAXPAID', '', 7.02, 'Accusamus laudantium in voluptatibus et.', 'L', 'CLOSED', 'SL033', 14892.93, 'N', 2230.52, 'SALE', '46618 Reyes Knoll\nBahringerport, NE 01457', '1986-02-16', NULL, '+1 (515) 767-2795', NULL, NULL, 'Gail Smith', '+13109216556', NULL, NULL),
(84, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE GST 28%', '', 41.24, 'Iusto quasi pariatur excepturi est qui odio.', 'L', '', 'SL034', 43656.27, 'Y', 2231.70, 'INCOME', '120 Will Skyway\nPort Yasmin, WY 71462-0502', NULL, '1977-07-27', NULL, NULL, 'fwilderman@hotmail.com', 'Krystal Lesch', NULL, NULL, '908.304.4899'),
(85, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE IGST 5%', '', 35.84, 'Natus laborum provident maxime suscipit.', 'C', 'CLOSED', 'SL035', 89905.32, 'N', 2677.74, 'INCOME', '20501 Diamond Center\nLoweport, KY 57718', '1987-08-31', NULL, NULL, NULL, 'raltenwerth@baumbach.com', 'Yasmine Gibson', '+1.337.663.2518', 'Elfrieda Murphy', '1-334-457-6467'),
(86, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE IGST FREE', 'Bill', 16.58, 'Beatae molestias reiciendis eum dolores.', 'C', 'ACTIVE', 'SL036', 65018.37, 'Y', 3743.20, 'SALE', '3423 Terrence Prairie Suite 326\nHegmannborough, ID 18759-6433', NULL, '2000-12-06', NULL, NULL, NULL, NULL, NULL, NULL, '(312) 940-8613'),
(87, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE GST 18%', 'Quotation', 0.95, 'Ut est recusandae id blanditiis nostrum.', 'C', '', 'SL037', 9167.94, 'N', 4417.40, '', '728 Rutherford Fork\nHudsonbury, SC 13480-3949', NULL, NULL, NULL, NULL, 'ressie.will@yahoo.com', 'Pierce Schiller II', NULL, 'Benny Bashirian', NULL),
(88, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE IGST FREE', 'Quotation', 34.52, 'Dolor voluptatibus vitae aut fugit sint assumenda architecto.', 'L', '', 'SL038', 99638.30, 'N', 3881.37, 'INCOME', '95992 Bins Summit Suite 734\nPaucekfurt, GA 87197-2926', NULL, '2006-04-22', '(650) 912-3998', '747-526-8988', 'cgoyette@rutherford.net', 'Prof. Mike Klocko', NULL, NULL, '+1.509.662.3221'),
(89, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE IGST 12%', 'Bill', 28.92, 'Assumenda provident dignissimos eius voluptas et.', 'L', 'ACTIVE', 'SL039', 74427.52, 'N', 2476.41, '', '191 Baumbach Square Apt. 095\nEast Jakayla, CO 79901', '1996-05-03', NULL, '+1.734.971.8800', NULL, 'lschmidt@rutherford.com', 'Aileen Harvey', '1-308-587-4060', 'Prof. Providenci McCullough V', NULL),
(90, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE IGST FREE', '', 31.63, 'Excepturi non dignissimos expedita et debitis quam.', 'C', 'PENDING', 'SL040', 21854.80, 'Y', 2797.00, 'REVENUE', '516 Feest Village\nKundeside, MS 59043-6289', NULL, '1975-02-09', NULL, NULL, NULL, NULL, NULL, 'Mohamed Legros', NULL),
(91, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE IGST FREE', 'Invoice', 8.40, 'Cupiditate velit omnis id in asperiores inventore cupiditate sunt.', 'L', 'INACTIVE', 'SL041', 71939.52, 'Y', 4765.62, 'INCOME', '7719 Kuphal Branch Suite 008\nRossiechester, LA 12853-9276', '2024-06-20', '1985-03-12', '816-479-6218', NULL, NULL, NULL, '520-699-9049', 'Miss River Lowe', NULL),
(92, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE IGST 5%', 'Invoice', 42.63, 'Placeat dolores doloribus repellat ut dicta repellat nihil.', 'L', 'CLOSED', 'SL042', 3237.51, 'Y', 2265.38, 'SALE', '837 Mercedes Throughway\nLake Joshuahhaven, PA 97121', '1972-10-20', NULL, '+1 (848) 603-3974', '+1 (432) 569-9016', NULL, 'Melyna Shields', NULL, 'Garry Bergstrom', NULL),
(93, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE GST 28%', 'Receipt', 33.12, 'Aliquid saepe velit tempore error facilis.', 'L', 'PENDING', 'SL043', 41120.33, 'Y', 737.16, 'REVENUE', '64489 Jacobson Locks Apt. 433\nPriceside, SD 60170', '1985-06-10', '1975-12-25', '(930) 292-3818', '(980) 276-5001', NULL, 'Miss Fanny Price', NULL, NULL, NULL),
(94, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE IGST 18%', 'Invoice', 8.37, 'Nesciunt nihil aspernatur aut tenetur.', 'C', 'ACTIVE', 'SL044', 14937.67, 'Y', 2372.35, 'REVENUE', '700 McGlynn Plain Apt. 422\nNew Adeline, MA 79083', '2011-07-22', '2016-01-31', '(430) 356-6523', '(267) 508-8371', NULL, 'Velda Price', '+1 (351) 214-8245', 'Wilma Kertzmann', NULL),
(95, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE IGST FREE', 'Receipt', 29.75, 'In quod maiores voluptate aspernatur aut qui.', 'C', 'INACTIVE', 'SL045', 37166.51, 'N', 4369.65, 'REVENUE', '5340 Watsica Mews\nWest Milo, WY 56554', '2014-08-18', '1985-12-29', NULL, '+1-845-869-7684', NULL, NULL, '1-629-262-9528', NULL, NULL),
(96, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE IGST 12%', 'Receipt', 9.12, 'Consequatur beatae harum ab.', 'L', 'INACTIVE', 'SL046', 78250.99, 'N', 1297.97, 'REVENUE', '9746 Ellen Ramp\nEast Theodora, AR 42477', NULL, '2013-04-20', '+1 (346) 525-4437', '+14582976831', 'goldner.margarette@steuber.com', NULL, NULL, NULL, NULL),
(97, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE IGST 12%', 'Bill', 12.50, 'Molestiae cumque corrupti molestiae.', 'L', 'CLOSED', 'SL047', 73729.60, 'Y', 4268.55, 'REVENUE', '205 Dicki Radial\nPort Magdalen, GA 64756', '1982-10-07', '2020-11-25', '979-375-8512', NULL, 'klebsack@yahoo.com', 'Prof. Demond Goodwin', '(706) 222-5552', NULL, NULL),
(98, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE IGST 5%', 'Invoice', 44.98, 'Voluptatibus ut numquam porro recusandae.', 'C', 'CLOSED', 'SL048', 65592.69, 'Y', 2632.83, 'REVENUE', '54389 Steuber Shore Suite 642\nPort Freidashire, OR 43136-6551', NULL, NULL, NULL, '(402) 539-1526', NULL, 'Maxie Steuber', '1-432-939-2780', 'Miss Tara Marks V', '1-341-673-6473'),
(99, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE GST FREE', 'Receipt', 16.40, 'Nesciunt placeat odio non accusantium alias sed culpa.', 'L', 'ACTIVE', 'SL049', 53589.62, 'N', 223.30, 'SALE', '464 Gutmann Mill Apt. 351\nEast Junius, MS 82776', '2010-04-04', NULL, '+1.432.720.6083', NULL, NULL, 'Zora Trantow', '657-583-2331', NULL, '253-825-5554'),
(100, '2025-10-15 04:26:32', '2025-10-15 04:26:32', 'SALE IGST 28%', 'Quotation', 38.78, 'Adipisci quos ad voluptas delectus eum.', 'C', 'CLOSED', 'SL050', 14406.79, 'Y', 558.43, '', '1211 Adele Creek\nEast Elmo, SC 46362-6653', '1983-03-16', NULL, NULL, NULL, NULL, 'Mrs. Jena Christiansen', NULL, 'Lessie Mayert MD', '+1.931.761.8651'),
(101, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE GST 5%', 'Bill', 26.24, 'Natus culpa illo unde animi eveniet voluptas ut.', 'L', 'PENDING', 'SL001', 16707.49, 'Y', 3317.67, '', '67984 Reynolds Garden Suite 238\nEast Lelahaven, FL 66348-6830', '1978-12-17', NULL, NULL, '(435) 203-6197', NULL, 'Anderson Hagenes II', '(640) 760-9289', NULL, NULL),
(102, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE IGST 28%', '', 35.32, 'Ad aut consectetur accusantium voluptatum est et.', 'C', 'CLOSED', 'SL002', 60490.63, 'Y', 3365.59, 'REVENUE', '118 Kub Hollow Apt. 897\nNew Emelie, AZ 72238-4539', '1988-03-14', '1992-10-17', '747-479-9141', NULL, 'frieda.tremblay@hotmail.com', 'Dr. Anibal Wyman MD', NULL, NULL, '(763) 802-7993'),
(103, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE IGST 12%', '', 43.56, 'Perferendis aut nam commodi id.', 'L', '', 'SL003', 45590.92, 'Y', 1747.99, '', '2224 Skiles Square\nFeeneyborough, CT 25579-4921', NULL, '2020-06-16', NULL, '1-225-937-2859', NULL, NULL, NULL, NULL, '+1-854-997-5299'),
(104, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE IGST FREE', '', 14.26, 'Consectetur quos sed aspernatur qui itaque quo voluptatem.', 'C', '', 'SL004', 24744.83, 'N', 2001.55, 'INCOME', '488 Hoppe Plaza Suite 398\nNathanborough, MO 24611', '2003-10-15', '1972-12-24', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(105, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE IGST 18%', 'Receipt', 18.87, 'Accusamus rem esse ut repudiandae vel ipsam fuga.', 'C', 'PENDING', 'SL005', 66727.27, 'N', 3221.94, 'INCOME', '909 Weimann Junctions Suite 063\nMorissettebury, DE 51779-5572', '2015-12-05', '1992-01-16', NULL, '657.456.4803', 'swaniawski.verla@dickinson.biz', NULL, '1-947-670-6707', 'Margarita Zieme', '541-830-0066'),
(106, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE IGST 5%', 'Invoice', 43.15, 'Ut facere dolore tempora mollitia nesciunt laudantium distinctio.', 'L', 'CLOSED', 'SL006', 65911.60, 'N', 3859.43, '', '736 Louisa Fords Apt. 659\nLake Garrettbury, TX 47397', '2002-04-22', '2004-10-12', '+1-847-826-7171', NULL, 'koelpin.marilie@yahoo.com', NULL, '+12399205494', 'Dr. Liana Schmeler', '937.708.9150'),
(107, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE IGST FREE', '', 22.36, 'Maxime laboriosam unde doloribus dolore dolorem et voluptate.', 'L', 'PENDING', 'SL007', 45964.19, 'N', 1969.92, 'SALE', '9407 Sasha Mount Suite 209\nPort Breanashire, AK 80738', NULL, '1975-05-12', NULL, NULL, 'alfredo.conn@hotmail.com', NULL, NULL, 'General Howell', '+19722275891'),
(108, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE GST 5%', 'Bill', 28.64, 'Fuga ut enim non sint rerum.', 'L', '', 'SL008', 69921.78, 'Y', 1576.51, 'REVENUE', '636 Marcia Ports Suite 086\nStanleyside, KS 40751', NULL, NULL, '1-580-289-2833', NULL, NULL, NULL, NULL, NULL, '+1.380.228.0877'),
(109, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE IGST FREE', '', 17.66, 'Rerum et error repellendus non neque omnis similique.', 'C', '', 'SL009', 35227.90, 'Y', 3829.20, 'REVENUE', '963 Kayden Junction Apt. 447\nNew Edwardo, FL 38767', '2010-06-13', '2004-02-20', NULL, '406.881.1284', 'jakubowski.nicole@hotmail.com', 'Bettye Haley', NULL, NULL, NULL),
(110, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE IGST 28%', 'Bill', 14.45, 'Totam suscipit earum deleniti fugit iure placeat.', 'C', '', 'SL010', 824.04, 'Y', 4217.35, 'SALE', '231 Orn Shoal Suite 934\nNorth Floydberg, MN 41402-0483', NULL, '1984-12-18', '650.342.5230', '+1.781.617.1881', NULL, NULL, '(586) 975-9622', NULL, '+1 (458) 754-8167'),
(111, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE GST 18%', 'Bill', 42.00, 'Non laudantium ut omnis reiciendis molestiae nobis.', 'L', 'PENDING', 'SL011', 14127.41, 'N', 3651.86, 'INCOME', '96323 Kristin Passage\nJacobishire, OK 78588', '1989-11-25', NULL, NULL, '323.265.7055', 'waldo.shields@yahoo.com', 'Jacinto Kertzmann', NULL, 'Prof. Adelle Buckridge DVM', NULL),
(112, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE GST 28%', 'Receipt', 8.57, 'Ut at sed occaecati neque necessitatibus voluptatem.', 'L', 'INACTIVE', 'SL012', 32395.51, 'Y', 4050.35, 'INCOME', '63642 Gleason Square\nDickensfort, LA 32890-2498', '1987-08-06', '2023-09-20', NULL, NULL, 'ledner.kyleigh@gmail.com', NULL, '+1-743-227-0583', 'Maximus Runolfsdottir', NULL),
(113, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE - TAXPAID', 'Receipt', 47.22, 'Ipsa sit sapiente corporis ipsa quos deleniti natus quia.', 'L', 'ACTIVE', 'SL013', 15769.46, 'Y', 4316.72, 'SALE', '45597 Thiel Crest Suite 570\nNew Florence, AL 70675', NULL, '1999-08-02', '1-531-619-5168', '(253) 852-2106', 'walter.mack@lowe.com', NULL, '(640) 813-5275', NULL, '575-457-8663'),
(114, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE IGST 28%', '', 26.68, 'Temporibus consectetur nisi beatae sit quidem.', 'L', 'PENDING', 'SL014', 76742.13, 'N', 3258.23, '', '57141 McLaughlin Rapids Suite 935\nKohlerburgh, CT 25805', '1977-12-16', '2009-03-28', NULL, '+16198007040', NULL, 'Prof. Edwin Lueilwitz', NULL, 'Alejandra Turcotte', '+1-936-834-4485'),
(115, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE IGST 18%', 'Receipt', 29.24, 'Impedit quibusdam voluptas velit magnam sunt.', 'C', '', 'SL015', 92811.33, 'N', 796.27, 'INCOME', '6910 McLaughlin Heights Apt. 733\nLake Laurianeville, DE 52709', NULL, '1999-10-31', '+1.570.983.6910', '+1-757-635-8220', NULL, 'Travon Dicki DVM', NULL, 'Erna Cole', NULL),
(116, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE IGST 18%', 'Bill', 15.57, 'Suscipit sint quo aut laboriosam doloribus blanditiis possimus.', 'L', 'PENDING', 'SL016', 84316.73, 'Y', 3243.03, '', '85979 Harvey Ports\nLake Matteohaven, TX 58856', NULL, NULL, NULL, NULL, NULL, NULL, '+1.845.208.8507', NULL, NULL),
(117, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE CENTRAL FREE', '', 8.84, 'Atque enim vitae non atque.', 'C', 'ACTIVE', 'SL017', 56837.31, 'Y', 3448.85, '', '856 Athena Roads Suite 223\nUnaborough, DE 75984-4188', '2017-01-24', '2014-08-22', NULL, '682-655-9323', NULL, 'Prof. Willy Wiza MD', '+1 (689) 802-6910', NULL, '+1-631-520-6058'),
(118, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE GST FREE', 'Receipt', 11.18, 'Cum in ullam a.', 'L', '', 'SL018', 64952.91, 'Y', 1462.27, '', '29074 Murazik Meadows\nLake Thurman, MD 59204', '2025-08-03', '1978-04-07', '+1.726.919.5005', NULL, NULL, NULL, '+1-564-403-3435', 'Miss Evangeline Reichert', NULL),
(119, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE GST 28%', '', 41.59, 'Aperiam eius et cupiditate aut.', 'C', 'PENDING', 'SL019', 81386.82, 'N', 1993.81, 'REVENUE', '33431 Augustus Square Apt. 004\nCristshire, TX 53054-5615', NULL, '1991-01-14', NULL, NULL, NULL, 'Charlotte Legros', '240.273.6262', NULL, NULL),
(120, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE CENTRAL FREE', 'Invoice', 21.75, 'Voluptas voluptatem quis minus tempora sunt laboriosam aliquid.', 'L', 'CLOSED', 'SL020', 98277.79, 'Y', 2476.74, '', '88077 Hyatt Forest\nNew Ronny, VT 90611', NULL, NULL, '(216) 595-2890', NULL, NULL, 'Timmy Lindgren', '+1.267.204.2907', NULL, '478-446-4310'),
(121, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE IGST 12%', 'Bill', 10.94, 'Ut eum quos suscipit sit.', 'L', 'PENDING', 'SL021', 19172.66, 'Y', 764.21, '', '329 Terry Overpass Suite 013\nMcLaughlinstad, WA 57811', NULL, '1993-08-15', '1-937-291-7599', '1-234-289-3108', 'earl.bruen@west.net', 'Dr. Jabari Brown DVM', '+15208523040', 'Domenick Fisher', NULL),
(122, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE - TAXPAID', 'Bill', 32.99, 'Tenetur qui libero et tenetur.', 'L', 'INACTIVE', 'SL022', 21780.38, 'Y', 4644.62, 'REVENUE', '50408 Dulce Wells\nLake Allan, TN 30199-9972', '2012-12-19', '1972-07-12', NULL, NULL, 'nitzsche.mikayla@hotmail.com', 'Eleazar Durgan V', '1-916-544-6238', 'Lee Gleichner', NULL),
(123, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE GST 28%', 'Bill', 44.20, 'Non consequatur dicta et repellat explicabo libero.', 'C', 'CLOSED', 'SL023', 89641.49, 'Y', 2760.09, 'SALE', '452 Jast Green\nRatkeport, SD 45682', NULL, NULL, NULL, '1-864-600-6471', NULL, 'Florian Ward', NULL, NULL, NULL),
(124, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE GST 12%', 'Bill', 42.85, 'Sed sit quia fugit vel alias ipsum.', 'L', 'ACTIVE', 'SL024', 33488.79, 'N', 136.80, 'SALE', '24961 Kilback Mission\nCarmelatown, HI 50116-7286', NULL, '2016-04-08', '+1.559.885.6638', NULL, 'ward.lea@hotmail.com', 'Haleigh Wisoky', NULL, 'Aryanna Jast', NULL),
(125, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE GST 5%', 'Quotation', 27.81, 'Similique optio neque culpa rerum delectus.', 'L', '', 'SL025', 68479.71, 'N', 4859.12, 'INCOME', '848 Caterina Island\nNew Elenafurt, DC 78037-3886', '2011-07-20', '2013-09-15', '1-262-482-4820', '+1 (256) 439-5999', NULL, NULL, '(941) 215-2059', 'Edmund Stoltenberg', NULL),
(126, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE IGST 28%', 'Bill', 44.79, 'Maxime nostrum porro possimus fuga voluptas dolores.', 'L', 'INACTIVE', 'SL026', 1374.83, 'N', 1496.40, 'SALE', '25072 Fahey Greens\nLake Enidshire, LA 15768-1428', '2005-06-13', NULL, NULL, '+1.434.638.2439', 'qmoen@hotmail.com', 'Geo Conroy MD', '531.606.5181', 'Maybell Cummings', '747-690-5416'),
(127, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE IGST 12%', 'Quotation', 48.44, 'Asperiores voluptatem delectus autem assumenda.', 'L', 'PENDING', 'SL027', 17057.70, 'Y', 291.28, 'REVENUE', '2542 Odie Plains\nHoweville, NE 30688-0020', NULL, NULL, NULL, NULL, NULL, 'Mable Kohler', NULL, 'Rosario Lind', '+1-520-440-8527'),
(128, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE IGST 18%', 'Receipt', 13.38, 'Voluptatibus voluptate eius dicta deleniti.', 'L', '', 'SL028', 76064.61, 'Y', 1862.42, 'SALE', '44166 German Springs\nLeonoraland, TN 72411-8756', '1973-11-11', NULL, NULL, '520.230.8551', NULL, 'Marty Hauck', '+1-469-840-1288', NULL, NULL),
(129, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE CENTRAL FREE', 'Quotation', 43.82, 'Sed perferendis rerum ut explicabo rerum repellat.', 'L', '', 'SL029', 11919.15, 'N', 918.86, '', '97495 Gutkowski Creek\nNew Darrickland, MI 06524-4845', '2000-03-28', '1980-12-17', '708-654-1546', '+1.949.882.5579', 'veda.schmitt@gmail.com', NULL, '(765) 440-0089', NULL, '202-501-5011'),
(130, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE CENTRAL FREE', 'Invoice', 24.67, 'Accusamus ullam natus explicabo nesciunt repellendus beatae.', 'C', 'PENDING', 'SL030', 2848.67, 'N', 3567.12, 'SALE', '3853 Kerluke Coves\nKoreyton, NM 84208', '2002-12-11', NULL, NULL, '1-726-438-0931', NULL, 'Milan Daniel', NULL, NULL, '(248) 297-8858'),
(131, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE IGST 28%', 'Quotation', 7.17, 'Sint et nihil maiores ipsa minima dolor ut reiciendis.', 'C', '', 'SL031', 64956.93, 'Y', 3939.49, '', '72324 Abbott Branch\nMyrtieburgh, MO 81079', '2025-08-05', NULL, NULL, '820.649.0549', 'fahey.grace@vandervort.com', NULL, '1-469-485-3538', NULL, '+1 (239) 875-4441'),
(132, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE IGST FREE', 'Bill', 1.06, 'Maiores delectus reprehenderit neque tenetur eveniet possimus.', 'C', 'INACTIVE', 'SL032', 91760.58, 'Y', 1890.93, '', '19772 Orn Square\nCandidoland, DE 82727', '1989-01-09', NULL, NULL, '1-404-726-0911', NULL, 'Hunter Blick', '1-989-852-9420', NULL, NULL),
(133, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE GST 5%', 'Bill', 13.76, 'Non molestias eveniet qui.', 'L', '', 'SL033', 11972.91, 'Y', 4363.50, 'INCOME', '53296 Pouros Expressway\nNorth Chesterbury, DE 62143', NULL, '1982-11-24', '1-531-384-0883', NULL, 'cedrick.daugherty@vandervort.com', NULL, '1-854-395-5287', 'Ezra Quitzon Jr.', '+12798048637'),
(134, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE IGST 28%', 'Receipt', 49.23, 'Eos officiis laboriosam nobis fugiat enim nesciunt ea.', 'C', 'CLOSED', 'SL034', 97020.64, 'Y', 700.98, '', '4552 O\'Keefe Fall Suite 615\nNew Keegan, MA 96907-9106', NULL, '2001-11-21', '283-941-6951', NULL, NULL, NULL, '+1 (906) 980-4196', 'Vern Rowe', '1-970-383-5124'),
(135, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE IGST 12%', 'Invoice', 36.59, 'Officiis voluptatibus aut eos dolores.', 'C', 'CLOSED', 'SL035', 81223.76, 'Y', 3196.62, '', '63955 Schroeder Haven Suite 319\nWest Sheldonton, AZ 00625-8615', '1982-12-29', NULL, '+1-470-616-5794', '629-298-4091', 'marlee.prohaska@yahoo.com', NULL, NULL, NULL, NULL),
(136, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE IGST 5%', '', 16.53, 'Qui tenetur nemo animi vitae asperiores temporibus.', 'L', 'ACTIVE', 'SL036', 43910.38, 'Y', 4685.40, 'SALE', '5278 Oberbrunner Rest Apt. 711\nAntoniettaport, ND 22217-7469', '1988-02-02', NULL, '386-327-0107', '559.895.5533', NULL, NULL, NULL, 'Helene Wyman', NULL),
(137, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE GST 5%', '', 39.25, 'Rem nulla autem reiciendis aut.', 'C', 'INACTIVE', 'SL037', 12994.06, 'N', 4040.43, '', '9592 Kertzmann Highway Suite 419\nWest Marley, DE 25825', '2025-01-19', '1984-06-02', NULL, NULL, 'julius.kuhn@hoeger.com', NULL, NULL, 'Beryl Kunze', '+1 (608) 305-5611'),
(138, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE GST 5%', 'Quotation', 36.71, 'Omnis distinctio veritatis rerum sapiente laudantium perspiciatis debitis.', 'L', 'ACTIVE', 'SL038', 86135.53, 'Y', 2460.08, 'REVENUE', '1149 Johnson Cliff\nSouth Watson, IN 27249', '1973-11-12', NULL, '+1-458-865-3782', '+1 (267) 855-8691', NULL, NULL, NULL, 'Hallie Hickle', '+1-805-378-3175'),
(139, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE GST 18%', 'Invoice', 23.04, 'Qui omnis quisquam voluptas id.', 'L', 'INACTIVE', 'SL039', 17629.60, 'N', 113.66, 'INCOME', '3168 Schulist Springs\nClevelandview, OR 39322-8341', NULL, NULL, '+1-762-435-4294', '603.844.1539', 'bartell.penelope@oconnell.com', NULL, '1-857-827-6638', NULL, NULL),
(140, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE IGST 18%', 'Invoice', 9.95, 'Nihil recusandae voluptas iusto debitis sequi in.', 'L', 'ACTIVE', 'SL040', 3496.96, 'Y', 465.77, 'REVENUE', '1621 Ole Throughway\nKoeppberg, CA 07201-4829', NULL, NULL, NULL, '1-657-368-3890', NULL, NULL, NULL, 'Mr. Cecil Hoeger IV', NULL),
(141, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE GST 18%', 'Receipt', 8.17, 'Cum excepturi nam aliquam doloremque quia sed est.', 'C', 'INACTIVE', 'SL041', 21586.44, 'Y', 4837.01, 'INCOME', '93076 Hintz Extensions Apt. 189\nRaphaelshire, NH 00584-5799', NULL, '2009-10-19', NULL, NULL, 'jarod.stroman@hodkiewicz.com', NULL, NULL, 'Marisol Kertzmann', NULL);
INSERT INTO `sale_ledgers` (`id`, `created_at`, `updated_at`, `ledger_name`, `form_type`, `sale_tax`, `desc`, `type`, `status`, `alter_code`, `opening_balance`, `form_required`, `charges`, `under`, `address`, `birth_day`, `anniversary`, `telephone`, `fax`, `email`, `contact_1`, `mobile_1`, `contact_2`, `mobile_2`) VALUES
(142, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE IGST 12%', 'Bill', 7.73, 'Officiis rerum incidunt ea et ab in.', 'C', '', 'SL042', 31472.93, 'N', 2594.42, 'SALE', '853 Shanahan Ferry Suite 208\nCorkeryborough, NH 94113', NULL, NULL, '1-878-571-1874', '+1-570-300-6580', NULL, 'Mr. Jamaal Pacocha PhD', '1-850-746-5040', NULL, NULL),
(143, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE GST 18%', 'Bill', 10.53, 'Laborum doloremque necessitatibus dolores asperiores maxime aut.', 'C', 'INACTIVE', 'SL043', 6159.56, 'Y', 2909.94, 'SALE', '9002 Tom Wells Apt. 011\nLake Kadinburgh, UT 43029-5357', '2004-02-06', '1996-08-24', NULL, NULL, 'vivienne06@smith.com', 'Estevan Grant II', '1-276-980-8713', NULL, NULL),
(144, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE IGST 5%', 'Quotation', 21.34, 'Deleniti officiis numquam sed odit ullam voluptatem dolorum.', 'C', 'CLOSED', 'SL044', 33733.91, 'N', 81.75, 'REVENUE', '895 Briana Crescent\nBrownstad, IN 73598-9158', NULL, NULL, NULL, NULL, 'amelia03@ankunding.com', 'Dr. Micah Torp PhD', '(413) 809-5709', NULL, '973-275-7991'),
(145, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE IGST FREE', 'Bill', 33.61, 'Sed beatae velit expedita atque aliquam quia amet culpa.', 'L', 'ACTIVE', 'SL045', 48769.33, 'Y', 1083.30, 'SALE', '98154 Hessel Divide Apt. 205\nColtville, SD 59858-2314', '2010-01-25', NULL, '561-659-2724', '757.685.9958', NULL, NULL, '+1 (325) 246-2606', NULL, NULL),
(146, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE - TAXPAID', 'Quotation', 26.16, 'Dolore quia et quis nesciunt omnis voluptas ut quis.', 'C', 'ACTIVE', 'SL046', 11809.64, 'Y', 4599.65, 'SALE', '352 Anita Crest Apt. 381\nNorth Rhodachester, AZ 68116-7791', NULL, '2021-04-02', NULL, '650-373-4264', 'fleta.crist@pagac.net', 'Lorine Sauer', '+1-323-471-3183', NULL, '330-424-6220'),
(147, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE - TAXPAID', 'Bill', 46.95, 'Eum sunt aut porro nulla exercitationem consequuntur.', 'L', '', 'SL047', 79015.23, 'N', 75.25, '', '6562 Blanche Gardens\nNorth Savanahchester, WI 14707-5252', '1980-11-27', NULL, NULL, '605-831-2320', NULL, NULL, NULL, NULL, '(931) 812-9071'),
(148, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE GST 12%', 'Receipt', 33.79, 'Molestiae fugiat molestiae aut perferendis quibusdam vitae.', 'C', 'PENDING', 'SL048', 38369.76, 'N', 1703.31, '', '483 Mayert Rapid Apt. 799\nHickletown, UT 33570', '2020-11-17', NULL, NULL, '1-347-282-7658', 'ruecker.arno@hotmail.com', 'Tyler Schneider', '276.956.6898', 'Mona McDermott', '+1-620-332-6337'),
(149, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE IGST 18%', 'Receipt', 48.14, 'Ullam et fuga nemo nam molestias provident est.', 'L', '', 'SL049', 36782.10, 'N', 4504.26, '', '28609 Bahringer Light Apt. 429\nSouth Mauriciofurt, WY 10547', '2005-05-16', NULL, '1-970-406-0176', '+12093506550', 'shanahan.lea@yahoo.com', 'Mrs. Frederique Lubowitz III', NULL, 'Roscoe Williamson', '(828) 643-2581'),
(150, '2025-10-15 04:27:10', '2025-10-15 04:27:10', 'SALE - TAXPAID', 'Bill', 16.78, 'Odit aut voluptatem molestiae molestiae.', 'C', 'ACTIVE', 'SL050', 19977.39, 'N', 4916.76, 'SALE', '38914 Mante Shoals Apt. 742\nDorthymouth, SD 48770', '2001-03-08', '2002-06-05', '986.754.1683', '+1-559-929-6769', 'cbeer@rodriguez.com', NULL, NULL, 'Gennaro McClure', '+1.678.636.3799'),
(151, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE GST 5%', 'Invoice', 3.06, 'Et ducimus totam eveniet qui qui atque explicabo eum.', 'L', 'ACTIVE', 'SL001', 79251.36, 'N', 2250.24, '', '523 Ledner Key\nPort Neal, UT 84262', '2020-10-20', NULL, NULL, NULL, NULL, 'Logan Toy', '678.581.7760', 'Lilla Reilly PhD', NULL),
(152, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE GST 5%', 'Invoice', 39.74, 'Reiciendis magni sint explicabo dolores laboriosam.', 'L', 'PENDING', 'SL002', 15570.00, 'N', 4326.13, 'INCOME', '230 Camren Hill\nWest Parker, MD 90056', NULL, NULL, NULL, '320-774-1525', NULL, 'Jerald Skiles', '+1-954-518-9508', NULL, NULL),
(153, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE GST 12%', 'Invoice', 33.30, 'Laborum asperiores corrupti illo sint.', 'C', 'INACTIVE', 'SL003', 18619.82, 'Y', 1399.80, '', '6637 Bulah Inlet\nPourosburgh, IL 88989', NULL, NULL, '580.959.9153', NULL, NULL, NULL, '+1 (267) 619-4964', NULL, '(321) 574-9354'),
(154, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE GST FREE', 'Bill', 31.50, 'Inventore optio porro ipsa ut unde.', 'L', 'CLOSED', 'SL004', 19779.16, 'N', 4180.73, '', '341 Halvorson Spurs Suite 369\nNew Edmund, KY 69129-4277', NULL, '2002-02-28', NULL, '+1 (623) 274-5429', 'eluettgen@gmail.com', NULL, NULL, NULL, '(724) 931-1609'),
(155, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE GST 12%', 'Receipt', 40.47, 'Voluptatem voluptates minima non ut aut.', 'L', 'CLOSED', 'SL005', 70603.35, 'N', 2614.53, 'REVENUE', '1072 Kuhlman Stream Apt. 553\nNorth Georgiannaberg, NE 60768', NULL, NULL, NULL, '1-717-329-4373', NULL, 'Dr. Sophie Berge III', NULL, 'Lempi Ullrich', NULL),
(156, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE CENTRAL FREE', 'Bill', 2.80, 'Sit officia eos vitae beatae ex.', 'C', 'PENDING', 'SL006', 94210.49, 'Y', 2151.33, 'INCOME', '7018 Jaleel Forges Suite 786\nSouth Alexanemouth, PA 19641-8544', NULL, NULL, '423.796.5614', '(267) 654-2742', 'pfeffer.tess@hotmail.com', NULL, '+1-903-373-0586', 'Dr. Michale Altenwerth DDS', NULL),
(157, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE GST 12%', 'Receipt', 31.97, 'Minus quia perferendis cupiditate asperiores repudiandae cupiditate debitis.', 'L', 'ACTIVE', 'SL007', 14723.96, 'N', 2256.70, '', '2967 Major Stream Suite 780\nBoganborough, OR 25209', NULL, '1979-06-04', NULL, NULL, NULL, 'Leta Deckow', NULL, 'Mr. Timothy Zboncak Jr.', '212.391.3948'),
(158, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE IGST 12%', 'Receipt', 30.93, 'Rerum odio incidunt et modi.', 'L', 'CLOSED', 'SL008', 11561.39, 'Y', 4546.39, 'INCOME', '1294 Dennis Flat\nKozeyhaven, NE 37518', '2024-03-24', '2012-05-07', NULL, NULL, NULL, 'Tiana Jacobson', NULL, NULL, NULL),
(159, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE GST 18%', 'Invoice', 46.03, 'Ullam ipsa similique voluptatem velit ea.', 'L', '', 'SL009', 371.52, 'N', 1408.06, 'INCOME', '967 Hank Wall\nRomaguerashire, MD 55313-0105', NULL, NULL, '657-960-3186', NULL, 'rblock@greenholt.com', 'Kelly Botsford Sr.', NULL, 'Manley Kautzer', NULL),
(160, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE GST FREE', 'Quotation', 2.51, 'Et aliquid cumque odit dolores.', 'L', 'ACTIVE', 'SL010', 9109.29, 'N', 230.77, 'REVENUE', '6933 Bins Shoals\nAssuntaberg, WV 72225', '1977-10-03', NULL, '413.364.7658', NULL, 'noble.abernathy@hotmail.com', NULL, '586.468.2386', 'Eunice Hackett DVM', NULL),
(161, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE IGST 12%', 'Quotation', 17.88, 'Consequatur alias voluptatem omnis blanditiis perferendis inventore.', 'L', 'ACTIVE', 'SL011', 6378.64, 'N', 4554.54, 'REVENUE', '27270 Magnus Manors Suite 203\nLake Camylle, AR 84849', NULL, NULL, '763-426-0402', '+1 (507) 912-1691', 'darby00@hotmail.com', 'Madge Jacobs III', '1-762-523-7337', NULL, NULL),
(162, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE GST 18%', 'Bill', 13.61, 'Eaque optio quo eveniet aliquam mollitia molestias eius.', 'L', 'ACTIVE', 'SL012', 12158.25, 'N', 1689.10, '', '233 Henry Street\nTurcotteport, AZ 81784-8900', NULL, '2018-09-04', NULL, '+1.575.604.3440', NULL, 'Yvonne Klocko', NULL, NULL, NULL),
(163, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE IGST 28%', 'Invoice', 42.56, 'Nulla a iure dolor in omnis.', 'L', 'INACTIVE', 'SL013', 23290.18, 'Y', 2862.83, '', '21315 Gabrielle Village Apt. 310\nPort Chaya, WY 88305', NULL, NULL, '+1-252-765-2435', '+19805106354', NULL, NULL, '(559) 536-8159', NULL, NULL),
(164, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE GST FREE', '', 19.63, 'Blanditiis ipsum quidem totam quos.', 'L', '', 'SL014', 72470.15, 'N', 2227.40, 'SALE', '4741 Russ Pine\nMcLaughlinchester, MT 54724-6166', NULL, '1997-11-29', '+1 (442) 254-8696', '424-718-4974', NULL, NULL, '718.942.7805', 'Miss Yasmin Kuhlman Jr.', '(678) 353-1435'),
(165, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE GST 12%', '', 22.17, 'Et voluptas ab hic.', 'L', 'ACTIVE', 'SL015', 18083.39, 'N', 1927.18, 'INCOME', '260 Veum Estates\nNorth Brennan, IN 96841-8610', '2020-06-25', '1972-05-21', '1-580-624-9777', '267.544.8502', 'kboyle@emard.com', NULL, '1-925-238-1170', 'Jasper Medhurst', '805-223-4036'),
(166, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE GST 12%', 'Invoice', 38.71, 'Natus recusandae occaecati culpa rerum dolorem.', 'C', 'CLOSED', 'SL016', 35117.99, 'Y', 1115.74, 'REVENUE', '77500 Katelin Vista Apt. 758\nSouth Chadrickside, OR 65016-8538', NULL, NULL, '1-254-590-7370', '1-248-768-9490', 'ffarrell@stoltenberg.biz', 'Kylie Hahn', NULL, NULL, '708.855.4677'),
(167, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE GST 12%', 'Quotation', 20.79, 'Tenetur iure repudiandae totam inventore eligendi totam itaque.', 'C', '', 'SL017', 39375.18, 'Y', 294.64, '', '87696 Kelley Forks Suite 138\nSouth Stefanshire, NM 17366', '1981-02-26', '1997-02-04', NULL, NULL, 'lang.marques@yahoo.com', 'Ms. Amya Moen II', NULL, 'Mr. Harley Wuckert', '1-940-712-2743'),
(168, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE IGST 28%', 'Bill', 17.46, 'Sunt voluptatem temporibus nostrum aliquam perferendis.', 'C', 'PENDING', 'SL018', 42329.81, 'Y', 809.17, 'INCOME', '144 Hollis Wall Suite 887\nLake Myra, AL 50832-0329', NULL, '2001-01-02', NULL, '385-948-7552', 'brekke.aaron@nienow.net', 'Marge Leannon', NULL, NULL, NULL),
(169, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE GST 12%', 'Bill', 26.24, 'Ut eos enim voluptatibus veritatis voluptates deserunt eveniet.', 'L', 'CLOSED', 'SL019', 35689.34, 'Y', 4342.67, 'SALE', '852 Gleason Club Apt. 730\nNorth Winona, AR 90310', '1974-03-02', NULL, NULL, NULL, NULL, 'Shawna Langworth', '+13084346140', 'Mr. Raoul Kautzer', NULL),
(170, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE IGST 18%', 'Invoice', 32.29, 'Ab odio dolorum rem ratione.', 'C', 'CLOSED', 'SL020', 24143.94, 'Y', 389.54, 'INCOME', '6928 Austin Road\nRicehaven, NV 19090-9588', NULL, NULL, '283-477-7996', '+1 (956) 892-7925', 'carli59@schmeler.biz', NULL, NULL, NULL, '602.451.1882'),
(171, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE IGST 12%', 'Quotation', 13.29, 'Aspernatur aut enim totam quibusdam et.', 'C', '', 'SL021', 83046.36, 'N', 33.74, 'INCOME', '148 Kaleb Cove Apt. 874\nD\'Amorefurt, AR 69938-2922', '2020-09-01', NULL, '+1-847-934-6730', NULL, 'jaydon82@barrows.com', NULL, NULL, NULL, '906.335.3297'),
(172, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE IGST 12%', '', 19.09, 'Qui non doloribus repellendus qui.', 'L', 'CLOSED', 'SL022', 49592.77, 'Y', 852.78, 'REVENUE', '637 Pacocha Courts Suite 217\nCharleymouth, NJ 27244-9545', '2002-01-23', '1988-01-22', '+13137236145', '+14455437001', NULL, NULL, '+1-520-920-8200', 'Dr. Elwin Monahan PhD', NULL),
(173, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE IGST 28%', 'Receipt', 30.25, 'Nihil illo officia maxime expedita.', 'C', 'ACTIVE', 'SL023', 55775.39, 'N', 79.92, '', '999 Lewis Prairie Apt. 187\nJaylinfort, AR 15804', '1999-01-13', '2015-03-18', '+1.419.420.0435', NULL, NULL, NULL, NULL, NULL, '231-283-2090'),
(174, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE IGST 5%', 'Receipt', 10.19, 'Et nobis aut commodi quisquam voluptatibus aut.', 'L', '', 'SL024', 57453.63, 'Y', 4.27, 'SALE', '2575 Jacobs Track\nFredaberg, NM 20545', NULL, NULL, '1-423-239-8395', NULL, 'kbrakus@yahoo.com', NULL, '+15716864402', 'Dr. Birdie Marquardt III', '1-617-850-5868'),
(175, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE GST 12%', 'Receipt', 10.78, 'Vitae aliquid nulla culpa perspiciatis.', 'L', 'INACTIVE', 'SL025', 85311.95, 'Y', 4276.44, 'INCOME', '703 McCullough Summit Suite 686\nWardborough, AZ 79349-7688', '1982-03-06', NULL, '248-749-5379', '+1 (252) 256-5861', NULL, NULL, '(608) 790-3670', NULL, NULL),
(176, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE IGST 28%', 'Quotation', 25.94, 'Aut iusto beatae eum omnis aut ipsum.', 'C', 'INACTIVE', 'SL026', 99292.83, 'Y', 4865.31, '', '7073 Lind Station\nLegrosmouth, UT 02440', NULL, '2024-06-10', NULL, NULL, NULL, NULL, NULL, 'Destiny Keeling III', '678-282-4494'),
(177, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE GST FREE', 'Bill', 27.53, 'Repellendus explicabo nisi reprehenderit consequuntur dolorem.', 'C', 'CLOSED', 'SL027', 85855.54, 'Y', 1348.10, '', '3498 Maximo Island\nBeerport, ME 80330', NULL, NULL, '+1 (971) 934-8266', '+1-470-492-6002', NULL, NULL, NULL, 'Name Kautzer DVM', NULL),
(178, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE CENTRAL FREE', 'Receipt', 0.17, 'Id praesentium quisquam sit similique voluptatem ipsum.', 'L', 'PENDING', 'SL028', 20685.42, 'N', 3198.47, '', '3161 Buddy Walk Suite 872\nKatherynport, TN 64597', NULL, NULL, NULL, NULL, 'dangelo.schowalter@heidenreich.com', NULL, NULL, NULL, NULL),
(179, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE GST 12%', 'Quotation', 46.72, 'Reiciendis temporibus ratione atque sapiente explicabo facilis quis impedit.', 'C', 'PENDING', 'SL029', 75490.18, 'Y', 4853.82, 'SALE', '5577 Narciso Flat\nJoeyhaven, KS 42734-1472', NULL, NULL, NULL, '919-884-4394', 'corrine08@huels.biz', NULL, '+15713922784', NULL, NULL),
(180, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE GST FREE', '', 32.73, 'Quo repellat et eos ipsum cumque dolor sed.', 'L', 'ACTIVE', 'SL030', 85810.62, 'Y', 1545.10, '', '235 Dina Hollow\nPeytonfort, MO 38494', '2022-12-27', NULL, '+1.763.679.0968', NULL, 'lrunte@bednar.net', NULL, '1-818-741-0780', NULL, NULL),
(181, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE GST 12%', 'Receipt', 10.80, 'Vitae repellat earum iure voluptates qui quo nobis repellat.', 'C', 'INACTIVE', 'SL031', 14412.85, 'N', 3572.64, 'INCOME', '96615 Durgan Club Apt. 540\nNorth Rebekahhaven, LA 41957-5279', NULL, NULL, '682.796.1632', '+1-283-407-8984', 'stacey.jenkins@adams.com', 'Nathanial Lind PhD', '+1 (562) 586-7492', NULL, '1-540-713-7690'),
(182, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE CENTRAL FREE', '', 8.41, 'Sit consequuntur maiores doloribus nihil et doloribus.', 'L', 'CLOSED', 'SL032', 16009.20, 'Y', 4109.83, 'INCOME', '82161 Jevon Vista\nPort Luther, MO 56115-5870', NULL, '1993-05-07', NULL, '1-216-883-1942', NULL, NULL, '276.349.0739', 'Norberto Bechtelar MD', NULL),
(183, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE CENTRAL FREE', 'Receipt', 1.98, 'Aliquid sequi odio est voluptatem dignissimos.', 'L', 'PENDING', 'SL033', 27772.98, 'N', 417.48, '', '4103 Balistreri Shores\nKendricktown, CA 66719', '1989-09-22', NULL, NULL, '332-223-4612', NULL, NULL, '812.696.6269', NULL, NULL),
(184, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE IGST 5%', 'Invoice', 13.29, 'Exercitationem provident odio id iste sit.', 'L', '', 'SL034', 14282.35, 'N', 2841.74, 'REVENUE', '930 Hartmann Ford\nStephanieland, HI 06247-2234', NULL, '1977-03-22', '(984) 771-2912', '(283) 742-8806', 'thora.heathcote@gmail.com', NULL, NULL, 'Scotty Wisozk', '+1.571.474.3847'),
(185, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE CENTRAL FREE', 'Invoice', 27.35, 'Assumenda suscipit iste voluptate laborum sed.', 'C', 'CLOSED', 'SL035', 11538.39, 'Y', 2195.29, 'REVENUE', '36205 Shaun Knoll\nKundeland, AZ 31406-4363', '1981-10-23', NULL, NULL, '478.938.4955', 'anderson.kaden@osinski.biz', 'Ms. Michaela Goldner', NULL, 'Thaddeus Schaden Jr.', NULL),
(186, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE GST 12%', 'Receipt', 13.55, 'Deleniti doloribus qui et nemo sit fugiat.', 'C', 'CLOSED', 'SL036', 39917.65, 'Y', 1523.73, 'SALE', '57265 Adams Loaf Suite 548\nGreenfeldershire, MN 31433-6910', '1997-07-30', NULL, NULL, '786.877.1361', NULL, 'Lou Stamm', '463.225.3052', NULL, '1-270-385-6584'),
(187, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE IGST 28%', 'Bill', 4.67, 'Nihil sint exercitationem unde ea omnis suscipit.', 'L', 'INACTIVE', 'SL037', 70651.00, 'N', 769.43, 'REVENUE', '459 Grimes Tunnel\nLake Amari, HI 19163-2706', NULL, '2025-10-08', NULL, '+1-870-904-8807', NULL, NULL, NULL, NULL, '262.824.0582'),
(188, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE GST 18%', 'Receipt', 11.44, 'Minima quia eligendi distinctio qui.', 'L', 'INACTIVE', 'SL038', 25224.15, 'Y', 4136.98, 'INCOME', '80419 Mylene Parkway\nDurganland, ME 11231', NULL, '2003-02-14', NULL, NULL, 'conn.estelle@grady.com', 'Miss Lilla Deckow', '(321) 916-7508', 'Carley Stanton', NULL),
(189, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE IGST 28%', '', 25.10, 'Ex nobis maxime nobis veritatis provident enim.', 'L', 'ACTIVE', 'SL039', 15976.80, 'N', 2546.33, 'REVENUE', '7467 King Falls\nNorth Jacquelyn, OH 73011-9622', '1998-02-27', '1975-12-13', '1-432-676-9909', NULL, NULL, NULL, NULL, NULL, '+1.401.228.1505'),
(190, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE GST 18%', '', 14.41, 'Quia corrupti sunt eaque numquam nam eius est.', 'L', 'ACTIVE', 'SL040', 32421.10, 'N', 4127.79, 'SALE', '64059 Mittie Spurs\nDurganberg, VT 72862', '1988-03-27', NULL, '1-785-849-1008', '+12523905525', NULL, 'Ignacio Hessel', NULL, 'Madaline Hansen MD', '1-270-323-8456'),
(191, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE GST FREE', 'Bill', 35.15, 'Perspiciatis recusandae deleniti in ducimus veniam iusto.', 'C', 'ACTIVE', 'SL041', 63737.57, 'N', 2300.54, 'SALE', '5375 Junior Place Apt. 823\nWest Jazmyn, KS 76263', '2020-01-22', '1976-06-07', NULL, NULL, 'haven.huels@schmidt.com', 'Sophia Schamberger MD', '+19546467261', NULL, NULL),
(192, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE IGST 5%', 'Receipt', 10.80, 'Omnis quos dolores cumque doloribus nihil ut soluta.', 'L', 'PENDING', 'SL042', 72485.85, 'Y', 798.02, 'SALE', '85420 Elton Glens\nPort Tateborough, DE 33757-6075', '1973-02-28', NULL, '614.798.2023', '(364) 676-3494', NULL, 'Dr. Valentine Nolan DVM', NULL, 'Dr. Jason Marvin I', NULL),
(193, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE IGST 18%', '', 28.53, 'Fuga accusamus ea sit.', 'L', 'CLOSED', 'SL043', 81957.83, 'Y', 1711.90, '', '5979 Stokes Lodge\nWest Ambrose, KS 94732', NULL, NULL, '865.337.6004', NULL, 'broderick.kunze@zemlak.com', NULL, '(757) 518-6852', 'Maya Greenfelder', NULL),
(194, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE IGST FREE', 'Receipt', 24.06, 'At eum accusantium consequatur qui porro consequatur.', 'C', 'PENDING', 'SL044', 53094.73, 'N', 3371.89, 'INCOME', '8566 Abner Trace\nHandton, NE 61886', '1977-06-28', NULL, '1-818-494-7546', NULL, NULL, NULL, '+14586594565', 'Abby Cronin', '563.510.5088'),
(195, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE IGST 12%', 'Quotation', 6.54, 'Voluptatem sapiente ut porro.', 'C', 'PENDING', 'SL045', 446.25, 'N', 3628.48, 'SALE', '642 Kane Mountains\nMaiyahaven, WY 00648-8555', '1995-05-21', NULL, NULL, NULL, 'telly78@hotmail.com', NULL, '747.719.1146', 'Janae Jerde', NULL),
(196, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE GST 5%', 'Quotation', 47.78, 'Nam labore tenetur velit rerum est nam.', 'L', 'INACTIVE', 'SL046', 2546.14, 'Y', 2268.85, '', '93834 Waters View\nPort Ewald, IL 08227', '2015-12-30', NULL, '380-925-1258', NULL, 'gkihn@marks.biz', 'Timothy Considine V', NULL, NULL, NULL),
(197, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE IGST 5%', '', 43.68, 'Perferendis quidem ut necessitatibus distinctio.', 'L', 'PENDING', 'SL047', 64203.40, 'N', 2869.01, 'REVENUE', '120 Wiegand Passage Apt. 073\nPort Libbieberg, ME 13430-1500', NULL, NULL, '1-231-764-3082', '1-959-870-7967', NULL, NULL, '+1.938.512.4858', 'Prof. Julius Johns', '(240) 623-5311'),
(198, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE GST 12%', '', 31.34, 'Quidem maiores sit quis qui quia quasi iusto quo.', 'L', 'CLOSED', 'SL048', 17850.08, 'Y', 1258.54, 'SALE', '24114 Tromp Mission\nLarkinmouth, CA 14472-4103', '2015-11-03', '2024-05-24', NULL, NULL, NULL, 'Prof. Garett Bayer', '773.387.5910', 'Bruce Crist', '251-566-7694'),
(199, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE IGST 12%', '', 47.90, 'Molestiae perferendis cum illo accusantium officiis veniam.', 'C', 'CLOSED', 'SL049', 30979.36, 'N', 75.40, 'REVENUE', '483 Vladimir Inlet\nReingermouth, RI 17549-1023', NULL, '2019-09-22', '+1 (623) 200-9696', '1-272-837-9683', NULL, NULL, NULL, NULL, '434.432.4524'),
(200, '2025-10-15 04:27:41', '2025-10-15 04:27:41', 'SALE GST 12%', 'Invoice', 2.19, 'Ut reprehenderit eveniet amet voluptatem officia.', 'L', 'ACTIVE', 'SL050', 71243.22, 'Y', 2125.13, '', '259 Gorczany Stravenue\nLake Woodrow, FL 14695', '1993-08-11', NULL, NULL, NULL, 'everette36@runte.net', 'Johnpaul Spencer III', '+1-878-449-6266', NULL, '(223) 538-9477'),
(201, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE IGST 28%', 'Receipt', 30.52, 'Qui dicta laborum occaecati sit iusto repellendus quos voluptas.', 'C', 'INACTIVE', 'SL001', 34745.06, 'N', 2239.96, '', '75468 Wisoky Terrace Apt. 347\nJakubowskitown, OH 85773-5827', '2017-04-16', NULL, '(615) 693-1482', NULL, 'norwood68@mayer.com', 'Gerardo Paucek II', '1-539-677-5267', NULL, '603.851.1877'),
(202, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE IGST 12%', 'Receipt', 27.37, 'Voluptatem nobis non nesciunt.', 'L', 'ACTIVE', 'SL002', 97007.03, 'Y', 620.24, 'REVENUE', '631 Collier Course\nPort Jessmouth, CT 11921', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '(726) 985-8886'),
(203, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE IGST 5%', '', 43.54, 'Sint quo eaque et alias eligendi.', 'C', 'ACTIVE', 'SL003', 59974.46, 'N', 664.74, 'INCOME', '94980 Stefanie View\nLinaport, CT 89981-4356', '2012-05-18', NULL, '+1-912-360-3743', '+1-248-887-0150', 'oscar80@yahoo.com', NULL, '385.412.9180', 'Margaret Shields', NULL),
(204, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE IGST 5%', 'Bill', 2.06, 'Dignissimos distinctio quos autem aut.', 'C', 'CLOSED', 'SL004', 90211.17, 'Y', 2122.42, 'INCOME', '715 Marcel Ridge\nSouth Wilson, GA 99531', NULL, '1999-10-28', NULL, NULL, NULL, NULL, NULL, 'Hallie Goldner', '978-507-7688'),
(205, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE IGST 28%', '', 47.23, 'Et aliquam eum et repellendus.', 'L', 'ACTIVE', 'SL005', 37543.88, 'Y', 4625.75, 'INCOME', '62003 Allison Motorway\nLake Julianaborough, AK 90674', '2013-03-21', NULL, NULL, NULL, NULL, 'Jennifer Orn', NULL, 'Kayley Vandervort', '(419) 839-5376'),
(206, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE GST 5%', 'Bill', 18.22, 'Beatae rerum optio quia id.', 'C', 'ACTIVE', 'SL006', 20144.13, 'Y', 351.88, 'SALE', '86570 Smitham Avenue Apt. 365\nHilpertberg, SD 94677-5522', NULL, '2022-01-15', '+1.719.435.1306', '+1-520-645-6489', NULL, NULL, '754-574-0242', NULL, '737-866-7303'),
(207, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE IGST 28%', '', 18.58, 'At impedit nihil occaecati nostrum impedit.', 'C', 'CLOSED', 'SL007', 65202.97, 'Y', 4002.96, 'INCOME', '643 Audie Valleys\nSouth Chanel, OK 58041', NULL, '1978-07-05', NULL, NULL, NULL, 'Prof. Arthur Pfannerstill I', NULL, 'Axel Rippin', '(843) 525-6000'),
(208, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE - TAXPAID', 'Receipt', 29.49, 'Dicta incidunt facere est aut.', 'L', '', 'SL008', 15715.99, 'Y', 3626.58, 'INCOME', '101 Schmeler Wall Apt. 349\nSpinkaville, TN 88243-4998', '1972-10-31', NULL, '754-402-8111', '(754) 702-5801', NULL, 'Claudia Schinner', '(220) 652-7489', 'Kevin Lind PhD', '(309) 557-7017'),
(209, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE GST FREE', 'Receipt', 28.98, 'Et et est facere quisquam nostrum.', 'C', 'CLOSED', 'SL009', 1144.80, 'N', 1925.49, 'REVENUE', '63388 Deonte Isle\nPort Jeff, SD 52807', NULL, NULL, NULL, '1-310-350-4700', NULL, NULL, NULL, NULL, NULL),
(210, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE IGST FREE', '', 7.01, 'Sequi eius enim est voluptatum debitis quia.', 'C', 'PENDING', 'SL010', 27155.94, 'Y', 3268.45, 'INCOME', '961 Kemmer Squares Apt. 271\nWatersbury, IN 64933-3006', '1996-06-03', NULL, NULL, NULL, 'pheller@renner.com', 'Clara Wilkinson Sr.', NULL, 'Reilly Treutel', NULL),
(211, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE GST 18%', 'Receipt', 26.08, 'Qui aut consequatur dolores ipsam tempore molestiae ea.', 'L', 'ACTIVE', 'SL011', 4110.74, 'Y', 4163.97, '', '46901 Morissette Crest\nRobelshire, NJ 73465', NULL, '1994-02-16', '+1.260.620.5249', '281.995.2822', NULL, 'Raoul Zulauf', '1-580-576-9796', 'Emanuel Witting PhD', NULL),
(212, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE IGST 28%', 'Invoice', 6.23, 'Error aut dolor illo eos minus.', 'L', 'CLOSED', 'SL012', 71086.21, 'N', 2596.72, '', '84598 Bret Parkways\nKihnmouth, OH 91009-3193', NULL, '1986-12-10', '+16626121640', '(475) 322-8715', NULL, NULL, NULL, 'Jack Towne', NULL),
(213, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE IGST 28%', 'Invoice', 40.59, 'Inventore nisi accusamus architecto odio architecto maiores aspernatur.', 'C', 'INACTIVE', 'SL013', 65102.63, 'Y', 3544.17, 'SALE', '152 Justina Loop\nEast Gilbertside, LA 87971', NULL, NULL, NULL, NULL, NULL, 'Zachariah Lockman PhD', '(409) 475-6032', 'Stacy Ward', NULL),
(214, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE IGST 5%', 'Receipt', 13.87, 'Consequatur ipsa et architecto consequatur nesciunt.', 'L', 'ACTIVE', 'SL014', 36310.20, 'Y', 3968.92, '', '86855 Rafael Parkway\nSpinkaview, AR 78405-5295', '1999-12-28', NULL, NULL, NULL, NULL, 'Dr. Irma Conroy', NULL, 'Issac Stracke', '470.993.1709'),
(215, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE GST 18%', 'Receipt', 31.25, 'Quas aliquid qui minus.', 'L', '', 'SL015', 63249.59, 'Y', 1841.51, '', '650 Nora Mission Suite 497\nLake Jailynchester, SD 14757', '1991-09-21', '1981-03-17', NULL, '620.315.0252', NULL, NULL, NULL, NULL, NULL),
(216, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE CENTRAL FREE', '', 9.12, 'Molestias labore corrupti libero nesciunt.', 'L', '', 'SL016', 25490.01, 'N', 978.54, '', '240 Schimmel Manor Suite 247\nPort Imelda, KY 16867', NULL, NULL, '(458) 200-5528', '+1-979-300-6831', NULL, NULL, '+1-563-819-2187', NULL, '610.440.2515'),
(217, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE IGST 28%', 'Quotation', 22.82, 'Dolorum consequatur ex qui sint possimus veritatis consequatur.', 'L', 'INACTIVE', 'SL017', 5389.81, 'Y', 405.56, 'REVENUE', '575 Schaefer Plains\nPort Elta, GA 27828-2603', '2009-10-09', '2023-01-03', NULL, '346-956-0053', NULL, NULL, '1-612-915-2648', NULL, NULL),
(218, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE GST FREE', 'Invoice', 11.79, 'Voluptatem cum suscipit quo occaecati velit alias.', 'C', '', 'SL018', 38979.84, 'N', 308.32, '', '9409 Francis Unions Apt. 692\nSouth Deondrechester, MN 46296-9126', NULL, '1999-05-28', '228.820.2484', NULL, NULL, 'Ryleigh Berge', '1-283-458-0043', 'Merle Erdman', '1-531-913-0111'),
(219, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE CENTRAL FREE', 'Quotation', 32.88, 'Aut et quia sed cupiditate quis.', 'L', 'ACTIVE', 'SL019', 2047.44, 'Y', 1196.79, '', '37307 Mireya Rue Suite 621\nEdwardmouth, CA 25282', NULL, NULL, NULL, '574-873-5962', NULL, NULL, '253.890.2549', 'Prof. Urban Gislason I', '+18042284004'),
(220, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE GST FREE', '', 17.93, 'Sed porro aspernatur ut commodi quia.', 'L', 'INACTIVE', 'SL020', 60844.86, 'N', 1778.59, 'INCOME', '36604 Funk Hollow Apt. 961\nHeathview, NJ 56895-2614', NULL, '2021-08-26', '(260) 319-8126', NULL, NULL, 'Ahmed Raynor', NULL, 'Prof. Juanita Jast III', NULL),
(221, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE GST 5%', 'Quotation', 28.45, 'Eaque omnis magnam aut aut velit.', 'L', 'INACTIVE', 'SL021', 56213.52, 'N', 3208.46, 'REVENUE', '62617 Schimmel Well\nHaleymouth, NY 71448-8955', NULL, '2000-11-24', NULL, '+18599594277', NULL, NULL, NULL, 'Ms. Tessie Thiel V', NULL),
(222, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE IGST 28%', 'Bill', 12.61, 'Voluptatum vitae id et rerum eos soluta et.', 'L', 'INACTIVE', 'SL022', 33714.75, 'N', 974.18, 'INCOME', '40018 Shany Turnpike\nMantefort, SC 17489', '2007-09-22', NULL, NULL, '+16075618576', 'ozella.fisher@hotmail.com', NULL, '+1-925-225-5933', 'Lucy Ullrich', '+1-938-229-9847'),
(223, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE GST FREE', '', 7.22, 'Aperiam nulla qui id dolorum ea repellendus.', 'C', 'ACTIVE', 'SL023', 68000.97, 'N', 3192.04, 'REVENUE', '8539 Roberts Mills\nKirstinberg, AZ 62933-9215', '1991-06-04', '1992-04-26', NULL, NULL, NULL, NULL, NULL, 'Antonina Heathcote', '+1-937-729-2635'),
(224, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE IGST 28%', 'Bill', 3.41, 'Dolores amet dolores pariatur odit est.', 'C', 'CLOSED', 'SL024', 93051.23, 'Y', 619.13, '', '7859 Gertrude Plain\nNew Aubreychester, AZ 42653-6426', NULL, NULL, '+1 (574) 708-7967', '586-391-7787', NULL, 'Jody Strosin', '+1.669.612.2953', 'Effie Hegmann', NULL),
(225, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE IGST 28%', 'Bill', 46.13, 'Reprehenderit explicabo soluta laudantium dolorum aliquam suscipit.', 'C', 'ACTIVE', 'SL025', 70231.01, 'N', 3659.76, 'INCOME', '73299 Irwin Coves\nEloychester, IL 15659-1976', NULL, NULL, '+1-831-757-3547', '1-715-678-6892', 'aarmstrong@gutmann.com', 'Mrs. Colleen Wolf', NULL, 'Prof. Armani Hodkiewicz DDS', '734-357-1723'),
(226, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE GST 12%', 'Receipt', 36.41, 'Aliquam non qui ipsum maiores aut non quia.', 'L', 'PENDING', 'SL026', 963.15, 'Y', 3431.34, 'REVENUE', '54737 Richie Knoll\nEast Justen, DE 85577', NULL, '2025-02-01', '+1-337-706-8456', NULL, 'nick.ebert@koepp.biz', 'Ruby Lakin', '+1 (304) 521-6118', 'Mrs. Birdie Gislason', '+1 (754) 820-6492'),
(227, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE GST 18%', 'Invoice', 5.76, 'Occaecati quis qui dolor voluptatum.', 'C', '', 'SL027', 71737.69, 'Y', 2120.06, 'INCOME', '72187 Braden Green\nNorth Flo, VT 03456', NULL, NULL, NULL, '(251) 283-6058', NULL, 'Mr. Brennan Kunze III', NULL, 'Kraig Boehm Jr.', '(458) 450-4197'),
(228, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE GST 5%', 'Bill', 4.03, 'Vitae aut sapiente ut.', 'L', 'INACTIVE', 'SL028', 20318.06, 'Y', 3543.46, 'SALE', '12751 Ethan Bypass\nBetteside, ND 35756-1847', NULL, '2021-09-09', NULL, NULL, 'cordelia65@yahoo.com', NULL, NULL, NULL, NULL),
(229, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE GST 5%', 'Receipt', 45.16, 'Voluptate optio harum id voluptatum provident quis temporibus.', 'C', '', 'SL029', 40410.00, 'N', 2175.81, '', '7964 Manuel Shore Suite 943\nSouth Jessside, OR 72401-6229', '1996-12-15', NULL, NULL, NULL, 'declan.weimann@hotmail.com', NULL, NULL, 'Orville Rolfson', NULL),
(230, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE - TAXPAID', '', 38.36, 'Voluptatem aliquid nihil sed.', 'L', 'INACTIVE', 'SL030', 20163.73, 'Y', 4668.85, '', '403 Marcelle Spurs\nNikolausstad, WV 40827-7937', '1991-01-02', '1985-10-08', NULL, NULL, NULL, 'Sophie Morissette', NULL, NULL, '443-358-6491'),
(231, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE GST 5%', 'Bill', 24.23, 'Deleniti dicta nobis et voluptatem deleniti.', 'L', 'ACTIVE', 'SL031', 47495.40, 'N', 608.86, 'SALE', '2773 Adriel Lake\nPort Magnolia, TN 85873-5327', NULL, NULL, NULL, NULL, 'bkeeling@yahoo.com', 'Elena Johns I', NULL, 'Lois Daugherty', '1-520-389-8514'),
(232, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE GST 5%', 'Receipt', 10.97, 'Minus omnis aliquid occaecati et qui.', 'L', 'CLOSED', 'SL032', 95418.91, 'N', 872.33, 'SALE', '12925 Orn Hollow\nSouth Chelseashire, DE 81263-5129', NULL, NULL, NULL, NULL, NULL, 'Nona Rogahn', '+1-229-851-2844', 'Dr. Reyes Thompson', NULL),
(233, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE IGST 5%', 'Bill', 31.29, 'Sunt mollitia consequatur temporibus quisquam temporibus velit minima dolores.', 'C', 'INACTIVE', 'SL033', 1204.11, 'Y', 4196.36, '', '73368 Hamill Heights Suite 694\nEast Yvetteton, MN 93923-5997', NULL, NULL, '(727) 710-8145', NULL, NULL, 'Ricky Anderson MD', NULL, 'Bryon Shields', '(985) 441-3346'),
(234, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE CENTRAL FREE', 'Bill', 38.76, 'Possimus enim cum et voluptatem.', 'L', 'INACTIVE', 'SL034', 66465.82, 'N', 3020.37, '', '189 Hermiston Ville\nNew Reannastad, OR 05291-5269', NULL, NULL, '+13032787723', '+1-678-242-2618', NULL, 'Rubie Medhurst', NULL, NULL, NULL),
(235, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE GST 12%', 'Invoice', 43.04, 'Sed voluptatum aliquam blanditiis vel omnis veniam voluptatem.', 'C', 'CLOSED', 'SL035', 52954.70, 'Y', 1036.38, 'SALE', '88941 Lois Port Suite 861\nParisport, MI 75121', '1980-05-10', '1990-08-18', NULL, NULL, 'hodkiewicz.solon@gmail.com', 'Carey Denesik', '+1.773.951.7405', NULL, NULL),
(236, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE IGST FREE', 'Quotation', 38.44, 'Vitae soluta quia quod expedita ducimus.', 'L', '', 'SL036', 28693.76, 'N', 3667.20, '', '116 Daniel Station\nHermanport, WA 92969-8312', '2002-10-14', NULL, NULL, '+15306977851', NULL, 'Meta Bartell PhD', '+1-351-766-9713', NULL, '820.264.2754'),
(237, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE - TAXPAID', 'Bill', 33.09, 'Sequi sit architecto nulla ex totam voluptas.', 'C', 'CLOSED', 'SL037', 5186.37, 'N', 3568.25, 'SALE', '195 Beer Fork Suite 103\nBraunside, SD 85303-1488', '2014-06-08', '2022-10-12', NULL, '+1-352-335-2514', 'lori.mcdermott@gmail.com', 'Cheyenne Gottlieb II', NULL, 'Mr. Saige Hermiston', '+1.762.643.9084'),
(238, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE - TAXPAID', 'Invoice', 21.25, 'Consequatur eveniet sequi culpa molestiae aliquid tenetur.', 'C', 'ACTIVE', 'SL038', 49572.79, 'N', 1769.99, 'REVENUE', '1423 Giovanny Springs Apt. 871\nLake Ethaborough, KY 21730-0781', '1977-06-28', NULL, '(859) 613-6873', NULL, NULL, 'Saige Kertzmann', NULL, 'Marguerite Collins', '+1-847-502-1588'),
(239, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE GST 12%', 'Quotation', 33.88, 'Ut est quia officia vel.', 'L', 'ACTIVE', 'SL039', 56432.72, 'Y', 855.23, '', '8009 Orville Rue\nWest Nelda, MA 68157', '1981-02-09', NULL, NULL, NULL, NULL, NULL, '(212) 486-5452', NULL, '+1-813-699-8233'),
(240, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE GST 12%', 'Receipt', 34.77, 'Eius fugit iure voluptas adipisci velit.', 'C', 'CLOSED', 'SL040', 359.83, 'N', 356.61, 'REVENUE', '860 Green Lodge Suite 849\nMitchellville, NC 47529-9011', '2023-11-06', '1981-03-07', '(845) 609-9589', NULL, NULL, 'Abbie Upton DVM', '1-534-532-4165', NULL, '423.776.9808'),
(241, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE CENTRAL FREE', '', 27.38, 'Voluptatibus nobis est voluptates excepturi itaque.', 'L', 'CLOSED', 'SL041', 71620.42, 'N', 1976.28, 'SALE', '383 Anais Square\nSouth Bart, NY 64657-5024', NULL, '2021-08-31', '920-878-3239', NULL, 'rafaela.schuster@yahoo.com', NULL, NULL, 'Aniya O\'Connell', NULL),
(242, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE IGST 12%', 'Invoice', 36.59, 'Maiores pariatur molestiae ea natus omnis voluptas.', 'C', 'PENDING', 'SL042', 20434.36, 'Y', 4322.18, '', '4944 Stoltenberg Dam Suite 389\nPort Santatown, VT 69499', NULL, NULL, '(971) 229-2374', NULL, NULL, 'Fatima Runolfsdottir', NULL, 'Dr. Rosa Casper Jr.', NULL),
(243, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE - TAXPAID', '', 4.26, 'Et ipsam quaerat voluptas voluptas voluptatem.', 'L', 'PENDING', 'SL043', 18421.83, 'N', 2092.49, 'INCOME', '303 Green Mountain Suite 330\nEast Kayafurt, HI 01416-6183', '2016-02-16', NULL, NULL, '1-949-633-4474', NULL, NULL, '+1-678-213-4928', 'Dr. Enos Herman MD', NULL),
(244, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE IGST FREE', 'Invoice', 5.25, 'Dolor recusandae provident voluptatem accusamus consectetur voluptas.', 'C', 'INACTIVE', 'SL044', 11199.11, 'Y', 2301.80, 'SALE', '945 Hyatt Ramp Suite 894\nBeattymouth, LA 37677-0610', NULL, NULL, NULL, NULL, 'gino85@kutch.org', NULL, NULL, 'Mrs. Christa Miller', NULL),
(245, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE GST 12%', '', 21.01, 'Et dignissimos dolorem qui adipisci.', 'L', 'PENDING', 'SL045', 22927.64, 'Y', 4367.97, 'SALE', '42291 Zelda Green\nIsomport, NV 89883', NULL, '1999-08-07', NULL, '952-337-6275', NULL, 'Edd Parker Jr.', '1-352-863-6267', NULL, NULL),
(246, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE - TAXPAID', 'Quotation', 40.04, 'Sint rerum et voluptatem voluptatem.', 'L', 'ACTIVE', 'SL046', 86208.79, 'N', 618.25, '', '4027 Rodriguez Valley\nPort Clotildetown, DE 82320-0694', '1975-09-21', '2001-07-04', '+1-734-639-3410', '+1 (539) 319-0712', 'lucy31@rogahn.org', NULL, '1-870-459-7525', NULL, '620.964.0455'),
(247, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE GST 18%', '', 21.72, 'Excepturi unde porro enim et.', 'C', 'INACTIVE', 'SL047', 4335.42, 'Y', 992.38, '', '6143 Runolfsson Fort\nMckennaville, SC 01144', NULL, NULL, '+1-385-736-0903', '+1 (248) 561-6223', NULL, NULL, '+13613886303', 'Prof. Wilford Harber', NULL),
(248, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE IGST 12%', 'Invoice', 13.92, 'Voluptas illum enim dolores et dolores minima consequuntur.', 'C', 'INACTIVE', 'SL048', 9429.62, 'Y', 4900.13, 'SALE', '458 Gaylord Mission Apt. 383\nDoyleview, RI 34096-6527', NULL, NULL, NULL, '1-347-901-6457', 'johan68@yahoo.com', NULL, '+1 (820) 553-1114', 'Merl Adams', NULL),
(249, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE CENTRAL FREE', '', 48.00, 'Est architecto qui in velit quo.', 'L', 'CLOSED', 'SL049', 92325.76, 'N', 3640.29, '', '51496 Renner Stream\nWest Creolaport, MO 22233', '1973-11-04', '1974-11-30', '+1-509-744-8510', NULL, NULL, NULL, '+1.936.746.9680', NULL, '1-484-578-3764'),
(250, '2025-10-15 04:27:55', '2025-10-15 04:27:55', 'SALE IGST 18%', '', 19.17, 'Tempora quod et temporibus rerum ea saepe et voluptatem.', 'L', 'PENDING', 'SL050', 7873.45, 'N', 742.79, '', '4453 Bernier Station Apt. 208\nWest Christinefurt, VA 98899', NULL, '2005-02-05', NULL, '+1-479-297-2918', 'rhayes@yahoo.com', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Xtbozxi9BWLNRFUtpzCYzsUPlu4xIvk7wL8giIHc', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNUh0OURPcm8xcTFBcmxoa1pjTzU0QjBNU1AzM1F5MDV3TFFmb3dCaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9jdXN0b21lcnMvMjEiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1761800505),
('y5wVNsZr3b55AzafS1MH829lBiGUiqknuGsAU6dj', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiallDblJEY09FOGIyTzNmU05IR0pUdGgyT2pLaGJoMzAwV0p0QlE2RyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9zYWxlL2dldC1pdGVtcyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1761737840);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `alter_code` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `alter_code`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Maharashtra', 'MH001', 'Active', '2025-10-15 04:11:48', '2025-10-15 04:11:48'),
(2, 'Delhi', 'DL002', 'Active', '2025-10-15 04:11:48', '2025-10-15 04:11:48'),
(3, 'Karnataka', 'KA003', 'Active', '2025-10-15 04:11:48', '2025-10-15 04:11:48'),
(4, 'Tamil Nadu', 'TN004', 'Active', '2025-10-15 04:11:48', '2025-10-15 04:11:48'),
(5, 'Gujarat', 'GJ005', 'Active', '2025-10-15 04:11:48', '2025-10-15 04:11:48'),
(6, 'Rajasthan', 'RJ006', 'Active', '2025-10-15 04:11:48', '2025-10-15 04:11:48'),
(8, 'Andhra Pradesh', 'AP008', '45345', '2025-10-15 04:11:48', '2025-10-15 04:17:11'),
(9, 'Telangana', 'TS009', 'Active', '2025-10-15 04:11:48', '2025-10-15 04:11:48'),
(10, 'Kerala', 'KL010', 'Active', '2025-10-15 04:11:48', '2025-10-15 04:11:48'),
(11, 'Punjab', 'PB011', 'Active', '2025-10-15 04:11:48', '2025-10-15 04:11:48'),
(12, 'Haryana', 'HR012', 'Active', '2025-10-15 04:11:48', '2025-10-15 04:11:48');

-- --------------------------------------------------------

--
-- Table structure for table `stock_ledgers`
--

CREATE TABLE `stock_ledgers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `trans_no` varchar(255) DEFAULT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `batch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transaction_type` varchar(255) NOT NULL,
  `quantity` decimal(12,2) NOT NULL,
  `free_quantity` decimal(12,2) NOT NULL DEFAULT 0.00,
  `salesman_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bill_number` varchar(255) DEFAULT NULL,
  `bill_date` date DEFAULT NULL,
  `rate` decimal(12,2) NOT NULL DEFAULT 0.00,
  `opening_qty` decimal(12,2) NOT NULL DEFAULT 0.00,
  `closing_qty` decimal(12,2) NOT NULL DEFAULT 0.00,
  `running_balance` decimal(12,2) NOT NULL DEFAULT 0.00,
  `reference_type` varchar(255) DEFAULT NULL,
  `reference_id` bigint(20) UNSIGNED DEFAULT NULL,
  `transaction_date` date NOT NULL,
  `godown` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `tax_retail_flag` varchar(255) DEFAULT NULL,
  `tan_no` varchar(255) DEFAULT NULL,
  `msme_lic` varchar(255) DEFAULT NULL,
  `opening_balance` decimal(15,2) DEFAULT NULL,
  `opening_balance_type` varchar(1) NOT NULL DEFAULT 'C',
  `credit_limit` decimal(15,2) DEFAULT NULL,
  `b_day` date DEFAULT NULL,
  `a_day` date DEFAULT NULL,
  `contact_person_1` varchar(255) DEFAULT NULL,
  `contact_person_2` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `mobile_additional` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `status` varchar(5) DEFAULT NULL,
  `flag` varchar(255) DEFAULT NULL,
  `dl_no` varchar(255) DEFAULT NULL,
  `dl_no_1` varchar(255) DEFAULT NULL,
  `food_lic` varchar(255) DEFAULT NULL,
  `cst_no` varchar(255) DEFAULT NULL,
  `tin_no` varchar(255) DEFAULT NULL,
  `pan` varchar(255) DEFAULT NULL,
  `gst_no` varchar(255) DEFAULT NULL,
  `state_code` varchar(255) DEFAULT NULL,
  `local_central_flag` varchar(255) DEFAULT NULL,
  `discount_on_excise` tinyint(1) DEFAULT 0,
  `scheme_type` varchar(255) DEFAULT NULL,
  `discount_after_scheme` tinyint(1) DEFAULT 0,
  `direct_indirect` varchar(255) DEFAULT NULL,
  `invoice_on_trade_rate` tinyint(1) DEFAULT 0,
  `net_rate_yn` varchar(1) DEFAULT NULL,
  `visit_days` varchar(255) DEFAULT NULL,
  `invoice_roff` decimal(10,2) DEFAULT NULL,
  `scheme_in_decimal` tinyint(1) DEFAULT 0,
  `vat_on_bill_expiry` tinyint(1) DEFAULT 0,
  `tax_on_fqty` tinyint(1) DEFAULT 0,
  `expiry_on_mrp_sale_rate_purchase_rate` varchar(1) NOT NULL DEFAULT 'M',
  `sale_purchase_status` varchar(1) NOT NULL DEFAULT 'B',
  `composite_scheme` tinyint(1) DEFAULT 0,
  `stock_transfer` tinyint(1) DEFAULT 0,
  `cash_purchase` tinyint(1) DEFAULT 0,
  `add_charges_with_gst` tinyint(1) DEFAULT 0,
  `purchase_import_box_conversion` tinyint(1) DEFAULT 0,
  `full_name` varchar(255) DEFAULT NULL,
  `aadhar` varchar(255) DEFAULT NULL,
  `registered_unregistered_composite` varchar(255) DEFAULT NULL,
  `registration_date` date DEFAULT NULL,
  `tcs_applicable` varchar(1) DEFAULT NULL,
  `tds_yn` tinyint(1) DEFAULT 0,
  `tds_on_return` tinyint(1) DEFAULT 0,
  `tds_tcs_on_bill_amount` tinyint(1) NOT NULL DEFAULT 0,
  `bank` varchar(255) DEFAULT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `account_no` varchar(255) DEFAULT NULL,
  `ifsc_code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `notebook` text DEFAULT NULL COMMENT 'Notebook field for supplier notes',
  `remarks` text DEFAULT NULL COMMENT 'Remarks field for additional information'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`supplier_id`, `name`, `code`, `address`, `telephone`, `email`, `tax_retail_flag`, `tan_no`, `msme_lic`, `opening_balance`, `opening_balance_type`, `credit_limit`, `b_day`, `a_day`, `contact_person_1`, `contact_person_2`, `mobile`, `mobile_additional`, `fax`, `status`, `flag`, `dl_no`, `dl_no_1`, `food_lic`, `cst_no`, `tin_no`, `pan`, `gst_no`, `state_code`, `local_central_flag`, `discount_on_excise`, `scheme_type`, `discount_after_scheme`, `direct_indirect`, `invoice_on_trade_rate`, `net_rate_yn`, `visit_days`, `invoice_roff`, `scheme_in_decimal`, `vat_on_bill_expiry`, `tax_on_fqty`, `expiry_on_mrp_sale_rate_purchase_rate`, `sale_purchase_status`, `composite_scheme`, `stock_transfer`, `cash_purchase`, `add_charges_with_gst`, `purchase_import_box_conversion`, `full_name`, `aadhar`, `registered_unregistered_composite`, `registration_date`, `tcs_applicable`, `tds_yn`, `tds_on_return`, `tds_tcs_on_bill_amount`, `bank`, `branch`, `account_no`, `ifsc_code`, `created_at`, `updated_at`, `created_by`, `updated_by`, `is_deleted`, `deleted_at`, `notebook`, `remarks`) VALUES
(11, 'Mahesh Traders', 'SUP001', '12 MG Road, Pune', '02024567890', 'maheshtraders@gmail.com', 'R', 'TANMT1234A', 'MSME12345', 15000.00, 'C', 250000.00, '2025-10-16', '2025-10-17', 'Mahesh Patil', 'Ravi K', '9823045678', '9765123456', '43534', '34534', '345345', 'DL001', 'DL001A', 'FSSAI001', 'CST001', 'TIN001', 'PANMT001P', '27MT001G1Z1', '09 Uttar Pradesh', 'L', 1, 'F', 0, 'T', 1, 'Y', 'Mon,Thu', 0.00, 1, 1, 1, 'M', 'P', 0, 0, 0, 1, 1, 'Mahesh Traders Pvt Ltd', '234567890123', 'R', '2018-03-01', 'N', 0, 0, 1, 'SBI', 'Pune Main', '000111222333', 'SBIN0000456', NULL, NULL, NULL, NULL, 0, NULL, 'rtgrtg', 'rtgertert'),
(12, 'Om Distributors', 'SUP002', 'Block B, Andheri East, Mumbai', '02226578990', 'omdist@gmail.com', 'F', 'TANOM2234B', NULL, 20000.00, 'C', 400000.00, NULL, NULL, 'Om Sharma', 'Vikas R', '9988776655', NULL, NULL, '', 'A', 'DL002', 'DL002A', 'FSSAI002', 'CST002', 'TIN002', 'PANOM002P', '27OM002G1Z2', '27', '1', 10, '2', 0, 'D', 1, '1', 'Tue,Fri', 0.00, 0, 1, 0, 'M', 'P', 0, 1, 0, 1, 1, 'Om Distributors LLP', '345678901234', 'R', '2019-07-15', '0', 0, 0, 0, 'HDFC Bank', 'Andheri', '444555666777', 'HDFC0000123', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(13, 'Sai Pharma', 'SUP003', 'Plot 8, MIDC, Nashik', '02532345678', 'contact@saipharma.in', 'T', 'TANSP3333C', 'MSME22333', 0.00, 'C', 150000.00, NULL, NULL, 'Suresh B', 'Amit V', '9876543210', NULL, NULL, '', 'A', 'DL003', NULL, 'FSSAI003', 'CST003', 'TIN003', 'PANSP003P', '27SP003G1Z3', '27', '1', 7, '1', 0, 'D', 1, '1', 'Wed,Sat', 0.00, 0, 1, 0, 'M', 'P', 1, 1, 0, 0, 1, 'Sai Pharma Pvt Ltd', '456789012345', 'R', '2020-02-05', '1', 0, 0, 0, 'Axis Bank', 'Nashik', '555666777888', 'UTIB0000456', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(14, 'Ravi Agencies', 'SUP004', 'Opp City Mall, Nagpur', '07122457890', 'raviagencies@outlook.com', 'T', 'TANRA4444D', NULL, 10000.00, 'C', 100000.00, NULL, NULL, 'Ravi M', 'Ketan D', '9922113344', NULL, NULL, '', 'A', 'DL004', NULL, 'FSSAI004', 'CST004', 'TIN004', 'PANRA004P', '27RA004G1Z4', '27', '1', 8, '1', 0, 'D', 1, '1', 'Tue,Sat', 0.00, 0, 0, 0, 'M', 'P', 0, 1, 0, 1, 0, 'Ravi Agencies', '567890123456', 'R', '2021-06-21', '0', 0, 0, 0, 'ICICI Bank', 'Nagpur Branch', '777888999000', 'ICIC0000234', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(15, 'Shree Medicals', 'SUP005', 'Main Market, Kolhapur', '02312233445', 'info@shreemedicals.com', 'F', 'TANSM5555E', 'MSME55555', 5000.00, 'C', 75000.00, NULL, NULL, 'Ajay N', 'Nikita R', '9898989898', '9000000001', NULL, '', 'A', 'DL005', NULL, 'FSSAI005', 'CST005', 'TIN005', 'PANSM005P', '27SM005G1Z5', '27', '1', 6, '2', 0, 'D', 1, '0', 'Mon,Wed,Fri', 0.00, 1, 1, 0, 'M', 'P', 0, 0, 0, 0, 1, 'Shree Medical Stores', '678901234567', 'R', '2017-09-30', '0', 0, 0, 0, 'Canara Bank', 'Kolhapur', '111222333444', 'CNRB0000456', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(16, 'Nexus Distributors', 'SUP006', 'Koregaon Park, Pune', '02025478900', 'sales@nexusdist.com', 'T', 'TANNX6666F', 'MSME66666', 30000.00, 'C', 500000.00, NULL, NULL, 'Nitin K', 'Rajesh G', '9865123456', NULL, NULL, '', 'A', 'DL006', NULL, 'FSSAI006', 'CST006', 'TIN006', 'PANNX006P', '27NX006G1Z6', '27', '1', 4, '1', 0, 'D', 1, '1', 'Tue,Fri', 0.00, 0, 0, 0, 'M', 'P', 0, 0, 1, 1, 0, 'Nexus Distribution Pvt Ltd', '789012345678', 'R', '2016-04-01', '0', 0, 0, 0, 'Union Bank', 'Pune', '333444555666', 'UBIN0000789', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(17, 'Kiran Enterprises', 'SUP007', 'MG Road, Solapur', '02172345678', 'kiranenterprises@yahoo.com', 'F', 'TANKR7777G', NULL, 0.00, 'C', 125000.00, NULL, NULL, 'Kiran S', 'Anil J', '9870001122', NULL, NULL, '', 'A', 'DL007', NULL, 'FSSAI007', 'CST007', 'TIN007', 'PANKR007P', '27KR007G1Z7', '27', '1', 3, '1', 0, 'D', 1, '1', 'Wed,Sat', 0.00, 0, 0, 0, 'M', 'P', 0, 0, 0, 1, 0, 'Kiran Enterprises', '890123456789', 'R', '2018-05-15', '0', 0, 0, 0, 'Bank of Baroda', 'Solapur', '222333444555', 'BARB0SOL123', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(18, 'Prime Medico', 'SUP008', 'Ambedkar Road, Aurangabad', '02402456789', 'prime.medico@gmail.com', 'T', 'TANPM8888H', NULL, 2000.00, 'C', 90000.00, NULL, NULL, 'Pooja R', 'Ashwin T', '9822998899', NULL, NULL, '', 'A', 'DL008', NULL, 'FSSAI008', 'CST008', 'TIN008', 'PANPM008P', '27PM008G1Z8', '27', '1', 2, '1', 0, 'D', 1, '0', 'Tue,Fri', 0.00, 0, 0, 0, 'M', 'P', 1, 0, 1, 1, 0, 'Prime Medico Pvt Ltd', '901234567890', 'R', '2019-11-12', '0', 0, 0, 0, 'Kotak Mahindra Bank', 'Aurangabad', '444666888999', 'KKBK0000456', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(19, 'Delta Agencies', 'SUP009', 'Civil Lines, Akola', '07242567890', 'deltaagencies@protonmail.com', 'F', 'TANDL9999I', 'MSME99999', 1000.00, 'C', 50000.00, NULL, NULL, 'Deepak L', 'Ramesh B', '9897665544', NULL, NULL, '', 'A', 'DL009', NULL, 'FSSAI009', 'CST009', 'TIN009', 'PANDL009P', '27DL009G1Z9', '27', '1', 2, '1', 0, 'D', 1, '0', 'Mon,Fri', 0.00, 0, 1, 0, 'M', 'P', 1, 1, 1, 0, 1, 'Delta Agencies Pvt Ltd', '912345678901', 'R', '2020-12-20', '0', 0, 0, 0, 'Yes Bank', 'Akola', '555777999000', 'YESB0000123', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(20, 'Everest Traders', 'SUP010', 'Ring Road, Sangli', '02332345678', 'everesttraders@biz.in', 'T', 'TANEV1010J', NULL, 7500.00, 'C', 80000.00, NULL, NULL, 'Manoj V', 'Lata S', '9001122334', NULL, NULL, '', 'A', 'DL010', NULL, 'FSSAI010', 'CST010', 'TIN010', 'PANE010P', '27EV010G1Z0', '27', '1', 3, '1', 0, 'D', 1, '1', 'Tue,Thu', 0.00, 1, 0, 0, 'M', 'P', 0, 0, 0, 1, 0, 'Everest Traders Pvt Ltd', '923456789012', 'R', '2015-07-07', '1', 0, 0, 0, 'IDBI Bank', 'Sangli', '888000111222', 'IBKL0000123', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(21, 'Mahesh Traders', 'SUP001', '12 MG Road, Pune', '02024567890', 'maheshtraders@gmail.com', 'T', 'TANMT1234A', 'MSME12345', 15000.00, 'C', 250000.00, NULL, NULL, 'Mahesh Patil', 'Ravi K', '9823045678', '9765123456', NULL, '', 'A', 'DL001', 'DL001A', 'FSSAI001', 'CST001', 'TIN001', 'PANMT001P', '27MT001G1Z1', '27', '1', 5, '1', 0, 'D', 1, '1', 'Mon,Thu', 0.00, 1, 1, 0, 'M', 'P', 0, 0, 0, 1, 1, 'Mahesh Traders Pvt Ltd', '234567890123', 'R', '2018-03-01', '0', 0, 0, 0, 'SBI', 'Pune Main', '000111222333', 'SBIN0000456', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(22, 'Om Distributors', 'SUP002', 'Block B, Andheri East, Mumbai', '02226578990', 'omdist@gmail.com', 'F', 'TANOM2234B', NULL, 20000.00, 'C', 400000.00, NULL, NULL, 'Om Sharma', 'Vikas R', '9988776655', NULL, NULL, '', 'A', 'DL002', 'DL002A', 'FSSAI002', 'CST002', 'TIN002', 'PANOM002P', '27OM002G1Z2', '27', '1', 10, '2', 0, 'D', 1, '1', 'Tue,Fri', 0.00, 0, 1, 0, 'M', 'P', 0, 1, 0, 1, 1, 'Om Distributors LLP', '345678901234', 'R', '2019-07-15', '0', 0, 0, 0, 'HDFC Bank', 'Andheri', '444555666777', 'HDFC0000123', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(23, 'Sai Pharma', 'SUP003', 'Plot 8, MIDC, Nashik', '02532345678', 'contact@saipharma.in', 'T', 'TANSP3333C', 'MSME22333', 0.00, 'C', 150000.00, NULL, NULL, 'Suresh B', 'Amit V', '9876543210', NULL, NULL, '', 'A', 'DL003', NULL, 'FSSAI003', 'CST003', 'TIN003', 'PANSP003P', '27SP003G1Z3', '27', '1', 7, '1', 0, 'D', 1, '1', 'Wed,Sat', 0.00, 0, 1, 0, 'M', 'P', 1, 1, 0, 0, 1, 'Sai Pharma Pvt Ltd', '456789012345', 'R', '2020-02-05', '1', 0, 0, 0, 'Axis Bank', 'Nashik', '555666777888', 'UTIB0000456', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(24, 'Ravi Agencies', 'SUP004', 'Opp City Mall, Nagpur', '07122457890', 'raviagencies@outlook.com', 'T', 'TANRA4444D', NULL, 10000.00, 'C', 100000.00, NULL, NULL, 'Ravi M', 'Ketan D', '9922113344', NULL, NULL, '', 'A', 'DL004', NULL, 'FSSAI004', 'CST004', 'TIN004', 'PANRA004P', '27RA004G1Z4', '27', '1', 8, '1', 0, 'D', 1, '1', 'Tue,Sat', 0.00, 0, 0, 0, 'M', 'P', 0, 1, 0, 1, 0, 'Ravi Agencies', '567890123456', 'R', '2021-06-21', '0', 0, 0, 0, 'ICICI Bank', 'Nagpur Branch', '777888999000', 'ICIC0000234', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(25, 'Shree Medicals', 'SUP005', 'Main Market, Kolhapur', '02312233445', 'info@shreemedicals.com', 'F', 'TANSM5555E', 'MSME55555', 5000.00, 'C', 75000.00, NULL, NULL, 'Ajay N', 'Nikita R', '9898989898', '9000000001', NULL, '', 'A', 'DL005', NULL, 'FSSAI005', 'CST005', 'TIN005', 'PANSM005P', '27SM005G1Z5', '27', '1', 6, '2', 0, 'D', 1, '0', 'Mon,Wed,Fri', 0.00, 1, 1, 0, 'M', 'P', 0, 0, 0, 0, 1, 'Shree Medical Stores', '678901234567', 'R', '2017-09-30', '0', 0, 0, 0, 'Canara Bank', 'Kolhapur', '111222333444', 'CNRB0000456', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(26, 'Nexus Distributors', 'SUP006', 'Koregaon Park, Pune', '02025478900', 'sales@nexusdist.com', 'T', 'TANNX6666F', 'MSME66666', 30000.00, 'C', 500000.00, NULL, NULL, 'Nitin K', 'Rajesh G', '9865123456', NULL, NULL, '', 'A', 'DL006', NULL, 'FSSAI006', 'CST006', 'TIN006', 'PANNX006P', '27NX006G1Z6', '27', '1', 4, '1', 0, 'D', 1, '1', 'Tue,Fri', 0.00, 0, 0, 0, 'M', 'P', 0, 0, 1, 1, 0, 'Nexus Distribution Pvt Ltd', '789012345678', 'R', '2016-04-01', '0', 0, 0, 0, 'Union Bank', 'Pune', '333444555666', 'UBIN0000789', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(27, 'Kiran Enterprises', 'SUP007', 'MG Road, Solapur', '02172345678', 'kiranenterprises@yahoo.com', 'F', 'TANKR7777G', NULL, 0.00, 'C', 125000.00, NULL, NULL, 'Kiran S', 'Anil J', '9870001122', NULL, NULL, '', 'A', 'DL007', NULL, 'FSSAI007', 'CST007', 'TIN007', 'PANKR007P', '27KR007G1Z7', '27', '1', 3, '1', 0, 'D', 1, '1', 'Wed,Sat', 0.00, 0, 0, 0, 'M', 'P', 0, 0, 0, 1, 0, 'Kiran Enterprises', '890123456789', 'R', '2018-05-15', '0', 0, 0, 0, 'Bank of Baroda', 'Solapur', '222333444555', 'BARB0SOL123', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(28, 'Prime Medico', 'SUP008', 'Ambedkar Road, Aurangabad', '02402456789', 'prime.medico@gmail.com', 'T', 'TANPM8888H', NULL, 2000.00, 'C', 90000.00, NULL, NULL, 'Pooja R', 'Ashwin T', '9822998899', NULL, NULL, '', 'A', 'DL008', NULL, 'FSSAI008', 'CST008', 'TIN008', 'PANPM008P', '27PM008G1Z8', '27', '1', 2, '1', 0, 'D', 1, '0', 'Tue,Fri', 0.00, 0, 0, 0, 'M', 'P', 1, 0, 1, 1, 0, 'Prime Medico Pvt Ltd', '901234567890', 'R', '2019-11-12', '0', 0, 0, 0, 'Kotak Mahindra Bank', 'Aurangabad', '444666888999', 'KKBK0000456', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(29, 'Delta Agencies', 'SUP009', 'Civil Lines, Akola', '07242567890', 'deltaagencies@protonmail.com', 'F', 'TANDL9999I', 'MSME99999', 1000.00, 'C', 50000.00, NULL, NULL, 'Deepak L', 'Ramesh B', '9897665544', NULL, NULL, '', 'A', 'DL009', NULL, 'FSSAI009', 'CST009', 'TIN009', 'PANDL009P', '27DL009G1Z9', '27', '1', 2, '1', 0, 'D', 1, '0', 'Mon,Fri', 0.00, 0, 1, 0, 'M', 'P', 1, 1, 1, 0, 1, 'Delta Agencies Pvt Ltd', '912345678901', 'R', '2020-12-20', '0', 0, 0, 0, 'Yes Bank', 'Akola', '555777999000', 'YESB0000123', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(30, 'Everest Traders', 'SUP010', 'Ring Road, Sangli', '02332345678', 'everesttraders@biz.in', 'T', 'TANEV1010J', NULL, 7500.00, 'C', 80000.00, NULL, NULL, 'Manoj V', 'Lata S', '9001122334', NULL, NULL, '', 'A', 'DL010', NULL, 'FSSAI010', 'CST010', 'TIN010', 'PANE010P', '27EV010G1Z0', '27', '1', 3, '1', 0, 'D', 1, '1', 'Tue,Thu', 0.00, 1, 0, 0, 'M', 'P', 0, 0, 0, 1, 0, 'Everest Traders Pvt Ltd', '923456789012', 'R', '2015-07-07', '1', 0, 0, 0, 'IDBI Bank', 'Sangli', '888000111222', 'IBKL0000123', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(31, 'Ganesh Medico', 'SUP011', 'Sector 10, Navi Mumbai', '02227894567', 'ganeshmedico@gmail.com', 'T', 'TANGM1111K', 'MSME11111', 18000.00, 'C', 220000.00, NULL, NULL, 'Ganesh D', 'Meena G', '9890011223', NULL, NULL, '', 'A', 'DL011', NULL, 'FSSAI011', 'CST011', 'TIN011', 'PANGM011P', '27GM011G1Z1', '27', '1', 6, '1', 0, 'D', 1, '1', 'Mon,Fri', 0.00, 0, 0, 0, 'M', 'P', 0, 0, 0, 1, 1, 'Ganesh Medico Stores', '934567890123', 'R', '2019-01-10', '0', 0, 0, 0, 'SBI', 'Navi Mumbai', '100200300400', 'SBIN0000457', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(32, 'Krishna Agencies', 'SUP012', 'Old Bus Stand, Jalgaon', '02572233445', 'krishnaagencies@yahoo.com', 'F', 'TANKA1212L', 'MSME12121', 22000.00, 'C', 300000.00, NULL, NULL, 'Krishna P', 'Lalit D', '9850012345', NULL, NULL, '', 'A', 'DL012', NULL, 'FSSAI012', 'CST012', 'TIN012', 'PANKA012P', '27KA012G1Z2', '27', '1', 4, '2', 0, 'D', 1, '1', 'Tue,Fri', 0.00, 0, 0, 0, 'M', 'P', 1, 0, 1, 0, 0, 'Krishna Agencies', '945678901234', 'R', '2018-11-09', '0', 0, 0, 0, 'HDFC Bank', 'Jalgaon', '101202303404', 'HDFC0000567', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(33, 'Metro Pharma', 'SUP013', 'Station Road, Latur', '02382233445', 'metro.pharma@bizmail.com', 'T', 'TANMP1313M', 'MSME13131', 35000.00, 'C', 480000.00, NULL, NULL, 'Rohan S', 'Ankit T', '9823456789', NULL, NULL, '', 'A', 'DL013', NULL, 'FSSAI013', 'CST013', 'TIN013', 'PANMP013P', '27MP013G1Z3', '27', '1', 3, '2', 0, 'D', 1, '0', 'Mon,Wed,Fri', 0.00, 1, 1, 0, 'M', 'P', 0, 1, 0, 1, 0, 'Metro Pharma Ltd', '956789012345', 'R', '2020-08-22', '0', 0, 0, 0, 'Axis Bank', 'Latur', '111333555777', 'UTIB0000567', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(34, 'City Traders', 'SUP014', 'Main Chowk, Satara', '02162233456', 'citytraders@outlook.com', 'F', 'TANCT1414N', NULL, 12000.00, 'C', 130000.00, NULL, NULL, 'Mohan B', 'Ajit P', '9765012345', NULL, NULL, '', 'A', 'DL014', NULL, 'FSSAI014', 'CST014', 'TIN014', 'PANCT014P', '27CT014G1Z4', '27', '1', 5, '1', 0, 'D', 1, '0', 'Mon,Thu', 0.00, 0, 0, 0, 'M', 'P', 1, 0, 1, 1, 1, 'City Traders', '967890123456', 'R', '2021-01-12', '0', 0, 0, 0, 'ICICI Bank', 'Satara', '222444666888', 'ICIC0000789', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(35, 'Nova Meds', 'SUP015', 'New Market, Thane', '02225367890', 'nova.meds@gmail.com', 'T', 'TANNM1515O', 'MSME15151', 17000.00, 'C', 190000.00, NULL, NULL, 'Nitin R', 'Sneha J', '9876540099', NULL, NULL, '', 'A', 'DL015', NULL, 'FSSAI015', 'CST015', 'TIN015', 'PANNM015P', '27NM015G1Z5', '27', '1', 2, '2', 0, 'D', 1, '0', 'Tue,Fri', 0.00, 0, 0, 0, 'M', 'P', 0, 1, 0, 1, 0, 'Nova Meds Pvt Ltd', '978901234567', 'R', '2019-09-09', '0', 0, 0, 0, 'Canara Bank', 'Thane', '333555777999', 'CNRB0000678', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(36, 'Advance Agencies', 'SUP016', 'Tilak Road, Ahmednagar', '02412233456', 'advance.agency@gmail.com', 'F', 'TANAD1616P', NULL, 8000.00, 'C', 100000.00, NULL, NULL, 'Aditya V', 'Tejas P', '9811122233', NULL, NULL, '', 'A', 'DL016', NULL, 'FSSAI016', 'CST016', 'TIN016', 'PANAD016P', '27AD016G1Z6', '27', '1', 3, '1', 0, 'D', 1, '0', 'Wed,Sat', 0.00, 0, 1, 0, 'M', 'P', 0, 0, 0, 1, 1, 'Advance Agencies', '989012345678', 'R', '2020-02-14', '0', 0, 0, 0, 'SBI', 'Ahmednagar', '444666888111', 'SBIN0000678', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(37, 'Sunrise Traders', 'SUP017', 'Sector 8, Navi Mumbai', '02227566789', 'sunrise.traders@biz.com', 'T', 'TANSR1717Q', 'MSME17171', 25000.00, 'C', 280000.00, NULL, NULL, 'Rajesh P', 'Minal L', '9857788990', NULL, NULL, '', 'A', 'DL017', NULL, 'FSSAI017', 'CST017', 'TIN017', 'PANSR017P', '27SR017G1Z7', '27', '1', 7, '1', 0, 'D', 1, '0', 'Tue,Fri', 0.00, 0, 0, 0, 'M', 'P', 1, 1, 1, 0, 0, 'Sunrise Traders Pvt Ltd', '990123456789', 'R', '2021-05-18', '0', 0, 0, 0, 'HDFC Bank', 'Vashi', '555777999111', 'HDFC0000789', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(38, 'Shivam Medicals', 'SUP018', 'Main Road, Beed', '02442233456', 'shivammedicals@gmail.com', 'T', 'TANSM1818R', NULL, 0.00, 'C', 85000.00, NULL, NULL, 'Shivam D', 'Rohit P', '9866011223', NULL, NULL, '', 'A', 'DL018', NULL, 'FSSAI018', 'CST018', 'TIN018', 'PANSM018P', '27SM018G1Z8', '27', '1', 4, '2', 0, 'D', 1, '0', 'Mon,Thu', 0.00, 0, 0, 0, 'M', 'P', 0, 1, 0, 1, 0, 'Shivam Medicals', '991234567890', 'R', '2022-04-01', '0', 0, 0, 0, 'ICICI Bank', 'Beed', '666888000111', 'ICIC0000890', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(39, 'Global Medico', 'SUP019', 'City Center, Amravati', '07212233445', 'globalmedico@yahoo.com', 'F', 'TANGM1919S', 'MSME19191', 19000.00, 'C', 210000.00, NULL, NULL, 'Gopal N', 'Sanjay L', '9822991100', NULL, NULL, '', 'A', 'DL019', NULL, 'FSSAI019', 'CST019', 'TIN019', 'PANGM019P', '27GM019G1Z9', '27', '1', 5, '1', 0, 'D', 1, '0', 'Mon,Fri', 0.00, 0, 1, 0, 'M', 'P', 0, 0, 1, 0, 0, 'Global Medico Pvt Ltd', '992345678901', 'R', '2017-07-19', '0', 0, 0, 0, 'Union Bank', 'Amravati', '777999111333', 'UBIN0000567', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(40, 'Perfect Pharma', 'SUP020', 'Shaniwar Peth, Pune', '02024455667', 'perfect.pharma@gmail.com', 'T', 'TANPP2020T', NULL, 25000.00, 'C', 350000.00, NULL, NULL, 'Pradeep J', 'Sonal T', '9833011223', NULL, NULL, '', 'A', 'DL020', NULL, 'FSSAI020', 'CST020', 'TIN020', 'PANPP020P', '27PP020G1Z0', '27', '1', 8, '1', 0, 'D', 1, '0', 'Mon,Fri', 0.00, 0, 0, 0, 'M', 'P', 1, 0, 1, 1, 1, 'Perfect Pharma Pvt Ltd', '993456789012', 'R', '2023-01-25', '0', 0, 0, 0, 'Axis Bank', 'Pune', '888111444777', 'UTIB0000678', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(41, 'amansingh', '1', 'RTGDFTGH', '345345', 'admin@gmail.com', 'T', '345345', '345345', 0.07, 'C', 0.12, '2025-10-19', '2025-10-21', 'wefwrf', 'GFDHDGF', '345345', '423143', '34', '23423', '34', '34234234', '4523423423', '34534', '234234', '2134', NULL, '34534', '09 Uttar Pradesh', 'L', 0, 'F', 0, 'T', 0, '0', NULL, 0.00, 0, 0, 0, 'M', 'P', 0, 0, 0, 0, 0, 'abhishek', '4334534534', 'U', '2025-10-21', '0', 0, 0, 0, 'fgfdxg', NULL, '34345345345', 'cgffd45', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(42, 'sfsrf', '434', 'swfweret', '34534', 'aditya34@gmail.com', 'T', '345345', '345345', 0.10, 'D', 0.08, '2025-10-16', '2025-10-17', 'wefwrf', 'ABHI', '5445656', '34534534', NULL, '23423', NULL, '34234234', '4523423423', '34534', '234234', '345345', '2342342342', '234234234234', '09 Uttar Pradesh', 'L', 0, 'F', 0, 'I', 0, '0', NULL, 0.00, 0, 0, 0, 'M', 'S', 0, 0, 0, 0, 0, 'System Admin1', '4334534534', 'R', '2025-10-16', '0', 0, 0, 0, 'KOTAK', 'MEERUT', '34345345345', '23423423', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(43, 'dfvdf', NULL, 'dfgdfg', '6756', 'dfgdfg@fdgh.fghf', 'T', NULL, NULL, 0.00, 'C', 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'L', 0, NULL, 0, 'T', 0, '0', NULL, 0.00, 0, 0, 0, 'M', 'B', 0, 0, 0, 0, 0, NULL, NULL, 'U', NULL, '0', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(44, 'dfgdfg', NULL, 'dfgdfg', '324234', 'dfsd@fth.fgh', 'T', NULL, NULL, 0.00, 'C', 0.00, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'L', 0, NULL, 0, 'T', 0, '1', NULL, 0.00, 0, 0, 0, 'M', 'B', 0, 0, 0, 0, 0, NULL, NULL, 'U', NULL, '0', 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL),
(46, 'sdfg', 'sfsdf', 'sdfsdf', '435345', 'sdf@dg.fgh', 'T', 'sdfsdf', 'sdfdsf', 0.13, 'C', 0.13, '2025-10-14', '2025-10-17', '4534', '345345', '345345', '354335', '345345', '345', '345345', '453453453', '34534534', '534534534', '554334', '534534534', '5345345', '234234234234', '09 Uttar Pradesh', 'C', 0, 'F', 0, 'T', 0, 'M', 'Mon,Thu', 0.00, 0, 0, 0, 'S', 'B', 0, 0, 0, 0, 0, 'abhishek', '345345345345', 'U', '2025-10-22', '#', 0, 0, 1, 'KOTAK', 'Pune Main', '000111222333', 'SBIN0000456', NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transport_masters`
--

CREATE TABLE `transport_masters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `alter_code` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `gst_no` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `vehicle_no` varchar(255) DEFAULT NULL,
  `trans_mode` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transport_masters`
--

INSERT INTO `transport_masters` (`id`, `name`, `address`, `alter_code`, `telephone`, `email`, `mobile`, `gst_no`, `status`, `vehicle_no`, `trans_mode`, `created_at`, `updated_at`) VALUES
(1, 'Blue Dart Express', 'Plot 12, Industrial Area\\nMumbai, Maharashtra 400001', 'BD001', '022-12345678', 'info@bluedart.com', '9876543210', '27AABCU9603R1ZM', 'Active', 'MH-01-AB-1234', 'Road', '2025-10-29 01:44:00', '2025-10-29 01:44:00'),
(2, 'DTDC Courier', 'Sector 15, Transport Hub\\nDelhi, Delhi 110001', 'DT002', '011-23456789', 'contact@dtdc.com', '9876543211', '07AABCD1234E1Z5', 'Active', 'DL-02-BC-5678', 'Road', '2025-10-29 01:44:00', '2025-10-29 01:44:00'),
(3, 'Professional Couriers', 'Zone 8, Logistics Park\\nAhmedabad, Gujarat 380001', 'PC003', '079-34567890', 'info@procourier.com', '9876543212', '24AABCP1234F1Z6', 'Active', 'GJ-03-CD-9012', 'Road', '2025-10-29 01:44:00', '2025-10-29 01:44:00'),
(4, 'First Flight Couriers', 'Building 5, Tech City\\nBangalore, Karnataka 560001', 'FF004', '080-45678901', 'support@firstflight.com', '9876543213', '29AABCF1234G1Z7', 'Active', 'KA-04-DE-3456', 'Air', '2025-10-29 01:44:00', '2025-10-29 01:44:00'),
(5, 'Gati Packers', 'Warehouse 3, Port Area\\nChennai, Tamil Nadu 600001', 'GP005', '044-56789012', 'info@gati.com', '9876543214', '33AABCG1234H1Z8', 'Active', 'TN-05-EF-7890', 'Road', '2025-10-29 01:44:00', '2025-10-29 01:44:00'),
(6, 'VRL Logistics', 'Station Road, Transport Nagar\\nPune, Maharashtra 411001', 'VL006', '020-67890123', 'contact@vrl.com', '9876543215', '27AABCV1234I1Z9', 'Active', 'MH-06-FG-1234', 'Road', '2025-10-29 01:44:00', '2025-10-29 01:44:00'),
(7, 'TCI Express', 'Sector 22, Industrial Zone\\nHyderabad, Telangana 500001', 'TC007', '040-78901234', 'info@tciexpress.com', '9876543216', '36AABCT1234J1ZA', 'Active', 'TS-07-GH-5678', 'Rail', '2025-10-29 01:44:00', '2025-10-29 01:44:00'),
(8, 'Safexpress', 'Plot 45, Cargo Complex\\nKolkata, West Bengal 700001', 'SX008', '033-89012345', 'support@safexpress.com', '9876543217', '19AABCS1234K1ZB', 'Active', 'WB-08-HI-9012', 'Road', '2025-10-29 01:44:00', '2025-10-29 01:44:00'),
(9, 'Delhivery', 'Warehouse 12, Logistics Hub\\nJaipur, Rajasthan 302001', 'DL009', '0141-90123456', 'info@delhivery.com', '9876543218', '08AABCD1234L1ZC', 'Active', 'RJ-09-IJ-3456', 'Road', '2025-10-29 01:44:00', '2025-10-29 01:44:00'),
(10, 'Ecom Express', 'Zone 5, Distribution Center\\nLucknow, Uttar Pradesh 226001', 'EC010', '0522-01234567', 'contact@ecomexpress.com', '9876543219', '09AABCE1234M1ZD', 'Active', 'UP-10-JK-7890', 'Road', '2025-10-29 01:44:00', '2025-10-29 01:44:00'),
(11, 'Shadowfax', 'Building 8, Tech Park\\nNoida, Uttar Pradesh 201301', 'SF011', '0120-12345678', 'info@shadowfax.com', '9876543220', '09AABCS1234N1ZE', 'Active', 'UP-11-KL-1234', 'Road', '2025-10-29 01:44:00', '2025-10-29 01:44:00'),
(12, 'Xpressbees', 'Sector 18, Logistics Zone\\nGurgaon, Haryana 122001', 'XB012', '0124-23456789', 'support@xpressbees.com', '9876543221', '06AABCX1234O1ZF', 'Active', 'HR-12-LM-5678', 'Road', '2025-10-29 01:44:00', '2025-10-29 01:44:00'),
(13, 'Ekart Logistics', 'Plot 25, Warehouse District\\nIndore, Madhya Pradesh 452001', 'EK013', '0731-34567890', 'info@ekartlogistics.com', '9876543222', '23AABCE1234P1ZG', 'Active', 'MP-13-MN-9012', 'Road', '2025-10-29 01:44:00', '2025-10-29 01:44:00'),
(14, 'Rivigo', 'Zone 12, Transport Hub\\nNagpur, Maharashtra 440001', 'RV014', '0712-45678901', 'contact@rivigo.com', '9876543223', '27AABCR1234Q1ZH', 'Active', 'MH-14-NO-3456', 'Road', '2025-10-29 01:44:00', '2025-10-29 01:44:00'),
(15, 'Mahindra Logistics', 'Sector 30, Industrial Area\\nSurat, Gujarat 395001', 'ML015', '0261-56789012', 'info@mahindralogistics.com', '9876543224', '24AABCM1234R1ZI', 'Active', 'GJ-15-OP-7890', 'Road', '2025-10-29 01:44:00', '2025-10-29 01:44:00'),
(16, 'Allcargo Logistics', 'Port Zone, Shipping Area\\nVisakhapatnam, AP 530001', 'AL016', '0891-67890123', 'support@allcargo.com', '9876543225', '37AABCA1234S1ZJ', 'Active', 'AP-16-PQ-1234', 'Ship', '2025-10-29 01:44:00', '2025-10-29 01:44:00'),
(17, 'Container Corporation', 'Railway Yard, Cargo Terminal\\nBhopal, Madhya Pradesh 462001', 'CC017', '0755-78901234', 'info@concorindia.com', '9876543226', '23AABCC1234T1ZK', 'Active', 'MP-17-QR-5678', 'Rail', '2025-10-29 01:44:00', '2025-10-29 01:44:00'),
(18, 'SpiceJet Cargo', 'Airport Complex, Cargo Terminal\\nCochin, Kerala 682001', 'SJ018', '0484-89012345', 'cargo@spicejet.com', '9876543227', '32AABCS1234U1ZL', 'Active', 'KL-18-RS-9012', 'Air', '2025-10-29 01:44:00', '2025-10-29 01:44:00'),
(19, 'IndiGo CarGo', 'Terminal 2, Airport Road\\nThiruvananthapuram, Kerala 695001', 'IC019', '0471-90123456', 'cargo@goindigo.in', '9876543228', '32AABCI1234V1ZM', 'Active', 'KL-19-ST-3456', 'Air', '2025-10-29 01:44:00', '2025-10-29 01:44:00'),
(20, 'Maersk Shipping', 'Dock 5, Port Area\\nMumbai, Maharashtra 400001', 'MS020', '022-01234567', 'info@maersk.com', '9876543229', '27AABCM1234W1ZN', 'Inactive', 'MH-20-TU-7890', 'Ship', '2025-10-29 01:44:00', '2025-10-29 01:44:00'),
(21, 'Om Logistics', 'Sector 45, Transport Nagar\\nChandigarh, Chandigarh 160001', 'OL021', '0172-12345678', 'info@omlogistics.com', '9876543230', '04AABCO1234X1ZO', 'Active', 'CH-21-UV-1234', 'Road', '2025-10-29 01:44:00', '2025-10-29 01:44:00'),
(22, 'Agarwal Packers', 'Plot 18, Industrial Zone\\nLudhiana, Punjab 141001', 'AP022', '0161-23456789', 'contact@agarwalpackers.com', '9876543231', '03AABCA1234Y1ZP', 'Active', 'PB-22-VW-5678', 'Road', '2025-10-29 01:44:00', '2025-10-29 01:44:00'),
(23, 'VRL Packers', 'Station Road, Transport Hub\\nVijayawada, AP 520001', 'VP023', '0866-34567890', 'info@vrlpackers.com', '9876543232', '37AABCV1234Z1ZQ', 'Active', 'AP-23-WX-9012', 'Road', '2025-10-29 01:44:00', '2025-10-29 01:44:00'),
(24, 'Leo Packers', 'Zone 8, Logistics Park\\nCoimbatore, Tamil Nadu 641001', 'LP024', '0422-45678901', 'support@leopackers.com', '9876543233', '33AABCL1234A2ZR', 'Active', 'TN-24-XY-3456', 'Road', '2025-10-29 01:44:00', '2025-10-29 01:44:00'),
(25, 'Shree Maruti', 'Warehouse 15, Port Road\\nMangalore, Karnataka 575001', 'SM025', '0824-56789012', 'info@shreemaruti.com', '9876543234', '29AABCS1234B2ZS', 'Active', 'KA-25-YZ-7890', 'Road', '2025-10-29 01:44:00', '2025-10-29 01:44:00'),
(26, 'Balaji Cargo', 'Sector 12, Industrial Area\\nRanchi, Jharkhand 834001', 'BC026', '0651-67890123', 'contact@balajicargo.com', '9876543235', '20AABCB1234C2ZT', 'Active', 'JH-26-ZA-1234', 'Road', '2025-10-29 01:44:00', '2025-10-29 01:44:00'),
(27, 'Shree Ganesh', 'Plot 22, Transport Zone\\nPatna, Bihar 800001', 'SG027', '0612-78901234', 'info@shreeganesh.com', '9876543236', '10AABCS1234D2ZU', 'Active', 'BR-27-AB-5678', 'Road', '2025-10-29 01:44:00', '2025-10-29 01:44:00'),
(28, 'Raj Transport', 'Zone 5, Logistics Hub\\nJodhpur, Rajasthan 342001', 'RT028', '0291-89012345', 'support@rajtransport.com', '9876543237', '08AABCR1234E2ZV', 'Active', 'RJ-28-BC-9012', 'Road', '2025-10-29 01:44:00', '2025-10-29 01:44:00'),
(29, 'Shivam Logistics', 'Building 10, Cargo Complex\\nUdaipur, Rajasthan 313001', 'SL029', '0294-90123456', 'info@shivamlogistics.com', '9876543238', '08AABCS1234F2ZW', 'Active', 'RJ-29-CD-3456', 'Road', '2025-10-29 01:44:00', '2025-10-29 01:44:00'),
(30, 'Krishna Cargo', 'Sector 18, Transport Nagar\\nAgra, Uttar Pradesh 282001', 'KC030', '0562-01234567', 'contact@krishnacargo.com', '9876543239', '09AABCK1234G2ZX', 'Active', 'UP-30-DE-7890', 'Road', '2025-10-29 01:44:00', '2025-10-29 01:44:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `profile_picture` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `username`, `email`, `password`, `role`, `profile_picture`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'abhishek', 'admin', 'admin@example.com', '$2y$12$vS5rUdF7AIRSadrWjVrq7Oz1.ha0QtsUedZUXrAJ98o6UqALsJgSS', 'admin', 'storage/profiles/XJenld9HwgtZdb7OF69iKxb8QBXKOHLFGh7qRdK9.jpg', NULL, '2025-10-07 04:07:34', '2025-10-24 05:59:29'),
(2, 'abhishek chauhan', 'abhi1', 'abhi@ok.com', '$2y$12$eQv8LEAbT7xYITpglenLN.K5ExKt/WSG4u0yxCqyVa/yhnJUVhPve', 'admin', NULL, NULL, '2025-10-08 05:21:12', '2025-10-08 05:21:12'),
(3, 'abhishek chauhan', 'abhi11', 'abhi11@gmail.com', '$2y$12$Ig1trZyIyDxCvOq0sgGdouvy6UMFBEorilt9T8uUG4j4gV2CKQ9oS', 'user', NULL, NULL, '2025-10-14 23:29:43', '2025-10-14 23:29:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `area_managers`
--
ALTER TABLE `area_managers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `area_managers_code_unique` (`code`);

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `batches_batch_number_unique` (`batch_number`),
  ADD KEY `batches_item_id_index` (`item_id`),
  ADD KEY `batches_expiry_date_index` (`expiry_date`),
  ADD KEY `batches_status_index` (`status`),
  ADD KEY `batches_batch_number_index` (`batch_number`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cash_bank_books`
--
ALTER TABLE `cash_bank_books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `country_managers`
--
ALTER TABLE `country_managers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `country_managers_code_unique` (`code`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_created_by_foreign` (`created_by`),
  ADD KEY `customers_modified_by_foreign` (`modified_by`);

--
-- Indexes for table `customer_challans`
--
ALTER TABLE `customer_challans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_challans_customer_id_index` (`customer_id`),
  ADD KEY `customer_challans_challan_date_index` (`challan_date`);

--
-- Indexes for table `customer_discounts`
--
ALTER TABLE `customer_discounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_discounts_customer_id_index` (`customer_id`);

--
-- Indexes for table `customer_dues`
--
ALTER TABLE `customer_dues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_dues_customer_id_index` (`customer_id`),
  ADD KEY `customer_dues_due_date_index` (`due_date`);

--
-- Indexes for table `customer_ledgers`
--
ALTER TABLE `customer_ledgers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_ledgers_customer_id_index` (`customer_id`),
  ADD KEY `customer_ledgers_transaction_date_index` (`transaction_date`);

--
-- Indexes for table `customer_prescriptions`
--
ALTER TABLE `customer_prescriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_prescriptions_customer_id_index` (`customer_id`),
  ADD KEY `customer_prescriptions_validity_date_index` (`validity_date`);

--
-- Indexes for table `customer_special_rates`
--
ALTER TABLE `customer_special_rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_special_rates_item_id_foreign` (`item_id`),
  ADD KEY `customer_special_rates_customer_id_item_id_index` (`customer_id`,`item_id`);

--
-- Indexes for table `divisional_managers`
--
ALTER TABLE `divisional_managers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `divisional_managers_code_unique` (`code`);

--
-- Indexes for table `expiry_ledger`
--
ALTER TABLE `expiry_ledger`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expiry_ledger_item_id_foreign` (`item_id`),
  ADD KEY `expiry_ledger_batch_id_foreign` (`batch_id`),
  ADD KEY `expiry_ledger_customer_id_foreign` (`customer_id`),
  ADD KEY `expiry_ledger_supplier_id_foreign` (`supplier_id`),
  ADD KEY `expiry_ledger_transaction_date_index` (`transaction_date`),
  ADD KEY `expiry_ledger_expiry_date_index` (`expiry_date`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `general_ledgers`
--
ALTER TABLE `general_ledgers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_managers`
--
ALTER TABLE `general_managers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_notebooks`
--
ALTER TABLE `general_notebooks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_reminders`
--
ALTER TABLE `general_reminders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `godown_expiry`
--
ALTER TABLE `godown_expiry`
  ADD PRIMARY KEY (`id`),
  ADD KEY `godown_expiry_item_id_foreign` (`item_id`),
  ADD KEY `godown_expiry_batch_id_foreign` (`batch_id`),
  ADD KEY `godown_expiry_expiry_date_index` (`expiry_date`);

--
-- Indexes for table `hsn_codes`
--
ALTER TABLE `hsn_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`invoice_id`),
  ADD KEY `invoices_company_id_foreign` (`company_id`),
  ADD KEY `invoices_customer_id_foreign` (`customer_id`),
  ADD KEY `invoices_created_by_foreign` (`created_by`),
  ADD KEY `invoices_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `invoice_items_invoice_id_foreign` (`invoice_id`),
  ADD KEY `invoice_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `invoice_payments`
--
ALTER TABLE `invoice_payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `invoice_payments_invoice_id_foreign` (`invoice_id`),
  ADD KEY `invoice_payments_created_by_foreign` (`created_by`);

--
-- Indexes for table `invoice_settings`
--
ALTER TABLE `invoice_settings`
  ADD PRIMARY KEY (`setting_id`),
  ADD KEY `invoice_settings_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `invoice_templates`
--
ALTER TABLE `invoice_templates`
  ADD PRIMARY KEY (`template_id`),
  ADD KEY `invoice_templates_created_by_foreign` (`created_by`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `items_company_id_foreign` (`company_id`);

--
-- Indexes for table `item_categories`
--
ALTER TABLE `item_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marketing_managers`
--
ALTER TABLE `marketing_managers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `marketing_managers_code_unique` (`code`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pending_orders`
--
ALTER TABLE `pending_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pending_orders_item_id_foreign` (`item_id`),
  ADD KEY `pending_orders_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `personal_directories`
--
ALTER TABLE `personal_directories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_ledgers`
--
ALTER TABLE `purchase_ledgers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `regional_managers`
--
ALTER TABLE `regional_managers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `regional_managers_code_unique` (`code`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sales_invoice_no_unique` (`invoice_no`),
  ADD KEY `sales_customer_id_foreign` (`customer_id`),
  ADD KEY `sales_salesman_id_foreign` (`salesman_id`);

--
-- Indexes for table `sales_men`
--
ALTER TABLE `sales_men`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sales_men_code_unique` (`code`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_items_sale_id_foreign` (`sale_id`),
  ADD KEY `sale_items_item_id_foreign` (`item_id`),
  ADD KEY `sale_items_batch_id_foreign` (`batch_id`);

--
-- Indexes for table `sale_ledgers`
--
ALTER TABLE `sale_ledgers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_ledgers`
--
ALTER TABLE `stock_ledgers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stock_ledgers_trans_no_unique` (`trans_no`),
  ADD KEY `stock_ledgers_item_id_index` (`item_id`),
  ADD KEY `stock_ledgers_batch_id_index` (`batch_id`),
  ADD KEY `stock_ledgers_transaction_date_index` (`transaction_date`),
  ADD KEY `stock_ledgers_transaction_type_index` (`transaction_type`),
  ADD KEY `stock_ledgers_customer_id_index` (`customer_id`),
  ADD KEY `stock_ledgers_supplier_id_index` (`supplier_id`),
  ADD KEY `stock_ledgers_salesman_id_index` (`salesman_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`),
  ADD KEY `suppliers_created_by_foreign` (`created_by`),
  ADD KEY `suppliers_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `transport_masters`
--
ALTER TABLE `transport_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `area_managers`
--
ALTER TABLE `area_managers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cash_bank_books`
--
ALTER TABLE `cash_bank_books`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `country_managers`
--
ALTER TABLE `country_managers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `customer_challans`
--
ALTER TABLE `customer_challans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_discounts`
--
ALTER TABLE `customer_discounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer_dues`
--
ALTER TABLE `customer_dues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customer_ledgers`
--
ALTER TABLE `customer_ledgers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customer_prescriptions`
--
ALTER TABLE `customer_prescriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer_special_rates`
--
ALTER TABLE `customer_special_rates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `divisional_managers`
--
ALTER TABLE `divisional_managers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `expiry_ledger`
--
ALTER TABLE `expiry_ledger`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_ledgers`
--
ALTER TABLE `general_ledgers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `general_managers`
--
ALTER TABLE `general_managers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `general_notebooks`
--
ALTER TABLE `general_notebooks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_reminders`
--
ALTER TABLE `general_reminders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `godown_expiry`
--
ALTER TABLE `godown_expiry`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hsn_codes`
--
ALTER TABLE `hsn_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `invoice_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `invoice_items`
--
ALTER TABLE `invoice_items`
  MODIFY `item_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `invoice_payments`
--
ALTER TABLE `invoice_payments`
  MODIFY `payment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_settings`
--
ALTER TABLE `invoice_settings`
  MODIFY `setting_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_templates`
--
ALTER TABLE `invoice_templates`
  MODIFY `template_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `item_categories`
--
ALTER TABLE `item_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `marketing_managers`
--
ALTER TABLE `marketing_managers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `pending_orders`
--
ALTER TABLE `pending_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_directories`
--
ALTER TABLE `personal_directories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `purchase_ledgers`
--
ALTER TABLE `purchase_ledgers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `regional_managers`
--
ALTER TABLE `regional_managers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sales_men`
--
ALTER TABLE `sales_men`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_ledgers`
--
ALTER TABLE `sale_ledgers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `stock_ledgers`
--
ALTER TABLE `stock_ledgers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `transport_masters`
--
ALTER TABLE `transport_masters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `batches`
--
ALTER TABLE `batches`
  ADD CONSTRAINT `batches_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `customers_modified_by_foreign` FOREIGN KEY (`modified_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `customer_challans`
--
ALTER TABLE `customer_challans`
  ADD CONSTRAINT `customer_challans_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_discounts`
--
ALTER TABLE `customer_discounts`
  ADD CONSTRAINT `customer_discounts_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_dues`
--
ALTER TABLE `customer_dues`
  ADD CONSTRAINT `customer_dues_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_ledgers`
--
ALTER TABLE `customer_ledgers`
  ADD CONSTRAINT `customer_ledgers_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_prescriptions`
--
ALTER TABLE `customer_prescriptions`
  ADD CONSTRAINT `customer_prescriptions_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_special_rates`
--
ALTER TABLE `customer_special_rates`
  ADD CONSTRAINT `customer_special_rates_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `customer_special_rates_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `expiry_ledger`
--
ALTER TABLE `expiry_ledger`
  ADD CONSTRAINT `expiry_ledger_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expiry_ledger_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `expiry_ledger_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expiry_ledger_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`supplier_id`) ON DELETE SET NULL;

--
-- Constraints for table `godown_expiry`
--
ALTER TABLE `godown_expiry`
  ADD CONSTRAINT `godown_expiry_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `godown_expiry_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`),
  ADD CONSTRAINT `invoices_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `invoices_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `invoices_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `invoice_items`
--
ALTER TABLE `invoice_items`
  ADD CONSTRAINT `invoice_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`invoice_id`),
  ADD CONSTRAINT `invoice_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `items` (`id`);

--
-- Constraints for table `invoice_payments`
--
ALTER TABLE `invoice_payments`
  ADD CONSTRAINT `invoice_payments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `invoice_payments_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`invoice_id`);

--
-- Constraints for table `invoice_settings`
--
ALTER TABLE `invoice_settings`
  ADD CONSTRAINT `invoice_settings_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `invoice_templates`
--
ALTER TABLE `invoice_templates`
  ADD CONSTRAINT `invoice_templates_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pending_orders`
--
ALTER TABLE `pending_orders`
  ADD CONSTRAINT `pending_orders_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pending_orders_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`supplier_id`) ON DELETE CASCADE;

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sales_salesman_id_foreign` FOREIGN KEY (`salesman_id`) REFERENCES `sales_men` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD CONSTRAINT `sale_items_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sale_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `sale_items_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stock_ledgers`
--
ALTER TABLE `stock_ledgers`
  ADD CONSTRAINT `stock_ledgers_batch_id_foreign` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stock_ledgers_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `suppliers_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
