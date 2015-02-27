<?php

if($_SESSION['login']=="wos_coprant")
{
	 
	$q_select="select * from agora_webpagina where id='".$_GET[id]."' limit 1";
	//print($q_select."<br />");
	$r_select=mysqli_query($link,$q_select);
	$select=mysqli_fetch_array($r_select);
	$inhoud=stripslashes($select[inhoud]);
	$inhoud=str_replace("jscript","../jscript",$inhoud);
	$inhoud=str_replace("\"","'",$inhoud);
	$inhoud=str_replace("%22","",$inhoud);
	$inhoud=str_replace("\&quot;","",$inhoud);
	$inhoud=str_replace("/'","'",$inhoud);
	//$inhoud=str_replace("a href='","a href='".$_SESSION['http'],$inhoud);
	$inhoud=str_replace("upload",$_SESSION['http']."upload",$inhoud);

	//print($_GET[id]."<br /><br />");
	print("<br /><h2>".$select[naam]."</h2>".$inhoud);
}
else 
{
	include("../index.php");
}
?>