<?php
class Objednat extends Modul{

var $id_objednavka;
var $email;
var $code;
var $values;


function get_content(){
global $model;
if($model->user->isAuthenticated()){  //prihlasen
//if(isset($_GET['action'])&& $_GET['action'] == "remove"){echo "tady";return $this->remove();}
if(isset($this->params_g['action'])){
switch ($this->params_g['action']){
case 'submit':
return $this->submit();
case 'remove':
return $this->remove();
default:
return $this->get_default();
} 
} else {return $this->get_default();}
}
////////////////////////////////////////
 else {  //neprihlasen
 if(isset($this->params_g['action'])){
switch ($this->params_g['action']){
case 'remove':
return $this->remove();
default:
return $this->get_default();
} 
}
if(isset($_SESSION['items']) && count($_SESSION['items']) != 0){
return $this->draw_kosik_content().$this->get_default_unreg().$this->getForm();
}
else {return MSG_BEGIN."Košík je prázdný.</br>Před odesláním objednávky musíte objednat nějaké zboží!".MSG_END;}
}   
////////////////////////////////////////
}

function get_title(){
return "Potvrzení objednávky";
}
/*
function remove(){
$code = $this->params_g['code'];
//if(isset($_SESSION['items'])){echo "OK";}
//echo $_SESSION['items'][1][1];
unset($_SESSION['items'][array_search($code,$_SESSION['items_codes'])]);
unset($_SESSION['items_codes'][array_search($code,$_SESSION['items_codes'])]);
return $this->get_default();
} */

function getForm(){
$reg_form = new Form;
$reg_form->addText('jmeno', 'Jméno:')
	->addRule(Form::FILLED, 'Zadejte jméno');
$reg_form->addText('prijmeni', 'Příjmení:')
	->addRule(Form::FILLED, 'Zadejte přijmení');
$reg_form->addText('email', 'E-mail:')
	->setEmptyValue('@') // zavináč bude předvyplněn
	->addRule(Form::EMAIL, 'E-mailová adresa není platná');
	//->addRule('MyValidators::emailTaken', 'Zadaný e-mail už někdo používá. Zvolte si jiný');  

$reg_form->addText('ulice', 'Ulice a čp:')
	->addRule(Form::FILLED, 'Zadejte ulici');
$reg_form->addText('mesto', 'Město:')
	->addRule(Form::FILLED, 'Zadejte město');
$reg_form->addText('psc', 'PSČ:')
	->addRule(Form::FILLED, 'Zadejte psč')
	->addRule(Form::MIN_LENGTH, 'Zadané PSČ je neplatné, zadávejte ho bez mezer',5)
	->addRule(Form::MAX_LENGTH, 'Zadané PSČ je neplatné, zadávejte ho bez mezer',5)
	->addRule(Form::INTEGER, 'Zadané PSČ je neplatné, zadávejte ho bez mezer');	
	
$reg_form->addText('tel_num', 'Mobilní telefon:')
	->addRule(Form::FILLED, 'Zadejte mobilní telefon')
	//->addRule(Form::INTEGER, 'Zadané telefoní číslo není platné')
	->addRule(Form::MIN_LENGTH, 'Zadané telefoní číslo není platné',9);



$reg_form->addCheckbox('podminky', 'Souhlasím s obchodními podmíkami')
		->addRule(Form::FILLED, 'Musíte souhlasit s obchodnímy podmíkami');
$reg_form->addSubmit('objednat', 'Potvrdit objednávku ');

if ($reg_form->isSubmitted()) {
    // a jestliže jsou všechny položky vyplněny správně
    if ($reg_form->isValid()) {

        //$reg_form->getValues();
		if($this->values = $reg_form->getValues()){
		return $this->submit();
		} else {
		return "Objednávka se nezdařila. Zkuste to znovu později nebo nás kontaktujte e-mailem na " . SUPPORT_MAIL;
		} 
	
        
    } else {return $reg_form;}

} else {
    return $reg_form;
    } 



}

function get_default_unreg(){
global $database,$reg_form;
if(isset($this->id_objednavka)){
if(isset($_SESSION['items'])){
$sum = "Položky v košíku:";
//$counter = 0;
foreach($_SESSION['items'] as $key => $value)
{
$q = "SELECT nazev FROM items WHERE id='$value'";
$result = $database->query($q);
$nazev = mysql_result($result,0,'nazev');
$sum = $sum ."<br>". $nazev." <a href=index.php?page=Objednat&action=remove&code=".$_SESSION['items_codes'][$key].">Odstranit</a>";
}
return $sum;
}
else {return "Nebyly vybrány žádné položky";}
}
else {return '';}


}


function get_default(){
global $database;
if(isset($_SESSION['items'])){
$sum = $this->draw_kosik_content();
//$counter = 0;
/*foreach($_SESSION['items'] as $key => $value)
{
$q = "SELECT nazev FROM items WHERE id='$value'";
$result = $database->query($q);
$nazev = mysql_result($result,0,'nazev');
$sum = $sum ."<br>". $nazev." <a href=index.php?page=Objednat&action=remove&code=".$_SESSION['items_codes'][$key].">Odstranit</a>";
}*/

if(sizeof($_SESSION['items']) != 0){
$sum = $sum . "<form action=\"index.php\" method=\"get\">
<input type=\"hidden\" name=\"page\" value=\"Objednat\">
<input type=\"hidden\" name=\"action\" value=\"submit\">
<input type=\"submit\" value=\"Potvrdit objednávku\" />
</form>";}
else {$sum = $sum . MSG_BEGIN ."Ve vašem košíku není žádné zboží.".MSG_END;}
return $sum;
}
else {return MSG_BEGIN ."Nebyly vybrány žádné položky".MSG_END;}

}

function sendMail(){
$mailer = new Mailer;
//TODO 
/*return*/ $mailer->sendConfEmail($this->id_objednavka,$this->email,$this->code);
//Debug::dump($this->id_objednavka);
return TRUE;
}
function submit(){
global $model;

foreach($_SESSION['items'] as $key => $value){
if($this->isitem($value)){
$items[$key] = $value;
}
}

if($model->user->isAuthenticated() && $items != 0){

$user = $model->user->getIdentity()->getName();
$credentials = $this->fetch_user($user);

if($this->createObjednavka(TRUE,$items)){
unset($_SESSION['items']);
return MSG_BEGIN."Objednávka byla uložena a byl odeslán ověřovací email. Realizace objednávky bude započata, až v ověřovacím emailu kliknete na kontrolní odkaz.</br> Děkujeme za nákup".MSG_END;
} else {return MSG_BEGIN."Objednávka se nezdařila zkuste to znovu".MSG_END;}


} elseif (!$model->user->isAuthenticated() && sizeof($_SESSION['items']) != 0 )  { //neprihlasen
if($this->createObjednavka(FALSE,$items)){
unset($_SESSION['items']);
return MSG_BEGIN."Objednávka byla uložena a byl odeslán ověřovací email. Realizace objednávky bude započata, až v ověřovacím emailu kliknete na kontrolní odkaz.</br></br>Děkujeme za nákup".MSG_END;
} else {return MSG_BEGIN."Objednávka se nezdařila zkuste to znovu".MSG_END;}


} else {   //prázdná session
return MSG_BEGIN."Objednávka nemohla být realizovaná z důvodu absence položek v košíku!".MSG_END;
}


}

function isitem($id){
global $database;
$q = "SELECT id FROM items WHERE id = '$id'";
$result = $database->query($q);
if (mysql_num_rows($result) <= 0) {return 0;}
else {return 1;}
}

function fetch_user($user){
global $model,$database;
$q = "select * from users where username='$user' limit 1";
$result = $database->query($q);
//Debug::dump(mysql_fetch_array($result));
if (mysql_num_rows($result) == 1){return mysql_fetch_array($result);}
else {return FALSE;}
}

function genCode(){
//echo substr(sha256(sha256($this->id_objednavka.RAND1).md5(RAND2)),25,32);
return substr(sha256(sha256($this->id_objednavka.RAND1).md5(RAND2)),25,32);
}

function createObjednavka($var,$items){
global $model,$database;
if($var){
$user = $model->user->getIdentity()->getName();
$credentials = $this->fetch_user($user);
$reg = "ano";
} else {
$credentials = $this->values;
$reg = "ne";
$user = '';
}
if($credentials){
$date = "NOW()";
//Debug::dump($credentials);

$str_objednavatele = "insert into objednatele values ('','$reg','".$credentials['jmeno']."','".$credentials['prijmeni']."','".$credentials['email']."','".$credentials['ulice']."','".$credentials['mesto']."','".$credentials['psc']."','".$credentials['tel_num']."','$user')";
if($database->query($str_objednavatele))		{
$objednatel_id = mysql_insert_id();
$str_objednavka = "insert into objednavky values ('',$date,'$objednatel_id','nepotvrzeno')";
if($database->query($str_objednavka))	{
$objednavka_id = mysql_insert_id();
foreach($items as $key => $value)	{
$str_polozka = "insert into objednavky_polozky values ('','$objednavka_id','$value','zpracovani')";
if(!$database->query($str_polozka)) {return FALSE;} 
									}									}
else {return FALSE;} 
										}
else {
return FALSE;} 
}
$this->id_objednavka = $objednavka_id;
$this->email = $credentials['email'];
$this->code = $this->genCode();
if(!$this->sendMail()){return FALSE;}
else {return TRUE;}

//echo $objednatel_id;
//echo $w;

}

function draw_kosik_content(){
//Debug::dump($_SESSION['items_codes']);
global $database;
if(isset($_SESSION['items']) && count($_SESSION['items']) != 0){
$sum = "<table><tr><th colspan=\"2\">Položky v košíku:</th></tr>";
//$counter = 0;
foreach($_SESSION['items'] as $key => $value)
{
$q = "SELECT nazev FROM items WHERE id='$value'";
$result = $database->query($q);
$nazev = mysql_result($result,0,'nazev');
$sum = $sum ."<tr><td width=\"100\">". $nazev."</td><td><a href=index.php?page=Objednat&action=remove&code=".$_SESSION['items_codes'][$key].">
<img src=\"".TEMPLATES_DIRECTORY.CURRENT_TEMPLATE."/images/drop.png\" alt=\"Odstranit\"></a></td><tr>";

/*<a href="index.php?page=Settings&action=remove_att&id=14"><img src="templates/Rukodilna/images/drop.png" alt="Odstranit"></a>*/

}
return $sum."</table></br>";
}
else {return /*MSG_BEGIN."Nebyly objednány žádné položky".MSG_END*/;}

}

function remove(){
if (isset($this->params_g['code']) && !(array_search($this->params_g['code'],$_SESSION['items_codes']) === FALSE)){
$code = $this->params_g['code'];
//echo "OK";
//if(isset($_SESSION['items'])){echo "OK";}
//echo $_SESSION['items'][1][1];
unset($_SESSION['items'][array_search($code,$_SESSION['items_codes'])]);
unset($_SESSION['items_codes'][array_search($code,$_SESSION['items_codes'])]);
unset($_GET['action']);
if(isset($_SESSION['items']) && count($_SESSION['items']) != 0){return MSG_BEGIN."Položka byla odstraněna".MSG_END.$this->draw_kosik_content().$this->get_default_unreg().$this->getForm();}
else {return MSG_BEGIN."Košík je prázdný!".MSG_END;}
//return $this->get_content();
}
else {
//echo array_search($this->params_g['code'],$_SESSION['items_codes']) ." \"".$this->params_g['code']."\"";
if(isset($_SESSION['items']) && count($_SESSION['items']) != 0){
return $this->draw_kosik_content().$this->get_default_unreg().$this->getForm();
}
else {
return $this->draw_kosik_content();
}
}
}

}
?>