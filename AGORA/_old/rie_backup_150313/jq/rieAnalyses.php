<?php
if($_REQUEST['sessie']!="") session_id($_REQUEST['sessie']);
session_start();

if(($_SESSION[login]=="wos_coprant") and ($_SESSION[rie]!=""))
{
	//databank openen
	include_once("../../config/dbi.php");
	include_once("../../config/config.php");	
	include_once("../config/config.php");	
	
	
	$id_laatste_vraag=$_SESSION['id_laatste_vraag'];
	$id_laatste_onderdeel=$_SESSION['id_laatste_onderdeel'];
	
	
	
    //SQL injection tegengaan in POST 
	if($_POST)
	{ 
		$actie=$_POST[actie];	
		$id=mysqli_real_escape_string($link,$_POST[id]);
		$vraag=mysqli_real_escape_string($link,$_POST[vraag]);
        $type_input=mysqli_real_escape_string($link, $_POST[evaluatie]);
		$naam=mysqli_real_escape_string($link,$_POST[naam]);//naam van audit
		$omschrijving=mysqli_real_escape_string($link,$_POST[omschrijving]);
		$inhoud=mysqli_real_escape_string($link,$_POST[inhoud]);
		$aard=mysqli_real_escape_string($link,$_POST[aard]);
		
		
       
		
		
        switch ($actie)
        {
            
                case 'nieuweAudit':
                    
                {
					//$id_laatste = $_SESSION['id_laatste'];
	

						
					$q_vraag=
                    "select * 
                    from rie_input 
                    where id='".$id_laatste_vraag."' limit 1";
					
					print($id_laatste_vraag."<br />");
					$r_vraag=mysqli_query($link,$q_vraag);
					if(mysqli_num_rows($r_vraag)=="1")
					{
						$vraag=mysqli_fetch_array($r_vraag);
					}
					else $vraag=array();
					
					
					$q_onderdeel=
                    "select * 
                    from rie_onderdeel 
                    where id='".$id_laatste_onderdeel."' limit 1";
					
					$r_onderdeel=mysqli_query($link,$q_onderdeel);
					if(mysqli_num_rows($r_onderdeel)=="1")
					{
						$onderdeel=mysqli_fetch_array($r_onderdeel);
					}
					else $onderdeel=array();
						
						
						
				
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
						
				
                    print("
                    <div id='dialog' title='Audit samenstellen'>
                    <form id='auditFormID'>
                    <input type='hidden' name='actie' value='analyseLijstOpslaan'>
                    <input type='hidden' name='id' value='".$id."'>
				    <br />
                    Naam van audit: <input type='text' name='naam' value='".$audit[naam]."' size='100'><br /><br />
                    Omschrijving: <input type='text' name='omschrijving' value='".$audit[omschrijving]."' size ='100'><br /> <br />
					Categorie: <input type='text' name='categorie' value='' size ='75'><br /> <br />
					
				
					<div id='onderdeelDIV' >
							Onderdeel: <input type='text' name='onderdeel' size='50' value='".$onderdeel[naam]."' readonly >&nbsp; &nbsp;
							<a href='javascript:void(0);' 
                            onClick=\"nieuwDeel('onderdelenForm','','Onderdeel','#onderdelenFormID');\">
                            <img src='".$_SESSION[http_images]."nieuw.png'> Nieuw Onderdeel
							</a>
							
                           <br />
							
						</div>
						
					<div id='vraagDIV'>
							Vraag: <input type='text' name='vraag' size='100' value='".$vraag[vraag]."' readonly > &nbsp; &nbsp; 
						<a href='javascript:void(0);' 
                            onClick=\"nieuwDeel('vragenForm','','Vraag','#VragenFormID');\">
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
					</div>
					
					</form>
				</div>"); //einde dialog div
                    
                    
                    
                }break;//einde nieuwe audit
                
                
                case 'analyseLijstOpslaan':
                {
                    //checken of het een nieuwe audit is of niet
					
					if($id=="")
					{
						$q_naarDB =
						"insert into rie_audit (naam, omschrijving, inhoud, actief)
						values('".$naam."','".$omschrijving."','test inhoud','";
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
					
		$(document).ready(function() {
			
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
		} );
	alert('<?php 	$id_laatste=mysqli_insert_id($link); echo $id_laatste; ?>');
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
											onClick=\"analyseLijst('".$lijst[id]."');\">
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
		
	    }// einde if($_POST)
	
    }
}
else print("Sessie verlopen");
