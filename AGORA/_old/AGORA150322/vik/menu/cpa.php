<?php

if(($_SESSION[aard]=="cpa") and ($_SESSION[school_id]=="0"))
{
	print("
        <div class=\"ubercolortabs\">
            <ul>
            	<li>
                    <a href='javascript:void(0);'><span>CPA</span></a>
                </li>	
            	<li>
                    <a href='index.php?pad=school&go=startvik2'"); 
                    if($go=="startvik") 
                    print(" id='menu_actief'"); 
                    print("><span>Databank VIK</span></a>
                </li> 
        	</ul>
    	</div>
	");
	//<li><a href='index.php?pad=../beheer&go=schooladmin'><span>Entiteit</span></a></li> 
	//<li><a href='index.php?pad=../beheer&go=gebruikers'><span>PA</span></a></li> 
	//<li><a href='index.php?pad=beheer&go=statistiek_totaal_keuringen'><span>Statistiek</span></a></li>
	//<li><a href='index.php?pad=school&go=uc'><span>Verslagen</span></a></li> 
	//<li><a href='index.php?pad=cpa&go=schoollijst'><span>Schoollijst afdrukken</span></a></li> 
}

elseif(($_SESSION[aard]=="cpa" or $_SESSION[aard]=="subgroep") and ($_SESSION[school_id]!="0"))
{
 	include_once("menu/school.php");
}
else
{
 	session_destroy();
	include("index.php");
}
?>