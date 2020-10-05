-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2019 at 09:50 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sportsnetfantasypage`
--

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `playerID` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `position` varchar(20) NOT NULL,
  `team` varchar(30) NOT NULL,
  `points/game` double NOT NULL,
  `assists/game` double NOT NULL,
  `rebounds/game` double NOT NULL,
  `fantasyTeamID` int(11) NOT NULL,
  `isAvailable` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `userfantasyteam`
--

CREATE TABLE `userfantasyteam` (
  `fantasyTeamID` int(11) NOT NULL,
  `fantasyTeamName` varchar(20) NOT NULL,
  `userId` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userfantasyteam`
--

INSERT INTO `userfantasyteam` (`fantasyTeamID`, `fantasyTeamName`, `userId`) VALUES
(1, 'THE BOYZ', 9),
(2, 'Cooking', 17),
(3, 'GOATS', 11),
(4, 'Cupcakes', 12),
(5, 'Walking Buckets', 13),
(6, 'Simmo Savages', 14),
(7, 'Infinite Clip', 15),
(8, 'Waste Yutes', 16),
(9, 'PG13', 18),
(10, 'NBA Overlords', 10);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `firstName` varchar(20) NOT NULL,
  `lastName` varchar(20) NOT NULL,
  `emailAddress` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `fantasyTeamID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `firstName`, `lastName`, `emailAddress`, `password`, `fantasyTeamID`) VALUES
(9, 'Nathanael', 'Meshesha', 'nmeshesha@rrc.ca', 'Password01', 0),
(10, 'Dale', 'Scott', 'dscott@rrc.ca', 'Password01', 0),
(11, 'Lebron', 'James', 'ljames@rrc.ca', 'Password01', 0),
(12, 'Kevin', 'Durant', 'kdurant@rrc.ca', 'Password01', 0),
(13, 'Devin', 'Booker', 'dbooker@rrc.ca', 'Password01', 0),
(14, 'Ben', 'Simmons', 'bsimmons@rrc.ca', 'Password01', 0),
(15, 'Joe', 'Harris', 'jharris@rrc.ca', 'Password01', 0),
(16, 'Klay', 'Thompson', 'kthompson@rrc.ca', 'Password01', 0),
(17, 'James', 'Harden', 'jharden@rrc.ca', 'Password01', 0),
(18, 'Paul', 'George', 'pgeorge@rrc.ca', 'Password01', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`playerID`),
  ADD KEY `FK_playersFantasyTeam` (`fantasyTeamID`);

--
-- Indexes for table `userfantasyteam`
--
ALTER TABLE `userfantasyteam`
  ADD PRIMARY KEY (`fantasyTeamID`),
  ADD KEY `FK_UsersFantasyTeam` (`userId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `playerID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userfantasyteam`
--
ALTER TABLE `userfantasyteam`
  MODIFY `fantasyTeamID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `players`
--
ALTER TABLE `players`
  ADD CONSTRAINT `FK_playersFantasyTeam` FOREIGN KEY (`fantasyTeamID`) REFERENCES `userfantasyteam` (`fantasyTeamID`);

--
-- Constraints for table `userfantasyteam`
--
ALTER TABLE `userfantasyteam`
  ADD CONSTRAINT `FK_UsersFantasyTeam` FOREIGN KEY (`userId`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
