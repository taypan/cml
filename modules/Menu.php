<?php
if(!class_exists("Menu")){
class Menu extends Modul{


function __construct($info,$arg){
parent::__construct($info,$arg);
//$this->fetch_data();

}

function jeGet($t,$value){
if(isset($_GET[$t]) && ($_GET[$t] == $value)){return TRUE;} else {return FALSE;}
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
if($this->jeGet("page","Login_screen") || $this->jeGet("page","Registrator")){
$q = "SELECT * FROM menus_items WHERE ((menu = '$menu' AND deep in (0,1)) OR id = 2) ORDER BY position";
}
elseif($this->jeGet("text","doplnky")){
$q = "SELECT * FROM menus_items WHERE ((menu = '$menu' AND deep in (0,1)) OR id in (43,44,45)) ORDER BY position";
}
elseif($this->jeGet("text","rozcestnik") || $this->jeGet("cat","0") || $this->jeGet("cat","1") || $this->jeGet("cat","2") || $this->jeGet("cat","3") || $this->jeGet("cat","4") || $this->jeGet("cat","5")  || $this->jeGet("text","zakazky")){
$q = "SELECT * FROM menus_items WHERE ((menu = '$menu' AND deep in (0,1)) OR id in (46,47,48,49,50,51)) ORDER BY position";
}
else {
$q = "SELECT * FROM menus_items WHERE menu = '$menu' AND deep in (0,1) ORDER BY position";
}
//echo  $q;

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