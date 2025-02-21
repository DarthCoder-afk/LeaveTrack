-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2025 at 06:19 AM
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
-- Database: `hrmoleave`
--

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `employee_id` varchar(3) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `midname` varchar(50) DEFAULT NULL,
  `lname` varchar(50) NOT NULL,
  `extname` varchar(10) DEFAULT NULL,
  `gender` varchar(10) NOT NULL,
  `position` varchar(100) NOT NULL,
  `office` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_id`, `fname`, `midname`, `lname`, `extname`, `gender`, `position`, `office`) VALUES
('001', 'Donovan', 'Abriol', 'Mancenido', '', 'Male', 'Municipal Mayor', 'Office of the Municipal Mayor'),
('005', 'Ruena', 'Valles', 'Estrella', '', 'Female', 'Administrative Aide VI', 'Office of the Municipal Mayor'),
('015', 'Maria Cristina', 'Zantua', 'Arevalo', '', 'Female', 'Municipal Vice Mayor', 'Sangguniang Bayan Office');

-- --------------------------------------------------------

--
-- Table structure for table `leaveapplication`
--

CREATE TABLE `leaveapplication` (
  `employee_id` varchar(10) NOT NULL,
  `leavetype` varchar(50) NOT NULL,
  `dateapplied` date NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `numofdays` int(100) NOT NULL,
  `file` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leaveapplication`
--

INSERT INTO `leaveapplication` (`employee_id`, `leavetype`, `dateapplied`, `startdate`, `enddate`, `numofdays`, `file`) VALUES
('001', 'Sick Leave', '2025-02-21', '2025-02-24', '2025-02-25', 2, 0x4c656176655f466f726d2e706466);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`username`, `password`) VALUES
('admin', 'admin123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`employee_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
