function test(){alert("test");}

function analyseLijst()
{

			//alert ("hoogte");
			$("#lijsten").html("<img src='../images/progress.gif' />");
			//Vragen laden
			$.post("jq/rieAnalyses.php",{actie:"nieuweAudit"}, function(data) 
			{
				$("#lijsten").html(data);
				$( "#dialog" ).dialog(
				{
					active: false, 
					collapsible: true, 
					width: $(window).width()-200, 
					height:$(window).height()-250,
					maxWidth:$(window).width(),
					maxHeight: $(window).height()
				});
				$( "#sortable3" ).sortable({
						items: "li:not(.ui-state-disabled)", 
						update: function(event, ui)
							{var postData = $(this).sortable('serialize'); 
							console.log(postData)}}).disableSelection();
				//zorgen dat de eerste twee tabellen blijven en dat een kloon wordt opgeslagen in tabel 3
				$( "#sortable1, #sortable2" ).sortable({
						connectWith: ".audit", 
						remove: function(event, ui) {
						ui.item.clone().appendTo('#sortable3');
						$(this).sortable('cancel');
					}
				}).disableSelection();
			  
			});//einde vragen laden
		
}//einde laadvragenlijst


function opslaan()
{
	
			  alert("in opslaan");
			  //audit lijst opslaan
			  $.post("jq/rieAnalyses.php",$("#auditform").serialize(), function(data)
			  {
				  feedback(data);
				
			  });
		 
}


