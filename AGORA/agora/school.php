<script type="text/javascript"> 
$(document).ready(function()
{
   $('a[title]').qtip({
style: { 
      tip: { // Now an object instead of a string
         corner: 'topLeft', // We declare our corner within the object using the corner sub-option
         color: '#6699CC',
         size: {
            x: 20, // Be careful that the x and y values refer to coordinates on screen, not height or width.
            y : 15 // Depending on which corner your tooltip is at, x and y could mean either height or width!
         }
}  } 
   });
});
</script>


<?php
	

	print("<br /><br />
	<table width='100%'>
	<tr>
	<td valign='top'>");
	
	if($_SESSION[weveco2]!="") print("<div class='button actief'>
		<a href='#' class='actief' onClick=\"window.open('".$_SESSION['http']."kms/index.php?pad=school&go=overzicht_beleid');\" title=\"<b>Kwaliteitsmanagementsysteem niveau organisatorisch proces</b><ul><li>Managementsysteem niveau CPA en PA volgens ISO 9001, 14001 en OHSAS 18001</li><li>uitgewerkte PRO, DOC, FRM en RGS niveau beleid en organisatie (GIDPBW of GID)</li><li>Kwaliteitshandboek – procedures en documenten beleid en organisatie GIDPBW</li></ul>\"><img src='images/kms.png' height='100'></a>
	</div>");
	
	if($_SESSION[weveco]!="") print("<div class='button actief'>
		<a href='#' class='actief' onClick=\"popup('weveco3');\" title=\"<b>WEVECO</b><ul><li>Frame met inventaris wettelijke verplichtingen</li><li> Uitgewerkte procedures (PRO, DOC, FRM, RGS en WI)</li><li>Wettelijke keuringen, controles – vergunningen -  opleidingen -  verslagen – verplichtingen -  occasioneel - codes  goede praktijken</li></ul>\"><img src='images/weveco.png' height='100'></a>
	</div>");
	
	if($_SESSION[inspectie]!="") print("<div class='button actief'>
		<a href='javascript:void(0);' onClick=\"window.open('".$_SESSION['http']."inspectie/index.php');\" title=\"<b>Inspectie Index</b>\"><img src='images/inspectie.png' height='100'></a>
	</div>"); 
	else print("<div class='button inactief'>
		<a href='javascript:void(0);' title=\"<b>Inspectie Index</b>\"><img src='images/inspectie.png' height='100'></a>
	</div>"); 
	
	if($_SESSION[taakbeheer]!="") print("<div class='button actief'>
		<a href='javascript:void(0);' onClick=\"window.open('".$_SESSION['http']."taakbeheer/');\" title=\"<b>Taakbeheer</b><ul><li>Meldingen</li><li>Taken</li><li>Maandverslag</li></ul>\"><img src='images/taakbeheer.png' height='100'></a>
	</div>"); 
	else print("<div class='button inactief'>
		<a href='javascript:void(0);' title=\"<b>Taakbeheer</b><ul><li>Agenda</li><li>Taken</li><li>Rondgang</li><li>Maandverslag</li></ul>\"><img src='images/taakbeheer.png' height='100'></a>
	</div>"); 
	
	if($_SESSION[EDPBW]!="") print("<div class='button actief'>
		<a href='#' class='actief' onClick=\"popup('EDPBW');\" title=\"<b>Externe Dienst Preventie en Bescherming op het Werk</b><ul><li>
	 Opmaak lijsten van onderworpenen en niet onderworpenen aan de hand van riscoanalyses, berekening van de jaarlijkse facturatie, en tijdskrediet, verplichte wettelijke opleidingen, …. zowel op niveau CPA als PA.</li></ul>\"><img src='images/EDPBW.png' height='100'></a>
	</div>"); 
	else print("<div class='button inactief'>
		<a href='#' title=\"<b>Externe Dienst Preventie en Bescherming op het Werk</b><ul><li>
	 Opmaak lijsten van onderworpenen en niet onderworpenen aan de hand van riscoanalyses, berekening van de jaarlijkse facturatie, en tijdskrediet, verplichte wettelijke opleidingen, …. zowel op niveau CPA als PA.</li></ul>\"><img src='images/EDPBW.png' height='100'></a>
	</div>"); 
	
	
	if($_SESSION[rie]!="") print("<div class='button actief'>
		<a href='#' class='actief' onClick=\"popup('rie');\" title=\"<b>RIE</b><ul><li>
	 Risico Inventarisatie en Evaluatie</li></ul>\"><img src='images/rie.png' height='100'></a>
	</div>"); 
	else print("<div class='button inactief'>
		<a href='#' title=\"<b>RIE</b><ul><li>Risico Inventarisatie en Evaluatie
	 </li></ul>\"><img src='images/rie.png' height='100'></a>
	</div>"); 
	
	if($_SESSION[pbm]!="") print("<div class='button actief'>
		<a href='#' class='actief' onClick=\"window.open('".$_SESSION['http']."PBM/index.php');\" title=\"<b>Persoonlijke beschermingsmiddelen</b>
		<ul><li>Opvolging PBM van leerlingen, leerkrachten en onderhoudspersoneel.</li><li>
	Niveau werkplaatsen en werkopdrachten</li>
	</ul>\"><img src='images/pbm.png' height='100'></a>
	</div>"); 
	else print("<div class='button inactief'>
		<a href='#' title=\"<b>Persoonlijke beschermingsmiddelen</b>
		<ul><li>Opvolging PBM van leerlingen, leerkrachten en onderhoudspersoneel.</li><li>
	Niveau werkplaatsen en werkopdrachten</li>
	</ul>\"><img src='images/pbm.png' height='100'></a>
	</div>"); 
	
	if($_SESSION[pbm]!="") print("
	<div class='button actief'>
		<a href='#' class='actief' onClick=\"popup('toolbox');\" ");
	else print("
	<div class='button inactief'>
		<a href='#' ");
		
	print(" title=\"<b>Toolboxmeetingorganisator</b><ul><li>
	Eén van de preventiemaatregelen is het overbrengen van informatie en opleiding rond gevaren die betrekking hebben op: veiligheid op het werk, de bescherming van de gezondheid van de werknemer, de psychosociale belasting, de ergonomie, de arbeidshygiëne, de verfraaiing van de werkplaats.</li></ul>\"><img src='images/toolbox.png' height='100'></a>
	</div>"); 
	
	if($_SESSION[wpf]!="") print("<div class='button actief'>
		<a href='#' class='actief' onClick=\"popup('wpf');\" title=\"<b>Werkpostfiche</b><ul><li>
	 veiligheidsinstructiekaarten</li></ul>\"><img src='images/werkpostfiche.png' height='100'></a>
	</div>"); 
	else print("<div class='button inactief'>
		<a href='#' title=\"<b>Werkpostfiche</b><ul><li>werkpostfiche...
	 </li></ul>\"><img src='images/werkpostfiche.png' height='100'></a>
	</div>"); 
	
	if($_SESSION[vik]!="") print("<div class='button actief'>
		<a href='#' class='actief' onClick=\"popup('vik');\""); 
	else print("<div class='button inactief'>
		<a href='#'");
	
	print(" title=\"<b>VIK</b><ul><li>veiligheidsinstructiekaarten (Bibliotheek)
	 </li></ul>\"><img src='images/vik.png' height='100'></a>
	</div>"); 

	
	if($_SESSION[rebos]!="") print("<div class='button actief'>
		<a href='javascript:void(0);' onClick=\"window.open('".$_SESSION['http']."rebos');\" title=\"<b>Registratie en Beheer van Ongevallen op School</b><ul><li>Registratie van leerlingenongevallen, stage-ongevallen, personeelsongevallen en EHBO-handelingen; bepalen van de ernst van een ongeval aan de hand van de codes die op de ongevallensteekkaart moeten ingevuld worden; …
</li></ul>\"><img src='images/rebos.png' height='100'></a>
	</div>"); 
	elseif($_SESSION[aard]!='lkt') print("<div class='button inactief'>
		<a href='javascript:void(0);' title=\"<b>Registratie en Beheer van Ongevallen op School</b><ul><li>Registratie van leerlingenongevallen, stage-ongevallen, personeelsongevallen en EHBO-handelingen; bepalen van de ernst van een ongeval aan de hand van de codes die op de ongevallensteekkaart moeten ingevuld worden; …
</li></ul>\"><img src='images/rebos.png' height='100'></a>
	</div>"); 
	
	print("<div class='button inactief' height=100>
		<a href='javascript:void(0);' title=\"<b>Registratie EHBO</b>\"><img src='images/EHBO.png' height='100'></a>
	</div>"); 
	
	if($_SESSION[pmge]!="") print("<div class='button actief'>
		<a href='javascript:void(0);' title=\"<b>Producten Met Gevaarlijke Eigenschappen</b>\"><img src='images/gsp.png' height='100'></a>
	</div>");
	else print("<div class='button inactief'>
		<a href='javascript:void(0);' title=\"<b>Producten Met Gevaarlijke Eigenschappen</b>\"><img src='images/gsp.png' height='100'></a>
	</div>"); 
	

	
	if($_SESSION[arbeidsmiddelen]!="") print("<div class='button actief'>
		<a href='#' class='actief' onClick=\"popup('AM');\" title=\"<b>Arbeidsmiddelen</b><ul><li>
	 Arbeidsmiddelen: indienststelling, uitdienststelling, inventaris.</li></ul>\"><img src='images/arbeidsmiddelen.png' height='100'></a>
	</div>"); 
	else print("<div class='button inactief'>
		<a href='#' title=\"<b>Arbeidsmiddelen</b><ul><li>Arbeidsmiddelen: indienststelling, uitdienststelling, inventaris,...
	 </li></ul>\"><img src='images/arbeidsmiddelen.png' height='100'></a>
	</div>"); 
	
	
	if($_SESSION[BA4-BA5]!="") print("<div class='button actief'>
		<a href='#' class='actief' onClick=\"popup('BA4-BA5');\" title=\"<b>BA4-BA5</b><ul><li>
	 BA4-BA5</li></ul>\"><img src='images/BA4-BA5.png' height='100'></a>
	</div>"); 
	else print("<div class='button inactief'>
		<a href='#' title=\"<b>VIK</b><ul><li>BA4-BA5
	 </li></ul>\"><img src='images/BA4-BA5.png' height='100'></a>
	</div>"); 
	
	if($_SESSION[gpp]!="") print("<div class='button actief'>
		<a href='#' class='actief' onClick=\"popup('gpp');\" title=\"<b>GPP</b><ul><li>
	 Globaal Preventie Plan</li></ul>\"><img src='images/gpp.png' height='100'></a>
	</div>"); 
	else print("<div class='button inactief'>
		<a href='#' title=\"<b>GPP</b><ul><li>Globaal Preventie Plan
	 </li></ul>\"><img src='images/gpp.png' height='100'></a>
	</div>"); 
	
	if($_SESSION[jap]!="") print("<div class='button actief'>
		<a href='#' class='actief' onClick=\"popup('jap');\" title=\"<b>JAP</b><ul><li>
	 JaarActiePlan</li></ul>\"><img src='images/jap.png' height='100'></a>
	</div>"); 
	else print("<div class='button inactief'>
		<a href='#' title=\"<b>JAP</b><ul><li>JaarActiePlan
	 </li></ul>\"><img src='images/jap.png' height='100'></a>
	</div>"); 
	
	print("<div class='button inactief'>
		<a href='#' title=\"<b>Bestelbon</b><ul><li>Bestelbon
	 </li></ul>\"><img src='images/bestelbon.png' height='100'></a>
	</div>"); 
	
	print("<div class='button inactief'>
		<a href='#' title=\"<b>Inventaris</b><ul><li>Inventaris
	 </li></ul>\"><img src='images/inventaris.png' height='100'></a>
	</div>"); 
	
	if($_SESSION[opleiding]!="") print("<div class='button actief'>
		<a href='#' class='actief' onClick=\"popup('opleiding');\" "); 
	else print("<div class='button inactief'>
		<a href='#' ");
	print(" title=\"<b>Opleidingen</b>\"><img src='images/opleiding.png' height='100'></a>
	</div>"); 
	
	if($_SESSION[wik]!="") print("<div class='button actief'>
		<a href='#' class='actief' onClick=\"popup('wik');\""); 
	else print("<div class='button inactief'>
		<a href='#'");
	
	print(" title=\"<b>WIK</b><ul><li>WerkInstructieKaarten (Bibliotheek)
	 </li></ul>\"><img src='images/vik.png' height='100'><br />WIK</a>
	</div>"); 
	
	print("<div class='button actief'>
		<a href='#' onClick=\"popup('afdruk');\" title=\"<b>AFDRUKKEN</b><ul><li>Printmodule voor alle Agora-applicaties
	 </li></ul>\"><img src='images/afdruk.png' height='100'></a>
	</div>"); 
	
	print("
	</td><td id='nieuws'>
	<div>
	");
	
	laatste_nieuws_titels($link,"agora","3");
	
	print("<br /><br /><br /></div>
	<div id='db_weveco'>weveco</div>
	<div id='db_agenda'></div>
	<div id='db_taakmelding'></div>
	
	</td></tr>
	</table><div id='leesbericht'></div>");
?>