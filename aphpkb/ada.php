<?php // delete.php Delete Article

include('./config/config.php');
include('functions.php');
$title = 'Delete Article'; 

include "./classes/mysql.class.php";
$mysqldb = new mysql();
$mysqldb->connect();
$mysqldb->select(); 
 
head_page($title);
menu_options($title, $vnum, $viewop, $pid, $keys, $adfl);
contentinit($title);
 
$fileid = mifi($_GET['num']); 
// must be the author of this article to be able to delete it.
if (!isset($_SESSION['first_name'])) {

	header ("Location:  http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.php");
	ob_end_clean();
	exit();
} else {
$first = TRUE; 
$mysqldb->query("DELETE from articles WHERE FileID='$fileid' AND AuthorID='{$_SESSION['user_id']}'"); 
echo "Article Deleted!<br /> 
</td></tr>\n";	 
footer($title);
} 
?>