<?
/**
 * config.php
*/

 
if ($_SERVER['HTTP_HOST'] == "localhost"){
define("DB_SERVER", "localhost");
define("DB_USER", "jirka");
define("DB_PASS", "jirka");
define("DB_NAME", "cml");
}

 elseif ($_SERVER['HTTP_HOST'] == "cml"){
define("DB_SERVER", "localhost");
define("DB_USER", "jirka");
define("DB_PASS", "jirka");
define("DB_NAME", "cml");
}

else 
{

/*ostre udaje*/
define("DB_SERVER", "");
define("DB_USER", "");
define("DB_PASS", "");
define("DB_NAME", "");
}
?>
