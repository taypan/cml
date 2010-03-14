<?php
class Enter extends Modul{

function __construct($info,$arg){
parent::__construct($info,$arg);

}

function get_title(){
return "Přihlášení";
}

function get_content($n){
global $model;

if(!$model->user->isAuthenticated()){


if(isset($_POST['username']) && isset($_POST['password']))
{
require 'MyAuthenticator.php';
$user = $model->user;

// zaregistrujeme autentizační handler
$user->setAuthenticationHandler(new MyAuthenticator);

// nastavíme expiraci
$user->setExpiration('+ 30 minutes');
$values['username'] = $_POST['username'];
$values['password'] = $_POST['password'];
try {
        // pokusíme se přihlásit uživatele...
        $user->authenticate($values['username'], $values['password']);
        // ...a v případě úspěchu presměrujeme na další stránku
		
		Environment::getHttpResponse()->redirect('index.php');

} catch (AuthenticationException $e) {

        return MSG_BEGIN.'Chyba: '. stripslashes(htmlspecialchars($e->getMessage())).MSG_END;

}
}



}


}
}
?>