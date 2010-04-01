<?php
class Sipka_ie extends Modul{

var $acl = array(	"get_default" => "guest");


function get_content($n){
if(isset($_GET['plain']) && !isset($_GET['shop'])){
//---------------------------------------------------
if(isset($_GET['text']) && ($_GET['text'] == "kdojsme")){return "420px";}
if(isset($_GET['text']) && ($_GET['text'] == "nabytek")){return "460px";}
if(isset($_GET['text']) && ($_GET['text'] == "doplnky_plain")){return "520px";}
if(isset($_GET['text']) && ($_GET['text'] == "kontakty")){return "610px";}
//---------------------------------------------------
} else{
//---------------------------------------------------
if(isset($_GET['page']) && ($_GET['page'] == "Zbozi")){
		//---------------------------------------------------
		if(isset($_GET['cat'])){
			if($_GET['cat'] == 0){return "560px";}
			elseif($_GET['cat'] == 1){return "620px";}
			elseif($_GET['cat'] == 2){return "670px";}
			elseif($_GET['cat'] == 3){return "740px";}
			elseif($_GET['cat'] == 4){return "810px";}
			elseif($_GET['cat'] == 6){return "600px";}
			elseif($_GET['cat'] == 7){return "650px";}
			elseif($_GET['cat'] == 8){return "710px";}
			elseif($_GET['cat'] == 9){return "870px";}
		} else {return "460px";}
		}
		
		//---------------------------------------------------
if(isset($_GET['text']) && ($_GET['text'] == "rozcestnik")){return "500px";}
if(isset($_GET['text']) && ($_GET['text'] == "zakazky")){return "870px";}
if(isset($_GET['text']) && ($_GET['text'] == "podminky")){return "610px";}
if(isset($_GET['text']) && ($_GET['text'] == "doplnky")){return "550px";}
if(isset($_GET['page']) && ($_GET['page'] == "Login_screen")){return "665px";}
if(isset($_GET['page']) && ($_GET['page'] == "Registrator")){return "705px";}
if(isset($_GET['text']) && ($_GET['text'] == "kontakty")){return "710px";}
//---------------------------------------------------
}
return "420px";}

/*function get_area($c){
return "sipka";
}*/

}?>