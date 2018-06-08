<?php
session_start();
include "../../config.php";
include "../functions.php";

//--------------------------------------------------------------
$xidhabitacion = $_GET['idhabitacion'];
$xidalquiler = $_GET['idalquiler'];

$formapago = $_GET['formapago'];
$idalquilerdetalle = $_GET['idalquilerdetalle'];

$xmonto = $_GET['monto'];

if($formapago == "efectivo"){
	$xmontoefectivo = $_GET['monto'];
	$xmontovisa = 0;
	
}elseif($formapago == "visa"){
	$xmontoefectivo = 0;
	$xmontovisa = $_GET['monto'];
}

$xidturno = $_SESSION['idturno'];
$idusuario = $_SESSION['xyzidusuario'];


//Alquiler Adicional
$consulta="update alquilerhabitacion_detalle set
	estadopago = '1',
	totalefectivo = '$xmontoefectivo',
	totalvisa = '$xmontovisa',
	idturno = '$xidturno',
	idusuario = '$idusuario'
	where idalquilerdetalle = '$idalquilerdetalle' and idalquiler = '$xidalquiler'";
if($mysqli->query($consulta)){}


$consultaturno = "update ingresosturno set
		totalhabitacion = totalhabitacion + $xmonto,
		
		totalefectivo = totalefectivo + $xmontoefectivo,
		totalvisa = totalvisa + $xmontovisa
		where idturno = '$xidturno'";
		if($mysqli->query($consultaturno)){}


/*
//Ingreso Turno Actualizar Montos
if($formapago == "efectivo"){
	$consultax="update ingresosturno set
		totaladicional = totaladicional + $monto,
		totalefectivo = totalefectivo + $monto
		where idturno = '$xidturno'";
	if($mysqli->query($consultax)){}
	
}else{
	$consultax="update ingresosturno set
		totaladicional = totaladicional + $monto,
		totalvisa = totalvisa + '$monto'
		where idturno = '$xidturno'";
	if($mysqli->query($consultax)){}
}
*/

$mysqli->close();	
$_SESSION['msgerror'] = $Men;

header("Location: ../../alquilar-detalle.php?idhabitacion=$xidhabitacion&idalquiler=$xidalquiler"); exit;
//************************************************************
?>