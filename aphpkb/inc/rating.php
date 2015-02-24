<?php   /* article rating */
if(isset($_REQUEST['score'])) {$score = mifi($_REQUEST['score']);}
$newratedtotal = '';
// get existing rating

 $mysqldb->select(); 

 $mysqldb->query("SELECT RatingTotal, RatedTotal from articles WHERE FileID=$a");

while($row = $mysqldb->fetchObject()){
$sum = $row->RatingTotal;
$rcount = $row->RatedTotal;
}

if ($rcount > 0) {
   $articleRating = $sum/$rcount;
} else {
   $articleRating = 0;
}

if(!isset($score)){ /* if we don't have a score, we'll just display the form */

// display rating form

echo "<p><form action=\"v.php?a=$a\" method=\"post\">";
$begbuttonstr = '<input type="radio" name="score" value="';
$endbuttonstr = '" />';
$starstr = '<img src="./imgs/star.gif" height="10" width="10" />';
$starcount = 5;
$star = 5;
while($starcount >0 ) {
echo $begbuttonstr . $starcount . $endbuttonstr;
while($star > 0) {
echo $starstr;
$star = $star - 1;
}
echo '<br />';
$starcount = $starcount - 1;
$star = $starcount;
}
echo '&nbsp;&nbsp;<input type=submit name="submit" value="Submit"></form></p>';

} else {
/* else if we have the new score we can add the score to the running total RatingTotal and
add 1 to the count which is RatedTotal */

// add score to RatingTotal and add 1 to RatedTotal
$newratingtotal = $score + $sum;
$newratedtotal = $rcount + 1;
// pop the values back into the database

 $mysqldb->select(); 

 $mysqldb->query("UPDATE articles SET RatingTotal = '$newratingtotal', RatedTotal = '$newratedtotal' WHERE FileID='$a'");



}
// display $score and $newrating
if ($newratedtotal > 0) {
   $newrating = $newratingtotal / $newratedtotal;
} else {
   $newrating = 0;
}

if(isset($score)) { echo 'You have rated this article at: ' . $score . '<br />  The overall rating for this article is: ' . substr($newrating,0,4) . '<br />'; }
else { echo 'Article Rating: ' . substr($articleRating,0,4) . '<br /></div>';}

/* end of article rating */ 
?>
