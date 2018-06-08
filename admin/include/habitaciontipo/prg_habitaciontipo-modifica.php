<?php
session_start();
include "../../config.php";
include "../functions.php";

//--------------------------------------------------------------
$xidprimario = $_POST['txtidtipo'];

//$txtnombre = $_POST['txtnombre'];
$txtpreciodiariouno = $_POST['txtpreciodiariouno'];
$txtpreciohorauno = $_POST['txtpreciohorauno'];
$txtpreciohoraadicionaluno = $_POST['txtpreciohoraadicionaluno'];
$txtpreciohuespedadicionaluno = $_POST['txtpreciohuespedadicionaluno'];

$txtpreciodiariodos = $_POST['txtpreciodiariodos'];
$txtpreciohorados = $_POST['txtpreciohorados'];
$txtpreciohoraadicionaldos = $_POST['txtpreciohoraadicionaldos'];
$txtpreciohuespedadicionaldos = $_POST['txtpreciohuespedadicionaldos'];

//*****************************************************

	
$consulta="update habitaciontipo set
	
	preciodiariouno = '$txtpreciodiariouno',
	preciohorauno = '$txtpreciohorauno',
	preciohoraadicionaluno = '$txtpreciohoraadicionaluno',
	preciohuespedadicionaluno = '$txtpreciohuespedadicionaluno',
	
	preciodiariodos = '$txtpreciodiariodos',
	preciohorados = '$txtpreciohorados',
	preciohoraadicionaldos = '$txtpreciohoraadicionaldos',
	preciohuespedadicionaldos = '$txtpreciohuespedadicionaldos'
	
	where idtipo = '$xidprimario'";

if($mysqli->query($consulta)){
		$Men = "Los datos fueron guardados satisfactoriamente.";
}else{
		$Men = "Ha fallado, los datos no han sido actualizados.";
}
$mysqli->close();	
$_SESSION['msgerror'] = $Men;
header("Location: ../../habitaciones-tipo.php"); exit;
//************************************************************
?>