<?php
class Admin_prehled extends Modul{

function get_content($n){
global $model,$database;
if($model->user->isAllowed('admin_prehled','change')){
$q = "SELECT * FROM objednavky ORDER BY (status='potvrzeno') DESC, status, id";
$resObjednavky = $database->query($q);
$sum = "<table width=\"0\" border=\"1\">
  <tr>
    <th scope=\"col\">ID</th>
    <th scope=\"col\">Položky</th>
    <th scope=\"col\">Jmeno</th>
    <th scope=\"col\">Objednací údaje</th>
    <th scope=\"col\">Status</th>
  </tr>";
while ($row = mysql_fetch_array($resObjednavky)) {
$p = "SELECT * FROM objednatele WHERE id='".$row['objednatel']."'";
$resObjednatel = $database->query($p);
$w = "SELECT id_item FROM objednavky_polozky WHERE id_obj='".$row['id']."'";
//echo $w;
$resPolozky = $database->query($w);
$polozky = "";
for($i = 0;$i < mysql_num_rows($resPolozky);$i++)
{
$polozky = $polozky .mysql_result($resPolozky,$i,'id_item').", ";
}
$sum = $sum . "<tr>
    <td>".$row['id']."</td>
    <td>$polozky</td>
    <td>".mysql_result($resObjednatel,0,'jmeno')." ".mysql_result($resObjednatel,0,'prijmeni')."</td>
    <td>".mysql_result($resObjednatel,0,'ulice')." ".mysql_result($resObjednatel,0,'mesto')." ".mysql_result($resObjednatel,0,'psc')."</br> Tel:".mysql_result($resObjednatel,0,'tel_num')."</td>
    <td>".$row['status']."</td>
  </tr>";
} 


$sum = $sum . "</table>";
return $sum;
} else {return $this->access_forbidden();}

}

function get_title($n){
return "Přehled objednávek";
}


}?>