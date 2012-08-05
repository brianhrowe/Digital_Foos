-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 05, 2012 at 05:48 PM
-- Server version: 5.5.20
-- PHP Version: 5.3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `modea_foos`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts_session`
--

CREATE TABLE IF NOT EXISTS `accounts_session` (
  `sessionid` varchar(32) NOT NULL,
  `userid` int(10) NOT NULL,
  `timestamp` int(12) NOT NULL,
  PRIMARY KEY (`sessionid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

CREATE TABLE IF NOT EXISTS `matches` (
  `match_id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `team1` varchar(32) NOT NULL DEFAULT 'Team 1',
  `player1_1` varchar(32) NOT NULL DEFAULT 'player1_1',
  `player1_2` varchar(32) NOT NULL DEFAULT 'player1_2',
  `team2` varchar(32) NOT NULL DEFAULT 'Team 2',
  `player2_1` varchar(32) NOT NULL DEFAULT 'player2_1',
  `player2_2` varchar(32) NOT NULL DEFAULT 'player2_2',
  `game1Score` varchar(3) NOT NULL DEFAULT '0-0',
  `game2Score` varchar(3) NOT NULL DEFAULT '0-0',
  `game3Score` varchar(3) NOT NULL DEFAULT '0-0',
  `currentGame` int(11) NOT NULL DEFAULT '1',
  `game1Winner` varchar(6) NOT NULL DEFAULT 'none',
  `game2Winner` varchar(6) NOT NULL DEFAULT 'none',
  `game3Winner` varchar(6) NOT NULL DEFAULT 'none',
  `status` varchar(15) NOT NULL DEFAULT 'in_progress',
  `table` varchar(30) NOT NULL DEFAULT 'ugc_tornado',
  `winner` varchar(20) NOT NULL DEFAULT 'none',
  PRIMARY KEY (`match_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `matches`
--

INSERT INTO `matches` (`match_id`, `time`, `team1`, `player1_1`, `player1_2`, `team2`, `player2_1`, `player2_2`, `game1Score`, `game2Score`, `game3Score`, `currentGame`, `game1Winner`, `game2Winner`, `game3Winner`, `status`, `table`, `winner`) VALUES
(13, '2012-07-27 02:12:09', 'guys', 'guy1', 'guy2', 'girls', 'girl1', 'girl2', '3-5', '4-5', '5-4', 3, 'b', 'b', 'y', 'over', 'ksq_tornado_sport', 'team2'),
(14, '2012-07-27 02:38:17', 'team11', 'guy1', 'guy2', 'team22', 'girl1', 'girl2', '3-5', '4-5', '5-4', 3, 'b', 'b', 'y', 'over', 'ksq_tornado_sport', 'team2'),
(15, '2012-07-27 02:41:05', 'team11', 'guy1', 'guy2', 'team22', 'girl1', 'girl2', '3-5', '4-5', '5-4', 3, 'b', 'b', 'y', 'over', 'ksq_tornado_sport', 'team2'),
(16, '2012-07-27 02:54:10', 'team11', 'guy1', 'guy2', 'team22', 'girl1', 'girl2', '3-5', '4-5', '5-4', 3, 'b', 'b', 'y', 'over', 'ksq_tornado_sport', 'team2'),
(17, '2012-07-27 03:32:56', 'team11', 'guy1', 'guy2', 'team22', 'girl1', 'girl2', '3-5', '4-5', '5-4', 3, 'b', 'b', 'y', 'over', 'ksq_tornado_sport', 'team2'),
(18, '2012-07-27 04:29:54', 'Awesome-Os', 'Pooper-Scooper', 'Donkey Punch', 'Peoples', 'Thing 1', 'Thing 2', '3-5', '4-5', '5-4', 3, 'b', 'b', 'y', 'over', 'ksq_tornado_sport', 'team2'),
(19, '2012-07-27 04:32:08', 'Awesome-Os', 'Pooper-Scooper', 'Donkey Punch', 'Peoples', 'Thing 1', 'Thing 2', '3-5', '4-5', '5-4', 3, 'b', 'b', 'y', 'over', 'ksq_tornado_sport', 'team2'),
(20, '2012-08-03 02:42:40', 'Team1s', 'T1_P1', 'T1_P2', 'Team2s', 'T2_P1', 'T2_P2', '3-5', '4-5', '5-4', 3, 'b', 'b', 'y', 'over', 'ksq_tornado_sport', 'team2'),
(21, '2012-08-03 03:03:57', 'Team1s', 'T1_P1', 'T1_P2', 'Team2s', 'T2_P1', 'T2_P2', '3-5', '4-5', '5-4', 3, 'b', 'b', 'y', 'over', 'ksq_tornado_sport', 'team2'),
(22, '2012-08-03 03:06:01', 'Team1s', 'T1_P1', 'T1_P2', 'Team2s', 'T2_P1', 'T2_P2', '3-5', '4-5', '5-4', 3, 'b', 'b', 'y', 'over', 'ksq_tornado_sport', 'team2'),
(23, '2012-08-03 03:39:20', 'Awesome-Os', 'Pooper-Scooper', 'Donkey Punch', 'Peoples', 'Thing 1', 'Thing 2', '3-5', '4-5', '5-4', 3, 'b', 'b', 'y', 'over', 'ksq_tornado_sport', 'team2'),
(24, '2012-08-03 04:19:16', 'Awesome-Os', 'Pooper-Scooper', 'Donkey Punch', 'Peoples', 'Thing 1', 'Thing 2', '3-5', '4-5', '5-4', 3, 'b', 'b', 'y', 'over', 'ksq_tornado_sport', 'team2'),
(25, '2012-08-03 05:02:24', 'Awesome-Os', 'Pooper-Scooper', 'Donkey Punch', 'Peoples', 'Thing 1', 'Thing 2', '3-5', '4-5', '5-4', 3, 'b', 'b', 'y', 'over', 'ksq_tornado_sport', 'team2'),
(26, '2012-08-03 05:23:18', 'Awesome-Os', 'Pooper-Scooper', 'Donkey Punch', 'Peoples', 'Thing 1', 'Thing 2', '3-5', '4-5', '5-4', 3, 'b', 'b', 'y', 'over', 'ksq_tornado_sport', 'team2'),
(27, '2012-08-05 00:59:12', 'Awesome-Os', 'Pooper-Scooper', 'Donkey Punch', 'Peoples', 'Thing 1', 'Thing 2', '3-5', '4-5', '5-4', 3, 'b', 'b', 'y', 'over', 'ksq_tornado_sport', 'team2'),
(28, '2012-08-05 02:54:21', 'Awesome-Os', 'Pooper-Scooper', 'Donkey Punch', 'Peoples', 'Thing 1', 'Thing 2', '3-5', '4-5', '5-4', 3, 'b', 'b', 'y', 'over', 'ksq_tornado_sport', 'team2'),
(29, '2012-08-05 03:41:24', 'Ubernerds', 'Nerd 1', 'Nerd 2', 'Crazy Dorks', 'Dork 1', 'Dork 2', '3-5', '4-5', '5-4', 3, 'b', 'b', 'none', 'in_progress', 'ksq_tornado_sport', 'none');

-- --------------------------------------------------------

--
-- Table structure for table `users_accounts`
--

CREATE TABLE IF NOT EXISTS `users_accounts` (
  `userid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
