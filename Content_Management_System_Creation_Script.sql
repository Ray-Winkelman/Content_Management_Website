SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cms`
--
CREATE DATABASE IF NOT EXISTS `cms` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `cms`;

-- --------------------------------------------------------

--
-- Table structure for table `Article`
--

DROP TABLE IF EXISTS `Article`;
CREATE TABLE IF NOT EXISTS `Article` (
  `ArticleID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) NOT NULL,
  `Title` varchar(255) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `HTML` text NOT NULL,
  `PageID` int(11) NOT NULL,
  `Div_DivID` int(11) NOT NULL,
  `Created` datetime DEFAULT NULL,
  `CreatedBy` int(11) NOT NULL,
  `LastModified` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ModifiedBy` int(11) DEFAULT NULL,
  `AllPages` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ArticleID`),
  KEY `fk_Article_Div_idx` (`Div_DivID`),
  KEY `fk_Article_Page1_idx` (`PageID`),
  KEY `fk_Article_User1_idx` (`ModifiedBy`),
  KEY `fk_Article_User2_idx` (`CreatedBy`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `Article`
--

INSERT INTO `Article` (`ArticleID`, `Name`, `Title`, `Description`, `HTML`, `PageID`, `Div_DivID`, `Created`, `CreatedBy`, `LastModified`, `ModifiedBy`, `AllPages`) VALUES
(1, 'Test One', 'Test One', 'All Pages', '<img src=''http://previewcf.turbosquid.com/Preview/2014/05/21__04_30_09/HamburgerByBecome3d_iso_user_Thumbnail_1.JPGb47add5e-2820-417a-9a25-93a3c120c2c2Small.jpg'' />\r\n\r\n<h3> This appears on each page! </h3>\r\n\r\n<p>\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur hendrerit vehicula magna eu imperdiet. Cras varius id libero sit amet aliquam. Nulla viverra euismod ligula, a viverra felis ultricies ac. Sed id justo vel odio pretium elementum a sed augue. Aenean nec cursus lacus. Nam elementum consequat ligula, vitae sollicitudin nulla vulputate id. Proin pellentesque at odio ac iaculis. Donec quis eros urna. Nunc ac arcu ac magna varius vulputate. Donec pretium faucibus augue ac semper. </p>', 1, 1, '2014-11-23 10:45:04', 1, '2014-11-28 01:55:36', 2, 1),
(2, 'Test Two', 'Test Two', 'Second test article', '<p>This is a test of the second article. It Appears on Page One / Div Two \r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur hendrerit vehicula magna eu imperdiet. Cras varius id libero sit amet aliquam. Nulla viverra euismod ligula, a viverra felis ultricies ac. Sed id justo vel odio pretium elementum a sed augue. Aenean nec cursus lacus. Nam elementum consequat ligula, vitae sollicitudin nulla vulputate id. Proin pellentesque at odio ac iaculis. Donec quis eros urna. Nunc ac arcu ac magna varius vulputate. Donec pretium faucibus augue ac semper. </p> ', 1, 2, '2014-11-23 10:45:04', 1, '2014-11-28 01:54:49', 2, 0),
(3, 'Test Three', 'Test Three', 'Page One / Div Three', '<p>This is a test of the second article. It Appears on Page One / Div Three \r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur hendrerit vehicula magna eu imperdiet. Cras varius id libero sit amet aliquam. Nulla viverra euismod ligula, a viverra felis ultricies ac. Sed id justo vel odio pretium elementum a sed augue. Aenean nec cursus lacus. Nam elementum consequat ligula, vitae sollicitudin nulla vulputate id. Proin pellentesque at odio ac iaculis. Donec quis eros urna. Nunc ac arcu ac magna varius vulputate. Donec pretium faucibus augue ac semper. </p>', 1, 3, '2014-11-23 10:45:04', 1, '2014-11-28 01:55:03', 1, 0),
(4, 'Test Four', 'Test Four', 'Page Two / Div Two', '<p>This is a test of the second article. It Appears on Page Two / Div Two Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur hendrerit vehicula magna eu imperdiet. Cras varius id libero sit amet aliquam. Nulla viverra euismod ligula, a viverra felis ultricies ac. Sed id justo vel odio pretium elementum a sed augue. Aenean nec cursus lacus. Nam elementum consequat ligula, vitae sollicitudin nulla vulputate id. Proin pellentesque at odio ac iaculis. Donec quis eros urna. Nunc ac arcu ac magna varius vulputate. Donec pretium faucibus augue ac semper. </p>', 2, 2, '2014-11-23 10:45:04', 1, '2014-11-28 01:55:18', 3, 0),
(5, 'Test Five', 'Test Five', 'Page Two / Div Two', '<p>This is a test of the second article. It Appears on Page Two / Div Two Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur hendrerit vehicula magna eu imperdiet. Cras varius id libero sit amet aliquam. Nulla viverra euismod ligula, a viverra felis ultricies ac. Sed id justo vel odio pretium elementum a sed augue. Aenean nec cursus lacus. Nam elementum consequat ligula, vitae sollicitudin nulla vulputate id. Proin pellentesque at odio ac iaculis. Donec quis eros urna. Nunc ac arcu ac magna varius vulputate. Donec pretium faucibus augue ac semper. </p>', 2, 2, '2014-11-23 10:45:04', 1, '2014-11-28 01:55:26', 2, 0),
(6, 'Test Six', 'Test Six', 'Page Three / Div 3', '<p>This is a test of the second article. It Appears on Page Three / Div Three Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur hendrerit vehicula magna eu imperdiet. Cras varius id libero sit amet aliquam. Nulla viverra euismod ligula, a viverra felis ultricies ac. Sed id justo vel odio pretium elementum a sed augue. Aenean nec cursus lacus. Nam elementum consequat ligula, vitae sollicitudin nulla vulputate id. Proin pellentesque at odio ac iaculis. Donec quis eros urna. Nunc ac arcu ac magna varius vulputate. Donec pretium faucibus augue ac semper. </p>', 3, 3, '2014-11-23 10:45:04', 1, '2014-11-28 01:55:44', 2, 0);

--
-- Triggers `Article`
--
DROP TRIGGER IF EXISTS `ArticleCreatedInsert`;
DELIMITER //
CREATE TRIGGER `ArticleCreatedInsert` BEFORE INSERT ON `Article`
 FOR EACH ROW SET NEW.Created = NOW()
//
DELIMITER ;
DROP TRIGGER IF EXISTS `ArticleModifiedUpdate`;
DELIMITER //
CREATE TRIGGER `ArticleModifiedUpdate` BEFORE UPDATE ON `Article`
 FOR EACH ROW SET NEW.LastModified = NOW()
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Content_Area`
--

DROP TABLE IF EXISTS `Content_Area`;
CREATE TABLE IF NOT EXISTS `Content_Area` (
  `DivID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) NOT NULL,
  `Alias` varchar(45) NOT NULL,
  `DivOrder` int(11) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Created` datetime DEFAULT NULL,
  `CreatedBy` int(11) NOT NULL,
  `LastModified` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ModifiedBy` int(11) NOT NULL,
  PRIMARY KEY (`DivID`),
  KEY `fk_Div_User1_idx` (`ModifiedBy`),
  KEY `fk_Div_User2_idx` (`CreatedBy`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `Content_Area`
--

INSERT INTO `Content_Area` (`DivID`, `Name`, `Alias`, `DivOrder`, `Description`, `Created`, `CreatedBy`, `LastModified`, `ModifiedBy`) VALUES
(1, 'Header Div', 'header', 1, 'Header Div.', '2014-11-23 10:45:04', 1, '2014-11-25 22:10:03', 1),
(2, 'Body Div', 'body', 2, 'This is the body Div.', '2014-11-23 10:45:04', 1, '2014-11-25 22:10:22', 2),
(3, 'Footer Div', 'footer', 3, 'This is the Footer div.', '2014-11-23 10:45:04', 1, '2014-11-25 22:10:37', 3);

--
-- Triggers `Content_Area`
--
DROP TRIGGER IF EXISTS `ContentAreaCreatedInsert`;
DELIMITER //
CREATE TRIGGER `ContentAreaCreatedInsert` BEFORE INSERT ON `Content_Area`
 FOR EACH ROW SET NEW.Created = NOW()
//
DELIMITER ;
DROP TRIGGER IF EXISTS `ContentAreaModifiedUpdate`;
DELIMITER //
CREATE TRIGGER `ContentAreaModifiedUpdate` BEFORE UPDATE ON `Content_Area`
 FOR EACH ROW SET NEW.LastModified = NOW()
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `CSS`
--

DROP TABLE IF EXISTS `CSS`;
CREATE TABLE IF NOT EXISTS `CSS` (
  `CSSID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) NOT NULL,
  `Active` tinyint(1) NOT NULL,
  `Content` text NOT NULL,
  `Created` datetime DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `CreatedBy` int(11) NOT NULL,
  `LastModified` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ModifiedBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`CSSID`),
  KEY `fk_CSS_User1_idx` (`CreatedBy`),
  KEY `fk_CSS_User2_idx` (`ModifiedBy`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `CSS`
--

INSERT INTO `CSS` (`CSSID`, `Name`, `Active`, `Content`, `Created`, `Description`, `CreatedBy`, `LastModified`, `ModifiedBy`) VALUES
(1, 'default', 1, '<style>\r\n.body {\r\n background-color: linen;\r\n}\r\n.header {\r\n color: maroon;\r\n background-color: grey;\r\n margin-left: 40px;\r\n}footer{}\r\n\r\nul {\r\n list-style-type: none;\r\n margin: 0;\r\n padding: 0;\r\n overflow: hidden;\r\n}\r\n\r\nli {\r\n float: left;\r\n}\r\n\r\na {\r\n display: block;\r\n width: 60px;\r\n background-color: #dddddd;\r\n}\r\n</style>', '2014-11-23 10:45:04', 'default style', 1, '2014-11-28 01:56:10', 2);

--
-- Triggers `CSS`
--
DROP TRIGGER IF EXISTS `CSSCreatedInsert`;
DELIMITER //
CREATE TRIGGER `CSSCreatedInsert` BEFORE INSERT ON `CSS`
 FOR EACH ROW SET NEW.Created = NOW()
//
DELIMITER ;
DROP TRIGGER IF EXISTS `CSSModifiedUpdate`;
DELIMITER //
CREATE TRIGGER `CSSModifiedUpdate` BEFORE UPDATE ON `CSS`
 FOR EACH ROW SET NEW.LastModified = NOW()
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Page`
--

DROP TABLE IF EXISTS `Page`;
CREATE TABLE IF NOT EXISTS `Page` (
  `PageID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) NOT NULL,
  `Alias` varchar(45) NOT NULL,
  `Description` varchar(55) DEFAULT NULL,
  `Created` datetime DEFAULT NULL,
  `CreatedBy` int(11) NOT NULL,
  `LastModified` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ModifiedBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`PageID`),
  KEY `fk_Page_User1_idx` (`ModifiedBy`),
  KEY `fk_Page_User2_idx` (`CreatedBy`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `Page`
--

INSERT INTO `Page` (`PageID`, `Name`, `Alias`, `Description`, `Created`, `CreatedBy`, `LastModified`, `ModifiedBy`) VALUES
(1, 'Index', 'index.html', 'Home Page', '2014-11-23 10:45:04', 1, '2014-11-28 01:56:26', 2),
(2, 'Info', 'info.html', 'Information Page', '2014-11-23 10:45:04', 1, '2014-11-28 01:56:45', 2),
(3, 'Contact', 'contact.html', 'Contact Page', '2014-11-23 10:45:04', 1, '2014-11-28 01:57:02', 1),
(4, 'Mailing List', 'mailinglist.html', NULL, '2014-11-23 10:45:04', 1, '2014-11-28 01:57:21', 2);

--
-- Triggers `Page`
--
DROP TRIGGER IF EXISTS `PageCreateTrigger`;
DELIMITER //
CREATE TRIGGER `PageCreateTrigger` BEFORE INSERT ON `Page`
 FOR EACH ROW SET NEW.Created = NOW()
//
DELIMITER ;
DROP TRIGGER IF EXISTS `PageModifiedUpdate`;
DELIMITER //
CREATE TRIGGER `PageModifiedUpdate` BEFORE UPDATE ON `Page`
 FOR EACH ROW SET NEW.LastModified = NOW()
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `Role`
--

DROP TABLE IF EXISTS `Role`;
CREATE TABLE IF NOT EXISTS `Role` (
  `RoleID` int(11) NOT NULL,
  `Role_Name` varchar(45) NOT NULL,
  PRIMARY KEY (`RoleID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Role`
--

INSERT INTO `Role` (`RoleID`, `Role_Name`) VALUES
(1, 'Admin'),
(2, 'Editor'),
(3, 'Author');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
CREATE TABLE IF NOT EXISTS `User` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(45) NOT NULL,
  `Password` varchar(128) NOT NULL,
  `FirstName` varchar(45) NOT NULL,
  `LastName` varchar(45) NOT NULL,
  `Salt` varchar(10) NOT NULL,
  `Created` datetime DEFAULT NULL,
  `CreatedBy` int(11) NOT NULL,
  `LastModified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ModifiedBy` int(11) DEFAULT NULL,
  PRIMARY KEY (`UserID`),
  KEY `fk_User_User1_idx` (`CreatedBy`),
  KEY `fk_User_User2_idx` (`ModifiedBy`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`UserID`, `Username`, `Password`, `FirstName`, `LastName`, `Salt`, `Created`, `CreatedBy`, `LastModified`, `ModifiedBy`) VALUES
(1, 'GHatt', '$4/v9.pbqw1Xo', 'Gregory', 'Hatt', '1417140913', '2014-11-23 10:45:04', 1, '2014-11-28 02:15:44', 1),
(2, 'RWinkelman', '$4/v9.pbqw1Xo', 'Ray', 'Winkelman', '1417140978', '2014-11-23 10:45:04', 1, '2014-11-28 02:16:34', 1),
(3, 'DCrawford', '$4/v9.pbqw1Xo', 'Dave', 'Crawford', '1417141009', '2014-11-23 10:45:04', 1, '2014-11-28 02:17:05', 2);

--
-- Triggers `User`
--
DROP TRIGGER IF EXISTS `UserCreateTrigger`;
DELIMITER //
CREATE TRIGGER `UserCreateTrigger` BEFORE INSERT ON `User`
 FOR EACH ROW BEGIN
SET NEW.Created = NOW();
SET New.Salt = UNIX_TIMESTAMP(NOW());
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `UserModifiedUpdate`;
DELIMITER //
CREATE TRIGGER `UserModifiedUpdate` BEFORE UPDATE ON `User`
 FOR EACH ROW SET NEW.LastModified = NOW()
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `User_Role`
--

DROP TABLE IF EXISTS `User_Role`;
CREATE TABLE IF NOT EXISTS `User_Role` (
  `User_UserID` int(11) NOT NULL,
  `Role_RoleID` int(11) NOT NULL,
  KEY `fk_User_Roles_User1_idx` (`User_UserID`),
  KEY `fk_User_Roles_Role1_idx` (`Role_RoleID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `User_Role`
--

INSERT INTO `User_Role` (`User_UserID`, `Role_RoleID`) VALUES
(1, 1),
(2, 2),
(3, 3);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `User`
--
ALTER TABLE `User`
  ADD CONSTRAINT `fk_User_User1` FOREIGN KEY (`CreatedBy`) REFERENCES `User` (`UserID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_User_User2` FOREIGN KEY (`ModifiedBy`) REFERENCES `User` (`UserID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `User_Role`
--
ALTER TABLE `User_Role`
  ADD CONSTRAINT `fk_User_Roles_Role1` FOREIGN KEY (`Role_RoleID`) REFERENCES `Role` (`RoleID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_User_Roles_User1` FOREIGN KEY (`User_UserID`) REFERENCES `User` (`UserID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;