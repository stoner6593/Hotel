<?php
session_start();
include "../../config.php";
include "../functions.php";

//--------------------------------------------------------------

$xidalquiler = $_GET['idalquiler'];
$xidhabitacion = $_GET['idhabitacion'];

//estadoalquiler: 1=Activo - 0=Anulado
$xestadoalquiler = 0;
$xmotivoanulacion = $_POST['txtmotivoanulacion'];

//Actualizar Alquiler
$consulta="update alquiler set
	estadoalquiler = '$xestadoalquiler',
	motivoanulacion = '$xmotivoanulacion'
	where idalquiler = '$xidalquiler' and idhabitacion = '$xidhabitacion'";
if($mysqli->query($consulta)){}

//Actualizar Habitacion
$consultahabitacion = "update habitacion set
	idalquiler = 0,
	idestado = 1
	where idhabitacion = '$xidhabitacion'";
if($mysqli->query($consultahabitacion)){}

$mysqli->close();	
//$_SESSION['msgerror'] = $Men;
header("Location: ../../control-habitaciones.php"); exit;
//************************************************************
?>