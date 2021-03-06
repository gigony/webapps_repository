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
** $Id: header.inc 18 2006-06-27 23:27:22Z sgrayban $
*/

print ("<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n");
print ("<!-- Copyright 2000 Andrew C. Bertola, All Rights Reserved -->\n");
print ("<!-- Copyright 2004-2006 Scott Grayban, All Rights Reserved -->\n\n");
print ("<html>\n" .
       "<head>\n" .
       "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">\n" .
       "<style type=\"text/css\">\n" .
       "<!--\n" .
       "body  { font-face: verdana, arial, helvetica, times ; }\n" .
       "td    { font-face: verdana, arial, helvetica, times ; }\n" .
       "a     { color: #0000ff ;\n" .
       "        text-decoration: none }\n" .
       "img   { border: 0 ;\n" .
       "-->\n" .
       "</style>\n" .
       "<title>$title</title>\n" .
       "</head>\n" .
       "<body bgcolor=white>\n" .
       "<center>\n\n" .
       "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\">\n" .
       "<tr><td width=\"75%\" align=\"left\">\n" .
       "<a href=\"http://sourceforge.net/projects/faqforge/\" target=\"_blank\"><img src=\"/images/faqforge.png\" alt=\"FaqForge\" align=\"top\" border=\"0\"></a> v $version\n" .
       "<a name=\"top\">&nbsp;</a>\n" .
       "</td>\n" .
       "<td width=\"25%\" align=\"right\">\n");

if ( $context != "Topics List" )
{
  if ( !isset($context) || $context == "" ) {
    print ($context."<br/>");
  } else {
  print ("<a href=\"./?context=Topics+List\">Back to Topics List</a><br>\n");
  }
}

if ( $context != "View Document" )
{
  print ("<a href=\"./?context=View+Document\">View Your Document</a><br>\n");
}

print ("</td></tr>\n" .
       "</table>\n\n" .
       "<br>\n");
?>
