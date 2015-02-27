<?php
	
if($_SESSION[login]=="wos_coprant")
{
	?>
	 <script>
		$(document).ready(function(){
		    //define config object
		    $('#dataTable').dataTable( {
				"bPaginate": false,
				"bLengthChange": false,
				"bFilter": true,
				"bSort": true,
				"bInfo": false,
				"bAutoWidth": false,
				"oLanguage":
				{
				
					"sProcessing":   "Bezig met verwerken...",
					"sLengthMenu":   "Toon _MENU_ rijen",
					"sZeroRecords":  "Geen resultaten gevonden",
					"sInfo":         "_START_ tot _END_ van _TOTAL_ rijen",
					"sInfoEmpty":    "Er zijn geen records om te tonen",
					"sInfoFiltered": "(gefilterd uit _MAX_ rijen)",
					"sInfoPostFix":  "",
					"sSearch":       "Filter:",
					"sUrl":          "",
					"oPaginate": {
						"sFirst":    "Eerste",
						"sPrevious": "Vorige",
						"sNext":     "Volgende",
						"sLast":     "Laatste"
						}
				},
				"aaSorting": [[0, 'desc']]
			});
		});
		

	</script>
	<div id="leesbericht"></div>
	
	<?php
	
	if($_GET)
	{
		$limiet=$_GET[limiet];
		$id=mysqli_real_escape_string($link,$_GET[id]);
		$actie=$_GET[actie];
		$agora=$_GET[agora];
	}

	if(($_SESSION[aard]=="super") and ($actie=="verwijder"))
	{
		$q_delete="update agora_nieuws set actief='0' where id='".$id."'";
		$r_delete=mysqli_query($link,$q_delete);
		if($r_delete) print("<font color=green>Nieuwsbericht met succes gedeactiveerd!</font><br /><br />");
		else print("<font color=red>Nieuwsbericht NIET gedeactiveerd!</font><br /><br />");
	}	
	
	print("<h1>Nieuws</h1><br />");
	
	//alle nieuws item weergeven
	$q_nieuws="select * from agora_nieuws where actief='1' and deel like '".$agora."' order by id desc";
	
	if($limiet!="") $q_nieuws.=" limit ".$limiet;
	
	pq($q_nieuws);
	
	$r_nieuws=mysqli_query($link,$q_nieuws);
	if(mysqli_num_rows($r_nieuws)>"0")
	{
		print("
			<table id='dataTable' class='nieuws' border='1'>
				<thead>
					<tr>
						<td>Datum</td>
						<td>Onderdeel</td>
						<td>Titel</td>
						<td>Aard</td>");
		
		if($_SESSION[aard]=="super") print("<td>Actie</td>");
		
		print("
					</tr>
				</thead>
				<tbody>
		");
		
		while($nieuws=mysqli_fetch_array($r_nieuws))
		{
			print(utf8_encode("
					<tr onClick=\"leesNieuws('".$nieuws[id]."');\">
						<td>".$nieuws[datum]."</td>
						<td>".$nieuws[deel]." ".$nieuws[hoofdstuk]."</td>
						<td>".stripslashes($nieuws[titel])."</td>
						<td>"));
						if($nieuws[aard]=="1") print("Inhoudelijk");
						else print("Programmatorisch");
						print("</td>");
		
		if($_SESSION[aard]=="super") print("<td><a href='index.php?pad=../agora&go=nieuws&actie=verwijder&id=".$nieuws[id]."&agora=".$agora."'>Verwijder</a></td>");
		
		print("
					</tr>
				");
		}
		
		
		print("	</tbody>
			</table>");
	}
	else print("Geen nieuwsberichten gevonden!");
}
else
{
	include("../index.php");
}
	
?>