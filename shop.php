<?php
session_start();
$_SESSION['shop'] = TRUE;
if(isset($_GET['off'])){
	unset($_SESSION['shop']);
}
header("Location: index.php?page=Zbozi");
?>