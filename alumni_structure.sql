-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 04, 2019 at 09:47 PM
-- Server version: 5.7.25-0ubuntu0.18.04.2
-- PHP Version: 7.2.15-0ubuntu0.18.04.2


-- THIS FILE CREATES ALL NECESSARY TABLES REQUIRED FOR APPLICATION--


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alumni`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(4) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `alumni_info`
--

CREATE TABLE `alumni_info` (
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `addr` varchar(100) DEFAULT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dept` varchar(35) NOT NULL,
  `passout` varchar(4) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `id` varchar(15) NOT NULL,
  `company` varchar(50) DEFAULT NULL,
  `desgn` varchar(20) NOT NULL,
  `from_yr` varchar(8) NOT NULL,
  `to_yr` varchar(8) NOT NULL,
  `git` varchar(100) DEFAULT NULL,
  `linkedin` varchar(100) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `bio` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `pid` varchar(15) NOT NULL,
  `ssc` varchar(100) DEFAULT NULL,
  `ssc_per` varchar(5) DEFAULT NULL,
  `hsc` varchar(100) DEFAULT NULL,
  `hsc_per` varchar(5) DEFAULT NULL,
  `ug` varchar(100) DEFAULT NULL,
  `ug_per` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pass_reset`
--

CREATE TABLE `pass_reset` (
  `email` varchar(30) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `pid` varchar(15) NOT NULL,
  `img_path` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `pid` varchar(15) NOT NULL,
  `skills` text,
  `project` text,
  `certi` text,
  `papers` text,
  `accomp` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `work`
--

CREATE TABLE `work` (
  `pid` varchar(15) NOT NULL,
  `company_name` varchar(50) NOT NULL,
  `desgn` varchar(30) NOT NULL,
  `from_yr` int(4) NOT NULL,
  `to_yr` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `alumni_info`
--
ALTER TABLE `alumni_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `mobile` (`mobile`);

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `pass_reset`
--
ALTER TABLE `pass_reset`
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD UNIQUE KEY `pid` (`pid`);

--
-- Indexes for table `work`
--
ALTER TABLE `work`
  ADD KEY `fk` (`pid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `education`
--
ALTER TABLE `education`
  ADD CONSTRAINT `fk` FOREIGN KEY (`pid`) REFERENCES `alumni_info` (`id`);

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `fk_2` FOREIGN KEY (`pid`) REFERENCES `alumni_info` (`id`);

--
-- Constraints for table `skills`
--
ALTER TABLE `skills`
  ADD CONSTRAINT `fk_4` FOREIGN KEY (`pid`) REFERENCES `alumni_info` (`id`);

--
-- Constraints for table `work`
--
ALTER TABLE `work`
  ADD CONSTRAINT `fk_3` FOREIGN KEY (`pid`) REFERENCES `alumni_info` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
