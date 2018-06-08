<?php 
session_start();	
if(empty($_SESSION['xyzcodigo'])) { // Recuerda usar corchetes.
	header('Location: ../index.php');
	exit;
}

if ($_SERVER['HTTP_REFERER'] == "" ){
	header ("Location: ../index.php");
exit;
} 
?>
