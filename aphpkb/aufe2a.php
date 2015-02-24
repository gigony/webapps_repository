<?php // aufe2a.php Authorise User for Email 2 Article
// Set the page title and include the HTML header. 

$adfl = TRUE; 
include_once "./config/config.php"; 
include_once "functions.php"; 
include "./classes/mysql.class.php";

$aid = $_REQUEST['aid'];

$title = 'Authorise User for Email 2 Article'; 
$fileid = mifi($_REQUEST['fileid']); 

 $mysqldb = new mysql();
 $mysqldb->connect();
 $mysqldb->select(); 

head_page($title);
menu_options($title, $vnum, $viewop, $pid, $keys, $adfl);
contentinit($title);

$first = TRUE; 

$query = "UPDATE authors SET Approved='Y' WHERE AuthorID='$aid'";
$mysqldb->query($query);

echo "Author authorised for Email 2 Article!<br /> 
</td></tr>\n";	 
 
// The HTML footer file. 
footer($title); 

?>