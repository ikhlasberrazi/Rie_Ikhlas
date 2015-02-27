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
		//$NAAMVARIABELE=mysqli_real_escape_string($link,$_POST[ID OF NAAM VAN VARIABELE OM TE POSTEN NAAR DB]);
		$id=mysqli_real_escape_string($link,$_POST[id]);
		$vraag=mysqli_real_escape_string($link,$_POST[vraag]);
        $type_input=mysqli_real_escape_string($link, $_POST[evaluatie]);
		$naam=mysqli_real_escape_string($link,$_POST[naam]);
		$aard=mysqli_real_escape_string($link,$_POST[aard]);
	
	
    switch ($actie)
    {
        
        //ALLES VOOR VRAGEN TAB 

    
			case 'actieveVragenlijst':
			
			{
				print("test");
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
                <table id='dataTable'>
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
                                        onClick=\"rieDeactiveer('actieveVLijst','".$lijst[id]."','');\">
                                        <img src='".$_SESSION[http_images]."kruis.png'> Deactiveer</a>
                                </td>
                            </tr>
                                ");                  
                    }
					print("</table>");
				}//einde if(mysqli_num_rows($r_actieveVragen)>"0")
			}break;//einde case actievevragenlijst
        
        
        
			//inactieve lijst weergevn
			case 'inactieveVragenlijst':
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
             
				 //query om de vragen op te halen
				$q_inactieveVragen=
				"select *
				from rie_input
				where actief =0
				order by vraag";
				
				$r_inactieveVragen=mysqli_query($link,$q_inactieveVragen);
				if(mysqli_num_rows($r_inactieveVragen)>'0')
				{
					while($lijst=mysqli_fetch_array($r_inactieveVragen))
					{
						print("
								<tr>
									<td>
										<b>+ ".$lijst[vraag]."</b>
									</td>
									<td>
										<b>+ ".$lijst[type_input]."</b>
									</td>
									<td align='right'>
										<a href='javascript:void(0);' onClick=\"rieActiveer('activeerVraag','".$lijst[id]."');\">
										<img src='".$_SESSION[http_images]."vink.png'> Activeer</a>
									</td>
								</tr>
							");
					}
				}
            
			}break;//einde inactieve vragenlijst
        
        
            
        
            //bij volgende code wordt de form van in de dialog box geladen. 
            case 'vragenForm':
			{
			 //zoeken naar info in geval van wijzigen
			 //print("Ik ben hier:".$id."<br />");
				if($id!="")
				{
					$q_vraag=
                    "select * 
                    from rie_input 
                    where id='".$id."' limit 1";
					//print($q_vraag."<br />");
					$r_vraag=mysqli_query($link,$q_vraag);
					if(mysqli_num_rows($r_vraag)=="1")
					{
						$vraag=mysqli_fetch_array($r_vraag);
					}
					else $vraag=array();
				}
				else $vraag=array();
				
				print("
					<form id='VragenFormID'>
					<input type='hidden' name='actie' value='vraag_opslaan'>
					<input type='hidden' name='id' value='".$id."'>
                    <br/>
					Vraag: <input type='text' name='vraag' value='".$vraag[vraag]."' size='75'><br/>
                    <br/>
                    Welke evaluatiemethode wil je bij deze vraag?
                    <select name='evaluatie'>
                      <option value=''>Selecteer...</option>
                      <option value='RG'>Risicograaf</option>
                      <option value='Kinney'>Kinney methode</option>
                      <option value='Guy'>Guy Lenaerts</option>
                      <option value='kleur'>Kleurencode</option>
                    </select>
                    <br/>
					</form>
				");
				
				

			}break;	//einde vragenForm
			
			
            //button om vragen weg te schrijven naar database tabel rie_input
			case 'vraag_opslaan':
			{
				if($id=="")
				{
					//insert
					$q_insert=
                    "insert into rie_input (vraag, type_input, actief) 
                    values('".$vraag."','".$type_input."','";
					if($_SESSION[aard]=="super") 
                        $q_insert.="1";
					else $q_insert.="2";
					
                    $q_insert.="')";
					
                    $r_insert=mysqli_query($link,$q_insert);
					if($r_insert) 
					{
						if($_SESSION[aard]=="super") 
                            print("<br /><br /><br /><h2><font color=green><center>Vraag met succes opgeslagen!</center></font></h2>");
						else print("<br /><br /><br /><h2><font color=green><center>Voorstel nieuwe vraag met succes opgeslagen!</center></font></h2>");
					}
                    //else print(mysql_error());
					else print("<br /><br /><br /><h2><font color=red><center>Vraag opslaan MISLUKT!</center></font></h2>");
				}
                else //dan gaan we de database updaten met de nieuwe data
				{
					 //print("Ik ben hier om te wijzigen:".$id."<br />");
					//update
					if($_SESSION[aard]=="super")
					{
                        $q_update="
							update rie_input 
							set vraag='".$vraag."', type_input='".$type_input."'  
							where id='".$id."'
							";
					}
					$r_update=mysqli_query($link,$q_update);
					if($r_update) 
					{
						if($_SESSION[aard]=="super") 
                            print("<br /><br /><br /><h2><font color=green><center>Wijziging met succes opgeslagen!</center></font></h2>");
						else print("<br /><br /><br /><h2><font color=green><center>Voorstel tot wijziging met succes opgeslagen!</center></font></h2>");
					}
					else print("<br /><br /><br /><h2><font color=red><center>Wijziging opslaan MISLUKT!</center></font></h2>");
				}
             
                
			}break;	//einde vraag opslaan
            
			 
            case 'deactiveerVraag':
            {
                
                
                $q_deactiveer="update rie_input set actief='0' where id='".$id."'";
               	$r_deactiveer=mysqli_query($link,$q_deactiveer);
                
                if($r_deactiveer) 
				{
					print("<br /><br /><br /><center><h2><font color=green>".ucfirst($aard)." met succes gedeactiveerd!</font></center></h2>");
				}
				else
				{
					print("<br /><br /><br /><center><h2><font color=red>".ucfirst($aard)." niet gedeactiveerd!</font></center></h2>");
				}
                
            }break;	//einde deactiveren
            
            case 'activeerVraag': //komende van rie.js RieActiveer()
			{
				$q_activeer="update rie_input set actief='1' where id='".$id."'";
				$r_activeer=mysqli_query($link,$q_activeer);
				if($r_activeer) 
				{
					print("<br /><br /><br /><h2><center><font color=green>Vraag met succes geactiveerd!</font></center></h2>");
				}
				else
				{
					print("<br /><br /><br /><h2><center><font color=red>Vraag niet geactiveerd!</font></center></h2>");
				}
			}break;
        
			
		//ALLES VOOR ONDERDELEN TAB 
			 case 'actieveOnderdelenLijst':
        
			{
				//hier gaan we de actieve onderdelen laten zien
				
				$q_actieveOnderdelen=
				"select *
				from rie_onderdeel
				where actief =1
				order by naam";
				
				$r_actieveOnderdelen=mysqli_query($link, $q_actieveOnderdelen);
				if(mysqli_num_rows($r_actieveOnderdelen)>"0")
				{
					print("
					<table id='dataTable'>
						<thead>
							<tr>
								<td>Onderdeel</td>
								<td>Actie</td>
							</tr>
						</thead>
					<tbody>
									");
				   
				  while($lijst=mysqli_fetch_array($r_actieveOnderdelen))
						{
							print("
								<tr>
									<td><b>+ ".$lijst[naam]."</b></td>
									<td align='right'>
										<a href='javascript:void(0);' 
											onClick=\"onderdeelRie('wijzig','".$lijst[id]."');\">
											<img src='".$_SESSION[http_images]."edit.png'> Wijzig</a> 
										&nbsp;  &nbsp;  &nbsp; 
										<a href='javascript:void(0);' 
											onClick=\"rieDeactiveerOnderdeel('actieveOnderdelenLijst','".$lijst[id]."','');\">
											<img src='".$_SESSION[http_images]."kruis.png'> Deactiveer</a>
									</td>
								</tr>
									");                  
						}
				print("</table>");
            }//einde if
        }break;//einde case actievevragenlijst
        
        
			//inactieve lijst weergevn
			case 'inactieveOnderdelenlijst':
			{
             print("
                <table id='dataTable'>
                    <thead>
                        <tr>
                            <td>Naam</td>
                            
                            <td>Actie</td>
                        </tr>
                    </thead>
                <tbody>
                                ");
             
             //query om de vragen op te halen
            $q_inactieveOnderdelen=
            "select *
            from rie_onderdeel
            where actief =0
            order by naam";
            
            $r_inactieveOnderdelen=mysqli_query($link,$q_inactieveOnderdelen);
            if(mysqli_num_rows($r_inactieveOnderdelen)>'0')
            {
                while($lijst=mysqli_fetch_array($r_inactieveOnderdelen))
                {
                    print("
                            <tr>
                                <td>
                                    <b>+ ".$lijst[naam]."</b>
                                </td>
                                
                                <td align='right'>
                                    <a href='javascript:void(0);' onClick=\"rieActiveer('activeerOnderdeel','".$lijst[id]."');\">
                                    <img src='".$_SESSION[http_images]."vink.png'> Activeer</a>
                                </td>
                            </tr>
                        ");
                }
            }
            
        }break;//einde inactieve vragenlijst
        
			
			//bij volgende code wordt de form van in de dialog box geladen. 
            case 'onderdelenForm':
			{
			 //zoeken naar info in geval van wijzigen
				if($id!="")
				{
					$q_onderdeel=
                    "select * 
                    from rie_onderdeel 
                    where id='".$id."' limit 1";
					$r_onderdeel=mysqli_query($link,$q_onderdeel);
					if(mysqli_num_rows($r_onderdeel)=="1")
					{
						$onderdeel=mysqli_fetch_array($r_onderdeel);
					}
					else $onderdeel=array();
				}
				else $onderdeel=array();
				
				print("
					<form id='VragenFormID'>
					<input type='hidden' name='actie' value='onderdeel_opslaan'>
					<input type='hidden' name='id' value='".$id."'>
                    <br/>
					Onderdeel: <input type='text' name='naam' size='75' value='".$onderdeel[naam]."'><br/>
                    <br/>
                    
                    <br/>
					</form>
					
				");//bijzetten section voor keuze uit vragen + query om rie_input up te daten met onderdeel
			}break;	//einde onderdelenForm
			
			//button om vragen weg te schrijven naar database tabel rie_input
			case 'onderdeel_opslaan':
			{
				if($id=="")
				{
					//insert
					$q_insert=
                    "insert into rie_onderdeel (naam, actief) 
                    values('".$naam."','";
					if($_SESSION[aard]=="super") 
                        $q_insert.="1";
					else $q_insert.="2";
					
                    $q_insert.="')";
					
                    $r_insert=mysqli_query($link,$q_insert);
					if($r_insert) 
					{
						if($_SESSION[aard]=="super") 
                            print("<br /><br /><br /><h2><font color=green><center>Onderdeel met succes opgeslagen!</center></font></h2>");
						else print("<br /><br /><br /><h2><font color=green><center>Voorstel nieuw onderdeel met succes opgeslagen!</center></font></h2>");
					}
					else print("<br /><br /><br /><h2><font color=red><center>Onderdeel opslaan MISLUKT!</center></font></h2>");
				}
                //TODO nog na te zien
                else
				{
					//update
					if($_SESSION[aard]=="super")
                        $q_update="update rie_onderdeel set naam='".$naam."' where id='".$id."'";
				
					$r_update=mysqli_query($link,$q_update);
					if($r_update) 
					{
						if($_SESSION[aard]=="super") 
                            print("<br /><br /><br /><h2><font color=green><center>Wijziging met succes opgeslagen!</center></font></h2>");
						else print("<br /><br /><br /><h2><font color=green><center>Voorstel tot wijziging met succes opgeslagen!</center></font></h2>");
					}
					else print("<br /><br /><br /><h2><font color=red><center>Wijziging opslaan MISLUKT!</center></font></h2>");
				}
                
                
			}break;	//einde onderdeel opslaan
           
            case 'deactiveerOnderdeel':
            {
                
                
                $q_deactiveer="update rie_onderdeel set actief='0' where id='".$id."'";
               	$r_deactiveer=mysqli_query($link,$q_deactiveer);
                
                if($r_deactiveer) 
				{
					print("<br /><br /><br /><center><h2><font color=green>".ucfirst($aard)." met succes gedeactiveerd!</font></center></h2>");
				}
				else
				{
					print("<br /><br /><br /><center><h2><font color=red>".ucfirst($aard)." niet gedeactiveerd!</font></center></h2>");
				}
                
            }break;	//einde deactiveren
            
            case 'activeerOnderdeel': //komende van rie.js RieActiveer()
			{
				$q_activeer="update rie_onderdeel set actief='1' where id='".$id."'";
				$r_activeer=mysqli_query($link,$q_activeer);
				if($r_activeer) 
				{
					print("<br /><br /><br /><h2><center><font color=green>Onderdeel met succes geactiveerd!</font></center></h2>");
				}
				else
				{
					print("<br /><br /><br /><h2><center><font color=red>Onderdeel niet geactiveerd!</font></center></h2>");
				}
			}break;
        
        
    }
		
	}
	
}
else print("Sessie verlopen");
	 