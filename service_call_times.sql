-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2019 at 03:37 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 5.6.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elasticc_25`
--

-- --------------------------------------------------------

--
-- Table structure for table `service_call_times`
--

CREATE TABLE `service_call_times` (
  `id` int(11) NOT NULL,
  `service_call_id` int(11) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `start_time` varchar(8) DEFAULT NULL,
  `finish_time` varchar(8) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `service_call_times`
--

INSERT INTO `service_call_times` (`id`, `service_call_id`, `staff_id`, `start_time`, `finish_time`, `created_at`) VALUES
(1, 0, 69, '00:00:00', '00:00:00', '0000-00-00 00:00:00'),
(2, 1080, 69, '09:30', '16:29', '0000-00-00 00:00:00'),
(3, 1080, 69, '12:45', '14:30', '2019-09-20 09:40:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `service_call_times`
--
ALTER TABLE `service_call_times`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_call_id` (`service_call_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `service_call_times`
--
ALTER TABLE `service_call_times`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
