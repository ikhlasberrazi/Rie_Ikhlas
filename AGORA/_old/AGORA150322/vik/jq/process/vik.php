<?php
if($_REQUEST['sessie']!="") session_id($_REQUEST['sessie']);
session_start();

if(($_SESSION[login]=="wos_coprant") and ($_SESSION[vik]!=""))
{
	//databank openen
	include_once("../../../config/dbi.php");
	include_once("../../../config/config.php");	
	include_once("../../config/config.php");	
	
	if($_POST)
	{ 
		$actie=$_POST[actie];	
		$id=mysqli_real_escape_string($link,$_POST[id]);
		$naam=mysqli_real_escape_string($link,$_POST[naam]);
		$aard=mysqli_real_escape_string($link,$_POST[aard]);
	}
	else
	{
		$actie=$_GET[actie];	
		$id=mysqli_real_escape_string($link,$_GET[id]);
		$naam=mysqli_real_escape_string($link,$_GET[naam]);
		$aard=mysqli_real_escape_string($link,$_GET[aard]);
	}	
		
	 	switch($actie)
		{
			case 'structuur':
			{
				//weergave van hoofdcategorie RIE checklisten	
			 	$q_hoofd=
			 		"select * 
			 		from vik_categorie_hoofd 
			 		where actief='1' 
			 		order by naam";
			 	$r_hoofd=mysqli_query($link,$q_hoofd);
			 	if(mysqli_num_rows($r_hoofd)>"0")
			 	{
					
					print("
						<table id='dataTable'>
							<thead>
								<tr>
									<td>Naam</td>
									<td>Aantal</td>
									<td>Actie</td>
								</tr>
							</thead>
						<tbody>
					");
					
					while($hoofd=mysqli_fetch_array($r_hoofd))
					{
						print("
							<tr>
								<td><b>+ ".$hoofd[naam]."</b></td>
								<td></td>
								<td></td>
							</tr>
						");
						
						//controle op subcategorie
						$q_sub=
							"select * 
							from vik_categorie_sub 
							where id_hoofd='".$hoofd[id]."' 
							and actief='1' 
							order by naam";
							
						$r_sub=mysqli_query($link,$q_sub);
						if(mysqli_num_rows($r_sub)>"0")
						{
							while($sub=mysqli_fetch_array($r_sub))
							{
								print("
									<tr>
										<td>&nbsp; &nbsp; &nbsp; +--".$sub[naam]."</td>
										<td></td>
										<td></td>
									</tr>
								");
															
								//controle op artikels
								$q_artikel=
									"select * 
									from vik_artikel 
									where id_hoofd='".$hoofd[id]."' 
									and id_sub='".$sub[id]."' 
									and actief='1' 
									order by naam";
								
								$r_artikel=mysqli_query($link,$q_artikel);
								if(mysqli_num_rows($r_artikel)>"0")
								{
									while($artikel=mysqli_fetch_array($r_artikel))
									{
										print("
											<tr>
												<td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; +--".$artikel[naam]."</td>
												<td>".aantal_vik($link,"artikel",$artikel[id])."</td>
												<td>
													<a href='javascript:void(0);' 
													onClick=\"vik('".$hoofd[id]."','artikel','".$artikel[id]."','".addslashes($artikel[naam])."');\">Overzicht VIK</a> 
												</td>
											</tr>
										");
									}
								}
							}
						}
					}
					
					print("</table>");
				}	
				
			}break;	
			
			case overzicht_vik:
			{
				print("
					<a href='javascript:void(0);' 
					onClick=\"uploadVIK('".$aard."','".$id."');\">
					<img src='".$_SESSION[http_images]."nieuw.png'> Nieuwe Veiligheidsinstructiekaart toevoegen</a>
					<br /><br />
				");
				
				$q_select=
				"select id,id_scholengemeenschap,id_school,bestandsnaam,wijzig_datum,wijzig_user_id,type,actief 
				from vik_upload 
				where aard='".$aard."' 
				and id_referentie='".$id."' 
				and ((id_scholengemeenschap='0' 
				and id_school='0') or (id_scholengemeenschap='".$_SESSION[scholengemeenschap]."' 
				and id_school='0') or (id_scholengemeenschap='".$_SESSION[scholengemeenschap]."' 
				and id_school='".$_SESSION[school_id]."'))";
				
				//print($q_select."<br />");
				$r_select=mysqli_query($link,$q_select);
				if(mysqli_num_rows($r_select)>"0")
				{
					print("
						<table id='dataTable' border='1'>
							<thead>
								<tr>
									<td>Datum</td>
									<td>Eigenaar</td>
									<td>Naam</td>
									<td>Actie</td>
								</tr>
								</thead>
							<tbody>
					");
					while($select=mysqli_fetch_array($r_select))
					{
						print("<tr><td>".$select[wijzig_datum]."</td><td>"); 
						if($select[id_scholengemeenschap]=="0") 
							print("ADMIN");
						elseif(($select[id_scholengemeenschap]==$_SESSION[scholengemeenschap]) and ($select[id_school]=="0")) 
							print("CPA");
						elseif($select[id_school]==$_SESSION[school_id]) 
							print("School");
						print("</td><td>".$select[bestandsnaam]."</td><td>");
						
						if($select[actief]=="1")
						{
							print("<a href='javascript:void(0);' onClick=\"VIKdownloadBestand('".$select[id]."');\">Download</a>");
							if(($_SESSION[scholengemeenschap]==$select[id_scholengemeenschap]) and ($select[id_school]==$_SESSION[school_id]))
								print(" 
									&nbsp;  &nbsp;  &nbsp; 
									<a href='javascript:void(0);' onClick=\"vikDeactiveer('".$aard."','".$id."','".$select[id]."');\">Deactiveer</a>
								");
							
						}
						elseif(($_SESSION[scholengemeenschap]==$select[id_scholengemeenschap]) and ($select[id_school]==$_SESSION[school_id]))
						{
							print("<a href='javascript:void(0);' onClick=\"vikActiveer('".$aard."','".$id."','".$select[id]."');\">Activeer</a>  ");
							if(($_SESSION[aard]=="super") or ($_SESSION[user_id]==$select[wijzig_user_id])) 
								print("
									&nbsp;  &nbsp;  &nbsp; 
									<a href='javascript:void(0);' onClick=\"vikVerwijder('".$aard."','".$id."','".$select[id]."');\">Verwijder definitief</a> 
								");
						}
						print("</td></tr>");
					}
					print("</tbody></table>");
				}
				else print("Geen VIK gevonden!");
				
			}break;
			
			
			case 'deactiveer':
			{
				
				$q_deactiveer=
					"update vik_upload 
					set actief='0' 
					where id='".$id."'";
					
				$r_deactiveer=mysqli_query($link,$q_deactiveer);
				if($r_deactiveer) 
				{
					print("<br /><br /><br /><center><h2><font color=green>VIK met succes gedeactiveerd!</font></center></h2>");
				}
				else
				{
					print("<br /><br /><br /><center><h2><font color=red>VIK niet gedeactiveerd!</font></center></h2>");
				}
			}break;
			
			case 'activeer':
			{
				
				$q_deactiveer=
					"update vik_upload 
					set actief='1' 
					where id='".$id."'";
					
				$r_deactiveer=mysqli_query($link,$q_deactiveer);
				if($r_deactiveer) 
				{
					print("<br /><br /><br /><h2><center><font color=green>VIK met succes geactiveerd!</font></center></h2>");
				}
				else
				{
					print("<br /><br /><br /><h2><center><font color=red>VIK niet geactiveerd!</font></center></h2>");
				}
			}break;
			
			case 'verwijder':
			{
				
				$q_deactiveer=
					"delete quick 
					from vik_upload 
					where id='".$id."'";
					
				$r_deactiveer=mysqli_query($link,$q_deactiveer);
				if($r_deactiveer) 
				{
					print("<br /><br /><br /><center><h2><font color=green>VIK met succes definitief verwijderd!</font></center></h2>");
				}
				else
				{
					print("<br /><br /><br /><center><h2><font color=red>VIK niet verwijderd!</font></center></h2>");
				}
			}break;
			
			case uploadform:
			{
				?>
				
				<script type="text/javascript">		
					function start_upload_vik_document()
					{
						var $a = $('#upload_file'),
							$f = $('#file'),
							$p = $('#progress'),
							$u = $('#upload_form'),
							aard='<?php print($aard);?>',
							type=$('#type').val(),
							id = '<?php print($id);?>',
							up = new uploader($f.get(0), {
								url:'jq/process/vik.php?actie=uploadsave&id='+id+'&aard='+aard,
								progress:function(ev){ console.log('progress'); $p.html(parseInt(((ev.loaded/ev.total)*100),10)+'%'); $p.css('width',$p.html()); if(parseInt(((ev.loaded/ev.total)*100),10)>'99') $p.css('background','lime'); },
								error:function(ev){ console.log('error'); },
								success:function(data)
								{ 
									console.log('success'); $p.html('100%'); $p.css('width',$p.html());  $('#progressbar').html("");
									$('div#feedback').bind('dialogclose', function(event) 
									{      
									 	vik_overzicht_detail(aard,id);
									 
									});
									$('#vikUpload').dialog("close");
									feedback(data);	
								}
							});
							
						$u.html("<img src='../images/progress.gif'>");
						up.send();
						
					}
				</script>
				
				<?php
				
				
				print("
				<div>
					<div id='upload_form'>
						<div id='upload_file'>	
							<label for='file'><b>Kies een bestand: test</b></label><br /><br />
							<input type='file' id='file' name='file' onChange=\"start_upload_vik_document();\" />
							<p>Wanneer er een bestand geselecteerd wordt, zal het automatisch verstuurd worden naar de server!!</p>
						</div>
					</div>
					<div id='progressbar'>
						<p>Vooruitgang upload:<br />
						<span id='progress' class='progress'>0%</span></p>
					</div>
				</div>
				");
			}break;
			
			case 'uploadsave':
			{
				if ($_FILES['file']["size"] > "0")
				{
					if ($_FILES['file']["error"] > 0)
					{
						echo "Foutcode: " . $_FILES['file']["error"] . "<br />";
					}
					else
					{
						$fileName = $_FILES['file']['name'];
						$tmpName  = $_FILES['file']['tmp_name'];
						$fileSize = $_FILES['file']['size'];
						
						$ontplof=explode(".",$fileName);
						
						//laatste deel na '.' is extensie
						$aantal=sizeof($ontplof);
						$aantal--;
						
						$ext=$ontplof[$aantal];
						
						//$fileType = $_FILES['Filedata']['type'];
						
						switch($ext)
						{
							case "jpg": $fileType.="image/jpeg";break;
							case "jpeg": $fileType.="image/jpeg";break;
							case "gif": $fileType.="image/gif";break;
							case "png": $fileType.="image/png";break;
							
							//microsoft
							case "doc": $fileType.="application/msword";break;
							case "docx": $fileType.="application/msword";break;
							case "xls": $fileType.="application/vnd.ms-excel";break;
							case "xlsx": $fileType.="application/vnd.ms-excel";break;
							case "ppt": $fileType.="application/vnd.ms-powerpoint";break;
							case "pptx": $fileType.="application/vnd.ms-powerpoint";break;
							
							case "pdf": $fileType.="application/pdf";break;					
						}
						//$fileType = $ext;
						
						$fileSize2=filesize($tmpName);
						
						$fp      = fopen($tmpName, 'r');
						$content = fread($fp,$fileSize2);
						//$content = addslashes($content);
						$content = mysqli_real_escape_string($link,$content);
						fclose($fp);
						
						if(!get_magic_quotes_gpc())
						{
						    $fileName = addslashes($fileName);
						}
						
									
						$query = 
							"INSERT INTO vik_upload (id_scholengemeenschap,id_school,id_referentie,aard,bestandsnaam, size, type, content,wijzig_user_id,wijzig_datum,ext ) 
							VALUES ('".$_SESSION[scholengemeenschap]."','".$_SESSION[school_id]."','".$id."','".$aard."','".$fileName."', '".$fileSize."', '".$fileType."', '".$content."','".$_SESSION[user_id]."','".date("Y-m-d")."','".$ext."')";
						
						//$query = "INSERT INTO am_upload (id_artikel,id_upload_specs,name, size, type,wijzig_user_id,wijzig_datum,ext ) VALUES ('".$id."','".$_REQUEST[type]."','".$fileName."', '".$fileSize."','".$fileType."','".$_SESSION[user_id]."','".date("Y-m-d")."','".$ext."')";
						//print("<textarea>".$query."</textarea><br />");
							
						mysqli_query($link,$query) or die("<br /><br /><br /><br /><center><h2><font color='red'>Er is een fout opgetreden bij het opslaan van het bestand ".$fileName." (".$fileSize."-".$fileSize2.")</font></h2></center>"); 
						
						
						echo "<br /><br /><br /><br /><center><h2><font color='green'>Bestand $fileName met succes geuploaded</font><h2></center>";
					}
				}
				else echo "<br /><br /><br /><br /><center><h2><font color='red'>Upload bestand mislukt, geen bestand gevonden!</center></font></h2>"; 
					
				
			}break;
			
			case 'download':
			{
				$q_item=
					"select id 
					from vik_upload 
					where id='".$id."'";
					
				//print($q_item."<br />");
				$r_item=mysqli_query($link,$q_item);
				if(mysqli_num_rows($r_item)=="1")
				{
										
					print("
						<center><font color=green>
						<h2>Bestand gevonden!</h2></font><br /><br />Volg onderstaande handleiding als u geen bestand ziet verschijnen!<br /><br />
						<a href='".$_SESSION['http']."upload/cookie_iexplorer.pdf' target='_blank'>
							<img src='".$_SESSION[http_images]."iexplorer.png'></a> 
						&nbsp;  &nbsp;  &nbsp; 
						<a href='".$_SESSION['http']."upload/cookie_firefox.pdf' target='_blank'>
							<img src='".$_SESSION[http_images]."firefox.png'></a>  
						&nbsp;  &nbsp;  &nbsp; 
						<a href='".$_SESSION['http']."upload/cookie_safari.pdf' target='_blank'>
							<img src='".$_SESSION[http_images]."safari.png'></a> 
						&nbsp;  &nbsp;  &nbsp; 
						<a href='".$_SESSION['http']."upload/cookie_chrome.pdf' target='_blank'>
							<img src='".$_SESSION[http_images]."chrome.png'></a> 
						&nbsp;  &nbsp;  &nbsp; 
						<a href='".$_SESSION['http']."upload/cookie_opera.pdf' target='_blank'>
							<img src='".$_SESSION[http_images]."opera.png'></a>
						</center>
						<script>location.href = \"".$_SESSION['http']."vik/bestanden/downloadvik.php?id=".$id."\";</script>");
					
				}
				else print("0");
			}break;
		}
	
	
}
else print("Sessie verlopen");
	 