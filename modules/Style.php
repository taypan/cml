<?php
class Style extends Modul{

var $acl = array(	"get_default" => "guest");


function get_default($n){
return TEMPLATES_DIRECTORY.CURRENT_TEMPLATE;
}

}?>