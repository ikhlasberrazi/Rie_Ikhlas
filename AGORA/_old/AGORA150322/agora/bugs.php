<?php

if($_SESSION['login']=="wos_coprant")
{
	if($_GET)
	{
		$actie=$_GET[actie];
		$id=$_GET[id];
		$agora=$_GET[agora];
	}
	else
	{
		$actie=$_POST[actie];
		$id=$_POST[id];
		$agora=$_POST[agora];
	}

	$show="0";

	switch($actie)
	{
		case nieuw:
		{
			print("<h1> Fout of suggestie ".$agora." melden: Nieuw &nbsp; &nbsp; &nbsp; &nbsp; <a href='index.php?pad=school&go=bugs&agora=".$agora."'><img src='images/beheer.png'> Overzicht</a></h1><br /><br /><div class='nieuw'>
				<form action='".$_SERVER['PHP_SELF']."' method='post'>
				<input type='hidden' name='pad' value='school'>
				<input type='hidden' name='go' value='bugs'>
				<input type='hidden' name='actie' value='input'>
				<input type='hidden' name='agora' value='".$agora."'>
				<font color=red>Denk eraan dat bij elke melding uw naam vermeld zal worden om misbruik te voorkomen!</font><br /><br />
				<table>
				<tr><td>Titel</td><td><input type='text' name='titel' size='60'></td></tr>
				<tr><td>Fout / suggestie: </td><td>
				<select name='aard'>
					<option value='bug'>Fout</option>
					<option value='suggestie'>Suggestie</option>
				</select></td></tr>
				<tr><td>Omschrijving: </td><td>
				<textarea name='omschrijving' cols='40' rows='5'></textarea>
				</td></tr>
				<tr><td align=center colspan='2'><br /><input type='submit' value='Opslaan'></td></tr>
				</table><br />
					<center>
					<font color=red>Alle velden zijn verplicht in te vullen!</font>
					</center>
				</form>
				</div>
			");
			
			$show="1";
		}break;
		
		case input:
		{
			if(($_POST[titel]!="") and ($_POST[aard]!="") and ($_POST[omschrijving]!=""))
			{
				$q_insert="insert into agora_bugs (id_aanvrager,aard,titel,omschrijving,datum) values (
				'".mysqli_real_escape_string($link,$_SESSION[user_id])."',
				'".mysqli_real_escape_string($link,$_POST[aard])."',
				'".mysqli_real_escape_string($link,$_POST[agora].": ".$_POST[titel])."',
				'".mysqli_real_escape_string($link,$_POST[omschrijving])."',
				'".date("Y-m-d")."'
				)";
				
				$r_insert=mysqli_query($link,$q_insert);
				if($r_insert) print("<font color=green>Fout / suggestie met succes toegevoegd!</font><br />");
				else print("<font color=red>FOUT: fout of suggestie NIET toegevoegd!</font><br />");
			}
		}break;
		
		case form:
		{
			print("
				<form id='feedback'>
				<input type='hidden' name='actie' value='feedback'>
				<input type='hidden' name='id' value='".$id."'>
				<textarea name='oplossing' cols='80' rows='5'></textarea>
				</form>
			");
		}break;
	}
	
	if($show=="0")
	{
		?>
	
		<script>
		$(document).ready(function() {
			$( "#accordion" ).accordion({
								collapsible: true,
								active: 0,
								heightStyle:"content"
							});
		});
		</script>
		
		<?php
		
		//index.php?pad=school&go=bugs&actie=nieuw&agora=".$agora."
		
		print("<h1>Fouten en suggesties ".$agora."&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ");
		if(($_SESSION[$agora]=="beheer") or ($agora==agora)) 
            print(" <a href='#' onClick=\"nieuweFout('".$agora."');\"><img src='".$_SESSION['http_images']."nieuw2.png'> Nieuw</a>");
		print("</h1><br />Klik op de titel om meer te weten te komen.<br /><br /><div id=accordion>
		<h3><a href='#'>Huidige fouten</a></h3><div>");
		
		
		$q_lijst="select * from agora_bugs where aard='bug' and titel like '".$agora."%' and actief='1'";
		$r_lijst=mysqli_query($link,$q_lijst);
		if(mysqli_num_rows($r_lijst)>"0")
		{
			print("<table id='dataTable' border='1'><thead><tr><td>Datum</td><td>Titel</td><td>Aanvrager</td><td>Start uitvoering</td></tr></thead><tbody>");
			
			while($lijst=mysqli_fetch_array($r_lijst))
			{
				print(utf8_encode("<tr onClick=\"toonBug('".$lijst[id]."');\"><td>".$lijst[datum]."</td><td>".stripslashes($lijst[titel])."</td><td>".print_aanvrager($link,$lijst[id_aanvrager])."</td><td>".$lijst[datum_start]."</td></tr>"));
			}
			
			print("</tbody></table>");
		}
		else print("Geen gegevens gevonden!");
		
		mysqli_free_result($r_lijst);
		
		print("</div><h3><a href='#'>Opgeloste fouten</a></h3><div>");
		
		$q_lijst2="select * from agora_bugs where aard='bug' and titel like '".$agora."%' and actief='0'";
		$r_lijst2=mysqli_query($link,$q_lijst2);
		if(mysqli_num_rows($r_lijst2)>"0")
		{
			print("<table id='dataTable' border='1'><thead><tr><td>Datum</td><td>Titel</td><td>Aanvrager</td><td>Start uitvoering</td></tr></thead><tbody>");
			
			while($lijst2=mysqli_fetch_array($r_lijst2))
			{
				print(utf8_encode("<tr onClick=\"toonBug('".$lijst2[id]."');\"><td>".$lijst2[datum]."</td><td>".stripslashes($lijst2[titel])."</td><td>".print_aanvrager($link,$lijst2[id_aanvrager])."</td><td>".$lijst2[datum_start]."</td></tr>"));
			}
			
			print("</tbody></table>");
		}
		else print("Geen gegevens gevonden!");
		
		mysqli_free_result($r_lijst2);
		
		print("</div><h3><a href='#'>Suggesties in ontwikkeling</a></h3><div>");
		$q_suggestie_start="select * from agora_bugs where aard='suggestie' and titel like '".$agora."%' and actief='1' and datum_start!='0000-00-00'";
		$r_suggestie_start=mysqli_query($link,$q_suggestie_start);
		if(mysqli_num_rows($r_suggestie_start)>"0")
		{
			print("<table id='dataTable' border='1'><thead><tr><td>Datum</td><td>Titel</td><td>Aanvrager</td><td>Start uitvoering</td></tr></thead><tbody>");
			
			while($suggestie_start=mysqli_fetch_array($r_suggestie_start))
			{
				print(utf8_encode("<tr onClick=\"toonBug('".$suggestie_start[id]."');\"><td>".$suggestie_start[datum]."</td><td>".stripslashes($suggestie_start[titel])."</td><td>".print_aanvrager($link,$suggestie_start[id_aanvrager])."</td><td>".$suggestie_start[datum_start]."</td></tr>"));
			}
			
			print("</tbody></table>");
		}
		else print("Geen gegevens gevonden!");
		
		mysqli_free_result($r_suggestie_start);
		
		print("</div><h3><a href='#'>Suggesties</a></h3><div>");
		
		$q_suggestie="select * from agora_bugs where aard='suggestie' and titel like '".$agora."%' and actief='1'";
		$r_suggestie=mysqli_query($link,$q_suggestie);
		if(mysqli_num_rows($r_suggestie)>"0")
		{
			print("<table id='dataTable' border='1'><thead><tr><td>Datum</td><td>Titel</td><td>Aanvrager</td><td>Start uitvoering</td></tr></thead><tbody>");
			
			while($suggestie=mysqli_fetch_array($r_suggestie))
			{
				print(utf8_encode("<tr onClick=\"toonBug('".$suggestie[id]."');\"><td>".$suggestie[datum]."</td><td>".stripslashes($suggestie[titel])."</td><td>".print_aanvrager($link,$suggestie[id_aanvrager])."</td><td>".$suggestie[datum_start]."</td></tr>"));
			}
			
			print("</tbody></table>");
		}
		else print("Geen gegevens gevonden!");
		
		mysqli_free_result($r_suggestie);
		
		
		print("</div><h3><a href='#'>Verworpen suggesties</a></h3><div>");
		
		$q_suggestie_stop="select * from agora_bugs where aard='suggestie' and titel like '".$agora."%'  and actief='0' and datum_start='0000-00-00'";
		$r_suggestie_stop=mysqli_query($link,$q_suggestie_stop);
		if(mysqli_num_rows($r_suggestie_stop)>"0")
		{
			print("<table id='dataTable' border='1'><thead><tr><td>Datum</td><td>Titel</td><td>Aanvrager</td><td>Start uitvoering</td></tr></thead><tbody>");
			
			while($suggestie_stop=mysqli_fetch_array($r_suggestie_stop))
			{
				print(utf8_encode("<tr onClick=\"toonBug('".$suggestie_stop[id]."');\"><td>".$suggestie_stop[datum]."</td><td>".stripslashes($suggestie_stop[titel])."</td><td>".print_aanvrager($link,$suggestie_stop[id_aanvrager])."</td><td>".$suggestie_stop[datum_start]."</td></tr>"));
			}
			
			print("</tbody></table>");
		}
		else print("Geen gegevens gevonden!");
		
		mysqli_free_result($r_suggestie_stop);		
		
		print("</div><h3><a href='#'>Uitgevoerde suggesties</a></h3><div>");
		
		$q_suggestie_einde="select * from agora_bugs where aard='suggestie' and titel like '".$agora."%' and actief='0' and datum_start!='0000-00-00'";
		$r_suggestie_einde=mysqli_query($link,$q_suggestie_einde);
		if(mysqli_num_rows($r_suggestie_einde)>"0")
		{
			print("<table id='dataTable' border='1'><thead><tr><td>Datum</td><td>Titel</td><td>Aanvrager</td><td>Start uitvoering</td></tr></thead><tbody>");
			
			while($suggestie_einde=mysqli_fetch_array($r_suggestie_einde))
			{
				print(utf8_encode("<tr onClick=\"toonBug('".$suggestie_einde[id]."');\"><td>".$suggestie_einde[datum]."</td><td>".stripslashes($suggestie_einde[titel])."</td><td>".print_aanvrager($link,$suggestie_einde[id_aanvrager])."</td><td>".$suggestie_einde[datum_start]."</td></tr>"));
			}
			
			print("</tbody></table>");
		}
		else print("Geen gegevens gevonden!");
		
		mysqli_free_result($r_suggestie_einde);
		print("</div></div>
		<div id='bug'></div><div id='oplossing'></div><div id='feedback'></div>
		");
	}
	
}
else
{
}
?>