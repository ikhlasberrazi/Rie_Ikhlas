<?php

define('DB_NAME','agora_stage');
define('DB_USER','root');
define('DB_PASSWORD', 'usbw');
define('DB_HOST','localhost:8080');

$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);

if(!$link)
    {die('fout: ' .mysql_error());}

$dbselected = mysql_select_db(DB_NAME, $link);
if(!$dbselected)
    {die('Kan '.DB_NAME.' niet gebruiken');}

echo("verbonden!");

$value1=$_POST['vraag'];
$value2=$_POST['type_input'];

$q_update = 
    "INSERT INTO rie_input(vraag, type_input)
    VALUES ('$value1','$value2')";
    
if(!mysql_query($q_update))
    {die('Error: '.mysql_error());}
    
?>