<?php
class MyValidators
{
	public static function usernameTaken($item){
		global $database;
		$username = $item->getValue();
		if(!get_magic_quotes_gpc()){
			$username = addslashes($username);
		}
		$q = "SELECT username FROM users WHERE username = '$username'";
		$result = $database->query($q);
		if (mysql_numrows($result) == 0)
		{return 1;}
		else {return 0;}
		//return 0;
	}
	 
	public static function emailTaken($item){
		global $database;
		$email = $item->getValue();
		if(!get_magic_quotes_gpc()){
			$email = addslashes($email);
		}
		$q = "SELECT email FROM users WHERE email = '$email'";
		$result = $database->query($q);
		if (mysql_numrows($result) == 0)
		{return 1;}
		else {return 0;}
		//return 0;
	}
	 
}

class Registrator extends Modul{

	function get_content($n){
		global $model;
		if(!$model->user->isAuthenticated()){
			if(isset($this->params_g['action'])){
				switch ($this->params_g['action']){
					case 'reg':
						return $this->reg();
					default:
						return $this->get_default();
				}}
				else {return $this->get_default();}
		} else {return MSG_BEGIN."Již jste registrován!".MSG_END;}
	}

	function get_title(){
		return "Registrace";
	}


	function get_default(){

		$reg_form = new Form;
		$reg_form->addText('username', 'Uživatelské jméno:')
		->addRule(Form::FILLED, 'Zadejte uživatelské jméno')
		->addRule(Form::MIN_LENGTH, 'Uživatelské jméno musí mít minimálně %d znaků',5)
		->addRule(Form::MAX_LENGTH, 'Uživatelské jméno může mít maximálně %d znaků',30)
		->addRule('MyValidators::usernameTaken', 'Uživatelské jméno je již zabrané. Zvolte si jiné'); 
		$reg_form->addPassword('password', 'Heslo:')
		->addRule(Form::FILLED, 'Zvolte si heslo')
		->addRule(Form::MIN_LENGTH, 'Zadané heslo je příliš krátké, zvolte si heslo alespoň o %d znacích', MIN_PASS_LENGHT);

		$reg_form->addPassword('password2', 'Heslo pro kontrolu:')
		->addRule(Form::FILLED, 'Zadejte heslo ještě jednou pro kontrolu')
		->addRule(Form::EQUAL, 'Zadané hesla se neshodují', $reg_form['password']);

		$reg_form->addText('jmeno', 'Jméno:')
		->addRule(Form::FILLED, 'Zadejte jméno');
		$reg_form->addText('prijmeni', 'Příjmení:')
		->addRule(Form::FILLED, 'Zadejte přijmení');
		$reg_form->addText('email', 'E-mail:')
		->setEmptyValue('@') // zavináč bude předvyplněn
		->addRule(Form::EMAIL, 'E-mailová adresa není platná')
		->addRule('MyValidators::emailTaken', 'Zadaný e-mail už někdo používá. Zvolte si jiný');  

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
		$reg_form->addSubmit('registrovat', 'Registrovat');

		if ($reg_form->isSubmitted()) {
			// a jestliže jsou všechny položky vyplněny správně
			if ($reg_form->isValid()) {

				$reg_form->getValues();
				if($this->reg($reg_form->getValues())){
					return MSG_BEGIN."Registrace proběhla úspěšně. Nyní se můžete <a href=\"index.php?page=Login_screen\">přihlásit</a>.".MSG_END;
				} else {
					return MSG_BEGIN."Registrace se nezdařila. Zkuste to znovu později nebo nás kontaktujte e-mailem na " . SUPPORT_MAIL.MSG_END;
				}


			} else {return $reg_form;}

		} else {
			return $reg_form;
		}


	}

	function reg($values){
		global $database;

		$values['password'] = sha256(sha256(sha1(md5($values['password'].RAND1).RAND2).RAND3).RAND4);
		unset($values['password2']);
		unset($values['podminky']);
		$q = "INSERT INTO users VALUES ('','member'";
		foreach($values as $key => $value){
			$q = $q . ",'" . $value ."'";
		}
		$q = $q . ")";
		//echo $q;
		//id 	username 	password 	group 	jmeno 	prijmeni 	email 	ulice 	mesto 	psc 	tel_num
		//INSERT INTO users VALUES ('','username','password','jmeno','prijmeni','email','ulice','mesto','psc','tel_num','podminky')
		//$q = "INSERT INTO users VALUES ('','".."')";
		if($database->query($q)) {return TRUE;} else {return FALSE;}
	}
}



?>