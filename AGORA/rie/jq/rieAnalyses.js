//dialog form structuur laden in rie.php case structuur
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
        $( "#sortable3" ).sortable({items: "li:not(.ui-state-disabled)", update: function(event, ui){var postData = $(this).sortable('serialize'); console.log(postData)}}).disableSelection();
        $( "#sortable1, #sortable2" ).sortable({connectWith: ".audit"}).disableSelection();
      
    });//einde vragen laden
    
}//einde laadvragenlijst

/**
 * function analyseOpslaan()
 * {
 *     buttons:
 * 		{
 * 			"Opslaan": function() 
 * 			{	
 *                 alert("in opslaan");
 *                 //audit lijst opslaan
 *                 $.post("jq/rieAnalyses.php",$("#auditform").serialize(), function(data)
 *                 {
 *                     feedback(data);
 *                     
 *                 });
 *             }//einde opslaan
 *     
 * }
 */




