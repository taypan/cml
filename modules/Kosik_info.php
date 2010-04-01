<?php
class Kosik_info extends Modul{

var $acl = array(	"get_default" => "guest");


function get_content($n){
global $database;
$cena = 0;
$count = 0;
if(!isset($_SESSION['items'])){$_SESSION['items'] = array();}
foreach($_SESSION['items'] as $key => $value)
{
if($this->isitem($value)){
$q = "SELECT cena FROM items WHERE id='$value'";
$result = $database->query($q);
$cena += mysql_result($result,0,'cena');
$count++;
}
}

if($count == 0){$items = "položek";}
elseif($count == 1){$items = "položku";}
elseif($count == 2 || $count == 3 || $count == 4){$items = "položky";}
else{$items = "položek";}
if(isset($_SESSION['shop']) && ((isset($_GET['page']) && $_GET['page'] == "Zbozi") || (isset($_GET['page']) && $_GET['page'] == "Feeder")|| (isset($_GET['page']) && $_GET['page'] == "Detail") || (isset($_GET['text']) && $_GET['text'] == "rozcestnik")|| (isset($_GET['text']) && $_GET['text'] == "doplnky"))){
$s = "<div class=\"kosikTXT\" id=\"kosikU\"><a href=\"index.php?page=Objednat\">V košíku máte $count $items za $cena Kč</a></div>";
return $s;}
else {return;}
}

function isitem($id){
global $database;
$q = "SELECT id FROM items WHERE id = '$id'";
$result = $database->query($q);
if (mysql_num_rows($result) <= 0) {return 0;}
else {return 1;}
}


}?>