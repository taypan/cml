<?php
class Tester extends Modul{

var $acl = array(	"test" => "guest",
					"get_default" => "administrator",
					"test2" => "administrator",
					"nevim" => "administrator");

function get_default($n){
$m = 1;
$n = 1;
//$sum = $this->ack($m,$n);
return $sum;
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