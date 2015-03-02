//dialog form structuur laden in rie.php case structuur
function analyseLijst()
{
	alert("laadRie");


	$("#lijsten").html("<img src='../images/progress.gif' />");
	//Vragen laden
	$.post("jq/rieAnalyses.php",{actie:"analyseLijstOverzicht"}, function(data) 
	{
		$("#lijsten").html(data);
        $( "#sortable1, #sortable2" ).sortable({
            connectWith: ".connectedSortable"}).disableSelection();
	});
    
}//einde laadvragenlijst


