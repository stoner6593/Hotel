<?php
session_start();
include "../../config.php";
include "../functions.php";

//--------------------------------------------------------------
$xidprimario = $_POST['txtidprimario'];

$xtxtpiso = $_POST['txtpiso'];
$xtxtnumero = $_POST['txtnumero'];
$xtxttipo = $_POST['txttipo'];
//$xtxtestado = $_POST['txtestado'];
$xtxtpreciodiario = $_POST['txtpreciodiario'];
$xtxtpreciohoras = $_POST['txtpreciohoras'];

$xtxtnrohuespedes = $_POST['txtnrohuespedes'];
$xtxtnroadicional = $_POST['txtnroadicional'];

$xtxtcaracteristicas = mayuscula($_POST['txtcaracteristicas']);
$txtubicacion = $_POST['txtubicacion'];

$txtpreciodiariodj = str_replace(',','',$_POST['txtpreciodiariodj']);
$txtpreciohorasdj = str_replace(',','',$_POST['txtpreciohorasdj']);
$txtpreciodiariovs = str_replace(',','',$_POST['txtpreciodiariovs']);
$txtpreciohorasvs = str_replace(',','',$_POST['txtpreciohorasvs']);

$txtpreciohoraadicional = str_replace(',','',$_POST['txtpreciohoraadicional']);
$txtpreciopersonaadicional = str_replace(',','',$_POST['txtpreciopersonaadicional']);
$txtprecio12=str_replace(',','',$_POST['txtprecio12']);
$txtprecio12vs=str_replace(',','',$_POST['txtprecio12vs']);
//*****************************************************

	
$consulta="update habitacion set
	
	piso = '$xtxtpiso',
	numero = '$xtxtnumero',
	idtipo = '$xtxttipo',

	nrohuespedes = '$xtxtnrohuespedes',
	nroadicional = '$xtxtnroadicional',
	caracteristicas = '$xtxtcaracteristicas',
	ubicacion = '$txtubicacion',
	
	preciodiariodj = '$txtpreciodiariodj',
	preciohorasdj = '$txtpreciohorasdj',
	preciodiariovs = '$txtpreciodiariovs',
	preciohorasvs = '$txtpreciohorasvs',
	
	costopersonaadicional = '$txtpreciohoraadicional',
	costohoraadicional = '$txtpreciopersonaadicional',
	precio12='$txtprecio12',
	precio12vs='$txtprecio12vs'
	
	where idhabitacion = '$xidprimario' ";

if($mysqli->query($consulta)){
		$Men = "Los datos fueron guardados satisfactoriamente.";
}else{
		$Men = "Ha fallado, los datos no han sido registrados.";
}
$mysqli->close();	
$_SESSION['msgerror'] = $Men;
header("Location: ../../habitaciones.php"); exit;
//************************************************************
?>