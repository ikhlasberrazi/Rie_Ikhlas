function laadVikStructuur()
{
	$("#vikStructuur").html("<img src='../images/progress.gif' />");
	
	$.post("jq/process/vikopties.php",{actie:"structuur"}, function(data) 
	{
		$("#vikStructuur").html(data);
	});
}

function laadVikHoofdStructuur()
{
	$("#vikStructuur").html("<img src='../images/progress.gif' />");
	
	$.post("jq/process/vikopties.php",{actie:"hoofdstructuur"}, function(data) 
	{
		$("#vikStructuur").html(data);
	});
}

function vikDeactiveer(aard,id)
{
	$.post("jq/process/vikopties.php",{actie:"deactiveer",aard:aard,id:id}, function(data) 
	{
		laadvikStructuur();
	});	
}

function categorieVik(id_hoofd,actie,id)
{
	var dialogOpts = 
	{
        modal: true,
        autoOpen: false,
		
        height: 150,
        width: 350,
		open:function() 
		{
			$("#vikHoofd").html("<img src='../images/progress.gif' />");
			
			$.post("jq/process/vikopties.php",{actie:'categorie_form',id:id}, function(data) 
			{
				$("#vikHoofd").html(data);
			});
		},
		buttons:
		{
			"Opslaan": function() 
			{				
				
				$.post("jq/process/vikopties.php",$("#hoofdcategorie").serialize(), function(data) 
				{

					feedback("<center><img src='../images/progress.gif'></center>");
					
					switch(data)
				 	{
						
						case '0':
							feedback(data);
						break;
						
											
						default:
						
							//feedback(data);
							
							if(data>'0')
							{
								$("#vikHoofd").dialog("close");
								feedback(data);
								
								//laadVikStructuur();
								laadSubstructuur(id_hoofd);
							}
						break;
					}
				});
			}
		}
    };

	
	$("#vikHoofd").dialog(dialogOpts);
	$("#vikHoofd").dialog({title: 'Hoofdcategorie: ' + actie});
    $("#vikHoofd").dialog("open");
}

function SubCategorieVik(id_hoofd,actie,id,naam)
{
	var dialogOpts = 
	{
        modal: true,
        autoOpen: false,
        height: 150,
        width: 400,
        
		open:function() 
		{
			$("#vikSub").html("<br /><br /><br /><img src='../images/progress.gif' />");
			
			$.post("jq/process/vikopties.php",{actie:'subcategorie_form',id:id,aard:actie}, function(data) 
			{
				$("#vikSub").html(data);
			});
		},
		buttons:
		{
			"Opslaan": function() 
			{				
				
				$.post("jq/process/vikopties.php",$("#subcategorie").serialize(), function(data) 
				{

					feedback("<center><img src='../images/progress.gif'></center>");
					
					switch(data)
				 	{
						
						case '0':
							feedback(data);
						break;
						
											
						default:
						
							//feedback(data);
							
							if(data>'0')
							{
								$("#vikSub").dialog("close");
							
								feedback(data);
								
								//laadVikStructuur();
								laadSubstructuur(id_hoofd);
							}
						break;
					}
				});
			}
		}
    };

	$("#vikSub").dialog(dialogOpts);
	$("#vikSub").dialog({title: naam+' subcategorie: ' + actie});
    $("#vikSub").dialog("open");
}

function artikelVik(aard,id,id_hoofd,id_sub,naam)
{
	var dialogOpts = 
	{
        modal: true,
        autoOpen: false,
        height: 150,
        width: 350,
        
		open:function() 
		{
			$("#vikArtikel").html("<img src='../images/progress.gif' />");
			
			$.post("jq/process/vikopties.php",{actie:'artikel_form',id:id,id_hoofd:id_hoofd,id_sub:id_sub,aard:aard}, function(data) 
			{
				$("#vikArtikel").html(data);
			});
		},
		buttons:
		{
			"Opslaan": function() 
			{				
				
				$.post("jq/process/vikopties.php",$("#artikel").serialize(), function(data) 
				{

					feedback("<center><img src='../images/progress.gif'></center>");
					
					switch(data)
				 	{
						
						case '0':
							feedback(data);
						break;
						
											
						default:
						
							//feedback(data);
							
							if(data>'0')
							{
								$("#vikArtikel").dialog("close");
							
								feedback(data);
								
								laadSubstructuur(id_hoofd);
							}
						break;
					}
				});
			}
		}
    };

	
	$("#vikArtikel").dialog(dialogOpts);
	$("#vikArtikel").dialog({title: 'Artikel: ' + naam + ' '+aard});
    $("#vikArtikel").dialog("open");
}

function vikDeactiveer2(aard,id,id_hulp)
{
	
	$.post("jq/process/vikopties.php",{actie:'deactiveer',aard:aard,id:id}, function(data) 
	{
		
		if(aard=="hoofdcategorie") $('div#feedback').bind('dialogclose', function(event) {location.reload(true); });
		else laadSubstructuur(id_hulp);
		feedback(data);
	});
}

function vikActiveer2(aard,id)
{
	$.post("jq/process/vikopties.php",{actie:'activeer',aard:aard,id:id}, function(data) 
	{
		$('div#feedback').bind('dialogclose', function(event) {location.reload(true); });
		feedback(data);
	});
}

function laadSubstructuur(id)
{
	$("#hoofd_"+id).html("<br /><br /><img src='../images/progress.gif' />");
	
	$.post("jq/process/vikopties.php",{actie:"substructuur",id_hoofd:id}, function(data) 
	{
		$("#hoofd_"+id).html(data);
	});
}

function Actiecategorie(actie,id)
{
	alert("in actie functie! " + actie +id);
	$.post("jq/process/vikopties.php",{actie : actie, id:id});
}