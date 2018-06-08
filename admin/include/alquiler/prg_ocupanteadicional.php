<?php
session_start();
include "../../config.php";
include "../functions.php";

//--------------------------------------------------------------
$xidhabitacion = $_GET['idhabitacion'];
$xidalquiler = $_GET['idalquiler'];

$xtxtnrocupanteadicional = $_POST['txtnrocupanteadicional'];
$txtprecioocupanteadicional = $_POST['txtprecioocupanteadicional'];
$xtxtimporteocupanteadicional = $_POST['txtimporteocupanteadicional'];
$xtipo = 1;
$xestadopago = 0;

if($xtxtnrocupanteadicional==0){
	header("Location: ../../alquilar-detalle.php?idhabitacion=$xidhabitacion&idalquiler=$xidalquiler"); exit;
}

//Guardar Adicionales
if($xtxtnrocupanteadicional > 0){
	$TblMaxa = $mysqli->query("select max(idadicional) from alquiler_adicional");
	$Contador = $TblMaxa->fetch_row();
	$xidadicional = $Contador['0'] + 1 ;
	
	$consultaadicional = "insert alquiler_adicional (
		idadicional,
		idalquiler,
		idtipo,
		nroadicional,
		costoadicional,
		total,
		estadopago
	
		)values(
		
		'$xidadicional',
		'$xidalquiler',
		'$xtipo',
		'$xtxtnrocupanteadicional',
		'$txtprecioocupanteadicional',
		'$xtxtimporteocupanteadicional',
		'$xestadopago'
		) ";
		
		if($mysqli->query($consultaadicional)){}
}

$mysqli->close();	
$_SESSION['msgerror'] = $Men;

header("Location: ../../alquilar-detalle.php?idhabitacion=$xidhabitacion&idalquiler=$xidalquiler"); exit;
//************************************************************
?>