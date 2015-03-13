<html>
<div id="dialog"></div>
<script>
function startdialog()
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
        
	$("#dialog").dialog(dialogOpts);    
    $("#dialog").html("<a href='javascript:void(0);' onClick='voegToe();'>Add</a><br /><div id='spin'>Overzicht:<br /></div>");
	$("#dialog").dialog("open");

}

function voegToe()
{
	$("#spin").append("<div>Test</div>");
}

startdialog();
</script>
</html>