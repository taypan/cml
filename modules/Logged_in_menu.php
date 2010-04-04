<?php
if (!class_exists("Menu")){include("Menu.php");}
class Logged_in_menu extends Menu{


	function __construct($info,$arg){
		parent::__construct($info,$arg);
		//$this->fetch_data();

	}
	//function


	function get_content(){
		global $database,$tag;
		$menu = $this->arg['menu'];
		$q = "SELECT alt,link,level FROM menus_items WHERE menu = '$menu' ORDER BY position";
		$result = $database->query($q);
		$sum = "";
		for($i = 0;$i != mysql_numrows($result);$i++){
			$page = mysql_result($result,$i,'link');
			$alt = mysql_result($result,$i,'alt');
			$level = mysql_result($result,$i,'level');
			$sum = $sum.$tag->a($page,$alt);
		}
		return $sum;
	}


}


?>