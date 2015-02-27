//INFO
function laadLijstRie()
{
    alert("tadaaaaaaa");
    //vragen
    $("#vragenLijst").html("<img src='../images/progress.gif' />");
    
    $.post("jq/rie.php",{actie:"actieveVragenlijst"}, function(data) 
    {
    	$("#vragenLijst").html(data);
    	$( "#accordion" ).accordion();
    });
    $.post("jq/rie.php",{actie:"inactieveVragenlijst"}, function(data) 
    {
    	$("#invragenLijst").html(data);
    	$( "#accordion" ).accordion();
    });			
    
    //onderdelen
    //$("#onderdelenLijst").html("<img src='../images/progress.gif' />");
    
    $.post("jq/rie.php",{actie:"actieveOnderdelenLijst"}, function(data) 
    {
    	$("#onderdelenLijst").html(data);
    	$( "#accordion" ).accordion();
    });
    $.post("jq/rie.php",{actie:"inactieveOnderdelenlijst"}, function(data) 
    {
    	$("#inonderdelenLijst").html(data);
    	$( "#accordion" ).accordion();
    });		

}//einde laadvragenlijst



function rieDeactiveerVraag(aard,id)
{
    alert("deactiveer");
    
        alert("deactiveervragen");
            $.post("jq/rie.php",{actie:'deactiveerVraag',aard:aard,id:id}, function(data) 
    	{
    		
    		if(aard=="actieveLijst") $('div#feedback').bind('dialogclose', function(event) {location.reload(true); });
    		feedback(data);
    	});
    
	
	
}// einde riedeactiveer vraag
function rieDeactiveerOnderdeel(aard,id)
{
    alert("deactiveer");
    
        alert("deactiveerOnderdeel");
            $.post("jq/rie.php",{actie:'deactiveerOnderdeel',aard:aard,id:id}, function(data) 
    	{
    		
    		if(aard=="actieveLijst") $('div#feedback').bind('dialogclose', function(event) {location.reload(true); });
    		feedback(data);
    	});
    
	
	
}// einde riedeactiveer onderdeel
function rieActiveer(aard,id)
{
    if(aard == 'activeerVraag')
    {
    	$.post("jq/rie.php",{actie:aard,id:id}, function(data) 
    	{
    		$('div#feedback').bind('dialogclose', function(event) {location.reload(true); });
    		feedback(data);
    	});
    }
    if(aard == 'activeerOnderdeel')
    {
    	$.post("jq/rie.php",{actie:aard,id:id}, function(data) 
    	{
    		$('div#feedback').bind('dialogclose', function(event) {location.reload(true); });
    		feedback(data);
    	});
    }
}//einde rieActiveer

function vraagRie(actie,id)
{
  
	var dialogOpts = 
	{
        modal: true,
        autoOpen: false,
        closeOnEscape: false, //toegevoegd om te stoppen dat het scherm sluit op esc toets
        height: 200,
        width: 600,
		open:function() 
		{
			$("#voegVraagToe").html("<img src='../images/progress.gif' />");
			
			$.post("jq/rie.php",{actie:'vragenForm',id:id}, function(data) 
			{
				$("#voegVraagToe").html(data);
			});
		},
		buttons:
		{
			"Opslaan": function() 
			{				
				feedback("<center><img src='../images/progress.gif'></center>");
				
				$.post("jq/rie.php",$("#VragenFormID").serialize(), function(data) 
				{
                    //alert("case opslaan");
					
				

					$("#voegVraagToe").dialog("close");
					feedback(data);
					
				});
                
                 //pagina herladen om meteen nieuwste data te zien !!MAG NIET
                location.reload();
			}//einde opslaan
		}
    };
	//$("#vragenLijst").load("vragendatabase.php");
	$("#voegVraagToe").dialog(dialogOpts);
	$("#voegVraagToe").dialog({title: 'Vragen toevoegen: ' + actie});
    $("#voegVraagToe").dialog("open");
}//einde vraag rie

function onderdeelRie(actie,id)
{
  
	var dialogOpts = 
	{
        modal: true,
        autoOpen: false,
        closeOnEscape: false, //toegevoegd om te stoppen dat het scherm sluit op esc toets
        height: 200,
        width: 600,
		open:function() 
		{
			$("#voegVraagToe").html("<img src='../images/progress.gif' />");
			
			$.post("jq/rie.php",{actie:'onderdelenForm',id:id}, function(data) 
			{
				$("#voegVraagToe").html(data);
			});
		},
		buttons:
		{
			"Opslaan": function() 
			{				
				
				$.post("jq/rie.php",$("#VragenFormID").serialize(), function(data) 
				{
                    //alert("case opslaan");
					feedback("<center><img src='../images/progress.gif'></center>");
					
					$("#voegVraagToe").dialog("close");
					feedback(data);
					
					}
				});
                //pagina herladen om meteen nieuwste data te zien !!MAG NIET
                location.reload();
                
			}//einde opslaan
		}
    };

	
	$("#voegVraagToe").dialog(dialogOpts);
	$("#voegVraagToe").dialog({title: 'Onderdelen toevoegen: ' + actie});
    $("#voegVraagToe").dialog("open");
}//einde vraag rie


