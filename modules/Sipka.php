<?php
class Sipka extends Modul{

	var $acl = array(	"get_default" => "guest");


	function get_content($n){
		if(isset($_GET['plain']) && !isset($_GET['shop'])){
			//---------------------------------------------------
			if(isset($_GET['text']) && ($_GET['text'] == "kdojsme")){return "420px";}
			if(isset($_GET['text']) && ($_GET['text'] == "nabytek")){return "470px";}
			if(isset($_GET['text']) && ($_GET['text'] == "sub_doplnky")){return "520px";}
			if(isset($_GET['text']) && ($_GET['text'] == "real_zakazky")){return "530px";}
			if(isset($_GET['text']) && ($_GET['text'] == "doplnky_plain")){return "520px";}
			if(isset($_GET['text']) && ($_GET['text'] == "kontakty")){return "620px";}
			//---------------------------------------------------
		} else{
			//---------------------------------------------------
			if(isset($_GET['page']) && ($_GET['page'] == "Zbozi")){
				//---------------------------------------------------
				if(isset($_GET['cat'])){
					if($_GET['cat'] == 0){return "560px";}
					elseif($_GET['cat'] == 1){return "610px";}
					elseif($_GET['cat'] == 2){return "658px";}
					elseif($_GET['cat'] == 3){return "720px";}
					elseif($_GET['cat'] == 4){return "780px";}
					elseif($_GET['cat'] == 6){return "600px";}
					elseif($_GET['cat'] == 7){return "650px";}
					elseif($_GET['cat'] == 8){return "695px";}
					elseif($_GET['cat'] == 9){return "520px";}
				} else {return "460px";}
			}

			//---------------------------------------------------
			if(isset($_GET['text']) && ($_GET['text'] == "rozcestnik")){return "500px";}
			if(isset($_GET['text']) && ($_GET['text'] == "zakazky")){return "870px";}
			if(isset($_GET['text']) && ($_GET['text'] == "podminky")){return "610px";}
			if(isset($_GET['text']) && ($_GET['text'] == "doplnky")){return "550px";}
			if(isset($_GET['page']) && ($_GET['page'] == "Login_screen")){return "660px";}
			if(isset($_GET['page']) && ($_GET['page'] == "Registrator")){return "700px";}
			if(isset($_GET['text']) && ($_GET['text'] == "kontakty")){return "700px";}

			//---------------------------------------------------
		}
		return "420px";}

		/*function get_area($c){
		 return "sipka";
		 }*/

}?>
