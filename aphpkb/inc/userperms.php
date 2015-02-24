<?php   /* article rating */
// get current user permissions

 $mysqldb->select(); 

 $mysqldb->query("SELECT Approved FROM authors WHERE AuthorID='$authorid'");
 
while($row = $mysqldb->fetchObject()){
$userperms = $row->Approved;
}

if(isset($_REQUEST['newperms'])) {$newperms = xss_clean($_REQUEST['newperms']);
/* we have the new user settings which we will update the user's table*/

$query = "UPDATE authors SET Approved = '$newperms' WHERE AuthorID='$authorid'";

 $mysqldb->select(); 

 $mysqldb->query($query);

$userperms = $newperms;
}
/* we'll just display the form */

// display rating form

echo '<p><form action="a_authordetails.php" method="post">';

switch($userperms){
case 'Y':
echo 'User/Author has <b>Full Permissions</b><br>
<input type="radio" name="newperms" value="B">Disable<br>
';

break;

case 'B':
echo 'User/Author has been <b>Disabled</b><br>';
echo '
<input type="radio" name="newperms" value="Y">Enable<br>
';
break;
case 'N':
echo 'User/Author has registered as a knowledgebase user<br>
<input type="radio" name="newperms" value="Y">Enable Full Permissions<br>
<input type="radio" name="newperms" value="B">Disable<br>
';
break;
default:
echo 'User/Author has registered as a knowledgebase user<br>
<input type="radio" name="newperms" value="Y">Enable Full Permissions<br>
<input type="radio" name="newperms" value="B">Disable<br>
';

}
echo '<input type="hidden" name="aid" value="' . $authorid . '">';
echo '&nbsp;&nbsp;<input type=submit name="submit" value="Submit"></form></p>';

/* end of user permissions */ 
?>