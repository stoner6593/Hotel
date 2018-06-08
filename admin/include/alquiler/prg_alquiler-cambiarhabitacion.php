<?php
session_start();
include "../../config.php";
include "../functions.php";

//--------------------------------------------------------------

$xidalquiler = $_GET['idalquiler'];
$xidhabitacion = $_GET['idhabitacion'];
$xidtipohabitacion = $_GET['idtipohabitacion'];

$xidnuevatxthabitacion = $_POST['txthabitacion'];
$sqlnumerohabitacion = $mysqli->query("select idhabitacion, numero from habitacion where idhabitacion = '$xidnuevatxthabitacion'");
$xnFila = $sqlnumerohabitacion->fetch_row();
$xnumerohabitacion = $xnFila['1'];

//Cambios: Habitacion: idestado e idalquiler en Nuevo y Anterior
//Cambios: En Alquiler: idhabitacion y numero de habitacion


//Actualizar Habitacion
$consultahabitacion = "update habitacion set
	idalquiler = 0,
	idestado = 1
	where idhabitacion = '$xidhabitacion'";
if($mysqli->query($consultahabitacion)){}

//Actualizar Nueva Habitacion
$consultanuevahabitacion = "update habitacion set
	idalquiler = '$xidalquiler',
	idestado = 2
	where idhabitacion = '$xidnuevatxthabitacion'";
if($mysqli->query($consultanuevahabitacion)){}

//Actualizar Alquiler
$consultanuevahabitacion = "update alquilerhabitacion set
	idhabitacion = '$xidnuevatxthabitacion',
	nrohabitacion = '$xnumerohabitacion'
	where idalquiler = '$xidalquiler'";
if($mysqli->query($consultanuevahabitacion)){}

$mysqli->close();	
//$_SESSION['msgerror'] = $Men;
header("Location: ../../alquilar-detalle.php?idhabitacion=$xidnuevatxthabitacion&idalquiler=$xidalquiler"); exit;
//************************************************************
?>