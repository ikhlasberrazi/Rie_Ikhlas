<?php

session_start();

if(($_SESSION[login]=="wos_coprant") and ($_SESSION[rie]!=""))
{
    
    if($_SESSION[aard]=="super") 
        print("
                <a 
                href='javascript:void(0);' 
                onClick=\"categorierie('nieuw','');
                \">
                <img src='".$_SESSION[http]."images/nieuw.png'> Nieuwe Vraag</a>"
            );
            
	elseif($_SESSION[aard]=="cpa") 
        print("<a 
            href='javascript:void(0);'
            onClick=\"categorierie('voorstel','');\">
            <img src='".$_SESSION[http]."images/nieuw.png'> Nieuwe Vraag (Voorstel)</a>"
        );
	print("</h1><br /><br />");
	
								
		while($hoofd=mysqli_fetch_array($r_hoofd))
		{
			print("
            <h3>
            <a href='javascript:void(0);' 
                onClick=\"laadSubstructuur('".$hoofd[id]."');\">".$hoofd[naam]); 
                    if($hoofd[actief]=="2") 
                        print(" (Voorstel)"
            ); 
            print("</a></h3><div>");
			
			if($_SESSION[aard]=="super")
                print("
                    <a href='javascript:void(0);' 
                        onClick=\"SubCategorierie('".$hoofd[id]."','nieuw','".$hoofd[id]."','".$hoofd[naam]."');\">
                        <img src='".$_SESSION[http_images]."nieuw.png'> Nieuwe subcategorie</a> 
                    &nbsp; &nbsp; &nbsp; 
                    <a href='javascript:void(0);' 
                        onClick=\"categorierie('".$hoofd[id]."','wijzig','".$hoofd[id]."');\">
                        <img src='".$_SESSION[http_images]."edit.png'> Wijzig</a> 
                    &nbsp;  &nbsp;  &nbsp; 
                    <a href='javascript:void(0);' 
                        onClick=\"rieDeactiveer2('hoofdcategorie','".$hoofd[id]."','');\">
                        <img src='".$_SESSION[http_images]."kruis.png'> Deactiveer</a> 
                    &nbsp; &nbsp; &nbsp;"
                );
			elseif($_SESSION[aard]=="cpa") 
			{
				print("
                <a href='javascript:void(0);' 
                    onClick=\"SubCategorierie('".$hoofd[id]."','nieuw','".$hoofd[id]."','".$hoofd[naam]."');\">
                    <img src='".$_SESSION[http_images]."nieuw.png'> Nieuwe subcategorie (Voorstel)</a> 
                &nbsp; &nbsp; &nbsp; "
                );
                
				if($hoofd[actief]=="1")
                    print("
                    <a href='javascript:void(0);' 
                        onClick=\"categorierie('".$hoofd[id]."','wijzig','".$hoofd[id]."');\">
                        <img src='".$_SESSION[http_images]."edit.png'> Wijzig (Voorstel)</a>"
                        );
				else print("In behandeling");
				print(" &nbsp;  &nbsp;  &nbsp;");
			}
			
			print(" 
            <a href='javascript:void(0);' 
                onClick=\"rie('".$hoofd[id]."','hoofd','".$hoofd[id]."','".$hoofd[naam]."');\">
                <img src='../images/download.png'> Overzicht Documenten (".aantal_rie($link,"hoofd",$hoofd[id]).")</a>
    		<div id='hoofd_".$hoofd[id]."'></div></div>"
            );
			
			
		}
		
		print("
		
		<h3><a href='javascript:void(0);'>Verwijderde structuren (tijdelijke prullenbak)</a></h3><div id='verwijderd'>");
		
			//inactieve structuren
				print("
                    <table id='dataTable' border=1 width=80%>
                        <thead>
                            <tr>
                                <td>Naam</td>
                                <td>Actie</td>
                            </tr>
                        </thead>
                    <tbody>"
                );
				
				
				
				
				
				
				print("</table>");
		
		
		
		print("</div></div>
		");
	}


 	

else print("Sessie verlopen");
?>