<?php
//komt overeen met vikcategorie.php
session_start();

if(($_SESSION[login]=="wos_coprant") and ($_SESSION[rie]!=""))
{
	print("
    <h1>Beheer Rie onderdelen 
        &nbsp; &nbsp; &nbsp; 
    	<a href='javascript:void(0);' 
            onClick=\"onderdeelRie('nieuw','');\">
            <img src='".$_SESSION[http_images]."nieuw.png'> Nieuw onderdeel
        </a>
    </h1>
    <br /><br />
	<script>laadOnderdelenLijstRie();</script>
    <div id='voegVraagToe'></div>
    <div id='accordion'>
    <h3>Actieve Onderdelen</h3>
    <div id='onderdelenLijst'><img src='../images/progress.gif'></div>
    <h3>Inactieve onderdelen</h3>
    <div id='inonderdelenLijst'></div>
</div>
   	
    <div id='feedback'></div>");
    //functies uit rie.js vb #onderdelenLijst vullen vorige divs indien er data is
 
}
else print("Sessie verlopen");

?>