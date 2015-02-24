<?php // a_authordetails.php -- Admin view Author Details

include('./functions.php');
require_once ('./config/auth.php'); 
require ('./config/config.php');
  include "./classes/mysql.class.php";
 $mysqldb = new mysql();
 $mysqldb->connect();
 $mysqldb->select(); 

$authorid = mifi($_REQUEST[aid]);  

$mysqldb->query("SELECT CONCAT(FirstName, ' ', LastName) AS name, Approved, UserName, Email, DATE_FORMAT(RegistrationDate, '%M %d, %Y') AS dr, (SELECT count(*) from articles WHERE Approved = 'N' AND AuthorID='$authorid') AS PendingArticles, (SELECT count(*) from articles WHERE Approved = 'Y' AND AuthorID='$authorid') AS ApprovedArticles, (SELECT count(*) from articles WHERE Approved = 'S' AND AuthorID='$authorid') AS SavedArticles FROM authors WHERE AuthorID='$authorid'");
$row = $mysqldb->fetchObject();

$totalarticles = $row->ApprovedArticles + $row->PendingArticles + $row->SavedArticles;

if(isset($_REQUEST['newperms'])) {
$title = 'Permissions Updated';
} else {
$title = 'Author details for ' . $row->name . ' (' . $row->UserName . ')';
}

$approved = $row->Approved;

if($approved != 'Y'){
$approved = "<a href=\"aufe2a.php?aid=$authorid\">$row->Approved</a>";
}

head_page($title);
menu_options($title, $vnum, $viewop, $pid, $keys, $adfl);
contentinit($title);
echo <<<_AUTHORDETAILS
AuthorID : $authorid<br />
UserName : $row->UserName<br />
Full Name : $row->name<br />
Permissions : $row->Approved<br>
Email Address : $row->Email<br />
RegistrationDate : $row->dr<br />
Approved Articles : $row->ApprovedArticles<br />
Pending Articles : $row->PendingArticles<br />
Saved Articles : $row->SavedArticles<br />
<br />
Total Articles : <a href="keysearch.php?authorid=$authorid&authorname=$row->UserName">$totalarticles</a><br />
</td>
_AUTHORDETAILS;
include("./inc/userperms.php");
footer();
?>
