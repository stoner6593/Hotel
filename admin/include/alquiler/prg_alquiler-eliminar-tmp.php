<?php
session_start();
include "../../config.php";
include "../functions.php";
date_default_timezone_set('America/Lima');


$xidprimario = $_GET['idtmp'];

$xtxthuesped = $_POST['txtidcliente'];
$xtxtcliente = $_POST['txtcliente'];

$xtxtidhabitacion = $_POST['txtidhabitacion'];
$xtxthrohabitacion = $_POST['txtnrohabitacion'];
$xtipohabitacion = $_POST['txtidtipohabitacion'];

$_SESSION['xidcliente'] = $_POST['txtidcliente'];
$_SESSION['xcliente'] = $_POST['txtcliente'];
	
$sSQL="delete from alquilerhabitacion_detalle_tmp where idtmp = '$xidprimario'";

if($mysqli->query($sSQL)){}

$mysqli->close();	
header("Location: ../../alquilar.php?idhabitacion=$xtxtidhabitacion&nrohabitacion=$xtxthrohabitacion&idtipohab=$xtipohabitacion&desdeactualizando=si"); 
?>