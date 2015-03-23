<?php

session_start();

if(($_SESSION[login]=="wos_coprant") and ($_SESSION[rie]!=""))
{
	print("
    <h1>Beheer RIE structuur 
        &nbsp; &nbsp; &nbsp; 
    	<a href='javascript:void(0);' 
            onClick=\"categorierie('nieuw','');\">
            <img src='".$_SESSION[http_images]."nieuw.png'> Nieuwe hoofdcategorie
        </a>
    </h1>
    <br /><br />
	<script>laadrieStructuur();</script>
	<div id='rieStructuur'><img src='../images/progress.gif'></div>
	<div id='rieHoofd'></div>
	<div id='rieSub'></div>
	<div id='feedback'></div>
	<div id='rieArtikel'></div>");

 	
}
else print("Sessie verlopen");
?>