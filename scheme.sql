-- phpMyAdmin SQL Dump
-- version 3.3.2deb1ubuntu1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 26, 2014 at 08:40 AM
-- Server version: 5.1.73
-- PHP Version: 5.4.25-1+sury.org~lucid+2

SET SQL_MODE=`NO_AUTO_VALUE_ON_ZERO`;

--
-- Database: `feedbacks`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE IF NOT EXISTS `feedbacks` (
  `CommentingUser` varchar(250) NOT NULL,
  `CommentingUserScore` int(11) NOT NULL,
  `CommentText` text NOT NULL,
  `CommentTime` datetime NOT NULL,
  `CommentType` varchar(50) NOT NULL,
  `ItemID` varchar(50) NOT NULL,
  `Role` varchar(50) NOT NULL,
  `FeedbackID` varchar(50) NOT NULL,
  `TransactionID` varchar(50) NOT NULL,
  `OrderLineItemID` varchar(250) NOT NULL,
  `ItemTitle` varchar(250) NOT NULL,
  `ItemPrice` decimal(11,5) NOT NULL,
  `currencyID` varchar(50) NOT NULL,
  KEY `FeedbackID` (`FeedbackID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `cases` (
  `caseId` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `userId` varchar(50) NOT NULL,
  `EBPSNADStatus` varchar(50) NOT NULL,
  `itemId` varchar(50) NOT NULL,
  `respondByDate` varchar(50) NOT NULL,
  `creationDate` varchar(50) NOT NULL,
  `lastModifiedDate` varchar(50) NOT NULL,
  `openReason` varchar(50) NOT NULL,
  `decision` varchar(50) NOT NULL,
  `agreedRefundAmount` varchar(50) NOT NULL,
  `detailStatus` varchar(50) NOT NULL,
  `initialBuyerExpectation` varchar(50) NOT NULL,
  KEY `caseId` (`caseId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;