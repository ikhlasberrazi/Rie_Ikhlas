<?php
if($_SESSION[login]=="wos_coprant")
{	

include_once("../config/dbi.php");
include_once("../config/config.php");
include_once("config/config.php");

//print("scholengemeenschap: ".$_SESSION[scholengemeenschap]."<br />"); 
//print("aard: ".$_SESSION[aard]."<br />"); 
//print("school_id: ".$_SESSION[school_id]."<br />"); 


if($_POST[start_school]=="1")
{
	if($_POST[school_id]!="") $_SESSION[school_id]=$_POST[school_id];
}
elseif($_GET[start_school]=="2") 
{
	$_SESSION[school_id]="0";
	$_SESSION[hoofdcampus]="";
	
	if($_SESSION[aard]=="super") $pagina="../beheer/schooladmin";
}

//include_once("../config/dbi_school.php");


print("
    <div class=cmsmenu>
    <table width='100%' border=0><tr>
    	<td valign=top rowspan='2'>
            <img src=".$_SESSION[http]."images/wos.jpg height='70'>
        </td>
        <td valign=top>
            <h1>
                ".$naam_app." ".$versie_app."
            </h1>
            <h3>
                ".$omschrijving_app."
            </h3>
        </td>
        <td valign=top>
");

//controle abonnement
/*
if(($_SESSION['aard']=="school") or ($_SESSION['aard']=="cpa"))
{
	if($_SESSION['aard']=="school") 
        $q_abo=
            "select * 
            from agora_scholen 
            where id='".$_SESSION['school_id']."' limit 1";
    
	if($_SESSION['aard']=="cpa") 
        $q_abo=
        "select * 
        from agora_scholengemeenschap 
        where id='".$_SESSION[scholengemeenschap]."' limit 1";
	
    pq($q_abo."<br />");
	$r_abo=mysqli_query($link,$q_abo);
	
	$abo=mysqli_fetch_array($r_abo);
	$datum_abonnement=$abo[abonnement];
	
	if($abo[abonnement]<date("Y-m-d")) $_SESSION[abo]="0";
	else $_SESSION[abo]="1";
}
elseif($_SESSION['aard']=="super") $_SESSION[abo]="1";
*/

//print("Abonnement: ".$_SESSION[abo]."<br />");
	
//weergave TB
if(($_SESSION['aard']=="school") or ($_SESSION['aard']=="lkt"))
{
	if($_SESSION[school_id]!="0")
	{
		//zoek school op en geef weer
		$q_school=
            "select naam 
            from agora_campus 
            where school_id='".$_SESSION[school_id]."' and aard='Hoofdcampus'";
            
		pq($q_school);
		$r_school=mysqli_query($link,$q_school);
		if(mysqli_num_rows($r_school)=="1")
		{
			$school=mysqli_fetch_array($r_school);
			print("School: ".$school[naam]."&nbsp; &nbsp; &nbsp;");
			//if($_SESSION[aantal_scholen]>"1") print("<a href='index.php?start_school=2'>[ wijzig TB ]</a>");
		}
	}
}
print("&nbsp; &nbsp;  &nbsp;Welkom ".$_SESSION[naam]." &nbsp; &nbsp; &nbsp; &nbsp; ");

print($_SESSION[instellingsnaam]." &nbsp;  &nbsp;  &nbsp;  &nbsp; ");

print("
    <a 
        href='#' 
        onclick=\"window.close();\" 
        style='background:#CC9; 
        text-decoration:none;
        padding-left:5px;
        padding-right:5px;'> 
            X ".$naam_app." sluiten 
    </a>"
);

print("
            <br /><br />
            <a href='index.php'>
                Home
            </a>
            &nbsp; &nbsp;  &nbsp;
            <a href='index.php?pad=../agora&go=nieuws&agora=".$link_app."'>
                Nieuws
            </a> 
            &nbsp; &nbsp;  &nbsp;
            <a href='index.php?pad=../agora&go=bugs&agora=".$link_app."'>
                Fouten / suggesties
            </a> 
            &nbsp; &nbsp;  &nbsp;
            <a href='index.php'>
                FAQ
            </a> 
        </td>
    </tr>
    
    <tr><td colspan=2 valign=bottom align=right>
");

//variabelen uit post of get halen
if($_GET[go]) 
	{
	 $go=$_GET[go];
	 $deel=$_GET[deel];
	 if($_GET[pad]!="") $pagina=$_GET[pad]."/".$go;
	}
else 
	{
	 $go=$_POST[go];
	 $deel=$_POST[deel];
	 if($_POST[pad]!="") $pagina=$_POST[pad]."/".$go;
	}

if($_SESSION[abo]=="1")
{
	switch($_SESSION['aard'])
	{
		case school: {if($_SESSION[school_id]!="0") include_once("menu/school.php");} break;
		case subgroep: {if($_SESSION[school_id]!="0") include_once("menu/school.php");} break;
		case lkt: {if($_SESSION[school_id]!="0") include_once("menu/school.php");} break;
		case super: include_once("menu/super.php"); break;
		case cpa: include_once("menu/cpa.php"); break;
	}
}

//print("abo:".$_SESSION[abo]."<br />");

//print("</td></tr></table></td></tr></table></div>");
print("</td></tr></table></div>");

//variabelen uit post of get halen
if($_GET[go]) 
	{
	 $go=$_GET[go];
	 if($_GET[pad]!="") $pagina=$_GET[pad]."/".$go;
	}
else 
	{
	 $go=$_POST[go];
	 if($_POST[pad]!="") $pagina=$_POST[pad]."/".$go;
	}

//middelste gedeelte
print("<div class=cmsmidden>");
if(isset($pagina) and ($_SESSION[abo]=="1"))
{
 pq($pagina);
 
 //pagina opzoeken en weergeven
 
$bestand=$pagina.".php";
pq("Bestand:".$bestand."<br>");
pq("hoofdcampus".$_SESSION[hoofdcampus]);
if(is_file($bestand) and $bestand!=".php") include_once("$bestand");
}
elseif(($_SESSION[school_id]=="0") and ($_SESSION[aard]=="school"))
{
	//controle aantal scholen
	//$q_schoolaccess="select *,".$_SESSION['db_prefix']."scholen.naam  from ".$_SESSION['db_prefix']."schoolaccess,".$_SESSION['db_prefix']."scholen where ".$_SESSION['db_prefix']."schoolaccess.user_id='".$_SESSION['user_id']."' and ".$_SESSION['db_prefix']."schoolaccess.school_id=".$_SESSION['db_prefix']."scholen.id";
	$q_schoolaccess="select t1.*,t2.abonnement from agora_campus as t1 inner join agora_scholen as t2 on t2.id=t1.school_id where t1.id_pa='".$_SESSION['user_id']."' and t1.aard='Hoofdcampus'";
	//print($q_schoolaccess);
	$r_schoolaccess=mysqli_query($link,$q_schoolaccess);
	
	if(mysqli_num_rows($r_schoolaccess)=="1") 
	{
		$school=mysqli_fetch_array($r_schoolaccess);
		$_SESSION[school_id]=$school[school_id];
		
		print("U beheert de wettelijke controles van ".$_SESSION[tb_nr]." - ".$school[naam].", ".$school[adres]."<br /><br /> >>>> <a href='index.php'>Ga verder</a> <<<<");
			print("<script type=\"text/javascript\">
				<!--
				window.location = \"index.php\"
				//-->
				</script>
				");
	}
	else
	{
		/*//scholen in een array
		$q_scholen="select * from ".$_SESSION['db_prefix']."campus order by naam";
		$r_scholen=mysqli_query($link,$q_scholen);
		
		if($_SESSION[aantal_scholen]>"0")
		{
			while($rij=mysqli_fetch_array($r_scholen))
			{
				$id=$rij[id];
				$school[$id]="TB ".$rij[tb_nr]." - ".$rij[naam]." ".$rij[adres].",".$rij[postcode]." ".$rij[plaats];
			}
		}*/
		print("<div class='kies_entiteit'><br /><br />Beste gebruiker,<br /><br />U werkt volgens onze gegevens voor 2 technische bedrijfseenheden (TB). Kies hieronder de juiste entiteit om verder te gaan:<br /><br /><form action=index.php method=post><input type=hidden name='start_school' value='1'>");
		$hulp="0";
		$_SESSION[aantal_scholen]=mysqli_num_rows($r_schoolaccess);
		
		print("<table border='1'>
			<tr><td>Entiteit</td><td>Abonnement ".$naam_app."</td></tr>");
		
		while($rij=mysqli_fetch_array($r_schoolaccess))
		{
			if($rij[abonnement]>date("Y-m-d"))print("<tr><td><input type=radio name=school_id value='".$rij[school_id]."' />".$rij[naam].", ".$rij[adres].", ".$rij[postcode]." ".$rij[plaats]." </td><td>".$rij[abonnement]."</td></tr>");
			else print("<tr><td>".$rij[naam].", ".$rij[adres].", ".$rij[postcode]." ".$rij[plaats]."</td><td><font color=red><b>VERLOPEN ".$rij[abonnement]." > ".date("Y-m-d")."</b></font></td></tr>");
			$hulp++;
		}
		
		if($hulp>"0") print("<tr><td colspan='2' align=center><input type=submit value='Bevestig keuze'></td></tr></table></form><br />");
	}
}
elseif(($_SESSION[abo]=="1") or ($_SESSION[aard]=="cpa") or ($_SESSION[aard]=="super")) 
{
	if(($_SESSION['aard']=="school") or ($_SESSION['aard']=="lkt"))
	{
		include_once("school/home.php");
	}
	elseif(($_SESSION['aard']=="cpa") and ($_SESSION[school_id]=="0"))
	{
		include_once("school/home.php");
	}
	elseif((($_SESSION['aard']=="cpa") or ($_SESSION['aard']=="super")or ($_SESSION['aard']=="subgroep")) and ($_SESSION[school_id]!="0"))
	{
		
		//$q_select="select t1.EDPBW,t1.id as school_id,t2.naam as pa_naam, t2.email as pa_email,t2.tel as pa_tel,t3.* from agora_scholen as t1 left join agora_campus as t3 on t3.school_id=t1.id left JOIN agora_login as t2 on t3.id_pa=t2.id where t3.aard='hoofdcampus' and t1.id='".$_SESSION[school_id]."' order by t3.naam limit 1";
		$q_select="
			select t1.EDPBW,t1.id as school_id,
				t2.naam as pa_naam, t2.email as pa_email,t2.tel as pa_tel,
				t3.* 
			from agora_scholen as t1 
				left join agora_campus as t3 on t3.school_id=t1.id 
left join agora_rechten as t4 on t4.id_school=t1.id
				left JOIN agora_login as t2 on t4.id_login=t2.id 
			where t3.aard='hoofdcampus' and t1.id='".$_SESSION[school_id]."' and t4.aard='school'
			order by t3.naam limit 1 ";
		print($q_select."<br />");
		$r_select=mysqli_query($link,$q_select);
		if(mysqli_num_rows($r_select)=="1")
		{
			$select=mysqli_fetch_array($r_select);
			print("<h2>U heeft zich aangemeld voor: ".$select[naam].", ".$select[adres].",".$select[postcode]." ".$select[plaats]."</h2><br />");
			$_SESSION[school_naam]=$select[naam];
			
			include_once("school/home.php");
		}
		
	}
	else
	{
		print("U bent aangemeld als superbeheerder!<br /><br />");
		
		
		include_once("beheer/voorstel.php");
	}
}
else
{
	print("<br /><br /><br /><center><h2><font color=red>Het abonnement is verlopen op ".draaidatum($abo[abonnement],"-")."! Neem contact op met .... om uw abonnement te verlengen!</font></h2>");
}
print("</div>");	
mysqli_close($link);
}
else 
{
	include_once("index.php");
}
?>