//dialog form structuur laden in rie.php case structuur
function analyseLijst()
{
	//alert("laadRie");


	$("#lijsten").html("<img src='../images/progress.gif' />");
	//Vragen laden
	$.post("jq/rieAnalyses.php",{actie:"analyseLijstOverzicht"}, function(data) 
	{
		$("#lijsten").html(data);
        $( "#accordion" ).accordion({active: false, collapsible: true});
	});
    
}//einde laadvragenlijst


