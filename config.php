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

 elseif ($_SERVER['HTTP_HOST'] == "omnique.ic.cz"){
define("DB_SERVER", "mysql.ic.cz");
define("DB_USER", "ic_omnique");
define("DB_PASS", "jirka");
define("DB_NAME", "ic_omnique");
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
