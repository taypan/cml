<?php
class Menuator extends Modul{
	var $varianta;

	function get_title($n){
		if($n == 1){
			return "Menuator";}
			else {return "Přidávání položek do Menu";}
	}

	function panel_count(){
		return 2;
	}

	function get_area($n){
		if($n == 1){
			return "left";}
			else {return FALSE;}
	}

	function get_menu(){
		//Debug::dump($this->info);
		$sum = "<a href=\"index.php?page=".$this->info['modul']."&action=add_view\">Přidat</a>";
		$sum = $sum . "</br><a href=\"index.php?page=".$this->info['modul']."&action=remove_view\">Odstranit</a>";
		return $sum;
	}


	function get_content($n){
		global $model;
		if($model->user->isAllowed('settings','change')){
			if($n == 1){
				return $this->get_menu();
			}
			else {

				if(isset($this->params_g['action'])){
					switch ($this->params_g['action']){
						case 'add_item':
							return $this->add_item();
						case 'add_view':
							return $this->get_add_view();
						case 'remove_view':
							return $this->get_remove_view();
						case 'remove':
							if(isset($this->params_g['id']) && isset($this->params_g['code'])){
								return $this->remove_item($this->params_g['id'],$this->params_g['code']).$this->get_remove_view();;
							} else return $this->get_add_view();
						default:
							return $this->get_add_view();
					}

				}else {return $this->get_add_view();}

			}
		} else {return $this->access_forbidden();}

	}

	function get_remove_view(){
		global $database;
		$q = "SELECT * FROM menus_items ORDER BY menu";
		$result = $database->query($q);
		$sum = "<table width=\"0\" border=\"1\">
  <tr>
    <th scope=\"col\">ID</th>
    <th scope=\"col\">Text</th>
    <th scope=\"col\">Link</th>
    <th scope=\"col\">Menu</th>
    <th scope=\"col\">Odstranit</th>
  </tr>";
		while ($row = mysql_fetch_array($result)) {
			$code = substr(sha256(sha256($row['id'].RAND3).md5(RAND4)),HASH_START,HASH_LENGHT);
			$rem = "index.php?page=".$this->info['modul']."&action=remove&id=".$row['id']."&code=".$code;
			$sum = $sum . "<tr>
    <td>".$row['id']."</td>
    <td>".$row['alt']."</td>
    <td>".$row['link']."</td>
    <td>".$row['menu']."</td>
    <td><a href=\"".$rem."\">Odstranit</a></td>
  </tr>";
		}
		$sum = $sum . "</table>";
		return $sum;
	}

	function remove_item($id,$code){
		global $database;
		if($this->check_code($code,$id)){
			$q = "DELETE FROM menus_items WHERE id = '$id' LIMIT 1";
			if($database->query($q)){
				return "Položka byla odstraněna.";
			} else {return "Položku se nepodařilo odtranit!";}

		}
		else {return "Tato položka neexistuje!";}
	}

	function check_code($code,$id){
		$ver_code = substr(sha256(sha256($id.RAND3).md5(RAND4)),HASH_START,HASH_LENGHT);
		if($ver_code == $code){
			return TRUE;
		}
		else {return FALSE;}
	}

	function add_item(){
		global $database,$funkce,$controler;
		$alt = $_POST['alt'];
		$link =$_POST['link'];
		$position = $_POST['position'];
		$level = $_POST['level'];
		$menu = $_POST['menu'];
		$deny_for = $_POST['deny_for'];
		$q = "INSERT INTO menus_items VALUES ('','$alt','$link','$position', '$level', '$menu','$deny_for')";
		if($database->query($q)){
			$id = mysql_insert_id();
			//$controler->acl->addResource("menus_item_".$id);
			//$controler->acl->allow($level, $key."_".$id, 'view');

			$funkce->msg("Položka byla úspěšně přidána"); } 
			else {$funkce->msg("Položku se nepodařilo přidat do menu");}
			return $this->get_add_view();
	}

	function get_add_view(){
		$this->sum("
<form id=\"add_item\" name=\"form1\" method=\"post\" action=\"index.php?page=".$this->info['modul']."&action=add_item\">
<table width=\"206\" height=\"157\" border=\"0\">
  <tr>
    <td width=\"56\">Text:</td>
    <td width=\"140\">
      <input type=\"text\" name=\"alt\" />
    </td>
  </tr>
  <tr>
    <td>Link:</td>
    <td><input type=\"text\" name=\"link\" /></td>
  </tr>
  <tr>
    <td>Pozice:</td>
    <td>
      
        <input type=\"text\" name=\"position\" size=\"3\" />
        
  
    </td>
  </tr>
  <tr>
    <td>Level:</td>
    <td><select name=\"level\">
	".$this->gen_option(LEVELS)."
      </select></td>
  </tr>
  <tr>
    <td>Zakazano pro level:</td>
    <td><select name=\"deny_for\">
	<option value=\"\">žádný</option>
	".$this->gen_option(LEVELS)."
      </select></td>
  </tr>
  <tr>
    <td>Menu:</td>
    <td>
      <select name=\"menu\">".
		$this->gen_option($this->get_menus())
		."</select>
    </td>
  </tr>
</table><input type=\"submit\" value=\"Přidat položku\" />
</form>
");
		return $this->echo_msg().$this->sum;
	}

	function get_menus(){
		global $database;
		$q = "SELECT menu FROM menus";
		$result = $database->query($q);
		$sum = "";
		for($i = 0; $i != mysql_num_rows($result); $i++){
			$sum = $sum . mysql_result($result,$i,"menu"). ",";
		}
		$sum = substr($sum, 0, (strlen($sum)-1)); // vrátí "olo"
		return $sum;
	}

	function gen_option($text){
		$pole = explode(",",$text);
		$options = "";
		foreach ($pole as $key => $value){
			$options = $options. "<option value=\"$value\">".ucfirst($value)."</option>";
		}

		return $options;
	}


}?>