<?php
if(($_SESSION[aard]=="super") and ($_SESSION[school_id]=="0"))
{
	print("
        <div class=\"ubercolortabs\">
            <ul>
            	<li>
                    <a href='index.php?pad=school&go=startvik2'"); 
                    if($go=="startvik2") 
                    print(" id='menu_actief'"); 
                    print("><span>Databank VIK</span></a>
                </li> 
        	</ul>
    	</div>
	");
	
	//<td align=center valign=bottom><a href='index.php?pad=beheer&go=nieuwescholen'>Nieuwe scholen</a></li><td align=center valign=bottom><a href='index.php?pad=beheer&go=schooladmin'>Scholen</a></li>*
}
elseif(($_SESSION[aard]=="super") and ($_SESSION[school_id]!="0"))
{
	include_once("menu/school.php");
}
else
{
	session_destroy();
	include("index.php");
}

/*

*/
?>