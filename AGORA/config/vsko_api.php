<?php
	
	$_SESSION['api_http']="http://api.vsko.be";
	
	function vsko_sg_instellingsnr($id)
	{
		$ctx = stream_context_create(array( 
		    'http' => array( 
		        'timeout' => 1 
		        ) 
		    ) 
		); 
	
		$jsonurl=$_SESSION['api_http'].'/schoolcommunities/'.$id; 
		$json = @file_get_contents($jsonurl,0,$ctx,null);  
		$json_output = json_decode($json, true);if($attitude=="1") print("<a href=index.php?dir=punten&pagina=attituderapport&periode=".$periode_id."&info=".$info[id]."&klas=".$info[klas].">Attitude</a>");
		
		$vsko=array();
		
		$vsko[naam]=$json_output['$$currentName'];
		$vsko[instellingsnr]=$json_output['institutionNumber'];
		$vsko[adres]=$json_output['seatAddresses']['0']['address']['street']." ".$json_output['seatAddresses']['0']['address']['houseNumber'];
		$vsko[postcode]=$json_output['seatAddresses']['0']['address']['zipCode'];
		if($json_output['seatAddresses']['0']['address']['subCity']!="")$vsko[plaats]=$json_output['seatAddresses']['0']['address']['subCity'];
		else $vsko[plaats]=$json_output['seatAddresses']['0']['address']['city'];
		$vsko[key]=$json_output['seatAddresses']['0']['key'];
		$vsko[telefoon]=$json_output['telecoms']['phones']['0']['number'];
		$vsko[fax]=$json_output['telecoms']['faxes']['0']['number'];
		$vsko[email]=$json_output['telecoms']['emails']['0']['address'];
		$vsko[website]=$json_output['telecoms']['websites']['0']['url'];
		
		return($vsko);
		
	}
	
	function vsko_school_instellingsnr($id)
	{

		$ctx = stream_context_create(array( 
		    'http' => array( 
		        'timeout' => 1 
		        ) 
		    ) 
		); 
	
		$jsonurl=$_SESSION['api_http'].'/schools/'.$id; 
		
		$json = @file_get_contents($jsonurl,0,$ctx,null);  
		$json_output = json_decode($json, true);

		$vsko=array();
		
		$vsko[naam]=$json_output['$$currentName'];		
		$vsko[instellingsnr]=$json_output['institutionNumber'];
		$vsko[adres]=$json_output['seatAddresses']['0']['address']['street']." ".$json_output['seatAddresses']['0']['address']['houseNumber'];
		$vsko[postcode]=$json_output['seatAddresses']['0']['address']['zipCode'];
		if($json_output['seatAddresses']['0']['address']['subCity']!="")$vsko[plaats]=$json_output['seatAddresses']['0']['address']['subCity'];
		else $vsko[plaats]=$json_output['seatAddresses']['0']['address']['city'];
		$vsko[key]=$json_output['seatAddresses']['0']['key'];
		$vsko[telefoon]=$json_output['telecoms']['phones']['0']['number'];
		$vsko[fax]=$json_output['telecoms']['faxes']['0']['number'];
		$vsko[email]=$json_output['telecoms']['emails']['0']['address'];
		$vsko[website]=$json_output['telecoms']['websites']['0']['url'];
		
		return($vsko);

	}
	
	function vsko_instellingsnr($id,$aard)
	{
		$vsko=array();
		if($id>"0")
		{
			$ctx = stream_context_create(array( 
			    'http' => array( 
			        'timeout' => 1 
			        ) 
			    ) 
			); 
		
			$jsonurl=$_SESSION['api_http'];
			switch($aard)
			{
				case 'school': $jsonurl.='/schools/'; break;
				case 'sg': $jsonurl.='/schoolcommunities/'; break;
				case 'vzw': $jsonurl.='/governinginstitutions/'; break;
				
			}
			
			$jsonurl.=$id; 
			//print("jsonurl:".$jsonurl."<br />");
			
			$json = @file_get_contents($jsonurl,0,$ctx,null);  
			$json_output = json_decode($json, true);
	
			
			$vsko[startdatum]=$json_output['details']['0']['startDate'];
			$vsko[naam]=$json_output['$$currentName'];		
			$vsko[instellingsnr]=$json_output['institutionNumber'];
			$vsko[adres]=$json_output['seatAddresses']['0']['address']['street']." ".$json_output['seatAddresses']['0']['address']['houseNumber'];
			$vsko[postcode]=$json_output['seatAddresses']['0']['address']['zipCode'];
			if($json_output['seatAddresses']['0']['address']['subCity']!="")$vsko[plaats]=$json_output['seatAddresses']['0']['address']['subCity'];
			else $vsko[plaats]=$json_output['seatAddresses']['0']['address']['city'];
			$vsko[key]=$json_output['seatAddresses']['0']['key'];
			$vsko[telefoon]=$json_output['telecoms']['phones']['0']['number'];
			$vsko[fax]=$json_output['telecoms']['faxes']['0']['number'];
			$vsko[email]=$json_output['telecoms']['emails']['0']['address'];
			$vsko[website]=$json_output['telecoms']['websites']['0']['url'];
			$vsko[kbonummer]=$json_output['companyNumber'];
			$vsko[vsko_nr]=$json_output['vskoNumber'];
		}
		return($vsko);
	}
	
	function vsko_zoek_instelling($word,$aard)
	{

		$ctx = stream_context_create(array( 
		    'http' => array( 
		        'timeout' => 1 
		        ) 
		    ) 
		); 
	
		$jsonurl=$_SESSION['api_http'];
		switch($aard)
		{
			case 'school': $jsonurl.='/schools'; break;
			case 'sg': $jsonurl.='/schoolcommunities'; break;
			case 'vzw': $jsonurl.='/governinginstitutions'; break;
			
		}
		
		$jsonurl.="?words=".$word; 
		
		//print($jsonurl."<br />");
		$json = @file_get_contents($jsonurl,0,$ctx,null);  
		$json_output = json_decode($json, true);
		
		return($json_output);
	}
	
	function vsko_overzicht_scholen($id,$aard)
	{
		$ctx = stream_context_create(array( 
		    'http' => array( 
		        'timeout' => 1 
		        ) 
		    ) 
		); 
	
		$jsonurl=$_SESSION['api_http'];
		switch($aard)
		{
			case 'sg': $jsonurl.='/schoolcommunities'; break;
			case 'vzw': $jsonurl.='/governinginstitutions'; break;	
		}
		
		$jsonurl.="/".$id; 
		
		//print($jsonurl."<br />");
		
		$json = @file_get_contents($jsonurl,0,$ctx,null);  
		$json_output = json_decode($json, true);
		
		return($json_output);		
	}
	

?>