<?php

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
		$id_hoofd=mysqli_real_escape_string($link,$_POST[id_hoofd]);
		$id_sub=mysqli_real_escape_string($link,$_POST[id_sub]);
		$naam=mysqli_real_escape_string($link,$_POST[naam]);
		$aard=mysqli_real_escape_string($link,$_POST[aard]);
	 
		function subcategorie($link,$hoofd_id,$hoofd_naam)
		{
			$q_sub=
            "select * 
            from vik_categorie_sub 
            where id_hoofd='".$hoofd_id."' 
            and (actief='1' or actief='2') 
            order by naam";
            
			$r_sub=mysqli_query($link,$q_sub);
			if(mysqli_num_rows($r_sub)>"0")
			{
				print("<br /><br /><table border='1'>");
				while($sub=mysqli_fetch_array($r_sub))
				{
					print("<tr><td><b>".$sub[naam]); 
                    if($sub[actief]=="2") 
                        print(" (Voorstel)"); 
                    print("</b></td><td align='right'>");
					
					if($_SESSION[aard]=="super")  
                        print("
                            <a href='javascript:void(0);' 
                                onClick=\"artikelVik('nieuw','','".$hoofd_id."','".$sub[id]."','".addslashes($hoofd_naam)." ".addslashes($sub[naam])."');\">
                                <img src='".$_SESSION[http_images]."nieuw.png'> Nieuw artikel</a>
                            &nbsp; &nbsp; &nbsp; 
                            <a href='javascript:void(0);' 
                                onClick=\"SubCategorieVik('".$hoofd_id."','wijzig','".$sub[id]."','".addslashes($hoofd_naam)." ".addslashes($sub[naam])."');\">
                                <img src='".$_SESSION[http_images]."edit.png'> Wijzig</a> 
                            &nbsp;  &nbsp;  &nbsp; 
                            <a href='javascript:void(0);' 
                                onClick=\"vikDeactiveer2('subcategorie','".$sub[id]."','".$hoofd_id."');\">
                                <img src='".$_SESSION[http_images]."kruis.png'> Deactiveer</a> 
                            &nbsp; &nbsp; &nbsp; 
                        ");
					elseif($_SESSION[aard]=="cpa") 
					{
						print("
                            <a href='javascript:void(0);' 
                                onClick=\"artikelVik('nieuw','','".$hoofd_id."','".$sub[id]."','".addslashes($hoofd_naam)." ".addslashes($sub[naam])."');\">
                                <img src='".$_SESSION[http_images]."nieuw.png'> Nieuw artikel (voorstel)</a>
                            &nbsp; &nbsp; &nbsp; 
                        ");
						if($sub[actief]=="1")
                            print("
                                <a href='javascript:void(0);' 
                                    onClick=\"SubCategorieVik('".$hoofd_id."','wijzig','".$sub[id]."','".addslashes($hoofd_naam)." ".addslashes($sub[naam])."');\">
                                    <img src='".$_SESSION[http_images]."edit.png'> Wijzig (voorstel)</a>
                            ");
						else print("In behandeling");
					}
					
					
					print(" 
                        &nbsp;  &nbsp;  &nbsp; 
                        <a href='javascript:void(0);' 
                            onClick=\"vik('".$hoofd_id."','sub','".$sub[id]."','".addslashes($sub[naam])."');\">
                            <img src='../images/download.png'> Overzicht Documenten (".aantal_vik($link,"sub",$sub[id]).")</a>
                        </td></tr>
                    ");
					
					//controle op artikels
					$q_artikel=
                        "select * 
                        from vik_artikel 
                        where id_hoofd='".$hoofd_id."' 
                        and id_sub='".$sub[id]."' 
                        and (actief='1' or actief='2')  
                        order by naam";
					$r_artikel=mysqli_query($link,$q_artikel);
					if(mysqli_num_rows($r_artikel)>"0")
					{
						while($artikel=mysqli_fetch_array($r_artikel))
						{
							print("<tr><td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; +--".$artikel[naam]); 
                            if($artikel[actief]=="2") 
                                print(" (Voorstel)");
							print("</td><td align='right'>");
							
							if($_SESSION[aard]=="super")
                                print("
                                    <a href='javascript:void(0);' 
                                        onClick=\"artikelVik('wijzig','".$artikel[id]."','".$hoofd_id."','".$sub[id]."','".addslashes($hoofd_naam)." ".addslashes($sub[naam])."');\">
                                        <img src='".$_SESSION[http_images]."edit.png'> Wijzig</a> 
                                    &nbsp;  &nbsp;  &nbsp; 
                                    <a href='javascript:void(0);' 
                                        onClick=\"vikDeactiveer2('artikel','".$artikel[id]."','".$hoofd_id."');\">
                                        <img src='".$_SESSION[http_images]."kruis.png'> Deactiveer</a> 
                                    &nbsp; &nbsp; &nbsp;
                                ");
							elseif($_SESSION[aard]=="cpa")
							{
								if($artikel[actief]=="2") 
                                    print("In behandeling ");
								else print("
                                    <a href='javascript:void(0);' 
                                    onClick=\"artikelVik('wijzig','".$artikel[id]."','".$hoofd_id."','".$sub[id]."','".addslashes($hoofd_naam)." ".addslashes($sub[naam])."');\">
                                    <img src='".$_SESSION[http_images]."edit.png'> Wijzig (Voorstel)</a>
                                ");
							}
							print("
                                &nbsp;  &nbsp;  &nbsp; 
                                <a href='javascript:void(0);' 
                                    onClick=\"vik('".$hoofd_id."','artikel','".$artikel[id]."','".addslashes($artikel[naam])."');\">
                                    <img src='../images/download.png'> Overzicht Documenten (".aantal_vik($link,"artikel",$artikel[id]).")</a>
                                </td></tr>
                            ");
						}
					}
				}
				print("</table><br />");
			}
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
                                <td align='right'>
                                    <a href='javascript:void(0);' 
                                        onClick=\"SubCategorieVik('".$hoofd[id]."','nieuw','".$hoofd[id]."','".addslashes($hoofd[naam])."');\">
                                        <img src='".$_SESSION[http_images]."nieuw.png'> Nieuwe subcategorie</a> 
                                    &nbsp; &nbsp; &nbsp; 
                                    <a href='javascript:void(0);' 
                                        onClick=\"CategorieVik('wijzig','".$hoofd[id]."');\">
                                        <img src='".$_SESSION[http_images]."edit.png'> Wijzig</a> 
                                    &nbsp;  &nbsp;  &nbsp; 
                                    <a href='javascript:void(0);' 
                                        onClick=\"vikDeactiveer2('hoofdcategorie','".$hoofd[id]."','');\">
                                        <img src='".$_SESSION[http_images]."kruis.png'> Deactiveer</a>
                                </td>
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
                                        <td>
                                        &nbsp; &nbsp; &nbsp; +--".$sub[naam]."
                                        </td>
                                        <td align='right'>
                                            <a href='javascript:void(0);' 
                                                onClick=\"artikelVik('nieuw','','".$hoofd[id]."','".$sub[id]."','".addslashes($hoofd[naam])." ".addslashes($sub[naam])."');\">
                                                <img src='".$_SESSION[http_images]."nieuw.png'> Nieuw artikel</a> 
                                            &nbsp; &nbsp; &nbsp; 
                                            <a href='javascript:void(0);' 
                                                onClick=\"SubCategorieVik('".$hoofd[id]."','wijzig','".$sub[id]."','".addslashes($hoofd[naam])." ".addslashes($sub[naam])."');\">
                                                <img src='".$_SESSION[http_images]."edit.png'> Wijzig</a> 
                                            &nbsp;  &nbsp;  &nbsp; 
                                            <a href='javascript:void(0);' 
                                                onClick=\"vikDeactiveer2('subcategorie','".$sub[id]."','".$hoofd[id]."');\">
                                                <img src='".$_SESSION[http_images]."kruis.png'> Deactiveer</a>
                                        </td>
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
                                                <td>
                                                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                                                    +--".$artikel[naam]."
                                                </td>
                                                <td align='right'>
                                                    <a href='javascript:void(0);' 
                                                        onClick=\"artikelVik('wijzig','".$artikel[id]."','".$hoofd[id]."','".$sub[id]."','".addslashes($hoofd[naam])." ".addslashes($sub[naam])."');\">
                                                        <img src='".$_SESSION[http_images]."edit.png'> Wijzig</a> 
                                                    &nbsp;  &nbsp;  &nbsp; 
                                                    <a href='javascript:void(0);' 
                                                        onClick=\"vikDeactiveer2('artikel','".$artikel[id]."','".$hoofd[id]."');\"><img src='".$_SESSION[http_images]."kruis.png'> Deactiveer</a>
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
					
				//inactieve structuren
				print("
                    <br /><br /><hr /><br /><br />
                    <h2>Verwijderde structuren (tijdelijke prullenbak)</h2>
                    <br /><br />
                    <table id='dataTable'>
                        <thead>
                            <tr>
                                <td>Naam</td>
                                <td>Actie</td>
                            </tr>
                        </thead>
                    <tbody>
                ");
				//weergave van hoofdcategorie RIE checklisten	
			 	$q_hoofd=
                     "select * 
                     from vik_categorie_hoofd 
                     where actief='0' 
                     order by naam";
			 	$r_hoofd=mysqli_query($link,$q_hoofd);
			 	if(mysqli_num_rows($r_hoofd)>"0")
			 	{
				
				
					while($hoofd=mysqli_fetch_array($r_hoofd))
					{
						print("
                            <tr>
                                <td><b>+ ".$hoofd[naam]."</b></td>
                                <td align='right'>
                                    <a href='javascript:void(0);' 
                                        onClick=\"vikActiveer2('hoofdcategorie','".$hoofd[id]."');\">
                                        <img src='".$_SESSION[http_images]."vink.png'> Activeer</a>
                                </td>
                            </tr>
                        ");
					}
				}
				
				//controle op subcategorie
				$q_sub=
                    "select * 
                    from vik_categorie_sub 
                    where actief='0' 
                    order by naam";
				$r_sub=mysqli_query($link,$q_sub);
				if(mysqli_num_rows($r_sub)>"0")
				{
					while($sub=mysqli_fetch_array($r_sub))
					{
					 
						print("
                            <tr>
                                <td>
                                    &nbsp; &nbsp; &nbsp; 
                                    +--".$sub[naam]."
                                </td>
                                <td align='right'>
                                    <a href='javascript:void(0);' 
                                    onClick=\"vikActiveer2('subcategorie','".$sub[id]."');\">
                                    <img src='".$_SESSION[http_images]."vink.png'> Activeer</a>
                                </td>
                            </tr>
                        ");
					}
				}		
				
				//controle op artikels
				$q_artikel=
                "select * 
                from vik_artikel 
                where actief='0' 
                order by naam";
				$r_artikel=mysqli_query($link,$q_artikel);
				if(mysqli_num_rows($r_artikel)>"0")
				{
					while($artikel=mysqli_fetch_array($r_artikel))
					{
						print("
                            <tr>
                                <td>
                                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                                    +--".$artikel[naam]."
                                </td>
                                <td align='right'>
                                    <a href='javascript:void(0);' 
                                    onClick=\"vikActiveer2('artikel','".$artikel[id]."');\">
                                    <img src='".$_SESSION[http_images]."vink.png'> Activeer</a>
                                </td>
                            </tr>
                        ");
					}
				}
				
				print("</table>");
				
			}break;
			
			case 'hoofdstructuur':
			{
				//weergave van hoofdcategorie RIE checklisten	zowel actieve als voorstellen tot wijziging en nieuwe
			 	$q_hoofd=
                 "select * 
                 from vik_categorie_hoofd 
                 where actief='1' or actief='2' 
                 order by naam";
			 	$r_hoofd=mysqli_query($link,$q_hoofd);
			 	if(mysqli_num_rows($r_hoofd)>"0")
			 	{
					
					print("
						 <script>
						    $(function() {
						        $( \"#accordion\" ).accordion(
								{
									collapsible:true,
									active:false
								});
						    });
						    </script>
							
						<div id='accordion'>");
											
					while($hoofd=mysqli_fetch_array($r_hoofd))
					{
						print("
                        <h3>".$hoofd[naam]."</h3>
                        <div>
                            <a href='javascript:void(0);' 
                                onClick=\"SubCategorieVik('".$hoofd[id]."','nieuw','".$hoofd[id]."','".addslashes($hoofd[naam])."');\">
                                <img src='".$_SESSION[http_images]."nieuw.png'> Nieuwe subcategorie</a> 
                            &nbsp; &nbsp; &nbsp; 
                            <a href='javascript:void(0);' onClick=\"CategorieVik('wijzig','".$hoofd[id]."');\">
                                
                            &nbsp;  &nbsp;  &nbsp; 
                            <a href='javascript:void(0);' onClick=\"vikDeactiveer2('hoofdcategorie','".$hoofd[id]."','');\">
                                <img src='".$_SESSION[http_images]."kruis.png'> Deactiveer</a>
    						<div id='".$hoofd[id]."'></div>
                        </div>");
						//controle op subcategorie
						
					}
					
					print("
					
					<h3>Verwijderde structuren (tijdelijke prullenbak)</h3><div id='verwijderd'>
					</div></div>
					");
				}	
					
				
			}break;	
			
			//Eigen testcode voor aanvaarden voor  hoofdcategorie
			
			case 'aanvaard':
			{
				$q_aanvaard=
					"update vik_categorie_hoofd 
					set actief='1' 
					where id='".$id."'";
					
				$r_aanvaard=mysqli_query($link,$q_aanvaard);
				if($r_aanvaard) 
				{
					print("<br /><br /><br /><h2><center><font color=green>VIK met succes aanvaard!</font></center></h2>");
				}
				else
				{
					print("<br /><br /><br /><h2><center><font color=red>VIK niet aanvaard!</font></center></h2>");
				}
			}break;
			//Einde testcode aanvaard hoofdcategorie
			
			//Eigen testcode voor weigeren van hoofdcategorie			
			case 'weiger':
			{
				$q_weiger=
					"update vik_categorie_hoofd 
					set actief='0' 
					where id='".$id."'";
					
				$r_weiger=mysqli_query($link,$q_weiger);
				if($r_weiger) 
				{
					print("<br /><br /><br /><h2><center><font color=green>VIK met succes aanvaard!</font></center></h2>");
				}
				else
				{
					print("<br /><br /><br /><h2><center><font color=red>VIK niet aanvaard!</font></center></h2>");
				}
			}break;
			//Einde testcode weiger
			
			//Eigen testcode voor aanvaarden van subdcategorie			
			case 'aanvaardsub':
			{
				$q_aanvaardsub=
					"update vik_categorie_sub 
					set actief='1' 
					where id='".$id."'";
					
				$r_aanvaardsub=mysqli_query($link,$q_aanvaardsub);
				if($r_aanvaardsub) 
				{
					print("<br /><br /><br /><h2><center><font color=green>VIK met succes aanvaard!</font></center></h2>");
				}
				else
				{
					print("<br /><br /><br /><h2><center><font color=red>VIK niet aanvaard!</font></center></h2>");
				}
			}break;
			//Einde testcode aanvaard
			
			//Eigen testcode voor weigeren voor  hoofdcategorie			
			case 'weigersub':
			{
				$q_weigersub=
					"update vik_categorie_sub 
					set actief='0' 
					where id='".$id."'";
					
				$r_weigersub=mysqli_query($link,$q_weigersub);
				if($r_weigersub) 
				{
					print("<br /><br /><br /><h2><center><font color=green>VIK met succes aanvaard!</font></center></h2>");
				}
				else
				{
					print("<br /><br /><br /><h2><center><font color=red>VIK niet aanvaard!</font></center></h2>");
				}
			}break;
			//Einde testcode weiger
			
			//Eigen testcode voor aanvaarden van artikel			
			case 'aanvaardartikel':
			{
				$q_aanvaardartikel=
					"update vik_artikel
					set actief='1' 
					where id='".$id."'";
					
				$r_aanvaardartikel=mysqli_query($link,$q_aanvaardartikel);
				if($r_aanvaardsub) 
				{
					print("<br /><br /><br /><h2><center><font color=green>VIK met succes aanvaard!</font></center></h2>");
				}
				else
				{
					print("<br /><br /><br /><h2><center><font color=red>VIK niet aanvaard!</font></center></h2>");
				}
			}break;
			//Einde testcode aanvaard
			
			//Eigen testcode voor weigeren van artikel		
			case 'weigerartikel':
			{
				$q_weigerartikel=
					"update vik_artikel 
					set actief='0' 
					where id='".$id."'";
					
				$r_weigerartikel=mysqli_query($link,$q_weigerartikel);
				if($r_weigerartikel) 
				{
					print("<br /><br /><br /><h2><center><font color=green>VIK met succes aanvaard!</font></center></h2>");
				}
				else
				{
					print("<br /><br /><br /><h2><center><font color=red>VIK niet aanvaard!</font></center></h2>");
				}
			}break;
			//Einde testcode weiger
			
			case 'substructuur':
			{
				subcategorie($link,$id_hoofd,$naam);
			}break;
			
			case 'inactieve_structuur':
			{
				//inactieve structuren
				print("<table id='dataTable'><thead><tr><td>Naam</td><td>Actie</td></tr></thead><tbody>");
				//weergave van hoofdcategorie RIE checklisten	
			 	$q_hoofd=
                 "select * 
                 from vik_categorie_hoofd 
                 where actief='0' 
                 order by naam";
			 	$r_hoofd=mysqli_query($link,$q_hoofd);
			 	if(mysqli_num_rows($r_hoofd)>"0")
			 	{
				
				
					while($hoofd=mysqli_fetch_array($r_hoofd))
					{
						print("
                            <tr>
                                <td>
                                    <b>+ ".$hoofd[naam]."</b>
                                </td>
                                <td align='right'>
                                    <a href='javascript:void(0);' onClick=\"vikActiveer2('hoofdcategorie','".$hoofd[id]."');\">
                                    <img src='".$_SESSION[http_images]."vink.png'> Activeer</a>
                                </td>
                            </tr>
                        ");
					}
				}
				
				//controle op subcategorie
				$q_sub=
                "select * 
                from vik_categorie_sub 
                where actief='0' 
                order by naam";
				$r_sub=mysqli_query($link,$q_sub);
				if(mysqli_num_rows($r_sub)>"0")
				{
					while($sub=mysqli_fetch_array($r_sub))
					{
						print("
                            <tr>
                                <td>
                                    &nbsp; &nbsp; &nbsp; 
                                    +--".$sub[naam]."
                                </td>
                                <td align='right'>
                                    <a href='javascript:void(0);' onClick=\"vikActiveer2('subcategorie','".$sub[id]."');\">
                                    <img src='".$_SESSION[http_images]."vink.png'> Activeer</a>
                                </td>
                            </tr>
                        ");
					}
				}		
				
				//controle op artikels
				$q_artikel=
                "select * 
                from vik_artikel 
                where actief='0' 
                order by naam";
				$r_artikel=mysqli_query($link,$q_artikel);
				if(mysqli_num_rows($r_artikel)>"0")
				{
					while($artikel=mysqli_fetch_array($r_artikel))
					{
						print("
                            <tr>
                                <td>
                                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                                    +--".$artikel[naam]."
                                </td>
                                <td align='right'>
                                    <a href='javascript:void(0);' onClick=\"vikActiveer2('artikel','".$artikel[id]."');\">
                                    <img src='".$_SESSION[http_images]."vink.png'> Activeer</a>
                                </td>
                            </tr>
                        ");
					}
				}
				
				print("</table>");
				
			}break;
			
			case 'categorie_form':
			{
				//zoeken naar info in geval van wijzigen
				if($id!="")
				{
					$q_cat=
                    "select * 
                    from vik_categorie_hoofd 
                    where id='".$id."' limit 1";
					$r_cat=mysqli_query($link,$q_cat);
					if(mysqli_num_rows($r_cat)=="1")
					{
						$cat=mysqli_fetch_array($r_cat);
					}
					else $cat=array();
				}
				else $cat=array();
				
				print("
					<form id='hoofdcategorie'>
					<input type='hidden' name='actie' value='categorie_save'>
					<input type='hidden' name='id' value='".$id."'>
					Naam: <input type='text' name='naam' value='".$cat[naam]."' size='100'>
					</form>
				");
			}break;	
			
			case 'categorie_save':
			{
				if($id=="")
				{
					//insert
					$q_insert=
                    "insert into vik_categorie_hoofd (naam,id_scholengemeenschap,id_school,actief) 
                    values('".$naam."','".$_SESSION[scholengemeenschap]."','".$_SESSION[school_id]."','";
					if($_SESSION[aard]=="super") 
                        $q_insert.="1";
					else $q_insert.="2";
					$q_insert.="')";
					//print($q_insert."<br />");
					$r_insert=mysqli_query($link,$q_insert);
					if($r_insert) 
					{
						if($_SESSION[aard]=="super") 
                            print("<br /><br /><br /><h2><font color=green><center>Categorie met succes opgeslagen!</center></font></h2>");
						else print("<br /><br /><br /><h2><font color=green><center>Voorstel nieuwe categorie met succes opgeslagen!</center></font></h2>");
					}
					else print("<br /><br /><br /><h2><font color=red><center>Categorie opslaan MISLUKT!</center></font></h2>");
				}
				else
				{
					//update
					if($_SESSION[aard]=="super")
                        $q_update="update vik_categorie_hoofd set naam='".$naam."' where id='".$id."'";
					else $q_update="insert into vik_categorie_hoofd_historiek (id_categorie_hoofd,naam,id_scholengemeenschap,id_school,actief) values('".$id."','".$naam."','".$_SESSION[scholengemeenschap]."','".$_SESSION[school_id]."','2')";
					$r_update=mysqli_query($link,$q_update);
					if($r_update) 
					{
						if($_SESSION[aard]=="super") print("<br /><br /><br /><h2><font color=green><center>Wijziging met succes opgeslagen!</center></font></h2>");
						else print("<br /><br /><br /><h2><font color=green><center>Voorstel tot wijziging met succes opgeslagen!</center></font></h2>");
					}
					else print("<br /><br /><br /><h2><font color=red><center>Wijziging opslaan MISLUKT!</center></font></h2>");
				}
			}break;	
			
			case 'subcategorie_form':
			{
				//zoeken naar info in geval van wijzigen
				//print("aard: ".$aard." id=".$id."<br />");
				if($aard!="nieuw")
				{
					$q_sub=
                    "select * 
                    from vik_categorie_sub 
                    where id='".$id."' limit 1";
					//print($q_sub."<br />");
					$r_sub=mysqli_query($link,$q_sub);
					if(mysqli_num_rows($r_sub)=="1")
					{
						$sub=mysqli_fetch_array($r_sub);
					}
					else $sub=array();
				}
				else 
				{
					$sub=array();
					$id_hoofd=$id;
				}
				
				if($id_hoofd=="") $id_hoofd=$sub[id_hoofd];
				
				print("<br />
					<form id='subcategorie'>
					<input type='hidden' name='actie' value='subcategorie_save'>
					<input type='hidden' name='id' value='".$id."'>
					<input type='hidden' name='aard' value='".$aard."'>
					<table><tr><td>
					Categorie:</td><td><select name='id_hoofd'>
					");
					
					$q_cat=
                    "select * 
                    from vik_categorie_hoofd 
                    order by naam";
					$r_cat=mysqli_query($link,$q_cat);
					if(mysqli_num_rows($r_cat)>"0")
					{
						while($cat=mysqli_fetch_array($r_cat))
						{
							print("<option value='".$cat[id]."' "); if($id_hoofd==$cat[id])print(" SELECTED ");print(">".$cat[naam]."</option>");
						}
					}
					
					print("
					</select></td></tr>
    					<tr>
                            <td>
        					Naam: </td><td><input type='text' name='naam' value='".$sub[naam]."' size='50'>
                            </td>
                        </tr>
					</table>
					
					</form>
				");
			}break;	
			
			case 'subcategorie_save':
			{
				if($aard=="nieuw")
				{
					//insert
					$q_insert=
                    "insert into vik_categorie_sub (naam,id_hoofd,id_scholengemeenschap,id_school,actief) 
                    values('".$naam."','".$id_hoofd."','".$_SESSION[scholengemeenschap]."','".$_SESSION[school_id]."','";
					if($_SESSION[aard]=="super") 
                        $q_insert.="1";
					else $q_insert.="2"; 
					   $q_insert.="')";
					$r_insert=mysqli_query($link,$q_insert);
					if($r_insert) 
					{
						if($_SESSION[aard]=="super") 
                            print("<br /><br /><br /><h2><font color=green><center>Subcategorie met succes opgeslagen!</center></font></h2>");
						else print("<br /><br /><br /><h2><font color=green><center>Voorstel subcategorie met succes opgeslagen!</center></font></h2>");
					}
					else print("<br /><br /><br /><h2><font color=red><center>Subcategorie opslaan MISLUKT!</center></font></h2>");
				}
				else
				{
					//update
					if($_SESSION[aard]=="super")
                        $q_update=
                        "update vik_categorie_sub    
                        set naam='".$naam."',id_hoofd='".$id_hoofd."' 
                        where id='".$id."'";
					else $q_update=
                    "insert into vik_categorie_sub_historiek (id_categorie_sub,naam,id_hoofd,id_scholengemeenschap,id_school,actief) 
                    values('".$id."','".$naam."','".$id_hoofd."','".$_SESSION[scholengemeenschap]."','".$_SESSION[school_id]."','2')";
					$r_update=mysqli_query($link,$q_update);
					if($r_update) 
					{
						if($_SESSION[aard]=="super") 
                            print("<br /><br /><br /><h2><font color=green><center>Wijziging met succes opgeslagen!</center></font></h2>");
						else print("<br /><br /><br /><h2><font color=green><center>Voorstel wijziging met succes opgeslagen!</center></font></h2>");
					}
					else print("<br /><br /><br /><h2><font color=red><center>Wijziging opslaan MISLUKT!</center></font></h2>");
				}
			}break;	
			
			case 'artikel_form':
			{
				//zoeken naar info in geval van wijzigen
				if($aard!="nieuw")
				{
					$q_cat=
                    "select * 
                    from vik_artikel 
                    where id='".$id."' limit 1";
					$r_cat=mysqli_query($link,$q_cat);
					if(mysqli_num_rows($r_cat)=="1")
					{
						$cat=mysqli_fetch_array($r_cat);
					}
					else $cat=array();
				}
				else $cat=array();
				
				print("<br />
					<form id='artikel'>
					<input type='hidden' name='actie' value='artikel_save'>
					<input type='hidden' name='id' value='".$id."'>
					<input type='hidden' name='id_hoofd' value='".$id_hoofd."'>
					<input type='hidden' name='id_sub' value='".$id_sub."'>
					<input type='hidden' name='aard' value='".$aard."'>
					Naam: <input type='text' name='naam' value='".$cat[naam]."' size='50'><br />
					</form>
				");
			}break;	
			
			case 'artikel_save':
			{
				if($aard=="nieuw")
				{
					//insert
					$q_insert=
                    "insert into vik_artikel (naam,id_hoofd,id_sub,id_scholengemeenschap,id_school,actief) 
                    values('".$naam."','".$id_hoofd."','".$id_sub."','".$_SESSION[scholengemeenschap]."','".$_SESSION[school_id]."','";
					if($_SESSION[super]) $q_insert.="1";
					else $q_insert.="2";
					$q_insert.="')";
					//print($q_insert."<br />");
					$r_insert=mysqli_query($link,$q_insert);
					if($r_insert) 
					{
						if($_SESSION[aard]=="super") 
                            print("<br /><br /><br /><h2><font color=green><center>Artikel met succes opgeslagen!</center></font></h2>");
						else print("<br /><br /><br /><h2><font color=green><center>Voorstel artikel met succes opgeslagen!</center></font></h2>");
					}
					else print("<br /><br /><br /><h2><font color=red><center>Artikel opslaan MISLUKT!</center></font></h2>");
				}
				else
				{
					//update
					if($_SESSION[aard]=="super") 
                        $q_update=
                        "update vik_artikel 
                        set naam='".$naam."' 
                        where id='".$id."'";
					else 
                        $q_update=
                        "insert into vik_artikel_historiek (id_artikel,naam,id_hoofd,id_sub,id_scholengemeenschap,id_school,actief) 
                        values('".$id."','".$naam."','".$id_hoofd."','".$id_sub."','".$_SESSION[scholengemeenschap]."','".$_SESSION[school_id]."','2')";
					print($q_update."<br />");
					$r_update=mysqli_query($link,$q_update);
					//print($q_update."<br />");
					if($r_update) 
					{
						if($_SESSION[aard]=="super") 
                            print("<br /><br /><br /><h2><font color=green><center>Wijziging met succes opgeslagen!</center></font></h2>");
						else print("<br /><br /><br /><h2><font color=green><center>Voorstel tot wijziging met succes opgeslagen!</center></font></h2>");
					}
					else print("<br /><br /><br /><h2><font color=red><center>Wijziging opslaan MISLUKT!</center></font></h2>");
				}
			}break;	
			
			case 'deactiveer':
			{
				$q_deactiveer="update vik_";
				
				switch($aard)
				{
					case 'hoofdcategorie': $q_deactiveer.="categorie_hoofd"; break;
					case 'subcategorie': $q_deactiveer.="categorie_sub"; break;
					case 'artikel': $q_deactiveer.="artikel"; break;
				}
				
				$q_deactiveer.=" set actief='0' where id='".$id."'";
				//print($q_deactiveer."<br />");
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
			
			case 'activeer':
			{
				$q_deactiveer="update vik_";
				
				switch($aard)
				{
					case 'hoofdcategorie': $q_deactiveer.="categorie_hoofd"; break;
					case 'subcategorie': $q_deactiveer.="categorie_sub"; break;
					case 'artikel': $q_deactiveer.="artikel"; break;
				}
				
				$q_deactiveer.=" set actief='1' where id='".$id."'";
				$r_deactiveer=mysqli_query($link,$q_deactiveer);
				if($r_deactiveer) 
				{
					print("<br /><br /><br /><h2><center><font color=green>".ucfirst($aard)." met succes geactiveerd!</font></center></h2>");
				}
				else
				{
					print("<br /><br /><br /><h2><center><font color=red>".ucfirst($aard)." niet geactiveerd!</font></center></h2>");
				}
			}break;
		}
	
	}
}
else print("Sessie verlopen");
	 