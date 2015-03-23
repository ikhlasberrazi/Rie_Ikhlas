<?php

session_start();

if(($_SESSION[login]=="wos_coprant") and ($_SESSION[rie]!=""))
{
	$db_hulp="rie"; 
	$titel_hulp="RIE";
	print("<h1>Meldingen ".$titel_hulp." beheren&nbsp;  &nbsp;  &nbsp; </h1><br /><br />");
	
	
}
else print("Sessie verlopen");
?>