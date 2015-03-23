<?php
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
    
    <script>laadAuditTabel();test();</script>
 
	<div id='auditTabel'></div>
	<div id='dialog'></div>
	<div id='dialog2'></div>
	<div id='laadForm'></div>
    <div id='feedback'></div>");
    
}
else print("Sessie verlopen");

?>