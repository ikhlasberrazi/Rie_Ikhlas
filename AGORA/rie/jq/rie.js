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

//

function rieDeactiveer(casephp,aard,id)
{
	if (casephp=='actieveLijst')
	{
		$.post("jq/rie.php",{actie:'deactiveerVraag',aard:aard,id:id}, function(data) 
		{
			
			if(aard=="actieveLijst") $('div#feedback').bind('dialogclose', function(event) {location.reload(true); });
			feedback(data);
			laadLijst();
		});
	}
	else if(casephp=='actieveOnderdeel')
	{
		$.post("jq/rie.php",{actie:'deactiveerOnderdeel',aard:aard,id:id}, function(data) 
		{
			
			if(aard=="actieveOnderdeel") $('div#feedback').bind('dialogclose', function(event) {location.reload(true); });
			feedback(data);
			laadLijst();
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

function vraagRie(actie, id)
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
				
					$.post("jq/rie.php",{actie:'vragenForm',id:id}, function(data) 
					{
					$("#laadForm").html(data);
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
						
						$("#laadForm").dialog("close");//divID in vragendatabase.php
						feedback(data);
						laadLijst();
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
	$("#laadForm").dialog({title: 'Vragen toevoegen: ' + actie});
    $("#laadForm").dialog("open");
}//einde vraag rie

function onderdeelRie(actie, id)
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
			
				$.post("jq/rie.php",{actie:'onderdelenForm',id:id}, function(data) 
				{
				$("#laadForm").html(data);
				
				});
			
			
			
		},
		buttons:
		{
			"Opslaan": function() 
			{				
				
					$.post("jq/rie.php",$("#onderdelenFormID").serialize(), function(data) 
					{
						//alert("case opslaan onderdeel");
						feedback("<center><img src='../images/progress.gif'></center>");
						
						$("#laadForm").dialog("close");
						
						feedback(data);
						
						laadLijst();
					});
					
					
				
                
			}//einde opslaan
		}
    };

	
	$("#laadForm").dialog(dialogOpts);
	$("#laadForm").dialog({title: 'Onderdelen toevoegen: ' + actie});
    $("#laadForm").dialog("open");
}//einde onderdeel rie

