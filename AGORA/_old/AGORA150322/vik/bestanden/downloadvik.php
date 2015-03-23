<?php

session_start();

if(($_SESSION[login]=="wos_coprant") and ($_SESSION[arbeidsmiddelen]!=""))
{
	
	//databank openen
	include_once("../../config/dbi.php");
	include_once("../../config/config.php");
 	
 	
 	if($_GET[id]!="")
 	{
		$id=mysqli_real_escape_string($link,$_GET[id]);
		
		$q_item=
        "select * 
        from vik_upload 
        where id='".$id."'";
		//print($q_item."<br />");
        
		$r_item=mysqli_query($link,$q_item);
		if(mysqli_num_rows($r_item)=="1")
		{
			$item=mysqli_fetch_array($r_item);
			
			//header("Content-length: ".$item[grootte]);
			header("Content-length: ".strlen($item[content]));
			header("Content-type: ".$item[type]);
			header("Content-Disposition: attachment; filename=".$item[bestandsnaam]);
			echo $item[content];
		}
		else print("Geen bestand gevonden!!");
		
	}
 
}

?>