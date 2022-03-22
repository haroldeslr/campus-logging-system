-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 22, 2022 at 12:16 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `campus_logging_system_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `roles_tbl`
--

CREATE TABLE `roles_tbl` (
  `id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `open_dashboard` tinyint(1) NOT NULL,
  `open_logbook` tinyint(1) NOT NULL,
  `edit_log` tinyint(1) NOT NULL,
  `delete_log` tinyint(1) NOT NULL,
  `open_announcement` tinyint(1) NOT NULL,
  `add_announcement` tinyint(1) NOT NULL,
  `edit_announcement` tinyint(1) NOT NULL,
  `delete_announcement` tinyint(1) NOT NULL,
  `open_users` tinyint(1) NOT NULL,
  `add_users` tinyint(1) NOT NULL,
  `edit_users` tinyint(1) NOT NULL,
  `delete_users` tinyint(1) NOT NULL,
  `open_roles_and_permissions` tinyint(1) NOT NULL,
  `add_roles_and_permissions` tinyint(1) NOT NULL,
  `edit_roles_and_permissions` tinyint(1) NOT NULL,
  `delete_roles_and_permissions` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roles_tbl`
--

INSERT INTO `roles_tbl` (`id`, `role_name`, `open_dashboard`, `open_logbook`, `edit_log`, `delete_log`, `open_announcement`, `add_announcement`, `edit_announcement`, `delete_announcement`, `open_users`, `add_users`, `edit_users`, `delete_users`, `open_roles_and_permissions`, `add_roles_and_permissions`, `edit_roles_and_permissions`, `delete_roles_and_permissions`) VALUES
(1, 'Administrator', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(2, 'Manager', 1, 1, 0, 0, 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `roles_tbl`
--
ALTER TABLE `roles_tbl`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `roles_tbl`
--
ALTER TABLE `roles_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
