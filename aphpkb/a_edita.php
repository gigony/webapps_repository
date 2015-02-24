<?php // adminea.php Admin Edit Article
include('./functions.php');
require_once ('./config/auth.php');
include('./config/config.php');
include "./classes/mysql.class.php";
$mysqldb = new mysql();
$mysqldb->connect();
$mysqldb->select(); 

$enum = mifi($_REQUEST['num']);
 
if(isset($_REQUEST['submit'])) {  
        // Handle the Form 
 
	$message = NULL;  
        // Create an empty new variable. 
 
	// Check for Title. 
	if (strlen($_REQUEST['title']) > 0) { $title = TRUE; 
	} else { 
	$title = FALSE; 
	$message .= 'needs a title, '; 
	} 
 
	// Check for Article. 
	if (strlen($_REQUEST['article']) > 0) { $article = TRUE; 
	} else { 
	$article = FALSE; 
	$message .= 'needs content, '; 
	} 
 
	// Check for Keywords. 
	if (strlen($_REQUEST['keywords']) > 0) { $keywords = TRUE; 
	} else { 
	$keywords = FALSE; 
	$message .= 'needs keywords, '; 
	} 
 
	if ($title && $article && $keywords) { // If everythings okay. 
 
	$titlesql = escdata($_REQUEST['title']); 
	$keywordssql = escdata($_REQUEST['keywords']); 


//    $articledatasql = escdata($_REQUEST['article']);
$articledatasql = $_REQUEST['article'];
	 $mysqldb->query("UPDATE articles SET Title = '$titlesql', Articledata = '$articledatasql', Keyw = '$keywordssql' WHERE FileID='$enum'");
	
    $message .= "has been updated successfully.  This article "; 
 
    // now that the database is updated, we'd like to put these values back
 
	$title = xss_clean($_REQUEST['title']); 
	$keywords = xss_clean($_REQUEST['keywords']); 
    $articledata = xss_clean($_REQUEST['article']);
    

    
    
    } else { 
 
	$message .= ' and has not been updated, please try again.  This article '; 
 
	} 
} 
 
 
// Set the page title and include the HTML header. 
 
$title = 'Edit Article'; 
head_page($title);
menu_options($title, $vnum, $viewop, $pid, $keys, $adfl);
contentinit($title);

$mysqldb->select(); 

 $mysqldb->query("SELECT Title, Approved, Keyw, Articledata from articles WHERE FileID='$enum' LIMIT 1");
 
 while($row = $mysqldb->fetchObject()){

	$title = $row->Title;
	$keywords = $row->Keyw;
	$pending = $row->Approved;
	$articledata = stripslashes($row->Articledata);
	    
}    
   
     
?> 
 
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"> 
<fieldset><legend>This article <?php 


// Print the error message if there is one. 
 
  if (isset($message)) { 
 	echo $message; 
} 




switch ($pending) {
case ('Y'):
$approvalstatus = 'is approved';
break;

case ('S'):
$approvalstatus = 'is saved but not yet submitted';
break;

case ('N'):
$approvalstatus = 'is pending approval';
break;
}

echo $approvalstatus; ?>

</legend> 
<?php
echo <<<_FORM

<p>Title:<br /> 
<input type="text" name="title" size="60" maxlength="60" value="$title" /></p> 

<p>Article:<br />
_FORM;
if (isset($articledata)) {
$textareacontent=$articledata; } 
$textareaname='article';
include('./textarea.php'); 
?>
</p> 
 
<p>Keywords:<br /> 
<input type="text" name="keywords" size="60" maxlength="120" value="<?php echo $keywords; ?>" /></p> 

<input type="hidden" name="num" value="<?php echo $enum; ?>" />

</fieldset> 

<p> 
<input type="submit" name="submit" value="Save" /><input type="reset" Value="Revert" /></p> 
</form> 
<?php footer($title);?> 