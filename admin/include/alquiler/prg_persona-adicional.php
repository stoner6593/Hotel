<?php
session_start();
include "../../config.php";
include "../functions.php";

$nombrecliente = $_GET['nombrecliente'];
$idhabitacion = $_GET['idhabitacion'];
$idalquiler = $_GET['idalquiler'];
$idcliente = $_GET['idcliente'];



//--------------------------------------------------------------
$TblMax = $mysqli->query("select max(idpersona) from alquiler_personaadicional");
$Contador = $TblMax->fetch_row();
$xidprimario = $Contador['0'] + 1 ;

$xnombre = $_POST['txtnombre'];
$xdni = $_POST['txtdni'];
$xnacimiento = Cfecha($_POST['txtnacimiento']);

$consulta="insert alquiler_personaadicional (
	idpersona,
	idalquiler,
	idcliente,
	nombre,
	dni,
	nacimiento
	
		
	) values (

	'$xidprimario',
	'$idalquiler',
	'$idcliente',
	'$xnombre',
	'$xdni',
	'$xnacimiento'
)";
if($mysqli->query($consulta)){}
	
	
	
$mysqli->close();	
$_SESSION['msgerror'] = $Men;
header("Location: ../../persona-adicional.php?idhabitacion=$idhabitacion&idalquiler=$idalquiler&idcliente=3"); exit;
//************************************************************
?>