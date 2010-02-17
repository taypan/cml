<?php
/////////////// CONTROLER //////////////////
class Controler{
//////////////////////////////////////////////
var $modul = array();
var $acl;

function Controler()
{
global $funkce, $status, $model,$database;
$database->load_settings();
$model->varchar = "panel-center,panel-header,panel-left,panel-right,panel-footer,panel-style,panel-kosik";
$model->path_to_template = TEMPLATES_DIRECTORY.CURRENT_TEMPLATE."/";
$model->template = $funkce->load_file($model->path_to_template."template.html");
$model->user = Environment::getUser();
$this->acl = new Permission;
$this->set_acl();
$model->user->setAuthorizationHandler($this->acl);
$this->parse();
$this->load_modules();
$this->include_modules();
$this->load_panels();


}
///////////////////////////////////////////////
function set_acl(){
global $database;
// definujeme role

$this->acl->addRole('guest');
//$this->acl->addRole('unautorized','guest');
$this->acl->addRole('member','guest');
$this->acl->addRole('administrator', 'member');  // administrator je potomkem member
$this->acl->addRole('superadmin', 'administrator');

$pole = array(
"panel" => "panels",
"menus_item" => "menus_items");


foreach($pole as $key => $value){
$q = "SELECT id,level FROM $value";
$result = $database->query($q);
for($i = 0;$i !=mysql_numrows($result);$i++){
$id = mysql_result($result,$i,'id');
$level = mysql_result($result,$i,'level');
$this->acl->addResource($key."_".$id);
$this->acl->allow($level, $key."_".$id, 'view');
}
$p = "SELECT id,deny_for FROM $value";
$result = $database->query($p);
for($i = 0;$i !=mysql_numrows($result);$i++){
$id = mysql_result($result,$i,'id');
$deny_for = mysql_result($result,$i,'deny_for');
//$this->acl->addResource($key."_".$id);
if($deny_for != ""){$this->acl->deny($deny_for, $key."_".$id, 'view');}
}
}

//TODO tahani opravneni z DB (nebo z modulu)

$this->acl->addResource("settings");
$this->acl->allow("administrator", "settings", 'change');
$this->acl->addResource("zbozi");
$this->acl->allow("administrator", "zbozi", 'change');
$this->acl->addResource("admin_prehled");
$this->acl->allow("administrator", "admin_prehled", 'change');


// definujeme zdroje
/*
$this->acl->addResource('file');
$this->acl->addResource('article');
*/
// pravidlo: host může jen prohlížet články


// pravidlo: člen může prohlížet vše, soubory i články
//$this->acl->allow('member', Permission::ALL, 'view');

// administrátor dědí práva od člena, navíc má právo vše editovat
//$this->acl->allow('administrator', Permission::ALL, array('view', 'edit'));

}

function load_panels(){
global $database, $model;
$q = "SELECT * FROM panels ORDER BY POSITION";
$result = $database->query($q);
if(mysql_numrows($result) > 0){
for($i = 0;$i != mysql_numrows($result);$i++){
$area = mysql_result($result,$i,'area');
$position = mysql_result($result,$i,'position');
$modul = mysql_result($result,$i,'modul');
$id = mysql_result($result,$i,'id');
if($model->user->isAllowed('panel_'.$id,'view')){
$info = array("area" => $area, "position" => $position, "id" => $id,"modul" => $modul);
$arg = mysql_result($result,$i,'arguments');
$objekt = new $modul($info,$arg);
//echo $modul;
//$objekt->acl = array("test" => "administrator","test2" => "administrator","nevim" => "guest");
//Debug::dump($objekt->acl);
foreach ($objekt->acl as $key => $value){
$res = $id."_action_".$key;
$this->acl->addResource($res);
$this->acl->allow($value, $res, 'execute');
										}

for($c = 0; $objekt->panel_count() > $c;$c++){
if($objekt->get_area($c)){$area = $objekt->get_area($c);}
//echo $area;
$model->panel_into_area($area,$objekt->get_content($c),$objekt->get_title($c),$objekt->has_own_panels());
}
												}
}
}



}


function isenabled($modul){
//TODO: kontrola jesli je modul povolený(z db)
return 1;
}
function include_modules()
{
global $model;
foreach($this->modul as $key => $value){
if($this->isenabled($value)){include(MUDULES_DIRECTORY.$value.".php");}
}

}

function load_modules()
{
global $model;
//echo MUDULES_DIRECTORY;
$handle=opendir(MUDULES_DIRECTORY); 
while (false!==($file = readdir($handle))) 
{ 
    if ($file != "." && $file != "..") 
    { 
		//echo $file;
        $pole = explode(".",$file);
		if (count($pole) == 2 && $pole[1] == "php") {
		$this->modul[] = $pole[0];
		
		}
    } 
}
closedir($handle); 


}

function parse(){
global $funkce, $model;
$pole = explode(",",$model->varchar);
foreach($pole as $index => $value) 
{
$data =  "<!--content-".$value." -->"; 
$key = "<!--".$value." -->";
$model->scheme_panels = $model->scheme_panels + array($key => $data);
}
//foreach($model->scheme_panels as $key => $value){echo "Key: ".$key." Value: ".$value;}

//echo $model->scheme_panels['<!--panel-left -->'];
$model->parsed = $funkce->insert_panels($model->scheme_panels,$model->template);
//$model->scheme_panels = array();

}

function put_panels()
{
global $model, $funkce;
$model->complete = $model->parsed;
foreach($model->areas as $key => $value) {
$index = "<!--content-panel-".$key." -->";
$content = $value->giveme_sum();
$model->complete = $funkce->insert_content($model->complete,$index,$content);
}

}
///////////////////////////////////////////////
function display()
{
global $model, $status;
$this->put_panels();
echo $model->complete;
$status->displayed = 1;
}
///////////////////////////////////////////////

}



?>