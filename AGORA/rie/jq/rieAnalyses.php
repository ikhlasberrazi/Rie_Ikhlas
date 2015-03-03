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
        $lijstAudit = $_POST[Inhoud];
	
        switch ($actie)
        {
            
                case 'nieuweAudit':
                    
                {
                    //form printen waarbij naam en omschrijving worden meegegeven aan rie_audit
                    print("
                    <div id='dialog' title='Audit samenstellen'>
                    <form id='auditForm'>
                    <input type='hidden' name='actie' value='analyseLijstOpslaan'>
                    <input type='hidden' name='id' value='".$id."'>
                    <br />
                        <a href='javascript:void(0);' 
                            onClick=\"vraagRie('Vraag','');\">
                            <img src='".$_SESSION[http_images]."nieuw.png'> Nieuwe Vraag
                        </a>
                		<a href='javascript:void(0);' 
                            onClick=\"onderdeelRie('Onderdeel','');\">
                            <img src='".$_SESSION[http_images]."nieuw.png'> Nieuw Onderdeel
                        </a>
                    <br />
                    <br />
                    Naam van audit: <input type='text' name='naam' size='100'><br />
                    Omschrijving: <input type='text' name='omschrijving' size ='100'><br /> <br />
                    ");
                    
                        //Onderdelen LATEN ZIEN IN LIJST
                           $q_actieveOnderdelen=
            				"select *
            				from rie_onderdeel
            				where actief =1
            				order by naam";
            				$r_actieveOnderdelen=mysqli_query($link, $q_actieveOnderdelen);
            				if(mysqli_num_rows($r_actieveOnderdelen)>"0")
            				{
            				    print("<ul id='sortable2' class='connectedSortable'>
                                
                                ");
            				    while($lijst=mysqli_fetch_array($r_actieveOnderdelen))
            						{
            							print("
            								
                                            <li class='ui-state-default'>+ ".$lijst[naam]."</li>
            									");                  
            						}
                               print("</ul>");
            			     }
                             
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
            								
                                            <li  class='ui-state-default'>+ ".$lijst[vraag]."</li>
            									");                  
            						}
                               print("</ul>");
                            }//einde if r_activevragenlijst
                   
    			    print("<ul id='sortable3' class='audit'><li class='ui-state-default ui-state-disabled'>Nieuwe lijst</li></ul>");
                    print("</div>"); //einde dialog div
                    
                    
                    
                }break;//einde nieuwe audit
                
                
                case 'analyseLijstOpslaan':
                {
                    
                    $output = array();
                    $lijst = parse_str($lijstAudit, $output);
                    print_r($output);
                }break;//einde case opslaan van analyselijst
                
                
    			case 'analyseLijstOverzicht':
    			
    			{
                    print("<button onClick=\"analyseLijst();\">Ververs</button>");
                    
                   	      
	               
            
                }break;//einde case actievevragenlijst
		
	    }// einde if($_POST)
	
    }
}
else print("Sessie verlopen");
