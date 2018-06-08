<?php
session_start();
include "../../config.php";
include "../functions.php";

//*****************************************************
$TblMax = $mysqli->query("select max(user_id) from usuario");
$Contador = $TblMax->fetch_row();
$xidusuario = $Contador['0'] + 1 ;

$xtxtnombre = mayuscula($_POST['txtnombre']);
$xtxtdni = $_POST['txtdni'];
$xtxtcategoria = $_POST['txtcategoria'];
$xtxtusuario = $_POST['txtusuario'];
$xtxtcontrasena = md5($_POST['txtcontrasena']);
$xestado = 1;

$consulta="insert usuario(
	user_id,
	user_nombre,
	user_dni,
	user_user,
	user_password,
	user_categoria,
	user_estado

	) values (
	'$xidusuario',
	'$xtxtnombre',
	'$xtxtdni',
	'$xtxtusuario',
	'$xtxtcontrasena',
	'$xtxtcategoria',
	'$xestado'

	)";
	
	if($mysqli->query($consulta)){
			$Men = "Los datos fueron guardados satisfactoriamente.";
	}else{
			$Men = "Ha fallado, los datos no han sido registrados.";
	}
	
$TblMax->free();	
$mysqli->close();
$_SESSION['msgerror'] = $Men;
header("Location: ../../usuarios.php"); exit;
//************************************************************
?>