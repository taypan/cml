<?php
class Tester extends Modul{

var $acl = array(	"test" => "guest",
					"get_default" => "guest",
					"test2" => "administrator",
					"nevim" => "administrator");

function get_default($n){

//$sum = $this->ack($m,$n);
return "OK";
}
function test(){
return "test";
}

function test2(){
return "tester";
}

function ack($m,$n){
     if($m == 0){return n+1;}
     elseif ($m > 0 && $n == 0){ 
	 return $this->ack($m-1, 1);
		  }
     else{
         return $this->ack(m-1, $this->ack($m, $n-1));
		 }
}



}?>