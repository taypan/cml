<?php
class Ikona extends Modul{

	var $acl = array(	"get_default" => "guest");


	function get_content($n){
		if(isset($_GET['plain']) && !isset($_GET['shop'])){
			if((isset($_GET['text']) && $_GET['text']=="nabytek") || (isset($_GET['text']) && $_GET['text']=="sub_doplnky"))
			{
				return "645";
			} else {
				return "602";
			}
		} else {return "485";}
		return "610";
	}



}?>
