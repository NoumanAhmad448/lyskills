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
