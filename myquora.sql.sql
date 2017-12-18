-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2017 at 08:30 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `quora`
--

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
`post_id` int(255) NOT NULL,
  `post_data` text NOT NULL,
  `send_from_id` int(255) NOT NULL,
  `send_to_id` int(255) NOT NULL,
  `post_pic` text NOT NULL,
  `action` int(11) NOT NULL,
  `reply_count` int(11) NOT NULL,
  `flag` int(11) NOT NULL,
  `time` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

--
-- Dumping data for table `post`
--


-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

--
-- Dumping data for table `quiz`
--


-- --------------------------------------------------------

--
-- Table structure for table `quiz_signup`
--


-- --------------------------------------------------------

--
-- Table structure for table `rate`
--

CREATE TABLE IF NOT EXISTS `rate` (
`rate_id` int(255) NOT NULL,
  `reply_id` int(255) NOT NULL,
  `rate_by` int(255) NOT NULL,
  `rate_to` int(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `rate`
--


-- --------------------------------------------------------

--
-- Table structure for table `reply`
--

CREATE TABLE IF NOT EXISTS `reply` (
`reply_id` int(255) NOT NULL,
  `reply_by` int(255) NOT NULL,
  `reply_to` int(255) NOT NULL,
  `reply` text NOT NULL,
  `question_id` int(255) NOT NULL,
  `rating` int(255) NOT NULL,
  `reply_time` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `reply`
--


-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE IF NOT EXISTS `request` (
`request_id` int(255) NOT NULL,
  `sent_from_id` int(255) NOT NULL,
  `sent_to_id` int(255) NOT NULL,
  `flag` int(11) NOT NULL,
  `punish_flag` int(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `request`
--


-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE IF NOT EXISTS `topic` (
`topic_id` int(255) NOT NULL,
  `topic_name` text NOT NULL,
  `topic_desc` text NOT NULL,
  `topic_pic` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `suscriber` int(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `topic`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`user_id` int(255) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `status` text NOT NULL,
  `school` text NOT NULL,
  `organization` text NOT NULL,
  `hobbies` text NOT NULL,
  `highest_degree` text NOT NULL,
  `lives_in` text NOT NULL,
  `hometown` text NOT NULL,
  `cover_pic` text NOT NULL,
  `profile_pic` text NOT NULL,
  `since` text NOT NULL,
  `salute` int(255) NOT NULL,
  `quiz` int(255) NOT NULL,
  `topic` int(255) NOT NULL,
  `whatilike` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `user`
--


-- --------------------------------------------------------

--
-- Table structure for table `whatilike`
--

CREATE TABLE IF NOT EXISTS `whatilike` (
`likeid` int(255) NOT NULL,
  `myid` int(11) NOT NULL,
  `mylike` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `whatilike`
--


--
-- Indexes for dumped tables
--

--
-- Indexes for table `post`
--
ALTER TABLE `post`
 ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `quiz`
--
--
-- Indexes for table `rate`
--
ALTER TABLE `rate`
 ADD PRIMARY KEY (`rate_id`);

--
-- Indexes for table `reply`
--
ALTER TABLE `reply`
 ADD PRIMARY KEY (`reply_id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
 ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `topic`
--
ALTER TABLE `topic`
 ADD PRIMARY KEY (`topic_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `whatilike`
--

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
MODIFY `post_id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `quiz`
--
--
-- AUTO_INCREMENT for table `rate`
--
ALTER TABLE `rate`
MODIFY `rate_id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reply`
--
ALTER TABLE `reply`
MODIFY `reply_id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
MODIFY `request_id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `topic`
--
ALTER TABLE `topic`
MODIFY `topic_id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `whatilike`
--
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
