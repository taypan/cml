<?php

class Model{

	var $template; // cista sablona
	var $parsed; // vyparsovana sablona;
	var $complete;
	var $scheme_panels = array();
	var $areas = array();
	var $user;
	//var $panels_pure = array(); // ciste panely s tagem content
	var $panels = array(/*"<!--content-panel-header -->" => "OBSAH1",
	"<!--content-panel-left -->" => "OBSAH2",
	"<!--content-panel-right -->" => "OBSAH3",
	"<!--content-panel-footer -->" => "OBSAH4"*/); // vyplnene panely
	var $path_to_template;
	var $path_to_moduls;
	var $varchar;

	function isAllowed($resource)
	{
		$this->user->isAllowed($resource);
		return;
	}
	function add_area($key)
	{
		if(isset($this->areas[$key])){//echo "Opakovaná inicializace oblasti $key!";
		}
		else { $this->areas[$key] = new Area($key); }
	}

	function panel_into_area($area,$content,$title,$has_own_panels = TRUE)
	{
		if($has_own_panels){
			if (isset($this->areas[$area])){
				$this->areas[$area]->add_panel($content,$title);

			}
			else {
				$this->add_area($area);
				$this->areas[$area]->add_panel($content,$title);
			}
		}
	}
	/*
	 function add_panel_pure($key)
	 {
	 global $funkce;
	 $value = $funkce->load_file($this->path_to_template."panel-".$key.".html");
	 $key = "<!--panel-".$key." -->";
	 $this->panels_pure = $this->panels_pure + array($key => $value);
	 }*/

	/*
	 function add_panel($key,$content,$title = '')
	 {
	 global $funkce;
	 $c_key = "<!--content-panel-".$key." -->";
	 $p_key = "<!--panel-".$key." -->";
	 $t_key = "<!--panel-".$key."-title -->";
	 $pattern = $this->panels_pure[$p_key];
	 $panel = $funkce->insert_content($pattern,$c_key,$content);
	 $panel = $funkce->insert_content($panel,$t_key,$title);
	 if(isset($this->panels[$c_key])){
	 $this->panels[$c_key] = $this->panels[$c_key].$panel;
	 } else {$this->panels[$c_key] = $panel;}*/


}

class Area {
	var $seznam = array();
	var $pattern;
	var $key;

	function Area($key)	{
		global $funkce,$model;
		$this->key = $key;
		$this->pattern = $funkce->load_file($model->path_to_template."panel-".$this->key.".html");

	}
		
		

	function add_panel($content,$title = '')
	{

		global $funkce;
		$c_key = "<!--content-panel-".$this->key." -->";
		//$p_key = "<!--panel-".$this->key." -->";
		$t_key = "<!--panel-".$this->key."-title -->";



		$panel_content = $funkce->insert_content($funkce->insert_content($this->pattern,$c_key,$content),$t_key,$title);
		$this->seznam[] = $panel_content;
	}

	function giveme_sum()
	{
		$sum = "";
		foreach ($this->seznam as $index => $value)	{
			$sum = $sum.$value;
		}
		//echo $sum;
		return $sum;

	}


}
?>