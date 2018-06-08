<?php 
session_start(); 
$_SESSION['xyzidusuario'] = "";
$_SESSION['xyzusuario'] = "";
$_SESSION['xyzcodigo'] = "";
$_SESSION['userlog'] = "";
$_SESSION['estadomenu'] = 0;
$_SESSION['idturno'] = 0;
session_destroy(); 
header("Location: ../index.php"); exit;
?>
