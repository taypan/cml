<?php
class Feeder extends Modul{

var $acl = array(	"get_default" => "guest");

function get_default(){
//$_SESSION['items'] = array();
//$_SESSION['items_codes'] = array();
if(isset($this->params_g['id'])){
$id = $this->params_g['id'];
if(isset($_SESSION['items'])){
//if(!isset($_SESSION['items_codes'])){$_SESSION['items_codes'] = array();}
for($code = $this->genRanStr(RAND_STRING_LENGHT);in_array($code, $_SESSION['items_codes']);$code = $this->genRanStr(RAND_STRING_LENGHT))
{}
array_push($_SESSION['items'],$id);
array_push($_SESSION['items_codes'],$code);
}
else {


$code = $this->genRanStr(RAND_STRING_LENGHT);
$_SESSION['items']=array($id);
$_SESSION['items_codes']=array($code);

}

return "Položka by přidána do košíku. Pokud si přejete dokončit objednávku pokračujte přes menu \"Košík\"";
//Debug::dump($_SESSION);
} else {return "Položka neexistuje!";}
}

function get_title(){
return "Detail";
}

function genRanStr($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $string = '';    


    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters))];
    }

    return $string;
}
}
?>