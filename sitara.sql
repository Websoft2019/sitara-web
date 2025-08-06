-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 14, 2024 at 10:47 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sitara`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `appointment_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `appointment_id`, `title`, `amount`, `created_at`, `updated_at`) VALUES
(4, 20, 'Consultation', 20.00, '2024-01-18 12:24:01', '2024-01-18 12:24:01'),
(5, 20, 'COnsultation', 40.00, '2024-01-18 12:24:01', '2024-01-18 12:24:01'),
(6, 19, 'Medicines', 10.00, '2024-01-19 04:20:28', '2024-01-19 04:20:28'),
(7, 19, 'Injections', 0.00, '2024-01-19 04:20:28', '2024-01-19 04:20:28');

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Ishwor Admin', 'admin@admin.com', '2023-05-02 05:51:01', '$2y$10$VdgtChAHEQZwkirlg5EZguWCyU5ortW9iV.MmYkQwJjM7cRd.UpKC', '6tgtCH8aFQ4qGUm6aziGhlsT0NXFQN9L8VVREAmRHMNRRZ3AafBZsMcEPHT3', '2023-05-02 05:51:01', '2023-11-28 22:45:44');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `clinic_id` bigint(20) UNSIGNED NOT NULL,
  `clinic_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `schedule_time_id` bigint(20) UNSIGNED NOT NULL,
  `reschedule_time_id` bigint(20) UNSIGNED DEFAULT NULL,
  `cause` text NOT NULL,
  `status` enum('pending','completed','approved','cancelled','rescheduled') NOT NULL DEFAULT 'pending',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `user_id`, `clinic_id`, `clinic_user_id`, `schedule_time_id`, `reschedule_time_id`, `cause`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(17, 8, 1, 3, 22, NULL, 'sdfsdf', 'approved', NULL, '2023-11-29 22:27:07', '2023-11-29 22:27:07'),
(18, 8, 1, 3, 23, NULL, 'sdfsdf', 'approved', NULL, '2024-01-15 12:22:42', '2024-01-15 12:22:42'),
(19, 8, 1, 3, 24, NULL, 'sfddf', 'completed', NULL, '2024-01-18 12:07:50', '2024-01-19 04:24:45'),
(20, 8, 1, 3, 25, NULL, '3442', 'completed', NULL, '2024-01-18 12:23:18', '2024-01-18 12:24:15');

-- --------------------------------------------------------

--
-- Table structure for table `clinics`
--

CREATE TABLE `clinics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `registration_number` varchar(255) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `contact_person_number` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `postalcode` varchar(255) DEFAULT NULL,
  `openinghour` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `status` enum('active','hidden') NOT NULL DEFAULT 'active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clinics`
--

INSERT INTO `clinics` (`id`, `name`, `slug`, `logo`, `description`, `registration_number`, `contact_person`, `contact_person_number`, `number`, `address`, `city`, `state`, `postalcode`, `openinghour`, `longitude`, `latitude`, `email`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Fewa City Hospital', 'fewa-city-hospital', NULL, 'sdfsdfsdf', 'Fewa City Hospital', 'Dr. ishwor raj Chalise', '34234234', '34234234', 'Simpang Ampat, Penang, Malaysia', NULL, NULL, NULL, NULL, 'sdfsdf', 'dsfdfdsfsdfsd', 'ishworchalise@gmail.com', 'active', NULL, '2023-09-18 00:11:43', '2023-09-18 00:11:43');

-- --------------------------------------------------------


-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `clinic_schedules` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `clinic_id` bigint UNSIGNED NOT NULL,
  `week` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `open` time DEFAULT NULL,
  `close` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `clinic_schedules_clinic_id_foreign` (`clinic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;
-- --------------------------------------------------------


--
-- Table structure for table `clinic_users`
--

CREATE TABLE `clinic_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `clinic_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `specialities` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `status` enum('active','hidden') NOT NULL DEFAULT 'active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','doctor') NOT NULL DEFAULT 'admin',
  `is_first_login` enum('yes','no') NOT NULL DEFAULT 'yes',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clinic_users`
--

INSERT INTO `clinic_users` (`id`, `clinic_id`, `name`, `specialities`, `email`, `image`, `description`, `email_verified_at`, `password`, `remember_token`, `status`, `deleted_at`, `role`, `is_first_login`, `created_at`, `updated_at`) VALUES
(2, 1, 'Fewa City Hospital1111', 'sdjfsd fjksdf111', 'ishworchalise@gmail.com', NULL, '12345111', '2024-01-15 11:45:58', '$2y$10$Sw3N4goiDjE.bgTa4mB3XuLUSGDIixJ0E5CJysxLjs7w1exBPzBbK', NULL, 'active', NULL, 'admin', 'yes', '2023-09-18 00:11:43', '2024-01-15 12:05:37'),
(3, 1, 'Dr. Jyoti', 'sdfkjhsdf', 'jyotichalise@gmail.com', NULL, 'sdfsdfa', NULL, '$2y$10$SWK7/rAKuYNRsmW6eIzQIuyp663NjaAcmQhcGnn7DVF0qZXYUF7UG', NULL, 'active', NULL, 'doctor', 'yes', '2023-11-29 22:26:30', '2023-11-29 22:26:30');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `commission` decimal(8,2) NOT NULL,
  `registration_number` varchar(255) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `contact_person_number` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('active','hidden') NOT NULL DEFAULT 'active',
  `is_first_login` enum('yes','no') NOT NULL DEFAULT 'yes',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `slug`, `logo`, `description`, `commission`, `registration_number`, `contact_person`, `contact_person_number`, `number`, `address`, `longitude`, `latitude`, `email`, `email_verified_at`, `password`, `status`, `is_first_login`, `deleted_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Websoft Technology Nepal111', 'websoft-technology-nepal', '97db91550f1c928090fbd31523edb24fba6024b2.jpg', '111', 10.00, '4234234', 'Suju Devkota111', '34234111', '34234111', 'Simpang Ampat, Penang, Malaysia111', 'dsfsdf111', 'sdfds111', 'websoft.pokhara@gmail.com', '2024-01-15 11:22:40', '$2y$10$VIG.4S0cISsxgDLF4pmS6uC5mcYH99v7Ilf/NZsVRlkqNwewqpVV2', 'active', 'yes', NULL, NULL, '2023-09-18 00:10:49', '2024-01-15 11:28:15'),
(2, 'sdfkjsadjkfsdf', 'sdfkjsadjkfsdf', NULL, '234234', 20.00, 'sjdfn', 'sdfsndjkf', '234234', '23423', 'skdjfjsdkf', 'sdjkfnks', 'jksdf', 'sdfsdf@sdfsdf.com', '2023-11-28 22:44:07', '$2y$10$ou3Igxo49Vvxz1IDsNs5lesNt4kzXEqW2gFcQzleageV9lb.1OQdG', 'active', 'yes', NULL, NULL, '2023-11-28 22:44:07', '2023-11-28 22:44:07');

-- --------------------------------------------------------

--
-- Table structure for table `company_clinics`
--

CREATE TABLE `company_clinics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `clinic_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `refer_code` varchar(10) NOT NULL,
  `status` enum('active','hidden') NOT NULL DEFAULT 'active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `request_company_id` bigint(20) DEFAULT NULL,
  `request_clinic_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_clinics`
--

INSERT INTO `company_clinics` (`id`, `clinic_id`, `company_id`, `refer_code`, `status`, `deleted_at`, `created_at`, `updated_at`, `request_company_id`, `request_clinic_id`) VALUES
(40, 1, NULL, 'TAHm8kSuii', 'active', '2024-01-18 12:22:01', '2023-09-18 00:13:43', '2024-01-18 12:22:01', 1, 1),
(41, NULL, NULL, 'EPL2mdMcfK', 'active', '2024-01-18 12:12:53', '2023-09-18 00:16:39', '2024-01-18 12:12:53', 1, 1),
(42, 1, 1, 'CrOehsKdR1', 'active', NULL, '2024-01-18 12:21:01', '2024-01-18 12:22:13', 1, NULL),
(43, NULL, 1, 'EQyzKGfkeR', 'active', NULL, '2024-01-19 05:01:47', '2024-01-19 05:01:47', 1, NULL);

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
(1, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_04_30_091916_create_admins_table', 1),
(6, '2023_04_30_134408_create_companies_table', 1),
(7, '2023_04_30_134409_create_users_table', 1),
(8, '2023_04_30_153607_create_clinics_table', 1),
(9, '2023_05_01_055410_create_clinic_users_table', 1),
(10, '2023_05_03_141400_create_company_clinics_table', 2),
(11, '2016_06_01_000001_create_oauth_auth_codes_table', 3),
(12, '2016_06_01_000002_create_oauth_access_tokens_table', 3),
(13, '2016_06_01_000003_create_oauth_refresh_tokens_table', 3),
(14, '2016_06_01_000004_create_oauth_clients_table', 3),
(15, '2016_06_01_000005_create_oauth_personal_access_clients_table', 3),
(16, '2023_05_05_070238_create_schedule_dates_table', 3),
(17, '2023_05_05_070827_create_schedule_times_table', 3),
(18, '2023_05_05_071821_create_appointments_table', 3),
(21, '2023_05_12_160822_create_accounts_table', 4),
(22, '2023_05_12_161031_create_payments_table', 4),
(23, '2023_05_05_074528_create_reports_table', 5),
(24, '2023_09_15_035654_create_registrationrequests_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('sdfsdf@sdfsdf.com', '$2y$10$iGVeazRd/9Y9aIur0NMyauQ9CRVb206NiD3CJSgkqIMfrng.2ZEY2', '2024-01-15 06:24:28');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('ishworchalise@gmail.com', '$2y$10$6uSQ/9s8UM8EVF0TPMXRrO/KIH60i.V4UPkfHSNlhUlJacHVG8SzO', '2024-01-15 06:28:54');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `appointment_id` bigint(20) UNSIGNED NOT NULL,
  `total_amount` decimal(8,2) NOT NULL,
  `company_claim_amount` decimal(8,2) NOT NULL,
  `paid_amount` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `appointment_id`, `total_amount`, `company_claim_amount`, `paid_amount`, `created_at`, `updated_at`) VALUES
(2, 20, 60.00, 60.00, 0.00, '2024-01-18 12:24:15', '2024-01-18 12:24:15');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registrationrequests`
--

CREATE TABLE `registrationrequests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('company','clinic') NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `registration_number` varchar(255) DEFAULT NULL,
  `contactperson` varchar(255) NOT NULL,
  `contact_person_number` varchar(255) NOT NULL,
  `company_contact_number` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `postalcode` varchar(255) NOT NULL,
  `openinghour` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `status` enum('A','P') NOT NULL DEFAULT 'P',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `registrationrequests`
--

INSERT INTO `registrationrequests` (`id`, `type`, `name`, `address`, `registration_number`, `contactperson`, `contact_person_number`, `company_contact_number`, `city`, `state`, `postalcode`, `openinghour`, `email`, `status`, `created_at`, `updated_at`) VALUES
(14, 'company', 'Websoft Technology Nepal', 'Srijana Chowk, Pokhara-8', '3745y3485', '345345', '8345738453', '8345738453', 'Pokhara', 'Gandaki', '33700', NULL, 'websoft.pokhara@gmail.com', 'P', '2023-09-17 01:33:48', '2023-09-17 01:33:48'),
(15, 'clinic', 'Fewa City Hospital', 'Simpang Ampat, Penang, Malaysia', '345345', 'Dr. ishwor raj Chalise', '345345345', '345345345', 'Pokhara', 'Gandaki', '33700', '24 Hrs', 'ishworchalise@gmail.com', 'A', '2023-09-17 01:34:27', '2023-09-17 01:36:41'),
(16, 'company', 'Websoft Technology Nepal', 'Simpang Ampat, Penang, Malaysia', '4234234', 'Suju Devkota', '34234', '34234', 'pokhara', 'Gandaki', '33700', NULL, 'websoft.pokhara@gmail.com', 'P', '2023-09-18 00:09:02', '2023-09-18 00:09:02'),
(17, 'clinic', 'Fewa City Hospital', 'Simpang Ampat, Penang, Malaysia', '345345345', 'Dr. ishwor raj Chalise', '34234234', '34234234', 'Pokhara', 'Gandaki', '33700', '2hrs', 'ishworchalise@gmail.com', 'A', '2023-09-18 00:09:39', '2023-09-18 00:11:43');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `report_name` varchar(255) NOT NULL,
  `appointment_id` bigint(20) UNSIGNED NOT NULL,
  `prescription` longtext DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `medical_leave` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `report_name`, `appointment_id`, `prescription`, `file_name`, `medical_leave`, `deleted_at`, `created_at`, `updated_at`) VALUES
(6, 'asdasdasd', 20, NULL, 'asdasdasd02da90ec8b2042e7e70e4ad7a350d069d.jpeg', NULL, NULL, '2024-01-18 12:44:59', '2024-01-18 12:44:59'),
(7, 'jsdhhjasda', 20, NULL, 'jsdhhjasda12da90ec8b2042e7e70e4ad7a350d069d.jpeg', NULL, NULL, '2024-01-18 12:44:59', '2024-01-18 12:44:59'),
(8, 'prescription', 20, '<div class=\"row\">\r\n<div class=\"col-sm-6\">\r\n<div class=\"biller-info\">\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td><img alt=\"\" src=\"http://localhost:8000/site/uploads/clinic\" style=\"width:100px\" /><br />\r\n			<strong>Fewa City Hospital</strong><br />\r\n			Simpang Ampat, Penang, Malaysia<br />\r\n			Phone no : 34234234<br />\r\n			Email Address: ishworchalise@gmail.com</td>\r\n			<td style=\"text-align:right\">\r\n			<p><strong>Fewa City Hospital1111</strong><br />\r\n			Registration No . 324323434<br />\r\n			<br />\r\n			Appointment Date : 2024-01-18 00:00:00 | 02:53:00<br />\r\n			Appointment ID : #20<br />\r\n			Checkup Date/Time : 18 Jan, 2024 18:29</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td>Patient Name : ishwor raj chalise, 39 Year, male<br />\r\n			Employee ID : #1-12123123<br />\r\n			Cause : 3442</td>\r\n			<td style=\"text-align:right\">Company Name : Websoft Technology Nepal111<br />\r\n			Company Address : Simpang Ampat, Penang, Malaysia111</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>Diagnose :</p>\r\n\r\n<p>Remarks :</p>\r\n\r\n<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td>Medicine</td>\r\n			<td>Dosage</td>\r\n			<td>Qty</td>\r\n			<td>Duration</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>Procedures/additional test:</p>\r\n</div>\r\n</div>\r\n</div>', 'prescription1705602718.pdf', '13-16 Jan 2024 (3 days)', NULL, '2024-01-18 12:46:58', '2024-01-18 12:46:58'),
(9, 'prescription', 19, '<div class=\"row\">\r\n<div class=\"col-sm-6\">\r\n<div class=\"biller-info\">\r\n<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td><img alt=\"\" src=\"http://localhost:8000/site/uploads/clinic\" style=\"width:100px\" /><br />\r\n			<strong>Fewa City Hospital</strong><br />\r\n			Simpang Ampat, Penang, Malaysia<br />\r\n			Phone no : 34234234<br />\r\n			Email Address: ishworchalise@gmail.com</td>\r\n			<td style=\"text-align:right\">\r\n			<p><strong>Fewa City Hospital1111</strong><br />\r\n			Registration No . 324323434<br />\r\n			<br />\r\n			Appointment Date : 2024-01-19 00:00:00 | 02:37:00<br />\r\n			Appointment ID : #19<br />\r\n			Checkup Date/Time : 19 Jan, 2024 10:08</p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td>Patient Name : ishwor raj chalise, 39 Year, male<br />\r\n			Employee ID : #1-12123123<br />\r\n			Cause : sfddf</td>\r\n			<td style=\"text-align:right\">Company Name : Websoft Technology Nepal111<br />\r\n			Company Address : Simpang Ampat, Penang, Malaysia111</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>Diagnose :</p>\r\n\r\n<p>Remarks :</p>\r\n\r\n<table border=\"1\" cellpadding=\"1\" cellspacing=\"1\" style=\"width:100%\">\r\n	<tbody>\r\n		<tr>\r\n			<td>Medicine</td>\r\n			<td>Dosage</td>\r\n			<td>Qty</td>\r\n			<td>Duration</td>\r\n		</tr>\r\n		<tr>\r\n			<td>sddsf</td>\r\n			<td>sdfsdf</td>\r\n			<td>sdfsdf</td>\r\n			<td>sdfsdf</td>\r\n		</tr>\r\n		<tr>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n			<td>&nbsp;</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n\r\n<p>Procedures/additional test:</p>\r\n</div>\r\n</div>\r\n</div>', 'prescription1705658985.pdf', '13-16 Jan 2024 (3 days)', NULL, '2024-01-19 04:24:45', '2024-01-19 04:24:45');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_dates`
--

CREATE TABLE `schedule_dates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `clinic_id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schedule_dates`
--

INSERT INTO `schedule_dates` (`id`, `clinic_id`, `date`, `created_at`, `updated_at`) VALUES
(14, 1, '2023-11-30', '2023-11-29 22:27:07', '2023-11-29 22:27:07'),
(15, 1, '2024-01-16', '2024-01-15 12:22:42', '2024-01-15 12:22:42'),
(16, 1, '2024-01-19', '2024-01-18 12:07:50', '2024-01-18 12:07:50'),
(17, 1, '2024-01-18', '2024-01-18 12:23:18', '2024-01-18 12:23:18');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_times`
--

CREATE TABLE `schedule_times` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `schedule_date_id` bigint(20) UNSIGNED NOT NULL,
  `time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schedule_times`
--

INSERT INTO `schedule_times` (`id`, `schedule_date_id`, `time`, `created_at`, `updated_at`) VALUES
(22, 14, '13:56:00', '2023-11-29 22:27:07', '2023-11-29 22:27:07'),
(23, 15, '02:52:00', '2024-01-15 12:22:42', '2024-01-15 12:22:42'),
(24, 16, '02:37:00', '2024-01-18 12:07:50', '2024-01-18 12:07:50'),
(25, 17, '02:53:00', '2024-01-18 12:23:18', '2024-01-18 12:23:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `post` varchar(255) DEFAULT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `race` varchar(255) DEFAULT NULL,
  `ic_number` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `per_visit_claim` decimal(8,2) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('active','hidden') NOT NULL DEFAULT 'active',
  `is_first_login` enum('yes','no') NOT NULL DEFAULT 'yes',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `employee_id`, `company_id`, `first_name`, `middle_name`, `last_name`, `image`, `post`, `date_of_birth`, `gender`, `race`, `ic_number`, `phone_number`, `address`, `description`, `per_visit_claim`, `email`, `email_verified_at`, `password`, `status`, `is_first_login`, `deleted_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(8, '1-12123123', 1, 'ishwor', 'raj', 'chalise', NULL, 'Manager', '2023-11-06', 'male', 'sdjfhsdh', '2348723784', '73462374', 'sjdsjdhf', 'skjdnskdjf', 100.00, 'ishworchalise@gmail.com', NULL, '$2y$10$kyWmhdLV.bz33rf0i/aAUu9qFOwpCFzCiWMu24IcX5mbRGzkql41S', 'active', 'yes', '2024-01-19 05:03:20', NULL, '2023-11-28 10:45:52', '2024-01-19 05:03:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `accounts_appointment_id_foreign` (`appointment_id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointments_user_id_foreign` (`user_id`),
  ADD KEY `appointments_clinic_id_foreign` (`clinic_id`),
  ADD KEY `appointments_clinic_user_id_foreign` (`clinic_user_id`),
  ADD KEY `appointments_schedule_time_id_foreign` (`schedule_time_id`),
  ADD KEY `appointments_reschedule_time_id_foreign` (`reschedule_time_id`);

--
-- Indexes for table `clinics`
--
ALTER TABLE `clinics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clinics_slug_unique` (`slug`),
  ADD UNIQUE KEY `clinics_registration_number_unique` (`registration_number`),
  ADD UNIQUE KEY `clinics_number_unique` (`number`),
  ADD UNIQUE KEY `clinics_email_unique` (`email`);

--
-- Indexes for table `clinic_users`
--
ALTER TABLE `clinic_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clinic_users_email_unique` (`email`),
  ADD KEY `clinic_users_clinic_id_foreign` (`clinic_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `companies_slug_unique` (`slug`),
  ADD UNIQUE KEY `companies_registration_number_unique` (`registration_number`),
  ADD UNIQUE KEY `companies_number_unique` (`number`),
  ADD UNIQUE KEY `companies_email_unique` (`email`);

--
-- Indexes for table `company_clinics`
--
ALTER TABLE `company_clinics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `company_clinics_refer_code_unique` (`refer_code`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_appointment_id_foreign` (`appointment_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `registrationrequests`
--
ALTER TABLE `registrationrequests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reports_appointment_id_foreign` (`appointment_id`);

--
-- Indexes for table `schedule_dates`
--
ALTER TABLE `schedule_dates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedule_dates_clinic_id_foreign` (`clinic_id`);

--
-- Indexes for table `schedule_times`
--
ALTER TABLE `schedule_times`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedule_times_schedule_date_id_foreign` (`schedule_date_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_company_id_foreign` (`company_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `clinics`
--
ALTER TABLE `clinics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `clinic_users`
--
ALTER TABLE `clinic_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `company_clinics`
--
ALTER TABLE `company_clinics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registrationrequests`
--
ALTER TABLE `registrationrequests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `schedule_dates`
--
ALTER TABLE `schedule_dates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `schedule_times`
--
ALTER TABLE `schedule_times`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
  ADD CONSTRAINT `accounts_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_clinic_id_foreign` FOREIGN KEY (`clinic_id`) REFERENCES `clinics` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_clinic_user_id_foreign` FOREIGN KEY (`clinic_user_id`) REFERENCES `clinic_users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_reschedule_time_id_foreign` FOREIGN KEY (`reschedule_time_id`) REFERENCES `schedule_times` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_schedule_time_id_foreign` FOREIGN KEY (`schedule_time_id`) REFERENCES `schedule_times` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `clinic_users`
--
ALTER TABLE `clinic_users`
  ADD CONSTRAINT `clinic_users_clinic_id_foreign` FOREIGN KEY (`clinic_id`) REFERENCES `clinics` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `company_clinics`
--
ALTER TABLE `company_clinics`
  ADD CONSTRAINT `company_clinics_clinic_id_foreign` FOREIGN KEY (`clinic_id`) REFERENCES `clinics` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `company_clinics_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `schedule_dates`
--
ALTER TABLE `schedule_dates`
  ADD CONSTRAINT `schedule_dates_clinic_id_foreign` FOREIGN KEY (`clinic_id`) REFERENCES `clinics` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `schedule_times`
--
ALTER TABLE `schedule_times`
  ADD CONSTRAINT `schedule_times_schedule_date_id_foreign` FOREIGN KEY (`schedule_date_id`) REFERENCES `schedule_dates` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
