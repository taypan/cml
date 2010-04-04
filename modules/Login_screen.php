<?php
class Login_screen extends Modul{

	var $acl = array(	"test" => "guest",
					"get_default" => "guest",
					"test2" => "administrator",
					"nevim" => "administrator");

	function get_title($n){
		return "Přihlášení";
	}

	function get_default($n){

		$login = new Form;
		$login->setAction('index.php?page=Enter');
		$login->addText('username', 'Uživatelské jméno:')
		->addRule(Form::FILLED, 'Zadejte jméno');
		$login->addPassword('password', 'Heslo:')
		->addRule(Form::FILLED, 'Zadejte heslo');
		$login->addSubmit('prihlasit', 'Přihlásit');

		if ($login->isSubmitted()) {
			// a jestliže jsou všechny položky vyplněny správně
			if ($login->isValid()) {
				/////////////////////////////////////////



				////////////////////////////////////////

				return '<h1>Formulář byl odeslán</h1>';

				//Debug::dump($values);
				exit;
			}

		} else {
			// a jestliže nebyl odeslán, nastavíme výchozí hodnoty
			return "<div class=\"login\">$login<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p></div>";
		}
	}


}?>