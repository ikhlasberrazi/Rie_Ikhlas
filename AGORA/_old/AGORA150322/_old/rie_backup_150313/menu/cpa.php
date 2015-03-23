<?php

if(($_SESSION[aard]=="cpa") and ($_SESSION[school_id]=="0"))
{
	 //printen van tabs in header als superuser
	print("
        <div class=\"ubercolortabs\">
            <ul>
            	
                <li>
                    <a href='index.php?pad=school&go=startcategorie'"); 
                    if($go=="startcategorie") 
                    print(" id='menu_actief'"); 
                    print("><span>Categorie</span></a>
                </li> 
                 <li>
                    <a href='index.php?pad=school&go=startrie'"); 
                    if($go=="startrie") 
                    print(" id='menu_actief'"); 
                    print("><span>Risicoanalyses</span></a>
                </li> 
                 <li>
                    <a href='index.php?pad=school&go=startvragen'"); 
                    if($go=="startvragen") 
                    print(" id='menu_actief'"); 
                    print("><span>Database Vragen</span></a>
                </li> 
                 <li>
                    <a href='index.php?pad=beheer&go=meldingen'"); 
                    if($go=="meldingen") 
                    print(" id='menu_actief'"); 
                    print("><span>Meldingen</span></a>
                </li> 
                
                <strong></strong>
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