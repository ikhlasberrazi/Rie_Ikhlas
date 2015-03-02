<?php
if($_REQUEST['sessie']!="") session_id($_REQUEST['sessie']);
session_start();

if(($_SESSION[login]=="wos_coprant") and ($_SESSION[rie]!=""))
{
	//databank openen
	include_once("../../config/dbi.php");
	include_once("../../config/config.php");	
	include_once("../config/config.php");	
	
    //SQL injection tegengaan in POST 
	if($_POST)
	{ 
		$actie=$_POST[actie];	
		$id=mysqli_real_escape_string($link,$_POST[id]);
		$vraag=mysqli_real_escape_string($link,$_POST[vraag]);
        $type_input=mysqli_real_escape_string($link, $_POST[evaluatie]);
		$naam=mysqli_real_escape_string($link,$_POST[naam]);
		$aard=mysqli_real_escape_string($link,$_POST[aard]);
	
	
    switch ($actie)
    {

			case 'analyseLijstOverzicht':
			
			{
				//hier gaan we de actieve vragen laten zien
				
				//query om de vragen op te halen
				$q_actieveVragen=
				"select *
				from rie_input
				where actief =1
				order by vraag";
				
				$r_actieveVragen=mysqli_query($link, $q_actieveVragen);
				if(mysqli_num_rows($r_actieveVragen)>"0")
				{
					print("
					<table id='datatable'>
						<thead>
							<tr>
								<td>Vraag</td>
								<td>Evaluatie</td>
								<td>Actie</td>
							</tr>
						</thead>
					<tbody>
							 ");
				   
				  while($lijst=mysqli_fetch_array($r_actieveVragen))
						{
							print("
								<tr>
									<td><b>+ ".$lijst[vraag]."</b></td>
									<td><b>+ ".$lijst[type_input]."</b></td>
									<td align='right'>
										<a href='javascript:void(0);' 
											onClick=\"vraagRie('wijzig','".$lijst[id]."');\">
											<img src='".$_SESSION[http_images]."edit.png'> Wijzig</a> 
										&nbsp;  &nbsp;  &nbsp; 
										<a href='javascript:void(0);' 
											onClick=\"rieDeactiveer('actieveLijst','Vraag','".$lijst[id]."','');\">
											<img src='".$_SESSION[http_images]."kruis.png'> Deactiveer</a>
									</td>
								</tr>
									");                  
						}
				print("</table>");
                
				}//einde if(mysqli_num_rows($r_actieveVragen)>"0")
                else print("Geen inhoud!");
			}break;//einde case actievevragenlijst
			
		
			
        
    }
		
	}
	
}
else print("Sessie verlopen");
	 