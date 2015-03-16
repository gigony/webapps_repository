<?php
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
** $Id: adminOnly.php 16 2006-06-27 23:20:45Z sgrayban $
*/
session_start();
if(   (!isset($_SESSION['adminUser'])) || (!isset($_SESSION['adminPassword'])) ) {
	include_once("adminLogin.php");
	exit;
}
require_once("admin-config.php");
/* adminOnly.php
   if the session variables are not set or are incorrect values 
   then present the login screen
*/
if( ($_SESSION['adminUser'] != ADMINUSER) || ($_SESSION['adminPassword'] != ADMINPASSWORD) ) {
	//header("Location: adminLogin.php");
	include_once("adminLogin.php");
	exit;
}else{?>
<table>
<tr>
	<td width=32><a href="adminLogOut.php"><img src="appimage/icons/icon_logout.gif" width="32" height="32" border=0 alt="Logout"></a></td>
	<td width=32><a href="<?php echo ADMINHOME;?>"><img src="appimage/icons/icon_admin.gif" width="32" height="32" border=0 alt="Admin"></a></td>
	<td width="100%" align="center"><div style="background-color:gold;font-size:xx-small;font-style:italic;">FaqForge Administration</div></td>
	<td width=32><a href="<?php echo ADMINHOME;?>"><img src="appimage/icons/icon_admin.gif" width="32" height="32" border=0 alt="Admin"></a></td>
	<td width=32><a href="adminLogOut.php"><img src="appimage/icons/icon_logout.gif" width="32" height="32" border=0 alt="Logout"></a></td>
</tr>
<tr>
	<td style="font-size:x-small;"><a href="adminLogOut.php">Logout</a></td>
	<td style="font-size:x-small;"><a href="<?php echo ADMINHOME;?>">Admin</a></td>
	<td>&nbsp;</td>
	<td style="font-size:x-small;"><a href="<?php echo ADMINHOME;?>">Admin</a></td>
	<td style="font-size:x-small;"><a href="adminLogOut.php">Logout</a></td>
</tr>
</table>
<?php }?>
