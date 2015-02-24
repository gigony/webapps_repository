-- Database: `akb`

CREATE TABLE IF NOT EXISTS `articles` (
  `FileID` int(3) unsigned NOT NULL auto_increment,
  `ParentID` int(3) unsigned NOT NULL default '0',
  `AuthorID` mediumint(8) unsigned NOT NULL default '0',
  `Title` varchar(50) NOT NULL default '',
  `Keyw` varchar(80) default NULL,
  `Articledata` longtext,
  `Approved` char(1) default 'N',
  `Views` int(10) default '0',
  `RatingTotal` varchar(5) NOT NULL default '0',
  `RatedTotal` varchar(5) NOT NULL default '0',
  `SubmitDate` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`FileID`),
  KEY `Keyw` (`Keyw`)
);

CREATE TABLE IF NOT EXISTS `authors` (
  `AuthorID` mediumint(8) unsigned NOT NULL auto_increment,
  `UserName` varchar(20) NOT NULL,
  `FirstName` varchar(15) NOT NULL,
  `LastName` varchar(30) NOT NULL,
  `Email` varchar(40) default NULL,
  `EmailMD5` varchar(50) default NULL,
  `Approved` char(1) default 'N',
  `Passwd` varchar(52) NOT NULL,
  `RegistrationDate` datetime NOT NULL,
  PRIMARY KEY  (`AuthorID`),
  UNIQUE KEY `UserName` (`UserName`),
  KEY `FirstName` (`FirstName`),
  KEY `LastName` (`LastName`),
  KEY `Passwd` (`Passwd`)
);


CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `fileid` int(10) unsigned NOT NULL,
  `tag` char(64) default NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `uploads` (
  `UploadID` int(10) unsigned NOT NULL auto_increment,
  `AuthorID` mediumint(8) unsigned NOT NULL,
  `FileID` mediumint(8) unsigned NOT NULL,
  `FileName` varchar(60) NOT NULL,
  `FileSize` int(6) unsigned NOT NULL,
  `FileType` varchar(30) NOT NULL,
  `FileDescription` varchar(100) default NULL,
  `UploadDate` datetime NOT NULL,
  PRIMARY KEY  (`UploadID`),
  KEY `FileName` (`FileName`),
  KEY `FileID` (`FileID`),
  KEY `AuthorID` (`AuthorID`)
);
