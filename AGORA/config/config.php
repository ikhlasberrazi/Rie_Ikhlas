<?php
	//bibliotheken laden
//	include '/srv/www/htdocs/config/PEAR/Mail.php';
//	include '/srv/www/htdocs/config/PEAR/Mail/mime.php' ;
	
	//variabelen
	//$_SESSION['db_prefix']="keuring_";
	$_SESSION['print']="0";
	$_SESSION['http']="http://localhost:8080/agora/";
//	$_SESSION['http']="https://agora.weveco.net/";

	//$_SESSION['school_pw']='ROGIER'; //gebruikt in lijsten!!
	
	//versies van de software
	$_SESSION['versie_weveco']="weveco3";

	$_SESSION['http_images']=$_SESSION['http']."images/";
	
	$pagina_niet_gevonden="<br /><br /><br /><br /><br /><br /><br /><br /><center><img src='".$_SESSION['http_images']."alert.png'><br /><br /><br /><h1>Pagina niet gevonden!</h1></center>";
	
	//percentage van het aantal controles die uitgevoerd moeten zijn om positief te antwoorden op de vraag
	$_SESSION['minimum_inspectie']="80";
	
	date_default_timezone_set('Europe/Brussels');
	
	//emailinfo
	$mailto="alainnaets@gmail.com,jan.vanocken@telenet.be"; //beheerder email
	//$headers  = 'MIME-Version: 1.0' . "\r\n";
	//$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	//$headers .= 'From: Agora WeVeCo <noreply@weveco.net>' . "\r\n";

	$bcc="noreply@weveco.net";	
	
	$mail_ok="1"; //0 geen email mogelijk, 1 smtp server beschikbaar

	//functies
	function pq($query)
	{
		if($_SESSION['print']=="1") print("Query: $query <br />");
	}
	
	function drukmenu()
	{
		switch($_SESSION[aard])
		{
			case school: include_once("menu/school.php"); break;
			case super: include_once("menu/super.php"); break;
		}
	}
	
		
	function createRandomPassword($nr) {
	
	    $chars = "abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ023456789";
	    srand((double)microtime()*1000000);
	    $pass = '';
	
	    while (strlen($pass)<$nr) 
		{
	        $num = rand() % 33;
	        $tmp = substr($chars, $num, 1);
	        $pass.=$tmp;
	    }
	
	    return $pass;
	}
	
	function createRandomNumber($nr) {
	
	    $chars = "0123456789";
	    srand((double)microtime()*1000000);
	    $pass = '';
	
	    while (strlen($pass)<$nr) 
		{
	        $num = rand() % 33;
	        $tmp = substr($chars, $num, 1);
	        $pass.=$tmp;
	    }
	
	    return $pass;
	}
	
	function controle_frequentie($aantal1,$tijd1,$aantal2,$tijd2)
	{
		pq($aantal1.", ".$tijd1.", ".$aantal2.", ".$tijd2."<br />");
		
		$array1[aantal]=$aantal1;
		$array1[tijd]=$tijd1;
		$array1[keuze]="1";
		
		$array2[aantal]=$aantal2;
		$array2[tijd]=$tijd2;
		$array2[keuze]="2";
		
		$array3[aantal]="";
		$array3[tijd]="Fout";
		$array3[keuze]="3";
		
		//controle op ingevulde aantallen
		if((($aantal1=="") or ($aantal1=="0")) and (($aantal2!="") or ($aantal2!="0"))) return $array2;
		elseif((($aantal1!="") or ($aantal1!="0")) and (($aantal2=="") or ($aantal2=="0"))) return $array1;
		elseif((($aantal1=="") or ($aantal1=="0")) and (($aantal2=="") or ($aantal2=="0"))) return $array3;
		
		if(($tijd1=="") and ($tijd2!="")) return $array2;
		elseif(($tijd2=="") and ($tijd1!="")) return $array1;
		elseif(($tijd2=="") and ($tijd1=="")) return $array3;
		
		switch($tijd1)
		{
			case indienstname:
			{
				switch($tijd2)
				{
				  case indienstname:
				  {
					return $array1;
				  }break;
				}
			}break;
			
			case maal:
			{
				switch($tijd2)
				{					  
					case dag:
					{
						return $array2;
					}break;
					
					case maand:
					{
						return $array2;
					}break;
				
					case jaar:
					{
				  		return $array2;
					}
					
					default:
					{
						return $array1;
					}break;
				}
			}break;
			
			case dag:
			{
				switch($tijd2)
				{
					case dag:
					{
						if(($aantal1<$aantal2) or ($aantal2=="")) return $array1;
						else return $array2;
					}break;
					
					case maand:
					{
						if($aantal1<($aantal2*30))	return $array1;
						else return $array2;
					}break;
				
					case jaar:
					{
						if($aantal1<($aantal2*365))	return $array1;
						else return $array2;			
					}break;
					
					default:
					{
						return $array1;		
					}break;
				}
			}break;
			
			case maand:
			{
				switch($tijd2)
				{
					case dag:
					{
						if(($aantal1*30)<$aantal2) return $array1;
						else return $array2;
					}break;
					
					case maand:
					{
						if(($aantal1<$aantal2) or ($aantal2=="")) return $array1;
						else return $array2;
					}break;
				
					case jaar:
					{
						if($aantal1<($aantal2*12))return $array1;				
						else return $array2;
					}break;
					
					
					
					default:
					{
						return $array1;		
					}break;
				}	
			}break;
		
			case jaar:
			{
				switch($tijd2)
				{
					case dag:
					{
						if(($aantal1*356)<$aantal2)return $array1;
						else return $array2;
					}break;
					
					case maand:
					{
						if(($aantal1*12)<$aantal2)return $array1;
						else return $array2;
					}break;
				
					case jaar:
					{
						//print("hoera!!<br />");
						if((intval($aantal1)<intval($aantal2)) or ($aantal2=="")) 
						{
						 //print($aantal1."<".$aantal2);
							return $array1;
						}
						else return $array2;				
					}break;
					
					default:
					{
						return $array1;		
					}break;
				}					
			}break;
			
			case onbepaald:
			{
				switch($tijd2)
				{
					case dag:
					{
						return $array2;
					}break;
					
					case maand:
					{
						return $array2;
					}break;
					
					case jaar:
					{
						return $array2;
					}break;
					
					case indienstname:
					{
						return $array2;
					}break;
					
					case maal:
					{
						return $array2;
					}break;
					
					
					default:
					{
						return $array1;
					}break;
				}
			}
		}
	}
	
	function selecteer_alle_uitvoerders($link)
	{
					//alle uitvoerders in array opslaan
			$q_uitvoerders="select * from keuring_uitvoerders where actief='1' order by naam";
			$r_uitvoerders=mysqli_query($link,$q_uitvoerders);
			$aantal_uitvoerders=mysqli_num_rows($r_uitvoerders);
			if($aantal_uitvoerders>"0")
			{
				while($uit=mysqli_fetch_array($r_uitvoerders))
				{
					$id=$uit[id];
					$uitvoerder[$id]=$uit;
				}
			}
			
			mysqli_free_result($r_uitvoerders);
			return $uitvoerder;
	}
	
	function controle_uploadmap($pad)
	{
		if(!file_exists($pad))
		{
			//pad aanmaken
			if(mkdir($pad,0777,true)) print("<font color=green>Map met succes aangemaakt</font><br />");
			else print("<font color=red>Map NIET aangemaakt</font><br />");	
		}
		//else print("<font color=green>Map bestaat reeds!</font><br />");
	}
	
	function bestaan_mappen($pad,$bestandsnaam,$stop)
	{
		$splits=explode("/",$bestandsnaam);
		$aantal=sizeof($splits);
		$map=$pad;
		
		for($i="0";$i<$aantal-$stop;$i++)
		{
			if($i>"0") $map.="/";
			$map.=$splits[$i];
			
			controle_uploadmap($map);
			
			//print($map."<br />");
		}
	}
	
	function draaidatum ($start,$teken)
	{
		$splits=explode($teken,$start);
		
		return $splits[2].$teken.$splits[1].$teken.$splits[0];
	}
	
	function datum_nieuwe_keuring($link,$laatste_keuring,$school_id,$id_ki_standaard)
	{
		
		$_print="0";
		
		if($_print) print($laatste_keuring."<br />");
		
		if($laatste_keuring!="0000-00-00")
		{
			//nieuwe uitvoerdatum berekenen en opslaan
			//alle keuringsfrequenties opzoeken
	  
	  		//keuringsfrequentie CPA ophalen
	  		$q_cpa="select * from keuring_".$_SESSION['hfst']."item_sg where id_scholengemeenschap='".$_SESSION[scholengemeenschap]."' and id_standaard='".$id_ki_standaard."'";
	  		//print($q_cpa."<br />");
	  		$r_cpa=mysqli_query($link,$q_cpa);
	  		if(mysqli_num_rows($r_cpa)=="1") $cpa=mysqli_fetch_array($r_cpa);
	  		else $cpa=array();
	  		
	  		mysqli_free_result($r_cpa);
	  		
	  		//keuringsfrequentie school ophalen
	  		$q_school="select * from keuring_".$_SESSION['hfst']."item_school where id_school='".$school_id."' and id_ki_standaard='".$id_ki_standaard."'";
	  		//print($q_school."<br />");
			$r_school=mysqli_query($link,$q_school);
	  		if(mysqli_num_rows($r_school)=="1") $school=mysqli_fetch_array($r_school);
	  		else $school=array();
	  		
	  		mysqli_free_result($r_school);
	  		
	  		//standaardfrequentie ophalen
	  		$q_standaard="select * from keuring_".$_SESSION['hfst']."item where id='".$id_ki_standaard."'";
	  		//print($q_standaard."<br />");
			$r_standaard=mysqli_query($link,$q_standaard);
	  		if(mysqli_num_rows($r_standaard)=="1") $std=mysqli_fetch_array($r_standaard);
	  		else $std=array();
	  		
	  		mysqli_free_result($r_standaard);

			//test frequenties en tijd op de strenge waarden
			$test=controle_frequentie($std[frequentie_aantal],$std[frequentie_tijd],$cpa[frequentie_aantal],$cpa[frequentie_tijd]);
			if($_print)print($test[aantal]." ".$test[tijd]."<br />");
			$test=controle_frequentie($school[frequentie_aantal],$school[frequentie_tijd],$test[aantal],$test[tijd]);
			if($_print)print($test[aantal]." ".$test[tijd]."<br />");
			
			//datum laatste keuring splitsen
			if($_print)print("laatste keuring:".$laatste_keuring."<br />");
			$datum=explode("-",$laatste_keuring);
			
			switch($test[tijd])
			{
				case dag: 
				{
					$dag=$test[aantal];
					$maand="0";
					$jaar="0";
				}break;
				
				case maand: 
				{
					$dag="0";
					$maand=$test[aantal];
					$jaar="0";
				}break;
				
				case jaar: 
				{
					$dag="0";
					$maand="0";
					$jaar=$test[aantal];
				}break;
				
				case indienstname:
				{
					
					$jaar=$datum[0]+"50";
					
					return $jaar."-".$datum[1]."-".$datum[2];
				}break;
				
				case onbepaald:
				{
					
					$jaar=$datum[0]+"50";
					
					return $jaar."-".$datum[1]."-".$datum[2];
				}break;
			}
			
			if($_print)print("dag=".$dag." maand=".$maand." jaar=".$jaar."<br />");
			$maand=$datum[1]+$maand;
			$dag=$datum[2]+$dag;
			$jaar=$datum[0]+$jaar;
			if($jaar>"2037")$jaar="2037";
			if($_print)print("dag=".$dag." maand=".$maand." jaar=".$jaar."<br />");
			$nieuwe_keuring=date("Y-m-d", mktime(0,0,0,$maand,$dag,$jaar));
			
		}
		else $nieuwe_keuring="0000-00-00";
		
		if($_print)print("Nieuwe keuring: ".$nieuwe_keuring."<br />");
		
		return $nieuwe_keuring;
	}
	
	function print_select_uitvoerder($link,$select_naam,$aard,$hulp_uitvoerder)
	{
		$splits=explode(";",$aard);
		$hulp="0";
		$q_uitvoerder="select * from keuring_uitvoerders where actief='1'";
		
		foreach($splits as $aard)
		{
			if($aard!="")
			{
				if($hulp<"1") $q_uitvoerder.=" and (";
				else $q_uitvoerder.=" OR ";
				$q_uitvoerder.=" ".$aard."='1' ";
				$hulp++;	
			}	
		}
		
		if($hulp>"0")
		{ 
			$q_uitvoerder.=") ";
			
			$q_uitvoerder.=" order by naam";
			pq($q_uitvoerder."<br />");
			$r_uitvoerder=mysqli_query($link,$q_uitvoerder);
			
			if(mysqli_num_rows($r_uitvoerder)>"0")
			{
				
				/*if($_SESSION[campus]>"1")
				{*/
					print("<select name='".$select_naam."'>
						<option value=''></option>
					");
					
					while($uitvoerder=mysqli_fetch_array($r_uitvoerder))
					{
						//print($hulp_uitvoerder." = ".$uitvoerder[id]."<br />");
						
						print("<option value='".$uitvoerder[id]."' ");
						if($hulp_uitvoerder==$uitvoerder[id]) print(" SELECTED ");
						print(">".$uitvoerder[naam]." (".$uitvoerder[plaats]."): ".$uitvoerder[contact]."</option>
						");
					}
					
					print("</select>");
				/*}
				else print("Geen selectie mogelijk");	*/
			}
			else print("Geen uitvoerders gevonden!!");
			
			mysqli_free_result($r_uitvoerder);
		}
		else print("Type uitvoerder niet vermeld!");
	}
	
	function print_option_uitvoerder($link,$aard,$hulp_uitvoerder)
	{
		$splits=explode(";",$aard);
		
		$q_uitvoerder="select * from keuring_uitvoerders where actief='1'";
		
		foreach($splits as $stukje)
		{
			if(trim($stukje)!="")
			{
				if($hulp<"1") $q_uitvoerder.=" and (";
				else $q_uitvoerder.=" OR ";
				$q_uitvoerder.=$stukje."='1' ";
				$hulp++;	
			}
		}
		if($aard!="") $q_uitvoerder.=") ";
		
		$q_uitvoerder.=" order by naam";
		$r_uitvoerder=mysqli_query($link,$q_uitvoerder);
		//print("<option value=''>".$q_uitvoerder."</option> ");
		print("<option value=''></option> ");
		if(mysqli_num_rows($r_uitvoerder)>"0")
		{
				
				while($uitvoerder=mysqli_fetch_array($r_uitvoerder))
				{
					print("<option value='".$uitvoerder[id]."' ");
					if($hulp_uitvoerder==$uitvoerder[id]) print(" SELECTED ");
					print(">".$uitvoerder[naam]." (".$uitvoerder[plaats]."): ".$uitvoerder[contact]."</option>
					");
				}
		}
		else print("Geen uitvoerders gevonden!!");
		
		mysqli_free_result($r_uitvoerder);
	}
	
	function print_uitvoerder($link,$link_school,$uitvoerder,$aard)
	{
	 	if($aard=="personeel") 
		{
		 	$q_select="select * from agora_personeel where id='".$uitvoerder."' and actief='1' limit 1";
		 	pq($q_select."<br />");
			$r_select=mysqli_query($link_school,$q_select);
		}
		else 
		{
			$q_select="select * from keuring_uitvoerders where id='".$uitvoerder."' and actief='1' limit 1";
			pq($q_select."<br />");
			$r_select=mysqli_query($link,$q_select);
		}
		
		pq($q_select."<br />");
		$select=mysqli_fetch_array($r_select);
		
		mysqli_free_result($r_select);
		
		if($select[actief]=="1") $actief="";
		else $actief="<font color=red>Inactief</font>";
		
		if($select[naam]=="") return "Nog niet geselecteerd";
		else
		{
			if($aard=="personeel") return $select[naam]." ".$select[voornaam].": ".$select[tel]." ".$select[email]." ".$actief;
			else return $select[naam]." ".$select[voornaam]." (".$select[plaats]."): ".$select[contact]." ".$actief;
		}
		
	}
	
	function print_select_personeel($link,$persoon)
	{
		print("<select name=personeel>
				<option value=''>Maak een keuze!</option>
		");
		
		print_option_personeel($link,$persoon);
		
		print("</select>
		");
	}
	
	function print_option_personeel($link,$persoon)
	{
		$q_personeel="select * from agora_personeel where ((bevoegd_persoon='1' and school_id='".$_SESSION[school_id]."') or school_id='0') and actief='1' order by naam";
		//print($q_personeel."<br />");
		$r_personeel=mysqli_query($link,$q_personeel);
		if(mysqli_num_rows($r_personeel)>"0")
		{		
			print("<option value=''></option>");
			
			while($personeel=mysqli_fetch_array($r_personeel))
			{
				print("<option value='".$personeel[id]."' ");
				if($personeel[id]==$persoon) print(" SELECTED ");
				print(">".$personeel[naam]." ".$personeel[voornaam]."</option>
				");
			}
		}
		else print("<option value=''>Geen personeel gevonden!</option>");
		
		mysqli_free_result($r_personeel);
	}
	
	function print_personeel($link,$persoon)
	{
		$q_personeel="select * from agora_personeel where school_id='".$_SESSION[school_id]."' and actief='1' order by naam";
		$r_personeel=mysqli_query($link,$q_personeel);
		if(mysqli_num_rows($r_personeel)>"0")
		{		
			while($personeel=mysqli_fetch_array($r_personeel))
			{
				print("<option value='".$personeel[id]."' ");
				if($personeel[id]==$persoon) print(" SELECTED ");
				print(">".$personeel[naam]." ".$personeel[voornaam]."</option>
				");
			}
		}
		else print("<option value=''>Geen personeel gevonden!</option>");
		
		mysqli_free_result($r_personeel);
	}
	
	function print_select_personeel2($link,$hulp,$persoon)
	{
		$q_personeel="select * from agora_personeel where (school_id='".$_SESSION[school_id]."' or school_id='0') and actief='1' order by naam, voornaam";
		//print($q_personeel."<br />");
		$r_personeel=mysqli_query($link,$q_personeel);
		if(mysqli_num_rows($r_personeel)>"0")
		{
			print("<select name='".$hulp."'><option value=''>Kies personeelslid</option>
			");
			
			while($personeel=mysqli_fetch_array($r_personeel))
			{
				print("<option value='".$personeel[id]."' ");
				if($personeel[id]==$persoon) print(" SELECTED ");
				print(">".$personeel[naam]." ".$personeel[voornaam]."</option>
				");
			}
			
			print("</select>
			");
		}
		else print("Geen personeel gevonden!");
		
		mysqli_free_result($r_personeel);
	}

	function uitvoerderniveau($x)
	{
		switch($x)
		{
			case 1: return "Admin - Beheerder"; break;
			case 2: return "CPA: Coˆrdinerend preventie adviseur"; break;
			case 3: return "School"; break;
			case 4: return "Campus"; break;
			case 5: return "Specifieke locatie"; break;
		}
	}
	
	function print_categorie($link,$id)
	{
		$q_categorie="select * from keuring_".$_SESSION['hfst']."categorie where id='".mysqli_real_escape_string($link,$id)."'";
		$r_categorie=mysqli_query($link,$q_categorie);
		if(mysqli_num_rows($r_categorie)>"0")
		{
			$categorie=mysqli_fetch_array($r_categorie);
			return $categorie[naam];
		}
		else return "Geen";		
	}
	
	
	function test_checkbox($info)
	{
		if($info=="1") return "1";
		else return "0";
	}
	
	//testen op speciale tekens zoals &
	function controle_xml($tekst)
	{
		if(is_integer(strpos($tekst,"&nbsp;"))) $tekst=str_replace("&nbsp;","",$tekst);
		if(is_integer(strpos($tekst,"&bull;"))) $tekst=str_replace("&bull;","*",$tekst);
		if(is_integer(strpos($tekst,"&euml;"))) $tekst=str_replace("&euml;","√´",$tekst);
		if(is_integer(strpos($tekst,"&iuml;"))) $tekst=str_replace("&iuml;","√Ø",$tekst);
		if(is_integer(strpos($tekst,"&eacute;"))) $tekst=str_replace("&eacute;","√©",$tekst);
		if(is_integer(strpos($tekst,"&ldquo;"))) $tekst=str_replace("&ldquo;","‚Äú",$tekst);
		if(is_integer(strpos($tekst,"&rdquo;"))) $tekst=str_replace("&rdquo;","‚Äù",$tekst);
		if(is_integer(strpos($tekst,"&lsquo;"))) $tekst=str_replace("&lsquo;","‚Äò",$tekst);
		if(is_integer(strpos($tekst,"&rsquo;"))) $tekst=str_replace("&rsquo;","‚Äô",$tekst);
		if(is_integer(strpos($tekst,"&ndash;"))) $tekst=str_replace("&ndash;",":",$tekst);
		if(is_integer(strpos($tekst,"&euro;"))) $tekst=str_replace("&euro;","‚Ç¨",$tekst);
		if(is_integer(strpos($tekst,"√∂"))) $tekst=str_replace("√∂","o",$tekst);
		if(is_integer(strpos($tekst,"&hellip;"))) $tekst=str_replace("&hellip;","‚Ä¶",$tekst);
		if(is_integer(strpos($tekst,"&quot;"))) $tekst=str_replace("&quot;","‚Äú",$tekst);
		if(is_integer(strpos($tekst,"<ul>"))) $tekst=str_replace("<ul>","",$tekst);
		if(is_integer(strpos($tekst,"</ul>"))) $tekst=str_replace("</ul>","",$tekst);
		if(is_integer(strpos($tekst,"&"))) $tekst=str_replace("&","&amp;",$tekst);
		if(is_integer(strpos($tekst,"&amp;amp;"))) $tekst=str_replace("&amp;amp;","&amp;",$tekst);
		if(is_integer(strpos($tekst,"&amp;lt;"))) $tekst=str_replace("&amp;lt;","&lt;",$tekst);
		if(is_integer(strpos($tekst,"&amp;gt;"))) $tekst=str_replace("&amp;gt;","&gt;",$tekst);
		if(is_integer(strpos($tekst,"<br>"))) $tekst=str_replace("<br>","</w:t></w:r></w:p><w:p/><w:p><w:r><w:t>",$tekst);
		if(is_integer(strpos($tekst,"<br />"))) $tekst=str_replace("<br />","</w:t></w:r></w:p><w:p/><w:p><w:r><w:t>",$tekst);
		//if(is_integer(strpos($tekst,""))) $tekst=str_replace("","",$tekst);
		if(is_integer(strpos($tekst,"<strong>"))) $tekst=vervang_opm("<strong>","</strong>","<w:b/>",$tekst);
		if(is_integer(strpos($tekst,"<b>"))) $tekst=vervang_opm("<b>","</b>","<w:b/>",$tekst);
		if(is_integer(strpos($tekst,"<i>"))) $tekst=vervang_opm("<i>","</i>","<w:i/>",$tekst);
		if(is_integer(strpos($tekst,"<em>"))) $tekst=vervang_opm("<em>","</em>","<w:i/>",$tekst);
		if(is_integer(strpos($tekst,"<u>"))) $tekst=vervang_opm("<u>","</u>","<w:u/>",$tekst);
		if(is_integer(strpos($tekst,"<li>"))) $tekst=str_replace("<w:r><w:t><li>","<w:pPr><w:listPr><w:ilvl w:val=\"0\"/><w:ilfo w:val=\"3\"/><wx:t wx:val=\"¬∑\" wx:wTabBefore=\"360\" wx:wTabAfter=\"240\"/><wx:font wx:val=\"Symbol\"/></w:listPr></w:pPr><w:r><w:t>",$tekst);
		
		//li wanneer deze niet automatisch op een nieuwe lijn start
		if(is_integer(strpos($tekst,"<li>"))) $tekst=str_replace("<li>","</w:t></w:r></w:p><w:p><w:pPr><w:listPr><w:ilvl w:val=\"0\"/><w:ilfo w:val=\"3\"/><wx:t wx:val=\"¬∑\" wx:wTabBefore=\"360\" wx:wTabAfter=\"240\"/><wx:font wx:val=\"Symbol\"/></w:listPr></w:pPr><w:r><w:t>",$tekst);
		
	
		if(is_integer(strpos($tekst,"</li>"))) $tekst=str_replace("</li>","",$tekst);
	
		return $tekst;
	}
	
	function print_aanvrager($link,$id)
	{
		$q_aanvrager="select naam from agora_login where id='".mysqli_real_escape_string($link,$id)."' limit 1";
		$r_aanvrager=mysqli_query($link,$q_aanvrager);
		if(mysqli_num_rows($r_aanvrager)=="1")
		{
			$aanvrager=mysqli_fetch_array($r_aanvrager);
			return $aanvrager[naam];
		}
		else return ("Niet gevonden");
	}
	
	function email_login($link,$id)
	{
		$q_aanvrager="select email from agora_login where id='".mysqli_real_escape_string($link,$id)."' limit 1";
		//print($q_aanvrager."<br />");
		$r_aanvrager=mysqli_query($link,$q_aanvrager);
		if(mysqli_num_rows($r_aanvrager)=="1")
		{
			$aanvrager=mysqli_fetch_array($r_aanvrager);
			return $aanvrager[email];
		}
		else return ("Niet gevonden");
	}
	
	function email_personeelslid($link_school,$id)
	{
		//$q_aanvrager="select email from agora_personeel where id='".mysqli_real_escape_string($link_school,$id)."' limit 1";
		$q_aanvrager="select email from agora_personeel where id='".$id."' limit 1";
	//	print($q_aanvrager."<br />");
		$r_aanvrager=mysqli_query($link_school,$q_aanvrager);
		if(mysqli_num_rows($r_aanvrager)=="1")
		{
			$aanvrager=mysqli_fetch_array($r_aanvrager);
			return $aanvrager[email];
		}
		else return ("0");
	}
	
	function alfabet($naam)
	{
		//print("<textarea>".$naam."</textarea><br />");
		if(strlen($naam)>"0")
		{
			//$convmap = array(0x80, 0xff, 0, 0xff);
			//$naam = mb_encode_numericentity($naam, $convmap, "ISO-8859-1");


			//$naam=utf8_decode($naam);
			
					
			$naam=str_replace("È","e",$naam);
    		$naam=str_replace("Î","e",$naam);
    		$naam=str_replace("Ë","e",$naam);
    		$naam=str_replace("Ô","i",$naam);
    		$naam=str_replace("Á","c",$naam);
    		$naam=str_replace("‡","a",$naam);
    		$naam=str_replace("ˆ","o",$naam);
    		$naam=str_replace("¸","u",$naam);
    		$naam=str_replace("/","-",$naam);
    		//$naam=str_replace("0","nul",$naam);
			
			//print($naam);
			$naam=trim($naam);
			$arr1 = str_split($naam);
			$naam2="";
			foreach ($arr1 as $value) 
			{
				//komt value voor in deze string
	    						
				$controle="*abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ123456789-_. @";
	    		
				if($value=="  ") $value="_";
				$pos="0";
				if(trim($value)!=FALSE) $pos=strpos($controle,$value);
				if(($pos!=FALSE) or ($value=="0")) $naam2.=$value;
				//else print($value);
				//else print("<textarea>".$value."</textarea><br />");
			}		
			return $naam2;
			
			
			//return $naam;
		}
		else return "Geen input";
	}
	
	function cijfersenletters($string)
	{
		// Strip HTML Tags
		$clear = strip_tags($string);
		// Clean up things like &amp;
		$clear = html_entity_decode($clear);
		// Strip out any url-encoded stuff
		$clear = urldecode($clear);
		// Replace non-AlNum characters with space
		$clear = preg_replace('/[^A-Za-z0-9]/', ' ', $clear);
		// Replace Multiple spaces with single space
		$clear = preg_replace('/ +/', ' ', $clear);
		// Trim the string of leading/trailing space
		$clear = trim($clear);
		
		return $clear;
	}
	
	function aantal_archief($link,$id)
	{
		$q_archief="select count(id) as aantal from keuring_dossiers_historiek where dossier_id='".$id."'";
		$r_archief=mysqli_query($link,$q_archief);
		$archief=mysqli_fetch_array($r_archief);
		return $archief[aantal];
	}
	
	function print_laatste_nieuws($link,$deel,$aantal)
	{
		//overzicht nieuwsberichten
		
		$q_nieuws="select * from agora_nieuws where titel like '".$deel."%' order by datum desc limit ".$aantal;
		$r_nieuws=mysqli_query($link,$q_nieuws);
		
		print("<h2>Laatste Nieuws</h2><br />");
		
		if(mysqli_num_rows($r_nieuws)>"0")
		{
			print("<table id=dataTable><thead><tr><td>Datum</td><td>Titel</td><td>Actie</td></tr></thead><tbody>");
			
			while($nieuws=mysqli_fetch_array($r_nieuws))
			{
				print("<tr onClick=\"leesNieuws('".$nieuws[id]."');\"><td>".$nieuws[datum]."</td><td>".$nieuws[titel]."</td><td><a href='#'>Lees meer</a></td></tr>");
			}
			
			print("</tbody></table>");
		}
		else print("Geen nieuwsberichten gevonden!");
	}
	
	function laatste_nieuws_titels($link,$deel,$aantal)
	{
		$q_nieuws="select * from agora_nieuws where titel like '".$deel."%' order by datum desc limit ".$aantal;
		$r_nieuws=mysqli_query($link,$q_nieuws);
		
		print("<h2>Laatste nieuwsberichten</h2><br />");
		
		if(mysqli_num_rows($r_nieuws)>"0")
		{
			print("<table id=dataTable><tbody>");
			
			while($nieuws=mysqli_fetch_array($r_nieuws))
			{
				print("<tr onClick=\"leesNieuws('".$nieuws[id]."');\"><td><a href='javascript:void(0);'>* ".$nieuws[titel]."</a></td></tr>");
			}
			
			print("</tbody></table>");
		}
		else print("Geen nieuwsberichten gevonden!");
	}
	
	function weergave_scholengemeenschap($link,$id)
	{
		$q_sg="select * from agora_scholengemeenschap where id='".$id."'";
		$r_sg=mysqli_query($link,$q_sg);
		if(mysqli_num_rows($r_sg)=="1")
		{
			$sg=mysqli_fetch_array($r_sg);
			return $sg[naam];
		}
		else return "Geen SG";
	}
	
	function print_form_schoolgegevens($link,$school_id)
	{
		$q_school="select * from agora_scholen where id='".$school_id."'";
		$r_school=mysqli_query($link,$q_school);
		$school=mysqli_fetch_array($r_school);
		
		//gegevens hoofdcampus opzoeken
		$q_campus="select * from agora_campus where school_id='".$school_id."' and aard='hoofdcampus' limit 1";
		$r_campus=mysqli_query($link,$q_campus);
		if(mysqli_num_rows($r_campus)=="1")
		{
			$campus=mysqli_fetch_array($r_campus);
			$_SESSION[hoofdcampus]=$campus[id];
			//print($_SESSION[hoofdcampus]."<br />");
		}
		else $campus=array();
		
		
		/*print("<div style='border:1px solid red'>Onderstaande informatie verdwijnt binnenkort....<br /><br />		<table>
		<tr><td class='form_titel'><u>Gegevens schoolbestuur</u></td></tr>
		<tr><td class='form_titel'>Naam</td><td class=form_veld><input type=text name='naam_bestuur' value='".stripslashes($school[naam_bestuur])."' size='50'></td></tr>
		
		<tr><td class='form_titel'>Straat, nr (bus)</td><td class=form_veld> <input type=text name='straat_bestuur' value='".stripslashes($school[straat_bestuur])."' size='50'></td></tr>
		<tr><td class='form_titel'>Postcode</td><td class=form_veld><input type=text name='postcode_bestuur' value='".stripslashes($school[postcode_bestuur])."' size='50'></td></tr>
		<tr><td class='form_titel'>Gemeente</td><td class=form_veld><input type=text name='plaats_bestuur' value='".stripslashes($school[plaats_bestuur])."' size='50'></td></tr>
		</td></tr>
		<tr><td class='form_titel'>Email</td><td class=form_veld><input type=text name='email_bestuur' value='".stripslashes($school[email_bestuur])."' size='50'></td></tr>
		</table>
		</div>");*/
		
		print("
		<br /><br />
		<table width='100%'>
		<tr><td class='form_titel'><u>Schoolbestuur:</u></td><td class=form_veld><nobr><select name='id_schoolbestuur'> 
		");
		
		$q_bestuur="select * from agora_schoolbestuur where id_scholengemeenschap='".$_SESSION[scholengemeenschap]."' order by naam";
		$r_bestuur=mysqli_query($link,$q_bestuur);
		if(mysqli_num_rows($r_bestuur)>"0")
		{
			while($bestuur=mysqli_fetch_array($r_bestuur))
			{
				print("<option value='".$bestuur[id]."' ");if($bestuur[id]==$school[id_schoolbestuur]) print(" SELECTED "); print(">".$bestuur[naam]."</option>");
			}
		}
		
		print(utf8_encode("
		</select>*</nobr></td></tr>
		<tr><td colspan='2'> &nbsp; </td></tr>
		<tr><td class='form_titel'><u>Gegevens school</u></td></tr>	
		<tr><td class='form_titel'>Naam school</td><td class=form_veld><input type=text name='naam_school' value='".stripslashes($campus[naam])."' size='50'></td></tr>
		<tr><td class='form_titel'>Straat, nr (bus)</td><td class=form_veld><input type=text name='straat_school' value='".stripslashes($campus[adres])."' size='50'></td></tr>
		<tr><td class='form_titel'>Postcode</td><td class=form_veld><input type=text name='postcode_school' value='".stripslashes($campus[postcode])."' size='50'></td></tr>
		<tr><td class='form_titel'>Plaats</td><td class=form_veld><input type=text name='plaats_school' value='".stripslashes($campus[plaats])."' size='50'></td></tr>
		
		<tr><td class='form_titel'>Naam directie (voorzitter comitÈ)</td><td class=form_veld><input type=text name='naam_directie' value='".stripslashes($school[naam_directie])."' size='50'></td></tr>
		<tr><td class='form_titel'>Email directie (voorzitter comitÈ)</td><td class=form_veld><input type=text name='email_directie' value='".stripslashes($school[email_directie])."' size='50'></td></tr>
		<tr><td class='form_titel'>Telefoon</td><td class=form_veld><input type=text name='tel_school' value='".stripslashes($campus[telefoon])."' size='50'></td></tr>
		<tr><td class='form_titel'>Fax</td><td class=form_veld><input type=text name='fax_school' value='".stripslashes($campus[fax])."' size='50'></td></tr>
		<tr><td class='form_titel'>Website school</td><td class=form_veld><input type=text name='website' value='".stripslashes($school[website])."' size='50'></td></tr>
		<tr><td class='form_titel'>E-mail school</td><td class=form_veld><input type=text name='email_school' value='".stripslashes($campus[email])."' size='50'></td></tr>
		<tr><td class='form_titel'>Ondernemingsnummer (KBO)</td><td class=form_veld><input type=text name='kbo_nr' value='".stripslashes($school[kbo_nr])."' size='50'></td></tr>
		<tr><td class='form_titel'>Vestigingseenheidnummer</td><td class=form_veld><input type=text name='vestigingseenheidnummer' value='".stripslashes($school[vestigingseenheidnummer])."' size='50'></td></tr>
		
		<tr><td class='form_titel'>RSZ ñ nummer</td><td class=form_veld><input type=text name='rsz' value='".stripslashes($school[rsz])."' size='50'></td></tr>
		<tr><td class='form_titel'>NACE-BEL code</td><td class=form_veld><input type=text name='nacebel' value='".stripslashes($school[nacebel])."' size='50'></td></tr>
	
		<tr><td colspan='2'> &nbsp; </td></tr>
		
		<tr><td class='form_titel'>Onderwijsvorm prebesrichtlijn</td><td class=form_veld>
			<select name='onderwijsvorm'>"));
			
		if($school[onderwijsvorm]=="")	print("<option value=''>Verplichte keuze</option>");
		
		print(" <option value='A' ");if($school[onderwijsvorm]=="A")print(" SELECTED "); print(">BSO/TSO/BuSO (nijverheid,voeding)</option> 
				<option value='B' ");if($school[onderwijsvorm]=="B")print(" SELECTED "); print(">BSO/TSO/BuSO (overige), KSO</option> 
				<option value='C' ");if($school[onderwijsvorm]=="C")print(" SELECTED "); print(">ASO/BuBaO </option> 
				<option value='D' ");if($school[onderwijsvorm]=="D")print(" SELECTED "); print(">BaO</option> 
			</select>
		</td></tr>
		<tr><td class='form_titel'>Aantal lestijden</td><td class=form_veld><input type=text name='lestijden' value='".stripslashes($school[lestijden])."' size='50'></td></tr>
		<tr><td class='form_titel'>Aantal leerlingen Basisonderwijs:</td><td class=form_veld><input type=text name='aantal_llbo' value='".stripslashes($school[aantal_llbo])."' size='50'></td></tr>
		<tr><td class='form_titel'>Aantal leerlingen Secundair onderwijs</td><td class=form_veld><input type=text name='aantal_llso' value='".stripslashes($school[aantal_llso])."' size='50'></td></tr>
		<tr><td class='form_titel'>Aantal leerlingen Volwassenenonderwijs</td><td class=form_veld><input type=text name='aantal_llvo' value='".stripslashes($school[aantal_llvo])."' size='50'></td></tr>
		<tr><td class='form_titel'>Totaal aantal leerlingen </td><td class=form_veld>".stripslashes($school[aantal_ll])."</td></tr>
		<tr><td class='form_titel'>Aantal leerkrachten</td><td class=form_veld><input type=text name='aantal_lkt' value='".stripslashes($school[aantal_lkt])."' size='50'></td></tr>
		<tr><td class='form_titel'>Aantal pers omkadering</td><td class=form_veld><input type=text name='aantal_pers_omkadering' value='".stripslashes($school[aantal_pers_omkadering])."' size='50'></td></tr>
		<tr><td class='form_titel'>Aantal arbeiders</td><td class=form_veld><input type=text name='aantal_arbeiders' value='".stripslashes($school[aantal_arbeiders])."' size='50'></td></tr>
		<tr><td class='form_titel'>Totaal aantal werknemers</td><td class=form_veld><input type=text name='totaal_werknemers' value='".stripslashes($school[totaal_werknemers])."' size='50'></td></tr>
		<tr><td colspan='2'> &nbsp; </td></tr>
		<tr><td class='form_titel'><u>Gegevens EDPBW</u></td></tr>	
		
		
		<tr><td class='form_titel'>Naam:</td><td class=form_veld>");
		
		print_select_uitvoerder($link,"id_EDPBW","EDPBW",$school[id_EDPBW]);
		
		print("</td></tr>
		<tr><td class='form_titel'>Aansluitingsnummer</td><td class=form_veld><input type=text name='EDPBW' value='".stripslashes($school[EDPBW])."' size='50'></td></tr>
		<tr><td colspan='2'> &nbsp; </td></tr>
		<tr><td class='form_titel'><u> Informatie noodzakelijk voor ReBOS: </td></tr>
		<tr><td class='form_titel'>Rekeningnummer:</td><td class=form_veld><input type='text' id='rekeningnr' name='rekeningnr' value='".$school[rekeningnr]."' size='50'></td></tr>
		<tr><td class='form_titel'>Aard van de administratie:</td><td class=form_veld><input type='text' id='aardadministratie' name='aardadministratie' value='".$school[aardadministratie]."' size='50'></td></tr>
		<tr><td class='form_titel'>Werkstation:</td><td class=form_veld><input type='text' id='werkstation' name='werkstation' value='".$school[werkstation]."' size='50'></td></tr>
		<tr><td class='form_titel'>Verzekeringsmaatschappij leerlingenongevallen:</td><td class=form_veld><input type='text' id='verzekeringlln' name='verzekeringlln' value='".$school[verzekeringlln]."' size='50'></td></tr>
		<tr><td class='form_titel'>Polisnummer:</td><td class=form_veld><input type='text' id='verzekeringllnpolisnr' name='verzekeringllnpolisnr' value='".$school[verzekeringllnpolisnr]."' size='50'></td></tr>
		<tr><td class='form_titel'>Verzekeringsmaatschappij arbeidsongevallen contractueel personeel:</td><td class=form_veld><input type='text' id='verzekeringcontractueel' name='verzekeringcontractueel' value='".$school[verzekeringcontractueel]."' size='50'></td></tr>
		<tr><td class='form_titel'>Polisnummer:</td><td class=form_veld><input type='text' id='verzekeringcontractueelpolisnr' name='verzekeringcontractueelpolisnr' value='".$school[verzekeringcontractueelpolisnr]."' size='50'></td></tr>
		<tr><td class='form_titel'>Bijkomende onderverdeling polisnummer:</td><td class=form_veld><input type='text' id='verzekeringcontractueelpolisextra' name='verzekeringcontractueelpolisextra' value='".$school[verzekeringcontractueelpolisextra]."' size='50'></td></tr>
		<tr><td class='form_titel'>Verzekeringsmaatschappij stageongevallen:</td><td class=form_veld>Zelfde als contractueel personeel</td></tr>
		<tr><td class='form_titel'>Polisnummer:</td><td class=form_veld><input type='text' id='verzekeringstagepolisnr' name='verzekeringstagepolisnr' value='".$school[verzekeringstagepolisnr]."' size='50'></td></tr>
		<tr><td class='form_titel'>Bijkomende onderverdeling polisnummer:</td><td class=form_veld><input type='text' id='verzekeringstagepolisextra' name='verzekeringstagepolisextra' value='".$school[verzekeringstagepolisextra]."' size='50'></td></tr>
		<tr><td colspan='2'> &nbsp; </td></tr>
		<tr><td><u> Automatische mailing bij wijzigingen naar: </td></tr>
		<tr><td class='form_titel'>Schoolbestuur</td><td class=form_veld><input type=checkbox name='auto_mail_bestuur' value='1' "); if($school[auto_mail_bestuur]=="1") print(" CHECKED ");print(utf8_encode("></td></tr>
		
		<tr><td class='form_titel'>Voorzitter comitÈ</td><td class=form_veld><input type=checkbox name='auto_mail_directie' value='1' ")); if($school[auto_mail_directie]=="1") print(" CHECKED ");print("></td></tr>
		<tr><td class='form_titel'>CPA</td><td class=form_veld><input type=checkbox name='auto_mail_cpa' value='1' "); if($school[auto_mail_cpa]=="1") print(" CHECKED ");print("></td></tr>
		<tr><td colspan='2'> &nbsp; </td></tr>
		<tr><td colspan='2' align=center><input type=submit value='Wijzigingen opslaan'></td></tr>
		</table>");
	}
	
	//function update_schoolgegevens($link,$_POST,$school_id)
	function update_schoolgegevens($link,$post,$school_id)
	{
		$aantal_ll=intval($_POST[aantal_llbo])+intval($_POST[aantal_llso])+intval($_POST[aantal_llvo]);
		
		$q_update="update agora_scholen set 
			id_schoolbestuur='".mysqli_real_escape_string($link,$_POST[id_schoolbestuur])."',
			naam_directie='".mysqli_real_escape_string($link,$_POST[naam_directie])."',
			email_directie='".mysqli_real_escape_string($link,$_POST[email_directie])."',
			email_school='".mysqli_real_escape_string($link,$_POST[email_school])."',
			kbo_nr='".mysqli_real_escape_string($link,$_POST[kbo_nr])."',
			vestigingseenheidnummer='".mysqli_real_escape_string($link,$_POST[vestigingseenheidnummer])."',
			rsz='".mysqli_real_escape_string($link,$_POST[rsz])."',
			nacebel='".mysqli_real_escape_string($link,$_POST[nacebel])."',
			website='".mysqli_real_escape_string($link,$_POST[website])."',
			onderwijsvorm='".mysqli_real_escape_string($link,$_POST[onderwijsvorm])."',
			lestijden='".mysqli_real_escape_string($link,$_POST[lestijden])."',
			aantal_ll='".$aantal_ll."',
			aantal_llbo='".mysqli_real_escape_string($link,$_POST[aantal_llbo])."',
			aantal_llso='".mysqli_real_escape_string($link,$_POST[aantal_llso])."',
			aantal_llvo='".mysqli_real_escape_string($link,$_POST[aantal_llvo])."',
			aantal_lkt='".mysqli_real_escape_string($link,$_POST[aantal_lkt])."',
			aantal_pers_omkadering='".mysqli_real_escape_string($link,$_POST[aantal_pers_omkadering])."',
			aantal_arbeiders='".mysqli_real_escape_string($link,$_POST[aantal_arbeiders])."',
			totaal_werknemers='".mysqli_real_escape_string($link,$_POST[totaal_werknemers])."',
			naam_EDPBW='".mysqli_real_escape_string($link,$_POST[naam_EDPBW])."',
			id_EDPBW='".mysqli_real_escape_string($link,$_POST[id_EDPBW])."',
			EDPBW='".mysqli_real_escape_string($link,$_POST[EDPBW])."',
			auto_mail_bestuur='".mysqli_real_escape_string($link,$_POST[auto_mail_bestuur])."',
			auto_mail_directie='".mysqli_real_escape_string($link,$_POST[auto_mail_directie])."',
			auto_mail_cpa='".mysqli_real_escape_string($link,$_POST[auto_mail_cpa])."',
			rekeningnr='".mysqli_real_escape_string($link,$_POST[rekeningnr])."',
			aardadministratie='".mysqli_real_escape_string($link,$_POST[aardadministratie])."',
			werkstation='".mysqli_real_escape_string($link,$_POST[werkstation])."',
			adresedpbw='".mysqli_real_escape_string($link,$_POST[adresedpbw])."',
			postcodeedpbw='".mysqli_real_escape_string($link,$_POST[postcodeedpbw])."',
			gemeenteedpbw='".mysqli_real_escape_string($link,$_POST[gemeenteedpbw])."',
			verzekeringlln='".mysqli_real_escape_string($link,$_POST[verzekeringlln])."',
			verzekeringllnpolisnr='".mysqli_real_escape_string($link,$_POST[verzekeringllnpolisnr])."',
			verzekeringcontractueel='".mysqli_real_escape_string($link,$_POST[verzekeringcontractueel])."',
			verzekeringcontractueelpolisnr='".mysqli_real_escape_string($link,$_POST[verzekeringcontractueelpolisnr])."',
			verzekeringcontractueelpolisextra='".mysqli_real_escape_string($link,$_POST[verzekeringcontractueelpolisextra])."',
			verzekeringstage='".mysqli_real_escape_string($link,$_POST[verzekeringcontractueel])."',
			verzekeringstagepolisnr='".mysqli_real_escape_string($link,$_POST[verzekeringstagepolisnr])."',
			verzekeringstagepolisextra='".mysqli_real_escape_string($link,$_POST[verzekeringstagepolisextra])."'
			where id='".$school_id."'";
			
		//print($q_update."<br />");
		print("<br /><br /><br /><br /><center><h2>");
		$r_update=mysqli_query($link,$q_update);
		if($r_update) 
		{
			
			if($_SESSION[hoofdcampus]!="")
			{
			//update hoofdcampus
			$q_edit2="UPDATE agora_campus SET 
			`naam` ='".mysqli_real_escape_string($link,$_POST[naam_school])."',
			`adres` ='".mysqli_real_escape_string($link,$_POST[straat_school])."',
			`postcode` ='".mysqli_real_escape_string($link,$_POST[postcode_school])."',
			`plaats` ='".mysqli_real_escape_string($link,$_POST[plaats_school])."',
			`telefoon` ='".mysqli_real_escape_string($link,$_POST[tel_school])."',
			`fax` ='".mysqli_real_escape_string($link,$_POST[fax_school])."',
			email='".mysqli_real_escape_string($link,$_POST[email_school])."'
			where id='".$_SESSION[hoofdcampus]."'";
			
			$r_edit2=mysqli_query($link,$q_edit2);
			//print($q_edit2);
			}
			else print("<font color='red'>Schoolgegevens niet volledig gewijzigd. Enkele onderdelen zal u kunnen wijzigen bij het onderdeel campus! Onze excuses voor het ongemak.</font>");
			
			if($_SESSION[school_id]!="")
			{
				//nieuwe datum +1j
				$nieuwe_datum=date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")+1));
				
				print("<font color=green>Schoolgegevens met succes gewijzigd!!</font><br />");
				$q_update_identificatie="update agora_rechten set identificatie='".$nieuwe_datum."' where id_login='".$_SESSION[user_id]."' and id_school='".$_SESSION[school_id]."'";
				//print($q_update_identificatie."<br />");
				$r_update_identificatie=mysqli_query($link,$q_update_identificatie);
				if($r_update_identificatie) $_SESSION[identificatie]=$nieuwe_datum;
			}
		}
		else print("<font color=red>Schoolgegevens NIET opgeslagen!</font><br />");
		print("</center></h2>");
	}
	
	function print_reboscode($link,$id)
	{
		$q_rebos="select * from rebos_codes where id='".$id."'";
		$r_rebos=mysqli_query($link,$q_rebos);
		if(mysqli_num_rows($r_rebos)=="1")
		{
			$rebos=mysqli_fetch_array($r_rebos);
			
			return $rebos[naam];
		}
	}
	
	function personeel_bevoegd($link_school,$id)
	{
		$q_select="select * from agora_personeel where id='".$id."' and actief='1' limit 1";
		//print($q_select);
		$r_select=mysqli_query($link_school,$q_select);
		if(mysqli_num_rows($r_select)=="1")
		{
			$select=mysqli_fetch_array($r_select);
			if($select[bevoegd_persoon]=="1") return true;
			else return false;
		}
		else return false;
	}
	
	function print_keuring_standaard($link,$hoofdstuk,$id)
	{
		$q_select="select * from keuring_".$hoofdstuk."item where id='".$id."' limit 1";
		$r_select=mysqli_query($link,$q_select);
		if(mysqli_num_rows($r_select))
		{
			$select=mysqli_fetch_array($r_select);
			return $select[naam];
		}
		else return "FOUT: Niet gevonden";
	}
	
	function print_campus_naam($link,$id)
	{
		$q_select="select * from agora_campus where id='".$id."'";
		$r_select=mysqli_query($link,$q_select);
		if(mysqli_num_rows($r_select))
		{
			$select=mysqli_fetch_array($r_select);
			return $select[naam];
		}
		else return "FOUT: Niet gevonden";
	}
	
	function print_locatie_naam($link,$id)
	{
		if($id!="0")
		{
			$q_select="select naam,omschrijving from agora_locatie where id='".$id."'";
			$r_select=mysqli_query($link,$q_select);
			if(mysqli_num_rows($r_select))
			{
				$select=mysqli_fetch_array($r_select);
				return "<nobr>".$select[naam].": ".$select[omschrijving]."</nobr>";
			}
			else return "FOUT";
		}
		else return "GEEN";
	}
	
	function print_gebruiker_naam($link,$id)
	{
		$q_select="select naam from agora_login where id='".$id."'";
		$r_select=mysqli_query($link,$q_select);
		if(mysqli_num_rows($r_select))
		{
			$select=mysqli_fetch_array($r_select);
			return $select[naam];
		}
		else return "FOUT: Niet gevonden";
	}
	
	function aantal_taken($link,$id,$deel,$hfst)
	{
		$a="0";
		
		$q_taken="select * from agora_taken where id_referentie='".$id."' and onderdeel='".$deel."' and hoofdstuk='".$hfst."'";
		//print($q_taken."<br />");
		$r_taken=mysqli_query($link,$q_taken);
		$a=mysqli_num_rows($r_taken);
		mysqli_free_result($r_taken);
				
		return $a;
	}
	
	function aantal_taken_opgelost($link,$id,$deel,$hfst)
	{
		$a="0";
			
		$q_taken_opgelost="select * from agora_taken where id_referentie='".$id."' and onderdeel='".$deel."' and hoofdstuk='".$hfst."' and datum_stop!='0000-00-00'";
		//print($q_taken."<br />");
		$r_taken_opgelost=mysqli_query($link,$q_taken_opgelost);
		$a=mysqli_num_rows($r_taken_opgelost);
		mysqli_free_result($r_taken_opgelost);
		
		return $a;
	}
	
	function resize_image($image,$max,$ext)
	{
		$gd=imagecreatefromstring($image);
		
		//zoek huidige afmetingen
		$width=imagesx($gd);
		$height=imagesy($gd);
		
		if(($width<=$max) and ($height<=$max))
		{
			return false;
		}
		else
		{
			if($width>$height)
			{
				$factor=$max/$width;
			}
			else
			{
				$factor=$max/$height;
			}
			
			//print("factor:".$factor);
			
			$new_width=$width*$factor;
			$new_height=$height*$factor;
			
			$resized=imagecreatetruecolor($new_width,$new_height);
			
			if(imagecopyresampled($resized,$gd,0,0,0,0,$new_width,$new_height,$width,$height)) 
			{
				//print("Resample gelukt!");
				
				if($ext=="jpg") imagejpeg($resized,'test.'.$ext,'100');
				elseif($ext=="jpeg") imagejpeg($resized,'test.'.$ext,'100');
				elseif($ext=="png") imagepng($resized,'test.'.$ext,'100');
				elseif($ext=="gif") imagegif($resized,'test.'.$ext,'100');
				
				imagedestroy($resized);
				
				$fp=fopen("test.".$ext,"rb");
				$content=fread($fp,filesize("test.".$ext));
				fclose($fp);
				
				
				//print($content." - ".filesize("test.".$ext)."-".sizeof($content));	
				unlink("test.".$ext);		
				return $content;
			}
			else 
			{
				//print("Resample mislukt!");
				return false;
			}
			//print("factor:".$factor." oud:".$width."/".$height." Nieuw:".$new_width."/".$new_height);
			
			imagedestroy($resized);
		}
	}
	
	function aantal_campus($link)
	{
		$q_aantal="select count(id) as campus from agora_campus where school_id='".$_SESSION[school_id]."'";
		$r_aantal=mysqli_query($link,$q_aantal);
		$aantal=mysqli_fetch_array($r_aantal);
		
		return $aantal[campus];
	}

	function print_uitvoerder_kort($link,$link_school,$uitvoerder,$aard)
	{
	 	if($uitvoerder!="999999999")
	 	{
			if($aard=="personeel") 
			{
			 	$q_select="select * from agora_personeel where id='".$uitvoerder."' and actief='1' limit 1";
			 	pq($q_select."<br />");
				$r_select=mysqli_query($link_school,$q_select);
			}
			else 
			{
				$q_select="select * from keuring_uitvoerders where id='".$uitvoerder."' and actief='1' limit 1";
				pq($q_select."<br />");
				$r_select=mysqli_query($link,$q_select);
			}
			
			pq($q_select."<br />");
			$select=mysqli_fetch_array($r_select);
			
			mysqli_free_result($r_select);
			
			if($select[actief]=="1") $actief="";
			else $actief="<font color=red>Inactief</font>";
			
			if($select[naam]=="") return "Nog niet geselecteerd";
			else
			{
				if($aard=="personeel") return $select[naam]." ".$select[voornaam];
				else return $select[naam]." ".$select[voornaam];
			}
		}
		else return "Agora Server (automatisch)";
	}
	
	function print_uitvoerder_kort_cpa($link,$id_school,$uitvoerder,$aard)
	{
		//school simuleren
		if(($_SESSION[school_id]=="0") and ($aard=="personeel") and ($id_school>"0"))
		{
			$_SESSION[school_id]=$id_school;
			include("dbi_school.php");
			$_SESSION[school_id]="0";
		}
		//met de schoollink gegevens ophalen uit databank
		$hulp=print_uitvoerder_kort($link,$link_school,$uitvoerder,$aard);
		
		//link met school breken
		mysqli_close($link_school); //test
		
		//data terug sturen
		return $hulp;
	}
	
	function print_select_locatie($link,$hulp,$id_locatie)
	{
		$q_locatie="select * from agora_locatie where campus_id='".$_SESSION[campus_id]."' and actief='1' order by naam";
		//print($q_locatie."<br />");
		$r_locatie=mysqli_query($link,$q_locatie);
		if(mysqli_num_rows($r_locatie)>"0")
		{
			print("<select name='".$hulp."'>
			");
			
			while($locatie=mysqli_fetch_array($r_locatie))
			{
				print("<option value='".$locatie[id]."' ");
				if($locatie[id]==$id_locatie) print(" SELECTED ");
				print(">".$locatie[naam].": ".$locatie[omschrijving]."</option>
				");
			}
			
			print("</select>
			");
		}
		else print("Geen lokalen gevonden!");
		
		mysqli_free_result($r_locatie);
	}
	
	function print_select_locatie_school($link,$hulp,$id_locatie,$id_school,$id_campus)
	{
		if($id_campus>"0") $q_locatie="select * from agora_locatie where campus_id='".$id_campus."' and actief='1' order by naam";
		else $q_locatie="select t1.*,t2.naam as campus from agora_locatie as t1 left join agora_campus as t2 on t1.campus_id=t2.id where t2.school_id='".$id_school."' and t2.actief='1' and t1.actief='1' order by t1.naam"; 
		//SELECT t1. * , t2.naam AS campus FROM agora_locatie AS t1 INNER JOIN agora_campus AS t2 ON t1.campus_id = t2.id WHERE t2.school_id =  '1' AND t2.actief =  '1' ORDER BY t1.naam
		//print($q_locatie."<br />");
		$r_locatie=mysqli_query($link,$q_locatie);
		if(mysqli_num_rows($r_locatie)>"0")
		{
			print("<select name='".$hulp."'>
			");
			
			while($locatie=mysqli_fetch_array($r_locatie))
			{
				print("<option value='".$locatie[id]."' ");
				if($locatie[id]==$id_locatie) print(" SELECTED ");
				print(">".$locatie[naam].": ".$locatie[omschrijving]);
				if($id_campus=="0") print(" (".$locatie[campus].")");
				print("</option>
				");
			}
			
			print("</select>
			");
		}
		else print("Geen lokalen gevonden!");
		
		mysqli_free_result($r_locatie);
	}
	
	function resize_image2($type,$bestand,$max_width,$max_height)
	{
		
		// Create image from file
		$image=imagecreatefromstring($bestand);
		/*
		switch(strtolower($type))
		{
		     case 'image/jpeg':
		         $image = imagecreatefromjpeg($bestand);
		         break;
		     case 'image/png':
		         $image = imagecreatefrompng($bestand);
		         break;
		     case 'image/gif':
		         $image = imagecreatefromgif($bestand);
		         break;
		     default:
		         exit('Unsupported type: '.$type);
		}*/
		
		// Get current dimensions
		$old_width  = imagesx($image);
		$old_height = imagesy($image);
		
		if($max_width=="" and max_height=="")
		{
			$scale="1";
		}
		else 
		{
			// Calculate the scaling we need to do to fit the image inside our frame
			$scale = min($max_width/$old_width, $max_height/$old_height);
		}
		// Get the new dimensions
		$new_width  = ceil($scale*$old_width);
		$new_height = ceil($scale*$old_height);
		
		// Create new empty image
		$new = imagecreatetruecolor($new_width, $new_height);
		
		// Resize old image into new
		imagecopyresampled($new, $image, 
		     0, 0, 0, 0, 
		     $new_width, $new_height, $old_width, $old_height);
		
		// Catch the imagedata
		ob_start();
		imagejpeg($new, NULL, 90);
		$data = ob_get_clean();
		
		// Destroy resources
		imagedestroy($image);
		imagedestroy($new);
		
		// Output data
		return $data;
	}
	
	function print_select_bewerking($link,$id,$veldnaam)
	{
		$select="select * from tra_bewerkingen where actief='1'";
		$r_select=mysqli_query($link,$select);
		if(mysqli_num_rows($r_select)>"0")
		{
			$hulp="<select name='".$veldnaam."'><option value='0'>Kies...</option>";
			
			while($bewerking=mysqli_fetch_array($r_select))
			{
				$hulp.="<option value='".$bewerking[id]."' "; 
				if($bewerking[id]==$id) $hulp.=" SELECTED "; 
				$hulp.=" >".$bewerking[naam]."</option>";
			}
			
			$hulp.="</select>";
		}
		else $hulp="Geen bewerkingen gevonden ".$select;
		
		return $hulp;
	}
	
	function print_bewerking($link,$id)
	{
		$q_select="select * from tra_bewerkingen where id='".$id."'";
		$r_select=mysqli_query($link,$q_select);
		if(mysqli_num_rows($r_select)=="1")
		{
			$bewerking=mysqli_fetch_array($r_select);
			
			return $bewerking[naam];
		}
		else return "Bewerking niet gevonden!";
	}
	
	function status_itil($status)
	{
		switch($status)
		{
			case 0: return "Geweigerd!"; break;
			case 1: return "Nog niet behandeld!"; break;
			case 2: return "Melding gelezen!"; break;
			case 3: return "Melding wordt onderzocht!"; break;
			case 4: return "Oplossing staat gepland"; break;
			case 9: return "Afgehandeld"; break;
		}
	}
	
	function print_taak_categorie($link,$id)
	{
		if($id!="0")
		{
			$q_select="select * from agora_taak_categorie where id='".$id."'";
			$r_select=mysqli_query($link,$q_select);
			if(mysqli_num_rows($r_select))
			{
				$select=mysqli_fetch_array($r_select);
				return $select[naam];
			}
			else return "FOUT";
		}
		else return "GEEN";
	}
	
	function zoek_personeelslid_id($link,$link_school,$user)
	{
		$email_user=email_login($link,$user);
		$naam_user=print_aanvrager($link,$user);
		
		$q_select="select id from agora_personeel where email='".$email_user."' limit 1";
		//print($q_select."<br />");
		$r_select=mysqli_query($link_school,$q_select);
		if(mysqli_num_rows($r_select)=="1")
		{
			$select=mysqli_fetch_array($r_select);
			return $select[id];
		}
		else return "0";
	}
	
	function zoek_bevoegden_itil($link,$link_school,$aard)
	{
		$hulp="";
		$q_bevoegd="select t2.id_personeel from itil_configuratie as t1 left join itil_bevoegdheid as t2 on t1.id=t2.id_configuratie where t1.naam='".$aard."'";
		//print($q_bevoegd."<br />");
		$r_bevoegd=mysqli_query($link,$q_bevoegd);
		if(mysqli_num_rows($r_bevoegd)>"0")
		{
			
			$i="0";
			while($bevoegd=mysqli_fetch_array($r_bevoegd))
			{
				if($i>"0") $hulp.=", "; //$hulp.=";";
				//$hulp.=$bevoegd[id_personeel];
				if($bevoegd[id_personeel]!="")$hulp.=print_uitvoerder_kort($link,$link_school,$bevoegd[id_personeel],"personeel");
				$i++;
			}
		}
		return $hulp;
	}
	
	function openstaandeTakenItil($link,$id)
	{
		//variabelen
		$id=mysqli_real_escape_string($link,$id);
		$id_referentie="0";
		$hoofdstuk="";
		
		//test inbreuken en klachten
		$q_klacht="select id from rondgang_klachten where id_itil='".$id."' limit 1";
		//print($q_klacht."<br />");
		$r_klacht=mysqli_query($link,$q_klacht);
		if(mysqli_num_rows($r_klacht)=="1")
		{
			$klacht=mysqli_fetch_array($r_klacht);
			$id_referentie=$klacht[id];
			$hoofdstuk="klacht";
		}
		else
		{
			$q_inbreuk="select id from rondgang_inbreuken where id_itil='".$id."' limit 1";
			//print($q_inbreuk."<br />");
			$r_inbreuk=mysqli_query($link,$q_inbreuk);
			if(mysqli_num_rows($r_inbreuk)=="1")
			{
				$inbreuk=mysqli_fetch_array($r_inbreuk);
				$id_referentie=$inbreuk[id];
				$hoofdstuk="inbreuk";
			}
		}
		
		if(($id_referentie!="0") and ($hoofdstuk!=""))
		{
			$q_select="select count(id) as aantal from agora_taken where hoofdstuk='".$hoofdstuk."' and id_referentie='".$id_referentie."' and datum_stop='0000-00-00' and actief='1'";
			//print($q_select."<br />");
			$r_select=mysqli_query($link,$q_select);
			if(mysqli_num_rows($r_select)=="1")
			{
				$select=mysqli_fetch_array($r_select);
				return $select[aantal];
			}
			else return "0";
		}
	}
	
	function bestaandeTakenItil($link,$id)
	{
		//variabelen
		$id=mysqli_real_escape_string($link,$id);
		$id_referentie="0";
		$hoofdstuk="";
		
		//test inbreuken en klachten
		$q_klacht="select id from rondgang_klachten where id_itil='".$id."' limit 1";
		//print($q_klacht."<br />");
		$r_klacht=mysqli_query($link,$q_klacht);
		if(mysqli_num_rows($r_klacht)=="1")
		{
			$klacht=mysqli_fetch_array($r_klacht);
			$id_referentie=$klacht[id];
			$hoofdstuk="klacht";
		}
		else
		{
			$q_inbreuk="select id from rondgang_inbreuken where id_itil='".$id."' limit 1";
			//print($q_inbreuk."<br />");
			$r_inbreuk=mysqli_query($link,$q_inbreuk);
			if(mysqli_num_rows($r_inbreuk)=="1")
			{
				$inbreuk=mysqli_fetch_array($r_inbreuk);
				$id_referentie=$inbreuk[id];
				$hoofdstuk="inbreuk";
			}
		}
		
		if(($id_referentie!="0") and ($hoofdstuk!=""))
		{
			$q_select="select count(id) as aantal from agora_taken where hoofdstuk='".$hoofdstuk."' and id_referentie='".$id_referentie."' and actief='1'";
			//print($q_select."<br />");
			$r_select=mysqli_query($link,$q_select);
			if(mysqli_num_rows($r_select)=="1")
			{
				$select=mysqli_fetch_array($r_select);
				return $select[aantal];
			}
			else return "0";
		}
	}
	
	function print_rebos_code($link,$id)
	{
		$q_select="select nummer from rebos_codes where id='".$id."' limit 1";
		$r_select=mysqli_query($link,$q_select);
		if(mysqli_num_rows($r_select)=="1")
		{
			$select=mysqli_fetch_array($r_select);
			return $select[nummer];
		}
		else return "??";
	}
	
	function email_nieuwe_taak($link,$link_school,$id_taak)
	{
		//gegevens taak opvragen:
		$q_taak="select * from agora_taken where id_school='".$_SESSION[school_id]."' and id='".$id_taak."'";
		$r_taak=mysqli_query($link,$q_taak);
		if(mysqli_num_rows($r_taak)=="1")
		{
			print("start email!<br />");
			$taak=mysqli_fetch_array($r_taak);
			
			$to=email_personeelslid($link_school,$taak[id_personeel]);
			
			if($to!="0")
			{
				// To send HTML mail, the Content-type header must be set
				//$headers  = 'MIME-Version: 1.0' . "\r\n";
				//$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				
				// Additional headers
				//$headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
				//$headers .= 'From: AGORA taakbeheer <noreply@weveco.net>' . "\r\n";
				
				$content="Er werd een nieuwe taak voor u aangemaakt:<br /><br />
						Plaats:".print_locatie_naam($link,$taak[id_locatie])."<br />
						Omschrijving:".$taak[taak_omschrijving]."<br />
						Prioriteit:".$taak[prioriteit]."<br />
						Uit te voeren voor:".draaidatum($taak[deadline],"-")."<br /><br />Coprant dankt u voor het gebruik van taakbeheer om het welzijn binnen uw organisatie te verbeteren! 
						";
				$subject="Nieuwe taak";
				stuur_smtp_html_mail($to,$bcc,$subject,$content);
				//if(mail($to,"Nieuwe taak",$message,$headers)) print("Email met succes verzonden!!");
				//else print("FOUT .... Email niet verzonden!!");
			}
			else print("Geen emailadres gevonden!!");
		}
		else print("Taak niet gevonden!!");
		
	}
	
	function test_herhaling_tijd($start_datum,$einde_datum,$freq_aantal,$freq_tijd)
	{
		$aantal="0";
		
		$hulp_einde=explode("-",$einde_datum);
		$hulp_datum=explode("-",$start_datum);
		
		$freq_aantal=intval($freq_aantal);
		
		$hulp_dag=intval($hulp_datum[2]);
		$hulp_maand=intval($hulp_datum[1]);
		$hulp_jaar=intval($hulp_datum[0]);
		
		$nieuwe_datum=$hulp_jaar."-".$hulp_maand."-".$hulp_dag;
		
		if(($freq_tijd=="dag") or ($freq_tijd=="maand") or ($freq_tijd=="jaar"))
		{
			$i="0";			
			while(($einde_datum>=$nieuwe_datum) and $i<"999")
			{
				switch($freq_tijd)
				{
					case 'dag':
					{
						$hulp_dag+=$freq_aantal;
					} break;
					
					case 'maand':
					{
						$hulp_maand+=$freq_aantal;
						if($hulp_maand>"12")
						{
							$hulp_jaar++;
							$hulp_maand=$hulp_maand-12;
						}
					} break;
					
					case 'jaar':
					{
						$hulp_jaar+=$freq_aantal;
					} break;				
				}
				
				$nieuwe_datum=date("Y-m-d",mktime('0','0','0',$hulp_maand,$hulp_dag,$hulp_jaar));
				
				if($einde_datum>=$nieuwe_datum)
				{
					//print($einde_datum."/".$nieuwe_datum."/".$hulp_jaar."-".$hulp_maand."-".$hulp_dag."/".$freq_aantal."/".$freq_tijd."<br />");
					$aantal++;
				} 
				
				$i++;
				//oneindige lus voorkomen als jaar groter is dan het eindejaar of indien de nieuwe datum te groot is waardoor de server een foute datum genereerd nl 1970-01-01
				if($hulp_jaar>=intval($hulp_einde[0])) $hulp_jaar=intval($hulp_einde[0])+"1";
				if(($i>"60") or ($nieuwe_datum=="1970-01-01"))
				{
					$i="999";
					//print("help! ");
					//$aantal="1";
				}
			}
			
			if($i=="1") 
			{
				//print($start_datum."/".$einde_datum."/".$nieuwe_datum."/".$hulp_jaar."-".$hulp_maand."-".$hulp_dag."/".$freq_aantal."/".$freq_tijd."<br />");
				$aantal++;
			}
			elseif($aantal=="0") $aantal++;
		}
		else $aantal="1";
		
		if($i=="999") 
		{
			//print($start_datum."/".$einde_datum."/".$nieuwe_datum."/".$hulp_jaar."-".$hulp_maand."-".$hulp_dag."/".$freq_aantal."/".$freq_tijd."/aantal: ".$aantal."<br />");
			$aantal="1";
		}
		
		return $aantal;
	}
	
	function getFileType($ext)
	{
		switch(strtolower($ext))
		{
			case "jpg": $fileType="image/jpeg";break;
			case "jpeg": $fileType="image/jpeg";break;
			case "gif": $fileType="image/gif";break;
			case "png": $fileType="image/png";break;
			
			//microsoft
			case "doc": $fileType="application/msword";break;
			case "docx": $fileType="application/msword";break;
			case "xls": $fileType="application/vnd.ms-excel";break;
			case "xlsx": $fileType="application/vnd.ms-excel";break;
			case "ppt": $fileType="application/vnd.ms-powerpoint";break;
			case "pptx": $fileType="application/vnd.ms-powerpoint";break;
			
			case "pdf": $fileType="application/pdf";break;					
			
			default: 
			{
				$fileType="txt";					
			}
		}
		
		return $fileType;
	}
	
	function document_icon($ext)
	{
		switch(strtolower($ext))
		{
			case doc: return "<img src='".$_SESSION['http']."images/word.png'>";break;
			case docx: return "<img src='".$_SESSION['http']."images/word.png'>";break;
			case xls: return "<img src='".$_SESSION['http']."images/excel.png'>";break;
			case xlsx: return "<img src='".$_SESSION['http']."images/excel.png'>";break;
			case pdf: return "<img src='".$_SESSION['http']."images/pdf.png'>";break;
			case csv: return "<img src='".$_SESSION['http']."images/excel.png'>";break;
			case jpg: return "<img src='".$_SESSION['http']."images/image.png'>";break;
			case gif: return "<img src='".$_SESSION['http']."images/image.png'>";break;
			case png: return "<img src='".$_SESSION['http']."images/image.png'>";break;
			case ppt: return "<img src='".$_SESSION['http']."images/ppt.png'>";break;
			case pptx: return "<img src='".$_SESSION['http']."images/ppt.png'>";break;
			case pps: return "<img src='".$_SESSION['http']."images/ppt.png'>";break;
			default: return "";
		}
	}
	
	function getFileExtension($filename)
	{
		
	}

	function stuur_smtp_html_mail($to,$bcc,$subject,$content)
	{
		$crlf = "\n";
		$hdrs = array(
		              'From'    => 'Agora<noreply@weveco.net>',
		              'To' => $to,
		              'Subject' => $subject
		              );
		
		if($bcc=="") $bcc="noreply@weveco.net";
		              
		if($to!="") $aan=$to.",".$bcc;
		else $aan=$bcc;
		$mime = new Mail_mime(array('eol' => $crlf));
		
		$mime->setHTMLBody($content);
		
		$body = $mime->get();
		$headers = $mime->headers($hdrs);
		
		$host = "ssl://send.one.com";
		$port = "465";
		$username = "noreply@weveco.net";
		$password = "jvo987";
		   
		$smtp = Mail::factory('smtp',
		   array ('host' => $host,
		     'port' => $port,
		     'auth' => true,
		     'username' => $username,
		     'password' => $password));
		 
		 $mail = $smtp->send($aan, $headers, $body);
		 
		 if (PEAR::isError($mail)) {
		   echo("<p>" . $mail->getMessage() . "</p>");
		  } else {
		   echo("Email met succes verzonden naar ".$to."!");
		  }
	}
	
	function utf8_encode_recursive($array)
	{
	    require_once('encoding.php'); 
		
		$result = array();
	    foreach ($array as $key => $value)
	    {
	        if (is_array($value))
	        {
	            $result[$key] = utf8_encode_recursive($value);
	        }
	        else if (is_string($value))
	        {
	            //$result[$key] = utf8_encode($value);
	            $result[$key] = \ForceUTF8\Encoding::toUTF8($value);
	        }
	        else
	        {
	            $result[$key] = $value;
	        }
	    }
	    return $result;
	}
	
	function print_personeel_campus($link,$link_school,$id_personeel)
	{
		$q_campus="select * from agora_campus where school_id='".$_SESSION[school_id]."'";
		$r_campus=mysqli_query($link,$q_campus);
		while($rij=mysqli_fetch_array($r_campus))
		{
			$id=$rij[id];
			$campus[$id]=$rij[naam];
		}
		
		$q_match="select * from agora_personeel_campus where id_personeel='".$id_personeel."' and actief='1'";
		//print($q_match."<br />");
		$r_match=mysqli_query($link_school,$q_match);
		if(mysqli_num_rows($r_match)>"0")
		{
			$hulp="";
			
			while($match=mysqli_fetch_array($r_match))
			{
				$id=$match[id_campus];
				if($hulp!="") $hulp.=", ";
				$hulp.=$campus[$id];
			}
			
			return $hulp;
		}
		else return "Niet gevonden!";
	}
	
	function print_naam_leerling($link_school,$id_leerling)
	{
		$q_select="select * from agora_lln where id='".$id_leerling."'";
		$r_select=mysqli_query($link_school,$q_select);
		if(mysqli_num_rows($r_select)=="1")
		{
			$select=mysqli_fetch_array($r_select);
			
			return $select[naam]." ".$select[voornaam];
		}
	}
	
	function print_naam_leerling_cpa($id_school,$id_leerling)
	{
		//school simuleren
		if(($_SESSION[school_id]=="0") and ($id_school>"0"))
		{
			$_SESSION[school_id]=$id_school;
			include("dbi_school.php");
			$_SESSION[school_id]="0";
		}
		//met de schoollink gegevens ophalen uit databank
		$hulp=print_naam_leerling($link_school,$id_leerling);
		
		//link met school breken
		mysqli_close($link_school); //test
		
		//data terug sturen
		return $hulp;
	}
	
	function abonnement_datum($link,$id_recht)
	{
		$q_login="select * from agora_rechten where id='".$id_recht."' and actief='1'";
		$r_login=mysqli_query($link,$q_login);
		if(mysqli_num_rows($r_login)=="1")
		{
			$login=mysqli_fetch_array($r_login);
			
			//abonnement onderzoeken van cpa
			$q_cpa_abo="select abonnement from agora_scholengemeenschap where id='".$login[id_scholengemeenschap]."' limit 1";
			$r_cpa_abo=mysqli_query($link,$q_cpa_abo);
			$cpa_abo=mysqli_fetch_array($r_cpa_abo);
			
			if($login[aard]=="super") return date("Y-m-d");
			elseif($login[aard]!="cpa" and $login[aard]!="subgroep" and $cpa_abo[abonnement]<date("Y-m-d"))
			{
				//abonnement school zoeken indien cpa abonnenment verlopen is
				$q_abo="select abonnement from agora_scholen where id='".$login[id_school]."' limit 1";
				$r_abo=mysqli_query($link,$q_abo);
				$abo=mysqli_fetch_array($r_abo);
				return $abo[abonnement];
			}
			else return $cpa_abo[abonnement];
		}
	}
	
	function abonnement_test($link,$id_recht)
	{
		$hulp=abonnement_datum($link,$id_recht);
		
		if($hulp>=date("Y-m-d")) return "1";
		else return $hulp;	
	}
	
	function login_instelling($link,$id)
	{
		$q_rechten="select * from agora_rechten where id='".$id."' and id_login='".$_SESSION[user_id]."' and actief='1' limit 1";
		//print($q_rechten."<br />");
		$r_rechten=mysqli_query($link,$q_rechten);
		if(mysqli_num_rows($r_rechten)=="1")
		{
			$rechten=mysqli_fetch_array($r_rechten);
			
			if(($rechten[aard]=="school") or ($rechten[aard]=="cpa")) $_SESSION[identificatie]=$rechten[identificatie]; //laatste update gegevens identificatiedocument
			else $_SESSION[identificatie]=date("Y-m-d"); //enkel pa en CPA dienen identificatiedocument te updaten!!
			
			if($rechten[id_school]!="") $_SESSION['school_id']=$rechten[id_school];
			else $_SESSION['school_id']="0";
			
			if($rechten[id_campus]!="") $_SESSION['id_campus']=$rechten[id_campus];
			else $_SESSION['id_campus']="0";
			
			if($rechten[id_subgroep]!="") $_SESSION['id_subgroep']=$rechten[id_subgroep];
			else $_SESSION['id_subgroep']="0";
			
			$_SESSION['aard']=$rechten[aard];
			$_SESSION['scholengemeenschap']=$rechten[id_scholengemeenschap];
			$_SESSION['agora']=$rechten[agora];
			$_SESSION['bugs']=$rechten[bugs];
			$_SESSION['weveco']=$rechten[weveco];
			$_SESSION['weveco2']=$rechten[weveco2];
			$_SESSION['pbm']=$rechten[pbm];
			$_SESSION['EDPBW']=$rechten[EDPBW];
			$_SESSION['rebos']=$rechten[rebos];
			$_SESSION['inspectie']=$rechten[inspectie];
			$_SESSION['taakbeheer']=$rechten[taakbeheer];
			$_SESSION['arbeidsmiddelen']=$rechten[arbeidsmiddelen];
			$_SESSION['toolbox']=$rechten[toolbox];
			$_SESSION['vik']=$rechten[vik];
			$_SESSION['wik']=$rechten[wik];
			$_SESSION['wi']=$rechten[wi];
			$_SESSION['rie']=$rechten[rie];
			$_SESSION['jap']=$rechten[jap];
			$_SESSION['gpp']=$rechten[gpp];
			$_SESSION['opleiding']=$rechten[opleiding];
			
			if(abonnement_test($link,$id)=="1") $_SESSION[abo]="1";
			else $_SESSION[abo]="0";
		}
		else
		{
			print("Aanmelden niet mogelijk!! Geen rechten gevonden!!");
		}
	}
?>