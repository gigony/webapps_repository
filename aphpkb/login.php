<?php // login.php -- Author Login
$title = 'Author Login';


include_once('./config/config.php');
include('functions.php');

include "./classes/mysql.class.php";
 $mysqldb = new mysql();
 $mysqldb->connect();
 $mysqldb->select(); 
 

head_page($title);

menu_options($title, $vnum, $viewop, $pid, $keys, $adfl);
contentinit($title);

if (isset($_POST['submit'])) { // Check if the form has been submitted.


	
	if (empty($_POST['username'])) { // Validate the username.
		$u = FALSE;
		echo '<p>You forgot to enter your username!</p>';
	} else {
		$u = escdata(xss_clean(($_POST['username'])));
	}
	
	if (empty($_POST['password'])) { // Validate the password.
		$p = FALSE;
		echo '<p>You forgot to enter your password!</p>';
	} else {
		$p = escdata(xss_clean($_POST['password']));
	}
	
	if ($u && $p) { // If everything's OK.
	
		// Query the database.
		$query = "SELECT AuthorID, FirstName FROM authors WHERE UserName='$u' AND Passwd=PASSWORD('$p') AND Approved!='B'";		
		$mysqldb->query($query);

		$row = $mysqldb->fetchObject();
		
		
		if ($row) { // A match was made.
				
				// Start the session, register the values & redirect.
				$_SESSION['first_name'] = $row->FirstName;
				$_SESSION['user_id'] = $row->AuthorID;
				
				if($u=='Admin' || $u=='admin'){ $_SESSION['adfl'] = TRUE; }
				
				ob_end_clean(); // Delete the buffer.
				
				if($u=='Admin' || $u=='admin'){
				
				header ("Location: http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/a_index.php");
				exit();
				}
				
				header ("Location:  http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/authors.php");
				exit();
				
		} else { // No match was made.
			echo '<p>The username and password entered do not match those on file.  Or the account has been disabled.  Try again, or contact your Knowledgebase Administrator.</p>'; 
		}
		
		 
		
	} else { // If everything wasn't OK.
		echo '<p>Please try again.</p>';		
	}	
}?>

<small>Your browser must allow cookies in order to login.</small><br /><br />
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

<p>User Name:<br /><input type="text" name="username" size="10" maxlength="20" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>" /></p>
<p>Password:<br /><input type="password" name="password" size="20" maxlength="20" /></p>
<input type="submit" name="submit" value="Login" />
</form>
<?php
footer($title);
?>
