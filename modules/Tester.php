<?php
class Tester extends Modul{

var $acl = array(	"test" => "guest",
					"get_default" => "guest",
					"test2" => "administrator",
					"nevim" => "administrator");

function get_default($n){

//$sum = $this->ack($m,$n);
$_SESSION['items'] = array(72,71);


return "OK";
}


}?>