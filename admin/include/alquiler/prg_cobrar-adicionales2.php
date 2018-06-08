<?php
session_start();
include "../../config.php";
include "../functions.php";

//--------------------------------------------------------------
$xidhabitacion = $_GET['idhabitacion'];
$xidalquiler = $_GET['idalquiler'];

$formapago1 = $_GET['formapago1']; //Visa
$formapago2 = $_GET['formapago2']; //Efectivo
$idalquilerdetalle = $_GET['idalquilerdetalle'];

$xmonto1 = $_GET['monto1']; //Monto pago visa
$xmonto2 = $_GET['monto2']; //Monto pago Efectivo

if($formapago2 == "efectivo"){
	$xmontoefectivo = $_GET['monto2'];
	//$xmontovisa = 0;
	
}
if($formapago1 == "visa"){
	//$xmontoefectivo = 0;
	$xmontovisa = $_GET['monto1'];
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
echo $consulta;

if($mysqli->query($consulta)){}


$consultaturno = "update ingresosturno set
		totalhabitacion = totalhabitacion + $xmonto,
		
		totalefectivo = totalefectivo + $xmontoefectivo,
		totalvisa = totalvisa + $xmontovisa
		where idturno = '$xidturno'";
		if($mysqli->query($consultaturno)){}




$mysqli->close();	
$_SESSION['msgerror'] = $Men;

header("Location: ../../alquilar-detalle.php?idhabitacion=$xidhabitacion&idalquiler=$xidalquiler"); exit;
//************************************************************
?>