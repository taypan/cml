<?php
class Settings extends Modul{
var $varianta;


function get_content($n){
global $model;
if($model->user->isAllowed('settings','change')){
if(isset($this->params_g['action'])){
switch ($this->params_g['action']){
case 'set':
return $this->set();
case 'add':
return $this->add();
case 'remove_att':
return $this->remove_att();
default:
return $this->get_default();
} 

}else {return $this->get_default();}

} else {return $this->access_forbidden();}



}
function set(){
global $database;
foreach($this->params_p as $key => $value){
//$value = addslashes($value);
$q = "UPDATE settings SET value='$value' WHERE id = '$key'";
$database->query($q);
}
$_SESSION['msg'] = "Nastavení byla úspěšně uložena!";
return $this->get_default();
}


function get_default(){
global $database,$model,$tag,$funkce;
//if($model->user->isAllowed('panel_9','view')){ echo "OK";} else { echo "NO";} 
$q = "SELECT * FROM settings ORDER BY id";
$result = $database->query($q); 
$page = $this->info['modul'];

$this->sum("<form id=\"settings\" name=\"form1\" method=\"post\" action=\"index.php?page=$page&action=set\"><table width=\"0\" border=\"1\"><tr><th scope=\"col\">Atribut</th><th scope=\"col\">Value</th><th></th></tr>");
for($i = 0;$i != mysql_numrows($result);$i++){
$atribut = stripslashes(mysql_result($result,$i,"atribut"));
$value =  stripslashes(htmlspecialchars(mysql_result($result,$i,"value"), ENT_QUOTES));
$id = mysql_result($result,$i,"id");
$this->sum("<tr><td>$atribut</td><td><input type=\"text\" name=\"$id\" value = \"$value\"/></td><td>".$tag->a("index.php?page=$page&action=remove_att&id=$id",$tag->img(TEMPLATES_DIRECTORY.CURRENT_TEMPLATE."/images/drop.png","Odstranit"))."</td></tr>");
}
$this->sum("</table><input type=\"submit\" value=\"Uložit\" /></form>");

$this->sum("</br><form id=\"add_setting\" name=\"form2\" method=\"post\" action=\"index.php?page=$page&action=add\"><table width=\"0\" border=\"1\"><tr><th scope=\"col\">Atribut</th><th scope=\"col\">Value</th></tr>");
if(!isset($this->params_g['adds'])){$this->params_g['adds'] = 1;}
for($i = 0;$i != $this->params_g['adds'];$i++){
$this->sum("<tr><td><input type=\"text\" name=\"$i\" value = \"\"/></td><td><input type=\"text\" name=\"".$i."_v\" value = \"\"/></td></tr>");
}
$this->sum("</table>".$tag->a("index.php?page=$page&adds=".($this->params_g['adds']+1),"Přidat více..."));
$this->sum("<p><input type=\"submit\" value=\"Přidat\" /></form>");



if(isset($_SESSION['msg'])){
$this->sum = "\n".MSG_BEGIN.$_SESSION['msg'].MSG_END."\n".$this->sum;
unset($_SESSION['msg']);}
return $this->sum;
}

function add(){
global $database,$funkce;
for($i = 0;isset($_POST[$i]);$i++){
$att = mysql_real_escape_string($_POST[$i]);
$key = $i."_v";
$val = mysql_real_escape_string($_POST[$key]);
$g = "SELECT atribut FROM settings";
$used = $database->query($g);
$exist = 0;
for($k = 0; $k != mysql_num_rows($used);$k++)
{
if (mysql_result($used,$k,'atribut') ==  $att) {$exist = 1;}
}
if(!($exist) and $att != ""){$q = "INSERT INTO settings VALUES ('','$att','$val')";
if($database->query($q)){$funkce->msg("Atribut $att byl přidán");} 
else {$funkce->msg("Atribut $att se nepodařilo přidat");}}
else if($att == ""){$funkce->msg("Zadaný atribut \"$att\" je neplatný");}
else {$funkce->msg("Atribut '$att' již existuje");} 
}
//foreach($this->params_p as $key => $value){
//$database->query($q);
//}

return $this->get_default();
}

function remove_att(){
global $database,$funkce;
$g = "SELECT id FROM settings";
$used = $database->query($g);
$exist = 0;
for($k = 0; $k != mysql_num_rows($used);$k++)
{
if (mysql_result($used,$k,'id') ==  $_GET['id']) {$exist = 1;}
}

if($exist){$q = "DELETE FROM settings WHERE id = ".$_GET['id']." LIMIT 1";
//echo $q;
if($database->query($q)){$funkce->msg("Atribut byl odstraněn");} else {$funkce->msg("Atribut se nepodařilo odstranit");}
} else {$funkce->msg("Atribut neexistuje");}



return $this->get_default();
}

}?>