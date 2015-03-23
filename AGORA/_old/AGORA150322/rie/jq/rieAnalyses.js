function analyseLijst(actie,id)
{
	
	var dialogOpts = 
	{
        modal: true,
        autoOpen: false,
        height: 300,
        width: 700,
		open:function() 
		{
			$.post("jq/rieAnalyses.php",{actie:'nieuweAudit', id:id}, function(data) 
			{
				
				//alert("in openfunction");
				$("#dialog").html(data);
			
			});
		},buttons:
		{
			"Opslaan": function() 
			{
				$.post("jq/rieAnalyses.php",$("#auditFormID").serialize(), function(data) 
					{
					   dialog2();
					   //alert("case opslaan");
						//feedback("<center><img src='../images/progress.gif'></center>");
						//feedback(data);
						
						
						$("#dialog").dialog("close");
						
                        $('.input').keypress(function (e) {
                          if (e.which == 13) {
                            $('form#login').submit();
                            return false;    //<---- Add this line
                          }
                        });
						
					});//
			},
			"Sluiten": function()
			{
				$(this).dialog("close");
			}
		}
	};

	
	$("#dialog").dialog(dialogOpts);
	$("#dialog").dialog({title: 'Nieuwe audit toevoegen '});
    $("#dialog").dialog("open");

			
		
		
}//einde laadvragenlijst


function dialog2(actie)
{
 	alert("in dialoog2");
	var dialogOpts = 
	{
        modal: true,
        autoOpen: false,
        height: 600,
        width: 800,
		open:function() 
		{
			$.post("jq/rieAnalyses.php",{actie:'auditAppend'}, function(data) 
			{
				
				//alert("in openfunction");
				$("#dialog2").html(data);
			
			});
		},buttons:
		{
			"Sluiten": function()
			{
				$(this).dialog("close");
			}
		}
	};

	
	$("#dialog2").dialog(dialogOpts);
	$("#dialog2").dialog({title: 'Nieuwe audit toevoegen '});
    $("#dialog2").dialog("open");
	
}

function voegToe(soort, tekst, onderdeel )
{
	
	if(soort =="Onderdeel")
	{
		//$("#spin").append(onderdeel);
		//$("#spin").append("<div>Onderdeel: <input value='".$onderdeelInput."' readonly> <br /></div>");
		$("#spin").append(tekst);
		alert(onderdeel);
	}
	else if (soort=="Vraag")
		$("#spin").append(tekst);
}


function laadAuditTabel()
{
	$("#auditTabel").html("<img src='../images/progress.gif' />");
	
	$.post("jq/rieAnalyses.php",{actie:"actieveAuditLijst"}, function(data) 
	{
		$("#auditTabel").html(data);
        
	});
			
		 
}

function nieuwDeel(actie, id, soort, form, tekst, onderdeel)
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
				
					$.post("jq/rieAnalyses.php",{actie:actie,id:id,form:form}, function(data) 
					{
					$("#laadForm").html(data);
					});
		},
		buttons:
		{
			"Opslaan": function() 
			{				
				
					
					$.post("jq/rieAnalyses.php",$(form).serialize(), function(data) 
					{
					   
						//alert("case opslaan");
						feedback("<center><img src='../images/progress.gif'></center>");
						voegToe(soort, tekst, onderdeel);
						$("#laadForm").dialog("close");//divID in vragendatabase.php
						feedback(data);
						
						
					
						
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

function rieDeactiveer(casephp,aard,id)
{
	if (casephp=='actieveLijst')
	{
		$.post("jq/rieAnalyses.php",{actie:'deactiveerVraag',aard:aard,id:id}, function(data) 
		{
			
			$('div#feedback').bind('dialogclose');
			feedback(data);
			laadLijst();
		});
	}
	else if(casephp=='actieveOnderdeel')
	{
		$.post("jq/rieAnalyses.php",{actie:'deactiveerOnderdeel',aard:aard,id:id}, function(data) 
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
		$.post("jq/rieAnalyses.php",{actie:'activeerVraag',aard:aard,id:id}, function(data) 
		{
			$('div#feedback').bind('dialogclose', function(event) {location.reload(true); });
			feedback(data);
			laadLijst();
		});
	}
	else if (casephp == 'actieveOnderdeel')
	{
		$.post("jq/rieAnalyses.php",{actie:'activeerOnderdeel',aard:aard,id:id}, function(data) 
		{
			$('div#feedback').bind('dialogclose', function(event) {location.reload(true); });
			feedback(data);
			laadLijst();
		});
	}
}//einde rieActiveer




