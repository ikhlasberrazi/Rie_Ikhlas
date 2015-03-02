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
    
    <script>analyseLijst();</script>
     <div id='voegVraagToe'></div>
   	<div id='lijsten'></div>
    <div id='feedback'></div>");
    //functies uit rie.js vb #vragenLijst vullen vorige divs indien er data is
 
}
else print("Sessie verlopen");

?>