<?php
class Layout extends Modul{

var $sum;

function __construct($info,$arg){
parent::__construct($info,$arg);
//$this->fetch_data();

}
//function 

function get_content(){

$count = $this->fetch_count();

$this->sum("<table width=\"281\" height=\"281\" border = \"2\" cellspacing=\"15\">");
$sloupce = ($count['left'] + $count['right'] +$count['center']) - $count['header'];

$this->sum("<tr>");
for($i = 0;$i != $count['header'];$i++){$this->sum("<td colspan = \"$sloupce\">&nbsp;</td>");}
$this->sum("</tr>");
unset($count['header']);

for($i = 1;$i != (max($count)+1);$i++){
$this->sum("<tr>");

foreach($count as $key => $value){
if(($value) >= $i){echo $this->sum("<td>$key</td>");}
}
$this->sum("</tr>");
}
$this->sum("</table>");
////////////////////
return $this->sum;

}

function get_title(){
return "Configurator";
}

function sum($text){
$this->sum = $this->sum."\n".$text;
}

function fetch_count(){
global $database;
$q = "SELECT * FROM panels WHERE area = 'left'"; 
$result = $database->query($q);
$count['left'] = mysql_num_rows($result);
$q = "SELECT * FROM panels WHERE area = 'center'"; 
$result = $database->query($q);
$count['center'] = mysql_num_rows($result);
$q = "SELECT * FROM panels WHERE area = 'right'"; 
$result = $database->query($q);
$count['right'] = mysql_num_rows($result);
$q = "SELECT * FROM panels WHERE area = 'header'"; 
$result = $database->query($q);
$count['header'] = mysql_num_rows($result);
return $count;
}


}
?>