<?php
if(($_SESSION['login']=="wos_coprant") and ($_SESSION['weveco']!=""))
{
	$q_campus=
    "select * 
    from agora_campus 
    where school_id='".$_SESSION[school_id]."'";
    
	pq($q_campus."<br />");
	$r_campus=mysqli_query($link,$q_campus);
	if($_SESSION['campus']!=mysqli_num_rows($r_campus)) $_SESSION['campus']=mysqli_num_rows($r_campus);
	
	mysqli_free_result($r_campus);
	
	print("
	   <div class=\"ubercolortabs\" style='float:left;'><ul>
    ");
	if(($_SESSION[aard]=="cpa") or ($_SESSION[aard]=="super")) print("<li><a href='javascript:void(0);'><span>".$_SESSION[school_naam]."</span></a></li>");
	print("
		<li><a href='index.php?pad=school&go=startvik2'"); if($go=="startvik2") print(" id='menu_actief'"); print("><span>Databank VIK</span></a></li> 
	");
	
	print("		
    	</ul>
    	</div>
	");
}
else
{
	session_destroy();
	include("index.php");
}
?>