<?php

session_start();

if(($_SESSION[login]=="wos_coprant") and ($_SESSION[vik]!=""))
{
	print("
    <h1>Beheer RIE structuur 
        &nbsp; &nbsp; &nbsp; 
    	<a href='javascript:void(0);' 
            onClick=\"categorieVik('nieuw','');\">
            <img src='".$_SESSION[http_images]."nieuw.png'> Nieuwe hoofdcategorie
        </a>
    </h1>
    <br /><br />
	<script>laadVikStructuur();</script>
	<div id='vikStructuur'><img src='../images/progress.gif'></div>
	<div id='vikHoofd'></div>
	<div id='vikSub'></div>
	<div id='feedback'></div>
	<div id='vikArtikel'></div>");

 	
}
else print("Sessie verlopen");
?>