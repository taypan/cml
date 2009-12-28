<?php
class Login extends Modul{
var $objekt;
var $inside;

function get_title(){
return "Přihlášení";
}

function logged_in_menu(){

global $model;
$this->inside = $this->arg['menu'];
$inside = $this->inside;
$this->objekt = new $this->inside($this->info,"menu=".$inside);
for($c = 0; $this->panel_inside_count() > $c;$c++){
$model->panel_into_area($this->info['area'],$this->get_inside_content($c),$this->get_inside_title($c));}
}

function panel_inside_count(){
return $this->objekt->panel_count();
}
function get_inside_content(){
return $this->objekt->get_content();
}
function get_inside_title(){
return $this->objekt->get_title();
}

function load_login_form(){
//global $user,$model;
return "<form name=\"login\" action=\"index.php?page=Enter\" method=\"post\" >
<table width=\"0\" border=\"0\">
  <tr>
    <td><label class=\"required\" for=\"frm-uname\">Uživatelské jméno:</label></td>
    <td><input type=\"text\" class=\"text\" name=\"username\" id=\"frm-uname\" value=\"\" size=\"10\"/></td>
  </tr>
  <tr>
    <td><label class=\"required\" for=\"frm-pass\">Heslo:</label></td>
    <td><input type=\"password\" class=\"text\" name=\"password\" id=\"frm-pass\" value=\"\" size=\"10\"/></td>
  </tr>
  <tr>
  <td></td>
    <td><input type=\"submit\" class=\"button\" name=\"prihlasit\" id=\"frm-prihlasit\" value=\"Přihlásit\" /></td>
  </tr>
</table>
</form>";
/*
$login = new Form;

$login->addText('username', 'Uživatelské jméno:')
->addRule(Form::FILLED, 'Musíte zadat uživatelské jméno!');
$login->addPassword('password', 'Heslo:')
->addRule(Form::FILLED, 'Musíte zadat heslo!');
$login->addSubmit('prihlasit', 'Přihlásit');

$renderer = $login->getRenderer();
$renderer->wrappers['controls']['container'] = 'dl';
$renderer->wrappers['pair']['container'] = NULL;
$renderer->wrappers['label']['container'] = NULL;
$renderer->wrappers['control']['container'] = NULL;


if ($login->isSubmitted()) {
    // a jestliže jsou všechny položky vyplněny správně
    if ($login->isValid()) {
        /////////////////////////////////////////
		

		
		////////////////////////////////////////	
		
		//return '<h1>Formulář byl odeslán</h1>';

        //Debug::dump($values);
        exit;
    }

} else {
    // a jestliže nebyl odeslán, nastavíme výchozí hodnoty
    $login->setDefaults(array(
        'promo' => TRUE,
    ));
	return $login;
	} */
}

function get_content($n){
global $model;
//$user = Environment::getUser();
if($model->user->isAuthenticated()){$this->logged_in_menu();}
else {return $this->load_login_form();}

}

function has_own_panels(){
global $model;
if($model->user->isAuthenticated()){return FALSE;}
else {return TRUE;}
}



}
?>