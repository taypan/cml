<?php
class Image_manager extends Modul{

	var $acl = array(	"get_default" => "guest");

	function get_default(){
		$result = $this->dirList(IMG_DIR_BIG);
		sort($result);
		//Debug::enable();
		//Debug::dump($result);
		$founded = array();
		$id = 65;
		$idun = $id."_";
		$len = strlen($idun);
		foreach($result as $key => $value){
		if(substr($value,0,$len) == $idun){	
		$founded[] = $value;	
		}
		}
		return; //var_dump($founded);
		
	}
	
	function dirList ($directory)
	{

		// create an array to hold directory list
		$results = array();

		// create a handler for the directory
		$handler = opendir($directory);

		// keep going until all files in directory have been read
		while ($file = readdir($handler)) {

			// if $file isn't this directory or its parent,
			// add it to the results array
			if ($file != '.' && $file != '..')
			$results[] = $file;
		}

		// tidy up: close the handler
		closedir($handler);

		// done!
		return $results;

	}
}
?>