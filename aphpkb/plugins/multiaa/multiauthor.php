<?php // multiauthor.php

//starting database

 $mysqldb = new mysql();
 $mysqldb->connect();
 $mysqldb->select(); 

$query="SELECT Username, AuthorID FROM authors";

$mysqldb->query($query);
$first=TRUE;
while($row = $mysqldb->fetchObject()){
if($first==TRUE){
echo '<select name="aid">';

echo '<option value="' . $aid . '">Remain the Author for this Article (default)</option>';
}
echo <<<_OPTIONS
<option value="$row->AuthorID">$row->Username</option>
_OPTIONS;
$first=FALSE;
}
echo "</select> Save to new Author.<br />";

?>
