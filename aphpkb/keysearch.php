<?php // keysearch.php Articles by Keywords

//includes

include('./config/config.php');
include('functions.php');
include "./classes/mysql.class.php";

//starting database

 $mysqldb = new mysql();
 $mysqldb->connect();
 $mysqldb->select(); 

//variables

$pagetitle = 'Search Results';

if($_REQUEST['authorid'] || $_REQUEST['authorname']){
$authorid = mifi($_REQUEST['authorid']);
$authorname = escdata($_REQUEST['authorname']);
$authorquery = "SELECT a.FileID, a.Title, a.ArticleData, a.AuthorID, (SELECT au.UserName FROM authors as au WHERE au.AuthorID=a.AuthorID) AS AuthorName, a.Keyw, a.Approved, DATE_FORMAT(a.SubmitDate, '%m/%e/%y') as date FROM articles AS a WHERE a.ParentID=0 AND a.Approved='Y' AND a.AuthorID=$authorid";
}

if($_REQUEST['keyword_list']){
	        $keyword_list = escdata(xss_clean($_REQUEST['keyword_list'])); 
	} else { 
		$keyword_list = 'nothing'; 
	}

if($_REQUEST['authorid'] || $_REQUEST['authorname']){
$pagetitle = "Articles by $authorname ";
} else {
$pagetitle = "Search Results for \"$keyword_list\"";
}

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

$firstquery = "SELECT a.FileID, a.Title, a.ArticleData, a.AuthorID, (SELECT au.UserName FROM authors as au WHERE au.AuthorID=a.AuthorID) AS AuthorName, a.Keyw, a.Approved, DATE_FORMAT(a.SubmitDate, '%m/%e/%y') as date FROM articles AS a WHERE a.ParentID=0 AND a.Approved='Y' AND Keyw LIKE ";

	$endquery = " ORDER by FileID";
	$arrkeywords = explode(' ', $keyword_list);
	$firsttime = "TRUE";

foreach ($arrkeywords as $keyword) {

	if($keyword == " " || $keyword == "") continue;

		if ($firsttime == "FALSE") {
			$keywordquery = $keywordquery . " OR Keyw LIKE " ;
		}
			$keywordquery = $keywordquery . "'%{$keyword}%'";
		$firsttime = "FALSE";
	}

$query = $firstquery . $keywordquery . $endquery;

if($_REQUEST['authorid'] || $_REQUEST['authorname']){
$query = $authorquery;
}

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

echo <<<EOF
<table border="0" cellspacing="0" cellpadding="5" align="center" width="95%"><tr>
<td align="left" width = "30%"><small>Title</small></td>
<td align="left" width = "40%"><small>Summary</small></td>
<td align = "left" width = "10%"><small>Author</small></td>
<td align = "right" width = "20%"><small>Last Updated</small></td></tr>
EOF;
} 
if($row->AuthorID == '0') {$authorname = 'Guest'; } else {$authorname = $row->AuthorName;}
echo "<tr bgcolor=\"$bg\"><td align=\"left\"><a href=\"v.php?a=$row->FileID\">$row->Title</a></td>";

echo '<td align="left">';
echo strip_tags(substr(stripslashes($row->ArticleData),0,52) . '...');
echo '</td>';
echo "<td align=\"left\">
<a href=\"keysearch.php?authorid=" . $row->AuthorID . '&authorname=' . $authorname . '">' . $authorname . "</a></td>

<td align=\"right\">
$row->date</td></tr>";	

$first = FALSE; 
$authorname = '';

// One record has been returned

}
// End of While loop
// If no records were displayed...
if($first) {	

echo '
<p>No articles match the query.</p>

<p>Please search again and use more specific keywords.<br />
Multiple keywords can be used to refine the search.</p>';

$searchwidth='30%';
include('search.php');
echo '</td></tr></table>'; 

} else {	

echo '</td></tr></table>'; 

			// Determine what page the script is on.	
			$current_page = ($start/$display) + 1;
			
			// If it's not the first page, make a Previous button.
			if ($current_page != 1) {
				echo '<a href="keysearch.php?keyword_list=' . $keyword_list . '&s=' . ($start - $display) . '&np=' . $num_pages . '">Previous</a> ';
			
			
			// Make all the numbered pages.
			for ($i = 1; $i <= $num_pages; $i++) {
				if ($i != $current_page) {
					echo '<a href="keysearch.php?keyword_list=' . $keyword_list . '&s=' . (($display * ($i - 1))) . '&np=' . $num_pages . '">' . $i . '</a> ';
				} else {
					echo $i . ' ';
				}
			}
			}
			// If it's not the last page, make a Next button.
			if ($current_page != $num_pages) {
				echo '<a href="keysearch.php?keyword_list=' . $keyword_list . '&s=' . ($start + $display) . '&np=' . $num_pages . '">Next</a>';
			}
			echo '</td></tr></table><br />';
		} // End of links section.

footer($index); 
?>
