<?php

session_start();

if(($_SESSION[login]=="wos_coprant") and ($_SESSION[arbeidsmiddelen]!=""))
{
	
	//databank openen
	include_once("../config/dbi.php");
	include_once("../config/config.php");
 	
 	
 	if($_GET[id]!="")
 	{
		$id=mysqli_real_escape_string($link,$_GET[id]);
		
		$q_item="select * from agora_import where id='".$id."' and id_school='".$_SESSION[school_id]."'";
		//print($q_item."<br />");
		$r_item=mysqli_query($link,$q_item);
		if(mysqli_num_rows($r_item)=="1")
		{
			$item=mysqli_fetch_array($r_item);
			
			//echo $item[json_data];
			//$json=json_decode($item[json_header],true);
			$buffer=json_decode($item[json_data],true);
			echo $buffer;
			
			//echo json_last_error();
			$i="0";
					
			//alle geuploade headers vergelijken met de opgeslagen headers
			//foreach($splits as $item)
			/*while(sizeof($json[$i])>"0")
			{
				print($json[$i]."<br />");
				$i++;
			}*/
		}
		else print("Geen bestand gevonden!!");
		
	}
 
}

?>