<?php
//komt overeen met vikcategorie.php
session_start();

if(($_SESSION[login]=="wos_coprant") and ($_SESSION[rie]!=""))
{
	print("
    <h1>Beheer Risicoanalyses
        &nbsp; &nbsp; &nbsp; 
    	<a href='javascript:void(0);' 
            onClick=\"analyseLijst();\">
            <img src='".$_SESSION[http_images]."nieuw.png'> Nieuwe Audit
        </a>
       
        
        
    </h1>
    <br /><br />
    
    <script>test();</script>
   	<div id='lijsten'></div>
	<div id='laadForm'></div>
    <div id='feedback'></div>");
    //functies uit rie.js vb #vragenLijst vullen vorige divs indien er data is
 
}
else print("Sessie verlopen");

?>