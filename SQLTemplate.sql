-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.5.24-log - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2013-03-09 15:54:51
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping structure for table notorac.attempts
CREATE TABLE IF NOT EXISTS `Attempts` (
  `AttemptID` int(10) NOT NULL AUTO_INCREMENT,
  `ProblemID` int(10) NOT NULL,
  `Code` text NOT NULL,
  `Output` text NOT NULL,
  `CompilerOutput` text NOT NULL,
  `ExecTime` float NOT NULL,
  PRIMARY KEY (`AttemptID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table notorac.problems
CREATE TABLE IF NOT EXISTS `Problems` (
  `ProblemID` int(11) NOT NULL AUTO_INCREMENT,
  `ClassID` varchar(8) NOT NULL,
  `ProblemName` varchar(64) NOT NULL,
  `Discription` text NOT NULL,
  `TimeLimit` int(11) NOT NULL DEFAULT '1',
  `Solution` text NOT NULL,
  `ValueGenerationM` varchar(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`ProblemID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.


-- Dumping structure for table notorac.users
CREATE TABLE IF NOT EXISTS `Users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(32) NOT NULL,
  `ClassID` varchar(8) NOT NULL,
  `Password` varchar(92) NOT NULL,
  `Email` varchar(128) NOT NULL,
  `DateRegistered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `GlobalScore` int(11) NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Data exporting was unselected.
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
