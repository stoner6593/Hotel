<?php
session_start();
include "../../../config.php";
include "../functions.php";

//*****************************************************
$xidusuario = $_GET['IDCgsdwernjsdw'];

$sSQL="delete from usuario where user_id = '$xidusuario'";

if($mysqli->query($sSQL)){
	$Men = "El registro ha sido eliminado satisfactoriamente.";
}else{
	$Men = "Ha fallado, los datos no han sido eliminados.";
}
		
$mysqli->close();
$_SESSION['msgerror'] = $Men;
header("Location: ../../configuracion/usuario.php"); exit;
//************************************************************
?>