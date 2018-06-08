<?php
session_start();
include "../../config.php";
include "../functions.php";

//--------------------------------------------------------------
$xidhabitacion = $_GET['idhabitacion'];
$xidalquiler = $_GET['idalquiler'];

$xtxtanotaciones = mayuscula($_POST['txtanotaciones']);

$consulta="update alquilerhabitacion set
	comentarios = '$xtxtanotaciones'
	where idalquiler = '$xidalquiler'";

if($mysqli->query($consulta)){
		$Men = "La anotación ha sido registrado.";
}else{
		$Men = "La anotación no ha sido registrado.";
}
$mysqli->close();	
$_SESSION['msgerror'] = $Men;
header("Location: ../../alquilar-detalle.php?idhabitacion=$xidhabitacion&idalquiler=$xidalquiler"); exit;
//************************************************************
?>