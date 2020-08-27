-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 20, 2020 at 08:38 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chat`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat_message`
--

CREATE TABLE `chat_message` (
  `chat_message_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `chat_message` mediumtext COLLATE utf8mb4_bin NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `chat_message`
--

INSERT INTO `chat_message` (`chat_message_id`, `to_user_id`, `from_user_id`, `chat_message`, `timestamp`, `status`) VALUES
(2, 6, 5, 'hii', '2020-07-22 06:07:00', 0),
(3, 6, 5, 'hii😅', '2020-07-22 06:07:13', 0),
(4, 5, 6, 'hii', '2020-07-22 06:07:56', 0),
(5, 6, 5, 'hii again', '2020-07-22 06:10:49', 0),
(6, 6, 5, 'emoji😀', '2020-07-22 06:10:58', 2),
(7, 0, 5, 'hello world!!', '2020-07-24 14:07:51', 1),
(8, 0, 6, '<p><img src=\"upload/download (1).jpg\" class=\"img-thumbnail\" width=\"200\" height=\"160\"></p>first largest word', '2020-07-24 14:08:48', 2),
(9, 0, 5, '<p><img src=\"upload/download (3).jpg\" class=\"img-thumbnail\" width=\"200\" height=\"160\"></p>2nd largest word...', '2020-07-24 14:09:13', 2),
(10, 6, 5, 'emoji....🤩', '2020-07-24 14:10:39', 0),
(11, 5, 6, 'working perfectly, I guess', '2020-07-24 14:20:07', 0),
(12, 0, 5, 'yo guys!!', '2020-08-18 04:16:26', 1),
(13, 0, 5, 'whats up', '2020-08-18 04:16:36', 1),
(14, 0, 5, 'new files', '2020-08-18 04:22:01', 1),
(15, 0, 5, 'msg sent check', '2020-08-18 04:22:41', 1),
(16, 6, 5, 'private chat check🤘', '2020-08-18 04:23:17', 0),
(17, 0, 5, 'hello?', '2020-08-18 05:17:06', 2),
(18, 0, 5, 'it\'s working offline', '2020-08-18 05:17:31', 1),
(19, 0, 5, 'hola hoomans', '2020-08-18 07:03:19', 1),
(20, 0, 5, 'greetings', '2020-08-18 07:08:22', 1),
(21, 0, 5, 'hey all', '2020-08-20 17:47:09', 1),
(22, 0, 6, 'hey there', '2020-08-20 17:49:17', 1),
(23, 0, 7, 'Admin here', '2020-08-20 17:52:31', 1),
(24, 0, 5, '65+6', '2020-08-20 17:53:11', 2),
(25, 0, 6, '4897489484', '2020-08-20 17:53:18', 2),
(26, 0, 5, '4654', '2020-08-20 17:55:03', 1),
(27, 0, 6, '51516516', '2020-08-20 17:55:10', 1),
(28, 0, 7, 'Remote Admin here', '2020-08-20 18:05:01', 1),
(29, 0, 5, 'ujtytyu', '2020-08-20 18:18:42', 1),
(30, 0, 5, 'jsr', '2020-08-20 18:35:29', 1),
(31, 0, 6, 'local testing of hosted website', '2020-08-20 18:35:59', 1),
(32, 0, 5, 'successful', '2020-08-20 18:36:14', 1);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`user_id`, `username`, `password`) VALUES
(5, 'satyam', '$2y$10$9ADiCQmVjK7bfYdcl7BrhO6d0HvmBgvE2ZIcEjicIOaxfG2W.iVsm'),
(6, 'qwerty', '$2y$10$1gkZq3WLlvNW/OkiK09uOe0xaZT2sRq9bGo5c6tTkvzf5M5.Uvs5q'),
(7, 'admin', '$2y$10$liESeGyRarNlW3aMHG.YPOs6BBmGPOMNjnOMomCrdHg5kCShpEau6');

-- --------------------------------------------------------

--
-- Table structure for table `login_details`
--

CREATE TABLE `login_details` (
  `login_details_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_activity` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_type` enum('no','yes') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_details`
--

INSERT INTO `login_details` (`login_details_id`, `user_id`, `last_activity`, `is_type`) VALUES
(1, 1, '2020-07-19 13:15:35', 'no'),
(2, 4, '2020-07-19 13:16:15', 'no'),
(3, 6, '2020-07-20 04:12:15', 'no'),
(4, 5, '2020-07-20 04:12:41', 'no'),
(5, 6, '2020-07-20 04:21:55', 'no'),
(6, 5, '2020-07-20 04:38:15', 'no'),
(7, 5, '2020-07-22 05:28:22', 'no'),
(8, 6, '2020-07-22 07:32:29', 'no'),
(9, 6, '2020-07-22 05:23:55', 'no'),
(10, 1, '2020-07-22 05:30:44', 'no'),
(11, 5, '2020-07-22 07:36:49', 'no'),
(12, 5, '2020-07-23 15:41:31', 'no'),
(13, 6, '2020-07-23 15:41:59', 'no'),
(14, 6, '2020-07-24 03:48:49', 'no'),
(15, 5, '2020-07-24 03:48:43', 'no'),
(16, 5, '2020-07-24 05:33:06', 'no'),
(17, 6, '2020-07-24 05:33:12', 'no'),
(18, 6, '2020-07-24 15:39:02', 'no'),
(19, 5, '2020-07-24 15:35:20', 'no'),
(20, 5, '2020-08-18 04:06:43', 'no'),
(21, 6, '2020-08-18 04:06:59', 'no'),
(22, 5, '2020-08-18 04:24:41', 'no'),
(23, 6, '2020-08-18 04:26:01', 'no'),
(24, 5, '2020-08-18 07:02:23', 'no'),
(25, 5, '2020-08-18 07:55:52', 'no'),
(26, 5, '2020-08-18 07:56:25', 'no'),
(27, 6, '2020-08-18 08:08:37', 'no'),
(28, 5, '2020-08-20 17:24:08', 'no'),
(29, 6, '2020-08-20 18:09:40', 'no'),
(30, 7, '2020-08-20 17:35:04', 'no'),
(31, 5, '2020-08-20 18:09:38', 'no'),
(32, 5, '2020-08-20 17:37:20', 'no'),
(33, 7, '2020-08-20 17:41:50', 'no'),
(34, 7, '2020-08-20 17:46:20', 'no'),
(35, 7, '2020-08-20 17:52:50', 'no'),
(36, 7, '2020-08-20 18:01:20', 'no'),
(37, 7, '2020-08-20 18:05:19', 'no'),
(38, 5, '2020-08-20 18:38:57', 'no'),
(39, 6, '2020-08-20 18:38:57', 'no');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat_message`
--
ALTER TABLE `chat_message`
  ADD PRIMARY KEY (`chat_message_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `login_details`
--
ALTER TABLE `login_details`
  ADD PRIMARY KEY (`login_details_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat_message`
--
ALTER TABLE `chat_message`
  MODIFY `chat_message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `login_details`
--
ALTER TABLE `login_details`
  MODIFY `login_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
