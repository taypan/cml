<?php
class Display extends Modul{


	function __construct($info,$arg){
		parent::__construct($info,$arg);
		//$this->fetch_data();

	}
	//function

	function get_content(){
		if(isset($_SESSION[$this->arg['value']])){
			echo $this->arg['value'];
			$sum = $_SESSION[$this->arg['value']];
			return $sum;
		}
		else {return "Empty";}
	}

	function get_title(){
		return 'Msg';
	}


}
?>