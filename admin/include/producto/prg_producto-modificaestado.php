<?php
session_start();
include "../../config.php";
include "../functions.php";
//**********************ACTUALIZAR COMPRA**********************
$xidparaestado = $_GET['xidparaestado'];
$xestado = $_GET['estado'];
//**********************IDUSUARIO******************************* 
if ($xestado == 1){
	$nestado = 0;
}elseif ($xestado == 0){
	$nestado = 1;	
}
//*****************************************************
	$consulta="update producto set
	estado = '$nestado'
	where idproducto = '$xidparaestado'";

	if($mysqli->query($consulta)){
		$Men = "Los datos fueron guardados satisfactoriamente.";
	}else{
		$Men = "Ha fallado, los datos no han sido registrados.";
	}

$mysqli->close();	
$_SESSION['msgerror'] = $Men;
header("Location: ../../productos.php"); exit;
?>