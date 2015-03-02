//dialog form structuur laden in rie.php case structuur
function laadLijst()
{


	$("#vragenLijst").html("<img src='../images/progress.gif' />");
	//Vragen laden
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
	//Onderdelen laden
	$.post("jq/rie.php",{actie:"actieveOnderdelenLijst"}, function(data) 
	{
		$("#onderdelenLijst").html(data);
        $( "#accordion" ).accordion();
	});
    $.post("jq/rie.php",{actie:"inactieveOnderdelenLijst"}, function(data) 
	{
		$("#inonderdelenLijst").html(data);
        $( "#accordion" ).accordion();
	});
}//einde laadvragenlijst

function rieDeactiveer(casephp,aard,id)
{
	if (casephp=='actieveLijst')
	{
		$.post("jq/rie.php",{actie:'deactiveerVraag',aard:aard,id:id}, function(data) 
		{
			
			if(aard=="actieveLijst") $('div#feedback').bind('dialogclose', function(event) {location.reload(true); });
			feedback(data);
		});
	}
	else if(casephp=='actieveOnderdeel')
	{
		$.post("jq/rie.php",{actie:'deactiveerOnderdeel',aard:aard,id:id}, function(data) 
		{
			
			if(aard=="actieveOnderdeel") $('div#feedback').bind('dialogclose', function(event) {location.reload(true); });
			feedback(data);
		});
	}
	
}// einde riedeactiveer vraag

function rieActiveer(casephp,aard,id)
{
	if(casephp=='actieveLijst')
	{
		$.post("jq/rie.php",{actie:'activeerVraag',aard:aard,id:id}, function(data) 
		{
			$('div#feedback').bind('dialogclose', function(event) {location.reload(true); });
			feedback(data);
		});
	}
	else if (casephp == 'actieveOnderdeel')
	{
		$.post("jq/rie.php",{actie:'activeerOnderdeel',aard:aard,id:id}, function(data) 
		{
			$('div#feedback').bind('dialogclose', function(event) {location.reload(true); });
			feedback(data);
		});
	}
}//einde rieActiveer

function vraagRie(actie, id)
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
			if(actie=='nieuweVraag')
			{
				$("#voegVraagToe").html("<img src='../images/progress.gif' />");
			
				$.post("jq/rie.php",{actie:'vragenForm',id:id}, function(data) 
				{
				$("#voegVraagToe").html(data);
				});
			}
			else if (actie='nieuwOnderdeel')
			{
				$("#voegVraagToe").html("<img src='../images/progress.gif' />");
			
				$.post("jq/rie.php",{actie:'onderdelenForm',id:id}, function(data) 
				{
				$("#voegVraagToe").html(data);
				});
			}
			
		},
		buttons:
		{
			"Opslaan": function() 
			{				
				if (actie == 'nieuweVraag')
				{
					$.post("jq/rie.php",$("#VragenFormID").serialize(), function(data) 
					{
						//alert("case opslaan");
						feedback("<center><img src='../images/progress.gif'></center>");
						
						$("#voegVraagToe").dialog("close");
						feedback(data);
					});
				}
				else if (actie == 'nieuwOnderdeel')
				{
					$.post("jq/rie.php",$("#onderdelenFormID").serialize(), function(data) 
					{
						//alert("case opslaan");
						feedback("<center><img src='../images/progress.gif'></center>");
						
						$("#voegVraagToe").dialog("close");
						feedback(data);
					});
				}
				
				
                //pagina herladen om meteen nieuwste data te zien
                location.reload();
                
			}//einde opslaan
		}
    };

	
	$("#voegVraagToe").dialog(dialogOpts);
	$("#voegVraagToe").dialog({title: 'Vragen toevoegen: ' + actie});
    $("#voegVraagToe").dialog("open");
}//einde vraag rie


