<?php

include("include.php");

$user = Environment::getUser();
$user->signOut(TRUE);
Environment::getHttpResponse()->redirect('index.php');

?>