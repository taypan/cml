<?php
class Kosik_info extends Modul{

var $acl = array(	"get_default" => "guest");


function get_content($n){
global $database;
$cena = 0;
$count = 0;
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

$s = "<a href=\"index.php?page=Objednat\">V košíku máte $count $items za $cena Kč</a>";
return $s;
}

function isitem($id){
global $database;
$q = "SELECT id FROM items WHERE id = '$id'";
$result = $database->query($q);
if (mysql_num_rows($result) <= 0) {return 0;}
else {return 1;}
}


}?>