<?php
session_start();
include "../../config.php";
include "../functions.php";

//*****************************************************
$xidtmp = $_GET['idtmp'];
//******************************************************
$xdesde = $_GET['desde'];
$idhabitacion = $_GET['idhabitacion'];
$nrohabitacion = $_GET['nrohabitacion'];
$xestado = $_GET['xestado'];
$idtipohab = $_GET['idtipohab'];
$xidcliente = $_GET['xidcliente'];
$xcliente = $_GET['xcliente'];
//******************************************************

$sSQL="delete from ventas_tmp where id = '$xidtmp'";
	if($mysqli->query($sSQL)){
			$Men = "El registro ha sido eliminado satisfactoriamente.";
	}else{
			$Men = "Ha fallado, los datos no han sido eliminados.";
	}
$mysqli->close();
//$_SESSION['msgerror'] = $Men;
if($xdesde=="alquiler"){
	$_SESSION['xidcliente'] = $xidcliente;
	$_SESSION['xcliente'] = $xcliente;
	header("Location: ../../alquilar.php?idhabitacion=$idhabitacion&nrohabitacion=$nrohabitacion&xestado=$xestado&idtipohab=$idtipohab&desdeactualizando=si"); exit;
}else{
	header("Location: ../../venta.php?actualiza=actualizar"); exit;
}
//************************************************************
?>