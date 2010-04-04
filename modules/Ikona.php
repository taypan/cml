<?php
class Ikona extends Modul{

	var $acl = array(	"get_default" => "guest");


	function get_content($n){
		if(isset($_GET['plain']) && !isset($_GET['shop'])){
			return "602";
		} else {return "485";}
		return "610";
	}



}?>
