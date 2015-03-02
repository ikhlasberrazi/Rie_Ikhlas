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
    			 
            //VRAGEN LATEN ZIEN IN LIJST
                //query om de vragen op te halen
				$q_actieveVragen=
				"select *
				from rie_input
				where actief =1
				order by vraag";
				
				$r_actieveVragen=mysqli_query($link, $q_actieveVragen);
				if(mysqli_num_rows($r_actieveVragen)>"0")
				{
				    print("<ul id='sortable1' class='connectedSortable'>
                    
                    ");
                    
				    while($lijst=mysqli_fetch_array($r_actieveVragen))
						{
							print("
								
                                <li class='ui-state-default'>+ ".$lijst[vraag]."</li>
									");                  
						}
				
					
                   print("</ul>");
                   
                   //Onderdelen LATEN ZIEN IN LIJST
               $q_actieveOnderdelen=
				"select *
				from rie_onderdeel
				where actief =1
				order by naam";
				$r_actieveOnderdelen=mysqli_query($link, $q_actieveOnderdelen);
				if(mysqli_num_rows($r_actieveOnderdelen)>"0")
				{
				    print("<ul id='sortable1' class='connectedSortable'>
                    
                    ");
                    
				    while($lijst=mysqli_fetch_array($r_actieveOnderdelen))
						{
							print("
								
                                <li class='ui-state-default'>+ ".$lijst[naam]."</li>
									");                  
						}
				
					
                   print("</ul>");
                
    			}break;//einde case actievevragenlijst
    			
    		
    			}
            
                }//einde switch($actie)
		
	    }// einde if($_POST)
	
    }
}
else print("Sessie verlopen");
