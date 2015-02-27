<?php
session_start();

if($_SESSION[login]=="wos_coprant")
{
	
	//databank openen
	include_once("../../config/dbi.php");
	include_once("../../config/config.php");
	
	if($_POST)
	{
		$agora=$_POST[agora];
		$actie=$_POST[actie];
		$id=$_POST[id];
		
		switch($actie)
		{
			case nieuw:
			{
				print("
					<form id='bugNieuw'>
					<input type='hidden' name='actie' value='input'>
					<input type='hidden' name='agora' value='".$agora."'>
					<font color=red>Denk eraan dat bij elke melding uw naam vermeld zal worden om misbruik te voorkomen!</font><br /><br />
						<table>
    						<tr>
                                <td>Titel</td>
                                <td><input type='text' name='titel' size='60'></td>
                            </tr>
    						<tr>
                                <td>Fout / suggestie: </td>
                                <td>
            						<select name='aard'>
            							<option value='bug'>Fout</option>
            							<option value='suggestie'>Suggestie</option>
            						</select>
                                </td>
                            </tr>
    						<tr>
                                <td>Omschrijving: </td>
                                <td>
        						  <textarea name='omschrijving' cols='40' rows='5'></textarea>
        						</td>
                            </tr>
    						
						</table><br />
						
					<center>
					   <font color=red>Alle velden zijn verplicht in te vullen!</font>
					</center>
					
					</form>
				");
			}break;
			
			case input:
			{
				if(($_POST[titel]!="") and ($_POST[aard]!="") and ($_POST[omschrijving]!=""))
				{
					$q_insert=
                        "insert into agora_bugs (id_aanvrager,aard,titel,omschrijving,datum) 
                        values (
        					'".mysqli_real_escape_string($link,$_SESSION[user_id])."',
        					'".mysqli_real_escape_string($link,$_POST[aard])."',
        					'".mysqli_real_escape_string($link,$_POST[agora].": ".$_POST[titel])."',
        					'".mysqli_real_escape_string($link,$_POST[omschrijving])."',
        					'".date("Y-m-d")."'
    					)";
					
					$r_insert=mysqli_query($link,$q_insert);
					if($r_insert) 
                        print("<font color=green>Fout / suggestie met succes toegevoegd!</font><br />");
					else print("<font color=red>FOUT: fout of suggestie NIET toegevoegd!</font><br />");
				}
				else print("0");
			}break;
			
			case detail:
			{
				$q_select=
                    "select * 
                    from agora_bugs 
                    where id='".$id."'";
                
				$r_select=mysqli_query($link,$q_select);
				if(mysqli_num_rows($r_select)=="1")
				{
					$select=mysqli_fetch_array($r_select);
					
					print("
                        <br /><br />
                        <b>Titel:</b> 
                        ".$select[titel]."<br /><br /><br />
                        <b>Omschrijving:</b> 
                        <br /><br />
                        ".$select[omschrijving]."<br /><br />
                        <b>Feedback:</b><br /><br />
                    ");
					if($select[feedback]!="")
                        print($select[feedback]."<br /><br /><b>Opgelost door: ".print_aanvrager($link,$select[id_oplosser]));
					elseif($_SESSION[bugs]=="beheer") 
                        print("<a href='javascript:void(0);' onClick=\"bugOpgelost('".$id."');\">Nu feedback geven</a>");
					else print("Er wordt binnenkort feedback gegeven!");
					
					print("</b>");
				}
				else print("2");
			}break;
			
			case form:
			{
				print("
					<form id='feedback'>
					<input type='hidden' name='actie' value='feedback'>
					<input type='hidden' name='id' value='".$id."'>
					<h2>Feedback:</h2><br /><br />
					<textarea name='oplossing' cols='60' rows='5'></textarea>
					</form>
				");
			}break;
			
			case feedback:
			{
				$q_update=
                    "update agora_bugs 
                    set datum_start='".date("Y-m-d")."', 
                    datum_stop='".date("Y-m-d")."', 
                    id_oplosser='".$_SESSION[user_id]."',
                    feedback='".mysqli_real_escape_string($link,$_POST[oplossing])."', 
                    actief='0' 
                    where id='".$id."'";
                    
				print($q_update."<br />");
				$r_update=mysqli_query($link,$q_update);
				if($r_update) 
                    print("1");
				else print("0");
			}break;
		}
	}
}
?>