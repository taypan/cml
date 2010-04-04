<?php
class Tag{

	function a($page,$alt,$target = ""){
		if($target != ""){
			return "\n<a href=\"$page\" target=\"$target\">$alt</a>";
		}
		else {
			return "\n<a href=\"$page\">$alt</a>";
		}

	}
	function img($source,$alt = ""){
		return "<img src=\"$source\" alt=\"$alt\">";
	}






}?>