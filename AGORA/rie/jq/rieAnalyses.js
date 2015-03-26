function analyseLijst(actie,id,wijzig)
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
						//alert("case opslaan");
						
						
						//feedback("<center><img src='../images/progress.gif'></center>");
						//feedback(data);
						laadAuditTabel();
						dialog2(id, wijzig);
						$("#dialog").dialog("close");
						
                        $('.input').keypress(function (e) {
                          if (e.which == 13) {
                            $('form#login').submit();
                            return false;    //<---- Add this line
                          }
                        });
						
					});
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


function dialog2(id, wijzig)
{	//alert(id);
 	//alert("in dialoog2");
	var dialogOpts = 
	{
        modal: true,
        autoOpen: false,
        height: 600,
        width: 800,
		open:function() 
		{
			$.post("jq/rieAnalyses.php",{actie:'auditAppend', id:id, wijzig:wijzig}, function(data) 
			{
				
				//alert("in openfunction");
				$("#dialog2").html(data);
			
			});
		},buttons:
		{
			
			"Opslaan": function() 
			{
				$.post("jq/rieAnalyses.php",{actie:'weergave'}, function(data) 
					{
						//alert("case opslaan dialog 2");
						
					});
			},
			"Sluiten": function()
			{
				$(this).dialog("close");
			}
		}
	};

	
	$("#dialog2").dialog(dialogOpts);
	$("#dialog2").dialog({title: 'Risicoanalyse '});
    $("#dialog2").dialog("open");
}

function voegToe(soort,id_onderdeel)
{
	if(soort =="Onderdeel")
	{
		var a=$('#onderdeelAppend').html();
		//$("#onderdeelDIV"+id_onderdeel).append(a);
		$("#onderdeelDIV").append(a);
	}
	
	else if (soort=="Vraag")
	{
		var b=$('#vraagAppend').html();
		$('#'+id_onderdeel).append(b);
	}
			
	
	
	//$("#spin").append(<?php  ?>);
}

//functie om audit lijst van vragen en onderdelen van een audit weergeven om te bewerken
function laadAuditEdit(data)
{
	$.post("jq/rieAnalyses.php",{actie:'auditAppend'}, function(data) 
					{
						$("#dialog2").html(data);
						
					});
}


function auditWeergave(actie, id_audit)
{
	var dialogOpts = 
	{
        modal: true,
        autoOpen: false,
        height: 600,
        width: 800,
		open:function() 
		{
			$.post("jq/rieAnalyses.php",{actie:actie, id_audit:id_audit}, function(data) 
			{
				
				//alert("in openfunction");
				$("#dialog2").html(data);
			
			});
		},buttons:
		{
			
			/* "Opslaan": function() 
			{
				$.post("jq/rieAnalyses.php",{actie:'weergave'}, function(data) 
					{
						//alert("case opslaan dialog 2");
						
					});
			}, */
			"Sluiten": function()
			{
				$(this).dialog("close");
			}
		}
	};

	
	$("#dialog2").dialog(dialogOpts);
	$("#dialog2").dialog({title: 'Audit bekijken'});
    $("#dialog2").dialog("open");
}



function laadAuditTabel()
{
	$("#auditTabel").html("<img src='../images/progress.gif' />");
	
	$.post("jq/rieAnalyses.php",{actie:"actieveAuditLijst"}, function(data) 
	{
		$("#auditTabel").html(data);
        
	});
			
		 
}

function nieuwDeel(actie, id, form, soort, id_onderdeel, id_audit)
{
	alert("id is: "+id);
    var dialogOpts = 
	{
        modal: true,
        autoOpen: false,
        height: 200,
        width: 600,
		open:function() 
		{
					$("#laadForm").html("<img src='../images/progress.gif' />");
				
					$.post("jq/rieAnalyses.php",{actie:actie,id:id,form:form,id_onderdeel:id_onderdeel,id_audit:id_audit}, function(data) //id_onderdeel toegevoegd
					{
						
					$("#laadForm").html(data);
					});
		},
		buttons:
		{
			"Opslaan": function() 
			{				
				
					//alert(id_onderdeel);
					$.post("jq/rieAnalyses.php",$(form).serialize(), function(data) 
					{
						alert(id_onderdeel);
						//alert("case opslaan");
						feedback("<center><img src='../images/progress.gif'></center>");
						
						$("#laadForm").dialog("close");//divID in vragendatabase.php
						//laadAuditEdit();
						feedback(data);
						voegToe(soort,id_onderdeel);
						//laadAuditEdit(data);
						
					
						
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
			//alert(id);
			$('div#feedback').bind('dialogclose');
			feedback(data);
			//laadAuditEdit();
			
		});
	}
	else if(casephp=='actieveOnderdeel')
	{
		$.post("jq/rieAnalyses.php",{actie:'deactiveerOnderdeel',aard:aard,id:id}, function(data) 
		{
			alert(id);
			$('div#feedback').bind('dialogclose');
			feedback(data);
			//laadAuditEdit();
			
		});
	}
	else if (casephp=='actieveAudit')
	{
		$.post("jq/rieAnalyses.php",{actie:'deactiveerAudit',aard:aard,id:id}, function(data) 
		{
			//alert("check");
			$('div#feedback').bind('dialogclose');
			feedback(data);
			
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




