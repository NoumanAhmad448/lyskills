-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 03, 2022 at 06:15 PM
-- Server version: 10.2.44-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `usmansaleem234_lyskills_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_ann_models`
--

CREATE TABLE `user_ann_models` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_ann_models`
--

INSERT INTO `user_ann_models` (`id`, `message`, `created_at`, `updated_at`) VALUES
(1, 'We have shifted to our new website update. It takes 3-4 Days all courses will be restored on the website again. Directly Contact us for any Query. 03349376619', '2021-05-03 08:36:02', '2021-05-03 08:41:40'),
(2, 'Dear Instructors, If you are feeling any difficulty in uploading the Video Lectures then Please discuss the issue we are working on the Server-side for the Video Issue.', '2021-05-06 14:28:42', '2021-05-06 14:28:42'),
(3, 'Dear Instructors, Upload Your Course Videos One by One. Now Website is Working Fine. If have any issue Directly contact us on 03349376619', '2021-05-07 20:00:34', '2021-05-07 20:00:34'),
(4, '!!!10$ Sale on 23rd March on all Engineering Courses!!! Hurry Up', '2021-05-09 12:19:03', '2022-03-20 23:22:36'),
(5, 'Users you were registered in the last update. Please re-register yourself for the continuation of the Courses.', '2021-05-09 22:52:18', '2021-05-09 22:52:18'),
(6, 'Welcome Instructors', '2021-05-19 12:12:20', '2021-06-17 15:23:22'),
(7, 'Our Webinar on \"One-time work and lifetime earn\" will held on 10th June 9 PM', '2021-06-01 12:38:54', '2021-06-01 12:38:54'),
(8, '20$ Reward for Instructor who uploads his Course on Our Website', '2021-06-14 22:43:04', '2021-06-14 22:43:04'),
(9, '!!!Most of the Courses are Free During EID UL AZHA Holidays. Avail the Opportunity and Learn Your Skills!!!', '2021-07-20 13:03:45', '2021-07-20 13:03:45'),
(10, 'Signup and Join the Online Instructor and Student Community.', '2021-07-28 16:39:20', '2021-07-28 16:39:20'),
(11, '5$ Sale up to 15 August', '2021-08-08 16:49:19', '2021-08-08 16:49:19'),
(12, 'Defence Day Offer 10$ Each Course', '2021-09-04 16:13:28', '2021-09-04 16:13:28'),
(13, 'Welcome to Lyskills', '2021-09-14 12:54:43', '2021-09-14 12:54:43'),
(14, 'December End-of-Year 12$ Sale is Available on all Courses', '2021-12-03 01:26:50', '2021-12-03 01:50:30'),
(15, '!!!25 DEC OFFER MOST OF THE COURSES ARE FREE ENROLL AND ENJOY!!!', '2021-12-25 02:32:00', '2021-12-25 02:32:00'),
(16, '!!!Massive Course on Electrical Design Engineer!!! It is on Promotion Buy Now. 40$ in Febuary and 180$ after Febuary.', '2022-02-03 02:09:31', '2022-02-03 02:09:31'),
(17, 'PLC BOOTCAMP TRAINING STARTING FROM 8 MARCH 2022. ENROLL BEFORE 5 MARCH.', '2022-02-07 16:23:12', '2022-02-07 16:23:12'),
(18, 'DESERVING QUOTA HAS BEEN ANNOUNCED FOR THE PLC BOOTCAMP TRAINING. CONTACT FOR DETAILS.', '2022-03-03 00:32:43', '2022-03-03 00:32:43'),
(19, 'MEGA OFFER COMING IN MAY. STAY CONNECTED AND ENROLL IN ONLY 5$', '2022-05-12 09:17:10', '2022-05-12 09:17:10'),
(20, 'August Offer all Courses under 12 $', '2022-08-05 02:22:14', '2022-08-05 02:22:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_ann_models`
--
ALTER TABLE `user_ann_models`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_ann_models`
--
ALTER TABLE `user_ann_models`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_id` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_student` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_instructor` tinyint(1) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL,
  `is_blogger` tinyint(1) DEFAULT NULL,
  `is_super_admin` tinyint(1) DEFAULT NULL,
  `profile_photo_path` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stripe_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_brand` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `card_last_four` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 08, 2023 at 01:00 PM
-- Server version: 10.2.44-MariaDB
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `usmansaleem234_lyskills_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `wish_lists`
--

CREATE TABLE `wish_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `c_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wish_lists`
--

INSERT INTO `wish_lists` (`id`, `user_id`, `c_id`, `created_at`, `updated_at`) VALUES
(5, '40', '18', '2021-05-15 20:18:30', '2021-05-15 20:18:30'),
(6, '42', '18', '2021-05-16 11:51:48', '2021-05-16 11:51:48'),
(7, '1', '19', '2021-05-17 10:47:49', '2021-05-17 10:47:49'),
(8, '3', '18', '2021-05-20 10:04:28', '2021-05-20 10:04:28'),
(9, '181', '18', '2021-06-01 22:28:59', '2021-06-01 22:28:59'),
(10, '42', '32', '2021-06-30 00:03:10', '2021-06-30 00:03:10'),
(11, '4', '14', '2021-07-01 14:16:53', '2021-07-01 14:16:53'),
(12, '527', '32', '2021-07-20 17:00:46', '2021-07-20 17:00:46'),
(13, '42', '14', '2021-07-22 21:00:43', '2021-07-22 21:00:43'),
(14, '42', '21', '2021-07-22 21:03:13', '2021-07-22 21:03:13'),
(15, '42', '49', '2021-07-22 21:22:20', '2021-07-22 21:22:20'),
(16, '42', '113', '2021-07-22 21:23:15', '2021-07-22 21:23:15'),
(17, '556', '9', '2021-07-28 20:28:20', '2021-07-28 20:28:20'),
(18, '517', '149', '2021-09-21 13:56:10', '2021-09-21 13:56:10'),
(19, '164', '149', '2021-09-27 18:59:09', '2021-09-27 18:59:09'),
(20, '645', '32', '2021-10-07 17:56:56', '2021-10-07 17:56:56'),
(21, '645', '147', '2021-10-07 17:57:59', '2021-10-07 17:57:59'),
(22, '675', '49', '2021-10-12 12:11:39', '2021-10-12 12:11:39'),
(23, '697', '9', '2021-11-01 07:28:04', '2021-11-01 07:28:04'),
(24, '704', '172', '2021-11-08 10:06:08', '2021-11-08 10:06:08'),
(25, '523', '21', '2021-12-28 15:56:25', '2021-12-28 15:56:25'),
(27, '774', '32', '2022-01-13 18:55:18', '2022-01-13 18:55:18'),
(28, '785', '138', '2022-01-17 17:38:56', '2022-01-17 17:38:56'),
(29, '831', '90', '2022-01-29 21:28:00', '2022-01-29 21:28:00'),
(30, '859', '219', '2022-01-29 23:11:59', '2022-01-29 23:11:59'),
(31, '872', '219', '2022-01-30 23:48:09', '2022-01-30 23:48:09'),
(32, '919', '221', '2022-02-01 19:20:16', '2022-02-01 19:20:16'),
(34, '939', '221', '2022-02-06 20:45:34', '2022-02-06 20:45:34'),
(35, '939', '219', '2022-02-06 20:45:51', '2022-02-06 20:45:51'),
(36, '857', '221', '2022-02-06 23:23:29', '2022-02-06 23:23:29'),
(37, '1006', '219', '2022-02-15 19:34:04', '2022-02-15 19:34:04'),
(38, '1025', '219', '2022-02-19 22:20:17', '2022-02-19 22:20:17'),
(39, '1030', '219', '2022-02-21 22:25:44', '2022-02-21 22:25:44'),
(40, '1035', '221', '2022-02-23 15:47:19', '2022-02-23 15:47:19'),
(41, '1082', '234', '2022-03-05 23:03:34', '2022-03-05 23:03:34'),
(42, '1047', '219', '2022-03-10 11:04:19', '2022-03-10 11:04:19'),
(43, '1125', '221', '2022-03-16 02:21:49', '2022-03-16 02:21:49'),
(44, '1137', '219', '2022-03-18 01:48:18', '2022-03-18 01:48:18'),
(45, '958', '221', '2022-03-19 13:06:25', '2022-03-19 13:06:25'),
(46, '871', '221', '2022-03-23 22:55:03', '2022-03-23 22:55:03'),
(47, '871', '219', '2022-03-23 22:58:13', '2022-03-23 22:58:13'),
(49, '1151', '245', '2022-03-24 15:20:48', '2022-03-24 15:20:48'),
(50, '1155', '255', '2022-03-25 14:07:05', '2022-03-25 14:07:05'),
(51, '1161', '221', '2022-03-27 12:40:36', '2022-03-27 12:40:36'),
(53, '1205', '172', '2022-04-27 20:25:54', '2022-04-27 20:25:54'),
(54, '881', '172', '2022-05-27 17:11:27', '2022-05-27 17:11:27'),
(55, '1229', '266', '2022-05-27 22:32:56', '2022-05-27 22:32:56'),
(56, '1258', '221', '2022-06-29 14:29:24', '2022-06-29 14:29:24'),
(57, '1256', '272', '2022-06-30 20:09:14', '2022-06-30 20:09:14'),
(58, '1336', '283', '2022-08-23 10:53:28', '2022-08-23 10:53:28'),
(59, '1353', '278', '2022-08-30 15:54:12', '2022-08-30 15:54:12'),
(60, '1361', '278', '2022-09-02 19:41:44', '2022-09-02 19:41:44'),
(61, '968', '255', '2022-09-06 02:52:35', '2022-09-06 02:52:35'),
(62, '968', '234', '2022-09-06 02:52:58', '2022-09-06 02:52:58'),
(63, '968', '221', '2022-09-06 02:54:15', '2022-09-06 02:54:15'),
(64, '968', '219', '2022-09-06 02:54:45', '2022-09-06 02:54:45'),
(65, '968', '10', '2022-09-06 02:57:33', '2022-09-06 02:57:33'),
(66, '932', '9', '2022-09-06 12:32:45', '2022-09-06 12:32:45'),
(67, '754', '9', '2022-09-06 16:26:05', '2022-09-06 16:26:05'),
(68, '1383', '9', '2022-09-06 19:22:26', '2022-09-06 19:22:26'),
(69, '1384', '9', '2022-09-06 21:04:43', '2022-09-06 21:04:43'),
(70, '1388', '284', '2022-09-08 05:26:20', '2022-09-08 05:26:20'),
(71, '1395', '285', '2022-09-09 17:48:50', '2022-09-09 17:48:50'),
(72, '1413', '303', '2022-09-17 00:54:21', '2022-09-17 00:54:21'),
(73, '55', '229', '2022-09-19 01:42:44', '2022-09-19 01:42:44'),
(74, '1416', '272', '2022-09-21 12:48:54', '2022-09-21 12:48:54'),
(75, '1416', '278', '2022-09-21 12:56:02', '2022-09-21 12:56:02'),
(76, '1416', '315', '2022-09-22 12:32:31', '2022-09-22 12:32:31'),
(77, '1421', '284', '2022-09-22 19:21:05', '2022-09-22 19:21:05'),
(78, '1334', '278', '2022-09-29 00:54:37', '2022-09-29 00:54:37'),
(79, '1438', '315', '2022-10-07 23:18:56', '2022-10-07 23:18:56'),
(80, '1453', '225', '2022-10-19 19:02:59', '2022-10-19 19:02:59'),
(82, '1461', '330', '2022-10-23 23:22:01', '2022-10-23 23:22:01'),
(83, '754', '330', '2022-10-24 07:51:24', '2022-10-24 07:51:24'),
(85, '1467', '330', '2022-10-30 18:36:48', '2022-10-30 18:36:48'),
(86, '1473', '206', '2022-11-09 14:58:00', '2022-11-09 14:58:00'),
(87, '1477', '285', '2022-11-12 13:34:23', '2022-11-12 13:34:23'),
(88, '1478', '309', '2022-11-16 18:38:42', '2022-11-16 18:38:42'),
(89, '1478', '285', '2022-11-16 18:38:57', '2022-11-16 18:38:57'),
(90, '1484', '303', '2022-11-22 17:50:18', '2022-11-22 17:50:18'),
(91, '1484', '309', '2022-11-22 17:50:36', '2022-11-22 17:50:36'),
(92, '1478', '345', '2022-12-02 19:07:22', '2022-12-02 19:07:22'),
(93, '132', '353', '2022-12-03 12:21:59', '2022-12-03 12:21:59'),
(94, '1492', '330', '2022-12-07 21:19:36', '2022-12-07 21:19:36'),
(95, '1438', '359', '2022-12-17 22:18:40', '2022-12-17 22:18:40'),
(96, '1501', '361', '2022-12-22 15:41:23', '2022-12-22 15:41:23'),
(97, '1510', '330', '2022-12-29 12:58:17', '2022-12-29 12:58:17'),
(98, '1525', '380', '2023-01-15 18:40:26', '2023-01-15 18:40:26'),
(99, '1500', '221', '2023-01-20 19:14:51', '2023-01-20 19:14:51'),
(100, '1505', '327', '2023-02-04 15:51:59', '2023-02-04 15:51:59'),
(101, '1545', '330', '2023-02-12 00:16:48', '2023-02-12 00:16:48'),
(102, '1545', '229', '2023-02-12 00:34:19', '2023-02-12 00:34:19'),
(103, '1545', '383', '2023-02-15 00:17:09', '2023-02-15 00:17:09'),
(104, '1557', '388', '2023-03-02 03:25:56', '2023-03-02 03:25:56'),
(105, '1573', '392', '2023-03-22 16:00:06', '2023-03-22 16:00:06'),
(106, '1579', '373', '2023-03-26 13:53:39', '2023-03-26 13:53:39'),
(107, '1615', '393', '2023-05-09 00:20:58', '2023-05-09 00:20:58'),
(108, '1619', '397', '2023-05-09 22:00:44', '2023-05-09 22:00:44'),
(110, '1627', '403', '2023-05-28 08:18:08', '2023-05-28 08:18:08'),
(111, '945', '401', '2023-05-29 11:35:42', '2023-05-29 11:35:42'),
(112, '1595', '403', '2023-05-29 15:18:20', '2023-05-29 15:18:20'),
(113, '1658', '172', '2023-06-17 22:36:02', '2023-06-17 22:36:02'),
(114, '1677', '400', '2023-07-08 19:55:06', '2023-07-08 19:55:06'),
(115, '1686', '219', '2023-07-16 23:52:09', '2023-07-16 23:52:09'),
(116, '1686', '147', '2023-07-17 00:12:31', '2023-07-17 00:12:31'),
(117, '1686', '113', '2023-07-17 00:12:56', '2023-07-17 00:12:56'),
(118, '1686', '32', '2023-07-17 00:13:51', '2023-07-17 00:13:51'),
(119, '1686', '18', '2023-07-17 00:14:31', '2023-07-17 00:14:31'),
(120, '1687', '402', '2023-07-17 06:27:57', '2023-07-17 06:27:57'),
(121, '1698', '401', '2023-07-26 11:07:42', '2023-07-26 11:07:42'),
(122, '1703', '9', '2023-07-30 23:44:22', '2023-07-30 23:44:22'),
(123, '1703', '18', '2023-07-31 00:05:42', '2023-07-31 00:05:42'),
(124, '1753', '18', '2023-07-31 00:08:55', '2023-07-31 00:08:55'),
(125, '1756', '18', '2023-07-31 00:09:32', '2023-07-31 00:09:32'),
(126, '1770', '18', '2023-07-31 00:13:55', '2023-07-31 00:13:55'),
(127, '1796', '9', '2023-07-31 05:14:56', '2023-07-31 05:14:56'),
(128, '1807', '138', '2023-07-31 07:06:23', '2023-07-31 07:06:23'),
(129, '1803', '9', '2023-07-31 18:42:53', '2023-07-31 18:42:53'),
(130, '1857', '401', '2023-08-06 20:07:11', '2023-08-06 20:07:11'),
(131, '2', '73', '2023-08-08 12:15:27', '2023-08-08 12:15:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wish_lists`
--
ALTER TABLE `wish_lists`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wish_lists`
--
ALTER TABLE `wish_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
