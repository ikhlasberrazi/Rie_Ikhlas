<?php

session_start();

if(($_SESSION[login]=="wos_coprant") and ($_SESSION[vik]!=""))
{
	$db_hulp="vik";
	$titel_hulp="VIK";
	print("<h1>Voorstellen ".$titel_hulp." beheren&nbsp;  &nbsp;  &nbsp; </h1><br /><br />");
	
	//weergave van hoofdcategorie  	
 	$q_hoofd=
     "select * 
     from ".$db_hulp."_categorie_hoofd
      where actief='2'
      order by naam";
 	//print($q_hoofd."<br />");
	$r_hoofd=mysqli_query($link,$q_hoofd);
 	if(mysqli_num_rows($r_hoofd)>"0")
 	{
		print("<h3>Hoofdcategorie:</h3><br />");							
		
        //knopfinctue toegevoegd
		while($hoofd=mysqli_fetch_array($r_hoofd))
		{
			$id = $hoofd[id];
			print($hoofd[naam]." &nbsp; &nbsp; &nbsp;<a href='' onClick=\"Actiecategorie('aanvaard','$id')\">[aanvaard]</a>&nbsp; &nbsp; &nbsp;<a href='' onClick=\"Actiecategorie('weiger','$id')\">[weiger]</a><br />");			
		}
	}
	
	//weergave van subcategorie 	
 	$q_sub=
     "select t1.*,t2.naam as hoofd 
     from ".$db_hulp."_categorie_sub as t1 
     left join ".$db_hulp."_categorie_hoofd as t2 
     on t1.id_hoofd=t2.id 
     where t1.actief='2' 
     order by t1.naam";
     
 	//print($q_sub."<br />");
 	$r_sub=mysqli_query($link,$q_sub);
 	if(mysqli_num_rows($r_sub)>"0")
 	{
		print("<br /><br /><h3>Subcategorie:</h3><br />");							
		
		while($sub=mysqli_fetch_array($r_sub))
		{
			$id= $sub[id];
		          //knopfinctue toegevoegd
			print($sub[hoofd].": ".$sub[naam]." &nbsp; &nbsp; &nbsp; <a href='' onClick=\"Actiecategorie('aanvaardsub','$id')\">[aanvaard]</a>&nbsp; &nbsp; &nbsp;<a href='' onClick=\"Actiecategorie('weigersub','$id')\">[weiger]</a><br />");			
		}
	}
	
	//weergave van artikels	
 	$q_artikel=
     "select t1.*,t2.naam as hoofd,t3.naam as sub 
     from ".$db_hulp."_artikel as t1 
     left join ".$db_hulp."_categorie_hoofd as t2 
     on t1.id_hoofd=t2.id 
     left outer join ".$db_hulp."_categorie_sub as t3 
     on t3.id=t1.id_sub 
     where t1.actief='2' 
     order by t1.naam";
 	//print($q_artikel."<br />");
    
 	$r_artikel=mysqli_query($link,$q_artikel);
 	if(mysqli_num_rows($r_artikel)>"0")
 	{
		print("<br /><br /><h3>Artikel:</h3><br />");							
		
		while($artikel=mysqli_fetch_array($r_artikel))
		{
			$id= $artikel[id];
		          //knopfinctue toegevoegd
			print($artikel[hoofd]."-".$artikel[sub].": ".$artikel[naam]." &nbsp; &nbsp; &nbsp;<a href='' onClick=\"Actiecategorie('aanvaardartikel','$id')\">[aanvaard]</a>&nbsp; &nbsp; &nbsp;<a href='' onClick=\"Actiecategorie('weigerartikel','$id')\">[weiger]</a><br />");		
		}
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