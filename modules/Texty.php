<?php
class Texty extends Modul{

var $text;
var $nadpis;
var $popis;
var $acl = array(	"show" => "guest",
					"get_default" => "guest",
					"test" => "guest",
					"nevim" => "administrator");
/*
function __construct($n){
global $database;
if(isset($_GET['text'])){$this->popis = $_GET['text'];}
else {$this->popis = "default";}
//if (valid($popis)){} TODO
$q = "SELECT * from texty WHERE jmeno='$this->popis'";
$result = $database->query($q);
$this->text = mysql_result($result,0,"text");
$this->nadpis = mysql_result($result,0,"nadpis");
return;
}*/

function get_default($n){
return $this->show(DEFAULT_TEXT);
}

function get_title($n){
global $database;
if(isset($_GET['text'])){$this->popis = $_GET['text'];}
else {$this->popis = "default";}
//if (valid($popis)){} TODO
$q = "SELECT * from texty WHERE jmeno='$this->popis'";
$result = $database->query($q);
if(mysql_num_rows($result) == 1){
$this->text = mysql_result($result,0,"text");
$this->nadpis = mysql_result($result,0,"nadpis");
return $this->nadpis;}
else {
$q = "SELECT * from texty WHERE jmeno='rozcestnik'";
$result = $database->query($q);
if(mysql_num_rows($result) == 1){
$this->text = mysql_result($result,0,"text");
$this->nadpis = mysql_result($result,0,"nadpis");
return $this->nadpis;} 
else {return "Text";}
//return "unknown";
}
}


function show($popis = ""){
global $database;
if(isset($_GET['text'])){$this->popis = $_GET['text'];
}
else {
$this->popis = $popis;}
if($this->popis == "podminky"){return file_get_contents("files/podminky.html");exit;}
elseif($this->popis == "kdojsme"){return file_get_contents("files/kdojsme.html");exit;}
//if (valid($popis)){} TODO
$q = "SELECT * from texty WHERE jmeno='$this->popis'";
$result = $database->query($q);
if(mysql_num_rows($result) == 1){
$this->text = mysql_result($result,0,"text");
$this->nadpis = mysql_result($result,0,"nadpis");
return $this->text;}
else {return MSG_BEGIN."Zadaný text neexistuje!".MSG_END;}
}

}?>