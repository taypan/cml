<?php
class Detail extends Modul{

	var $acl = array(	"test" => "guest",
					"get_default" => "guest",
					"test2" => "administrator",
					"nevim" => "administrator");

	function get_default(){
		if(isset($_GET['id']) && $this->isitem(intval($_GET['id']))){
			$data = $this->fetch_data($_GET['id']);
			$id = $_GET['id'];
			$data['img'] = $this->draw_img($id);
			return $this->show_item($data);

		} else {return MSG_BEGIN."Zadaná položka neexistuje!".MSG_END;}


	}

	function isitem($id){
		global $database;
		$q = "SELECT id FROM items WHERE id = '$id'";
		$result = $database->query($q);
		if (mysql_num_rows($result) <= 0) {return FALSE;}
		else {return TRUE;}
	}

	function str_replace_assoc($array,$string){
		$from_array = array();
		$to_array = array();

		foreach ($array as $k => $v){
			$from_array[] = $k;
			$to_array[] = $v;
		}

		return str_replace($from_array,$to_array,$string);
	}

	function array2comm($data,$start,$stop){
		$new = array();
		foreach($data as $key => $value){
			$new[$start.$key.$stop] = $value;
		}
		return $new;
	}

	function show_item($data){
		$temp_detail = file_get_contents(TEMPLATES_DIRECTORY.CURRENT_TEMPLATE."/".DETAIL_TEMPLATE);
		$data = $this->array2comm($data,"<!--detail-"," -->");
		$content = $this->str_replace_assoc($data,$temp_detail);
		return $content;
		/*return '<div id="obsahNahled">
		 <img src="'.$data['img'].'" width="310px" id="imgMain" />
		 <div id="productInfo">
		 <h2>'.$data['nazev'].'</h2>
		 </div>
		 <div class="zboziContPrice">
		 <div class="popis">s DPH<strong> '.$data['cena'].'</strong> Kč</div>
		 <div class="add"><a href="index.php?page=Feeder&id='.$data['id'].'">Přidat do košíku</a></div>
		 </div>
		 <h3>Rozměry</h3>
		 <p>'.$data['rozmery'].'</p>
		 <h3>Popis</h3>
		 <p>'.$data['popis'].'</p>
		 </div>';*/
	}


	function draw_img($id){
		$file = IMG_BIG_DIR . $id.".jpg";
		//echo $file;
		if(file_exists($file)){
			return $file;
		} else {
			return IMG_DIR . NO_IMG;
		}

	}

	function fetch_data($id){
		global $database;
		$q = "SELECT * FROM items WHERE id = '$id'";
		$result = $database->query($q);
		return mysql_fetch_assoc($result);
	}

	function get_title(){
		return "Detail";
	}


}
?>