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
$dbname     = "timeclock";           // name of the database you are using


$dbLink = mysql_connect ($dbaddress,$dbuser,$dbpass);
mysql_select_db($dbname, $dbLink);

$q = "truncate audit";
mysql_query($q, $dbLink);
$q = "truncate dbversion";
mysql_query($q, $dbLink);
$q = "truncate employees";
mysql_query($q, $dbLink);
$q = "truncate groups";
mysql_query($q, $dbLink);
$q = "truncate info";
mysql_query($q, $dbLink);
$q = "truncate metars";
mysql_query($q, $dbLink);
$q = "truncate offices";
mysql_query($q, $dbLink);
$q = "truncate punchlist";
mysql_query($q, $dbLink);

$q = "INSERT INTO `employees` (`empfullname`, `tstamp`, `employee_passwd`, `displayname`, `email`, `groups`, `office`, `admin`, `reports`, `time_admin`, `disabled`)".
"VALUES".
	"('admin', NULL, 'xy.RY2HT1QTc2', 'administrator', '', '', '', 1, 1, 1, 0),".
	"('oscar', 1425918440, 'xyw1.V0rbu5mQ', 'Oscar Madison', 'oscar@yahoo.com', 'g1', 'TheOffice', 0, 1, 0, 0),".
	"('felix', 1425913149, 'xyw1.V0rbu5mQ', 'Felix Ungar', 'felix@yahoo.com', 'Front Group', 'front', 0, 1, 0, 0),".
	"('glenda', 1426021285, 'xyw1.V0rbu5mQ', 'Glenda Radner', 'gradner@comcast.net', 'b101group', 'b101', 0, 0, 0, 0),".
	"('norma', 1425993531, 'xyw1.V0rbu5mQ', 'Norma Rae Robbins', 'nrr@inetd.net', 'back', 'backoffice', 0, 1, 0, 0),".
	"('lois', 1425933373, 'xyw1.V0rbu5mQ', 'Lois Lane', 'llane@dailyplanetnews.net', 'b101group', 'b101', 0, 0, 0, 0),".
	"('jolsen', 1425933366, 'xyw1.V0rbu5mQ', 'Jimmy Olsen', 'jolson@dailyplanetnews.net', 'b102group', 'b102', 0, 0, 0, 0),".
	"('ckent', 1426021279, 'xyw1.V0rbu5mQ', 'Clark Kent', 'ckent@dailyplanetnews.net', 'b103group', 'b103', 0, 0, 0, 0),".
	"('skyler', 1425918430, 'xyw1.V0rbu5mQ', 'Schuyler Colfax', 'scolfax3041@q.com', 'a101group', 'a101', 0, 0, 0, 0),".
	"('randy', 1425918448, 'xyw1.V0rbu5mQ', 'Randy Neuman', 'iluvla2much@aol.com', 'a102group', 'a102', 0, 0, 0, 0),".
	"('don', 1425931878, 'xyw1.V0rbu5mQ', 'Don Imus', 'dimus@whoknows.net', 'c10xgroup', 'c103', 0, 0, 0, 0),".
	"('howard', NULL, 'xyw1.V0rbu5mQ', 'Howard Stein', 'howardstein@skyhook.us', 'c10xgroup', 'c103', 0, 0, 0, 0),".
	"('vince', 1426021292, 'xyw1.V0rbu5mQ', 'Vince Foster', 'vfoster@whitehouse.gov', 'group1', 'TheOffice', 0, 0, 0, 0),".
	"('hilly', 1425925264, 'xyw1.V0rbu5mQ', 'Hillary Clinton', 'hdr44@clintonemail.net', 'back', 'backoffice', 0, 1, 0, 0),".
	"('billc', 1425913130, 'xyw1.V0rbu5mQ', 'Bill Clinton', 'cigarlover69@yahoo.com', 'c10xgroup', 'c103', 0, 0, 0, 0),".
	"('louis', NULL, 'xyw1.V0rbu5mQ', 'Louis Armstrong', 'blowyerhorn@hotmail.com', 'c10xgroup', 'c102', 0, 0, 0, 0),".
	"('clyde', 1425935372, 'xyw1.V0rbu5mQ', 'Clyde Barrow', 'clydeb8472@q.com', 'c10xgroup', 'c102', 0, 0, 0, 0)";
mysql_query($q, $dbLink);

$q = "INSERT INTO `groups` (`groupname`, `groupid`, `officeid`)".
"VALUES".
	"('g1', 1, 1),".
	"('g2', 2, 1),".
	"('g3', 3, 1),".
	"('g4', 4, 1),".
	"('g5', 5, 1),".
	"('g6', 6, 1),".
	"('g7', 7, 1),".
	"('g8', 8, 1),".
	"('g9', 9, 1),".
	"('group1', 10, 1),".
	"('a101group', 12, 7),".
	"('a102group', 13, 8),".
	"('b103group', 14, 6),".
	"('b101group', 15, 4),".
	"('b102group', 16, 5),".
	"('c10xgroup', 17, 9),".
	"('c10xgroup', 18, 10),".
	"('back', 19, 2),".
	"('Front Group', 20, 3)";
mysql_query($q, $dbLink);

$q = "INSERT INTO `info` (`fullname`, `inout`, `timestamp`, `notes`, `ipaddress`)".
"VALUES".
	"('don', 'in', 1425870279, 'im here dammit', '127.0.0.1'),".
	"('felix', 'in', 1425870303, 'keep it clean', '127.0.0.1'),".
	"('oscar', 'in', 1425870321, 'i always do', '127.0.0.1'),".
	"('jolsen', 'in', 1425870350, '', '127.0.0.1'),".
	"('ckent', 'in', 1425870364, '', '127.0.0.1'),".
	"('jolsen', 'break', 1425870863, '', '127.0.0.1'),".
	"('billc', 'in', 1425870879, '', '127.0.0.1'),".
	"('don', 'lunch', 1425870893, '', '127.0.0.1'),".
	"('randy', 'in', 1425870982, '', '127.0.0.1'),".
	"('jolsen', 'in', 1425870991, '', '127.0.0.1'),".
	"('glenda', 'in', 1425871008, '', '127.0.0.1'),".
	"('billc', 'out', 1425913130, '', '10.211.136.85'),".
	"('ckent', 'out', 1425913137, '', '10.211.136.85'),".
	"('don', 'in', 1425913141, '', '10.211.136.85'),".
	"('felix', 'out', 1425913149, '', '10.211.136.85'),".
	"('glenda', 'break', 1425913156, '', '10.211.136.85'),".
	"('jolsen', 'lunch', 1425913163, '', '10.211.136.85'),".
	"('skyler', 'in', 1425914661, '', '10.211.136.85'),".
	"('ckent', 'in', 1425914681, 'im baaaack', '10.211.136.85'),".
	"('skyler', 'out', 1425918430, '', '10.211.136.85'),".
	"('oscar', 'out', 1425918440, '', '10.211.136.85'),".
	"('randy', 'out', 1425918448, '', '10.211.136.85'),".
	"('hilly', 'in', 1425918454, '', '10.211.136.85'),".
	"('vince', 'in', 1425918471, '', '10.211.136.85'),".
	"('lois', 'in', 1425918480, '', '10.211.136.85'),".
	"('norma', 'in', 1425918493, '', '10.211.136.85'),".
	"('ckent', 'break', 1425918716, 'ill be baaaack', '10.211.136.85'),".
	"('don', 'lunch', 1425919026, '', '10.211.136.85'),".
	"('don', 'in', 1425922477, '', '10.211.136.85'),".
	"('jolsen', 'in', 1425922494, 'that was great', '10.211.136.85'),".
	"('hilly', 'out', 1425925264, '', '10.211.136.85'),".
	"('vince', 'break', 1425925275, '', '10.211.136.85'),".
	"('don', 'out', 1425931878, '', '10.211.136.85'),".
	"('clyde', 'in', 1425932253, '', '10.211.136.85'),".
	"('clyde', 'out', 1425932291, '', '10.211.136.85'),".
	"('jolsen', 'out', 1425933366, '', '10.211.136.85'),".
	"('lois', 'out', 1425933373, '', '10.211.136.85'),".
	"('clyde', 'in', 1425935299, '', '10.211.136.85'),".
	"('clyde', 'out', 1425935372, '', '10.211.136.85'),".
	"('norma', 'out', 1425993531, '', '10.211.136.85'),".
	"('vince', 'in', 1425993544, '', '10.211.136.85'),".
	"('glenda', 'in', 1425993552, '', '10.211.136.85'),".
	"('ckent', 'in', 1425993558, '', '10.211.136.85'),".
	"('ckent', 'out', 1426021279, '', '10.211.136.85'),".
	"('glenda', 'out', 1426021285, '', '10.211.136.85'),".
	"('vince', 'out', 1426021292, '', '10.211.136.85')";
mysql_query($q, $dbLink);

$q = "INSERT INTO `offices` (`officename`, `officeid`)".
"VALUES".
	"('TheOffice', 1),".
	"('backoffice', 2),".
	"('front', 3),".
	"('b101', 4),".
	"('b102', 5),".
	"('b103', 6),".
	"('a101', 7),".
	"('a102', 8),".
	"('c102', 9),".
	"('c103', 10);";
mysql_query($q, $dbLink);

$q = "INSERT INTO `dbversion` (`dbversion`) VALUES (1.4)";
mysql_query($q, $dbLink);

$q = "INSERT INTO `punchlist` (`punchitems`, `color`, `in_or_out`) VALUES ('in', '#009900', 1), ('out', '#FF0000', 0), ('break', '#FF9900', 0), ('lunch', '#0000FF', 0)";
mysql_query($q, $dbLink);

print("<html><head></head><body>DB cleared!</body></html>");
mysql_close ( $dbLink );

?>
