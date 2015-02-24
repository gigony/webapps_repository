<?
/* login page */
/*
** FaqForge
** Copyright (C) 2004-2005 Scott Grayban <sgrayban@users.sourceforge.net>
** Copyright (C) 2000 Andrew C. Bertola <drewb@users.sourceforge.net>
**          All Rights Reserved
** 
** FaqForge is free software; you can redistribute it and/or modify
** it under the terms of the GNU General Public License as published by
** the Free Software Foundation; either version 2 of the License, or
** (at your option) any later version.
**
** FaqForge is distributed in the hope that it will be useful,
** but WITHOUT ANY WARRANTY; without even the implied warranty of
** MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
** GNU General Public License for more details.
**
** You should have received a copy of the GNU General Public License
** along with FaqForge; if not, write to the Free Software
** Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
**
**
** Last updated 2004-10-25
**
** $Id: index.php 2 2006-02-22 10:01:14Z sgrayban $
*/
require_once("adminOnly.php");

$libPath = "../lib/";
require ( $libPath . "faqforge-config.inc" );
require ( $libPath . "functions.inc" );

if ( ! $context ) 
{
  $context = "Topics List";
}

$title = "FaqForge - $context";

$dbLink = mysql_connect ($dbServer, $dbUser, $dbPass);
mysql_select_db ($dbName);

switch ( $action )
{
case "deleteTopic":
  {
    $message = delete_topic_test ( $id, $dbLink );
    break;
  }
case "DELETETopic":
  {
    delete_topic ( $id, $dbLink );
    break;
  }
case "addNewTopic":
  {
    add_new_topic ( $newTitle, $newParent, $newContext, $newOrder, $dbLink );
    break;
  }
case "commit":
  {
    update_page ( stripslashes($faqText), $pageId, $id, $dbLink );
    break;
  }
case "Update Topic":
  {
    $topicPublish = ( $topicPublish == "on" ) ? "y" : "n";
    
    update_topic ( $topicTitle, $topicContext, $topicParent, 
		   $topicOrder, $topicPublish, $id, $dbLink );
    break;
  }
case "deletePage":
  {
    $message = delete_page_test ( $page_num, $id, $dbLink );
    break;
  }
case "DELETEPage":
  {
    delete_page ( $id, $page_num, $dbLink );
    
    mysql_close ($dbLink);
    header("Location: http://" . $SERVER_NAME . $SCRIPT_NAME . 
	   "?context=Edit+Page&id=$id");
    exit;
  }
case "addPage":
  {
    add_new_page ( $id, $dbLink );
    
    mysql_close ($dbLink);
    header("Location: http://" . $SERVER_NAME . $SCRIPT_NAME .
	   "?context=Edit+Page&id=$id");
    exit;
  }
case "moveUp":
  {
    swap_page_position ( $page_num, $page_num - 1, $id, $dbLink );
    
    mysql_close ($dbLink);
    header("Location: http://" . $SERVER_NAME . $SCRIPT_NAME . 
	   "?context=Edit+Page&id=$id#" . $newNum);
    exit;
  }
case "moveDown":
  {
    swap_page_position ( $page_num, $page_num++, $id, $dbLink );
    
    mysql_close ($dbLink);
    header("Location: http://" . $SERVER_NAME . $SCRIPT_NAME . 
	   "?context=Edit+Page&id=$id#" . ($newNum + 1));
    exit;
  }
}

require ( $libPath . "header.inc" );

switch ( $context )
{
case "Topics List":
  {
    require ( $libPath . "topics.inc" );
    break;
  }
case "Edit Page":
  {
    require ( $libPath . "edit-page.inc" );
    break;
  }
case "Preview Page":
  {
    require ( $libPath . "preview-page.inc" );
    break;
  }
case "View Document":
  {
    include ( $libPath . "view-doc.inc" );
    break;
  }
default:
  {
    require ( $libPath . "topics.inc" );
    break;
  }  
}



mysql_close ( $dbLink );


?>
