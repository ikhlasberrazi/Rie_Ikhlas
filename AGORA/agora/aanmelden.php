<?php
if((($_SESSION['aard']=="cpa") or ($_SESSION['aard']=="super") or ($_SESSION['aard']=="subgroep")) and ($_SESSION['login']=="wos_coprant"))
{
	if($_GET[id]!="") $_SESSION[school_id]=$_GET[id];
	
	//opzoeken schoolnaam in db
	
	$q_school="SELECT * FROM agora_campus WHERE school_id='".$_SESSION[school_id]."' AND aard = 'Hoofdcampus'";
	pq($q_school."<br />");
	$r_school=mysqli_query($link,$q_school);
	if(mysqli_num_rows($r_school)=="1")
	{
		$school=mysqli_fetch_array($r_school);
		$_SESSION[school_naam]=$school[naam];
		$_SESSION[hoofdcampus]=$school[id];
	}
	
	print("schoolnaam:".$_SESSION[school_naam]." - id:".$_SESSION[hoofdcampus]."/".$_SESSION[school_id]." sg:".$_SESSION[scholengemeenschap]." subgroep:".$_SESSION[id_subgroep]." abo:".$_SESSION[abo]);
	
	print("<script type=\"text/javascript\">
	<!--
	window.location = \"index.php\"
	//-->
	</script>
	");
	
}
else
{
	print($pagina_niet_gevonden);
}
?>