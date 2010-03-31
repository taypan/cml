<?php
if(!class_exists("Menu")){
class Menu extends Modul{


function __construct($info,$arg){
parent::__construct($info,$arg);
//$this->fetch_data();

}
//function 
function item2temp($level,$link,$alt){
$temp = file_get_contents(TEMPLATES_DIRECTORY.CURRENT_TEMPLATE."/menu_temp_".$level.".html");
$temp = str_replace("<!--menu-link -->",$link,$temp);
$temp = str_replace("<!--menu-alt -->",$alt,$temp);
return $temp;
}

function get_content(){
global $database,$tag,$model,$controler;
$menu = $this->arg['menu'];
$q = "SELECT * FROM menus_items WHERE menu = '$menu' ORDER BY position";
$result = $database->query($q);
$sum = "";
for($i = 0;$i != mysql_numrows($result);$i++){
$obj = mysql_fetch_object($result);
/*$page = mysql_result($result,$i,'link');
$alt = mysql_result($result,$i,'alt');
$id = mysql_result($result,$i,'id');*/
//TODO hází chybu pri pradani noveho menu resenim je "$controler->acl->hasResource('menus_item_'.$id) && " do podminky, ale to odsud nejde zavolat 
try {
if($model->user->isAllowed('menus_item_'.$obj->id,'view')){
$sum = $sum.$this->item2temp($obj->deep,$obj->link,$obj->alt);

}
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
}
?>