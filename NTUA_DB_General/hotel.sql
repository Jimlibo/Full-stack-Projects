-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2021 at 06:39 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel`
--

-- --------------------------------------------------------

--
-- Table structure for table `access`
--

CREATE TABLE `access` (
  `NFC_ID` int(10) NOT NULL,
  `Room ID` int(2) NOT NULL,
  `T&D of start` datetime NOT NULL,
  `T&D of end` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `charging for service`
--

CREATE TABLE `charging for service` (
  `Service ID` int(2) NOT NULL,
  `T&D of charge` datetime NOT NULL,
  `Description` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `Charge` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `NFC_ID` int(10) NOT NULL,
  `Last name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `First name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `Birth Date` date NOT NULL,
  `ID document number` int(15) NOT NULL,
  `ID document kind` varchar(15) COLLATE latin1_general_ci NOT NULL,
  `ID document authority` varchar(20) COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`NFC_ID`, `Last name`, `First name`, `Birth Date`, `ID document number`, `ID document kind`, `ID document authority`) VALUES
(1, 'Smith', 'John', '2000-01-01', 123456, 'Identity', 'Hellenic Police'),
(2, 'Smith', 'Jane', '2000-06-01', 478638, 'Passport', 'Italian Police');

-- --------------------------------------------------------

--
-- Table structure for table `client email`
--

CREATE TABLE `client email` (
  `NFC_ID` int(10) NOT NULL,
  `Email` varchar(30) COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client phone`
--

CREATE TABLE `client phone` (
  `NFC_ID` int(10) NOT NULL,
  `Phone number` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conducted in`
--

CREATE TABLE `conducted in` (
  `Room ID` int(2) NOT NULL,
  `Service ID` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enroll in services`
--

CREATE TABLE `enroll in services` (
  `NFC_ID` int(10) NOT NULL,
  `Service ID` int(2) NOT NULL,
  `T&D of enrollment` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `Room ID` int(2) NOT NULL,
  `Number of beds` int(1) DEFAULT NULL,
  `Name` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `Description and location` varchar(50) COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `Service ID` int(2) NOT NULL,
  `Description` varchar(50) COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`Service ID`, `Description`) VALUES
(1, 'Drinks at bar'),
(2, 'Food and drinks at restaurant'),
(3, 'Hairdressing & Barbering'),
(4, 'Gym usage'),
(5, 'Sauna visit'),
(6, 'Conference room usage');

-- --------------------------------------------------------

--
-- Table structure for table `services with enrollment`
--

CREATE TABLE `services with enrollment` (
  `Service ID` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `services with enrollment`
--

INSERT INTO `services with enrollment` (`Service ID`) VALUES
(4),
(5),
(6);

-- --------------------------------------------------------

--
-- Table structure for table `services without enrollment`
--

CREATE TABLE `services without enrollment` (
  `Service ID` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `services without enrollment`
--

INSERT INTO `services without enrollment` (`Service ID`) VALUES
(1),
(2),
(3);

-- --------------------------------------------------------

--
-- Table structure for table `usage of services`
--

CREATE TABLE `usage of services` (
  `NFC_ID` int(10) NOT NULL,
  `Service ID` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visit`
--

CREATE TABLE `visit` (
  `NFC_ID` int(10) NOT NULL,
  `Room ID` int(2) NOT NULL,
  `T&D of entrance` datetime NOT NULL,
  `T&D of departure` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access`
--
ALTER TABLE `access`
  ADD PRIMARY KEY (`NFC_ID`,`Room ID`),
  ADD KEY `NFC_ID` (`NFC_ID`,`Room ID`),
  ADD KEY `Room ID` (`Room ID`);

--
-- Indexes for table `charging for service`
--
ALTER TABLE `charging for service`
  ADD PRIMARY KEY (`Service ID`,`T&D of charge`),
  ADD UNIQUE KEY `Service ID_2` (`Service ID`,`Description`),
  ADD KEY `Service ID` (`Service ID`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`NFC_ID`),
  ADD UNIQUE KEY `NFC_ID` (`NFC_ID`),
  ADD UNIQUE KEY `ID document number` (`ID document number`);

--
-- Indexes for table `client email`
--
ALTER TABLE `client email`
  ADD PRIMARY KEY (`NFC_ID`,`Email`),
  ADD UNIQUE KEY `NFC_ID_2` (`NFC_ID`,`Email`),
  ADD UNIQUE KEY `NFC_ID_3` (`NFC_ID`),
  ADD KEY `NFC_ID` (`NFC_ID`);

--
-- Indexes for table `client phone`
--
ALTER TABLE `client phone`
  ADD PRIMARY KEY (`NFC_ID`,`Phone number`),
  ADD UNIQUE KEY `NFC_ID_2` (`NFC_ID`,`Phone number`),
  ADD UNIQUE KEY `NFC_ID_3` (`NFC_ID`),
  ADD KEY `NFC_ID` (`NFC_ID`);

--
-- Indexes for table `conducted in`
--
ALTER TABLE `conducted in`
  ADD PRIMARY KEY (`Room ID`,`Service ID`),
  ADD UNIQUE KEY `Service ID` (`Service ID`),
  ADD KEY `Room ID` (`Room ID`,`Service ID`);

--
-- Indexes for table `enroll in services`
--
ALTER TABLE `enroll in services`
  ADD PRIMARY KEY (`NFC_ID`,`Service ID`),
  ADD KEY `NFC_ID` (`NFC_ID`,`Service ID`),
  ADD KEY `Service ID` (`Service ID`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`Room ID`),
  ADD UNIQUE KEY `Room ID` (`Room ID`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`Service ID`);

--
-- Indexes for table `services with enrollment`
--
ALTER TABLE `services with enrollment`
  ADD PRIMARY KEY (`Service ID`),
  ADD KEY `Service ID` (`Service ID`);

--
-- Indexes for table `services without enrollment`
--
ALTER TABLE `services without enrollment`
  ADD PRIMARY KEY (`Service ID`),
  ADD KEY `Service ID` (`Service ID`);

--
-- Indexes for table `usage of services`
--
ALTER TABLE `usage of services`
  ADD PRIMARY KEY (`NFC_ID`,`Service ID`),
  ADD UNIQUE KEY `NFC_ID_2` (`NFC_ID`,`Service ID`),
  ADD KEY `NFC_ID` (`NFC_ID`,`Service ID`),
  ADD KEY `Service ID` (`Service ID`);

--
-- Indexes for table `visit`
--
ALTER TABLE `visit`
  ADD PRIMARY KEY (`NFC_ID`,`Room ID`),
  ADD KEY `NFC_ID` (`NFC_ID`,`Room ID`),
  ADD KEY `Room ID` (`Room ID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `access`
--
ALTER TABLE `access`
  ADD CONSTRAINT `access_ibfk_1` FOREIGN KEY (`NFC_ID`) REFERENCES `client` (`NFC_ID`),
  ADD CONSTRAINT `access_ibfk_2` FOREIGN KEY (`Room ID`) REFERENCES `rooms` (`Room ID`);

--
-- Constraints for table `charging for service`
--
ALTER TABLE `charging for service`
  ADD CONSTRAINT `charging for service_ibfk_1` FOREIGN KEY (`Service ID`) REFERENCES `services` (`Service ID`);

--
-- Constraints for table `client email`
--
ALTER TABLE `client email`
  ADD CONSTRAINT `client email_ibfk_1` FOREIGN KEY (`NFC_ID`) REFERENCES `client` (`NFC_ID`);

--
-- Constraints for table `client phone`
--
ALTER TABLE `client phone`
  ADD CONSTRAINT `client phone_ibfk_1` FOREIGN KEY (`NFC_ID`) REFERENCES `client` (`NFC_ID`);

--
-- Constraints for table `conducted in`
--
ALTER TABLE `conducted in`
  ADD CONSTRAINT `conducted in_ibfk_1` FOREIGN KEY (`Room ID`) REFERENCES `rooms` (`Room ID`),
  ADD CONSTRAINT `conducted in_ibfk_2` FOREIGN KEY (`Service ID`) REFERENCES `services` (`Service ID`);

--
-- Constraints for table `enroll in services`
--
ALTER TABLE `enroll in services`
  ADD CONSTRAINT `enroll in services_ibfk_1` FOREIGN KEY (`NFC_ID`) REFERENCES `client` (`NFC_ID`),
  ADD CONSTRAINT `enroll in services_ibfk_2` FOREIGN KEY (`Service ID`) REFERENCES `services with enrollment` (`Service ID`);

--
-- Constraints for table `services with enrollment`
--
ALTER TABLE `services with enrollment`
  ADD CONSTRAINT `services with enrollment_ibfk_1` FOREIGN KEY (`Service ID`) REFERENCES `services` (`Service ID`);

--
-- Constraints for table `services without enrollment`
--
ALTER TABLE `services without enrollment`
  ADD CONSTRAINT `services without enrollment_ibfk_1` FOREIGN KEY (`Service ID`) REFERENCES `services` (`Service ID`);

--
-- Constraints for table `usage of services`
--
ALTER TABLE `usage of services`
  ADD CONSTRAINT `usage of services_ibfk_1` FOREIGN KEY (`NFC_ID`) REFERENCES `client` (`NFC_ID`),
  ADD CONSTRAINT `usage of services_ibfk_2` FOREIGN KEY (`Service ID`) REFERENCES `services` (`Service ID`);

--
-- Constraints for table `visit`
--
ALTER TABLE `visit`
  ADD CONSTRAINT `visit_ibfk_1` FOREIGN KEY (`NFC_ID`) REFERENCES `client` (`NFC_ID`),
  ADD CONSTRAINT `visit_ibfk_2` FOREIGN KEY (`Room ID`) REFERENCES `rooms` (`Room ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
