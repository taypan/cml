<?php
class Funkce
{

function parse_arg($string){   //TODO - dopsat kontrolu validity stringu
if($string != ""){

$arg = array();
$string = explode(",",$string,2);
foreach ($string as $key => $value){
$parts = explode("=",$value,2);
$arg = $arg + array($parts[0] => $parts[1]);
}
return $arg;}
else {return $string;}
}

function load_file($nazev)
{
$file = FOpen ($nazev, "r"); // otevře soubor data.txt pro čtení
return FRead ($file, FileSize ($nazev)); // načte do proměnné $data obsah souboru data.txt
FClose ($file); // zavře soubor data.txt, který jsme předtím otevřeli
}

function  insert_content($string,$separator,$content)
{

$field = explode($separator,$string);
reset($field);
$count = count($field);
$suma = "";
foreach ($field as $index => $value)
{
$count--;
if($count > 0){$suma = $suma.$value.$content;} else {$suma = $suma.$value;}
}
return $suma;
}

function msg($text){
if(isset($_SESSION[MSG])){
$_SESSION[MSG] = $_SESSION[MSG] ."</br>".$text;
} else {
$_SESSION[MSG] = $text;
}
return;
}


function insert_panels ($scheme,$source)
{
foreach($scheme as $index => $value){
//echo "X-".$index."-".$value."-X";
$source = $this->insert_content($source,$index,$value);
}
return $source;
}

}//--------------------

?>