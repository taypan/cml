<?php
class Zbozi2 extends Modul{
//var $items = array();




function get_content($n){
if(isset($this->params_g['limit'])){
return $this->draw_counter("index.php?page=Zbozi2&").$this->get_items(0,$this->params_g['limit']);
} else {return $this->draw_counter("index.php?page=Zbozi2&").$this->get_items(0,0);}
}

function get_title(){
return "Zboží";
}

function get_items($c = 0,$from = 0)
{
global $database;
$sum = "";
$limit = ITEMS_ON_PAGE;

if(isset($_GET['cat'])) {
$cat = $_GET['cat'];
if(isset($_GET['subcat'])) {
$subcat = $_GET['subcat'];
$q = "SELECT * FROM items WHERE cat='$cat' AND subcat='$subcat' ORDER BY id LIMIT $from,$limit";
}
else {
$q = "SELECT * FROM items WHERE cat='$cat' ORDER BY id LIMIT $from,$limit";
}
} else {
$q = "SELECT * FROM items ORDER BY id LIMIT $from,$limit";
}


//echo $q;
$result = $database->query($q);
$d = mysql_num_rows($result);
for($i = 0;$i != $d;$i++)
{

if($c == 0){$sum = $sum. $this->list_items($i,$result);} else {

$sum = $sum.list_table($i,$result);
}
}
return $sum;
}

function list_items($i,$result)
{

$id = mysql_result($result,$i,"id");
$nazev = mysql_result($result,$i,"nazev");
$popis = mysql_result($result,$i,"popis");
$cena = mysql_result($result,$i,"cena");
//$img = mysql_result($result,$i,"dostupnost");
$dostupnost = mysql_result($result,$i,"dostupnost");

return $this->item($id,$nazev,$popis,$cena,$dostupnost);

}

function item($id,$nazev,$popis,$cena,$dostupnost){
if($dostupnost == 1){ $dostupnost = "Skladem";} else {$dostupnost = "Na cestě";}
if(is_file(IMG_DIR_BIG.$id.".jpg")){
$img = IMG_DIR_BIG.$id.".jpg";
$img_sml = IMG_DIR_SMALL.$id.".jpg";
} else {
$img = IMG_DIR.NO_IMG;
$img_sml = IMG_DIR.NO_IMG;
}
//echo IMG_DIR_BIG.$id.".jpg";
return "
	<div class=\"zboziCont\">
	<h2>$nazev</h2>
    <div class=\"popis\">cena $cena Kč</div>
    <div class=\"add\"><a href=\"index.php?page=Feeder&id=$id\">Přidat do košíku</a></div>
    </div>";


/*return "<table width=\"259\" border=\"1\">  <tr>    <th colspan=\"3\" scope=\"col\">$nazev - $id</th>
  </tr>
  <tr>
    <td width=\"57\">Popis:</td>
    <td width=\"73\" rowspan=\"2\">$popis</td>
    <td width=\"107\" rowspan=\"3\"><a href=\"$img\"><img src=\"$img_sml\"></a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
 
  <tr>
    <td>Cena:</td>
    <td>$cena Kč</td>
  </tr>
   <tr>
    <td height=\"28\" colspan=\"2\"></td>
    <td>
	
	</td>
  </tr> 
</table>
</br>";*/



}

function  draw_counter($page){
global $database;
if(!isset($_GET['limit'])){$_GET['limit'] = 0;}
/*
if(isset($_GET['cat'])) {
$cat = $_GET['cat'];
$q = "SELECT id FROM items WHERE cat='$cat'"; 
} else {
$q = "SELECT id FROM items"; 
}*/


if(isset($_GET['cat'])) {
$cat = $_GET['cat'];
if(isset($_GET['subcat'])) {
$subcat = $_GET['subcat'];
$q = "SELECT id FROM items WHERE cat='$cat' AND subcat='$subcat'";
$cats = "&cat=$cat&subcat=$subcat";
}
else {
$q = "SELECT id FROM items WHERE cat='$cat'";
$cats = "&cat=$cat";
}
} else {
$q = "SELECT id FROM items";
}

//echo $q;
$result = $database->query($q);
$sum = "<div class=\"counter\">";
$c = 1;
$count = mysql_num_rows($result);
for($i = 0;$i < $count;$i += ITEMS_ON_PAGE)
															{
if($i == 0){
if(isset($_GET['limit']) && $_GET['limit'] >= ITEMS_ON_PAGE)
{$sum = $sum. "<a href=\"".$page."limit=".($_GET['limit'] - ITEMS_ON_PAGE).$cats."\">Předchozí</a> ";}
}

if(isset($_GET['limit']) && $_GET['limit'] == (($c -1)*ITEMS_ON_PAGE))
{$sum = $sum. $c. " ";}
else {$sum = $sum. "<a href=\"".$page."limit=". $i.$cats. "\">".$c."</a> ";}
if($c  == ceil($count / ITEMS_ON_PAGE) && isset($_GET['limit']) && !(($_GET['limit']+ITEMS_ON_PAGE) >= $count ))
{
$sum = $sum. "<a href=\"".$page."limit=".($_GET['limit'] + ITEMS_ON_PAGE).$cats. "\">Následující</a> ";
}
elseif (!(isset($_GET['limit'])) && ($c  == ceil($count / ITEMS_ON_PAGE))){$sum = $sum. "<a href=\"".$page."limit=".ITEMS_ON_PAGE.$cats. "\">Následující</a> ";}
$c++;
															}
															
$sum = $sum . "</div></br>";
return $sum;
}

}

?>