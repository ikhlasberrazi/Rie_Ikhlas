//dialog form structuur laden in rie.php case structuur
function laadVragenLijstRie()
{


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
}//einde laadvragenlijst

function rieDeactiveerVraag(aard,id,id_hulp)
{
	
	$.post("jq/rie.php",{actie:'deactiveerVraag',aard:aard,id:id}, function(data) 
	{
		
		if(aard=="actieveLijst") $('div#feedback').bind('dialogclose', function(event) {location.reload(true); });
		feedback(data);
	});
}// einde riedeactiveer vraag

function rieActiveerVraag(aard,id)
{
	$.post("jq/rie.php",{actie:'activeerVraag',aard:aard,id:id}, function(data) 
	{
		$('div#feedback').bind('dialogclose', function(event) {location.reload(true); });
		feedback(data);
	});
}//einde rieActiveer

function vraagRie(id_hoofd,actie,id)
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
				
				$.post("jq/rie.php",$("#VragenFormID").serialize(), function(data) 
				{
                    //alert("case opslaan");
					feedback("<center><img src='../images/progress.gif'></center>");
					
					switch(data)
				 	{
						case '0':
							feedback(data);
						break;
									
						default:
							if(data>'0')
							{
								$("#voegVraagToe").dialog("close");
								feedback(data);
							}
						break;
					}
				});
                //pagina herladen om meteen nieuwste data te zien
                location.reload();
                
			}//einde opslaan
		}
    };

	
	$("#voegVraagToe").dialog(dialogOpts);
	$("#voegVraagToe").dialog({title: 'Vragen toevoegen: ' + actie});
    $("#voegVraagToe").dialog("open");
}//einde vraag rie


