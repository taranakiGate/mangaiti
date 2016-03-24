-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2016 at 02:30 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pohehe_training`
--
CREATE DATABASE IF NOT EXISTS `pohehe_training` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `pohehe_training`;

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `sp_addGrade`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_addGrade`(IN `userid` INT, IN `score` DECIMAL(10,2), IN `topicnumber` INT, IN `date` DATE)
    NO SQL
insert into grade 
(studentID,
 grade,
 quizID,
 quizDate) 
 values 
 (userid,
  score,
  topicnumber,
  date)$$

DROP PROCEDURE IF EXISTS `sp_addInProgress`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_addInProgress`(IN `score` DECIMAL(10,2), IN `topicnumber` INT, IN `date` DATE, IN `questionno` INT, IN `student` INT)
    NO SQL
insert into inprogress 
(studentID,
currentgrade,
quizID,
date,
currentquestion) 
values 
(student,
score,
topicnumber,
date,
questionno)$$

DROP PROCEDURE IF EXISTS `sp_fetchAnswer`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_fetchAnswer`(IN `topic` INT, IN `question` INT)
    NO SQL
select ranswer
from   questions
where  qnumber=question 
and    quizID=topic$$

DROP PROCEDURE IF EXISTS `sp_fetchQuestions`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_fetchQuestions`(IN `topic` INT, IN `question` INT)
    NO SQL
select * 
from   questions 
where  quizID=topic  
and    qnumber=question$$

DROP PROCEDURE IF EXISTS `sp_fetchTopic`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_fetchTopic`(IN `topic` INT)
    NO SQL
select name 
from   quiz 
where  id=topic$$

DROP PROCEDURE IF EXISTS `sp_questionCount`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_questionCount`(IN `topic` INT)
    NO SQL
select count(*) 
from  questions 
where quizID=topic$$

DROP PROCEDURE IF EXISTS `sp_saveBadAnswer`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_saveBadAnswer`(IN `topic` INT, IN `question` INT, IN `badAnswer` VARCHAR(255), IN `student` INT(0000), IN `date` DATE)
    NO SQL
insert into badAnswer 
(quizID,
 questionNumber,
 badAnswer,
 student,
 quizDate) 
values (
topic,
question,
badanswer,
student,
date)$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `badanswer`
--

DROP TABLE IF EXISTS `badanswer`;
CREATE TABLE IF NOT EXISTS `badanswer` (
  `ID` mediumint(9) NOT NULL AUTO_INCREMENT,
  `quizID` int(11) NOT NULL,
  `questionNumber` int(11) NOT NULL,
  `badAnswer` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `quizDate` date NOT NULL,
  `student` varchar(100) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

-- --------------------------------------------------------

--
-- Table structure for table `grade`
--

DROP TABLE IF EXISTS `grade`;
CREATE TABLE IF NOT EXISTS `grade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grade` decimal(10,2) NOT NULL,
  `studentID` int(11) NOT NULL,
  `quizID` int(11) NOT NULL,
  `quizDate` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_bin AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `inprogress`
--

DROP TABLE IF EXISTS `inprogress`;
CREATE TABLE IF NOT EXISTS `inprogress` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `studentID` int(11) NOT NULL,
  `priorquestion` int(11) NOT NULL,
  `currentquestion` int(11) NOT NULL,
  `currentgrade` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `quizID` mediumint(9) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=94 ;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `qid` int(11) NOT NULL AUTO_INCREMENT,
  `question` text,
  `ranswer` varchar(255) DEFAULT NULL,
  `wanswer1` varchar(255) DEFAULT NULL,
  `wanswer2` varchar(255) DEFAULT NULL,
  `wanswer3` varchar(255) DEFAULT NULL,
  `qnumber` int(11) DEFAULT NULL,
  `quizID` int(11) NOT NULL,
  `questiontype` tinyint(4) NOT NULL,
  PRIMARY KEY (`qid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=138 ;

-- --------------------------------------------------------

--
-- Table structure for table `quiz`
--

DROP TABLE IF EXISTS `quiz`;
CREATE TABLE IF NOT EXISTS `quiz` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `updated` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `stid` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(20) DEFAULT NULL,
  `firstname` varchar(20) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `companyID` int(11) NOT NULL DEFAULT '2',
  PRIMARY KEY (`stid`,`companyID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Table structure for table `studentspending`
--

DROP TABLE IF EXISTS `studentspending`;
CREATE TABLE IF NOT EXISTS `studentspending` (
  `stid` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(20) DEFAULT NULL,
  `firstname` varchar(20) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `companyID` int(11) NOT NULL DEFAULT '2',
  PRIMARY KEY (`stid`,`companyID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
