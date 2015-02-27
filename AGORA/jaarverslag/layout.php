<?php
include_once("config.php");

if($_SESSION[login]=="wos_coprant")
{	
print("<div class=cmsmenu>
<table width='100%' border=0><tr>
	<td valign=top rowspan='2'><img src=".$_SESSION[http]."images/wos.jpg height='70'></td><td valign=top><h1>".$naam_app." ".$versie_app."</h1><h3>".$omschrijving_app."</h3></td><td valign=top>");
}

print("&nbsp; &nbsp;  &nbsp;Welkom ".$_SESSION[naam]." &nbsp; &nbsp; &nbsp; &nbsp; ");
print($_SESSION[instellingsnaam]." &nbsp;  &nbsp;  &nbsp;  &nbsp; ");
print("<a href='#' onclick=\"window.close();\" style='background:#CC9; text-decoration:none;padding-left:5px;padding-right:5px;'> X ".$naam_app." sluiten </a>");
print("<br /><br /><a href='index.php'>Home</a>&nbsp; &nbsp;  &nbsp;<a href='index.php?pad=../agora&go=nieuws&agora=".$link_app."'>Nieuws</a> &nbsp; &nbsp;  &nbsp;<a href='index.php?pad=../agora&go=bugs&agora=".$link_app."'>Fouten / suggesties</a> &nbsp; &nbsp;  &nbsp;<a href='index.php'>FAQ</a> </td></tr>

<tr><td colspan=2 valign=bottom align=right>");
?>