<?php
class Modul {


var $name;  //název modulu
var $info;
var $arg;
var $params_p = array();
var $params_g = array();
var $action;
var $sum;
var $acl = array();

function get_content($n){                       // přepíná na akce podle parametru action
$validita = $this->isValidAction($_GET['action']);
//echo $validita;
if ($validita=="valid"){									// TODO - kontrola jesli ma uzivatel vubec prava vlozit modul do generalu
return $this->$_GET['action']();
}
elseif($validita=="default"){
return $this->get_default();
}
elseif($validita=="no_resource" || $validita== "unknown_action"){
return $this->no_action();
}
else {return $this->access_forbidden();}

}

function __construct($info,$arg){
global $funkce,$controler;
$this->info = $info;
$this->arg = $funkce->parse_arg($arg);
foreach($_GET as $key => $value){
$this->params_g[$key] = $value;
}
foreach($_POST as $key => $value){
$this->params_p[$key] = $value;
}

}

function no_action(){
return "Požadovaná akce neexistuje!";
}
function sum($text){
$this->sum = $this->sum."\n".$text;
}

function echo_msg($text = MSG){
if(isset($_SESSION[$text])){
$msg = $_SESSION[$text];
unset($_SESSION[$text]);
return $msg ;} else  {return;

}
}

function has_own_panels(){
return TRUE;
}

function get_area($n){
return FALSE;
}

function panel_count(){ //varací pocet panelu;
return 1;
}

function get_default(){
return "Obsah nenastaven";
}

function get_title(){
//Debug::dump($this->arg);
return $this->info['modul'];
}

function access_forbidden(){
return "Access Denied";

}

function isValidAction($action){
global $model,$controler;
//echo "tady";
try{
if(isset($action) && $model->user->isAllowed($this->info['id']."_action_".$action,"execute") && method_exists($this->info['modul'],$action)){
return "valid";
}
elseif(!isset($action)){
return "default";
}  elseif(!$model->user->isAllowed($this->info['id']."_action_".$action,"execute")){
return "forbidden";
}elseif(!method_exists($this->info['modul'],$action)){
return "unknown_action";
}
else {return "else";}
}
catch (InvalidStateException $e){
//echo $e->getMessage()."</br>";
return "no_resource";
}

}

}



?>