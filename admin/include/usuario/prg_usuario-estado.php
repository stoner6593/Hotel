<?php
session_start();
//ini_set ('error_reporting', E_ALL);
include "../../../config.php";
include "../functions.php";
//**********************variables*******************************

$xidusuario = $_GET['xidusuario'];
$xestado = $_GET['xestado'];

if ($xestado==1){
	$xestado = 0;
}else{
	$xestado = 1;
}
//********************************************
$consulta="update usuario set
	user_estado = '$xestado'
	where user_id = '$xidusuario'";
	
if (!$mysqli->query($consulta, $link)) 
	{ 
	$Men='No se ha modificado el estado.'; 
	} 
else
	{ 
	$Men='El estado del cliente ha sido modificado.'; 
	//Guardar Log
	/*$xdescripcion = "Actualizacion el Estado de Seguimiento de la Cotizacion - ID: ".$xidcotizador;
	include "../../configuracion/include/registro-nuevo.php"; */
} 

$mysqli->close();

header("Location: ../../configuracion/usuario.php"); exit;
//************************************************************
?>