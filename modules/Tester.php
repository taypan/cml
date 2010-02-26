<?php
class Tester extends Modul{

var $acl = array(	"test" => "guest",
					"get_default" => "guest",
					"test2" => "administrator",
					"nevim" => "administrator");

function get_default($n){

//$sum = $this->ack($m,$n);
global $database;
$q = "DELETE FROM texty WHERE jmeno = 'rozcestnik'";
$p = "insert into texty values ('','rozcestnik','<div id=\"obsahSekce\"><div class=\"sekceCont\"> <a href=\"#\">
       <h2>Čajové stolky a sety</h2>
       </a>
       <div class=\"linkCont\"> <a href=\"#\">jidelni</a> <a href=\"#\">konferencni</a> <a href=\"#\">odkladaci</a> </div>
     </div>
     <div class=\"sekceCont\"> <a href=\"#\">
       <h2>Ložnice</h2>
       </a>
       <div class=\"linkCont\"> <a href=\"#\">jidelni</a> <a href=\"#\">konferencni</a> <a href=\"#\">odkladaci</a> </div>
     </div>
     <div class=\"sekceCont\"> <a href=\"#\">
       <h2>STOLY A STOLKY</h2>
       </a>
       <div class=\"linkCont\"> <a href=\"#\">jidelni</a> <a href=\"#\">konferencni</a> <a href=\"#\">odkladaci</a> </div>
     </div>
     <div class=\"sekceCont\"> <a href=\"index.php?page=Zbozi&limit=0&cat=stoly\">
       <h2>PRACOVNí STOLY A SKříňKY</h2>
       </a>
       <div class=\"linkCont\"> <a href=\"index.php?page=Zbozi&limit=0&cat=stoly&subcat=jidelni\">jidelni</a> <a href=\"#\">konferencni</a> <a href=\"#\">odkladaci</a> </div>
     </div>
     <div class=\"sekceCont\"> <a href=\"#\">
       <h2>Dětský nábytek</h2>
       </a>
       <div class=\"linkCont\"> <a href=\"#\">jidelni</a> <a href=\"#\">konferencni</a> <a href=\"#\">odkladaci</a> </div>
     </div>
     <div class=\"sekceCont\"> <a href=\"#\">
       <h2>Zakázková výroba</h2>
       </a>
       <div class=\"linkCont\"> <a href=\"#\">jidelni</a> <a href=\"#\">konferencni</a> <a href=\"#\">odkladaci</a> </div>
     </div>','Nábytek')";

$database->query($q);
$database->query($p);
return "OK";
}


}?>