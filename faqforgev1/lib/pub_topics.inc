<?
/*
** FaqForge
** Copyright (C) 2004-2006 Scott Grayban <sgrayban@users.sourceforge.net>
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
** Last updated $Date: 2006-06-27 15:07:49 -0700 (Tue, 27 Jun 2006) $
**
** $Id: pub_topics.inc 9 2006-06-27 22:07:49Z sgrayban $
*/

print ("<center><big>$defaultwebTitle</big><br>\n");

if ( $message )
{
  print ("<br>\n" .
	 "<table bgcolor=\"#ff0000\" cellpadding=\"3\" cellspacing=\"0\" border=\"0\">\n" .
	 "<tr><td>\n" .
	 "<table bgcolor=\"#eeeeee\" cellpadding=\"20\" cellspacing=\"0\" border=\"0\">\n".
	 "<tr><td>$message</td></tr>\n" .
	 "</table>\n" .
	 "</td></tr>\n" .
	 "</table><br>\n\n");
}

print ("<br>\n\n" .
       "<table bgcolor=\"#000000\" cellpadding=\"2\" cellspacing=\"0\" border=\"0\">\n" .
       "<tr><td>\n\n" .
       "<table bgcolor=\"#eeeeee\" cellpadding=\"4\" cellspacing=\"1\" border=\"0\">\n" .
       "<tr bgcolor=\"#dddddd\">\n" .
       "<th width=\"200\">HOWTO's</th>\n" .
       "</tr>\n");

$q  = "SELECT * FROM Faq WHERE parent_id = 0 ORDER BY list_order";
$result0 = mysql_query ($q, $dbLink);

while ( $faq0 = mysql_fetch_array ($result0) )
{
  if ( $faq0["title"] == "" ) $faq0["title"] = "???";

  $idList[] = $faq0["id"];

  print ("<tr bgcolor=\"#eeeeee\">\n" .
	 "<td width=\"200\">\n" .
	 "<small><a href=\"./?context=View+Document&helpContext=" . 
	 urlencode($faq0["context"]) ."\">" .
	 $faq0["title"] .
	 "</a></td>\n" .
	 "</td></tr>\n");

  $q  = "SELECT * from Faq WHERE parent_id = " . $faq0["id"] . " ";
  $q .= "ORDER BY list_order";
  $result1 = mysql_query($q, $dbLink);
  
  while ( $faq1 = mysql_fetch_array ($result1) )
    {
      if ( $faq1["title"] == "" ) $faq1["title"] = "???";

      $idList[] = $faq1["id"];

      print ("<tr bgcolor=\"#eeeeee\">\n" .
	     "<td width=\"200\">\n" .
	     //"&nbsp;&nbsp;&nbsp;&nbsp;" .
	     " -> " .
	     "<small><a href=\"./?context=View+Document&helpContext=" . 
	     urlencode($faq1["context"]) ."\">" .
	     $faq1["title"] . 
	     "</a></td>\n" .
	     "</td></tr>\n");

      $q  = "SELECT * from Faq WHERE parent_id = " . $faq1["id"] . " ";
      $q .= "ORDER BY list_order";
      $result2 = mysql_query($q, $dbLink);
      
      while ( $faq2 = mysql_fetch_array ($result2) )
	{
	  if ( $faq2["title"] == "" ) $faq2["title"] = "???";
	  
	  $idList[] = $faq2["id"];
	  
	  print ("<tr bgcolor=\"#eeeeee\">\n" .
		 "<td width=\"200\">\n" .
		 //"&nbsp;&nbsp;&nbsp;&nbsp;" .
		 " ---> " .
		"<small><a href=\"./?context=View+Document&helpContext=" .
		 urlencode($faq1["context"]) ."\">" .
		 $faq2["title"] .
		 "</a></td>\n" .
		 "</td></tr>\n");
	}
    }
}
print ("</table>\n\n" .
       "</td></tr>\n" .
       "</table>\n\n" .
       "<br>" .
       "<a href=\"http://www.mysql.com\" target=\"_blank\"><img border=\"0\" src=\"/images/mysql.png\" alt=\"Poweder by MySQL\"></a>" .
       "&nbsp;&nbsp;<a href=\"http://www.php.net\" target=\"_blank\"><img border=\"0\" src=\"/images/php.png\" alt=\"Powered by PHP\"></a>" .
       "\n" .
       "</body>\n");

?>
