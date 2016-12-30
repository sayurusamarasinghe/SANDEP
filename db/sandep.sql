-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2016 at 11:52 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sandep`
--

-- --------------------------------------------------------

--
-- Table structure for table `building_list`
--

CREATE TABLE `building_list` (
  `Building_Code` varchar(3) NOT NULL,
  `Location_Code` varchar(3) NOT NULL,
  `Building_Name` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `building_list`
--

INSERT INTO `building_list` (`Building_Code`, `Location_Code`, `Building_Name`) VALUES
('ENT', 'UOM', 'Department of Electronic and Telecommunication Engineering'),
('CPE', 'UOM', 'Department of Chemical and Process Engineering'),
('+', '+', 'Any');

-- --------------------------------------------------------

--
-- Table structure for table `city_list`
--

CREATE TABLE `city_list` (
  `City_Code` varchar(3) NOT NULL,
  `Country_Code` varchar(3) NOT NULL,
  `City_Name` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `city_list`
--

INSERT INTO `city_list` (`City_Code`, `Country_Code`, `City_Name`) VALUES
('MOR', 'SRL', 'Moratuwa'),
('PER', 'SRL', 'Peradeniya'),
('+', '+', 'Any');

-- --------------------------------------------------------

--
-- Table structure for table `country_list`
--

CREATE TABLE `country_list` (
  `Country_Code` varchar(3) NOT NULL,
  `Country_Name` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `country_list`
--

INSERT INTO `country_list` (`Country_Code`, `Country_Name`) VALUES
('SRL', 'Sri Lanka'),
('IND', 'India'),
('+', 'Any');

-- --------------------------------------------------------

--
-- Table structure for table `location_list`
--

CREATE TABLE `location_list` (
  `Location_Code` varchar(3) NOT NULL,
  `City_Code` varchar(3) NOT NULL,
  `Location_Name` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location_list`
--

INSERT INTO `location_list` (`Location_Code`, `City_Code`, `Location_Name`) VALUES
('UOM', 'MOR', 'University of Moratuwa'),
('+', '+', 'Any'),
('UOP', 'PER', 'University of Peradeniya'),
('KZN', 'MOR', 'K-Zone');

-- --------------------------------------------------------

--
-- Table structure for table `message_log`
--

CREATE TABLE `message_log` (
  `ID` int(11) NOT NULL,
  `Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Country` varchar(50) NOT NULL,
  `City` varchar(50) NOT NULL,
  `Location` varchar(50) NOT NULL,
  `Building` varchar(50) NOT NULL,
  `Node` varchar(50) NOT NULL,
  `Sensor` varchar(50) NOT NULL,
  `Message` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message_log`
--

INSERT INTO `message_log` (`ID`, `Date`, `Country`, `City`, `Location`, `Building`, `Node`, `Sensor`, `Message`) VALUES
(1, '2016-12-10 10:03:07', 'Sri Lanka', 'Colombo', 'Battaramulla', '', '', '', ''),
(2, '2016-12-10 10:03:07', 'UK', 'London', 'East', '', '', '', ''),
(3, '2016-12-10 00:00:00', 'UK', 'Oxford', 'Cityhall', 'Mall', 'Node2', 'Light', 'It is bright'),
(4, '2016-12-10 00:00:00', 'England', 'Oxford', 'Cityhall', 'Mall', 'Node2', 'Light', 'It is bright'),
(5, '2016-12-10 00:00:00', 'England', 'Oxford', 'Cityhall', 'Mall', 'Node2', 'Light', 'It is bright'),
(6, '2016-12-10 00:00:00', 'Japan', 'Tokyo', 'Cityhall', 'Mall', 'Node2', 'Light', 'It is sunny'),
(7, '2016-12-12 14:27:10', 'UK', 'Oxford', 'East', 'CityHall', 'Node200', 'Temperature', 'IT IS FREEZING'),
(92, '2016-12-12 15:54:45', 'Germany', 'Berlin', 'MainStreet', 'ShoppingMall', 'NodeZA', 'Light', 'IT IS BRIGHT'),
(93, '2016-12-12 15:54:45', 'Germany', 'Berlin', 'MainStreet', 'ShoppingMall', 'NodeZA', 'Light', 'IT IS BRIGHT'),
(94, '2016-12-12 16:01:27', 'Germany', 'Berlin', 'MainStreet', 'ShoppingMall', 'NodeZA', 'Light', 'IT IS BRIGHT'),
(95, '2016-12-12 16:01:27', 'Germany', 'Berlin', 'MainStreet', 'ShoppingMall', 'NodeZA', 'Light', 'IT IS BRIGHT'),
(96, '2016-12-12 16:01:27', 'Germany', 'Berlin', 'MainStreet', 'ShoppingMall', 'NodeZA', 'Light', 'IT IS BRIGHT'),
(97, '2016-12-12 16:06:19', 'Germany', 'Berlin', 'MainStreet', 'ShoppingMall', 'NodeZA', 'Light', 'IT IS BRIGHT'),
(98, '2016-12-12 16:06:19', 'Germany', 'Berlin', 'MainStreet', 'ShoppingMall', 'NodeZA', 'Light', 'IT IS BRIGHT'),
(99, '2016-12-12 16:06:19', 'Germany', 'Berlin', 'MainStreet', 'ShoppingMall', 'NodeZA', 'Light', 'IT IS BRIGHT'),
(100, '2016-12-12 16:06:19', 'Germany', 'Berlin', 'MainStreet', 'ShoppingMall', 'NodeZA', 'Light', 'IT IS BRIGHT'),
(101, '2016-12-12 16:08:51', 'UK', 'Oxford', 'East', 'CityHall', 'Node200', 'Temperature', 'IT IS FREEZING cc'),
(102, '2016-12-12 16:08:51', 'UK', 'Oxford', 'East', 'CityHall', 'Node200', 'Temperature', 'IT IS FREEZING cc'),
(103, '2016-12-12 16:08:51', 'UK', 'Oxford', 'East', 'CityHall', 'Node200', 'Temperature', 'IT IS FREEZING cc'),
(104, '2016-12-12 16:08:51', 'UK', 'Oxford', 'East', 'CityHall', 'Node200', 'Temperature', 'IT IS FREEZING cc'),
(105, '2016-12-12 16:10:43', 'UK', 'Oxford', 'East', 'CityHall', 'Node200', 'Temperature', 'IT IS FREEZING cc'),
(106, '2016-12-12 16:10:43', 'UK', 'Oxford', 'East', 'CityHall', 'Node200', 'Temperature', 'IT IS FREEZING cc'),
(107, '2016-12-12 16:10:43', 'UK', 'Oxford', 'East', 'CityHall', 'Node200', 'Temperature', 'IT IS FREEZING cc'),
(108, '2016-12-12 16:10:43', 'UK', 'Oxford', 'East', 'CityHall', 'Node200', 'Temperature', 'IT IS FREEZING cc'),
(109, '2016-12-12 16:10:43', 'UK', 'Oxford', 'East', 'CityHall', 'Node200', 'Temperature', 'IT IS FREEZING cc'),
(110, '2016-12-12 16:13:20', 'UK', 'Oxford', 'East', 'CityHall', 'Node200', 'Temperature', 'IT IS FREEZING cc'),
(111, '2016-12-12 16:13:20', 'UK', 'Oxford', 'East', 'CityHall', 'Node200', 'Temperature', 'IT IS FREEZING cc'),
(112, '2016-12-12 16:13:20', 'UK', 'Oxford', 'East', 'CityHall', 'Node200', 'Temperature', 'IT IS FREEZING cc'),
(113, '2016-12-12 16:13:20', 'UK', 'Oxford', 'East', 'CityHall', 'Node200', 'Temperature', 'IT IS FREEZING cc'),
(114, '2016-12-12 16:14:39', 'UK', 'Oxford', 'East', 'CityHall', 'Node200', 'Temperature', 'IT IS FREEZING cc'),
(115, '2016-12-12 16:14:55', 'UK', 'Oxford', 'East', 'CityHall', 'Node200', 'Temperature', 'IT IS FREEZING DD'),
(116, '2016-12-12 16:16:12', 'UK', 'Oxford', 'East', 'CityHall', 'Node200', 'Temperature', 'IT IS FREEZING AAA'),
(117, '2016-12-12 16:16:38', 'Germany', 'Berlin', 'MainStreet', 'ShoppingMall', 'NodeZA', 'Light', 'IT IS BRIGHT'),
(118, '2016-12-12 16:17:27', 'Germany', 'Berlin', 'MainStreet', 'ShoppingMall', 'NodeZA', 'Light', 'SUNNY'),
(119, '2016-12-12 16:19:33', 'Germany', 'Berlin', 'MainStreet', 'ShoppingMall', 'NodeZA', 'Light', 'SUNNY');

-- --------------------------------------------------------

--
-- Table structure for table `nodes`
--

CREATE TABLE `nodes` (
  `NodeID` varchar(4) NOT NULL,
  `Country` varchar(3) NOT NULL,
  `City` varchar(3) NOT NULL,
  `Location` varchar(3) NOT NULL,
  `Building` varchar(3) NOT NULL,
  `Node_Number` tinyint(4) NOT NULL,
  `Started_Time` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nodes`
--

INSERT INTO `nodes` (`NodeID`, `Country`, `City`, `Location`, `Building`, `Node_Number`, `Started_Time`) VALUES
('001', 'SRL', 'MOR', 'UOM', 'ENT', 1, '2016-11-15 02:13:06'),
('002', 'SRL', 'MOR', 'UOM', 'ENT', 2, '2016-11-16 15:24:51'),
('003', 'SRL', 'MOR', 'UOM', 'CPE', 1, '2016-11-17 06:41:19');

-- --------------------------------------------------------

--
-- Table structure for table `node_sensors`
--

CREATE TABLE `node_sensors` (
  `NodeID` varchar(4) NOT NULL,
  `Sensor_Code` varchar(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `node_sensors`
--

INSERT INTO `node_sensors` (`NodeID`, `Sensor_Code`) VALUES
('001', 'ATM'),
('001', 'TEM'),
('002', 'HUM'),
('002', 'TEM');

-- --------------------------------------------------------

--
-- Table structure for table `sensor_list`
--

CREATE TABLE `sensor_list` (
  `Sensor_Code` varchar(3) NOT NULL,
  `Sensor_Name` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sensor_list`
--

INSERT INTO `sensor_list` (`Sensor_Code`, `Sensor_Name`) VALUES
('TEM', 'Temperature'),
('ATM', 'Atmospheric Pressure'),
('HUM', 'Humidity'),
('+', 'Any');

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `Email` varchar(30) NOT NULL,
  `Country` varchar(3) NOT NULL,
  `City` varchar(3) NOT NULL,
  `Location` varchar(3) NOT NULL,
  `Building` varchar(3) NOT NULL,
  `Node_Number` varchar(3) NOT NULL,
  `Sensor_Code` varchar(3) NOT NULL,
  `Timestamp` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`Email`, `Country`, `City`, `Location`, `Building`, `Node_Number`, `Sensor_Code`, `Timestamp`) VALUES
('sayurusamarasinghe@yahoo.com', 'SRL', 'MOR', 'UOM', 'ENT', '1', 'TEM', '2016-11-26 08:19:19'),
('sayurusamarasinghe@yahoo.com', 'SRL', 'MOR', 'UOM', 'CPE', '1', 'ATM', '2016-11-27 16:38:41'),
('sayurusamarasinghe@yahoo.com', 'SRL', 'MOR', 'UOM', 'ENT', '2', 'TEM', '2016-11-27 21:09:34'),
('sayurusamarasinghe@yahoo.com', 'SRL', '+', '+', '+', '1', 'ATM', '2016-12-10 19:35:11'),
('sayurusamarasinghe@yahoo.com', 'SRL', '+', 'UOM', '+', '1', '+', '2016-12-10 19:29:52'),
('sayurusamarasinghe@yahoo.com', 'SRL', '+', 'UOM', 'ENT', '+', 'ATM', '2016-12-10 19:27:31'),
('sayurusamarasinghe@yahoo.com', 'SRL', 'MOR', 'UOM', 'ENT', '1', '+', '2016-12-10 19:17:13'),
('sayurusamarasinghe@yahoo.com', 'SRL', 'MOR', 'UOM', 'ENT', '1', 'ATM', '2016-12-10 19:17:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Nickname` varchar(15) NOT NULL,
  `First_Name` varchar(15) NOT NULL,
  `Last_Name` varchar(20) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `DOB` date NOT NULL,
  `Password` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Nickname`, `First_Name`, `Last_Name`, `Email`, `DOB`, `Password`) VALUES
('Sparky', 'Sayuru', 'Samarasinghe', 'sayurusamarasinghe@yahoo.com', '1993-01-06', '29aa7acafb73866d6571e1a72f46c146');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `building_list`
--
ALTER TABLE `building_list`
  ADD PRIMARY KEY (`Building_Code`,`Location_Code`);

--
-- Indexes for table `city_list`
--
ALTER TABLE `city_list`
  ADD PRIMARY KEY (`City_Code`,`Country_Code`);

--
-- Indexes for table `country_list`
--
ALTER TABLE `country_list`
  ADD PRIMARY KEY (`Country_Code`);

--
-- Indexes for table `location_list`
--
ALTER TABLE `location_list`
  ADD PRIMARY KEY (`Location_Code`,`City_Code`);

--
-- Indexes for table `message_log`
--
ALTER TABLE `message_log`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID` (`ID`);

--
-- Indexes for table `nodes`
--
ALTER TABLE `nodes`
  ADD PRIMARY KEY (`NodeID`);

--
-- Indexes for table `node_sensors`
--
ALTER TABLE `node_sensors`
  ADD PRIMARY KEY (`NodeID`,`Sensor_Code`);

--
-- Indexes for table `sensor_list`
--
ALTER TABLE `sensor_list`
  ADD PRIMARY KEY (`Sensor_Code`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`Email`,`Country`,`City`,`Location`,`Building`,`Node_Number`,`Sensor_Code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `message_log`
--
ALTER TABLE `message_log`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
