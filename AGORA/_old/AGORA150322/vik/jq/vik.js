function laadRieStructuurVIK()
{
	$("#rieStructuur").html("<img src='../images/progress.gif' />");
	
	$.post("jq/process/vik.php",{actie:"structuur"}, function(data) 
	{
		$("#rieStructuur").html(data);
	});
}

function vik_overzicht_detail(aard,id)
{
		$("#vik").html("<img src='../images/progress.gif' />");
	
	$.post("jq/process/vik.php",{aard:aard,id:id,actie:"overzicht_vik"}, function(data) 
	{
		$("#vik").html(data);
	});
}

function vik(id_hoofd,aard,id,naam)
{
	var dialogOpts = 
	{
        modal: true,
        autoOpen: false,
        height: 500,
        width: 1024,
        
		open:function() 
		{
			vik_overzicht_detail(aard,id);
		}
	}
	
	$('div#vik').bind('dialogclose', function(event) {laadSubstructuur(id_hoofd); });
	
	$("#vik").dialog(dialogOpts);
	$("#vik").dialog({title: 'Overzicht VIK: '+naam});
    $("#vik").dialog("open");
}

function vikDeactiveer(aard,id,id_vik)
{
	$.post("jq/process/vik.php",{actie:'deactiveer',aard:aard,id:id_vik}, function(data) 
	{
		feedback(data);
		vik_overzicht_detail(aard,id);
	});
}

function vikVerwijder(aard,id,id_vik)
{
	$.post("jq/process/vik.php",{actie:'verwijder',aard:aard,id:id_vik}, function(data) 
	{
		feedback(data);
		vik_overzicht_detail(aard,id);
	});
}

function vikActiveer(aard,id,id_vik)
{
	$.post("jq/process/vik.php",{actie:'activeer',aard:aard,id:id_vik}, function(data) 
	{
		feedback(data);
		vik_overzicht_detail(aard,id);
	});
}

function uploadVIK(aard,id)
{
	var dialogOpts = 
	{
        modal: true,
        autoOpen: false,
        height: 300,
        width: 400,
        
		open:function()
		{
			$("#vikUpload").html("<img src='../images/progress.gif' />");
			
			$.post("jq/process/vik.php",{actie:'uploadform',id:id,aard:aard}, function(data) 
			{
				$("#vikUpload").html(data);
			});
		}
    };
	
	$("#vikUpload").dialog(dialogOpts);
	$("#vikUpload").dialog({title: 'Upload VIK'});
    $("#vikUpload").dialog("open");
}

function VIKstartUpload(id,aard,sessie)
{
	  $('#file_upload').uploadify({
	    'uploader'  : 'jq/uploadify/uploadify.swf',
//	    'script'    : 'http://localhost:8080/weveco/jq/process/uploadDossier.php',
	    'script'    : 'jq/process/vik.php',
	    'cancelImg' : 'jq/uploadify/cancel.png',
	    'buttonText' : 'Bladeren',
	    'sizeLimit'   : 15728640,
	    'fileTypeDesc' : 'Afbeeldingen en documenten',
        'fileTypeExts' : '*.gif; *.jpg; *.png; *.doc; *.docx; *.xls; *.xlsx; *.ppt; *.pptx; *.pdf;',
	    'auto'      : true,
	    'scriptData' : {id:id,aard:aard,actie:'uploadsave',sessie:sessie},
	    'onComplete'  : function(event, ID, fileObj, response, data) 
			{ 
				$("#vikUpload").dialog("close");
								
				vik_overzicht_detail(aard,id);
								
				feedback(response);
			}
	  });	
}

function VIKdownloadBestand(id)
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
			
			$.post("jq/process/vik.php",{id:id,actie:'download'}, function(data) 
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