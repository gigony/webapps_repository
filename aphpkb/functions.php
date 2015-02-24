<?php

// Start output buffering and initialise a session.
ob_start();
session_start();

function xss_clean ($var) {
       $allowedTags =
'<font><p><strong><em><i><u><h1><h2><h3><h4><h5><h6><li><ol><ul><span><div><br><ins><del><b><pre><div><p><table><tbody><tr><td><th><li><hr><ul><ol>';

$var = strip_tags($var, $allowedTags);
      return $var;
}

function mifi($incoming) {
	if (is_numeric($incoming)) {
		return mysql_real_escape_string(intval($incoming));
	} 
	return '';
}

function escdata($data){
return mysql_real_escape_string(trim($data));
}

function head_page($title) {
include('./html/header.html');
}

function menu_options($title, $a, $viewop, $pid, $keys, $adfl) {


echo '
<div id="navAlpha">
<div class="title">
<img src="./imgs/logo.png" width="45" alt="Andy Grayndler">
<br /><br />
</div>';

if($_SESSION['adfl']==TRUE) {
include"./html/adminmenu.html";
}
$searchwidth='100%';
include"search.php";

include"./inc/tags.php";

$guestuser = TRUE;
if(!isset($_SESSION['user_id'])) {
include"./html/articlemenu.html";
} else {
include"./html/articlemenu.html";
}


echo '</div>';
} //end of menu_options

function contentinit($title) {

echo '<div class ="navstrip">';
echo '&nbsp;&nbsp;<a href="' . KBHOMEURL . '" title="' . KBHOMEURL . '">'. stripslashes(KBNAME) . '</a>';
echo '&raquo; <a href="index.php" title="Knowledge Base">Knowledgebase</a> &raquo; <font color="red">';
echo stripslashes($title) . '</font><div align="right">';?>

<?php if(isset($_SESSION['user_id']) AND (substr($_SERVER['PHP_SELF'], -10) != 'logout.php')){

echo <<<_LCA

<a href="logout.php">Logout</a> :: <a href="change_password.php">Change Password</a> :: <a href="authors.php">List Articles</a>
_LCA;
}
else
{
echo <<<_LRF
<a href="login.php">Login</a> :: <a href="register.php">Register</a> :: <a href="forgot_password.php">Forgot Password</a>
_LRF;
}

echo '</div></div><div class ="content">';
}

function footer($mode){
// mode is whether the footer is being called from a normal page, or via the installation wizard.
if($mode=='installing'){
$file='../docs/VERSION';  // installation wizard is one folder higher than the normal scripts.
$footbegin = '<br /></div></div><div class="footer">';
} else {
$mode = '';
$file='./docs/VERSION';  // normal scripts are in the same folder as the docs folder.
$footbegin = '<br /></div></div><div class="footer">';
}//end of mode check install/noninstall
$aphpkblink = '<a href="http://www.aphpkb.org">Andy\'s PHP Knowledgebase ';
$fhr = fopen("$file", "r");
$data = fread($fhr,filesize($file)+1);
fclose ($fhr);
$version = substr($data,0,6);
$copyright = '</a> &copy; Andy Grayndler 2012 </div></body></html>';
// print out the footer
echo <<<_FOOT
$footbegin
$mode
$aphpkblink
$version
$copyright

_FOOT;
}
function permcheck(){
$w = is_writeable('./index.php');
$r = is_readable('./index.php');
$x = is_executable('./index.php');


if($w==FALSE || $r==FALSE || $x==FALSE) {
// something isn't quite right here.
$rwxerror = 'Aphpkb folder does not appear to be ';
if($w==FALSE){ $rwxerror .= ' writable ';}
if($r==FALSE){ $rwxerror .= ' readable ';}
if($x==FALSE){ $rwxerror .= ' executable ';}
$rwxerror .= '<br /> please check ownership and permissions.<br />';

return $rwxerror;
} // there's absolutely nothing wrong with the ownership and/or permissions for the aphpkb folder.
}


function updaterss () {
$first = TRUE;
$maxrec = DB_MAX_REC;
$query = "SELECT FileID, Title, Articledata FROM articles WHERE Approved='Y' AND ParentID=0 ORDER by FileID DESC LIMIT $maxrec";

$result = mysql_query($query);
$num_records = @mysql_num_rows($result);

// Display all the URLs
while ($row = mysql_fetch_array ($result, MYSQL_ASSOC)) {	
// If this is the first record, create the table header.	
$linktitle = stripslashes($row['Title']);
$link = KBURL . '/v.php?a=' . $row['FileID'];
$description = strip_tags(substr(stripslashes($row['Articledata']),0,52) . '...');

$sitetitle = KBNAME;
$sitelink = KBURL;
$sitedescription = KBNAME . ' Knowledgebase';

if($first==TRUE) {
$output =
'<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
<channel>
<title>' . $sitetitle . '</title>
<link>' . $sitelink . '</link>
<description>' . $sitedescription . '</description>

';
}

$output .= '
<item>
<title>' . $linktitle . '</title>
<link>' . $link . '</link>
<guid>' . $link . '</guid>
<description>' . $description . '</description>
</item>';
$first = FALSE; 
}

$output .= '
</channel>
</rss>';

// write the file
	$file = '../rss.xml';
	$fh = fopen($file, "w+");
	$status = fwrite($fh, $output);
	fclose($fh);
}

function postprocess($type, $id){
switch ($type){
case 'a':
$query = "DELETE from articles WHERE FileID='$id'"; 
$tagquery = "DELETE from tags WHERE fileid='$id'"; 
$postresult = 'Article Deleted';
break;

case 'c':
$query = "DELETE from articles WHERE FileID='$id'"; 
$postresult = 'Comment Deleted';
break;

case 'q':
$query = "DELETE from articles WHERE FileID='$id' AND Approved='Q'"; 
$postresult = 'Question Deleted';
break;

case 'aa':
$query = "UPDATE articles SET Approved='Y' where FileID='$id' LIMIT 1"; 
$postresult = 'Article Approved';
addtag($id);
break;

case 'ac':
$query = "UPDATE articles SET Approved='Y' where FileID='$id' LIMIT 1"; 
$postresult = 'Comment Approved';
break;

}
// run query
$mysqldb = new mysql();
$mysqldb->connect();
$mysqldb->select();
$mysqldb->query($query);

if($tagquery){ $mysqldb->query($tagquery); }

if(PLUGINRSS){ updaterss(); }

return $postresult;
}

function addtag($id) {
if(!$id) {exit(); }
$mysqldb = new mysql();
$mysqldb->connect();
$mysqldb->select();
$mysqldb->query("SELECT Keyw FROM articles WHERE FileID='$id'");

 $row = $mysqldb->fetchObject();
 $keystotags = $row->Keyw;

// place keywords into tags table.
	$arrkeywords = explode(' ', $keystotags);

foreach ($arrkeywords as $keyword) {
	if(strlen($keyword)>4){
		$mysqldb->query("INSERT INTO tags (fileid, tag) VALUES ('$fileid', '$keyword')");
}

}
}

function proscribedfiletypes($type) {
switch ($type){
case 'application/x-httpd-php':
$type = 'TRUE';
break;

default:
$type = 'FALSE';
break;
}
return $type;
}

function errhandler($e_number, $e_message, $e_file, $e_line) {
	   if(PRODLEV==1){ error_reporting (0); } else { error_reporting (7); }
        $message = 'An error occurred in script ' . $e_file . ' on line ' . $e_line . ": $e_message";
        if(PRODLEV=='1'){        
	      /*uncomment out for email notification of errors and warnings */
	     // error_log ($message, 1, KBADMINEMAIL);
        	} else { 
		/* uncomment out for display errors and warning on page */
        	//echo '<font color="red" size="1">', $message, '</font>';
        }
}
set_error_handler('errhandler');
?>
