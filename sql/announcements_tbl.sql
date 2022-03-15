-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 14, 2022 at 07:48 AM
-- Server version: 10.5.12-MariaDB
-- PHP Version: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id18567046_campus_logging_system_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements_tbl`
--

CREATE TABLE `announcements_tbl` (
  `id` int(11) NOT NULL,
  `date` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `announcements_tbl`
--

INSERT INTO `announcements_tbl` (`id`, `date`, `title`, `message`) VALUES
(1, '03/13/2022', 'Student Vaccination Profile edited', 'Hello Flames!.... Edit'),
(2, '03/16/2022', 'INUMAN SESSION', 'SA LAHAT NG GUSTO UMINOM SA MARCH 16 (WED), 2022. PUMUNTA LANG SA BAHAY NILA GUARIN. SHEEEEESH!'),
(3, '03/08/2022', 'DEBUT NI GUARIN!', 'SHEEEEEESSSH! AM SO RITS YO MAGENGGENG, TO GUARIN HAPE BERTDIY TO YUUUUUUUUU, YU WANT DIS DIS? AM SO RITS YU MAGENGGENG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements_tbl`
--
ALTER TABLE `announcements_tbl`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements_tbl`
--
ALTER TABLE `announcements_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
