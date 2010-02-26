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
$p = "insert into texty values ('','rozcestnik','
		<div id=\"obsahSekce\">
		<div class=\"sekceCont\"> <a href=\"index.php?page=Zbozi&limit=0&cat=0\">
       <h2>Čajové stolky a sety</h2>
       </a>
     </div>
     <div class=\"sekceCont\"> <a href=\"index.php?page=Zbozi&limit=0&cat=1\">
       <h2>Ložnice</h2>
       </a>
       <div class=\"linkCont\"> 
	   <a href=\"index.php?page=Zbozi&limit=0&cat=1&subcat=2\">Postele</a> 
	   <a href=\"index.php?page=Zbozi&limit=0&cat=1&subcat=3\">Noční stolky</a> 
	   <a href=\"index.php?page=Zbozi&limit=0&cat=1&subcat=4\">Sety</a> </div>
     </div>
     <div class=\"sekceCont\"> <a href=\"index.php?page=Zbozi&limit=0&cat=2\">
       <h2>STOLY A STOLKY</h2>
       </a>
       <div class=\"linkCont\"> 
	   <a href=\"index.php?page=Zbozi&limit=0&cat=2&subcat=6\">Jídelní</a> 
	   <a href=\"index.php?page=Zbozi&limit=0&cat=2&subcat=7\">Konferenční</a> 
	   <a href=\"index.php?page=Zbozi&limit=0&cat=2&subcat=8\">Odkládací</a> </div> </div>
     <div class=\"sekceCont\"> <a href=\"index.php?page=Zbozi&limit=0&cat=3\">
       <h2>PRACOVNí STOLY A SKříňKY</h2>
       </a>
     </div>
     <div class=\"sekceCont\"> <a href=\"index.php?page=Zbozi&limit=0&cat=4\">
       <h2>Dětský nábytek</h2>
       </a>
       <div class=\"linkCont\">  
	   <a href=\"index.php?page=Zbozi&limit=0&cat=4&subcat=10\">Postele</a> 
	   <a href=\"index.php?page=Zbozi&limit=0&cat=4&subcat=11\">Noční stolky</a> 
	   <a href=\"index.php?page=Zbozi&limit=0&cat=4&subcat=12\">Pracovní stoly a police</a> 
	    </div>
     </div>
     <div class=\"sekceCont\"> <a href=\"index.php?page=Zbozi&limit=0&cat=5\">
       <h2>Zakázková výroba</h2>
       </a>
     </div></div>','Nábytek')";

$database->query($q);
$database->query($p);
return "OK";
}


}?>