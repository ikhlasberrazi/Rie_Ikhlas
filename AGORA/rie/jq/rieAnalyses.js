function analyseLijst(id)
{

			//alert(id);
			$("#lijsten").html("<img src='../images/progress.gif' />");
			//Vragen laden
			$.post("jq/rieAnalyses.php",{actie:"nieuweAudit", id:id}, function(data) 
			{
				
				$("#lijsten").html(data);
				$( "#dialog" ).dialog(
				{
					active: false, 
					collapsible: true, 
					width: $(window).width()-200, 
					height:$(window).height()-250,
					maxWidth:$(window).width(),
					maxHeight: $(window).height(),
					buttons:
					{
						"Opslaan": function(){
							
							  $.post("jq/rieAnalyses.php",$("#auditFormID").serialize(), function(data)
							  {
								  feedback("<center><img src='../images/progress.gif'></center>");
									feedback(data);
									laadAuditTabel();
								  
								
							  });
							$(this).dialog("close");
						}
					}
					
				});
				
				//begin lijst sortable maken
				$( "#audit_lijst" ).sortable({
						items: "li:not(.ui-state-disabled)", 
						update: function(event, ui)
							{var postData = $(this).sortable('serialize'); 
							console.log(postData)}}).disableSelection();
				//zorgen dat de eerste twee tabellen blijven en dat een kloon wordt opgeslagen in tabel 3
				$( "#vragen_sortable, #onderdelen_sortable" ).sortable({
						connectWith: ".audit", 
						remove: function(event, ui) {
						ui.item.clone().appendTo('#audit_lijst');
						$(this).sortable('cancel');
					}
				}).disableSelection();
			  
			});//einde vragen laden
		
}//einde laadvragenlijst


function laadAuditTabel()
{
	$("#auditTabel").html("<img src='../images/progress.gif' />");
	
	$.post("jq/rieAnalyses.php",{actie:"actieveAuditLijst"}, function(data) 
	{
		$("#auditTabel").html(data);
        
	});
			
		 
}




