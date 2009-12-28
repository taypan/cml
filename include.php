<?php
//vkldni zkladnich souboru
include("functions.php");
include("Modul.php");
include("model.php");
include("status.php");
include("controler.php");
include("config.php");
include("database.php");
include("tag.php");
require 'Nette/loader.php';
include("MyIdentity.php");
include("Mailer.php");
if(!function_exists('sha256')){include("sha256.php");}
//require_once('sha256.php');
?>