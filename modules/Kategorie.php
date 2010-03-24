<?php
class Kategorie extends Modul{

var $acl = array(	"test" => "guest",
					"get_default" => "guest",
					"test2" => "administrator",
					"nevim" => "administrator");

function get_default($n){


return "OK";
}



}

?>