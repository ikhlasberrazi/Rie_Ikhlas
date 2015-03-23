<?php
if(($_SESSION[aard]=="super") and ($_SESSION[school_id]=="0"))
{
    //printen van tabs in header als superuser
	print("
        <div class=\"ubercolortabs\">
            <ul>
            	
                
                 <li>
                    <a href='index.php?pad=school&go=vragenlijst'"); 
                    if($go=="vragenlijst") 
                    print(" id='menu_actief'"); 
                    print("><span>Risicoanalyses</span></a>
                </li> 
                 <li>
                    <a href='index.php?pad=school&go=vragendatabase'"); 
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