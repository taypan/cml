<?php
class Tester extends Modul{

var $acl = array(	"test" => "guest",
					"get_default" => "administrator",
					"test2" => "administrator",
					"nevim" => "administrator");

function test(){
return "test";
}

function test2(){
return "tester";
}



}?>