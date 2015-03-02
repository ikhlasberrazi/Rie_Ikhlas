<?php
//komt overeen met vikcategorie.php
session_start();

if(($_SESSION[login]=="wos_coprant") and ($_SESSION[rie]!=""))
{
	print("
    <h1>Beheer Rie vragen 
        &nbsp; &nbsp; &nbsp; 
    	<a href='javascript:void(0);' 
            onClick=\"vraagRie('Vraag','');\">
            <img src='".$_SESSION[http_images]."nieuw.png'> Nieuwe Vraag
        </a>
		<a href='javascript:void(0);' 
            onClick=\"onderdeelRie('Onderdeel','');\">
            <img src='".$_SESSION[http_images]."nieuw.png'> Nieuw Onderdeel
        </a>
    </h1>
    <br /><br />
	<script>laadLijst();</script>
    <div id='voegVraagToe'></div>
    <div id='accordion'>
		<h3>Actieve vragen</h3>
		<div id='vragenLijst'><img src='../images/progress.gif'></div>
		<h3>Inactieve vragen</h3>
		<div id='invragenLijst'><img src='../images/progress.gif'></div>
		<h3>Actieve onderdelen</h3>
		<div id='onderdelenLijst'><img src='../images/progress.gif'></div>
		<h3>Inactieve onderdelen</h3>
		<div id='inonderdelenLijst'><img src='../images/progress.gif'></div>
	</div>
   	
    <div id='feedback'></div>");
    //functies uit rie.js vb #vragenLijst vullen vorige divs indien er data is
 
}
else print("Sessie verlopen");

?>