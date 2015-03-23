<?php

	//variabelen applicatie
	$naam_app="Risicoanalyses";
	$link_app="rie";
	$versie_app="1.0";
	$omschrijving_app="";

    
	function aantal_rie($link,$aard,$id)
	{
	   
		$q_select=
        "select count(id) as aantal 
        from rie_upload 
        where aard='".$aard."' 
        and id_referentie='".$id."' 
        and actief='1' 
        and ((id_scholengemeenschap='0' 
        and id_school='0') 
            or (id_scholengemeenschap='".$_SESSION[scholengemeenschap]."' 
        and id_school='0') 
            or (id_scholengemeenschap='".$_SESSION[scholengemeenschap]."' 
        and id_school='".$_SESSION[school_id]."'))";
		//print($q_select."<br />");
        
		$r_select=mysqli_query($link,$q_select);
		if(mysqli_num_rows($r_select)>"0")
		{
			$select=mysqli_fetch_array($r_select);
			return $select[aantal];
		}
		else return "Fout";
	}
    
?>