<?php

session_start();

if(($_SESSION[login]=="wos_coprant") and ($_SESSION[rie]!=""))
{
    
    if($_SESSION[aard]=="super" || $_SESSION[aard]=="cpa" || $_SESSION[aard]=="school") 
        print("
                <a 
                href='javascript:void(0);' 
                onClick=\"nieuweaudit('nieuw','');
                \">
                <img src='".$_SESSION[http]."images/nieuw.png'> Nieuwe audit</a>"
            );
    
	print("</h1><br /><br />");
	
	//hier code
    
    
		
		
		print("</div></div>
		");
	}


 	

else print("Sessie verlopen");
?>