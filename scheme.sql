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
  `type` varchar(50) DEFAULT NULL,
  `userId` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `itemId` varchar(50) DEFAULT NULL,
  `respondByDate` varchar(50) DEFAULT NULL,
  `creationDate` varchar(50) DEFAULT NULL,
  `lastModifiedDate` varchar(50) DEFAULT NULL,
  `openReason` varchar(50) DEFAULT NULL,
  `decision` varchar(50) DEFAULT NULL,
  `agreedRefundAmount` varchar(50) DEFAULT NULL,
  `detailStatus` varchar(50) DEFAULT NULL,
  `initialBuyerExpectation` varchar(50) DEFAULT NULL,
  KEY `caseId` (`caseId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `customer_reports` (
`order_source` varchar(50) NOT NULL,
`account` varchar(50) NOT NULL,
`txn_id` varchar(50) NOT NULL,
`txn_id2` varchar(50) NOT NULL,
`date` varchar(50) NOT NULL,
`payment_type` varchar(50) NOT NULL,
`payment_auth_info` varchar(50) NOT NULL,
`first_name` varchar(50) NOT NULL,
`last_name` varchar(50) NOT NULL,
`payer_email` varchar(50) NOT NULL,
`contact_phone` varchar(50) NOT NULL,
`address_country` varchar(50) NOT NULL,
`address_state` varchar(50) NOT NULL,
`address_zip` varchar(50) NOT NULL,
`address_city` varchar(50) NOT NULL,
`address_street` varchar(50) NOT NULL,
`address_street2` varchar(50) NOT NULL,
`total` varchar(50) NOT NULL,
`shipping` varchar(50) NOT NULL,
`tax` varchar(50) NOT NULL,
`discount` varchar(50) NOT NULL,
`fee` varchar(50) NOT NULL,
`ship_date` varchar(50) NOT NULL,
`carrier` varchar(50) NOT NULL,
`method` varchar(50) NOT NULL,
`tracking` varchar(50) NOT NULL,
`postage` varchar(50) NOT NULL,
`num_order_lines` varchar(50) NOT NULL,
`items` varchar(50) NOT NULL,
`qtys` varchar(50) NOT NULL,
`skus` varchar(50) NOT NULL,
`subtotals` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `paypal_reports` (
`date` varchar(50) NULL,
`time` varchar(50) NULL,
`time_zone` varchar(50) NULL,
`name` varchar(50) NULL,
`type` varchar(50) NULL,
`status` varchar(50) NULL,
`subject` varchar(50) NULL,
`currency` varchar(50) NULL,
`gross` varchar(50) NULL,
`fee` varchar(50) NULL,
`net` varchar(50) NULL,
`note` varchar(50) NULL,
`from_email_address` varchar(50) NULL,
`to_email_address` varchar(50) NULL,
`transaction_ID` varchar(50) NULL,
`payment_type` varchar(50) NULL,
`counterparty_status` varchar(50) NULL,
`shipping_address` varchar(50) NULL,
`address_status` varchar(50) NULL,
`item_title` varchar(50) NULL,
`item_ID` varchar(50) NULL,
`shipping_and_handling_amount` varchar(50) NULL,
`insurance_amount` varchar(50) NULL,
`sales_tax` varchar(50) NULL,
`option_1_name` varchar(50) NULL,
`option_1_value` varchar(50) NULL,
`option_2_name` varchar(50) NULL,
`option_2_value` varchar(50) NULL,
`auction_site` varchar(50) NULL,
`buyer_ID` varchar(50) NULL,
`item_URL` varchar(50) NULL,
`closing_date` varchar(50) NULL,
`reference_txn_ID` varchar(50) NULL,
`invoice_number` varchar(50) NULL,
`subscription_number` varchar(50) NULL,
`custom_number` varchar(50) NULL,
`receipt_ID` varchar(50) NULL,
`balance` varchar(50) NULL,
`address_line_1` varchar(50) NULL,
`address_line_2` varchar(50) NULL,
`city` varchar(50) NULL,
`state` varchar(50) NULL,
`zip` varchar(50) NULL,
`country` varchar(50) NULL,
`contact_phone_number` varchar(50) NULL,
`balance_impact` varchar(50) NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;