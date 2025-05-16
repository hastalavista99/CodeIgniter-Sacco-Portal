-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2025 at 07:57 AM
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
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `account_code` varchar(50) NOT NULL,
  `category` enum('asset','liability','equity','income','expense') NOT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `account_name`, `account_code`, `category`, `parent_id`) VALUES
(2, 'Debtors', '200100', 'asset', NULL),
(3, 'Current Bank Account', '200200', 'asset', NULL),
(4, 'Savings Bank Account', '200300', 'asset', NULL),
(5, 'Cash in Hand', '200400', 'asset', NULL),
(6, 'Creditors & Accruals', '300100', 'liability', NULL),
(70, 'Dividend & Interest', '300200', 'liability', NULL),
(71, 'Bank Overdraft', '300300', 'liability', NULL),
(72, 'Taxation', '300400', 'liability', NULL),
(73, 'Share Capital', '500100', 'equity', NULL),
(74, 'Customer Deposits', '300500', 'liability', 3),
(75, 'Entrance Fee', '600120', 'income', NULL),
(76, 'Statutory Reserve', '500400', 'equity', NULL),
(77, 'General Reserve', '500500', 'equity', NULL),
(78, 'Revaluation Account', '500600', 'equity', NULL),
(79, 'Retained Surplus', '500700', 'equity', NULL),
(80, 'Sinking Fund', '500800', 'equity', NULL),
(81, 'Current Year Accruals', '500900', 'equity', NULL),
(82, 'Interest on Loans', '600100', 'income', NULL),
(83, 'Rent Receivable', '600200', 'income', NULL),
(84, 'Interest on Deposits', '600300', 'income', NULL),
(85, 'Other Incomes', '600500', 'income', NULL),
(86, 'Customer Contributions Received', '600600', 'income', NULL),
(87, 'Administration Expenses', '700100', 'expense', NULL),
(88, 'Financial Expenses', '700200', 'expense', NULL),
(89, 'Establishment', '700300', 'expense', NULL),
(90, 'Depreciation', '700400', 'expense', NULL),
(91, 'Interest Charges', '700500', 'expense', NULL),
(92, 'Normal Loan', '110100', 'asset', 3),
(93, 'Loan Application fee', '600110', 'income', 3),
(94, 'Insurance Fees Recovered', '600210', 'income', 3),
(95, 'CRB Charges', '600130', 'income', 3),
(112, 'Salaries & Wages', '700110', 'expense', 3),
(113, 'Rent', '700120', 'expense', 3),
(114, 'Utilities', '700130', 'expense', 3),
(115, 'Software Subscription', '700140', 'expense', 3),
(116, 'Loan Defaults Written Off', '700210', 'expense', 3),
(117, 'Audit & Legal Fees', '700220', 'expense', 3),
(118, 'Travel & Logistics', '700230', 'expense', 3),
(119, 'SACCO Meeting', '700240', 'expense', 3),
(120, 'Loan Insurance Income', '600140', 'income', 3);

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `id` int(11) NOT NULL,
  `agent_no` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `id_number` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`id`, `agent_no`, `name`, `mobile`, `id_number`, `email`, `created_at`) VALUES
(6, '001', 'Kimani', '0742753573', '', 'jack@gmail.com', '2024-07-29 09:13:52'),
(7, '002', 'John', '0742753573', '', 'jack@gmail.com', '2024-07-29 11:16:37'),
(8, '003', 'Johnson', '0744566665', '', 'john@gmail.com', '2024-09-03 06:56:16'),
(9, '004', 'Phillis', '0742753573', '', '', '2024-09-03 08:24:06');

-- --------------------------------------------------------

--
-- Table structure for table `agent_members`
--

CREATE TABLE `agent_members` (
  `id` int(11) NOT NULL,
  `agent_no` varchar(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `balances`
--

CREATE TABLE `balances` (
  `id` int(11) NOT NULL,
  `member_no` varchar(20) NOT NULL,
  `shares` varchar(20) NOT NULL,
  `deposits` varchar(20) NOT NULL,
  `loan` varchar(20) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `beneficiaries`
--

CREATE TABLE `beneficiaries` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `relationship` varchar(100) DEFAULT NULL,
  `is_beneficiary` tinyint(1) NOT NULL DEFAULT 0,
  `entitlement_percentage` decimal(5,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `closed_years`
--

CREATE TABLE `closed_years` (
  `id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `closed_by` int(11) NOT NULL,
  `closed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `commission`
--

CREATE TABLE `commission` (
  `id` int(11) NOT NULL,
  `agent_number` varchar(20) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `amount` varchar(20) NOT NULL,
  `member_phone` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `commission`
--

INSERT INTO `commission` (`id`, `agent_number`, `agent_id`, `amount`, `member_phone`, `date`) VALUES
(1, '001', 6, '300', '2547225222', '2024-08-06 10:59:55'),
(2, '002', 7, '4000', '0742753573', '2024-08-06 11:00:09');

-- --------------------------------------------------------

--
-- Table structure for table `financial_statements`
--

CREATE TABLE `financial_statements` (
  `id` int(11) NOT NULL,
  `type` enum('Income Statement','Balance Sheet','Cash Flow Statement') NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `period` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `interest_types`
--

CREATE TABLE `interest_types` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `interest_types`
--

INSERT INTO `interest_types` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Flat Rate', 'Constant interest for the loan period. Calculated at loan application process', '2025-04-16 08:42:53', '2025-04-16 08:42:53'),
(2, 'Reducing Balance', 'Interest is calculated per month as per the opening balance of the loan for that month', '2025-04-16 08:42:53', '2025-04-16 17:57:11'),
(3, 'Equal Payment & Interest on Declining', 'Interest and loan repayments are constant. ', '2025-05-15 10:49:29', '2025-05-15 10:49:52'),
(4, 'Interest Inclusive Equal Total Payments', 'Loans repay + Interest repayment is a constant', '2025-05-15 11:31:59', '2025-05-15 11:31:59'),
(5, 'Fixed Interest & Repayment – Straight', 'Loan and Interest payment is a constant', '2025-05-15 11:31:59', '2025-05-15 11:31:59');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `due_date` date NOT NULL,
  `status` enum('Pending','Paid','Overdue') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `journal_entries`
--

CREATE TABLE `journal_entries` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL,
  `reference` varchar(100) NOT NULL,
  `created_by` int(11) NOT NULL,
  `posted` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `journal_entry_details`
--

CREATE TABLE `journal_entry_details` (
  `id` int(11) NOT NULL,
  `journal_entry_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `debit` decimal(15,2) DEFAULT 0.00,
  `credit` decimal(15,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `transaction_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan_applications`
--

CREATE TABLE `loan_applications` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `loan_type_id` int(11) NOT NULL,
  `interest_method` varchar(50) DEFAULT NULL,
  `interest_rate` decimal(5,2) DEFAULT NULL,
  `insurance_premium` decimal(5,2) DEFAULT NULL,
  `crb_amount` decimal(10,2) DEFAULT NULL,
  `service_charge` decimal(5,2) DEFAULT NULL,
  `principal` decimal(12,2) DEFAULT NULL,
  `repayment_period` int(11) DEFAULT NULL,
  `request_date` date DEFAULT NULL,
  `total_loan` decimal(12,2) DEFAULT NULL,
  `total_interest` decimal(12,2) DEFAULT NULL,
  `fees` decimal(12,2) DEFAULT NULL,
  `monthly_repayment` decimal(12,2) DEFAULT NULL,
  `disburse_amount` decimal(12,2) DEFAULT NULL,
  `loan_status` enum('approved','rejected','pending') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan_guarantors`
--

CREATE TABLE `loan_guarantors` (
  `id` int(11) NOT NULL,
  `loan_application_id` int(11) NOT NULL,
  `guarantor_member_no` varchar(20) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `amount` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan_repayments`
--

CREATE TABLE `loan_repayments` (
  `id` int(11) NOT NULL,
  `loan_id` int(11) NOT NULL,
  `installment_number` int(11) NOT NULL,
  `due_date` date NOT NULL,
  `amount_due` decimal(10,2) NOT NULL,
  `amount_paid` decimal(10,2) DEFAULT 0.00,
  `payment_date` date DEFAULT NULL,
  `status` enum('pending','paid','overdue') DEFAULT 'pending',
  `payment_method` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loan_types`
--

CREATE TABLE `loan_types` (
  `id` int(11) NOT NULL,
  `loan_name` varchar(100) NOT NULL,
  `service_charge` decimal(5,2) NOT NULL,
  `interest_type_id` int(11) DEFAULT NULL,
  `interest_rate` decimal(5,2) DEFAULT NULL,
  `insurance_premium` decimal(5,2) DEFAULT NULL,
  `crb_amount` decimal(10,2) DEFAULT NULL,
  `min_repayment_period` int(11) DEFAULT NULL,
  `max_repayment_period` int(11) DEFAULT NULL,
  `min_loan_limit` decimal(12,2) DEFAULT NULL,
  `max_loan_limit` decimal(12,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `loan_types`
--

INSERT INTO `loan_types` (`id`, `loan_name`, `service_charge`, `interest_type_id`, `interest_rate`, `insurance_premium`, `crb_amount`, `min_repayment_period`, `max_repayment_period`, `min_loan_limit`, `max_loan_limit`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Normal Loan', 1.00, 2, 1.00, 1.00, 500.00, 1, 36, 1000.00, 1000000.00, 'This is a general purpose loan', '2025-04-16 05:44:49', '2025-04-16 05:44:49');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `member_number` varchar(120) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `join_date` date NOT NULL,
  `gender` varchar(20) NOT NULL,
  `nationality` varchar(100) NOT NULL,
  `marital_status` varchar(20) DEFAULT NULL,
  `id_number` varchar(50) DEFAULT NULL,
  `terms_accepted` tinyint(1) NOT NULL DEFAULT 0,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `alternate_phone` varchar(20) DEFAULT NULL,
  `street_address` varchar(255) NOT NULL,
  `address_line2` varchar(255) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `county` varchar(100) NOT NULL,
  `zip_code` varchar(20) NOT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mobile_payments`
--

CREATE TABLE `mobile_payments` (
  `id` int(11) NOT NULL,
  `TransactionType` varchar(100) NOT NULL,
  `TransID` varchar(100) NOT NULL,
  `TransTime` varchar(100) NOT NULL,
  `TransAmount` varchar(100) NOT NULL,
  `BusinessShortCode` varchar(100) NOT NULL,
  `BillRefNumber` varchar(100) NOT NULL,
  `InvoiceNumber` varchar(100) NOT NULL,
  `OrgAccountBalance` varchar(100) NOT NULL,
  `ThirdPartyTransID` varchar(100) NOT NULL,
  `MSISDN` varchar(100) NOT NULL,
  `FirstName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `mobile_payments`
--

INSERT INTO `mobile_payments` (`id`, `TransactionType`, `TransID`, `TransTime`, `TransAmount`, `BusinessShortCode`, `BillRefNumber`, `InvoiceNumber`, `OrgAccountBalance`, `ThirdPartyTransID`, `MSISDN`, `FirstName`) VALUES
(1, 'Pay Bill', 'SD93M8PEY5', '20240409110859', '1.00', '4115729', 'Jack', '', '21566.00', '', '2547 ***** 573', 'JACKSON');

-- --------------------------------------------------------

--
-- Table structure for table `mofos`
--

CREATE TABLE `mofos` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `pwd` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `time_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `mofos`
--

INSERT INTO `mofos` (`id`, `username`, `pwd`, `email`, `time_created`) VALUES
(1, 'jonjon', '$2y$12$R00MS1372GRmuPcndqaIbuoKuYc58bTsc2LsA8qTD5I', 'jon@gmail.com', '2024-04-25 18:58:17');

-- --------------------------------------------------------

--
-- Table structure for table `organization_profile`
--

CREATE TABLE `organization_profile` (
  `id` int(11) NOT NULL,
  `org_name` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `postal_address` varchar(255) DEFAULT NULL,
  `physical_address` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `organization_profile`
--

INSERT INTO `organization_profile` (`id`, `org_name`, `phone`, `email`, `postal_address`, `physical_address`, `logo`, `updated_at`) VALUES
(1, 'Macrologic Systems & Software Limited', '0742753573', 'githumuj@gmail.com', '00100', 'Kitengela', '1745584522_15ffad1c9635be015025.svg', '2025-04-25 12:35:22');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `test` varchar(50) NOT NULL,
  `name` varchar(20) NOT NULL,
  `amount` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `test`, `name`, `amount`) VALUES
(1, '0373784', 'Jsksfk', '232323'),
(2, 'REG0000001', 'John', '34344'),
(3, 'REG0742000000', 'James', '9000'),
(4, 'REG0742753573', 'Jack', '40000'),
(5, 'REG0712345678', 'Belinda', '900'),
(6, 'REG0723223232', 'Valaria', '2000');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `date` date NOT NULL,
  `method` enum('Cash','Bank Transfer','Mobile Payment') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `savings_accounts`
--

CREATE TABLE `savings_accounts` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `account_number` varchar(20) DEFAULT NULL,
  `account_type` varchar(50) DEFAULT NULL,
  `balance` decimal(10,0) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `share_accounts`
--

CREATE TABLE `share_accounts` (
  `id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `shares_owned` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_parameters`
--

CREATE TABLE `system_parameters` (
  `id` int(11) NOT NULL,
  `param_key` varchar(100) NOT NULL,
  `param_value` text DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `system_parameters`
--

INSERT INTO `system_parameters` (`id`, `param_key`, `param_value`, `description`) VALUES
(4, 'savings_loan_ratio', '3', 'ratio of savings to loan limit'),
(5, 'minimum_guarantors', '3', 'Minimum guarantors'),
(6, 'maximum_loans', '3', 'Maximum loans to guarantee'),
(27, 'allow_member_self_registration', 'false', 'Allow members to register themselves online'),
(28, 'require_approval_for_new_members', 'true', 'New member applications require admin approval'),
(29, 'enable_sms_notifications', 'true', 'Send SMS notifications for transactions'),
(30, 'enable_email_notifications', 'true', 'Send email notifications for transactions'),
(31, 'show_member_balances_on_dashboard', 'true', 'Show member balances on their dashboard'),
(32, 'enable_mobile_money_integration', 'true', 'Integrate with mobile money services'),
(33, 'allow_member_document_upload', 'true', 'Allow members to upload ID, payslips, etc.'),
(34, 'enable_end_of_year_dividends', 'true', 'Enable dividend calculation at year-end'),
(35, 'require_beneficiary_for_registration', 'true', 'Require member to add a beneficiary when registering'),
(36, 'allow_members_to_view_statements_online', 'true', 'Members can view/download their statements'),
(37, 'send_sms_for_savings_deposit', 'true', 'Send SMS when a savings deposit is made'),
(38, 'send_sms_for_loan_repayment', 'true', 'Send SMS when a loan repayment is made'),
(39, 'enable_admin_email_alerts', 'true', 'Send alerts to admin email for key events'),
(40, 'maintenance_mode', 'false', 'Put the system into maintenance mode'),
(41, 'maintenance_message', 'We are upgrading, please check back soon.', 'Custom message to show during maintenance'),
(42, 'allow_member_password_reset', 'true', 'Allow members to reset their passwords'),
(43, 'allow_member_profile_update', 'true', 'Allow members to edit their own profile info'),
(44, 'enforce_unique_member_email', 'true', 'Require unique email address per member'),
(45, 'enable_member_login', 'true', 'Enable or disable member portal login'),
(46, 'show_announcements_on_member_dashboard', 'true', 'Show admin announcements on member dashboard');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bank`
--

CREATE TABLE `tbl_bank` (
  `id` int(11) NOT NULL,
  `transactionReferenceCode` varchar(255) NOT NULL,
  `transactionDate` varchar(255) NOT NULL,
  `totalAmount` varchar(255) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `documentReferenceNumber` varchar(255) NOT NULL,
  `bankCode` varchar(255) NOT NULL,
  `branchCode` varchar(255) NOT NULL,
  `paymentDate` varchar(255) NOT NULL,
  `paymentReferenceCode` varchar(255) NOT NULL,
  `paymentCode` varchar(255) NOT NULL,
  `paymentMode` varchar(255) NOT NULL,
  `paymentAmount` varchar(255) NOT NULL,
  `additionalInfo` text NOT NULL,
  `accountNumber` varchar(255) NOT NULL,
  `accountName` varchar(255) NOT NULL,
  `institutionCode` varchar(255) NOT NULL,
  `institutionName` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_bank`
--

INSERT INTO `tbl_bank` (`id`, `transactionReferenceCode`, `transactionDate`, `totalAmount`, `currency`, `documentReferenceNumber`, `bankCode`, `branchCode`, `paymentDate`, `paymentReferenceCode`, `paymentCode`, `paymentMode`, `paymentAmount`, `additionalInfo`, `accountNumber`, `accountName`, `institutionCode`, `institutionName`, `created_at`) VALUES
(1, 'IB116cd8a1d1b44IDP', '2019-08-28T17:32:02.7460598+03:00', '12', 'KES', 'DOC1234', '45', '01', '2019-08-29', 'PAY1234', 'PC001', 'MPESA', '12', 'Test payment', 'EDA/1140/13', 'John Doe', '2100082', 'Eldoret University', '2025-04-09 16:38:56'),
(2, 'IB116cd8a1d1b44IDP', '2019-08-28T17:32:02.7460598+03:00', '12', 'KES', 'DOC1234', '45', '01', '2019-08-24', 'PAY1234', 'PC001', 'MPESA', '12', 'Test payment', 'EDA/1140/13', 'John Doe', '2100082', 'Eldoret University', '2025-04-11 01:00:26'),
(3, 'SAC001', '2019-08-28T17:32:02.7460598+03:00', '12000', 'KES', 'SAC001', '00011', '00011001', '2019-08-28T17:32:02.7460598+03:00', '', '', '1', '12000', 'SAC001', 'SAC001', '', '', '', '2025-04-11 01:34:21');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mpesa`
--

CREATE TABLE `tbl_mpesa` (
  `mp_id` int(11) NOT NULL,
  `mp_name` varchar(200) NOT NULL,
  `TransactionType` varchar(50) NOT NULL,
  `TransID` varchar(50) NOT NULL,
  `TransTime` varchar(50) NOT NULL,
  `TransAmount` float(20,0) NOT NULL,
  `ShortCode` varchar(20) NOT NULL,
  `BillRefNumber` varchar(50) NOT NULL,
  `InvoiceNumber` varchar(50) DEFAULT NULL,
  `ThirdPartyTransID` varchar(50) DEFAULT NULL,
  `MSISDN` varchar(50) NOT NULL,
  `mp_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `auth_id` int(11) NOT NULL,
  `exported` varchar(10) NOT NULL,
  `member_no` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_mpesa`
--

INSERT INTO `tbl_mpesa` (`mp_id`, `mp_name`, `TransactionType`, `TransID`, `TransTime`, `TransAmount`, `ShortCode`, `BillRefNumber`, `InvoiceNumber`, `ThirdPartyTransID`, `MSISDN`, `mp_date`, `auth_id`, `exported`, `member_no`) VALUES
(188, 'JACKSON', 'Pay Bill', 'SD93M8PEY5', '20240409110859', 1, '4115729', '0742753573', '', '', '2547 ***** 573', '2024-04-10 13:14:52', 0, '', ''),
(189, 'JACKSON', 'Pay Bill', 'SD93M8PEY5', '20240409110859', 1, '4115729', '0742753573', '', '', '2547 ***** 573', '2024-04-10 13:55:00', 0, '', ''),
(190, 'JACKSON', 'Pay Bill', 'SD93M8PEY5', '20240409110859', 1, '4115729', '0742753573', '', '', '2547 ***** 573', '2024-04-10 15:03:50', 0, '', ''),
(191, 'JACKSON', 'Pay Bill', 'SD93M8PEY5', '20240409110859', 1, '4115729', '0742753573', '', '', '2547 ***** 573', '2024-04-11 06:57:51', 0, '', ''),
(192, 'JACKSON', 'Pay Bill', 'SD93M8PEY5', '20240409110859', 1, '4115729', '0742753573', '', '', '2547 ***** 573', '2024-04-11 06:58:39', 0, '', ''),
(193, 'JACKSON', 'Pay Bill', 'SD93M8PEY5', '20240409110859', 1, '4115729', '0742753573', '', '', '2547 ***** 573', '2024-04-11 06:58:54', 0, '', ''),
(194, 'JACKSON', 'Pay Bill', 'SD93M8PEY5', '20240409110859', 1, '4115729', 'REG0742753573', '', '', '2547 ***** 573', '2024-04-11 07:00:47', 0, '', ''),
(195, 'JACKSON', 'Pay Bill', 'SD93M8PEY5', '20240409110859', 1, '4115729', 'REG0742753573', '', '', '2547 ***** 573', '2024-04-11 07:01:37', 0, '', ''),
(196, 'JACKSON', 'Pay Bill', 'SD93M8PEY5', '20240409110859', 1, '4115729', 'REG0742753573', '', '', '2547 ***** 573', '2024-04-11 07:10:27', 0, '', ''),
(197, 'JACKSON', 'Pay Bill', 'SD93M8PEY5', '20240409110859', 1, '4115729', 'REG0742753573', '', '', '2547 ***** 573', '2024-04-11 07:11:12', 0, '', ''),
(198, 'JACKSON', 'Pay Bill', 'SD93M8PEY5', '20240409110859', 1, '4115729', 'REG0742753573', '', '', '2547 ***** 573', '2024-04-11 07:11:13', 0, '', ''),
(199, 'JACKSON', 'Pay Bill', 'SD93M8PEY5', '20240409110859', 1, '4115729', 'REG0742753573', '', '', '2547 ***** 573', '2024-04-11 07:11:22', 0, '', ''),
(200, 'JACKSON', 'Pay Bill', 'SD93M8PEY5', '20240409110859', 1, '4115729', 'REG0742753579', '', '', '2547 ***** 573', '2024-04-11 07:11:43', 0, '', ''),
(201, 'JACKSON', 'Pay Bill', 'SD93M8PEY5', '20240409110859', 1, '4115729', 'REG0742753579', '', '', '2547 ***** 573', '2024-04-11 07:13:03', 0, '', ''),
(202, 'JACKSON', 'Pay Bill', 'SD93M8PEY5', '20240409110859', 1, '4115729', 'REG0742753579', '', '', '2547 ***** 573', '2024-04-11 07:13:07', 0, '1', ''),
(203, 'JACKSON', 'Pay Bill', 'SD93M8PEY5', '20240409110859', 1, '4115729', 'REG0742753579', '', '', '2547 ***** 573', '2024-04-11 07:13:54', 0, '1', ''),
(204, 'JACKSON ', 'Pay Bill', 'SD93M8PEY5', '20240409110859', 1, '4115729', 'REG0742753578', '', '', '2547 ***** 573', '2024-04-11 07:14:09', 0, '1', '002'),
(205, 'JACKSON', 'Pay Bill', 'SD93M8PEY5', '20240409110859', 1, '4115729', '0742753573', '', '', '2547 ***** 573', '2024-04-23 07:16:33', 0, '', ''),
(206, 'JACKSON', 'Pay Bill', 'SD93M8PEY5', '20240409110859', 1, '4115729', '0742753573', '', '', '2547 ***** 573', '2024-04-23 07:17:07', 0, '1', ''),
(207, 'JACKSON', 'Pay Bill', 'SD93M8PEY5', '20240409110859', 1, '4115729', '0742753573', '', '', '2547 ***** 573', '2024-04-23 07:17:57', 0, '', ''),
(208, 'JACKSON', 'Pay Bill', 'SD93M8PEY5', '20240409110859', 1, '4115729', 'sl30742753573', '', '', '2547 ***** 573', '2024-04-23 07:18:03', 0, '', ''),
(209, 'JACKSON', 'Pay Bill', 'SD93M8PEY5', '20240409110859', 1, '4115729', 'sl20742753573', '', '', '2547 ***** 573', '2024-04-23 07:18:26', 0, '', ''),
(210, 'JACKSON ', 'Pay Bill', 'SD93M8PEY5', '20240409110859', 1, '4115729', 'sl10742753573', '', '', '2547 ***** 573', '2024-04-24 12:36:31', 0, '1', 'ILS001'),
(211, 'JACKSON', 'Pay Bill', 'SD93M8PEY5', '20240409110859', 1, '4115729', 'lon0742753573', '', '', '2547 ***** 573', '2024-04-24 12:37:02', 0, '', ''),
(212, 'JACKSON ', 'Pay Bill', 'SD93M8PEY5', '20240409110859', 1, '4115729', 'ILS089', '', '', '2547 ***** 573', '2024-04-24 12:37:17', 0, '1', '001'),
(213, 'JACKSON KITE', 'Pay Bill', 'SD93M8PEY5', '20240409110859', 1111, '4115729', '0742753573', '', '', '2547 ***** 573', '2024-04-24 12:37:33', 0, '1', ''),
(214, 'JACKSON NJUNG\'E', 'Pay Bill', 'SD93M8PEY5', '20240409110859', 1111, '4115729', 'g0742753573', '', '', '2547 ***** 573', '2024-05-20 10:24:39', 0, '1', ''),
(215, 'JACKSON JOHN', 'Pay Bill', 'SD93M8PEY5', '20240409110859', 1111, '4115729', 'dep0742753573', '', '', '2547 ***** 573', '2024-05-20 10:30:13', 0, '1', ''),
(216, 'KIMANIJackson ', 'Pay Bill', 'SD93M8PEY5', '20240409110859', 1111, '4115729', 'sha0759580403', '', '', '2547 ***** 573', '2024-05-20 10:31:05', 0, '1', 'ILS009');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `member_number` varchar(20) NOT NULL,
  `service_transaction` varchar(50) NOT NULL,
  `transaction_type` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `transaction_date` date NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trial_balance`
--

CREATE TABLE `trial_balance` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `debit` decimal(15,2) DEFAULT 0.00,
  `credit` decimal(15,2) DEFAULT 0.00,
  `period` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `member_no` varchar(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','member','user','agent','accountant','cashier') NOT NULL,
  `permissions` text DEFAULT NULL,
  `temp` varchar(2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user`, `name`, `member_no`, `email`, `mobile`, `password`, `role`, `permissions`, `temp`, `created_at`) VALUES
(1, 'Jackson Githumu', 'Jack', 'ILS089', 'jack@gmail.com', '0742753573', '$2y$10$cnC0OBC4GgNKc2uFvmUgJ.QyuSQuoAZys0vorJm503pOqBKd9x4li', 'admin', '[\"post_journal_entries\",\"approve_loans\",\"edit_member_details\",\"access_system_parameters\",\"view_payments\",\"manage_users\",\"view_reports\",\"create_members\",\"edit_settings\",\"reverse_transactions\"]', '', '2025-05-07 13:30:49');

-- --------------------------------------------------------

--
-- Table structure for table `verify_otp`
--

CREATE TABLE `verify_otp` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `otp` longtext NOT NULL,
  `expiry` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `verify_otp`
--

INSERT INTO `verify_otp` (`id`, `username`, `otp`, `expiry`) VALUES
(16, 'Jack', '$2y$10$QKZK5eIaU/pZLcOvaWGK5.389M5GgcBhrsyHSQGKNVz4P7NbI03uy', '1733990058');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`account_code`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agent_members`
--
ALTER TABLE `agent_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `balances`
--
ALTER TABLE `balances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `beneficiaries`
--
ALTER TABLE `beneficiaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `closed_years`
--
ALTER TABLE `closed_years`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `year` (`year`),
  ADD KEY `closed_by` (`closed_by`);

--
-- Indexes for table `commission`
--
ALTER TABLE `commission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agent_id` (`agent_id`);

--
-- Indexes for table `financial_statements`
--
ALTER TABLE `financial_statements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `interest_types`
--
ALTER TABLE `interest_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journal_entries`
--
ALTER TABLE `journal_entries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journal_entry_details`
--
ALTER TABLE `journal_entry_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `journal_entry_id` (`journal_entry_id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `transaction_id` (`transaction_id`);

--
-- Indexes for table `loan_applications`
--
ALTER TABLE `loan_applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_guarantors`
--
ALTER TABLE `loan_guarantors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_application_id` (`loan_application_id`);

--
-- Indexes for table `loan_repayments`
--
ALTER TABLE `loan_repayments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loan_id` (`loan_id`);

--
-- Indexes for table `loan_types`
--
ALTER TABLE `loan_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_interest_type` (`interest_type_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mobile_payments`
--
ALTER TABLE `mobile_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mofos`
--
ALTER TABLE `mofos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organization_profile`
--
ALTER TABLE `organization_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_id` (`invoice_id`);

--
-- Indexes for table `savings_accounts`
--
ALTER TABLE `savings_accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account_number` (`account_number`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `share_accounts`
--
ALTER TABLE `share_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `system_parameters`
--
ALTER TABLE `system_parameters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `param_key` (`param_key`);

--
-- Indexes for table `tbl_bank`
--
ALTER TABLE `tbl_bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_mpesa`
--
ALTER TABLE `tbl_mpesa`
  ADD PRIMARY KEY (`mp_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trial_balance`
--
ALTER TABLE `trial_balance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `verify_otp`
--
ALTER TABLE `verify_otp`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `agent_members`
--
ALTER TABLE `agent_members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `balances`
--
ALTER TABLE `balances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `beneficiaries`
--
ALTER TABLE `beneficiaries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `closed_years`
--
ALTER TABLE `closed_years`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `commission`
--
ALTER TABLE `commission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `financial_statements`
--
ALTER TABLE `financial_statements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `interest_types`
--
ALTER TABLE `interest_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `journal_entries`
--
ALTER TABLE `journal_entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `journal_entry_details`
--
ALTER TABLE `journal_entry_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_applications`
--
ALTER TABLE `loan_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_guarantors`
--
ALTER TABLE `loan_guarantors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_repayments`
--
ALTER TABLE `loan_repayments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loan_types`
--
ALTER TABLE `loan_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mobile_payments`
--
ALTER TABLE `mobile_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mofos`
--
ALTER TABLE `mofos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `organization_profile`
--
ALTER TABLE `organization_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `savings_accounts`
--
ALTER TABLE `savings_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `share_accounts`
--
ALTER TABLE `share_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_parameters`
--
ALTER TABLE `system_parameters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `tbl_bank`
--
ALTER TABLE `tbl_bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_mpesa`
--
ALTER TABLE `tbl_mpesa`
  MODIFY `mp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=217;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trial_balance`
--
ALTER TABLE `trial_balance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `verify_otp`
--
ALTER TABLE `verify_otp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `accounts` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `beneficiaries`
--
ALTER TABLE `beneficiaries`
  ADD CONSTRAINT `beneficiaries_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `closed_years`
--
ALTER TABLE `closed_years`
  ADD CONSTRAINT `closed_years_ibfk_1` FOREIGN KEY (`closed_by`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `commission`
--
ALTER TABLE `commission`
  ADD CONSTRAINT `commission_ibfk_1` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`);

--
-- Constraints for table `journal_entry_details`
--
ALTER TABLE `journal_entry_details`
  ADD CONSTRAINT `journal_entry_details_ibfk_1` FOREIGN KEY (`journal_entry_id`) REFERENCES `journal_entries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `journal_entry_details_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `journal_entry_details_ibfk_3` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`);

--
-- Constraints for table `loan_guarantors`
--
ALTER TABLE `loan_guarantors`
  ADD CONSTRAINT `loan_guarantors_ibfk_1` FOREIGN KEY (`loan_application_id`) REFERENCES `loan_applications` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `loan_repayments`
--
ALTER TABLE `loan_repayments`
  ADD CONSTRAINT `loan_repayments_ibfk_1` FOREIGN KEY (`loan_id`) REFERENCES `loan_applications` (`id`);

--
-- Constraints for table `loan_types`
--
ALTER TABLE `loan_types`
  ADD CONSTRAINT `fk_interest_type` FOREIGN KEY (`interest_type_id`) REFERENCES `interest_types` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `savings_accounts`
--
ALTER TABLE `savings_accounts`
  ADD CONSTRAINT `savings_accounts_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`),
  ADD CONSTRAINT `savings_accounts_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`);

--
-- Constraints for table `share_accounts`
--
ALTER TABLE `share_accounts`
  ADD CONSTRAINT `share_accounts_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`),
  ADD CONSTRAINT `share_accounts_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`);

--
-- Constraints for table `trial_balance`
--
ALTER TABLE `trial_balance`
  ADD CONSTRAINT `trial_balance_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
