<?php
$libPath = "./lib/";

require ( $libPath . "faqforge-config.inc" );
require ( $libPath . "functions.inc" );


session_start();
function session_clear() {
// if session exists, unregister all variables that exist and destroy session
  $exists = "no";
  $session_array = explode(";",session_encode());
  for ($x = 0; $x < count($session_array); $x++) {
    $name  = substr($session_array[$x], 0, strpos($session_array[$x],"|")); 
  if (session_is_registered($name)) {
    session_unregister('$name');
    $exists = "yes";
  }
  }
if ($exists != "no") {
    session_destroy();
  }
}
session_clear();


$dbLink = mysql_connect ($dbServer, $dbUser, $dbPass);
mysql_select_db ($dbName);

$q = "truncate FaqPage";
mysql_query ($q, $dbLink);

$q = "truncate Faq";
mysql_query ($q, $dbLink);

print("<html><head></head><body>DB cleared!</body></html>");

mysql_close ( $dbLink );

?>

