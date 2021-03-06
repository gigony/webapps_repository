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
** $Id: view-doc.inc 16 2006-06-27 23:20:45Z sgrayban $
*/

if ( ! $helpContext ) $helpContext = $defaultTopic;

print ("</center><br><br>\n" .
       "<table cellpadding=\"4\" cellspacing=\"0\" border=\"0\">\n" .
       "<tr><td width=\"160\" valign=\"top\">\n" .
       "\n\n<table cellpadding=$padding cellspacing=\"0\" border=\"0\" " .
       "bgcolor=\"$leftFormColor\">\n");

/* 
 * handle context sensitive left side content. <-- OR NOT!  STATIC LOOKS GOOD.
 */

print ("<tr><td>\n" . // "nowrap" ???
       "<br><big>TOPICS</big><br><br>\n");

$q  = "SELECT * FROM Faq WHERE parent_id = 0 AND publish = 'y' ";
$q .= "ORDER BY list_order";
$result0 = mysql_query ($q, $dbLink);

while ( $faq0 = mysql_fetch_array ($result0) )
{
  if ( $faq0["title"] == "" ) $faq0["title"] = "???";

  $idList[] = $faq0["id"];

  print ("<a href=\"./?context=View+Document&helpContext=" . 
	 urlencode($faq0["context"]) . "\">" .
	 "<small>" . $faq0["title"] . "</small></a><br>\n");

  $q  = "SELECT * from Faq WHERE parent_id = " . $faq0["id"] . " ";
  $q .= "AND publish = 'y' ORDER BY list_order";
  $result1 = mysql_query($q, $dbLink);
  
  while ( $faq1 = mysql_fetch_array ($result1) )
    {
      if ( $faq1["title"] == "" ) $faq1["title"] = "???";

      $idList[] = $faq1["id"];

      print ("<a href=\"./?context=View+Document&helpContext=" . 
	     urlencode($faq1["context"]) ."\">" .
	     "<small>&nbsp;&nbsp;&nbsp;" . $faq1["title"] .
	     "</small></a><br>\n");

      $q  = "SELECT * from Faq WHERE parent_id = " . $faq1["id"] . " ";
      $q .= "AND publish = 'y' ORDER BY list_order";
      $result2 = mysql_query($q, $dbLink);
  
      while ( $faq2 = mysql_fetch_array ($result2) )
	{
	  if ( $faq2["title"] == "" ) $faq2["title"] = "???";
	  
	  $idList[] = $faq2["id"];
	  
	  print ("<a href=\"./?context=View+Document&helpContext=" . 
		 urlencode($faq2["context"]) ."\">" .
		 "<small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" .
		 $faq2["title"] . "</small></a><br>\n");
	}
    }
}

print ("</td></tr>\n" .
       "</table>\n\n" .
       "</td>\n\n" .

       "<!------------  Start right side content ------------>\n\n" .

       "<td width=\"540\" valign=\"top\">\n\n" .
       "<table cellpadding=\"2\" cellspacing=\"0\" border=\"0\" width=\"100%\">\n");

$q = "SELECT * FROM Faq WHERE context =  '$helpContext'";
$result = mysql_query ($q, $dbLink);
$faq = mysql_fetch_array ($result);

$helpId = $faq["id"];
$list[] = urlencode($faq["context"]);
$faqTitle[] = $faq["title"];

while ( $faq["parent_id"] != 0 )
{
  $faqId = $faq["parent_id"];
  $q = "SELECT * FROM Faq WHERE id = $faqId";
  $result = mysql_query ($q, $dbLink);
  $faq = mysql_fetch_array ($result);
  $list[] = urlencode($faq["context"]);
  $faqTitle[] = $faq["title"];
}

print ("<tr><td colspan=\"3\">" .
       "<small>\n");

for ( $i = ( count ($list) - 1 ); $i >= 0; $i-- )
{
  print ("<a href=\"./?context=View+Document&helpContext=" . $list[$i] . "\">" . $faqTitle[$i] . "</a>");
  if ( $i > 0 ) print (" <b>-></b>\n");
}

print ("</td></tr>\n");

if ( ! $current ) $current = 0;

$q  = "SELECT * FROM FaqPage WHERE owner_id = $helpId";
$result = mysql_query ($q, $dbLink);
$numPages = mysql_num_rows ($result);

while ( $faqPage = mysql_fetch_array ($result) )
{
  if ( $current == $faqPage["page_num"] ) 
    {
      $faqText = $faqPage["faqText"];
      $thisPage = $faqPage["page_num"] + 1;
    }
}

$context = urlencode($context);

print ("<tr bgcolor=\"#dddddd\">");

if ( ( $thisPage > 1 ) && ( $numPages > 1 ) )
{
  $last = $current - 1;
  print ("<td align=\"center\" width=\"20%\"><small>" .
	 "<a href=\"./?context=$context&helpContext=" . 
	 urlencode($helpContext) . "&current=$last\"><< Prev</a></td>\n");
}
else
{
  print ("<td align=\"center\" width=\"20%\">&nbsp;</td>\n");
}

print ("<td align=\"center\" width=\"60%\"><small>" .
       "<strong>Page $thisPage of $numPages</strong></td>\n");


if ( ( $thisPage < $numPages ) && ( $numPages > 1 ) )
{
  $next = $current + 1;
  print ("<td align=\"center\" width=\"20%\"><small>" .
	 "<a href=\"./?context=$context&helpContext=" . 
	 urlencode($helpContext) . "&current=$next\">Next >></a></td>\n");
}
else
{
  print ("<td align=\"center\" width=\"20%\">&nbsp;</td>\n");
}

print ("</tr></table>\n" .
       "<table cellpadding=\"6\" cellspacing=\"0\" border=\"0\" width=\"100%\">" .
       "<tr bgcolor=\"#eeeeee\"><td colspan=\"3\">\n" .
       "<strong><u>" . $faqTitle[0] . "</u></strong><br><br>\n" .
       "<small>" . $faqText . "</small>\n" .
       "<br></td></tr></table>\n");

print ("<table cellpadding=\"2\" cellspacing=\"0\" border=\"0\" width=\"100%\">\n" .
       "<tr bgcolor=\"#dddddd\">");

if ( ( $thisPage > 1 ) && ( $numPages > 1 ) )
{
  $last = $current - 1;
  print ("<td align=\"center\" width=\"20%\"><small>" .
	 "<a href=\"./?context=$context&helpContext=" . 
	 urlencode($helpContext) . "&current=$last\"><< Prev</a></td>\n");
}
else
{
  print ("<td align=\"center\" width=\"20%\">&nbsp;</td>\n");
}

print ("<td align=\"center\" width=\"60%\"><small>" .
       "<strong>Page $thisPage of $numPages</strong></td>\n");


if ( ( $thisPage < $numPages ) && ( $numPages > 1 ) )
{
  $next = $current + 1;
  print ("<td align=\"center\" width=\"20%\"><small>" .
	 "<a href=\"./?context=$context&helpContext=" . 
	 urlencode($helpContext) . "&current=$next\">Next >></a></td>\n");
}
else
{
  print ("<td align=\"center\" width=\"20%\">&nbsp;</td>\n");
}

print ("</tr>\n" .
       "</table>\n\n" .
       "</td></tr>\n" .
       "</table>\n\n" .
       "</body>\n" .
       "</html>\n");
?>
