<?php
session_start();
	
if($_SESSION[login]=="wos_coprant")
{
	//echo "login";
?>

<!DOCTYPE HTML>
<html>
 
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href='config/stijl.css' rel=stylesheet type=text/css>
    </head>
	
	<body>
	<div id='start'>
	<?php
	if($_SESSION['login']=="wos_coprant")
	{
	include_once("layout.php");
	}	
	?>	
	</td></tr></table>
	</div>
	</body>
<?php
}
?>
