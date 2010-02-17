<?php
class Texty extends Modul{

var $acl = array(	"show" => "guest",
					"get_default" => "guest",
					"test2" => "administrator",
					"nevim" => "administrator");

function get_default($n){
return "OK";
}

function show(){
global $database;
if(isset($_GET['text'])){$popis = $_GET['text'];}
else {$popis = "default";}
//if (valid($popis)){} TODO
$q = "SELECT * from texty WHERE jmeno='$popis'";
echo $q;
$result = $database->query($q);
$text = mysql_result($result,0,"text");
return $text;

}

}?>