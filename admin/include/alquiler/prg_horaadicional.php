<?php
session_start();
include "../../config.php";
include "../functions.php";

//--------------------------------------------------------------
$xidhabitacion = $_GET['idhabitacion'];
$xidalquiler = $_GET['idalquiler'];

$xtxtnrohoraadicional = $_POST['txtnrohoraadicional'];
$txtpreciohoraadicional = $_POST['txtpreciohoraadicional'];
$xtxtimportehoraadicional = $_POST['txtimportehoraadicional'];
$xtipo = 2;
$xestadopago = 0;

if($xtxtnrohoraadicional==0){
	header("Location: ../../alquilar-detalle.php?idhabitacion=$xidhabitacion&idalquiler=$xidalquiler"); exit;
}


//Guardar Adicionales
if($xtxtnrohoraadicional > 0){
	$TblMaxa = $mysqli->query("select max(idadicional) from alquiler_adicional");
	$Contador = $TblMaxa->fetch_row();
	$xidadicional = $Contador['0'] + 1 ;
	
	$consultaadicional = "insert alquiler_adicional (
		idadicional,
		idalquiler,
		idtipo,
		nrohoras,
		costohoras,
		total,
		estadopago
	
		)values(
		
		'$xidadicional',
		'$xidalquiler',
		'$xtipo',
		'$xtxtnrohoraadicional',
		'$txtpreciohoraadicional',
		'$xtxtimportehoraadicional',
		'$xestadopago'
		) ";
		
		if($mysqli->query($consultaadicional)){}
}


$mysqli->close();	
$_SESSION['msgerror'] = $Men;
header("Location: ../../alquilar-detalle.php?idhabitacion=$xidhabitacion&idalquiler=$xidalquiler"); exit;
//************************************************************
?>