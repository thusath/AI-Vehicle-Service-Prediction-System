-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2026 at 07:20 PM
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
-- Database: `vehicle_service_prediction`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `activity_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(150) DEFAULT NULL,
  `details` varchar(500) DEFAULT NULL,
  `ip_address` varchar(64) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`activity_id`, `user_id`, `action`, `details`, `ip_address`, `created_at`) VALUES
(1, 2, 'User login', '', '::1', '2026-08-17 12:37:33'),
(2, 2, 'User logout', '', '::1', '2026-08-17 12:39:57'),
(3, 1, 'User login', '', '::1', '2026-08-17 12:45:34'),
(4, 1, 'User logout', '', '::1', '2026-08-17 12:50:25'),
(5, 2, 'User login', '', '::1', '2026-08-17 12:50:46'),
(6, 2, 'Prediction created', 'Toyota Axio - Full Service', '::1', '2026-08-17 12:51:46'),
(7, 2, 'Prediction created', 'Toyota Axio - Oil Change', '::1', '2026-08-17 12:52:26'),
(8, 2, 'Prediction created', 'Toyota Prado 150 - Engine Repair', '::1', '2026-08-17 12:54:17'),
(9, 2, 'User logout', '', '::1', '2026-08-17 12:54:35'),
(10, 1, 'User login', '', '::1', '2026-08-17 12:54:57'),
(11, 1, 'User logout', '', '::1', '2026-08-17 13:02:46'),
(12, 2, 'User login', '', '::1', '2026-08-20 10:04:00'),
(13, 2, 'Prediction created', 'Toyota Prado 150 - Oil Change', '::1', '2026-08-20 10:40:57'),
(14, 2, 'Prediction created', 'Honda Civic - Oil Change', '::1', '2026-08-20 10:45:08'),
(15, 2, 'Prediction created', 'Mercedes-Benz C200 - Oil Change', '::1', '2026-08-20 10:47:03'),
(16, 2, 'Prediction created', 'Toyota Axio - Oil Change', '::1', '2026-08-20 10:48:32'),
(17, 2, 'Prediction created', 'Toyota Axio - Oil Change', '::1', '2026-08-20 10:48:42'),
(18, 2, 'Prediction created', 'BMW 520D - Oil Change', '::1', '2026-08-20 10:49:57'),
(19, 2, 'Prediction created', 'Mercedes-Benz C200 - Full Service', '::1', '2026-08-20 10:51:57'),
(20, 2, 'User logout', '', '::1', '2026-08-20 11:25:43'),
(21, 1, 'User login', '', '::1', '2026-08-20 11:25:51'),
(22, 1, 'User logout', '', '::1', '2026-08-20 18:19:57'),
(23, 2, 'User login', '', '::1', '2026-08-20 18:49:13'),
(24, 2, 'User login', '', '::1', '2026-08-20 18:51:54'),
(25, 2, 'User logout', '', '::1', '2026-08-20 18:52:51'),
(26, 1, 'User login', '', '::1', '2026-08-20 18:55:02'),
(27, 1, 'User login', '', '::1', '2026-08-20 18:55:49'),
(28, 1, 'User logout', '', '::1', '2026-08-20 19:00:21'),
(29, 1, 'User login', '', '::1', '2026-08-20 19:03:30'),
(30, 1, 'User logout', '', '::1', '2026-08-20 19:04:08'),
(31, 1, 'User login', '', '::1', '2026-08-20 19:05:22'),
(32, 1, 'User logout', '', '::1', '2026-08-20 19:06:40'),
(33, 2, 'User login', '', '::1', '2026-08-20 19:06:58'),
(34, 2, 'User logout', '', '::1', '2026-08-20 19:07:07'),
(35, 2, 'User login', '', '::1', '2026-08-20 19:08:12'),
(36, 2, 'User logout', '', '::1', '2026-08-20 19:08:24'),
(37, 2, 'User login', '', '::1', '2026-08-20 19:08:43'),
(38, 2, 'User logout', '', '::1', '2026-08-20 19:09:09'),
(39, 2, 'User login', '', '::1', '2026-08-20 19:55:03'),
(40, 2, 'User login', '', '::1', '2026-08-20 19:55:45'),
(41, 2, 'User logout', '', '::1', '2026-08-21 06:50:18'),
(42, 2, 'User login', '', '::1', '2026-08-21 07:03:51'),
(43, 2, 'User logout', '', '::1', '2026-08-21 07:05:41'),
(44, 1, 'User login', '', '::1', '2026-08-21 07:05:48'),
(45, 1, 'User logout', '', '::1', '2026-08-21 07:06:31'),
(46, 2, 'User login', '', '::1', '2026-08-21 07:06:45'),
(47, 2, 'User logout', '', '::1', '2026-08-21 07:06:52'),
(48, 1, 'User login', '', '::1', '2026-08-21 07:06:59'),
(49, 1, 'User logout', '', '::1', '2026-08-21 07:07:40'),
(50, 2, 'User login', '', '::1', '2026-08-21 07:07:53'),
(51, 2, 'User logout', '', '::1', '2026-08-21 07:17:03'),
(52, 1, 'User login', '', '::1', '2026-08-21 07:41:11'),
(53, 1, 'User logout', '', '::1', '2026-08-21 17:27:39'),
(54, 2, 'User login', '', '::1', '2026-08-21 17:27:51'),
(55, 2, 'Prediction created', 'Nissan Magnite - Full Service', '::1', '2026-08-21 17:31:25'),
(56, 2, 'User logout', '', '::1', '2026-08-21 17:57:00'),
(57, 1, 'User login', '', '::1', '2026-08-21 17:57:10'),
(58, 1, 'User logout', '', '::1', '2026-08-21 18:03:05'),
(59, 2, 'User login', '', '::1', '2026-08-21 18:03:17'),
(60, 2, 'User logout', '', '::1', '2026-08-21 18:28:38'),
(61, 1, 'User login', '', '::1', '2026-08-21 18:29:53'),
(62, 1, 'User logout', '', '::1', '2026-08-21 18:38:39'),
(63, 2, 'User login', '', '::1', '2026-08-21 18:39:01'),
(64, 2, 'User logout', '', '::1', '2026-08-21 18:39:50'),
(65, 1, 'User login', '', '::1', '2026-08-21 18:39:59'),
(66, 1, 'User logout', '', '::1', '2026-08-21 19:29:23'),
(67, 2, 'User login', '', '::1', '2026-08-21 19:30:20'),
(68, 2, 'User logout', '', '::1', '2026-08-21 19:35:39'),
(69, 2, 'User login', '', '::1', '2026-08-22 07:18:00'),
(70, 2, 'User logout', '', '::1', '2026-08-22 07:20:00'),
(71, 3, 'User login', '', '::1', '2026-08-22 07:20:19'),
(72, 2, 'User login', '', '::1', '2026-08-22 07:24:09'),
(73, 2, 'User logout', '', '::1', '2026-08-22 08:58:44'),
(74, 1, 'User login', '', '::1', '2026-08-22 08:58:53'),
(75, 1, 'User logout', '', '::1', '2026-08-22 10:06:49'),
(76, 2, 'User login', '', '::1', '2026-08-22 10:07:13'),
(77, 2, 'User logout', '', '::1', '2026-08-22 10:11:20'),
(78, 1, 'User login', '', '::1', '2026-08-22 10:11:28'),
(79, 1, 'User logout', '', '::1', '2026-08-22 11:26:30'),
(80, 3, 'User login', '', '::1', '2026-08-22 11:26:57'),
(81, 3, 'User logout', '', '::1', '2026-08-22 11:28:03'),
(82, 1, 'User login', '', '::1', '2026-08-22 11:36:07'),
(83, 2, 'User login', '', '::1', '2026-10-13 14:48:08'),
(84, 2, 'Prediction created', 'Honda Civic - Full Service', '::1', '2026-10-13 17:43:33'),
(85, 2, 'User logout', '', '::1', '2026-10-13 17:44:37'),
(86, 1, 'User login', '', '::1', '2026-10-13 17:46:55'),
(87, 1, 'User logout', '', '::1', '2026-10-13 17:47:17'),
(88, 2, 'User login', '', '::1', '2026-10-13 17:47:26'),
(89, 2, 'User logout', '', '::1', '2026-10-13 17:47:28'),
(90, 2, 'User login', '', '::1', '2026-10-14 06:00:21'),
(91, 2, 'Prediction created', 'Kia Sorento - Full Service', '::1', '2026-10-14 07:37:29'),
(92, 2, 'User logout', '', '::1', '2026-10-14 08:44:13'),
(93, 2, 'User login', '', '::1', '2026-10-14 08:44:29'),
(94, 2, 'Prediction created', 'Toyota Axio - Full Service', '::1', '2026-10-14 08:47:01'),
(95, 2, 'User logout', '', '::1', '2026-10-14 08:47:10'),
(96, 1, 'User login', '', '::1', '2026-10-14 08:47:19'),
(97, 2, 'User login', '', '::1', '2026-11-15 09:37:18');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `message_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `email` varchar(190) DEFAULT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('pending','replied') DEFAULT 'pending',
  `reply` text DEFAULT NULL,
  `replied_by` int(11) DEFAULT NULL,
  `replied_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`message_id`, `user_id`, `name`, `email`, `subject`, `message`, `status`, `reply`, `replied_by`, `replied_at`, `created_at`) VALUES
(1, 3, 'Dilhani Godakanda', 'dilhani.medruhuna@gmail.com', 'Vehicle Service Prediction Question', 'I would like more information about my service prediction.', 'replied', 'Thank you for contacting us. Your request has been reviewed.', 1, '2026-08-22 17:06:59', '2026-08-22 11:27:50');

-- --------------------------------------------------------

--
-- Table structure for table `dataset_uploads`
--

CREATE TABLE `dataset_uploads` (
  `upload_id` int(11) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(500) DEFAULT NULL,
  `record_count` int(11) DEFAULT NULL,
  `version` varchar(80) DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 1,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dataset_uploads`
--

INSERT INTO `dataset_uploads` (`upload_id`, `file_name`, `file_path`, `record_count`, `version`, `uploaded_by`, `is_active`, `uploaded_at`) VALUES
(1, 'car_service_prediction_dataset_3500.csv', 'uploads/datasets/car_service_prediction_dataset_3500.csv', 3500, 'DS-2026-INITIAL', 1, 0, '2026-08-17 12:36:42'),
(2, '20260822_002914_car_service_prediction_dataset_srilanka_2026_recalibrated.csv', 'uploads/datasets/20260822_002914_car_service_prediction_dataset_srilanka_2026_recalibrated.csv', 3499, 'DS-20260822-002914', 1, 1, '2026-08-21 18:59:14');

-- --------------------------------------------------------

--
-- Table structure for table `favorite_vehicles`
--

CREATE TABLE `favorite_vehicles` (
  `favorite_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `attempt_id` bigint(20) NOT NULL,
  `email` varchar(190) DEFAULT NULL,
  `ip_address` varchar(64) DEFAULT NULL,
  `success` tinyint(4) DEFAULT 0,
  `attempted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`attempt_id`, `email`, `ip_address`, `success`, `attempted_at`) VALUES
(1, 'thusathkarunrathna@gmail.com', '::1', 1, '2026-08-17 12:37:33'),
(2, 'admin@vehicleai.lk', '::1', 0, '2026-08-17 12:40:46'),
(3, 'admin@vehicleai.lk', '::1', 0, '2026-08-17 12:43:16'),
(4, 'admin@vehicleai.lk', '::1', 1, '2026-08-17 12:45:34'),
(5, 'thusathkarunrathna@gmail.com', '::1', 0, '2026-08-17 12:50:38'),
(6, 'thusathkarunrathna@gmail.com', '::1', 1, '2026-08-17 12:50:46'),
(7, 'admin@vehicleai.lk', '::1', 1, '2026-08-17 12:54:57'),
(8, 'thusathkarunrathna@gmail.com', '::1', 0, '2026-08-20 10:02:36'),
(9, 'thusathkarunrathna@gmail.com', '::1', 0, '2026-08-20 10:02:49'),
(10, 'thusathkarunrathna@gmail.com', '::1', 1, '2026-08-20 10:04:00'),
(11, 'admin@vehicleai.lk', '::1', 1, '2026-08-20 11:25:51'),
(12, 'thusathkarunrathna@gmail.com', '::1', 0, '2026-08-20 18:49:04'),
(13, 'thusathkarunrathna@gmail.com', '::1', 1, '2026-08-20 18:49:13'),
(14, 'thusathkarunrathna@gmail.com', '::1', 1, '2026-08-20 18:51:54'),
(15, 'admin@vehicleai.lk', '::1', 1, '2026-08-20 18:55:02'),
(16, 'admin@vehicleai.lk', '::1', 1, '2026-08-20 18:55:49'),
(17, 'thusathkarunrathna@gmail.com', '::1', 0, '2026-08-20 18:58:46'),
(18, 'nisabhachagika@gmail.com', '::1', 0, '2026-08-20 18:59:23'),
(19, 'nisabhachagika@gmail.com', '::1', 0, '2026-08-20 19:00:14'),
(20, 'admin@vehicleai.lk', '::1', 1, '2026-08-20 19:03:30'),
(21, 'dilhani.medruhuna@gmail.com', '::1', 1, '2026-08-20 19:04:44'),
(22, 'admin@vehicleai.lk', '::1', 1, '2026-08-20 19:05:22'),
(23, 'thusathkarunrathna@gmail.com', '::1', 1, '2026-08-20 19:06:58'),
(24, 'thusathkarunrathna@gmail.com', '::1', 1, '2026-08-20 19:08:12'),
(25, 'thusathkarunrathna@gmail.com', '::1', 1, '2026-08-20 19:08:43'),
(26, 'thusathkarunrathna@gmail.com', '::1', 1, '2026-08-20 19:55:03'),
(27, 'thusathkarunrathna@gmail.com', '::1', 1, '2026-08-20 19:55:45'),
(28, 'thusathkarunrathna@gmail.com', '::1', 1, '2026-08-21 07:03:51'),
(29, 'admin@vehicleai.lk', '::1', 1, '2026-08-21 07:05:48'),
(30, 'thusathkarunrathna@gmail.com', '::1', 1, '2026-08-21 07:06:45'),
(31, 'admin@vehicleai.lk', '::1', 1, '2026-08-21 07:06:59'),
(32, 'thusathkarunrathna@gmail.com', '::1', 1, '2026-08-21 07:07:53'),
(33, 'admin@vehicleai.lk', '::1', 1, '2026-08-21 07:41:11'),
(34, 'thusathkarunrathna@gmail.com', '::1', 1, '2026-08-21 17:27:51'),
(35, 'admin@vehicleai.lk', '::1', 1, '2026-08-21 17:57:10'),
(36, 'thusathkarunrathna@gmail.com', '::1', 1, '2026-08-21 18:03:17'),
(37, 'admin@vehicleai.lk', '::1', 1, '2026-08-21 18:29:53'),
(38, 'thusathkarunrathna@gmail.com', '::1', 1, '2026-08-21 18:39:01'),
(39, 'admin@vehicleai.lk', '::1', 1, '2026-08-21 18:39:59'),
(40, 'thusathkarunrathna@gmail.com', '::1', 1, '2026-08-21 19:30:20'),
(41, 'thusathkarunrathna@gmail.com', '::1', 0, '2026-08-22 07:17:09'),
(42, 'thusathkarunrathna@gmail.com', '::1', 0, '2026-08-22 07:17:14'),
(43, 'thusathkarunrathna@gmail.com', '::1', 1, '2026-08-22 07:18:00'),
(44, 'dilhani.medruhuna@gmail.com', '::1', 1, '2026-08-22 07:20:19'),
(45, 'thusathkarunrathna@gmail.com', '::1', 1, '2026-08-22 07:24:09'),
(46, 'admin@vehicleai.lk', '::1', 1, '2026-08-22 08:58:53'),
(47, 'thusathkarunrathna@gmail.com', '::1', 1, '2026-08-22 10:07:13'),
(48, 'admin@vehicleai.lk', '::1', 1, '2026-08-22 10:11:28'),
(49, 'dilhani.medruhuna@gmail.com', '::1', 1, '2026-08-22 11:26:57'),
(50, 'admin@vehicleai.lk', '::1', 1, '2026-08-22 11:36:07'),
(51, 'nisabha.2023@gmail.com', '::1', 0, '2026-10-13 14:46:47'),
(52, 'thusathkarunrathna@gmail.com', '::1', 0, '2026-10-13 14:46:57'),
(53, 'thusathkarunrathna@gmail.com', '::1', 0, '2026-10-13 14:47:36'),
(54, 'thusathkarunrathna@gmail.com', '::1', 1, '2026-10-13 14:48:08'),
(55, 'admin@gmail.com', '::1', 0, '2026-10-13 17:44:48'),
(56, 'admin@gmail.com', '::1', 0, '2026-10-13 17:44:56'),
(57, 'admin@vehicleai.lk', '::1', 1, '2026-10-13 17:46:55'),
(58, 'thusathkarunrathna@gmail.com', '::1', 1, '2026-10-13 17:47:26'),
(59, 'thusathkarunrathna@gmail.com', '::1', 1, '2026-10-14 06:00:21'),
(60, 'thusathkarunrathna@gmail.com', '::1', 1, '2026-10-14 08:44:29'),
(61, 'admin@vehicleai.lk', '::1', 1, '2026-10-14 08:47:19'),
(62, 'nisabha.2023@gmail.com', '::1', 0, '2026-11-08 06:55:39'),
(63, 'nisabha.2023@gmail.com', '::1', 0, '2026-11-15 09:36:58'),
(64, 'thusathkarunrathna@gmail.com', '::1', 0, '2026-11-15 09:37:08'),
(65, 'thusathkarunrathna@gmail.com', '::1', 1, '2026-11-15 09:37:18');

-- --------------------------------------------------------

--
-- Table structure for table `model_metrics`
--

CREATE TABLE `model_metrics` (
  `metric_id` int(11) NOT NULL,
  `cost_r2` decimal(10,6) DEFAULT NULL,
  `cost_mae` decimal(14,2) DEFAULT NULL,
  `cost_rmse` decimal(14,2) DEFAULT NULL,
  `duration_r2` decimal(10,6) DEFAULT NULL,
  `duration_mae` decimal(12,4) DEFAULT NULL,
  `duration_rmse` decimal(12,4) DEFAULT NULL,
  `delay_r2` decimal(10,6) DEFAULT NULL,
  `delay_mae` decimal(12,4) DEFAULT NULL,
  `delay_rmse` decimal(12,4) DEFAULT NULL,
  `dataset_records` int(11) DEFAULT NULL,
  `trained_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_metrics`
--

INSERT INTO `model_metrics` (`metric_id`, `cost_r2`, `cost_mae`, `cost_rmse`, `duration_r2`, `duration_mae`, `duration_rmse`, `delay_r2`, `delay_mae`, `delay_rmse`, `dataset_records`, `trained_at`) VALUES
(1, 0.827146, 29663.71, 62010.21, 0.759087, 1.8817, 2.5877, 0.816301, 7.3144, 9.0445, 3500, '2026-08-17 12:36:42'),
(2, 0.966742, 17927.92, 37174.27, 0.951890, 0.8092, 1.3559, 0.926457, 4.4338, 5.2764, 3499, '2026-08-22 10:12:04');

-- --------------------------------------------------------

--
-- Table structure for table `model_training_log`
--

CREATE TABLE `model_training_log` (
  `training_id` int(11) NOT NULL,
  `trained_by` int(11) DEFAULT NULL,
  `status` varchar(40) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `trained_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_training_log`
--

INSERT INTO `model_training_log` (`training_id`, `trained_by`, `status`, `notes`, `trained_at`) VALUES
(1, 1, 'completed', 'TRAINING_COMPLETED\n{\"dataset_file\": \"20260822_002914_car_service_prediction_dataset_srilanka_2026_recalibrated.csv\", \"records\": 3499, \"cost\": {\"r2\": 0.9667424140889697, \"mae\": 17927.921321892394, \"rmse\": 37174.27297372819}, \"duration\": {\"r2\": 0.9518898657019857, \"mae\": 0.8091738548752837, \"rmse\": 1.35585464717021}, \"delay\": {\"r2\": 0.9264570656162807, \"mae\": 4.43378688852814, \"rmse\": 5.276437675117871}}\nOneHotEncoder(handle_unknown=\"ignore\") enabled.\n', '2026-08-22 10:12:04');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `type` varchar(60) DEFAULT NULL,
  `action_link` varchar(255) DEFAULT NULL,
  `is_read` tinyint(4) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `user_id`, `title`, `message`, `type`, `action_link`, `is_read`, `created_at`) VALUES
(1, 2, 'Prediction Completed', 'Your prediction for Toyota Axio has been completed successfully.', 'prediction', 'prediction_details.php?id=1', 1, '2026-08-17 12:51:46'),
(2, 2, 'Prediction Completed', 'Your prediction for Toyota Axio has been completed successfully.', 'prediction', 'prediction_details.php?id=2', 1, '2026-08-17 12:52:26'),
(3, 2, 'Prediction Completed', 'Your prediction for Toyota Prado 150 has been completed successfully.', 'prediction', 'prediction_details.php?id=3', 1, '2026-08-17 12:54:17'),
(4, 2, 'Prediction Completed', 'Your prediction for Toyota Prado 150 has been completed successfully.', 'prediction', 'prediction_details.php?id=4', 1, '2026-08-20 10:40:57'),
(5, 2, 'Prediction Completed', 'Your prediction for Honda Civic has been completed successfully.', 'prediction', 'prediction_details.php?id=5', 1, '2026-08-20 10:45:08'),
(6, 2, 'Prediction Completed', 'Your prediction for Mercedes-Benz C200 has been completed successfully.', 'prediction', 'prediction_details.php?id=6', 1, '2026-08-20 10:47:03'),
(7, 2, 'Prediction Completed', 'Your prediction for Toyota Axio has been completed successfully.', 'prediction', 'prediction_details.php?id=7', 1, '2026-08-20 10:48:32'),
(8, 2, 'Prediction Completed', 'Your prediction for Toyota Axio has been completed successfully.', 'prediction', 'prediction_details.php?id=8', 1, '2026-08-20 10:48:42'),
(9, 2, 'Prediction Completed', 'Your prediction for BMW 520D has been completed successfully.', 'prediction', 'prediction_details.php?id=9', 1, '2026-08-20 10:49:57'),
(10, 2, 'Prediction Completed', 'Your prediction for Mercedes-Benz C200 has been completed successfully.', 'prediction', 'prediction_details.php?id=10', 1, '2026-08-20 10:51:57'),
(11, 1, 'New Actual Service Feedback', 'Thusath Karunarathna submitted actual service details for Mercedes-Benz C200.', 'feedback', 'admin_feedback.php', 1, '2026-08-21 07:05:37'),
(12, 2, 'Actual Feedback Reply Received', 'Admin has replied to your actual service feedback.', 'feedback_reply', 'notifications.php', 1, '2026-08-21 07:07:21'),
(13, 2, 'Prediction Completed', 'Your prediction for Nissan Magnite has been completed successfully.', 'prediction', 'prediction_details.php?id=11', 0, '2026-08-21 17:31:25'),
(14, 1, 'New Actual Service Feedback', 'Thusath Karunarathna submitted actual service details for Nissan Magnite.', 'feedback', 'admin_feedback.php', 1, '2026-08-21 17:56:28'),
(15, 2, 'Actual Feedback Reply Received', 'Admin has replied to your actual service feedback.', 'feedback_reply', 'notifications.php', 1, '2026-08-21 17:58:02'),
(16, 1, 'New Customer Message', 'Dilhani Godakanda sent a support message.', 'message', 'admin_messages.php', 0, '2026-08-22 11:27:50'),
(17, 3, 'Admin Reply Received', 'Admin has replied to your support message.', 'reply', 'my_messages.php', 0, '2026-08-22 11:36:59'),
(18, 2, 'Prediction Completed', 'Your prediction for Honda Civic has been completed successfully.', 'prediction', 'prediction_details.php?id=12', 0, '2026-10-13 17:43:33'),
(19, 2, 'Prediction Completed', 'Your prediction for Kia Sorento has been completed successfully.', 'prediction', 'prediction_details.php?id=13', 0, '2026-10-14 07:37:29'),
(20, 2, 'Prediction Completed', 'Your prediction for Toyota Axio has been completed successfully.', 'prediction', 'prediction_details.php?id=14', 0, '2026-10-14 08:47:01');

-- --------------------------------------------------------

--
-- Table structure for table `predictions`
--

CREATE TABLE `predictions` (
  `prediction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `vehicle_brand` varchar(80) DEFAULT NULL,
  `vehicle_model` varchar(120) DEFAULT NULL,
  `vehicle_age` int(11) DEFAULT NULL,
  `mileage` int(11) DEFAULT NULL,
  `service_type` varchar(120) DEFAULT NULL,
  `repair_category` varchar(50) DEFAULT NULL,
  `predicted_cost` decimal(14,2) DEFAULT NULL,
  `predicted_duration_hours` decimal(8,2) DEFAULT NULL,
  `predicted_delay_probability` decimal(7,2) DEFAULT NULL,
  `is_deleted_by_user` tinyint(4) DEFAULT 0,
  `is_deleted_by_admin` tinyint(4) DEFAULT 0,
  `prediction_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `predictions`
--

INSERT INTO `predictions` (`prediction_id`, `user_id`, `vehicle_id`, `vehicle_brand`, `vehicle_model`, `vehicle_age`, `mileage`, `service_type`, `repair_category`, `predicted_cost`, `predicted_duration_hours`, `predicted_delay_probability`, `is_deleted_by_user`, `is_deleted_by_admin`, `prediction_date`) VALUES
(1, 2, 1, 'Toyota', 'Axio', 15, 55000, 'Full Service', 'Minor', 96285.00, 2.72, 31.50, 1, 0, '2026-08-17 12:51:46'),
(2, 2, 1, 'Toyota', 'Axio', 7, 55000, 'Oil Change', 'Minor', 48825.00, 1.26, 20.30, 1, 0, '2026-08-17 12:52:26'),
(3, 2, 2, 'Toyota', 'Prado 150', 7, 65000, 'Engine Repair', 'Moderate', 306038.25, 7.96, 30.75, 1, 0, '2026-08-17 12:54:17'),
(4, 2, 3, 'Toyota', 'Prado 150', 7, 55000, 'Oil Change', 'Minor', 48825.00, 1.26, 20.30, 1, 0, '2026-08-20 10:40:57'),
(5, 2, 4, 'Honda', 'Civic', 15, 65000, 'Oil Change', 'Minor', 70455.00, 1.98, 31.95, 1, 0, '2026-08-20 10:45:08'),
(6, 2, 5, 'Mercedes-Benz', 'C200', 1, 15000, 'Oil Change', 'Minor', 46375.00, 1.00, 10.08, 0, 0, '2026-08-20 10:47:03'),
(7, 2, 6, 'Toyota', 'Axio', 14, 65000, 'Oil Change', 'Minor', 67935.00, 1.89, 30.55, 1, 1, '2026-08-20 10:48:32'),
(8, 2, 6, 'Toyota', 'Axio', 7, 65000, 'Oil Change', 'Minor', 50295.00, 1.26, 20.75, 1, 1, '2026-08-20 10:48:42'),
(9, 2, 7, 'BMW', '520D', 23, 85000, 'Oil Change', 'Minor', 155925.00, 2.70, 44.06, 1, 0, '2026-08-20 10:49:57'),
(10, 2, 5, 'Mercedes-Benz', 'C200', 1, 15000, 'Full Service', 'Minor', 91875.00, 1.46, 10.08, 0, 0, '2026-08-20 10:51:57'),
(11, 2, 8, 'Nissan', 'Magnite', 1, 5000, 'Full Service', 'Minor', 53655.00, 1.46, 9.63, 0, 0, '2026-08-21 17:31:25'),
(12, 2, 9, 'Honda', 'Civic', 7, 65000, 'Full Service', 'Minor', 77595.00, 2.00, 20.75, 0, 0, '2026-10-13 17:43:33'),
(13, 2, 10, 'Kia', 'Sorento', 20, 85000, 'Full Service', 'Moderate', 152948.25, 3.65, 49.86, 0, 0, '2026-10-14 07:37:29'),
(14, 2, 11, 'Toyota', 'Axio', 7, 65000, 'Full Service', 'Minor', 77595.00, 2.00, 20.75, 0, 0, '2026-10-14 08:47:01');

-- --------------------------------------------------------

--
-- Table structure for table `service_records`
--

CREATE TABLE `service_records` (
  `record_id` int(11) NOT NULL,
  `prediction_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `actual_cost` decimal(14,2) DEFAULT NULL,
  `actual_duration` decimal(8,2) DEFAULT NULL,
  `accuracy_rating` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `admin_reply` text DEFAULT NULL,
  `status` enum('pending','replied') DEFAULT 'pending',
  `replied_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_records`
--

INSERT INTO `service_records` (`record_id`, `prediction_id`, `user_id`, `actual_cost`, `actual_duration`, `accuracy_rating`, `comment`, `admin_reply`, `status`, `replied_at`, `created_at`) VALUES
(1, 6, 2, 45000.00, 1.20, 5, 'Predictions are excellent', 'Thank you for the feedback.', 'replied', '2026-08-21 12:37:21', '2026-08-21 07:05:37'),
(2, 11, 2, 4500.00, 2.00, 4, 'Predictions are good.', 'Thank you for the feedback.', 'replied', '2026-08-21 23:28:02', '2026-08-21 17:56:28');

-- --------------------------------------------------------

--
-- Table structure for table `system_announcements`
--

CREATE TABLE `system_announcements` (
  `announcement_id` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(190) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer') DEFAULT 'customer',
  `status` enum('active','disabled') DEFAULT 'active',
  `reset_token` varchar(128) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `phone`, `address`, `password`, `role`, `status`, `reset_token`, `reset_expires`, `created_at`) VALUES
(1, 'System Administrator', 'admin@vehicleai.lk', NULL, NULL, '$2y$10$hP9HqCZsWypc2VmFkN6HBuBDGvJDJ4ZfnynptUN1lpM.dwk.WwDOq', 'admin', 'active', NULL, NULL, '2026-08-17 12:36:42'),
(2, 'Thusath Karunarathna', 'thusathkarunrathna@gmail.com', '0775916435', '', '$2y$10$eQuc5Fpl3gAH7izeY3FMRecEDdXSDiFSWffeRiCvFotk.T0HW4PvW', 'customer', 'active', NULL, NULL, '2026-08-17 12:37:19'),
(3, 'Dilhani Godakanda', 'dilhani.medruhuna@gmail.com', '0775916435', NULL, '$2y$10$11Hs3cfMzQ2LPNlsufFFm.M6BOCVJ3PmwyJ/0avYni68W0.uF6WrC', 'customer', 'active', 'a98e3e23474f3a147b402409b1b18409a1de32f37fe62c07b15557b43b6a3500', '2026-08-21 01:49:42', '2026-08-20 18:27:34');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `vehicle_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vehicle_number` varchar(60) DEFAULT NULL,
  `plate_prefix` varchar(20) DEFAULT NULL,
  `plate_number` varchar(20) DEFAULT NULL,
  `vehicle_type` varchar(30) DEFAULT 'Car',
  `vehicle_brand` varchar(80) DEFAULT NULL,
  `vehicle_model` varchar(120) DEFAULT NULL,
  `manufacture_year` int(11) DEFAULT NULL,
  `mileage` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`vehicle_id`, `user_id`, `vehicle_number`, `plate_prefix`, `plate_number`, `vehicle_type`, `vehicle_brand`, `vehicle_model`, `manufacture_year`, `mileage`, `created_at`) VALUES
(1, 2, 'CBI-9218', 'CBI', '9218', 'Car', 'Toyota', 'Axio', 2019, 55000, '2026-08-17 12:51:46'),
(2, 2, 'CBN-6987', 'CBN', '6987', 'Car', 'Toyota', 'Prado 150', 2019, 65000, '2026-08-17 12:54:17'),
(3, 2, 'CBS-8532', 'CBS', '8532', 'Car', 'Toyota', 'Prado 150', 2019, 55000, '2026-08-20 10:40:57'),
(4, 2, 'CBM-8888', 'CBM', '8888', 'Car', 'Honda', 'Civic', 2011, 65000, '2026-08-20 10:45:08'),
(5, 2, 'CCC-8888', 'CCC', '8888', 'Car', 'Mercedes-Benz', 'C200', 2025, 15000, '2026-08-20 10:47:03'),
(6, 2, 'CBI-6218', 'CBI', '6218', 'Car', 'Toyota', 'Axio', 2019, 65000, '2026-08-20 10:48:32'),
(7, 2, 'CBS-8745', 'CBS', '8745', 'Car', 'BMW', '520D', 2003, 85000, '2026-08-20 10:49:57'),
(8, 2, 'CCD-0005', 'CCD', '0005', 'Car', 'Nissan', 'Magnite', 2025, 5000, '2026-08-21 17:31:25'),
(9, 2, 'CBC-4881', 'CBC', '4881', 'Car', 'Honda', 'Civic', 2019, 65000, '2026-10-13 17:43:33'),
(10, 2, 'CCW-7823', 'CCW', '7823', 'Car', 'Kia', 'Sorento', 2006, 85000, '2026-10-14 07:37:29'),
(11, 2, 'CBM-9632', 'CBM', '9632', 'Car', 'Toyota', 'Axio', 2019, 65000, '2026-10-14 08:47:01');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_models`
--

CREATE TABLE `vehicle_models` (
  `model_id` int(11) NOT NULL,
  `brand` varchar(80) DEFAULT NULL,
  `model` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicle_models`
--

INSERT INTO `vehicle_models` (`model_id`, `brand`, `model`) VALUES
(29, 'Audi', 'A3'),
(30, 'Audi', 'A4'),
(31, 'Audi', 'Q3'),
(23, 'BMW', '320i'),
(24, 'BMW', 'X1'),
(25, 'BMW', 'X3'),
(9, 'Honda', 'Civic'),
(7, 'Honda', 'Fit'),
(10, 'Honda', 'Grace'),
(8, 'Honda', 'Vezel'),
(34, 'Hyundai', 'i10'),
(35, 'Hyundai', 'Tucson'),
(32, 'Kia', 'Picanto'),
(33, 'Kia', 'Sportage'),
(18, 'Mazda', 'Axela'),
(19, 'Mazda', 'CX-5'),
(17, 'Mazda', 'Demio'),
(26, 'Mercedes-Benz', 'C200'),
(27, 'Mercedes-Benz', 'E200'),
(28, 'Mercedes-Benz', 'GLA'),
(20, 'Mitsubishi', 'Lancer'),
(22, 'Mitsubishi', 'Montero'),
(21, 'Mitsubishi', 'Outlander'),
(12, 'Nissan', 'Leaf'),
(13, 'Nissan', 'March'),
(11, 'Nissan', 'X-Trail'),
(16, 'Suzuki', 'Alto'),
(15, 'Suzuki', 'Swift'),
(14, 'Suzuki', 'Wagon R'),
(1, 'Toyota', 'Aqua'),
(4, 'Toyota', 'Axio'),
(6, 'Toyota', 'Prado 150'),
(5, 'Toyota', 'Premio'),
(2, 'Toyota', 'Prius'),
(3, 'Toyota', 'Vitz');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `dataset_uploads`
--
ALTER TABLE `dataset_uploads`
  ADD PRIMARY KEY (`upload_id`),
  ADD KEY `uploaded_by` (`uploaded_by`);

--
-- Indexes for table `favorite_vehicles`
--
ALTER TABLE `favorite_vehicles`
  ADD PRIMARY KEY (`favorite_id`),
  ADD UNIQUE KEY `uq_fav` (`user_id`,`vehicle_id`),
  ADD KEY `vehicle_id` (`vehicle_id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`attempt_id`),
  ADD KEY `idx_attempt` (`email`,`attempted_at`);

--
-- Indexes for table `model_metrics`
--
ALTER TABLE `model_metrics`
  ADD PRIMARY KEY (`metric_id`);

--
-- Indexes for table `model_training_log`
--
ALTER TABLE `model_training_log`
  ADD PRIMARY KEY (`training_id`),
  ADD KEY `trained_by` (`trained_by`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `predictions`
--
ALTER TABLE `predictions`
  ADD PRIMARY KEY (`prediction_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `vehicle_id` (`vehicle_id`),
  ADD KEY `idx_brand` (`vehicle_brand`),
  ADD KEY `idx_service` (`service_type`),
  ADD KEY `idx_date` (`prediction_date`);

--
-- Indexes for table `service_records`
--
ALTER TABLE `service_records`
  ADD PRIMARY KEY (`record_id`),
  ADD UNIQUE KEY `prediction_id` (`prediction_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `system_announcements`
--
ALTER TABLE `system_announcements`
  ADD PRIMARY KEY (`announcement_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`vehicle_id`),
  ADD UNIQUE KEY `uq_plate` (`plate_prefix`,`plate_number`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `vehicle_models`
--
ALTER TABLE `vehicle_models`
  ADD PRIMARY KEY (`model_id`),
  ADD UNIQUE KEY `uq_model` (`brand`,`model`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dataset_uploads`
--
ALTER TABLE `dataset_uploads`
  MODIFY `upload_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `favorite_vehicles`
--
ALTER TABLE `favorite_vehicles`
  MODIFY `favorite_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `attempt_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `model_metrics`
--
ALTER TABLE `model_metrics`
  MODIFY `metric_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `model_training_log`
--
ALTER TABLE `model_training_log`
  MODIFY `training_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `predictions`
--
ALTER TABLE `predictions`
  MODIFY `prediction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `service_records`
--
ALTER TABLE `service_records`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `system_announcements`
--
ALTER TABLE `system_announcements`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `vehicle_models`
--
ALTER TABLE `vehicle_models`
  MODIFY `model_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD CONSTRAINT `contact_messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `dataset_uploads`
--
ALTER TABLE `dataset_uploads`
  ADD CONSTRAINT `dataset_uploads_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `favorite_vehicles`
--
ALTER TABLE `favorite_vehicles`
  ADD CONSTRAINT `favorite_vehicles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorite_vehicles_ibfk_2` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`vehicle_id`) ON DELETE CASCADE;

--
-- Constraints for table `model_training_log`
--
ALTER TABLE `model_training_log`
  ADD CONSTRAINT `model_training_log_ibfk_1` FOREIGN KEY (`trained_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `predictions`
--
ALTER TABLE `predictions`
  ADD CONSTRAINT `predictions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `predictions_ibfk_2` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`vehicle_id`) ON DELETE CASCADE;

--
-- Constraints for table `service_records`
--
ALTER TABLE `service_records`
  ADD CONSTRAINT `service_records_ibfk_1` FOREIGN KEY (`prediction_id`) REFERENCES `predictions` (`prediction_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `service_records_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `system_announcements`
--
ALTER TABLE `system_announcements`
  ADD CONSTRAINT `system_announcements_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
