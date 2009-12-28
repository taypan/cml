<?php

require 'Nette/loader.php';
//require_once('sha256.php');

// pokud používáte verzi pro PHP 5.3, odkomentujte následující řádek:
// use Nette\Object, Nette\Security\IAuthenticator, Nette\Security\AuthenticationException, Nette\Security\Identity;

class MyAuthenticator extends Object implements IAuthenticator
{

    public function authenticate(array $credentials)
    {
		global $database;
 		//include('database.php');
		//include('constants.php');
 		//$database = new Database;
		//$database->load_settings();
        $username = $credentials[self::USERNAME];
        $password = sha256(sha256(sha1(md5($credentials[self::PASSWORD].RAND1).RAND2).RAND3).RAND4);
		// přečteme záznam o uživateli z databáze
		$q = "SELECT * FROM users WHERE username = '$username'";
		$result = $database->query($q);
		
		//$row = dibi::fetch('SELECT realname, password FROM users WHERE login=%s', $username);

        if (mysql_numrows($result) == 0) { // uživatel nenalezen?
            throw new AuthenticationException("Uživatel \"$username\" nebyl nalezen!", self::IDENTITY_NOT_FOUND);
        }
		//echo mysql_result($result,0,'password');
        if (mysql_result($result,0,'password') !== $password) { // hesla se neshodují?
            throw new AuthenticationException("Neplatné heslo.", self::INVALID_CREDENTIAL);
        }
		
		$data['jmeno'] = mysql_result($result,0,'jmeno');
		$data['prijmeni'] = mysql_result($result,0,'prijmeni');
		$data['email'] = mysql_result($result,0,'email');
		$data['ulice'] = mysql_result($result,0,'ulice');
		$data['mesto'] = mysql_result($result,0,'mesto');
		$data['psc'] = mysql_result($result,0,'psc');
		$data['tel_num'] = mysql_result($result,0,'tel_num');
		
		//
		session_regenerate_id();
        return new MyIdentity($username,mysql_result($result,0,'group'),$data); // vrátíme identitu
    }

} 


?>