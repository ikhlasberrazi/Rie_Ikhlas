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
		$aard=mysqli_real_escape_string($link,$_POST[aard]);
	
	
    switch ($actie)
    {
       case 'vragenForm':
			{
			
				
				print("
					<form id='VragenFormID'>
					<input type='hidden' name='actie' value='vraag_opslaan'>
					<input type='hidden' name='id' value='".$id."'>
					Vraag: <input type='text' name='vraag' size='75'><br/>
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
			}break;	
			
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
                /*
				else
				{
					//update
					if($_SESSION[aard]=="super")
                        $q_update="update rie_input set vraag='".$vraag."' type_input='".$type_input."' where id='".$id."'";
					//else $q_update="insert into vik_categorie_hoofd_historiek (id_categorie_hoofd,naam,type_input,id_scholengemeenschap,id_school,actief) values('".$id."','".$naam."','".$_SESSION[scholengemeenschap]."','".$_SESSION[school_id]."','2')";
					$r_update=mysqli_query($link,$q_update);
					if($r_update) 
					{
						if($_SESSION[aard]=="super") print("<br /><br /><br /><h2><font color=green><center>Wijziging met succes opgeslagen!</center></font></h2>");
						else print("<br /><br /><br /><h2><font color=green><center>Voorstel tot wijziging met succes opgeslagen!</center></font></h2>");
					}
                    //else print(mysql_error());
					else print("<br /><br /><br /><h2><font color=red><center>Wijziging opslaan MISLUKT!</center></font></h2>");
                    
				}*/
			}break;	
        
        
    }
		
	}
	
}
else print("Sessie verlopen");
	 