<?php
class Style extends Modul{

	var $acl = array(	"get_default" => "guest");


	function get_content($n){
		return SITE.TEMPLATES_DIRECTORY.CURRENT_TEMPLATE;
	}

}?>