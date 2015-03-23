<?php
if(($_SESSION[aard]!="school") and ($_SESSION['login']=="wos_coprant"))
{
	if($_SESSION[aard]=="super") 
	{
		$_SESSION[scholengemeenschap]="0";
		$_SESSION[school_id]="0";
		$_SESSION[school_naam]="";
		print("test");
	}
	elseif($_SESSION[aard]=="cpa")
	{
		$_SESSION[school_id]="0";
		$_SESSION[school_naam]="";
	} 
	
	print("<br /><br /><br /><br /><center>Afmelden voltooid!!<br /><br /><a href=index.php>Klik hier om verder te gaan!</a></center>");
}
else include_once("../index.php");	
?>
