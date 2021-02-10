-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2021 at 09:56 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tasker`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `tasks_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `comments` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `tasks_id`, `users_id`, `comments`) VALUES
(39, 94, 21, '(Admin): '),
(40, 95, 21, '(Admin): '),
(41, 96, 21, '(Admin): '),
(42, 97, 21, '(Admin): '),
(43, 98, 21, '(Admin): '),
(44, 99, 22, '(Admin): '),
(45, 100, 22, '(Admin): '),
(46, 101, 22, '(Admin): '),
(47, 102, 21, '(Admin): '),
(48, 103, 22, '(Admin): '),
(49, 104, 21, '(Admin): '),
(50, 105, 22, '(Admin): ');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `tasks_id` int(4) NOT NULL,
  `updates` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `title` char(35) COLLATE utf8_unicode_ci NOT NULL,
  `details` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `completion` tinyint(1) NOT NULL,
  `deadline` date DEFAULT NULL,
  `ext_request` tinyint(1) NOT NULL,
  `ext_approval` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`tasks_id`, `updates`, `title`, `details`, `completion`, `deadline`, `ext_request`, `ext_approval`) VALUES
(94, '2021-02-05 20:34:42', 'Design the solution', 'dentify resources to be monitored.\r\nDefine users and workflow\r\nIdentify event sources by resource type.\r\nDefine the relationship between resources and business systems.\r\nIdentify tasks and URLs by resource type.\r\nDefine the server configuration.', 0, '2021-02-09', 1, 0),
(95, '2021-02-05 20:30:36', 'Prepare the test/QA environment', 'Install test and QA servers and prerequisite software.\r\nInstall console machines and prerequisite software.\r\nVerify connectivity from test and QA servers to test LPAR, Tivoli Enterprise Console(R) server, and console machines.', 0, '2021-02-07', 0, 0),
(96, '2021-02-05 20:53:47', 'Prepare for implementation', 'Identify the implementation team.\r\nOrder the server hardware for production as well as test/quality assurance (QA).\r\nOrder console machines.\r\nOrder prerequisite software.\r\nIdentify the test LPAR.\r\nIdentify production LPARs.\r\nSchedule changes as required.\r\nCreate user IDs and groups.\r\nTivoli Business Systems Manager operators and administrators\r\nTivoli OMEGAMON(R) logins and profiles\r\nSecurity changes as required.\r\nSAF\r\nFirewall', 0, '2021-02-06', 1, 0),
(97, '2021-02-05 20:31:47', 'Install the product in the test/QA', 'For each resource type, do the following tasks:\r\nExtend the data model.\r\nConfigure the instance placement.\r\nConfigure the Tivoli Enterprise Console rules to send events.\r\nAssociate tasks and URLs with object types.', 0, '2021-02-06', 0, 0),
(98, '2021-02-05 20:32:16', 'Implement Source/390 data feeds on', 'For each resource type, do the following tasks:\r\nConfigure filtering, if appropriate.\r\nPerform discovery, if required.\r\nConfigure the event source.\r\nVerify the event flow.', 0, '2021-02-10', 0, 0),
(99, '2021-02-05 20:32:36', 'Schedule jobs', 'Tivoli Business Systems Manager SQL server jobs\r\nSource/390 rediscoveries\r\nBatch schedule download/process\r\nDatabase backup and maintenance', 0, '2021-02-24', 0, 0),
(100, '2021-02-05 20:32:57', 'Install the Health Monitor.', 'Install the Tivoli Business Systems Manager health monitor software.\r\nCustomize the health monitor to match your environment.\r\nTest the health monitor client functions.', 0, '2021-02-26', 0, 0),
(101, '2021-02-05 20:42:44', 'Test Task 1', 'Test Task 1', 0, '2021-02-20', 0, 0),
(102, '2021-02-05 20:43:01', 'Test Task 2', 'Test Task 2\r\nTest Task 2\r\nTest Task 2', 0, '2021-02-13', 0, 0),
(103, '2021-02-05 20:43:16', 'Test Task 3', 'Test Task 3', 0, '2021-03-03', 0, 0),
(104, '2021-02-05 20:50:40', 'Task test 5', 'Task test 5\r\nTask test 5', 0, '2021-02-27', 0, 0),
(105, '2021-02-05 20:50:54', 'Task test 6', 'Task test 6', 0, '2021-03-09', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `users_id` int(4) NOT NULL,
  `email_id` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `isadmin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`users_id`, `email_id`, `name`, `password`, `isadmin`) VALUES
(20, 'admin@admin.com', 'Admin Access', 'Admin@123', 1),
(21, 'user1@user.com', 'User 1', 'User1@123', 0),
(22, 'user2@user.com', 'User 2', 'User2@123', 0),
(23, 'user3@user.com', 'User 3', 'User3@123', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Foreign Key` (`tasks_id`),
  ADD KEY `Foreign Key User` (`users_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`tasks_id`),
  ADD KEY `tasks_id` (`tasks_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`users_id`),
  ADD UNIQUE KEY `email_id` (`email_id`),
  ADD KEY `users_id` (`users_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `tasks_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `Foreign Key` FOREIGN KEY (`tasks_id`) REFERENCES `tasks` (`tasks_id`),
  ADD CONSTRAINT `Foreign Key User` FOREIGN KEY (`users_id`) REFERENCES `users` (`users_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
