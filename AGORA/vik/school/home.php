<?php
	
	if($_SESSION[aard]=="school")$_GET[id]='22';
	else $_GET[id]="21";
	
	print_laatste_nieuws($link,"vik","5");
	
	print("<div id='leesbericht'></div><br /><br />");
	
	include_once("../agora/pagina.php");
?>