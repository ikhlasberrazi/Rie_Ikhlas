<?php
	session_start();
	//include_once("config/config.php");
?>
function test_cookie()
{
	if( $.cookie('agora') == null ) { $.cookie( 'agora', '1',  { expires: 7, path: '/' } ); } 
	if( $.cookie('agora') == null ) 
	{
		$('#start').hide();
	}
	else
	{
		$('#cookies').hide();
	}
}

function showHide(checkBox,shID) {
	if (document.getElementById(shID)) {
		if (checkBox.checked == true) 
		{
			document.getElementById(shID).style.display = 'block';
		}
		else 
		{
			document.getElementById(shID).style.display = 'none';
		}
	}
} 

function showHideSelect(select,shID) {
	if (document.getElementById(shID)) {
	 var x = select.selectedIndex;
		if (select.options[x].value > "0") 
		{
			document.getElementById(shID).style.display = 'block';
		}
		else 
		{
			document.getElementById(shID).style.display = 'none';
		}
	}
}


function feedback(data)
{
	var dialogOpts = 
	{
        title: "Feedback server",
        modal: true,
        autoOpen: false,
        height: 200,
        width: 400,
        buttons: {"Sluiten": function(){$(this).dialog("close");}}
    };
        
	$("#feedback").dialog(dialogOpts);    
    $("#feedback").html(data);
	$("#feedback").dialog("open");
}

function closeFeedback()
{
	$("#feedback").dialog("close");
}

function nieuweFout(agora)
{

	var dialogOpts = {
        title: "Fout of suggestie melden",
        modal: true,
        autoOpen: false,
        height: 270,
        width: 550,
        buttons:
		{
			"Opslaan":function() 
			{
				$.post("<?php print($_SESSION[http]); ?>jq/process/bug.php", $("#bugNieuw").serialize(),  function(data)
				{ 
					switch(data)
				 	{
						case '0':
							feedback("<center><h1><font color=red>Niet alle velden met * werden ingevuld!</font></h1></center> <br />Wanneer u alle velden heeft ingevulgd en toch deze melding ontvangt, neem dan contact op met de beheerder!<br /><br />Foutcode: uitv_wijz_0</font>");
							
						break;
						
						case '1':
							feedback("<font color=red>Er is een fout opgetreden bij het wijzigen van de gegevens!</font> <br /><br />Neem contact op met de beheerder, wanneer dit probleem zich blijft voordoen!<br /><br />Foutcode: uitv_wijz_1</font>");
						break;
										
						default:
							//$("#"+id).replaceWith(data);
							$('div#feedback').bind('dialogclose', function(event) {location.reload(true); });
							$("#bug").dialog("close");
							feedback("<br /><br /><br /><h2><center><font color=green>De wijzigingen zijn met succes opgeslagen!</font></center></h2>");
							
						break;
					}
				
				}); 
			}
		},
		open:function() 
		{
			$.post("<?php print($_SESSION[http]); ?>jq/process/bug.php",{actie:'nieuw',agora:agora}, function(data) 
				{
					$("#bug").html(data);
				});
		}		
    };
    
    

	$("#bug").dialog(dialogOpts);
    $("#bug").dialog("open");
}

function toonBug(id)
{
		var dialogOpts = {
        title: "Details fout / suggestie",
        modal: true,
        autoOpen: false,
        height: 270,
        width: 550,
		open:function() 
		{
			$.post("<?php print($_SESSION[http]); ?>jq/process/bug.php",{actie:'detail',id:id}, function(data) 
				{
					$("#bug").html(data);
				});
		}		
    };
    
    

	$("#bug").dialog(dialogOpts);
    $("#bug").dialog("open");
}

function bugOpgelost(id)
{
	var dialogOpts = {
        title: "Feedback op bug of suggestie",
        modal: true,
        autoOpen: false,
        height: 220,
        width: 550,
		open:function() 
		{
			$.post("<?php print($_SESSION[http]); ?>jq/process/bug.php",{actie:'form',id:id}, function(data) 
				{
					$("#oplossing").html(data);
				});
		},
		buttons:
		{
			"Opslaan":function() 
			{
				$.post("<?php print($_SESSION[http]); ?>jq/process/bug.php", $("#feedback").serialize(),  function(data)
				{ 
					switch(data)
				 	{					
						case '0':
							feedback("<font color=red>Er is een fout opgetreden bij het wijzigen van de gegevens!</font> <br /><br />Neem contact op met de beheerder, wanneer dit probleem zich blijft voordoen!<br /><br />Foutcode: uitv_wijz_1</font>");
							$('div#feedback').bind('dialogclose', function(event) {location.reload(true); });
							$("#oplossing").dialog("close");
						break;
										
						default:
							//$("#"+id).replaceWith(data);
							$('div#feedback').bind('dialogclose', function(event) {location.reload(true); });
							$("#oplossing").dialog("close");
							feedback("<br /><br /><br /><h2><center><font color=green>De wijzigingen zijn met succes opgeslagen!</font></center></h2>");
							
						break;
					}
				
				}); 
			}
		}		
    };

	$("#oplossing").dialog(dialogOpts);
    $("#oplossing").dialog("open");
}

function leesNieuws(id)
{
	var dialogOpts = {
        title: 'Nieuwsbericht',
        modal: true,
        height:'700',
        width: '700',
        open: function() {
        //display correct dialog content
        //$(this).parent().children().children('.ui-dialog-titlebar-close').hide(); 
	        $.post("<?php print($_SESSION[http]); ?>jq/process/leesNieuws.php",{id:id},function(data)
				{
					$("#leesbericht").html(data);
				});
		}
    };
    
	$("#leesbericht").dialog(dialogOpts);
    $("#leesbericht").dialog("open");
}

function cpaFunctieNieuw()
{
	
	var dialogOpts = {
        title: "Nieuwe functie toevoegen",
        modal: true,
        autoOpen: false,
        height: 330,
        width: 500,
        buttons: 
		{
			"Gegevens opslaan": function() {
				$.post("jq/process/cpabeheer.php",$("#cpaInput").serialize(), function(data) 
				{
					switch(data)
				 	{
						case '0':
							feedback("<center><h1><font color=red>Niet alle velden werden ingevuld!</font></h1></center> <br />Wanneer u alle velden heeft ingevulgd en toch deze melding ontvangt, neem dan contact op met de beheerder!<br /><br />Foutcode: cpaFunctie_nw_0</font>");
							
						break;
						
						case '1':
							feedback("<font color=red>Er is een fout opgetreden bij het toevoegen van de functie!</font> <br /><br />Neem contact op met de beheerder!<br /><br />Foutcode: cpaFunctie_nw_1</font>");
						break;
						
						
						default:
							$("#leeg").replaceWith("");
							$("#functies tbody").append(data);
							$("#cpaForm").dialog("close");
						break;
					}
				});
			}
		},
		open:function() 
		{
			$.post("jq/process/cpabeheer.php",{actie:'nieuw_functie'}, function(data) 
				{
					$("#cpaForm").html(data);
				});
		}
    };
    
	$("#cpaForm").dialog(dialogOpts);
    $("#cpaForm").dialog("open");
}

function cpaFunctieWijzig(id)
{
	
	var dialogOpts = {
        title: "Functie wijzigen",
        modal: true,
        autoOpen: false,
        height: 330,
        width: 500,
        buttons: 
		{
			"Gegevens opslaan": function() 
			{
				$.post("jq/process/cpabeheer.php",$("#cpaInput").serialize(), function(data) 
				{
					switch(data)
				 	{
						case '0':
							alert('Fout 0');							
						break;
						
						case '1':
							alert('Fout 1');
						break;
						
						default:
							$("#"+id).replaceWith(data);
							$("#cpaForm").dialog("close");
						break;
					}
				})
			}
		},
		open:function() 
		{
			$.post("jq/process/cpabeheer.php",{id:id,actie:'wijzig_functie'}, function(data) 
				{
					$("#cpaForm").html(data);
				});
		}
    };
    
	$("#cpaForm").dialog(dialogOpts);
    $("#cpaForm").dialog("open");
}

function cpaFunctieVerwijder(id)
{
	
	var dialogOpts = {
        title: "Functie verwijderen",
        modal: true,
        autoOpen: false,
        height: 150,
        width:400,
        buttons: 
		{
			"Ja, nu verwijderen.": function() 
			{
				$.post("jq/process/cpabeheer.php",{actie:'verwijder_functie',id:id}, function(data) 
				{
					switch(data)
				 	{
						case '0':
							alert('Fout 0');							
						break;
						
						case '1':
							alert('Fout 1');
						break;
						
						
						default:
							$("#"+id).replaceWith("");
							$("#cpaForm").dialog("close");
						break;
					}
				})
			},
			"Nee":function()
			{
				$("#cpaForm").dialog("close");
			}
			
		},
		open:function() 
		{
			$("#cpaForm").html("Bent u zeker dat u deze functie wenst te verwijderen?");
			
		}
    };
    
	$("#cpaForm").dialog(dialogOpts);
    $("#cpaForm").dialog("open");
}

function cpaWijzig()
{
	
	var dialogOpts = 
	{
        title: "Gegevens GIDPBW wijzigen",
        modal: true,
        autoOpen: false,
        height: 600,
        width: 500,
        buttons: 
		{
			"Gegevens opslaan": function() 
			{
				$.post("jq/process/cpabeheer.php",$("#cpaInput").serialize(), function(data) 
				{
					switch(data)
				 	{
						case '0':
							alert('Fout 0');
						break;
						
						case '1':
							alert('Fout 1');
						break;
						
						
						default:
							$("#cpaForm").dialog("close");
							location.reload(true);
						break;
					}
				})
			}
		},
		open:function() 
		{
			$.post("jq/process/cpabeheer.php",{actie:'wijzig_gegevens'}, function(data) 
				{
					$("#cpaForm").html(data);
				});
		}
    };
    
	$("#cpaForm").dialog(dialogOpts);
    $("#cpaForm").dialog("open");
}

function sluitOnderdeel()
{
	$.post("../jq/process/sluitOnderdeel.php",{}, function(data) 
	{
		window.close();
		location.reload();
	});
	
}

function opleidingKoppel(id1,id2)
{
	
	var dialogOpts = 
	{
        title: "Data aan opleiding koppelen",
        modal: true,
        autoOpen: false,
        height: 150,
        width: 300,
        buttons: 
		{
			"Gegevens opslaan": function() 
			{
				$.post("jq/process/opleidingKoppel.php",$("#opleidingForm").serialize(), function(data) 
				{
					switch(data)
				 	{
						case '0':
							alert('Fout 0');
						break;
						
						case '1':
							alert('Fout 1');
						break;
						
						
						default:
							$("#opleiding").dialog("close");
							
							$.post("jq/process/opleidingKoppel.php",{actie:'overzicht',opleiding:id1}, function(data) 
							{
								$("#"+id1).replaceWith(data);
							});
						break;
					}
				})
			}
		},
		open:function() 
		{
			$.post("jq/process/opleidingKoppel.php",{actie:'wijzig',opleiding:id1,data:id2}, function(data) 
				{
					$("#opleiding").html(data);
				});
		}
    };
    
	$("#opleiding").dialog(dialogOpts);
    $("#opleiding").dialog("open");
}

function wijzigLocatie(actie,id)
{
	
	var dialogOpts = 
	{
        title: "Lokalen "+actie,
        modal: true,
        autoOpen: false,
        height: 400,
        width: 600,
        buttons: 
		{
			"Gegevens opslaan": function() 
			{
				$.post("jq/process/wijzigLocatie.php",$("#locatieForm").serialize(), function(data) 
				{
					switch(data)
				 	{
						case '0':
							alert('Fout 0');
						break;
						
						case '1':
							alert('Fout 1');
						break;
						
						default:
							$("#locatie").dialog("close");
							//feedback(data);
							if(actie=='nieuw') id=data;
							
							$.post("jq/process/wijzigLocatie.php",{actie:'overzicht',id:id}, function(data) 
							{
								$("#0").replaceWith("");
								if(actie=='nieuw') $("#dataTable tbody").append(data);
								else $("#"+id).replaceWith(data);
							});
						break;
					}
				})
			}
		},
		open:function() 
		{
			$.post("jq/process/wijzigLocatie.php",{actie:actie,id:id}, function(data) 
				{
					$("#locatie").html(data);
				});
		}
    };
    
	$("#locatie").dialog(dialogOpts);
    $("#locatie").dialog("open");
}

function wijzigGebouw(actie,id)
{
	
	var dialogOpts = 
	{
        title: "Gebouwen: "+actie,
        modal: true,
        autoOpen: false,
        height: 300,
        width: 500,
        buttons: 
		{
			"Gegevens opslaan": function() 
			{
				$.post("jq/process/wijzigGebouw.php",$("#locatieForm").serialize(), function(data) 
				{
					switch(data)
				 	{
						case '0':
							alert('Fout 0');
						break;
						
						case '1':
							alert('Fout 1');
						break;
						
						default:
							$("#locatie").dialog("close");
							
							//feedback(data);
							
							//if(actie=='nieuw')
							id=data;
							
							
						break;
					}
				});
				laadGebouw(id);
			}
		},
		open:function() 
		{
			$.post("jq/process/wijzigGebouw.php",{actie:actie,id:id}, function(data) 
				{
					$("#locatie").html(data);
				});
		}
    };
    
	$("#locatie").dialog(dialogOpts);
    $("#locatie").dialog("open");
}

function verwijderGebouw(id,campus)
{
	$.post("jq/process/wijzigGebouw.php",{actie:"verwijder_gebouw",id:id}, function(data) 
	{
		$("#gebouw"+id).html();
		laadGebouw(campus);
		feedback(data);
		
	});
}

function laadGebouw(campus)
{
	$.post("jq/process/wijzigGebouw.php",{actie:"overzicht",id:campus}, function(data) 
	{
		$("#gebouw_campus_"+campus).html(data);
	});
}

/*function toonPA()
{
	$('#PA').html("<center>De gegevens worden opgevraagd even geduld aub.<br /><br /><img src='images/progress.gif'></center>");
	
	$.post("jq/process/gebruikers.php",{actie:'toonPa'}, function(data) 
	{
		$("#PA").html(data);
	});
}*/

function toonPa(id)
{
	var dialogOpts = {
        title: "Gegevens preventieadviseur",
        modal: true,
        autoOpen: false,
        height: 130,
        width: 400,
        open: function() {
        	$("#toonPA").load("jq/process/toonPa.php?id="+id);}
        };
        
		$("#toonPA").dialog(dialogOpts);    
        $("#toonPA").dialog("open");
}

function wijzigPa(id,id2)
{
	var dialogOpts = {
        title: "Wijzig preventieadviseur",
        modal: true,
        autoOpen: false,
        height: 120,
        width: 400,
        buttons: 
        {
			"opslaan": function()
			{
				$.post("jq/process/wijzigPa.php",$("#form").serialize(),function(data)
				{
					//$("#wijzigPA").html(data);
					$("#wijzigPA").dialog("close");
					
					feedback(data);
					laadSchoolOverzicht();
					
				});
			}	
		},
        open: function() {
	        	$("#wijzigPA").html("<img src='images/progress.gif'>");
				//$("#wijzigPA").load("jq/process/wijzigPa.php?id="+id+"&id2="+id2+"&actie=wijzig");
				$.post("jq/process/wijzigPa.php",{actie:'wijzig',id:id,id2:id2},function(data)
				{
					$("#wijzigPA").html(data);
				});
			}
        };
        
		$("#wijzigPA").dialog(dialogOpts);    
        $("#wijzigPA").dialog("open");
}

function nieuwPersoneel()
{
	
	var dialogOpts = {
        title: "Nieuw personeelslid",
        modal: true,
        autoOpen: false,
        height: 600,
        width: 550,
        buttons: {
			"Gegevens opslaan": function() {
				$.post("jq/process/nieuwPersoneel.php",$("#personeel").serialize(), function(data) 
				{
					switch(data)
				 	{
						case '0':
							feedback("<center><h1><font color=red>Niet alle velden met * werden ingevuld!</font></h1></center> <br />Wanneer u alle velden heeft ingevuld en toch deze melding ontvangt, neem dan contact op met de beheerder!<br /><br />Foutcode: pers_nw_0</font>");
							
						break;
						
						case '1':
							feedback("<font color=red>Er is een fout opgetreden bij het toevoegen van het item!</font> <br /><br />Neem contact op met de beheerder!<br /><br />Foutcode: pers_nw_1</font>");
						break;
						
						case '2':
							feedback("<font color=red>Deze persoon bestaat reeds in uw school!</font><br /><br /> Controleer ook de verwijderde personeelsleden<br /><br />Indien u problemen blijft ondervinden, neem dan contact op met de beheerder!<br /><br />Foutcode: pers_nw_2</font>");
						break;
						
						default:
							$('div#feedback').bind('dialogclose', function(event) { $("#wijzigPersoneel").dialog("close"); });
							feedback(data);
						break;
					}
				})
			}
		},
		open:function() 
		{
			$.post("jq/process/nieuwPersoneel.php",{actie:'nieuw'}, function(data) 
				{
					$("#wijzigPersoneel").html(data);
				});
		}
    };
    
    $('div#wijzigPersoneel').bind('dialogclose', function(event) {      location.reload(true); });
	$("#wijzigPersoneel").dialog(dialogOpts);
    $("#wijzigPersoneel").dialog("open");
}

function personeelInUit(test,id)
{
	switch(test)
	{
		case 'in':
			$('#confirm').text("U staat op het punt om een verwijderd personeelslid terug te activeren. Wilt u verder gaan?");
		break;
		
		case 'uit':
			$('#confirm').text("U staat op het punt om een personeelslid te verwijderen. Wilt u verder gaan?");
		break;
	}
	
	
	
	$('#confirm').dialog({
		resizable: false,
		height:140,
		modal: true,
		buttons: {
			"Bevestig": function() {
				$( this ).dialog( "close" );
				$.post("jq/process/personeelInUit.php",{actie:test,id:id}, function(data) 
				{
					switch(data)
					{
						case '1':
							feedback("Er is een fout opgetreden! Gegevens niet gewijzigd!");
						break;
						
						default:
							$('div#feedback').bind('dialogclose', function(event) {location.reload(true); });
							feedback(data);
						break;
					}
				});
			},
			"Annuleer": function() {
				$( this ).dialog( "close" );
			}
		}
	});
}

function wijzigPersoneel(id)
{

	var dialogOpts = {
        title: "Wijzig gegevens personeelslid",
        modal: true,
        autoOpen: false,
        height: 600,
        width: 550,
        buttons:
		{
			"Opslaan":function() 
			{
				feedback("<img src='images/progress.gif'>");
				
				$.post("jq/process/wijzigPersoneel.php", $("#personeel").serialize(),  function(data)
				{ 
					switch(data)
				 	{
						case '0':
							$('#feedback').html("<center><h1><font color=red>Niet alle velden met * werden ingevuld!</font></h1></center> <br />Wanneer u alle velden heeft ingevulgd en toch deze melding ontvangt, neem dan contact op met de beheerder!<br /><br />Foutcode: pers_nw_0</font>");
							
						break;
						
						case '1':
							$('#feedback').html("<font color=red>Er is een fout opgetreden bij het wijzigen van de gegevens!</font> <br /><br />Neem contact op met de beheerder, wanneer dit probleem zich blijft voordoen!<br /><br />Foutcode: pers_nw_1</font>");
						break;
										
						default:
							$('div#feedback').bind('dialogclose', function(event) { $("#wijzigPersoneel").dialog("close"); });
							$('#feedback').html(data);
						break;
					}
				
				}); 
			}
		},
		open:function() 
		{
			formwijzigpersoneelslid(id);
		}		
    };
    
    $('div#wijzigPersoneel').bind('dialogclose', function(event) 
		{
			$.post("jq/process/wijzigPersoneel.php", {id:id,actie:'info'},  function(data)
				{
					$("#"+id).replaceWith(data);
				});
		});
	$("#wijzigPersoneel").dialog(dialogOpts);
    $("#wijzigPersoneel").dialog("open");
}

function formwijzigpersoneelslid(id)
{
	$.post("../jq/process/wijzigPersoneel.php",{actie:'wijzig',id:id}, function(data) 
	{
		$("#wijzigPersoneel").html(data);
	});
}

function laadSamenstelling()
{
	$.post("jq/process/campus.php", {actie:'samenstelling'},  function(data)
		{
			//alert(data);
			$("#samenstelling").replaceWith(data);
		});
}

function afspraken_GID(actie)
{
	
	var dialogOpts = {
        title: "Afspraken GID - School wijzigen",
        modal: true,
        autoOpen: false,
        height: 450,
        width: 500,
        buttons: {
			"Gegevens opslaan": function() {
				$.post("jq/process/afsprakenGID.php",$("#afsprakenInput").serialize(), function(data) 
				{
					switch(data)
				 	{
						case '2':
							alert('Fout 2');
						break;
						
						case '3':
							alert('Fout 3');
						break;
						
						
						default:
							$("#afspraken").replaceWith(data);
							$("#afsprakenForm").dialog("close");
						break;
					}
				})
			}
		},
		open:function() 
		{
			$.post("jq/process/afsprakenGID.php",{actie:actie}, function(data) 
				{
					switch(data)
				 	{
						case '0':
							alert('Fout 0');							
						break;
						
						case '1':
							alert('Fout 1');
						break;
						
						default:
							$("#afsprakenForm").html(data);
						break;
					}
				});
		}
    };
    
	$("#afsprakenForm").dialog(dialogOpts);
    $("#afsprakenForm").dialog("open");
}

function verwijder_school(id,id2)
{
		var dialogOpts = {
        title: "School verwijderen",
        modal: true,
        autoOpen: false,
        height: 200,
        width: 500,
        buttons: {
			"Aanvraag indienen": function() {
				$.post("jq/process/verwijderSchool.php",{id:id,actie:'verwijder_nu'}, function(data) 
				{
					switch(data)
				 	{
						case '0':
							feedback("<br /><br /><h2><font color=red>Aanvraag verwijderen school geweigerd!</font></h2>");
						break;
											
						default:
						//feedback(data);
							feedback("<br /><br /><center><h2><font color=green>De school wordt binnenkort automatisch verwijderd!</font></h2>");
							$("#verwijderSchool").dialog("close");
							//location.reload(true);
							laadSchoolOverzicht();
						break;
					}
				});
				
			},
			"Annuleren": function()
			{
				$("#verwijderSchool").dialog("close");
			}
		},
		open:function() 
		{
			$("#verwijderSchool").html("<H1><font color=red>Bent u zeker dat u deze entiteit wenst te verwijderen?</font></h1>");
		}
    };
    
	$("#verwijderSchool").dialog(dialogOpts);
    $("#verwijderSchool").dialog("open");
}

function verwijder_school_niet(id,id2)
{
	feedback("<img src='images/progress.gif'>");
	$.post("jq/process/verwijderSchool.php",{id:id,actie:'undo'}, function(data) 
	{
		switch(data)
	 	{
			case '0':
				$("#feedback").html("<br /><br /><h2><font color=red>Verwijderen ongedaan maken mislukt!</font></h2>");
			break;
								
			default:
			//feedback(data);
				$("#feedback").html("<br /><br /><h2><font color=green><center>Verwijderen ongedaan gemaakt!</font></h2>");
				//$("#verwijderSchool").dialog("close");
				/*
				$.post("jq/process/verwijderSchool.php",{actie:'controle',id:id2},function(data)
				{
					//$("#"+id2).replaceWith(data);
					
				});
				*/
				//location.reload(true);
				laadSchoolOverzicht();
			break;
		}
	});
}

function startImport(id)
{
	var dialogOpts = {
        title: 'Importeer personeelsleden Stap 1: bestand selecteren',
        modal: true,
        autoOpen: false,
        height: 250,
        width: 400,
		open: function ()
		{
			$.post("jq/process/importPersoneel.php",{id:id,actie:'form_upload'},function(data)
			{
				$("#uploadPersoneel").html(data);	
			});
		}		
    };

	$("#uploadPersoneel").dialog(dialogOpts);
    $("#uploadPersoneel").dialog("open");
}

function importStap2(id)
{
	var dialogOpts = {
        title: 'Importeer personeelsleden Stap 2: velden linken',
        modal: true,
        autoOpen: false,
        height: 700,
        width: 400,
		open: function()
		{
			$.post("jq/process/importPersoneel.php",{id:id,actie:'velden'}, function(data) 
			{
				$("#uploadPersoneel2").html(data);
			});
		},
		buttons:
		{
			opslaan: function()
			{
				$.post("jq/process/importPersoneel.php",$("#linkVelden").serialize(), function(data) 
				{
					$("#uploadPersoneel2").dialog("close");
					feedback(data);
				});
			}
		}		
    };


	$("#uploadPersoneel2").dialog(dialogOpts);
    $("#uploadPersoneel2").dialog("open");
}


function startImportLln(id)
{
	var dialogOpts = {
        title: 'Importeer leerlingen Stap 1: bestand selecteren',
        modal: true,
        autoOpen: false,
        height: 250,
        width: 400,
		open: function ()
		{
			$.post("jq/process/importLln.php",{id:id,actie:'form_upload'},function(data)
			{
				$("#uploadLln").html(data);	
			});
		}		
    };

	$("#uploadLln").dialog(dialogOpts);
    $("#uploadLln").dialog("open");
}

function importLlnStap2(id)
{
	var dialogOpts = {
        title: 'Importeer leerlingen Stap 2: velden linken',
        modal: true,
        autoOpen: false,
        height: 700,
        width: 400,
		open: function()
		{
			$.post("jq/process/importLln.php",{id:id,actie:'velden'}, function(data) 
			{
				$("#uploadLln2").html(data);
			});
		},
		buttons:
		{
			opslaan: function()
			{
				$.post("jq/process/importLln.php",$("#linkVelden").serialize(), function(data) 
				{
					$("#uploadLln2").dialog("close");
					feedback(data);
				});
			}
		}		
    };

	$("#uploadLln2").dialog(dialogOpts);
    $("#uploadLln2").dialog("open");
}

function verwijderCampus(id,naam)
{
	
	var dialogOpts = {
        title: "Campus verwijderen",
        modal: true,
        autoOpen: false,
        height: 150,
        width:400,
        buttons: 
		{
			"Ja, nu verwijderen.": function() 
			{
				$.post("jq/process/campus.php",{actie:'verwijder',id:id}, function(data) 
				{
					switch(data)
				 	{
						case '0':
							alert('Fout 0');							
						break;
						
						case '1':
							alert('Fout 1');
						break;
						
						
						default:
							$("#c"+id).replaceWith("");
							$("#campus").dialog("close");
						break;
					}
				})
			},
			"Nee":function()
			{
				$("#campus").dialog("close");
			}
			
		},
		open:function() 
		{
			$("#campus").html("Bent u zeker dat u de campus " + naam + " wenst te verwijderen? Deze gegevens kunnen nadien niet meer hersteld worden!");
			
		}
    };
    
	$("#campus").dialog(dialogOpts);
    $("#campus").dialog("open");
}

function activeerCampus(id,naam)
{
	$.post("jq/process/campus.php",{actie:'activeer',id:id}, function(data) 
	{
		location.reload(true);
	});
}

function activeer(id,aard)
{
	$.post("jq/process/wijzigPersoneel.php",{actie:'activeer',id:id}, function(data) 
	{
		
	});
	
	switch(aard)
	{
		case 'school': laadOverzichtGebruikers('overzicht_pa','school','1'); break;
		case 'subgroep': laadOverzichtGebruikers('overzicht_subgroep','subgroep','1'); break;
		case 'lkt': laadOverzichtGebruikers('overzicht_lkt','lkt','1'); break;
	}
}

function deactiveer(id,aard)
{
	$.post("jq/process/wijzigPersoneel.php",{actie:'deactiveer',id:id}, function(data) 
	{
		
	});
	
	switch(aard)
	{
		case 'school': laadOverzichtGebruikers('overzicht_pa','school','1'); break;
		case 'subgroep': laadOverzichtGebruikers('overzicht_subgroep','subgroep','1'); break;
		case 'lkt': laadOverzichtGebruikers('overzicht_lkt','lkt','1'); break;
	}
}

function maakLogin(id)
{
		var dialogOpts = {
        title: "Login Agora aanmaken",
        modal: true,
        autoOpen: false,
        height: 150,
        width:400,
		open:function() 
		{
			$("#campus").html("<center><img src='../images/progress.gif'></center>");
			
			$.post("jq/process/wijzigPersoneel.php",{actie:'maaklogin',id:id}, function(data) 
				{
					switch(data)
				 	{
						case '0':
							$("#campus").html('Fout 0');
														
						break;
						
						default:
							$("#campus").html(data);
							
							
							//$("#campus").dialog("close");
						break;
					}
				})
			
		}
    };
    
    $('div#campus').bind('dialogclose', function(event) 
	{
		$.post("jq/process/wijzigPersoneel.php", {id:id,actie:'info'},  function(data)
			{
				$("#"+id).replaceWith(data);
			});
	});
    
	$("#campus").dialog(dialogOpts);
    $("#campus").dialog("open");
}

function rechtenAgora(id,aard,id_login,id_sg,id_subgroep,id_school,id_campus)
{
	var dialogOpts = {
        title: 'Toekennen rechten AGORA',
        modal: true,
        autoOpen: false,
        height: 600,
        width: 400,
		open: function()
		{
			$("#rechten").html("<img src='../images/progress.gif' />");
			$.post("jq/process/rechtenAgora.php",{actie:'wijzig',id:id,aard:aard,id_login:id_login,id_sg:id_sg,id_subgroep:id_subgroep,id_school:id_school,id_campus:id_campus}, function(data) 
			{
				$("#rechten").html(data);
			});
		},
		buttons:
		{
			opslaan: function()
			{
				$.post("jq/process/rechtenAgora.php",$("#personeel").serialize(), function(data) 
				{
					$("#rechten").dialog("close");
					
					feedback(data);
				});
			}
		}		
    };

	$("#rechten").dialog(dialogOpts);
    $("#rechten").dialog("open");
}

function verstuurAccount(id)
{
		var dialogOpts = {
        title: "Verstuur Accountgegevens",
        modal: true,
        autoOpen: false,
        height: 150,
        width:400,
		open:function() 
		{
			$("#account").html("<center><img src='../images/progress.gif'></center>");
			
			$.post("jq/process/gebruikers.php",{actie:'mailaccount',id:id}, function(data) 
				{
					$("#account").html(data);
				});
		}
    };
    
	$("#account").dialog(dialogOpts);
    $("#account").dialog("open");
}

function schoolbestuur(aard,id)
{
	
	var dialogOpts = 
	{
        title: "Schoolbestuur: "+aard,
        modal: true,
        autoOpen: false,
        height: 400,
        width: 1000,
        buttons: 
		{
			"Gegevens opslaan": function() 
			{
				$.post("jq/process/cpabeheer.php",$("#bestuur").serialize(), function(data) 
				{
					switch(data)
				 	{
						case '0':
							feedback("<br /><br /><h2><font color=red><center>Fout bij het opslaan van de gegevens!</font></h2>");
						break;
						
						
						default:
							$("#cpaForm").dialog("close");
							if(aard=="nieuw") feedback("<br /><br /><h2><font color=green><center>Schoolbestuur met succes opgeslagen!</font></h2>");
							else feedback("<br /><br /><h2><font color=green><center>Schoolbestuur met succes gewijzigd!</font></h2>");
							overzichtSchoolbestuur();

						break;
					}
				})
			}
		},
		open:function() 
		{
			$("#cpaForm").html("");
			$.post("jq/process/cpabeheer.php",{actie:'wijzig_bestuur',aard:aard,id:id}, function(data) 
				{
					$("#cpaForm").html(data);
				});
		}
    };
    
	$("#cpaForm").dialog(dialogOpts);
    $("#cpaForm").dialog("open");
}

function overzichtSchoolbestuur()
{
	$.post("jq/process/cpabeheer.php",{actie:'overzicht_bestuur'}, function(data) 
	{
		$("#schoolbestuur").html("<div id='schoolbestuur'>"+data+"</div>");
	});
}

function verwijder_schoolbestuur(id)
{
	feedback("Schoolbestuur wordt verwijderd!<br /><img src='images/progress.gif'>");
	
	$.post("jq/process/cpabeheer.php",{actie:'verwijder_bestuur',id:id},function(data)
	{
		$("#feedback").html(data);
		overzichtSchoolbestuur();
	});
}

//documenten ivm logo, inplantingsplan opladen op niveau campus
function campus_overzicht_bestanden_detail(id)
{
	$("#campusBestanden").html("<img src='../images/progress.gif' />");
	
	$.post("jq/process/campus_upload.php",{id:id,actie:"bestanden"}, function(data) 
	{
		$("#campusBestanden").html(data);
	});
}

function campus_overzicht_bestanden(id,id_locatie,artikelnaam)
{
	var dialogOpts = 
	{
        modal: true,
        autoOpen: false,
        height: 500,
        width: 900,
        
		open:function() 
		{
			campus_overzicht_bestanden_detail(id);
		}
	}
	/*
	$('div#campusBestanden').bind('dialogclose', function(event) {
    	campus_overzicht_bestanden_detail(id_locatie);
	});
	*/
	$("#campusBestanden").dialog(dialogOpts);
	$("#campusBestanden").dialog({title: 'Overzicht bestanden '+artikelnaam});
    $("#campusBestanden").dialog("open");
}

function campus_upload(id)
{
	var dialogOpts = 
	{
        modal: true,
        autoOpen: false,
        height: 300,
        width: 400,
        
		open:function()
		{
			$("#campusUpload").html("<img src='../images/progress.gif' />");
			
			$.post("jq/process/campus_upload.php",{actie:'form',id:id}, function(data) 
			{
				$("#campusUpload").html(data);
			});
		}
    };
    
    $('div#campusUpload').bind('dialogclose', function(event) 
	{      
	 
	 	campus_overzicht_bestanden_detail(id);	
	 
	});

	$("#campusUpload").dialog(dialogOpts);
	$("#campusUpload").dialog({title: 'Upload bestand'});
    $("#campusUpload").dialog("open");
}


function campusDownloadBestand(id)
{
	
	var dialogOpts = {
        title: "Bestand downloaden",
        modal: true,
        autoOpen: false,
        height: 200,
        width: 500,
		open:function() 
		{
			$("#download").html("<center>Het bestand wordt klaargemaakt voor download!<br /><br /><img src='images/progress.gif'></center>");
			
			$.post("jq/process/campus_upload.php",{id:id,actie:"download"}, function(data) 
				{
					switch(data)
				 	{
						case '0':
							
							$("#download").dialog("close");
							alert('Fout 0: het gevraagde bestand bestaat niet in de databank!');
						break;
						
						case '1':
							
							$("#download").dialog("close");
							alert('Fout 1: bestand niet gevonden op de server');
						break;
						
						default:
							$("#download").html(data);
						break;
					}
				});
		}
    };
    
	$("#download").dialog(dialogOpts);
    $("#download").dialog("open");
}

function campusInplanting(id_campus,id_upload)
{
	$.post("jq/process/campus_upload.php",{id_campus:id_campus,id:id_upload,actie:'inplanting'}, function(data) 
	{
			feedback(data);
			campus_overzicht_bestanden_detail(id_campus);
	});
}

function campusLogo(id_campus,id_upload)
{
	$.post("jq/process/campus_upload.php",{id_campus:id_campus,id:id_upload,actie:'logo'}, function(data) 
	{
			feedback(data);
			campus_overzicht_bestanden_detail(id_campus);
	});
}

function campusBestandActief(id_campus,id_upload,actie)
{
	$.post("jq/process/campus_upload.php",{id:id_upload,actie:actie}, function(data) 
	{
			feedback(data);
			campus_overzicht_bestanden_detail(id_campus);
	});
}

//functies ivm plattegronden
function locatie_overzicht_bestanden_detail(id)
{
	$("#locatieBestanden").html("<img src='../images/progress.gif' />");
	
	$.post("jq/process/locatie_upload.php",{id:id,actie:"bestanden"}, function(data) 
	{
		$("#locatieBestanden").html(data);
	});
}

function locatie_overzicht_bestanden(id,artikelnaam)
{
	var dialogOpts = 
	{
        modal: true,
        autoOpen: false,
        height: 500,
        width: 900,
        
		open:function() 
		{
			locatie_overzicht_bestanden_detail(id);
		}
	}
	
	$('div#locatieBestanden').bind('dialogclose', function(event) {
    	locatie_overzicht_bestanden_detail(id);
	});
	
	$("#locatieBestanden").dialog(dialogOpts);
	$("#locatieBestanden").dialog({title: 'Overzicht bestanden '+artikelnaam});
    $("#locatieBestanden").dialog("open");
}

function locatie_upload(id)
{
	var dialogOpts = 
	{
        modal: true,
        autoOpen: false,
        height: 300,
        width: 400,
        
		open:function()
		{
			$("#locatieUpload").html("<img src='../images/progress.gif' />");
			
			$.post("jq/process/locatie_upload.php",{actie:'form',id:id}, function(data) 
			{
				$("#locatieUpload").html(data);
			});
		}
    };
    
    $('div#locatieUpload').bind('dialogclose', function(event) 
	{      
	 
	 	locatie_overzicht_bestanden_detail(id);	
	 
	});

	$("#locatieUpload").dialog(dialogOpts);
	$("#locatieUpload").dialog({title: 'Upload bestand'});
    $("#locatieUpload").dialog("open");
}


function locatieDownloadBestand(id)
{
	
	var dialogOpts = {
        title: "Bestand downloaden",
        modal: true,
        autoOpen: false,
        height: 200,
        width: 500,
		open:function() 
		{
			$("#download").html("<center>Het bestand wordt klaargemaakt voor download!<br /><br /><img src='images/progress.gif'></center>");
			
			$.post("jq/process/locatie_upload.php",{id:id,actie:'download'}, function(data) 
				{
					switch(data)
				 	{
						case '0':
							
							$("#download").dialog("close");
							alert('Fout 0: het gevraagde bestand bestaat niet in de databank!');
						break;
						
						case '1':
							
							$("#download").dialog("close");
							alert('Fout 1: bestand niet gevonden op de server');
						break;
						
						default:
							$("#download").html(data);
						break;
					}
				});
		}
    };
    
	$("#download").dialog(dialogOpts);
    $("#download").dialog("open");
}

function locatiePlattegrond(id_locatie,id_upload)
{
	$.post("jq/process/locatie_upload.php",{id_locatie:id_locatie,id:id_upload,actie:'plattegrond'}, function(data) 
	{
			feedback(data);
			locatie_overzicht_bestanden_detail(id_locatie);
	});
}

function locatieBestandActief(id_locatie,id_upload,actie)
{
	$.post("jq/process/locatie_upload.php",{id:id_upload,actie:actie}, function(data) 
	{
			feedback(data);
			locatie_overzicht_bestanden_detail(id_locatie);
	});
}

//toon locatie gegevens
function locatieInfo(id)
{
	var dialogOpts = {
        title: "Informatie Lokatie",
        modal: true,
        autoOpen: false,
        height: 600,
        width: 600,
		open:function() 
		{
			$("#info").html("<center>De gegevens worden opgezocht in de databank.<br /><br /><img src='<?php print($_SESSION[http]); ?>images/progress.gif'></center>");
			
			$.post("<?php print($_SESSION[http]); ?>jq/process/locatie_informatie.php",{id:id}, function(data) 
				{
					switch(data)
				 	{
						case '0':
							
							$("#info").dialog("close");
							feedback('Fout 0: de gevraagde informatie werd niet gevonden!');
						break;
												
						default:
							$("#info").html(data);
						break;
					}
				});
		}
    };
    
	$("#info").dialog(dialogOpts);
    $("#info").dialog("open");	
}

function showDashboardWeveco()
{
	$.post("<?php print($_SESSION[http]); ?>jq/process/dashboard_weveco.php",{}, function(data) 
	{
	 	$("#db_weveco").html(data);
	});
}

function showDashboardTaakbeheer()
{
	$.post("<?php print($_SESSION[http]); ?>jq/process/dashboard_taakbeheer.php",{}, function(data) 
	{
	 	$("#db_agenda").html(data);
	});
}

function vskoCpaUpdate()
{
	$('div#feedback').bind('dialogclose', function(event) {location.reload(true); });
	
	$.post("<?php print($_SESSION[http]); ?>jq/process/cpabeheer.php",$("#vskoCPA").serialize(), function(data) 
	{
	 	feedback(data);
	});
}

function vsko_school_nieuw()
{
	var id=$("#instellingsnr").val();

	feedback("<center>Even geduld a.u.b. uw gegevens worden opgezocht op de VSKO servers....wanneer dit langer dan een paar seconden duurt, is waarschijnlijk uw instellingsnummer fout!!<br /><img src='../images/progress.gif'>");
	$.post("jq/process/cpabeheer.php",{actie:'nieuwe_school',id:id},function (data)
	{
		if(data!="1")
		{
			eval(data);
			$('#feedback').dialog('close');
		}
		else $('#feedback').html("<br /><br /><br /><center><font color=red><h2>Gelieve een correct instellingsnummer op te geven!!</h2></font></center>");
	});
		
}

function vsko_form_schoolbestuur()
{
	$("#vsko_info").html("Informatie wordt opgezocht!!<br /><br /><img src='../images/progress.gif'>");
	var instellingsnr=$("#instellingsnr").val();
	var vsko_nr=$("#vsko_nr").val();
	
	$.post("jq/process/cpabeheer.php",{actie:'vsko_form_schoolbestuur',instellingsnr:instellingsnr,vsko_nr:vsko_nr},function (data,status)
	{
		if(status=='timeout') $("#vsko_info").html("Geen verbinding met de server mogelijk!");
		else
		{
			$("#vsko_info").html(data);
			check_vsko_info();
		}
	});
}

function vsko_update_schoolbestuur()
{
	var id=$("#id").val();
	var aard=$("#aard").val();
	var data=$("#vsko_bestuur").serializeArray();
	data.push({name:'id',value:id});
	data.push({name:'aard',value:aard});
	
	$("#cpaForm").dialog('close');
	feedback("<img src='../images/progress.gif'>");
	
	$.post("jq/process/cpabeheer.php",data,function (data,status)
	{
		switch(data)
		{
			case '0': $("#feedback").html("<br /><br /><br /><center><h2><font color='red'>Gegevens niet kunnen opslaan</font></h2></center>");break;
			case '1': $("#feedback").html("<br /><br /><br /><center><h2><font color='green'>Schoolbestuur met succes toegevoegd!</font></h2></center>");break;
			case '2': $("#feedback").html("<br /><br /><br /><center><h2><font color='green'>Gegevens schoolbestuur met succes gewijzigd!</font></h2></center>");break;
		}
		$('div#feedback').bind('dialogclose', function(event) {overzichtSchoolbestuur();});
		
	});
}

function vsko_selecteer_scholen()
{
	var dialogOpts = {
        title: "Overzicht scholen VSKO",
        modal: true,
        autoOpen: false,
        height: 600,
        width: 800,
		open:function() 
		{
			$("#vsko").html("<center><br /><br /><h2><font color=red>De gegevens worden opgezocht in de databank.<br /><br />Dit kan enkele minuten duren!</h2></font><br /><br /><img src='<?php print($_SESSION[http]); ?>images/progress.gif'></center>");
			
			laad_vsko_school_overzicht();
		}
    };
    
    $('div#vsko').bind('dialogclose', function(event) {location.reload(true); });
	$("#vsko").dialog(dialogOpts);
    $("#vsko").dialog("open");	
}

function laad_vsko_school_overzicht()
{
	$.post("jq/process/schooladmin.php",{actie:'overzicht_vsko_scholen'}, function(data) 
	{
		$("#vsko").html(data);		
	});
}

function vsko_school_voegtoe(schoolbestuur,instellingsnr)
{
	var dialogOpts = {
        title: "Nieuwe school via VSKO",
        modal: true,
        autoOpen: false,
        height: 200,
        width: 400,
		open:function() 
		{
			$("#vsko_school").html("<center>De gegevens worden opgezocht in de databank.<br /><br /><img src='<?php print($_SESSION[http]); ?>images/progress.gif'></center>");
			
			$.post("jq/process/schooladmin.php",{actie:'vsko_voegtoe',schoolbestuur:schoolbestuur,instellingsnr:instellingsnr}, function(data) 
			{
				$("#vsko_school").html(data);		
			});
		},
		buttons:
		{
			Akkoord: function()
			{
				$.post("jq/process/schooladmin.php",$("#vsko_school_voegtoe").serialize(), function(data) 
				{
					$("#vsko_school").dialog("close");
					laad_vsko_school_overzicht();
					feedback(data);
				});
			},
			Annuleer: function()
			{
				$("#vsko_school").dialog("close");
			}
		}
    };
    
	$("#vsko_school").dialog(dialogOpts);
    $("#vsko_school").dialog("open");	
}

function vsko_form_zoek_instellingsnr(aard)
{
	var dialogOpts = {
        title: "Zoek instellingsnummer via VSKO",
        modal: true,
        autoOpen: false,
        height: 700,
        width: 1000,
		open:function() 
		{
			$("#vsko_zoek").html("<center>De gegevens worden opgezocht in de databank.<br /><br /><img src='<?php print($_SESSION[http]); ?>images/progress.gif'></center>");
			
			$.post("../../jq/process/schooladmin.php",{actie:'vsko_zoek',aard:aard}, function(data) 
			{
				$("#vsko_zoek").html(data);		
			});
		}
    };
    
	$("#vsko_zoek").dialog(dialogOpts);
    $("#vsko_zoek").dialog("open");	
}

function vsko_zoek_instellingsnr()
{
	var formdata=$("#zoek_instellingsnr").serializeArray();
	
	$("#vsko_zoek").html("<img src='../../images/progress.gif'>");
			
	//$.post("jq/process/schooladmin.php",$("form#zoek_instellingsnr").serialize(),function(data)
	$.post("jq/process/schooladmin.php",formdata,function(data)
	{
		$("#vsko_zoek").html(data);	
	});
	
}

function vsko_put_instellingsnr(id,aard)
{
	$("#instellingsnr").val(id);
	//eval(data);
	$("#vsko_zoek").dialog("close");
	switch(aard)
	{
		case 'vzw': vsko_form_schoolbestuur(); break;
		case 'school': vsko_form_school(); break;
	}
}

function campus_wijzig(id)
{
	var dialogOpts = {
        title: "Campus",
        modal: true,
        autoOpen: false,
        height: 400,
        width: 1000,
		open:function() 
		{
			$("#vsko_zoek").html("<center>De gegevens worden opgezocht in de databank.<br /><br /><img src='../../images/progress.gif'></center>");
			
			$.post("jq/process/campus.php",{actie:'wijzig',id:id}, function(data) 
			{
				$("#campus_wijzig").html(data);		
			});
			vsko_form_school();
		},
		buttons:
		{
			Opslaan: function()
			{
				$.post("jq/process/campus.php",$("#form_campus").serialize(), function(data) 
				{
					$("#campus_wijzig").dialog("close");
					laad_campus_overzicht();
					feedback(data);
				});
			}
		}
    };
    
	$("#campus_wijzig").dialog(dialogOpts);
    $("#campus_wijzig").dialog("open");	
}

function laad_campus_overzicht()
{
	$("#campus_overzicht").html("<img src='../../images/progress.gif'>");
	$.post("jq/process/campus.php",{actie:'overzicht'}, function(data) 
	{
		$("#campus_overzicht").html(data);		
	});
}

function vsko_form_school()
{
	$("#vsko_info").html("Informatie wordt opgezocht!!<br /><br /><img src='../images/progress.gif'>");
	var instellingsnr=$("#instellingsnr").val();
	
	$.post("jq/process/campus.php",{actie:'vsko_form_school',instellingsnr:instellingsnr},function (data,status)
	{
		if(status=='timeout') $("#vsko_info").html("Geen verbinding met de server mogelijk!");
		else
		{
			$("#vsko_info").html(data);
			check_vsko_info();
		}
	});	
}

function vsko_update_schoolgegevens()
{
	$("#campus_wijzig").dialog('close');
	feedback("<img src='../images/progress.gif'>");
	
	$.post("jq/process/campus.php",$("#form_vsko_school").serialize(),function (data,status)
	{
		$("#feedback").html(data);
		$('div#feedback').bind('dialogclose', function(event) {laad_campus_overzicht();});
		
	});
}

function check_vsko_info()
{
	var vink="<img src='../../images/vink.png'>";
	var kruis="<img src='../../images/kruis.png'>";
	
	if($("#naam").val()!=$("#vsko_naam").val()) $("#check_naam").html(kruis);
	else  $("#check_naam").html(vink);
	
	if($("#instellingsnr").val()!=$("#vsko_instellingsnr").val()) $("#check_instellingsnr").html(kruis);
	else  $("#check_instellingsnr").html(vink);
	
	if($("#adres").val()!=$("#vsko_adres").val()) $("#check_adres").html(kruis);
	else  $("#check_adres").html(vink);
	
	if($("#postcode").val()!=$("#vsko_postcode").val()) $("#check_postcode").html(kruis);
	else  $("#check_postcode").html(vink);
	
	if($("#plaats").val()!=$("#vsko_plaats").val()) $("#check_plaats").html(kruis);
	else  $("#check_plaats").html(vink);
	
	if($("#telefoon").val()!=$("#vsko_telefoon").val()) $("#check_telefoon").html(kruis);
	else  $("#check_telefoon").html(vink);
	
	if($("#fax").val()!=$("#vsko_fax").val()) $("#check_fax").html(kruis);
	else  $("#check_fax").html(vink);
	
	if($("#email").val()!=$("#vsko_email").val()) $("#check_email").html(kruis);
	else  $("#check_email").html(vink);
	
	if($("#vsko_nr").val()!=$("#vsko_vsko_nr").val()) $("#check_vsko_nr").html(kruis);
	else  $("#check_vsko_nr").html(vink);
	
	if($("#ondernemingsnummer").val()!=$("#vsko_ondernemingsnummer").val()) $("#check_ondernemingsnummer").html(kruis);
	else  $("#check_ondernemingsnummer").html(vink);
	
	if($("#begindatum").val()!=$("#vsko_begindatum").val()) $("#check_begindatum").html(kruis);
	else  $("#check_begindatum").html(vink);
	/*
	if($("#").val()!=$("#vsko_").val()) $("#check_").html(kruis);
	else  $("#check_").html(vink);
	*/
}

function load_import_data(aard)
{
	$.post("jq/process/importData.php",{actie:'overzicht',aard:aard},function (data)
	{
		$('#importData').html(data);
		
	});
}

function laadAndereInstelling(id)
{
	$('#andere_instelling').html("<img src='../images/progress.gif'>");
	$.post("../../jq/process/wijzigPersoneel.php",{actie:'toon_andere_instelling',id:id},function (data)
	{
		$('#andere_instelling').html(data);
		
	});
}

function deleteAndereInstellingen(id,id_andere)
{
	$.post("../../jq/process/wijzigPersoneel.php",{actie:'verwijder_andere_instelling',id:id_andere},function (data)
	{
		feedback(data);
		laadAndereInstelling(id);
	});
}
function inputAndereInstelling(id)
{
	var instellingsnr=$("#instellingsnr").val();
	
	$.post("../../jq/process/wijzigPersoneel.php",{actie:'input_andere_instelling',id:id,instellingsnr:instellingsnr},function (data)
	{
		feedback(data);
		laadAndereInstelling(id);
	});
}

function laadSchoolOverzicht()
{
	$('#overzicht_scholen').html("<img src='../images/progress.gif'>");
	$.post("jq/process/schooladmin.php",{actie:'overzicht_scholen'},function (data)
	{
		$('#overzicht_scholen').html(data);
		
	});	
	
	reloadStylesheets();
}

function wijzigSchool(id)
{
	var dialogOpts = {
        title: "School",
        modal: true,
        autoOpen: false,
        height: 700,
        width: 500,
		open:function() 
		{
			$("#wijzig_school").html("<center>De gegevens worden opgezocht in de databank.<br /><br /><img src='../../images/progress.gif'></center>");
			
			$.post("jq/process/schooladmin.php",{actie:'wijzig_school',id:id}, function(data) 
			{
				$("#wijzig_school").html(data);		
			});
			
		},
		buttons:
		{
			Opslaan: function()
			{
				$.post("jq/process/schooladmin.php",$("#formschool").serialize(), function(data) 
				{
					$("#wijzig_school").dialog("close");
					laadSchoolOverzicht();
					feedback(data);
				});
			}
		}
    };
    
	$("#wijzig_school").dialog(dialogOpts);
    $("#wijzig_school").dialog("open");	
}

function laadSubgroepOverzicht()
{
	$('#overzicht_subgroep').html("<img src='../images/progress.gif'>");
	$.post("jq/process/schooladmin.php",{actie:'overzicht_subgroep'},function (data)
	{
		$('#overzicht_subgroep').html(data);
		
	});	
}

function wijzigSubgroep(id)
{
	var dialogOpts = {
        title: "School",
        modal: true,
        autoOpen: false,
        height: 200,
        width: 300,
		open:function() 
		{
			$("#wijzig_subgroep").html("<center>De gegevens worden opgezocht in de databank.<br /><br /><img src='../../images/progress.gif'></center>");
			
			$.post("jq/process/schooladmin.php",{actie:'wijzig_subgroep',id:id}, function(data) 
			{
				$("#wijzig_subgroep").html(data);		
			});
			
		},
		buttons:
		{
			Opslaan: function()
			{
				$.post("jq/process/schooladmin.php",$("#formsubgroep").serialize(), function(data) 
				{
					$("#wijzig_subgroep").dialog("close");
					laadSubgroepOverzicht();
					feedback(data);
				});
			}
		}
    };
    
	$("#wijzig_subgroep").dialog(dialogOpts);
    $("#wijzig_subgroep").dialog("open");	
}

function verwijderPa(id,div,aard,actief)
{
	feedback("<img src='../images/progress.gif' />");
	$.post("jq/process/gebruikers.php",{actie:'verwijder_sg_gebruiker',id:id},function(data)
	{
		$("#feedback").html(data);
		laadOverzichtGebruikers(div,aard,actief);
	});
}

function laadOverzichtGebruikers(div,aard,actief)
{
	$("#"+div).html("<img src='../images/progress.gif' />");
	$.post("jq/process/gebruikers.php",{actie:'overzicht_gebruikers',aard:aard,actief:actief,div:div},function(data){
		$("#"+div).html(data);	
	});
	
	reloadStylesheets();
}

function wijzigGebruiker(id,div,aard,actief)
{
	
	var dialogOpts = {
        title: "Wijzig gebruiker",
        modal: true,
        autoOpen: false,
        height: 250,
        width: 500,
		open:function() 
		{
			$("#wijzigGebruiker").html("<center>De gegevens worden opgezocht in de databank.<br /><br /><img src='../../images/progress.gif'></center>");
			
			$.post("jq/process/gebruikers.php",{actie:'wijzig',id:id}, function(data) 
			{
				$("#wijzigGebruiker").html(data);		
			});
			
		},
		buttons:
		{
			Opslaan: function()
			{				
				feedback("<img src='../images/progress.gif' />");
				$.post("jq/process/gebruikers.php",$("#formgebruiker").serialize(),function(data)
				{
					$("#wijzigGebruiker").dialog("close");
					$("#feedback").html(data);
					laadOverzichtGebruikers(div,aard,actief);
				});
			}
		}
    };
    
	$("#wijzigGebruiker").dialog(dialogOpts);
    $("#wijzigGebruiker").dialog("open");
}

function veranderGebruiker(id,id_nieuw)
{
	$("#feedback").html("<img src='../images/progress.gif' />");
	$.post("jq/process/gebruikers.php",{actie:'gebruikersamenvoegen',id:id,id_nieuw:id_nieuw},function(data)
	{
		$("#feedback").html(data);
		$("#feedback").bind("dialogclose",function(event) {location.reload(true); });
	});
}

function sgGebruiker(id,sg,aard)
{
	$("#feedback").html("<img src='../images/progress.gif' />");
	$.post("jq/process/gebruikers.php",{actie:'sg_gebruiker',id:id,sg:sg,aard:aard},function(data)
	{
		$("#feedback").html(data);
		$("#feedback").bind("dialogclose",function(event) {location.reload(true); });
	});
}

function maakLeerkracht(id,div,aard,actief)
{
	feedback("<img src='../images/progress.gif' />");
	$.post("jq/process/gebruikers.php",{actie:'maaklkt',id:id},function(data)
	{
		$("#feedback").html(data);
		laadOverzichtGebruikers(div,aard,actief);
	});
}

function maakPa(id,div,aard,actief)
{
	feedback("<img src='../images/progress.gif' />");
	$.post("jq/process/gebruikers.php",{actie:'maakpa',id:id},function(data)
	{
		$("#feedback").html(data);
		laadOverzichtGebruikers(div,aard,actief);
	});
}

function cpbwSubgroep(id)
{
	var dialogOpts = {
        title: "Koppel CPBW afdeling met Subgroep",
        modal: true,
        autoOpen: false,
        height: 700,
        width: 500,
		open:function() 
		{
			cpbwSubgroepOverview(id);
		}
    };
    
    $("#cpbw_subgroep").bind('dialogclose', function(event) {laadSubgroepOverzicht();});
	$("#cpbw_subgroep").dialog(dialogOpts);
    $("#cpbw_subgroep").dialog("open");
}

function cpbwSubgroepOverview(id)
{
	$("#cpbw_subgroep").html("<center>De gegevens worden opgezocht in de databank.<br /><br /><img src='../../images/progress.gif'></center>");
	
	$.post("jq/process/schooladmin.php",{actie:'subgroep_cpbw_overzicht',id:id}, function(data) 
	{
		$("#cpbw_subgroep").html(data);		
	});
}

function cpbwSubgroepAdd(id,id_cpbw)
{
	feedback("<img src='../images/progress.gif' />");
	$.post("jq/process/schooladmin.php",{actie:'subgroep_cpbw_voegtoe',id:id,id_cpbw:id_cpbw}, function(data) 
	{
		$("#feedback").html(data);		
		cpbwSubgroepOverview(id);
	});
}

function cpbwSubgroepRemove(id,id_cpbw)
{
	feedback("<img src='../images/progress.gif' />");
	$.post("jq/process/schooladmin.php",{actie:'subgroep_cpbw_verwijder',id:id,id_cpbw:id_cpbw}, function(data) 
	{
		$("#feedback").html(data);		
		cpbwSubgroepOverview(id);
	});
}

function gebruikerSubgroep(id)
{
	var dialogOpts = {
        title: "Koppel gebruikers met Subgroep",
        modal: true,
        autoOpen: false,
        height: 700,
        width: 500,
		open:function() 
		{
			gebruikerSubgroepOverview(id);
		}
    };
    
    $("#gebruiker_subgroep").bind('dialogclose', function(event) {laadSubgroepOverzicht();});
	$("#gebruiker_subgroep").dialog(dialogOpts);
    $("#gebruiker_subgroep").dialog("open");
}

function gebruikerSubgroepOverview(id)
{
	$("#gebruiker_subgroep").html("<center>De gegevens worden opgezocht in de databank.<br /><br /><img src='../../images/progress.gif'></center>");
	
	$.post("jq/process/schooladmin.php",{actie:'subgroep_gebruiker_overzicht',id:id}, function(data) 
	{
		$("#gebruiker_subgroep").html(data);		
	});
}

function gebruikerSubgroepAdd(id,id_gebruiker)
{
	feedback("<img src='../images/progress.gif' />");
	$.post("jq/process/schooladmin.php",{actie:'subgroep_gebruiker_voegtoe',id:id,id_gebruiker:id_gebruiker}, function(data) 
	{
		$("#feedback").html(data);		
		gebruikerSubgroepOverview(id);
	});
}

function gebruikerSubgroepRemove(id,id_gebruiker)
{
	feedback("<img src='../images/progress.gif' />");
	$.post("jq/process/schooladmin.php",{actie:'subgroep_gebruiker_verwijder',id:id,id_gebruiker:id_gebruiker}, function(data) 
	{
		$("#feedback").html(data);		
		gebruikerSubgroepOverview(id);
	});
}

function reloadStylesheets() {
    var queryString = '?reload=' + new Date().getTime();
    $('link[rel="stylesheet"]').each(function () {
        this.href = this.href.replace(/\?.*|$/, queryString);
    });
}

function start_db_sync()
{
	var dialogOpts = {
        title: "Update databank school",
        modal: true,
        autoOpen: false,
        height: 300,
        width: 500,
        closeOnEscape: false,
		open:function() 
		{
			//$(".ui-dialog-titlebar-close",ui.dialog||ui).hide();
			$("#feedback").html("<center><font color=red><br /><br /><h2>Update databank gestart!<br /><br />Dit kan enkele minuten duren, dank u voor uw begrip!<br /><br /><img src='../images/progress.gif'></h2></font></center>");
			
			$.post("jq/process/sync_db_school.php",{actie:'start'}, function(data) 
			{
				$("#feedback").html(data);	
				window.setTimeout(function(){location.reload()},2000);	
			});
		}
    };
    
	$("#feedback").dialog(dialogOpts);
    $("#feedback").dialog("open");

}

function web_bestand_download(id)
{
	
	var dialogOpts = {
        title: "Bestand downloaden",
        modal: true,
        autoOpen: false,
        height: 200,
        width: 500,
		open:function() 
		{
			$("#download").html("<center>Het bestand wordt klaargemaakt voor download!<br /><br /><img src='images/progress.gif'></center>");
			
			$.post("jq/process/webpagina.php",{id:id,actie:"download"}, function(data) 
				{
					switch(data)
				 	{
						case '0':
							
							$("#download").dialog("close");
							alert('Fout 0: het gevraagde bestand bestaat niet in de databank!');
						break;
						
						case '1':
							
							$("#download").dialog("close");
							alert('Fout 1: bestand niet gevonden op de server');
						break;
						
						default:
							$("#download").html(data);
						break;
					}
				});
		}
    };
    
	$("#download").dialog(dialogOpts);
    $("#download").dialog("open");
}

function verwijderSchoolLogin(id)
{
	$.post("jq/process/schoollogin.php",{id:id}, function(data) 
	{
		//alert(id+": "+data);
		location.reload();	
	});
}