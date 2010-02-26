<?php
class Tester extends Modul{

var $acl = array(	"test" => "guest",
					"get_default" => "guest",
					"test2" => "administrator",
					"nevim" => "administrator");

function get_default($n){

//$sum = $this->ack($m,$n);
global $database;
$q = "DELETE FROM texty WHERE jmeno = 'doplnky'";
$p = "insert into texty values ('','doplnky','
		<div id=\"obsahSekce\">
		<div class=\"sekceCont\"> <a href=\"index.php?page=Zbozi&limit=0&cat=6\">
       <h2>Hračky</h2>
       </a>
     </div>
     	<div class=\"sekceCont\"> <a href=\"index.php?page=Zbozi&limit=0&cat=7\">
       <h2>Lampy a lampičky</h2>
       </a>
     </div>
     	<div class=\"sekceCont\"> <a href=\"index.php?page=Zbozi&limit=0&cat=8\">
       <h2>Doplňky</h2>
       </a>
       </div>
     </div>','Doplňky a hračky')";

$database->query($q);
$database->query($p);
return "OK";
}


}?>