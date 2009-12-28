<?php
class Tester extends Modul{

var $acl = array(	"test" => "guest",
					"test2" => "administrator",
					"nevim" => "administrator");

function test(){
return "test";
}

function test2(){
return "tester";
}



}?>