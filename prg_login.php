<?php
session_start();
include("admin/config.php");



$xusuario  = $mysqli->real_escape_string($_POST['username']);
$xpassword = md5($mysqli->real_escape_string($_POST['password']));
$xvar = 1;
$sqlusuario = $mysqli->query("select 
	user_id, 
	user_nombre, 
	user_user, 
	user_password,
	user_categoria,
	user_estado
	from usuario 
	where user_user ='". $xusuario ."' and user_password = '". $xpassword ."' and user_estado = '".$xvar."' ");
	
$uFila = $sqlusuario->fetch_row(); //Obtiene filas // fetch_assoc() = campos por nombre / fetch_row = campos por indice
$num = $sqlusuario->num_rows; //Obtiene nro de filas

if($num == 0 || $num == "")	{
	$_SESSION['msgerror'] = "Usuario o password inv&aacute;lido.";
	header("Location: index.php"); exit;
}else{
	$_SESSION['xyzcodigo'] = "e10adc3949ba59abbe56e057f20f883z";
	$_SESSION['xyzidusuario'] = $uFila['0'];
	$_SESSION['xyznombre'] = $uFila['1'];
	$_SESSION['xyzusuario'] = $uFila['2'];
	$_SESSION['xyztipo'] = $uFila['4'];
	header("Location: admin/index.php"); exit;
	//Redirigir al Admin
}

/* cerrar el resultset */
$sqlusuario->close();
/* cerrar la conexión */
$mysqli->close();
?>