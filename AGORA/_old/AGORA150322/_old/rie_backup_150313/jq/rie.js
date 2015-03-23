//dialog form structuur laden in rie.php case structuur
function laadLijst()
{
	//alert("laadRie");
//laadLijst(vraagofonderdeel, actiefnietactief) toevoegen aan accordion click

	$("#vragenLijst").html("<img src='../images/progress.gif' />");
	//Vragen laden
	$.post("jq/rie.php",{actie:"actieveVragenlijst"}, function(data) 
	{
		$("#vragenLijst").html(data);
        $( "#accordion" ).accordion({active: false, collapsible: true});
	});
    $.post("jq/rie.php",{actie:"inactieveVragenlijst"}, function(data) 
	{
		$("#invragenLijst").html(data);
        $( "#accordion" ).accordion({active: false, collapsible: true});
	});
	//Onderdelen laden
	$.post("jq/rie.php",{actie:"actieveOnderdelenLijst"}, function(data) 
	{
		$("#onderdelenLijst").html(data);
        $( "#accordion" ).accordion({active: false, collapsible: true});
	});
    $.post("jq/rie.php",{actie:"inactieveOnderdelenLijst"}, function(data) 
	{
		$("#inonderdelenLijst").html(data);
        $( "#accordion" ).accordion({active: false, collapsible: true});
	});
}//einde laadvragenlijst

function rieDeactiveer(casephp,aard,id)
{
	if (casephp=='actieveLijst')
	{
		$.post("jq/rie.php",{actie:'deactiveerVraag',aard:aard,id:id}, function(data) 
		{
			
			$('div#feedback').bind('dialogclose');
			feedback(data);
			laadLijst();
		});
	}
	else if(casephp=='actieveOnderdeel')
	{
		$.post("jq/rie.php",{actie:'deactiveerOnderdeel',aard:aard,id:id}, function(data) 
		{
			
			$('div#feedback').bind('dialogclose');
			feedback(data);
			laadLijst();
		});
	}
	else if (casephp=='actieveAudit')
	{
		$.post("jq/rieAnalyses.php",{actie:'deactiveerAudit',aard:aard,id:id}, function(data) 
		{
			//alert("check");
			$('div#feedback').bind('dialogclose');
			feedback(data);
			laadAuditTabel();
		});
	}
	
}// einde riedeactiveer 

function rieActiveer(casephp,aard,id)
{
	
	//TODO casephp en actie nakijken voor kortere code
	if(casephp=='actieveLijst')
	{
		$.post("jq/rie.php",{actie:'activeerVraag',aard:aard,id:id}, function(data) 
		{
			$('div#feedback').bind('dialogclose', function(event) {location.reload(true); });
			feedback(data);
			laadLijst();
		});
	}
	else if (casephp == 'actieveOnderdeel')
	{
		$.post("jq/rie.php",{actie:'activeerOnderdeel',aard:aard,id:id}, function(data) 
		{
			$('div#feedback').bind('dialogclose', function(event) {location.reload(true); });
			feedback(data);
			laadLijst();
		});
	}
}//einde rieActiveer

function nieuwDeel(actie, id, soort, form)
{
    var dialogOpts = 
	{
        modal: true,
        autoOpen: false,
        height: 200,
        width: 600,
		open:function() 
		{
					$("#laadForm").html("<img src='../images/progress.gif' />");
				
					$.post("jq/rie.php",{actie:actie,id:id,form:form}, function(data) 
					{
					$("#laadForm").html(data);
					});
		},
		buttons:
		{
			"Opslaan": function() 
			{				
				
					
					$.post("jq/rie.php",$(form).serialize(), function(data) 
					{
					   
						//alert("case opslaan");
						feedback("<center><img src='../images/progress.gif'></center>");
						
						$("#laadForm").dialog("close");//divID in vragendatabase.php
						feedback(data);
						//analyseLijst();
						
					
						
                        $('.input').keypress(function (e) {
                          if (e.which == 13) {
                            $('form#login').submit();
                            return false;    //<---- Add this line
                          }
                        });
						
					});
			}//einde opslaan
		}
    };

	
	$("#laadForm").dialog(dialogOpts);
	$("#laadForm").dialog({title: 'Nieuw toevoegen: ' + soort});
    $("#laadForm").dialog("open");
}//einde vraag rie

