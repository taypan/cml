<?php
class Kategorie extends Modul{

var $acl = array(	"test" => "guest",
					"get_default" => "guest",
					"nevim" => "administrator");

function get_default($n){
$ids = $this->fetch_ids(1);
$items = $this->fetch_items($ids);
return "OK";
}

function fetch_items($ids){
global $database;
$q = "SELECT id FROM items WHERE cat IN (".$ids.") ORDER BY id ASC";
$result = $database->query($q);
//echo mysql_num_rows($result);
//var_dump($result);
return;
}

function fetch_ids($id){
global $database;
$cats = array();
$q = "SELECT lft,rgt FROM categories WHERE id = $id";
$obj = mysql_fetch_object($database->query($q));
//echo 'SELECT id FROM categories WHERE lft BETWEEN '.$obj->lft.' AND '.$obj->rgt.' ORDER BY lft ASC';
$result = $database->query('SELECT id FROM categories WHERE lft BETWEEN '.$obj->lft.' AND '.$obj->rgt.' ORDER BY lft ASC');
while($cat = mysql_fetch_object($result)){
//echo $cat->id."X";
$cats[] = $cat->id;
}
//var_dump($cats);
return implode(",",$cats);
}



}

?>
