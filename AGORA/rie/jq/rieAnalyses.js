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




