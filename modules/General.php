<?php
class General extends Modul{
var $name;  //název modulu
var $info;
var $inside;
var $objekt;



function __construct($info,$arg)	{
global $model;
//echo $this->info['area'];
parent::__construct($info,$arg);
if(isset($_GET['page']) && $this->is_enabled($_GET['page']))
{$this->inside = $_GET['page'];}
else {$this->inside = DEFAULT_PAGE;}

$info = $this->info;
$info['modul'] = $this->inside;
$this->objekt = new $this->inside($info,$this->arg);
$this->acl = $this->objekt->acl;
//$this->get_panels();
						}



function is_enabled($modul)	{
global $database;
$q = "SELECT * FROM settings WHERE atribut = 'general_enabled_panels'";
$result = $database->query($q);
$enabled = explode(',',mysql_result($result,0,'value'));
if(in_array($modul,$enabled)){return TRUE;}
else {return FALSE;}
							}
							
							
function panel_count(){ //vrací pocet panelu;
return $this->objekt->panel_count();
}

function panel_inside_count(){ //vrací pocet panelu;
return  $this->objekt->panel_count();
}

function get_content($i){
return $this->objekt->get_content($i);
}

function get_title($i){
return $this->objekt->get_title($i);

}

function get_area($n){
//echo $n;
return $this->objekt->get_area($n);

}

function get_inside_content($i){
global $model;
return $this->objekt->get_content($i);

}
function get_inside_title($i){
return $this->objekt->get_title($i);
}

/*
function get_panels(){
global $model;


for($c = 0; $this->panel_inside_count() > $c;$c++)
{
//echo " X:" . $c;
if($this->get_area($c)){$area = $this->get_area($c);} else {$area = $this->info['area'];}
$model->panel_into_area($area,$this->get_inside_content($c),$this->get_inside_title($c));
}



} */

}
?>