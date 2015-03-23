<?php

session_start();

if(($_SESSION[login]=="wos_coprant") and ($_SESSION[arbeidsmiddelen]!=""))
{
	print("<h1>Databank VIK</h1><br /><br />
	<script>laadVikStructuur();</script>
	<div id='vikStructuur'><img src='../images/progress.gif'></div>
	<div id='vik'></div>
	<div id='vikUpload'></div>
	<div id='vikEdit'></div>
	<div id='feedback'></div>
	<div id='download'></div>
	");

 	
}
else print("Sessie verlopen");
?>