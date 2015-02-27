<?php
	session_start();
	$_SESSION[login]="wos_coprant";
	$_SESSION[instellingsnaam]="Stella Maris";
	$_SESSION['naam']="gebruiker";
	/*$_SESSION['user_id']="1";
	$_SESSION['school_id']="1";
	$_SESSION['scholengemeenschap']="1";
	$_SESSION['gb']="schoolgebruiker";;
	$_SESSION['vnaam']="school";
	$_SESSION['overeenkomst']="2014-11-01"; //iedereen moet de gebruikersovereenkomst invullen!!
	$_SESSION[laatste_login]="2014-11-01";
	$_SESSION[aard]="school";
	$_SESSION[aantal_scholen]="1";
	$_SESSION[abo]="1";
		
//rechten: enkel de laatste zou geselecteerd moeten zijn alle andere moeten weg!!	
	$_SESSION[arbeidsmiddelen]="beheer";
	$_SESSION['weveco']="beheer";
	$_SESSION[vik]="beheer";*/

	
?>

<script>

    window.location.assign("http://localhost:8080/agora/jaarverslag/index.php");

</script>