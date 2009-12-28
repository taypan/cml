<?php
class Kosik_panel extends Modul{
//var $items = array();




function get_content($n){
global $database;
//list_detail($this->$items)
//$_SESSION['items'] = array(1 => "Polozka 1",2 => "Polozka 2",3 => "Polozka 3");
//$_SESSION['items_codes'] = array(1 => "dfgderg546", 2 => "sd24f3s",3=>"54sd3f4f");
//if($_SESSION['items'] != NULL){echo $_SESSION['items'];}else{ echo "ne";}
//Debug::dump($_SESSION['items']);
if(isset($_SESSION['items']) && sizeof($_SESSION['items']) != 0){
//echo "OK";
$sum = "Polozky v kosiku:";
$counter = 0;
foreach($_SESSION['items'] as $key => $value)
{
$counter++;
if($this->isitem($value)){
$q = "SELECT nazev FROM items WHERE id='$value'";
$result = $database->query($q);
$nazev = mysql_result($result,0,'nazev');
if($counter <= KOSIK_MAX_ITEMS_SHOWN){$sum = $sum ."<br>". $nazev;} elseif ($counter == sizeof($_SESSION['items'])) {$sum = $sum."<br>"."<a href=\"index.php?page=Kosik\">Více...</a>";} 
}
}
$sum = $sum . "<form action=\"index.php?page=Objednat\" method=\"get\">
<input type=\"hidden\" name=\"page\" value=\"Objednat\">
<input type=\"submit\" value=\"Dokončit objednávku\" />
</form>";

return $sum;
}
/*elseif (sizeof($_SESSION['items']) == 0)
{
echo "mazu";
$_SESSION['items'] = array();
$_SESSION['items_codes'] = array();
return "Nebyly objednány žádné položky";
}*/

else {
return "Nebyly objednány žádné položky";}
}

function get_title(){
return "Košík";
}

function isitem($id){
global $database;
$q = "SELECT id FROM items WHERE id = '$id'";
$result = $database->query($q);
if (mysql_num_rows($result) <= 0) {return 0;}
else {return 1;}
}

}



?>