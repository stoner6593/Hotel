<?php
session_start();
include "../../config.php";
include "../functions.php";
date_default_timezone_set('America/Lima');


$xiddetalle = $_GET['iddetalle'];
$xidalquiler = $_GET['idalquiler'];
$xidhabitacion = $_GET['idhabitacion'];

$consulta="update alquilerhabitacion_detalle set	
	estadopago = 2
	where idalquiler = '$xidalquiler' and idalquilerdetalle = '$xiddetalle' ";

if($mysqli->query($consulta)){}

$mysqli->close();	
$_SESSION['msgerror'] = $Men;
header("Location: ../../alquilar-detalle.php?idhabitacion=$xidhabitacion&idalquiler=$xidalquiler");
exit; 


?>