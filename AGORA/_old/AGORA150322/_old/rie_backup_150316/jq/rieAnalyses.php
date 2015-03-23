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
		$naam=mysqli_real_escape_string($link,$_POST[naam]);//naam van audit
		$onderdeelInput=mysqli_real_escape_string($link, $_POST[onderdeelInput]);
		$omschrijving=mysqli_real_escape_string($link,$_POST[omschrijving]);
		$inhoud=mysqli_real_escape_string($link,$_POST[inhoud]);
		$aard=mysqli_real_escape_string($link,$_POST[aard]);
		$categorie=mysqli_real_escape_string($link,$_POST[categorie]);
		
	}//einde post
       
		
		
        switch ($actie)
        {
            
                 case 'nieuweAudit':
                    
                {
                 	
					
					
					/* //query naar vragen om deze terug op te halen in het inputveld	
					$q_vraag=
                    "select * 
                    from rie_input 
                    where id='".$id_laatste_vraag."' 
					limit 1";
					
					print("laatste id is: ");
					print($id_laatste_vraag);
					
					
					$r_vraag=mysqli_query($link,$q_vraag);
					if(mysqli_num_rows($r_vraag)=="1")
					{
						$vraag=mysqli_fetch_array($r_vraag);
					}
					else $vraag=array();
					
					//query naar onderdelen om deze terug op te halen in het inputveld
					$q_onderdeel=
                    "select * 
                    from rie_onderdeel 
                    where id='".$id_laatste_onderdeel."' 
					limit 1";
					
					$r_onderdeel=mysqli_query($link,$q_onderdeel);
					if(mysqli_num_rows($r_onderdeel)=="1")
					{
						$onderdeel=mysqli_fetch_array($r_onderdeel);
					}
					else $onderdeel=array(); */
						
					
					print("<br />ik ben hier<br />");	
					print($id);	
					//nazien of de audit al niet bestaat en als het al bestaat de audit te wijzigen
					if ($id!="")
					{
						$q_audit=
						"select *
						from rie_audit
						where id='".$id."'";
						$r_audit = mysqli_query($link,$q_audit);
						
						if(mysqli_num_rows($r_audit)>"0")
						{
							$audit=mysqli_fetch_array($r_audit);
							
						}
						else $audit=array(); 
					}
					else $audit=array();
					
						
					print_r($audit);
				
                    print("
                    
                    <form id='auditFormID'>
                    <input type='hidden' name='actie' value='analyseLijstOpslaan'>
                    <input type='hidden' name='id' value='".$id."'>
                    <input type='hidden' name='Categorie' value='".$categorie."'
				    <br />
                    Naam van audit: <input type='text' name='naam' value='".$audit[naam]."' size='100'><br /><br />
                    Omschrijving: <input type='text' name='omschrijving' value='".$audit[omschrijving]."' size ='100'><br /> <br />
					Categorie: <input type='text' name='categorie' value='".$audit[categorie]."' size ='75'><br /> <br />
					
					</form>
					");
					
					$onderdeelDIV="<div>Onderdeel: <input readonly> <br /></div>";
					//	$onderdeelDIV="<div>Onderdeel: '".$onderdeel."'<br /></div>";
					//	$onderdeelDIV="<div>Onderdeel: <input readonly> <br /></div>";
					$onderdeelVastDIV="<div id='borderDIV' >
											Onderdeel: <input type='text'  size='50' value='Voorbeeld onderdeel' readonly >&nbsp; &nbsp;
											<a href='javascript:void(0);' 
											onClick=\"nieuwDeel('onderdelenForm','','Onderdeel','#onderdelenFormID', '".$onderdeelDIV."','".$onderdeelInput."');\">
											<img src='".$_SESSION[http_images]."nieuw.png'> Nieuw Onderdeel
											</a>
											<a href='javascript:void(0);' 
							onClick=\"analyseLijst('wijzig','".$lijst[id]."');\">
							<img src='".$_SESSION[http_images]."edit.png'> Wijzig</a> 
											<br />
										</div>";
					print($onderdeelVastDIV);
					
					$vraagDIV="<div>Vraag: <input readonly><br />";
					
					$vraagVastDIV="<div id='borderDIV' >
							Vraag: <input type='text' name='vraag' size='100' value='Voorbeeld vraag' readonly > &nbsp; &nbsp; 
						<a href='javascript:void(0);' 
                            onClick=\"nieuwDeel('vragenForm','','Vraag','#VragenFormID', '".$vraagDIV."');\">
                            <img src='".$_SESSION[http_images]."nieuw.png'> Nieuwe Vraag
                        </a>
						<a href='javascript:void(0);' 
							onClick=\"analyseLijst('wijzig','".$lijst[id]."');\">
							<img src='".$_SESSION[http_images]."edit.png'> Wijzig</a> 
						<br />
						<br />							
							<form action=''>
								<input type='checkbox' name='Open[]' value='ja'>Ja
								<input type='checkbox' name='Open[]' value='nee'>Nee
								<input type='checkbox' name='Open[]' value='nvt'>NVT
							</form><br /><br />
							Antwoord: <br />
							<textarea id ='antwoordOpen' rows='5' cols='80' id='TITLE'>
							</textarea>
							
					</div>";
					print($vraagVastDIV);
					
					print("<div><h2>Nieuw samengestelde audit</h2></div>");
					print("<!-- test om div toe te voegen -->
							<br />
							<div id='spin'></div>");
					
					

                    
                    
                    
                }break;//einde nieuwe audit
                 
                
                case 'analyseLijstOpslaan':
                {
                    //checken of het een nieuwe audit is of niet
					
					if($id=="")
					{
						$q_naarDB =
						"insert into rie_audit (naam, omschrijving, inhoud, categorie, actief)
						values('".$naam."','".$omschrijving."','test inhoud','".$categorie."','";
						if($_SESSION[aard]=="super") 
							$q_naarDB.="1";
						else $q_naarDB.="2";
						
						$q_naarDB.="')";
							
						$r_naarDB = mysqli_query($link,$q_naarDB);
						if($r_naarDB)
						{
							if($_SESSION[aard]=="super")print("<br /><br /><br /><h2><font color=green><center>Onderdeel met succes opgeslagen!</center></font></h2>");
							else print("<br /><br /><br /><h2><font color=green><center>Voorstel tot wijziging met succes opgeslagen!</center></font></h2>");
						}
						else print("<br /><br /><br /><h2><font color=red><center>Onderdeel opslaan MISLUKT!</center></font></h2>");
					}
					else 
					{
						//update
						if($_SESSION[aard]=="super")
							$q_update="update rie_audit set naam='".$naam."', omschrijving='".$omschrijving."' where id='".$id."'";
					
						$r_update=mysqli_query($link,$q_update);
						if($r_update) 
						{
							if($_SESSION[aard]=="super") 
								print("<br /><br /><br /><h2><font color=green><center>Wijziging met succes opgeslagen!</center></font></h2>");
							else print("<br /><br /><br /><h2><font color=green><center>Voorstel tot wijziging met succes opgeslagen!</center></font></h2>");
						}
						else print("<br /><br /><br /><h2><font color=red><center>Wijziging opslaan MISLUKT!</center></font></h2>");
					}	
				
					
                    
                }break;//einde case opslaan van analyselijst
                
                
                
                
                
                
                
                
    			case 'actieveAuditLijst':
    			
    			{
                    
                    
					//query naar inhoud rie_audit
					$q_actieveAudit=
					"select *
					from rie_audit
					where actief =1
					order by naam";
					$r_actieveAudit=mysqli_query($link, $q_actieveAudit);
					
					?>
					
					<script>
					//script om tabel te filteren
					
					//dataTable filter laden
							$('#dataTable').dataTable( {
								"bPaginate": false,
								"bLengthChange": false,
								"bFilter": true,
								"bSort": true,
								"bInfo": false,
								"bAutoWidth": false,
								"oLanguage":
								{
								
									"sProcessing":   "Bezig met verwerken...",
									"sLengthMenu":   "Toon _MENU_ rijen",
									"sZeroRecords":  "Geen resultaten gevonden",
									"sInfo":         "_START_ tot _END_ van _TOTAL_ rijen",
									"sInfoEmpty":    "Er zijn geen records om te tonen",
									"sInfoFiltered": "(gefilterd uit _MAX_ rijen)",
									"sInfoPostFix":  "",
									"sSearch":       "Filter:",
									"sUrl":          "",
									"oPaginate": {
										"sFirst":    "Eerste",
										"sPrevious": "Vorige",
										"sNext":     "Volgende",
										"sLast":     "Laatste"
										}
								},
								"aaSorting": [[ 1, "asc" ]],//hier wordt geezegd hoe het gesorteerd moet worden
								"aoColumnDefs": [ 
											
											{ "bSearchable": false, "bSortable": false, "aTargets": [ 2 ] }
											//om tabel actie niet mee te laten sorteren
										]
					 
							} );
			
			
		
					</script>
					
					<?php
					if(mysqli_num_rows($r_actieveAudit)>"0")
					{
						print("
						<table id='dataTable'>
							<thead>
								<tr>
									<td>Audit ID</td>
									<td>Naam</td>
									<td>Omschrijving</td>
									<td>Inhoud</td>
									<td>Actie</td>
								</tr>
							</thead>
						<tbody>
								 ");
					while($lijst=mysqli_fetch_array($r_actieveAudit))
						{
							
							print("
								<tr>
									<td><b>+ ".$lijst[id]."</b></td>
									<td><b>+ ".$lijst[naam]."</b></td>
									<td><b>+ ".$lijst[omschrijving]."</b></td>
									<td><b>+ ".$lijst[inhoud]."</b></td>
									<td align='right'>
										<a href='javascript:void(0);' 
											onClick=\"analyseLijst('Wijzig','".$lijst[id]."');\">
											<img src='".$_SESSION[http_images]."edit.png'> Wijzig</a> 
										&nbsp;  &nbsp;  &nbsp; 
										<a href='javascript:void(0);' 
											onClick=\"rieDeactiveer('actieveAudit','Audit','".$lijst[id]."','');\">
											<img src='".$_SESSION[http_images]."kruis.png'> Deactiveer</a>
									</td>
								</tr>
									"); 
														
						}
						print("</table>");
					}//einde if
					else print("Geen inhoud!");
					
                   	      
	               
            
                }break;//einde case
				
				//einde case actieveAuditLijst
				
				case 'deactiveerAudit':
				{
					$q_deactiveer="update rie_audit set actief='0' where id='".$id."'";
					$r_deactiveer=mysqli_query($link,$q_deactiveer);
                
					if($r_deactiveer) 
					{
						print("<br /><br /><br /><center><h2><font color=green>".ucfirst($aard)." met succes gedeactiveerd!</font></center></h2>");
					}
					else
					{
						print("<br /><br /><br /><center><h2><font color=red>".ucfirst($aard)." niet gedeactiveerd!</font></center></h2>");
					}
				}break;
				
				
				
				
				
				
				
				
				
				
				//bij volgende code wordt de form van in de dialog box geladen. 
				case 'vragenForm':
				{
				 
				 //zoeken naar info in geval van wijzigen
				 //print("Ik ben hier:".$id."<br />");
					if($id!="")
					{
						//query om vraag op te halen bij wijzigen
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
					
				
					
					
					//in de volgende print staan twee input velden. de eerste is om naar de volgende case te gaan "vraag_opslaan" en de tweede is om de ID door te geven aan deze case
					print("
						<form id='VragenFormID'>
						<input type='hidden' name='actie' value='vraag_opslaan'>
						<input type='hidden' name='id' value='".$id."'>
						 
						<br/>
						Vraag: <input  type='text' name='vraag' value='".$vraag[vraag]."' size='75'><br/>
						<br/>
						Welke soort vraag wil je?
						<select name='vraagSoort'>
						  <option value'Geen'>Selecteer...</option>
						  <option value='Open' "); if ($vraag[soort_vraag]=="Open") print(" SELECTED "); print(">Open Vraag</option>
						  <option value='JaNee' "); if ($vraag[soort_vraag]=="JaNee") print(" SELECTED "); print(">Ja Nee Vraag</option>
						</select>
						<br/>
						Welke evaluatiemethode wil je bij deze vraag?
						<select name='evaluatie'>
						  <option value'Geen'>Selecteer...</option>
						  <option value='RG' "); if ($vraag[type_input]=="RG") print(" SELECTED "); print(">Risicograaf</option>
						  <option value='Kinney' "); if ($vraag[type_input]=="Kinney") print(" SELECTED "); print(">Kinney methode</option>
						  <option value='kleur' "); if ($vraag[type_input]=="kleur") print(" SELECTED "); print(">Kleurencode</option>
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
						"insert into rie_input (vraag, soort_vraag, type_input, actief) 
						values('".$vraag."','".$soort_vraag."','".$type_input."','";
						if($_SESSION[aard]=="super") 
							$q_insert.="1";
						else $q_insert.="2";
						
						$q_insert.="')";
						
						
						$r_insert=mysqli_query($link,$q_insert);
						
						//laatste toegevoegde rij de id terughalen en wegschrijven
						$id_laatste_vraag=mysqli_insert_id($link);
						
						if($r_insert) 
						{
							if($_SESSION[aard]=="super") 
								print($id_laatste_vraag);
								//print("<br /><br /><br /><h2><font color=green><center>Vraag met succes opgeslagen!</center></font></h2>");
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
								set vraag='".$vraag."', soort_vraag='".$soort_vraag."', type_input='".$type_input."'  
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
						<form id='onderdelenFormID'>
						<input type='hidden' name='actie' value='onderdeelOpslaan'>
						<input type='hidden' name='id' value='".$id."'>
						<br/>
						Onderdeel: <input type='text'  value='".$onderdeel[naam]."' size='75'><br/>
						<br />
						<br />
						</form>
					");
				}break;	//einde onderdelenForm
				
				//button om vragen weg te schrijven naar database tabel rie_
				
				case 'onderdeelOpslaan':
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
						//print($q_insert."<br />");
						$r_insert=mysqli_query($link,$q_insert);
						
						
						//laatste onderdeel ophalen
						//$id_laatste_onderdeel=mysqli_insert_id($link);
						if($r_insert) 
						{
							if($_SESSION[aard]=="super") 
								//print($id_laatste_onderdeel);
								print($onderdeelInput); //wordt doorgegeven 
								//print("<br /><br /><br /><h2><font color=green><center>Onderdeel met succes opgeslagen!</center></font></h2>");
							else print("<br /><br /><br /><h2><font color=green><center>Voorstel nieuw onderdeel met succes opgeslagen!</center></font></h2>");
						}
						else print ("mislukt");
						//else print("<br /><br /><br /><h2><font color=red><center>Onderdeel opslaan MISLUKT!</center></font></h2>");
					}
					
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
				 
		
	
    }
}
else print("Sessie verlopen");
