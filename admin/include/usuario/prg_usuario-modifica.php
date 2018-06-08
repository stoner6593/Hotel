<?php
session_start();
include "../../config.php";
include "../functions.php";
//*****************************************************
$xidusuario = $_POST['txtidusuario'];

$xtxtnombre = mayuscula($_POST['txtnombre']);
$xtxtdni = $_POST['txtdni'];
$xtxtcategoria = $_POST['txtcategoria'];
$xtxtusuario = $_POST['txtusuario'];
$xtxtcontrasena = md5($_POST['txtcontrasena']);


if($_POST['txtcontrasena'] == ""){	
	$consulta="update usuario set
	user_nombre = '$xtxtnombre',
	user_dni = '$xtxtdni',
	user_user = '$xtxtusuario',
	user_categoria = '$xtxtcategoria'
	where user_id = '$xidusuario'";
}else{
	$consulta="update usuario set
	user_nombre = '$xtxtnombre',
	user_dni = '$xtxtdni',
	user_user = '$xtxtusuario',
	user_password = '$xtxtcontrasena',
	user_categoria = '$xtxtcategoria'
	where user_id = '$xidusuario'";
}	
	echo $consulta;
if($mysqli->query($consulta)){
	$Men = "Los datos fueron guardados satisfactoriamente.";
}else{
	$Men = "Ha fallado, los datos no han sido actualizados.";
}
	
$mysqli->close();
$_SESSION['msgerror'] = $Men;
header("Location: ../../usuarios.php"); exit;
//************************************************************
?>