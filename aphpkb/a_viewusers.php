<?php // View Registered Users

//includes

include('./config/config.php');
include('functions.php');
include "./classes/mysql.class.php";

//starting database

 $mysqldb = new mysql();
 $mysqldb->connect();
 $mysqldb->select(); 

//variables
$adfl = TRUE;
$pagetitle = 'View Registered Users';

head_page($pagetitle);
menu_options($pagetitle, $vnum, $viewop, $pid, $keys, $adfl);
contentinit($pagetitle);
// Number of Records to show per page:
$display = DB_MAX_REC;

// Determine where in the db results to start returning results
if (isset($_GET['s'])) { // Already determined
$start = mifi($_GET['s']);
} else {
$start = 0;
}

$query="SELECT CONCAT(au.LastName, ', ', au.FirstName) AS name, au.AuthorID, DATE_FORMAT(RegistrationDate, '%M %d, %Y') AS dr,(SELECT COUNT(*) FROM articles AS a WHERE a.AuthorID=au.AuthorID AND a.Approved='N' AND a.ParentID='0') AS pending, (SELECT COUNT(*) FROM articles AS a WHERE a.AuthorID=au.AuthorID AND a.Approved='S' AND a.ParentID='0') AS saved, (SELECT COUNT(*) FROM articles AS a WHERE a.AuthorID=au.AuthorID AND a.Approved='Y' AND a.ParentID='0') AS approved, (SELECT COUNT(*) FROM articles AS a WHERE a.AuthorID=au.AuthorID AND  a.ParentID='0') AS total FROM authors AS au";





$viewquery = $query . " LIMIT $start, $display";
// That's the end of our query making.  

$mysqldb->query($query);
$num_records = $mysqldb->numRows($query);
$mysqldb->query($viewquery);

if ($num_records > $display) { // more than one page
$num_pages = ceil($num_records/$display);
} else {
$num_pages = 1;
}
$first = TRUE;

while($row = $mysqldb->fetchObject()){
$bg = ($bg=='#f5f5f5' ? '#cccccc' : '#f5f5f5');
if ($first) {
//name dr pending approved total
echo <<<EOF
<table border="0" cellspacing="0" cellpadding="5" align="center" width="95%"><tr>
<td align="left" width = "30%"><small>Name</small></td>
<td align="right" width = "30%"><small>Register Date</small></td>
<td align = "left" width = "10%"><small>Pending</small></td>
<td align = "left" width = "10%"><small>Saved</small></td>
<td align = "left" width = "10%"><small>Approved</small></td>
<td align = "right" width = "10%"><small>Total</small></td></tr>
EOF;
} 
echo "<tr bgcolor=\"$bg\"><td align=\"left\"><a href=\"a_authordetails.php?aid=$row->AuthorID\">$row->name</a></td>

<td align=\"right\"> $row->dr</td>

<td align=\"center\"> $row->pending</td>
<td align=\"center\"> $row->saved</td>
<td align=\"center\"> $row->approved</td>
<td align=\"center\"> $row->total</td>


</tr>";	


$first = FALSE; 


// One record has been returned

}
// End of While loop
// If no records were displayed...
if($first) {	

echo '
<p>No registered authors match the query.</p>';

} else {	

echo '</td></tr></table>'; 

			// Determine what page the script is on.	
			$current_page = ($start/$display) + 1;
			
			// If it's not the first page, make a Previous button.
			if ($current_page != 1) {
				echo '<a href="a_viewusers.php?s=' . ($start - $display) . '&np=' . $num_pages . '">Previous</a> ';
			
			
			// Make all the numbered pages.
			for ($i = 1; $i <= $num_pages; $i++) {
				if ($i != $current_page) {
					echo '<a href="a_viewusers.php?s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '">' . $i . '</a> ';
				} else {
					echo $i . ' ';
				}
			}
			}
			// If it's not the last page, make a Next button.
			if ($current_page != $num_pages) {
				echo '<a href="a_viewusers.php?s=' . ($start + $display) . '&np=' . $num_pages . '">Next</a>';
			}
			echo '</td></tr></table><br />';
		} // End of links section.

footer($title); 
?>
