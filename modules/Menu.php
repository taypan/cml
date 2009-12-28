<?php
class Menu extends Modul{


function __construct($info,$arg){
parent::__construct($info,$arg);
//$this->fetch_data();

}
//function 

function get_content(){
global $database,$tag,$model,$controler;
$menu = $this->arg['menu'];
$q = "SELECT alt,link,id FROM menus_items WHERE menu = '$menu' ORDER BY position";
$result = $database->query($q);
$sum = "";
for($i = 0;$i != mysql_numrows($result);$i++){
$page = mysql_result($result,$i,'link');
$alt = mysql_result($result,$i,'alt');
$id = mysql_result($result,$i,'id');
//TODO hází chybu pri pradani noveho menu resenim je "$controler->acl->hasResource('menus_item_'.$id) && " do podminky, ale to odsud nejde zavolat 
try {
if($model->user->isAllowed('menus_item_'.$id,'view')){
$sum = $sum."<dt>".$tag->a($page,$alt)."</dt>";}
	}
catch (InvalidStateException $vyjímka) {}
}
return $sum;
}

function get_title(){
global $database;
$menu = $this->arg['menu'];
$q = "SELECT title FROM menus WHERE menu = '$menu'";
$result = $database->query($q);
if(mysql_num_rows($result) > 0){
return mysql_result($result,0,'title');
}
}


}
?>