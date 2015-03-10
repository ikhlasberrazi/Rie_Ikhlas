<?php

session_start();
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  
  <style>
    body { font-size: 62.5%; }
    label, input { display:block; }
    input.text { margin-bottom:12px; width:95%; padding: .4em; }
    fieldset { padding:0; border:0; margin-top:25px; }
    h1 { font-size: 1.2em; margin: .6em 0; }
    div#vragen-contain { width: 350px; margin: 20px 0; }
    div#vragen-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
    div#vragen-contain table td, div#vragen-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
    .ui-dialog .ui-state-error { padding: .3em; }
    .validateTips { border: 1px solid transparent; padding: 0.3em; }
  </style>
  
  <script>
  $(function() {
    var dialog, form,
 
      id = $( "#id" ),
      vraag = $( "#vraag" ),
      id_audit =$("#id_audit"),
      id_onderdeel =$("#id_onderdeel"),
      type_input =$("#type_input"),
      actief=$("#actief"),
      //variabelen toevegen aan veldenlijst
      allFields = $( [] ).add( id ).add(id_audit).add(id_onderdeel).add( vraag ) .add(type_input).add(actief),
      tips = $( ".validateTips" );
 
    function updateTips( t ) {
      tips
        .text( t )
        .addClass( "ui-state-highlight" );
      setTimeout(function() {
        tips.removeClass( "ui-state-highlight", 1500 );
      }, 500 );
    }
 
 
 
    function checkRegexp( o, regexp, n ) {
      if ( !( regexp.test( o.val() ) ) ) {
        o.addClass( "ui-state-error" );
        updateTips( n );
        return false;
      } else {
        return true;
      }
    }
 
    function addVraag() {
     
      allFields.removeClass( "ui-state-error" );
 
      
        $( "#vragen tbody" ).append( "<tr>" +
          "<td>" + vraag.val() + "</td>" +
          "<td>" + type_input.val() + "</td>" +
        "</tr>" );
        $.post({
        url: 'vragendemo.php',
        data: 
        {  
           vraag:vraag.val(),
           type_input:type_input.val())
        }
        dialog.dialog( "close" );
      
    }
 
    dialog = $( "#dialog-form" ).dialog({
      autoOpen: false,
      height: 300,
      width: 350,
      modal: true,
      buttons: {
        "Voeg toe": addVraag,
        Cancel: function() {
          dialog.dialog( "close" );
        }
      },
      close: function() {
        form[ 0 ].reset();
        allFields.removeClass( "ui-state-error" );
      }
    });
 
    form = dialog.find( "form" ).on( "submit", function( event ) {
      event.preventDefault();
      addVraag();
    });
 
    $( "#voegVraagToe" ).button().on( "click", function() {
      dialog.dialog( "open" );
    });
  });
  </script>
</head>
<body>
 
<div id="dialog-form" title="Voeg vragen toe">
  <p class="validateTips">Elk veld moet worden ingevuld.</p>
 
  <form action="vragendemo.php" method="post">
    <fieldset>
      <label for="vraag">Vraag</label>
      <input type="text" id="vraag" name="vraag" class="text ui-widget-content ui-corner-all">
     <label for="type_input">Type input</label>
      <input type="text" id="type_input" name="type_input" class="text ui-widget-content ui-corner-all">
      
      <!-- Allow form submission with keyboard without duplicating the dialog button -->
      <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
    </fieldset>
  </form>
</div>
 
 
<div id="vragen-contain" class="ui-widget">
  <h1>Vragenlijst:</h1>
  <table id="vragen" class="ui-widget ui-widget-content">
    <thead>
      <tr class="ui-widget-header ">
        <th>Id</th>
        <th>id_audit</th>
        <th>id_onderdeel</th>
        <th id="vraag">Vraag</th>
        <th id="type_input" >type_input</th>
        <th>actief</th>
        
        
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>001</td>
        <td>Is het veilig?</td>
        <td>001</td>
        <td>Is het veilig?</td>
        <td>001</td>
        <td>Is het veilig?</td>
        
      </tr>
    </tbody>
  </table>
</div>
<button id="voegVraagToe">Voeg een vraag toe</button>
 
 
</body>
</html>