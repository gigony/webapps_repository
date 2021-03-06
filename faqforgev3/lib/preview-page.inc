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
** $Id: preview-page.inc 16 2006-06-27 23:20:45Z sgrayban $
*/

$pageTitle = stripslashes ( $pageTitle );

$encText = urlencode ($faqText);
$faqText = stripslashes ($faqText);
$faqText = ereg_replace ("\$site", $site, $faqText);

print ("<center><big>Page Preview</big><br><br>\n\n" .
       "<table bgcolor=\"#000000\" cellpadding=\"2\" cellspacing=\"0\" border=\"0\">\n" .
       "<tr><td>\n\n" .
       "<table bgcolor=\"#eeeeee\" cellpadding=\"8\" cellspacing=\"0\" " .
       "width=\"540\" border=\"0\">\n" .
       "<tr><td><strong><u>$pageTitle</td></tr>\n" .
       "<tr><td>\n" . $faqText . "</td></tr>\n" .
       "</table>\n\n" .
       "</td></tr>\n" .
       "</table>\n\n" .
       "<br>\n" .
       "<a href=\"?context=Edit+Page&id=$faqId&pageId=$pageNum" .
       "&faqText=$encText#$pageNum\">Modify Changes</a>\n" .
       "&nbsp;&nbsp;&nbsp;&nbsp;\n" .
       "<a href=\"?context=Edit+Page&id=$faqId&pageId=$pageNum" .
       "&action=commit&faqText=$encText\">" .
       "Commit Changes</a>\n" .
       "</center>\n" .
       "</body>\n" .
       "</html>\n");

?>
