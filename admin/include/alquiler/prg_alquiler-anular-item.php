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



//Restaura fecha salida
$ultimafecha=$mysqli->query("SELECT fechahasta FROM alquilerhabitacion_detalle where idalquiler='$xidalquiler' 
AND idalquilerdetalle= (SELECT MAX(det.idalquilerdetalle) FROM alquilerhabitacion_detalle det where det.idalquiler='$xidalquiler' and det.estadopago=1 LIMIT 1 ) AND estadopago=1");

if ($ultimafecha) {
	$dato=$ultimafecha->fetch_row();
	
	// Actualizar Fecha Fin 		
	$consultaact="update alquilerhabitacion set
	fechafin = '$dato[0]'
	where idalquiler = '$xidalquiler'";
	if($mysqli->query($consultaact)){}
}


$mysqli->close();	
$_SESSION['msgerror'] = $Men;
header("Location: ../../alquilar-detalle.php?idhabitacion=$xidhabitacion&idalquiler=$xidalquiler");
exit; 


?>