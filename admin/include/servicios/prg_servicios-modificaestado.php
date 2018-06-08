<?php
session_start();
include "../../config.php";
include "../functions.php";
//**********************ACTUALIZAR COMPRA**********************
$xidparaestado = $_GET['xidparaestado'];
$xestado = $_GET['estado'];
//**********************IDUSUARIO******************************* 
if ($xestado == 1){
	$nestado = false;
}elseif ($xestado == 0){
	$nestado = true;	
}
//*****************************************************
	$consulta="update servicios set
	estado = '$nestado'
	where idservicios = '$xidparaestado'";

	if($mysqli->query($consulta)){
		$Men = "Los datos fueron guardados satisfactoriamente.";
	}else{
		$Men = "Ha fallado, los datos no han sido registrados.";
	}
	echo $consulta;
$mysqli->close();	
$_SESSION['msgerror'] = $Men;
header("Location: ../../servicios.php"); exit;
?>