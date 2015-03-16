<?php

session_start();
session_unset();
$_SESSION = array();
session_destroy();
session_write_close();
setcookie(session_name(),'',0,'/');
session_regenerate_id(true);

$dbaddress  = "localhost";            // location of the database
$dbuser     = "test";         // databse username
$dbpass     = "test";         // databse password
$dbname     = "schoolmate";           // name of the database you are using

$dbLink = mysql_connect ($dbaddress,$dbuser,$dbpass);
mysql_select_db($dbname, $dbLink);

$q = "truncate adminstaff";
mysql_query ($q, $dbLink);
$q = "truncate assignments";
mysql_query ($q, $dbLink);
$q = "truncate courses";
mysql_query ($q, $dbLink);
$q = "truncate grades";
mysql_query ($q, $dbLink);
$q = "truncate parent_student_match";
mysql_query ($q, $dbLink);
$q = "truncate parents";
mysql_query ($q, $dbLink);
$q = "truncate registrations";
mysql_query ($q, $dbLink);
$q = "truncate schoolattendance";
mysql_query ($q, $dbLink);
$q = "truncate schoolbulletins";
mysql_query ($q, $dbLink);
$q = "truncate schoolinfo";
mysql_query ($q, $dbLink);
$q = "truncate semesters";
mysql_query ($q, $dbLink);
$q = "truncate students";
mysql_query ($q, $dbLink);
$q = "truncate teachers";
mysql_query ($q, $dbLink);
$q = "truncate terms";
mysql_query ($q, $dbLink);
$q = "truncate users";
mysql_query ($q, $dbLink);


$q = "INSERT INTO `courses` (`courseid`, `semesterid`, `termid`, `coursename`, `teacherid`, `sectionnum`, `roomnum`, `periodnum`, `q1points`, `q2points`, `totalpoints`, `aperc`, `bperc`, `cperc`, `dperc`, `fperc`, `dotw`, `substituteid`, `secondcourseid`)".
"VALUES".
	"(1, 1, 3, 'Basic Math', 2, '101', '40', '1', 0.00, 0.00, 0.00, 0.000, 0.000, 0.000, 0.000, 0.000, 'MWF', 3, NULL),".
	"(2, 1, 3, 'Basic English', 1, '102', '41', '2', 0.00, 0.00, 0.00, 0.000, 0.000, 0.000, 0.000, 0.000, 'MWF', 4, NULL),".
	"(3, 1, 3, 'Basketry', 1, '103', '42', '3', 0.00, 0.00, 0.00, 0.000, 0.000, 0.000, 0.000, 0.000, 'MWF', 3, NULL),".
	"(4, 1, 3, 'Copying', 2, '105', '43', '4', 0.00, 0.00, 0.00, 0.000, 0.000, 0.000, 0.000, 0.000, 'MWF', 4, NULL),".
	"(5, 1, 3, 'Pasting', 2, '104', '40', '5', 0.00, 0.00, 0.00, 0.000, 0.000, 0.000, 0.000, 0.000, 'MWF', 3, NULL),".
	"(6, 1, 3, 'Hunting', 1, '106', '41', '6', 0.00, 0.00, 0.00, 0.000, 0.000, 0.000, 0.000, 0.000, 'MWF', 3, NULL),".
	"(7, 1, 3, 'Pecking', 6, '101', '40', '7', 0.00, 0.00, 0.00, 0.000, 0.000, 0.000, 0.000, 0.000, 'MWF', 3, NULL),".
	"(8, 1, 3, 'Social Apathy', 1, '002', '33', '8', 0.00, 0.00, 0.00, 0.000, 0.000, 0.000, 0.000, 0.000, 'MTWHF', 3, NULL),".
	"(9, 2, 4, 'Horticulture', 7, '003', '12', '5', 0.00, 0.00, 0.00, 0.000, 0.000, 0.000, 0.000, 0.000, 'TH', 3, NULL)";
mysql_query($q, $dbLink);

$q = "INSERT INTO `parent_student_match` (`matchid`, `parentid`, `studentid`)".
"VALUES".
	"(1, 1, 1),".
	"(4, 2, 2),".
	"(5, 3, 3),".
	"(6, 4, 7),".
	"(7, 5, 4),".
	"(8, 6, 5)";
mysql_query($q, $dbLink);

$q = "INSERT INTO `parents` (`parentid`, `userid`, `fname`, `lname`)".
"VALUES".
	"(1, 22, 'Dave', 'Doe'),".
	"(2, 11, 'Gregg', 'Marx'),".
	"(3, 12, 'Karen', 'March'),".
	"(4, 13, 'Rich', 'Young'),".
	"(5, 18, 'Don', 'Dean'),".
	"(6, 24, 'Rachel', 'Chase')";
mysql_query($q, $dbLink);

$q = "INSERT INTO `registrations` (`regid`, `courseid`, `studentid`, `semesterid`, `termid`, `q1currpoints`, `q2currpoints`, `currentpoints`)".
"VALUES".
	"(2, 1, 3, 1, 3, 0.00, 0.00, 0.00),".
	"(3, 1, 1, 1, 3, 0.00, 0.00, 0.00),".
	"(4, 2, 2, 1, 3, 0.00, 0.00, 0.00),".
	"(23, 2, 3, 1, 3, 0.00, 0.00, 0.00),".
	"(6, 3, 1, 1, 3, 0.00, 0.00, 0.00),".
	"(7, 4, 1, 1, 3, 0.00, 0.00, 0.00),".
	"(8, 5, 1, 1, 3, 0.00, 0.00, 0.00),".
	"(9, 6, 1, 1, 3, 0.00, 0.00, 0.00),".
	"(10, 1, 4, 1, 3, 0.00, 0.00, 0.00),".
	"(11, 2, 4, 1, 3, 0.00, 0.00, 0.00),".
	"(12, 3, 4, 1, 3, 0.00, 0.00, 0.00),".
	"(13, 4, 4, 1, 3, 0.00, 0.00, 0.00),".
	"(14, 6, 4, 1, 3, 0.00, 0.00, 0.00),".
	"(15, 8, 4, 1, 3, 0.00, 0.00, 0.00),".
	"(16, 2, 6, 1, 3, 0.00, 0.00, 0.00),".
	"(17, 3, 6, 1, 3, 0.00, 0.00, 0.00),".
	"(18, 4, 6, 1, 3, 0.00, 0.00, 0.00),".
	"(19, 5, 6, 1, 3, 0.00, 0.00, 0.00),".
	"(20, 7, 6, 1, 3, 0.00, 0.00, 0.00),".
	"(21, 8, 6, 1, 3, 0.00, 0.00, 0.00),".
	"(22, 8, 2, 1, 3, 0.00, 0.00, 0.00),".
	"(24, 3, 3, 1, 3, 0.00, 0.00, 0.00),".
	"(25, 4, 3, 1, 3, 0.00, 0.00, 0.00),".
	"(26, 5, 3, 1, 3, 0.00, 0.00, 0.00),".
	"(27, 6, 3, 1, 3, 0.00, 0.00, 0.00),".
	"(28, 7, 3, 1, 3, 0.00, 0.00, 0.00),".
	"(29, 8, 3, 1, 3, 0.00, 0.00, 0.00),".
	"(30, 2, 7, 1, 3, 0.00, 0.00, 0.00)";
mysql_query($q, $dbLink);


$q = "INSERT INTO `schoolattendance` (`sattendid`, `studentid`, `sattenddate`, `semesterid`, `termid`, `type`)".
"VALUES".
	"(1, 4, '2001-01-06', 1, 3, 'tardy'),".
	"(2, 3, '2001-01-03', 1, 3, 'absent'),".
	"(3, 2, '2001-02-04', 1, 3, 'tardy'),".
	"(4, 2, '2001-02-03', 1, 3, 'absent')";
mysql_query($q, $dbLink);



$q = "INSERT INTO `schoolinfo` (`schoolname`, `address`, `phonenumber`, `sitetext`, `sitemessage`, `currenttermid`, `numsemesters`, `numperiods`, `apoint`, `bpoint`, `cpoint`, `dpoint`, `fpoint`".
"VALUE".
	"('School Name', '1,Street', '52365895', 'Login page Text Woo Hoo!', 'This is the Message of the day:-\r\n\r\n\r\nWe think our fathers fools, so wise do we grow,\r\nno doubt our wisest sons would think us\r\nso.', NULL, 2, 8, 4.000, 3.000, 2.000, 1.000, 0.000)";
mysql_query($q, $dbLink);


$q = "INSERT INTO `semesters` (`semesterid`, `termid`, `title`, `startdate`, `midtermdate`, `enddate`, `type`)".
"VALUES".
	"(1, '3', 'spring2001', '2001-01-01', '2001-03-14', '2001-05-15', '1'),".
	"(2, '4', 'spring2001', '2001-01-01', '2001-03-14', '2001-05-15', '2'),".
	"(3, '3', 'summer2001', '2001-06-01', '2001-06-21', '2001-07-10', '1'),".
	"(4, '4', 'summer2001', '2001-07-16', '2001-08-01', '2001-08-16', '2');";
mysql_query($q, $dbLink);

$q = "INSERT INTO `students` (`studentid`, `userid`, `fname`, `mi`, `lname`)".
"VALUES".
	"(1, 2, 'Tom', 'T', 'Doe'),".
	"(2, 5, 'Carla', 'H', 'Marx'),".
	"(3, 6, 'Mark', 'V', 'March'),".
	"(4, 17, 'Daisy', 'D', 'Dean'),".
	"(5, 19, 'Robin', 'F', 'Chase'),".
	"(6, 20, 'Gordon', 'S', 'Kline'),".
	"(7, 23, 'Ernst', 'B', 'Young');";
mysql_query($q, $dbLink);

$q = "INSERT INTO `teachers` (`teacherid`, `userid`, `fname`, `lname`)".
"VALUES".
	"(1, 3, 'Jane', 'Doe'),".
	"(2, 7, 'Beth', 'Cool'),".
	"(3, 9, 'Sam', 'Walker'),".
	"(4, 10, 'Herb', 'Hunt'),".
	"(5, 14, 'Bill', 'Bourne'),".
	"(6, 15, 'Janet', 'Fields'),".
	"(7, 25, 'Gail', 'Gordon'),".
	"(8, 32, 'Ichabod', 'Crane'),".
	"(9, 26, 'Don', 'Davis'),".
	"(11, 27, 'Robert', 'Rogers'),".
	"(12, 28, 'Caroline', 'Clark'),".
	"(13, 29, 'Mordacai', 'Martin'),".
	"(14, 30, 'Paul', 'Anka'),".
	"(15, 31, 'Crystal', 'Gail')";
mysql_query($q, $dbLink);

$q = "INSERT INTO `terms` (`termid`, `title`, `startdate`, `enddate`)".
"VALUES".
	"(3, 'Term1', '2001-01-01', '2001-03-18'),".
	"(4, 'Term2', '2001-03-19', '2001-05-09'),".
	"(5, 'SumTerm1', '2001-06-03', '2001-07-15'),".
	"(6, 'SumTerm2', '2001-07-17', '2001-08-17')";
mysql_query($q, $dbLink);

$q = "INSERT INTO `users` (`userid`, `username`, `password`, `type`)".
"VALUES".
	"(1, 'test', '098f6bcd4621d373cade4e832627b4f6', 'Admin'),".
	"(2, 'tdoe', '098f6bcd4621d373cade4e832627b4f6', 'Student'),".
	"(3, 'jdoe', '098f6bcd4621d373cade4e832627b4f6', 'Teacher'),".
	"(4, 'mdoe', '098f6bcd4621d373cade4e832627b4f6', 'Parent'),".
	"(5, 'cmarx', '098f6bcd4621d373cade4e832627b4f6', 'Student'),".
	"(6, 'mmarch', '098f6bcd4621d373cade4e832627b4f6', 'Student'),".
	"(7, 'bcool', '098f6bcd4621d373cade4e832627b4f6', 'Teacher'),".
	"(9, 'swalker', '098f6bcd4621d373cade4e832627b4f6', 'Substitute'),".
	"(10, 'hhunt', '098f6bcd4621d373cade4e832627b4f6', 'Substitute'),".
	"(11, 'gmarx', '098f6bcd4621d373cade4e832627b4f6', 'Parent'),".
	"(12, 'kmarch', '098f6bcd4621d373cade4e832627b4f6', 'Parent'),".
	"(13, 'ryoung', '098f6bcd4621d373cade4e832627b4f6', 'Parent'),".
	"(14, 'bbourne', '098f6bcd4621d373cade4e832627b4f6', 'Substitute'),".
	"(15, 'jfields', '098f6bcd4621d373cade4e832627b4f6', 'Teacher'),".
	"(16, 'lazy', '098f6bcd4621d373cade4e832627b4f6', 'Teacher'),".
	"(17, 'daisy', '098f6bcd4621d373cade4e832627b4f6', 'Student'),".
	"(18, 'paisley', '098f6bcd4621d373cade4e832627b4f6', 'Parent'),".
	"(19, 'rchase', '098f6bcd4621d373cade4e832627b4f6', 'Student'),".
	"(20, 'gkline', '098f6bcd4621d373cade4e832627b4f6', 'Student'),".
	"(21, 'tkline', '098f6bcd4621d373cade4e832627b4f6', 'Parent'),".
	"(22, 'ddoe', '098f6bcd4621d373cade4e832627b4f6', 'Parent'),".
	"(23, 'eyoung', '098f6bcd4621d373cade4e832627b4f6', 'Student'),".
	"(24, 'rchase2', '098f6bcd4621d373cade4e832627b4f6', 'Parent'),".
	"(25, 'ggordon', '098f6bcd4621d373cade4e832627b4f6', 'Teacher'),".
	"(26, 'ddavis', '098f6bcd4621d373cade4e832627b4f6', 'Teacher'),".
	"(27, 'rrogers', '098f6bcd4621d373cade4e832627b4f6', 'Teacher'),".
	"(28, 'cclark', '098f6bcd4621d373cade4e832627b4f6', 'Teacher'),".
	"(29, 'mmartin', '098f6bcd4621d373cade4e832627b4f6', 'Substitute'),".
	"(30, 'panka', '098f6bcd4621d373cade4e832627b4f6', 'Teacher'),".
	"(31, 'cgail', '098f6bcd4621d373cade4e832627b4f6', 'Teacher'),".
	"(32, 'icrane', '098f6bcd4621d373cade4e832627b4f6', 'Substitute')";
mysql_query($q, $dbLink);



print("<html><head></head><body>DB cleared!</body></html>");
mysql_close ( $dbLink );

?>
