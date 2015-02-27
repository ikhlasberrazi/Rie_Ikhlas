<?php

session_start();

if(($_SESSION[login]=="wos_coprant") and ($_SESSION[vik]!=""))
{
	print("<h1>Databank VIK &nbsp;  &nbsp;  &nbsp; ");
	if($_SESSION[aard]=="super") 
        print("
                <a 
                href='javascript:void(0);' 
                onClick=\"categorieVik('nieuw','');
                \">
                <img src='".$_SESSION[http]."images/nieuw.png'> Nieuwe hoofdcategorie</a>"
            );
	elseif($_SESSION[aard]=="cpa") 
        print("<a 
            href='javascript:void(0);'
            onClick=\"categorieVik('voorstel','');\">
            <img src='".$_SESSION[http]."images/nieuw.png'> Nieuwe hoofdcategorie (Voorstel)</a>"
        );
	print("</h1><br /><br />");
	
	//weergave van hoofdcategorie RIE checklisten	
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
						header: \"h3\",
					    collapsible: true,
					    heightStyle: \"content\",
					    navigation: true,
						active:false 

					});
			    });
			    </script>
			
			<div id='accordion'>");
								
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
                        onClick=\"SubCategorieVik('".$hoofd[id]."','nieuw','".$hoofd[id]."','".$hoofd[naam]."');\">
                        <img src='".$_SESSION[http_images]."nieuw.png'> Nieuwe subcategorie</a> 
                    &nbsp; &nbsp; &nbsp; 
                    <a href='javascript:void(0);' 
                        onClick=\"categorieVik('".$hoofd[id]."','wijzig','".$hoofd[id]."');\">
                        <img src='".$_SESSION[http_images]."edit.png'> Wijzig</a> 
                    &nbsp;  &nbsp;  &nbsp; 
                    <a href='javascript:void(0);' 
                        onClick=\"vikDeactiveer2('hoofdcategorie','".$hoofd[id]."','');\">
                        <img src='".$_SESSION[http_images]."kruis.png'> Deactiveer</a> 
                    &nbsp; &nbsp; &nbsp;"
                );
			elseif($_SESSION[aard]=="cpa") 
			{
				print("
                <a href='javascript:void(0);' 
                    onClick=\"SubCategorieVik('".$hoofd[id]."','nieuw','".$hoofd[id]."','".$hoofd[naam]."');\">
                    <img src='".$_SESSION[http_images]."nieuw.png'> Nieuwe subcategorie (Voorstel)</a> 
                &nbsp; &nbsp; &nbsp; "
                );
                
				if($hoofd[actief]=="1")
                    print("
                    <a href='javascript:void(0);' 
                        onClick=\"categorieVik('".$hoofd[id]."','wijzig','".$hoofd[id]."');\">
                        <img src='".$_SESSION[http_images]."edit.png'> Wijzig (Voorstel)</a>"
                        );
				else print("In behandeling");
				print(" &nbsp;  &nbsp;  &nbsp;");
			}
			
			print(" 
            <a href='javascript:void(0);' 
                onClick=\"vik('".$hoofd[id]."','hoofd','".$hoofd[id]."','".$hoofd[naam]."');\">
                <img src='../images/download.png'> Overzicht Documenten (".aantal_vik($link,"hoofd",$hoofd[id]).")</a>
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
						print("<tr><td>Hoofdmap: ".$hoofd[naam]."</td><td align='right'>");
						if($_SESSION[aard]=="super") 
                            print("
                                <a href='javascript:void(0);' 
                                    onClick=\"vikActiveer2('hoofdcategorie','".$hoofd[id]."');\">
                                    <img src='".$_SESSION[http_images]."vink.png'> Activeer</a>"
                            );
						print("</td></tr>");
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
						print("<tr><td>Submap: ".$sub[naam]."</td><td align='right'>");
						if($_SESSION[aard]=="super") 
                            print("
                                <a href='javascript:void(0);' 
                                    onClick=\"vikActiveer2('subcategorie','".$sub[id]."');\">
                                    <img src='".$_SESSION[http_images]."vink.png'> Activeer</a>"
                            );
						print("</td></tr>");
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
						print("<tr><td>Artikel: ".$artikel[naam]."</td><td align='right'>");
						if($_SESSION[aard]=="super") 
                            print("
                                <a href='javascript:void(0);' 
                                    onClick=\"vikActiveer2('artikel','".$artikel[id]."');\">
                                    <img src='".$_SESSION[http_images]."vink.png'> Activeer</a>"
                            );
						print("</td></tr>");
					}
				}
				
				print("</table>");
		
		
		
		print("</div></div>
		");
	}
print("
	<div id='vikStructuur'>	</div>
	<div id='vik'></div>
	<div id='vikHoofd'></div>
	<div id='vikSub'></div>
	<div id='vikUpload'></div>
	<div id='vikEdit'></div>
	<div id='feedback'></div>
	<div id='download'></div>
	<div id='vikArtikel'></div>
	
	");

 	
}
else print("Sessie verlopen");
?>