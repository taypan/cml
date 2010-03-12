<?php
class Confirm extends Modul{

function get_title(){
return "Ověření objednávky";
}

function get_content($n){
global $model;
if($this->checkCode()){
return MSG_BEGIN."Vaše objednávka byla potvrzena a nyní čeká na zpracování. Budeme vás průběžně informovat e-mailem.".MSG_END;
} else {return "Neplatný kód!";}

}
function checkCode(){
global $database;
if (isset($this->params_g['code']) && isset($this->params_g['id'])){
$code = $this->params_g['code'];
$id = $this->params_g['id'];

$ver_code = substr(sha256(sha256($id.RAND1).md5(RAND2)),25,32);
$q = "UPDATE objednavky SET status='potvrzeno' WHERE id='$id'";
if($ver_code == $code && $database->query($q)) {
return TRUE;
}
else {return FALSE;}
} else {return FALSE;}

}

}
?>