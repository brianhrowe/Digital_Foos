-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 05, 2012 at 05:22 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

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
(13, '2012-07-27 02:12:09', 'guys', 'guy1', 'guy2', 'girls', 'girl1', 'girl2', '3-5', '4-5', '7-8', 3, 'b', 'b', 'b', 'over', 'ksq_tornado_sport', 'team1'),
(14, '2012-07-27 02:38:17', 'team11', 'guy1', 'guy2', 'team22', 'girl1', 'girl2', '3-5', '4-5', '7-8', 3, 'b', 'b', 'b', 'over', 'ksq_tornado_sport', 'team1'),
(15, '2012-07-27 02:41:05', 'team11', 'guy1', 'guy2', 'team22', 'girl1', 'girl2', '3-5', '4-5', '7-8', 3, 'b', 'b', 'b', 'over', 'ksq_tornado_sport', 'team1'),
(16, '2012-07-27 02:54:10', 'team11', 'guy1', 'guy2', 'team22', 'girl1', 'girl2', '3-5', '4-5', '7-8', 3, 'b', 'b', 'b', 'over', 'ksq_tornado_sport', 'team1'),
(17, '2012-07-27 03:32:56', 'team11', 'guy1', 'guy2', 'team22', 'girl1', 'girl2', '3-5', '4-5', '7-8', 3, 'b', 'b', 'b', 'over', 'ksq_tornado_sport', 'team1'),
(18, '2012-07-27 04:29:54', 'Awesome-Os', 'Pooper-Scooper', 'Donkey Punch', 'Peoples', 'Thing 1', 'Thing 2', '3-5', '4-5', '7-8', 3, 'b', 'b', 'b', 'over', 'ksq_tornado_sport', 'team1'),
(19, '2012-07-27 04:32:08', 'Awesome-Os', 'Pooper-Scooper', 'Donkey Punch', 'Peoples', 'Thing 1', 'Thing 2', '3-5', '4-5', '7-8', 3, 'b', 'b', 'b', 'over', 'ksq_tornado_sport', 'team1'),
(20, '2012-08-03 02:42:40', 'Team1s', 'T1_P1', 'T1_P2', 'Team2s', 'T2_P1', 'T2_P2', '3-5', '4-5', '7-8', 3, 'b', 'b', 'b', 'over', 'ksq_tornado_sport', 'team1'),
(21, '2012-08-03 03:03:57', 'Team1s', 'T1_P1', 'T1_P2', 'Team2s', 'T2_P1', 'T2_P2', '3-5', '4-5', '7-8', 3, 'b', 'b', 'b', 'over', 'ksq_tornado_sport', 'team1'),
(22, '2012-08-03 03:06:01', 'Team1s', 'T1_P1', 'T1_P2', 'Team2s', 'T2_P1', 'T2_P2', '3-5', '4-5', '7-8', 3, 'b', 'b', 'b', 'over', 'ksq_tornado_sport', 'team1'),
(23, '2012-08-03 03:39:20', 'Awesome-Os', 'Pooper-Scooper', 'Donkey Punch', 'Peoples', 'Thing 1', 'Thing 2', '3-5', '4-5', '7-8', 3, 'b', 'b', 'b', 'over', 'ksq_tornado_sport', 'team1'),
(24, '2012-08-03 04:19:16', 'Awesome-Os', 'Pooper-Scooper', 'Donkey Punch', 'Peoples', 'Thing 1', 'Thing 2', '3-5', '4-5', '7-8', 3, 'b', 'b', 'b', 'over', 'ksq_tornado_sport', 'team1'),
(25, '2012-08-03 05:02:24', 'Awesome-Os', 'Pooper-Scooper', 'Donkey Punch', 'Peoples', 'Thing 1', 'Thing 2', '3-5', '4-5', '7-8', 3, 'b', 'b', 'b', 'over', 'ksq_tornado_sport', 'team1'),
(26, '2012-08-03 05:23:18', 'Awesome-Os', 'Pooper-Scooper', 'Donkey Punch', 'Peoples', 'Thing 1', 'Thing 2', '3-5', '4-5', '7-8', 3, 'b', 'b', 'b', 'over', 'ksq_tornado_sport', 'team1'),
(27, '2012-08-05 00:59:12', 'Awesome-Os', 'Pooper-Scooper', 'Donkey Punch', 'Peoples', 'Thing 1', 'Thing 2', '3-5', '4-5', '7-8', 3, 'b', 'b', 'b', 'over', 'ksq_tornado_sport', 'team1'),
(28, '2012-08-05 02:54:21', 'Awesome-Os', 'Pooper-Scooper', 'Donkey Punch', 'Peoples', 'Thing 1', 'Thing 2', '3-5', '4-5', '7-8', 3, 'b', 'b', 'b', 'over', 'ksq_tornado_sport', 'team1'),
(29, '2012-08-05 03:41:24', 'Ubernerds', 'Nerd 1', 'Nerd 2', 'Crazy Dorks', 'Dork 1', 'Dork 2', '3-5', '4-5', '7-8', 3, 'b', 'b', 'b', 'over', 'ksq_tornado_sport', 'team1');

-- --------------------------------------------------------

--
-- Table structure for table `tz_members`
--

CREATE TABLE IF NOT EXISTS `tz_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usr` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `pass` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `regIP` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `dt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `usr` (`usr`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tz_members`
--

INSERT INTO `tz_members` (`id`, `usr`, `pass`, `email`, `regIP`, `dt`) VALUES
(1, 'carbonguy9', '08e5f28398c13ea53964afbc082d62e9', 'carbonguy9@gmail.com', '127.0.0.1', '2012-08-22 00:00:39'),
(2, 'emailuser4321', 'pass1234', 'emailuser4321@gmail.com', '127.0.0.1', '2012-08-26 22:22:38');

-- --------------------------------------------------------

--
-- Table structure for table `users_accounts`
--

CREATE TABLE IF NOT EXISTS `users_accounts` (
  `userid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(32) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `user_handle` varchar(32) NOT NULL,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `height` varchar(10) NOT NULL,
  `weight` varchar(10) NOT NULL,
  `dob` varchar(10) NOT NULL,
  `avatar` varchar(32) NOT NULL DEFAULT 'default.jpg',
  `jersey` int(11) NOT NULL,
  `teams` varchar(255) NOT NULL,
  `bio` text NOT NULL,
  `motto` varchar(255) NOT NULL,
  `play_style` varchar(32) NOT NULL,
  `shots` varchar(255) NOT NULL,
  `dt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `regIP` varchar(15) NOT NULL,
  PRIMARY KEY (`userid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

--
-- Dumping data for table `users_accounts`
--

INSERT INTO `users_accounts` (`userid`, `email`, `username`, `password`, `user_handle`, `first_name`, `last_name`, `height`, `weight`, `dob`, `avatar`, `jersey`, `teams`, `bio`, `motto`, `play_style`, `shots`, `dt`, `regIP`) VALUES
(1, 'brian.rowe@modea.com', 'brian.rowe', 'pass1234', 'Crash Override', 'Brian', 'Rowe', '6''2"', '199', '6-16-84', 'me.jpg', 1, 'Uber_Guys||Awesome-0''s', 'Blah Blah Blah.', 'Mess with the best, Die like the rest.', 'All Around', 'Pull||Push', '0000-00-00 00:00:00', ''),
(2, 'emailuser4321@gmail.com', 'emailuser4321', 'pass1234', 'Special Person', 'Eddie', 'Van Halen', '', '', '', 'default.jpg', 0, '', '', '', '', '', '2012-08-26 23:00:23', '127.0.0.1'),
(3, 'asdfsdf@asdf.com', 'asdfds', 'fdsasdf', '', '', '', '', '', '', 'default.jpg', 0, '', '', '', '', '', '2012-08-28 01:27:59', '127.0.0.1'),
(4, 'brian.rowe@modea.com', 'bbbbbbbb', 'pass1234', '', '', '', '', '', '', 'default.jpg', 0, '', '', '', '', '', '2012-08-28 14:52:58', '127.0.0.1'),
(7, 'brian.rowe@modea.com', 'asdffdsa', 'saberpie1', '', '', '', '', '', '', 'default.jpg', 0, '', '', '', '', '', '2012-08-28 14:54:02', '127.0.0.1'),
(9, 'brian.rowe@modea.com', 'bhrowe01', 'pass1234', '', '', '', '', '', '', 'default.jpg', 0, '', '', '', '', '', '2012-08-28 15:19:58', '127.0.0.1'),
(11, 'brian.rowe@modea.com', 'bhrowe02', 'pass1234', '', '', '', '', '', '', 'default.jpg', 0, '', '', '', '', '', '2012-08-28 15:22:10', '127.0.0.1'),
(13, 'brian.rowe@modea.com', 'bhrowe03', 'pass1234', '', '', '', '', '', '', 'default.jpg', 0, '', '', '', '', '', '2012-08-28 15:23:31', '127.0.0.1'),
(42, 'brian.rowe@modea.com', 'bhrowe04', 'fastssks', '', '', '', '', '', '', 'default.jpg', 0, '', '', '', '', '', '2012-08-28 15:34:10', '127.0.0.1'),
(45, 'brian.rowe@modea.com', 'bhrowe05', 'fastssks', '', '', '', '', '', '', 'default.jpg', 0, '', '', '', '', '', '2012-08-28 15:35:33', '127.0.0.1'),
(47, 'brian.rowe@modea.com', 'bhrowe06', 'fastssks', '', '', '', '', '', '', 'default.jpg', 0, '', '', '', '', '', '2012-08-28 15:36:01', '127.0.0.1'),
(49, 'brian.rowe@modea.com', 'asdfasdfsdsd', 'asdlfasjdl;fskj', '', '', '', '', '', '', 'default.jpg', 0, '', '', '', '', '', '2012-08-28 15:37:14', '127.0.0.1'),
(51, 'brian.rowe@modea.com', 'asdfasdfsdsddd', 'asdlfasjdl;fskj', '', '', '', '', '', '', 'default.jpg', 0, '', '', '', '', '', '2012-08-28 15:37:53', '127.0.0.1'),
(53, 'brian.rowe@modea.com', 'asdfasdfsdsdddwwe', 'asdlfasjdl;fskj', '', '', '', '', '', '', 'default.jpg', 0, '', '', '', '', '', '2012-08-28 15:39:06', '127.0.0.1'),
(55, 'brian.rowe@modea.com', 'asdfasdfsdsdddwwesdf', 'asdlfasjdl;fskj', '', '', '', '', '', '', 'default.jpg', 0, '', '', '', '', '', '2012-08-28 15:46:53', '127.0.0.1'),
(57, 'brian.rowe@modea.com', 'ffffddddss', 'asdlfasjdl;fskj', '', '', '', '', '', '', 'default.jpg', 0, '', '', '', '', '', '2012-08-28 15:48:36', '127.0.0.1'),
(58, 'brian.rowe@modea.comd', 'ffffddddsssd1', 'asdlfasjdl;fskj', '', '', '', '', '', '', 'default.jpg', 0, '', '', '', '', '', '2012-08-28 15:49:22', '127.0.0.1'),
(59, 'brian.rowe@modea.comd', 'sdfss3333fs', 'asdlfasjdl;fskj', '', '', '', '', '', '', 'default.jpg', 0, '', '', '', '', '', '2012-08-28 16:42:29', '127.0.0.1'),
(61, '1234567@gmail.com', '1234567', 'asdf', '', '', '', '', '', '', 'default.jpg', 0, '', '', '', '', '', '2012-08-28 17:00:04', '127.0.0.1');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
