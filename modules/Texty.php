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
return "OK";
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
else {return "unknown";}
}


function show(){
global $database;
if(isset($_GET['text'])){$this->popis = $_GET['text'];}
else {$this->popis = "default";}
//if (valid($popis)){} TODO
$q = "SELECT * from texty WHERE jmeno='$this->popis'";
$result = $database->query($q);
if(mysql_num_rows($result) == 1){
$this->text = mysql_result($result,0,"text");
$this->nadpis = mysql_result($result,0,"nadpis");
return $this->text;}
else {return "";}
}

}?>