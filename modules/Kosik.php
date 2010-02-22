<?php
class Kosik extends Modul{
//var $items = array();

var $acl = array(	"remove" => "guest",
					"get_default" => "guest"
					);


/*function get_content($n){
//global $model;
//list_detail($this->$items)
//$_SESSION['items'] = array(1 => "Polozka 1",2 => "Polozka 2",3 => "Polozka 3");

if(isset($this->params_g['action'])){
switch ($this->params_g['action']){
case 'remove':
return $this->remove();
default:
return $this->get_default();
} 
} else {return $this->get_default();}
}*/

function get_title(){
return "Košík";
}


function remove(){
$code = $this->params_g['code'];
//if(isset($_SESSION['items'])){echo "OK";}
//echo $_SESSION['items'][1][1];
unset($_SESSION['items'][array_search($code,$_SESSION['items_codes'])]);
unset($_SESSION['items_codes'][array_search($code,$_SESSION['items_codes'])]);
return $this->get_default();
}



function get_default(){
//Debug::dump($_SESSION['items_codes']);
global $database;
if(isset($_SESSION['items'])){
$sum = "Polozky v kosiku:";
//$counter = 0;
foreach($_SESSION['items'] as $key => $value)
{
$q = "SELECT nazev FROM items WHERE id='$value'";
$result = $database->query($q);
$nazev = mysql_result($result,0,'nazev');
$sum = $sum ."<br>". $nazev." <a href=index.php?page=Kosik&action=remove&code=".$_SESSION['items_codes'][$key].">Odstranit</a>";
}
return $sum;
}
else {return "Nebyly objednány žádné položky";}

}

}



?>