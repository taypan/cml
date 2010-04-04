<?php
class Admin_prehled extends Modul{

	function get_content($n){
		global $model,$database;
		if($model->user->isAllowed('admin_prehled','change')){
			$q = "SELECT * FROM objednavky ORDER BY (status='potvrzeno') DESC, status, id";
			$resObjednavky = $database->query($q);
			$sum = "<table width=\"600\" border=\"1\">
  <tr>
    <th scope=\"col\">ID</th>
    <th scope=\"col\">Položky</th>
    <th scope=\"col\">Jméno</th>
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
					$id= mysql_result($resPolozky,$i,'id_item');
					$name = $this->fetchName($id);
					$polozky = $polozky ."<a href=\"index.php?page=Detail&id=$id\">".$name."</a></br> ";
				}
				$obj = mysql_fetch_object($resObjednatel);
				$sum = $sum . "<tr>
    <td>".$row['id']."</td>
    <td>$polozky</td>
    <td>".$obj->jmeno." ".$obj->prijmeni."</td>
    <td>Ulice: ".$obj->ulice."</br> Mesto: ".$obj->mesto."</br> PSC: ".$obj->psc."</br> Tel:".$obj->tel_num."</br>Email: ".$obj->email."</td>
    <td>".$row['status']."</td>
  </tr>";
			}


			$sum = $sum . "</table>";
			return $sum;
		} else {return $this->access_forbidden();}

	}
	function fetchName($id){
		global $database;
		$q = "SELECT nazev FROM items WHERE id = $id";
		$obj = mysql_fetch_object($database->query($q));
		return $obj->nazev;
	}
	function get_title($n){
		return "Přehled objednávek";
	}


}?>