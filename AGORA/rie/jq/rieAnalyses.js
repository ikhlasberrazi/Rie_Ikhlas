function analyseLijst(actie,id_audit,wijzig)
{
	
	var dialogOpts = 
	{
        modal: true,
        autoOpen: false,
        height: 300,
        width: 700,
		open:function() 
		{
			//bij wijzig click onClick=\"analyseLijst('Wijzig','".$lijst[id]."','wijzig');\">
			$.post("jq/rieAnalyses.php",{actie:'nieuweAudit', id_audit:id_audit}, function(data) 
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
						
						
						
						//feedback("<center><img src='../images/progress.gif'></center>");
						feedback(data);
						laadAuditTabel();
						//alert("Audit id in AnalyseLijst()  is: "+id_audit);
						dialog2(id_audit, wijzig);
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

function refresh(actie, id_audit)
{
	$.post("jq/rieAnalyses.php",{actie:'auditAppend', id_audit:id_audit}, function(data) 
			{
				
				//alert("in openfunction");
				$("#dialog2").html(data);
			
			});
}

function dialog2(id_audit, wijzig)
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
			$.post("jq/rieAnalyses.php",{actie:'auditAppend', id_audit:id_audit, wijzig:wijzig}, function(data) 
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
	alert(soort + id_onderdeel);
	if(soort =="Onderdeel")
	{
		var a=$('#onderdeelAppend').html();
		//$("#onderdeelDIV"+id_onderdeel).append(a);
		$("#onderdeelDIV").append(a);
	}
	
	else if (soort=="Vraag")
	{
		var b=$('#vraagAppend').html();
		//$('#'+id_onderdeel).append(b);
		$('#onderdeelDIV').append(b);
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


function auditWeergave(actie,id_audit)
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

<<<<<<< HEAD
<<<<<<< HEAD

function voegToe(soort)
{
	//Id van child van #onderdeelAppend ophalen en wegschrijven in var. Deze waarde is uniek
	var divOnderdeelID = $('[name="nieuwOnderdeel"]').attr('id');
	var divVraagID = $('[name="nieuweVraag"]').attr('id');
	
	alert(divOnderdeelID);
	
	if(soort =="Onderdeel")
	{
		var a=$('#onderdeelAppend').html();
		$("#onderdeelDIV").append(a);
	}
	
	else if (soort=="Vraag")
	{
		alert(divVraagID + divOnderdeelID);
		var b=$('#vraagAppend').html();
		$('#'+divOnderdeelID).append(b);
	}
}

=======
>>>>>>> parent of ba35c39... vragen worden aan correcte onderdelen append
=======
>>>>>>> parent of ba35c39... vragen worden aan correcte onderdelen append
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
						alert("Id onderdeel "+id_onderdeel + "id_audit ="+id_audit);
						//alert("case opslaan");
						feedback("<center><img src='../images/progress.gif'></center>");
						
						$("#laadForm").dialog("close");//divID in vragendatabase.php
						//laadAuditEdit();
						feedback(data);
<<<<<<< HEAD
<<<<<<< HEAD
						//alert("juiste id is: "+id);
						
						voegToe(soort);
=======
=======
>>>>>>> parent of ba35c39... vragen worden aan correcte onderdelen append
						if (soort == 'Onderdeel' && id_onderdeel =='' )
						{
							voegToe(soort,id_onderdeel);
						}
						else if (soort == 'Onderdeel' && id_onderdeel !='' )
						{
							alert("id onderdeel in save ="+id_onderdeel);
							//laadDeel(soort,id);
						
						}
						else if (soort == 'Vraag' && id_onderdeel !='' )
						{
							voegToe(soort,id_onderdeel);
>>>>>>> parent of ba35c39... vragen worden aan correcte onderdelen append
						
						
							
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


function laadDeel(soort,id)
{
	$("#"+soort+id).html("<img src='../images/progress.gif'>");
	$.post()
	{
		$("#"+soort+id).html(data);
	}
	
}
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




