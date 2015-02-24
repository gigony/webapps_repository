<?php 
extract($_REQUEST);
extract($_SERVER);
extract($_SESSION);
extract($_GET);
extract($_POST);
function session_register($name){
          global $$name;
          $_SESSION[$name] = $$name;
          $$name = &$_SESSION[$name]; 
}
function session_is_registered($x) {return isset($_SESSION[$x]);}
function session_unregister($name){
	global $$name;
	unset($_SESSION[$name]);
	unset($$name);
}
?>

