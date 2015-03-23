 <?php
	session_start();
	$_SESSION[login]="wos_coprant";
	$_SESSION['user_id']="1";
	$_SESSION['school_id']="0";
	$_SESSION['scholengemeenschap']="0";
	$_SESSION['gb']="schoolgebruiker";
	$_SESSION['naam']="Berrazi";
	$_SESSION['vnaam']="Ikhlas";
	$_SESSION['overeenkomst']="2014-11-01"; //iedereen moet de gebruikersovereenkomst invullen!!
	$_SESSION[laatste_login]="2014-11-01";
	$_SESSION[aard]="super";
	$_SESSION[aantal_scholen]="1";
	$_SESSION[abo]="1";
		
//rechten: enkel de laatste zou geselecteerd moeten zijn alle andere moeten weg!!	
	$_SESSION[arbeidsmiddelen]="beheer";
	$_SESSION['weveco']="beheer";
	$_SESSION[rie]="beheer";

	
?>

<script>

    window.location.assign("http://localhost:8080/agora/vik/index.php");

</script>