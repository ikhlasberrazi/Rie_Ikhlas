<?php
session_start();

if( !isset($_SESSION['last_access']) || (time() - $_SESSION['last_access']) > 60 ) $_SESSION['last_access'] = time(); 


if($_SESSION[login]=="wos_coprant")
{
	if(($_SESSION[arbeidsmiddelen]!="") or ($_SESSION[aard]=="super"))
	{
?>

<!DOCTYPE HTML>
<html>
 
<head>
	<!-- enter key blokkeren van functie -->
	 <script type="text/javascript">
    function stopEnterKey(evt) {
        var evt = (evt) ? evt : ((event) ? event : null);
        var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
        if ((evt.keyCode == 13) && (node.type == "text")) { return false; }
    }
    document.onkeypress = stopEnterKey;
</script> 

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href='config/stijl.css' rel=stylesheet type=text/css>
	
	<style type="text/css" title="currentStyle">
		@import "../jq/css/demo_table.css";
		@import "../jq/css/jquery-ui.min.css";
	</style>
	
	<script type="text/javascript" src="../jq/jquery.min.js"></script>
	<script type="text/javascript" src="../jq/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" src="../jq/jquery-ui.min.js"></script>
	<script type="text/javascript" src="../jq/jquery.cookie.js"></script>
	<script type="text/javascript" src="../jq/jquery.dataTables.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
	<!--<script src="//johnny.github.io/jquery-sortable/js/jquery-sortable.js"></script>-->
	<script type="text/javascript" src="../jq/uploader_html5.js"></script>
	<script type="text/javascript" src="../jq/start.js.php"></script>
    



	
	<script type="text/javascript" src="jq/rie.js"></script>
    <script type="text/javascript" src="jq/rieAnalyses.js"></script>	
	
	<script language="JavaScript">
	$(document).ready(function(){
	test_cookie();
	});
	</script>
	
	</head>
	
	<body>
	<div id='start'>
	<?php
		
	//alert(f + " bytes");
	
	if($_GET[stop]=="1")
	{
	 include_once("loguit.php");
	}
	
	if(($_POST[login]) or $_GET[autologin])
	{
	   include_once("checklogin.php");
	}
	
	if($_SESSION['login']!="wos_coprant")
	{
	   include_once("login.php");
	}
	else
	{
	   include_once("layout.php");
	}
	
	?>
	
	</td></tr></table>
	</div>
	</body>
	
	<div id='cookies'>
    	<br /><br /><center>
    	<img src='images/wos.jpg'><br />
        <br />
    	   Deze website gebruikt cookies.
        <br />
        <br /> 
            Wij hebben vastgesteld dat uw browser geen cookies accepteert. 
        <br />
        <br />
            Klik op onderstaande browsers om de handleiding te downloaden.
        <br /><br /><br /><br />
            <a href='upload/cookie_iexplorer.pdf' target='_blank'>
                <img src='images/iexplorer.png'></a> 
            &nbsp;  &nbsp;  &nbsp; 
            <a href='upload/cookie_firefox.pdf' target='_blank'>
                <img src='images/firefox.png'></a>  
            &nbsp;  &nbsp;  &nbsp; 
            <a href='upload/cookie_safari.pdf' target='_blank'>
                <img src='images/safari.png'></a> 
            &nbsp;  &nbsp;  &nbsp; 
            <a href='upload/cookie_chrome.pdf' target='_blank'>
                <img src='images/chrome.png'></a> 
            &nbsp;  &nbsp;  &nbsp; 
            <a href='upload/cookie_opera.pdf' target='_blank'>
                <img src='images/opera.png'></a>
	</div> <!--einde div cookies-->

<?php
	}//einde "if(($_SESSION[arbeidsmiddelen]!="") or ($_SESSION[aard]=="super"))"
	else print("U heeft geen toegang tot Arbeidsmiddelen!");
} //einde "if($_SESSION[login]=="wos_coprant")"
else print("fout bij opstart!"); //header("location:'".$_SESSION[http]."'");
?>