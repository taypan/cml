<?php 
include("include.php");

$tag = new Tag;
$model = new Model;
$funkce = new Funkce;
$status = new Status;
$database = new Database;
$controler = new Controler;

//Debug::enable();
//echo $scheme[$begin.'panel-header'.$end];
//echo $scheme[$begin.'panel-right'.$end];
//$model->panels


//$separator = "<!--panel-header -->";
//$content = "Header";
//echo $funkce->insert_content($model->template,$separator,$content);


//echo $model->parsed;
//$scheme_content = array();
/*foreach($pole as $index => $value) {
//$data = $funkce->load_file($path_to_template.$value.".html");
$scheme_content = $scheme_content + array($begin."content-".$value.$end => $model->panels['']);
}*/

//$model->add_panel_pure("left");
//$model->add_panel_pure("header");
//$model->add_panel_pure("right");
//$model->add_panel_pure("center");
//$model->add_panel_pure("footer");
/*
$model->add_panel("center","CENTER","Hlavní strana1");
$model->add_panel("center","CENTER","Hlavní strana2");
$model->add_panel("left","CENTER","Nadpis");
$model->add_panel("left","Panel 2","Nadpis 2");
*/

//$model->add_area("center");
//$model->add_area("left");

//$model->panel_into_area("center","Obsah","Titulek");
//$model->areas["left"]->add_panel("Obsah","Titulek");
//echo $model->panels['<!--content-panel-left -->'];
session_start();

header(`Expires: Mon, 26 Jul 1997 05:00:00 GMT`);
header(`Last-Modified: `.gmdate(`D, d M Y H:i:s`).` GMT`);
header(`Cache-Control: no-cache, must-revalidate`);
header(`Pragma: no-cache`);

//Debug::dump($_SESSION['items']);
global $model,$PHPSESSID;
//Debug::dump($_SESSION);
echo "XX".$PHPSESSID;
//if($PHPSESSID)
{

}
echo "XX".$PHPSESSID;
/*$objekt = new Clanky;
echo $objekt->panel_count();
echo $objekt->get_content(0);
$model->panel_into_area("left",$objekt->get_content(1),$objekt->get_title(1));*/
//$database->query("insert into menus_items values ('','Hlavní strana','index.php',1,0,'second')");
$controler->display();



/*
$pole = $funkce->parse_arg("");
echo $pole['hodnota'];
*/

/*
function tester($opt = ""){
if($opt == ""){echo "Empty";}
else {echo "full of: $opt";}
}
*/



//$q = "INSERT INTO table VALUES"; 
//echo addslashes("./templates/Aukce/");



//echo "---------------------------------<br>";
//foreach($model->panels as $key => $value)
//{
//echo $key;
//}
//echo "--".$model->panels['<!--content-panel-left -->'];

//while(list($index, $value) = each($scheme)){
//echo $funkce->insert_content($suma,$index,$value);

//$model->template = $funkce->insert_content($model->template,$index,$value);
//}

/*
$scheme = array( 
"<!--panel-header -->" =>"Header", 
"<!--panel-left -->" => "Left",
"<!--panel-right -->" => "Right", 
"<!--panel-footer -->" => "Footer"
);*/

//echo "--------------\n";
//echo $model->complet;
//echo $funkce->insert_content($model->complete,"<!--panel-left -->","DATA");


?>