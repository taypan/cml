<?php
class Zbozi_manager extends Modul{
var $varianta;

function get_title($n)
{
if($n == 0) {return "Správce zboží";}
elseif ($n == 1) {return "Správce - Menu";}
else {return FALSE;}
}

function br2nl($text) {
return preg_replace('/<br\\s*?\\/??>/i', "", $text);
}

function get_area($n)
{
//echo $n;
if($n == 0) {return FALSE;}
elseif ($n == 1) {return "left";}
else {return FALSE;}
}

function remove_item($id){
$q = "DELETE FROM items WHERE id = $id LIMIT 1";
//echo $q;
global $database;
if($database->query($q)){return TRUE;} else {return FALSE;}
}


function panel_count(){ //varací pocet panelu;
return 2;
}

function remove(){
if(isset($_GET['id']) && $this->isitem($_GET['id'])){
if($this->remove_item($_GET['id'])) {return MSG_BEGIN."Položka byla odstraněna".MSG_END;} 
else {return MSG_BEGIN."Položku se nepodařilo odstranit".MSG_END;
}

}
else {
return MSG_BEGIN."Polozka neexistuje".MSG_END;
}
}
function get_content($n){
if($n == 0){
global $model;
if($model->user->isAllowed('zbozi','change')){

if(isset($this->params_g['action'])){
switch ($this->params_g['action']){
case 'manage':
return $this->manage();
case 'add':
return $this->add();
case 'remove':
return $this->remove();
default:
return $this->manage();
} 

}else {return $this->manage();}



} else {return $this->access_forbidden();}


} else {return $this->get_default();}
}

function isitem($id){
global $database;
$q = "SELECT id FROM items WHERE id = '$id'";
$result = $database->query($q);
if (mysql_num_rows($result) <= 0) {return 0;}
else {return 1;}
}

function manage(){
$sum = $this->draw_counter("index.php?page=Zbozi_manager&action=manage&");
if(isset($_SESSION['msg'])){$sum = $sum . $_SESSION['msg']; unset($_SESSION['msg']);}
$sum = $sum . '<br><br><table><tr><th>Jméno</th><th>Popis</th><th>Cena</th><th colspan="3">Možnosti</th></tr>';
if(isset($_GET['limit'])){$sum = $sum . $this->get_items(1,$_GET['limit']);} else {$sum = $sum .$this->get_items(1);}
$sum = $sum . "</table>";


return $sum;
}

function get_items($c = 0,$from = 0)
{
global $database;
$sum = "";
$limit = ITEMS_ON_PAGE;
$q = "SELECT * FROM items ORDER BY id LIMIT $from,$limit";

$result = $database->query($q);
$d = mysql_num_rows($result);
for($i = 0;$i != $d;$i++)
{

if($c == 0){$sum = $sum. $this->list_items($i,$result);} else {

$sum = $sum.$this->list_table($i,$result);
}
}
return $sum;
}

function list_table($i,$result)
{
$id = mysql_result($result,$i,"id");
$nazev = mysql_result($result,$i,"nazev");
$popis = mysql_result($result,$i,"popis");
$popis = substr($popis, 0, POPIS_LENGHT);
$cena = mysql_result($result,$i,"cena");
$dostupnost = mysql_result($result,$i,"dostupnost");

return "<tr>
    <td> $nazev </td>
    <td> $popis </td>
    <td> $cena </td>
    <td><a href=\"index.php?page=Zbozi_manager&action=add&id=$id\">Upravit</a></td>
    <td><a href=\"index.php?page=Zbozi_manager&action=remove&id=$id\">Odstranit</a></td>
  </tr>";

}

function  draw_counter($page){
global $database;
$q = "SELECT id FROM items";
$result = $database->query($q);
$sum = "Strana: ";
$c = 1;
$count = mysql_num_rows($result);
if(!isset($_GET['limit'])){$_GET['limit'] = 0;}
for($i = 0;$i < $count;$i += ITEMS_ON_PAGE)
															{
if($i == 0){
if(isset($_GET['limit']) && $_GET['limit'] >= ITEMS_ON_PAGE)
{$sum = $sum. "<a href=\"".$page."limit=".($_GET['limit'] - ITEMS_ON_PAGE)."\">Předchozí</a> ";}
}

if(isset($_GET['limit']) && $_GET['limit'] == (($c -1)*ITEMS_ON_PAGE))
{$sum = $sum. "<strong>" .$c."</strong>" . " ";}
else {$sum = $sum. "<a href=\"".$page."limit=". $i. "\">".$c."</a> ";}
if($c  == ceil($count / ITEMS_ON_PAGE) && isset($_GET['limit']) && !(($_GET['limit']+ITEMS_ON_PAGE) >= $count ))
{
$sum = $sum. "<a href=\"".$page."limit=".($_GET['limit'] + ITEMS_ON_PAGE). "\">Následující</a> ";
}
elseif (!(isset($_GET['limit'])) && ($c  == ceil($count / ITEMS_ON_PAGE))){$sum = $sum. "<a href=\"".$page."limit=".ITEMS_ON_PAGE. "\">Následující</a> ";}
$c++;
															}

return $sum;
}

function get_default(){
return "<p align=\"center\"><a href=\"index.php?page=Zbozi_manager&action=add\">Přidat</a></br><a href=\"index.php?page=Zbozi_manager&action=manage\">Upravit</a>";
}


function add(){
$dostup = array(
	1 => 'Skladem',
	2 => 'Na ceste',
	3 => 'Není skladem',
);
$cat = explode(",",CAT);
$subcat = explode(",",SUBCAT);

$pridavani = new Form;
$pridavani->setAction("index.php?page=Zbozi_manager&action=add");
$pridavani->addText('nazev', 'Název:',30)
	->addRule(Form::FILLED, 'Zadejte název');
	
$pridavani->addTextArea('popis', 'Popis:',50,10)
	->addRule(Form::FILLED, 'Zadejte popis');
$pridavani->addSelect('cat', 'Kategorie:', $cat);
$pridavani->addSelect('subcat', 'Podkategorie:', $subcat);
$pridavani->addText('rozmery', 'Rozměry:')
	->addRule(Form::FILLED, 'Zadejte rozměry');

$pridavani->addRadioList('dostupnost', 'Dostupnost:', $dostup)
		->addRule(Form::FILLED, 'Zadejte dostupnost');
$pridavani->addText('cena', 'Cena:')
	->addRule(Form::FILLED, 'Zadejte cenu')
	->addRule(Form::INTEGER, 'Cena musí být číslo');
	//->addRule(Form::RANGE, 'Věk musí být v rozmezí od %d do %d', array(5, 120));
$pridavani->addFile('new_image', 'Obrázek (pouze JPEG do velikosti 2 MB)')
        ->addCondition(Form::FILLED)
		->addRule(Form::MIME_TYPE, 'Soubor musí být obrázek', 'image/jpeg');
if(isset($_GET['id']))
{
$pridavani->addHidden('id')->setValue($_GET['id']);
}

if(isset($_GET['id'])){$text = 'Uložit';} else {$text = 'Přidat';}
$pridavani->addSubmit('pridat', $text);



if (isset($_GET['id'])  && $this->isitem($_GET['id']))
{
//echo "OK";
$id = $_GET['id'];
$q = "SELECT * FROM items WHERE id = '$id'";
global $database;
$result = $database->query($q);
//echo mysql_num_rows($result);
//echo $this->br2nl(mysql_result($result,0,"popis"));
$pridavani->setDefaults(array(
        'nazev' => mysql_result($result,0,"nazev"),
		'popis' => $this->br2nl(mysql_result($result,0,"popis")),
		'cat' => mysql_result($result,0,"cat"),
		'subcat' => mysql_result($result,0,"subcat"),
		'rozmery' => mysql_result($result,0,"rozmery"),
		'dostupnost' => mysql_result($result,0,"dostupnost"),
		'cena' => mysql_result($result,0,"cena"),
    ));
}

//echo "X:".$pridavani['pridat']->isSubmittedBy();
//if($pridavani['pridat']->isSubmittedBy()){echo " je";} else {echo " neni";}

if ($pridavani->isSubmitted()) {

	//echo $form->isSubmitted();
	//$form['pridat']->isSubmittedBy()
	// a jestli?e jsou v?echny polo?ky vypln?ny správn?
	
	if ($pridavani->isValid()) {
		//$form->isValid()
		$values = $pridavani->getValues();
		//Debug::dump($values);
		//image_upload(3);
		//Debug::dump($_POST);
		//echo "X".$pridavani['id']->value."X";
		if(isset($_POST['id'])){$id= $_POST['id'];} else {$id = 0;}
		//echo "X".$values['id']."X";
		$this->add_item($values,$id);
		//image_upload ($name,TMP_DIR,IMG_DIR_BIG,IMG_DIR_SMALL,MODWIDTH_SML,MODWIDTH_BIG);
		
		//image_upload ($id,$tmpdir,$bigdir,$smldir,$modwidth_sml,$modwidth_big){
		if(isset($_SESSION['msg'])){return $_SESSION['msg']; unset($_SESSION['msg']);}
		/*$pridavani->setDefaults(array(
        'nazev' => '',
		'popis' => '',
		'rozmery' => '',
		'dostupnost' => '',
		'cena' => '',
    	));*/
		//echo 'Polo?ka byla úsp??n? p?idána<br><a href="admin.php?add">Přidat dal?í...</a>';
		return MSG_BEGIN.'Položka byla úspěšně upravena<br><a href="index.php?page=Zbozi_manager&action=manage">Upravit další...</a>'.MSG_END;
	}

} else {
	return $pridavani;
	}

}

function add_item($values,$id = 0){
global $database;
//echo $id;
if($id != 0 && $this->isitem($id)){
$q = "UPDATE items SET nazev = '".addslashes($values['nazev'])."', popis = '".nl2br(addslashes($values['popis']))."', cat = '".$values['cat']."', subcat = '".$values['subcat']."' , cena = '".$values['cena']."', dostupnost = '".$values['dostupnost']."',rozmery = '".addslashes($values['rozmery'])."' WHERE id = $id LIMIT 1 ";
//echo $q;
$database->query($q);
}
else{ 
$q = "insert into items values ('','".$values['cat']."','".$values['subcat']."','".addslashes($values['nazev'])."','".nl2br(addslashes($values['popis']))."',".$values['cena'].",'".$values['dostupnost']."','".addslashes($values['rozmery'])."')";
//echo $q;
$database->query($q);
$_SESSION['msg'] = MSG_BEGIN.'Položka byla úspěšně přidána<br><a href="index.php?page=Zbozi_manager&action=add">Přidat další...</a>'.MSG_END;
}
if($id == 0){$id = mysql_insert_id();}
$this->image_upload ($id,TMP_DIR,IMG_DIR_BIG,IMG_DIR_SMALL,MODWIDTH_SML,MODWIDTH_BIG);
//echo mysql_insert_id();
return 0;
}

function image_upload ($id,$tmpdir,$bigdir,$smldir,$modwidth_sml,$modwidth_big){
        if(isset($_POST['pridat'])){
		//echo "XXX";
          if (isset ($_FILES['new_image']) && $_FILES['new_image']['name'] != ""){
		  //echo ":".$_FILES['new_image']['name'].":";
              $imagename = $_FILES['new_image']['name'];
			  //echo $imagename;
              $source = $_FILES['new_image']['tmp_name'];
			  //if (is_file($source)){echo "OK";} else{echo "XXX";}
			  //echo $source;
              $target = $tmpdir . $imagename;
			  //Debug::enable();
			  //Debug::dump($_FILES);
			  
              move_uploaded_file($source, $target);
 
              $imagepath = $imagename;
              $save = $bigdir .$id.".jpg"; //This is the new file you saving
              $file = $tmpdir . $imagepath; //This is the original file
 
              list($width, $height) = getimagesize($file) ; 
 
              $modwidth = $modwidth_big; 
 
              $diff = $width / $modwidth;
 
              $modheight = $height / $diff; 
              $tn = imagecreatetruecolor($modwidth, $modheight) ; 
              $image = imagecreatefromjpeg($file) ; 
              imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ; 
 				
			  //mkdir("img/".$id."/",0777);
  			  //mkdir("img/".$id."/sml/",0777);
			  if(file_exists($bigdir .$id.".jpg")){unlink($bigdir .$id.".jpg");}
              imagejpeg($tn, $save, 100) ; 
              $save = $smldir.$id.".jpg"; //This is the new file you saving
              $file = $tmpdir . $imagepath; //This is the original file
 
              list($width, $height) = getimagesize($file) ; 
 
              $modwidth = $modwidth_sml; 
 
              $diff = $width / $modwidth;
 
              $modheight = $height / $diff; 
              $tn = imagecreatetruecolor($modwidth, $modheight) ; 
              $image = imagecreatefromjpeg($file) ; 
              imagecopyresampled($tn, $image, 0, 0, 0, 0, $modwidth, $modheight, $width, $height) ; 
			  //mkdir("pictures/".$id."/",0777);
              if(file_exists($smldir.$id.".jpg")){unlink($smldir.$id.".jpg");}
			  
			  imagejpeg($tn, $save, 100);
			  
			  
			  if (file_exists($tmpdir . $imagepath)) {unlink($tmpdir . $imagepath);}
			  
            //$_SESSION['big'] = "img/".$id.".jpg";
			//$_SESSION['small'] = "img/sml/".$id."/.jpg"; 
            //echo "Thumbnail: <img src='pictures/sml_".$imagepath."'>"; 
 
          }
        }}
	
}	
		/*
function add_item($values,$id = 0){
global $database;
//echo $id;
if($id != 0 && $this->isitem($id)){
$q = "UPDATE items SET nazev = '".$values['nazev']."', popis = '".$values['popis']."' , cena = '".$values['cena']."', dostupnost = '".$values['dostupnost']."',rozmery = '".$values['rozmery']."' WHERE id = $id LIMIT 1 ";
//echo $q;
$database->query($q);
}
else{ 
$q = "insert into items values ('','".$values['nazev']."','".$values['popis']."',".$values['cena'].",'".$values['dostupnost']."','".$values['rozmery']."')";
//echo $q;
$database->query($q);
$_SESSION['msg'] = 'Polo?ka byla úsp??n? p?idána<br><a href="index.php?page=Zbozi_manager&action=add">P?idat dal?í...</a>';
}
if($id == 0){$id = mysql_insert_id();}
$this->image_upload ($id,TMP_DIR,IMG_DIR_BIG,IMG_DIR_SMALL,MODWIDTH_SML,MODWIDTH_BIG);
//echo mysql_insert_id();
return "Polo?ka byla úsp??n? upravena!";
}*/

?>