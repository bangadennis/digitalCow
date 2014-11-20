-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 21, 2014 at 08:42 PM
-- Server version: 5.5.35
-- PHP Version: 5.3.10-1ubuntu3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `onlineDairy`
--

-- --------------------------------------------------------

--
-- Table structure for table `calving_register`
--

CREATE TABLE IF NOT EXISTS `calving_register` (
  `cow_id` varchar(10) NOT NULL,
  `method_calving` varchar(40) NOT NULL,
  `calf_sex` varchar(7) NOT NULL,
  `remarks` text,
  `calf_id` varchar(10) NOT NULL,
  PRIMARY KEY (`calf_id`),
  KEY `cow_id` (`cow_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `calving_register`
--

INSERT INTO `calving_register` (`cow_id`, `method_calving`, `calf_sex`, `remarks`, `calf_id`) VALUES
('KAMAUY', 'Natural', 'Male', 'kkkkkkkkkkkkkkkkkkk', ''),
('09KA07', 'Surgery', 'Femal', 'kkkkkkkkkkkkkkkkkk', '09KA01'),
('09KA04', 'Natural', 'Male', 'Calf on Good Health', '09KA08'),
('BA001', 'Natural', 'Male', 'xxxxxxxxxxxxxxxxxxxxxxx', '09KA09');

-- --------------------------------------------------------

--
-- Table structure for table `cow_detail`
--

CREATE TABLE IF NOT EXISTS `cow_detail` (
  `cow_id` varchar(10) NOT NULL,
  `dateofbirth` date NOT NULL,
  `sex` varchar(8) NOT NULL,
  `breed` varchar(15) NOT NULL,
  `phone_no` varchar(13) NOT NULL,
  PRIMARY KEY (`cow_id`),
  KEY `phone_no` (`phone_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cow_detail`
--

INSERT INTO `cow_detail` (`cow_id`, `dateofbirth`, `sex`, `breed`, `phone_no`) VALUES
('001', '2014-04-11', 'Heifer', 'Freshian', '+254715757109'),
('002', '2014-04-10', 'Cow', 'kalong0', '+254715757109'),
('09KA00', '2014-03-02', 'Heifer', 'Guernsey', '+254724015053'),
('09KA01', '2012-01-31', 'Heifer', 'Freshian', '+254333334444'),
('09KA02', '2014-02-04', 'Cow', 'Guernsey', '+254222222222'),
('09KA03l', '2014-03-08', 'Cow', 'Aberdeen Angus', '+254222222222'),
('09KA04', '2014-03-07', 'Cow', 'Guernsey', '+254222222222'),
('09KA07', '2013-12-30', 'Cow', 'Guernsey', '+254333334444'),
('09KA08', '2014-03-08', 'Heifer', 'Guernsey', '+254222222222'),
('09KA09', '2014-03-04', 'Cow', 'Guernsey', '+254731053591'),
('09KA0k', '2014-03-09', 'Cow', 'Guernsey', '+254222222222'),
('AM001', '2014-01-02', 'Cow', 'Fresian', '+254721567977'),
('BA001', '2010-09-29', 'Cow', 'Guernsey', '+254731053591'),
('BA003', '2012-12-31', 'Cow', 'Guernsey', '+254731053591'),
('DK001', '2013-01-31', 'Cow', 'Fresian', '+254737012454'),
('DM001', '2013-12-31', 'Cow', 'Guernsey', '+254707533075'),
('EK001', '2014-01-31', 'Cow', 'Guernsey', '+254702148296'),
('FN001', '2014-12-31', 'Cow', 'Guernsey', '+254728957117'),
('FSSS', '2014-03-09', 'Cow', 'Guernsey', '+254713353604'),
('Kamau', '2014-03-22', 'Heifer', 'Guernsey', '+254222222222'),
('KAMAUY', '2014-02-27', 'Cow', 'Guernsey', '+254724015053'),
('KM001', '2013-12-31', 'Cow', 'Fresian', '+254713353604'),
('PN001', '2013-12-31', 'Cow', 'Guernsey', '+254724441239');

-- --------------------------------------------------------

--
-- Table structure for table `feedingrecord`
--

CREATE TABLE IF NOT EXISTS `feedingrecord` (
  `cow_id` varchar(10) NOT NULL,
  `type_feed` text NOT NULL,
  `amount_feed` varchar(100) DEFAULT NULL,
  `feed_date` date NOT NULL,
  `feed_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`feed_id`),
  UNIQUE KEY `feed_id` (`feed_id`),
  KEY `cow_id` (`cow_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `feedingrecord`
--

INSERT INTO `feedingrecord` (`cow_id`, `type_feed`, `amount_feed`, `feed_date`, `feed_id`) VALUES
('09KA02', 'Fddddddddddddd', 'ddd', '2014-02-27', 2),
('09KA02', 'Fddddddddddddd', 'sssssssssssss', '2014-03-09', 4),
('09KA04', 'Fddddddddddddd', 'dddldsllsl', '2014-03-07', 6),
('09KA02', 'kkkkk', 'KQUWE', '2014-03-05', 7),
('KM001', 'thara', 'Ngunia ithatu na bra', '2014-03-23', 9),
('KM001', 'kkkkk', 'sssssssssssss', '2014-03-24', 10),
('DM001', 'jjjjjjjjjjjj', 'Ngunia', '2014-03-23', 11),
('09KA09', 'kkkkk', 'sssssssssssss', '2014-04-05', 12),
('09KA00', 'Fddddddddddddd', 'sssssssssssss', '2014-04-10', 13);

-- --------------------------------------------------------

--
-- Table structure for table `health`
--

CREATE TABLE IF NOT EXISTS `health` (
  `cow_id` varchar(10) NOT NULL,
  `symptoms` text NOT NULL,
  `type_treatment` varchar(20) DEFAULT NULL,
  `treatment` text,
  `veterinary` varchar(30) DEFAULT NULL,
  `date_treatment` date NOT NULL,
  `remarks` text,
  `health_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`health_id`),
  UNIQUE KEY `health_id` (`health_id`),
  KEY `cow_id` (`cow_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `health`
--

INSERT INTO `health` (`cow_id`, `symptoms`, `type_treatment`, `treatment`, `veterinary`, `date_treatment`, `remarks`, `health_id`) VALUES
('09KA02', 'hhhhhhhhhhhh', 'Normal', 'ssssssssssssss', 'Njoroge Kamau', '2014-03-28', 'Good Recovery', 2),
('Kamau', 'jjjjjjjjjjjjjj', 'Normal', 'jjjjjjjjjjjjjj', 'Kamaud', '2014-03-06', 'jjjjjjjjjjjjjjjj', 3),
('09KA02', 'ddddddddddddddd', 'Vaccination', 'jjjjjjj', 'kamau', '2013-12-31', 'lddddddddd', 4),
('09KA02', 'ddddddddddddddd', 'Vaccination', 'jjjjjjj', 'kamau', '2013-12-12', 'lddddddddd', 5),
('09KA02', 'ddddddddddddddd', 'Vaccination', 'jjjjjjj', 'kamau', '2013-11-29', 'lddddddddd', 6),
('09KA02', 'ddddddddddddddd', 'Vaccination', 'jjjjjjj', 'kamau', '2013-11-16', 'lddddddddd', 7),
('09KA02', 'ddddddddddddddd', 'Vaccination', 'jjjjjjj', 'kamau', '2013-11-19', 'lddddddddduuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuu', 8),
('09KA01', 'hhhhhhhhhhhhhhh', 'Normal', 'hhhhhhhhhhhhhhh', 'hhhhhhhhhhhh', '0004-04-04', 'kkkkkkkkkkkkkkkkkk', 9),
('BA001', 'ddddddddddddddddddddddddd', 'Normal', 'ddddddddddddd', 'jddddddddd', '2014-02-10', 'dddddddddddddd', 10),
('09KA00', 'jjjjjjjjjjjjjjjjjjjjjjjj', 'Vaccination', 'kkkkkkkkkkkkkkkkkkk', 'kamau', '2014-04-09', 'kkkkkkkkkkkkkkkkkkkkk', 11);

-- --------------------------------------------------------

--
-- Table structure for table `income`
--

CREATE TABLE IF NOT EXISTS `income` (
  `phone_no` varchar(13) NOT NULL,
  `description` varchar(70) NOT NULL,
  `type_income` varchar(7) NOT NULL,
  `amount` float NOT NULL,
  `date` date NOT NULL,
  `income_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`income_id`),
  KEY `phone_no` (`phone_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `income`
--

INSERT INTO `income` (`phone_no`, `description`, `type_income`, `amount`, `date`, `income_id`) VALUES
('+254222222222', 'Kamau', 'Income', 33, '2014-12-31', 2),
('+254222222222', 'Bought medicine', 'Expense', 45.2, '2014-12-31', 3),
('+254222222222', 'ggggggggggggggg', 'Income', 45.2, '2014-03-18', 4),
('+254737012454', 'ddddddddddddddddd', 'Expense', 3333330000000, '2014-03-23', 7),
('+254737012454', 'jjjjjjjjjjjjjj', 'Income', 3333330000, '2014-03-07', 8),
('+254737012454', ',,,,,,,,,,,,,,,,,,', 'Expense', 45.2, '2014-03-23', 9),
('+254731053591', 'ddddddddddd', 'Income', 45.2, '2013-12-31', 10),
('+254731053591', '8888888888', 'Expense', 2000, '2014-03-16', 23),
('+254724015053', '...........', 'Income', 45.2, '2014-03-29', 24);

-- --------------------------------------------------------

--
-- Table structure for table `insemination`
--

CREATE TABLE IF NOT EXISTS `insemination` (
  `cow_id` varchar(10) NOT NULL,
  `date_insemination` date NOT NULL,
  `time_insemination` time NOT NULL,
  `method_insemination` varchar(40) NOT NULL,
  `bull_breed_source` varchar(20) NOT NULL,
  `doctor` varchar(30) NOT NULL,
  `insemination_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`insemination_id`),
  UNIQUE KEY `insemination_id` (`insemination_id`),
  KEY `cow_id` (`cow_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `insemination`
--

INSERT INTO `insemination` (`cow_id`, `date_insemination`, `time_insemination`, `method_insemination`, `bull_breed_source`, `doctor`, `insemination_id`) VALUES
('09KA02', '2014-03-14', '23:59:00', 'Artificial', 'freshian', 'njoroge', 3),
('BA001', '2014-03-05', '23:59:00', 'Artificial', 'fresian', 'kamau', 4),
('09KA09', '2014-04-10', '23:59:00', 'Artificial', 'freshian', 'kamau', 5),
('09KA00', '2014-04-01', '23:00:00', 'Artificial', 'freshian', 'njoroge', 6);

-- --------------------------------------------------------

--
-- Table structure for table `invalidmessage`
--

CREATE TABLE IF NOT EXISTS `invalidmessage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` varchar(13) NOT NULL,
  `receiver` varchar(13) NOT NULL,
  `msg` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sender` (`sender`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `invalidmessage`
--

INSERT INTO `invalidmessage` (`id`, `sender`, `receiver`, `msg`, `date`) VALUES
(1, '+254731053591', '+254724015053', 'p milk total daily ba001', '2014-03-29 21:20:49'),
(14, '+254731053591', '0', 'cowskkk', '2014-04-03 16:36:27'),
(15, '+254731053591', '0', 'cowskkk', '2014-04-03 16:36:41'),
(16, '+254731053591', '0', 'cowskkk', '2014-04-03 16:36:44'),
(17, '+254731053591', '0', 'cowskkk', '2014-04-03 16:36:46'),
(18, '+254731053591', '0', 'cowskkk', '2014-04-03 16:36:50'),
(19, '+254731053591', '0', 'x milk total daily ba001', '2014-04-19 11:22:59');

-- --------------------------------------------------------

--
-- Table structure for table `milkrecord`
--

CREATE TABLE IF NOT EXISTS `milkrecord` (
  `cow_id` varchar(10) NOT NULL,
  `morning_amount` float DEFAULT NULL,
  `evening_amount` float DEFAULT NULL,
  `date_cow` date NOT NULL,
  `milk_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`milk_id`),
  KEY `cow_id` (`cow_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=66 ;

--
-- Dumping data for table `milkrecord`
--

INSERT INTO `milkrecord` (`cow_id`, `morning_amount`, `evening_amount`, `date_cow`, `milk_id`) VALUES
('09KA02', 3, 2, '2013-01-01', 1),
('09KA02', 15, 14, '2013-01-05', 5),
('09KA02', 30, 20, '2013-01-07', 6),
('09KA02', 2, 3, '2014-03-06', 8),
('09KA07', 3, 3, '2014-03-15', 9),
('DK001', 6, 7, '2014-03-20', 30),
('KM001', 10, 8, '2014-03-22', 35),
('KM001', 10, 8.1, '2014-03-23', 36),
('KM001', 6, 9, '2014-03-24', 37),
('BA001', 7, 9, '2013-03-24', 40),
('BA001', 7, 9, '2014-03-11', 45),
('BA001', 3, 55, '2014-03-07', 46),
('BA001', 77, 55, '2014-03-06', 48),
('BA003', 3, 10, '2014-04-01', 49),
('BA003', 4, 2, '2014-03-01', 50),
('BA001', 33, 10, '2014-03-04', 51),
('BA001', 33, 10, '2014-03-02', 52),
('BA001', 33, 10, '2014-03-17', 55),
('BA001', 33, 10, '2014-03-29', 56),
('BA001', 33, 266, '2014-03-27', 57),
('BA001', 33, 10, '2014-03-26', 58),
('KAMAUY', 3, 5, '2014-04-02', 59),
('KAMAUY', 3, 55, '2014-04-01', 60),
('KAMAUY', 8, 2, '2014-04-07', 61),
('09KA09', 1, 25, '2014-04-01', 63),
('09KA09', 45, 2600000000000, '2014-04-09', 64),
('002', 25, 25, '2014-04-12', 65);

-- --------------------------------------------------------

--
-- Table structure for table `ozekimessagein`
--

CREATE TABLE IF NOT EXISTS `ozekimessagein` (
  `sender` varchar(13) NOT NULL,
  `receiver` varchar(13) NOT NULL,
  `msg` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `sender` (`sender`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2147483651 ;

--
-- Dumping data for table `ozekimessagein`
--

INSERT INTO `ozekimessagein` (`sender`, `receiver`, `msg`, `date`, `id`) VALUES
('+254731053591', '0', 'q milk total daily ba001', '2014-04-19 11:22:51', 2147483650);

-- --------------------------------------------------------

--
-- Table structure for table `ozekimessageout`
--

CREATE TABLE IF NOT EXISTS `ozekimessageout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` varchar(13) NOT NULL,
  `receiver` varchar(13) NOT NULL,
  `msg` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `receiver` (`receiver`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `ozekimessageout`
--

INSERT INTO `ozekimessageout` (`id`, `sender`, `receiver`, `msg`, `date`) VALUES
(2, '+254724015053', '+254731053591', 'Query Information Dennis, Sum morning and evening for Cow BA001 is ', '0000-00-00 00:00:00'),
(3, '+254724015053', '+254731053591', 'Query Information Dennis, Sum morning and evening for Cow BA001 is ', '2014-03-29 21:30:10'),
(4, '0', '+254731053591', 'Your Cow Id include: 09KA09, BA001, BA002, BA003, ', '2014-04-03 16:35:04'),
(5, '+254731284184', '+254731053591', 'Your Cow Id include: 09KA09, BA001, BA002, BA003, ', '2014-04-04 08:53:21'),
(6, '+254731284184', '+254731053591', 'Your Cow Id include: 09KA09, BA001, BA002, BA003, ', '2014-04-04 09:02:21'),
(7, '+254731284184', '+254724015053', 'Your Cow Id include: 09KA00, KAMAUY, ', '2014-04-07 11:28:11'),
(8, '+254731284184', '+254724015053', 'Your Cow Id include: 09KA00, KAMAUY, ', '2014-04-07 19:11:12'),
(9, '+254731284184', '+254724015053', 'Milk Information Updated Succesfully', '2014-04-07 19:12:48'),
(10, '+254731284184', '+254724015053', 'Get list of your cows, send word: cows\n				,to update milk record morning and evening send: u milk m=? e=? cow_id date[YYYY-MM-DD],\n					to update income/expense: u income/expense amount description date,\n					to add a reminder: u reminder date activity description,\n					to Query Milk Records:q milk total/average date/monthly/weekly/week=? cow_id/all,\n					to Query Income/Expense Profit, expenses &income: q all daily/weekly/monthly/week=?/date,\n					to Query Income or Expense: q income/expense, monthly/daily/weekly/week=?/date,\n					NOTE, NOT CASE SENSTIVE\n					', '2014-04-07 19:13:54'),
(11, '+254731284184', '+254724015053', 'Your Cow Id include: 09KA00, KAMAUY, ', '2014-04-08 11:02:23'),
(12, '0', '+254724015053', 'Query Information Joshua, Sum morning and evening for Cow BA001 is ', '2014-04-19 08:53:56'),
(13, '0', '+254724015053', 'Query Information Joshua, Sum morning and evening for Cow BA001 is ', '2014-04-19 08:57:09'),
(14, '0', '+254724015053', 'Query Information Joshua, Sum morning and evening for Cow BA001 is ', '2014-04-19 09:04:46'),
(15, '0', '+254724015053', 'Query Information Joshua, Sum morning and evening for Cow BA001 is ', '2014-04-19 09:04:49'),
(16, '0', '+254724015053', 'Query Information Joshua, Sum morning and evening for Cow BA001 is ', '2014-04-19 09:04:52'),
(17, '0', '+254731053591', 'Query Information Dennis, Sum morning and evening for Cow BA001 is ', '2014-04-19 11:22:51');

-- --------------------------------------------------------

--
-- Table structure for table `reminder`
--

CREATE TABLE IF NOT EXISTS `reminder` (
  `phone_no` varchar(13) NOT NULL,
  `date_set` date NOT NULL,
  `date_remind` date NOT NULL,
  `activity` varchar(40) NOT NULL,
  `description` text,
  `reminder_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`reminder_id`),
  UNIQUE KEY `reminder_id` (`reminder_id`),
  KEY `phone_no` (`phone_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `reminder`
--

INSERT INTO `reminder` (`phone_no`, `date_set`, `date_remind`, `activity`, `description`, `reminder_id`) VALUES
('+254222222222', '2014-03-18', '2014-03-27', 'Cattle', 'Dip all cows at Makuyu\nFarmers Dip', 1),
('+254222222222', '2014-03-18', '2014-03-19', 'Deworming', 'Cattle Deworming', 3),
('+254222222222', '2014-03-18', '2014-03-19', 'Treat Mastitis', 'Have the cows treated for mastitis', 4),
('+254333334444', '2014-03-19', '2014-03-20', 'Insemination', 'Call the veterinary to inseminate the cow.', 5),
('+254333334444', '2014-03-18', '2014-03-30', 'Insemination', 'llllllllllllll', 6),
('+254333334444', '2014-03-19', '2014-03-20', 'Cattle', 'kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk', 7),
('+254333334444', '2014-03-19', '2014-03-30', 'Insemination', 'llllllllllllllllllllllll', 8),
('+254713353604', '2014-03-20', '2014-03-30', 'Cattle', 'ddddddddddddddddddd', 37),
('+254728957117', '2014-03-20', '2014-03-21', 'Deworming', 'De-worm my cattle with a de-wormer', 46),
('+254731053591', '2014-04-18', '2014-04-27', 'Cattle', '.................', 47),
('+254702547125', '2014-04-08', '2014-04-09', 'Cattle Dipping', 'Dipping at Kenol Dip all cows', 49),
('+254731053591', '2014-04-18', '2014-04-25', 'Cattle', 'kdkkkddkkd', 50),
('+254724015053', '2014-04-19', '2014-12-31', 'fffff', 'dsdddsssssssssssssss', 51),
('+254724015053', '2014-04-19', '2014-10-05', 'dddddd', 'ssssssssssssss', 52);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `phone_no` varchar(13) NOT NULL,
  `fname` varchar(25) NOT NULL,
  `sname` varchar(25) NOT NULL,
  `gender` varchar(1) NOT NULL,
  `password` text NOT NULL,
  `confirmed_login` varchar(1) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`phone_no`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`phone_no`, `fname`, `sname`, `gender`, `password`, `confirmed_login`, `user_id`) VALUES
('+254000000000', 'Kenneth', 'Kamau', 'M', '82cdf867e9579d284a93d3c0223448d3', '0', 8),
('+254222222222', 'banga', 'BANGA', 'M', '4e257179772a18e4dc9cf9280e57c56c', '1', 4),
('+254333333333', 'butanga', 'kma', 'M', 'd07030bf4f79fdb47561d1d6d70828bc', '0', 6),
('+254333333334', 'Kma', 'kkskdk', 'M', '32639db9ccbc0455d0fb654e7bbdfc05', '0', 13),
('+254333334444', 'Kamau', 'kenaya', 'M', '51326c5bb67923d7a40b415e4296a202', '1', 15),
('+254444444444', 'banga', 'banga', 'M', '7f08d8843347bd557a1e0e93b136ff5e', '1', 7),
('+254700418712', 'Valentino', 'Shimanyi', 'M', 'b304d12155fc51aaf1db47b40292ec54', '1', 23),
('+254702075774', 'Vivian', 'O', 'M', 'ef6454c46da56ae242cfbcd023d6d61f', '1', 26),
('+254702148296', 'Erick', 'Kibet', 'M', '7f2a1a95486cdfec15f637cd6a8a00bf', '1', 17),
('+254702547125', 'Alexander', 'Mwangi', 'M', '6b34a8bba1dd1aaa9ac3fc1235f21f39', '1', 29),
('+254704596936', 'Cyrus', 'Wachira', 'M', 'a91edecd508cd9e5b3049e1918f0c6eb', '1', 21),
('+254707533075', 'Daniel', 'Mbugua', 'M', 'c2869b120d934ee28d3411cd8a13aae5', '1', 24),
('+254713353604', 'kenneth', 'Kamau', 'M', 'a1b920f10ac082e45d50b3c16b48a2c3', '1', 18),
('+254715757109', 'tony', 'young', 'M', '832e0fce202bd77509e31bb6b706acab', '1', 30),
('+254720281691', 'george', 'muga', 'M', '5ed6a5e2ae1fb654c27be4095e2c51cf', '1', 5),
('+254721567977', 'Anthony', 'Muriuki', 'M', '24bad578b642e353c602ddafd1a93fed', '1', 22),
('+254722222222', 'banga', 'dennis', 'M', 'bcec54d81eeafcc62f759e105d79fb55', '0', 14),
('+254724015053', 'Joshua', 'Muiruri', 'M', 'e4975f4a4b48593bae064581a28005b5', '1', 27),
('+254724441239', 'Patrick', 'Njogu', 'M', '9dcc7f7c341f77a6d814e6f1e0fc6df3', '1', 28),
('+254728957117', 'Frank', 'Njuguna', 'M', '2046b83af17a483efe991d1e3454f71d', '1', 20),
('+254731053591', 'Dennis', 'Banga', 'M', 'cf39d6ba2d4450f13cd49b5d62b356c0', '1', 16),
('+254737012454', 'Dancun', 'Kamau', 'M', '5c964f28cb97eb717bf96fc2f6a8e5b5', '1', 19),
('+254744444444', 'Vivian', 'kk', 'M', '0d906a38328b8e0b0d070c66e4719b13', '0', 25),
('+254909090900', 'mwangi', 'WaIria', 'M', '953343ef8cb26ac7c4c8e27ec60f7f7e', '0', 11),
('+254999999999', 'kamau', 'njoroge', 'M', 'dd32c0fc8172acd5312c1089a5aa4d33', '0', 10),
('254000000000', 'DENNIS', 'BANGA', 'F', '761cf01dbdd613109777a71dc0f611cb', '1', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users_location`
--

CREATE TABLE IF NOT EXISTS `users_location` (
  `county` varchar(30) NOT NULL,
  `district` varchar(40) NOT NULL,
  `location` varchar(40) NOT NULL,
  `area` varchar(40) NOT NULL,
  `phone_no` varchar(13) NOT NULL,
  PRIMARY KEY (`phone_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_location`
--

INSERT INTO `users_location` (`county`, `district`, `location`, `area`, `phone_no`) VALUES
('Murang''a', 'Kandara', 'Ruchu', 'Kangui', '+254222222222'),
('Murang''a', 'Kandara', 'Ruchu', 'Kangui', '+254333334444'),
('Murang''a', 'Kandara', 'Ruchu', 'Kangui', '+254444444444'),
('kkk', 'eee', 'edeee', 'sssssssssss', '+254700418712'),
('Murang''a', 'Kandara', 'Ruchu', 'Kangui', '+254702075774'),
('Nakuru', 'Nakuru', 'Gilgil', 'Munada', '+254702148296'),
('Murang''a', 'Kenol', 'Kenol', 'Kenol', '+254702547125'),
('Nairobi', 'Nakuru', 'Nakuru', 'kaharati', '+254704596936'),
('Nakuru', 'Nakuru', 'Nakuru', 'Nakuru', '+254707533075'),
('Murang''a', 'Kandara', 'Ithiru', 'Kiguoya', '+254713353604'),
('kisii', 'ibeno', 'kabosi', 'nyanturago', '+254715757109'),
('Nyeri', 'Nyeri', 'Magutu', 'kaharati', '+254721567977'),
('Murang''a', 'Kandara', 'Ruchu', 'Kangui', '+254724015053'),
('Nyeri', 'Nyeri', 'Nyeri Town', 'Nyeri Town', '+254724441239'),
('Kiambu', 'Ruiri', 'Ruiru', 'Ruiru', '+254728957117'),
('Murang''a', 'Kandara', 'Ruchu', 'Kangui', '+254731053591'),
('Nakuru', 'Nakuru', 'Gilgil', 'Kangui', '+254737012454');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `calving_register`
--
ALTER TABLE `calving_register`
  ADD CONSTRAINT `calving_register_ibfk_1` FOREIGN KEY (`cow_id`) REFERENCES `cow_detail` (`cow_id`);

--
-- Constraints for table `cow_detail`
--
ALTER TABLE `cow_detail`
  ADD CONSTRAINT `cow_detail_ibfk_2` FOREIGN KEY (`phone_no`) REFERENCES `users` (`phone_no`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `feedingrecord`
--
ALTER TABLE `feedingrecord`
  ADD CONSTRAINT `feedingrecord_ibfk_2` FOREIGN KEY (`cow_id`) REFERENCES `cow_detail` (`cow_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `health`
--
ALTER TABLE `health`
  ADD CONSTRAINT `health_ibfk_2` FOREIGN KEY (`cow_id`) REFERENCES `cow_detail` (`cow_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `income`
--
ALTER TABLE `income`
  ADD CONSTRAINT `income_ibfk_2` FOREIGN KEY (`phone_no`) REFERENCES `users` (`phone_no`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `insemination`
--
ALTER TABLE `insemination`
  ADD CONSTRAINT `insemination_ibfk_2` FOREIGN KEY (`cow_id`) REFERENCES `cow_detail` (`cow_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invalidmessage`
--
ALTER TABLE `invalidmessage`
  ADD CONSTRAINT `invalidmessage_ibfk_2` FOREIGN KEY (`sender`) REFERENCES `users` (`phone_no`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `milkrecord`
--
ALTER TABLE `milkrecord`
  ADD CONSTRAINT `milkrecord_ibfk_2` FOREIGN KEY (`cow_id`) REFERENCES `cow_detail` (`cow_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ozekimessagein`
--
ALTER TABLE `ozekimessagein`
  ADD CONSTRAINT `ozekimessagein_ibfk_2` FOREIGN KEY (`sender`) REFERENCES `users` (`phone_no`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ozekimessageout`
--
ALTER TABLE `ozekimessageout`
  ADD CONSTRAINT `ozekimessageout_ibfk_2` FOREIGN KEY (`receiver`) REFERENCES `users` (`phone_no`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reminder`
--
ALTER TABLE `reminder`
  ADD CONSTRAINT `reminder_ibfk_3` FOREIGN KEY (`phone_no`) REFERENCES `users` (`phone_no`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_location`
--
ALTER TABLE `users_location`
  ADD CONSTRAINT `users_location_ibfk_2` FOREIGN KEY (`phone_no`) REFERENCES `users` (`phone_no`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
