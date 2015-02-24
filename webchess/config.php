
<?php

$_CONFIG=true;

/* database settings */
$CFG_SERVER = 'localhost';
$CFG_USER = 'test';
$CFG_PASSWORD = 'test';
$CFG_DATABASE = 'webchess';

/* server settings */
$CFG_SESSIONTIMEOUT = 900;
$CFG_EXPIREGAME = 14;
$CFG_MINAUTORELOAD = 5;
$CFG_USEEMAILNOTIFICATION = FALSE;
$CFG_MAILADRESS = 'gigony@gmail.com';
$CFG_MAINPAGE = 'webchess.dev';
$CFG_MAXUSERS = 50;
$CFG_MAXACTIVEGAMES = 50;
$CFG_NICKCHANGEALLOWED = TRUE;
$CFG_NEW_USERS_ALLOWED = TRUE;
$CFG_BOARDSQUARESIZE = 50;
/* mysql table names */
$CFG_TABLE[communication] = "communication";
$CFG_TABLE[games] = "games";
$CFG_TABLE[history] = "history";
$CFG_TABLE[messages] = "messages";
$CFG_TABLE[pieces] = "pieces";
$CFG_TABLE[players] = "players";
$CFG_TABLE[preferences] = "preferences";

$CFG_IMAGE_EXT = 'gif';
?>