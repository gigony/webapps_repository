<?php // Submit Saved Article
// Set the page title and include the HTML header. 

$adfl = FALSE; 
include_once "./config/config.php"; 
include_once "functions.php"; 
include "./classes/mysql.class.php";

$title = 'Submit Saved Article'; 
$fileid = mifi($_REQUEST['fileid']); 

 $mysqldb = new mysql();
 $mysqldb->connect();
 $mysqldb->select(); 

head_page($title);
menu_options($title, $vnum, $viewop, $pid, $keys, $adfl);
contentinit($title);

// must be the author of this article to be able to delete it.

if (!isset($_SESSION['first_name'])) {

	header ("Location:  http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.php");
	ob_end_clean();
	exit();
	
} else {

$first = TRUE; 

$query = "UPDATE articles SET Approved='N' where FileID='{$fileid}' AND AuthorID='{$_SESSION['user_id']}' LIMIT 1";
$mysqldb->query($query);

echo "Article Submitted!<br /> 
</td></tr>\n";	 
 
// The HTML footer file. 
footer($title); 
} 
?>
